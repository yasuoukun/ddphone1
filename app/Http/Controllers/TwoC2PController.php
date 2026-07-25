<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Services\TwoC2PService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * TwoC2PController — Handles all 2C2P PGW v4.3 HTTP interactions
 *
 * Routes:
 *   POST /payment/2c2p/{order}/initiate  → initiate()  [auth]
 *   GET  /payment/2c2p/return             → return()    [auth]
 *   POST /payment/2c2p/webhook            → webhook()   [no auth, no CSRF]
 */
class TwoC2PController extends Controller
{
    public function __construct(private readonly TwoC2PService $pgw) {}

    /**
     * Initiate a 2C2P payment session.
     * Called from the checkout/pay page when user clicks "ชำระผ่าน SCB".
     */
    public function initiate(Request $request, Order $order)
    {
        // Guard: only the owning customer can initiate
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            return redirect()->route('customer.dashboard', ['tab' => 'orders'])
                ->with('info', 'คำสั่งซื้อนี้ไม่ได้อยู่ในสถานะรอชำระเงิน');
        }

        $type = $request->input('type', 'card'); // 'card' or 'qr'

        try {
            $data = $this->pgw->initiatePayment($order, $type);

            // 2C2P returns a webPaymentUrl to redirect the user to
            if (!empty($data['webPaymentUrl'])) {
                return redirect()->away($data['webPaymentUrl']);
            }

            // PromptPay QR: show QR code page
            if (!empty($data['qrCode']) || !empty($data['qrImage'])) {
                return view('checkout.twoc2p_qr', [
                    'order'   => $order,
                    'qrCode'  => $data['qrCode'] ?? null,
                    'qrImage' => $data['qrImage'] ?? null,
                    'expiry'  => $data['expiredDate'] ?? null,
                ]);
            }

            // Fallback: unexpected response structure
            Log::warning('2C2P: No webPaymentUrl or qrCode in response', $data);
            return redirect()->route('checkout.pay', $order->id)
                ->with('error', 'ไม่สามารถเริ่มกระบวนการชำระเงินได้ กรุณาลองใหม่อีกครั้ง');

        } catch (\Exception $e) {
            Log::error('2C2P initiate error', ['order_id' => $order->id, 'error' => $e->getMessage()]);
            return redirect()->route('checkout.pay', $order->id)
                ->with('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
        }
    }

    /**
     * Handle browser redirect back from 2C2P (Frontend Return URL).
     * This is NOT authoritative — just a UX landing page.
     * Actual order confirmation is done via webhook().
     */
    public function return(Request $request)
    {
        $invoiceNo = $request->input('invoiceNo');
        $respCode  = $request->input('respCode', '');
        $respDesc  = $request->input('respDesc', '');

        Log::info('2C2P return redirect', ['invoiceNo' => $invoiceNo, 'respCode' => $respCode]);

        $order = null;
        if ($invoiceNo) {
            try {
                // Find payment by invoice_no, then load order
                $payment = Payment::where('invoice_no', $invoiceNo)->first();
                if ($payment) {
                    $order = Order::find($payment->order_id);
                }
            } catch (\Exception $e) {
                Log::warning('2C2P return: could not resolve order', ['invoiceNo' => $invoiceNo]);
            }
        }

        $status = $this->pgw->mapRespCode($respCode);

        return view('checkout.twoc2p_return', compact('order', 'status', 'respCode', 'respDesc', 'invoiceNo'));
    }

    /**
     * Handle 2C2P server-to-server Payment Notification (Webhook).
     * This is the AUTHORITATIVE source for payment confirmation.
     *
     * 2C2P will POST here directly (bypasses browser, no CSRF needed).
     * Must respond HTTP 200 to acknowledge receipt.
     */
    public function webhook(Request $request)
    {
        $data = $request->all();
        Log::info('2C2P webhook received', ['invoiceNo' => $data['invoiceNo'] ?? 'unknown', 'respCode' => $data['respCode'] ?? 'unknown']);

        // 1. Verify HMAC signature
        if (!$this->pgw->verifyWebhookSignature($data)) {
            Log::warning('2C2P webhook: invalid signature', ['data' => $data]);
            return response('Invalid signature', 400);
        }

        $invoiceNo = $data['invoiceNo'] ?? null;
        $respCode  = $data['respCode'] ?? '';

        if (!$invoiceNo) {
            Log::warning('2C2P webhook: missing invoiceNo');
            return response('Missing invoiceNo', 400);
        }

        // 2. Find the payment record
        $payment = Payment::where('invoice_no', $invoiceNo)->first();
        if (!$payment) {
            Log::warning('2C2P webhook: payment not found', ['invoiceNo' => $invoiceNo]);
            return response('OK', 200); // ACK anyway to prevent 2C2P retrying
        }

        $order = Order::find($payment->order_id);
        if (!$order) {
            Log::error('2C2P webhook: order not found', ['payment_id' => $payment->id]);
            return response('OK', 200);
        }

        // 3. Anti-Replay: verify uniqueTransactionCode matches what we stored
        if (!empty($data['nonceStr']) && $payment->twoc2p_transaction_code !== $data['nonceStr']) {
            Log::warning('2C2P webhook: nonce mismatch (possible replay attack)', [
                'invoiceNo'   => $invoiceNo,
                'stored'      => $payment->twoc2p_transaction_code,
                'received'    => $data['nonceStr'],
            ]);
            return response('Nonce mismatch', 400);
        }

        // 4. Update payment status
        $payment->update([
            'twoc2p_status' => $respCode,
            'transaction_id' => $data['tranRef'] ?? $data['transactionId'] ?? $payment->transaction_id,
            'status'        => $respCode === '0000' ? 'completed' : 'failed',
        ]);

        // 5. Confirm order if payment successful
        if ($respCode === '0000' && $order->status === 'pending') {
            DB::beginTransaction();
            try {
                $order->confirm(); // deducts stock, sets status to 'confirmed'
                event(new \App\Events\NewOrderCreated($order));
                DB::commit();
                Log::info('2C2P webhook: order confirmed', ['order_id' => $order->id]);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('2C2P webhook: order confirmation failed', ['order_id' => $order->id, 'error' => $e->getMessage()]);
            }
        }

        // Always respond 200 to acknowledge
        return response('OK', 200);
    }
}

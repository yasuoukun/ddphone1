<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * TwoC2PService — 2C2P Payment Gateway v4.3 Integration
 *
 * Handles:
 *   - Anti-Gravity Unique Invoice ID generation (DDC-YYYYMMDD-HEXID)
 *   - Anti-Replay Protection (timestamp + UUID nonce)
 *   - Payment initiation (Card & PromptPay/QR)
 *   - Webhook signature verification
 *   - Order resolution from invoice number
 */
class TwoC2PService
{
    private string $baseUrl;
    private string $merchantId;
    private string $merchantIdCard;
    private string $merchantIdQr;
    private string $secretKey;
    private string $invoicePrefix;
    private string $currency;

    public function __construct()
    {
        $this->baseUrl        = config('twoc2p.base_url');
        $this->merchantId     = config('twoc2p.merchant_id');
        $this->merchantIdCard = config('twoc2p.merchant_id_card');
        $this->merchantIdQr   = config('twoc2p.merchant_id_qr');
        $this->secretKey      = config('twoc2p.secret_key');
        $this->invoicePrefix  = config('twoc2p.invoice_prefix', 'DDC');
        $this->currency       = config('twoc2p.currency', '764');
    }

    /**
     * Build a unique Anti-Gravity invoice number for 2C2P.
     *
     * Format: {PREFIX}-{YYYYMMDD}-{HEXID}
     *   - PREFIX   : site-specific prefix (e.g. "DDC" for dd.it.com)
     *   - YYYYMMDD : current date for natural collision protection
     *   - HEXID    : order ID encoded as zero-padded 8-char uppercase hex
     *
     * Example: DDC-20260724-000003E9  (order ID 1001)
     * Max length: 21 chars (2C2P supports up to 30 chars)
     *
     * Two sites using the same order ID on the same day will never collide
     * because their prefixes differ (DDC vs WEB2 etc.).
     */
    public function buildInvoiceNo(Order $order): string
    {
        $hexId    = strtoupper(str_pad(dechex($order->id), 8, '0', STR_PAD_LEFT));
        $dateStr  = now()->format('Ymd');
        return "{$this->invoicePrefix}-{$dateStr}-{$hexId}";
    }

    /**
     * Resolve an Order from a 2C2P invoice number.
     * Reverse of buildInvoiceNo().
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function resolveOrderFromInvoiceNo(string $invoiceNo): Order
    {
        // Extract hex part (last segment after final "-")
        $parts  = explode('-', $invoiceNo);
        $hexId  = end($parts);
        $orderId = hexdec($hexId);

        return Order::findOrFail($orderId);
    }

    /**
     * Select the correct merchant ID based on payment type.
     * card → SCB01 (Credit/Debit Card Merchant)
     * qr   → SCB02 (PromptPay/QR/Wallet Merchant)
     */
    public function merchantIdForType(string $type): string
    {
        return match ($type) {
            'qr', 'promptpay' => $this->merchantIdQr ?: $this->merchantId,
            'card', 'credit'  => $this->merchantIdCard ?: $this->merchantId,
            default           => $this->merchantId,
        };
    }

    /**
     * Build the Anti-Replay payload fields:
     *   - timestamp              : Unix timestamp (seconds) at request time
     *   - uniqueTransactionCode  : UUID v4 — stored in DB, validated on return/webhook
     */
    public function buildAntiReplayFields(): array
    {
        return [
            'timestamp'             => (string) now()->timestamp,
            'uniqueTransactionCode' => (string) Str::uuid(),
        ];
    }

    /**
     * Build a HMAC-SHA256 signature of the payload string.
     * 2C2P requires the entire sorted-key JSON to be signed.
     */
    public function buildSignature(array $payload): string
    {
        $data = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        return strtoupper(hash_hmac('sha256', $data, $this->secretKey));
    }

    /**
     * Initiate a 2C2P payment session.
     *
     * @param  Order  $order
     * @param  string $type  'card' | 'qr'
     * @return array  Contains 'webPaymentUrl' or 'qrCode' from 2C2P
     * @throws \Exception on API error
     */
    public function initiatePayment(Order $order, string $type = 'card'): array
    {
        $invoiceNo      = $this->buildInvoiceNo($order);
        $antiReplay     = $this->buildAntiReplayFields();
        $merchantId     = $this->merchantIdForType($type);

        // Convert amount to satang (smallest unit): multiply by 100, zero-pad to 12 digits
        $amountSatang   = str_pad((string) ((int) round($order->total_amount * 100)), 12, '0', STR_PAD_LEFT);

        $payload = [
            'merchantID'            => $merchantId,
            'invoiceNo'             => $invoiceNo,
            'description'           => "DD.IT.COM Order #{$order->id}",
            'amount'                => $amountSatang,
            'currencyCode'          => $this->currency,
            'paymentChannel'        => $type === 'qr' ? ['QR'] : ['CC'],
            'agentCode'             => null,
            'frontendReturnUrl'     => route('payment.2c2p.return'),
            'backendReturnUrl'      => route('payment.2c2p.webhook'),
            'paymentNotificationUrl'=> route('payment.2c2p.webhook'),
            'nonceStr'              => $antiReplay['uniqueTransactionCode'],
            'timestamp'             => $antiReplay['timestamp'],
            'userDefined1'          => (string) $order->id,
        ];

        // Remove null values
        $payload = array_filter($payload, fn($v) => $v !== null);

        // Attach HMAC signature
        $payload['hashValue'] = $this->buildSignature($payload);

        // Persist invoice + nonce to the payment record BEFORE calling API
        $payment = Payment::firstOrCreate(
            ['order_id' => $order->id],
            ['payment_method' => $type, 'amount' => $order->total_amount, 'status' => 'pending']
        );
        $payment->update([
            'invoice_no'              => $invoiceNo,
            'twoc2p_transaction_code' => $antiReplay['uniqueTransactionCode'],
            'payment_method'          => $type,
        ]);

        // Call 2C2P Payment API
        $endpoint = rtrim($this->baseUrl, '/') . config('twoc2p.endpoints.payment');
        Log::info('2C2P initiatePayment request', ['endpoint' => $endpoint, 'invoiceNo' => $invoiceNo, 'env' => config('twoc2p.env')]);

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept'       => 'application/json',
        ])->timeout(30)->post($endpoint, $payload);

        if ($response->failed()) {
            Log::error('2C2P API error', ['status' => $response->status(), 'body' => $response->body()]);
            throw new \Exception("2C2P API returned HTTP {$response->status()}: {$response->body()}");
        }

        $data = $response->json();
        Log::info('2C2P initiatePayment response', ['invoiceNo' => $invoiceNo, 'respCode' => $data['respCode'] ?? 'unknown']);

        if (($data['respCode'] ?? '') !== '0000') {
            $msg = $data['respDesc'] ?? 'Unknown 2C2P error';
            throw new \Exception("2C2P rejected payment: [{$data['respCode']}] {$msg}");
        }

        return $data;
    }

    /**
     * Verify HMAC-SHA256 signature from 2C2P webhook/return payload.
     *
     * 2C2P sends a 'hashValue' field. We must re-sign the payload
     * (excluding 'hashValue' itself) and compare.
     */
    public function verifyWebhookSignature(array $data): bool
    {
        $receivedHash = strtoupper($data['hashValue'] ?? '');
        unset($data['hashValue']);

        $expectedHash = $this->buildSignature($data);

        return hash_equals($expectedHash, $receivedHash);
    }

    /**
     * Map 2C2P respCode to a human-readable status.
     */
    public function mapRespCode(string $respCode): string
    {
        return match ($respCode) {
            '0000'  => 'success',
            '0001'  => 'pending',
            '0002'  => 'rejected',
            '0003'  => 'cancelled',
            default => 'unknown',
        };
    }
}

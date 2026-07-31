<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $cart = session()->get('cart', []);
        if(count($cart) === 0) {
            return redirect()->route('products.index')->with('error', 'ตะกร้าสินค้าว่างเปล่า');
        }

        // Filter cart items by query param 'items'
        $selectedIds = [];
        if ($request->has('items') && !empty($request->query('items'))) {
            $selectedIds = array_map('strval', explode(',', $request->query('items')));
            $cart = array_filter($cart, function($key) use ($selectedIds) {
                return in_array((string)$key, $selectedIds, true);
            }, ARRAY_FILTER_USE_KEY);
            
            if (count($cart) === 0) {
                return redirect()->route('cart.index')->with('error', 'กรุณาเลือกสินค้าอย่างน้อย 1 ชิ้นเพื่อชำระเงิน');
            }
        } else {
            $selectedIds = array_map('strval', array_keys($cart));
        }
        
        // Save selected items keys to session
        session()->put('checkout_items', $selectedIds);

        // Keep coupon in session or clear if first visit without coupon
        $addresses = \App\Models\Address::where('user_id', auth()->id())->get();
        $mainAddress = $addresses->where('is_main', true)->first();

        // Load valid collected coupons for the user
        $collectedCoupons = \App\Models\CollectedCoupon::with('coupon')
            ->where('user_id', auth()->id())
            ->where('is_used', false)
            ->get()
            ->filter(function($cc) use ($cart) {
                $coupon = $cc->coupon;
                if (!$coupon) return false;
                if ($coupon->expires_at < now()->toDateTimeString()) return false;
                if ($coupon->product_id !== null && !array_key_exists($coupon->product_id, $cart)) return false;
                return true;
            });

        return view('checkout.index', compact('cart', 'addresses', 'mainAddress', 'collectedCoupons'));
    }

    public function applyCoupon(Request $request)
    {
        $code = $request->input('coupon_code');
        if (!$code) {
            return redirect()->back()->with('error', 'กรุณากรอกรหัสคูปอง');
        }

        $coupon = \App\Models\Coupon::where('code', $code)
            ->where('expires_at', '>=', now()->toDateTimeString())
            ->first();

        if (!$coupon) {
            return redirect()->back()->with('error', 'รหัสคูปองไม่ถูกต้องหรือหมดอายุแล้ว');
        }

        // Check if user has collected this coupon
        $hasCollected = \App\Models\CollectedCoupon::where('user_id', auth()->id())
            ->where('coupon_id', $coupon->id)
            ->where('is_used', false)
            ->exists();

        if (!$hasCollected) {
            return redirect()->back()->with('error', 'คุณยังไม่ได้เก็บคูปองนี้ หรือใช้คูปองนี้ไปแล้ว');
        }

        // Check if product eligibility is met
        $selectedIds = session()->get('checkout_items', []);
        $cart = session()->get('cart', []);
        if (count($selectedIds) > 0) {
            $cart = array_filter($cart, function($key) use ($selectedIds) {
                return in_array($key, $selectedIds);
            }, ARRAY_FILTER_USE_KEY);
        }

        if ($coupon->product_id !== null && !array_key_exists($coupon->product_id, $cart)) {
            $targetProduct = \App\Models\Product::find($coupon->product_id);
            $productName = $targetProduct ? $targetProduct->name : 'สินค้าที่กำหนด';
            return redirect()->back()->with('error', 'คูปองนี้ใช้ได้เฉพาะเมื่อมีสินค้า "' . $productName . '" อยู่ในรายการที่สั่งซื้อเท่านั้น');
        }

        session()->put('coupon', $coupon);
        return redirect()->back()->with('sweet_success', 'ใช้คูปองส่วนลด ฿' . number_format($coupon->discount_amount, 0) . ' สำเร็จ!');
    }

    public function removeCoupon()
    {
        session()->forget('coupon');
        return redirect()->back()->with('sweet_success', 'ยกเลิกการใช้คูปองส่วนลดเรียบร้อยแล้ว');
    }

    public function process(Request $request)
    {
        $cart = session()->get('cart', []);
        if(count($cart) === 0) {
            return redirect()->route('products.index');
        }

        // Filter cart items by checkout_items session
        $selectedIds = session()->get('checkout_items', []);
        if (count($selectedIds) > 0) {
            $selectedIds = array_map('strval', $selectedIds);
            $filteredCart = array_filter($cart, function($key) use ($selectedIds) {
                return in_array((string)$key, $selectedIds, true);
            }, ARRAY_FILTER_USE_KEY);
            if (count($filteredCart) > 0) {
                $cart = $filteredCart;
            }
        }

        // Validate request inputs
        $validated = $request->validate([
            'shipping_info' => 'required|string|max:1000',
            'payment_method' => 'required|string|in:promptpay,credit_card',
        ]);

        // Validate product stock before creating the order
        foreach ($cart as $id => $item) {
            $product = \App\Models\Product::find($id);
            if (!$product) {
                return redirect()->route('cart.index')->with('error', "ไม่พบสินค้า \"{$item['name']}\" ในระบบ");
            }
            if ($product->stock < $item['quantity']) {
                return redirect()->route('cart.index')->with('error', "สินค้า \"{$product->name}\" มีจำนวนไม่พอในคลัง (เหลือ {$product->stock} ชิ้น)");
            }
        }

        DB::beginTransaction();
        try {
            $total = 0;
            foreach($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            // Coupon Calculation
            $couponCode = null;
            $discountAmount = 0.00;
            if (session()->has('coupon')) {
                $coupon = session()->get('coupon');
                $couponCode = $coupon->code;
                $discountAmount = $coupon->discount_amount;
                $total = max(0, $total - $discountAmount);

                // Note: Coupon will be marked as used (is_used = true) ONLY when payment is completed/confirmed.
            }

            // Create Address record if they don't have one and input shipping info
            if (auth()->check()) {
                $userAddressesCount = \App\Models\Address::where('user_id', auth()->id())->count();
                if ($userAddressesCount === 0 && $validated['shipping_info']) {
                    \App\Models\Address::create([
                        'user_id' => auth()->id(),
                        'address_line' => $validated['shipping_info'],
                        'province' => 'กรุงเทพมหานคร',
                        'district' => 'เขต/อำเภอ',
                        'subdistrict' => 'แขวง/ตำบล',
                        'postal_code' => '10000',
                        'phone' => '000-000-0000',
                        'is_main' => true
                    ]);
                }
            }

            // Create Order as "pending"
            $order = Order::create([
                'user_id' => auth()->id() ?? 1,
                'total_amount' => $total,
                'status' => 'pending',
                'shipping_info' => $validated['shipping_info'],
                'coupon_code' => $couponCode,
                'discount_amount' => $discountAmount,
            ]);

            // Create Order Items
            foreach($cart as $id => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            // Create Payment record as "pending"
            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $validated['payment_method'],
                'amount' => $total,
                'status' => 'pending',
            ]);
            
            DB::commit();

            // Remove processed items from cart
            $fullCart = session()->get('cart', []);
            foreach($cart as $id => $item) {
                unset($fullCart[$id]);
            }
            session()->put('cart', $fullCart);
            session()->forget('coupon');
            session()->forget('checkout_items');

            return redirect()->route('checkout.pay', $order->id);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
        }
    }

    public function pay($id)
    {
        $userId = auth()->id() ?? 1;
        $order = Order::with('items.product')->where('user_id', $userId)->findOrFail($id);
        if ($order->status !== 'pending') {
            return redirect()->route('dashboard', ['tab' => 'orders'])->with('info', 'คำสั่งซื้อนี้มีสถานะอื่นแล้ว');
        }
        
        $paymentMethods = auth()->check() ? \App\Models\UserPaymentMethod::where('user_id', auth()->id())->get() : collect();
        
        return view('checkout.pay', compact('order', 'paymentMethods'));
    }

    public function uploadSlip(Request $request, $id)
    {
        $request->validate([
            'slip_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        $userId = auth()->id() ?? 1;
        $order = Order::where('user_id', $userId)->findOrFail($id);
        if ($order->status !== 'pending') {
            return redirect()->route('dashboard', ['tab' => 'orders'])->with('info', 'คำสั่งซื้อนี้ไม่ได้อยู่ในสถานะรอชำระเงิน');
        }

        if ($request->hasFile('slip_image')) {
            $path = $request->file('slip_image')->store('payment_slips', 'public');
            $sourcePath = storage_path('app/public/' . $path);
            $targetPath = public_path('storage/' . $path);
            @mkdir(dirname($targetPath), 0777, true);
            if (file_exists($sourcePath)) {
                @copy($sourcePath, $targetPath);
            }
            
            // Update order status & mark payment as submitted for verification
            $order->update(['status' => 'pending_verification']);
            
            // Update or create payment record with slip image
            Payment::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'payment_method' => 'promptpay',
                    'amount'         => $order->total_amount,
                    'slip_image'     => $path,
                    'status'         => 'pending'
                ]
            );

            // Deduct stock immediately when customer uploads slip (prevents overselling)
            $order->load('items.product');
            $order->deductStock();

            // Fire real-time notification event ONLY after customer uploads slip/pays
            try {
                event(new \App\Events\NewOrderCreated($order));
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('Order broadcast failed: ' . $e->getMessage());
            }

            return redirect()->route('dashboard', ['tab' => 'orders'])->with('sweet_success', 'อัปโหลดสลิปชำระเงินสำเร็จ! คำสั่งซื้อของคุณเข้าสู่ระบบเรียบร้อยแล้ว กรุณารอระบบทำการตรวจสอบความถูกต้อง');
        }

        return redirect()->back()->with('error', 'กรุณาอัปโหลดรูปภาพสลิปชำระเงิน');
    }

    public function success($id)
    {
        $order = Order::findOrFail($id);
        return view('checkout.success', compact('order'));
    }

    public function payDirectDebit(Request $request, $id)
    {
        $validated = $request->validate([
            'payment_method_id' => 'required|exists:user_payment_methods,id',
        ]);

        $order = Order::where('user_id', auth()->id())->findOrFail($id);
        if ($order->status !== 'pending') {
            return redirect()->route('dashboard', ['tab' => 'orders'])->with('info', 'คำสั่งซื้อนี้ไม่ได้อยู่ในสถานะรอชำระเงิน');
        }

        $paymentMethod = \App\Models\UserPaymentMethod::where('user_id', auth()->id())->findOrFail($validated['payment_method_id']);

        // Simulate payment api debit
        DB::beginTransaction();
        try {
            // Update order status and deduct stock via unified confirm logic
            $payment = Payment::where('order_id', $order->id)->first();
            if ($payment) {
                $payment->update([
                    'payment_method' => 'direct_debit',
                    'transaction_id' => 'DD-' . strtoupper(uniqid())
                ]);
            }
            $order->confirm();
            
            try {
                event(new \App\Events\NewOrderCreated($order));
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('Order broadcast failed: ' . $e->getMessage());
            }

            DB::commit();
            return redirect()->route('checkout.success', $order->id)->with('sweet_success', "หักบัญชีอัตโนมัติสำเร็จ! ธนาคาร {$paymentMethod->provider} บัญชีเลขท้าย **" . substr($paymentMethod->account_number, -4) . " ชำระแล้ว");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาดในการตัดบัญชีอัตโนมัติ: ' . $e->getMessage());
        }
    }

    public function payOmise(Request $request, $id)
    {
        $validated = $request->validate([
            'omise_token' => 'required|string',
        ]);

        $order = Order::where('user_id', auth()->id())->findOrFail($id);
        if ($order->status !== 'pending') {
            return redirect()->route('dashboard', ['tab' => 'orders'])->with('info', 'คำสั่งซื้อนี้ไม่ได้อยู่ในสถานะรอชำระเงิน');
        }

        DB::beginTransaction();
        try {
            // Simulate Omise API charge creation using the token
            // In the future, this can be swapped with Omise PHP SDK:
            // OmiseCharge::create(['amount' => $order->total_amount * 100, 'currency' => 'thb', 'card' => $request->omise_token]);

            // Update order status and deduct stock via unified confirm logic
            $payment = Payment::where('order_id', $order->id)->first();
            if ($payment) {
                $payment->update([
                    'payment_method' => 'omise',
                    'transaction_id' => 'OMISE-CHG-' . strtoupper(uniqid())
                ]);
            }
            $order->confirm();
            
            try {
                event(new \App\Events\NewOrderCreated($order));
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('Order broadcast failed: ' . $e->getMessage());
            }

            DB::commit();
            return redirect()->route('checkout.success', $order->id)->with('sweet_success', "ชำระเงินผ่าน Omise Payment Gateway สำเร็จ! หมายเลขรายการอ้างอิง: " . ($payment ? $payment->transaction_id : 'N/A'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาดในการจ่ายเงินผ่าน Omise: ' . $e->getMessage());
        }
    }
    public function cancel($id)
    {
        $order = Order::with('items.product')->where('user_id', auth()->id())->findOrFail($id);

        // Allow cancel only if order is still pending (not paid) or pending_verification (paid but not confirmed)
        if (!in_array($order->status, ['pending', 'pending_verification'])) {
            return redirect()->back()->with('error', 'คำสั่งซื้อนี้ไม่สามารถยกเลิกได้ เนื่องจากแอดมินได้ยืนยันและดำเนินการแล้ว');
        }

        // Cancel and restore stock (if slip was already uploaded, stock was deducted — restore it)
        $order->cancelAndRestoreStock();

        return redirect()->route('dashboard', ['tab' => 'orders'])->with('sweet_success', 'ยกเลิกคำสั่งซื้อเรียบร้อยแล้ว สต๊อกสินค้าได้รับการอัปเดตแล้ว');
    }
}

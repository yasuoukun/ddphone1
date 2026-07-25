<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Customer\ProfileController as CustomerProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CentralAdminDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $categories = \App\Models\Category::all();
    $popularProducts = \App\Models\Product::with('images')->orderBy('id', 'desc')->take(8)->get();
    
    // Articles written by admins
    $articles = \App\Models\Article::where('is_published', true)->orderBy('created_at', 'desc')->take(6)->get();

    // CMS Data
    $banners = \App\Models\PromotionalBanner::where('is_active', true)->orderBy('sort_order')->get();
    $settings = [
        'slogan_badge' => \App\Models\HomepageSetting::get('slogan_badge', '🔥 โปรโมชันพิเศษ ลดสูงสุด 50%'),
        'slogan_title' => \App\Models\HomepageSetting::get('slogan_title', 'DDPHONE ดีดีโฟน จัดเต็มโปรโมชัน!'),
        'slogan_description' => \App\Models\HomepageSetting::get('slogan_description', "สมาร์ทโฟน แท็บเล็ต แก็ดเจ็ต และบริการซ่อมครบวงจร\nพร้อมประกันศูนย์และบริการหลังการขายระดับพรีเมียม"),
    ];

    return view('welcome', compact('categories', 'popularProducts', 'banners', 'settings', 'articles'));
})->name('home');

Route::get('/products', [\App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [\App\Http\Controllers\ProductController::class, 'show'])->name('products.show');
Route::get('/promotions', function () {
    $coupons = \App\Models\Coupon::where('expires_at', '>=', now()->toDateTimeString())->orderBy('discount_amount', 'desc')->get();
    $collectedCouponIds = auth()->check() ? \App\Models\CollectedCoupon::where('user_id', auth()->id())->pluck('coupon_id')->toArray() : [];
    $banners = \App\Models\PromotionalBanner::where('is_active', true)->orderBy('sort_order')->get();
    
    // Get products with active discounts
    $discountedProducts = \App\Models\Product::with('images')
        ->whereNotNull('discount_price')
        ->where('discount_price', '>', 0)
        ->orderByRaw('(price - discount_price) DESC')
        ->take(12)
        ->get();
        
    return view('promotions.index', compact('coupons', 'collectedCouponIds', 'discountedProducts', 'banners'));
})->name('promotions.index');

Route::post('/promotions/collect/{coupon}', function (\App\Models\Coupon $coupon) {
    if (!auth()->check()) {
        return response()->json(['success' => false, 'message' => 'กรุณาเข้าสู่ระบบก่อนเก็บคูปอง'], 401);
    }
    $exists = \App\Models\CollectedCoupon::where('user_id', auth()->id())
        ->where('coupon_id', $coupon->id)
        ->exists();
    if ($exists) {
        return response()->json(['success' => false, 'message' => 'คุณได้เก็บคูปองนี้ไปแล้ว']);
    }
    \App\Models\CollectedCoupon::create([
        'user_id' => auth()->id(),
        'coupon_id' => $coupon->id,
        'is_used' => false
    ]);
    return response()->json(['success' => true, 'message' => 'เก็บคูปองสำเร็จ! สามารถนำไปเลือกใช้ตอนชำระเงินได้ทันที']);
})->middleware('auth')->name('promotions.collect');

Route::post('/cart/add/{id}', [\App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [\App\Http\Controllers\CartController::class, 'view'])->name('cart.index');
Route::patch('/cart/update', [\App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove', [\App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');

// New Public Info & Tools Routes
Route::get('/installment', function () {
    return view('installment');
})->name('installment');

Route::get('/trade-in', function () {
    return view('trade_in');
})->name('trade_in');

Route::get('/education', function () {
    return view('education');
})->name('education');

Route::get('/business', function () {
    return view('business');
})->name('business');

Route::get('/service-center', function () {
    return view('service_center');
})->name('service_center');

Route::get('/help-center', function () {
    return view('help_center');
})->name('help_center');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/services', function () {
    return view('services');
})->name('services');

Route::get('/categoryblog', function () {
    $articles = \App\Models\Article::where('is_published', true)->orderBy('created_at', 'desc')->get();
    return view('blog', compact('articles'));
})->name('categoryblog');

Route::get('/blog/{article}', function (\App\Models\Article $article) {
    $articles = \App\Models\Article::where('is_published', true)->orderBy('created_at', 'desc')->get();
    return view('blog', compact('articles', 'article'));
})->name('blog.show');

Route::get('/tracking', [\App\Http\Controllers\ClaimController::class, 'track'])->name('tracking');
Route::post('/claims/submit', [\App\Http\Controllers\ClaimController::class, 'store'])->name('claims.submit');
Route::get('/quotation/generate', [\App\Http\Controllers\QuotationController::class, 'generate'])->name('quotation.generate');
Route::post('/quotations', [\App\Http\Controllers\QuotationController::class, 'store'])->name('quotations.store');

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [\App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [\App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success/{id}', [\App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');
    
    // Messages
    Route::get('/messages', [\App\Http\Controllers\MessageController::class, 'index'])->name('messages.index');
    Route::post('/messages', [\App\Http\Controllers\MessageController::class, 'store'])->name('messages.store');
});

Route::get('/dashboard', function () {
    $role = auth()->user()->role;
    $query = request()->query();
    if ($role === 'super_admin') {
        return redirect()->route('central_admin.dashboard', $query);
    } elseif ($role === 'admin') {
        return redirect()->route('admin.dashboard', $query);
    }
    return redirect()->route('customer.dashboard', $query);
})->middleware(['auth', 'verified'])->name('dashboard');

// Customer Routes
Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', function () {
        $orders = \App\Models\Order::with('items.product')->where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();
        $addresses = \App\Models\Address::where('user_id', auth()->id())->get();
        $wishlists = \App\Models\Wishlist::with('product.images')->where('user_id', auth()->id())->get();
        $collectedCoupons = \App\Models\CollectedCoupon::with('coupon.product')
            ->where('user_id', auth()->id())
            ->orderBy('is_used', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
        $paymentMethods = \App\Models\UserPaymentMethod::where('user_id', auth()->id())->get();
        $quotations = \App\Models\Quotation::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();
        $claims = \App\Models\Claim::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();
        return view('dashboard', compact('orders', 'addresses', 'wishlists', 'collectedCoupons', 'paymentMethods', 'quotations', 'claims'));
    })->name('dashboard');
    
    Route::post('/addresses', [\App\Http\Controllers\AddressController::class, 'store'])->name('addresses.store');
    Route::put('/addresses/{address}', [\App\Http\Controllers\AddressController::class, 'update'])->name('addresses.update');
    Route::patch('/addresses/{address}/main', [\App\Http\Controllers\AddressController::class, 'setMain'])->name('addresses.set_main');
    Route::delete('/addresses/{address}', [\App\Http\Controllers\AddressController::class, 'destroy'])->name('addresses.destroy');

    Route::post('/orders/{order}/cancel', [\App\Http\Controllers\CheckoutController::class, 'cancel'])->name('orders.cancel');

    // User Saved Payment Methods Routes
    Route::post('/payment-methods', [\App\Http\Controllers\Customer\PaymentMethodController::class, 'store'])->name('payment_methods.store');
    Route::patch('/payment-methods/{paymentMethod}/default', [\App\Http\Controllers\Customer\PaymentMethodController::class, 'setDefault'])->name('payment_methods.set_default');
    Route::delete('/payment-methods/{paymentMethod}', [\App\Http\Controllers\Customer\PaymentMethodController::class, 'destroy'])->name('payment_methods.destroy');
});

// General Admin Routes
Route::middleware(['auth', 'role:admin,super_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class);
    
    // Stock management
    Route::get('/stock', [\App\Http\Controllers\Admin\StockController::class, 'index'])->name('stock.index');
    Route::post('/stock/update', [\App\Http\Controllers\Admin\StockController::class, 'update'])->name('stock.update');

    Route::get('/chats', function () {
        $userIds = \App\Models\Message::select('sender_id')
            ->distinct()
            ->where('sender_id', '!=', auth()->id())
            ->pluck('sender_id')
            ->merge(
                \App\Models\Message::select('receiver_id')
                    ->distinct()
                    ->whereNotNull('receiver_id')
                    ->where('receiver_id', '!=', auth()->id())
                    ->pluck('receiver_id')
            )
            ->merge(
                \App\Models\User::where('role', 'customer')->where('id', '!=', auth()->id())->pluck('id')
            )
            ->unique();
            
        $users = \App\Models\User::whereIn('id', $userIds)->where('id', '!=', auth()->id())->get();
        return view('admin.chats.index', compact('users'));
    })->name('chats.index');

    Route::get('/chats/list-ajax', function () {
        $userIds = \App\Models\Message::select('sender_id')
            ->distinct()
            ->where('sender_id', '!=', auth()->id())
            ->pluck('sender_id')
            ->merge(
                \App\Models\Message::select('receiver_id')
                    ->distinct()
                    ->whereNotNull('receiver_id')
                    ->where('receiver_id', '!=', auth()->id())
                    ->pluck('receiver_id')
            )
            ->merge(
                \App\Models\User::where('role', 'customer')->where('id', '!=', auth()->id())->pluck('id')
            )
            ->unique();
            
        $users = \App\Models\User::whereIn('id', $userIds)->where('id', '!=', auth()->id())->get();
        
        // Add unread count and last message details per user
        $users->each(function($user) {
            $user->unread_count = \App\Models\Message::where('sender_id', $user->id)
                ->whereNull('receiver_id')
                ->where('is_read', false)
                ->count();

            $lastMsg = \App\Models\Message::where(function($q) use ($user) {
                    $q->where('sender_id', $user->id)
                      ->orWhere('receiver_id', $user->id);
                })
                ->orderBy('created_at', 'desc')
                ->first();

            if ($lastMsg) {
                $user->last_message_content = $lastMsg->content;
                $user->last_message_sender_id = $lastMsg->sender_id;
                $user->last_message_time = $lastMsg->created_at->toISOString();
            } else {
                $user->last_message_content = null;
                $user->last_message_sender_id = null;
                $user->last_message_time = null;
            }
        });
        
        return response()->json($users);
    })->name('chats.list_ajax');

    Route::get('/notification-counts', function () {
        $unreadChats = \App\Models\Message::whereNull('receiver_id')->where('is_read', false)->count();
        $lastViewed = session('last_viewed_orders_at');
        $ordersQuery = \App\Models\Order::where('status', 'pending_verification');
        if ($lastViewed) { $ordersQuery->where('created_at', '>', $lastViewed); }
        $pendingOrders = $ordersQuery->count();
        return response()->json(['unread_chats' => $unreadChats, 'pending_orders' => $pendingOrders]);
    })->name('notification_counts');

    // Admin Claims Management
    Route::resource('claims', \App\Http\Controllers\Admin\ClaimController::class)->only(['index', 'show', 'update', 'destroy']);

    // Admin Quotations Management
    Route::get('/quotations', [\App\Http\Controllers\Admin\AdminQuotationController::class, 'index'])->name('quotations.index');
    Route::post('/quotations/{quotation}/status', [\App\Http\Controllers\Admin\AdminQuotationController::class, 'updateStatus'])->name('quotations.update_status');
    Route::delete('/quotations/{quotation}', [\App\Http\Controllers\Admin\AdminQuotationController::class, 'destroy'])->name('quotations.destroy');
});

// Central Admin Routes
Route::middleware(['auth', 'role:admin,super_admin'])->prefix('central-admin')->name('central_admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\CentralAdminDashboardController::class, 'index'])->name('dashboard');
    Route::post('/images/{image}/primary', [\App\Http\Controllers\Admin\ProductController::class, 'setImagePrimary'])->name('products.images.primary');
    Route::delete('/images/{image}', [\App\Http\Controllers\Admin\ProductController::class, 'deleteImage'])->name('products.images.delete');
    Route::get('/products/generate-sku', [\App\Http\Controllers\Admin\ProductController::class, 'generateSkuAjax'])->name('products.generate_sku');
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('brands', \App\Http\Controllers\Admin\BrandController::class);
    Route::resource('coupons', \App\Http\Controllers\Admin\CouponController::class);
    Route::resource('reviews', \App\Http\Controllers\Admin\ReviewController::class)->only(['index', 'destroy']);
    Route::resource('articles', \App\Http\Controllers\Admin\ArticleController::class);
    
    // CMS Settings
    Route::get('/cms', [\App\Http\Controllers\Admin\CmsController::class, 'index'])->name('cms.index');
    Route::post('/cms/settings', [\App\Http\Controllers\Admin\CmsController::class, 'updateSettings'])->name('cms.update_settings');
    Route::post('/cms/banners', [\App\Http\Controllers\Admin\CmsController::class, 'storeBanner'])->name('cms.banners.store');
    Route::delete('/cms/banners/{banner}', [\App\Http\Controllers\Admin\CmsController::class, 'deleteBanner'])->name('cms.banners.destroy');

    Route::get('/notifications', [\App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/send', [\App\Http\Controllers\Admin\NotificationController::class, 'send'])->name('notifications.send');

    // Super Admin User Management
    Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::post('/users', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
    Route::patch('/users/{user}/role', [\App\Http\Controllers\Admin\UserController::class, 'updateRole'])->name('users.update_role');
    Route::patch('/users/{user}/status', [\App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggle_status');
    Route::delete('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Notifications
    Route::post('/notifications/read-all', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifications.markAllAsRead');

    // Wishlist Toggle
    Route::post('/wishlist/toggle/{product}', [\App\Http\Controllers\WishlistController::class, 'toggle'])->name('wishlist.toggle');

    // Product Review Store
    Route::post('/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');

    Route::post('/coupons/apply', [\App\Http\Controllers\CheckoutController::class, 'applyCoupon'])->name('coupons.apply');

    Route::post('/orders/{order}/cancel', [\App\Http\Controllers\CheckoutController::class, 'cancel'])->name('orders.cancel');

    Route::get('/checkout/pay/{order}', [\App\Http\Controllers\CheckoutController::class, 'pay'])->name('checkout.pay');
    Route::post('/checkout/pay/{order}/upload', [\App\Http\Controllers\CheckoutController::class, 'uploadSlip'])->name('checkout.upload_slip');
    Route::post('/checkout/pay/{order}/direct-debit', [\App\Http\Controllers\CheckoutController::class, 'payDirectDebit'])->name('checkout.pay_direct_debit');
    Route::post('/checkout/pay/{order}/omise', [\App\Http\Controllers\CheckoutController::class, 'payOmise'])->name('checkout.pay_omise');
});


// ========================================================
// 2C2P SCB Payment Gateway Routes
// ========================================================
// Webhook: no auth, no CSRF (2C2P server calls this directly)
Route::post('/payment/2c2p/webhook', [\App\Http\Controllers\TwoC2PController::class, 'webhook'])
    ->name('payment.2c2p.webhook')
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

// Initiate + Return: requires auth
Route::middleware('auth')->group(function () {
    Route::post('/payment/2c2p/{order}/initiate', [\App\Http\Controllers\TwoC2PController::class, 'initiate'])
        ->name('payment.2c2p.initiate');
    Route::get('/payment/2c2p/return', [\App\Http\Controllers\TwoC2PController::class, 'return'])
        ->name('payment.2c2p.return');
});

require __DIR__.'/auth.php';

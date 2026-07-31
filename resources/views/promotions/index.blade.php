@extends('layouts.store')

@section('title', 'โปรเด็ด & คูปองส่วนลดพิเศษ | DDPHONE ดีดีโฟน')
@section('meta_title', 'โปรเด็ด & คูปองส่วนลดพิเศษ | DDPHONE ดีดีโฟน')
@section('meta_description', 'รวมโปรโมชันเด็ดและโค้ดส่วนลดพิเศษประจำเดือนจาก DDPHONE ดีดีโฟน กดเก็บโค้ดส่วนลดง่ายๆ นำไปใช้ลดราคาได้ทันทีในการสั่งซื้อ')
@section('meta_keywords', 'โปรเด็ด, คูปองส่วนลด, โค้ดส่วนลด, DDPHONE, ดีดีโฟน, ลดราคา')

@section('content')
<style>
    @keyframes pulseGlowFun {
        0%, 100% { box-shadow: 0 0 12px rgba(255, 230, 0, 0.4); transform: scale(1); }
        50% { box-shadow: 0 0 25px rgba(255, 230, 0, 0.85); transform: scale(1.03); }
    }
    .anim-pulse-glow {
        animation: pulseGlowFun 2.5s ease-in-out infinite !important;
    }
    @keyframes couponShake {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-4px); }
    }
    .coupon-card-motion {
        transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.25s ease !important;
    }
    .coupon-card-motion:hover {
        transform: translateY(-6px) scale(1.015) !important;
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.12) !important;
    }
</style>

<!-- Full-Width Edge-to-Edge Banner Section (Section 5) -->
<div style="width: 100%; margin-bottom: 3.5rem; overflow: hidden; background: #0F172A;">
    @if(isset($banners) && count($banners) > 0)
    <div x-data="{ 
        currentSlide: 0, 
        totalSlides: {{ count($banners) }},
        timer: null,
        init() {
            this.startAutoSlide();
        },
        startAutoSlide() {
            this.timer = setInterval(() => {
                this.nextSlide();
            }, 5000);
        },
        nextSlide() {
            this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
        },
        prevSlide() {
            this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
        }
    }" @mouseenter="clearInterval(timer)" @mouseleave="startAutoSlide()" 
       style="position: relative; width: 100%; aspect-ratio: 21/8; min-height: 320px; max-height: 520px; background: #0F172A;">
        
        <!-- Slide Items -->
        @foreach($banners as $index => $banner)
        <div x-show="currentSlide === {{ $index }}" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" style="position: absolute; inset: 0; width: 100%; height: 100%;">
            @if($banner->link_url)
                <a href="{{ $banner->link_url }}" target="_blank" style="display: block; width: 100%; height: 100%;">
                    <img src="{{ str_starts_with($banner->image_path, 'http') ? $banner->image_path : Storage::url($banner->image_path) }}" alt="Promotion Banner" style="width: 100%; height: 100%; object-fit: cover;">
                </a>
            @else
                <img src="{{ str_starts_with($banner->image_path, 'http') ? $banner->image_path : Storage::url($banner->image_path) }}" alt="Promotion Banner" style="width: 100%; height: 100%; object-fit: cover;">
            @endif
        </div>
        @endforeach

        <!-- Overlay Text & Glowing Badge -->
        <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(15, 23, 42, 0.95)); padding: 2.5rem 3rem; display: flex; justify-content: space-between; align-items: flex-end; z-index: 5;">
            <div>
                <span class="anim-pulse-glow" style="background: #FFE600; color: #0F172A; font-size: 0.8rem; padding: 5px 16px; border-radius: 99px; font-weight: 900; margin-bottom: 0.5rem; display: inline-block;">
                    🔥 PROMOTION & HOT DEALS
                </span>
                <h2 style="font-size: 1.8rem; font-weight: 900; color: white; margin: 4px 0 0;">
                    โปรเด็ด & โค้ดส่วนลดพิเศษสุดคุ้ม
                </h2>
            </div>
        </div>

        <!-- Navigation Arrows -->
        <button type="button" @click="prevSlide()" style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%); background: rgba(15, 23, 42, 0.7); color: white; border: 1.5px solid rgba(255,255,255,0.3); width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; backdrop-filter: blur(4px); font-size: 1.2rem; z-index: 10;">
            &lsaquo;
        </button>
        <button type="button" @click="nextSlide()" style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); background: rgba(15, 23, 42, 0.7); color: white; border: 1.5px solid rgba(255,255,255,0.3); width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; backdrop-filter: blur(4px); font-size: 1.2rem; z-index: 10;">
            &rsaquo;
        </button>
    </div>
    @else
    <!-- Full-width Default Banner -->
    <div style="width: 100%; min-height: 280px; padding: 3.5rem 2rem; background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%); text-align: center; color: white; position: relative;">
        <span class="anim-pulse-glow" style="display: inline-block; background: #FFE600; color: #0F172A; padding: 6px 20px; border-radius: 99px; font-size: 0.85rem; font-weight: 900; margin-bottom: 1rem;">
            🔥 SPECIAL DEALS & COUPONS
        </span>
        <h1 style="font-size: 2.2rem; font-weight: 900; margin: 0 0 0.75rem; color: white;">
            โปรเด็ด & โค้ดส่วนลดสุดคุ้ม
        </h1>
        <p style="font-size: 1.05rem; color: #E2E8F0; font-weight: 500; max-width: 650px; margin: 0 auto;">
            กดเก็บโค้ดส่วนลดไปใช้ในขั้นตอนชำระเงินเพื่อรับส่วนลดพิเศษทันที!
        </p>
    </div>
    @endif
</div>

<div class="container fade-in" style="max-width: 1100px; margin: 0 auto; padding: 0 1rem 4rem;">

    <!-- Title Section -->
    <div style="text-align: center; margin-bottom: 2.5rem;">
        <span style="display: inline-block; background: #FFE600; color: #0F172A; padding: 4px 16px; border-radius: 99px; font-size: 0.8rem; font-weight: 900; margin-bottom: 0.5rem; letter-spacing: 0.5px;">COLLECT COUPONS</span>
        <h2 style="font-size: 2rem; color: #0F172A; font-weight: 900; margin: 0;">
            🎟️ คูปองส่วนลดพิเศษประจำเดือน
        </h2>
    </div>

    <!-- Coupons List -->
    <div style="display: flex; flex-direction: column; gap: 1.5rem; margin-bottom: 4.5rem;">
        @forelse($coupons as $coupon)
        @php
            $isCollected = in_array($coupon->id, $collectedCouponIds);
        @endphp
        <div class="coupon-card-motion" style="background: white; border: 2px dashed #0F172A; border-radius: 22px; display: flex; overflow: hidden; box-shadow: 0 8px 25px rgba(15, 23, 42, 0.06); flex-wrap: wrap; position: relative;">
            
            <!-- Left Ticket Part (Navy Box with Yellow Glow Text) -->
            <div style="background: #0F172A; color: white; padding: 2rem; display: flex; flex-direction: column; justify-content: center; align-items: center; min-width: 220px; text-align: center; border-right: 2px dashed #FFE600; position: relative;">
                <span style="font-size: 0.82rem; font-weight: 900; color: #FFE600; text-transform: uppercase; letter-spacing: 1px;">⚡ โค้ดลดพิเศษ</span>
                <h3 style="font-size: 2.4rem; font-weight: 900; color: #FFE600; margin: 0.4rem 0; text-shadow: 0 0 10px rgba(255, 230, 0, 0.4);">฿{{ number_format($coupon->discount_amount, 0) }}</h3>
                <span style="font-size: 0.8rem; color: #CBD5E1; font-weight: 700;">
                    @if($coupon->product)
                        เฉพาะสินค้าที่ร่วมรายการ
                    @else
                        ไม่มีขั้นต่ำในการสั่งซื้อ
                    @endif
                </span>
            </div>

            <!-- Right Info Part -->
            <div style="padding: 1.5rem 2rem; flex: 1 1 300px; display: flex; flex-direction: column; justify-content: space-between; background: white;">
                <div>
                    <h4 style="font-size: 1.3rem; color: #0F172A; font-weight: 900; margin: 0 0 0.5rem;">
                        {{ $coupon->name }}
                    </h4>
                    <p style="color: #64748b; font-size: 0.9rem; margin: 0; font-weight: 700;">
                        @if($coupon->product)
                            <span style="color: #EF4444; font-weight: 800;">⚠️ คูปองนี้ใช้ได้เฉพาะกับ: {{ $coupon->product->name }}</span>
                        @else
                            <span>ใช้ได้กับสมาร์ทโฟนมือสองและสินค้าทุกชิ้นในร้าน DDPHONE</span>
                        @endif
                    </p>
                </div>
                
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px; margin-top: 1.25rem; border-top: 1.5px solid #F1F5F9; padding-top: 1rem;">
                    <div>
                        <p style="margin: 0 0 2px; font-size: 0.78rem; color: #64748b; font-weight: 800;">รหัสโค้ดส่วนลด:</p>
                        <strong style="font-size: 1.25rem; color: #0F172A; font-family: monospace; letter-spacing: 1px; background: #FFE600; padding: 4px 14px; border-radius: 8px; border: 1.5px solid #0F172A; display: inline-block;">{{ $coupon->code }}</strong>
                    </div>
                    
                    <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
                        <span class="countdown-timer" data-expires="{{ $coupon->expires_at }}" style="font-size: 0.82rem; color: #D97706; font-weight: 800; background: #FEF3C7; padding: 6px 14px; border-radius: 99px; border: 1px solid #FCD34D;">
                            ⌛ โค้ดหมดอายุใน: --:--:--
                        </span>

                        @if($isCollected)
                            <button disabled style="background: #94A3B8; color: white; border: none; padding: 11px 26px; border-radius: 99px; font-weight: 800; font-size: 0.9rem; cursor: not-allowed;">
                                ✓ เก็บโค้ดแล้ว
                            </button>
                        @else
                            <button onclick="collectCoupon(this, '{{ $coupon->id }}')" class="anim-pulse-glow" style="background: #0F172A; color: #FFE600; border: none; padding: 11px 26px; border-radius: 99px; font-weight: 900; font-size: 0.9rem; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.background='#1E293B'" onmouseout="this.style.background='#0F172A'">
                                🎁 กดเก็บโค้ดส่วนลด
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div style="background: white; border: 2px solid #E2E8F0; border-radius: 24px; padding: 4rem 2rem; text-align: center; color: #64748b;">
            <span style="font-size: 3.5rem;">🎟️</span>
            <h3 style="margin-top: 1rem; font-size: 1.25rem; font-weight: 900; color: #0F172A;">ขณะนี้ยังไม่มีโปรโมชันคูปองส่วนลดพิเศษ</h3>
            <p style="font-size: 0.9rem; margin-top: 5px; font-weight: 600;">โปรดติดตามข่าวสารและโปรโมชันพิเศษจากทางร้าน DDPHONE ในเร็วๆ นี้</p>
        </div>
        @endforelse
    </div>

    <!-- Discounted Products Grid (Matching Main Products Grid Layout) -->
    <div style="margin-top: 3rem; margin-bottom: 2rem;">
        <div style="border-bottom: 2px solid #E2E8F0; padding-bottom: 0.75rem; margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
            <div>
                <span style="display: inline-block; background: #FFE600; color: #0F172A; padding: 4px 14px; border-radius: 99px; font-size: 0.75rem; font-weight: 900; margin-bottom: 0.4rem;">
                    🔥 HOT PROMOTIONS
                </span>
                <h2 style="font-size: 1.5rem; font-weight: 900; color: #0F172A; margin: 0; letter-spacing: -0.02em;">
                    สินค้าโปรเด็ดลดราคาพิเศษ
                </h2>
            </div>
            <a href="{{ route('products.index', ['on_sale' => 1]) }}" style="font-size: 0.85rem; color: #0F172A; text-decoration: none; font-weight: 800; display: flex; align-items: center; gap: 6px;">
                ดูทั้งหมด <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <div class="product-grid-container" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(230px, 1fr)); gap: 16px;">
            @forelse($discountedProducts as $product)
            <div class="card-fun-hover shopee-card-style" style="background: white; border: 1px solid #E2E8F0; border-radius: 14px; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04); position: relative; transition: all 0.2s ease;">
                
                <!-- Image Box (Shopee 1:1 Square Ratio with Overlay Badges) -->
                <a href="{{ route('products.show', $product->id) }}" style="text-decoration: none; color: inherit; display: block; position: relative; width: 100%; aspect-ratio: 1/1; background: #F8FAFC; overflow: hidden;">
                    @if($product->discount_price)
                        @php $percent = round((($product->price - $product->discount_price) / $product->price) * 100); @endphp
                        <span style="position: absolute; top: 6px; left: 6px; z-index: 10; font-size: 10px; font-weight: 900; background: #FF5722; color: white; padding: 2px 7px; border-radius: 4px; box-shadow: 0 2px 6px rgba(255,87,34,0.3);">
                            -{{ $percent }}%
                        </span>
                    @else
                        <span style="position: absolute; top: 6px; left: 6px; z-index: 10; font-size: 10px; font-weight: 900; background: #FF5722; color: white; padding: 2px 7px; border-radius: 4px;">
                            ลดพิเศษ 🔥
                        </span>
                    @endif

                    @if($product->stock <= 0)
                        <span style="position: absolute; top: 6px; right: 6px; z-index: 10; font-size: 9px; font-weight: 900; background: #EF4444; color: white; padding: 2px 6px; border-radius: 4px;">หมด</span>
                    @else
                        <span style="position: absolute; top: 6px; right: 6px; z-index: 10; font-size: 9px; font-weight: 900; background: #FFE600; color: #0F172A; padding: 2px 6px; border-radius: 4px; border: 1px solid #EAB308;">พร้อมส่ง</span>
                    @endif

                    @if($product->primary_image_url)
                        <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: contain; padding: 0.6rem; transition: transform 0.3s ease;">
                    @else
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                            <i class="fa-solid fa-mobile-screen text-4xl"></i>
                        </div>
                    @endif
                </a>
                
                <!-- Details & Pricing Box (Shopee Info Specs) -->
                <div style="padding: 0.5rem 0.55rem 0.45rem; background: white; display: flex; flex-direction: column; justify-content: space-between; flex-grow: 1; gap: 3px;">
                    <a href="{{ route('products.show', $product->id) }}" style="text-decoration: none; color: inherit;">
                        <h3 style="font-size: 0.78rem; font-weight: 700; color: #0F172A; margin: 0; min-height: 2.1rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.3;">
                            {{ $product->name }}
                        </h3>
                    </a>
                    
                    <div style="display: flex; flex-direction: column; gap: 2px;">
                        <div style="display: flex; align-items: baseline; gap: 4px;">
                            @if($product->discount_price)
                                <span style="font-size: 0.98rem; font-weight: 900; color: #FF5722; line-height: 1;">฿{{ number_format($product->discount_price) }}</span>
                                <span style="font-size: 0.65rem; text-decoration: line-through; color: #94A3B8; line-height: 1;">฿{{ number_format($product->price) }}</span>
                            @else
                                <span style="font-size: 0.98rem; font-weight: 900; color: #FF5722; line-height: 1;">฿{{ number_format($product->price) }}</span>
                            @endif
                        </div>

                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 2px;">
                            @php
                                $avgRating = round($product->reviews()->avg('rating') ?? 5.0, 1);
                                $reviewCount = $product->reviews()->count();
                            @endphp
                            <span style="font-size: 0.62rem; color: #64748B; font-weight: 600;">
                                ⭐ {{ number_format($avgRating, 1) }} <span style="color: #CBD5E1;">|</span> {{ $reviewCount > 0 ? 'รีวิว ' . $reviewCount : 'สินค้าใหม่' }}
                            </span>
                            
                            <div style="display: flex; gap: 4px; align-items: center;">
                                @php 
                                    $isFavorite = auth()->check() && \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->exists();
                                @endphp
                                <button type="button" class="wishlist-toggle-btn" data-product-id="{{ $product->id }}" onclick="animateHeartBtn(this)" title="เพิ่มในสินค้าที่ชอบ" style="background: #F8FAFC; border: 1px solid #E2E8F0; color: {{ $isFavorite ? '#EF4444' : '#94A3B8' }}; width: 24px; height: 24px; border-radius: 50%; cursor: pointer; font-size: 0.7rem; display: flex; align-items: center; justify-content: center; transition: all 0.2s;">
                                    <i class="fa-{{ $isFavorite ? 'solid' : 'regular' }} fa-heart"></i>
                                </button>

                                <form action="{{ route('cart.add', $product) }}" method="POST" class="ajax-add-to-cart-form" style="margin: 0;">
                                    @csrf
                                    <button type="submit" onclick="animateBasketBtn(this)" title="เพิ่มลงตะกร้า" style="background: #FF5722; color: white; border: none; width: 24px; height: 24px; border-radius: 50%; cursor: pointer; font-size: 0.7rem; font-weight: 900; display: flex; align-items: center; justify-content: center; transition: all 0.2s; box-shadow: 0 2px 6px rgba(255, 87, 34, 0.3);">
                                        <i class="fa-solid fa-basket-shopping"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div style="grid-column: 1 / -1; background: white; border: 1.5px solid #E2E8F0; border-radius: 24px; padding: 4rem 2rem; text-align: center; color: #64748b;">
                <p style="font-size: 1rem; font-weight: 800; color: #0F172A; margin: 0;">ขณะนี้ยังไม่มีรายการสินค้าลดราคาพิเศษแยกเฉพาะ</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<script>
    // AJAX collect coupon function
    function collectCoupon(btn, couponId) {
        if (!{{ auth()->check() ? 'true' : 'false' }}) {
            Swal.fire({
                icon: 'warning',
                title: 'กรุณาเข้าสู่ระบบ',
                text: 'ต้องเข้าสู่ระบบก่อนจึงจะเก็บคูปองส่วนลดได้',
                confirmButtonText: 'เข้าสู่ระบบ',
                showCancelButton: true,
                cancelButtonText: 'ยกเลิก',
                confirmButtonColor: '#0F172A'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('login') }}";
                }
            });
            return;
        }

        btn.disabled = true;
        btn.innerText = 'กำลังประมวลผล...';

        fetch(`/promotions/collect/${couponId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                btn.style.background = '#94A3B8';
                btn.style.color = '#FFFFFF';
                btn.style.cursor = 'not-allowed';
                btn.classList.remove('anim-pulse-glow');
                btn.innerText = '✓ เก็บโค้ดแล้ว';
                btn.removeAttribute('onclick');
                
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
                Toast.fire({
                    icon: 'success',
                    title: data.message
                });
            } else {
                btn.disabled = false;
                btn.innerText = '🎁 กดเก็บโค้ดส่วนลด';
                Swal.fire({
                    icon: 'info',
                    title: 'คำชี้แจง',
                    text: data.message,
                    confirmButtonColor: '#0F172A'
                });
            }
        })
        .catch(err => {
            console.error(err);
            btn.disabled = false;
            btn.innerText = '🎁 กดเก็บโค้ดส่วนลด';
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: 'ไม่สามารถติดต่อเซิร์ฟเวอร์ได้ กรุณาลองใหม่อีกครั้ง',
                confirmButtonColor: '#0F172A'
            });
        });
    }

    // Countdown Timer Logic
    document.addEventListener('DOMContentLoaded', function() {
        const timers = document.querySelectorAll('.countdown-timer');
        
        function updateTimers() {
            const now = new Date().getTime();
            
            timers.forEach(timer => {
                const expiresString = timer.getAttribute('data-expires');
                if (!expiresString) return;
                const expiryTime = new Date(expiresString.replace(/-/g, "/")).getTime();
                const distance = expiryTime - now;
                
                if (distance < 0) {
                    timer.innerHTML = "⌛ โค้ดหมดอายุแล้ว";
                    timer.style.color = "#94A3B8";
                    timer.style.background = "#F1F5F9";
                } else {
                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    
                    let countdownText = "⌛ เหลือเวลา: ";
                    if (days > 0) {
                        countdownText += days + " วัน ";
                    }
                    countdownText += hours.toString().padStart(2, '0') + ":" + 
                                     minutes.toString().padStart(2, '0') + ":" + 
                                     seconds.toString().padStart(2, '0');
                                     
                    timer.innerHTML = countdownText;
                }
            });
        }
        
        updateTimers();
        setInterval(updateTimers, 1000);
    });
</script>
@endsection

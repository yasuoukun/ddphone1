@extends('layouts.store')

@section('content')
<div class="container" style="max-width: 900px; margin: 3rem auto; padding: 0 1rem;">
    <!-- Auto-Sliding Promotion Banners Carousel -->
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
            }, 4000);
        },
        nextSlide() {
            this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
        },
        prevSlide() {
            this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
        }
    }" @mouseenter="clearInterval(timer)" @mouseleave="startAutoSlide()" 
       style="position: relative; width: 100%; border-radius: 20px; overflow: hidden; margin-bottom: 3rem; box-shadow: 0 15px 35px rgba(0,0,0,0.1); background: #0F172A; aspect-ratio: 21/9; max-height: 380px;">
        
        <!-- Slide Items -->
        @foreach($banners as $index => $banner)
        <div x-show="currentSlide === {{ $index }}" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" style="position: absolute; inset: 0; width: 100%; height: 100%;">
            @if($banner->link_url)
                <a href="{{ $banner->link_url }}" target="_blank" style="display: block; width: 100%; height: 100%;">
                    <img src="{{ str_starts_with($banner->image_path, 'http') ? $banner->image_path : Storage::url($banner->image_path) }}" alt="Promotion Banner" style="width: 100%; height: 100%; object-fit: cover;">
                </a>
            @else
                <img src="{{ str_starts_with($banner->image_path, 'http') ? $banner->image_path : Storage::url($banner->image_path) }}" alt="Promotion Banner" style="width: 100%; height: 100%; object-fit: cover;">
            @endif
        </div>
        @endforeach

        <!-- Navigation Arrows -->
        <button type="button" @click="prevSlide()" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); background: rgba(0,0,0,0.4); color: white; border: none; width: 42px; height: 42px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; backdrop-filter: blur(4px); transition: background 0.2s;" onmouseover="this.style.background='rgba(0,0,0,0.7)'" onmouseout="this.style.background='rgba(0,0,0,0.4)'">
            <i class="fa-solid fa-chevron-left"></i>
        </button>
        <button type="button" @click="nextSlide()" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); background: rgba(0,0,0,0.4); color: white; border: none; width: 42px; height: 42px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; backdrop-filter: blur(4px); transition: background 0.2s;" onmouseover="this.style.background='rgba(0,0,0,0.7)'" onmouseout="this.style.background='rgba(0,0,0,0.4)'">
            <i class="fa-solid fa-chevron-right"></i>
        </button>

        <!-- Dots Indicators -->
        <div style="position: absolute; bottom: 15px; left: 50%; transform: translateX(-50%); display: flex; gap: 8px; z-index: 10;">
            @foreach($banners as $index => $banner)
            <button type="button" @click="currentSlide = {{ $index }}" :style="currentSlide === {{ $index }} ? 'background: #FF4500; width: 24px;' : 'background: rgba(255,255,255,0.6); width: 10px;'" style="height: 10px; border-radius: 5px; border: none; cursor: pointer; transition: all 0.3s;"></button>
            @endforeach
        </div>
    </div>
    @endif

    <div style="text-align: center; margin-bottom: 3rem;">
        <span class="badge-yellow-fun bounce-fun" style="margin-bottom: 0.75rem;">SPECIAL DEALS & COUPONS</span>
        <h2 style="font-size: 2.2rem; color: var(--color-navy-dark); font-weight: 900; margin-bottom: 0.5rem; font-family: 'Prompt', sans-serif;">🔥 โปรเด็ดมือสอง & โค้ดส่วนลดสุดคุ้ม</h2>
        <p style="color: #64748b; font-size: 1.05rem;">กดเก็บโค้ดส่วนลดนำไปใช้ในขั้นตอนชำระเงินเพื่อรับส่วนลดพิเศษทันที!</p>
    </div>

    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        @forelse($coupons as $coupon)
        @php
            $isCollected = in_array($coupon->id, $collectedCouponIds);
        @endphp
        <div class="card-fun-hover" style="background: white; border: 2px dashed #FF5722; border-radius: 20px; display: flex; overflow: hidden; box-shadow: 0 8px 25px rgba(255, 87, 34, 0.08); flex-wrap: wrap;">
            
            <!-- Left Ticket Part -->
            <div style="background: linear-gradient(135deg, #070D1B 0%, #0F172A 100%); color: white; padding: 2rem; display: flex; flex-direction: column; justify-content: center; align-items: center; min-width: 210px; text-align: center; border-right: 2px dashed #FFE600;">
                <span style="font-size: 0.85rem; font-weight: 800; color: #FFE600; text-transform: uppercase; letter-spacing: 1px;">⚡ ลดทันที</span>
                <h3 style="font-size: 2.3rem; font-weight: 900; color: #FFE600; margin: 0.4rem 0;">฿{{ number_format($coupon->discount_amount, 0) }}</h3>
                <span style="font-size: 0.8rem; color: #CBD5E1;">
                    @if($coupon->product)
                        เฉพาะสินค้าที่ร่วมรายการ
                    @else
                        ไม่มีขั้นต่ำ
                    @endif
                </span>
            </div>

            <!-- Right Info Part -->
            <div style="padding: 1.5rem 2rem; flex: 1 1 300px; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <h4 style="font-size: 1.25rem; color: var(--color-navy-dark); font-weight: 800; margin: 0 0 0.5rem;">
                        {{ $coupon->name }}
                    </h4>
                    <p style="color: #64748b; font-size: 0.9rem; margin: 0;">
                        @if($coupon->product)
                            <span style="color: #FF5722; font-weight: 700;">⚠️ คูปองนี้ใช้ได้เฉพาะกับ: {{ $coupon->product->name }}</span>
                        @else
                            <span>ใช้ได้กับสินค้ามือถือมือสองทุกชิ้นในร้าน DDPHONE</span>
                        @endif
                    </p>
                </div>
                
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-top: 1rem; border-top: 1px solid #F1F5F9; padding-top: 1rem;">
                    <div>
                        <p style="margin: 0; font-size: 0.8rem; color: #64748b; font-weight: 600;">รหัสโค้ดส่วนลด:</p>
                        <strong style="font-size: 1.25rem; color: #FF5722; font-family: monospace; letter-spacing: 1px; background: #FFF5F5; padding: 2px 10px; border-radius: 6px; border: 1px solid #FFE600;">{{ $coupon->code }}</strong>
                    </div>
                    
                    <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
                        <span class="countdown-timer" data-expires="{{ $coupon->expires_at }}" style="font-size: 0.82rem; color: #D97706; font-weight: 700; background: #FEF3C7; padding: 5px 12px; border-radius: 20px;">
                            ⌛ โค้ดหมดอายุใน: --:--:--
                        </span>

                        @if($isCollected)
                            <button disabled style="background: #94A3B8; color: white; border: none; padding: 10px 22px; border-radius: 14px; font-weight: 700; font-size: 0.88rem; cursor: not-allowed;">
                                เก็บโค้ดแล้ว
                            </button>
                        @else
                            <button onclick="collectCoupon(this, '{{ $coupon->id }}')" class="btn-orange-fun" style="padding: 9px 22px !important; font-size: 0.88rem !important;">
                                เก็บโค้ดส่วนลด
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div style="background: white; border: 2px solid #E2E8F0; border-radius: 20px; padding: 4rem 2rem; text-align: center; color: #64748b;">
            <span style="font-size: 3rem;">🎟️</span>
            <h3 style="margin-top: 1rem; font-size: 1.2rem; font-weight: 800; color: var(--color-navy-dark);">ขณะนี้ยังไม่มีโปรโมชันคูปองส่วนลดพิเศษ</h3>
            <p style="font-size: 0.9rem; margin-top: 5px;">โปรดติดตามข่าวสารและโปรโมชันพิเศษจากทางร้าน DDPHONE ในเร็วๆ นี้</p>
        </div>
        @endforelse
    </div>

    <!-- Discounted Products Section -->
    <div style="margin-top: 4rem; margin-bottom: 2rem;">
        <div style="border-bottom: 2px solid var(--color-silver); padding-bottom: 1rem; margin-bottom: 2rem; display: flex; align-items: center; justify-content: space-between;">
            <h3 style="font-size: 1.6rem; color: var(--color-navy-dark); font-weight: 800; margin: 0; font-family: 'Prompt', sans-serif; display: flex; align-items: center; gap: 8px;">
                🔥 สินค้าลดราคาพิเศษในช่วงนี้
            </h3>
            <a href="{{ route('products.index', ['on_sale' => 1]) }}" style="font-size: 0.95rem; color: var(--color-navy); text-decoration: none; font-weight: 700; display: flex; align-items: center; gap: 4px;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                ดูทั้งหมด <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 20px;">
            @forelse($discountedProducts as $product)
            @php
                $primaryImage = $product->images->where('is_primary', true)->first() ?? $product->images->first();
                if ($primaryImage) {
                    $imgPath = $primaryImage->image_path;
                    $imagePath = str_starts_with($imgPath, 'http') ? $imgPath : Storage::url($imgPath);
                } else {
                    $imagePath = 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?q=80&w=300&auto=format&fit=crop';
                }
                $discountAmount = $product->price - ($product->discount_price ?? 0);
                $discountPercent = $product->price > 0 ? round(($discountAmount / $product->price) * 100) : 0;
            @endphp
            <div style="background: white; border: 1px solid var(--color-silver-light); border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.02); display: flex; flex-direction: column; transition: all 0.2s;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(0,0,0,0.06)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.02)'">
                <!-- Image Wrapper -->
                <div style="position: relative; height: 190px; background: #f8fafc; display: flex; align-items: center; justify-content: center; padding: 12px;">
                    <img src="{{ $imagePath }}" alt="{{ $product->name }}" style="max-width: 100%; max-height: 100%; object-fit: contain; border-radius: 8px;">
                    
                    <!-- Discount Badge -->
                    @if($discountPercent > 0)
                    <span style="position: absolute; top: 12px; left: 12px; background: #ef4444; color: white; padding: 4px 10px; border-radius: 99px; font-weight: 700; font-size: 0.8rem; box-shadow: 0 2px 5px rgba(239, 68, 68, 0.3); z-index: 2;">
                        ลด {{ $discountPercent }}%
                    </span>
                    @endif
                </div>

                <!-- Product Details -->
                <div style="padding: 1.25rem; display: flex; flex-grow: 1; flex-direction: column; justify-content: space-between; gap: 10px;">
                    <div>
                        <span style="font-size: 0.75rem; text-transform: uppercase; color: #94a3b8; font-weight: 700; letter-spacing: 0.5px;">{{ $product->brand->name ?? 'แบรนด์' }}</span>
                        <h4 style="font-size: 0.95rem; font-weight: 700; color: var(--color-navy-dark); margin: 3px 0 8px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 2.8em;">
                            {{ $product->name }}
                        </h4>
                    </div>

                    <div>
                        <!-- Price display -->
                        <div style="display: flex; align-items: baseline; gap: 6px; margin-bottom: 8px;">
                            <span style="font-size: 1.2rem; font-weight: 800; color: #ef4444;">฿{{ number_format($product->discount_price, 0) }}</span>
                            <span style="font-size: 0.85rem; text-decoration: line-through; color: #94a3b8;">฿{{ number_format($product->price, 0) }}</span>
                        </div>

                        <div style="display: flex; gap: 8px;">
                            <a href="{{ route('products.show', $product->id) }}" style="flex: 1; text-align: center; text-decoration: none; padding: 8px; background: #1B2A47; color: white; font-size: 0.8rem; font-weight: 700; border-radius: 8px; transition: background 0.2s;" onmouseover="this.style.background='#2c3e5d'" onmouseout="this.style.background='#1B2A47'">
                                ดูรายละเอียด
                            </a>
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" style="margin: 0;">
                                @csrf
                                <button type="submit" style="padding: 8px 10px; background: #ef4444; color: white; border: none; border-radius: 8px; font-size: 0.9rem; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#dc2626'" onmouseout="this.style.background='#ef4444'" title="เพิ่มลงตะกร้า">
                                    🛒
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div style="grid-column: 1 / -1; background: white; border: 1px solid var(--color-silver); border-radius: 12px; padding: 3rem 2rem; text-align: center; color: var(--color-grey);">
                <p style="font-size: 0.95rem; margin: 0;">ขณะนี้ยังไม่มีรายการสินค้าลดราคาพิเศษแยกเฉพาะ</p>
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
                confirmButtonColor: '#1B2A47'
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
                btn.style.background = 'var(--color-grey-light)';
                btn.style.cursor = 'not-allowed';
                btn.innerText = 'เก็บโค้ดแล้ว';
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
                btn.innerText = 'เก็บโค้ดส่วนลด';
                Swal.fire({
                    icon: 'info',
                    title: 'คำชี้แจง',
                    text: data.message,
                    confirmButtonColor: '#1B2A47'
                });
            }
        })
        .catch(err => {
            console.error(err);
            btn.disabled = false;
            btn.innerText = 'เก็บโค้ดส่วนลด';
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: 'ไม่สามารถติดต่อเซิร์ฟเวอร์ได้ กรุณาลองใหม่อีกครั้ง',
                confirmButtonColor: '#1B2A47'
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
                const expiryTime = new Date(expiresString.replace(/-/g, "/")).getTime();
                const distance = expiryTime - now;
                
                if (distance < 0) {
                    timer.innerHTML = "⌛ โค้ดหมดอายุแล้ว";
                    timer.style.color = "#a0aec0";
                    timer.style.background = "#edf2f7";
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

@extends('layouts.store')

@section('content')
<!-- Section 3: Full-width Hero Banner (No Container Box) -->
<div style="width: 100%; margin-bottom: 3.5rem; overflow: hidden; background: #0F172A; position: relative;">
    @if($banners->isEmpty())
        <!-- Full-width Default Hero Banner -->
        <div style="width: 100%; min-height: 400px; padding: 4rem 2rem; background: linear-gradient(135deg, #0F172A 0%, #1E293B 50%, #0F172A 100%); display: flex; align-items: center; justify-content: center; position: relative; color: white;">
            <div style="max-width: 1300px; width: 100%; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 40px; position: relative; z-index: 2;">
                
                <div style="flex: 1; min-width: 300px;">
                    <span style="display: inline-block; background: #FFE600; color: #0F172A; padding: 6px 20px; border-radius: 99px; font-size: 0.88rem; font-weight: 900; margin-bottom: 1.5rem; letter-spacing: 0.5px; box-shadow: 0 0 15px rgba(255, 230, 0, 0.4);">
                        🔥 DDPHONE PREVIEW & PROMOTION
                    </span>
                    <h1 style="font-size: clamp(2.2rem, 5vw, 3.4rem); font-weight: 900; margin: 0 0 1.25rem; line-height: 1.25; color: #FFFFFF; text-shadow: 0 4px 20px rgba(0,0,0,0.5);">
                        {{ $settings['slogan_title'] ?? 'ศูนย์รวมสมาร์ทโฟนมือสองเกรด A+ คุณภาพระดับมืออาชีพ' }}
                    </h1>
                    <p style="font-size: 1.1rem; color: #E2E8F0; line-height: 1.65; margin: 0 0 2rem; font-weight: 500; max-width: 600px;">
                        {!! e($settings['slogan_description'] ?? 'ตรวจเช็คเครื่องแท้ 100% พร้อมการรับประกันและบริการหลังการขายที่ดีที่สุด') !!}
                    </p>
                    <div style="display: flex; gap: 16px; flex-wrap: wrap;">
                        <a href="{{ route('products.index') }}" style="text-decoration: none;">
                            <button style="background: #FFE600; color: #0F172A; border: none; padding: 16px 38px; font-size: 1.05rem; font-weight: 900; border-radius: 99px; cursor: pointer; transition: all 0.3s; box-shadow: 0 8px 25px rgba(255, 230, 0, 0.35); display: flex; align-items: center; gap: 10px;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
                                <i class="fa-solid fa-mobile-screen-button"></i> เลือกชมสินค้าทั้งหมด
                            </button>
                        </a>
                    </div>
                </div>

                <!-- 3D Mascot Floating Graphic Illustration -->
                <div style="flex: 1; min-width: 280px; max-width: 440px; display: flex; justify-content: center; align-items: center; position: relative;">
                    <img src="{{ asset('images/ddphone_3d_mascot.png') }}" alt="DDPHONE 3D Cute Robot Mascot" style="width: 100%; max-width: 360px; height: auto; object-fit: contain; filter: drop-shadow(0 20px 30px rgba(2, 132, 199, 0.3));">
                </div>

            </div>
        </div>
    @else
        <!-- Full-width Dynamic Slideshow Hero -->
        <div x-data="{ 
                activeSlide: 0, 
                slidesCount: {{ $banners->count() }},
                next() { this.activeSlide = (this.activeSlide + 1) % this.slidesCount },
                prev() { this.activeSlide = (this.activeSlide - 1 + this.slidesCount) % this.slidesCount },
                init() { setInterval(() => this.next(), 6000) }
             }"
             style="position: relative; width: 100%; aspect-ratio: 21/8; min-height: 320px; max-height: 520px; background: #0F172A;">
            
            <!-- Slides Container -->
            <div style="width: 100%; height: 100%; position: relative;">
                @foreach($banners as $idx => $banner)
                <div x-show="activeSlide === {{ $idx }}" 
                     x-transition:enter="transition ease-out duration-700"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     style="width: 100%; height: 100%; position: absolute; inset: 0; display: {{ $idx === 0 ? 'block' : 'none' }};">
                    @if($banner->link_url)
                    <a href="{{ $banner->link_url }}" style="display: block; width: 100%; height: 100%;">
                        <img src="{{ str_starts_with($banner->image_path, 'http') ? $banner->image_path : Storage::url($banner->image_path) }}" alt="Promotion Banner" style="width: 100%; height: 100%; object-fit: cover;">
                    </a>
                    @else
                        <img src="{{ str_starts_with($banner->image_path, 'http') ? $banner->image_path : Storage::url($banner->image_path) }}" alt="Promotion Banner" style="width: 100%; height: 100%; object-fit: cover;">
                    @endif
                </div>
                @endforeach
            </div>

            <!-- Full-width Overlay Content -->
            <div class="hero-slide-overlay" style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(15, 23, 42, 0.95)); padding: 2.5rem 3rem; display: flex; justify-content: space-between; align-items: flex-end; z-index: 5;">
                <div class="hero-slide-text" style="max-width: 65%;">
                    <span style="background: #FFE600; color: #0F172A; font-size: 0.78rem; padding: 4px 12px; border-radius: 99px; font-weight: 900; margin-bottom: 0.5rem; display: inline-block;">
                        DDPHONE PROMOTION
                    </span>
                    <h2 style="font-size: 1.6rem; font-weight: 900; color: white; margin: 4px 0 6px;">
                        {{ $settings['slogan_title'] }}
                    </h2>
                    <p style="margin: 0; font-size: 0.9rem; color: #E2E8F0; font-weight: 500;">
                        {{ str_replace("\n", ' ', $settings['slogan_description']) }}
                    </p>
                </div>
                <a href="{{ route('products.index') }}" style="text-decoration: none;" class="hero-slide-btn-wrap">
                    <button style="background: #FFE600; color: #0F172A; border: none; padding: 12px 24px; border-radius: 99px; font-size: 0.95rem; font-weight: 900; cursor: pointer; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 15px rgba(255, 230, 0, 0.3);">
                        <i class="fa-solid fa-cart-shopping"></i> ช้อปเลย ➔
                    </button>
                </a>
            </div>

            <!-- Slider Navigation Arrows -->
            <button @click="prev()" style="position: absolute; top: 50%; left: 20px; transform: translateY(-50%); width: 44px; height: 44px; border-radius: 50%; background: rgba(15, 23, 42, 0.7); border: 1.5px solid rgba(255,255,255,0.3); color: white; display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 10; font-size: 1.2rem;">&lsaquo;</button>
            <button @click="next()" style="position: absolute; top: 50%; right: 20px; transform: translateY(-50%); width: 44px; height: 44px; border-radius: 50%; background: rgba(15, 23, 42, 0.7); border: 1.5px solid rgba(255,255,255,0.3); color: white; display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 10; font-size: 1.2rem;">&rsaquo;</button>
        </div>
    @endif
</div>

<!-- Main Homepage Container -->
<div class="container fade-in" style="max-width: 1440px; width: 96%; margin: 0 auto; padding: 0 0.5rem 3rem;">

    <!-- Minimal Category Badges (Clean Responsive Flex Wrap) -->
    <div style="text-align: center; margin-bottom: 2rem; padding-top: 1rem;">
        <span style="display: inline-block; background: rgba(15, 23, 42, 0.06); color: #0F172A; padding: 4px 18px; border-radius: 99px; font-size: 0.8rem; font-weight: 900; margin-bottom: 0.5rem; letter-spacing: 0.5px;">EXPLORE CATEGORIES</span>
        <h2 style="font-size: 1.85rem; font-weight: 900; color: #0F172A; margin: 0;">
            หมวดหมู่สินค้ามินิมอล
        </h2>
    </div>

    @php 
        $catFaIcons = [
            'fa-mobile-screen-button',
            'fa-tablet-screen-button',
            'fa-laptop',
            'fa-headphones',
            'fa-watch-smart',
            'fa-gamepad',
            'fa-camera',
            'fa-desktop'
        ];
    @endphp
    <div class="category-badges-scroll-wrapper" style="display: flex; flex-wrap: wrap; justify-content: center; gap: 12px 14px; margin-bottom: 4rem; align-items: center; width: 100%; overflow-x: auto; scrollbar-width: none; -webkit-overflow-scrolling: touch; padding: 0.5rem 0;">
        @foreach($categories as $idx => $category)
        <a href="{{ route('products.index', ['category' => $category->id]) }}" style="text-decoration: none; flex-shrink: 0;">
            <div style="background: white; border: 1.5px solid #E2E8F0; border-radius: 99px; padding: 10px 24px; display: flex; align-items: center; gap: 10px; box-shadow: 0 4px 12px rgba(15, 23, 42, 0.04); transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1); cursor: pointer;" onmouseover="this.style.transform='translateY(-3px)'; this.style.borderColor='#0F172A'; this.style.background='#0F172A'; this.querySelector('.cat-txt').style.color='#FFE600'; this.querySelector('.cat-icon').style.color='#FFE600';" onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='#E2E8F0'; this.style.background='white'; this.querySelector('.cat-txt').style.color='#0F172A'; this.querySelector('.cat-icon').style.color='#0F172A';">
                <i class="cat-icon fa-solid {{ $catFaIcons[$idx % count($catFaIcons)] }}" style="font-size: 1.1rem; color: #0F172A; transition: color 0.2s;"></i>
                <span class="cat-txt" style="font-size: 0.9rem; font-weight: 800; color: #0F172A; transition: color 0.2s; white-space: nowrap;">
                    {{ $category->name }}
                </span>
            </div>
        </a>
        @endforeach
    </div>
</div>

<!-- FULL-WIDTH BORDERLESS USER CUSTOM 3D DEVICES SHOWCASE SECTION (DYNAMIC BANNER 2 FROM CMS) -->
<div class="borderless-showcase-section">
    <!-- Soft Gradient Backdrop Circle -->
    <div class="borderless-showcase-backdrop-circle"></div>

    <div style="max-width: 1400px; margin: 0 auto; padding: 0 1.5rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 48px; position: relative; z-index: 2;">
        
        <!-- Left Text & Thai DDPHONE Branding Content -->
        <div style="flex: 1.2; min-width: 340px; max-width: 620px;">
            <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(2, 132, 199, 0.1); color: #0284C7; padding: 6px 16px; border-radius: 99px; font-size: 0.85rem; font-weight: 900; margin-bottom: 1.25rem; text-transform: uppercase; letter-spacing: 0.5px;">
                <i class="fa-solid fa-mobile-screen text-sky-600"></i> {{ $settings['showcase_badge'] ?? 'DDPHONE PREVIEW & PROMOTION' }}
            </div>
            
            <h2 style="font-size: clamp(2rem, 3.6vw, 2.8rem); font-weight: 900; color: #0F172A; line-height: 1.35; margin: 0 0 1.25rem; letter-spacing: -0.5px;">
                {!! nl2br(e($settings['showcase_title'] ?? "สมาร์ทโฟนมือสองเกรด A+\nสวยกริ๊บ ไร้รอย สภาพ 99%")) !!}
            </h2>
            
            <p style="font-size: 1.05rem; color: #475569; line-height: 1.7; margin: 0 0 2.25rem; font-weight: 600;">
                {!! nl2br(e($settings['showcase_description'] ?? 'คัดสรรไอโฟน ไอแพด แมคบุ๊ก และสมาร์ทโฟนแท้ 100% แบตอึด สแกนนิ้ว/กล้องเพอร์เฟกต์ การันตีประกันร้าน 30 วัน พร้อมจัดส่งฟรีทั่วประเทศ')) !!}
            </p>

            <!-- Action Button -->
            <a href="{{ !empty($settings['showcase_button_url']) ? $settings['showcase_button_url'] : route('products.index') }}" style="text-decoration: none; display: inline-block;">
                <div style="display: inline-flex; align-items: center; background: #0284C7; color: #FFFFFF; padding: 8px 10px 8px 30px; border-radius: 99px; font-weight: 900; font-size: 1rem; letter-spacing: 0.5px; box-shadow: 0 10px 30px rgba(2, 132, 199, 0.35); transition: transform 0.25s, box-shadow 0.25s; cursor: pointer;" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 15px 35px rgba(2, 132, 199, 0.5)'" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 10px 30px rgba(2, 132, 199, 0.35)'">
                    <span>{{ !empty($settings['showcase_button_text']) ? $settings['showcase_button_text'] : 'ช้อปมือถือโปรเด็ด' }}</span>
                    <div style="width: 42px; height: 42px; background: #FFE600; color: #0F172A; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-left: 16px; font-size: 0.98rem; font-weight: 900;">
                        ➔
                    </div>
                </div>
            </a>
        </div>

        <!-- Right USER UPLOADED 3D DEVICES ECOSYSTEM SHOWCASE IMAGE (100% TRANSPARENT PNG - ZERO BOX) -->
        <div style="flex: 1.2; min-width: 340px; max-width: 650px; display: flex; justify-content: center; align-items: center; position: relative;">
            @if(!empty($settings['showcase_image']))
                <img src="{{ str_starts_with($settings['showcase_image'], 'http') ? $settings['showcase_image'] : Storage::url($settings['showcase_image']) }}" alt="DDPHONE Showcase Banner" class="user-devices-showcase-img">
            @else
                <img src="{{ asset('images/user_devices_showcase.png') }}" alt="DDPHONE User Choice 3D Devices Ecosystem Showcase" class="user-devices-showcase-img">
            @endif
        </div>

    </div>
</div>

<!-- Main Homepage Container Part 2 -->
<div class="container fade-in" style="max-width: 1440px; width: 96%; margin: 0 auto; padding: 0 0.5rem 3rem;">

    <!-- Popular Products (Enhanced with HOT Glow & Rating Stars) -->
    <div style="text-align: left; margin-bottom: 1.75rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
        <div>
            <span style="display: inline-block; background: #FFE600; color: #0F172A; padding: 4px 14px; border-radius: 99px; font-size: 0.8rem; font-weight: 900; margin-bottom: 0.4rem; box-shadow: 0 2px 8px rgba(255, 230, 0, 0.4);">🔥 HOT ITEMS</span>
            <h2 style="font-size: 1.75rem; font-weight: 900; color: #0F172A; margin: 0;">
                สินค้ายอดนิยมแนะนำ
            </h2>
        </div>
        <a href="{{ route('products.index') }}" style="text-decoration: none; color: #0F172A; font-weight: 800; font-size: 0.95rem; display: flex; align-items: center; gap: 6px;" onmouseover="this.style.color='#2563EB'" onmouseout="this.style.color='#0F172A'">
            ดูทั้งหมด <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

    <div class="product-grid-container" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(230px, 1fr)); gap: 16px; margin-bottom: 4.5rem;">
        @forelse($popularProducts as $product)
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
                        HOT 🔥
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
            <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; color: #94a3b8;">
                <i class="fa-solid fa-box-open text-5xl mb-3"></i>
                <p style="font-weight: 700;">ยังไม่มีสินค้าในขณะนี้</p>
            </div>
        @endforelse
    </div>

    <!-- 4-Core Guarantees Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 4.5rem; margin-top: 1rem;">
        <div style="background: linear-gradient(135deg, #FFFFFF 0%, #F8FAFC 100%); border: 1.5px solid #E2E8F0; border-radius: 24px; padding: 1.75rem 1.5rem; display: flex; align-items: flex-start; gap: 16px; box-shadow: 0 8px 25px rgba(15, 23, 42, 0.04);">
            <div style="width: 52px; height: 52px; background: rgba(2, 132, 199, 0.1); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; color: #0284C7; flex-shrink: 0;">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <div>
                <h4 style="font-size: 1.05rem; font-weight: 900; color: #0F172A; margin: 0 0 4px;">ประกันร้าน 30 วันเต็ม</h4>
                <p style="font-size: 0.85rem; color: #64748B; margin: 0; line-height: 1.5; font-weight: 600;">เปลี่ยนเครื่องใหม่ฟรี ดูแลดั่งครอบครัว พร้อมตรวจเช็กตลอดชีพ</p>
            </div>
        </div>

        <div style="background: linear-gradient(135deg, #FFFFFF 0%, #F8FAFC 100%); border: 1.5px solid #E2E8F0; border-radius: 24px; padding: 1.75rem 1.5rem; display: flex; align-items: flex-start; gap: 16px; box-shadow: 0 8px 25px rgba(15, 23, 42, 0.04);">
            <div style="width: 52px; height: 52px; background: rgba(16, 185, 129, 0.1); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; color: #10B981; flex-shrink: 0;">
                <i class="fa-solid fa-truck-fast"></i>
            </div>
            <div>
                <h4 style="font-size: 1.05rem; font-weight: 900; color: #0F172A; margin: 0 0 4px;">จัดส่งด่วนฟรีทั่วไทย</h4>
                <p style="font-size: 0.85rem; color: #64748B; margin: 0; line-height: 1.5; font-weight: 600;">ส่งพัสดุห่อกันกระแทกอย่างดี ได้รับใน 1-2 วัน มีเลขติดตาม 24 ชม.</p>
            </div>
        </div>

        <div style="background: linear-gradient(135deg, #FFFFFF 0%, #F8FAFC 100%); border: 1.5px solid #E2E8F0; border-radius: 24px; padding: 1.75rem 1.5rem; display: flex; align-items: flex-start; gap: 16px; box-shadow: 0 8px 25px rgba(15, 23, 42, 0.04);">
            <div style="width: 52px; height: 52px; background: rgba(245, 158, 11, 0.1); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; color: #F59E0B; flex-shrink: 0;">
                <i class="fa-solid fa-magnifying-glass-location"></i>
            </div>
            <div>
                <h4 style="font-size: 1.05rem; font-weight: 900; color: #0F172A; margin: 0 0 4px;">คัดสรรแท้ 100% 30 รายการ</h4>
                <p style="font-size: 0.85rem; color: #64748B; margin: 0; line-height: 1.5; font-weight: 600;">ผ่าน QC เข้มงวด ตรวจเช็กสุขภาพแบต กล้อง สแกนนิ้ว จอเดิมแท้</p>
            </div>
        </div>

        <div style="background: linear-gradient(135deg, #FFFFFF 0%, #F8FAFC 100%); border: 1.5px solid #E2E8F0; border-radius: 24px; padding: 1.75rem 1.5rem; display: flex; align-items: flex-start; gap: 16px; box-shadow: 0 8px 25px rgba(15, 23, 42, 0.04);">
            <div style="width: 52px; height: 52px; background: rgba(139, 92, 246, 0.1); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; color: #8B5CF6; flex-shrink: 0;">
                <i class="fa-solid fa-credit-card"></i>
            </div>
            <div>
                <h4 style="font-size: 1.05rem; font-weight: 900; color: #0F172A; margin: 0 0 4px;">ผ่อนสบาย / นำเครื่องมาเทรด</h4>
                <p style="font-size: 0.85rem; color: #64748B; margin: 0; line-height: 1.5; font-weight: 600;">รองรับการผ่อนชำระง่ายๆ หรือนำเครื่องเก่ามาแลกซื้อให้ราคาสูงสุด</p>
            </div>
        </div>
    </div>

    <!-- Centered Activities and News Section -->
    <div style="margin-top: 2rem; margin-bottom: 3.5rem;">
        <div style="text-align: center; margin-bottom: 2.5rem;">
            <span style="display: inline-block; background: #FFE600; color: #0F172A; padding: 4px 16px; border-radius: 99px; font-size: 0.8rem; font-weight: 900; margin-bottom: 0.6rem; letter-spacing: 0.5px;">ACTIVITIES & NEWS</span>
            <h2 style="font-size: 1.75rem; font-weight: 900; color: #0F172A; margin: 0;">
                กิจกรรมและข่าวสาร DDPHONE
            </h2>
            <p style="color: #64748b; font-size: 0.92rem; margin-top: 0.4rem; font-weight: 600;">ติดตามข่าวอัปเดต รีวิวสมาร์ทโฟน และกิจกรรมของร้านดีดีโฟน</p>
        </div>

        <!-- Centered Layout for News Cards if Items are Few -->
        <div style="display: flex; justify-content: center; flex-wrap: wrap; gap: 24px; max-width: 1200px; margin: 0 auto;">
            @if(isset($articles) && $articles->count() > 0)
                @foreach($articles->take(4) as $article)
                @php
                    $articleImgs = $article->images ?? [];
                    $articleCover = collect($articleImgs)->map(function($i) {
                        return str_starts_with($i, 'http') ? $i : Storage::url($i);
                    })->first() ?? 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=600&q=80';
                @endphp
                <div class="card-fun-hover" style="background: white; border-radius: 20px; overflow: hidden; border: 1.5px solid #E2E8F0; box-shadow: 0 4px 15px rgba(15, 23, 42, 0.04); display: flex; flex-direction: column; width: 270px; flex-shrink: 0;">
                    <img src="{{ $articleCover }}" alt="{{ $article->title }}" style="width: 100%; height: 170px; object-fit: cover;" onerror="this.src='https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=600&q=80'">
                    <div style="padding: 1.25rem; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <span style="font-size: 0.75rem; color: #2563EB; font-weight: 900; text-transform: uppercase;">ข่าวสาร</span>
                            <h4 style="font-size: 1rem; font-weight: 800; color: #0F172A; margin: 6px 0 10px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $article->title }}</h4>
                            <p style="color: #64748b; font-size: 0.8rem; line-height: 1.5; margin: 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ Str::limit(strip_tags($article->content), 90) }}</p>
                        </div>
                        <a href="{{ route('blog.show', $article->id) }}" style="display: inline-flex; align-items: center; gap: 6px; color: #0F172A; font-weight: 900; font-size: 0.82rem; margin-top: 1rem; text-decoration: none;" onmouseover="this.style.color='#2563EB'" onmouseout="this.style.color='#0F172A'">
                            อ่านรายละเอียด ➔
                        </a>
                    </div>
                </div>
                @endforeach
            @else
                <!-- Fallback Activity Cards Centered -->
                <div class="card-fun-hover" style="background: white; border-radius: 20px; overflow: hidden; border: 1.5px solid #E2E8F0; box-shadow: 0 4px 15px rgba(15, 23, 42, 0.04); width: 270px; flex-shrink: 0;">
                    <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=600&q=80" alt="บริการสมาร์ทโฟนเพื่อการศึกษา" style="width: 100%; height: 170px; object-fit: cover;">
                    <div style="padding: 1.25rem;">
                        <span style="font-size: 0.75rem; color: #2563EB; font-weight: 900; text-transform: uppercase;">สถาบันการศึกษา</span>
                        <h4 style="font-size: 1rem; font-weight: 800; color: #0F172A; margin: 6px 0 10px; line-height: 1.4;">โครงการไอทีและแท็บเล็ตเพื่อการศึกษา DDPHONE</h4>
                        <p style="color: #64748b; font-size: 0.8rem; line-height: 1.5; margin: 0;">ส่งมอบ iPad และสมาร์ทโฟนเพื่อการศึกษา พร้อมประกันและบริการหลังการขาย</p>
                    </div>
                </div>

                <div class="card-fun-hover" style="background: white; border-radius: 20px; overflow: hidden; border: 1.5px solid #E2E8F0; box-shadow: 0 4px 15px rgba(15, 23, 42, 0.04); width: 270px; flex-shrink: 0;">
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=600&q=80" alt="นำเสนอ Apple Products" style="width: 100%; height: 170px; object-fit: cover;">
                    <div style="padding: 1.25rem;">
                        <span style="font-size: 0.75rem; color: #2563EB; font-weight: 900; text-transform: uppercase;">แอปเปิ้ลมือสองคัดเกรด</span>
                        <h4 style="font-size: 1rem; font-weight: 800; color: #0F172A; margin: 6px 0 10px; line-height: 1.4;">สาธิตการใช้งาน iPhone & iPad มือสองแท้เกรด A+</h4>
                        <p style="color: #64748b; font-size: 0.8rem; line-height: 1.5; margin: 0;">แนะนำการเช็คสุขภาพแบตเตอรี่และตรวจเช็คเครื่องแท้ก่อนส่งถึงมือลูกค้า</p>
                    </div>
                </div>

                <div class="card-fun-hover" style="background: white; border-radius: 20px; overflow: hidden; border: 1.5px solid #E2E8F0; box-shadow: 0 4px 15px rgba(15, 23, 42, 0.04); width: 270px; flex-shrink: 0;">
                    <img src="https://images.unsplash.com/photo-1530595467537-0b5996c41f2d?auto=format&fit=crop&w=600&q=80" alt="กิจกรรม CSR" style="width: 100%; height: 170px; object-fit: cover;">
                    <div style="padding: 1.25rem;">
                        <span style="font-size: 0.75rem; color: #10B981; font-weight: 900; text-transform: uppercase;">กิจกรรมเพื่อสังคม</span>
                        <h4 style="font-size: 1rem; font-weight: 800; color: #0F172A; margin: 6px 0 10px; line-height: 1.4;">กิจกรรมตอบแทนสังคมและสิ่งแวดล้อม DDPHONE</h4>
                        <p style="color: #64748b; font-size: 0.8rem; line-height: 1.5; margin: 0;">ร่วมมือสร้างสิ่งแวดล้อมยั่งยืนและสนับสนุนการรีไซเคิลขยะอิเล็กทรอนิกส์</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

</div>

<script>
    function animateHeartBtn(btn) {
        btn.classList.add('heart-pop-anim');
        setTimeout(() => btn.classList.remove('heart-pop-anim'), 450);
    }

    function animateBasketBtn(btn) {
        btn.classList.add('basket-bounce-anim');
        setTimeout(() => btn.classList.remove('basket-bounce-anim'), 450);
    }
</script>
@endsection

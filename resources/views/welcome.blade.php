@extends('layouts.store')

@section('content')
<div class="container fade-in" style="padding: 2.5rem 1rem;">
    <!-- Hero/Promotion Banner Slider -->
    @if($banners->isEmpty())
        <!-- Default Hero (No Banners) -->
        <div class="hero-banner">
            <div style="position: absolute; top: -50%; left: -20%; width: 60%; height: 200%; background: radial-gradient(circle, rgba(99, 102, 241, 0.08) 0%, transparent 70%); pointer-events: none;"></div>
            <div style="position: absolute; bottom: -50%; right: -20%; width: 60%; height: 200%; background: radial-gradient(circle, rgba(49, 130, 206, 0.06) 0%, transparent 70%); pointer-events: none;"></div>
            <div style="position: relative; z-index: 1;">
                @if($settings['slogan_badge'])
                <span style="display: inline-block; background: rgba(99, 102, 241, 0.2); color: #a5b4fc; padding: 6px 16px; border-radius: 99px; font-size: 0.85rem; font-weight: 600; margin-bottom: 1.5rem; border: 1px solid rgba(99, 102, 241, 0.3);">
                    {{ $settings['slogan_badge'] }}
                </span>
                @endif
                <h1 class="hero-banner-title">
                    {{ $settings['slogan_title'] }}
                </h1>
                <p class="hero-banner-desc">{!! e($settings['slogan_description']) !!}</p>
                
                <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap; margin-top: 10px;">
                    <a href="{{ route('products.index') }}" style="text-decoration: none;">
                        <button class="pulse-glow" style="background: linear-gradient(135deg, #FF5722, #FF8A00); color: white; border: none; padding: 16px 36px; font-size: 1.05rem; font-weight: 700; border-radius: 14px; cursor: pointer; transition: all 0.3s; box-shadow: 0 8px 25px rgba(255, 87, 34, 0.4); display: flex; align-items: center; gap: 10px;">
                            <i class="fa-solid fa-cart-shopping"></i> ซื้อสินค้าไอที
                        </button>
                    </a>
                    <a href="{{ route('business') }}" style="text-decoration: none;">
                        <button style="background: rgba(255,255,255,0.15); color: white; border: 1px solid rgba(255,255,255,0.3); padding: 16px 36px; font-size: 1.05rem; font-weight: 700; border-radius: 14px; cursor: pointer; transition: all 0.3s; backdrop-filter: blur(8px); display: flex; align-items: center; gap: 10px;" onmouseover="this.style.background='rgba(255,255,255,0.25)'" onmouseout="this.style.background='rgba(255,255,255,0.15)'">
                            <i class="fa-solid fa-building"></i> โซลูชันสำหรับองค์กร
                        </button>
                    </a>
                </div>
            </div>
        </div>
    @else
        <!-- Dynamic Slideshow Hero -->
        <div x-data="{ 
                activeSlide: 0, 
                slidesCount: {{ $banners->count() }},
                next() { this.activeSlide = (this.activeSlide + 1) % this.slidesCount },
                prev() { this.activeSlide = (this.activeSlide - 1 + this.slidesCount) % this.slidesCount },
                init() { setInterval(() => this.next(), 6000) }
             }"
             style="position: relative; border-radius: 24px; overflow: hidden; margin-bottom: 4rem; box-shadow: 0 25px 50px rgba(15, 23, 42, 0.15); aspect-ratio: 3/1; min-height: 280px; background: #0F172A;">
            
            <!-- Slides Container -->
            <div style="width: 100%; height: 100%; position: relative;">
                @foreach($banners as $idx => $banner)
                <div x-show="activeSlide === {{ $idx }}" 
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     style="width: 100%; height: 100%; position: absolute; inset: 0; display: {{ $idx === 0 ? 'block' : 'none' }};">
                    @if($banner->link_url)
                    <a href="{{ $banner->link_url }}" style="display: block; width: 100%; height: 100%;">
                    @endif
                        <img src="{{ str_starts_with($banner->image_path, 'http') ? $banner->image_path : Storage::url($banner->image_path) }}" alt="Promotion Banner" style="width: 100%; height: 100%; object-fit: cover;">
                    @if($banner->link_url)
                    </a>
                    @endif
                </div>
                @endforeach
            </div>

            <!-- Overlay Slogans with Glassmorphism -->
            <div class="slider-overlay">
                <div style="text-align: left; max-width: 70%;">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 0.25rem;">
                        <h2 style="font-size: 1.4rem; font-weight: 800; margin: 0; background: linear-gradient(135deg, #fff 0%, #c7d2fe 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                            {{ $settings['slogan_title'] }}
                        </h2>
                        @if($settings['slogan_badge'])
                        <span style="background: rgba(99, 102, 241, 0.3); color: #c7d2fe; font-size: 0.75rem; padding: 2px 8px; border-radius: 8px; font-weight: 600; border: 1px solid rgba(99, 102, 241, 0.2);">
                            {{ $settings['slogan_badge'] }}
                        </span>
                        @endif
                    </div>
                    <p style="margin: 0; font-size: 0.85rem; color: rgba(203, 213, 225, 0.9); display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden;">
                        {{ str_replace("
", ' ', $settings['slogan_description']) }}
                    </p>
                </div>
                
                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                    <a href="{{ route('products.index') }}" style="text-decoration: none;">
                        <button style="background: linear-gradient(135deg, #FF5722, #FF8A00); border: none; color: white; padding: 12px 20px; border-radius: 12px; font-size: 0.95rem; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 15px rgba(255, 87, 34, 0.4);">
                            <i class="fa-solid fa-cart-shopping"></i> เลือกซื้อสินค้า
                        </button>
                    </a>
                    <a href="{{ route('business') }}" style="text-decoration: none;">
                        <button style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3); color: white; padding: 12px 20px; border-radius: 12px; font-size: 0.95rem; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 8px; backdrop-filter: blur(4px);">
                            <i class="fa-solid fa-building"></i> ลูกค้าองค์กร
                        </button>
                    </a>
                </div>
            </div>

            <!-- Slider Controls -->
            <button @click="prev()" style="position: absolute; top: 50%; left: 15px; transform: translateY(-50%); width: 36px; height: 36px; border-radius: 50%; background: rgba(0,0,0,0.4); border: 1px solid rgba(255,255,255,0.1); color: white; display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 10;">&lsaquo;</button>
            <button @click="next()" style="position: absolute; top: 50%; right: 15px; transform: translateY(-50%); width: 36px; height: 36px; border-radius: 50%; background: rgba(0,0,0,0.4); border: 1px solid rgba(255,255,255,0.1); color: white; display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 10;">&rsaquo;</button>
        </div>
    @endif

    <!-- Popular Products -->
    <div style="text-align: left; margin-bottom: 1.75rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-top: 1rem;">
        <div>
            <span style="display: inline-block; background: rgba(239, 68, 68, 0.08); color: #ef4444; padding: 4px 14px; border-radius: 99px; font-size: 0.8rem; font-weight: 600; margin-bottom: 0.5rem;">🔥 HOT</span>
            <h2 style="font-size: 1.75rem; font-weight: 800; color: var(--color-navy-dark); letter-spacing: -0.02em; margin: 0;">
                สินค้ายอดนิยม
            </h2>
        </div>
        <a href="{{ route('products.index') }}" style="text-decoration: none; color: var(--color-accent); font-weight: 600; font-size: 0.95rem; display: flex; align-items: center; gap: 6px; transition: color 0.2s;" onmouseover="this.style.color='var(--color-navy)'" onmouseout="this.style.color='var(--color-accent)'">
            ดูทั้งหมด <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 24px; margin-bottom: 4rem;">
        @forelse($popularProducts as $product)
        <div class="hover-scale" style="background: white; border: 1px solid rgba(226, 232, 240, 0.8); border-radius: 20px; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 4px 15px rgba(27, 42, 71, 0.03);">
            <a href="{{ route('products.show', $product->id) }}" style="text-decoration: none; color: inherit; display: block; padding: 1.5rem; text-align: center; position: relative;">
                <!-- Stock Status Pill -->
                @if($product->stock <= 0)
                    <span style="position: absolute; top: 12px; right: 12px; font-size: 10px; font-weight: bold; background: #ef4444; color: white; padding: 4px 8px; border-radius: 99px;">สินค้าหมด</span>
                @elseif($product->stock <= 5)
                    <span style="position: absolute; top: 12px; right: 12px; font-size: 10px; font-weight: bold; background: #f59e0b; color: white; padding: 4px 8px; border-radius: 99px;">ใกล้หมดเหลือ {{ $product->stock }} ชิ้น</span>
                @endif

                @if($product->images->where('is_primary', true)->first())
                    @php
                        $imgPath = $product->images->where('is_primary', true)->first()->image_path;
                    @endphp
                    @if(str_starts_with($imgPath, 'http'))
                        <img src="{{ $imgPath }}" alt="{{ $product->name }}" style="max-width: 100%; height: 190px; object-fit: contain; border-radius: 12px;">
                    @else
                        <img src="{{ Storage::url($imgPath) }}" alt="{{ $product->name }}" style="max-width: 100%; height: 190px; object-fit: contain; border-radius: 12px;">
                    @endif
                @else
                    <div style="width: 100%; height: 190px; background: #f8fafc; display: flex; align-items: center; justify-content: center; color: #94a3b8; border-radius: 12px;">
                        <i class="fa-solid fa-image text-3xl"></i>
                    </div>
                @endif
            </a>
            
            <div style="padding: 1.5rem; border-top: 1px solid rgba(226, 232, 240, 0.6); background: #fafafb;">
                <a href="{{ route('products.show', $product->id) }}" style="text-decoration: none; color: inherit;">
                    <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.75rem; color: var(--color-navy-dark); min-height: 2.8rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.4; transition: color 0.2s;" onmouseover="this.style.color='var(--color-accent)'" onmouseout="this.style.color='var(--color-navy-dark)'">
                        {{ $product->name }}
                    </h3>
                </a>
                
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; flex-direction: column;">
                        @if($product->discount_price)
                            <span style="font-size: 0.9rem; text-decoration: line-through; color: #94a3b8; margin-bottom: -0.25rem;">฿{{ number_format($product->price, 2) }}</span>
                            <span style="font-size: 1.25rem; font-weight: 800; color: var(--color-accent);">฿{{ number_format($product->discount_price, 2) }}</span>
                        @else
                            <span style="font-size: 1.25rem; font-weight: 800; color: var(--color-navy-light);">฿{{ number_format($product->price, 2) }}</span>
                        @endif
                    </div>
                    
                    <div style="display: flex; gap: 8px; align-items: center;">
                        <!-- Wishlist Toggle (AJAX) -->
                        @php 
                            $isFavorite = auth()->check() && \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->exists();
                        @endphp
                        <button type="button" class="wishlist-toggle-btn" data-product-id="{{ $product->id }}" title="เพิ่มในสินค้าที่ชอบ" style="background: white; border: 1px solid rgba(226, 232, 240, 0.8); color: {{ $isFavorite ? '#ef4444' : '#94a3b8' }}; width: 42px; height: 42px; border-radius: 50%; cursor: pointer; font-size: 1.1rem; display: flex; align-items: center; justify-content: center; transition: all 0.2s; box-shadow: 0 4px 6px rgba(0,0,0,0.03);" onmouseover="this.style.transform='scale(1.1)'; this.style.borderColor='#ef4444';" onmouseout="this.style.transform='scale(1)'; this.style.borderColor='rgba(226, 232, 240, 0.8)';">
                            <i class="fa-{{ $isFavorite ? 'solid' : 'regular' }} fa-heart"></i>
                        </button>

                        <!-- Add to Cart (Ajax-enabled) -->
                        <form action="{{ route('cart.add', $product) }}" method="POST" class="ajax-add-to-cart-form" style="margin: 0;">
                            @csrf
                            <button type="submit" title="เพิ่มลงตะกร้า" style="background: var(--color-navy); color: white; border: none; width: 42px; height: 42px; border-radius: 50%; cursor: pointer; font-size: 1rem; display: flex; align-items: center; justify-content: center; transition: all 0.2s; box-shadow: 0 4px 10px rgba(27, 42, 71, 0.15);" onmouseover="this.style.transform='scale(1.1)'; this.style.background='var(--color-accent)';" onmouseout="this.style.transform='scale(1)'; this.style.background='var(--color-navy)';">
                                <i class="fa-solid fa-basket-shopping"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; color: #94a3b8;">
                <i class="fa-solid fa-box-open text-5xl mb-3"></i>
                <p>ยังไม่มีสินค้าในขณะนี้</p>
            </div>
        @endforelse
    </div>

          <!-- Categories Grid -->
    <div style="text-align: center; margin-bottom: 1.75rem;">
        <span style="display: inline-block; background: rgba(99, 102, 241, 0.08); color: #6366f1; padding: 4px 14px; border-radius: 99px; font-size: 0.8rem; font-weight: 600; margin-bottom: 0.75rem;">CATEGORIES</span>
        <h2 style="font-size: 1.75rem; font-weight: 800; color: var(--color-navy-dark); letter-spacing: -0.02em; margin: 0;">
            หมวดหมู่สินค้ายอดนิยม
        </h2>
    </div>
    @php 
        $catFaIcons = [
            'fa-mobile-screen-button',
            'fa-laptop',
            'fa-stopwatch',
            'fa-headphones',
            'fa-camera',
            'fa-gamepad',
            'fa-tablet-screen-button',
            'fa-desktop'
        ]; 
        $catGradients = [
            'linear-gradient(135deg, #FF5722, #FF8A00)',
            'linear-gradient(135deg, #FF007F, #EC4899)',
            'linear-gradient(135deg, #06B6D4, #3B82F6)',
            'linear-gradient(135deg, #8B5CF6, #6366F1)',
            'linear-gradient(135deg, #10B981, #059669)',
            'linear-gradient(135deg, #F59E0B, #D97706)',
            'linear-gradient(135deg, #EC4899, #8B5CF6)',
            'linear-gradient(135deg, #3B82F6, #1D4ED8)'
        ];
        $catShadows = [
            'rgba(255, 87, 34, 0.25)',
            'rgba(255, 0, 127, 0.25)',
            'rgba(6, 182, 212, 0.25)',
            'rgba(139, 92, 246, 0.25)',
            'rgba(16, 185, 129, 0.25)',
            'rgba(245, 158, 11, 0.25)',
            'rgba(236, 72, 153, 0.25)',
            'rgba(59, 130, 246, 0.25)'
        ];
    @endphp
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 16px; margin-bottom: 3.5rem;">
        @foreach($categories as $idx => $category)
        <a href="{{ route('products.index', ['category' => $category->id]) }}" style="text-decoration: none;">
            <div class="hover-scale" style="background: white; border: 1px solid rgba(226, 232, 240, 0.8); border-radius: 18px; padding: 1.5rem 1rem; text-align: center; cursor: pointer; box-shadow: 0 4px 12px rgba(27, 42, 71, 0.03); height: 140px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                <div style="width: 50px; height: 50px; background: {{ $catGradients[$idx % count($catGradients)] }}; border-radius: 14px; display: flex; align-items: center; justify-content: center; margin-bottom: 0.85rem; color: white; font-size: 1.35rem; box-shadow: 0 6px 16px {{ $catShadows[$idx % count($catShadows)] }};">
                    <i class="fa-solid {{ $catFaIcons[$idx % count($catFaIcons)] }}"></i>
                </div>
                <h3 style="font-size: 0.95rem; font-weight: 700; color: var(--color-navy); margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%;">{{ $category->name }}</h3>
            </div>
        </a>
        @endforeach
    </div>

    






    <!-- Service Center CTA -->
    <div style="background: linear-gradient(135deg, #10B981 0%, #059669 100%); border-radius: 24px; padding: 3rem 2.5rem; margin-top: 2rem; margin-bottom: 5rem; color: white; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 30px; box-shadow: 0 15px 35px rgba(16, 185, 129, 0.25); position: relative; overflow: hidden;">
        <div style="position: absolute; right: -10%; top: -50%; font-size: 20rem; opacity: 0.05; pointer-events: none;">
            <i class="fa-solid fa-screwdriver-wrench"></i>
        </div>
        <div style="flex: 1; min-width: 300px; position: relative; z-index: 1;">
            <span style="display: inline-block; background: rgba(255,255,255,0.2); padding: 4px 12px; border-radius: 8px; font-size: 0.85rem; font-weight: 700; margin-bottom: 1rem; letter-spacing: 0.5px;">AFTER-SALES CARE</span>
            <h2 style="font-size: 2rem; font-weight: 800; margin: 0 0 1rem; line-height: 1.3;">
                อุ่นใจทุกการใช้งาน<br>ด้วยศูนย์บริการมาตรฐาน
            </h2>
            <p style="font-size: 1.05rem; opacity: 0.9; margin: 0 0 1.5rem; line-height: 1.6; max-width: 500px;">
                เพราะเราไม่ได้แค่ขาย แต่เราดูแลคุณตลอดอายุการใช้งาน ให้บริการซ่อม เคลม และแก้ไขปัญหาไอทีโดยทีมช่างผู้เชี่ยวชาญ พร้อมระบบติดตามงานซ่อมออนไลน์
            </p>
            <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                <a href="{{ route('service_center') }}" style="text-decoration: none;">
                    <button style="background: white; color: #059669; border: none; padding: 12px 24px; font-size: 1rem; font-weight: 700; border-radius: 12px; cursor: pointer; transition: transform 0.2s; display: flex; align-items: center; gap: 8px;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                        <i class="fa-solid fa-wrench"></i> แจ้งซ่อม/เคลมสินค้า
                    </button>
                </a>
                <a href="{{ route('tracking') }}" style="text-decoration: none;">
                    <button style="background: rgba(255,255,255,0.15); color: white; border: 1px solid rgba(255,255,255,0.4); padding: 12px 24px; font-size: 1rem; font-weight: 700; border-radius: 12px; cursor: pointer; transition: background 0.2s; display: flex; align-items: center; gap: 8px;" onmouseover="this.style.background='rgba(255,255,255,0.25)'" onmouseout="this.style.background='rgba(255,255,255,0.15)'">
                        <i class="fa-solid fa-magnifying-glass"></i> ติดตามสถานะ
                    </button>
                </a>
            </div>
        </div>
    </div>




    <!-- Services Section -->
    <div style="background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%); color: white; border-radius: 24px; padding: 3.5rem 2rem; margin-top: 2rem; margin-bottom: 3rem; border: 1px solid rgba(226, 232, 240, 0.8); box-shadow: 0 10px 30px rgba(0,0,0,0.02);">
        <div style="text-align: center; margin-bottom: 2.5rem;">
            <span style="display: inline-block; background: rgba(99, 102, 241, 0.08); color: #6366f1; padding: 4px 14px; border-radius: 99px; font-size: 0.8rem; font-weight: 600; margin-bottom: 0.75rem;">OUR SERVICES</span>
            <h2 style="font-size: 1.75rem; font-weight: 800; color: white; letter-spacing: -0.02em; margin: 0;">
                บริการครบวงจรจาก ดีดี.ไอที.คอม
            </h2>
            <p style="color: #cbd5e1; font-size: 0.95rem; margin-top: 0.5rem;">ดูแลช่วยเหลือลูกค้าและองค์กรทุกท่านด้วยโซลูชันระดับมืออาชีพ</p>
        </div>

        <div class="shopee-mobile-row" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px;">
            <!-- Service 1 -->
            <div style="background: rgba(255,255,255,0.05); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1); padding: 2rem; border-radius: 16px; border: 1px solid rgba(226, 232, 240, 0.6); box-shadow: 0 4px 15px rgba(0,0,0,0.01); display: flex; flex-direction: column; align-items: center; text-align: center;">
                <div style="width: 60px; height: 60px; background: rgba(99, 102, 241, 0.08); color: #6366f1; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.6rem; margin-bottom: 1.25rem;">
                    🖥️
                </div>
                <h3 style="font-size: 1.1rem; font-weight: 700; color: white; margin: 0 0 0.5rem;">ระบบ Apple (ABM) & MDM</h3>
                <p style="color: #cbd5e1; font-size: 0.82rem; line-height: 1.6; margin: 0;">บริการจัดการอุปกรณ์ Apple แบบรวมศูนย์ ตั้งค่าเครื่องอัตโนมัติ (Zero-Touch) และควบคุมความปลอดภัยขององค์กรอย่างปลอดภัย</p>
            </div>

            <!-- Service 2 -->
            <div style="background: rgba(255,255,255,0.05); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1); padding: 2rem; border-radius: 16px; border: 1px solid rgba(226, 232, 240, 0.6); box-shadow: 0 4px 15px rgba(0,0,0,0.01); display: flex; flex-direction: column; align-items: center; text-align: center;">
                <div style="width: 60px; height: 60px; background: rgba(59, 130, 246, 0.08); color: #3b82f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.6rem; margin-bottom: 1.25rem;">
                    🛠️
                </div>
                <h3 style="font-size: 1.1rem; font-weight: 700; color: white; margin: 0 0 0.5rem;">Enterprise IT Support</h3>
                <p style="color: #cbd5e1; font-size: 0.82rem; line-height: 1.6; margin: 0;">ให้คำปรึกษาและดูแลรักษาระบบ IT ครบวงจรโดยผู้เชี่ยวชาญ ทั้งเครื่องคอมพิวเตอร์ เครือข่าย และเซิร์ฟเวอร์แบบไม่มีสะดุด</p>
            </div>

            <!-- Service 3 -->
            <div style="background: rgba(255,255,255,0.05); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1); padding: 2rem; border-radius: 16px; border: 1px solid rgba(226, 232, 240, 0.6); box-shadow: 0 4px 15px rgba(0,0,0,0.01); display: flex; flex-direction: column; align-items: center; text-align: center;">
                <div style="width: 60px; height: 60px; background: rgba(16, 185, 129, 0.08); color: #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.6rem; margin-bottom: 1.25rem;">
                    🔄
                </div>
                <h3 style="font-size: 1.1rem; font-weight: 700; color: white; margin: 0 0 0.5rem;">บริการรับ Trade-In สินค้าเก่า</h3>
                <p style="color: #cbd5e1; font-size: 0.82rem; line-height: 1.6; margin: 0;">ประเมินราคาและรับเทิร์นอุปกรณ์ไอที โทรศัพท์มือถือเก่าอย่างคุ้มค่า เพื่อรับส่วนลดการซื้อเครื่องใหม่ทันที</p>
            </div>

            <!-- Service 4 -->
            <div style="background: rgba(255,255,255,0.05); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1); padding: 2rem; border-radius: 16px; border: 1px solid rgba(226, 232, 240, 0.6); box-shadow: 0 4px 15px rgba(0,0,0,0.01); display: flex; flex-direction: column; align-items: center; text-align: center;">
                <div style="width: 60px; height: 60px; background: rgba(139, 92, 246, 0.08); color: #8b5cf6; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.6rem; margin-bottom: 1.25rem;">
                    💼
                </div>
                <h3 style="font-size: 1.1rem; font-weight: 700; color: white; margin: 0 0 0.5rem;">เช่าอุปกรณ์ไอที (DaaS)</h3>
                <p style="color: #cbd5e1; font-size: 0.82rem; line-height: 1.6; margin: 0;">บริการเช่าใช้อุปกรณ์ IT รายเดือน เปลี่ยนเงินลงทุนก้อนใหญ่เป็นค่าใช้จ่ายรายเดือนพร้อมการดูแลตลอดสัญญา</p>
            </div>
        </div>
    </div>
        <div style="text-align: center; margin-top: 3.5rem;">
            <a href="{{ route('quotation.generate') }}" style="text-decoration: none;">
                <button style="background: white; color: var(--color-navy-dark); border: none; padding: 16px 40px; font-size: 1.1rem; font-weight: 700; border-radius: 99px; cursor: pointer; transition: all 0.3s; box-shadow: 0 10px 25px rgba(255,255,255,0.2); display: inline-flex; align-items: center; gap: 10px;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 15px 35px rgba(255,255,255,0.3)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 25px rgba(255,255,255,0.2)';">
                    <i class="fa-solid fa-file-invoice"></i> ขอใบเสนอราคาสำหรับโครงการ
                </button>
            </a>
            <p style="color: #94a3b8; font-size: 0.9rem; margin-top: 1rem;">สำหรับหน่วยงานราชการ สถานศึกษา และบริษัทเอกชน</p>
        </div>

    </div>




    <!-- What Makes Us Different -->
    <div style="margin-top: 5rem; margin-bottom: 5rem;">
        <div style="text-align: center; margin-bottom: 3rem;">
            <span style="display: inline-block; background: rgba(49, 130, 206, 0.08); color: #3182ce; padding: 4px 14px; border-radius: 99px; font-size: 0.8rem; font-weight: 600; margin-bottom: 0.75rem; text-transform: uppercase;">Why Us</span>
            <h2 style="font-size: 1.75rem; font-weight: 800; color: var(--color-navy-dark); letter-spacing: -0.02em; margin: 0;">
                สิ่งที่ทำให้เราแตกต่าง
            </h2>
            <p style="color: #64748b; font-size: 0.95rem; margin-top: 0.5rem;">ยกระดับคุณภาพและมาตรฐานงานบริการเพื่อตอบสนองต่อธุรกิจคุณสูงสุด</p>
        </div>

        <div class="shopee-mobile-row" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 24px;">
            <!-- Difference Card 1 -->
            <div class="hover-scale" style="background: white; padding: 2rem; border-radius: 20px; border: 1px solid rgba(226, 232, 240, 0.8); box-shadow: 0 4px 20px rgba(27, 42, 71, 0.02); display: flex; flex-direction: column; gap: 15px;">
                <div style="width: 50px; height: 50px; background: rgba(99, 102, 241, 0.1); color: #6366f1; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                    🛡️
                </div>
                <h3 style="font-size: 1.1rem; font-weight: 700; color: var(--color-navy-dark); margin: 0;">มาตรฐานสากลและความปลอดภัยสูงสุด</h3>
                <p style="color: #64748b; font-size: 0.85rem; line-height: 1.6; margin: 0;">ส่งมอบและออกแบบโซลูชัน IT ที่ได้มาตรฐานสากล มุ่งเน้นการปกป้องข้อมูลสำคัญของธุรกิจคุณให้ปลอดภัยสูงสุดในทุกระดับการทำงาน</p>
            </div>

            <!-- Difference Card 2 -->
            <div class="hover-scale" style="background: white; padding: 2rem; border-radius: 20px; border: 1px solid rgba(226, 232, 240, 0.8); box-shadow: 0 4px 20px rgba(27, 42, 71, 0.02); display: flex; flex-direction: column; gap: 15px;">
                <div style="width: 50px; height: 50px; background: rgba(59, 130, 246, 0.1); color: #3b82f6; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                    🚀
                </div>
                <h3 style="font-size: 1.1rem; font-weight: 700; color: var(--color-navy-dark); margin: 0;">การจัดการอุปกรณ์แบบรวมศูนย์</h3>
                <p style="color: #64748b; font-size: 0.85rem; line-height: 1.6; margin: 0;">บริการตั้งค่าและจัดการอุปกรณ์องค์กรแบบรวมศูนย์ (Zero-Touch Deployment) อุปกรณ์พร้อมใช้งานทันที ลดภาระงานและเพิ่มประสิทธิภาพให้ทีม IT ของคุณ</p>
            </div>

            <!-- Difference Card 3 -->
            <div class="hover-scale" style="background: white; padding: 2rem; border-radius: 20px; border: 1px solid rgba(226, 232, 240, 0.8); box-shadow: 0 4px 20px rgba(27, 42, 71, 0.02); display: flex; flex-direction: column; gap: 15px;">
                <div style="width: 50px; height: 50px; background: rgba(16, 185, 129, 0.1); color: #10b981; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                    📈
                </div>
                <h3 style="font-size: 1.1rem; font-weight: 700; color: var(--color-navy-dark); margin: 0;">ความคุ้มค่าของการลงทุน (ROI)</h3>
                <p style="color: #64748b; font-size: 0.85rem; line-height: 1.6; margin: 0;">นำเสนออุปกรณ์และโซลูชันที่ตอบโจทย์การลงทุนของธุรกิจ (ROI) พร้อมบริการดูแลหลังการขายระดับองค์กร (Enterprise Support) ที่รวดเร็วและไว้ใจได้</p>
            </div>

            <!-- Difference Card 4 -->
            <div class="hover-scale" style="background: white; padding: 2rem; border-radius: 20px; border: 1px solid rgba(226, 232, 240, 0.8); box-shadow: 0 4px 20px rgba(27, 42, 71, 0.02); display: flex; flex-direction: column; gap: 15px;">
                <div style="width: 50px; height: 50px; background: rgba(139, 92, 246, 0.1); color: #8b5cf6; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                    🤝
                </div>
                <h3 style="font-size: 1.1rem; font-weight: 700; color: var(--color-navy-dark); margin: 0;">ความน่าเชื่อถือและการบำรุงรักษา</h3>
                <p style="color: #64748b; font-size: 0.85rem; line-height: 1.6; margin: 0;">ดูแลบำรุงรักษาระบบและอุปกรณ์อย่างมืออาชีพ (Maintenance Service) เป็นพาร์ทเนอร์ด้านเทคโนโลยีที่หน่วยงานและองค์กรชั้นนำให้ความไว้วางใจ</p>
            </div>
        </div>
    </div>

    



    <!-- Activities and News Section (Synced with Articles) -->
    <div style="margin-top: 5rem; margin-bottom: 5rem;">
        <div style="text-align: center; margin-bottom: 3rem;">
            <span style="display: inline-block; background: #FFE600; color: #0F172A; padding: 4px 16px; border-radius: 99px; font-size: 0.8rem; font-weight: 900; margin-bottom: 0.75rem; letter-spacing: 0.5px;">ACTIVITIES & NEWS</span>
            <h2 style="font-size: 1.75rem; font-weight: 900; color: #0F172A; letter-spacing: -0.02em; margin: 0;">
                กิจกรรมและข่าวสาร DDPHONE
            </h2>
            <p style="color: #64748b; font-size: 0.95rem; margin-top: 0.5rem;">ติดตามข่าวอัปเดต รีวิวสมาร์ทโฟน และกิจกรรมของร้านดีดีโฟน</p>
        </div>

        <div class="shopee-mobile-row" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px;">
            @if(isset($articles) && $articles->count() > 0)
                @foreach($articles->take(4) as $article)
                <div class="hover-scale" style="background: white; border-radius: 20px; overflow: hidden; border: 1.5px solid #E2E8F0; box-shadow: 0 4px 15px rgba(15, 23, 42, 0.04); display: flex; flex-direction: column;">
                    <img src="{{ $article->cover_image ? (str_starts_with($article->cover_image, 'http') ? $article->cover_image : Storage::url($article->cover_image)) : 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=600&q=80' }}" alt="{{ $article->title }}" style="width: 100%; height: 180px; object-fit: cover;">
                    <div style="padding: 1.25rem; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <span style="font-size: 0.75rem; color: #3B82F6; font-weight: 800; text-transform: uppercase;">{{ $article->category ?? 'ข่าวสาร' }}</span>
                            <h4 style="font-size: 1rem; font-weight: 800; color: #0F172A; margin: 6px 0 10px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $article->title }}</h4>
                            <p style="color: #64748b; font-size: 0.8rem; line-height: 1.5; margin: 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ Str::limit(strip_tags($article->content), 100) }}</p>
                        </div>
                        <a href="{{ route('blog.show', $article->id ?? 1) }}" style="display: inline-flex; align-items: center; gap: 6px; color: #0F172A; font-weight: 800; font-size: 0.82rem; margin-top: 1rem; text-decoration: none;" onmouseover="this.style.color='#FF5722'" onmouseout="this.style.color='#0F172A'">
                            อ่านรายละเอียด ➔
                        </a>
                    </div>
                </div>
                @endforeach
            @else
                <!-- Activity 1 -->
                <div class="hover-scale" style="background: white; border-radius: 20px; overflow: hidden; border: 1.5px solid #E2E8F0; box-shadow: 0 4px 15px rgba(15, 23, 42, 0.04);">
                    <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=600&q=80" alt="บริการสมาร์ทโฟนเพื่อการศึกษา" style="width: 100%; height: 180px; object-fit: cover;">
                    <div style="padding: 1.25rem;">
                        <span style="font-size: 0.75rem; color: #3B82F6; font-weight: 800; text-transform: uppercase;">สถาบันการศึกษา</span>
                        <h4 style="font-size: 1rem; font-weight: 800; color: #0F172A; margin: 6px 0 10px; line-height: 1.4;">โครงการไอทีและแท็บเล็ตเพื่อการศึกษา DDPHONE</h4>
                        <p style="color: #64748b; font-size: 0.8rem; line-height: 1.5; margin: 0;">ส่งมอบ iPad และสมาร์ทโฟนเพื่อการศึกษา พร้อมประกันและบริการหลังการขาย</p>
                    </div>
                </div>

                <!-- Activity 2 -->
                <div class="hover-scale" style="background: white; border-radius: 20px; overflow: hidden; border: 1.5px solid #E2E8F0; box-shadow: 0 4px 15px rgba(15, 23, 42, 0.04);">
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=600&q=80" alt="นำเสนอ Apple Products" style="width: 100%; height: 180px; object-fit: cover;">
                    <div style="padding: 1.25rem;">
                        <span style="font-size: 0.75rem; color: #3B82F6; font-weight: 800; text-transform: uppercase;">แอปเปิ้ลมือสองคัดเกรด</span>
                        <h4 style="font-size: 1rem; font-weight: 800; color: #0F172A; margin: 6px 0 10px; line-height: 1.4;">สาธิตการใช้งาน iPhone & iPad มือสองแท้เกรด A+</h4>
                        <p style="color: #64748b; font-size: 0.8rem; line-height: 1.5; margin: 0;">แนะนำการเช็คสุขภาพแบตเตอรี่และตรวจเช็คเครื่องแท้ก่อนส่งถึงมือลูกค้า</p>
                    </div>
                </div>

                <!-- Activity 3 -->
                <div class="hover-scale" style="background: white; border-radius: 20px; overflow: hidden; border: 1.5px solid #E2E8F0; box-shadow: 0 4px 15px rgba(15, 23, 42, 0.04);">
                    <img src="https://images.unsplash.com/photo-1530595467537-0b5996c41f2d?auto=format&fit=crop&w=600&q=80" alt="กิจกรรม CSR" style="width: 100%; height: 180px; object-fit: cover;">
                    <div style="padding: 1.25rem;">
                        <span style="font-size: 0.75rem; color: #10B981; font-weight: 800; text-transform: uppercase;">กิจกรรมเพื่อสังคม</span>
                        <h4 style="font-size: 1rem; font-weight: 800; color: #0F172A; margin: 6px 0 10px; line-height: 1.4;">กิจกรรมตอบแทนสังคมและสิ่งแวดล้อม DDPHONE</h4>
                        <p style="color: #64748b; font-size: 0.8rem; line-height: 1.5; margin: 0;">ร่วมมือสร้างสิ่งแวดล้อมยั่งยืนและสนับสนุนการรีไซเคิลขยะอิเล็กทรอนิกส์</p>
                    </div>
                </div>

                <!-- Activity 4 -->
                <div class="hover-scale" style="background: white; border-radius: 20px; overflow: hidden; border: 1.5px solid #E2E8F0; box-shadow: 0 4px 15px rgba(15, 23, 42, 0.04);">
                    <img src="https://images.unsplash.com/photo-1511512578047-dfb367046420?auto=format&fit=crop&w=600&q=80" alt="รางวัลคุณภาพ" style="width: 100%; height: 180px; object-fit: cover;">
                    <div style="padding: 1.25rem;">
                        <span style="font-size: 0.75rem; color: #F59E0B; font-weight: 800; text-transform: uppercase;">รางวัลการันตี</span>
                        <h4 style="font-size: 1rem; font-weight: 800; color: #0F172A; margin: 6px 0 10px; line-height: 1.4;">รางวัลร้านค้ารับประกันคุณภาพยอดเยี่ยม</h4>
                        <p style="color: #64748b; font-size: 0.8rem; line-height: 1.5; margin: 0;">การันตีความไว้วางใจด้วยบริการหลังการขายและการดูแลลูกค้าตลอด 30 วัน</p>
                    </div>
            @endif
        </div>
    </div>

</div>
@endsection

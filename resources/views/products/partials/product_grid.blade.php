<div class="product-grid-container" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(230px, 1fr)); gap: 16px; margin-bottom: 3.5rem;">
    @forelse($products as $product)
    <div class="card-fun-hover shopee-card-style" style="background: white; border: 1px solid #E2E8F0; border-radius: 14px; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04); position: relative; transition: all 0.2s ease;">
        
        <!-- Image Box (Shopee 1:1 Square Ratio with Overlay Badges) -->
        <a href="{{ route('products.show', $product->id) }}" style="text-decoration: none; color: inherit; display: block; position: relative; width: 100%; aspect-ratio: 1/1; background: #F8FAFC; overflow: hidden;">
            
            <!-- Top Left Shopee Badge (Mall / Recommended / Discount) -->
            @if($product->discount_price)
                @php 
                    $percent = round((($product->price - $product->discount_price) / $product->price) * 100);
                @endphp
                <span style="position: absolute; top: 6px; left: 6px; z-index: 10; font-size: 10px; font-weight: 900; background: #FF5722; color: white; padding: 2px 7px; border-radius: 4px; box-shadow: 0 2px 6px rgba(255,87,34,0.3);">
                    -{{ $percent }}%
                </span>
            @else
                <span style="position: absolute; top: 6px; left: 6px; z-index: 10; font-size: 10px; font-weight: 900; background: #0284C7; color: white; padding: 2px 7px; border-radius: 4px;">
                    แนะนำ
                </span>
            @endif

            <!-- Top Right Stock Status -->
            @if($product->stock <= 0)
                <span style="position: absolute; top: 6px; right: 6px; z-index: 10; font-size: 9px; font-weight: 900; background: #EF4444; color: white; padding: 2px 6px; border-radius: 4px;">หมด</span>
            @else
                <span style="position: absolute; top: 6px; right: 6px; z-index: 10; font-size: 9px; font-weight: 900; background: #FFE600; color: #0F172A; padding: 2px 6px; border-radius: 4px; border: 1px solid #EAB308;">พร้อมส่ง</span>
            @endif

            <!-- Product Image (Aspect Ratio 1:1 contain) -->
            @if($product->primary_image_url)
                <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}" loading="lazy" decoding="async" style="width: 100%; height: 100%; object-fit: contain; padding: 0.6rem; transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
            @else
                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                    <i class="fa-solid fa-mobile-screen text-4xl"></i>
                </div>
            @endif
        </a>
        
        <!-- Details & Pricing Box (Shopee Info Specs) -->
        <div style="padding: 0.5rem 0.55rem 0.45rem; background: white; display: flex; flex-direction: column; justify-content: space-between; flex-grow: 1; gap: 3px;">
            
            <!-- 2-Line Truncated Title -->
            <a href="{{ route('products.show', $product->id) }}" style="text-decoration: none; color: inherit;">
                <h3 style="font-size: 0.78rem; font-weight: 700; color: #0F172A; margin: 0; min-height: 2.1rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.3;">
                    {{ $product->name }}
                </h3>
            </a>
            
            <!-- Price & Ratings/Buttons Row (Ultra Compact) -->
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
                        $avgRating = round($product->reviews_avg_rating ?? 5.0, 1);
                        $reviewCount = $product->reviews_count ?? 0;
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

                        @if($product->stock > 0)
                        <form action="{{ route('cart.add', $product) }}" method="POST" class="ajax-add-to-cart-form" style="margin: 0;">
                            @csrf
                            <button type="submit" onclick="animateBasketBtn(this)" title="เพิ่มลงตะกร้า" style="background: #FF5722; color: white; border: none; width: 24px; height: 24px; border-radius: 50%; cursor: pointer; font-size: 0.7rem; font-weight: 900; display: flex; align-items: center; justify-content: center; transition: all 0.2s; box-shadow: 0 2px 6px rgba(255, 87, 34, 0.3);">
                                <i class="fa-solid fa-basket-shopping"></i>
                            </button>
                        </form>
                        @else
                        <button type="button" disabled title="สินค้าหมดชั่วคราว" style="background: #94A3B8; color: white; border: none; width: 24px; height: 24px; border-radius: 50%; cursor: not-allowed; font-size: 0.7rem; font-weight: 900; display: flex; align-items: center; justify-content: center; opacity: 0.7;">
                            <i class="fa-solid fa-ban"></i>
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 4rem 2rem; color: #94a3b8; background: white; border-radius: 24px; border: 1.5px solid #E2E8F0; box-shadow: 0 4px 20px rgba(0,0,0,0.02);">
            <i class="fa-solid fa-magnifying-glass-minus text-5xl mb-3" style="color: #94A3B8;"></i>
            <h4 style="font-size: 1.15rem; font-weight: 800; color: #0F172A; margin: 0 0 6px;">ไม่พบสินค้าที่ตรงตามเงื่อนไขการค้นหา</h4>
            <p style="font-size: 0.88rem; color: #64748B; margin: 0;">ลองเปลี่ยนคำค้นหา หรือกดล้างตัวกรองเพื่อดูสินค้าทั้งหมด</p>
        </div>
    @endforelse
</div>

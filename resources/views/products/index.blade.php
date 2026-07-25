@extends('layouts.store')

@section('content')
<div class="container fade-in" style="padding: 2.5rem 1rem; display: flex; gap: 2.5rem; flex-wrap: wrap;">

    <!-- Left Sidebar: Filters -->
    <aside style="flex: 1 1 280px; background: white; padding: 1.75rem; border-radius: 22px; border: 2px solid #E2E8F0; height: fit-content; box-shadow: 0 4px 15px rgba(15, 23, 42, 0.04);">
        <h3 style="font-size: 1.2rem; font-weight: 900; color: var(--color-navy); margin-bottom: 1.5rem; border-bottom: 2px solid #FFE600; padding-bottom: 0.75rem; display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-sliders" style="color: #FF5722;"></i> ตัวกรองมือถือมือสอง
        </h3>
        
        <form action="{{ route('products.index') }}" method="GET" style="display: flex; flex-direction: column; gap: 1.5rem;">
            
            <!-- Search Keyword Input -->
            <div>
                <h4 style="font-weight: 800; color: var(--color-navy); margin-bottom: 0.6rem; font-size: 0.92rem; text-transform: uppercase; letter-spacing: 0.03em;">ค้นหาชื่อรุ่น / สินค้า</h4>
                <div style="position: relative;">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="พิมพ์ iPhone 14, iPad..." 
                           style="width: 100%; padding: 10px 14px; border: 1.5px solid #FFE600; border-radius: 12px; font-size: 0.88rem; font-family: inherit; outline: none; transition: border-color 0.2s;"
                           onfocus="this.style.borderColor='#FF5722'"
                           onblur="this.style.borderColor='#FFE600'">
                </div>
            </div>

            <!-- Brand Filter (Checkboxes) -->
            <div>
                <h4 style="font-weight: 800; color: var(--color-navy); margin-bottom: 0.6rem; font-size: 0.92rem; text-transform: uppercase; letter-spacing: 0.03em;">แบรนด์ / ยี่ห้อ</h4>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    @foreach($brands as $brand)
                    @php
                        $brandChecked = is_array(request('brand_ids')) && in_array($brand->id, request('brand_ids')) || request('brand_id') == $brand->id;
                    @endphp
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 0.88rem; color: #475569; font-weight: 600; transition: color 0.2s;" onmouseover="this.style.color='#FF5722'" onmouseout="this.style.color='#475569'">
                        <input type="checkbox" name="brand_ids[]" value="{{ $brand->id }}" {{ $brandChecked ? 'checked' : '' }} 
                               style="width: 16px; height: 16px; border: 1.5px solid #FFE600; border-radius: 4px; cursor: pointer; accent-color: #FF5722;">
                        <span>{{ $brand->name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- Category Filter (Checkboxes) -->
            <div>
                <h4 style="font-weight: 800; color: var(--color-navy); margin-bottom: 0.6rem; font-size: 0.92rem; text-transform: uppercase; letter-spacing: 0.03em;">หมวดหมู่สินค้า</h4>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    @foreach($categories as $category)
                    @php
                        $catChecked = is_array(request('category_ids')) && in_array($category->id, request('category_ids')) || request('category_id') == $category->id;
                    @endphp
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 0.88rem; color: #475569; font-weight: 600; transition: color 0.2s;" onmouseover="this.style.color='#FF5722'" onmouseout="this.style.color='#475569'">
                        <input type="checkbox" name="category_ids[]" value="{{ $category->id }}" {{ $catChecked ? 'checked' : '' }} 
                               style="width: 16px; height: 16px; border: 1.5px solid #FFE600; border-radius: 4px; cursor: pointer; accent-color: #FF5722;">
                        <span>{{ $category->name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- Price Range Filter -->
            <div>
                <h4 style="font-weight: 800; color: var(--color-navy); margin-bottom: 0.6rem; font-size: 0.92rem; text-transform: uppercase; letter-spacing: 0.03em;">ช่วงราคา (บาท)</h4>
                <div style="display: flex; gap: 8px; align-items: center;">
                    <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="ต่ำสุด" min="0"
                           style="width: 100%; padding: 8px 10px; border: 1.5px solid #E2E8F0; border-radius: 10px; font-size: 0.85rem; outline: none;"
                           onfocus="this.style.borderColor='#FFE600'" onblur="this.style.borderColor='#E2E8F0'">
                    <span style="color: #94A3B8;">-</span>
                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="สูงสุด" min="0"
                           style="width: 100%; padding: 8px 10px; border: 1.5px solid #E2E8F0; border-radius: 10px; font-size: 0.85rem; outline: none;"
                           onfocus="this.style.borderColor='#FFE600'" onblur="this.style.borderColor='#E2E8F0'">
                </div>
            </div>

            <!-- Special Discount Filter Toggle -->
            <div>
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 0.92rem; font-weight: 800; color: var(--color-navy-dark);">
                    <input type="checkbox" name="on_sale" value="1" {{ request('on_sale') == '1' ? 'checked' : '' }}
                           style="width: 18px; height: 18px; border: 1.5px solid #FF5722; border-radius: 4px; cursor: pointer; accent-color: #FF5722;">
                    <span style="color: #FF5722; display: flex; align-items: center; gap: 4px;">
                        🔥 สินค้าลดราคาพิเศษ
                    </span>
                </label>
            </div>

            <!-- Filter Buttons -->
            <div style="display: flex; flex-direction: column; gap: 10px; margin-top: 0.5rem;">
                <button type="submit" class="btn-capsule-yellow" style="width: 100%; justify-content: center; margin-top: 0.5rem;">
                ค้นหาสินค้า <span class="circle-icon"><i class="fa-solid fa-magnifying-glass"></i></span>
            </button>
                <a href="{{ route('products.index') }}" style="display: block; text-align: center; padding: 10px; color: #EF4444; text-decoration: none; font-weight: 700; font-size: 0.88rem; transition: color 0.2s; border: 1.5px solid rgba(239, 68, 68, 0.3); border-radius: 14px;" onmouseover="this.style.background='rgba(239, 68, 68, 0.08)'" onmouseout="this.style.background='transparent'">
                    ล้างตัวกรองทั้งหมด
                </a>
            </div>

        </form>
    </aside>

    <!-- Main Content: Products Grid -->
    <main style="flex: 3 1 600px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.75rem; flex-wrap: wrap; gap: 12px;">
            <div>
                <span class="badge-orange-fun" style="margin-bottom: 0.4rem; font-size: 0.72rem;">
                    🛡️ สินค้าคัดเกรด A+ รับประกัน 30 วัน
                </span>
                <h2 style="font-size: 1.85rem; font-weight: 900; color: var(--color-navy-dark); margin: 0; letter-spacing: -0.02em;">📱 สมาร์ทโฟนมือสองทั้งหมด</h2>
            </div>
            <span style="font-size: 0.9rem; color: #64748b; font-weight: 600;">พบทั้งหมด {{ $products->total() }} รายการ</span>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(230px, 1fr)); gap: 24px; margin-bottom: 3rem;">
            @forelse($products as $product)
            <div class="card-fun-hover" style="background: white; border: 2px solid #E2E8F0; border-radius: 22px; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 4px 18px rgba(15, 23, 42, 0.04);">
                <a href="{{ route('products.show', $product->id) }}" style="text-decoration: none; color: inherit; display: block; padding: 1.5rem; text-align: center; position: relative;">
                    <!-- Stock Pill -->
                    @if($product->stock <= 0)
                        <span style="position: absolute; top: 12px; right: 12px; font-size: 10px; font-weight: 900; background: #EF4444; color: white; padding: 4px 10px; border-radius: 99px;">สินค้าหมด</span>
                    @elseif($product->stock <= 5)
                        <span style="position: absolute; top: 12px; right: 12px; font-size: 10px; font-weight: 900; background: #FF5722; color: white; padding: 4px 10px; border-radius: 99px;">เหลือ {{ $product->stock }} เครื่อง</span>
                    @else
                        <span style="position: absolute; top: 12px; right: 12px; font-size: 10px; font-weight: 900; background: #FFE600; color: #0F172A; padding: 4px 10px; border-radius: 99px; border: 1px solid #FFC700;">พร้อมส่ง</span>
                    @endif

                    @if($product->images->where('is_primary', true)->first())
                        @php
                            $imgPath = $product->images->where('is_primary', true)->first()->image_path;
                        @endphp
                        @if(str_starts_with($imgPath, 'http'))
                            <img src="{{ $imgPath }}" alt="{{ $product->name }}" style="max-width: 100%; height: 180px; object-fit: contain; border-radius: 12px;">
                        @else
                            <img src="{{ Storage::url($imgPath) }}" alt="{{ $product->name }}" style="max-width: 100%; height: 180px; object-fit: contain; border-radius: 12px;">
                        @endif
                    @else
                        <div style="width: 100%; height: 180px; background: #f8fafc; display: flex; align-items: center; justify-content: center; color: #94a3b8; border-radius: 12px;">
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
                                <span style="font-size: 0.85rem; text-decoration: line-through; color: #94A3B8; margin-bottom: -0.25rem;">฿{{ number_format($product->price, 2) }}</span>
                                <span style="font-size: 1.3rem; font-weight: 900; color: #FF5722;">฿{{ number_format($product->discount_price, 2) }}</span>
                            @else
                                <span style="font-size: 1.3rem; font-weight: 900; color: var(--color-navy-dark);">฿{{ number_format($product->price, 2) }}</span>
                            @endif
                        </div>
                        
                        <div style="display: flex; gap: 8px; align-items: center;">
                            <!-- Wishlist Toggle (AJAX) -->
                            @php 
                                $isFavorite = auth()->check() && \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->exists();
                            @endphp
                            <button type="button" class="wishlist-toggle-btn" data-product-id="{{ $product->id }}" title="เพิ่มในสินค้าที่ชอบ" style="background: white; border: 1.5px solid #E2E8F0; color: {{ $isFavorite ? '#FF5722' : '#94A3B8' }}; width: 42px; height: 42px; border-radius: 50%; cursor: pointer; font-size: 1.1rem; display: flex; align-items: center; justify-content: center; transition: all 0.2s; box-shadow: 0 4px 6px rgba(0,0,0,0.03);" onmouseover="this.style.transform='scale(1.1)'; this.style.borderColor='#FF5722';" onmouseout="this.style.transform='scale(1)'; this.style.borderColor='#E2E8F0';">
                                <i class="fa-{{ $isFavorite ? 'solid' : 'regular' }} fa-heart"></i>
                            </button>

                            <!-- Add to Cart (Ajax-enabled) -->
                            <form action="{{ route('cart.add', $product) }}" method="POST" class="ajax-add-to-cart-form" style="margin: 0;">
                                @csrf
                                <button type="submit" title="เพิ่มลงตะกร้า" style="background: #FFE600; color: #0F172A; border: 1.5px solid #FFC700; width: 42px; height: 42px; border-radius: 50%; cursor: pointer; font-size: 1.1rem; font-weight: 900; display: flex; align-items: center; justify-content: center; transition: all 0.2s; box-shadow: 0 4px 10px rgba(255, 230, 0, 0.4);" onmouseover="this.style.transform='scale(1.1)'; this.style.background='#FF5722'; this.style.color='white';" onmouseout="this.style.transform='scale(1)'; this.style.background='#FFE600'; this.style.color='#0F172A';">
                                    <i class="fa-solid fa-basket-shopping"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 4rem; color: #94a3b8; background: white; border-radius: 20px; border: 1px solid rgba(226, 232, 240, 0.8);">
                    <i class="fa-solid fa-box-open text-5xl mb-3"></i>
                    <p>ไม่พบสินค้าที่ตรงตามตัวกรองนี้</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div style="margin-top: 2rem;">
            {{ $products->links() }}
        </div>
    </main>

</div>
@endsection

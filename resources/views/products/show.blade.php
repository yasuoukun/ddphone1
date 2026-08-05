@extends('layouts.store')

@php
    $effectivePrice = $product->discount_price ?: $product->price;
    $primaryImg = $product->images->where('is_primary', true)->first() ?? $product->images->first();
    $primaryImgUrl = $primaryImg ? (str_starts_with($primaryImg->image_path, 'http') ? $primaryImg->image_path : asset('storage/' . ltrim(str_replace(['public/', 'storage/'], '', $primaryImg->image_path), '/'))) : asset('images/logoddphone.png');
    
    // Smart Fallback Logic
    $autoTitle = $product->name . ' - ราคา ฿' . number_format($effectivePrice) . ' | DDPHONE ดีดีโฟน';
    $autoDesc = Str::limit(strip_tags($product->description ?: $product->name . ' คุณภาพสูง พร้อมการรับประกันร้าน 30 วันเต็ม จัดส่งฟรีทั่วไทย'), 160);
    $autoKeywords = $product->name . ', ' . ($product->brand->name ?? '') . ', ' . ($product->category->name ?? '') . ', DDPHONE, ดีดีโฟน, สมาร์ทโฟน';

    $finalTitle = !empty($product->seo_title) ? $product->seo_title : $autoTitle;
    $finalDesc = !empty($product->seo_description) ? $product->seo_description : $autoDesc;
    $finalKeywords = !empty($product->seo_keywords) ? $product->seo_keywords : $autoKeywords;
@endphp

@section('title', $finalTitle)
@section('meta_title', $finalTitle)
@section('meta_description', $finalDesc)
@section('meta_keywords', $finalKeywords)

@section('og_type', 'product')
@section('og_title', $finalTitle)
@section('og_description', $finalDesc)
@section('og_image', $primaryImgUrl)

<script type="application/ld+json">
{
  "@@context": "https://schema.org/",
  "@type": "Product",
  "name": "{{ e($product->name) }}",
  "image": ["{{ $primaryImgUrl }}"],
  "description": "{{ e($finalDesc) }}",
  "sku": "{{ $product->sku ?: $product->id }}",
  "brand": {
    "@type": "Brand",
    "name": "{{ e($product->brand->name ?? 'DDPHONE') }}"
  },
  "offers": {
    "@type": "Offer",
    "url": "{{ url()->current() }}",
    "priceCurrency": "THB",
    "price": "{{ $effectivePrice }}",
    "priceValidUntil": "{{ date('Y-12-31') }}",
    "itemCondition": "https://schema.org/UsedCondition",
    "availability": "{{ $product->stock > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' }}",
    "seller": {
      "@type": "Organization",
      "name": "DDPHONE ดีดีโฟน"
    }
  }
  @if($product->reviews && count($product->reviews) > 0)
  ,
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "{{ round($product->reviews->avg('rating'), 1) }}",
    "reviewCount": "{{ count($product->reviews) }}"
  }
  @endif
}
</script>

@section('content')
<style>
    .custom-file-upload-label {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #0F172A;
        color: #FFE600;
        padding: 10px 20px;
        border-radius: 99px;
        font-weight: 800;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.15);
    }
    .custom-file-upload-label:hover {
        background: #1E293B;
        transform: translateY(-2px);
    }
    .review-card-item {
        background: #FAFAFA;
        border: 1.5px solid #E2E8F0;
        border-radius: 18px;
        padding: 1.5rem;
        margin-bottom: 1.25rem;
        transition: all 0.2s;
    }
    .review-card-item:hover {
        background: white;
        border-color: #0F172A;
        box-shadow: 0 6px 20px rgba(15, 23, 42, 0.06);
    }
    .anonymous-toggle-card {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 12px;
        border-radius: 99px;
        background: #F1F5F9;
        border: 1.5px solid #E2E8F0;
        cursor: pointer;
        user-select: none;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        color: #475569;
        width: fit-content;
        max-width: 100%;
        box-sizing: border-box;
    }
    .anonymous-toggle-card:hover {
        border-color: #CBD5E1;
        background: #E2E8F0;
    }
    .anonymous-toggle-card.active {
        background: #0F172A;
        border-color: #0F172A;
        color: #FFFFFF;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.2);
    }
    .toggle-switch-track {
        width: 34px;
        height: 20px;
        background: #CBD5E1;
        border-radius: 99px;
        position: relative;
        padding: 2px;
        transition: background-color 0.25s ease;
        flex-shrink: 0;
        box-sizing: border-box;
    }
    .toggle-switch-track.active {
        background: #22C55E;
    }
    .toggle-switch-thumb {
        width: 16px;
        height: 16px;
        background: #FFFFFF;
        border-radius: 50%;
        transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 1px 4px rgba(0,0,0,0.2);
        transform: translateX(0);
        box-sizing: border-box;
    }
    .toggle-switch-thumb.active {
        transform: translateX(14px);
    }
    .sr-only-input {
        position: absolute !important;
        width: 1px !important;
        height: 1px !important;
        padding: 0 !important;
        margin: -1px !important;
        overflow: hidden !important;
        clip: rect(0, 0, 0, 0) !important;
        white-space: nowrap !important;
        border-width: 0 !important;
    }
    @media (max-width: 768px) {
        .custom-file-upload-label {
            padding: 8px 14px !important;
            font-size: 0.78rem !important;
            width: 100%;
            box-sizing: border-box;
            justify-content: center;
        }
        .anonymous-toggle-wrapper-box {
            align-self: flex-start !important;
            width: 100%;
        }
        .anonymous-toggle-card {
            width: 100% !important;
            padding: 6px 10px !important;
            box-sizing: border-box;
        }
        .anon-title-txt {
            font-size: 0.78rem !important;
        }
        .anon-sub-txt {
            font-size: 0.65rem !important;
        }
        .product-detail-grid {
            grid-template-columns: 1fr !important;
            padding: 1.5rem !important;
            gap: 1.5rem !important;
        }
        .product-main-image-box {
            max-height: 320px !important;
        }
    }
</style>

<div class="container fade-in" style="padding: 2.5rem 1rem; max-width: 1200px; margin: 0 auto;">
    
    <!-- Back Button -->
    <a href="{{ route('products.index') }}" style="display: inline-flex; align-items: center; gap: 8px; color: #0F172A; text-decoration: none; font-weight: 800; margin-bottom: 2rem; font-size: 0.92rem; background: white; padding: 8px 18px; border-radius: 99px; border: 1.5px solid #E2E8F0; box-shadow: 0 2px 8px rgba(15,23,42,0.04);" onmouseover="this.style.background='#0F172A'; this.style.color='#FFE600';" onmouseout="this.style.background='white'; this.style.color='#0F172A';">
        ← กลับไปหน้าสินค้าทั้งหมด
    </a>

    <!-- Product Main Details Grid Card -->
    <div class="product-detail-grid" style="background: white; border: 2px solid #E2E8F0; border-radius: 24px; padding: 2.5rem; display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; box-shadow: 0 6px 25px rgba(15,23,42,0.04); margin-bottom: 3.5rem;">
        
        <!-- Left Column: Product Image Showcase -->
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            <!-- Main Large Image Container (Fixed Aspect Ratio & Height to Prevent Layout Shift) -->
            <div class="product-main-image-box" style="display: flex; flex-direction: column; align-items: center; justify-content: center; background: #F8FAFC; border-radius: 20px; padding: 1rem; border: 1.5px solid #E2E8F0; position: relative; width: 100%; aspect-ratio: 1/1; max-height: 420px; overflow: hidden; box-sizing: border-box;">
                <span style="position: absolute; top: 15px; left: 15px; background: #FFE600; color: #0F172A; font-weight: 900; font-size: 0.72rem; padding: 3px 10px; border-radius: 99px; border: 1px solid #EAB308; z-index: 5; white-space: nowrap;">
                    GRADE A+ GUARANTEED
                </span>

                @php
                    $primaryImg = $product->images->where('is_primary', true)->first() ?? $product->images->first();
                @endphp

                @if($primaryImg)
                    @php
                        $mainSrc = str_starts_with($primaryImg->image_path, 'http') 
                            ? $primaryImg->image_path 
                            : '/media/' . ltrim(str_replace(['public/', 'storage/'], '', $primaryImg->image_path), '/');
                    @endphp
                    <img id="main-product-img-display" src="{{ $mainSrc }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: contain; filter: drop-shadow(0 10px 20px rgba(15,23,42,0.12)); cursor: pointer; transition: transform 0.3s ease;" title="คลิกเพื่อดูรูปขนาดเต็ม" onclick="openImageModal(this.src)">
                @else
                    <div style="width: 100%; height: 100%; background: #E2E8F0; border-radius: 16px; display: flex; align-items: center; justify-content: center; color: #64748B; font-size: 3rem;">📱</div>
                @endif
            </div>

            <!-- Gallery Thumbnails (Other Uploaded Images) -->
            @if($product->images && $product->images->count() > 1)
            <div style="display: flex; gap: 12px; overflow-x: auto; padding: 6px 2px; scrollbar-width: thin;">
                @foreach($product->images as $imgIdx => $img)
                    @php
                        $imgUrl = str_starts_with($img->image_path, 'http') 
                            ? $img->image_path 
                            : '/media/' . ltrim(str_replace(['public/', 'storage/'], '', $img->image_path), '/');
                        $isActive = ($primaryImg && $primaryImg->id === $img->id);
                    @endphp
                    <div class="product-gallery-thumb {{ $isActive ? 'active-thumb' : '' }}" onclick="changeMainImage('{{ $imgUrl }}', this)" style="width: 76px; height: 76px; border-radius: 14px; border: 2.5px solid {{ $isActive ? '#0F172A' : '#E2E8F0' }}; background: white; padding: 4px; cursor: pointer; flex-shrink: 0; transition: all 0.2s; box-shadow: 0 2px 8px rgba(15,23,42,0.04);">
                        <img src="{{ $imgUrl }}" alt="Product image {{ $imgIdx + 1 }}" style="width: 100%; height: 100%; object-fit: contain; border-radius: 8px;">
                    </div>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Right Column: Product Info & Actions -->
        <div style="display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <!-- Brand & Category & SKU Badges -->
                <div style="display: flex; gap: 10px; margin-bottom: 1rem; flex-wrap: wrap;">
                    <span style="background: #0F172A; color: #FFE600; padding: 4px 14px; border-radius: 99px; font-size: 0.82rem; font-weight: 900; white-space: nowrap;">
                        แบรนด์: {{ $product->brand->name ?? 'ทั่วไป' }}
                    </span>
                    <span style="background: #EFF6FF; color: #2563EB; border: 1px solid #BFDBFE; padding: 4px 14px; border-radius: 99px; font-size: 0.82rem; font-weight: 900; white-space: nowrap;">
                        หมวดหมู่: {{ $product->category->name ?? 'ทั่วไป' }}
                    </span>
                    @if($product->sku)
                    <span style="background: #F1F5F9; color: #475569; padding: 4px 14px; border-radius: 99px; font-size: 0.82rem; font-weight: 800; font-family: monospace; white-space: nowrap;">
                        SKU: {{ $product->sku }}
                    </span>
                    @endif
                </div>

                <!-- Product Name -->
                <h1 style="font-size: 2.1rem; color: #0F172A; font-weight: 900; margin: 0 0 1rem; line-height: 1.25;">
                    {{ $product->name }}
                </h1>

                <!-- Price and Discount -->
                <div style="display: flex; align-items: baseline; gap: 16px; margin-bottom: 1.5rem;">
                    @if($product->discount_price)
                        <span style="font-size: 2.4rem; font-weight: 900; color: #EF4444;">
                            ฿{{ number_format($product->discount_price, 2) }}
                        </span>
                        <span style="font-size: 1.25rem; text-decoration: line-through; color: #94A3B8; font-weight: 700;">
                            ฿{{ number_format($product->price, 2) }}
                        </span>
                    @else
                        <span style="font-size: 2.4rem; font-weight: 900; color: #0F172A;">
                            ฿{{ number_format($product->price, 2) }}
                        </span>
                    @endif
                </div>

                <!-- Section 7: Conditional Installment Widget (Shown ONLY IF Admin added installment_details) -->
                @if(!empty($product->installment_details))
                <div style="background: #EFF6FF; border: 1.5px solid #BFDBFE; border-radius: 16px; padding: 14px 18px; margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                    <div style="font-size: 0.92rem; color: #0F172A; font-weight: 800;">
                        💳 <strong style="color: #2563EB;">รายละเอียดการผ่อนชำระ:</strong> {{ $product->installment_details }}
                    </div>
                    <a href="{{ route('installment') }}" style="color: #2563EB; font-weight: 900; font-size: 0.85rem; text-decoration: underline;">
                        คำนวณยอดผ่อน ➔
                    </a>
                </div>
                @endif

                <!-- Freebie/Gift Widget -->
                @if($product->freebie)
                <div style="background: #FEF2F2; border: 1.5px dashed #EF4444; border-radius: 16px; padding: 14px 18px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 12px;">
                    <span style="font-size: 1.4rem;">🎁</span>
                    <div style="font-size: 0.9rem; color: #0F172A; line-height: 1.4; font-weight: 700;">
                        <strong style="color: #EF4444; font-weight: 900;">ของแถมพิเศษ:</strong> {{ $product->freebie }}
                    </div>
                </div>
                @endif

                <!-- Stock availability -->
                <p style="font-size: 0.95rem; margin-bottom: 1.75rem; display: flex; align-items: center; gap: 8px;">
                    <span style="width: 10px; height: 10px; border-radius: 50%; background: {{ $product->stock > 0 ? '#10B981' : '#EF4444' }}; display: inline-block;"></span>
                    <strong style="color: #0F172A; font-weight: 900;">สถานะสินค้า:</strong> 
                    <span style="color: {{ $product->stock > 0 ? '#10B981' : '#EF4444' }}; font-weight: 800;">
                        {{ $product->stock > 0 ? 'สินค้าพร้อมจำหน่าย (คงเหลือ '.$product->stock.' เครื่อง)' : 'สินค้าหมดชั่วคราว' }}
                    </span>
                </p>

                <!-- Description Section -->
                <div style="border-top: 1.5px solid #F1F5F9; padding-top: 1.25rem; margin-bottom: 1.5rem;">
                    <h3 style="font-size: 1.1rem; color: #0F172A; font-weight: 900; margin-top: 0; margin-bottom: 0.5rem;">
                        📝 รายละเอียดสินค้าเพิ่มเติม
                    </h3>
                    <p style="color: #475569; font-size: 0.98rem; line-height: 1.65; margin: 0; white-space: pre-line; font-weight: 600;">
                        {{ $product->description ?? 'ไม่มีข้อมูลรายละเอียดสินค้าเพิ่มเติม' }}
                    </p>
                </div>

                <!-- Specifications Section -->
                @if($product->specifications)
                <div style="border-top: 1.5px solid #F1F5F9; padding-top: 1.25rem; margin-bottom: 1.5rem;">
                    <h3 style="font-size: 1.1rem; color: #0F172A; font-weight: 900; margin-top: 0; margin-bottom: 0.5rem;">
                        ⚙️ สเปกสินค้า (Specifications)
                    </h3>
                    <p style="color: #475569; font-size: 0.98rem; line-height: 1.65; margin: 0; white-space: pre-line; font-weight: 600;">
                        {{ $product->specifications }}
                    </p>
                </div>
                @endif
            </div>

            <!-- Action Buttons Section -->
            <div style="display: flex; gap: 14px; width: 100%;">
                <div style="flex-grow: 1;">
                    @if($product->stock > 0)
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="ajax-add-to-cart-form" style="margin: 0;">
                        @csrf
                        <button type="submit" style="width: 100%; padding: 16px; background: #0F172A; color: #FFE600; border: none; border-radius: 99px; font-weight: 900; font-size: 1.05rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 12px; box-shadow: 0 8px 20px rgba(15,23,42,0.2); transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.02)'; this.style.background='#1E293B';" onmouseout="this.style.transform='scale(1)'; this.style.background='#0F172A';">
                            <i class="fa-solid fa-basket-shopping"></i> <span class="cart-btn-label">เพิ่มลงตะกร้าสินค้า</span>
                        </button>
                    </form>
                    @else
                    <button disabled style="width: 100%; padding: 16px; background: #94A3B8; color: white; border: none; border-radius: 99px; font-weight: 900; font-size: 1.05rem; cursor: not-allowed; display: flex; align-items: center; justify-content: center; gap: 12px;">
                        <i class="fa-solid fa-ban"></i> <span class="cart-btn-label">สินค้าหมดชั่วคราว</span>
                    </button>
                    @endif
                </div>
                
                <div>
                    <!-- Wishlist Toggle -->
                    @php 
                        $isFavorite = auth()->check() && \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->exists();
                    @endphp
                    <button type="button" class="wishlist-toggle-btn" data-product-id="{{ $product->id }}" style="background: white; border: 2px solid #E2E8F0; color: {{ $isFavorite ? '#EF4444' : '#94A3B8' }}; width: 56px; height: 56px; border-radius: 50%; cursor: pointer; font-size: 1.4rem; display: flex; align-items: center; justify-content: center; transition: all 0.2s;" onmouseover="this.style.borderColor='#EF4444';" onmouseout="this.style.borderColor='#E2E8F0';">
                        <i class="fa-{{ $isFavorite ? 'solid' : 'regular' }} fa-heart"></i>
                    </button>
                </div>
            </div>

            <!-- LINE OA Contact Button -->
            <div style="margin-top: 14px;">
                <a href="https://line.me/ti/p/@ddphone" target="_blank" style="display: flex; align-items: center; justify-content: center; gap: 10px; background-color: #06c755; color: white; padding: 14px; border-radius: 99px; font-weight: 900; text-decoration: none; font-size: 0.98rem; transition: transform 0.2s; box-shadow: 0 6px 16px rgba(6,199,85,0.25);" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                    <i class="fa-brands fa-line" style="font-size: 1.4rem;"></i> สอบถามรายละเอียดเพิ่มเติมผ่าน LINE OA
                </a>
            </div>

        </div>
    </div>

    <!-- Product Reviews Section (Section 7: Beautiful Layout & Custom File Button & Show More Toggle) -->
    <div style="background: white; border: 2px solid #E2E8F0; border-radius: 24px; padding: 2.5rem; box-shadow: 0 6px 25px rgba(15,23,42,0.04); margin-bottom: 4rem;">
        <h2 style="font-size: 1.65rem; color: #0F172A; margin-bottom: 1.75rem; font-weight: 900; border-left: 5px solid #0F172A; padding-left: 14px; display: flex; align-items: center; gap: 10px;">
            ⭐ รีวิวและความคิดเห็นจากผู้ซื้อจริง ({{ count($product->reviews) }})
        </h2>

        <!-- Write a Review Form (Custom File Button & Star Rating) -->
        @auth
        <div style="background: #F8FAFC; border-radius: 20px; padding: 2rem; margin-bottom: 2.5rem; border: 2px dashed #CBD5E1;">
            <h3 style="font-size: 1.15rem; color: #0F172A; font-weight: 900; margin: 0 0 1.25rem;">✍️ เขียนรีวิวให้คะแนนสินค้าของคุณ</h3>
            <form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                
                <div style="margin-bottom: 1.25rem; display: flex; align-items: center; gap: 16px;">
                    <label style="font-weight: 800; color: #0F172A; font-size: 0.95rem;">ให้คะแนนความพึงพอใจ:</label>
                    <div style="display: flex; gap: 6px; font-size: 2rem; cursor: pointer; color: #CBD5E1;" id="star-rating-container">
                        <span class="star-item" data-value="1" style="transition: color 0.1s;">★</span>
                        <span class="star-item" data-value="2" style="transition: color 0.1s;">★</span>
                        <span class="star-item" data-value="3" style="transition: color 0.1s;">★</span>
                        <span class="star-item" data-value="4" style="transition: color 0.1s;">★</span>
                        <span class="star-item" data-value="5" style="transition: color 0.1s;">★</span>
                    </div>
                    <input type="hidden" name="rating" id="rating-hidden-input" value="5" required>
                </div>

                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-weight: 800; margin-bottom: 0.5rem; color: #0F172A; font-size: 0.95rem;">รายละเอียดความคิดเห็นของคุณ:</label>
                    <textarea name="comment" rows="3" placeholder="แบ่งปันประสบการณ์การใช้งานสินค้า สภาพเครื่อง การจัดส่ง และบริการ..." style="width: 100%; padding: 12px 16px; border: 1.5px solid #E2E8F0; border-radius: 14px; outline: none; font-family: inherit; font-weight: 600; color: #0F172A; background: white;" required></textarea>
                </div>

                <!-- Custom Styled File Upload & Anonymous Option Button -->
                <div style="margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px;">
                    <div>
                        <label style="display: block; font-weight: 800; margin-bottom: 0.5rem; color: #0F172A; font-size: 0.95rem;">📷 แนบรูปภาพ / วิดีโอรีวิวสินค้า:</label>
                        <label class="custom-file-upload-label">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                            <span id="file-upload-status-txt">เลือกไฟล์รูปภาพหรือวิดีโอ...</span>
                            <input type="file" name="media[]" id="custom-media-input" multiple accept="image/*,video/*" style="display: none;" onchange="updateFileNameDisplay(this)">
                        </label>
                    </div>

                    <!-- Modern Styled Toggle Pill / Switch for Anonymous Review -->
                    <div x-data="{ isAnon: false }" class="anonymous-toggle-wrapper-box" style="align-self: flex-end;">
                        <label class="anonymous-toggle-card" :class="{ 'active': isAnon }">
                            <input type="checkbox" name="is_anonymous" value="1" x-model="isAnon" class="sr-only-input">
                            
                            <!-- iOS Style Slider Switch -->
                            <div class="toggle-switch-track" :class="{ 'active': isAnon }">
                                <div class="toggle-switch-thumb" :class="{ 'active': isAnon }">
                                    <i x-show="isAnon" class="fa-solid fa-user-ninja" style="font-size: 0.58rem; color: #0F172A;"></i>
                                    <i x-show="!isAnon" class="fa-solid fa-user" style="font-size: 0.55rem; color: #94A3B8;"></i>
                                </div>
                            </div>

                            <div style="display: flex; flex-direction: column; line-height: 1.2;">
                                <span class="anon-title-txt" style="font-weight: 800; font-size: 0.82rem; display: flex; align-items: center; gap: 6px;">
                                    โพสต์รีวิวแบบไม่ระบุตัวตน
                                    <span x-show="isAnon" style="font-size: 0.62rem; background: #FFE600; color: #0F172A; padding: 1px 5px; border-radius: 4px; font-weight: 900;">เปิดใช้งาน</span>
                                </span>
                                <span class="anon-sub-txt" style="font-size: 0.68rem; opacity: 0.75; font-weight: 600;">ซ่อนชื่อและรูปโปรไฟล์ของคุณจากสาธารณะ</span>
                            </div>
                        </label>
                    </div>
                </div>

                <button type="submit" style="background: #0F172A; color: #FFE600; border: none; padding: 12px 30px; border-radius: 99px; font-weight: 900; font-size: 0.95rem; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 12px rgba(15,23,42,0.2);" onmouseover="this.style.background='#1E293B'" onmouseout="this.style.background='#0F172A'">
                    ส่งรีวิวสินค้า ➔
                </button>
            </form>
        </div>
        @else
        <div style="background: #FFFBEB; border: 1.5px solid #FCD34D; border-radius: 16px; padding: 1.25rem; text-align: center; color: #92400E; font-weight: 800; margin-bottom: 2.5rem;">
            🔒 กรุณา <a href="{{ route('login') }}" style="color: #0F172A; text-decoration: underline; font-weight: 900;">เข้าสู่ระบบ</a> เพื่อเขียนรีวิวสินค้าชิ้นนี้
        </div>
        @endauth

        <!-- Reviews Sorted by Likes Count & Limit 3 Items with Show More Button (Section 7) -->
        @php
            $sortedReviews = $product->reviews->sortByDesc('likes_count');
        @endphp

        <div id="reviews-container-wrapper">
            @forelse($sortedReviews as $idx => $review)
            <div class="review-card-item {{ $idx >= 3 ? 'extra-review-item' : '' }}" style="{{ $idx >= 3 ? 'display: none;' : '' }}">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.6rem; flex-wrap: wrap; gap: 10px;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        @if($review->is_anonymous)
                            <!-- Anonymous Avatar -->
                            <div style="width: 44px; height: 44px; border-radius: 50%; background: #64748B; color: white; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; box-shadow: 0 2px 8px rgba(0,0,0,0.15);" title="ผู้ใช้งานไม่ระบุตัวตน">
                                🕶️
                            </div>
                            <div>
                                <strong style="color: #0F172A; font-size: 1rem; font-weight: 900;">ผู้ใช้งานไม่ระบุตัวตน</strong>
                                <span style="color: #64748B; font-size: 0.78rem; margin-left: 8px; font-weight: 700;">🕒 {{ $review->created_at->format('d/m/Y H:i') }} น.</span>
                            </div>
                        @else
                            <!-- User Profile Avatar Image -->
                            <img src="{{ $review->user ? $review->user->avatar_url : 'https://ui-avatars.com/api/?name=User&color=FFFFFF&background=1B2A47' }}" 
                                 alt="{{ $review->user->name ?? 'ลูกค้าทั่วไป' }}" 
                                 style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover; border: 2px solid #0F172A; box-shadow: 0 2px 8px rgba(15,23,42,0.12);"
                                 onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($review->user->name ?? 'User') }}&color=FFFFFF&background=1B2A47'">
                            <div>
                                <strong style="color: #0F172A; font-size: 1rem; font-weight: 900;">{{ $review->user->name ?? 'ลูกค้าทั่วไป' }}</strong>
                                <span style="color: #64748B; font-size: 0.78rem; margin-left: 8px; font-weight: 700;">🕒 {{ $review->created_at->format('d/m/Y H:i') }} น.</span>
                            </div>
                        @endif
                    </div>
                    
                    <div style="color: #F59E0B; font-size: 1.1rem; letter-spacing: 2px;">
                        @for($i = 1; $i <= 5; $i++)
                            {{ $i <= $review->rating ? '★' : '☆' }}
                        @endfor
                    </div>
                </div>

                <p style="margin: 0 0 12px; color: #0F172A; font-size: 0.98rem; line-height: 1.6; font-weight: 600;">
                    {{ $review->comment }}
                </p>

                <!-- Media attachments -->
                @if(!empty($review->media_paths) && count($review->media_paths) > 0)
                <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 12px;">
                    @foreach($review->media_paths as $m)
                        @if(str_contains(strtolower($m), '.mp4') || str_contains(strtolower($m), '.mov'))
                            <video src="{{ Storage::url($m) }}" controls style="height: 110px; border-radius: 10px; border: 1.5px solid #E2E8F0;"></video>
                        @else
                            <img src="{{ Storage::url($m) }}" onclick="openImageModal(this.src)" style="height: 100px; width: 100px; object-fit: cover; border-radius: 10px; border: 1.5px solid #E2E8F0; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'" title="คลิกเพื่อดูรูปขนาดเต็ม">
                        @endif
                    @endforeach
                </div>
                @endif

                <!-- Review Like Button (Section 7) -->
                @php
                    $isLikedSession = session()->get('liked_review_' . $review->id, false);
                @endphp
                <div style="display: flex; justify-content: flex-end; align-items: center;">
                    <button type="button" onclick="likeReview(this, '{{ $review->id }}')" 
                            style="background: {{ $isLikedSession ? '#EFF6FF' : '#F1F5F9' }}; border: 1px solid {{ $isLikedSession ? '#2563EB' : '#CBD5E1' }}; color: {{ $isLikedSession ? '#2563EB' : '#0F172A' }}; padding: 4px 14px; border-radius: 99px; font-size: 0.8rem; font-weight: 800; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s;">
                        👍 ถูกใจรีวิวนี้ (<span class="like-count-num">{{ $review->likes_count ?? 0 }}</span>)
                    </button>
                </div>
            </div>
            @empty
            <div style="text-align: center; padding: 3rem 1rem; color: #94A3B8; font-weight: 700;">
                <p style="margin: 0; font-size: 0.95rem;">ยังไม่มีรีวิวสำหรับสินค้าชิ้นนี้ มาร่วมเป็นคนแรกที่เขียนรีวิวกันเถอะ!</p>
            </div>
            @endforelse
        </div>

        <!-- Show More Reviews Toggle Button (Section 7) -->
        @if(count($sortedReviews) > 3)
        <div style="text-align: center; margin-top: 1.5rem;">
            <button id="toggle-more-reviews-btn" onclick="toggleMoreReviews()" style="background: #0F172A; color: #FFE600; border: none; padding: 12px 32px; border-radius: 99px; font-weight: 900; font-size: 0.9rem; cursor: pointer; box-shadow: 0 4px 12px rgba(15,23,42,0.15); transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.04)'" onmouseout="this.style.transform='scale(1)'">
                👇 ดูรีวิวเพิ่มเติมทั้งหมด ({{ count($sortedReviews) - 3 }} รายการ)
            </button>
        </div>
        @endif
    </div>

    <!-- Related Products Section -->
    @if(count($relatedProducts) > 0)
    <div style="margin-bottom: 2rem;">
        <div style="border-bottom: 2px solid #E2E8F0; padding-bottom: 0.85rem; margin-bottom: 2rem;">
            <h2 style="font-size: 1.6rem; color: #0F172A; font-weight: 900; margin: 0;">
                📱 สินค้าอื่น ๆ ในหมวดหมู่นี้
            </h2>
        </div>
        <div class="product-grid-container" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(230px, 1fr)); gap: 16px;">
            @foreach($relatedProducts as $rel)
            <div class="card-fun-hover shopee-card-style" style="background: white; border: 1px solid #E2E8F0; border-radius: 14px; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04); position: relative; transition: all 0.2s ease;">
                
                <!-- Image Box (Shopee 1:1 Square Ratio) -->
                <a href="{{ route('products.show', $rel->id) }}" style="text-decoration: none; color: inherit; display: block; position: relative; width: 100%; aspect-ratio: 1/1; background: #F8FAFC; overflow: hidden;">
                    @if($rel->discount_price)
                        @php $percent = round((($rel->price - $rel->discount_price) / $rel->price) * 100); @endphp
                        <span style="position: absolute; top: 6px; left: 6px; z-index: 10; font-size: 10px; font-weight: 900; background: #FF5722; color: white; padding: 2px 7px; border-radius: 4px; box-shadow: 0 2px 6px rgba(255,87,34,0.3);">
                            -{{ $percent }}%
                        </span>
                    @endif

                    @if($rel->stock <= 0)
                        <span style="position: absolute; top: 6px; right: 6px; z-index: 10; font-size: 9px; font-weight: 900; background: #EF4444; color: white; padding: 2px 6px; border-radius: 4px;">หมด</span>
                    @else
                        <span style="position: absolute; top: 6px; right: 6px; z-index: 10; font-size: 9px; font-weight: 900; background: #FFE600; color: #0F172A; padding: 2px 6px; border-radius: 4px; border: 1px solid #EAB308;">พร้อมส่ง</span>
                    @endif

                    @if($rel->primary_image_url)
                        <img src="{{ $rel->primary_image_url }}" alt="{{ $rel->name }}" loading="lazy" decoding="async" style="width: 100%; height: 100%; object-fit: contain; padding: 0.6rem; transition: transform 0.3s ease;">
                    @else
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                            <i class="fa-solid fa-mobile-screen text-4xl"></i>
                        </div>
                    @endif
                </a>
                
                <!-- Details & Pricing Box (Shopee Info Specs) -->
                <div style="padding: 0.5rem 0.55rem 0.45rem; background: white; display: flex; flex-direction: column; justify-content: space-between; flex-grow: 1; gap: 3px;">
                    <a href="{{ route('products.show', $rel->id) }}" style="text-decoration: none; color: inherit;">
                        <h3 style="font-size: 0.78rem; font-weight: 700; color: #0F172A; margin: 0; min-height: 2.1rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.3;">
                            {{ $rel->name }}
                        </h3>
                    </a>
                    
                    <div style="display: flex; flex-direction: column; gap: 2px;">
                        <div style="display: flex; align-items: baseline; gap: 4px;">
                            @if($rel->discount_price)
                                <span style="font-size: 0.98rem; font-weight: 900; color: #FF5722; line-height: 1;">฿{{ number_format($rel->discount_price) }}</span>
                                <span style="font-size: 0.65rem; text-decoration: line-through; color: #94A3B8; line-height: 1;">฿{{ number_format($rel->price) }}</span>
                            @else
                                <span style="font-size: 0.98rem; font-weight: 900; color: #FF5722; line-height: 1;">฿{{ number_format($rel->price) }}</span>
                            @endif
                        </div>

                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 2px;">
                            @php
                                $avgRating = round($rel->reviews_avg_rating ?? 5.0, 1);
                                $reviewCount = $rel->reviews_count ?? 0;
                            @endphp
                            <span style="font-size: 0.62rem; color: #64748B; font-weight: 600;">
                                ⭐ {{ number_format($avgRating, 1) }} <span style="color: #CBD5E1;">|</span> {{ $reviewCount > 0 ? 'รีวิว ' . $reviewCount : 'สินค้าใหม่' }}
                            </span>
                            
                            <div style="display: flex; gap: 4px; align-items: center;">
                                @php 
                                    $isFav = auth()->check() && \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $rel->id)->exists();
                                @endphp
                                <button type="button" class="wishlist-toggle-btn" data-product-id="{{ $rel->id }}" onclick="animateHeartBtn(this)" title="เพิ่มในสินค้าที่ชอบ" style="background: #F8FAFC; border: 1px solid #E2E8F0; color: {{ $isFav ? '#EF4444' : '#94A3B8' }}; width: 24px; height: 24px; border-radius: 50%; cursor: pointer; font-size: 0.7rem; display: flex; align-items: center; justify-content: center; transition: all 0.2s;">
                                    <i class="fa-{{ $isFav ? 'solid' : 'regular' }} fa-heart"></i>
                                </button>

                                <form action="{{ route('cart.add', $rel) }}" method="POST" class="ajax-add-to-cart-form" style="margin: 0;">
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
            @endforeach
        </div>
    </div>
    @endif

</div>

<script>
    // Switch Main Product Image from Thumbnail Click
    function changeMainImage(url, thumbEl) {
        const mainImg = document.getElementById('main-product-img-display');
        if (mainImg) {
            mainImg.src = url;
        }
        document.querySelectorAll('.product-gallery-thumb').forEach(el => {
            el.classList.remove('active-thumb');
            el.style.borderColor = '#E2E8F0';
        });
        if (thumbEl) {
            thumbEl.classList.add('active-thumb');
            thumbEl.style.borderColor = '#0F172A';
        }
    }

    // File Input Label Display Update
    function updateFileNameDisplay(input) {
        const txt = document.getElementById('file-upload-status-txt');
        if (input.files && input.files.length > 0) {
            txt.innerText = `เลือกแล้ว ${input.files.length} ไฟล์`;
        } else {
            txt.innerText = `เลือกไฟล์รูปภาพหรือวิดีโอ...`;
        }
    }

    // Toggle More Reviews Display
    let isReviewsExpanded = false;
    function toggleMoreReviews() {
        const extraItems = document.querySelectorAll('.extra-review-item');
        const btn = document.getElementById('toggle-more-reviews-btn');
        if (!isReviewsExpanded) {
            extraItems.forEach(el => el.style.display = 'block');
            btn.innerText = '👆 ย่อรายการรีวิว';
            isReviewsExpanded = true;
        } else {
            extraItems.forEach(el => el.style.display = 'none');
            btn.innerText = '👇 ดูรีวิวเพิ่มเติมทั้งหมด';
            isReviewsExpanded = false;
        }
    }

    // Secure Like Review Function (Server-side validation & Toggle)
    function likeReview(btn, reviewId) {
        if (btn.disabled) return;
        btn.disabled = true;

        fetch('/reviews/' + reviewId + '/like', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const numSpan = btn.querySelector('.like-count-num');
                if (numSpan) numSpan.innerText = data.likes_count;

                if (data.liked) {
                    btn.style.color = '#2563EB';
                    btn.style.borderColor = '#2563EB';
                    btn.style.background = '#EFF6FF';
                } else {
                    btn.style.color = '#0F172A';
                    btn.style.borderColor = '#CBD5E1';
                    btn.style.background = '#F1F5F9';
                }
            }
        })
        .catch(err => console.error('Like review error:', err))
        .finally(() => {
            btn.disabled = false;
        });
    }

    // Dynamic Star Rating Interaction
    document.addEventListener('DOMContentLoaded', function() {
        const starContainer = document.getElementById('star-rating-container');
        if (starContainer) {
            const stars = starContainer.querySelectorAll('.star-item');
            const ratingInput = document.getElementById('rating-hidden-input');

            function setStars(val) {
                stars.forEach(star => {
                    const starVal = parseInt(star.getAttribute('data-value'));
                    if (starVal <= val) {
                        star.style.color = '#F59E0B'; // Gold
                    } else {
                        star.style.color = '#CBD5E1'; // Grey
                    }
                });
            }

            setStars(5);

            stars.forEach(star => {
                star.addEventListener('mouseover', function() {
                    const val = parseInt(this.getAttribute('data-value'));
                    setStars(val);
                });

                star.addEventListener('mouseout', function() {
                    const val = parseInt(ratingInput.value) || 5;
                    setStars(val);
                });

                star.addEventListener('click', function() {
                    const val = parseInt(this.getAttribute('data-value'));
                    ratingInput.value = val;
                    setStars(val);
                });
            });
        }
    });

    // Image Lightbox Modal Functions (Works on Desktop PC & Mobile)
    function openImageModal(imgSrc) {
        const modal = document.getElementById('image-lightbox-modal');
        const modalImg = document.getElementById('lightbox-modal-img');
        if (modal && modalImg) {
            modalImg.src = imgSrc;
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
    }

    function closeImageModal() {
        const modal = document.getElementById('image-lightbox-modal');
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    }
</script>

<!-- Global Image Lightbox Modal Popup (PC & Mobile Fit) -->
<div id="image-lightbox-modal" onclick="closeImageModal()" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(15, 23, 42, 0.88); backdrop-filter: blur(8px); z-index: 999999; align-items: center; justify-content: center; padding: 1rem; box-sizing: border-box; cursor: zoom-out;">
    <div style="position: relative; max-width: 90vw; max-height: 90vh; display: flex; flex-direction: column; align-items: center; justify-content: center;" onclick="event.stopPropagation()">
        <button type="button" onclick="closeImageModal()" style="position: absolute; top: -45px; right: -10px; background: #FFE600; color: #0F172A; border: none; width: 36px; height: 36px; border-radius: 50%; font-size: 1.1rem; font-weight: 900; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(0,0,0,0.3); z-index: 10;">
            ✕
        </button>
        <img id="lightbox-modal-img" src="" alt="ภาพสินค้าขยายเต็มจอ" style="max-width: 90vw; max-height: 82vh; object-fit: contain; border-radius: 16px; border: 2px solid rgba(255,255,255,0.2); box-shadow: 0 20px 50px rgba(0,0,0,0.5); background: white;">
    </div>
</div>
@endsection

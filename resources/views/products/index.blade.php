@extends('layouts.store')

@section('content')
<style>
    @keyframes heartPop {
        0% { transform: scale(1); }
        50% { transform: scale(1.35); color: #EF4444; }
        100% { transform: scale(1); }
    }
    .heart-pop-anim {
        animation: heartPop 0.4s ease-in-out !important;
    }
    @keyframes basketBounce {
        0%, 100% { transform: scale(1) rotate(0deg); }
        25% { transform: scale(1.2) rotate(-12deg); }
        75% { transform: scale(1.2) rotate(12deg); }
    }
    .basket-bounce-anim {
        animation: basketBounce 0.45s ease-in-out !important;
    }
    .pagination-wrapper nav {
        display: flex;
        justify-content: center;
    }
    .pagination-wrapper ul {
        display: flex;
        gap: 6px;
        list-style: none;
        padding: 0;
    }
    .pagination-wrapper li span, .pagination-wrapper li a {
        padding: 8px 16px;
        border-radius: 99px;
        border: 1.5px solid #E2E8F0;
        color: #0F172A;
        font-weight: 800;
        font-size: 0.88rem;
        text-decoration: none;
        transition: all 0.2s;
    }
    .pagination-wrapper li.active span {
        background: #0F172A;
        color: #FFE600;
        border-color: #0F172A;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.2);
    }
</style>

<div class="container fade-in" style="max-width: 1280px; margin: 0 auto; padding: 2rem 0.75rem; display: flex; gap: 2rem; flex-wrap: wrap; justify-content: center;">

    <!-- Mobile Filter Popup Trigger Button & Horizontal Filter Chips Bar -->
    <div class="mobile-filter-bar" style="display: none; width: 100%; margin-bottom: 1rem;">
        <!-- Real-time Search Input on Mobile -->
        <div style="margin-bottom: 0.65rem;">
            <form action="{{ route('products.index') }}" method="GET" style="margin: 0; position: relative;">
                <input type="text" id="mobile-realtime-q-input" name="q" value="{{ request('q') }}" placeholder="🔍 พิมพ์ค้นหาสินค้าอัตโนมัติ..." 
                       style="width: 100%; padding: 8px 12px 8px 34px; border: 1.5px solid #2563EB; border-radius: 99px; font-size: 0.8rem; font-family: inherit; outline: none; background: white; font-weight: 700; color: #0F172A; box-shadow: 0 2px 8px rgba(37,99,235,0.08);">
                <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #2563EB; font-size: 0.8rem;"></i>
                @if(request('q'))
                <a href="{{ route('products.index') }}" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); color: #94A3B8; font-size: 0.8rem; text-decoration: none;">
                    <i class="fa-solid fa-circle-xmark"></i>
                </a>
                @endif
            </form>
        </div>

        <div style="display: flex; align-items: center; justify-content: space-between; gap: 10px; width: 100%;">
            <!-- Left Horizontal Quick Filter Chips -->
            <div style="display: flex; gap: 8px; overflow-x: auto; scrollbar-width: none; -webkit-overflow-scrolling: touch; flex-grow: 1; padding: 2px 0;">
                <a href="{{ route('products.index') }}" style="text-decoration: none; flex-shrink: 0; padding: 6px 14px; border-radius: 8px; font-size: 0.78rem; font-weight: 800; background: {{ !request()->hasAny(['brand_ids', 'category_ids', 'on_sale']) ? '#0F172A' : '#F1F5F9' }}; color: {{ !request()->hasAny(['brand_ids', 'category_ids', 'on_sale']) ? '#FFE600' : '#475569' }}; border: 1px solid #E2E8F0;">
                    ทั้งหมด
                </a>
                <a href="{{ route('products.index', ['on_sale' => 1]) }}" style="text-decoration: none; flex-shrink: 0; padding: 6px 14px; border-radius: 8px; font-size: 0.78rem; font-weight: 800; background: {{ request('on_sale') ? '#FF5722' : '#F1F5F9' }}; color: {{ request('on_sale') ? 'white' : '#475569' }}; border: 1px solid #E2E8F0;">
                    🔥 โปรลดราคา
                </a>
            </div>

            <!-- Right Shopee-Style "ตัวกรอง" Button with Funnel Icon -->
            <button type="button" onclick="toggleMobileFilterModal()" style="flex-shrink: 0; display: flex; align-items: center; gap: 6px; background: #FFFFFF; border: 1.5px solid #E2E8F0; color: #FF5722; padding: 6px 14px; border-radius: 8px; font-weight: 900; font-size: 0.78rem; font-family: 'Prompt', sans-serif; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <i class="fa-solid fa-filter" style="font-size: 0.85rem; color: #FF5722;"></i> ตัวกรอง
                @php
                    $activeFilterCount = (is_array(request('brand_ids')) ? count(request('brand_ids')) : 0) + (is_array(request('category_ids')) ? count(request('category_ids')) : 0) + (request('on_sale') ? 1 : 0);
                @endphp
                @if($activeFilterCount > 0)
                <span style="background: #FF5722; color: white; border-radius: 50%; font-size: 0.65rem; width: 16px; height: 16px; display: inline-flex; align-items: center; justify-content: center;">{{ $activeFilterCount }}</span>
                @endif
            </button>
        </div>
    </div>

    <!-- Mobile Filter Slide-Up Popup Modal (Shopee Style) -->
    <div id="mobile-filter-modal-backdrop" onclick="toggleMobileFilterModal()" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 999998;"></div>
    <div id="mobile-filter-modal" style="display: none; position: fixed; bottom: -100%; left: 0; right: 0; background: white; border-radius: 20px 20px 0 0; z-index: 999999; padding: 1rem; max-height: 80vh; overflow-y: auto; transition: bottom 0.35s cubic-bezier(0.16, 1, 0.3, 1); box-shadow: 0 -10px 40px rgba(0,0,0,0.2);">
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1.5px solid #F1F5F9; padding-bottom: 0.5rem; margin-bottom: 0.75rem;">
            <h3 style="margin: 0; font-size: 0.98rem; font-weight: 900; color: #0F172A; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-filter" style="color: #FF5722;"></i> ตัวกรองสินค้า
            </h3>
            <button type="button" onclick="toggleMobileFilterModal()" style="background: #F1F5F9; border: none; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #64748B;">
                <i class="fa-solid fa-xmark" style="font-size: 0.85rem;"></i>
            </button>
        </div>

        <form id="mobile-filter-form" action="{{ route('products.index') }}" method="GET" style="display: flex; flex-direction: column; gap: 0.85rem;">
            <!-- Sort -->
            <div>
                <h4 style="font-weight: 900; color: #0F172A; margin: 0 0 0.35rem; font-size: 0.78rem;">เรียงลำดับตาม</h4>
                <select name="sort" style="width: 100%; padding: 6px 10px; border: 1.5px solid #E2E8F0; border-radius: 8px; font-size: 0.78rem; font-weight: 700; color: #0F172A; background: #F8FAFC;">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>✨ มาใหม่ล่าสุด</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>💰 ราคา: ต่ำ - สูง</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>💎 ราคา: สูง - ต่ำ</option>
                </select>
            </div>

            <!-- Brand -->
            <div>
                <h4 style="font-weight: 900; color: #0F172A; margin: 0 0 0.35rem; font-size: 0.78rem;">แบรนด์สินค้า</h4>
                <div style="display: flex; flex-wrap: wrap; gap: 6px;">
                    @foreach($brands as $brand)
                    @php $bChecked = is_array(request('brand_ids')) && in_array($brand->id, request('brand_ids')); @endphp
                    <label style="display: inline-flex; align-items: center; gap: 5px; font-size: 0.74rem; font-weight: 700; background: #F8FAFC; padding: 4px 8px; border-radius: 6px; border: 1px solid #E2E8F0; max-width: 48%; box-sizing: border-box;">
                        <input type="checkbox" name="brand_ids[]" value="{{ $brand->id }}" {{ $bChecked ? 'checked' : '' }} style="accent-color: #FF5722; flex-shrink: 0;">
                        <span style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $brand->name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- Category -->
            <div>
                <h4 style="font-weight: 900; color: #0F172A; margin: 0 0 0.35rem; font-size: 0.78rem;">หมวดหมู่สินค้า</h4>
                <div style="display: flex; flex-wrap: wrap; gap: 6px;">
                    @foreach($categories as $category)
                    @php $cChecked = is_array(request('category_ids')) && in_array($category->id, request('category_ids')); @endphp
                    <label style="display: inline-flex; align-items: center; gap: 5px; font-size: 0.74rem; font-weight: 700; background: #F8FAFC; padding: 4px 8px; border-radius: 6px; border: 1px solid #E2E8F0; max-width: 48%; box-sizing: border-box;">
                        <input type="checkbox" name="category_ids[]" value="{{ $category->id }}" {{ $cChecked ? 'checked' : '' }} style="accent-color: #FF5722; flex-shrink: 0;">
                        <span style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $category->name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- Price -->
            <div>
                <h4 style="font-weight: 900; color: #0F172A; margin: 0 0 0.35rem; font-size: 0.78rem;">ช่วงราคา (บาท)</h4>
                <div style="display: flex; gap: 6px;">
                    <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="ต่ำสุด" style="width: 50%; padding: 6px 8px; border: 1.5px solid #E2E8F0; border-radius: 6px; font-size: 0.76rem;">
                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="สูงสุด" style="width: 50%; padding: 6px 8px; border: 1.5px solid #E2E8F0; border-radius: 6px; font-size: 0.76rem;">
                </div>
            </div>

            <!-- Action Buttons Sticky at bottom -->
            <div style="display: flex; gap: 8px; margin-top: 0.25rem; padding-top: 0.5rem; border-top: 1px solid #F1F5F9; position: sticky; bottom: 0; background: white; z-index: 10;">
                <a href="{{ route('products.index') }}" style="flex: 1; text-align: center; background: #F1F5F9; color: #64748B; text-decoration: none; padding: 8px; border-radius: 8px; font-weight: 800; font-size: 0.78rem;">ล้างค่า</a>
                <button type="submit" style="flex: 2; background: #FF5722; color: white; border: none; padding: 8px; border-radius: 8px; font-weight: 900; font-size: 0.78rem; font-family: 'Prompt', sans-serif;">ดูผลลัพธ์</button>
            </div>
        </form>
    </div>

    <!-- Desktop Left Sidebar: Real-time Filters -->
    <aside class="desktop-filter-sidebar" style="flex: 0 0 280px; width: 280px; max-width: 100%; background: white; padding: 1.75rem; border-radius: 24px; border: 2px solid #E2E8F0; height: fit-content; box-shadow: 0 6px 20px rgba(15, 23, 42, 0.04);">
        <div style="border-bottom: 2px solid #3B82F6; padding-bottom: 0.75rem; margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between;">
            <h3 style="font-size: 1.15rem; font-weight: 900; color: #0F172A; margin: 0; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-filter" style="color: #2563EB;"></i> ค้นหา & ตัวกรองสินค้า
            </h3>
            <span style="font-size: 0.72rem; background: #EFF6FF; color: #2563EB; font-weight: 800; padding: 3px 10px; border-radius: 99px; border: 1px solid #BFDBFE;">Real-time</span>
        </div>
        
        <form id="realtime-filter-form" action="{{ route('products.index') }}" method="GET" style="display: flex; flex-direction: column; gap: 1.5rem;">
            <!-- Search Input -->
            <div style="background: #F8FAFC; padding: 1rem; border-radius: 16px; border: 1.5px solid #E2E8F0;">
                <h4 style="font-weight: 900; color: #0F172A; margin: 0 0 0.6rem; font-size: 0.88rem; text-transform: uppercase; letter-spacing: 0.03em; display: flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-magnifying-glass" style="color: #2563EB;"></i> พิมพ์ค้นหาสินค้าอัตโนมัติ
                </h4>
                <div style="position: relative;">
                    <input type="text" id="realtime-q-input" name="q" value="{{ request('q') }}" placeholder="ค้นหา iPhone, Samsung, iPad..." 
                           style="width: 100%; padding: 10px 14px; border: 1.5px solid #93C5FD; border-radius: 12px; font-size: 0.88rem; font-family: inherit; outline: none; background: white; font-weight: 700; color: #0F172A;">
                </div>
            </div>

            <!-- Sorting Dropdown -->
            <div style="background: #F8FAFC; padding: 1rem; border-radius: 16px; border: 1.5px solid #E2E8F0;">
                <h4 style="font-weight: 900; color: #0F172A; margin: 0 0 0.6rem; font-size: 0.88rem; text-transform: uppercase; letter-spacing: 0.03em; display: flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-arrow-down-short-wide" style="color: #2563EB;"></i> เรียงลำดับตาม
                </h4>
                <select name="sort" class="auto-submit-trigger" style="width: 100%; padding: 9px 12px; border: 1.5px solid #93C5FD; border-radius: 12px; font-size: 0.88rem; font-weight: 700; color: #0F172A; outline: none; background: white; cursor: pointer; height: 42px;">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>✨ สินค้ามาใหม่ล่าสุด</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>💰 ราคา: ต่ำสุด - สูงสุด</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>💎 ราคา: สูงสุด - ต่ำสุด</option>
                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>🔤 ชื่อสินค้า (A - Z)</option>
                </select>
            </div>

            <!-- Brand Filter -->
            <div style="background: #F8FAFC; padding: 1rem; border-radius: 16px; border: 1.5px solid #E2E8F0;">
                <h4 style="font-weight: 900; color: #0F172A; margin: 0 0 0.6rem; font-size: 0.88rem; text-transform: uppercase; letter-spacing: 0.03em; display: flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-mobile-screen" style="color: #2563EB;"></i> แบรนด์สินค้า
                </h4>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    @foreach($brands as $brand)
                    @php
                        $brandChecked = is_array(request('brand_ids')) && in_array($brand->id, request('brand_ids')) || request('brand_id') == $brand->id;
                    @endphp
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 0.88rem; color: #0F172A; font-weight: 700;">
                        <input type="checkbox" name="brand_ids[]" value="{{ $brand->id }}" {{ $brandChecked ? 'checked' : '' }} class="auto-submit-trigger"
                               style="width: 16px; height: 16px; border: 1.5px solid #2563EB; border-radius: 4px; accent-color: #2563EB;">
                        <span>{{ $brand->name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- Category Filter -->
            <div style="background: #F8FAFC; padding: 1rem; border-radius: 16px; border: 1.5px solid #E2E8F0;">
                <h4 style="font-weight: 900; color: #0F172A; margin: 0 0 0.6rem; font-size: 0.88rem; text-transform: uppercase; letter-spacing: 0.03em; display: flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-layer-group" style="color: #2563EB;"></i> หมวดหมู่
                </h4>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    @foreach($categories as $category)
                    @php
                        $catChecked = is_array(request('category_ids')) && in_array($category->id, request('category_ids')) || request('category_id') == $category->id;
                    @endphp
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 0.88rem; color: #0F172A; font-weight: 700;">
                        <input type="checkbox" name="category_ids[]" value="{{ $category->id }}" {{ $catChecked ? 'checked' : '' }} class="auto-submit-trigger"
                               style="width: 16px; height: 16px; border: 1.5px solid #2563EB; border-radius: 4px; accent-color: #2563EB;">
                        <span>{{ $category->name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- Price Range Filter -->
            <div style="background: #F8FAFC; padding: 1rem; border-radius: 16px; border: 1.5px solid #E2E8F0;">
                <h4 style="font-weight: 900; color: #0F172A; margin: 0 0 0.6rem; font-size: 0.88rem; text-transform: uppercase; letter-spacing: 0.03em; display: flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-tag" style="color: #2563EB;"></i> ช่วงราคา (บาท)
                </h4>
                <div style="display: flex; gap: 8px; align-items: center;">
                    <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="ต่ำสุด" min="0" class="auto-submit-trigger"
                           style="width: 100%; padding: 8px 10px; border: 1.5px solid #93C5FD; border-radius: 10px; font-size: 0.85rem; outline: none; font-weight: 700; color: #0F172A;">
                    <span style="color: #64748B; font-weight: bold;">-</span>
                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="สูงสุด" min="0" class="auto-submit-trigger"
                           style="width: 100%; padding: 8px 10px; border: 1.5px solid #93C5FD; border-radius: 10px; font-size: 0.85rem; outline: none; font-weight: 700; color: #0F172A;">
                </div>
            </div>

            <!-- Special Discount Filter Toggle -->
            <div style="background: #EFF6FF; padding: 0.85rem 1rem; border-radius: 14px; border: 1.5px solid #BFDBFE;">
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 0.9rem; font-weight: 900; color: #1D4ED8;">
                    <input type="checkbox" name="on_sale" value="1" {{ request('on_sale') == '1' ? 'checked' : '' }} class="auto-submit-trigger"
                           style="width: 18px; height: 18px; border: 1.5px solid #2563EB; border-radius: 4px; accent-color: #2563EB;">
                    <span style="display: flex; align-items: center; gap: 4px;">
                        🔥 สินค้าโปรลดราคาพิเศษ
                    </span>
                </label>
            </div>

            <!-- Filter Reset Button -->
            <div style="display: flex; flex-direction: column; gap: 10px;">
                <a href="{{ route('products.index') }}" id="reset-filter-btn" style="display: block; text-align: center; padding: 10px; color: #EF4444; text-decoration: none; font-weight: 800; font-size: 0.88rem; border: 1.5px solid rgba(239, 68, 68, 0.3); border-radius: 99px;">
                    🔄 ล้างตัวกรองทั้งหมด
                </a>
            </div>

        </form>
    </aside>

    <!-- Main Content: Products Grid -->
    <main style="flex: 1 1 680px; min-width: 0; max-width: 100%;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; flex-wrap: wrap; gap: 12px; border-bottom: 2px solid #E2E8F0; padding-bottom: 0.75rem;">
            <div>
                <h2 style="font-size: 1.5rem; font-weight: 900; color: #0F172A; margin: 0; letter-spacing: -0.02em;">
                    สินค้าทั้งหมด
                </h2>
            </div>
            <span style="font-size: 0.82rem; color: #64748B; font-weight: 700;">
                พบ <span id="products-total-count" style="color: #0F172A; font-weight: 900;">{{ $products->total() }}</span> รายการ
            </span>
        </div>

        <!-- Product Grid Container for AJAX rendering -->
        <div id="product-grid-wrapper">
            @include('products.partials.product_grid')
        </div>

        <!-- Centered Pagination with Soft Design -->
        <div class="pagination-wrapper" style="margin-top: 2.5rem; display: flex; justify-content: center; width: 100%;">
            {!! $products->links()->toHtml() !!}
        </div>
    </main>

</div>

<script>
    function toggleMobileFilterModal() {
        const modal = document.getElementById('mobile-filter-modal');
        const backdrop = document.getElementById('mobile-filter-modal-backdrop');
        if (modal && backdrop) {
            if (modal.style.display === 'none' || modal.style.display === '') {
                backdrop.style.display = 'block';
                modal.style.display = 'block';
                setTimeout(() => { modal.style.bottom = '0'; }, 10);
            } else {
                modal.style.bottom = '-100%';
                setTimeout(() => {
                    modal.style.display = 'none';
                    backdrop.style.display = 'none';
                }, 350);
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('realtime-filter-form');
        const searchInput = document.getElementById('realtime-q-input');
        const gridWrapper = document.getElementById('product-grid-wrapper');
        const totalCountEl = document.getElementById('products-total-count');
        const paginationWrapper = document.querySelector('.pagination-wrapper');
        const resetBtn = document.getElementById('reset-filter-btn');

        let debounceTimer = null;

        function fetchProducts(url, updateUrlBar = true) {
            if (!gridWrapper) return;

            // Subtly dim grid while fetching (no layout shift or screen flash)
            gridWrapper.style.transition = 'opacity 0.2s ease';
            gridWrapper.style.opacity = '0.35';
            gridWrapper.style.pointerEvents = 'none';

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(res => {
                if (!res.ok) throw new Error('HTTP ' + res.status);
                return res.json();
            })
            .then(data => {
                if (data.html !== undefined && gridWrapper) {
                    gridWrapper.innerHTML = data.html;
                }
                if (data.total !== undefined && totalCountEl) {
                    totalCountEl.textContent = data.total;
                }
                if (data.pagination !== undefined && paginationWrapper) {
                    paginationWrapper.innerHTML = data.pagination;
                }
                if (updateUrlBar) {
                    history.pushState(null, '', url);
                }
                bindPaginationLinks();
            })
            .catch(err => {
                console.error('AJAX product search error:', err);
            })
            .finally(() => {
                if (gridWrapper) {
                    gridWrapper.style.opacity = '1';
                    gridWrapper.style.pointerEvents = 'auto';
                }
            });
        }

        function triggerFilterUpdate() {
            if (!form) return;
            const formData = new FormData(form);
            const params = new URLSearchParams();

            for (const [key, value] of formData.entries()) {
                if (value !== '') {
                    params.append(key, value);
                }
            }

            const actionUrl = form.getAttribute('action') || window.location.pathname;
            const fullUrl = actionUrl + (params.toString() ? '?' + params.toString() : '');

            fetchProducts(fullUrl);
        }

        // Prevent standard form submission
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                clearTimeout(debounceTimer);
                triggerFilterUpdate();
            });
        }

        // Real-time typed search (keeps input focus while typing)
        const mobileSearchInput = document.getElementById('mobile-realtime-q-input');
        [searchInput, mobileSearchInput].forEach(inp => {
            if (inp) {
                inp.addEventListener('input', function() {
                    if (inp === mobileSearchInput && searchInput) searchInput.value = inp.value;
                    if (inp === searchInput && mobileSearchInput) mobileSearchInput.value = inp.value;
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(triggerFilterUpdate, 300);
                });
            }
        });

        // Auto-trigger on checkbox & select & number inputs
        document.querySelectorAll('.auto-submit-trigger').forEach(input => {
            input.addEventListener('change', function() {
                clearTimeout(debounceTimer);
                triggerFilterUpdate();
            });
            if (input.type === 'number') {
                input.addEventListener('input', function() {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(triggerFilterUpdate, 450);
                });
            }
        });

        // Reset button handler
        if (resetBtn) {
            resetBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (form) form.reset();
                if (searchInput) searchInput.value = '';
                document.querySelectorAll('.auto-submit-trigger').forEach(el => {
                    if (el.type === 'checkbox') el.checked = false;
                    if (el.type === 'number') el.value = '';
                    if (el.tagName === 'SELECT') el.selectedIndex = 0;
                });
                fetchProducts(this.href);
            });
        }

        // Pagination click handler
        function bindPaginationLinks() {
            if (!paginationWrapper) return;
            paginationWrapper.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    fetchProducts(this.href);
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            });
        }

        bindPaginationLinks();

        // Browser Back/Forward buttons
        window.addEventListener('popstate', function() {
            fetchProducts(window.location.href, false);
        });
    });

    // Heart Pulse Animation Effect on Click
    function animateHeartBtn(btn) {
        btn.classList.add('heart-pop-anim');
        setTimeout(() => btn.classList.remove('heart-pop-anim'), 450);
    }

    // Basket Bounce Animation Effect on Click
    function animateBasketBtn(btn) {
        btn.classList.add('basket-bounce-anim');
        setTimeout(() => btn.classList.remove('basket-bounce-anim'), 450);
    }
</script>
@endsection

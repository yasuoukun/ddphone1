<!-- Sales & Product Intelligence Section -->
<div class="mt-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-extrabold text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-chart-line text-indigo-600"></i>
                วิเคราะห์ข้อมูลสินค้าและการตลาด (Product & Sales Intelligence)
            </h2>
            <p class="text-xs text-slate-500 mt-1">สรุปข้อมูลสินค้าขายดี สินค้ายอดนิยม สินค้าที่มีผู้สนใจเซฟไว้มากที่สุด และรายการแจ้งเตือนสต็อก</p>
        </div>
        <span class="text-xs font-bold bg-indigo-50 text-indigo-700 px-3 py-1.5 rounded-full border border-indigo-100 shadow-sm">
            <i class="fa-solid fa-arrows-rotate animate-spin text-indigo-500 mr-1"></i> Realtime Analytics
        </span>
    </div>

    <!-- Summary Stats Row (Wishlists, Reviews, Average Rating) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-br from-rose-50 to-pink-50/50 p-5 rounded-2xl border border-rose-100 flex items-center justify-between shadow-sm">
            <div>
                <p class="text-xs text-rose-600 font-bold uppercase tracking-wider">ลูกค้าถูกใจทั้งหมด (Wishlist)</p>
                <h3 class="text-2xl font-black text-rose-700 mt-1">{{ number_format($totalWishlistsCount) }} <span class="text-xs font-normal">ครั้ง</span></h3>
                <p class="text-[11px] text-rose-500 mt-1">❤️ สินค้าที่ถูกกดเซฟเป็นรายการโปรด</p>
            </div>
            <div class="w-12 h-12 bg-rose-500 text-white rounded-2xl flex items-center justify-center text-xl shadow-md">
                <i class="fa-solid fa-heart"></i>
            </div>
        </div>

        <div class="bg-gradient-to-br from-amber-50 to-orange-50/50 p-5 rounded-2xl border border-amber-100 flex items-center justify-between shadow-sm">
            <div>
                <p class="text-xs text-amber-600 font-bold uppercase tracking-wider">คะแนนรีวิวเฉลี่ย (Overall Rating)</p>
                <h3 class="text-2xl font-black text-amber-700 mt-1">{{ number_format($avgRating, 1) }} / 5.0</h3>
                <p class="text-[11px] text-amber-600 mt-1">⭐ จากผู้รีวิวทั้งหมด {{ number_format($totalReviewsCount) }} ท่าน</p>
            </div>
            <div class="w-12 h-12 bg-amber-500 text-white rounded-2xl flex items-center justify-center text-xl shadow-md">
                <i class="fa-solid fa-star"></i>
            </div>
        </div>

        <div class="bg-gradient-to-br from-sky-50 to-indigo-50/50 p-5 rounded-2xl border border-sky-100 flex items-center justify-between shadow-sm">
            <div>
                <p class="text-xs text-sky-600 font-bold uppercase tracking-wider">สินค้าเปิดขายในระบบ</p>
                <h3 class="text-2xl font-black text-sky-700 mt-1">{{ number_format($totalProducts ?? $productCount ?? 0) }} <span class="text-xs font-normal">รายการ</span></h3>
                <p class="text-[11px] text-sky-600 mt-1">📦 สถานะคลังพร้อมจัดส่งทั่วประเทศ</p>
            </div>
            <div class="w-12 h-12 bg-sky-600 text-white rounded-2xl flex items-center justify-center text-xl shadow-md">
                <i class="fa-solid fa-cubes"></i>
            </div>
        </div>
    </div>

    <!-- Grid 2x2: Top Selling, Most Wishlisted, Highest Rated, Low Stock -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Card 1: สินค้าขายดีที่สุด (Top Selling Products) -->
        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4 border-b border-gray-100 pb-3">
                    <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
                        <span class="w-8 h-8 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center text-sm font-black">🔥</span>
                        5 อันดับสินค้าขายดีที่สุด (Top Sellers)
                    </h3>
                    <span class="text-[11px] text-slate-400 font-medium">เรียงตามจำนวนชิ้นที่ขายได้</span>
                </div>
                <div class="space-y-3">
                    @forelse($topSellingProducts as $index => $item)
                        @php $prod = $item->product; @endphp
                        @if($prod)
                        <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-50/70 hover:bg-slate-100/80 transition border border-slate-100">
                            <div class="flex items-center gap-3 min-w-0">
                                <span class="w-6 h-6 rounded-lg text-xs font-black flex items-center justify-center flex-shrink-0 {{ $index === 0 ? 'bg-amber-400 text-amber-950 shadow-sm' : ($index === 1 ? 'bg-slate-300 text-slate-800' : ($index === 2 ? 'bg-amber-700 text-white' : 'bg-slate-200 text-slate-600')) }}">
                                    {{ $index + 1 }}
                                </span>
                                <img src="{{ $prod->primary_image_url }}" alt="" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?q=80&w=300&auto=format&fit=crop';" style="width: 44px; height: 44px; min-width: 44px; min-height: 44px; max-width: 44px; max-height: 44px; object-fit: cover; border-radius: 12px; border: 1px solid #E2E8F0; flex-shrink: 0;" class="bg-white shadow-sm">
                                <div class="min-w-0">
                                    <h4 class="font-bold text-xs text-slate-800 truncate" title="{{ $prod->name }}">{{ $prod->name }}</h4>
                                    <span class="text-[10px] text-slate-400 font-mono block">SKU: {{ $prod->sku ?: 'N/A' }}</span>
                                </div>
                            </div>
                            <div class="text-right flex-shrink-0 pl-3">
                                <span class="block font-black text-emerald-600 text-xs">{{ number_format($item->total_quantity) }} ชิ้น</span>
                                <span class="text-[10px] text-slate-400">฿{{ number_format($item->total_sales, 2) }}</span>
                            </div>
                        </div>
                        @endif
                    @empty
                        <div class="text-center py-8 text-slate-400 text-xs">
                            <i class="fa-solid fa-receipt text-2xl mb-2 text-slate-300"></i>
                            <p>ยังไม่มีข้อมูลยอดขายในขณะนี้</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Card 2: สินค้าที่กดถูกใจมากที่สุด (Most Wishlisted) -->
        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4 border-b border-gray-100 pb-3">
                    <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
                        <span class="w-8 h-8 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center text-sm font-black">❤️</span>
                        สินค้าที่ลูกค้ากดถูกใจมากที่สุด (Most Wishlisted)
                    </h3>
                    <span class="text-[11px] text-slate-400 font-medium">รายการโปรดของลูกค้า</span>
                </div>
                <div class="space-y-3">
                    @forelse($mostWishlistedProducts as $index => $item)
                        @php $prod = $item->product; @endphp
                        @if($prod)
                        <div class="flex items-center justify-between p-3 rounded-2xl bg-rose-50/30 hover:bg-rose-50/60 transition border border-rose-100/60">
                            <div class="flex items-center gap-3 min-w-0">
                                <span class="w-6 h-6 rounded-lg text-xs font-black bg-rose-100 text-rose-700 flex items-center justify-center flex-shrink-0">
                                    {{ $index + 1 }}
                                </span>
                                <img src="{{ $prod->primary_image_url }}" alt="" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?q=80&w=300&auto=format&fit=crop';" style="width: 44px; height: 44px; min-width: 44px; min-height: 44px; max-width: 44px; max-height: 44px; object-fit: cover; border-radius: 12px; border: 1px solid #E2E8F0; flex-shrink: 0;" class="bg-white shadow-sm">
                                <div class="min-w-0">
                                    <h4 class="font-bold text-xs text-slate-800 truncate" title="{{ $prod->name }}">{{ $prod->name }}</h4>
                                    <span class="text-[10px] text-rose-600 font-bold block">฿{{ number_format($prod->effective_price ?: $prod->price, 2) }}</span>
                                </div>
                            </div>
                            <div class="text-right flex-shrink-0 pl-3">
                                <span class="inline-flex items-center gap-1 font-black text-rose-600 text-xs bg-rose-100/80 px-2.5 py-1 rounded-full border border-rose-200">
                                    <i class="fa-solid fa-heart text-rose-500 text-[10px]"></i> {{ number_format($item->wishlist_count) }} คนถูกใจ
                                </span>
                            </div>
                        </div>
                        @endif
                    @empty
                        <div class="text-center py-8 text-slate-400 text-xs">
                            <i class="fa-solid fa-heart text-2xl mb-2 text-slate-300"></i>
                            <p>ยังไม่มีข้อมูลรายการโปรด</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Card 3: สินค้ารีวิวคะแนนสูงสุด (Highest Rated Products) -->
        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4 border-b border-gray-100 pb-3">
                    <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
                        <span class="w-8 h-8 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center text-sm font-black">⭐</span>
                        สินค้ารีวิวดีเยี่ยม / ยอดนิยม (Top Rated & Popular)
                    </h3>
                    <span class="text-[11px] text-slate-400 font-medium">คะแนนความพึงพอใจสูง</span>
                </div>
                <div class="space-y-3">
                    @forelse($topRatedProducts as $index => $prod)
                        <div class="flex items-center justify-between p-3 rounded-2xl bg-amber-50/30 hover:bg-amber-50/60 transition border border-amber-100/60">
                            <div class="flex items-center gap-3 min-w-0">
                                <span class="w-6 h-6 rounded-lg text-xs font-black bg-amber-100 text-amber-800 flex items-center justify-center flex-shrink-0">
                                    {{ $index + 1 }}
                                </span>
                                <img src="{{ $prod->primary_image_url }}" alt="" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?q=80&w=300&auto=format&fit=crop';" style="width: 44px; height: 44px; min-width: 44px; min-height: 44px; max-width: 44px; max-height: 44px; object-fit: cover; border-radius: 12px; border: 1px solid #E2E8F0; flex-shrink: 0;" class="bg-white shadow-sm">
                                <div class="min-w-0">
                                    <h4 class="font-bold text-xs text-slate-800 truncate" title="{{ $prod->name }}">{{ $prod->name }}</h4>
                                    <span class="text-[10px] text-slate-600 font-bold block">฿{{ number_format($prod->effective_price ?: $prod->price, 2) }}</span>
                                </div>
                            </div>
                            <div class="text-right flex-shrink-0 pl-3">
                                <div class="flex items-center justify-end gap-1 text-amber-500 text-xs font-black">
                                    <i class="fa-solid fa-star text-amber-400"></i>
                                    <span>{{ number_format($prod->reviews_avg_rating ?: 5.0, 1) }}</span>
                                </div>
                                <span class="text-[10px] text-slate-400 block">({{ $prod->reviews_count ?: 0 }} รีวิว)</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-slate-400 text-xs">
                            <i class="fa-solid fa-star text-2xl mb-2 text-slate-300"></i>
                            <p>ยังไม่มีข้อมูลรีวิว</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Card 4: แจ้งเตือนสินค้าสต็อกต่ำ (Low Stock Alert) -->
        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4 border-b border-gray-100 pb-3">
                    <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
                        <span class="w-8 h-8 rounded-xl bg-red-100 text-red-600 flex items-center justify-center text-sm font-black">⚠️</span>
                        แจ้งเตือนสินค้าสต็อกต่ำใกล้หมด (Low Stock Alert)
                    </h3>
                    <a href="{{ route('admin.stock.index') }}" class="text-[11px] font-bold text-indigo-600 hover:underline">
                        จัดการสต็อก ➔
                    </a>
                </div>
                <div class="space-y-3">
                    @forelse($lowStockProducts as $index => $prod)
                        <div class="flex items-center justify-between p-3 rounded-2xl bg-red-50/30 hover:bg-red-50/60 transition border border-red-100/60">
                            <div class="flex items-center gap-3 min-w-0">
                                <img src="{{ $prod->primary_image_url }}" alt="" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?q=80&w=300&auto=format&fit=crop';" style="width: 44px; height: 44px; min-width: 44px; min-height: 44px; max-width: 44px; max-height: 44px; object-fit: cover; border-radius: 12px; border: 1px solid #E2E8F0; flex-shrink: 0;" class="bg-white shadow-sm">
                                <div class="min-w-0">
                                    <h4 class="font-bold text-xs text-slate-800 truncate" title="{{ $prod->name }}">{{ $prod->name }}</h4>
                                    <span class="text-[10px] text-slate-400 font-mono block">SKU: {{ $prod->sku ?: 'N/A' }}</span>
                                </div>
                            </div>
                            <div class="text-right flex-shrink-0 pl-3">
                                <span class="inline-flex items-center gap-1 font-black text-red-700 text-xs bg-red-100 px-2.5 py-1 rounded-full border border-red-200">
                                    <i class="fa-solid fa-triangle-exclamation text-red-500 text-[10px]"></i> เหลือ {{ $prod->stock }} ชิ้น
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-emerald-600 text-xs">
                            <i class="fa-solid fa-circle-check text-2xl mb-2 text-emerald-400"></i>
                            <p class="font-bold">สินค้าทุกรายการมีสต็อกเพียงพอ (ไม่มีสินค้าวิกฤต)</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>

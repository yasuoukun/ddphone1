<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center justify-between">
            <span class="flex items-center gap-3">
                <!-- Back Button (Section 8.4) -->
                <a href="{{ route('central_admin.dashboard') }}" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-800 rounded-xl text-xs font-bold transition flex items-center gap-1 shadow-sm">
                    <i class="fa-solid fa-arrow-left"></i> กลับแดชบอร์ด
                </a>
                <i class="fa-solid fa-mobile-retro text-indigo-600"></i>
                จัดการสินค้าทั้งหมด
            </span>
            @if(auth()->user()->role === 'super_admin' || auth()->user()->role === 'admin')
            <a href="{{ route('central_admin.products.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold shadow-sm transition text-sm">
                <i class="fa-solid fa-plus"></i> เพิ่มสินค้าใหม่
            </a>
            @endif
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-r-lg shadow-sm flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-emerald-500 text-xl"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            @endif

            <x-real-time-filter table-id="productsTable" placeholder="ค้นหาชื่อสินค้า, SKU หรือรหัส ID..." count-label="สินค้า">
                <select id="rtf-productsTable-category" class="px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 text-sm font-semibold bg-white min-w-[160px]">
                    <option value="all">📁 ทุกหมวดหมู่</option>
                    @foreach(\App\Models\Category::all() as $cat)
                        <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
                <select id="rtf-productsTable-brand" class="px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 text-sm font-semibold bg-white min-w-[140px]">
                    <option value="all">🏷️ ทุกแบรนด์</option>
                    @foreach(\App\Models\Brand::all() as $brand)
                        <option value="{{ $brand->name }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
                <select id="rtf-productsTable-stock" class="px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 text-sm font-semibold bg-white min-w-[140px]">
                    <option value="all">📦 ทุกสถานะสต็อก</option>
                    <option value="instock">✅ มีสต็อก</option>
                    <option value="low">⚠️ ใกล้หมด</option>
                    <option value="outofstock">❌ หมดสต็อก</option>
                </select>
            </x-real-time-filter>

            <!-- Products Table (Section 8.3 & Section 8.4) -->
            <div class="bg-white md:overflow-hidden shadow-sm rounded-3xl border border-gray-100 md:overflow-x-auto">
                <table id="productsTable" class="w-full text-left border-collapse block md:table">
                    <thead class="hidden md:table-header-group">
                        <tr class="border-b border-gray-100 text-slate-500 text-xs font-semibold uppercase bg-slate-50/80">
                            <th class="py-4 px-4 text-center rounded-tl-xl">รูปภาพ</th>
                            <th class="py-4 px-4">ชื่อสินค้า</th>
                            <th class="py-4 px-4">หมวดหมู่</th>
                            <th class="py-4 px-4 text-right">ราคา</th>
                            <th class="py-4 px-4 text-center">เติมสต็อกสินค้า (Section 8.3)</th>
                            <th class="py-4 px-4 text-center rounded-tr-xl">จัดการสินค้า (Section 8.4)</th>
                        </tr>
                    </thead>
                    <tbody class="block md:table-row-group divide-y-0 md:divide-y divide-gray-50 bg-transparent md:bg-white space-y-4 md:space-y-0 p-4 md:p-0">
                        @forelse($products as $product)
                        @php
                            $stockStatus = $product->stock > 5 ? 'instock' : ($product->stock > 0 ? 'low' : 'outofstock');
                        @endphp
                        <tr class="hover:bg-indigo-50/30 transition-colors block md:table-row bg-white border border-gray-100 md:border-0 rounded-2xl md:rounded-none shadow-sm md:shadow-none p-4 md:p-0 relative"
                            x-data="{ expanded: false }"
                            data-searchable="{{ strtolower($product->name . ' ' . $product->sku . ' ' . $product->serial_number . ' ' . $product->id . ' ' . ($product->category->name ?? '') . ' ' . ($product->brand->name ?? '')) }}"
                            data-filter-category="{{ $product->category->name ?? '' }}"
                            data-filter-brand="{{ $product->brand->name ?? '' }}"
                            data-filter-stock="{{ $stockStatus }}">
                            
                            <td class="flex items-start md:items-center justify-between md:justify-center md:table-cell py-2 md:py-4 md:px-4 border-b border-gray-50 md:border-0">
                                <div class="flex items-center gap-3 md:justify-center w-full md:w-auto">
                                    @if($product->primary_image_url)
                                        <img src="{{ $product->primary_image_url }}" class="w-14 h-14 object-contain rounded-xl border border-gray-100 shadow-sm bg-white shrink-0">
                                    @else
                                        <div class="w-14 h-14 bg-amber-50 text-amber-500 rounded-xl flex items-center justify-center text-lg border border-amber-200 shadow-sm shrink-0" title="สินค้านี้ยังไม่มีรูปภาพ">
                                            <i class="fa-solid fa-image"></i>
                                        </div>
                                    @endif
                                    
                                    <!-- Mobile Only Title next to Image -->
                                    <div class="md:hidden flex-1 min-w-0">
                                        <div class="font-bold text-slate-800 text-sm truncate">{{ $product->name }}</div>
                                        <div class="text-xs text-slate-400 mt-0.5 flex flex-wrap items-center gap-1">
                                            <span>ID: {{ $product->id }}</span>
                                            @if($product->serial_number)
                                            <span class="bg-indigo-50 text-indigo-700 px-1.5 py-0.5 rounded text-[10px] font-mono font-semibold">S/N: {{ $product->serial_number }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="md:hidden shrink-0">
                                        <button @click="expanded = !expanded" class="w-8 h-8 flex items-center justify-center bg-gray-100 text-gray-600 rounded-full">
                                            <i class="fa-solid fa-chevron-down transition-transform duration-300" :class="expanded ? 'rotate-180' : ''"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            
                            <td class="hidden md:table-cell py-3 md:py-4 md:px-2 lg:px-4 border-b border-gray-50 md:border-0">
                                <div class="font-bold text-slate-800 md:text-sm lg:text-base flex items-center gap-2">
                                    <span>{{ $product->name }}</span>
                                    @if($product->images->count() === 0)
                                        <span class="inline-flex items-center gap-1 bg-rose-50 text-rose-700 border border-rose-200 px-2 py-0.5 rounded-full text-[10px] font-bold" title="สินค้านี้ยังไม่มีการอัปโหลดรูปภาพ">
                                            <i class="fa-solid fa-triangle-exclamation text-rose-500"></i> ยังไม่มีรูปภาพ
                                        </span>
                                    @endif
                                </div>
                                <div class="text-xs text-slate-400 mt-0.5 flex flex-wrap items-center gap-2">
                                    <span>ID: {{ $product->id }}</span>
                                    @if($product->sku)
                                    <span class="bg-slate-100 text-slate-700 px-1.5 py-0.5 rounded text-[11px] font-mono font-semibold">SKU: {{ $product->sku }}</span>
                                    @endif
                                    @if($product->serial_number)
                                    <span class="bg-indigo-50 text-indigo-700 border border-indigo-200 px-1.5 py-0.5 rounded text-[11px] font-mono font-semibold" title="หมายเลขซีเรียล S/N (เฉพาะแอดมินเห็น)">S/N: {{ $product->serial_number }}</span>
                                    @endif
                                </div>
                            </td>
                            
                            <td class="flex justify-between items-center md:table-cell py-3 md:py-4 md:px-4 border-b border-gray-50 md:border-0" :class="expanded ? 'flex' : 'hidden md:table-cell'">
                                <div class="text-[10px] text-slate-400 font-bold uppercase md:hidden">หมวดหมู่</div>
                                <span class="px-3 py-1 text-xs font-bold bg-blue-50 text-blue-700 rounded-full">
                                    {{ $product->category->name ?? 'ทั่วไป' }}
                                </span>
                            </td>
                            
                            <td class="flex justify-between items-center md:table-cell py-3 md:py-4 md:px-4 text-right border-b border-gray-50 md:border-0" :class="expanded ? 'flex' : 'hidden md:table-cell'">
                                <div class="text-[10px] text-slate-400 font-bold uppercase md:hidden">ราคา</div>
                                <div class="font-bold text-slate-800">
                                    @if($product->discount_price)
                                        <span class="text-rose-600 md:text-sm lg:text-base font-extrabold">฿{{ number_format($product->discount_price, 2) }}</span>
                                        <div class="text-xs text-slate-400 line-through font-normal inline-block md:block ml-2 md:ml-0">฿{{ number_format($product->price, 2) }}</div>
                                    @else
                                        <span class="md:text-sm lg:text-base font-extrabold">฿{{ number_format($product->price, 2) }}</span>
                                    @endif
                                </div>
                            </td>

                            <!-- Section 8.3: Restock Quick Form -->
                            <td class="block md:table-cell py-3 md:py-4 md:px-4 text-center border-b border-gray-50 md:border-0" :class="expanded ? 'block' : 'hidden md:table-cell'">
                                <div class="text-[10px] text-slate-400 font-bold uppercase mb-2 md:hidden">เติมสต็อกสินค้า</div>
                                <form action="{{ route('admin.stock.update') }}" method="POST" class="flex items-center justify-center md:justify-center gap-2">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="number" name="stock" value="{{ $product->stock }}" min="0" 
                                           class="w-20 px-2 py-1.5 border-2 {{ $product->stock <= 0 ? 'border-rose-400 bg-rose-50 text-rose-700' : 'border-gray-200' }} rounded-xl text-center font-bold text-sm focus:outline-none focus:border-indigo-500">
                                    <button type="submit" class="px-3 py-1.5 md:py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow-sm transition" title="อัปเดตสต็อกสินค้า">
                                        บันทึก
                                    </button>
                                </form>
                                <div class="text-[11px] mt-1.5 md:mt-1 font-bold {{ $product->stock <= 0 ? 'text-rose-600' : 'text-slate-400' }}">
                                    {{ $product->stock <= 0 ? '❌ หมดสต็อก' : 'คงเหลือ ' . $product->stock . ' ชิ้น' }}
                                </div>
                            </td>

                            <!-- Section 8.4: Action Buttons (Clear Edit & Delete) -->
                            <td class="block md:table-cell pt-3 pb-1 md:py-4 md:px-4 text-center" :class="expanded ? 'block' : 'hidden md:table-cell'">
                                <div class="flex items-center justify-center gap-2 w-full md:w-auto">
                                    <a href="{{ route('central_admin.products.edit', $product) }}" class="flex-1 md:flex-none inline-flex items-center justify-center gap-1.5 px-3 py-2 md:py-1.5 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl text-xs shadow-sm transition" title="แก้ไขสินค้า">
                                        <i class="fa-solid fa-pen-to-square"></i> แก้ไข
                                    </a>
                                    
                                    <form action="{{ route('central_admin.products.destroy', $product) }}" method="POST" class="flex-1 md:flex-none" onsubmit="return confirm('⚠️ ยืนยันการลบสินค้าชิ้นนี้ออกจากระบบ?')">
                                        @csrf @method("DELETE")
                                        <button type="submit" class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-2 md:py-1.5 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-xl text-xs shadow-sm transition" title="ลบสินค้า">
                                            <i class="fa-solid fa-trash-can"></i> ลบสินค้า
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr class="block md:table-row">
                            <td colspan="6" class="block md:table-cell py-16 text-center text-slate-400">
                                <i class="fa-solid fa-box-open text-4xl mb-3 block"></i>
                                ยังไม่มีข้อมูลสินค้าในระบบ
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            </div>
            <div class="mt-4">{{ $products->links() }}</div>
        </div>
    </div>
</x-app-layout>
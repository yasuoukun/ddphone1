<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class="fa-solid fa-boxes-stacked text-indigo-600"></i>
            จัดการสต๊อกสินค้าอย่างง่าย
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

            <x-real-time-filter table-id="stockTable" placeholder="ค้นหาชื่อสินค้า, SKU, ID..." count-label="สินค้า">
                <select id="rtf-stockTable-category" class="px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 text-sm font-semibold bg-white min-w-[160px]">
                    <option value="all">📂 ทุกหมวดหมู่</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
                <select id="rtf-stockTable-brand" class="px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 text-sm font-semibold bg-white min-w-[150px]">
                    <option value="all">🏷️ ทุกแบรนด์</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->name }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
                <select id="rtf-stockTable-stockstatus" class="px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 text-sm font-semibold bg-white min-w-[150px]">
                    <option value="all">📦 ทุกสถานะ</option>
                    <option value="ok">🟢 พร้อมส่ง</option>
                    <option value="low">⚠️ ใกล้หมด (&lt;5)</option>
                    <option value="out">🔴 หมดสต็อก</option>
                </select>
            </x-real-time-filter>

            <!-- Products Stock Table -->
            <div class="bg-white md:overflow-hidden shadow-sm rounded-3xl border border-gray-100 mb-6 md:overflow-x-auto">
                <table id="stockTable" class="w-full text-left border-collapse block md:table">
                    <thead class="hidden md:table-header-group">
                        <tr class="border-b border-gray-100 text-slate-500 text-xs font-semibold uppercase bg-slate-50/80">
                            <th class="py-4 px-5 rounded-tl-xl">สินค้า</th>
                            <th class="py-4 px-5">หมวดหมู่</th>
                            <th class="py-4 px-5">แบรนด์</th>
                            <th class="py-4 px-5 text-right">ราคา</th>
                            <th class="py-4 px-5 text-center">ระดับสต๊อกปัจจุบัน</th>
                            <th class="py-4 px-5 text-center rounded-tr-xl">แก้ไขสต๊อก</th>
                        </tr>
                    </thead>
                    <tbody class="block md:table-row-group divide-y-0 md:divide-y divide-gray-50 bg-transparent md:bg-white space-y-4 md:space-y-0 p-4 md:p-0">
                        @forelse($products as $product)
                        @php
                            $stockSt = $product->stock == 0 ? 'out' : ($product->stock < 5 ? 'low' : 'ok');
                        @endphp
                        <tr class="hover:bg-indigo-50/30 transition-colors block md:table-row bg-white border border-gray-100 md:border-0 rounded-2xl md:rounded-none shadow-sm md:shadow-none p-4 md:p-0 relative"
                            x-data="{ expanded: false }"
                            data-searchable="{{ strtolower($product->name . ' ' . $product->sku . ' ' . $product->serial_number . ' ' . ($product->category->name ?? '') . ' ' . ($product->brand->name ?? '') . ' ' . $product->id) }}"
                            data-filter-category="{{ $product->category->name ?? '' }}"
                            data-filter-brand="{{ $product->brand->name ?? '' }}"
                            data-filter-stockstatus="{{ $stockSt }}">
                            <!-- Product details & Image -->
                            <td class="flex items-start md:items-center justify-between md:table-cell py-2 md:py-4 md:px-5 border-b border-gray-50 md:border-0">
                                <div class="flex items-center gap-3 md:w-auto w-full">
                                    <div class="w-12 h-12 rounded-xl bg-gray-100 border border-gray-100 p-1 flex items-center justify-center overflow-hidden flex-shrink-0">
                                        @if($product->images->where('is_primary', true)->first())
                                            <img src="{{ str_starts_with($product->images->where('is_primary', true)->first()->image_path, 'http') ? $product->images->where('is_primary', true)->first()->image_path : Storage::url($product->images->where('is_primary', true)->first()->image_path) }}" alt="{{ $product->name }}" class="max-w-full max-h-full object-contain">
                                        @else
                                            <span class="text-gray-400 text-[10px]">No Image</span>
                                        @endif
                                    </div>
                                    <div class="flex-1 md:flex-none min-w-0">
                                        <div class="font-bold text-slate-800 text-sm line-clamp-1" title="{{ $product->name }}">
                                            {{ $product->name }}
                                        </div>
                                        <div class="text-[11px] text-gray-400 flex items-center gap-1.5 flex-wrap">
                                            <span>ID: {{ $product->id }}</span>
                                            @if($product->serial_number)
                                            <span class="bg-indigo-50 text-indigo-700 font-mono px-1.5 py-0.5 rounded text-[10px] font-semibold" title="หมายเลขซีเรียล (เฉพาะแอดมินเห็น)">S/N: {{ $product->serial_number }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="md:hidden shrink-0 ml-2">
                                        <button @click="expanded = !expanded" class="w-8 h-8 flex items-center justify-center bg-gray-100 text-gray-600 rounded-full">
                                            <i class="fa-solid fa-chevron-down transition-transform duration-300" :class="expanded ? 'rotate-180' : ''"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>

                            <!-- Category -->
                            <td class="flex justify-between items-center md:table-cell py-3 md:py-4 md:px-5 text-sm text-slate-600 font-medium border-b border-gray-50 md:border-0" :class="expanded ? 'flex' : 'hidden md:table-cell'">
                                <div class="text-[10px] text-slate-400 font-bold uppercase md:hidden">หมวดหมู่</div>
                                {{ $product->category->name ?? '-' }}
                            </td>

                            <!-- Brand -->
                            <td class="flex justify-between items-center md:table-cell py-3 md:py-4 md:px-5 text-sm text-slate-600 font-medium border-b border-gray-50 md:border-0" :class="expanded ? 'flex' : 'hidden md:table-cell'">
                                <div class="text-[10px] text-slate-400 font-bold uppercase md:hidden">แบรนด์</div>
                                {{ $product->brand->name ?? '-' }}
                            </td>

                            <!-- Price -->
                            <td class="flex justify-between items-center md:table-cell py-3 md:py-4 md:px-5 text-right font-bold text-slate-800 text-sm border-b border-gray-50 md:border-0" :class="expanded ? 'flex' : 'hidden md:table-cell'">
                                <div class="text-[10px] text-slate-400 font-bold uppercase md:hidden">ราคา</div>
                                @if($product->discount_price)
                                    <div>
                                        <span class="text-xs text-rose-500 line-through mr-2">฿{{ number_format($product->price, 2) }}</span>
                                        <span class="text-emerald-600">฿{{ number_format($product->discount_price, 2) }}</span>
                                    </div>
                                @else
                                    <span>฿{{ number_format($product->price, 2) }}</span>
                                @endif
                            </td>

                            <!-- Stock status -->
                            <td class="flex justify-between items-center md:table-cell py-3 md:py-4 md:px-5 text-center border-b border-gray-50 md:border-0" :class="expanded ? 'flex' : 'hidden md:table-cell'">
                                <div class="text-[10px] text-slate-400 font-bold uppercase md:hidden">ระดับสต๊อก</div>
                                @if($product->stock == 0)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800">
                                        🔴 หมดสต๊อก
                                    </span>
                                @elseif($product->stock < 5)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
                                        ⚠️ เหลือ {{ $product->stock }} ชิ้น
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                                        🟢 พร้อมส่ง {{ $product->stock }} ชิ้น
                                    </span>
                                @endif
                            </td>

                            <!-- Edit form -->
                            <td class="block md:table-cell py-3 md:py-4 md:px-5 text-center" :class="expanded ? 'block' : 'hidden md:table-cell'">
                                <div class="text-[10px] text-slate-400 font-bold uppercase mb-2 md:hidden">แก้ไขสต๊อก</div>
                                <form action="{{ route('admin.stock.update') }}" method="POST" class="flex items-center justify-center md:justify-center gap-1.5 max-w-[150px] mx-auto md:mx-auto">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="number" name="stock" value="{{ $product->stock }}" min="0" required
                                           class="w-20 text-center rounded-lg border-gray-300 py-1.5 md:py-1 text-sm font-semibold focus:ring-indigo-200">
                                    <button type="submit" class="bg-indigo-600 text-white p-2 md:p-1.5 rounded-lg hover:bg-indigo-700 transition" title="บันทึก">
                                        <i class="fa-solid fa-floppy-disk text-xs"></i> บันทึก
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr class="block md:table-row">
                            <td colspan="6" class="block md:table-cell py-16 text-center text-slate-400">
                                <i class="fa-solid fa-box-open text-4xl mb-3 block"></i>
                                ไม่พบสินค้าตามที่ค้นหา
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $products->links() }}
            </div>

        </div>
    </div>
</x-app-layout>

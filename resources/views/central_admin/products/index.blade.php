<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center justify-between">
            <span class="flex items-center gap-2">
                <i class="fa-solid fa-mobile-retro text-indigo-600"></i>
                จัดการสินค้าทั้งหมด
            </span>
            @if(auth()->user()->role === 'super_admin')
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

            <!-- Products Table -->
            <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-gray-100">
                <div class="overflow-x-auto">
                    <table id="productsTable" class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 text-slate-500 text-xs font-semibold uppercase bg-slate-50/80">
                                <th class="py-4 px-4 text-center rounded-tl-xl">รูปภาพ</th>
                                <th class="py-4 px-4">ชื่อสินค้า</th>
                                <th class="py-4 px-4">หมวดหมู่</th>
                                <th class="py-4 px-4">แบรนด์</th>
                                <th class="py-4 px-4 text-right">ราคา</th>
                                <th class="py-4 px-4 text-center">สต็อก</th>
                                <th class="py-4 px-4 text-center rounded-tr-xl">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($products as $product)
                            @php
                                $stockStatus = $product->stock > 5 ? 'instock' : ($product->stock > 0 ? 'low' : 'outofstock');
                            @endphp
                            <tr class="hover:bg-indigo-50/30 transition-colors"
                                data-searchable="{{ strtolower($product->name . ' ' . $product->sku . ' ' . $product->id . ' ' . ($product->category->name ?? '') . ' ' . ($product->brand->name ?? '')) }}"
                                data-filter-category="{{ $product->category->name ?? '' }}"
                                data-filter-brand="{{ $product->brand->name ?? '' }}"
                                data-filter-stock="{{ $stockStatus }}">
                                <td class="py-4 px-4 flex justify-center">
                                    @if($product->images->where('is_primary', true)->first())
                                        @php $primaryImgPath = $product->images->where('is_primary', true)->first()->image_path; @endphp
                                        @if(str_starts_with($primaryImgPath, 'http'))
                                            <img src="{{ $primaryImgPath }}" class="w-14 h-14 object-contain rounded-xl border border-gray-100 shadow-sm bg-white">
                                        @else
                                            <img src="{{ Storage::url($primaryImgPath) }}" class="w-14 h-14 object-contain rounded-xl border border-gray-100 shadow-sm bg-white">
                                        @endif
                                    @else
                                        <div class="w-14 h-14 bg-slate-100 text-slate-400 rounded-xl flex items-center justify-center text-lg border border-gray-50">
                                            <i class="fa-solid fa-image"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    <div class="font-bold text-slate-800">{{ $product->name }}</div>
                                    <div class="text-xs text-slate-400 mt-0.5 flex items-center gap-2">
                                        <span>ID: {{ $product->id }}</span>
                                        @if($product->sku)
                                        <span class="bg-slate-100 text-slate-700 px-1.5 py-0.5 rounded text-[11px] font-mono font-semibold">SKU: {{ $product->sku }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="px-3 py-1 text-xs font-semibold bg-blue-50 text-blue-700 rounded-full">
                                        {{ $product->category->name ?? 'ทั่วไป' }}
                                    </span>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="px-3 py-1 text-xs font-semibold bg-purple-50 text-purple-700 rounded-full">
                                        {{ $product->brand->name ?? 'ทั่วไป' }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-right">
                                    <div class="font-bold text-slate-800">
                                        @if($product->discount_price)
                                            <span class="text-rose-600">฿{{ number_format($product->discount_price, 2) }}</span>
                                            <div class="text-xs text-slate-400 line-through font-normal">฿{{ number_format($product->price, 2) }}</div>
                                        @else
                                            <span>฿{{ number_format($product->price, 2) }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    @if($product->stock > 5)
                                        <span class="px-2.5 py-1 text-xs font-bold bg-emerald-50 text-emerald-700 rounded-lg">{{ $product->stock }} ชิ้น</span>
                                    @elseif($product->stock > 0)
                                        <span class="px-2.5 py-1 text-xs font-bold bg-amber-50 text-amber-700 rounded-lg">ใกล้หมด ({{ $product->stock }})</span>
                                    @else
                                        <span class="px-2.5 py-1 text-xs font-bold bg-rose-50 text-rose-700 rounded-lg">หมดสต็อก</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('central_admin.products.edit', $product) }}" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition" title="แก้ไข">
                                            <i class="fa-solid fa-pen-to-square text-lg"></i>
                                        </a>
                                        <form action="{{ route('central_admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('ยืนยันการลบสินค้าชิ้นนี้?')">
                                            @csrf @method("DELETE")
                                            <button type="submit" class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition" title="ลบ">
                                                <i class="fa-solid fa-trash-can text-lg"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="py-16 text-center text-slate-400">
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
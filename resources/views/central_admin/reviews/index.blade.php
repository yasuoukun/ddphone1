<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('จัดการรีวิวสินค้าจากลูกค้า') }}
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

            <x-real-time-filter table-id="reviewsTable" placeholder="ค้นหาชื่อลูกค้า, ชื่อสินค้า หรือความคิดเห็น..." count-label="รีวิว">
                <select id="rtf-reviewsTable-product" class="px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 text-sm font-semibold bg-white min-w-[220px]">
                    <option value="all">📱 ทุกรุ่นสินค้า</option>
                    @foreach($products as $prod)
                        <option value="{{ $prod->name }}">{{ $prod->name }}</option>
                    @endforeach
                </select>
                <select id="rtf-reviewsTable-rating" class="px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 text-sm font-semibold bg-white min-w-[150px]">
                    <option value="all">⭐ ทุกคะแนน</option>
                    <option value="5">⭐⭐⭐⭐⭐ 5 ดาว</option>
                    <option value="4">⭐⭐⭐⭐ 4 ดาว</option>
                    <option value="3">⭐⭐⭐ 3 ดาว</option>
                    <option value="2">⭐⭐ 2 ดาว</option>
                    <option value="1">⭐ 1 ดาว</option>
                </select>
            </x-real-time-filter>

            <div class="bg-white md:overflow-hidden shadow-sm rounded-3xl border border-gray-100 md:overflow-x-auto">
                <table id="reviewsTable" class="w-full text-left border-collapse block md:table">
                    <thead class="hidden md:table-header-group">
                        <tr class="border-b border-gray-100 text-slate-500 text-xs font-semibold uppercase bg-slate-50/80">
                            <th class="py-4 px-4 rounded-tl-xl">สินค้า</th>
                            <th class="py-4 px-4">ลูกค้า</th>
                            <th class="py-4 px-4 text-center">คะแนน</th>
                            <th class="py-4 px-4">ความคิดเห็น</th>
                            <th class="py-4 px-4 text-center">วันที่</th>
                            <th class="py-4 px-4 text-center rounded-tr-xl">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="block md:table-row-group divide-y-0 md:divide-y divide-gray-50 bg-transparent md:bg-white space-y-4 md:space-y-0 p-4 md:p-0">
                        @forelse($reviews as $review)
                        <tr class="hover:bg-slate-50/50 transition-colors block md:table-row bg-white border border-gray-100 md:border-0 rounded-2xl md:rounded-none shadow-sm md:shadow-none p-4 md:p-0 relative"
                            x-data="{ expanded: false }"
                            data-searchable="{{ strtolower(($review->user->name ?? '') . ' ' . ($review->product->name ?? '') . ' ' . $review->comment) }}"
                            data-filter-product="{{ $review->product->name ?? '' }}"
                            data-filter-rating="{{ $review->rating }}">
                            
                            <td class="flex justify-between items-start md:table-cell py-2 md:py-4 md:px-4 border-b border-gray-50 md:border-0">
                                <div class="flex-1 md:flex-none">
                                    <div class="text-[10px] text-slate-400 font-bold uppercase mb-1 md:hidden">สินค้า</div>
                                    <a href="{{ route('products.show', $review->product_id) }}" target="_blank" class="text-indigo-600 hover:underline font-semibold text-sm block pr-2">
                                        {{ $review->product->name ?? 'สินค้าถูกลบ' }}
                                    </a>
                                </div>
                                <div class="md:hidden mt-4 shrink-0">
                                    <button @click="expanded = !expanded" class="w-8 h-8 flex items-center justify-center bg-gray-100 text-gray-600 rounded-full">
                                        <i class="fa-solid fa-chevron-down transition-transform duration-300" :class="expanded ? 'rotate-180' : ''"></i>
                                    </button>
                                </div>
                            </td>
                            
                            <td class="block md:table-cell py-3 md:py-4 md:px-4 border-b border-gray-50 md:border-0" :class="expanded ? 'block' : 'hidden md:table-cell'">
                                <div class="text-[10px] text-slate-400 font-bold uppercase mb-1 md:hidden">ลูกค้า</div>
                                <div class="font-semibold text-slate-800 text-sm">{{ $review->user->name ?? 'ลูกค้าทั่วไป' }}</div>
                                <div class="text-xs text-slate-400">{{ $review->user->email ?? '' }}</div>
                            </td>
                            
                            <td class="flex justify-between items-center md:table-cell py-3 md:py-4 md:px-4 text-center border-b border-gray-50 md:border-0" :class="expanded ? 'flex' : 'hidden md:table-cell'">
                                <div class="text-[10px] text-slate-400 font-bold uppercase md:hidden">คะแนน</div>
                                <div class="flex items-center md:justify-center gap-1 text-amber-400 text-base">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fa-{{ $i <= $review->rating ? 'solid' : 'regular' }} fa-star text-sm"></i>
                                    @endfor
                                    <span class="text-[11px] text-slate-400 font-semibold ml-1">{{ $review->rating }}/5</span>
                                </div>
                            </td>
                            
                            <td class="block md:table-cell py-3 md:py-4 md:px-4 text-slate-600 text-sm max-w-xs md:max-w-xs w-full border-b border-gray-50 md:border-0" :class="expanded ? 'block' : 'hidden md:table-cell'">
                                <div class="text-[10px] text-slate-400 font-bold uppercase mb-1 md:hidden">ความคิดเห็น</div>
                                <p class="md:truncate md:w-auto w-full break-words" title="{{ $review->comment }}">{{ $review->comment ?: '—' }}</p>
                            </td>
                            
                            <td class="flex justify-between items-center md:table-cell py-3 md:py-4 md:px-4 text-center text-xs text-slate-500 border-b border-gray-50 md:border-0" :class="expanded ? 'flex' : 'hidden md:table-cell'">
                                <div class="text-[10px] text-slate-400 font-bold uppercase md:hidden">วันที่</div>
                                {{ $review->created_at->format('d/m/Y') }}
                            </td>
                            
                            <td class="block md:table-cell py-3 md:py-4 md:px-4 text-center border-b border-gray-50 md:border-0" :class="expanded ? 'block' : 'hidden md:table-cell'">
                                <div class="text-[10px] text-slate-400 font-bold uppercase mb-2 md:hidden">จัดการ</div>
                                <form action="{{ route('central_admin.reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('ยืนยันที่จะลบรีวิวนี้หรือไม่?');" class="w-full md:w-auto">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center gap-1.5 px-3 py-2 md:py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs font-bold rounded-xl transition w-full md:w-auto">
                                        <i class="fa-solid fa-trash-can"></i> ลบรีวิว
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr class="block md:table-row">
                            <td colspan="6" class="block md:table-cell py-14 text-center text-slate-400 italic">ยังไม่มีรีวิวสินค้าจากลูกค้าในขณะนี้</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>

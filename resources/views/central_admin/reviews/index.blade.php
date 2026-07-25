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

            <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-gray-100">
                <div class="overflow-x-auto">
                    <table id="reviewsTable" class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 text-slate-500 text-xs font-semibold uppercase bg-slate-50/80">
                                <th class="py-4 px-4 rounded-tl-xl">สินค้า</th>
                                <th class="py-4 px-4">ลูกค้า</th>
                                <th class="py-4 px-4 text-center">คะแนน</th>
                                <th class="py-4 px-4">ความคิดเห็น</th>
                                <th class="py-4 px-4 text-center">วันที่</th>
                                <th class="py-4 px-4 text-center rounded-tr-xl">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($reviews as $review)
                            <tr class="hover:bg-slate-50/50 transition-colors"
                                data-searchable="{{ strtolower(($review->user->name ?? '') . ' ' . ($review->product->name ?? '') . ' ' . $review->comment) }}"
                                data-filter-product="{{ $review->product->name ?? '' }}"
                                data-filter-rating="{{ $review->rating }}">
                                <td class="py-4 px-4">
                                    <a href="{{ route('products.show', $review->product_id) }}" target="_blank" class="text-indigo-600 hover:underline font-semibold text-sm">
                                        {{ $review->product->name ?? 'สินค้าถูกลบ' }}
                                    </a>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="font-semibold text-slate-800 text-sm">{{ $review->user->name ?? 'ลูกค้าทั่วไป' }}</div>
                                    <div class="text-xs text-slate-400">{{ $review->user->email ?? '' }}</div>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <div class="flex items-center justify-center gap-0.5 text-amber-400 text-base">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fa-{{ $i <= $review->rating ? 'solid' : 'regular' }} fa-star text-sm"></i>
                                        @endfor
                                    </div>
                                    <span class="text-[11px] text-slate-400 font-semibold">{{ $review->rating }}/5</span>
                                </td>
                                <td class="py-4 px-4 text-slate-600 text-sm max-w-xs">
                                    <p class="truncate" title="{{ $review->comment }}">{{ $review->comment ?: '—' }}</p>
                                </td>
                                <td class="py-4 px-4 text-center text-xs text-slate-500">
                                    {{ $review->created_at->format('d/m/Y') }}
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <form action="{{ route('central_admin.reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('ยืนยันที่จะลบรีวิวนี้หรือไม่?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs font-bold rounded-xl transition">
                                            <i class="fa-solid fa-trash-can"></i> ลบรีวิว
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="py-14 text-center text-slate-400 italic">ยังไม่มีรีวิวสินค้าจากลูกค้าในขณะนี้</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center justify-between">
            <span class="flex items-center gap-2">
                <i class="fa-solid fa-ticket text-indigo-600"></i>
                จัดการคูปองส่วนลด
            </span>
            <a href="{{ route('central_admin.coupons.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold shadow-sm transition text-sm">
                <i class="fa-solid fa-plus"></i> สร้างคูปองใหม่
            </a>
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50/50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-r-lg shadow-sm flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-emerald-500 text-xl"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            @endif

            <x-real-time-filter table-id="couponsTable" placeholder="ค้นหารหัสคูปอง..." count-label="คูปอง">
                <select id="rtf-couponsTable-status" class="px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 text-sm font-semibold bg-white min-w-[160px]">
                    <option value="all">🎫 ทุกสถานะ</option>
                    <option value="active">✅ ยังใช้งานได้</option>
                    <option value="expired">❌ หมดอายุแล้ว</option>
                </select>
            </x-real-time-filter>

            <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-gray-100">
                <div class="overflow-x-auto">
                    <table id="couponsTable" class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 text-slate-500 text-xs font-semibold uppercase bg-slate-50/80">
                                <th class="py-4 px-5 rounded-tl-xl">รหัสคูปอง</th>
                                <th class="py-4 px-5 text-center">ส่วนลด</th>
                                <th class="py-4 px-5 text-center">วันหมดอายุ</th>
                                <th class="py-4 px-5 text-center">สถานะ</th>
                                <th class="py-4 px-5 text-center rounded-tr-xl">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($coupons as $coupon)
                            @php
                                $isExpired = \Carbon\Carbon::parse($coupon->expires_at)->isPast();
                            @endphp
                            <tr class="hover:bg-indigo-50/30 transition-colors"
                                data-searchable="{{ strtolower($coupon->code) }}"
                                data-filter-status="{{ $isExpired ? 'expired' : 'active' }}">
                                <td class="py-4 px-5">
                                    <div class="flex items-center gap-3">
                                        <div class="bg-indigo-50 text-indigo-700 px-3 py-1.5 rounded-xl font-mono font-bold text-sm tracking-wider">
                                            {{ $coupon->code }}
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-5 text-center">
                                    <span class="font-bold text-rose-600 text-base">฿{{ number_format($coupon->discount_amount, 2) }}</span>
                                </td>
                                <td class="py-4 px-5 text-center text-sm text-slate-500">
                                    {{ \Carbon\Carbon::parse($coupon->expires_at)->format('d/m/Y') }}
                                </td>
                                <td class="py-4 px-5 text-center">
                                    @if($isExpired)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700">❌ หมดอายุ</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">✅ ใช้งานได้</span>
                                    @endif
                                </td>
                                <td class="py-4 px-5 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('central_admin.coupons.edit', $coupon) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 rounded-xl transition">
                                            <i class="fa-solid fa-pen-to-square"></i> แก้ไข
                                        </a>
                                        <form action="{{ route('central_admin.coupons.destroy', $coupon) }}" method="POST" class="inline" onsubmit="return confirm('ยืนยันการลบคูปอง {{ $coupon->code }}?')">
                                            @csrf @method("DELETE")
                                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-rose-600 bg-rose-50 hover:bg-rose-100 rounded-xl transition">
                                                <i class="fa-solid fa-trash-can"></i> ลบ
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="py-14 text-center text-slate-400"><i class="fa-solid fa-ticket text-4xl mb-2 block text-slate-300"></i>ยังไม่มีคูปองส่วนลดในระบบ</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

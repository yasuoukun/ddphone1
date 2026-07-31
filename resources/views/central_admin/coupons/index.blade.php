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

            <div class="bg-white md:overflow-hidden shadow-sm rounded-3xl border border-gray-100 md:overflow-x-auto">
                <table id="couponsTable" class="w-full text-left border-collapse block md:table">
                    <thead class="hidden md:table-header-group">
                        <tr class="border-b border-gray-100 text-slate-500 text-xs font-semibold uppercase bg-slate-50/80">
                            <th class="py-4 px-5 rounded-tl-xl">รหัสคูปอง</th>
                            <th class="py-4 px-5 text-center">ส่วนลด</th>
                            <th class="py-4 px-5 text-center">วันหมดอายุ</th>
                            <th class="py-4 px-5 text-center">สถานะ</th>
                            <th class="py-4 px-5 text-center rounded-tr-xl">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="block md:table-row-group divide-y-0 md:divide-y divide-gray-50 bg-transparent md:bg-white space-y-4 md:space-y-0 p-4 md:p-0">
                        @forelse($coupons as $coupon)
                        @php
                            $isExpired = \Carbon\Carbon::parse($coupon->expires_at)->isPast();
                        @endphp
                        <tr class="hover:bg-indigo-50/30 transition-colors block md:table-row bg-white border border-gray-100 md:border-0 rounded-2xl md:rounded-none shadow-sm md:shadow-none p-4 md:p-0 relative"
                            x-data="{ expanded: false }"
                            data-searchable="{{ strtolower($coupon->code) }}"
                            data-filter-status="{{ $isExpired ? 'expired' : 'active' }}">
                            
                            <td class="flex items-center justify-between md:table-cell py-2 md:py-4 md:px-5 border-b border-gray-50 md:border-0">
                                <div class="flex items-center gap-3">
                                    <div class="bg-indigo-50 text-indigo-700 px-3 py-1.5 rounded-xl font-mono font-bold text-sm tracking-wider">
                                        {{ $coupon->code }}
                                    </div>
                                </div>
                                <div class="md:hidden">
                                    <button @click="expanded = !expanded" class="w-8 h-8 flex items-center justify-center bg-gray-100 text-gray-600 rounded-full">
                                        <i class="fa-solid fa-chevron-down transition-transform duration-300" :class="expanded ? 'rotate-180' : ''"></i>
                                    </button>
                                </div>
                            </td>
                            
                            <td class="flex justify-between items-center md:table-cell py-3 md:py-4 md:px-5 text-center border-b border-gray-50 md:border-0" :class="expanded ? 'flex' : 'hidden md:table-cell'">
                                <div class="text-[10px] text-slate-400 font-bold uppercase md:hidden">ส่วนลด</div>
                                <span class="font-bold text-rose-600 text-base">฿{{ number_format($coupon->discount_amount, 2) }}</span>
                            </td>
                            
                            <td class="flex justify-between items-center md:table-cell py-3 md:py-4 md:px-5 text-center text-sm text-slate-500 border-b border-gray-50 md:border-0" :class="expanded ? 'flex' : 'hidden md:table-cell'">
                                <div class="text-[10px] text-slate-400 font-bold uppercase md:hidden">วันหมดอายุ</div>
                                {{ \Carbon\Carbon::parse($coupon->expires_at)->format('d/m/Y') }}
                            </td>
                            
                            <td class="flex justify-between items-center md:table-cell py-3 md:py-4 md:px-5 text-center border-b border-gray-50 md:border-0" :class="expanded ? 'flex' : 'hidden md:table-cell'">
                                <div class="text-[10px] text-slate-400 font-bold uppercase md:hidden">สถานะ</div>
                                @if($isExpired)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700">❌ หมดอายุ</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">✅ ใช้งานได้</span>
                                @endif
                            </td>
                            
                            <td class="block md:table-cell py-3 md:py-4 md:px-5 text-center border-b border-gray-50 md:border-0" :class="expanded ? 'block' : 'hidden md:table-cell'">
                                <div class="text-[10px] text-slate-400 font-bold uppercase mb-2 md:hidden">จัดการ</div>
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('central_admin.coupons.edit', $coupon) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 rounded-xl transition w-full md:w-auto justify-center">
                                        <i class="fa-solid fa-pen-to-square"></i> แก้ไข
                                    </a>
                                    <form action="{{ route('central_admin.coupons.destroy', $coupon) }}" method="POST" class="inline w-full md:w-auto" onsubmit="return confirm('ยืนยันการลบคูปอง {{ $coupon->code }}?')">
                                        @csrf @method("DELETE")
                                        <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-rose-600 bg-rose-50 hover:bg-rose-100 rounded-xl transition w-full md:w-auto justify-center">
                                            <i class="fa-solid fa-trash-can"></i> ลบ
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr class="block md:table-row">
                            <td colspan="5" class="block md:table-cell py-14 text-center text-slate-400">
                                <i class="fa-solid fa-ticket text-4xl mb-2 block text-slate-300"></i>ยังไม่มีคูปองส่วนลดในระบบ
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class="fa-solid fa-wrench text-indigo-600"></i>
            จัดการการเคลมและงานซ่อมทั้งหมด
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

            <x-real-time-filter table-id="claimsTable" placeholder="ค้นหาชื่อลูกค้า รหัสเคลม อุปกรณ์..." count-label="รายการเคลม">
                <select id="rtf-claimsTable-status" class="px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 text-sm font-semibold bg-white min-w-[180px]">
                    <option value="all">📋 ทุกสถานะ</option>
                    <option value="pending">⏳ รอตรวจสอบ (ใหม่)</option>
                    <option value="pending_assessment">🔍 รอประเมิน</option>
                    <option value="quoted">💬 แจ้งราคาแล้ว รอลูกค้ายืนยัน</option>
                    <option value="confirmed_waiting_device">📬 ลูกค้ายืนยัน รอรับเครื่อง</option>
                    <option value="device_received">📦 รับเครื่องแล้ว</option>
                    <option value="in_repair">🛠️ กำลังซ่อม</option>
                    <option value="repaired_waiting_payment">✅ ซ่อมเสร็จ รอชำระ</option>
                    <option value="return_shipped">🚚 จัดส่งคืนแล้ว</option>
                    <option value="completed">🏁 เสร็จสมบูรณ์</option>
                    <option value="cancelled">❌ ยกเลิก</option>
                </select>
                <select id="rtf-claimsTable-claimtype" class="px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 text-sm font-semibold bg-white min-w-[180px]">
                    <option value="all">🔧 ทุกประเภทงาน</option>
                    <option value="warranty">🛡️ เคลมประกันศูนย์</option>
                    <option value="repair">🔧 ส่งซ่อมทั่วไป</option>
                    <option value="service">⚙️ ตั้งค่า/ลงโปรแกรม</option>
                </select>
            </x-real-time-filter>

            <div class="bg-white md:overflow-hidden shadow-sm rounded-3xl border border-gray-100 md:overflow-x-auto">
                <table id="claimsTable" class="w-full text-left border-collapse block md:table">
                    <thead class="hidden md:table-header-group">
                        <tr class="border-b border-gray-100 text-slate-500 text-xs font-semibold uppercase bg-slate-50/80">
                            <th class="py-4 px-5 rounded-tl-xl">รหัสเคลม</th>
                            <th class="py-4 px-5">ผู้แจ้ง / เบอร์โทร</th>
                            <th class="py-4 px-5">อุปกรณ์</th>
                            <th class="py-4 px-5">ประเภทงาน</th>
                            <th class="py-4 px-5 text-center">สถานะ</th>
                            <th class="py-4 px-5">วันที่แจ้ง</th>
                            <th class="py-4 px-5 text-center rounded-tr-xl">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="block md:table-row-group divide-y-0 md:divide-y divide-gray-50 bg-transparent md:bg-white space-y-4 md:space-y-0 p-4 md:p-0">
                        @forelse($claims as $claim)
                        @php
                            $isActionNeeded = in_array($claim->status, ['pending', 'confirmed_waiting_device']);
                        @endphp
                        <tr class="hover:bg-indigo-50/30 transition-colors block md:table-row rounded-2xl md:rounded-none shadow-sm md:shadow-none p-4 md:p-0 relative
                            {{ $isActionNeeded 
                                ? 'bg-orange-50 border-2 border-orange-200 md:border-0 md:bg-orange-50/40' 
                                : 'bg-white border border-gray-100 md:border-0' }}"
                            x-data="{ expanded: false }"
                            data-searchable="{{ strtolower($claim->customer_name . ' ' . $claim->customer_phone . ' ' . $claim->device_name . ' ' . $claim->id) }}"
                            data-filter-status="{{ $claim->status }}"
                            data-filter-claimtype="{{ $claim->claim_type }}">
                            
                            <td class="flex justify-between items-center md:table-cell py-2 md:py-4 md:px-5 border-b border-gray-50 md:border-0">
                                <div class="font-bold text-slate-800 text-sm">
                                    <div class="text-[10px] text-slate-400 font-bold uppercase md:hidden mb-1">รหัสเคลม</div>
                                    <div class="flex items-center gap-2">
                                        <span>{{ $claim->id }}</span>
                                        @if($claim->status === 'pending')
                                            <span class="inline-flex items-center gap-1 bg-orange-100 text-orange-700 border border-orange-300 px-2 py-0.5 rounded-full text-[10px] font-extrabold animate-pulse">
                                                <span class="w-1.5 h-1.5 bg-orange-500 rounded-full"></span> ใหม่!
                                            </span>
                                        @elseif($claim->status === 'confirmed_waiting_device')
                                            <span class="inline-flex items-center gap-1 bg-blue-100 text-blue-700 border border-blue-300 px-2 py-0.5 rounded-full text-[10px] font-extrabold">
                                                <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span> รอรับเครื่อง
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="md:hidden mt-2">
                                    <button @click="expanded = !expanded" class="w-8 h-8 flex items-center justify-center bg-gray-100 text-gray-600 rounded-full">
                                        <i class="fa-solid fa-chevron-down transition-transform duration-300" :class="expanded ? 'rotate-180' : ''"></i>
                                    </button>
                                </div>
                            </td>
                            
                            <td class="block md:table-cell py-3 md:py-4 md:px-5 text-sm border-b border-gray-50 md:border-0" :class="expanded ? 'block' : 'hidden md:table-cell'">
                                <div class="text-[10px] text-slate-400 font-bold uppercase md:hidden mb-1">ผู้แจ้ง / เบอร์โทร</div>
                                <div class="font-semibold text-slate-800">{{ $claim->customer_name }}</div>
                                <div class="text-xs text-slate-400"><i class="fa-solid fa-phone text-[10px]"></i> {{ $claim->customer_phone }}</div>
                            </td>
                            
                            <td class="flex justify-between items-center md:table-cell py-3 md:py-4 md:px-5 text-sm font-medium text-slate-700 border-b border-gray-50 md:border-0" :class="expanded ? 'flex' : 'hidden md:table-cell'">
                                <div class="text-[10px] text-slate-400 font-bold uppercase md:hidden">อุปกรณ์</div>
                                {{ $claim->device_name }}
                            </td>
                            
                            <td class="flex justify-between items-center md:table-cell py-3 md:py-4 md:px-5 text-sm border-b border-gray-50 md:border-0" :class="expanded ? 'flex' : 'hidden md:table-cell'">
                                <div class="text-[10px] text-slate-400 font-bold uppercase md:hidden">ประเภทงาน</div>
                                @if($claim->claim_type === 'warranty')
                                    <span class="text-emerald-600 font-semibold">🛡️ เคลมประกันศูนย์</span>
                                @elseif($claim->claim_type === 'repair')
                                    <span class="text-indigo-600 font-semibold">🔧 ส่งซ่อมทั่วไป</span>
                                @else
                                    <span class="text-amber-600 font-semibold">⚙️ ตั้งค่า/ลงโปรแกรม</span>
                                @endif
                            </td>
                            
                            <td class="flex justify-between items-center md:table-cell py-3 md:py-4 md:px-5 text-center border-b border-gray-50 md:border-0" :class="expanded ? 'flex' : 'hidden md:table-cell'">
                                <div class="text-[10px] text-slate-400 font-bold uppercase md:hidden">สถานะ</div>
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold border {{ $claim->status_badge_class }}">{{ $claim->status_label }}</span>
                            </td>
                            
                            <td class="flex justify-between items-center md:table-cell py-3 md:py-4 md:px-5 text-sm text-slate-500 border-b border-gray-50 md:border-0" :class="expanded ? 'flex' : 'hidden md:table-cell'">
                                <div class="text-[10px] text-slate-400 font-bold uppercase md:hidden">วันที่แจ้ง</div>
                                {{ $claim->created_at->format('d/m/Y H:i') }}
                            </td>
                            
                            <td class="block md:table-cell py-3 md:py-4 md:px-5 text-center border-b border-gray-50 md:border-0" :class="expanded ? 'block' : 'hidden md:table-cell'">
                                <div class="text-[10px] text-slate-400 font-bold uppercase mb-2 md:hidden">จัดการ</div>
                                <a href="{{ route('admin.claims.show', $claim->id) }}" class="inline-flex items-center justify-center gap-1.5 px-4 py-2 text-xs font-bold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 rounded-xl transition w-full md:w-auto">
                                    <i class="fa-solid fa-edit"></i> อัปเดตสถานะ
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr class="block md:table-row">
                            <td colspan="7" class="block md:table-cell py-16 text-center text-slate-400">
                                <i class="fa-solid fa-inbox text-4xl mb-3 block"></i>ยังไม่มีคำขอเคลมหรือส่งซ่อมในระบบ
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $claims->links() }}</div>
        </div>
    </div>
</x-app-layout>

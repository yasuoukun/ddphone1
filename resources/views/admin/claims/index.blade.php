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
                    <option value="pending">⏳ ได้รับแจ้งเรื่อง</option>
                    <option value="received">📦 ได้รับเครื่องแล้ว</option>
                    <option value="in_progress">🛠️ กำลังดำเนินการ</option>
                    <option value="completed">✅ เสร็จสิ้นส่งคืน</option>
                    <option value="cancelled">❌ ยกเลิก</option>
                </select>
                <select id="rtf-claimsTable-claimtype" class="px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 text-sm font-semibold bg-white min-w-[180px]">
                    <option value="all">🔧 ทุกประเภทงาน</option>
                    <option value="warranty">🛡️ เคลมประกันศูนย์</option>
                    <option value="repair">🔧 ส่งซ่อมทั่วไป</option>
                    <option value="service">⚙️ ตั้งค่า/ลงโปรแกรม</option>
                </select>
            </x-real-time-filter>

            <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-gray-100">
                <div class="overflow-x-auto">
                    <table id="claimsTable" class="w-full text-left border-collapse">
                        <thead>
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
                        <tbody class="divide-y divide-gray-50">
                            @forelse($claims as $claim)
                            <tr class="hover:bg-indigo-50/30 transition-colors"
                                data-searchable="{{ strtolower($claim->customer_name . ' ' . $claim->customer_phone . ' ' . $claim->device_name . ' ' . $claim->id) }}"
                                data-filter-status="{{ $claim->status }}"
                                data-filter-claimtype="{{ $claim->claim_type }}">
                                <td class="py-4 px-5 font-bold text-slate-800 text-sm">{{ $claim->id }}</td>
                                <td class="py-4 px-5 text-sm">
                                    <div class="font-semibold text-slate-800">{{ $claim->customer_name }}</div>
                                    <div class="text-xs text-slate-400"><i class="fa-solid fa-phone text-[10px]"></i> {{ $claim->customer_phone }}</div>
                                </td>
                                <td class="py-4 px-5 text-sm font-medium text-slate-700">{{ $claim->device_name }}</td>
                                <td class="py-4 px-5 text-sm">
                                    @if($claim->claim_type === 'warranty')
                                        <span class="text-emerald-600 font-semibold">🛡️ เคลมประกันศูนย์</span>
                                    @elseif($claim->claim_type === 'repair')
                                        <span class="text-indigo-600 font-semibold">🔧 ส่งซ่อมทั่วไป</span>
                                    @else
                                        <span class="text-amber-600 font-semibold">⚙️ ตั้งค่า/ลงโปรแกรม</span>
                                    @endif
                                </td>
                                <td class="py-4 px-5 text-center">
                                    @php
                                        $statusMap = [
                                            'pending' => ['ได้รับแจ้งเรื่อง', 'bg-amber-100 text-amber-800'],
                                            'received' => ['ได้รับเครื่องแล้ว', 'bg-blue-100 text-blue-800'],
                                            'in_progress' => ['กำลังดำเนินการ', 'bg-purple-100 text-purple-800'],
                                            'completed' => ['เสร็จสิ้นส่งคืน', 'bg-emerald-100 text-emerald-800'],
                                            'cancelled' => ['ยกเลิก', 'bg-rose-100 text-rose-800'],
                                        ];
                                        $st = $statusMap[$claim->status] ?? ['ไม่ทราบ', 'bg-gray-100 text-gray-600'];
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold {{ $st[1] }}">{{ $st[0] }}</span>
                                </td>
                                <td class="py-4 px-5 text-sm text-slate-500">{{ $claim->created_at->format('d/m/Y H:i') }}</td>
                                <td class="py-4 px-5 text-center">
                                    <a href="{{ route('admin.claims.show', $claim->id) }}" class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 rounded-xl transition">
                                        <i class="fa-solid fa-edit"></i> อัปเดตสถานะ
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="py-16 text-center text-slate-400"><i class="fa-solid fa-inbox text-4xl mb-3 block"></i>ยังไม่มีคำขอเคลมหรือส่งซ่อมในระบบ</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4">{{ $claims->links() }}</div>
        </div>
    </div>
</x-app-layout>

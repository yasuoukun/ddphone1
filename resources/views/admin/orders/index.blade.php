<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class="fa-solid fa-receipt text-indigo-600"></i>
            จัดการคำสั่งซื้อทั้งหมด
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

            <x-real-time-filter table-id="ordersTable" placeholder="ค้นหาชื่อลูกค้า อีเมล หรือเลขออเดอร์..." count-label="ออเดอร์">
                <select id="rtf-ordersTable-status" class="px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 text-sm font-semibold bg-white min-w-[180px]">
                    <option value="all">📋 ทุกสถานะ</option>
                    <option value="pending">⏳ รอชำระเงิน</option>
                    <option value="pending_verification">🔍 รอตรวจสอบสลิป</option>
                    <option value="confirmed">✅ ยืนยันแล้ว</option>
                    <option value="shipped">🚚 กำลังจัดส่ง</option>
                    <option value="delivered">📦 ส่งมอบแล้ว</option>
                    <option value="cancelled">❌ ยกเลิก</option>
                </select>
            </x-real-time-filter>

            <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-gray-100">
                <div class="overflow-x-auto">
                    <table id="ordersTable" class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 text-slate-500 text-xs font-semibold uppercase bg-slate-50/80">
                                <th class="py-4 px-5 rounded-tl-xl">เลขออเดอร์</th>
                                <th class="py-4 px-5">ลูกค้า</th>
                                <th class="py-4 px-5 text-right">ยอดรวม</th>
                                <th class="py-4 px-5 text-center">สถานะ</th>
                                <th class="py-4 px-5">วันที่สั่งซื้อ</th>
                                <th class="py-4 px-5 text-center rounded-tr-xl">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($orders as $order)
                            <tr class="hover:bg-indigo-50/30 transition-colors"
                                data-searchable="{{ strtolower(($order->user->name ?? 'guest') . ' ' . ($order->user->email ?? '') . ' #' . str_pad($order->id, 5, '0', STR_PAD_LEFT)) }}"
                                data-filter-status="{{ $order->status }}">
                                <td class="py-4 px-5">
                                    <span class="font-bold text-slate-800 text-sm">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td class="py-4 px-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-sm font-bold">
                                            {{ mb_substr($order->user->name ?? 'G', 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-semibold text-slate-800 text-sm">{{ $order->user->name ?? 'Guest' }}</div>
                                            <div class="text-xs text-slate-400">{{ $order->user->email ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-5 text-right font-bold text-slate-800">฿{{ number_format($order->total_amount, 2) }}</td>
                                <td class="py-4 px-5 text-center">
                                    @php
                                        $statusMap = [
                                            'pending' => ['รอชำระเงิน', 'bg-amber-100 text-amber-800'],
                                            'pending_verification' => ['รอตรวจสลิป', 'bg-blue-100 text-blue-800'],
                                            'confirmed' => ['ยืนยันแล้ว', 'bg-emerald-100 text-emerald-800'],
                                            'shipped' => ['กำลังจัดส่ง', 'bg-purple-100 text-purple-800'],
                                            'delivered' => ['ส่งมอบแล้ว', 'bg-green-100 text-green-800'],
                                            'cancelled' => ['ยกเลิก', 'bg-rose-100 text-rose-800'],
                                        ];
                                        $st = $statusMap[$order->status] ?? ['ไม่ทราบ', 'bg-gray-100 text-gray-600'];
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold {{ $st[1] }}">{{ $st[0] }}</span>
                                </td>
                                <td class="py-4 px-5 text-sm text-slate-500">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td class="py-4 px-5 text-center">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 rounded-xl transition">
                                        <i class="fa-solid fa-eye"></i> ดูรายละเอียด
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="py-16 text-center text-slate-400"><i class="fa-solid fa-inbox text-4xl mb-3 block"></i>ยังไม่มีคำสั่งซื้อในระบบ</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
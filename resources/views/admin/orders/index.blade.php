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

            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 md:overflow-x-auto">
                <table id="ordersTable" class="w-full text-left border-collapse md:min-w-[850px] block md:table">
                    <thead class="hidden md:table-header-group">
                        <tr class="border-b border-slate-200 text-slate-700 text-xs font-bold uppercase bg-slate-50/90 select-none">
                            <th class="py-4 px-5 rounded-tl-3xl whitespace-nowrap">เลขออเดอร์</th>
                            <th class="py-4 px-5 whitespace-nowrap">ลูกค้า</th>
                            <th class="py-4 px-5 whitespace-nowrap">รายการสินค้า</th>
                            <th class="py-4 px-5 text-right whitespace-nowrap">ยอดรวม</th>
                            <th class="py-4 px-5 text-center whitespace-nowrap">สถานะ</th>
                            <th class="py-4 px-5 whitespace-nowrap">วันที่สั่งซื้อ</th>
                            <th class="py-4 px-5 text-center rounded-tr-3xl whitespace-nowrap">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="block md:table-row-group divide-y-0 md:divide-y divide-slate-100 bg-transparent md:bg-white space-y-4 md:space-y-0 p-4 md:p-0">
                        @forelse($orders as $order)
                        @php
                            $itemNames = $order->items->map(fn($i) => $i->product->name ?? 'สินค้า')->join(' ');
                            $searchableStr = strtolower(($order->user->name ?? 'guest') . ' ' . ($order->user->email ?? '') . ' #' . str_pad($order->id, 5, '0', STR_PAD_LEFT) . ' ' . $itemNames);
                        @endphp
                        <tr class="hover:bg-indigo-50/30 transition-colors block md:table-row bg-white border border-slate-200 md:border-0 rounded-2xl md:rounded-none shadow-sm md:shadow-none p-4 md:p-0 relative"
                            x-data="{ expanded: false }"
                            data-searchable="{{ $searchableStr }}"
                            data-filter-status="{{ $order->status }}">
                            <td class="flex justify-between items-center md:table-cell py-2 md:py-4 md:px-5 whitespace-nowrap border-b border-slate-100 md:border-0">
                                <div>
                                    <div class="text-[10px] text-slate-400 font-bold uppercase mb-0.5 md:hidden">เลขออเดอร์</div>
                                    <span class="font-extrabold text-indigo-600 md:text-slate-800 text-sm">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                                </div>
                                <div class="flex items-center gap-2 md:hidden">
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
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-extrabold {{ $st[1] }}">{{ $st[0] }}</span>
                                    <button @click="expanded = !expanded" class="w-8 h-8 flex items-center justify-center bg-slate-100 text-slate-600 rounded-full">
                                        <i class="fa-solid fa-chevron-down transition-transform duration-300" :class="expanded ? 'rotate-180' : ''"></i>
                                    </button>
                                </div>
                            </td>
                            
                            <td class="block md:table-cell py-3 md:py-4 md:px-5 whitespace-nowrap border-b border-slate-100 md:border-0" :class="expanded ? 'block' : 'hidden md:table-cell'">
                                <div class="text-[10px] text-slate-400 font-bold uppercase mb-1.5 md:hidden">ข้อมูลลูกค้า</div>
                                <div class="flex items-center gap-3">
                                    <img src="{{ optional($order->user)->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($order->user->name ?? 'Guest') }}" 
                                         alt="{{ $order->user->name ?? 'Guest' }}" 
                                         class="w-9 h-9 rounded-full object-cover border border-indigo-200 shadow-sm shrink-0"
                                         onerror="this.src='https://ui-avatars.com/api/?name=Guest'">
                                    <div class="min-w-0">
                                        <div class="font-bold text-slate-800 text-sm truncate">{{ $order->user->name ?? 'Guest' }}</div>
                                        <div class="text-xs text-slate-500 truncate">{{ $order->user->email ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            
                            <td class="block md:table-cell py-3 md:py-4 md:px-5 border-b border-slate-100 md:border-0" :class="expanded ? 'block' : 'hidden md:table-cell'">
                                <div class="text-[10px] text-slate-400 font-bold uppercase mb-1.5 md:hidden">รายการสินค้า</div>
                                <div class="space-y-1.5 min-w-[200px] max-w-[300px]">
                                    @forelse($order->items as $item)
                                    <div class="flex items-center justify-between gap-2 text-xs bg-slate-50 border border-slate-200 px-2.5 py-1.5 rounded-xl">
                                        <span class="font-bold text-slate-800 truncate flex-1" title="{{ $item->product->name ?? 'สินค้าถูกลบ' }}">
                                            📱 {{ $item->product->name ?? 'สินค้าถูกลบ' }}
                                        </span>
                                        <span class="px-2 py-0.5 rounded-full bg-slate-800 text-white font-extrabold text-[10px] shrink-0">
                                            x{{ $item->quantity }}
                                        </span>
                                    </div>
                                    @empty
                                    <span class="text-xs text-slate-400 font-semibold italic">- ไม่มีรายการสินค้า -</span>
                                    @endforelse
                                </div>
                            </td>
                            
                            <td class="flex justify-between items-center md:table-cell py-3 md:py-4 md:px-5 text-right whitespace-nowrap border-b border-slate-100 md:border-0" :class="expanded ? 'flex' : 'hidden md:table-cell'">
                                <div class="text-[10px] text-slate-400 font-bold uppercase md:hidden">ยอดรวมทั้งหมด</div>
                                <span class="font-extrabold text-slate-900 text-sm">฿{{ number_format($order->total_amount, 2) }}</span>
                            </td>
                            
                            <td class="block md:table-cell py-3 md:py-4 md:px-5 text-center whitespace-nowrap border-b border-slate-100 md:border-0" :class="expanded ? 'block' : 'hidden md:table-cell'">
                                <div class="text-[10px] text-slate-400 font-bold uppercase mb-2 md:hidden">สถานะและการชำระเงิน</div>
                                @php
                                    $paymentRecord = $order->payments->first();
                                    $slipThumbUrl = null;
                                    if ($paymentRecord && !empty($paymentRecord->slip_image)) {
                                        $cleanSlip = ltrim(str_replace(['public/', 'storage/'], '', $paymentRecord->slip_image), '/');
                                        $slipThumbUrl = '/storage/' . $cleanSlip;
                                    }
                                @endphp
                                <div class="flex flex-row md:flex-col items-center justify-between md:justify-center gap-2">
                                    <span class="hidden md:inline-flex items-center px-3 py-1.5 rounded-full text-xs font-extrabold {{ $st[1] }}">{{ $st[0] }}</span>
                                    @if($slipThumbUrl)
                                        <button type="button" 
                                                onclick="Swal.fire({ title: '📄 สลิปโอนเงิน ออเดอร์ #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}', imageUrl: '{{ $slipThumbUrl }}', imageAlt: 'สลิปชำระเงิน', showConfirmButton: true, confirmButtonText: 'ปิดหน้าต่าง', confirmButtonColor: '#4f46e5', customClass: { popup: 'rounded-3xl' } })" 
                                                class="inline-flex items-center gap-1 px-3 py-1.5 md:px-2.5 md:py-1 rounded-lg bg-indigo-50 border border-indigo-200 text-[11px] font-bold text-indigo-700 hover:bg-indigo-600 hover:text-white transition shadow-sm w-full md:w-auto justify-center" 
                                                title="กดเพื่อเปิดดูรูปสลิปเด้งหน้าต่าง">
                                            <i class="fa-solid fa-file-image"></i> ดูรูปสลิป
                                        </button>
                                    @else
                                        <span class="text-[10px] text-slate-400 md:hidden">- ไม่มีสลิป -</span>
                                    @endif
                                </div>
                            </td>
                            
                            <td class="flex justify-between items-center md:table-cell py-3 md:py-4 md:px-5 whitespace-nowrap border-b border-slate-100 md:border-0" :class="expanded ? 'flex' : 'hidden md:table-cell'">
                                <div class="text-[10px] text-slate-400 font-bold uppercase md:hidden">วันที่สั่งซื้อ</div>
                                <div class="text-right md:text-left">
                                    <div class="text-xs font-bold text-slate-700">{{ $order->created_at->format('d/m/Y') }}</div>
                                    <div class="text-[11px] text-slate-500 font-medium">{{ $order->created_at->format('H:i') }} น.</div>
                                </div>
                            </td>
                            
                            <td class="block md:table-cell pt-3 pb-1 md:py-4 md:px-5 text-center whitespace-nowrap" :class="expanded ? 'block' : 'hidden md:table-cell'">
                                <a href="{{ route('admin.orders.show', $order) }}" class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 md:py-2 text-xs font-bold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 rounded-xl transition whitespace-nowrap w-full md:w-auto">
                                    <i class="fa-solid fa-eye"></i> ดูรายละเอียด
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr class="block md:table-row">
                            <td colspan="7" class="block md:table-cell py-16 text-center text-slate-400">
                                <i class="fa-solid fa-inbox text-4xl mb-3 block"></i>
                                <span class="font-bold text-sm">ยังไม่มีคำสั่งซื้อในระบบ</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>

    <!-- Real-time badge indicator update (No automatic page reload) -->
</x-app-layout>
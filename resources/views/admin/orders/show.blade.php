<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.orders.index') }}" class="w-10 h-10 rounded-2xl bg-white border border-slate-200 shadow-sm flex items-center justify-center text-slate-600 hover:text-indigo-600 hover:border-indigo-200 transition-all">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="font-black text-2xl text-slate-900 leading-tight flex items-center gap-2">
                        คำสั่งซื้อ #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                    </h2>
                    <p class="text-xs text-slate-500 font-semibold mt-0.5">
                        <i class="fa-regular fa-clock"></i> ทำรายการเมื่อ: {{ $order->created_at ? $order->created_at->locale('th')->translatedFormat('j F Y เวลา H:i น.') : '-' }}
                    </p>
                </div>
            </div>

            <!-- Status Badge -->
            <div class="flex items-center gap-2">
                @php
                    $statusConfig = [
                        'pending' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-200', 'icon' => 'fa-clock', 'label' => 'รอชำระเงิน'],
                        'pending_verification' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'border' => 'border-blue-200', 'icon' => 'fa-receipt', 'label' => 'รอตรวจสอบสลิป'],
                        'confirmed' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'icon' => 'fa-circle-check', 'label' => 'ชำระเงินแล้ว/ยืนยันแล้ว'],
                        'shipped' => ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-700', 'border' => 'border-indigo-200', 'icon' => 'fa-truck-fast', 'label' => 'จัดส่งสินค้าแล้ว'],
                        'delivered' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-700', 'border' => 'border-purple-200', 'icon' => 'fa-box-open', 'label' => 'ได้รับสินค้าแล้ว'],
                        'cancelled' => ['bg' => 'bg-rose-50', 'text' => 'text-rose-700', 'border' => 'border-rose-200', 'icon' => 'fa-circle-xmark', 'label' => 'ยกเลิกคำสั่งซื้อ'],
                    ];
                    $currentStatus = $statusConfig[$order->status] ?? ['bg' => 'bg-slate-50', 'text' => 'text-slate-700', 'border' => 'border-slate-200', 'icon' => 'fa-circle-info', 'label' => $order->status];
                @endphp
                <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-2xl text-xs font-black border {{ $currentStatus['bg'] }} {{ $currentStatus['text'] }} {{ $currentStatus['border'] }} shadow-sm">
                    <i class="fa-solid {{ $currentStatus['icon'] }}"></i>
                    {{ $currentStatus['label'] }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left 2 Columns: Items & Order Summary -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Products Card -->
                <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-6">
                        <h3 class="font-black text-lg text-slate-800 flex items-center gap-2">
                            <i class="fa-solid fa-boxes-packing text-indigo-600"></i>
                            รายการสินค้าที่สั่งซื้อ ({{ $order->items->count() }} รายการ)
                        </h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-xs font-bold text-slate-400 uppercase border-b border-slate-100">
                                    <th class="pb-3 pl-2">สินค้า</th>
                                    <th class="pb-3 text-center">ราคา/ชิ้น</th>
                                    <th class="pb-3 text-center">จำนวน</th>
                                    <th class="pb-3 text-right pr-2">ราคารวม</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($order->items as $item)
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="py-4 pl-2">
                                        <div class="flex items-center gap-3">
                                            <div class="w-14 h-14 rounded-2xl bg-slate-100 border border-slate-200 overflow-hidden flex-shrink-0 flex items-center justify-center p-1">
                                                @if(optional($item->product)->primary_image_url)
                                                    <img src="{{ $item->product->primary_image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-contain">
                                                @else
                                                    <i class="fa-solid fa-mobile-screen text-slate-400 text-xl"></i>
                                                @endif
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-sm text-slate-800 line-clamp-1">
                                                    {{ $item->product->name ?? 'สินค้าถูกลบจากระบบ' }}
                                                </h4>
                                                @if(optional($item->product)->sku)
                                                    <span class="text-[11px] font-semibold text-slate-400 bg-slate-100 px-2 py-0.5 rounded-md mt-1 inline-block">
                                                        SKU: {{ $item->product->sku }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 text-center text-sm font-bold text-slate-700">
                                        ฿{{ number_format($item->price, 2) }}
                                    </td>
                                    <td class="py-4 text-center">
                                        <span class="inline-block px-3 py-1 bg-slate-100 rounded-xl text-xs font-black text-slate-700">
                                            x{{ $item->quantity }}
                                        </span>
                                    </td>
                                    <td class="py-4 text-right pr-2 text-sm font-black text-slate-900">
                                        ฿{{ number_format($item->price * $item->quantity, 2) }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Order Financial Summary -->
                    <div class="mt-6 pt-6 border-t border-slate-100 bg-slate-50/50 -mx-6 -mb-6 p-6 rounded-b-3xl">
                        <div class="max-w-xs ml-auto space-y-2.5">
                            <div class="flex justify-between items-center text-xs font-semibold text-slate-500">
                                <span>รวมค่าสินค้า:</span>
                                <span class="font-bold text-slate-700">฿{{ number_format($order->items->sum(fn($i) => $i->price * $i->quantity), 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center text-xs font-semibold text-slate-500">
                                <span>ค่าจัดส่ง:</span>
                                <span class="font-bold text-emerald-600">ฟรี (ส่งฟรีทั่วไทย)</span>
                            </div>
                            <div class="border-t border-slate-200 pt-3 flex justify-between items-center">
                                <span class="font-black text-sm text-slate-900">ยอดชำระสุทธิ:</span>
                                <span class="font-black text-2xl text-indigo-600">฿{{ number_format($order->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Slip Preview Card -->
                @php
                    $payment = $order->payments->first() ?? \App\Models\Payment::where('order_id', $order->id)->first();
                    $slipUrl = null;
                    if ($payment && !empty($payment->slip_image)) {
                        $rawPath = ltrim(str_replace(['public/', 'storage/'], '', $payment->slip_image), '/');
                        $slipUrl = '/storage/' . $rawPath;
                    }
                @endphp
                <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
                    <h3 class="font-black text-lg text-slate-800 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-receipt text-indigo-600"></i>
                        หลักฐานการโอนเงิน (สลิปชำระเงิน)
                    </h3>

                    @if($slipUrl)
                        <div class="bg-slate-50/80 p-4 rounded-2xl border border-slate-200 text-center">
                            <div onclick="Swal.fire({ title: '📄 สลิปโอนเงิน ออเดอร์ #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}', imageUrl: '{{ $slipUrl }}', imageAlt: 'สลิปชำระเงิน', showConfirmButton: true, confirmButtonText: 'ปิดหน้าต่าง', confirmButtonColor: '#4f46e5', customClass: { popup: 'rounded-3xl' } })" 
                                 class="inline-block relative group cursor-pointer">
                                <img src="{{ $slipUrl }}" 
                                     alt="Slip Image #{{ $order->id }}" 
                                     class="max-w-full h-auto max-h-[380px] mx-auto rounded-2xl border border-slate-200 shadow-md group-hover:scale-[1.01] transition-transform duration-200"
                                     onerror="if(!this.dataset.retry){this.dataset.retry=1;this.src='/media/{{ ltrim(str_replace(['public/','storage/'], '', $payment->slip_image), '/') }}';}">
                                <div class="mt-3 inline-flex items-center gap-1.5 text-xs text-indigo-600 font-bold bg-indigo-50 px-4 py-2 rounded-full border border-indigo-100 hover:bg-indigo-100 transition-colors">
                                    <i class="fa-solid fa-expand"></i> คลิกเพื่อเปิดกล่องขยายรูปภาพสลิป
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="p-5 bg-amber-50/80 border border-amber-200/80 text-amber-800 rounded-2xl text-xs font-bold text-center flex items-center justify-center gap-2">
                            <i class="fa-solid fa-triangle-exclamation text-amber-500 text-lg"></i>
                            ยังไม่มีการอัปโหลดสลิป หรือชำระผ่านช่องทางอื่น
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Column: Customer Info & Status Updater Card -->
            <div class="space-y-6">
                
                <!-- Customer & Delivery Address Card -->
                <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
                    <h3 class="font-black text-lg text-slate-800 mb-4 flex items-center gap-2 pb-3 border-b border-slate-100">
                        <i class="fa-solid fa-user text-indigo-600"></i>
                        ข้อมูลลูกค้าและสถานที่จัดส่ง
                    </h3>

                    <div class="space-y-3 text-sm">
                        <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-2xl">
                            <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-lg">
                                <i class="fa-solid fa-circle-user"></i>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 font-bold">ผู้สั่งซื้อ</p>
                                <p class="font-black text-slate-800">{{ $order->user->name ?? 'Guest User' }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-2xl">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-base">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 font-bold">อีเมล</p>
                                <p class="font-bold text-slate-700 break-all">{{ $order->user->email ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 mt-2">
                            <p class="text-xs text-slate-400 font-bold mb-1 flex items-center gap-1.5">
                                <i class="fa-solid fa-location-dot text-rose-500"></i> ที่อยู่สำหรับจัดส่งสินค้า
                            </p>
                            <p class="text-xs font-semibold text-slate-700 leading-relaxed">
                                {{ $order->shipping_info }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Update Status & Tracking Form Card -->
                <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
                    <h3 class="font-black text-lg text-slate-800 mb-4 flex items-center gap-2 pb-3 border-b border-slate-100">
                        <i class="fa-solid fa-sliders text-indigo-600"></i>
                        อัปเดตสถานะและเลขพัสดุ
                    </h3>

                    <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="space-y-4">
                        @csrf 
                        @method("PUT")

                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1.5">
                                สถานะออเดอร์ (Order Status)
                            </label>
                            <select name="status" class="w-full rounded-2xl border-slate-200 text-xs font-bold text-slate-800 focus:border-indigo-500 focus:ring-indigo-500 py-2.5">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>⌛ Pending (รอชำระเงิน)</option>
                                <option value="pending_verification" {{ $order->status == 'pending_verification' ? 'selected' : '' }}>📄 Pending Verification (รอตรวจสอบสลิป)</option>
                                <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>✅ Confirmed (ยืนยัน/ชำระเงินแล้ว)</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>🚚 Shipped (จัดส่งสินค้าแล้ว)</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>📦 Delivered (ได้รับสินค้าแล้ว)</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>❌ Cancelled (ยกเลิกคำสั่งซื้อ)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1.5">
                                บริษัทขนส่ง (Courier)
                            </label>
                            <input type="text" name="shipping_courier" value="{{ $order->shipping_courier }}" placeholder="เช่น Flash Express, Kerry, ไปรษณีย์ไทย" class="w-full rounded-2xl border-slate-200 text-xs font-bold text-slate-800 focus:border-indigo-500 focus:ring-indigo-500 py-2.5">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1.5">
                                เลขพัสดุติดตาม (Tracking Number)
                            </label>
                            <input type="text" name="tracking_number" value="{{ $order->tracking_number }}" placeholder="ระบุเลขพัสดุที่สามารถเช็คสถานะได้" class="w-full rounded-2xl border-slate-200 text-xs font-bold text-slate-800 focus:border-indigo-500 focus:ring-indigo-500 py-2.5">
                        </div>

                        <button type="submit" class="w-full py-3 px-4 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs shadow-lg shadow-indigo-600/25 flex items-center justify-center gap-2 transition-all hover:scale-[1.02]">
                            <i class="fa-solid fa-floppy-disk"></i> บันทึกข้อมูลการอัปเดต
                        </button>
                    </form>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
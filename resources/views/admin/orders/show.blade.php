<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">รายละเอียดคำสั่งซื้อ #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="md:col-span-2 space-y-6">
                <!-- Items -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-bold text-lg mb-4">รายการสินค้า</h3>
                    <table class="w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left pb-2">สินค้า</th>
                                <th class="text-center pb-2">ราคา</th>
                                <th class="text-center pb-2">จำนวน</th>
                                <th class="text-right pb-2">รวม</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr class="border-b">
                                <td class="py-2">{{ $item->product->name ?? 'สินค้าถูกลบ' }}</td>
                                <td class="py-2 text-center">฿{{ number_format($item->price, 2) }}</td>
                                <td class="py-2 text-center">{{ $item->quantity }}</td>
                                <td class="py-2 text-right">฿{{ number_format($item->price * $item->quantity, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-right py-4 font-bold">ยอดสุทธิ:</td>
                                <td class="text-right py-4 font-bold text-xl text-blue-600">฿{{ number_format($order->total_amount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="space-y-6">
                <!-- Customer Info -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-bold text-lg mb-4">ข้อมูลลูกค้าและการจัดส่ง</h3>
                    <p><strong>ชื่อ:</strong> {{ $order->user->name ?? 'Guest' }}</p>
                    <p><strong>อีเมล:</strong> {{ $order->user->email ?? '-' }}</p>
                    <hr class="my-4">
                    <p><strong>ที่อยู่จัดส่ง:</strong></p>
                    <p class="text-gray-600 mt-2">{{ $order->shipping_info }}</p>
                </div>

                <!-- Status Update -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-bold text-lg mb-4">อัปเดตสถานะ</h3>
                    <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                        @csrf @method("PUT")
                        <select name="status" class="w-full rounded border-gray-300 mb-4">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending (รอชำระเงิน)</option>
                            <option value="pending_verification" {{ $order->status == 'pending_verification' ? 'selected' : '' }}>Pending Verification (รอตรวจสอบสลิป)</option>
                            <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmed (ยืนยันแล้ว)</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped (จัดส่งแล้ว)</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered (ส่งถึงแล้ว)</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled (ยกเลิก)</option>
                        </select>
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">บริษัทขนส่ง (Courier)</label>
                            <input type="text" name="shipping_courier" value="{{ $order->shipping_courier }}" placeholder="เช่น Flash Express, Kerry, ไปรษณีย์ไทย" class="w-full rounded border-gray-300">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">เลขพัสดุ (Tracking Number)</label>
                            <input type="text" name="tracking_number" value="{{ $order->tracking_number }}" placeholder="ระบุเลขพัสดุ" class="w-full rounded border-gray-300">
                        </div>
                        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">อัปเดตข้อมูล</button>
                    </form>
                </div>

                <!-- Payment Slip Display -->
                @php
                    $payment = $order->payments->first() ?? \App\Models\Payment::where('order_id', $order->id)->first();
                    $slipUrl = null;
                    if ($payment && !empty($payment->slip_image)) {
                        $rawPath = ltrim(str_replace(['public/', 'storage/'], '', $payment->slip_image), '/');
                        $slipUrl = '/storage/' . $rawPath;
                    }
                @endphp
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-bold text-lg mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-file-invoice-dollar text-indigo-600"></i>
                        หลักฐานการโอนเงิน (สลิป)
                    </h3>
                    @if($slipUrl)
                        <div class="bg-slate-50 p-3 rounded-2xl border border-slate-200 text-center">
                            <div onclick="Swal.fire({ title: '📄 สลิปโอนเงิน ออเดอร์ #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}', imageUrl: '{{ $slipUrl }}', imageAlt: 'สลิปชำระเงิน', showConfirmButton: true, confirmButtonText: 'ปิดหน้าต่าง', confirmButtonColor: '#4f46e5', customClass: { popup: 'rounded-3xl' } })" 
                                 class="inline-block relative group cursor-pointer">
                                <img src="{{ $slipUrl }}" 
                                     alt="Slip Image #{{ $order->id }}" 
                                     class="max-w-full h-auto max-h-[420px] mx-auto rounded-xl border border-slate-200 shadow-md group-hover:scale-[1.02] transition-transform duration-200"
                                     onerror="if(!this.dataset.retry){this.dataset.retry=1;this.src='/media/{{ ltrim(str_replace(['public/','storage/'], '', $payment->slip_image), '/') }}';}">
                                <div class="mt-2 text-xs text-indigo-600 font-bold flex items-center justify-center gap-1">
                                    <i class="fa-solid fa-expand"></i> คลิกเพื่อเปิดกล่องหน้าต่างเด้งดูรูปภาพ
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="p-4 bg-amber-50 border border-amber-200 text-amber-800 rounded-xl text-xs font-semibold text-center">
                            ⚠️ ลูกค้ายังไม่ได้อัปโหลดรูปภาพสลิปชำระเงิน
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
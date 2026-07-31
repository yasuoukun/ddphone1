<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center justify-between">
            <span class="flex items-center gap-2">
                <i class="fa-solid fa-wrench text-indigo-600"></i>
                รายละเอียดงานเคลม/ซ่อม: {{ $claim->id }}
            </span>
            <a href="{{ route('admin.claims.index') }}" class="text-xs bg-indigo-100 text-indigo-800 px-3 py-1.5 rounded-full font-bold hover:bg-indigo-200 transition">
                ⬅️ กลับไปหน้ารวม
            </a>
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50/50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-r-lg shadow-sm flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-emerald-500 text-xl"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Info Section (2 cols) -->
                <div class="md:col-span-2 space-y-6">
                    <!-- Customer and Device Info Card -->
                    <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-4">
                        <h3 class="text-lg font-bold text-gray-800 border-b pb-2">📋 ข้อมูลการแจ้งซ่อม/เคลม</h3>
                        
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-400 block">ชื่อลูกค้า</span>
                                <strong class="text-slate-800">{{ $claim->customer_name }}</strong>
                            </div>
                            <div>
                                <span class="text-gray-400 block">เบอร์โทรศัพท์</span>
                                <strong class="text-slate-800">{{ $claim->customer_phone }}</strong>
                            </div>
                            <div>
                                <span class="text-gray-400 block">ชื่ออุปกรณ์</span>
                                <strong class="text-slate-800">{{ $claim->device_name }}</strong>
                            </div>
                            <div>
                                <span class="text-gray-400 block">หมายเลขซีเรียล (S/N)</span>
                                <strong class="text-slate-800">{{ $claim->serial_number ?? '-' }}</strong>
                            </div>
                            <div>
                                <span class="text-gray-400 block">ประเภทงาน</span>
                                @if($claim->claim_type === 'warranty')
                                    <span class="inline-flex px-2.5 py-1 text-xs font-bold bg-emerald-100 text-emerald-800 rounded-full">🛡️ เคลมประกันศูนย์</span>
                                @elseif($claim->claim_type === 'repair')
                                    <span class="inline-flex px-2.5 py-1 text-xs font-bold bg-indigo-100 text-indigo-800 rounded-full">🔧 ส่งซ่อมทั่วไป</span>
                                @else
                                    <span class="inline-flex px-2.5 py-1 text-xs font-bold bg-amber-100 text-amber-800 rounded-full">⚙️ ตั้งค่า/ลงโปรแกรม</span>
                                @endif
                            </div>
                            <div>
                                <span class="text-gray-400 block">เลขออเดอร์อ้างอิง</span>
                                <strong class="text-slate-800">{{ $claim->order_id_raw ?? '-' }}</strong>
                            </div>
                        </div>

                        <div class="pt-4 border-t">
                            <span class="text-gray-400 text-xs block mb-1">อาการเสียที่พบ / บริการที่ต้องการ</span>
                            <div class="bg-slate-50 p-4 rounded-xl text-sm text-slate-700 whitespace-pre-line leading-relaxed">
                                {{ $claim->issue_description }}
                            </div>
                        </div>

                        <!-- Uploaded Device Photos -->
                        @if(!empty($claim->image_paths) && count($claim->image_paths) > 0)
                        <div class="pt-4 border-t">
                            <span class="text-gray-600 text-xs font-bold block mb-2">📷 รูปถ่ายตัวเครื่องหรืออาการเสียจากลูกค้า:</span>
                            <div class="grid grid-cols-3 sm:grid-cols-4 gap-3">
                                @foreach($claim->image_paths as $img)
                                <a href="{{ Storage::url($img) }}" target="_blank" class="block border rounded-xl overflow-hidden aspect-square bg-gray-100 hover:opacity-80 transition">
                                    <img src="{{ Storage::url($img) }}" alt="Device Photo" class="w-full h-full object-cover">
                                </a>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Update Status Form Section (1 col) -->
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm h-fit space-y-6">
                    <h3 class="text-lg font-bold text-gray-800 border-b pb-2">⚙️ ปรับสถานะ & ประเมินงานซ่อม</h3>

                    @php $wInfo = $claim->calculated_warranty_info; @endphp
                    @if($claim->order)
                    <div class="p-3.5 rounded-2xl {{ $wInfo['is_in_warranty'] ? 'bg-emerald-50 border border-emerald-200 text-emerald-900' : 'bg-rose-50 border border-rose-200 text-rose-900' }} text-xs font-bold space-y-1">
                        <div class="flex items-center justify-between">
                            <span>🛡️ สิทธิประกันร้าน (นับจากรับสินค้า):</span>
                            <span class="px-2 py-0.5 rounded-full {{ $wInfo['is_in_warranty'] ? 'bg-emerald-200 text-emerald-900' : 'bg-rose-200 text-rose-900' }}">{{ $wInfo['is_in_warranty'] ? 'อยู่ในประกัน 30 วัน' : 'หมดประกันแล้ว' }}</span>
                        </div>
                        <div>{{ $wInfo['status_label'] }}</div>
                    </div>
                    @endif

                    @if($claim->inbound_tracking_number)
                    <div class="p-3.5 bg-sky-50 border border-sky-200 rounded-2xl text-xs text-sky-900 space-y-1">
                        <span class="font-bold block text-sky-700">📦 เลขพัสดุที่ลูกค้าส่งมาที่ร้าน:</span>
                        <div class="font-extrabold text-sm">{{ $claim->inbound_courier ?? 'ขนส่ง' }}: <span class="text-indigo-600 font-mono">{{ $claim->inbound_tracking_number }}</span></div>
                    </div>
                    @endif
                    
                    <form action="{{ route('admin.claims.update', $claim->id) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PATCH')
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">สิทธิประกัน:</label>
                            <select name="warranty_status" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm font-medium focus:ring-2 focus:ring-indigo-200">
                                <option value="unknown" {{ $claim->warranty_status === 'unknown' ? 'selected' : '' }}>❓ รอตรวจสอบ</option>
                                <option value="in_warranty" {{ $claim->warranty_status === 'in_warranty' ? 'selected' : '' }}>🛡️ อยู่ในประกัน (ฟรีค่าซ่อม/มีเงื่อนไข)</option>
                                <option value="out_of_warranty" {{ $claim->warranty_status === 'out_of_warranty' ? 'selected' : '' }}>💰 นอกประกัน (มีค่าซ่อม)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">เลือกสถานะขั้นตอน:</label>
                            <select name="status" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm font-bold focus:ring-2 focus:ring-indigo-200 bg-slate-50">
                                <option value="pending_assessment" {{ in_array($claim->status, ['pending', 'pending_assessment']) ? 'selected' : '' }}>⏳ 1. รอแอดมินประเมิน / เช็คประกัน</option>
                                <option value="quoted" {{ $claim->status === 'quoted' ? 'selected' : '' }}>💬 2. เสนอราคาแล้ว (รอลูกค้ายืนยัน)</option>
                                <option value="confirmed_waiting_device" {{ $claim->status === 'confirmed_waiting_device' ? 'selected' : '' }}>🚚 3. ลูกค้ายืนยันแล้ว (รอส่งเครื่องมา)</option>
                                <option value="device_received" {{ $claim->status === 'device_received' ? 'selected' : '' }}>📦 4. ร้านได้รับเครื่องแล้ว (กำลังตรวจเช็ค)</option>
                                <option value="in_repair" {{ in_array($claim->status, ['in_repair', 'in_progress']) ? 'selected' : '' }}>🛠️ 5. ช่างกำลังดำเนินการซ่อม</option>
                                <option value="repaired_waiting_payment" {{ $claim->status === 'repaired_waiting_payment' ? 'selected' : '' }}>✨ 6. ซ่อมเสร็จแล้ว (รอชำระเงิน/ส่งคืน)</option>
                                <option value="return_shipped" {{ $claim->status === 'return_shipped' ? 'selected' : '' }}>📫 7. จัดส่งเครื่องคืนลูกค้าแล้ว</option>
                                <option value="completed" {{ $claim->status === 'completed' ? 'selected' : '' }}>✅ 8. เสร็จสิ้นสมบูรณ์ (Completed)</option>
                                <option value="cancelled" {{ $claim->status === 'cancelled' ? 'selected' : '' }}>❌ ยกเลิกรายการ (Cancelled)</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">💰 ราคาประเมินซ่อม (บาท):</label>
                                <input type="number" step="0.01" name="estimated_cost" value="{{ $claim->estimated_cost }}" placeholder="0.00" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm font-medium focus:ring-2 focus:ring-indigo-200">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">⏱️ ระยะเวลาซ่อม (วัน):</label>
                                <input type="number" name="estimated_days" value="{{ $claim->estimated_days ?? 1 }}" placeholder="1" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm font-medium focus:ring-2 focus:ring-indigo-200">
                            </div>
                        </div>

                        <div class="border-t pt-3 space-y-3">
                            <span class="text-xs font-bold text-slate-700 block">🚚 เลขพัสดุจัดส่งเครื่องคืนลูกค้า:</span>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <input type="text" name="return_courier" value="{{ $claim->return_courier ?? 'Flash Express' }}" placeholder="บริษัทขนส่ง" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-xs font-medium focus:ring-2 focus:ring-indigo-200">
                                </div>
                                <div>
                                    <input type="text" name="return_tracking_number" value="{{ $claim->return_tracking_number }}" placeholder="เลข Tracking" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-xs font-mono font-medium focus:ring-2 focus:ring-indigo-200">
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">โน้ตแจ้งลูกค้า / รายละเอียดการซ่อม:</label>
                            <textarea name="admin_notes" rows="4" class="w-full border border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-200 placeholder-gray-400" placeholder="เช่น เครื่องอยู่ในประกัน เปลี่ยนหน้าจอฟรี ไม่เสียค่าใช้จ่าย หรือ เปลี่ยนแบตเตอรี่แท้ ฿1,500 สั่งอะไหล่ 1 วัน...">{{ $claim->admin_notes }}</textarea>
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm py-3 rounded-xl transition duration-150 shadow-sm shadow-indigo-100">
                            💾 บันทึกอัปเดตงานซ่อม
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

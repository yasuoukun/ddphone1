<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center justify-between">
            <span class="flex items-center gap-2">
                <i class="fa-solid fa-file-invoice-dollar text-indigo-600"></i>
                {{ __('จัดการใบเสนอราคาออนไลน์') }}
            </span>
            <span class="text-xs bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full font-bold">แผงควบคุมผู้จัดการ</span>
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50/50 min-h-screen" x-data="{ selectedQuote: null, openDetailsModal: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-r-lg shadow-sm flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-emerald-500 text-xl"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            @endif

            <x-real-time-filter table-id="quotationsTable" placeholder="ค้นหาชื่อลูกค้า, เลขใบเสนอราคา..." count-label="ใบเสนอราคา">
                <select id="rtf-quotationsTable-status" class="px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 text-sm font-semibold bg-white min-w-[170px]">
                    <option value="all">📋 ทุกสถานะ</option>
                    <option value="pending">⏳ รอตรวจสอบ</option>
                    <option value="approved">✅ อนุมัติแล้ว</option>
                    <option value="rejected">❌ ไม่อนุมัติ</option>
                    <option value="ordered">🛏️ สั่งซื้อแล้ว</option>
                </select>
            </x-real-time-filter>

            <!-- Quotations Table Card -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex flex-wrap justify-between items-center gap-4 bg-white">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">รายการใบเสนอราคาทั้งหมด</h3>
                        <p class="text-xs text-gray-500">ใบเสนอราคาที่ลูกค้าขอผ่านเว็บไซต์ออนไลน์และถูกเก็บไว้ในระบบ</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table id="quotationsTable" class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-400 uppercase text-[11px] font-bold tracking-wider border-b border-gray-100">
                                <th class="py-4 px-6">เลขที่ใบเสนอราคา</th>
                                <th class="py-4 px-6">ลูกค้า/หน่วยงาน</th>
                                <th class="py-4 px-6">ข้อมูลติดต่อ</th>
                                <th class="py-4 px-6 text-right">ยอดเงินสุทธิ์</th>
                                <th class="py-4 px-6 text-center">สถานะ</th>
                                <th class="py-4 px-6 text-center">อัปเดตสถานะ</th>
                                <th class="py-4 px-6 text-center">การจัดการ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @forelse($quotations as $quote)
                            <tr class="hover:bg-slate-50/80 transition-colors"
                                data-searchable="{{ strtolower($quote->quote_no . ' ' . $quote->cust_name . ' ' . ($quote->cust_org ?? '') . ' ' . ($quote->cust_email ?? '') . ' ' . ($quote->cust_phone ?? '')) }}"
                                data-filter-status="{{ $quote->status }}">
                                <td class="py-4 px-6 font-bold text-indigo-600">
                                    <span class="block text-slate-800">{{ $quote->quote_no }}</span>
                                    <span class="text-[11px] text-gray-400 font-normal">{{ $quote->created_at->format('d/m/Y H:i') }}</span>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="font-semibold text-slate-800">{{ $quote->cust_name }}</div>
                                    @if($quote->cust_org)
                                    <div class="text-xs text-gray-500">{{ $quote->cust_org }}</div>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <div class="text-slate-700">{{ $quote->cust_phone ?? '-' }}</div>
                                    <div class="text-xs text-gray-500">{{ $quote->cust_email ?? '-' }}</div>
                                </td>
                                <td class="py-4 px-6 text-right font-extrabold text-slate-800">
                                    ฿{{ number_format($quote->net_total, 2) }}
                                </td>
                                <td class="py-4 px-6 text-center">
                                    @if($quote->status === 'pending')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-600">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                        รอตรวจสอบ
                                    </span>
                                    @elseif($quote->status === 'approved')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        อนุมัติแล้ว
                                    </span>
                                    @elseif($quote->status === 'rejected')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-600">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        ไม่อนุมัติ
                                    </span>
                                    @elseif($quote->status === 'ordered')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-sky-50 text-sky-600">
                                        <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>
                                        สั่งซื้อแล้ว
                                    </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <form action="{{ route('admin.quotations.update_status', $quote) }}" method="POST" class="inline-flex items-center gap-1">
                                        @csrf
                                        <select name="status" onchange="this.form.submit()" class="text-xs font-semibold bg-gray-50 border border-gray-200 rounded-lg px-2 py-1 outline-none focus:ring-2 focus:ring-indigo-500">
                                            <option value="pending" {{ $quote->status === 'pending' ? 'selected' : '' }}>รอตรวจสอบ</option>
                                            <option value="approved" {{ $quote->status === 'approved' ? 'selected' : '' }}>อนุมัติแล้ว</option>
                                            <option value="rejected" {{ $quote->status === 'rejected' ? 'selected' : '' }}>ไม่อนุมัติ</option>
                                            <option value="ordered" {{ $quote->status === 'ordered' ? 'selected' : '' }}>สั่งซื้อแล้ว</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="py-4 px-6 text-center space-x-2">
                                    <button @click="selectedQuote = {{ json_encode($quote) }}; openDetailsModal = true;" class="text-indigo-600 hover:text-indigo-800 font-bold text-xs bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition-colors">
                                        <i class="fa-solid fa-eye mr-1"></i> ดูรายละเอียด
                                    </button>
                                    <form action="{{ route('admin.quotations.destroy', $quote) }}" method="POST" class="inline-block" onsubmit="return confirm('ยืนยันที่จะลบใบเสนอราคานี้หรือไม่?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-600 hover:text-rose-800 font-bold text-xs bg-rose-50 hover:bg-rose-100 px-3 py-1.5 rounded-lg transition-colors">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="py-10 text-center text-gray-500">
                                    <i class="fa-solid fa-file-invoice-dollar text-4xl text-gray-300 mb-3 block"></i>
                                    ไม่มีใบเสนอราคาในระบบ
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($quotations->hasPages())
                <div class="p-6 border-t border-gray-100 bg-white">
                    {{ $quotations->links() }}
                </div>
                @endif
            </div>

        </div>

        <!-- Detail Modal drawer -->
        <div x-show="openDetailsModal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4" x-cloak>
            <div class="bg-white rounded-3xl shadow-xl max-w-2xl w-full max-h-[90vh] flex flex-col overflow-hidden transform transition-all" @click.away="openDetailsModal = false">
                <!-- Header -->
                <div class="bg-slate-900 text-white p-6 flex justify-between items-center">
                    <div>
                        <h4 class="font-bold text-lg" x-text="'รายละเอียดใบเสนอราคา: ' + (selectedQuote ? selectedQuote.quote_no : '')"></h4>
                        <p class="text-xs text-slate-400" x-text="'วันที่: ' + (selectedQuote ? new Date(selectedQuote.created_at).toLocaleString('th-TH') : '')"></p>
                    </div>
                    <button @click="openDetailsModal = false" class="text-slate-400 hover:text-white transition-colors text-xl">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <!-- Body -->
                <div class="p-6 overflow-y-auto flex-grow space-y-6 text-sm text-slate-700">
                    <!-- Customer Details Grid -->
                    <div class="grid grid-cols-2 gap-4 bg-slate-50 p-4 rounded-2xl">
                        <div>
                            <span class="text-xs text-gray-400 block font-semibold uppercase">ชื่อลูกค้า/ผู้ติดต่อ</span>
                            <strong class="text-slate-800 text-base" x-text="selectedQuote ? selectedQuote.cust_name : ''"></strong>
                        </div>
                        <div>
                            <span class="text-xs text-gray-400 block font-semibold uppercase">หน่วยงาน/บริษัท</span>
                            <strong class="text-slate-800 text-base" x-text="selectedQuote && selectedQuote.cust_org ? selectedQuote.cust_org : '-'"></strong>
                        </div>
                        <div>
                            <span class="text-xs text-gray-400 block font-semibold uppercase">เบอร์โทรศัพท์</span>
                            <span class="text-slate-800" x-text="selectedQuote ? selectedQuote.cust_phone : '-'"></span>
                        </div>
                        <div>
                            <span class="text-xs text-gray-400 block font-semibold uppercase">อีเมล</span>
                            <span class="text-slate-800" x-text="selectedQuote ? selectedQuote.cust_email : '-'"></span>
                        </div>
                        <div class="col-span-2">
                            <span class="text-xs text-gray-400 block font-semibold uppercase">ที่อยู่จัดส่งเอกสาร</span>
                            <span class="text-slate-800" x-text="selectedQuote ? selectedQuote.cust_address : '-'"></span>
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div>
                        <h5 class="font-bold text-slate-800 mb-3 text-base border-b border-gray-100 pb-2">รายการสินค้า/บริการ</h5>
                        <div class="border border-gray-100 rounded-2xl overflow-hidden">
                            <table class="w-full text-left">
                                <thead class="bg-slate-50 text-[10px] uppercase font-bold text-slate-400">
                                    <tr>
                                        <th class="py-2.5 px-4">ชื่อสินค้า</th>
                                        <th class="py-2.5 px-4 text-center">จำนวน</th>
                                        <th class="py-2.5 px-4 text-right">ราคาต่อหน่วย</th>
                                        <th class="py-2.5 px-4 text-right">รวม</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 text-xs">
                                    <template x-if="selectedQuote && selectedQuote.items">
                                        <template x-for="item in selectedQuote.items" :key="item.id">
                                            <tr>
                                                <td class="py-3 px-4 font-semibold text-slate-800" x-text="item.name"></td>
                                                <td class="py-3 px-4 text-center" x-text="item.qty"></td>
                                                <td class="py-3 px-4 text-right" x-text="'฿' + parseFloat(item.price).toLocaleString(undefined, {minimumFractionDigits: 2})"></td>
                                                <td class="py-3 px-4 text-right font-bold text-slate-900" x-text="'฿' + (parseFloat(item.price) * parseInt(item.qty)).toLocaleString(undefined, {minimumFractionDigits: 2})"></td>
                                            </tr>
                                        </template>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Financial Summary -->
                    <div class="flex justify-end">
                        <div class="w-64 space-y-2 border-t border-gray-100 pt-3">
                            <div class="flex justify-between text-xs text-gray-500">
                                <span>ราคารวมสินค้า:</span>
                                <span x-text="selectedQuote ? '฿' + parseFloat(selectedQuote.subtotal).toLocaleString(undefined, {minimumFractionDigits: 2}) : ''"></span>
                            </div>
                            <div class="flex justify-between text-xs text-gray-500">
                                <span>ส่วนลด:</span>
                                <span class="text-rose-500" x-text="selectedQuote ? '-฿' + parseFloat(selectedQuote.discount).toLocaleString(undefined, {minimumFractionDigits: 2}) : ''"></span>
                            </div>
                            <div class="flex justify-between text-xs text-gray-500">
                                <span>มูลค่าหลังหักส่วนลด:</span>
                                <span x-text="selectedQuote ? '฿' + parseFloat(selectedQuote.before_vat).toLocaleString(undefined, {minimumFractionDigits: 2}) : ''"></span>
                            </div>
                            <div class="flex justify-between text-xs text-gray-500">
                                <span>ภาษีมูลค่าเพิ่ม VAT (7%):</span>
                                <span x-text="selectedQuote ? '฿' + parseFloat(selectedQuote.vat).toLocaleString(undefined, {minimumFractionDigits: 2}) : ''"></span>
                            </div>
                            <div class="flex justify-between font-extrabold text-slate-800 text-base border-t border-gray-100 pt-2">
                                <span>ยอดสุทธิทั้งสิ้น:</span>
                                <span class="text-indigo-600" x-text="selectedQuote ? '฿' + parseFloat(selectedQuote.net_total).toLocaleString(undefined, {minimumFractionDigits: 2}) : ''"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="p-6 bg-slate-50 border-t border-gray-100 flex justify-end gap-3">
                    <a :href="selectedQuote ? '{{ route('quotation.generate') }}?items=' + selectedQuote.items.map(i => i.id).join(',') : '#'" target="_blank" class="px-4 py-2 border border-slate-300 rounded-xl hover:bg-slate-100 font-bold transition-all text-xs text-slate-700">
                        🖨️ เปิดพิมพ์เอกสาร
                    </a>
                    <button @click="openDetailsModal = false" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white font-bold rounded-xl transition-all text-xs">
                        ปิดหน้าต่าง
                    </button>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>

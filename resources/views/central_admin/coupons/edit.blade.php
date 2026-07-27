<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center justify-between">
            <span class="flex items-center gap-2">
                <i class="fa-solid fa-pen-to-square text-indigo-600"></i>
                แก้ไขคูปองส่วนลด: {{ $coupon->code }}
            </span>
            <a href="{{ route('central_admin.coupons.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold transition text-xs">
                ← กลับไปหน้ารายการคูปอง
            </a>
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50/50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-gray-100 p-8">
                <form action="{{ route('central_admin.coupons.update', $coupon) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-5">
                        <label class="block text-sm font-bold text-slate-700 mb-2">ชื่อแคมเปญคูปอง (เช่น ส่วนลดต้อนรับสมาชิกใหม่)</label>
                        <input type="text" name="name" value="{{ old('name', $coupon->name) }}" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 font-semibold" placeholder="ระบุชื่อโปรโมชันหรือคูปอง">
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-bold text-slate-700 mb-2">รหัสโค้ดคูปอง (ตัวพิมพ์ใหญ่ เช่น DISCOUNT50)</label>
                        <input type="text" name="code" value="{{ old('code', $coupon->code) }}" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 font-mono font-bold text-indigo-600 uppercase" required placeholder="เช่น SUMMER100">
                    </div>

                    <!-- Section 8.1: Coupon product selection -->
                    <div class="mb-5 bg-indigo-50/40 p-4 rounded-2xl border border-indigo-100">
                        <label class="block text-sm font-bold text-indigo-900 mb-2 flex items-center gap-2">
                            <i class="fa-solid fa-mobile-screen text-indigo-600"></i> เลือกสินค้าเฉพาะตัวที่ให้ใช้คูปองได้ (Section 8.1)
                        </label>
                        <select name="product_id" class="mt-1 block w-full rounded-xl border-indigo-200 shadow-sm focus:border-indigo-500 font-semibold text-slate-800">
                            <option value="">🎁 -- ใช้ได้กับสินค้าทุกชิ้นในร้าน DDPHONE --</option>
                            @foreach($products as $prod)
                                <option value="{{ $prod->id }}" {{ old('product_id', $coupon->product_id) == $prod->id ? 'selected' : '' }}>
                                    📱 {{ $prod->name }} (SKU: {{ $prod->sku ?? $prod->id }}) - ฿{{ number_format($prod->price, 0) }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-[11px] text-indigo-600 font-medium mt-1.5">* หากเลือกสินค้าเฉพาะ คูปองนี้จะสามารถนำไปใช้ลดราคาได้เฉพาะตอนซื้อสินค้าชิ้นที่เลือกเท่านั้น</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">จำนวนส่วนลด (บาท)</label>
                            <input type="number" step="0.01" name="discount_amount" value="{{ old('discount_amount', $coupon->discount_amount) }}" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 font-bold text-rose-600 text-lg" required min="0" placeholder="เช่น 500.00">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">วันหมดอายุ (Expires At)</label>
                            <input type="date" name="expires_at" value="{{ old('expires_at', \Carbon\Carbon::parse($coupon->expires_at)->format('Y-m-d')) }}" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 font-semibold" required min="{{ date('Y-m-d') }}">
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100">
                        <a href="{{ route('central_admin.coupons.index') }}" class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition shadow-sm">ยกเลิก</a>
                        <button type="submit" class="px-8 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition shadow-sm">บันทึกการเปลี่ยนแปลง</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

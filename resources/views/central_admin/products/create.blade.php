<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class="fa-solid fa-plus text-indigo-600"></i>
            {{ "เพิ่มสินค้าใหม่" }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50/50 min-h-screen">
            @if($errors->any())
            <div class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 text-rose-800 rounded-r-xl shadow-sm">
                <div class="font-bold flex items-center gap-2 mb-1">
                    <i class="fa-solid fa-triangle-exclamation text-rose-500"></i> กรอกข้อมูลไม่ถูกต้องตามระเบียบ:
                </div>
                <ul class="list-disc list-inside text-xs space-y-1">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-gray-100 p-8">
                
                <form action="{{ route('central_admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-2">ชื่อสินค้า</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="เช่น iPhone 15 Pro Max" required>
                        </div>
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="block text-sm font-bold text-slate-700">รหัสสินค้า / SKU</label>
                                <button type="button" onclick="autoGenerateSku()" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 bg-indigo-50 px-2.5 py-1 rounded-lg hover:bg-indigo-100 transition">
                                    <i class="fa-solid fa-bolt text-amber-500"></i> สุ่ม SKU อัตโนมัติ
                                </button>
                            </div>
                            <input type="text" id="sku-input" name="sku" value="{{ old('sku') }}" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="ปล่อยว่างไว้เพื่อสร้างรหัสอัตโนมัติ (เช่น APL-MOB-2026-X8K2P)">
                            <p class="text-[11px] text-gray-400 mt-1">* หากเว้นว่างไว้ ระบบจะสร้างรหัส SKU มาตรฐานให้อัตโนมัติเมื่อกดบันทึก</p>
                        </div>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-slate-700 mb-2">สต็อก (จำนวนคงเหลือ)</label>
                        <input type="number" name="stock" value="{{ old('stock', 0) }}" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required min="0">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">ราคาเต็ม (บาท)</label>
                            <input type="number" step="0.01" name="price" value="{{ old('price') }}" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="เช่น 35000" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">ราคาลด/ราคาโปรโมชัน (เว้นว่างถ้าไม่มี)</label>
                            <input type="number" step="0.01" name="discount_price" value="{{ old('discount_price') }}" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="เช่น 32900">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">หมวดหมู่สินค้า</label>
                            <select name="category_id" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                <option value="">-- เลือกหมวดหมู่ --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">แบรนด์สินค้า</label>
                            <select name="brand_id" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                <option value="">-- เลือกแบรนด์ --</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-bold text-slate-700 mb-2">รายละเอียดสินค้า</label>
                        <textarea name="description" rows="4" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="อธิบายรายละเอียด ประกันศูนย์ ฯลฯ">{{ old('description') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">ของแถม (Freebie / Gift)</label>
                            <input type="text" name="freebie" value="{{ old('freebie') }}" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="เช่น เคสใส + ฟิล์มกระจกกันรอย">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">สเปกสินค้า (Specifications)</label>
                            <textarea name="specifications" rows="2" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="เช่น ชิป A17 Pro, จอ Super Retina XDR 6.7 นิ้ว, กล้อง 48MP">{{ old('specifications') }}</textarea>
                        </div>
                    </div>

                    <!-- Section 8.2: Installment Options (มีผ่อนชำระ / ไม่มีผ่อนชำระ) -->
                    <div class="mb-6 bg-slate-50 p-4 rounded-2xl border border-slate-200" x-data="{ hasInstallment: {{ old('installment_details') ? 'true' : 'false' }} }">
                        <div class="flex items-center justify-between mb-3">
                            <label class="font-bold text-slate-800 text-sm flex items-center gap-2">
                                <i class="fa-solid fa-credit-card text-blue-600"></i> เงื่อนไขการผ่อนชำระสินค้า
                            </label>
                            <div class="flex items-center gap-4">
                                <label class="inline-flex items-center cursor-pointer gap-2 font-bold text-xs text-slate-700">
                                    <input type="radio" name="has_installment_radio" value="0" @click="hasInstallment = false" :checked="!hasInstallment" class="text-indigo-600">
                                    <span>ไม่มีผ่อนชำระ</span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer gap-2 font-bold text-xs text-blue-600">
                                    <input type="radio" name="has_installment_radio" value="1" @click="hasInstallment = true" :checked="hasInstallment" class="text-indigo-600">
                                    <span>มีผ่อนชำระ</span>
                                </label>
                            </div>
                        </div>
                        <div x-show="hasInstallment" style="display: none;" class="mt-3">
                            <label class="block text-xs font-bold text-slate-600 mb-1">ระบุรายละเอียดผ่อนชำระ (เช่น ผ่อนเริ่มต้น ฿2,990 / เดือน นาน 10 เดือน)</label>
                            <input type="text" name="installment_details" value="{{ old('installment_details') }}" class="block w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 font-semibold text-sm" placeholder="เช่น ผ่อนชำระเริ่มต้น ฿2,990 / เดือน (สูงสุด 10 เดือน)">
                            <p class="text-[11px] text-blue-600 font-semibold mt-1">* หากเลือก 'มีผ่อนชำระ' และระบุรายละเอียด รายละเอียดผ่อนชำระนี้จะไปแสดงผลในหน้าสินค้า</p>
                        </div>
                    </div>

                    <!-- Upload Input with AlpineJS Preview -->
                    <div class="mb-8" x-data="{ previewImages: [] }">
                        <label class="block text-sm font-bold text-slate-700 mb-2 flex items-center gap-2">
                            <span>รูปภาพสินค้า <span class="text-rose-500">* (จำเป็นต้องแนบอย่างน้อย 1 รูปภาพ)</span></span>
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed rounded-2xl transition relative" :class="previewImages.length > 0 ? 'border-indigo-400 bg-indigo-50/20' : 'border-rose-300 bg-rose-50/20'">
                            <div class="space-y-1 text-center">
                                <i class="fa-solid fa-images text-3xl mb-2" :class="previewImages.length > 0 ? 'text-indigo-500' : 'text-rose-400'"></i>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <label class="relative cursor-pointer bg-white px-3 py-1.5 rounded-xl font-bold shadow-sm text-indigo-600 hover:text-indigo-500 focus-within:outline-none border border-indigo-200">
                                        <span>คลิกเพื่อเลือกไฟล์รูปภาพสินค้า</span>
                                        <input type="file" name="images[]" accept="image/*" required @change="previewImages = Array.from($event.target.files).map(file => URL.createObjectURL(file))" multiple class="sr-only">
                                    </label>
                                </div>
                                <p class="text-xs font-semibold text-slate-500">รองรับไฟล์ PNG, JPG, JPEG, WEBP ขนาดไม่เกิน 50MB ต่อรูปภาพ</p>
                            </div>
                        </div>

                        <!-- Preview Grid -->
                        <div x-show="previewImages.length > 0" class="mt-6" style="display: none;">
                            <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3 flex items-center gap-1">
                                <i class="fa-solid fa-circle-check text-indigo-500"></i> ตัวอย่างรูปภาพที่คุณเลือก (รูปแรกจะเป็นภาพหน้าปกอัตโนมัติ)
                            </h4>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                                <template x-for="(url, idx) in previewImages" :key="idx">
                                    <div class="border rounded-2xl p-2 bg-indigo-50/20 flex flex-col items-center justify-between relative shadow-sm border-indigo-100">
                                        <img :src="url" class="h-24 object-contain rounded-xl">
                                        <span class="text-[10px] text-indigo-600 mt-2 font-bold px-2 py-0.5 bg-indigo-50 rounded-full" x-text="idx === 0 ? '★ รูปหน้าปกหลัก' : 'รูปประกอบที่ ' + idx"></span>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100">
                        <a href="{{ route('central_admin.products.index') }}" class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition shadow-sm">
                            ยกเลิก
                        </a>
                        <button type="submit" onclick="if(this.form.checkValidity()) { this.disabled=true; this.innerText='⏳ กำลังบันทึกข้อมูลสินค้า...'; this.form.submit(); }" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition shadow-sm">
                            บันทึกข้อมูลสินค้า
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function autoGenerateSku() {
            const brandId = document.querySelector('select[name="brand_id"]')?.value || '';
            const catId = document.querySelector('select[name="category_id"]')?.value || '';
            const input = document.getElementById('sku-input');
            
            fetch(`/central-admin/products/generate-sku?brand_id=${brandId}&category_id=${catId}`)
                .then(res => res.json())
                .then(data => {
                    if (data.sku) {
                        input.value = data.sku;
                    }
                })
                .catch(err => {
                    console.error(err);
                });
        }
    </script>
</x-app-layout>
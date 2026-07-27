<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class="fa-solid fa-pen-to-square text-indigo-600"></i>
            แก้ไขข้อมูลสินค้า: {{ $product->name }}
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
                
                <!-- Current Product Images Manager (show FIRST so admin sees existing images) -->
                @if(count($product->images) > 0)
                <div class="mb-8">
                    <label class="block text-sm font-bold text-slate-700 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-images text-indigo-500"></i>
                        รูปภาพปัจจุบันของสินค้า ({{ count($product->images) }} รูป)
                    </label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-5">
                        @foreach($product->images as $img)
                            <div class="border-2 rounded-2xl p-3 flex flex-col items-center justify-between relative shadow-sm transition-all hover:shadow-md {{ $img->is_primary ? 'border-amber-400 bg-amber-50/30' : 'border-gray-200 bg-white' }}">
                                
                                @if($img->is_primary)
                                <div class="absolute -top-2.5 -left-2.5 bg-amber-500 text-white rounded-full w-7 h-7 flex items-center justify-center text-xs shadow-md">
                                    <i class="fa-solid fa-star"></i>
                                </div>
                                @endif

                                @if(str_starts_with($img->image_path, 'http'))
                                    <img src="{{ $img->image_path }}" alt="Product Image" class="h-28 w-full object-contain rounded-xl bg-white p-1 mb-3">
                                @else
                                    <img src="{{ Storage::url($img->image_path) }}" alt="Product Image" class="h-28 w-full object-contain rounded-xl bg-white p-1 mb-3">
                                @endif
                                
                                <div class="w-full flex flex-col gap-1.5">
                                    @if($img->is_primary)
                                        <span class="text-xs bg-gradient-to-r from-amber-500 to-amber-600 text-white px-2 py-1.5 rounded-lg text-center font-bold shadow-sm flex items-center justify-center gap-1">
                                            <i class="fa-solid fa-star text-[10px]"></i> รูปหน้าปก
                                        </span>
                                    @else
                                        <form action="{{ route('central_admin.products.images.primary', $img) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-xs w-full bg-indigo-600 hover:bg-indigo-700 text-white py-1.5 rounded-lg text-center font-semibold transition shadow-sm flex items-center justify-center gap-1">
                                                <i class="fa-solid fa-image text-[10px]"></i> ตั้งเป็นหน้าปก
                                            </button>
                                        </form>
                                        <form action="{{ route('central_admin.products.images.delete', $img) }}" method="POST" onsubmit="return confirm('ยืนยันลบรูปภาพนี้?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-xs w-full bg-rose-500 hover:bg-rose-600 text-white py-1.5 rounded-lg text-center font-semibold transition shadow-sm flex items-center justify-center gap-1">
                                                <i class="fa-solid fa-trash-can text-[10px]"></i> ลบรูปภาพ
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <hr class="border-gray-100 mb-8">
                @else
                <div class="mb-8 p-6 bg-amber-50 border border-amber-200 rounded-2xl text-center">
                    <i class="fa-solid fa-image text-amber-400 text-3xl mb-2"></i>
                    <p class="text-amber-700 font-semibold">ยังไม่มีรูปภาพสำหรับสินค้าชิ้นนี้</p>
                    <p class="text-amber-600 text-sm mt-1">กรุณาอัปโหลดรูปภาพด้านล่าง</p>
                </div>
                @endif

                <form action="{{ route('central_admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-2">ชื่อสินค้า</label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">รหัสสินค้า / SKU</label>
                            <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="เช่น SKU-IP15P-256">
                        </div>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-slate-700 mb-2">สต็อก (จำนวน)</label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required min="0">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">ราคาเต็ม (บาท)</label>
                            <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">ราคาลด (เว้นว่างถ้าไม่มี)</label>
                            <input type="number" step="0.01" name="discount_price" value="{{ old('discount_price', $product->discount_price) }}" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">หมวดหมู่สินค้า</label>
                            <select name="category_id" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ (old('category_id', $product->category_id) == $cat->id) ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">แบรนด์สินค้า</label>
                            <select name="brand_id" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ (old('brand_id', $product->brand_id) == $brand->id) ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-bold text-slate-700 mb-2">รายละเอียดสินค้า</label>
                        <textarea name="description" rows="4" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">ของแถม (Freebie / Gift)</label>
                            <input type="text" name="freebie" value="{{ old('freebie', $product->freebie) }}" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="เช่น เคสใส + ฟิล์มกระจกกันรอย">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">สเปกสินค้า (Specifications)</label>
                            <textarea name="specifications" rows="2" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="เช่น ชิป A17 Pro, จอ Super Retina XDR 6.7 นิ้ว, กล้อง 48MP">{{ old('specifications', $product->specifications) }}</textarea>
                        </div>
                    </div>

                    <!-- Section 8.2: Installment Options (มีผ่อนชำระ / ไม่มีผ่อนชำระ) -->
                    <div class="mb-6 bg-slate-50 p-4 rounded-2xl border border-slate-200" x-data="{ hasInstallment: {{ old('installment_details', $product->installment_details) ? 'true' : 'false' }} }">
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
                        <div x-show="hasInstallment" style="display: {{ old('installment_details', $product->installment_details) ? 'block' : 'none' }};" class="mt-3">
                            <label class="block text-xs font-bold text-slate-600 mb-1">ระบุรายละเอียดผ่อนชำระ (เช่น ผ่อนเริ่มต้น ฿2,990 / เดือน นาน 10 เดือน)</label>
                            <input type="text" name="installment_details" value="{{ old('installment_details', $product->installment_details) }}" class="block w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 font-semibold text-sm" placeholder="เช่น ผ่อนชำระเริ่มต้น ฿2,990 / เดือน (สูงสุด 10 เดือน)">
                            <p class="text-[11px] text-blue-600 font-semibold mt-1">* หากเลือก 'มีผ่อนชำระ' และระบุรายละเอียด รายละเอียดผ่อนชำระนี้จะไปแสดงผลในหน้าสินค้า</p>
                        </div>
                    </div>

                    <!-- Upload New Images -->
                    <div class="mb-8" x-data="{ previewImages: [] }">
                        <label class="block text-sm font-bold text-slate-700 mb-2 flex items-center gap-2">
                            <i class="fa-solid fa-cloud-arrow-up text-indigo-500"></i>
                            อัปโหลดรูปภาพเพิ่มเติม
                        </label>
                        <label class="mt-1 flex justify-center px-6 pt-6 pb-7 border-2 border-gray-200 border-dashed rounded-2xl bg-slate-50/50 hover:bg-indigo-50/30 hover:border-indigo-300 transition cursor-pointer">
                            <div class="space-y-2 text-center">
                                <i class="fa-solid fa-cloud-arrow-up text-slate-400 text-4xl"></i>
                                <div class="text-sm font-semibold text-indigo-600">คลิกเพื่อเลือกไฟล์ภาพ</div>
                                <p class="text-xs text-slate-400">PNG, JPG, JPEG, WEBP ขนาดไม่เกิน 2MB ต่อรูป</p>
                            </div>
                            <input type="file" name="images[]" accept="image/*" 
                                   @change="previewImages = Array.from($event.target.files).map(file => URL.createObjectURL(file))" 
                                   multiple class="hidden">
                        </label>

                        <!-- Preview New Uploads -->
                        <div x-show="previewImages.length > 0" class="mt-5" x-cloak>
                            <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3 flex items-center gap-1">
                                <i class="fa-solid fa-circle-check text-indigo-500"></i> 
                                ตัวอย่างรูปภาพใหม่ (กดบันทึกเพื่อจัดเก็บ)
                            </h4>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                                <template x-for="(url, idx) in previewImages" :key="idx">
                                    <div class="border-2 border-indigo-200 rounded-2xl p-2 bg-indigo-50/20 flex flex-col items-center justify-between shadow-sm">
                                        <img :src="url" class="h-24 w-full object-contain rounded-xl">
                                        <span class="text-[10px] text-indigo-600 mt-2 font-bold px-2 py-0.5 bg-indigo-50 rounded-full" x-text="'รูปใหม่ #' + (idx + 1)"></span>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100">
                        <a href="{{ route('central_admin.products.index') }}" class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition shadow-sm">
                            ยกเลิก
                        </a>
                        <button type="submit" class="px-8 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition shadow-sm flex items-center gap-2">
                            <i class="fa-solid fa-floppy-disk"></i> บันทึกข้อมูล
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
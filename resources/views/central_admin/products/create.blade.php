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

            <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-gray-100 p-8"
                 x-data="{
                    name: '{{ old('name') }}',
                    price: '{{ old('price') }}',
                    discountPrice: '{{ old('discount_price') }}',
                    description: '{{ old('description') }}',
                    seoTitle: '{{ old('seo_title') }}',
                    seoDescription: '{{ old('seo_description') }}',
                    seoKeywords: '{{ old('seo_keywords') }}',
                    openSeo: false,
                    
                    // Tag Pills System
                    tagInput: '',
                    tags: '{{ old('seo_keywords') }}' ? '{{ old('seo_keywords') }}'.split(',').map(s => s.trim()).filter(Boolean) : [],

                    addTag() {
                        let val = this.tagInput.replace(/,/g, '').trim();
                        if (val && !this.tags.includes(val)) {
                            this.tags.push(val);
                        }
                        this.tagInput = '';
                    },
                    handleKeyInput() {
                        if (this.tagInput.includes(',')) {
                            this.addTag();
                        }
                    },
                    removeTag(idx) {
                        this.tags.splice(idx, 1);
                    },
                    removeLastTag() {
                        if (this.tagInput === '' && this.tags.length > 0) {
                            this.tags.pop();
                        }
                    },

                    get effectivePrice() {
                        let p = parseFloat(this.discountPrice) || parseFloat(this.price) || 0;
                        return p > 0 ? '฿' + p.toLocaleString('th-TH') : '฿0';
                    },
                    get displayTitle() {
                        if (this.seoTitle && this.seoTitle.trim().length > 0) return this.seoTitle;
                        let n = this.name && this.name.trim().length > 0 ? this.name : 'ชื่อสินค้าของคุณ';
                        return n + ' - ราคา ' + this.effectivePrice + ' | DDPHONE ดีดีโฟน';
                    },
                    get displayDescription() {
                        if (this.seoDescription && this.seoDescription.trim().length > 0) return this.seoDescription;
                        if (this.description && this.description.trim().length > 0) return this.description.substring(0, 160);
                        return 'ศูนย์รวมสมาร์ทโฟนและไอแพดคัดเกรด A+ คุณภาพสูง ตรวจเช็คเครื่องแท้ 100% พร้อมประกันร้าน 30 วันเต็ม จัดส่งฟรีทั่วไทย';
                    }
                 }">
                
                <form action="{{ route('central_admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-2">ชื่อสินค้า</label>
                            <input type="text" name="name" x-model="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="เช่น iPhone 15 Pro Max" required>
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
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">สต็อก (จำนวนคงเหลือ)</label>
                            <input type="number" name="stock" value="{{ old('stock', 0) }}" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required min="0">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">🔢 หมายเลขซีเรียล / Serial Number (S/N)</label>
                            <input type="text" name="serial_number" value="{{ old('serial_number') }}" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 font-mono" placeholder="เช่น DX3DG08XN70K (ไม่กรอกก็ได้ - เฉพาะแอดมินเห็น)">
                            <p class="text-[11px] text-gray-400 mt-1">* ไม่บังคับกรอก (เฉพาะแอดมินเท่านั้นที่เห็น ใช้สำหรับเช็คการขายและส่งซ่อม/เคลมประกัน)</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">ราคาเต็ม (บาท)</label>
                            <input type="number" step="0.01" name="price" x-model="price" value="{{ old('price') }}" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="เช่น 35000" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">ราคาลด/ราคาโปรโมชัน (เว้นว่างถ้าไม่มี)</label>
                            <input type="number" step="0.01" name="discount_price" x-model="discountPrice" value="{{ old('discount_price') }}" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="เช่น 32900">
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
                        <textarea name="description" x-model="description" rows="4" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="อธิบายรายละเอียด ประกันศูนย์ ฯลฯ">{{ old('description') }}</textarea>
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

                    <!-- Live Google Search Result Preview Card (Real-time Interactive) -->
                    <div class="mb-6 bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">
                        <div class="flex items-center justify-between mb-3 border-b border-gray-100 pb-3">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 text-xs shadow-xs font-bold">
                                    <i class="fa-brands fa-google"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800 text-sm">ตัวอย่างการแสดงผลบน Google (Live Google Snippet Preview)</h4>
                                    <p class="text-[11px] text-gray-400">ภาพจำลองผลการค้นหาจริงบน Google Search อัปเดตเรียลไทม์ขณะพิมพ์</p>
                                </div>
                            </div>
                            <span class="text-[11px] font-bold px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center gap-1">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span> Real-time Live
                            </span>
                        </div>

                        <!-- Google Result Box (Authentic Google Search Result Layout) -->
                        <div class="p-4 bg-gray-50/60 rounded-xl border border-gray-200 font-sans space-y-1">
                            <!-- Site Header URL & Favicon -->
                            <div class="flex items-center gap-2 text-xs">
                                <img src="{{ asset('images/logoddphone.png') }}" class="w-4 h-4 object-contain rounded-full bg-white shadow-xs" alt="DDPHONE">
                                <div class="flex flex-col text-[11px] leading-tight">
                                    <span class="font-semibold text-slate-800">DDPHONE ดีดีโฟน</span>
                                    <span class="text-slate-500 text-[10px] truncate max-w-md">https://www.ddphone.com › products › <span x-text="name.trim() ? encodeURIComponent(name.toLowerCase().replace(/[^a-z0-9]/g, '-')) : 'product-id'"></span></span>
                                </div>
                            </div>

                            <!-- Google Result Title (Blue Link #1a0dab) -->
                            <h3 class="text-base md:text-lg font-normal text-[#1a0dab] hover:underline cursor-pointer leading-snug tracking-tight font-sans" x-text="displayTitle"></h3>

                            <!-- Rich Snippet Meta Line (Rating + Price + Stock) -->
                            <div class="flex items-center gap-2 text-xs text-[#4d5156] font-sans">
                                <span class="text-amber-500 font-bold">Rating 5.0 ★★★★★</span>
                                <span>·</span>
                                <span class="font-semibold text-slate-800" x-text="effectivePrice"></span>
                                <span>·</span>
                                <span class="text-emerald-700 font-medium">In stock</span>
                            </div>

                            <!-- Google Result Description -->
                            <p class="text-xs md:text-sm text-[#4d5156] leading-relaxed line-clamp-2 font-sans" x-text="displayDescription"></p>
                        </div>

                        <!-- Live Character Counters & Progress Indicators -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 pt-3 border-t border-gray-100 text-xs">
                            <div>
                                <div class="flex justify-between font-semibold text-slate-600 mb-1">
                                    <span>ความยาว SEO Title:</span>
                                    <span :class="displayTitle.length >= 50 && displayTitle.length <= 65 ? 'text-emerald-600 font-bold' : 'text-slate-500'" x-text="displayTitle.length + ' / 60 ตัวอักษร'"></span>
                                </div>
                                <div class="w-full h-1.5 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full transition-all duration-300" :style="'width: ' + Math.min((displayTitle.length / 60) * 100, 100) + '%'" :class="displayTitle.length > 65 ? 'bg-amber-500' : 'bg-indigo-600'"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between font-semibold text-slate-600 mb-1">
                                    <span>ความยาว SEO Description:</span>
                                    <span :class="displayDescription.length >= 120 && displayDescription.length <= 160 ? 'text-emerald-600 font-bold' : 'text-slate-500'" x-text="displayDescription.length + ' / 160 ตัวอักษร'"></span>
                                </div>
                                <div class="w-full h-1.5 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full transition-all duration-300" :style="'width: ' + Math.min((displayDescription.length / 160) * 100, 100) + '%'" :class="displayDescription.length > 160 ? 'bg-amber-500' : 'bg-indigo-600'"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 8.3: Custom Product SEO Settings (Optional with Auto-Fallback) -->
                    <div class="mb-6 bg-amber-50/60 p-5 rounded-2xl border border-amber-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-bold text-amber-900 text-sm flex items-center gap-2">
                                    <i class="fa-solid fa-magnifying-glass text-amber-600"></i> ตั้งค่า SEO สำหรับสินค้า (SEO Metadata - ไม่บังคับกรอก)
                                </h4>
                                <p class="text-[11px] text-amber-700 mt-0.5">กำหนดหัวข้อ คำบรรยาย และคีย์เวิร์ดบน Google ได้เอง หรือปล่อยว่างไว้เพื่อใช้ระบบ Smart Auto-SEO อัตโนมัติ</p>
                            </div>
                            <button type="button" @click="openSeo = !openSeo" class="text-xs font-bold px-3 py-1.5 rounded-xl bg-amber-100 text-amber-800 hover:bg-amber-200 transition">
                                <span x-show="!openSeo">✏️ ปรับแต่ง SEO</span>
                                <span x-show="openSeo">✕ ซ่อน</span>
                            </button>
                        </div>
                        <div x-show="openSeo" style="display: none;" class="mt-4 space-y-4 pt-4 border-t border-amber-200/80">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">SEO Title (ชื่อหัวข้อบน Google)</label>
                                <input type="text" name="seo_title" x-model="seoTitle" value="{{ old('seo_title') }}" class="block w-full rounded-xl border-gray-200 shadow-sm focus:border-amber-500 text-xs font-medium" placeholder="ปล่อยว่างไว้เพื่อสร้างให้อัตโนมัติ เช่น 'iPhone 15 Pro - ราคา ฿35,900 | DDPHONE'">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">SEO Description (คำบรรยายสรุปบน Google)</label>
                                <textarea name="seo_description" x-model="seoDescription" rows="2" class="block w-full rounded-xl border-gray-200 shadow-sm focus:border-amber-500 text-xs font-medium" placeholder="ปล่อยว่างไว้เพื่อดึงจากรายละเอียดสินค้าอัตโนมัติ">{{ old('seo_description') }}</textarea>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1 flex items-center justify-between">
                                    <span>SEO Keywords (แท็กคำค้นหาหลัก - พิมพ์คีย์เวิร์ดแล้วใส่เครื่องหมาย , หรือกด Enter)</span>
                                    <span class="text-[10px] text-amber-700 font-semibold" x-text="tags.length + ' แท็กคำค้นหา'"></span>
                                </label>
                                
                                <!-- Hidden input to submit concatenated comma-separated string -->
                                <input type="hidden" name="seo_keywords" :value="tags.join(', ')">

                                <!-- Interactive Tag Box Container -->
                                <div class="w-full min-h-[46px] p-2 bg-white rounded-xl border border-gray-200 focus-within:border-amber-500 focus-within:ring-2 focus-within:ring-amber-200 transition flex flex-wrap items-center gap-2">
                                    
                                    <!-- Rendered Interactive Tag Badges (Colorful Pills) -->
                                    <template x-for="(tag, index) in tags" :key="index">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gradient-to-r from-amber-500 to-amber-600 text-white font-bold text-xs rounded-lg shadow-xs transition hover:shadow-sm">
                                            <i class="fa-solid fa-tag text-[10px] opacity-80"></i>
                                            <span x-text="tag"></span>
                                            <button type="button" @click="removeTag(index)" class="w-4 h-4 ml-1 rounded-full bg-white/20 hover:bg-white/40 text-white flex items-center justify-center text-[10px] transition">
                                                ✕
                                            </button>
                                        </span>
                                    </template>

                                    <!-- Input Field for Typing -->
                                    <input type="text" 
                                           x-model="tagInput" 
                                           @input="handleKeyInput" 
                                           @keydown.enter.prevent="addTag" 
                                           @keydown.backspace="removeLastTag"
                                           class="flex-1 border-0 focus:border-0 focus:ring-0 text-xs font-medium text-slate-800 placeholder-gray-400 p-1 min-w-[150px] bg-transparent" 
                                           style="outline: none !important; border: none !important; box-shadow: none !important;"
                                           placeholder="พิมพ์คำค้นหา แล้วใส่ , (จุลภาค) เช่น iphone 15 pro,">
                                </div>
                                <p class="text-[11px] text-amber-700 font-medium mt-1">💡 เคล็ดลับ: พิมพ์คำค้นหาแล้วพิมพ์เครื่องหมายจุลภาค <code>,</code> หรือกดปุ่ม <code>Enter</code> เพื่อเปลี่ยนเป็นป้ายแท็กสีสันทันที</p>
                            </div>
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
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class="fa-solid fa-window-restore text-indigo-600"></i>
            ตกแต่งหน้าแรกและระบบจัดการ CMS
        </h2>
    </x-slot>

    {{-- Cropper.js CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>

    <style>
        /* === Cropper Modal === */
        #cropperModal {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: rgba(0, 0, 0, 0.75);
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        #cropperModal.active {
            display: flex;
        }
        .cropper-modal-box {
            background: #fff;
            border-radius: 24px;
            width: 100%;
            max-width: 900px;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(0,0,0,0.3);
        }
        .cropper-modal-header {
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            color: white;
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
        }
        .cropper-canvas-wrap {
            flex: 1;
            overflow: hidden;
            max-height: 55vh;
            background: #0f172a;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #cropperImage {
            max-width: 100%;
            max-height: 55vh;
            display: block;
        }
        .cropper-preview-wrap {
            padding: 1rem 1.5rem;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            flex-shrink: 0;
        }
        .crop-size-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #eef2ff;
            color: #4f46e5;
            font-size: 11px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 99px;
            border: 1px solid #c7d2fe;
        }
    </style>

    <div class="py-8 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
            <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-r-lg shadow-sm flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-emerald-500 text-xl"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            @endif

            @if($errors->any())
            <div class="p-4 bg-rose-50 border-l-4 border-rose-500 text-rose-800 rounded-r-lg shadow-sm flex flex-col gap-1.5">
                <div class="flex items-center gap-3 font-semibold mb-1">
                    <i class="fa-solid fa-triangle-exclamation text-rose-500 text-xl"></i>
                    <span>เกิดข้อผิดพลาดในการดำเนินงาน:</span>
                </div>
                <ul class="list-disc list-inside text-sm space-y-0.5 pl-6 font-medium">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Column 1: Slogan Settings Form & Showcase Banner 2 Form -->
                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm lg:col-span-1 h-fit space-y-6">
                    <div>
                        <h3 class="font-bold text-lg text-slate-800 mb-2 flex items-center gap-2">
                            <i class="fa-solid fa-pen-nib text-indigo-600"></i>
                            คำโฆษณา Slogan และแบนเนอร์ Showcase
                        </h3>
                        <p class="text-xs text-gray-400 mb-4">ปรับแต่งข้อความแบนเนอร์หน้าแรก และแบนเนอร์สมาร์ทโฟน 3D Showcase ได้ที่นี่</p>

                        <form action="{{ route('central_admin.cms.update_settings') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            
                            <!-- Hero Banner Slogan -->
                            <div class="p-4 bg-indigo-50/40 rounded-2xl border border-indigo-100 space-y-3">
                                <h4 class="font-bold text-sm text-indigo-900 flex items-center gap-1.5">
                                    <i class="fa-solid fa-flag text-indigo-600"></i> 1. แบนเนอร์สไลด์ด้านบนสุด (Hero)
                                </h4>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">ข้อความ Badge (หัวข้อสีเด่น)</label>
                                    <input type="text" name="slogan_badge" value="{{ $settings['slogan_badge'] }}" placeholder="เช่น 🔥 โปรโมชันพิเศษ!" 
                                           class="w-full rounded-xl border-gray-200 focus:ring-indigo-200 focus:border-indigo-400 text-xs font-medium">
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">หัวข้อ Slogan หลัก</label>
                                    <input type="text" name="slogan_title" value="{{ $settings['slogan_title'] }}" required placeholder="เช่น ดีดี.ไอที.คอม ยินดีต้อนรับ" 
                                           class="w-full rounded-xl border-gray-200 focus:ring-indigo-200 focus:border-indigo-400 text-xs font-medium">
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">รายละเอียดสโลแกน</label>
                                    <textarea name="slogan_description" rows="2" placeholder="ระบุข้อความบรรยายสั้นๆ..." 
                                              class="w-full rounded-xl border-gray-200 focus:ring-indigo-200 focus:border-indigo-400 text-xs font-medium">{{ $settings['slogan_description'] }}</textarea>
                                </div>
                            </div>

                            <!-- Showcase Banner 2 -->
                            <div class="p-4 bg-slate-900 text-white rounded-2xl border border-slate-700 space-y-3">
                                <h4 class="font-bold text-sm text-amber-400 flex items-center gap-1.5">
                                    <i class="fa-solid fa-mobile-screen text-amber-400"></i> 2. แบนเนอร์ Showcase สมาร์ทโฟน
                                </h4>
                                
                                <div>
                                    <label class="block text-xs font-semibold text-slate-300 mb-1">ข้อความ Badge กล่องสีเหลือง</label>
                                    <input type="text" name="showcase_badge" value="{{ $settings['showcase_badge'] ?? '📱 DDPHONE 3D SHOWCASE' }}" 
                                           class="w-full rounded-xl border-slate-700 bg-slate-800 text-white text-xs font-medium">
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-300 mb-1">หัวข้อหลัก แบนเนอร์ที่ 2</label>
                                    <input type="text" name="showcase_title" value="{{ $settings['showcase_title'] ?? "สมาร์ทโฟนมือสองเกรด A+\nสวยกริ๊บ ไร้รอย สภาพ 99%" }}" 
                                           class="w-full rounded-xl border-slate-700 bg-slate-800 text-white text-xs font-medium">
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-300 mb-1">รายละเอียดคำบรรยาย</label>
                                    <textarea name="showcase_description" rows="2" 
                                              class="w-full rounded-xl border-slate-700 bg-slate-800 text-white text-xs font-medium">{{ $settings['showcase_description'] ?? 'คัดสรรไอโฟนและสมาร์ทโฟนแท้ 100% แบตอึด สแกนนิ้ว/กล้องเพอร์เฟกต์ การันตีประกันร้าน 30 วัน พร้อมบริการจัดส่งฟรีทั่วประเทศ' }}</textarea>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-300 mb-1">ข้อความปุ่มกด</label>
                                    <input type="text" name="showcase_button_text" value="{{ $settings['showcase_button_text'] ?? 'ช้อปมือถือโปรเด็ด ➔' }}" 
                                           class="w-full rounded-xl border-slate-700 bg-slate-800 text-white text-xs font-medium">
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-300 mb-1">ลิงก์ URL เมื่อกดปุ่ม</label>
                                    <input type="text" name="showcase_button_url" value="{{ $settings['showcase_button_url'] ?? '/products' }}" 
                                           class="w-full rounded-xl border-slate-700 bg-slate-800 text-white text-xs font-medium">
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-300 mb-1">รูปภาพไร้พื้นหลัง (Transparent PNG Cutout)</label>
                                    <input type="file" name="showcase_image_file" accept="image/png,image/webp,image/gif" 
                                           class="w-full text-xs text-slate-400 file:mr-2 file:py-1 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-amber-400 file:text-slate-900 hover:file:bg-amber-300 cursor-pointer">
                                    <span class="text-[10px] text-slate-400 block mt-1">แนะนำใช้ไฟล์ PNG ไร้พื้นหลังสีขาว (Transparent PNG)</span>
                                </div>
                            </div>

                            <!-- 3. Popular Products (HOT ITEMS) Settings -->
                            <div class="p-4 bg-amber-50/50 rounded-2xl border border-amber-200/70 space-y-3">
                                <h4 class="font-bold text-sm text-amber-900 flex items-center gap-1.5">
                                    <i class="fa-solid fa-fire text-amber-600"></i> 3. ตั้งค่าสินค้ายอดนิยม (HOT ITEMS)
                                </h4>
                                <p class="text-[11px] text-amber-800 leading-relaxed">เลือกรูปแบบการดึงข้อมูลสินค้ายอดนิยมแนะนำในหน้าแรกของร้าน</p>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">รูปแบบการเลือกแสดงผล:</label>
                                    <div class="space-y-1.5">
                                        <label class="flex items-center gap-2 p-2 bg-white rounded-xl border border-amber-200 cursor-pointer hover:bg-amber-50/30 text-xs">
                                            <input type="radio" name="popular_products_mode" value="hybrid" {{ ($settings['popular_products_mode'] ?? 'hybrid') === 'hybrid' ? 'checked' : '' }} class="text-amber-600 focus:ring-amber-500">
                                            <div>
                                                <span class="font-bold text-amber-900">✨ ไฮบริด (ผสมผสาน - แนะนำ)</span>
                                                <span class="block text-[10px] text-slate-500">แสดงสินค้าที่ปักหมุดก่อน แล้วเติมเต็มที่เหลือด้วยสินค้าขายดีจริงอัตโนมัติ</span>
                                            </div>
                                        </label>

                                        <label class="flex items-center gap-2 p-2 bg-white rounded-xl border border-amber-200 cursor-pointer hover:bg-amber-50/30 text-xs">
                                            <input type="radio" name="popular_products_mode" value="auto" {{ ($settings['popular_products_mode'] ?? '') === 'auto' ? 'checked' : '' }} class="text-amber-600 focus:ring-amber-500">
                                            <div>
                                                <span class="font-bold text-slate-800">📈 ขายดีอัตโนมัติ 100%</span>
                                                <span class="block text-[10px] text-slate-500">คำนวณจากยอดขายจริงในระบบ หรือสินค้าเรตติ้งสูง</span>
                                            </div>
                                        </label>

                                        <label class="flex items-center gap-2 p-2 bg-white rounded-xl border border-amber-200 cursor-pointer hover:bg-amber-50/30 text-xs">
                                            <input type="radio" name="popular_products_mode" value="custom" {{ ($settings['popular_products_mode'] ?? '') === 'custom' ? 'checked' : '' }} class="text-amber-600 focus:ring-amber-500">
                                            <div>
                                                <span class="font-bold text-slate-800">📌 กำหนดสินค้าเอง 100%</span>
                                                <span class="block text-[10px] text-slate-500">แสดงเฉพาะสินค้าที่เลือกปักหมุดด้านล่างนี้เท่านั้น</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1 flex items-center justify-between">
                                        <span>ปักหมุดเลือกสินค้านิยม (สำหรับโหมดไฮบริด/กำหนดเอง):</span>
                                        <span class="text-[10px] text-amber-700 font-normal">เลือกได้หลายรายการ</span>
                                    </label>
                                    
                                    <div class="max-h-48 overflow-y-auto border border-amber-200 rounded-xl bg-white p-2 space-y-1 text-xs divide-y divide-slate-100">
                                        @forelse($allProducts as $p)
                                            <label class="flex items-center justify-between py-1.5 px-2 hover:bg-amber-50/50 rounded-lg cursor-pointer transition">
                                                <div class="flex items-center gap-2 truncate">
                                                    <input type="checkbox" name="popular_product_ids[]" value="{{ $p->id }}" {{ in_array($p->id, $settings['popular_product_ids'] ?? []) ? 'checked' : '' }} class="rounded text-amber-600 focus:ring-amber-500">
                                                    <span class="truncate font-medium text-slate-800">{{ $p->name }}</span>
                                                </div>
                                                <span class="text-[10px] font-bold text-emerald-600 flex-shrink-0">฿{{ number_format($p->discount_price ?: $p->price) }}</span>
                                            </label>
                                        @empty
                                            <p class="text-slate-400 text-center py-3 text-xs">ยังไม่มีสินค้าในระบบ</p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl transition shadow-md text-sm">
                                บันทึกการตั้งค่าทั้งหมด
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Column 2 & 3: Banners Management -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Banner Size Guide Card -->
                    <div class="bg-gradient-to-br from-indigo-50 to-blue-50/50 border border-indigo-100 rounded-2xl p-4 flex items-start gap-4">
                        <div class="w-10 h-10 bg-indigo-600 text-white rounded-xl flex items-center justify-center text-lg flex-shrink-0 shadow-sm">
                            <i class="fa-solid fa-ruler-combined"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-indigo-800 text-sm mb-1">📐 ขนาดมาตรฐานของแบนเนอร์บนเว็บไซต์</h4>
                            <p class="text-xs text-indigo-700">แบนเนอร์บนเว็บไซต์ใช้อัตราส่วน <strong>3:1</strong> (กว้าง × สูง = 1200 × 400px) — เครื่องมือครอปรูปด้านล่างจะล็อกอัตราส่วนนี้ให้โดยอัตโนมัติ เพื่อให้รูปภาพแสดงผลพอดีกับแบนเนอร์บนเว็บไซต์ทุกขนาดหน้าจอ</p>
                        </div>
                    </div>

                    <!-- Upload Banner Form with Cropper -->
                    <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
                        <h3 class="font-bold text-lg text-slate-800 mb-1 flex items-center gap-2">
                            <i class="fa-solid fa-circle-plus text-indigo-600"></i>
                            อัปโหลดรูปภาพสไลด์แบนเนอร์ใหม่
                        </h3>
                        <p class="text-xs text-gray-400 mb-5">หลังจากเลือกไฟล์รูปภาพแล้ว ระบบจะเปิดหน้าต่างครอปรูปให้อัตโนมัติ พร้อม Preview ก่อนบันทึก</p>
                        
                        {{-- Hidden form that actually submits the cropped image --}}
                        <form id="bannerUploadForm" action="{{ route('central_admin.cms.banners.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            {{-- Hidden inputs sent to backend --}}
                            <input type="hidden" name="cropped_image_data" id="croppedImageData">
                            <input type="hidden" name="link_url" id="hiddenLinkUrl">
                            <input type="hidden" name="sort_order" id="hiddenSortOrder">
                            <input type="hidden" name="image_url" id="hiddenImageUrl">
                        </form>

                        {{-- Visible UI form (not submitted directly) --}}
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="p-4 border border-indigo-100 bg-indigo-50/20 rounded-2xl">
                                    <label class="block text-sm font-semibold text-slate-700 mb-1.5 flex items-center gap-1.5">
                                        <span class="bg-indigo-600 text-white text-[10px] px-1.5 py-0.5 rounded-full">วิธีที่ 1</span>
                                        วางลิงก์รูปภาพออนไลน์
                                    </label>
                                    <input type="url" id="uiImageUrl" placeholder="เช่น https://imgur.com/your-image.jpg" 
                                           class="w-full rounded-xl border-gray-200 focus:ring-indigo-200 focus:border-indigo-400 text-sm font-medium bg-white">
                                    <button type="button" onclick="loadUrlForCrop()" class="mt-2 w-full bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-bold py-2 rounded-xl text-xs transition flex items-center justify-center gap-1.5">
                                        <i class="fa-solid fa-crop-simple"></i> โหลดและครอปรูปจาก URL
                                    </button>
                                    <span class="text-[10px] text-gray-400 block mt-1">ใส่ลิงก์รูปภาพ แล้วกดปุ่มด้านบนเพื่อเปิดเครื่องมือครอป</span>
                                </div>

                                <div class="p-4 border border-gray-150 bg-gray-50/50 rounded-2xl">
                                    <label class="block text-sm font-semibold text-slate-700 mb-1.5 flex items-center gap-1.5">
                                        <span class="bg-slate-500 text-white text-[10px] px-1.5 py-0.5 rounded-full">วิธีที่ 2</span>
                                        อัปโหลดไฟล์จากเครื่อง
                                    </label>
                                    <label class="flex flex-col items-center justify-center w-full h-20 border-2 border-dashed border-indigo-200 rounded-xl cursor-pointer bg-white hover:bg-indigo-50/30 transition group">
                                        <i class="fa-solid fa-cloud-arrow-up text-2xl text-indigo-400 group-hover:text-indigo-600 transition mb-1"></i>
                                        <span class="text-xs text-slate-500 font-medium">คลิกเพื่อเลือกรูปภาพ</span>
                                        <input type="file" id="bannerFileInput" accept="image/*" class="sr-only" onchange="openCropperModal(this)">
                                    </label>
                                    <span class="text-[10px] text-gray-400 block mt-1">รองรับ JPG, PNG, WebP, GIF (ไม่เกิน 5MB)</span>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">ลิงก์ URL เมื่อกดรูปภาพ (ไม่บังคับ)</label>
                                    <input type="url" id="uiLinkUrl" placeholder="https://example.com/promotions" 
                                           class="w-full rounded-xl border-gray-200 focus:ring-indigo-200 focus:border-indigo-400 text-sm font-medium">
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">ลำดับการเรียง (Sort Order)</label>
                                    <input type="number" id="uiSortOrder" value="0" min="0" 
                                           class="w-full rounded-xl border-gray-200 focus:ring-indigo-200 focus:border-indigo-400 text-sm font-medium">
                                </div>
                            </div>

                            {{-- Cropped Preview --}}
                            <div id="cropResultPreview" style="display:none;" class="mt-2">
                                <p class="text-xs font-bold text-emerald-700 mb-2 flex items-center gap-1.5">
                                    <i class="fa-solid fa-circle-check text-emerald-500"></i> ตัวอย่างรูปหลังจากครอปแล้ว (พร้อมบันทึก)
                                </p>
                                <div style="width: 100%; aspect-ratio: 3/1; border-radius: 12px; overflow: hidden; border: 2px solid #6366f1; background: #0f172a; position: relative;">
                                    <img id="cropResultImg" src="" alt="Cropped Preview" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                                    <div style="position: absolute; top: 8px; right: 8px; background: #4f46e5; color: white; font-size: 10px; font-weight: 700; padding: 3px 8px; border-radius: 99px;">
                                        ✅ พร้อมอัปโหลด 3:1
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end pt-2 gap-3">
                                <button type="button" id="recropBtn" onclick="recropImage()" style="display:none;"
                                        class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-3 px-6 rounded-xl transition text-sm flex items-center gap-2">
                                    <i class="fa-solid fa-crop-simple"></i> ครอปใหม่
                                </button>
                                <button type="button" onclick="submitBannerForm()" 
                                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-10 rounded-xl transition shadow-md flex items-center gap-2">
                                    <i class="fa-solid fa-cloud-arrow-up"></i> บันทึกและเพิ่มสไลด์แบนเนอร์
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Banners Listing -->
                    <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
                        <h3 class="font-bold text-lg text-slate-800 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-images text-indigo-600"></i>
                            รายการแบนเนอร์ปัจจุบันที่เปิดใช้งาน
                        </h3>
                        <p class="text-xs text-gray-400 mb-6">หากมีการลงทะเบียนรูปภาพสไลด์แบนเนอร์ ระบบหน้าแรกจะสลับมาแสดงแบนเนอร์เหล่านี้แทนภาพสีพื้นหลังเริ่มต้นโดยอัตโนมัติ</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @forelse($banners as $banner)
                            <div class="border border-gray-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition bg-gray-50 flex flex-col justify-between group">
                                <div class="aspect-[3/1] bg-gray-200 overflow-hidden relative">
                                    <img src="{{ str_starts_with($banner->image_path, 'http') ? $banner->image_path : Storage::url($banner->image_path) }}" alt="Banner" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    <span class="absolute top-2 left-2 bg-indigo-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-md shadow-sm">
                                        ลำดับ: {{ $banner->sort_order }}
                                    </span>
                                    <span class="absolute top-2 right-2 bg-black/50 text-white text-[10px] font-bold px-2 py-0.5 rounded-md backdrop-blur-sm">
                                        3:1
                                    </span>
                                </div>
                                <div class="p-3 flex justify-between items-center gap-2 bg-white">
                                    <div class="text-[11px] text-gray-400 truncate flex-grow" title="{{ $banner->link_url }}">
                                        {{ $banner->link_url ? "🔗 {$banner->link_url}" : "❌ ไม่มีลิงก์เชื่อมโยง" }}
                                    </div>
                                    <form action="{{ route('central_admin.cms.banners.destroy', $banner) }}" method="POST" onsubmit="return confirm('ยืนยันที่จะลบรูปสไลด์แบนเนอร์นี้?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-rose-50 text-rose-600 hover:bg-rose-100 px-3 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1">
                                            <i class="fa-solid fa-trash-can"></i> ลบรูป
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @empty
                            <div class="col-span-2 py-12 text-center text-slate-400">
                                <i class="fa-solid fa-mountain-sun text-4xl mb-2 block"></i>
                                ยังไม่มีภาพสไลด์โฆษณาในระบบ (แสดงผลหน้าพื้นหลังสีดาร์คโหมดของร้านเริ่มต้น)
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- ======= CROPPER.JS MODAL ======= -->
    <div id="cropperModal">
        <div class="cropper-modal-box">
            <!-- Header -->
            <div class="cropper-modal-header">
                <div class="flex items-center gap-3">
                    <div style="width:36px;height:36px;background:rgba(255,255,255,0.2);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <i class="fa-solid fa-crop-simple text-white"></i>
                    </div>
                    <div>
                        <p class="font-bold text-base leading-tight">ครอปรูปภาพแบนเนอร์</p>
                        <p class="text-indigo-200 text-xs">ล็อกอัตราส่วน 3:1 (1200×400px) เพื่อให้พอดีกับแบนเนอร์บนเว็บไซต์</p>
                    </div>
                </div>
                <button onclick="closeCropperModal()" style="background:rgba(255,255,255,0.15);border:none;color:white;width:32px;height:32px;border-radius:8px;cursor:pointer;font-size:16px;display:flex;align-items:center;justify-content:center;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Cropper Canvas -->
            <div class="cropper-canvas-wrap">
                <img id="cropperImage" src="" alt="Crop Image">
            </div>

            <!-- Controls Footer -->
            <div class="cropper-preview-wrap">
                <div class="flex items-center justify-between flex-wrap gap-3">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="crop-size-badge"><i class="fa-solid fa-ruler-horizontal"></i> 3:1 (1200×400px)</span>
                        <span class="crop-size-badge"><i class="fa-solid fa-lock"></i> อัตราส่วนล็อกแล้ว</span>

                        <!-- Rotate buttons -->
                        <button onclick="cropperInstance.rotate(-90)" style="background:#f1f5f9;border:1px solid #e2e8f0;border-radius:8px;padding:6px 12px;font-size:11px;font-weight:700;cursor:pointer;color:#475569;display:flex;align-items:center;gap:4px;">
                            <i class="fa-solid fa-rotate-left"></i> หมุนซ้าย
                        </button>
                        <button onclick="cropperInstance.rotate(90)" style="background:#f1f5f9;border:1px solid #e2e8f0;border-radius:8px;padding:6px 12px;font-size:11px;font-weight:700;cursor:pointer;color:#475569;display:flex;align-items:center;gap:4px;">
                            <i class="fa-solid fa-rotate-right"></i> หมุนขวา
                        </button>
                        <button onclick="cropperInstance.reset()" style="background:#f1f5f9;border:1px solid #e2e8f0;border-radius:8px;padding:6px 12px;font-size:11px;font-weight:700;cursor:pointer;color:#475569;display:flex;align-items:center;gap:4px;">
                            <i class="fa-solid fa-arrows-rotate"></i> รีเซ็ต
                        </button>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="closeCropperModal()" style="background:#f1f5f9;border:1px solid #e2e8f0;border-radius:12px;padding:10px 18px;font-size:13px;font-weight:700;cursor:pointer;color:#64748b;">
                            ยกเลิก
                        </button>
                        <button onclick="applyCrop()" style="background:linear-gradient(135deg,#4f46e5,#6366f1);border:none;border-radius:12px;padding:10px 22px;font-size:13px;font-weight:700;cursor:pointer;color:white;display:flex;align-items:center;gap:6px;box-shadow:0 4px 12px rgba(79,70,229,0.3);">
                            <i class="fa-solid fa-check"></i> ยืนยันการครอป
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ======= JAVASCRIPT ======= -->
    <script>
    let cropperInstance = null;
    let currentSourceType = 'file'; // 'file' or 'url'
    let originalFileObjectUrl = null;

    // === Open Cropper from file input ===
    function openCropperModal(input) {
        if (!input.files || !input.files[0]) return;
        const file = input.files[0];
        if (file.size > 5 * 1024 * 1024) {
            alert('ขนาดไฟล์เกิน 5MB กรุณาเลือกรูปภาพที่มีขนาดเล็กลง');
            input.value = '';
            return;
        }
        currentSourceType = 'file';
        const reader = new FileReader();
        reader.onload = function(e) {
            originalFileObjectUrl = e.target.result;
            showCropperModal(e.target.result);
        };
        reader.readAsDataURL(file);
    }

    // === Open Cropper from URL ===
    function loadUrlForCrop() {
        const url = document.getElementById('uiImageUrl').value.trim();
        if (!url) { alert('กรุณากรอก URL รูปภาพก่อนครับ'); return; }
        currentSourceType = 'url';
        // Use a proxy-friendly approach — load via <img> with crossOrigin
        const testImg = new Image();
        testImg.crossOrigin = 'anonymous';
        testImg.onload = function() {
            originalFileObjectUrl = url;
            showCropperModal(url);
        };
        testImg.onerror = function() {
            // Fallback: just try to display it directly (CORS may block canvas export)
            originalFileObjectUrl = url;
            showCropperModal(url);
        };
        testImg.src = url + '?' + Date.now();
    }

    // === Show modal and init Cropper.js ===
    function showCropperModal(src) {
        const modal = document.getElementById('cropperModal');
        const img = document.getElementById('cropperImage');
        img.src = src;
        modal.classList.add('active');

        // Destroy previous cropper instance if exists
        if (cropperInstance) {
            cropperInstance.destroy();
            cropperInstance = null;
        }

        img.onload = function() {
            cropperInstance = new Cropper(img, {
                aspectRatio: 3 / 1,       // Lock to 3:1 (1200×400)
                viewMode: 1,              // Restrict crop box to canvas
                autoCropArea: 1,          // Fill canvas by default
                movable: true,
                zoomable: true,
                rotatable: true,
                scalable: true,
                responsive: true,
                restore: false,
                guides: true,
                center: true,
                highlight: true,
                cropBoxMovable: true,
                cropBoxResizable: true,
                toggleDragModeOnDblclick: false,
            });
        };
    }

    // === Close modal ===
    function closeCropperModal() {
        document.getElementById('cropperModal').classList.remove('active');
        if (cropperInstance) {
            cropperInstance.destroy();
            cropperInstance = null;
        }
        // Reset file input so user can re-select the same file
        document.getElementById('bannerFileInput').value = '';
    }

    // === Apply crop — get canvas data and show preview ===
    function applyCrop() {
        if (!cropperInstance) return;

        let canvas;
        try {
            canvas = cropperInstance.getCroppedCanvas({
                width: 1200,
                height: 400,
                fillColor: '#FFFFFF',
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            });
        } catch(e) {
            // CORS block on external URL — warn user
            alert('ไม่สามารถครอปรูปจาก URL ภายนอกได้เนื่องจากข้อจำกัด CORS\nกรุณาดาวน์โหลดรูปก่อน แล้วอัปโหลดเป็นไฟล์แทน (วิธีที่ 2)');
            closeCropperModal();
            return;
        }

        if (!canvas) {
            alert('ไม่สามารถครอปรูปภาพได้ กรุณาลองใหม่อีกครั้ง');
            return;
        }

        const dataUrl = canvas.toDataURL('image/jpeg', 0.92);

        // Store cropped data
        document.getElementById('croppedImageData').value = dataUrl;

        // Show preview
        document.getElementById('cropResultImg').src = dataUrl;
        document.getElementById('cropResultPreview').style.display = 'block';
        document.getElementById('recropBtn').style.display = 'inline-flex';

        closeCropperModal();
    }

    // === Re-crop: open cropper again with same image ===
    function recropImage() {
        if (originalFileObjectUrl) {
            showCropperModal(originalFileObjectUrl);
        }
    }

    // === Final form submission ===
    function submitBannerForm() {
        const croppedData = document.getElementById('croppedImageData').value;
        const imageUrl    = document.getElementById('uiImageUrl').value.trim();

        if (!croppedData && !imageUrl) {
            alert('กรุณาเลือกรูปภาพและทำการครอปก่อนบันทึกครับ');
            return;
        }

        // Fill in the hidden form fields
        document.getElementById('hiddenLinkUrl').value   = document.getElementById('uiLinkUrl').value;
        document.getElementById('hiddenSortOrder').value = document.getElementById('uiSortOrder').value || '0';

        if (croppedData) {
            // Cropped image will be sent as base64 data
            document.getElementById('hiddenImageUrl').value = '';
        } else {
            // No crop was done — send URL directly (fallback)
            document.getElementById('hiddenImageUrl').value = imageUrl;
        }

        document.getElementById('bannerUploadForm').submit();
    }

    // === Close modal on backdrop click ===
    document.getElementById('cropperModal').addEventListener('click', function(e) {
        if (e.target === this) closeCropperModal();
    });
    </script>

</x-app-layout>

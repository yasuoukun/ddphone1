@extends('layouts.store')

@section('content')
<div class="container service-center-container" style="max-width: 1000px; margin: 0 auto; padding: 3rem 1rem;">
    <!-- Premium Header -->
    <div class="service-center-header" style="text-align: center; margin-bottom: 3.5rem;">
        <span class="badge-yellow-fun bounce-fun" style="margin-bottom: 0.75rem;">SERVICE & WARRANTY 30 DAYS</span>
        <h1 style="font-size: 2.3rem; font-weight: 900; color: var(--color-navy-dark); margin: 0.5rem 0 10px; font-family: 'Prompt', sans-serif;">🔧 ศูนย์บริการแจ้งส่งซ่อมและเคลมประกัน 30 วัน</h1>
        <p style="color: #64748b; max-width: 650px; margin: 0 auto; font-size: 1.05rem; line-height: 1.6;">ส่งเคลมประกันร้าน 30 วัน หรือส่งซ่อมเปลี่ยนแบต/หน้าจอมือถือมือสอง ทำรายการบันทึกเข้าระบบออนไลน์ได้ทันที</p>
    </div>

    <!-- Service Offerings -->
    <div class="service-offerings-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.5rem; margin-bottom: 4rem;">
        <div class="card-fun-hover" style="background: white; border: 2px solid #E2E8F0; border-radius: 20px; padding: 2rem; box-shadow: 0 4px 18px rgba(15,23,42,0.03); text-align: center;">
            <div style="font-size: 2.5rem; margin-bottom: 1rem; color: #FF5722;" class="bounce-fun">🛡️</div>
            <h3 style="color: var(--color-navy-dark); font-weight: 800; margin-bottom: 10px;">ส่งเคลมประกัน 30 วัน</h3>
            <p style="color: #64748b; font-size: 0.88rem; line-height: 1.6; margin: 0;">สินค้ามือสองรับประกัน 30 วันเต็ม ดูแลปัญหาตัวเครื่อง เมนบอร์ด แบตเตอรี่ และหน้าจออย่างรวดเร็ว</p>
        </div>
        <div class="card-fun-hover" style="background: white; border: 2px solid #E2E8F0; border-radius: 20px; padding: 2rem; box-shadow: 0 4px 18px rgba(15,23,42,0.03); text-align: center;">
            <div style="font-size: 2.5rem; margin-bottom: 1rem; color: #FFE600;" class="float-fun">🔧</div>
            <h3 style="color: var(--color-navy-dark); font-weight: 800; margin-bottom: 10px;">ซ่อมด่วนโดยช่างผู้เชี่ยวชาญ</h3>
            <p style="color: #64748b; font-size: 0.88rem; line-height: 1.6; margin: 0;">รับเปลี่ยนหน้าจอร้าว แบตเตอรี่เสื่อม ซ่อมบอร์ดช็อต งานประณีต อะไหล่คุณภาพสูงพร้อมประกันงานซ่อม</p>
        </div>
        <div class="card-fun-hover" style="background: white; border: 2px solid #E2E8F0; border-radius: 20px; padding: 2rem; box-shadow: 0 4px 18px rgba(15,23,42,0.03); text-align: center;">
            <div style="font-size: 2.5rem; margin-bottom: 1rem; color: #9A3412;" class="bounce-fun">⚙️</div>
            <h3 style="color: var(--color-navy-dark); font-weight: 800; margin-bottom: 10px;">ตั้งค่า & ย้ายข้อมูลข้ามเครื่อง</h3>
            <p style="color: #64748b; font-size: 0.88rem; line-height: 1.6; margin: 0;">ย้ายข้อมูล iPhone / Android เครื่องเก่ามาเครื่องใหม่ สมัคร Apple ID และล้างเครื่องลงระบบฟรี</p>
        </div>
    </div>

    <!-- Booking Form & Info Split -->
    <div class="service-form-split" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 2.5rem; align-items: start;">
        <!-- Form Box -->
        <div class="service-form-box" style="background: white; border: 2px solid #E2E8F0; border-radius: 26px; padding: 2.5rem; box-shadow: 0 15px 35px rgba(15,23,42,0.06); position: relative;">
            <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 2.5px solid #F1F5F9; padding-bottom: 1rem; margin-bottom: 1.75rem;">
                <h3 style="font-size: 1.35rem; font-weight: 900; color: #0F172A; margin: 0; display: flex; align-items: center; gap: 10px; font-family: 'Prompt', sans-serif;">
                    <span style="width: 38px; height: 38px; border-radius: 12px; background: #FFF7ED; border: 1.5px solid #FFEDD5; color: #FF5722; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; box-shadow: 0 2px 8px rgba(255,87,34,0.15);">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </span>
                    ฟอร์มแจ้งขอเคลม / ซ่อมเครื่อง
                </h3>
                <span style="font-size: 0.75rem; font-weight: 800; background: #FEF3C7; color: #92400E; padding: 4px 12px; border-radius: 99px; border: 1px solid #FDE68A;">
                    ⚡ ดำเนินการใน 24 ชม.
                </span>
            </div>
            
            <form action="{{ route('claims.submit') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Input Grid Row 1 -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 18px; margin-bottom: 1.25rem;">
                    <div>
                        <label style="display: block; font-weight: 800; margin-bottom: 6px; color: #1E293B; font-size: 0.88rem;">
                            👤 ชื่อ-นามสกุล ผู้แจ้ง <span style="color: #EF4444;">*</span>
                        </label>
                        <input type="text" name="customer_name" required value="{{ auth()->check() ? auth()->user()->name : '' }}" 
                               placeholder="กรอกชื่อ-นามสกุลของคุณ" 
                               style="width: 100%; padding: 12px 14px; border: 1.5px solid #CBD5E1; border-radius: 14px; outline: none; font-family: 'Prompt', sans-serif; font-size: 0.9rem; font-weight: 600; color: #0F172A; background: #F8FAFC;"
                               onfocus="this.style.borderColor='#FF5722'; this.style.background='#FFFFFF';" 
                               onblur="this.style.borderColor='#CBD5E1'; this.style.background='#F8FAFC';">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 800; margin-bottom: 6px; color: #1E293B; font-size: 0.88rem;">
                            📞 เบอร์โทรศัพท์ติดต่อ <span style="color: #EF4444;">*</span>
                        </label>
                        <input type="tel" name="customer_phone" required value="{{ auth()->check() ? auth()->user()->phone : '' }}" 
                               placeholder="08X-XXX-XXXX" 
                               style="width: 100%; padding: 12px 14px; border: 1.5px solid #CBD5E1; border-radius: 14px; outline: none; font-family: 'Prompt', sans-serif; font-size: 0.9rem; font-weight: 600; color: #0F172A; background: #F8FAFC;"
                               onfocus="this.style.borderColor='#FF5722'; this.style.background='#FFFFFF';" 
                               onblur="this.style.borderColor='#CBD5E1'; this.style.background='#F8FAFC';">
                    </div>
                </div>

                <!-- Input Grid Row 2 -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 18px; margin-bottom: 1.25rem;">
                    <div>
                        <label style="display: block; font-weight: 800; margin-bottom: 6px; color: #1E293B; font-size: 0.88rem;">
                            📱 รุ่นสินค้า / สมาร์ทโฟน <span style="color: #EF4444;">*</span>
                        </label>
                        <input type="text" name="device_name" required placeholder="เช่น iPhone 14 Pro, iPad Air 5" 
                               style="width: 100%; padding: 12px 14px; border: 1.5px solid #CBD5E1; border-radius: 14px; outline: none; font-family: 'Prompt', sans-serif; font-size: 0.9rem; font-weight: 600; color: #0F172A; background: #F8FAFC;"
                               onfocus="this.style.borderColor='#FF5722'; this.style.background='#FFFFFF';" 
                               onblur="this.style.borderColor='#CBD5E1'; this.style.background='#F8FAFC';">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 800; margin-bottom: 6px; color: #1E293B; font-size: 0.88rem;">
                            🔢 เลขซีเรียล / Serial Number
                        </label>
                        <input type="text" name="serial_number" placeholder="เช่น DX3D..." 
                               style="width: 100%; padding: 12px 14px; border: 1.5px solid #CBD5E1; border-radius: 14px; outline: none; font-family: 'Prompt', sans-serif; font-size: 0.9rem; font-weight: 600; color: #0F172A; background: #F8FAFC;"
                               onfocus="this.style.borderColor='#FF5722'; this.style.background='#FFFFFF';" 
                               onblur="this.style.borderColor='#CBD5E1'; this.style.background='#F8FAFC';">
                    </div>
                </div>

                <!-- Input Grid Row 3 -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 18px; margin-bottom: 1.25rem;">
                    <div>
                        <label style="display: block; font-weight: 800; margin-bottom: 6px; color: #1E293B; font-size: 0.88rem;">
                            🛠️ ประเภทบริการที่ต้องการ <span style="color: #EF4444;">*</span>
                        </label>
                        <select name="claim_type" required 
                                style="width: 100%; padding: 12px 14px; border: 1.5px solid #CBD5E1; border-radius: 14px; outline: none; font-family: 'Prompt', sans-serif; font-size: 0.9rem; font-weight: 700; color: #0F172A; background: #F8FAFC; cursor: pointer;">
                            <option value="warranty">🛡️ ส่งเคลมประกันร้าน 30 วัน</option>
                            <option value="repair">🔧 ส่งซ่อมเปลี่ยนแบต/จอ (เครื่องหมดประกัน)</option>
                            <option value="setting">⚙️ บริการตั้งค่า/ย้ายข้อมูลเครื่องใหม่</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-weight: 800; margin-bottom: 6px; color: #1E293B; font-size: 0.88rem;">
                            🧾 เลขออเดอร์อ้างอิง (ถ้ามี)
                        </label>
                        <input type="text" name="order_id_raw" placeholder="เช่น ORD-20260727-XXXX" 
                               style="width: 100%; padding: 12px 14px; border: 1.5px solid #CBD5E1; border-radius: 14px; outline: none; font-family: 'Prompt', sans-serif; font-size: 0.9rem; font-weight: 600; color: #0F172A; background: #F8FAFC;">
                    </div>
                </div>

                <!-- Textarea Row -->
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 800; margin-bottom: 6px; color: #1E293B; font-size: 0.88rem;">
                        📝 รายละเอียดปัญหา / อาการเสียที่พบ <span style="color: #EF4444;">*</span>
                    </label>
                    <textarea name="issue_description" required rows="3" 
                              placeholder="อธิบายอาการชำรุด เช่น หน้าจอดับ, แบตเสื่อมเร็ว, ลำโพงไม่มีเสียง หรือบริการตั้งค่าเครื่อง..." 
                              style="width: 100%; padding: 14px; border: 1.5px solid #CBD5E1; border-radius: 14px; outline: none; font-family: 'Prompt', sans-serif; font-size: 0.9rem; font-weight: 500; color: #0F172A; background: #F8FAFC; resize: vertical;"></textarea>
                </div>

                <!-- Styled Image Upload Drag Zone -->
                <div style="margin-bottom: 2rem;">
                    <label style="display: block; font-weight: 800; margin-bottom: 6px; color: #1E293B; font-size: 0.88rem;">
                        📷 แนบรูปถ่ายสภาพตัวเครื่องหรืออาการเสีย
                    </label>
                    <div style="position: relative; border: 2px dashed #0284C7; border-radius: 16px; background: linear-gradient(135deg, #F0F9FF 0%, #E0F2FE 100%); padding: 1.5rem 1rem; text-align: center; cursor: pointer;">
                        <input type="file" name="images[]" multiple accept="image/*" 
                               style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 5;"
                               onchange="let files = Array.from(this.files).map(f => f.name).join(', '); document.getElementById('file-upload-txt').innerText = files || 'คลิกหรือลากไฟล์มาวางที่นี่ (เลือกได้หลายรูป)';">
                        <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 8px; pointer-events: none;">
                            <div style="width: 48px; height: 48px; border-radius: 50%; background: #0284C7; color: white; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; box-shadow: 0 4px 12px rgba(2,132,199,0.3);">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                            </div>
                            <span id="file-upload-txt" style="font-size: 0.88rem; font-weight: 800; color: #0369A1;">
                                คลิกเพื่อเลือกรูปภาพ หรือลากไฟล์มาวางที่นี่
                            </span>
                            <span style="font-size: 0.75rem; color: #64748B; font-weight: 600;">
                                รองรับไฟล์ PNG, JPG, JPEG (ขนาดไม่เกิน 4MB ต่อรูป)
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Premium Gradient Call-to-Action Submit Button -->
                <button type="submit" class="service-submit-btn"
                        style="width: 100%; border: 2px solid #FFE600; padding: 16px 28px; border-radius: 99px; background: linear-gradient(135deg, #FF5722 0%, #E64A19 100%); color: white; font-weight: 900; font-size: 1.1rem; font-family: 'Prompt', sans-serif; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 12px; box-shadow: 0 10px 25px rgba(255,87,34,0.35);">
                    <span>บันทึกและส่งแจ้งเรื่องเคลม/ซ่อม</span>
                    <span style="width: 32px; height: 32px; border-radius: 50%; background: #FFE600; color: #0F172A; display: flex; align-items: center; justify-content: center; font-size: 0.95rem; font-weight: 900;">
                        <i class="fa-solid fa-paper-plane"></i>
                    </span>
                </button>
            </form>
        </div>

        <!-- Info Column -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <!-- Track claim box -->
            <div style="background: linear-gradient(135deg, #070D1B 0%, #0F172A 100%); color: white; border-radius: 22px; padding: 2rem; border: 2px solid #FFE600; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
                <h4 style="font-weight: 900; margin-top: 0; margin-bottom: 10px; color: #FFE600; font-size: 1.25rem;">🔍 ติดตามสถานะงานซ่อม/เคลม</h4>
                <p style="color: #CBD5E1; font-size: 0.9rem; line-height: 1.6; margin-bottom: 1.5rem;">เมื่อบันทึกฟอร์มเสร็จสิ้น ระบบจะสร้างหมายเลขใบเคลม (Claim Code) ให้ใช้สำหรับตรวจเช็คสถานะการทำงานได้ตลอด 24 ชม.</p>
                <a href="{{ route('tracking', ['type' => 'claim']) }}" style="text-decoration: none; display: block;">
                    <button class="btn-orange-fun" style="width: 100%; justify-content: center;">
                        <i class="fa-solid fa-magnifying-glass"></i> เข้าสู่หน้าเช็คสถานะงานซ่อม
                    </button>
                </a>
            </div>

            <!-- Shop details -->
            <div style="background: white; border-radius: 22px; padding: 2rem; border: 2px solid #E2E8F0; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                <h4 style="color: var(--color-navy-dark); font-weight: 800; margin-top: 0; margin-bottom: 10px;">📍 ที่อยู่สำหรับจัดส่งพัสดุเคลม/ซ่อม</h4>
                <p style="color: #64748b; font-size: 0.88rem; line-height: 1.6; margin-bottom: 1rem;">หากกรอกฟอร์มบริการแบบส่งพัสดุ กรุณาแพ็คเครื่องกันกระแทกอย่างดีและส่งมาที่:</p>
                <div style="background: #070D1B; border: 1.5px solid #FFE600; padding: 14px; border-radius: 12px; font-size: 0.85rem; color: white; font-family: monospace; margin-bottom: 1.5rem; line-height: 1.6;">
                    <strong style="color: #FFE600;">ผู้รับ: ฝ่ายเคลมและบริการ DDPHONE ดีดีโฟน</strong><br>
                    ที่อยู่: 72/47-48ก ถนนชัยประสิทธิ์ ต.ในเมือง อ.เมือง จ.ชัยภูมิ 36000<br>
                    เบอร์ติดต่อ: 086-869-9666
                </div>
                <p style="color: #64748b; font-size: 0.82rem; margin-bottom: 0;">*กรุณาเขียนหมายเลขใบเคลม (CLM-XXXXXX) กำกับบนกล่องพัสดุเพื่อให้เจ้าหน้าที่คัดแยกเครื่องได้อย่างรวดเร็ว</p>
            </div>
        </div>
    </div>
</div>
@endsection

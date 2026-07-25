@extends('layouts.store')

@section('content')
<div class="container" style="max-width: 1000px; margin: 0 auto; padding: 3rem 1rem;">
    <!-- Premium Header -->
    <div style="text-align: center; margin-bottom: 3.5rem;">
        <span class="badge-yellow-fun bounce-fun" style="margin-bottom: 0.75rem;">SERVICE & WARRANTY 30 DAYS</span>
        <h1 style="font-size: 2.3rem; font-weight: 900; color: var(--color-navy-dark); margin: 0.5rem 0 10px; font-family: 'Prompt', sans-serif;">🔧 ศูนย์บริการแจ้งส่งซ่อมและเคลมประกัน 30 วัน</h1>
        <p style="color: #64748b; max-width: 650px; margin: 0 auto; font-size: 1.05rem; line-height: 1.6;">ส่งเคลมประกันร้าน 30 วัน หรือส่งซ่อมเปลี่ยนแบต/หน้าจอมือถือมือสอง ทำรายการบันทึกเข้าระบบออนไลน์ได้ทันที</p>
    </div>

    <!-- Service Offerings -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.5rem; margin-bottom: 4rem;">
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
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 2.5rem; align-items: start;">
        <!-- Form Box -->
        <div style="background: white; border: 2px solid #E2E8F0; border-radius: 22px; padding: 2.5rem; box-shadow: 0 10px 30px rgba(0,0,0,0.04);">
            <h3 style="font-size: 1.35rem; font-weight: 900; color: var(--color-navy-dark); margin-bottom: 1.5rem; border-bottom: 2px solid #FFE600; padding-bottom: 0.5rem; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-pen-to-square" style="color: #FF5722;"></i> ฟอร์มแจ้งขอเคลม / ซ่อมเครื่อง
            </h3>
            
            <form action="{{ route('claims.submit') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; font-weight: 700; margin-bottom: 5px; color: var(--color-navy-dark); font-size: 0.88rem;">ชื่อ-นามสกุล ผู้แจ้ง</label>
                        <input type="text" name="customer_name" required value="{{ auth()->check() ? auth()->user()->name : '' }}" style="width: 100%; padding: 10px; border: 1.5px solid #E2E8F0; border-radius: 10px; outline: none;" onfocus="this.style.borderColor='#FFE600'" onblur="this.style.borderColor='#E2E8F0'">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 700; margin-bottom: 5px; color: var(--color-navy-dark); font-size: 0.88rem;">เบอร์โทรศัพท์ติดต่อ</label>
                        <input type="tel" name="customer_phone" required value="{{ auth()->check() ? auth()->user()->phone : '' }}" style="width: 100%; padding: 10px; border: 1.5px solid #E2E8F0; border-radius: 10px; outline: none;" onfocus="this.style.borderColor='#FFE600'" onblur="this.style.borderColor='#E2E8F0'">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; font-weight: 700; margin-bottom: 5px; color: var(--color-navy-dark); font-size: 0.88rem;">รุ่นสินค้า / สมาร์ทโฟน</label>
                        <input type="text" name="device_name" required placeholder="เช่น iPhone 14 Pro, iPad Air 5" style="width: 100%; padding: 10px; border: 1.5px solid #E2E8F0; border-radius: 10px; outline: none;" onfocus="this.style.borderColor='#FFE600'" onblur="this.style.borderColor='#E2E8F0'">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 700; margin-bottom: 5px; color: var(--color-navy-dark); font-size: 0.88rem;">เลขซีเรียล / Serial Number</label>
                        <input type="text" name="serial_number" placeholder="เช่น DX3D..." style="width: 100%; padding: 10px; border: 1.5px solid #E2E8F0; border-radius: 10px; outline: none;" onfocus="this.style.borderColor='#FFE600'" onblur="this.style.borderColor='#E2E8F0'">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; font-weight: 700; margin-bottom: 5px; color: var(--color-navy-dark); font-size: 0.88rem;">ประเภทบริการ</label>
                        <select name="claim_type" required style="width: 100%; padding: 10px; border: 1.5px solid #E2E8F0; border-radius: 10px; font-family: inherit; font-size: 0.88rem;">
                            <option value="warranty">🛡️ ส่งเคลมประกันร้าน 30 วัน</option>
                            <option value="repair">🔧 ส่งซ่อมเปลี่ยนแบต/จอ (เครื่องหมดประกัน)</option>
                            <option value="setting">⚙️ บริการตั้งค่า/ย้ายข้อมูลเครื่องใหม่</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-weight: 700; margin-bottom: 5px; color: var(--color-navy-dark); font-size: 0.88rem;">เลขออเดอร์อ้างอิง (ถ้ามี)</label>
                        <input type="text" name="order_id_raw" placeholder="เช่น ORD-..." style="width: 100%; padding: 10px; border: 1.5px solid #E2E8F0; border-radius: 10px; outline: none;" onfocus="this.style.borderColor='#FFE600'" onblur="this.style.borderColor='#E2E8F0'">
                    </div>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 700; margin-bottom: 5px; color: var(--color-navy-dark); font-size: 0.88rem;">รายละเอียดปัญหา / อาการเสียที่พบ</label>
                    <textarea name="issue_description" required rows="3" placeholder="ระบุอาการชำรุด อาการเสีย หรือบริการตั้งค่าที่ต้องการ..." style="width: 100%; padding: 10px; border: 1.5px solid #E2E8F0; border-radius: 10px; outline: none; font-family: inherit;" onfocus="this.style.borderColor='#FFE600'" onblur="this.style.borderColor='#E2E8F0'"></textarea>
                </div>

                <!-- Multi-image Upload Input -->
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 700; margin-bottom: 5px; color: var(--color-navy-dark); font-size: 0.88rem;">📷 แนบรูปถ่ายสภาพตัวเครื่องหรืออาการเสีย</label>
                    <input type="file" name="images[]" multiple accept="image/*" style="width: 100%; padding: 8px; border: 1.5px dashed #FFE600; border-radius: 10px; background: #FFFDF0; font-size: 0.85rem;">
                    <span style="font-size: 0.75rem; color: #64748b; display: block; margin-top: 4px;">รองรับไฟล์ PNG, JPG, JPEG ขนาดไม่เกิน 4MB ต่อรูป</span>
                </div>

                <button type="submit" class="btn-capsule-yellow" style="width: 100%; justify-content: center; font-size: 1rem !important; padding: 8px 8px 8px 24px !important;">
                    บันทึกและส่งแจ้งเรื่องเคลม/ซ่อม <span class="circle-icon"><i class="fa-solid fa-paper-plane"></i></span>
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
                    เบอร์ติดต่อ: 083-828-941
                </div>
                <p style="color: #64748b; font-size: 0.82rem; margin-bottom: 0;">*กรุณาเขียนหมายเลขใบเคลม (CLM-XXXXXX) กำกับบนกล่องพัสดุเพื่อให้เจ้าหน้าที่คัดแยกเครื่องได้อย่างรวดเร็ว</p>
            </div>
        </div>
    </div>
</div>
@endsection

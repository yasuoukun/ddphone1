@extends('layouts.store')

@section('content')
<div class="fade-in" style="max-width: 1200px; margin: 0 auto; padding: 4rem 1.5rem; font-family: 'Prompt', sans-serif;">
    
    <!-- Hero Banner with Gradient -->
    <div style="background: linear-gradient(135deg, var(--color-navy-dark) 0%, var(--color-navy-light) 100%); border-radius: 24px; padding: 4.5rem 2rem; text-align: center; color: white; margin-bottom: 4.2rem; box-shadow: 0 20px 40px rgba(18, 28, 48, 0.15); position: relative; overflow: hidden;">
        <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.03); border-radius: 50%;"></div>
        <div style="position: absolute; bottom: -50px; left: -50px; width: 150px; height: 150px; background: rgba(255,255,255,0.03); border-radius: 50%;"></div>
        
        <span style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); color: #E2E8F0; font-size: 0.9rem; font-weight: 600; padding: 8px 20px; border-radius: 30px; letter-spacing: 1px; display: inline-block; margin-bottom: 1.5rem;">OUR SERVICES & SOLUTIONS</span>
        <h1 style="font-size: 3rem; font-weight: 700; margin: 0 0 1.5rem 0; line-height: 1.2;">ใส่ใจทุกการบริการ ดูแลทุกปัญหา</h1>
        <p style="color: #CBD5E1; max-width: 800px; margin: 0 auto; font-size: 1.2rem; line-height: 1.7;">
            ดีดี.ไอที.คอม (DDITCOM) ศูนย์บริการไอทีครบวงจร มุ่งมั่นส่งมอบบริการโซลูชัน IT ระดับองค์กร ยกระดับความปลอดภัยและประสิทธิภาพการทำงานให้ธุรกิจของคุณด้วยเทคโนโลยีที่ทันสมัย
        </p>
    </div>

    <!-- Core IT Solutions Section -->
    <h2 style="font-size: 2.2rem; font-weight: 700; color: var(--color-navy-dark); text-align: center; margin-bottom: 3rem;">
        บริการโซลูชัน IT ระดับองค์กร
    </h2>
    <div class="shopee-mobile-row" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem; margin-bottom: 5rem;">
        
        <!-- Service 1 -->
        <div class="premium-card" style="padding: 2.2rem; background: white;">
            <div style="color: var(--color-accent); font-size: 2rem; margin-bottom: 1rem;"><i class="fa-solid fa-comments"></i></div>
            <h3 style="font-size: 1.3rem; font-weight: 700; color: var(--color-navy-dark); margin-top: 0; margin-bottom: 10px;">บริการให้คำปรึกษาด้าน IT</h3>
            <p style="color: var(--color-grey); font-size: 0.95rem; line-height: 1.7; margin: 0;">
                วิเคราะห์โครงสร้างพื้นฐานเดิมและให้คำปรึกษา ออกแบบโครงสร้างพื้นฐานด้านไอที (IT Infrastructure Design) ให้เหมาะสมกับขนาดธุรกิจและประเภทองค์กรของคุณอย่างแท้จริง
            </p>
        </div>

        <!-- Service 2 -->
        <div class="premium-card" style="padding: 2.2rem; background: white;">
            <div style="color: #E53E3E; font-size: 2rem; margin-bottom: 1rem;"><i class="fa-solid fa-shield-halved"></i></div>
            <h3 style="font-size: 1.3rem; font-weight: 700; color: var(--color-navy-dark); margin-top: 0; margin-bottom: 10px;">Enterprise Endpoint Security</h3>
            <p style="color: var(--color-grey); font-size: 0.95rem; line-height: 1.7; margin: 0;">
                ยกระดับการป้องกันภัยคุกคามทางไซเบอร์ ปกป้องข้อมูลสำคัญขององค์กรบนทุกอุปกรณ์ที่เชื่อมต่อ (Endpoints เช่น iPhone, iPad, Mac, Windows) อย่างรัดกุมและปลอดภัยสูงสุด
            </p>
        </div>

        <!-- Service 3 -->
        <div class="premium-card" style="padding: 2.2rem; background: white;">
            <div style="color: #3182CE; font-size: 2rem; margin-bottom: 1rem;"><i class="fa-solid fa-network-wired"></i></div>
            <h3 style="font-size: 1.3rem; font-weight: 700; color: var(--color-navy-dark); margin-top: 0; margin-bottom: 10px;">Enterprise Network Infrastructure</h3>
            <p style="color: var(--color-grey); font-size: 0.95rem; line-height: 1.7; margin: 0;">
                ออกแบบ ติดตั้ง และจัดการระบบเครือข่ายองค์กร (Network) ให้เสถียร รวดเร็ว และปลอดภัย รองรับการขยายตัวและการเชื่อมต่ออินเทอร์เน็ตของธุรกิจคุณอย่างไร้รอยต่อ
            </p>
        </div>

        <!-- Service 4 -->
        <div class="premium-card" style="padding: 2.2rem; background: white;">
            <div style="color: #805AD5; font-size: 2rem; margin-bottom: 1rem;"><i class="fa-solid fa-cubes"></i></div>
            <h3 style="font-size: 1.3rem; font-weight: 700; color: var(--color-navy-dark); margin-top: 0; margin-bottom: 10px;">Business Application Deployment</h3>
            <p style="color: var(--color-grey); font-size: 0.95rem; line-height: 1.7; margin: 0;">
                บริการตั้งค่าและกระจายแอปพลิเคชัน (App Distribution) ที่จำเป็นสำหรับธุรกิจลงสู่อุปกรณ์พนักงานอย่างรวดเร็วและพร้อมเพรียงกันผ่านระบบจัดการจากศูนย์กลาง (MDM)
            </p>
        </div>

        <!-- Service 5 -->
        <div class="premium-card" style="padding: 2.2rem; background: white;">
            <div style="color: #38A169; font-size: 2rem; margin-bottom: 1rem;"><i class="fa-solid fa-cloud"></i></div>
            <h3 style="font-size: 1.3rem; font-weight: 700; color: var(--color-navy-dark); margin-top: 0; margin-bottom: 10px;">Cloud Management & Storage</h3>
            <p style="color: var(--color-grey); font-size: 0.95rem; line-height: 1.7; margin: 0;">
                ให้คำปรึกษา วางระบบ และบริหารจัดการพื้นที่เก็บข้อมูลบนคลาวด์ เพิ่มความคล่องตัวในการทำงานร่วมกันของทีมงาน และปกป้องข้อมูลสำคัญไม่ให้สูญหาย
            </p>
        </div>

        <!-- Service 6 -->
        <div class="premium-card" style="padding: 2.2rem; background: white;">
            <div style="color: #DD6B20; font-size: 2rem; margin-bottom: 1rem;"><i class="fa-solid fa-headset"></i></div>
            <h3 style="font-size: 1.3rem; font-weight: 700; color: var(--color-navy-dark); margin-top: 0; margin-bottom: 10px;">Enterprise IT Helpdesk</h3>
            <p style="color: var(--color-grey); font-size: 0.95rem; line-height: 1.7; margin: 0;">
                ทีมวิศวกรและผู้เชี่ยวชาญพร้อมดูแลระบบไอที ให้บริการตอบข้อซักถาม แก้ไขปัญหาเชิงลึก และดูแลรักษาระบบไอทีองค์กรของคุณอย่างต่อเนื่อง (MA & IT Maintenance Support)
            </p>
        </div>

    </div>

    <!-- The 12-Step Implementation Flow -->
    <div style="background: var(--color-navy-dark); border-radius: 24px; padding: 4rem 3rem; color: white; margin-bottom: 5rem; box-shadow: 0 15px 30px rgba(0,0,0,0.15);">
        <h2 style="font-size: 2rem; font-weight: 700; text-align: center; margin-top: 0; margin-bottom: 3rem;">
            ขั้นตอนการบริการโซลูชัน IT แบบครบวงจร (Our Service Flow)
        </h2>
        
        <div class="shopee-mobile-row" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 2rem;">
            
            <div style="background: rgba(255,255,255,0.05); padding: 1.5rem; border-radius: 16px; border: 1px solid rgba(255,255,255,0.08);">
                <div style="font-size: 0.85rem; color: var(--color-accent); font-weight: 700; margin-bottom: 8px;">STEP 01</div>
                <h4 style="margin: 0 0 10px 0; font-size: 1.1rem; font-weight: 600;">Consultation</h4>
                <p style="color: #94A3B8; font-size: 0.88rem; line-height: 1.6; margin: 0;">วิเคราะห์โครงสร้างพื้นฐานเดิมและให้คำปรึกษาที่ตอบโจทย์</p>
            </div>

            <div style="background: rgba(255,255,255,0.05); padding: 1.5rem; border-radius: 16px; border: 1px solid rgba(255,255,255,0.08);">
                <div style="font-size: 0.85rem; color: var(--color-accent); font-weight: 700; margin-bottom: 8px;">STEP 02</div>
                <h4 style="margin: 0 0 10px 0; font-size: 1.1rem; font-weight: 600;">Recommend Product</h4>
                <p style="color: #94A3B8; font-size: 0.88rem; line-height: 1.6; margin: 0;">คัดสรรฮาร์ดแวร์และซอฟต์แวร์ระดับ Enterprise (เช่น Apple ABM)</p>
            </div>

            <div style="background: rgba(255,255,255,0.05); padding: 1.5rem; border-radius: 16px; border: 1px solid rgba(255,255,255,0.08);">
                <div style="font-size: 0.85rem; color: var(--color-accent); font-weight: 700; margin-bottom: 8px;">STEP 03</div>
                <h4 style="margin: 0 0 10px 0; font-size: 1.1rem; font-weight: 600;">Delivery Service</h4>
                <p style="color: #94A3B8; font-size: 0.88rem; line-height: 1.6; margin: 0;">บริการจัดส่งอุปกรณ์ไอทีอย่างปลอดภัยและรวดเร็ว</p>
            </div>

            <div style="background: rgba(255,255,255,0.05); padding: 1.5rem; border-radius: 16px; border: 1px solid rgba(255,255,255,0.08);">
                <div style="font-size: 0.85rem; color: var(--color-accent); font-weight: 700; margin-bottom: 8px;">STEP 04</div>
                <h4 style="margin: 0 0 10px 0; font-size: 1.1rem; font-weight: 600;">Setting / Install</h4>
                <p style="color: #94A3B8; font-size: 0.88rem; line-height: 1.6; margin: 0;">ติดตั้งอุปกรณ์อัตโนมัติ (Zero-Touch Deployment) พร้อมใช้งาน</p>
            </div>

            <div style="background: rgba(255,255,255,0.05); padding: 1.5rem; border-radius: 16px; border: 1px solid rgba(255,255,255,0.08);">
                <div style="font-size: 0.85rem; color: var(--color-accent); font-weight: 700; margin-bottom: 8px;">STEP 05</div>
                <h4 style="margin: 0 0 10px 0; font-size: 1.1rem; font-weight: 600;">MDM Solution</h4>
                <p style="color: #94A3B8; font-size: 0.88rem; line-height: 1.6; margin: 0;">ติดตั้งระบบจัดการอุปกรณ์ ควบคุมความปลอดภัยจากศูนย์กลาง</p>
            </div>

            <div style="background: rgba(255,255,255,0.05); padding: 1.5rem; border-radius: 16px; border: 1px solid rgba(255,255,255,0.08);">
                <div style="font-size: 0.85rem; color: var(--color-accent); font-weight: 700; margin-bottom: 8px;">STEP 06</div>
                <h4 style="margin: 0 0 10px 0; font-size: 1.1rem; font-weight: 600;">Demo / POC</h4>
                <p style="color: #94A3B8; font-size: 0.88rem; line-height: 1.6; margin: 0;">บริการจำลองระบบและทดสอบการใช้งานจริงก่อนตัดสินใจ</p>
            </div>

            <div style="background: rgba(255,255,255,0.05); padding: 1.5rem; border-radius: 16px; border: 1px solid rgba(255,255,255,0.08);">
                <div style="font-size: 0.85rem; color: var(--color-accent); font-weight: 700; margin-bottom: 8px;">STEP 07</div>
                <h4 style="margin: 0 0 10px 0; font-size: 1.1rem; font-weight: 600;">MA / On-site Service</h4>
                <p style="color: #94A3B8; font-size: 0.88rem; line-height: 1.6; margin: 0;">บริการบำรุงรักษาระบบและซ่อมแซมถึงหน้างาน (On-site)</p>
            </div>

            <div style="background: rgba(255,255,255,0.05); padding: 1.5rem; border-radius: 16px; border: 1px solid rgba(255,255,255,0.08);">
                <div style="font-size: 0.85rem; color: var(--color-accent); font-weight: 700; margin-bottom: 8px;">STEP 08</div>
                <h4 style="margin: 0 0 10px 0; font-size: 1.1rem; font-weight: 600;">Training / Workshop</h4>
                <p style="color: #94A3B8; font-size: 0.88rem; line-height: 1.6; margin: 0;">จัดอบรมสอนการใช้งานระบบและอุปกรณ์ให้พนักงานองค์กร</p>
            </div>

            <div style="background: rgba(255,255,255,0.05); padding: 1.5rem; border-radius: 16px; border: 1px solid rgba(255,255,255,0.08);">
                <div style="font-size: 0.85rem; color: var(--color-accent); font-weight: 700; margin-bottom: 8px;">STEP 09</div>
                <h4 style="margin: 0 0 10px 0; font-size: 1.1rem; font-weight: 600;">Finance Plan</h4>
                <p style="color: #94A3B8; font-size: 0.88rem; line-height: 1.6; margin: 0;">ให้คำปรึกษาด้านการลงทุนไอที (ROI) วางแผนงบอย่างคุ้มค่า</p>
            </div>

            <div style="background: rgba(255,255,255,0.05); padding: 1.5rem; border-radius: 16px; border: 1px solid rgba(255,255,255,0.08);">
                <div style="font-size: 0.85rem; color: var(--color-accent); font-weight: 700; margin-bottom: 8px;">STEP 10</div>
                <h4 style="margin: 0 0 10px 0; font-size: 1.1rem; font-weight: 600;">Leasing</h4>
                <p style="color: #94A3B8; font-size: 0.88rem; line-height: 1.6; margin: 0;">บริการเช่าอุปกรณ์ เปลี่ยนงบลงทุนก้อนใหญ่เป็นผ่อนรายเดือน</p>
            </div>

            <div style="background: rgba(255,255,255,0.05); padding: 1.5rem; border-radius: 16px; border: 1px solid rgba(255,255,255,0.08);">
                <div style="font-size: 0.85rem; color: var(--color-accent); font-weight: 700; margin-bottom: 8px;">STEP 11</div>
                <h4 style="margin: 0 0 10px 0; font-size: 1.1rem; font-weight: 600;">Procurement</h4>
                <p style="color: #94A3B8; font-size: 0.88rem; line-height: 1.6; margin: 0;">บริการจัดหาสินค้าไอทีตามความต้องการเฉพาะขององค์กร</p>
            </div>

            <div style="background: rgba(255,255,255,0.05); padding: 1.5rem; border-radius: 16px; border: 1px solid rgba(255,255,255,0.08);">
                <div style="font-size: 0.85rem; color: var(--color-accent); font-weight: 700; margin-bottom: 8px;">STEP 12</div>
                <h4 style="margin: 0 0 10px 0; font-size: 1.1rem; font-weight: 600;">Help Desk</h4>
                <p style="color: #94A3B8; font-size: 0.88rem; line-height: 1.6; margin: 0;">ทีมงานวิศวกรสแตนด์บายคอยช่วยเหลือแก้ไขปัญหาตลอดวัน</p>
            </div>

        </div>
    </div>

    <!-- Maintenance & Repairs Section -->
    <div style="background: white; border-radius: 24px; border: 1px solid var(--color-silver); padding: 3.5rem; margin-bottom: 5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.02);">
        <h2 style="font-size: 2rem; font-weight: 700; color: var(--color-navy-dark); text-align: center; margin-top: 0; margin-bottom: 3rem;">
            ศูนย์ซ่อมบำรุงและบริการไอที (Maintenance & Repair Services)
        </h2>
        
        <div class="shopee-mobile-row" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-bottom: 3.5rem;">
            
            <div style="display: flex; gap: 15px; align-items: flex-start;">
                <span style="color: var(--color-accent); font-size: 1.5rem;"><i class="fa-solid fa-desktop"></i></span>
                <div>
                    <h4 style="margin: 0 0 8px 0; font-size: 1.15rem; font-weight: 700; color: var(--color-navy-dark);">ซ่อมคอมพิวเตอร์และโน๊ตบุ๊ค</h4>
                    <p style="color: var(--color-grey); font-size: 0.92rem; line-height: 1.6; margin: 0;">แก้ไขปัญหาเครื่องช้า อัปเกรดแรม/SSD เปลี่ยนหน้าจอ แป้นพิมพ์ และแก้ไขปัญหาฮาร์ดแวร์/ซอฟต์แวร์ทุกประเภท</p>
                </div>
            </div>

            <div style="display: flex; gap: 15px; align-items: flex-start;">
                <span style="color: var(--color-accent); font-size: 1.5rem;"><i class="fa-solid fa-server"></i></span>
                <div>
                    <h4 style="margin: 0 0 8px 0; font-size: 1.15rem; font-weight: 700; color: var(--color-navy-dark);">บำรุงรักษาเซิร์ฟเวอร์</h4>
                    <p style="color: var(--color-grey); font-size: 0.92rem; line-height: 1.6; margin: 0;">ตรวจสอบความเสถียร จัดเก็บข้อมูล และบำรุงรักษาระบบควบคุมเซิร์ฟเวอร์ของบริษัท เพื่อให้ระบบทำงานต่อเนื่อง ป้องกัน Downtime</p>
                </div>
            </div>

            <div style="display: flex; gap: 15px; align-items: flex-start;">
                <span style="color: var(--color-accent); font-size: 1.5rem;"><i class="fa-solid fa-globe"></i></span>
                <div>
                    <h4 style="margin: 0 0 8px 0; font-size: 1.15rem; font-weight: 700; color: var(--color-navy-dark);">แก้ไขปัญหาเครือข่ายและอินเทอร์เน็ต</h4>
                    <p style="color: var(--color-grey); font-size: 0.92rem; line-height: 1.6; margin: 0;">แก้ไขสัญญาณอินเทอร์เน็ตขัดข้อง ปรับตั้งตัวกระจายสัญญาณ WiFi วางสายแลน และดูแลการเชื่อมต่อให้เสถียรและเร็วสูงสุด</p>
                </div>
            </div>

            <div style="display: flex; gap: 15px; align-items: flex-start;">
                <span style="color: var(--color-accent); font-size: 1.5rem;"><i class="fa-solid fa-virus-slash"></i></span>
                <div>
                    <h4 style="margin: 0 0 8px 0; font-size: 1.15rem; font-weight: 700; color: var(--color-navy-dark);">กำจัดไวรัสและมัลแวร์</h4>
                    <p style="color: var(--color-grey); font-size: 0.92rem; line-height: 1.6; margin: 0;">ตรวจสแกนลบโปรแกรมไม่พึงประสงค์ คืนความเร็วและความปลอดภัยสูงสุดให้กับไฟล์ระบบคอมพิวเตอร์ของคุณ</p>
                </div>
            </div>

            <div style="display: flex; gap: 15px; align-items: flex-start;">
                <span style="color: var(--color-accent); font-size: 1.5rem;"><i class="fa-solid fa-folder-plus"></i></span>
                <div>
                    <h4 style="margin: 0 0 8px 0; font-size: 1.15rem; font-weight: 700; color: var(--color-navy-dark);">อัพเกรดและติดตั้งอุปกรณ์ใหม่</h4>
                    <p style="color: var(--color-grey); font-size: 0.92rem; line-height: 1.6; margin: 0;">ติดตั้งเครื่องพิมพ์ (Printer), เครื่องสแกน, ระบบจัดเก็บไฟล์ข้อมูลกลางในสำนักงาน (NAS) เพื่อเพิ่มประสิทธิภาพการทำงานร่วมกัน</p>
                </div>
            </div>

            <div style="display: flex; gap: 15px; align-items: flex-start;">
                <span style="color: var(--color-accent); font-size: 1.5rem;"><i class="fa-solid fa-house-laptop"></i></span>
                <div>
                    <h4 style="margin: 0 0 8px 0; font-size: 1.15rem; font-weight: 700; color: var(--color-navy-dark);">บริการติดตั้งและปรับตั้งระบบ</h4>
                    <p style="color: var(--color-grey); font-size: 0.92rem; line-height: 1.6; margin: 0;">บริการปรับจูนระบบคอมพิวเตอร์และเชื่อมต่อโครงข่ายแบบครบวงจร ทั้งสำหรับบ้านพักอาศัยและสำนักงาน</p>
                </div>
            </div>

        </div>

        <!-- Smartphone Certified Repair Center -->
        <div style="border-top: 1px solid var(--color-silver); padding-top: 3rem; display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; align-items: center;">
            <div>
                <span style="background: rgba(56, 161, 105, 0.1); color: #38A169; font-weight: 600; font-size: 0.85rem; padding: 6px 14px; border-radius: 20px; text-transform: uppercase;">Certified Repair Center</span>
                <h3 style="font-size: 1.8rem; font-weight: 700; color: var(--color-navy-dark); margin-top: 12px; margin-bottom: 1.2rem;">ศูนย์บริการซ่อมมือถือสมาร์ทโฟนระดับมาตรฐาน</h3>
                <p style="color: var(--color-grey); font-size: 0.98rem; line-height: 1.7; margin-bottom: 1.5rem;">
                    <strong>บริษัท ดีดี.ไอที.คอม จำกัด (DD.IT.COM CO., LTD.)</strong> เป็นศูนย์บริการซ่อมโทรศัพท์มือถือสมาร์ทโฟนที่ได้รับการรับรองมาตรฐานสากล โดยเราเชี่ยวชาญในการซ่อมบำรุงรักษาอุปกรณ์ Apple iPhone ทุกรุ่น รวมถึงสมาร์ทโฟนแบรนด์ชั้นนำอื่นๆ 
                </p>
                <p style="color: var(--color-grey); font-size: 0.98rem; line-height: 1.7; margin-bottom: 0;">
                    ทีมช่างผู้ชำนาญการของเราผ่านการฝึกอบรมพิเศษและใช้อะไหล่คุณภาพสูงในการซ่อมบำรุง พร้อมเครื่องมือซ่อมที่ทันสมัย เพื่อให้บริการซ่อมแซมอย่างมีประสิทธิภาพและรวดเร็ว เรารับซ่อมทุกปัญหา ทั้งหน้าจอแตก เปลี่ยนกระจก แบตเตอรี่เสื่อม ปัญหาระบบเปิดไม่ติด และอื่นๆ พร้อมรับประกันคุณภาพงานซ่อม
                </p>
            </div>
            <div style="background: var(--color-grey-bg); border-radius: 20px; padding: 2.5rem; border: 1px solid var(--color-silver-light);">
                <h4 style="font-size: 1.25rem; font-weight: 700; color: var(--color-navy-dark); margin-top: 0; margin-bottom: 1.5rem; text-align: center;">ส่งคำขอซ่อม หรือเช็คสถานะซ่อมออนไลน์</h4>
                <p style="color: var(--color-grey); font-size: 0.9rem; line-height: 1.7; text-align: center; margin-bottom: 2rem;">
                    ท่านสามารถส่งข้อมูลรายละเอียดอุปกรณ์ที่เสียหายผ่านระบบออนไลน์ เพื่อจองคิวการซ่อมหรือส่งเรื่องส่งเคลมล่วงหน้าได้อย่างง่ายดาย
                </p>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <a href="{{ route('service_center') }}" style="background: var(--color-accent); color: white; text-decoration: none; font-weight: 600; padding: 14px 20px; border-radius: 10px; text-align: center; font-size: 0.95rem; transition: background 0.2s;" onmouseover="this.style.background='var(--color-navy-light)';" onmouseout="this.style.background='var(--color-accent)';">
                        🔧 ส่งซ่อม / ส่งเคลมออนไลน์ทันที
                    </a>
                    <a href="{{ route('tracking') }}" style="background: white; border: 1px solid var(--color-silver); color: var(--color-navy-dark); text-decoration: none; font-weight: 600; padding: 14px 20px; border-radius: 10px; text-align: center; font-size: 0.95rem; transition: background 0.2s;" onmouseover="this.style.background='var(--color-silver-light)';" onmouseout="this.style.background='white';">
                        📦 ติดตามสถานะงานซ่อม/เครื่องเคลม
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- Trade-In & Leasing Info Block -->
    <div class="shopee-mobile-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 5rem;">
        
        <!-- Procurement -->
        <div style="background: white; border: 1px solid var(--color-silver); border-radius: 20px; padding: 3rem 2.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.01);">
            <div style="font-size: 2.2rem; margin-bottom: 1rem; color: var(--color-accent);"><i class="fa-solid fa-boxes-packing"></i></div>
            <h3 style="font-size: 1.5rem; font-weight: 700; color: var(--color-navy-dark); margin-top: 0; margin-bottom: 1rem;">บริการจัดหาสินค้าไอทียกเซ็ต (IT Procurement)</h3>
            <p style="color: var(--color-grey); font-size: 0.95rem; line-height: 1.7; margin-bottom: 1.5rem;">
                จัดหาและจัดส่งอุปกรณ์ไอทีแท้ประกันศูนย์ไทยสำหรับเปิดออฟฟิศใหม่ โรงเรียน หรือขยายสาขา พร้อมราคาพิเศษยกล็อต:
            </p>
            <ul style="color: var(--color-grey); font-size: 0.9rem; line-height: 1.8; padding-left: 20px; margin: 0;">
                <li>คอมพิวเตอร์และโน้ตบุ๊ค (MacBook, iMac, Windows Laptop)</li>
                <li>สมาร์ทโฟนและแท็บเล็ตเพื่อการทำงาน (iPhone, iPad)</li>
                <li>อุปกรณ์สำนักงานครบวงจร (Printer, Projector, Smart TV)</li>
                <li>อุปกรณ์เน็ตเวิร์กและเซิร์ฟเวอร์ (Router, Switch, Access Point)</li>
            </ul>
            <a href="{{ route('quotation.generate') }}" style="color: var(--color-accent); font-weight: 600; text-decoration: none; font-size: 0.95rem; display: inline-flex; align-items: center; gap: 6px; margin-top: 1.5rem;">
                ขอใบเสนอราคาสินค้ายกล็อต ➔
            </a>
        </div>

        <!-- Leasing / Financing -->
        <div style="background: white; border: 1px solid var(--color-silver); border-radius: 20px; padding: 3rem 2.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.01);">
            <div style="font-size: 2.2rem; margin-bottom: 1rem; color: #DD6B20;"><i class="fa-solid fa-percent"></i></div>
            <h3 style="font-size: 1.5rem; font-weight: 700; color: var(--color-navy-dark); margin-top: 0; margin-bottom: 1rem;">บริการเช่าซื้อ/เช่าใช้เครื่องไอทีองค์กร</h3>
            <p style="color: var(--color-grey); font-size: 0.95rem; line-height: 1.7; margin-bottom: 1.5rem;">
                หากธุรกิจต้องการใช้เทคโนโลยีล่าสุดแต่ต้องการรักษาสภาพคล่องทางการเงิน เรามีบริการเช่าซื้ออุปกรณ์แบบจ่ายงวดผ่อนระยะยาว เหมาะสำหรับองค์กร:
            </p>
            <ul style="color: var(--color-grey); font-size: 0.9rem; line-height: 1.8; padding-left: 20px; margin: 0;">
                <li>คอมพิวเตอร์เดสก์ท็อป / คอมพิวเตอร์พกพา (PC / Notebook / Mac)</li>
                <li>อุปกรณ์สำนักงานครบวงจร (Printer, Scanner)</li>
                <li>อุปกรณ์เครือข่ายความเร็วสูงและเซิร์ฟเวอร์ส่วนกลาง</li>
                <li>อุปกรณ์จัดเก็บข้อมูลระยะยาวสำหรับบริษัท (NAS / SAN Storage)</li>
            </ul>
            <a href="{{ route('installment') }}" style="color: #DD6B20; font-weight: 600; text-decoration: none; font-size: 0.95rem; display: inline-flex; align-items: center; gap: 6px; margin-top: 1.5rem;">
                คำนวณอัตราผ่อนชำระเครื่องออนไลน์ ➔
            </a>
        </div>

    </div>

    <!-- Unified CTA -->
    <div style="background: linear-gradient(135deg, var(--color-navy-light) 0%, var(--color-navy-dark) 100%); border-radius: 24px; padding: 4rem 2rem; text-align: center; color: white; box-shadow: 0 20px 45px rgba(18, 28, 48, 0.2);">
        <h2 style="font-size: 2.2rem; font-weight: 700; margin-top: 0; margin-bottom: 1rem;">ต้องการเอกสาร หรือขอใบเสนอราคาด่วน?</h2>
        <p style="color: #CBD5E1; max-width: 700px; margin: 0 auto 2.5rem auto; font-size: 1.05rem; line-height: 1.7;">
            ไม่ว่าจะเป็นการขอจัดซื้ออุปกรณ์เช่า การซ่อมบำรุงรักษาอุปกรณ์รายปี หรือสั่งซื้อฮาร์ดแวร์ไอที ท่านสามารถคำนวณ จัดเตรียมรายการ และสร้างใบเสนอราคาออนไลน์อย่างเป็นทางการได้ทันที
        </p>
        
        <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('quotation.generate') }}" class="pulse-glow" style="background: var(--color-accent); color: white; text-decoration: none; padding: 16px 32px; border-radius: 12px; font-weight: 600; font-size: 1.1rem; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 10px;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 20px rgba(49, 130, 206, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                <i class="fa-solid fa-file-invoice-dollar"></i> สร้างใบเสนอราคาออนไลน์
            </a>
            
            <a href="https://line.me/ti/p/@ddphone" target="_blank" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); color: white; text-decoration: none; padding: 16px 32px; border-radius: 12px; font-weight: 600; font-size: 1.1rem; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 10px;" onmouseover="this.style.background='rgba(255,255,255,0.15)'; this.style.transform='translateY(-3px)';" onmouseout="this.style.background='rgba(255,255,255,0.08)'; this.style.transform='translateY(0)';">
                <i class="fa-brands fa-line" style="color: #06c755; font-size: 1.3rem;"></i> ปรึกษาบริการทาง Line
            </a>
        </div>
    </div>

</div>
@endsection

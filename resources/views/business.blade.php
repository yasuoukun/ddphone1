@extends('layouts.store')

@section('content')
<div class="fade-in" style="max-width: 1200px; margin: 0 auto; padding: 4rem 1.5rem; font-family: 'Prompt', sans-serif;">
    
    <!-- Hero Banner with Gradient -->
    <div style="background: linear-gradient(135deg, var(--color-navy-dark) 0%, var(--color-navy-light) 100%); border-radius: 24px; padding: 4rem 2rem; text-align: center; color: white; margin-bottom: 4rem; box-shadow: 0 20px 40px rgba(18, 28, 48, 0.15); position: relative; overflow: hidden;">
        <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.03); border-radius: 50%;"></div>
        <div style="position: absolute; bottom: -50px; left: -50px; width: 150px; height: 150px; background: rgba(255,255,255,0.03); border-radius: 50%;"></div>
        
        <span style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); color: #E2E8F0; font-size: 0.9rem; font-weight: 600; padding: 8px 20px; border-radius: 30px; letter-spacing: 1px; display: inline-block; margin-bottom: 1.5rem;">ENTERPRISE IT SOLUTIONS</span>
        <h1 style="font-size: 3rem; font-weight: 700; margin: 0 0 1.5rem 0; line-height: 1.2;">บริหารจัดการอุปกรณ์ธุรกิจด้วย Apple Business Manager</h1>
        <p style="color: #CBD5E1; max-width: 800px; margin: 0 auto; font-size: 1.15rem; line-height: 1.7;">
            <strong>Apple in Business:</strong> ด้วย Apple in Business solutions เราคำนึงถึงทุกด้านที่องค์กรคุณต้องการ 
            เพื่อช่วยให้คุณสามารถปรับใช้และบริหารจัดการอุปกรณ์ Apple ได้อย่างมีประสิทธิภาพ ไม่ว่าจะเป็น iPhone, iPad หรือ Mac 
            และไม่ว่าจะเป็นองค์กรขนาดเล็กหรือใหญ่
        </p>
    </div>

    <!-- Video Showcase & Corporate Media -->
    <div style="margin-bottom: 5rem;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2.5rem; align-items: center; margin-bottom: 3rem;">
            <div>
                <h2 style="font-size: 2rem; font-weight: 700; color: var(--color-navy-dark); margin-bottom: 1rem;">
                    ทำไมธุรกิจยุคใหม่จึงเลือก Apple Business Manager?
                </h2>
                <p style="color: var(--color-grey); font-size: 1rem; line-height: 1.8; margin-bottom: 1.5rem;">
                    ช่วยลดเวลาของแผนก IT ในการเซ็ตอัพคอมพิวเตอร์และสมาร์ทโฟนลงกว่า 80% ปรับแต่งค่าความปลอดภัยแบบ Zero-touch Deployment โดยที่พนักงานเพียงแค่เปิดเครื่องขึ้นมาก็พร้อมใช้งานแอปพลิเคชันของบริษัทได้ทันที
                </p>
                <div style="display: flex; gap: 15px;">
                    <div style="background: white; border: 1px solid var(--color-silver); padding: 1rem 1.5rem; border-radius: 16px; flex: 1;">
                        <h4 style="margin: 0; font-size: 1.3rem; font-weight: 800; color: var(--color-accent);">80%</h4>
                        <p style="margin: 4px 0 0; font-size: 0.8rem; color: var(--color-grey);">ลดเวลาทำงานของฝ่าย IT</p>
                    </div>
                    <div style="background: white; border: 1px solid var(--color-silver); padding: 1rem 1.5rem; border-radius: 16px; flex: 1;">
                        <h4 style="margin: 0; font-size: 1.3rem; font-weight: 800; color: #059669;">100%</h4>
                        <p style="margin: 4px 0 0; font-size: 0.8rem; color: var(--color-grey);">การควบคุมความปลอดภัยข้อมูล</p>
                    </div>
                </div>
            </div>
            
            <!-- Embedded Video Player -->
            <div style="position: relative; border-radius: 24px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.12); border: 2px solid var(--color-silver-light); background: #000; aspect-ratio: 16/9;">
                <iframe width="100%" height="100%" src="https://www.youtube.com/embed/S2Y8W3C3K70" title="Apple Business Manager Overview" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>
        </div>

        <!-- Corporate Photo Grid -->
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem;">
            <div style="border-radius: 16px; overflow: hidden; height: 180px;">
                <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&q=80&w=600" alt="Modern Office" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
            </div>
            <div style="border-radius: 16px; overflow: hidden; height: 180px;">
                <img src="https://images.unsplash.com/photo-1531403009284-440f080d1e12?auto=format&fit=crop&q=80&w=600" alt="Team Work Mac" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
            </div>
            <div style="border-radius: 16px; overflow: hidden; height: 180px;">
                <img src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7?auto=format&fit=crop&q=80&w=600" alt="Business Meeting" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
            </div>
        </div>
    </div>

    <!-- Cycle Details Grid -->
    <div class="shopee-mobile-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 4rem;">
        
        <!-- Step 1 -->
        <div style="background: white; border-radius: 20px; border: 1px solid var(--color-silver); padding: 2.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.01);">
            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 1.5rem;">
                <span style="background: rgba(49, 130, 206, 0.1); color: var(--color-accent); width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-weight: 700; font-size: 1.2rem;">1</span>
                <h3 style="font-size: 1.4rem; font-weight: 700; color: var(--color-navy-dark); margin: 0;">วางแผนซื้อ (เช่าใช้ / เช่าซื้อ)</h3>
            </div>
            <p style="color: var(--color-grey); line-height: 1.7; font-size: 0.95rem; margin-bottom: 1.5rem;">
                เราให้บริการ <strong>เช่าใช้ เช่าซื้อ สำหรับองค์กร</strong> จัดหาอุปกรณ์แบบยืดหยุ่น พร้อมตัวเลือกเช่าระยะสั้น-ยาว ตอบโจทย์ทุกความต้องการของธุรกิจคุณ:
            </p>
            <ul style="color: var(--color-grey); font-size: 0.9rem; line-height: 1.8; padding-left: 20px; margin: 0;">
                <li>ลดภาระค่าใช้จ่ายก้อนใหญ่ล่วงหน้า - ชำระเป็นงวดแทนการลงทุนครั้งเดียว</li>
                <li>อัปเกรดอุปกรณ์ได้ง่าย - หมดห่วงเรื่องเทคโนโลยีล้าสมัย</li>
                <li>บริหารงบประมาณได้แม่นยำ - ช่วยควบคุมค่าใช้จ่ายรายเดือนหรือรายปีได้ชัดเจน</li>
                <li>รวมบริการบำรุงรักษาและซัพพอร์ต - มีทีมงานคอยดูแลตลอดอายุสัญญา</li>
                <li>รองรับการตัดค่าใช้จ่ายทางบัญชี - เข้าข่ายเป็นค่าใช้จ่ายในการดำเนินธุรกิจ</li>
                <li>พร้อมใช้งานทันที - ไม่ต้องรอวงรอบการอนุมัติงบประมาณนาน</li>
            </ul>
        </div>

        <!-- Step 2 -->
        <div style="background: white; border-radius: 20px; border: 1px solid var(--color-silver); padding: 2.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.01);">
            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 1.5rem;">
                <span style="background: rgba(49, 130, 206, 0.1); color: var(--color-accent); width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-weight: 700; font-size: 1.2rem;">2</span>
                <h3 style="font-size: 1.4rem; font-weight: 700; color: var(--color-navy-dark); margin: 0;">ตั้งค่า - นำไปใช้งาน (Apple Business Manager)</h3>
            </div>
            <p style="color: var(--color-grey); line-height: 1.7; font-size: 0.95rem; margin-bottom: 1.2rem;">
                <strong>Apple Business Manager (ABM)</strong> คือเครื่องมือบนระบบคลาวด์จาก Apple ที่ออกแบบมาเพื่อช่วยให้ธุรกิจสามารถจัดการอุปกรณ์ Apple, แอปพลิเคชัน และบัญชีผู้ใช้ได้อย่างง่ายดายจากศูนย์กลาง 
                รองรับการทำงานร่วมกับระบบ MDM เพื่อการปรับใช้อุปกรณ์แบบอัตโนมัติและปลอดภัย ช่วยลดปัญหาการตั้งค่าเครื่องไม่ตรงมาตรฐาน หรือการติดตั้งแอปที่ไม่เหมาะสม
            </p>
            <div style="background: var(--color-grey-bg); padding: 12px 18px; border-radius: 12px; font-weight: 600; color: var(--color-navy-dark); font-size: 0.9rem; text-align: center;">
                🚀 เตรียมอุปกรณ์ให้ผู้ใช้ได้เลยตั้งแต่ยังไม่แกะออกจากกล่อง!
            </div>
        </div>

        <!-- Step 3 -->
        <div style="background: white; border-radius: 20px; border: 1px solid var(--color-silver); padding: 2.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.01);">
            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 1.5rem;">
                <span style="background: rgba(49, 130, 206, 0.1); color: var(--color-accent); width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-weight: 700; font-size: 1.2rem;">3</span>
                <h3 style="font-size: 1.4rem; font-weight: 700; color: var(--color-navy-dark); margin: 0;">บริการช่วยเหลือ (IT Support & Services)</h3>
            </div>
            <p style="color: var(--color-grey); line-height: 1.7; font-size: 0.95rem; margin-bottom: 1rem;">
                เราเชี่ยวชาญในการซ่อมบำรุงอุปกรณ์ Apple, iPhone ทุกรุ่น รวมถึงสมาร์ทโฟนแบรนด์อื่นๆ ทีมช่างผู้ชำนาญการของเราผ่านการฝึกอบรมพิเศษและใช้อะไหล่คุณภาพสูง พร้อมเครื่องมือที่ทันสมัย เพื่อให้บริการซ่อมแซมที่มีประสิทธิภาพและรวดเร็ว
            </p>
            <p style="color: var(--color-grey); line-height: 1.7; font-size: 0.95rem; margin: 0;">
                เรารับซ่อมทุกปัญหา ทั้งหน้าจอแตก แบตเตอรี่เสื่อม ปัญหาระบบ และอื่นๆ โดยรับประกันคุณภาพงานซ่อม มั่นใจได้ในความเป็นมืออาชีพของศูนย์บริการ ดีดี.ไอที.คอม
            </p>
        </div>

        <!-- Step 4 -->
        <div style="background: white; border-radius: 20px; border: 1px solid var(--color-silver); padding: 2.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.01);">
            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 1.5rem;">
                <span style="background: rgba(49, 130, 206, 0.1); color: var(--color-accent); width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-weight: 700; font-size: 1.2rem;">4</span>
                <h3 style="font-size: 1.4rem; font-weight: 700; color: var(--color-navy-dark); margin: 0;">เปลี่ยนรุ่น - เทรดอิน (Trade-In Program)</h3>
            </div>
            <p style="color: var(--color-grey); line-height: 1.7; font-size: 0.95rem; margin-bottom: 1rem;">
                เมื่อมีอุปกรณ์เก่าที่องค์กรต้องการผลัดเปลี่ยน <strong>โปรแกรม Trade-in ของ Apple</strong> ช่วยเพิ่มความคุ้มค่าสูงสุดให้องค์กร เนื่องจากอุปกรณ์ Apple เป็นแบรนด์ที่มีมูลค่าคงเหลือ (Residual Value) สูงที่สุดในตลาด
            </p>
            <p style="color: var(--color-grey); line-height: 1.7; font-size: 0.95rem; margin-bottom: 1rem;">
                บริการรับ Trade-In สินค้าเก่า อัปเกรดสินค้าใหม่ ทั้งคอมพิวเตอร์และโน้ตบุ๊ก (Mac, Windows, Laptop), สมาร์ทโฟนและแท็บเล็ต (iPhone, iPad, Android), จอภาพและอุปกรณ์ต่อพ่วง, อุปกรณ์เน็ตเวิร์กและเซิร์ฟเวอร์
            </p>
            <p style="color: var(--color-grey); line-height: 1.7; font-size: 0.95rem; margin: 0;">
                ช่วยลดค่าใช้จ่ายรวมของการเป็นเจ้าของ (TCO) และเพิ่มความต่อเนื่องในการบริหารจัดการอุปกรณ์ในองค์กรได้อย่างชาญฉลาด
            </p>
        </div>

    </div>

    <!-- Comparison Table MDM vs Non-MDM -->
    <div style="background: white; border-radius: 24px; border: 1px solid var(--color-silver); padding: 3rem; margin-bottom: 5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.02);">
        <h3 style="font-size: 1.6rem; font-weight: 700; color: var(--color-navy-dark); margin-top: 0; margin-bottom: 1.5rem; text-align: center;">
            ตารางเปรียบเทียบการใช้งาน: ระบบจัดการอุปกรณ์ (MDM) vs ไม่ใช้ระบบ (Non-MDM)
        </h3>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.95rem;">
                <thead>
                    <tr style="border-bottom: 2px solid var(--color-silver); color: var(--color-navy-dark); font-weight: 700;">
                        <th style="padding: 12px 15px;">หัวข้อ</th>
                        <th style="padding: 12px 15px; color: var(--color-accent);">ใช้ระบบ MDM (ร่วมกับ ABM)</th>
                        <th style="padding: 12px 15px; color: var(--color-grey);">ไม่ใช้ระบบ MDM</th>
                    </tr>
                </thead>
                <tbody style="color: var(--color-grey);">
                    <tr style="border-bottom: 1px solid var(--color-silver-light);">
                        <td style="padding: 12px 15px; font-weight: 600;">การตั้งค่าเริ่มต้น</td>
                        <td style="padding: 12px 15px; color: #38A169; font-weight: 500;">ตั้งค่าอัตโนมัติแบบไร้สาย (Zero-touch)</td>
                        <td style="padding: 12px 15px;">เจ้าหน้าที่ IT ต้องทำเองทีละเครื่อง</td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--color-silver-light);">
                        <td style="padding: 12px 15px; font-weight: 600;">การแจกแอป/เนื้อหา</td>
                        <td style="padding: 12px 15px; color: #38A169; font-weight: 500;">สั่งติดตั้งจากศูนย์กลางได้ทันที</td>
                        <td style="padding: 12px 15px;">ต้องดาวน์โหลดและติดตั้งด้วยตนเอง</td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--color-silver-light);">
                        <td style="padding: 12px 15px; font-weight: 600;">การควบคุมอุปกรณ์</td>
                        <td style="padding: 12px 15px; color: #38A169; font-weight: 500;">รีโมตจัดการ ล็อคเครื่อง หรือลบข้อมูลได้</td>
                        <td style="padding: 12px 15px;">ไม่มีระบบควบคุมจากส่วนกลาง</td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--color-silver-light);">
                        <td style="padding: 12px 15px; font-weight: 600;">ความปลอดภัยของข้อมูล</td>
                        <td style="padding: 12px 15px; color: #38A169; font-weight: 500;">กำหนดนโยบาย / จำกัดสิทธิ์พนักงานได้</td>
                        <td style="padding: 12px 15px;">ขึ้นอยู่กับพนักงานควบคุมและดูแลตนเอง</td>
                    </tr>
                    <tr>
                        <td style="padding: 12px 15px; font-weight: 600;">เวลาที่ใช้ในการเซ็ตอัพ</td>
                        <td style="padding: 12px 15px; color: #38A169; font-weight: 500;">รวดเร็วมาก ประหยัดแรงงานและเวลา IT</td>
                        <td style="padding: 12px 15px;">ล่าช้าและใช้ทรัพยากรบุคคลสูง</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Interactive Call-To-Action (CTA) Page Section -->
    <div style="background: linear-gradient(135deg, var(--color-navy-light) 0%, var(--color-navy-dark) 100%); border-radius: 24px; padding: 4rem 2rem; text-align: center; color: white; box-shadow: 0 20px 45px rgba(18, 28, 48, 0.2);">
        <h2 style="font-size: 2.2rem; font-weight: 700; margin-top: 0; margin-bottom: 1rem;">พร้อมยกระดับองค์กรของคุณแล้วหรือยัง?</h2>
        <p style="color: #CBD5E1; max-width: 700px; margin: 0 auto 2.5rem auto; font-size: 1.05rem; line-height: 1.7;">
            ต้องการคำปรึกษาด้านการเช่าซื้ออุปกรณ์ไอที บริการ Trade-In ตีราคาเครื่อง หรือการติดตั้งระบบ Apple Business Manager สำหรับบริษัทจดทะเบียน ขอใบเสนอราคาอย่างเป็นทางการเพื่อดำเนินเรื่องภายใน 24 ชั่วโมงได้ทันที
        </p>
        
        <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('quotation.generate') }}" class="pulse-glow" style="background: var(--color-accent); color: white; text-decoration: none; padding: 16px 32px; border-radius: 12px; font-weight: 600; font-size: 1.1rem; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 10px;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 20px rgba(49, 130, 206, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                <i class="fa-solid fa-file-invoice-dollar"></i> สร้างใบเสนอราคาองค์กร
            </a>
            
            <a href="https://line.me/ti/p/@ddphone" target="_blank" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); color: white; text-decoration: none; padding: 16px 32px; border-radius: 12px; font-weight: 600; font-size: 1.1rem; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 10px;" onmouseover="this.style.background='rgba(255,255,255,0.15)'; this.style.transform='translateY(-3px)';" onmouseout="this.style.background='rgba(255,255,255,0.08)'; this.style.transform='translateY(0)';">
                <i class="fa-brands fa-line" style="color: #06c755; font-size: 1.3rem;"></i> ติดต่อฝ่ายขายธุรกิจทาง Line
            </a>
        </div>
    </div>

</div>
@endsection

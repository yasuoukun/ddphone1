@extends('layouts.store')

@section('content')
<div class="fade-in" style="max-width: 1200px; margin: 0 auto; padding: 4rem 1.5rem; font-family: 'Prompt', sans-serif;">
    
    <!-- Hero Banner with Gradient -->
    <div style="background: linear-gradient(135deg, #070D1B 0%, #0F172A 100%); border-radius: 26px; padding: 5rem 2rem; text-align: center; color: white; margin-bottom: 4rem; border: 2px solid #FFE600; box-shadow: 0 20px 40px rgba(0,0,0,0.3); position: relative; overflow: hidden;">
        <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255,230,0,0.05); border-radius: 50%;"></div>
        
        <span class="badge-yellow-fun bounce-fun" style="margin-bottom: 1.25rem;">ABOUT DDPHONE</span>
        <h1 style="font-size: 3rem; font-weight: 900; margin: 0 0 1.25rem 0; line-height: 1.2;">DDPHONE ดีดีโฟน</h1>
        <p style="color: #CBD5E1; max-width: 800px; margin: 0 auto; font-size: 1.2rem; line-height: 1.7;">
            ศูนย์รวมสมาร์ทโฟนมือสองคัดเกรด A+ แท้ 100% ผ่านการตรวจเช็กละเอียด 30 รายการ พร้อมรับประกัน 30 วันเต็ม
        </p>
    </div>

    <!-- Corporate History Section -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 3.5rem; align-items: center; margin-bottom: 5rem;">
        <div>
            <h2 style="font-size: 2.2rem; font-weight: 900; color: var(--color-navy-dark); margin-bottom: 1.5rem;">
                ความเป็นมาของ DDPHONE
                <span style="display: block; width: 60px; height: 4px; background: #FFE600; margin-top: 10px; border-radius: 2px;"></span>
            </h2>
            <p style="color: #334155; font-size: 1.05rem; line-height: 1.8; margin-bottom: 1.5rem;">
                <strong>DDPHONE ดีดีโฟน</strong> คือศูนย์รวมโทรศัพท์มือถือสมาร์ทโฟนมือสองคัดเกรดคุณภาพสูง iPhone, iPad และ Android แบรนด์ชั้นนำ ผ่านการคัดสรรสภาพนางฟ้า สภาพสดใหม่ 95-99% และตรวจทดสอบระบบการทำงานอย่างละเอียดโดยช่างผู้เชี่ยวชาญก่อนส่งถึงมือลูกค้า
            </p>
            <p style="color: #334155; font-size: 1.05rem; line-height: 1.8; margin-bottom: 1.5rem;">
                เรามุ่งมั่นให้บริการด้วยความซื่อสัตย์ ตรงไปตรงมา รับประกันสินค้าจริง 30 วันเต็ม มีหน้าร้านชัดเจน บริการจัดส่งด่วนทั่วประเทศพร้อมระบบเก็บเงินปลายทาง เพื่อให้ลูกค้าทุกท่านมั่นใจสูงสุดในทุกคำสั่งซื้อ
            </p>
        </div>
        <div>
            <div style="background: white; border: 2px solid #E2E8F0; border-radius: 24px; padding: 2.5rem; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
                <span style="font-size: 4rem; font-weight: 900; color: #FF5722; display: block; line-height: 1;" class="bounce-fun">100%</span>
                <span style="font-size: 1.15rem; font-weight: 800; color: var(--color-navy-dark); display: block; margin-top: 10px; margin-bottom: 15px;">เครื่องแท้คัดเกรด A+ รับประกัน 30 วัน</span>
                <p style="color: #64748b; font-size: 0.92rem; line-height: 1.6; margin: 0;">
                    ผ่านการทดสอบ 30 รายการ ทั้งสุขภาพแบตเตอรี่ กล้องถ่ายรูป สแกนนิ้ว/หน้า และระบบสัญญาณ
                </p>
            </div>
        </div>
    </div>

    <!-- Strengths Section: สิ่งที่ทำให้เราแตกต่าง -->
    <div style="background: white; border-radius: 24px; border: 1px solid var(--color-silver); padding: 3.5rem; margin-bottom: 5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.02);">
        <h2 style="font-size: 2rem; font-weight: 700; color: var(--color-navy-dark); text-align: center; margin-top: 0; margin-bottom: 3rem;">
            สิ่งที่ทำให้เราแตกต่าง
        </h2>
        
        <div class="shopee-mobile-row" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
            
            <div style="text-align: center; padding: 1rem;">
                <div style="width: 70px; height: 70px; background: rgba(49, 130, 206, 0.1); color: var(--color-accent); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem auto; font-size: 2rem;">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--color-navy-dark); margin-bottom: 10px;">ความปลอดภัยสูงสุด</h3>
                <p style="color: var(--color-grey); font-size: 0.92rem; line-height: 1.7; margin: 0;">
                    ปกป้องข้อมูลสำคัญขององค์กรด้วยระบบ MDM มาตรฐานสากล ควบคุมสิทธิ์การเข้าถึงและป้องกันข้อมูลรั่วไหลในทุกอุปกรณ์ได้อย่างรัดกุม
                </p>
            </div>

            <div style="text-align: center; padding: 1rem;">
                <div style="width: 70px; height: 70px; background: rgba(49, 130, 206, 0.1); color: var(--color-accent); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem auto; font-size: 2rem;">
                    <i class="fa-solid fa-diagram-project"></i>
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--color-navy-dark); margin-bottom: 10px;">เชี่ยวชาญระบบองค์กร</h3>
                <p style="color: var(--color-grey); font-size: 0.92rem; line-height: 1.7; margin: 0;">
                    ทีมวิศวกรผู้เชี่ยวชาญในการวางระบบ Apple Business Manager (ABM) และการตั้งค่าอุปกรณ์จำนวนมากแบบอัตโนมัติ (Zero-Touch Deployment)
                </p>
            </div>

            <div style="text-align: center; padding: 1rem;">
                <div style="width: 70px; height: 70px; background: rgba(49, 130, 206, 0.1); color: var(--color-accent); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem auto; font-size: 2rem;">
                    <i class="fa-solid fa-hand-holding-dollar"></i>
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--color-navy-dark); margin-bottom: 10px;">บริหารต้นทุนคุ้มค่า</h3>
                <p style="color: var(--color-grey); font-size: 0.92rem; line-height: 1.7; margin: 0;">
                    นำเสนอโซลูชันที่ตอบโจทย์การลงทุน (ROI) ทั้งรูปแบบการจัดซื้อและการเช่าใช้อุปกรณ์ (DaaS) ช่วยองค์กรลดภาระค่าใช้จ่ายระยะยาว
                </p>
            </div>

            <div style="text-align: center; padding: 1rem;">
                <div style="width: 70px; height: 70px; background: rgba(49, 130, 206, 0.1); color: var(--color-accent); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem auto; font-size: 2rem;">
                    <i class="fa-solid fa-people-carry-box"></i>
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--color-navy-dark); margin-bottom: 10px;">พันธมิตรพร้อมดูแล</h3>
                <p style="color: var(--color-grey); font-size: 0.92rem; line-height: 1.7; margin: 0;">
                    เคียงข้างธุรกิจคุณด้วยบริการ IT Support ระดับ Enterprise ทั้งการดูแลรักษาระบบ (MA) และให้คำปรึกษาอย่างต่อเนื่องและไว้ใจได้
                </p>
            </div>

        </div>
    </div>

    <!-- Vision & Mission Section -->
    <div style="display: grid; grid-template-columns: 1fr 1.2fr; gap: 3.5rem; margin-bottom: 5rem;">
        
        <!-- Vision -->
        <div style="background: linear-gradient(135deg, var(--color-navy-light) 0%, var(--color-navy-dark) 100%); border-radius: 20px; padding: 3rem 2.5rem; color: white; box-shadow: 0 10px 35px rgba(18,28,48,0.1);">
            <div style="font-size: 2.2rem; margin-bottom: 1rem; color: #E2E8F0;"><i class="fa-regular fa-eye"></i></div>
            <h2 style="font-size: 1.8rem; font-weight: 700; margin-top: 0; margin-bottom: 1.5rem;">วิสัยทัศน์ (Vision)</h2>
            <p style="font-size: 1.1rem; line-height: 1.8; color: #E2E8F0; font-style: italic; margin: 0;">
                "มุ่งสู่การเป็นผู้นำด้านการจัดจำหน่ายสินค้าไอทีและโทรศัพท์มือถือที่ลูกค้าไว้วางใจมากที่สุดในประเทศไทย ด้วยบริการที่เป็นเลิศ สินค้าคุณภาพ และเทคโนโลยีล้ำสมัย"
            </p>
        </div>

        <!-- Mission -->
        <div style="background: white; border: 1px solid var(--color-silver); border-radius: 20px; padding: 3rem 2.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.01);">
            <div style="font-size: 2.2rem; margin-bottom: 1rem; color: var(--color-accent);"><i class="fa-solid fa-bullseye"></i></div>
            <h2 style="font-size: 1.8rem; font-weight: 700; color: var(--color-navy-dark); margin-top: 0; margin-bottom: 1.5rem;">พันธกิจ (Mission)</h2>
            <ul style="color: var(--color-grey); font-size: 1rem; line-height: 1.8; padding-left: 20px; margin: 0; display: flex; flex-direction: column; gap: 10px;">
                <li><strong>จัดจำหน่ายสินค้าไอทีและโทรศัพท์มือถือคุณภาพ</strong> จากแบรนด์ชั้นนำ พร้อมรับประกันความพึงพอใจ</li>
                <li><strong>ให้บริการลูกค้าอย่างมืออาชีพ</strong> ด้วยความจริงใจ รวดเร็ว และเป็นกันเอง</li>
                <li><strong>พัฒนาระบบการขายออนไลน์และหน้าร้านให้ทันสมัย</strong> รองรับทุกความต้องการของลูกค้าในยุคดิจิทัล</li>
                <li><strong>สร้างประสบการณ์การซื้อขายที่เหนือความคาดหมาย</strong> ด้วยโปรโมชั่นดี ราคาคุ้มค่า และบริการหลังการขายที่ไว้ใจได้</li>
            </ul>
        </div>

    </div>

    <!-- Trusted IT Partner Block -->
    <div style="background: white; border-radius: 24px; border: 2px solid #FFE600; padding: 3.5rem; text-align: center; margin-bottom: 5rem; box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
        <h3 style="font-size: 1.8rem; font-weight: 900; color: var(--color-navy-dark); margin-top: 0; margin-bottom: 1.2rem;">
            📱 ศูนย์รวมสมาร์ทโฟนมือสองที่คุณไว้วางใจ (Your Trusted Phone Store)
        </h3>
        <p style="color: #334155; max-width: 900px; margin: 0 auto; font-size: 1.05rem; line-height: 1.8;">
            <strong>DDPHONE ดีดีโฟน:</strong> ศูนย์รวมสมาร์ทโฟนมือสองสภาพนางฟ้าในจังหวัดชัยภูมิและบริการจัดส่งทั่วประเทศ เรามุ่งมั่นส่งมอบโทรศัพท์มือถือคัดเกรดคุณภาพ A+ แท้ 100% พร้อมบริการรับประกัน 30 วันเต็ม และทีมงานแอดมินคอยให้คำปรึกษาดูแลตลอดการใช้งาน
        </p>
    </div>

    <!-- Contact & Operating Hours Section -->
    <div style="background: white; border: 2px solid #E2E8F0; border-radius: 24px; padding: 3.5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.02); display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 3rem; align-items: center;">
        <div>
            <h2 style="font-size: 2rem; font-weight: 900; color: var(--color-navy-dark); margin-top: 0; margin-bottom: 1.5rem;">
                ข้อมูลติดต่อเรา
            </h2>
            <div style="display: flex; flex-direction: column; gap: 1.2rem; color: #334155; font-size: 1rem;">
                <div style="display: flex; gap: 15px; align-items: flex-start;">
                    <span style="color: #FF5722; font-size: 1.2rem;"><i class="fa-solid fa-location-dot"></i></span>
                    <span>
                        <strong>DDPHONE ดีดีโฟน (หน้าร้านชัยภูมิ)</strong><br>
                        ที่อยู่ 72/47-48ก ถนนชัยประสิทธิ์ ต.ในเมือง อ.เมือง จ.ชัยภูมิ 36000
                    </span>
                </div>
                <div style="display: flex; gap: 15px; align-items: center;">
                    <span style="color: #FF5722; font-size: 1.2rem;"><i class="fa-solid fa-clock"></i></span>
                    <span><strong>เวลาทำการ:</strong> จันทร์ - อาทิตย์ เวลา 09.00 - 19.00 น.</span>
                </div>
                <div style="display: flex; gap: 15px; align-items: center;">
                    <span style="color: #FF5722; font-size: 1.2rem;"><i class="fa-solid fa-phone"></i></span>
                    <span><strong>เบอร์โทร:</strong> 083-828-9414, 044-822-388</span>
                </div>
                <div style="display: flex; gap: 15px; align-items: center;">
                    <span style="color: #FF5722; font-size: 1.2rem;"><i class="fa-solid fa-envelope"></i></span>
                    <span><strong>อีเมล:</strong> ddit.com.88@gmail.com</span>
                </div>
            </div>
        </div>
        
        <div style="text-align: center; background: var(--color-grey-bg); border-radius: 20px; padding: 3rem 2rem; border: 1px solid var(--color-silver-light);">
            <h3 style="color: var(--color-navy-dark); font-weight: 700; margin-top: 0; margin-bottom: 1rem; font-size: 1.4rem;">เชื่อมต่อกับเรา</h3>
            <p style="color: var(--color-grey); font-size: 0.95rem; margin-bottom: 2rem;">
                มีคำถามเพิ่มเติม ต้องการให้ทีมขายติดต่อกลับ หรือต้องการส่งเครื่องเก่ามาเปลี่ยนใหม่?
            </p>
            <a href="https://line.me/ti/p/@dditcom" target="_blank" style="background: #06c755; color: white; text-decoration: none; padding: 14px 28px; border-radius: 12px; font-weight: 600; font-size: 1.05rem; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 10px; width: 100%; justify-content: center; box-shadow: 0 4px 15px rgba(6,199,85,0.25);" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='translateY(0)';">
                <i class="fa-brands fa-line" style="font-size: 1.3rem;"></i> แชทคุยกับทีมงานทาง Line
            </a>
        </div>
    </div>

</div>
@endsection

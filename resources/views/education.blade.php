@extends('layouts.store')

@section('content')
<div class="fade-in" style="max-width: 1200px; margin: 0 auto; padding: 4rem 1.5rem; font-family: 'Prompt', sans-serif;">
    
    <!-- Hero Banner with Gradient -->
    <div style="background: linear-gradient(135deg, var(--color-navy-dark) 0%, var(--color-navy-light) 100%); border-radius: 24px; padding: 4rem 2rem; text-align: center; color: white; margin-bottom: 4rem; box-shadow: 0 20px 40px rgba(18, 28, 48, 0.15); position: relative; overflow: hidden;">
        <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.03); border-radius: 50%;"></div>
        <div style="position: absolute; bottom: -50px; left: -50px; width: 150px; height: 150px; background: rgba(255,255,255,0.03); border-radius: 50%;"></div>
        
        <span style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); color: #E2E8F0; font-size: 0.9rem; font-weight: 600; padding: 8px 20px; border-radius: 30px; letter-spacing: 1px; display: inline-block; margin-bottom: 1.5rem;">EDUCATION IT SOLUTIONS</span>
        <h1 style="font-size: 3rem; font-weight: 700; margin: 0 0 1.5rem 0; line-height: 1.2;">ยกระดับการเรียนการสอนด้วยระบบ Apple School Manager</h1>
        <p style="color: #CBD5E1; max-width: 800px; margin: 0 auto; font-size: 1.15rem; line-height: 1.7;">
            <strong>Apple สำหรับสถานศึกษา</strong> ดีดี.ไอที.คอม (DDITCOM) คือพันธมิตรด้านการศึกษา (Apple Education Partner) 
            เราให้การสนับสนุนโรงเรียน วิทยาลัย และมหาวิทยาลัยในการนำผลิตภัณฑ์ Apple ไปใช้เพื่อพัฒนารูปแบบการเรียนการสอนทั้งในห้องเรียนและนอกห้องเรียน 
            เราพร้อมทำงานร่วมกับคุณอย่างใกล้ชิดเพื่อทำความเข้าใจวิสัยทัศน์และผลลัพธ์ที่คุณต้องการ เพื่อให้เราสามารถส่งมอบโซลูชันที่ยั่งยืนและประสบความสำเร็จ
        </p>
    </div>

    <!-- Video & Image Showcase -->
    <div style="margin-bottom: 5rem;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2.5rem; align-items: center; margin-bottom: 3rem;">
            <div>
                <h2 style="font-size: 2.2rem; font-weight: 700; color: var(--color-navy-dark); margin-bottom: 1.2rem; position: relative;">
                    ทำไมต้อง Apple ในด้านการศึกษา?
                    <span style="display: block; width: 60px; height: 4px; background: var(--color-accent); margin-top: 10px; border-radius: 2px;"></span>
                </h2>
                <p style="color: var(--color-grey); font-size: 1.05rem; line-height: 1.8; margin-bottom: 1.5rem;">
                    เราอาจคุ้นเคยกับผลิตภัณฑ์ยอดเยี่ยมของ Apple เช่น iPad และ Mac ที่ออกแบบมาอย่างดีและผู้คนใช้งานในชีวิตประจำวันอยู่เสมอ แต่สิ่งที่คุณอาจยังไม่ทราบ คือ Apple ยังออกแบบผลิตภัณฑ์พร้อมแนวคิดเพื่อการศึกษาด้วย ทั้งยังมีแอป ฟีเจอร์และระบบการจัดการอุปกรณ์ที่ทรงพลัง ซึ่งออกแบบมาโดยเฉพาะเพื่อการเรียนการสอนในห้องเรียน
                </p>
                <div style="display: flex; gap: 15px;">
                    <div style="background: white; border: 1px solid var(--color-silver); padding: 1rem 1.5rem; border-radius: 16px; flex: 1;">
                        <h4 style="margin: 0; font-size: 1.4rem; font-weight: 800; color: var(--color-accent);">100%</h4>
                        <p style="margin: 4px 0 0; font-size: 0.85rem; color: var(--color-grey);">รองรับระบบการเรียนการสอนออนไลน์</p>
                    </div>
                    <div style="background: white; border: 1px solid var(--color-silver); padding: 1rem 1.5rem; border-radius: 16px; flex: 1;">
                        <h4 style="margin: 0; font-size: 1.4rem; font-weight: 800; color: #059669;">Zero-Touch</h4>
                        <p style="margin: 4px 0 0; font-size: 0.85rem; color: var(--color-grey);">กระจายแอปผ่าน Apple School Manager</p>
                    </div>
                </div>
            </div>
            
            <!-- Embedded Video Player -->
            <div style="position: relative; border-radius: 24px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.12); border: 2px solid var(--color-silver-light); background: #000; aspect-ratio: 16/9;">
                <iframe width="100%" height="100%" src="https://www.youtube.com/embed/WJ_p-i10n4Q" title="Apple Education Video" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>
        </div>

        <!-- Photo Gallery Grid -->
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem;">
            <div style="border-radius: 16px; overflow: hidden; height: 200px; shadow: 0 4px 15px rgba(0,0,0,0.05);">
                <img src="https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?auto=format&fit=crop&q=80&w=600" alt="Education iPad" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
            </div>
            <div style="border-radius: 16px; overflow: hidden; height: 200px; shadow: 0 4px 15px rgba(0,0,0,0.05);">
                <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&q=80&w=600" alt="Digital Classroom" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
            </div>
            <div style="border-radius: 16px; overflow: hidden; height: 200px; shadow: 0 4px 15px rgba(0,0,0,0.05);">
                <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&q=80&w=600" alt="Students Working" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
            </div>
        </div>
    </div>

    <!-- Section: iPad for Education -->
    <div style="background: white; border-radius: 24px; border: 1px solid var(--color-silver); padding: 3.5rem; margin-bottom: 4rem; box-shadow: 0 4px 20px rgba(0,0,0,0.02);">
        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 2rem;">
            <span style="font-size: 2.5rem; color: var(--color-accent);"><i class="fa-solid fa-tablet-screen-button"></i></span>
            <h2 style="font-size: 2rem; font-weight: 700; color: var(--color-navy-dark); margin: 0;">ทำไมต้อง iPad เพื่อการศึกษา</h2>
        </div>
        <p style="color: var(--color-grey); font-size: 1.05rem; line-height: 1.8; margin-bottom: 2.5rem;">
            ไม่ว่าจะเป็นงานแบบใด ก็จัดการให้เสร็จได้ด้วยเครื่องมือที่พกพาง่ายและทรงพลังอย่าง iPad ความอเนกประสงค์ดังกล่าวมอบขุมพลังด้านการเรียนการสอนแก่ทั้งนักเรียนและผู้สอนในรูปแบบที่ดีที่สุดสำหรับแต่ละคน และด้วยแบตเตอรี่ที่ใช้งานได้นาน 10 ชั่วโมง* กับดีไซน์ที่ทั้งบางและเบา ทำให้การเรียนการสอนด้วย iPad เกิดขึ้นได้ทุกที่ทุกเวลาตลอดทั้งวัน
        </p>

        <!-- iPad Features Grid -->
        <div class="shopee-mobile-row" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
            <div style="background: var(--color-grey-bg); border-radius: 16px; padding: 1.8rem; border: 1px solid var(--color-silver-light);">
                <h3 style="color: var(--color-navy-dark); font-weight: 700; margin-top: 0; display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-bolt" style="color: #D69E2E;"></i> ประสิทธิภาพอันทรงพลัง
                </h3>
                <p style="color: var(--color-grey); font-size: 0.95rem; line-height: 1.7;">
                    ชิป A14 Bionic อันทรงพลังมอบประสิทธิภาพและการตอบสนองที่เหนือชั้น เพื่อให้นักเรียนและผู้สอนทำสิ่งมหัศจรรย์ได้บน iPad แอปที่มาพร้อมเครื่องสำหรับการเรียนรู้และการสร้างสรรค์ช่วยยกระดับงานทั่วไปในชีวิตประจำวันให้เหนือขึ้นไปอีกระดับ ในขณะที่แอปด้านการศึกษาใน App Store ก็ช่วยพัฒนาการเรียนรู้ไปอีกขั้น
                </p>
            </div>
            
            <div style="background: var(--color-grey-bg); border-radius: 16px; padding: 1.8rem; border: 1px solid var(--color-silver-light);">
                <h3 style="color: var(--color-navy-dark); font-weight: 700; margin-top: 0; display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-circle-nodes" style="color: var(--color-accent);"></i> ขีดความสามารถเหนือระดับ
                </h3>
                <p style="color: var(--color-grey); font-size: 0.95rem; line-height: 1.7;">
                    iPad มอบขุมพลังด้านการเรียนการสอนแก่ทั้งนักเรียนและผู้สอนไม่ว่าจะที่ใด เมื่อใด และมีความต้องการแบบใดก็ตาม เครื่องมือเพื่อการสร้างสรรค์และการทำงานร่วมกันที่มาพร้อมเครื่อง ทำให้ iPad เป็นได้ทุกสิ่งที่จำเป็น ทั้งกล้อง สตูดิโอบันทึกเสียง โน้ตบุ๊ก สมุดวาดภาพ และอีกมากมาย
                </p>
            </div>

            <div style="background: var(--color-grey-bg); border-radius: 16px; padding: 1.8rem; border: 1px solid var(--color-silver-light);">
                <h3 style="color: var(--color-navy-dark); font-weight: 700; margin-top: 0; display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-link" style="color: #38A169;"></i> ใช้งานร่วมกับอุปกรณ์อื่นได้ดี
                </h3>
                <p style="color: var(--color-grey); font-size: 0.95rem; line-height: 1.7;">
                    iPad เป็นอุปกรณ์ที่สมบูรณ์แบบสำหรับแอปและเวิร์กโฟลว์ทั้งหมดที่นักเรียนและผู้สอนจำเป็นต้องใช้ รวมถึง Google Workspace for Education, Microsoft 365 และระบบบริหารจัดการการเรียนรู้ยอดนิยมในปัจจุบันอีกมากมาย อีกทั้งแอปไฟล์บน iPad ยังทำให้การเข้าถึงไฟล์บนไดรฟ์ USB และบริการคลาวด์ทำได้ง่ายครบถ้วนในที่เดียว
                </p>
            </div>

            <div style="background: var(--color-grey-bg); border-radius: 16px; padding: 1.8rem; border: 1px solid var(--color-silver-light);">
                <h3 style="color: var(--color-navy-dark); font-weight: 700; margin-top: 0; display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-shield-halved" style="color: #E53E3E;"></i> สร้างมาให้ทนทานยาวนาน
                </h3>
                <p style="color: var(--color-grey); font-size: 0.95rem; line-height: 1.7;">
                    iPad เพรียวบางจนเหลือเชื่อและมีน้ำหนักไม่ถึง 500 กรัมจึงเบาจนพกพาไปเรียนรู้ที่ใดก็ได้ ทั้งยังมีโครงสร้างอะลูมิเนียมแบบ Unibody ที่ทนทาน ซึ่งพัฒนาขึ้นเพื่อรับมือกับการใช้งานในแต่ละวันที่แสนหนักหน่วงของนักเรียนได้ อีกทั้งตัวเครื่องยังทำจากอะลูมิเนียมรีไซเคิล 100% ดังนั้น iPad จึงเป็นมิตรต่อสิ่งแวดล้อมอีกด้วย
                </p>
            </div>

            <div style="background: var(--color-grey-bg); border-radius: 16px; padding: 1.8rem; border: 1px solid var(--color-silver-light);">
                <h3 style="color: var(--color-navy-dark); font-weight: 700; margin-top: 0; display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-square-poll-horizontal" style="color: var(--color-accent);"></i> อินเทอร์เฟซหน้าจอสัมผัส
                </h3>
                <p style="color: var(--color-grey); font-size: 0.95rem; line-height: 1.7;">
                    iPad มีอินเทอร์เฟซหน้าจอสัมผัสที่ใช้งานง่ายทำให้นักเรียนและผู้สอนค้นหาสิ่งที่ต้องการได้ง่าย จัดการงานได้เป็นระเบียบ และรับมือกับงานมอบหมายได้ทุกแบบ ยิ่งถ้าคุ้นเคยกับ iPhone อยู่แล้ว ก็จะรู้สึกว่าการใช้ iPad นั้นง่ายยิ่งขึ้นด้วยดีไซน์อันเรียบง่ายและชัดเจน ที่เห็นปุ๊บก็เข้าใจได้ทันที
                </p>
            </div>

            <div style="background: var(--color-grey-bg); border-radius: 16px; padding: 1.8rem; border: 1px solid var(--color-silver-light);">
                <h3 style="color: var(--color-navy-dark); font-weight: 700; margin-top: 0; display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-pen-fancy" style="color: #805AD5;"></i> ใช้ร่วมกับอุปกรณ์เสริม
                </h3>
                <p style="color: var(--color-grey); font-size: 0.95rem; line-height: 1.7;">
                    นักเรียนและผู้สอนจะทำอะไรๆ ได้มากขึ้นเมื่อใช้ประโยชน์จากอุปกรณ์เสริม iPad เทคโนโลยีการดูดซับแรงกระแทกที่ใช้สร้างเคส iPad ออกแบบมาให้รับมือกับความสึกหรอจากการใช้งานในแต่ละวันของนักเรียน ทั้งในชั้นเรียนและที่บ้าน ส่วนสไตลัส iPad เช่น Logitech Crayon และ Apple Pencil ก็เป็นดินสอดิจิทัลที่อเนกประสงค์
                </p>
            </div>
        </div>

        <div style="margin-top: 2rem; padding: 1.5rem; background: rgba(49, 130, 206, 0.05); border-radius: 16px; border-left: 4px solid var(--color-accent); display: flex; flex-direction: column; gap: 10px;">
            <strong style="color: var(--color-navy-dark); font-size: 1.05rem;">💡 เพิ่มเติมเกี่ยวกับโซลูชัน iPad:</strong>
            <ul style="margin: 0; padding-left: 20px; color: var(--color-grey); font-size: 0.95rem; line-height: 1.8;">
                <li><strong>แชร์ผลงานได้อย่างรวดเร็ว:</strong> AirDrop มอบวิธีการที่รวดเร็วให้กับผู้สอนและนักเรียนในการแชร์งานมอบหมาย โน้ต และเอกสารไปยังอุปกรณ์อื่นๆ ของ Apple ภายในห้อง</li>
                <li><strong>ปกป้องความเป็นส่วนตัวตั้งแต่แรกเริ่ม:</strong> ผลิตภัณฑ์ทั้งหมดของ Apple ออกแบบและสร้างขึ้นโดยคำนึงถึงความเป็นส่วนตัวและความปลอดภัยเป็นสำคัญ</li>
                <li><strong>ทุกคนเข้าถึงได้:</strong> iPad ทุกเครื่องมาพร้อมกับคุณสมบัติการช่วยการเข้าถึงในตัวที่หลากหลายเพื่อให้นักเรียนทุกคนสามารถเรียนรู้ได้ตั้งแต่แรก</li>
                <li><strong>ผสานการทำงานในห้องเรียนได้แบบไม่มีสะดุด:</strong> iPad รองรับโมเดลการแจกจ่ายและการจัดการที่ทันสมัยพร้อมด้วยการตั้งค่าแบบไร้สายที่มีประสิทธิภาพ ช่วยประหยัดเวลาฝ่าย IT</li>
            </ul>
        </div>
    </div>

    <!-- Section: Mac for Education -->
    <div style="background: white; border-radius: 24px; border: 1px solid var(--color-silver); padding: 3.5rem; margin-bottom: 5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.02);">
        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 2rem;">
            <span style="font-size: 2.5rem; color: #DD6B20;"><i class="fa-solid fa-laptop"></i></span>
            <h2 style="font-size: 2rem; font-weight: 700; color: var(--color-navy-dark); margin: 0;">ทำไมต้อง Mac เพื่อการศึกษา</h2>
        </div>
        <p style="color: var(--color-grey); font-size: 1.05rem; line-height: 1.8; margin-bottom: 2.5rem;">
            Mac คือคอมพิวเตอร์ที่เหมาะกับการศึกษาที่สุดและยังเป็นขุมพลังสำหรับการสร้างประสบการณ์การเรียนรู้ที่น่าสนใจ Mac มาพร้อมกับคุณสมบัติที่ช่วยให้นักเรียนและนักการศึกษาทำงานได้อย่างมีประสิทธิภาพ เกิดความร่วมมือ และเชื่อมต่อกันอยู่เสมอไม่ว่าจะเป็นในห้องเรียน ที่บ้าน หรือระหว่างเดินทาง
        </p>

        <!-- Mac Features Grid -->
        <div class="shopee-mobile-row" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
            <div style="background: var(--color-grey-bg); border-radius: 16px; padding: 1.8rem; border: 1px solid var(--color-silver-light);">
                <h3 style="color: var(--color-navy-dark); font-weight: 700; margin-top: 0; display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-wand-magic-sparkles" style="color: #DD6B20;"></i> เครื่องมือสร้างสรรค์อันทรงพลัง
                </h3>
                <p style="color: var(--color-grey); font-size: 0.95rem; line-height: 1.7;">
                    ไม่ว่าจะขับเคลื่อนด้วยชิป Apple M1 หรือชิป M2 รุ่นใหม่ล่าสุด Mac ก็มาพร้อมกับขุมพลังที่จำเป็นต่อการเรียนรู้ของนักเรียน นักเรียนสามารถสร้างสรรค์ได้โดยใช้แอปที่มีในตัวอย่าง Safari เพื่อการค้นหาในเว็บที่ลื่นไหล หรือ iMovie เพื่อทำงานในโปรเจ็กต์ร่วมกัน
                </p>
            </div>

            <div style="background: var(--color-grey-bg); border-radius: 16px; padding: 1.8rem; border: 1px solid var(--color-silver-light);">
                <h3 style="color: var(--color-navy-dark); font-weight: 700; margin-top: 0; display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-battery-full" style="color: #38A169;"></i> ประสิทธิภาพที่ไม่มีสะดุด
                </h3>
                <p style="color: var(--color-grey); font-size: 0.95rem; line-height: 1.7;">
                    MacBook Air ใช้งานแบตเตอรี่ได้นานสูงสุด 18 ชั่วโมง แม้จะเลยเวลาคาบเรียนสุดท้ายแล้วก็ยังเรียนรู้ต่อได้นาน* Mac ทุกเครื่องมาพร้อมกับ Pages, Numbers, Keynote, iMovie, GarageBand และแอปประสิทธิภาพสูงอีกมากมาย
                </p>
            </div>

            <div style="background: var(--color-grey-bg); border-radius: 16px; padding: 1.8rem; border: 1px solid var(--color-silver-light);">
                <h3 style="color: var(--color-navy-dark); font-weight: 700; margin-top: 0; display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-laptop-code" style="color: var(--color-accent);"></i> ใช้งานร่วมกับอุปกรณ์อื่นได้ดี
                </h3>
                <p style="color: var(--color-grey); font-size: 0.95rem; line-height: 1.7;">
                    Mac เป็นคอมพิวเตอร์ที่สมบูรณ์แบบสำหรับแอปและเวิร์กโฟลว์ทั้งหมดที่นักเรียนจำเป็นต้องใช้ รวมถึง Google Workspace for Education, Microsoft Office 365 และระบบบริหารจัดการการเรียนรู้ยอดนิยมในปัจจุบันอีกมากมาย
                </p>
            </div>

            <div style="background: var(--color-grey-bg); border-radius: 16px; padding: 1.8rem; border: 1px solid var(--color-silver-light);">
                <h3 style="color: var(--color-navy-dark); font-weight: 700; margin-top: 0; display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-shield" style="color: var(--color-navy);"></i> แข็งแรง ทนทาน ยาวนาน
                </h3>
                <p style="color: var(--color-grey); font-size: 0.95rem; line-height: 1.7;">
                    Mac ช่วยให้นักเรียนและผู้สอนทำงานให้เสร็จเรียบร้อยได้ไม่ว่าจะอยู่ที่ไหน ด้วยดีไซน์ที่บางและเบาอย่างเหลือเชื่อ ตัวเครื่องทำจากอะลูมิเนียมรีไซเคิล 100% จึงเป็นมิตรต่อสิ่งแวดล้อมและแข็งแรงพอที่จะรับมือกับการใช้งานที่แสนหนักหน่วงได้
                </p>
            </div>

            <div style="background: var(--color-grey-bg); border-radius: 16px; padding: 1.8rem; border: 1px solid var(--color-silver-light);">
                <h3 style="color: var(--color-navy-dark); font-weight: 700; margin-top: 0; display: flex; align-items: center; gap: 10px;">
                    <i class="fa-regular fa-lightbulb" style="color: #D69E2E;"></i> อินเทอร์เฟซที่ใช้งานง่าย
                </h3>
                <p style="color: var(--color-grey); font-size: 0.95rem; line-height: 1.7;">
                    Mac สร้างขึ้นโดยคำนึงถึงนักเรียน ให้นักเรียนสามารถค้นหาสิ่งที่ต้องการ จัดระเบียบ และทำงานที่ได้รับมอบหมายได้อย่างง่ายดาย การค้นหาโดย Spotlight ช่วยให้ค้นหางานได้รวดเร็วในพริบตา
                </p>
            </div>

            <div style="background: var(--color-grey-bg); border-radius: 16px; padding: 1.8rem; border: 1px solid var(--color-silver-light);">
                <h3 style="color: var(--color-navy-dark); font-weight: 700; margin-top: 0; display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-arrows-spin" style="color: #805AD5;"></i> ทำงานสลับอุปกรณ์ไร้รอยต่อ
                </h3>
                <p style="color: var(--color-grey); font-size: 0.95rem; line-height: 1.7;">
                    Mac ทำงานร่วมกับอุปกรณ์ Apple อื่นๆ ได้อย่างไร้รอยต่อ ไม่ว่าจะเป็นการเริ่มต้นไอเดียบน iPad แล้วมาปรับแต่งต่อบน Mac โดยใช้คีย์บอร์ด เมาส์ หรือแทร็คแพดชุดเดียวกัน เพื่อประสิทธิภาพที่ดีขึ้นอย่างเหลือเชื่อ
                </p>
            </div>
        </div>

        <div style="margin-top: 2rem; padding: 1.5rem; background: rgba(221, 107, 32, 0.05); border-radius: 16px; border-left: 4px solid #DD6B20; display: flex; flex-direction: column; gap: 10px;">
            <strong style="color: var(--color-navy-dark); font-size: 1.05rem;">💡 เพิ่มเติมเกี่ยวกับโซลูชัน Mac:</strong>
            <ul style="margin: 0; padding-left: 20px; color: var(--color-grey); font-size: 0.95rem; line-height: 1.8;">
                <li><strong>แชร์ผลงานได้อย่างรวดเร็ว:</strong> ใช้ AirDrop ในการแชร์งานมอบหมาย โน้ต และเอกสารไปยังอุปกรณ์ Apple อื่นๆ ภายในห้องได้ในพริบตาเพียงคลิกเดียว</li>
                <li><strong>ปกป้องความเป็นส่วนตัวตั้งแต่แรกเริ่ม:</strong> เมื่อ Apple Silicon และ macOS ทำงานร่วมกัน MacBook Air จึงมีคุณสมบัติด้านความเป็นส่วนตัวและความปลอดภัยที่เหนือชั้น</li>
                <li><strong>ทุกคนเข้าถึงได้:</strong> Mac ทุกเครื่องมาพร้อมกับคุณสมบัติการช่วยการเข้าถึงในตัวเพื่อการเรียนรู้ด้วยวิธีที่เหมาะสมกับทุกคน</li>
                <li><strong>การบริหารจัดการอุปกรณ์ที่เรียบง่าย:</strong> รองรับการตั้งค่าอุปกรณ์แบบไร้สาย ช่วยประหยัดทั้งเวลาและทรัพยากรของฝ่าย IT ในการเตรียมความพร้อม</li>
            </ul>
        </div>
    </div>

    <!-- Interactive Call-To-Action (CTA) Page Section -->
    <div style="background: linear-gradient(135deg, var(--color-navy-light) 0%, var(--color-navy-dark) 100%); border-radius: 24px; padding: 4rem 2rem; text-align: center; color: white; box-shadow: 0 20px 45px rgba(18, 28, 48, 0.2);">
        <h2 style="font-size: 2.2rem; font-weight: 700; margin-top: 0; margin-bottom: 1rem;">ต้องการเอกสาร หรือขอใบเสนอราคาระบบราชการ?</h2>
        <p style="color: #CBD5E1; max-width: 700px; margin: 0 auto 2.5rem auto; font-size: 1.05rem; line-height: 1.7;">
            เรายินดีให้บริการจัดทำใบเสนอราคาอย่างเป็นทางการสำหรับสถานศึกษา ครู อาจารย์ หรือกลุ่มนักเรียนนักศึกษาที่ต้องการจัดซื้ออุปกรณ์จำนวนมาก สามารถคำนวณและสร้างเอกสารใบเสนอราคาผ่านระบบออนไลน์ได้ทันที
        </p>
        
        <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('quotation.generate') }}" class="pulse-glow" style="background: var(--color-accent); color: white; text-decoration: none; padding: 16px 32px; border-radius: 12px; font-weight: 600; font-size: 1.1rem; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 10px;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 20px rgba(49, 130, 206, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                <i class="fa-solid fa-file-invoice-dollar"></i> สร้างใบเสนอราคาออนไลน์
            </a>
            
            <a href="https://line.me/ti/p/@ddphone" target="_blank" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); color: white; text-decoration: none; padding: 16px 32px; border-radius: 12px; font-weight: 600; font-size: 1.1rem; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 10px;" onmouseover="this.style.background='rgba(255,255,255,0.15)'; this.style.transform='translateY(-3px)';" onmouseout="this.style.background='rgba(255,255,255,0.08)'; this.style.transform='translateY(0)';">
                <i class="fa-brands fa-line" style="color: #06c755; font-size: 1.3rem;"></i> ปรึกษาฝ่ายการศึกษาทาง Line
            </a>
        </div>
    </div>

</div>
@endsection

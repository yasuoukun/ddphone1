@extends('layouts.store')

@section('content')
<div class="container" style="max-width: 1000px; margin: 0 auto; padding: 3rem 1rem;" x-data="{
    deviceType: 'iphone',
    model: 'iphone15pm',
    grade: 'A',
    models: {
        iphone: [
            { id: 'iphone15pm', name: 'iPhone 15 Pro Max', basePrice: 28000 },
            { id: 'iphone15p', name: 'iPhone 15 Pro', basePrice: 24000 },
            { id: 'iphone15', name: 'iPhone 15', basePrice: 18000 },
            { id: 'iphone14pm', name: 'iPhone 14 Pro Max', basePrice: 22000 },
            { id: 'iphone14p', name: 'iPhone 14 Pro', basePrice: 19000 },
            { id: 'iphone13pm', name: 'iPhone 13 Pro Max', basePrice: 16000 }
        ],
        ipad: [
            { id: 'ipadprom4', name: 'iPad Pro M4 (2024)', basePrice: 32000 },
            { id: 'ipadprom2', name: 'iPad Pro M2 (2022)', basePrice: 20000 },
            { id: 'ipadairm2', name: 'iPad Air M2 (2024)', basePrice: 17000 },
            { id: 'ipadair5', name: 'iPad Air 5 (2022)', basePrice: 13000 },
            { id: 'ipad10', name: 'iPad Gen 10', basePrice: 9000 }
        ],
        mac: [
            { id: 'macbookprom3', name: 'MacBook Pro M3', basePrice: 42000 },
            { id: 'macbookprom2', name: 'MacBook Pro M2', basePrice: 31000 },
            { id: 'macbookairm3', name: 'MacBook Air M3', basePrice: 29000 },
            { id: 'macbookairm2', name: 'MacBook Air M2', basePrice: 22000 },
            { id: 'macbookairm1', name: 'MacBook Air M1 (2020)', basePrice: 14000 }
        ]
    },
    get currentModels() {
        return this.models[this.deviceType] || [];
    },
    get selectedModel() {
        return this.currentModels.find(m => m.id === this.model) || this.currentModels[0];
    },
    get estimatedValue() {
        if (!this.selectedModel) return 0;
        let base = this.selectedModel.basePrice;
        let multiplier = 1.0;
        if (this.grade === 'B') multiplier = 0.85;
        else if (this.grade === 'C') multiplier = 0.70;
        else if (this.grade === 'D') multiplier = 0.50;
        
        return Math.round(base * multiplier);
    },
    changeDevice(type) {
        this.deviceType = type;
        this.model = this.models[type][0].id;
    }
}">
    <!-- Header Section -->
    <div style="text-align: center; margin-bottom: 3rem;">
        <span style="background: rgba(27, 42, 71, 0.08); color: var(--color-navy); font-size: 0.9rem; font-weight: 600; padding: 6px 16px; border-radius: 20px; text-transform: uppercase; letter-spacing: 1px;">Trade-in Program</span>
        <h1 style="font-size: 2.5rem; font-weight: 700; color: var(--color-navy-dark); margin: 10px 0 15px; font-family: 'Prompt', sans-serif;">เทรดอินรับซื้อและตีราคาเครื่องเก่า</h1>
        <p style="color: var(--color-grey); max-width: 600px; margin: 0 auto; font-size: 1.05rem; line-height: 1.6;">นำอุปกรณ์ Apple เครื่องเก่าของคุณมาเปลี่ยนเป็นส่วนลดในการซื้อเครื่องใหม่ ได้ราคาดี ตีราคาง่าย รวดเร็วและปลอดภัย</p>
    </div>

    <!-- Main Grid -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2.5rem; align-items: start; margin-bottom: 4rem;">
        
        <!-- Selection Box -->
        <div style="background: white; border: 1px solid var(--color-silver); border-radius: 16px; padding: 2.5rem; box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
            <h3 style="font-size: 1.4rem; font-weight: 700; color: var(--color-navy-dark); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                📱 ตรวจสอบสภาพและตีราคาเบื้องต้น
            </h3>
            
            <!-- Category Tabs -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--color-navy-dark);">เลือกประเภทอุปกรณ์</label>
                <div style="display: flex; gap: 10px;">
                    <button type="button" @click="changeDevice('iphone')" style="flex: 1; padding: 12px; border-radius: 8px; border: 1px solid var(--color-silver); background: var(--color-grey-bg); cursor: pointer; font-weight: 600; transition: all 0.2s;" :style="deviceType === 'iphone' ? 'border-color: var(--color-navy); background: var(--color-navy); color: white;' : ''">📱 iPhone</button>
                    <button type="button" @click="changeDevice('ipad')" style="flex: 1; padding: 12px; border-radius: 8px; border: 1px solid var(--color-silver); background: var(--color-grey-bg); cursor: pointer; font-weight: 600; transition: all 0.2s;" :style="deviceType === 'ipad' ? 'border-color: var(--color-navy); background: var(--color-navy); color: white;' : ''">平板 iPad</button>
                    <button type="button" @click="changeDevice('mac')" style="flex: 1; padding: 12px; border-radius: 8px; border: 1px solid var(--color-silver); background: var(--color-grey-bg); cursor: pointer; font-weight: 600; transition: all 0.2s;" :style="deviceType === 'mac' ? 'border-color: var(--color-navy); background: var(--color-navy); color: white;' : ''">💻 Mac</button>
                </div>
            </div>

            <!-- Model Selection -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--color-navy-dark);">เลือกโครงรุ่นสินค้า</label>
                <select x-model="model" style="width: 100%; padding: 12px; border: 1px solid var(--color-silver); border-radius: 8px; font-family: inherit; font-size: 0.95rem;">
                    <template x-for="m in currentModels" :key="m.id">
                        <option :value="m.id" x-text="m.name"></option>
                    </template>
                </select>
            </div>

            <!-- Condition Selection (Grade) -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--color-navy-dark);">สภาพการใช้งานของตัวเครื่อง (Grade)</label>
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <label style="border: 1px solid var(--color-silver); padding: 12px; border-radius: 8px; display: flex; align-items: center; gap: 10px; cursor: pointer; transition: all 0.2s;" :style="grade === 'A' ? 'border-color: var(--color-navy); background: rgba(27,42,71,0.02);' : ''">
                        <input type="radio" name="grade" value="A" x-model="grade">
                        <div>
                            <span style="font-weight: 600; color: var(--color-navy-dark);">เกรด A — สภาพนางฟ้า</span>
                            <span style="display: block; font-size: 0.85rem; color: var(--color-grey);">ตัวเครื่องไม่มีรอยขีดข่วน หน้าจอปกติ สุขภาพแบตเตอรี่เกิน 85% ทุกระบบทำงานสมบูรณ์</span>
                        </div>
                    </label>
                    <label style="border: 1px solid var(--color-silver); padding: 12px; border-radius: 8px; display: flex; align-items: center; gap: 10px; cursor: pointer; transition: all 0.2s;" :style="grade === 'B' ? 'border-color: var(--color-navy); background: rgba(27,42,71,0.02);' : ''">
                        <input type="radio" name="grade" value="B" x-model="grade">
                        <div>
                            <span style="font-weight: 600; color: var(--color-navy-dark);">เกรด B — สภาพดี</span>
                            <span style="display: block; font-size: 0.85rem; color: var(--color-grey);">มีรอยขนแมวหรือรอยขีดข่วนเล็กน้อยจากการใช้งานทั่วไป ไม่มีรอยบิ่นกระแทกร้ายแรง</span>
                        </div>
                    </label>
                    <label style="border: 1px solid var(--color-silver); padding: 12px; border-radius: 8px; display: flex; align-items: center; gap: 10px; cursor: pointer; transition: all 0.2s;" :style="grade === 'C' ? 'border-color: var(--color-navy); background: rgba(27,42,71,0.02);' : ''">
                        <input type="radio" name="grade" value="C" x-model="grade">
                        <div>
                            <span style="font-weight: 600; color: var(--color-navy-dark);">เกรด C — สภาพใช้งาน</span>
                            <span style="display: block; font-size: 0.85rem; color: var(--color-grey);">มีรอยบุบ รอยกระแทก หรือรอยขีดข่วนชัดเจน สุขภาพแบตเตอรี่เสื่อม แต่ปุ่มและกล้องยังใช้ได้</span>
                        </div>
                    </label>
                    <label style="border: 1px solid var(--color-silver); padding: 12px; border-radius: 8px; display: flex; align-items: center; gap: 10px; cursor: pointer; transition: all 0.2s;" :style="grade === 'D' ? 'border-color: var(--color-navy); background: rgba(27,42,71,0.02);' : ''">
                        <input type="radio" name="grade" value="D" x-model="grade">
                        <div>
                            <span style="font-weight: 600; color: var(--color-navy-dark);">เกรด D — มีตำหนิหนัก</span>
                            <span style="display: block; font-size: 0.85rem; color: var(--color-grey);">หน้าจอแตกร้าว, บอดี้งอ, กล้องเสีย หรือมีฟังก์ชันการใช้งานบางอย่างผิดปกติ</span>
                        </div>
                    </label>
                </div>
            </div>

        </div>

        <!-- Result Box -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            
            <div style="background: linear-gradient(135deg, var(--color-navy-dark) 0%, var(--color-navy) 100%); color: white; border-radius: 16px; padding: 2.5rem; box-shadow: 0 10px 30px rgba(27,42,71,0.15); text-align: center;">
                <span style="font-size: 0.9rem; text-transform: uppercase; color: var(--color-silver); font-weight: 600; letter-spacing: 1px;">ราคาประเมินเทรดอินสูงสุด</span>
                
                <div style="margin-top: 15px; margin-bottom: 25px;">
                    <span style="font-size: 3rem; font-weight: 700; color: #FFD700; line-height: 1;" x-text="'฿' + estimatedValue.toLocaleString()">฿0</span>
                </div>

                <p style="color: var(--color-silver); font-size: 0.85rem; line-height: 1.5; margin-bottom: 0;">*ราคาประเมินเบื้องต้นนี้อาจมีการเปลี่ยนแปลง ขึ้นอยู่กับการตรวจสอบสภาพความสมบูรณ์ของตัวเครื่องโดยละเอียดจากเจ้าหน้าที่หน้าร้าน</p>
            </div>

            <!-- Call to Action -->
            <a href="https://line.me/ti/p/@ddphone" target="_blank" style="background: #06c755; color: white; text-align: center; padding: 16px; border-radius: 12px; font-weight: 700; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 10px; box-shadow: 0 4px 15px rgba(6,199,85,0.25); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                <i class="fa-brands fa-line" style="font-size: 1.5rem;"></i> ทักแชทส่งรูปเพื่อยืนยันราคาประเมินทันที
            </a>

            <!-- Trade-in steps -->
            <div style="background: var(--color-grey-bg); border-radius: 12px; padding: 1.5rem; border: 1px solid var(--color-silver);">
                <h4 style="color: var(--color-navy-dark); font-weight: 700; margin: 0 0 10px;">📦 3 ขั้นตอนง่ายๆ ในการเทรดเครื่อง</h4>
                <ol style="color: var(--color-grey); font-size: 0.9rem; line-height: 1.6; margin: 0; padding-left: 20px;">
                    <li><strong>ประเมินราคา:</strong> เช็คราคาตามขั้นตอนด้านบน หรือส่งรูปมาตีราคาที่ LINE OA</li>
                    <li><strong>ส่งเครื่องตรวจ:</strong> นำเครื่องเข้าตรวจสภาพที่ร้าน หรือส่งพัสดุมาที่บริษัท</li>
                    <li><strong>รับเงิน/ส่วนลด:</strong> ตกลงราคาเสร็จสิ้น รับเงินโอนทันที หรือใช้เป็นส่วนลดซื้อเครื่องใหม่</li>
                </ol>
            </div>

        </div>

    </div>

</div>
@endsection

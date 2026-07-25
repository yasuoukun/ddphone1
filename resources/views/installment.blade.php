@extends('layouts.store')

@section('content')
<div class="container" style="max-width: 1000px; margin: 0 auto; padding: 3rem 1rem;" x-data="{
    price: 32900,
    bank: 'kbank_0',
    months: 10,
    customPrice: '',
    get monthlyPayment() {
        let p = parseFloat(this.price) || 0;
        let rate = 0;
        if (this.bank === 'scb_interest') {
            rate = 0.0099; // 0.99% per month
        } else if (this.bank === 'krungsri_interest') {
            rate = 0.0079; // 0.79% per month
        }
        
        if (rate > 0) {
            let totalInterest = p * rate * this.months;
            return ((p + totalInterest) / this.months).toFixed(2);
        } else {
            return (p / this.months).toFixed(2);
        }
    },
    get totalPaid() {
        return (parseFloat(this.monthlyPayment) * this.months).toFixed(2);
    },
    get totalInterest() {
        return (parseFloat(this.totalPaid) - (parseFloat(this.price) || 0)).toFixed(2);
    },
    updatePrice(val) {
        this.price = val;
        this.customPrice = '';
    },
    updateCustomPrice() {
        let val = parseFloat(this.customPrice);
        if (!isNaN(val) && val > 0) {
            this.price = val;
        }
    }
}">
    <!-- Premium Header -->
    <div style="text-align: center; margin-bottom: 3rem;">
        <span style="background: linear-gradient(135deg, #FF4500, #ff7b00); color: white; font-size: 0.85rem; font-weight: 700; padding: 6px 18px; border-radius: 20px; text-transform: uppercase; letter-spacing: 1px; box-shadow: 0 4px 15px rgba(255,69,0,0.25);">
            ⚡ EASY INSTALLMENT
        </span>
        <h1 style="font-size: 2.4rem; font-weight: 800; color: var(--color-navy-dark); margin: 12px 0 15px; font-family: 'Prompt', sans-serif;">บริการผ่อนชำระค่างวด ง่าย ปลอดภัย อนุมัติไว</h1>
        <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 12px; margin-top: 1rem;">
            <span style="background: rgba(6, 199, 85, 0.1); color: #059669; font-weight: 700; padding: 8px 16px; border-radius: 12px; border: 1px solid rgba(6, 199, 85, 0.3); font-size: 0.95rem;">
                🆔 ใช้เพียงบัตรประชาชนใบเดียว
            </span>
            <span style="background: rgba(59, 130, 246, 0.1); color: #2563eb; font-weight: 700; padding: 8px 16px; border-radius: 12px; border: 1px solid rgba(59, 130, 246, 0.3); font-size: 0.95rem;">
                ❌ ไม่เช็คเครดิตหรือสเตตเม้น
            </span>
            <span style="background: rgba(168, 85, 247, 0.1); color: #7c3aed; font-weight: 700; padding: 8px 16px; border-radius: 12px; border: 1px solid rgba(168, 85, 247, 0.3); font-size: 0.95rem;">
                🚫 ไม่เช็คเครดิตบูโร
            </span>
        </div>
    </div>

    <!-- Installment Table & Image Section -->
    <div style="background: white; border-radius: 24px; border: 1px solid var(--color-silver); padding: 2.5rem; margin-bottom: 3.5rem; box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
        <div style="text-align: center; margin-bottom: 2rem;">
            <h3 style="font-size: 1.6rem; font-weight: 800; color: var(--color-navy-dark); margin-bottom: 0.5rem; font-family: 'Prompt', sans-serif;">
                📋 ตารางผ่อนชำระสินค้า DDPHONE ดีดีโฟน
            </h3>
                <i class="fa-brands fa-line" style="font-size: 1.5rem;"></i> ทักแชท LINE เพื่อยื่นเรื่องผ่อน (อนุมัติใน 15 นาที)
            </a>

        </div>

    </div>

    <!-- Installment Rate Table Section -->
    <div style="background: white; border-radius: 20px; border: 1px solid var(--color-silver); padding: 2.5rem; margin-bottom: 3.5rem; shadow: 0 4px 20px rgba(0,0,0,0.03);">
        <h3 style="font-size: 1.4rem; font-weight: 800; color: var(--color-navy-dark); margin-bottom: 0.5rem; display: flex; align-items: center; gap: 10px;">
            📊 ตารางเปรียบเทียบอัตราค่างวดผ่อนชำระรายเดือน
        </h3>
        <p style="font-size: 0.9rem; color: var(--color-grey); margin-bottom: 2rem;">ตารางคำนวณยอดผ่อนรายเดือนโดยประมาณตามระดับราคาสินค้ายอดนิยม (ผ่อนแบบใช้บัตรประชาชนใบเดียว)</p>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: center; font-size: 0.95rem;">
                <thead>
                    <tr style="background: var(--color-navy-dark); color: white;">
                        <th style="padding: 14px; border-top-left-radius: 12px; text-align: left; padding-left: 20px;">ราคาสินค้า (บาท)</th>
                        <th style="padding: 14px;">ผ่อน 6 เดือน</th>
                        <th style="padding: 14px;">ผ่อน 10 เดือน</th>
                        <th style="padding: 14px;">ผ่อน 12 เดือน</th>
                        <th style="padding: 14px;">ผ่อน 18 เดือน</th>
                        <th style="padding: 14px; border-top-right-radius: 12px;">ผ่อน 24 เดือน</th>
                    </tr>
                </thead>
                <tbody style="border-bottom: 1px solid var(--color-silver);">
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 14px 20px; text-align: left; font-weight: 700; color: var(--color-navy-dark);">฿10,000</td>
                        <td style="padding: 14px; font-weight: 600; color: #2563eb;">฿1,667 /ด.</td>
                        <td style="padding: 14px; font-weight: 600; color: #2563eb;">฿1,000 /ด.</td>
                        <td style="padding: 14px; font-weight: 600; color: #059669;">฿834 /ด.</td>
                        <td style="padding: 14px; font-weight: 600; color: #059669;">฿556 /ด.</td>
                        <td style="padding: 14px; font-weight: 600; color: #7c3aed;">฿417 /ด.</td>
                    </tr>
                    <tr style="border-bottom: 1px solid #f1f5f9; background: #f8fafc;">
                        <td style="padding: 14px 20px; text-align: left; font-weight: 700; color: var(--color-navy-dark);">฿20,000</td>
                        <td style="padding: 14px; font-weight: 600; color: #2563eb;">฿3,334 /ด.</td>
                        <td style="padding: 14px; font-weight: 600; color: #2563eb;">฿2,000 /ด.</td>
                        <td style="padding: 14px; font-weight: 600; color: #059669;">฿1,667 /ด.</td>
                        <td style="padding: 14px; font-weight: 600; color: #059669;">฿1,112 /ด.</td>
                        <td style="padding: 14px; font-weight: 600; color: #7c3aed;">฿834 /ด.</td>
                    </tr>
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 14px 20px; text-align: left; font-weight: 700; color: var(--color-navy-dark);">฿30,000</td>
                        <td style="padding: 14px; font-weight: 600; color: #2563eb;">฿5,000 /ด.</td>
                        <td style="padding: 14px; font-weight: 600; color: #2563eb;">฿3,000 /ด.</td>
                        <td style="padding: 14px; font-weight: 600; color: #059669;">฿2,500 /ด.</td>
                        <td style="padding: 14px; font-weight: 600; color: #059669;">฿1,667 /ด.</td>
                        <td style="padding: 14px; font-weight: 600; color: #7c3aed;">฿1,250 /ด.</td>
                    </tr>
                    <tr style="border-bottom: 1px solid #f1f5f9; background: #f8fafc;">
                        <td style="padding: 14px 20px; text-align: left; font-weight: 700; color: var(--color-navy-dark);">฿40,000</td>
                        <td style="padding: 14px; font-weight: 600; color: #2563eb;">฿6,667 /ด.</td>
                        <td style="padding: 14px; font-weight: 600; color: #2563eb;">฿4,000 /ด.</td>
                        <td style="padding: 14px; font-weight: 600; color: #059669;">฿3,334 /ด.</td>
                        <td style="padding: 14px; font-weight: 600; color: #059669;">฿2,223 /ด.</td>
                        <td style="padding: 14px; font-weight: 600; color: #7c3aed;">฿1,667 /ด.</td>
                    </tr>
                    <tr style="background: #f8fafc;">
                        <td style="padding: 14px 20px; text-align: left; font-weight: 700; color: var(--color-navy-dark);">฿50,000</td>
                        <td style="padding: 14px; font-weight: 600; color: #2563eb;">฿8,334 /ด.</td>
                        <td style="padding: 14px; font-weight: 600; color: #2563eb;">฿5,000 /ด.</td>
                        <td style="padding: 14px; font-weight: 600; color: #059669;">฿4,167 /ด.</td>
                        <td style="padding: 14px; font-weight: 600; color: #059669;">฿2,778 /ด.</td>
                        <td style="padding: 14px; font-weight: 600; color: #7c3aed;">฿2,084 /ด.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Conditions and Info -->
    <div style="background: var(--color-grey-bg); border-radius: 20px; padding: 2.5rem;">
        <h3 style="font-size: 1.4rem; font-weight: 700; color: var(--color-navy-dark); margin-bottom: 2rem; border-bottom: 2px solid var(--color-silver); padding-bottom: 0.75rem;">🧾 เงื่อนไขการอนุมัติและเอกสารประกอบ</h3>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
            <div style="background: white; padding: 1.5rem; border-radius: 16px; border: 1px solid var(--color-silver);">
                <h4 style="color: var(--color-navy); font-weight: 700; font-size: 1.1rem; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                    🆔 ผ่อนชำระด้วยบัตรประชาชน (เงื่อนไขพิเศษ)
                </h4>
                <ul style="color: var(--color-grey); font-size: 0.95rem; line-height: 1.8; padding-left: 20px; display: flex; flex-direction: column; gap: 6px;">
                    <li><strong>บัตรประชาชนตัวจริงเท่านั้น</strong> (สัญชาติไทย อายุ 18 ปีขึ้นไป)</li>
                    <li><strong>ไม่เช็คเครดิต หรือสเตตเม้นย้อนหลัง</strong></li>
                    <li><strong>ไม่เช็คประวัติเครดิตบูโร (NCB)</strong></li>
                    <li>อนุมัติผลไวใน 15 นาที รับสินค้ากลับบ้านได้ทันที</li>
                </ul>
            </div>
            <div style="background: white; padding: 1.5rem; border-radius: 16px; border: 1px solid var(--color-silver);">
                <h4 style="color: var(--color-navy); font-weight: 700; font-size: 1.1rem; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                    💳 ผ่อนชำระผ่านบัตรเครดิตธนาคาร
                </h4>
                <ul style="color: var(--color-grey); font-size: 0.95rem; line-height: 1.8; padding-left: 20px; display: flex; flex-direction: column; gap: 6px;">
                    <li>รองรับบัตรเครดิต KBank, SCB, Krungsri, UOB, BBL, KTC</li>
                    <li>เลือกดอกเบี้ย 0% นานสูงสุด 10 เดือน</li>
                    <li>วงเงินคงเหลือในบัตรต้องครอบคลุมราคาสินค้าเต็มจำนวน</li>
                    <li>ทำรายการผ่านหน้าสั่งซื้อสินค้าได้ทันทีตลอด 24 ชั่วโมง</li>
                </ul>
            </div>
        </div>
    </div>

</div>
@endsection

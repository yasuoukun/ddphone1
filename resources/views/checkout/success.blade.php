@extends('layouts.store')

@section('content')
<div class="container" style="max-width: 600px; margin: 4rem auto; padding: 2rem 1.5rem; text-align: center; background: white; border: 1px solid var(--color-silver); border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
    
    <div style="width: 80px; height: 80px; background: rgba(16, 185, 129, 0.1); color: var(--color-success); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 3rem; margin: 0 auto 1.5rem; animation: pulse 2s infinite;">
        ✓
    </div>

    <h2 style="font-size: 2rem; color: var(--color-navy-dark); font-weight: 700; margin-bottom: 0.5rem;">สั่งซื้อสินค้าสำเร็จ!</h2>
    <p style="color: var(--color-grey); font-size: 1.05rem; margin-bottom: 2rem;">รหัสคำสั่งซื้อของคุณคือ <strong style="color: var(--color-navy);">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</strong></p>

    <!-- Payment details card -->
    <div style="background: var(--color-grey-bg); border-radius: 12px; padding: 1.5rem; border: 1px solid var(--color-silver); margin-bottom: 2rem; text-align: left;">
        <h3 style="font-size: 1.1rem; color: var(--color-navy-dark); font-weight: 700; margin-top: 0; margin-bottom: 1rem; border-bottom: 1px solid var(--color-silver); padding-bottom: 0.5rem;">ข้อมูลคำสั่งซื้อ</h3>
        <p style="margin: 0.5rem 0; font-size: 0.95rem;"><strong>ยอดชำระสุทธิ:</strong> <span style="color: var(--color-accent); font-weight: 700; font-size: 1.1rem;">฿{{ number_format($order->total_amount, 2) }}</span></p>
        <p style="margin: 0.5rem 0; font-size: 0.95rem;"><strong>ช่องทางชำระเงิน:</strong> {{ $order->payments->first()->payment_method == 'promptpay' ? 'Thai PromptPay (QR Code)' : 'Credit Card (Mocked)' }}</p>
        <p style="margin: 0.5rem 0; font-size: 0.95rem;"><strong>ที่อยู่จัดส่ง:</strong></p>
        <p style="margin: 0; font-size: 0.9rem; color: var(--color-grey-dark); line-height: 1.4;">{{ $order->shipping_info }}</p>
    </div>

    <!-- QR Code Mockup for PromptPay -->
    @if($order->payments->first() && $order->payments->first()->payment_method == 'promptpay')
    <div style="border: 2px dashed var(--color-silver); border-radius: 12px; padding: 2rem; background: white; margin-bottom: 2rem;">
        <div style="display: flex; align-items: center; justify-content: center; gap: 10px; margin-bottom: 1.5rem;">
            <div style="font-size: 1.5rem;">📱</div>
            <h4 style="margin: 0; font-size: 1.15rem; color: #003664; font-weight: 700; font-family: 'Prompt', sans-serif;">PROMPT PAY (พร้อมเพย์)</h4>
        </div>

        <!-- Render Styled Fake QR code -->
        <div style="background: white; border: 1px solid var(--color-silver); padding: 1rem; display: inline-block; box-shadow: 0 4px 10px rgba(0,0,0,0.05); margin-bottom: 1rem;">
            <div style="width: 200px; height: 200px; background: linear-gradient(45deg, #003664 25%, #fff 25%, #fff 50%, #003664 50%, #003664 75%, #fff 75%, #fff 100%); background-size: 20px 20px; border: 10px solid #003664; display: flex; align-items: center; justify-content: center; position: relative;">
                <div style="background: white; padding: 5px; border-radius: 4px; border: 2px solid #070D1B; font-weight: 800; font-size: 0.75rem; color: #070D1B;">DDPHONE ดีดีโฟน</div>
            </div>
        </div>

        <p style="margin: 0; font-size: 0.85rem; color: var(--color-grey);">สแกน QR Code นี้ด้วยแอปธนาคารใดก็ได้เพื่อชำระเงินจำลอง</p>
    </div>
    @endif

    <div style="display: flex; gap: 1rem; justify-content: center;">
        <a href="{{ route('dashboard') }}?tab=orders" style="display: inline-block; padding: 12px 25px; background: var(--color-navy); color: white; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 0.95rem; box-shadow: 0 4px 10px rgba(27,42,71,0.15);">ตรวจสอบคำสั่งซื้อของคุณ</a>
        <a href="{{ route('home') }}" style="display: inline-block; padding: 12px 25px; background: var(--color-grey-bg); color: var(--color-navy-dark); border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 0.95rem; border: 1px solid var(--color-silver);">กลับหน้าแรก</a>
    </div>

</div>

<style>
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
</style>
@endsection

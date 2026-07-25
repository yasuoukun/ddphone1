@extends('layouts.store')

@section('title', 'ผลการชำระเงิน - DD.IT.COM')

@section('content')
<div class="container fade-in" style="padding: 3rem 1rem; max-width: 600px; margin: 0 auto;">

    @if($status === 'success')
    {{-- SUCCESS --}}
    <div style="background: linear-gradient(135deg, #ecfdf5, #f0fdf4); border: 1.5px solid #86efac; border-radius: 24px; padding: 3rem 2.5rem; text-align: center; box-shadow: 0 8px 32px rgba(16, 185, 129, 0.1);">
        <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #10b981, #059669); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; box-shadow: 0 8px 20px rgba(16,185,129,0.35);">
            <i class="fa-solid fa-circle-check" style="color: white; font-size: 2.5rem;"></i>
        </div>
        <h1 style="font-size: 1.75rem; font-weight: 800; color: #065f46; margin-bottom: 0.75rem;">ชำระเงินสำเร็จ! 🎉</h1>
        <p style="color: #047857; font-size: 1rem; margin-bottom: 1.5rem;">ระบบได้รับการชำระเงินของคุณเรียบร้อยแล้ว<br>คำสั่งซื้อกำลังได้รับการดำเนินการ</p>
        @if($invoiceNo)
        <div style="background: white; border-radius: 12px; padding: 1rem 1.5rem; margin-bottom: 1.5rem; border: 1px solid #bbf7d0;">
            <p style="font-size: 0.8rem; color: #6b7280; margin-bottom: 0.25rem;">หมายเลขอ้างอิง (Invoice)</p>
            <p style="font-family: monospace; font-weight: 700; color: #065f46; font-size: 1rem;">{{ $invoiceNo }}</p>
        </div>
        @endif
        @if($order)
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; margin-top: 1rem;">
            <a href="{{ route('customer.dashboard', ['tab' => 'orders']) }}" 
               style="background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 0.85rem 2rem; border-radius: 12px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 12px rgba(16,185,129,0.3);">
                <i class="fa-solid fa-box"></i> ดูคำสั่งซื้อของฉัน
            </a>
            <a href="{{ route('products.index') }}" 
               style="background: white; color: #065f46; padding: 0.85rem 2rem; border-radius: 12px; font-weight: 700; text-decoration: none; border: 1.5px solid #86efac; display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="fa-solid fa-store"></i> ช้อปต่อ
            </a>
        </div>
        @else
        <a href="{{ route('customer.dashboard', ['tab' => 'orders']) }}" 
           style="background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 0.85rem 2rem; border-radius: 12px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 12px rgba(16,185,129,0.3);">
            <i class="fa-solid fa-box"></i> ดูคำสั่งซื้อของฉัน
        </a>
        @endif
    </div>

    @elseif($status === 'pending')
    {{-- PENDING --}}
    <div style="background: linear-gradient(135deg, #fffbeb, #fef9c3); border: 1.5px solid #fde68a; border-radius: 24px; padding: 3rem 2.5rem; text-align: center; box-shadow: 0 8px 32px rgba(245, 158, 11, 0.1);">
        <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #f59e0b, #d97706); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; box-shadow: 0 8px 20px rgba(245,158,11,0.35);">
            <i class="fa-solid fa-clock" style="color: white; font-size: 2.5rem;"></i>
        </div>
        <h1 style="font-size: 1.75rem; font-weight: 800; color: #78350f; margin-bottom: 0.75rem;">รอการยืนยัน ⏳</h1>
        <p style="color: #92400e; font-size: 1rem; margin-bottom: 1.5rem;">ระบบกำลังตรวจสอบการชำระเงินของคุณ<br>กรุณารอสักครู่ ระบบจะอัปเดตสถานะโดยอัตโนมัติ</p>
        @if($invoiceNo)
        <div style="background: white; border-radius: 12px; padding: 1rem 1.5rem; margin-bottom: 1.5rem; border: 1px solid #fde68a;">
            <p style="font-size: 0.8rem; color: #6b7280; margin-bottom: 0.25rem;">หมายเลขอ้างอิง (Invoice)</p>
            <p style="font-family: monospace; font-weight: 700; color: #78350f; font-size: 1rem;">{{ $invoiceNo }}</p>
        </div>
        @endif
        <a href="{{ route('customer.dashboard', ['tab' => 'orders']) }}" 
           style="background: linear-gradient(135deg, #f59e0b, #d97706); color: white; padding: 0.85rem 2rem; border-radius: 12px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 12px rgba(245,158,11,0.3);">
            <i class="fa-solid fa-box"></i> ตรวจสอบสถานะคำสั่งซื้อ
        </a>
    </div>

    @else
    {{-- FAILED / CANCELLED / UNKNOWN --}}
    <div style="background: linear-gradient(135deg, #fff1f2, #fff5f5); border: 1.5px solid #fca5a5; border-radius: 24px; padding: 3rem 2.5rem; text-align: center; box-shadow: 0 8px 32px rgba(239, 68, 68, 0.1);">
        <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #ef4444, #dc2626); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; box-shadow: 0 8px 20px rgba(239,68,68,0.35);">
            <i class="fa-solid fa-circle-xmark" style="color: white; font-size: 2.5rem;"></i>
        </div>
        <h1 style="font-size: 1.75rem; font-weight: 800; color: #7f1d1d; margin-bottom: 0.75rem;">การชำระเงินไม่สำเร็จ</h1>
        <p style="color: #991b1b; font-size: 1rem; margin-bottom: 1rem;">
            {{ $respDesc ?: 'เกิดข้อผิดพลาดในการชำระเงิน กรุณาลองใหม่อีกครั้ง' }}
        </p>
        @if($respCode)
        <p style="font-size: 0.8rem; color: #9ca3af; margin-bottom: 1.5rem;">รหัสข้อผิดพลาด: <code style="font-family: monospace;">{{ $respCode }}</code></p>
        @endif
        @if($order)
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('checkout.pay', $order->id) }}" 
               style="background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; padding: 0.85rem 2rem; border-radius: 12px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 12px rgba(59,130,246,0.3);">
                <i class="fa-solid fa-rotate-right"></i> ลองชำระเงินอีกครั้ง
            </a>
            <a href="{{ route('customer.dashboard', ['tab' => 'orders']) }}" 
               style="background: white; color: #7f1d1d; padding: 0.85rem 2rem; border-radius: 12px; font-weight: 700; text-decoration: none; border: 1.5px solid #fca5a5; display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="fa-solid fa-box"></i> ดูคำสั่งซื้อ
            </a>
        </div>
        @else
        <a href="{{ route('products.index') }}" 
           style="background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; padding: 0.85rem 2rem; border-radius: 12px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
            <i class="fa-solid fa-store"></i> กลับหน้าร้านค้า
        </a>
        @endif
    </div>
    @endif

</div>
@endsection

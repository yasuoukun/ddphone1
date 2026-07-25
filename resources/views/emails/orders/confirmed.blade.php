<x-mail::message>
# ยืนยันคำสั่งซื้อของคุณ

ขอบคุณที่สั่งซื้อสินค้ากับ DDPHONE ดีดีโฟน

**รหัสคำสั่งซื้อ:** #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}<br>
**สถานะ:** ยืนยันการชำระเงินเรียบร้อยแล้ว<br>
**ยอดรวม:** ฿{{ number_format($order->total_amount, 2) }}

เรากำลังเตรียมการจัดส่งสินค้าของคุณไปยังที่อยู่:
{{ $order->shipping_info }}

<x-mail::button :url="url('/dashboard')">
ตรวจสอบสถานะคำสั่งซื้อ
</x-mail::button>

ขอบคุณ,<br>
{{ config('app.name') }}
</x-mail::message>

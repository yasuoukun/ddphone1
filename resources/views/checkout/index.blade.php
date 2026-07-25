@extends('layouts.store')

@section('content')
<div class="container fade-in" style="max-width: 1200px; margin: 0 auto; padding: 2.5rem 1rem;" x-data="{ 
    selectedAddress: '{{ $mainAddress ? $mainAddress->address_line . ", " . $mainAddress->subdistrict . ", " . $mainAddress->district . ", " . $mainAddress->province . " " . $mainAddress->postal_code . " (โทร: " . $mainAddress->phone . ")" : "" }}',
    paymentMethod: 'promptpay',
    setAddress(addrText) {
        this.selectedAddress = addrText;
    }
}">
    
    <!-- Step Header Bar -->
    <div style="display: flex; align-items: center; justify-content: center; gap: 1rem; margin-bottom: 2.5rem; flex-wrap: wrap;">
        <div style="display: flex; align-items: center; gap: 10px; background: #0F172A; color: white; padding: 10px 20px; border-radius: 99px; font-weight: 700; font-size: 0.9rem; box-shadow: 0 4px 12px rgba(15, 23, 42, 0.15);">
            <span style="background: #FFB800; color: #0F172A; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: 900;">1</span>
            <span>ที่อยู่จัดส่งสินค้า</span>
        </div>
        <i class="fa-solid fa-chevron-right text-slate-300"></i>
        <div style="display: flex; align-items: center; gap: 10px; background: white; color: #64748B; padding: 10px 20px; border-radius: 99px; font-weight: 600; font-size: 0.9rem; border: 1px solid #E2E8F0;">
            <span style="background: #E2E8F0; color: #64748B; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">2</span>
            <span>สรุปรายการออเดอร์</span>
        </div>
        <i class="fa-solid fa-chevron-right text-slate-300"></i>
        <div style="display: flex; align-items: center; gap: 10px; background: white; color: #64748B; padding: 10px 20px; border-radius: 99px; font-weight: 600; font-size: 0.9rem; border: 1px solid #E2E8F0;">
            <span style="background: #E2E8F0; color: #64748B; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">3</span>
            <span>ชำระเงิน</span>
        </div>
    </div>

    <h2 style="font-size: 1.85rem; color: var(--color-navy-dark); margin-bottom: 2rem; font-weight: 900; letter-spacing: -0.02em; display: flex; align-items: center; gap: 10px;">
        <i class="fa-solid fa-cart-shopping" style="color: #FFB800;"></i> ยืนยันการสั่งซื้อสินค้า (Checkout)
    </h2>

    <form action="{{ route('checkout.process') }}" method="POST" style="display: flex; gap: 2rem; flex-wrap: wrap;">
        @csrf
        
        <!-- Left Column: Shipping & Payment -->
        <div style="flex: 2 1 600px; display: flex; flex-direction: column; gap: 1.5rem;">
            
            <!-- Address Selection Card -->
            <div style="background: white; border: 1.5px solid #E2E8F0; border-radius: 20px; padding: 2rem; box-shadow: 0 4px 20px rgba(10, 25, 47, 0.03);">
                <h3 style="font-size: 1.2rem; font-weight: 800; color: var(--color-navy-dark); margin-bottom: 1.25rem; border-bottom: 2px solid #F1F5F9; padding-bottom: 0.75rem; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-location-dot" style="color: #F59E0B;"></i> 1. เลือกที่อยู่สำหรับจัดส่งสินค้า
                </h3>
                
                @if($addresses->count() > 0)
                <div style="display: flex; flex-direction: column; gap: 0.75rem; margin-bottom: 1.5rem;">
                    <p style="font-weight: 700; color: var(--color-navy-dark); font-size: 0.9rem; margin: 0;">ที่อยู่ที่บันทึกไว้ในบัญชีของคุณ:</p>
                    @foreach($addresses as $addr)
                    <div @click="setAddress('{{ $addr->address_line }}, {{ $addr->subdistrict }}, {{ $addr->district }}, {{ $addr->province }} {{ $addr->postal_code }} (โทร: {{ $addr->phone }})')" 
                         style="border: 1.5px solid #E2E8F0; padding: 1.15rem; border-radius: 14px; cursor: pointer; background: #F8FAFC; transition: all 0.2s;"
                         :style="selectedAddress.includes('{{ $addr->address_line }}') ? 'border-color: #FFB800; background: #FFFBEB; box-shadow: 0 0 0 2px #FFB800;' : ''"
                         onmouseover="this.style.borderColor='#FFB800'"
                         onmouseout="this.style.borderColor=this.style.borderColor==='rgb(255, 184, 0)'?'#FFB800':'#E2E8F0'">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.25rem;">
                            <span style="font-weight: 800; color: var(--color-navy-dark); font-size: 0.95rem;">
                                {{ $addr->address_line }}
                            </span>
                            @if($addr->is_main)
                            <span style="background: #0F172A; color: #FFB800; font-size: 0.7rem; padding: 2px 8px; border-radius: 8px; font-weight: 800;">ที่อยู่หลัก</span>
                            @endif
                        </div>
                        <p style="margin: 0; font-size: 0.88rem; color: #64748B;">{{ $addr->subdistrict }}, {{ $addr->district }}, {{ $addr->province }}, {{ $addr->postal_code }} (โทร: {{ $addr->phone }})</p>
                    </div>
                    @endforeach
                </div>
                @else
                <div style="background: #FEF3C7; color: #92400E; padding: 1rem 1.25rem; border-radius: 12px; margin-bottom: 1.5rem; border: 1px solid #FDE68A; font-size: 0.88rem; line-height: 1.5;">
                    💡 คุณยังไม่มีที่อยู่จัดส่งที่บันทึกไว้ พิมพ์ระบุที่อยู่ใหม่ในช่องด้านล่างได้ทันที (ระบบจะบันทึกให้อัตโนมัติ)
                </div>
                @endif

                <div>
                    <label style="display: block; font-weight: 700; margin-bottom: 0.5rem; color: var(--color-navy-dark); font-size: 0.9rem;">ระบุรายละเอียดที่อยู่จัดส่ง</label>
                    <textarea name="shipping_info" x-model="selectedAddress" rows="3" required placeholder="กรอกที่อยู่จัดส่ง เช่น บ้านเลขที่ ถนน แขวง/ตำบล เขต/อำเภอ จังหวัด รหัสไปรษณีย์ และเบอร์โทรศัพท์..." style="width: 100%; padding: 12px 14px; border: 1.5px solid #CBD5E1; border-radius: 12px; outline: none; transition: border-color 0.2s; font-family: inherit; font-size: 0.9rem;" onfocus="this.style.borderColor='#FFB800'" onblur="this.style.borderColor='#CBD5E1'"></textarea>
                </div>
            </div>

            <!-- Payment Selection Card -->
            <div style="background: white; border: 1.5px solid #E2E8F0; border-radius: 20px; padding: 2rem; box-shadow: 0 4px 20px rgba(10, 25, 47, 0.03);">
                <h3 style="font-size: 1.2rem; font-weight: 800; color: var(--color-navy-dark); margin-bottom: 1.25rem; border-bottom: 2px solid #F1F5F9; padding-bottom: 0.75rem; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-credit-card" style="color: #F59E0B;"></i> 2. เลือกช่องทางชำระเงิน
                </h3>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1rem;">
                    <label style="border: 1.5px solid #E2E8F0; padding: 1.25rem; border-radius: 14px; display: flex; align-items: center; gap: 14px; cursor: pointer; transition: all 0.2s; background: #F8FAFC;" :style="paymentMethod === 'promptpay' ? 'border-color: #FFB800; background: #FFFBEB; box-shadow: 0 0 0 2px #FFB800;' : ''">
                        <input type="radio" name="payment_method" value="promptpay" x-model="paymentMethod" style="accent-color: #0F172A;">
                        <div>
                            <span style="font-size: 1.6rem;">📱</span>
                            <span style="font-weight: 800; color: var(--color-navy-dark); display: block; margin-top: 2px; font-size: 0.95rem;">PromptPay QR / SCB</span>
                            <span style="font-size: 0.75rem; color: #64748B;">สแกนผ่าน Mobile Banking</span>
                        </div>
                    </label>

                    <label style="border: 1.5px solid #E2E8F0; padding: 1.25rem; border-radius: 14px; display: flex; align-items: center; gap: 14px; cursor: pointer; transition: all 0.2s; background: #F8FAFC;" :style="paymentMethod === 'credit_card' ? 'border-color: #FFB800; background: #FFFBEB; box-shadow: 0 0 0 2px #FFB800;' : ''">
                        <input type="radio" name="payment_method" value="credit_card" x-model="paymentMethod" style="accent-color: #0F172A;">
                        <div>
                            <span style="font-size: 1.6rem;">💳</span>
                            <span style="font-weight: 800; color: var(--color-navy-dark); display: block; margin-top: 2px; font-size: 0.95rem;">บัตรเครดิต/เดบิต</span>
                            <span style="font-size: 0.75rem; color: #64748B;">SCB 2C2P / Visa / Mastercard</span>
                        </div>
                    </label>
                </div>
            </div>

        </div>

        <!-- Right Column: Cart Summary & Button -->
        <div style="flex: 1 1 360px;">
            <div style="background: white; border: 1.5px solid #E2E8F0; border-radius: 24px; padding: 2rem; box-shadow: 0 10px 30px rgba(10, 25, 47, 0.08); position: sticky; top: 100px;">
                <h3 style="font-size: 1.25rem; font-weight: 900; color: var(--color-navy-dark); margin-bottom: 1.25rem; border-bottom: 2px solid #F1F5F9; padding-bottom: 0.75rem; display: flex; align-items: center; justify-content: space-between;">
                    <span>📦 รายการสินค้า</span>
                    <span style="font-size: 0.8rem; background: #FEF3C7; color: #B45309; padding: 2px 8px; border-radius: 6px; font-weight: 700;">{{ count($cart) }} รายการ</span>
                </h3>
                
                <!-- Hidden inputs for items being processed -->
                @foreach($cart as $id => $item)
                    <input type="hidden" name="items[]" value="{{ $id }}">
                @endforeach

                <div style="display: flex; flex-direction: column; gap: 0.85rem; margin-bottom: 1.5rem; max-height: 220px; overflow-y: auto; padding-right: 4px;">
                    @php $total = 0; @endphp
                    @foreach($cart as $item)
                    @php $total += $item['price'] * $item['quantity']; @endphp
                    <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.9rem;">
                        <span style="color: var(--color-navy-dark); font-weight: 600; min-width: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px;">{{ $item['name'] }} <small style="color: #94A3B8;">x{{ $item['quantity'] }}</small></span>
                        <span style="font-weight: 800; color: var(--color-navy-dark); flex-shrink: 0;">฿{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                    </div>
                    @endforeach
                </div>

                <!-- Coupon Selector Section -->
                <div style="margin: 1.25rem 0; padding-top: 1.25rem; border-top: 1px solid #F1F5F9;">
                    <label style="display: block; font-weight: 800; margin-bottom: 0.75rem; color: var(--color-navy-dark); font-size: 0.9rem;">🎟️ ใช้คูปองส่วนลดที่คุณเก็บไว้</label>
                    
                    @if($collectedCoupons->count() > 0)
                        <div style="display: flex; flex-direction: column; gap: 8px; max-height: 160px; overflow-y: auto; margin-bottom: 1rem; padding-right: 4px;">
                            @foreach($collectedCoupons as $cc)
                                @php
                                    $c = $cc->coupon;
                                    $isApplied = session('coupon') && session('coupon')->id === $c->id;
                                @endphp
                                <div style="border: 1.5px solid {{ $isApplied ? '#F59E0B' : '#E2E8F0' }}; padding: 10px 12px; border-radius: 10px; background: {{ $isApplied ? '#FFFBEB' : '#F8FAFC' }}; display: flex; justify-content: space-between; align-items: center;">
                                    <div style="flex-grow: 1;">
                                        <p style="margin: 0; font-size: 0.85rem; font-weight: 800; color: var(--color-navy-dark);">
                                            {{ $c->name }}
                                        </p>
                                        <div style="display: flex; gap: 6px; margin-top: 2px; align-items: center;">
                                            <span style="background: #F59E0B; color: white; font-size: 0.7rem; padding: 1px 6px; border-radius: 4px; font-weight: bold;">
                                                ลด ฿{{ number_format($c->discount_amount, 0) }}
                                            </span>
                                            <code style="font-size: 0.75rem; color: #64748B;">{{ $c->code }}</code>
                                        </div>
                                    </div>
                                    <div>
                                        @if($isApplied)
                                            <span style="color: #D97706; font-size: 0.8rem; font-weight: 800;">✔️ ใช้แล้ว</span>
                                        @else
                                            <button type="button" onclick="submitApplyCoupon('{{ $c->code }}')" style="background: #0F172A; color: #FFB800; border: none; padding: 6px 12px; border-radius: 8px; font-size: 0.75rem; font-weight: 800; cursor: pointer;">
                                                ใช้คูปอง
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div style="display: flex; gap: 8px;">
                        <input type="text" id="coupon_code_input" placeholder="พิมพ์รหัสส่วนลด..." value="{{ session('coupon') ? session('coupon')->code : '' }}" style="flex: 1; padding: 10px 12px; border: 1.5px solid #CBD5E1; border-radius: 10px; font-family: inherit; font-size: 0.85rem; outline: none;">
                        <button type="button" onclick="applyCouponCode()" style="background: #0F172A; color: #FFB800; border: none; padding: 10px 16px; border-radius: 10px; font-weight: 800; cursor: pointer; font-family: inherit; font-size: 0.85rem;">ใช้งาน</button>
                    </div>
                </div>

                <hr style="border: 0; border-top: 1px solid #F1F5F9; margin-bottom: 1.25rem;">

                @php 
                    $discount = session()->has('coupon') ? session('coupon')->discount_amount : 0;
                    $netTotal = max(0, $total - $discount);
                @endphp

                <div style="display: flex; flex-direction: column; gap: 8px; margin-bottom: 1.75rem;">
                    <div style="display: flex; justify-content: space-between; font-size: 0.95rem;">
                        <span style="color: #64748B;">รวมค่าสินค้า</span>
                        <span style="font-weight: 700; color: var(--color-navy-dark);">฿{{ number_format($total, 2) }}</span>
                    </div>
                    @if($discount > 0)
                    <div style="display: flex; justify-content: space-between; font-size: 0.95rem; color: #EF4444;">
                        <span>ส่วนลดคูปอง</span>
                        <span style="font-weight: 700;">-฿{{ number_format($discount, 2) }}</span>
                    </div>
                    @endif
                    <div style="display: flex; justify-content: space-between; font-size: 1.3rem; font-weight: 900; border-top: 2px solid #F1F5F9; padding-top: 12px; margin-top: 4px;">
                        <span style="color: var(--color-navy-dark);">ยอดที่ต้องชำระ</span>
                        <span style="color: #D97706;">฿{{ number_format($netTotal, 2) }}</span>
                    </div>
                </div>

                <button type="submit" style="width: 100%; text-align: center; padding: 16px; background: linear-gradient(135deg, #0F172A, #1E293B); color: #FFB800; border: none; border-radius: 14px; font-weight: 900; font-size: 1.1rem; cursor: pointer; box-shadow: 0 8px 25px rgba(15,23,42,0.3); transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 8px;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                    <i class="fa-solid fa-lock"></i> ดำเนินการสั่งซื้อและชำระเงิน
                </button>
            </div>
        </div>

    </form>
</div>

<!-- Hidden coupon submission form -->
<form id="coupon-form" action="{{ route('coupons.apply') }}" method="POST" style="display:none;">
    @csrf
    <input type="hidden" name="coupon_code" id="hidden_coupon_code">
</form>

<script>
    function submitApplyCoupon(code) {
        document.getElementById('hidden_coupon_code').value = code;
        document.getElementById('coupon-form').submit();
    }

    function applyCouponCode() {
        const val = document.getElementById('coupon_code_input').value.trim();
        if (!val) {
            Swal.fire({
                icon: 'warning',
                title: 'กรุณากรอกรหัสคูปอง',
                confirmButtonColor: '#0F172A'
            });
            return;
        }
        submitApplyCoupon(val);
    }
</script>
@endsection

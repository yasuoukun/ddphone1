@extends('layouts.store')

@section('content')
<style>
/* Absolute 100% Guaranteed Capsule Pill Buttons (Zero rectangular edges) */
.addr-mode-btn {
    border-radius: 9999px !important;
    -webkit-border-radius: 9999px !important;
    -moz-border-radius: 9999px !important;
    padding: 10px 22px !important;
    font-weight: 900 !important;
    font-size: 0.88rem !important;
    cursor: pointer !important;
    transition: all 0.2s ease !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 8px !important;
    font-family: inherit !important;
    white-space: nowrap !important;
    outline: none !important;
    box-sizing: border-box !important;
}

.addr-mode-btn.is-active {
    background: linear-gradient(135deg, #0284C7 0%, #0369A1 100%) !important;
    color: #FFFFFF !important;
    border: 2px solid #0284C7 !important;
    box-shadow: 0 4px 15px rgba(2, 132, 199, 0.35) !important;
    transform: translateY(-1px) !important;
}

.addr-mode-btn.is-inactive {
    background: #FFFFFF !important;
    color: #0E7490 !important;
    border: 2px solid #BAE6FD !important;
    box-shadow: none !important;
    transform: none !important;
}
.addr-mode-btn.is-inactive:hover {
    background: #F0F9FF !important;
    border-color: #0284C7 !important;
}

/* Unified High-End Capsule Select Pill Button */
.select-addr-pill {
    appearance: none !important;
    -webkit-appearance: none !important;
    -moz-appearance: none !important;
    border-radius: 9999px !important;
    -webkit-border-radius: 9999px !important;
    -moz-border-radius: 9999px !important;
    padding: 10px 40px 10px 20px !important;
    font-weight: 900 !important;
    font-size: 0.88rem !important;
    font-family: inherit !important;
    cursor: pointer !important;
    outline: none !important;
    transition: all 0.22s ease !important;
    max-width: 100% !important;
    white-space: nowrap !important;
    text-overflow: ellipsis !important;
    overflow: hidden !important;
}
.select-addr-pill.is-active {
    background: linear-gradient(135deg, #0284C7 0%, #0369A1 100%) !important;
    color: #FFFFFF !important;
    border: 2px solid #0284C7 !important;
    box-shadow: 0 4px 15px rgba(2, 132, 199, 0.35) !important;
}
.select-addr-pill.is-inactive {
    background: #FFFFFF !important;
    color: #0E7490 !important;
    border: 2px solid #BAE6FD !important;
    box-shadow: none !important;
}
.select-addr-pill option {
    background: #FFFFFF !important;
    color: #0F172A !important;
    font-weight: 700 !important;
    padding: 10px !important;
}
</style>

<div class="container fade-in checkout-container" style="max-width: 1200px; margin: 0 auto; padding: 2.5rem 1rem;" x-data="{ 
    addressMode: '{{ $addresses->count() > 0 ? "saved" : "new" }}',
    selectedAddrId: {{ $mainAddress ? $mainAddress->id : 'null' }},
    addrLine: '{{ $mainAddress ? addslashes($mainAddress->address_line) : "" }}',
    subdistrict: '{{ $mainAddress ? addslashes($mainAddress->subdistrict) : "" }}',
    district: '{{ $mainAddress ? addslashes($mainAddress->district) : "" }}',
    province: '{{ $mainAddress ? addslashes($mainAddress->province) : "" }}',
    postalCode: '{{ $mainAddress ? addslashes($mainAddress->postal_code) : "" }}',
    phone: '{{ $mainAddress ? addslashes($mainAddress->phone) : "" }}',
    paymentMethod: 'promptpay',
    couponSearchQuery: '',
    fillAddress(line, sub, dist, prov, zip, ph, id = null) {
        this.addrLine = line;
        this.subdistrict = sub;
        this.district = dist;
        this.province = prov;
        this.postalCode = zip;
        this.phone = ph;
        this.selectedAddrId = id;
        this.addressMode = 'saved';
    },
    clearAddressForNew() {
        this.addrLine = '';
        this.subdistrict = '';
        this.district = '';
        this.province = '';
        this.postalCode = '';
        this.phone = '';
        this.selectedAddrId = null;
        this.addressMode = 'new';
    },
    get formattedAddress() {
        if (!this.addrLine) return '';
        let parts = [this.addrLine];
        if (this.subdistrict) parts.push(this.subdistrict.startsWith('ต.') || this.subdistrict.startsWith('แขวง') ? this.subdistrict : 'ต.' + this.subdistrict);
        if (this.district) parts.push(this.district.startsWith('อ.') || this.district.startsWith('เขต') ? this.district : 'อ.' + this.district);
        if (this.province) parts.push(this.province.startsWith('จ.') ? this.province : 'จ.' + this.province);
        if (this.postalCode) parts.push(this.postalCode);
        if (this.phone) parts.push('(โทร: ' + this.phone + ')');
        return parts.join(' ');
    }
}">
    
    <!-- Step Header Bar -->
    <div class="checkout-step-bar" style="display: flex; align-items: center; justify-content: center; gap: 1rem; margin-bottom: 3rem; flex-wrap: wrap;">
        <div style="display: flex; align-items: center; gap: 10px; background: linear-gradient(135deg, #0284C7 0%, #0369A1 100%); color: white; padding: 12px 24px; border-radius: 99px; font-weight: 900; font-size: 0.92rem; box-shadow: 0 4px 15px rgba(2, 132, 199, 0.3);">
            <span style="background: white; color: #0284C7; width: 26px; height: 26px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; font-weight: 900;">1</span>
            <span>ที่อยู่จัดส่งสินค้า</span>
        </div>
        <i class="fa-solid fa-chevron-right text-slate-300"></i>
        <div style="display: flex; align-items: center; gap: 10px; background: white; color: #64748B; padding: 12px 24px; border-radius: 99px; font-weight: 800; font-size: 0.92rem; border: 1.5px solid #BAE6FD;">
            <span style="background: #E2E8F0; color: #64748B; width: 26px; height: 26px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; font-weight: 900;">2</span>
            <span>สรุปรายการออเดอร์</span>
        </div>
        <i class="fa-solid fa-chevron-right text-slate-300"></i>
        <div style="display: flex; align-items: center; gap: 10px; background: white; color: #64748B; padding: 12px 24px; border-radius: 99px; font-weight: 800; font-size: 0.92rem; border: 1.5px solid #BAE6FD;">
            <span style="background: #E2E8F0; color: #64748B; width: 26px; height: 26px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; font-weight: 900;">3</span>
            <span>ชำระเงิน</span>
        </div>
    </div>

    <h2 class="checkout-title" style="font-size: 2rem; color: #0F172A; margin-bottom: 2rem; font-weight: 900; letter-spacing: -0.02em; display: flex; align-items: center; gap: 12px;">
        <i class="fa-solid fa-cart-shopping" style="color: #0284C7;"></i> ยืนยันการสั่งซื้อสินค้า (Checkout)
    </h2>

    <form action="{{ route('checkout.process') }}" method="POST" style="display: flex; gap: 2.2rem; flex-wrap: wrap;">
        @csrf
        <input type="hidden" name="shipping_info" :value="formattedAddress">
        
        <!-- Left Column: Shipping & Payment -->
        <div style="flex: 2 1 600px; display: flex; flex-direction: column; gap: 1.75rem;">
            
            <!-- Address Selection & Form Card -->
            <div class="checkout-card-box" style="background: white; border: 1.5px solid #BAE6FD; border-radius: 32px; padding: 2.25rem; box-shadow: 0 10px 40px rgba(8, 145, 178, 0.06);">
                <h3 style="font-size: 1.25rem; font-weight: 900; color: #0E7490; margin-bottom: 1.5rem; border-bottom: 2px solid #F0F9FF; padding-bottom: 0.85rem; display: flex; align-items: center; gap: 10px;">
                    📍 1. ข้อมูลและที่อยู่สำหรับจัดส่งสินค้า
                </h3>

                <!-- Address Options Toolbar (Custom Alpine Floating Dropdown Menu + New Address Button) -->
                <div style="display: flex; gap: 12px; margin-bottom: 1.75rem; flex-wrap: wrap; align-items: center;">
                    @if($addresses->count() > 0)
                    <!-- Button 1: Custom Alpine Dropdown Card Button (Matches Topbar Profile Dropdown Style) -->
                    <div style="position: relative; display: inline-block; z-index: 1000;" x-data="{ openAddrMenu: false }">
                        <button type="button" 
                                @click="openAddrMenu = !openAddrMenu; addressMode = 'saved'" 
                                @click.away="openAddrMenu = false" 
                                class="addr-mode-btn"
                                :class="addressMode === 'saved' ? 'is-active' : 'is-inactive'">
                            <span>📌 เลือกที่อยู่จัดส่งที่บันทึกไว้</span>
                            <span style="font-size: 0.75rem; margin-left: 4px;">▼</span>
                        </button>

                        <!-- Custom Floating Glass Card Dropdown Menu (Matches Screenshot 2 Layout) -->
                        <div x-show="openAddrMenu" 
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 transform scale-95 -translate-y-2"
                             x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
                             style="display: none; position: absolute; left: 0; top: 100%; margin-top: 10px; background: white; border: 1.5px solid #BAE6FD; border-radius: 22px; box-shadow: 0 12px 35px rgba(2, 132, 199, 0.18); z-index: 9999; min-width: 320px; max-width: 450px; padding: 0.6rem 0; overflow: hidden;">
                            
                            <div style="padding: 8px 16px; font-size: 0.78rem; font-weight: 900; color: #0E7490; background: #F0F9FF; border-bottom: 1px solid #E0F2FE; letter-spacing: 0.02em;">
                                📍 คลิกเลือกที่อยู่จัดส่งจากบัญชีของคุณ:
                            </div>

                            <div style="max-height: 280px; overflow-y: auto;">
                                @foreach($addresses as $addr)
                                <div @click="fillAddress('{{ addslashes($addr->address_line) }}', '{{ addslashes($addr->subdistrict) }}', '{{ addslashes($addr->district) }}', '{{ addslashes($addr->province) }}', '{{ addslashes($addr->postal_code) }}', '{{ addslashes($addr->phone) }}', {{ $addr->id }}); openAddrMenu = false"
                                     style="padding: 12px 18px; cursor: pointer; transition: all 0.18s; border-bottom: 1px solid #F1F5F9; display: flex; align-items: flex-start; gap: 10px;"
                                     onmouseover="this.style.background='#F0F9FF'" 
                                     onmouseout="this.style.background='white'">
                                    <span style="font-size: 1.1rem; margin-top: 2px;">{{ $addr->is_main ? '📌' : '📍' }}</span>
                                    <div style="flex-grow: 1;">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2px;">
                                            <span style="font-weight: 900; color: #0F172A; font-size: 0.92rem;">
                                                {{ $addr->address_line }}
                                            </span>
                                            @if($addr->is_main)
                                            <span style="background: #0284C7; color: white; font-size: 0.68rem; padding: 1px 8px; border-radius: 99px; font-weight: 900;">ที่อยู่หลัก</span>
                                            @endif
                                        </div>
                                        <p style="margin: 0; font-size: 0.82rem; color: #64748B; font-weight: 700; line-height: 1.4;">
                                            {{ $addr->subdistrict ? 'ต.' . $addr->subdistrict : '' }} 
                                            {{ $addr->district ? 'อ.' . $addr->district : '' }} 
                                            {{ $addr->province ? 'จ.' . $addr->province : '' }} 
                                            {{ $addr->postal_code }}
                                        </p>
                                        <p style="margin: 2px 0 0; font-size: 0.78rem; color: #0E7490; font-weight: 800;">📞 {{ $addr->phone }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Button 2: Enter New Address -->
                    <button type="button" 
                            @click="clearAddressForNew()"
                            class="addr-mode-btn"
                            :class="addressMode === 'new' ? 'is-active' : 'is-inactive'">
                        <span>✍️</span> กรอกที่อยู่จัดส่งใหม่
                    </button>
                </div>

                <!-- Structured Address Form Input Fields (Ultra-Rounded Capsule Inputs) -->
                <div style="background: #F8FAFC; border: 1.5px solid #E2E8F0; border-radius: 28px; padding: 1.75rem;">
                    <h4 style="font-size: 1rem; font-weight: 900; color: #0E7490; margin: 0 0 1.25rem; display: flex; align-items: center; gap: 8px;">
                        ✍️ กรอก/ตรวจสอบที่อยู่จัดส่งสินค้า
                    </h4>

                    <div style="display: flex; flex-direction: column; gap: 1.15rem;">
                        <div>
                            <label style="display: block; font-weight: 800; margin-bottom: 6px; color: #0F172A; font-size: 0.88rem; padding-left: 8px;">รายละเอียดที่อยู่ / บ้านเลขที่ / อาคาร / ถนน *</label>
                            <input type="text" x-model="addrLine" required placeholder="เช่น 123/45 หมู่ 2 ถ.ชัยประสิทธิ์" style="width: 100%; padding: 12px 20px; border: 1.5px solid #BAE6FD; border-radius: 99px; font-family: inherit; font-size: 0.95rem; font-weight: 700; color: #0F172A; outline: none; background: white; transition: all 0.2s;" onfocus="this.style.borderColor='#0284C7'; this.style.boxShadow='0 0 0 4px rgba(2, 132, 199, 0.15)'" onblur="this.style.borderColor='#BAE6FD'; this.style.boxShadow='none'">
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                            <div>
                                <label style="display: block; font-weight: 800; margin-bottom: 6px; color: #0F172A; font-size: 0.88rem; padding-left: 8px;">จังหวัด *</label>
                                <input type="text" x-model="province" required placeholder="เช่น ชัยภูมิ" style="width: 100%; padding: 12px 20px; border: 1.5px solid #BAE6FD; border-radius: 99px; font-family: inherit; font-size: 0.95rem; font-weight: 700; color: #0F172A; outline: none; background: white; transition: all 0.2s;" onfocus="this.style.borderColor='#0284C7'; this.style.boxShadow='0 0 0 4px rgba(2, 132, 199, 0.15)'" onblur="this.style.borderColor='#BAE6FD'; this.style.boxShadow='none'">
                            </div>
                            <div>
                                <label style="display: block; font-weight: 800; margin-bottom: 6px; color: #0F172A; font-size: 0.88rem; padding-left: 8px;">อำเภอ / เขต *</label>
                                <input type="text" x-model="district" required placeholder="เช่น เมืองชัยภูมิ" style="width: 100%; padding: 12px 20px; border: 1.5px solid #BAE6FD; border-radius: 99px; font-family: inherit; font-size: 0.95rem; font-weight: 700; color: #0F172A; outline: none; background: white; transition: all 0.2s;" onfocus="this.style.borderColor='#0284C7'; this.style.boxShadow='0 0 0 4px rgba(2, 132, 199, 0.15)'" onblur="this.style.borderColor='#BAE6FD'; this.style.boxShadow='none'">
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                            <div>
                                <label style="display: block; font-weight: 800; margin-bottom: 6px; color: #0F172A; font-size: 0.88rem; padding-left: 8px;">ตำบล / แขวง *</label>
                                <input type="text" x-model="subdistrict" required placeholder="เช่น ในเมือง" style="width: 100%; padding: 12px 20px; border: 1.5px solid #BAE6FD; border-radius: 99px; font-family: inherit; font-size: 0.95rem; font-weight: 700; color: #0F172A; outline: none; background: white; transition: all 0.2s;" onfocus="this.style.borderColor='#0284C7'; this.style.boxShadow='0 0 0 4px rgba(2, 132, 199, 0.15)'" onblur="this.style.borderColor='#BAE6FD'; this.style.boxShadow='none'">
                            </div>
                            <div>
                                <label style="display: block; font-weight: 800; margin-bottom: 6px; color: #0F172A; font-size: 0.88rem; padding-left: 8px;">รหัสไปรษณีย์ *</label>
                                <input type="text" x-model="postalCode" required placeholder="เช่น 36000" style="width: 100%; padding: 12px 20px; border: 1.5px solid #BAE6FD; border-radius: 99px; font-family: inherit; font-size: 0.95rem; font-weight: 700; color: #0F172A; outline: none; background: white; transition: all 0.2s;" onfocus="this.style.borderColor='#0284C7'; this.style.boxShadow='0 0 0 4px rgba(2, 132, 199, 0.15)'" onblur="this.style.borderColor='#BAE6FD'; this.style.boxShadow='none'">
                            </div>
                        </div>

                        <div>
                            <label style="display: block; font-weight: 800; margin-bottom: 6px; color: #0F172A; font-size: 0.88rem; padding-left: 8px;">เบอร์โทรศัพท์ติดต่อผู้รับ *</label>
                            <input type="text" x-model="phone" required placeholder="เช่น 0812345678" style="width: 100%; padding: 12px 20px; border: 1.5px solid #BAE6FD; border-radius: 99px; font-family: inherit; font-size: 0.95rem; font-weight: 700; color: #0F172A; outline: none; background: white; transition: all 0.2s;" onfocus="this.style.borderColor='#0284C7'; this.style.boxShadow='0 0 0 4px rgba(2, 132, 199, 0.15)'" onblur="this.style.borderColor='#BAE6FD'; this.style.boxShadow='none'">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Selection Card (Ultra-Rounded Capsule Style) -->
            <div class="checkout-card-box" style="background: white; border: 1.5px solid #BAE6FD; border-radius: 32px; padding: 2.25rem; box-shadow: 0 10px 40px rgba(8, 145, 178, 0.06);">
                <h3 style="font-size: 1.25rem; font-weight: 900; color: #0E7490; margin-bottom: 1.25rem; border-bottom: 2px solid #F0F9FF; padding-bottom: 0.75rem; display: flex; align-items: center; gap: 10px;">
                    💳 2. ช่องทางการชำระเงิน
                </h3>
                
                <div style="display: grid; grid-template-columns: 1fr; gap: 1rem;">
                    <label style="border: 2px solid #0284C7; padding: 1.25rem 1.6rem; border-radius: 24px; display: flex; align-items: center; gap: 16px; cursor: pointer; background: #F0F9FF; box-shadow: 0 6px 20px rgba(2, 132, 199, 0.12);">
                        <input type="radio" name="payment_method" value="promptpay" checked style="accent-color: #0284C7; width: 22px; height: 22px;">
                        <div>
                            <span style="font-size: 1.6rem;">📱</span>
                            <span style="font-weight: 900; color: #0F172A; display: block; margin-top: 2px; font-size: 1rem;">PromptPay QR / โอนผ่านหมายเลขบัญชี</span>
                            <span style="font-size: 0.82rem; color: #0E7490; font-weight: 800;">สแกน QR Code หรือโอนชำระเงินผ่าน Mobile Banking</span>
                        </div>
                    </label>
                </div>
            </div>

        </div>

        <!-- Right Column: Order Summary & Real-time Coupon Search -->
        <div style="flex: 1 1 380px;">
            <div class="checkout-card-box" style="background: white; border: 1.5px solid #BAE6FD; border-radius: 32px; padding: 2rem; box-shadow: 0 10px 40px rgba(8, 145, 178, 0.06); position: sticky; top: 100px;">
                <h3 style="font-size: 1.25rem; font-weight: 900; color: #0E7490; margin-bottom: 1.25rem; border-bottom: 2px solid #F0F9FF; padding-bottom: 0.75rem; display: flex; align-items: center; justify-content: space-between;">
                    <span>📦 รายการสินค้า</span>
                    <span style="font-size: 0.8rem; background: #0284C7; color: white; padding: 4px 14px; border-radius: 99px; font-weight: 900;">{{ count($cart) }} รายการ</span>
                </h3>
                
                @foreach($cart as $id => $item)
                    <input type="hidden" name="items[]" value="{{ $id }}">
                @endforeach

                <div style="display: flex; flex-direction: column; gap: 0.85rem; margin-bottom: 1.5rem; max-height: 220px; overflow-y: auto; padding-right: 4px;">
                    @php $total = 0; @endphp
                    @foreach($cart as $item)
                    @php $total += $item['price'] * $item['quantity']; @endphp
                    <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.9rem;">
                        <span style="color: #0F172A; font-weight: 800; min-width: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 210px;">{{ $item['name'] }} <small style="color: #94A3B8;">x{{ $item['quantity'] }}</small></span>
                        <span style="font-weight: 900; color: #0F172A; flex-shrink: 0;">฿{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                    </div>
                    @endforeach
                </div>

                <!-- Real-time Coupon Section -->
                <div style="margin: 1.25rem 0; padding-top: 1.25rem; border-top: 1.5px solid #F1F5F9;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                        <label style="font-weight: 900; color: #0E7490; font-size: 0.92rem; display: flex; align-items: center; gap: 6px;">
                            🎟️ คูปองส่วนลด
                        </label>
                    </div>

                    @if(session('coupon'))
                        <!-- Active Applied Coupon Card (Guaranteed Non-wrapping Cancel Button) -->
                        <div style="border: 2px solid #0284C7; padding: 14px 18px; border-radius: 24px; background: #F0F9FF; display: flex; justify-content: space-between; align-items: center; gap: 12px; box-shadow: 0 6px 20px rgba(2, 132, 199, 0.12); margin-bottom: 0.85rem;">
                            <div style="min-width: 0; flex: 1;">
                                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px; flex-wrap: wrap;">
                                    <span style="font-weight: 900; color: #0F172A; font-size: 0.95rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%;">
                                        {{ session('coupon')->name }}
                                    </span>
                                    <span style="background: #0284C7; color: white; font-size: 0.72rem; padding: 2px 10px; border-radius: 9999px; font-weight: 900; white-space: nowrap;">
                                        ลด ฿{{ number_format(session('coupon')->discount_amount, 0) }}
                                    </span>
                                </div>
                                <div style="font-size: 0.82rem; color: #0E7490; font-weight: 800;">
                                    โค้ด: <code style="background: #BAE6FD; color: #0369A1; padding: 1px 8px; border-radius: 6px; font-weight: 900;">{{ session('coupon')->code }}</code>
                                </div>
                            </div>
                            <!-- Cancel Coupon Button (Independent Click Trigger) -->
                            <button type="button" onclick="submitRemoveCoupon(event)" 
                                    style="background: #FFF2F2; color: #EF4444; border: 1.5px solid #FCA5A5; padding: 8px 18px; border-radius: 9999px; font-size: 0.82rem; font-weight: 900; cursor: pointer; transition: all 0.2s; white-space: nowrap; flex-shrink: 0; display: inline-flex; align-items: center; gap: 4px; outline: none;"
                                    onmouseover="this.style.background='#FEE2E2'" onmouseout="this.style.background='#FFF2F2'">
                                <span>❌</span> ยกเลิกโค้ด
                            </button>
                        </div>
                    @else
                        @php
                            $activeCoupons = $collectedCoupons->filter(function($cc) {
                                return !$cc->is_used && \Carbon\Carbon::parse($cc->coupon->expires_at)->isFuture();
                            });
                        @endphp

                        @if($activeCoupons->count() > 0)
                            <!-- Custom Alpine Floating Glass Card Dropdown for Collected Coupons -->
                            <div style="margin-bottom: 0.85rem;">
                                <label style="display: block; font-weight: 800; color: #0E7490; font-size: 0.82rem; margin-bottom: 6px; padding-left: 4px;">
                                    🎟️ เลือกคูปองจากบัญชีของคุณ ({{ $activeCoupons->count() }} ใบ):
                                </label>
                                
                                <div style="position: relative; width: 100%; z-index: 900;" x-data="{ openCouponMenu: false }">
                                    <button type="button" 
                                            @click="openCouponMenu = !openCouponMenu" 
                                            @click.away="openCouponMenu = false"
                                            style="width: 100%; padding: 10px 18px; border: 2px solid #0284C7; border-radius: 9999px !important; font-family: inherit; font-size: 0.85rem; font-weight: 800; color: #0F172A; background: #F0F9FF; outline: none; cursor: pointer; text-align: left; box-shadow: 0 4px 12px rgba(2, 132, 199, 0.1); display: flex; align-items: center; justify-content: space-between; transition: all 0.2s;"
                                            onmouseover="this.style.background='#E0F2FE'" onmouseout="this.style.background='#F0F9FF'">
                                        <span style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-weight: 800;">
                                            -- คลิกเลือกคูปองส่วนลด --
                                        </span>
                                        <span style="color: #0284C7; font-size: 0.75rem; margin-left: 6px; flex-shrink: 0;">
                                            ▼
                                        </span>
                                    </button>

                                    <!-- Custom Floating Glass Card Dropdown Menu (Matches User Profile Menu Style) -->
                                    <div x-show="openCouponMenu" 
                                         x-transition:enter="transition ease-out duration-150"
                                         x-transition:enter-start="opacity-0 transform scale-95 -translate-y-2"
                                         x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
                                         style="display: none; position: absolute; left: 0; top: 100%; margin-top: 6px; background: white; border: 1.5px solid #BAE6FD; border-radius: 20px; box-shadow: 0 12px 35px rgba(2, 132, 199, 0.18); z-index: 9999; width: 100%; padding: 0.5rem 0; overflow: hidden;">
                                        
                                        <div style="padding: 6px 14px; font-size: 0.75rem; font-weight: 900; color: #0E7490; background: #F0F9FF; border-bottom: 1px solid #E0F2FE;">
                                            🎟️ คลิกเลือกคูปองที่ต้องการใช้งาน:
                                        </div>

                                        <div style="max-height: 220px; overflow-y: auto;">
                                            @foreach($activeCoupons as $cc)
                                                @php $c = $cc->coupon; @endphp
                                                <div @click="submitApplyCoupon('{{ $c->code }}'); openCouponMenu = false"
                                                     style="padding: 10px 14px; cursor: pointer; transition: all 0.18s; border-bottom: 1px solid #F1F5F9; display: flex; justify-content: space-between; align-items: center; gap: 8px;"
                                                     onmouseover="this.style.background='#F0F9FF'" 
                                                     onmouseout="this.style.background='white'">
                                                    <div style="min-width: 0; flex: 1;">
                                                        <div style="font-weight: 900; color: #0F172A; font-size: 0.85rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                            {{ $c->name }}
                                                        </div>
                                                        <div style="font-size: 0.75rem; color: #0E7490; font-weight: 800; margin-top: 1px;">
                                                            โค้ด: <code style="background: #BAE6FD; color: #0369A1; padding: 0 5px; border-radius: 4px; font-weight: 900;">{{ $c->code }}</code>
                                                        </div>
                                                    </div>
                                                    <span style="background: #0284C7; color: white; font-size: 0.72rem; padding: 3px 10px; border-radius: 9999px; font-weight: 900; flex-shrink: 0;">
                                                        ลด ฿{{ number_format($c->discount_amount, 0) }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Manual Coupon Code Input Bar -->
                        <div style="display: flex; gap: 8px;">
                            <input type="text" id="coupon_code_input" placeholder="พิมพ์รหัสส่วนลดอื่น..." 
                                   style="flex: 1; min-width: 0; padding: 10px 18px; border: 1.5px solid #BAE6FD; border-radius: 9999px !important; font-family: inherit; font-size: 0.85rem; outline: none; font-weight: 700; color: #0F172A; background: white; transition: all 0.2s;"
                                   onfocus="this.style.borderColor='#0284C7'; this.style.boxShadow='0 0 0 4px rgba(2, 132, 199, 0.15)'"
                                   onblur="this.style.borderColor='#BAE6FD'; this.style.boxShadow='none'">
                            <button type="button" onclick="applyCouponCode()" 
                                    class="addr-mode-btn is-inactive" 
                                    style="padding: 10px 18px !important; font-size: 0.85rem !important; flex-shrink: 0;">
                                ใช้รหัส
                            </button>
                        </div>
                    @endif
                </div>

                <hr style="border: 0; border-top: 1.5px solid #F1F5F9; margin-bottom: 1.25rem;">

                @php 
                    $discount = session()->has('coupon') ? session('coupon')->discount_amount : 0;
                    $netTotal = max(0, $total - $discount);
                @endphp

                <div style="display: flex; flex-direction: column; gap: 8px; margin-bottom: 1.75rem;">
                    <div style="display: flex; justify-content: space-between; font-size: 0.95rem;">
                        <span style="color: #64748B; font-weight: 700;">รวมค่าสินค้า</span>
                        <span style="font-weight: 900; color: #0F172A;">฿{{ number_format($total, 2) }}</span>
                    </div>
                    @if($discount > 0)
                    <div style="display: flex; justify-content: space-between; font-size: 0.95rem; color: #EF4444;">
                        <span style="font-weight: 800;">ส่วนลดคูปอง</span>
                        <span style="font-weight: 900;">-฿{{ number_format($discount, 2) }}</span>
                    </div>
                    @endif
                    <div style="display: flex; justify-content: space-between; font-size: 1.35rem; font-weight: 900; border-top: 2px solid #F1F5F9; padding-top: 12px; margin-top: 4px;">
                        <span style="color: #0F172A;">ยอดที่ต้องชำระ</span>
                        <span style="color: #EF4444;">฿{{ number_format($netTotal, 2) }}</span>
                    </div>
                </div>

                <button type="submit" style="width: 100%; text-align: center; padding: 16px; background: linear-gradient(135deg, #0284C7 0%, #0369A1 100%); color: white; border: none; border-radius: 9999px; font-weight: 900; font-size: 1.1rem; cursor: pointer; box-shadow: 0 8px 25px rgba(2, 132, 199, 0.3); transition: transform 0.2s; display: flex; align-items: center; justify-content: center; gap: 10px;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                    <i class="fa-solid fa-lock"></i> ดำเนินการสั่งซื้อและชำระเงิน
                </button>
            </div>
        </div>

    </form>
</div>

<!-- Hidden coupon submission forms (Outside main checkout form) -->
<form id="coupon-form" action="{{ route('coupons.apply') }}" method="POST" style="display:none;">
    @csrf
    <input type="hidden" name="coupon_code" id="hidden_coupon_code">
</form>

<form id="remove-coupon-form" action="{{ route('coupons.remove') }}" method="POST" style="display:none;">
    @csrf
</form>

<script>
    function submitApplyCoupon(code) {
        if (!code) return;
        document.getElementById('hidden_coupon_code').value = code;
        document.getElementById('coupon-form').submit();
    }

    function applySelectedCoupon() {
        const select = document.getElementById('collected_coupon_select');
        const code = select ? select.value : '';
        if (!code) {
            Swal.fire({
                icon: 'warning',
                title: 'กรุณาเลือกคูปอง',
                text: 'กรุณาเลือกคูปองส่วนลดจากเมนูก่อนกดใช้งาน',
                confirmButtonColor: '#0284C7'
            });
            return;
        }
        submitApplyCoupon(code);
    }

    function applyCouponCode() {
        const input = document.getElementById('coupon_code_input');
        const val = input ? input.value.trim() : '';
        if (!val) {
            Swal.fire({
                icon: 'warning',
                title: 'กรุณากรอกรหัสคูปอง',
                text: 'กรุณาพิมพ์รหัสส่วนลดก่อนกดใช้งาน',
                confirmButtonColor: '#0284C7'
            });
            return;
        }
        submitApplyCoupon(val);
    }

    function submitRemoveCoupon(e) {
        if (e) {
            e.preventDefault();
            e.stopPropagation();
        }
        document.getElementById('remove-coupon-form').submit();
    }
</script>
@endsection

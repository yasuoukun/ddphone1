@extends('layouts.store')

@section('content')
<div class="container checkout-container fade-in">
    <!-- Main Two-Column Grid -->
    <div class="checkout-grid">
        
        <!-- Left Column: Order Summary -->
        <div class="order-summary-card">
            <h3 class="summary-title">📦 สรุปคำสั่งซื้อ #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h3>
            
            <!-- Items list -->
            <div class="items-list">
                @foreach($order->items as $item)
                <div class="item-row">
                    <div class="item-pic-info">
                        @if($item->product && $item->product->images->isNotEmpty())
                            @php
                                $itemImgPath = $item->product->images->first()->image_path;
                            @endphp
                            @if(str_starts_with($itemImgPath, 'http'))
                                <img src="{{ $itemImgPath }}" alt="{{ $item->product->name }}" class="item-thumb">
                            @else
                                <img src="{{ Storage::url($itemImgPath) }}" alt="{{ $item->product->name }}" class="item-thumb">
                            @endif
                        @else
                            <div class="item-thumb-placeholder">📱</div>
                        @endif
                        <div>
                            <h4 class="item-name">{{ $item->product ? $item->product->name : 'สินค้าทั่วไป' }}</h4>
                            <span class="item-qty">จำนวน: {{ $item->quantity }} ชิ้น</span>
                        </div>
                    </div>
                    <div class="item-price">
                        ฿{{ number_format($item->price * $item->quantity, 2) }}
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Financials -->
            <div class="financials-box">
                @php
                    $rawSubtotal = $order->total_amount + $order->discount_amount;
                @endphp
                <div class="fin-row">
                    <span>ยอดรวมสินค้า:</span>
                    <span>฿{{ number_format($rawSubtotal, 2) }}</span>
                </div>
                @if($order->discount_amount > 0)
                <div class="fin-row discount">
                    <span>ส่วนลดคูปอง ({{ $order->coupon_code }}):</span>
                    <span>-฿{{ number_format($order->discount_amount, 2) }}</span>
                </div>
                @endif
                <hr class="summary-divider">
                <div class="fin-row total">
                    <span>ยอดที่ต้องชำระทั้งสิ้น:</span>
                    <span class="net-total-price">฿{{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>

            <!-- Shipping address card info -->
            <div class="shipping-info-brief">
                <h5>📍 ที่อยู่จัดส่ง</h5>
                <p>{{ $order->shipping_info }}</p>
            </div>
        </div>

        <!-- Right Column: Payment Form -->
        <div class="payment-card">
            <div class="payment-header">
                <h2>💳 ช่องทางการชำระเงิน</h2>
                <p>เลือกช่องทางชำระเงินที่สะดวกเพื่อยืนยันออเดอร์ของท่าน</p>
            </div>

            @if(session('error'))
            <div class="error-banner">
                ⚠️ {{ session('error') }}
            </div>
            @endif

            <!-- Alpine.js tabbed selector -->
            <div x-data="{ paymentType: 'promptpay' }" class="tabs-container">
                <!-- Tabs buttons -->
                <div class="tabs-buttons">
                    <button @click="paymentType = 'promptpay'" 
                            :class="paymentType === 'promptpay' ? 'active-tab' : 'inactive-tab'">
                        <span class="tab-icon">📱</span> PromptPay QR & โอนผ่านหมายเลขบัญชี
                    </button>
                    @if(false)
                    <button @click="paymentType = 'direct_debit'" 
                            :class="paymentType === 'direct_debit' ? 'active-tab' : 'inactive-tab'">
                        <span class="tab-icon">🏦</span> หักบัญชีธนาคาร
                    </button>
                    <button @click="paymentType = 'omise'" 
                            :class="paymentType === 'omise' ? 'active-tab' : 'inactive-tab'">
                        <span class="tab-icon">💳</span> บัตรเครดิตออนไลน์
                    </button>
                    <button @click="paymentType = 'scb_qr'" 
                            :class="paymentType === 'scb_qr' ? 'active-tab' : 'inactive-tab'"
                            style="background: linear-gradient(135deg, #4f46e5, #7c3aed); color: white; border: none;">
                        <span class="tab-icon">📲</span> SCB PromptPay/QR
                    </button>
                    <button @click="paymentType = 'scb_card'" 
                            :class="paymentType === 'scb_card' ? 'active-tab' : 'inactive-tab'"
                            style="background: linear-gradient(135deg, #059669, #047857); color: white; border: none;">
                        <span class="tab-icon">🏧</span> SCB บัตรเครดิต/เดบิต
                    </button>
                    @endif
                </div>
                
                <!-- TAB 1: PromptPay -->
                <div x-show="paymentType === 'promptpay'" class="tab-content fade-in">
                    <div class="promptpay-box">
                        <div class="promptpay-logo-container">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/c/c5/PromptPay-logo.png" alt="PromptPay" class="promptpay-logo">
                        </div>
                        
                        <div class="qr-container">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=https://www.dditcom.co.th/pay/order/{{ $order->id }}" alt="Payment QR" class="qr-image">
                        </div>

                        <div class="account-details">
                            <p>ชื่อบัญชี: <strong>DDPHONE (ดีดีโฟน ชัยภูมิ)</strong></p>
                            <p>หมายเลขพร้อมเพย์: <strong class="text-indigo-600">088-999-8888</strong></p>
                        </div>
                    </div>

                    <!-- Upload Slip Uploader Form -->
                    <form action="{{ route('checkout.upload_slip', $order->id) }}" method="POST" enctype="multipart/form-data" class="uploader-form">
                        @csrf
                        <div class="file-input-group">
                            <label class="file-label">
                                📁 แนบรูปภาพสลิปการโอนเงินเพื่อแจ้งชำระ
                            </label>
                            <input type="file" name="slip_image" accept="image/*" required class="file-control">
                            <p class="file-note">
                                * รองรับไฟล์รูปภาพ JPG, JPEG, PNG, WEBP (ขนาดไม่เกิน 4MB)
                            </p>
                        </div>

                        <div class="actions-group">
                            <button type="submit" class="btn-submit-payment">
                                ส่งสลิปแจ้งชำระเงิน
                            </button>
                            <a href="{{ route('dashboard', ['tab' => 'orders']) }}" class="btn-later-payment">
                                ชำระทีหลัง
                            </a>
                        </div>
                    </form>
                </div>

                @if(false)
                <!-- TAB 2: Direct Debit Bank Transfer -->
                <div x-show="paymentType === 'direct_debit'" class="tab-content fade-in" x-cloak>
                    @if($paymentMethods->isEmpty())
                        <div class="no-payment-methods">
                            <i class="fa-solid fa-building-columns text-4xl text-rose-500 mb-4 block animate-bounce"></i>
                            <h4>ยังไม่ได้ผูกบัญชีธนาคาร</h4>
                            <p>กรุณาผูกบัญชีธนาคารกับระบบก่อนจึงจะเปิดใช้งานการหักบัญชีอัตโนมัติได้</p>
                            <a href="{{ route('dashboard', ['tab' => 'payment_methods']) }}" class="btn-bind-now">
                                🔗 ไปผูกบัญชีธนาคารที่นี่
                            </a>
                        </div>
                    @else
                        <div class="direct-debit-box">
                            <h4>เลือกบัญชีธนาคารเพื่อหักยอดเงินอัตโนมัติ</h4>
                            
                            <form action="{{ route('checkout.pay_direct_debit', $order->id) }}" method="POST" x-data="{ paying: false }" @submit="paying = true">
                                @csrf
                                <div class="bank-accounts-list">
                                    @foreach($paymentMethods as $pm)
                                    <label class="bank-account-option">
                                        <input type="radio" name="payment_method_id" value="{{ $pm->id }}" {{ $pm->is_default ? 'checked' : '' }} required class="radio-input">
                                        <div class="bank-details">
                                            <span class="bank-name">
                                                🏦 {{ $pm->provider }} 
                                                @if($pm->is_default)
                                                    <span class="default-badge">บัญชีหลัก</span>
                                                @endif
                                            </span>
                                            <span class="bank-acc-info">ชื่อบัญชี: {{ $pm->account_name }} | เลขบัญชี: {{ $pm->account_number }}</span>
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                                
                                <button type="submit" :disabled="paying" class="btn-submit-debit">
                                    <span x-show="paying" class="flex items-center justify-center gap-2">
                                        <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        กำลังหักบัญชีผ่านระบบ...
                                    </span>
                                    <span x-show="!paying">💸 ยืนยันหักบัญชีอัตโนมัติ</span>
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                <!-- TAB 3: Omise Credit/Debit Card -->
                <div x-show="paymentType === 'omise'" class="tab-content fade-in" x-cloak>
                    <div class="omise-box">
                        <i class="fa-solid fa-credit-card text-5xl text-indigo-500 mb-4 block"></i>
                        <h4>ชำระด้วยบัตรเครดิต/เดบิตออนไลน์</h4>
                        <p>
                            ระบบการชำระเงินที่ปลอดภัยสูงผ่าน Omise Payment Gateway ในโหมดทดสอบ
                        </p>
                        
                        <form id="omiseForm" action="{{ route('checkout.pay_omise', $order->id) }}" method="POST" x-data="{ paying: false }" @submit="paying = true">
                            @csrf
                            <input type="hidden" name="omise_token" id="omiseTokenInput">
                            
                            <button type="button" id="payOmiseButton" :disabled="paying" class="btn-submit-omise">
                                <span x-show="paying" class="flex items-center justify-center gap-2">
                                    <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    กำลังเปิดตัวเชื่อมชำระเงิน...
                                </span>
                                <span x-show="!paying">💳 ชำระเงินด้วยบัตรเครดิต (ออนไลน์)</span>
                            </button>
                        </form>
                        
                        <div class="secured-badge">
                            <span>Secured by</span>
                            <img src="https://cdn.omise.co/assets/logo.png" alt="Omise Logo" class="secured-logo">
                        </div>
                    </div>
                </div>

                <!-- TAB: SCB PromptPay / QR (2C2P) -->
                <div x-show="paymentType === 'scb_qr'" class="tab-content fade-in" x-cloak>
                    <div style="background: linear-gradient(135deg, #f5f3ff, #ede9fe); border-radius: 20px; padding: 2.5rem; text-align: text; border: 1.5px solid #c4b5fd;">
                        <div style="display: flex; align-items: center; justify-content: center; gap: 12px; margin-bottom: 1rem;">
                            <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #4f46e5, #7c3aed); border-radius: 14px; display: flex; align-items: center; justify-content: center; box-shadow: 0 6px 16px rgba(79,70,229,0.35);">
                                <i class="fa-solid fa-qrcode" style="color: white; font-size: 1.5rem;"></i>
                            </div>
                            <div style="text-align: left;">
                                <h4 style="font-weight: 800; color: #3730a3; margin: 0; font-size: 1.1rem;">ชำระผ่าน SCB PromptPay / QR Code</h4>
                                <p style="color: #6d28d9; font-size: 0.85rem; margin: 0;">ขับเคลื่อนโดย 2C2P Payment Gateway</p>
                            </div>
                        </div>
                        <p style="color: #5b21b6; font-size: 0.9rem; margin-bottom: 1.5rem; line-height: 1.6;">
                            สแกน QR Code ด้วยแอปธนาคาร หรือ Mobile Banking ของคุณ<br>
                            <strong>รับรองโดย SCB (ไทยพาณิชย์)</strong> ผ่าน 2C2P PGW v4.3
                        </p>
                        <div style="background: white; border-radius: 12px; padding: 1rem; margin-bottom: 1.5rem; border: 1px solid #c4b5fd;">
                            <p style="font-size: 0.85rem; color: #6b7280; margin: 0;">ยอดที่ต้องชำระ</p>
                            <p style="font-size: 1.75rem; font-weight: 900; color: #3730a3; margin: 0;">฿{{ number_format($order->total_amount, 2) }}</p>
                        </div>
                        <form action="{{ route('payment.2c2p.initiate', $order->id) }}" method="POST" x-data="{ paying: false }" @submit="paying = true">
                            @csrf
                            <input type="hidden" name="type" value="qr">
                            <button type="submit" :disabled="paying"
                                style="width: 100%; padding: 1rem; background: linear-gradient(135deg, #4f46e5, #7c3aed); color: white; border: none; border-radius: 14px; font-size: 1.05rem; font-weight: 700; cursor: pointer; box-shadow: 0 6px 20px rgba(79,70,229,0.4); transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 0.75rem;">
                                <span x-show="!paying"><i class="fa-solid fa-qrcode"></i> รับ QR Code เพื่อชำระเงิน</span>
                                <span x-show="paying" style="display: flex; align-items: center; gap: 0.5rem;">
                                    <svg class="animate-spin" style="width:20px;height:20px;" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                    กำลังเชื่อมต่อระบบ SCB...
                                </span>
                            </button>
                        </form>
                        <div style="margin-top: 1rem; display: flex; align-items: center; justify-content: center; gap: 8px;">
                            <i class="fa-solid fa-shield-halved" style="color: #6d28d9;"></i>
                            <span style="font-size: 0.8rem; color: #6d28d9;">Secured by 2C2P · SCB Payment Gateway v4.3</span>
                        </div>
                    </div>
                </div>

                <!-- TAB: SCB Credit/Debit Card (2C2P) -->
                <div x-show="paymentType === 'scb_card'" class="tab-content fade-in" x-cloak>
                    <div style="background: linear-gradient(135deg, #ecfdf5, #f0fdf4); border-radius: 20px; padding: 2.5rem; text-align: center; border: 1.5px solid #86efac;">
                        <div style="display: flex; align-items: center; justify-content: center; gap: 12px; margin-bottom: 1rem;">
                            <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #059669, #047857); border-radius: 14px; display: flex; align-items: center; justify-content: center; box-shadow: 0 6px 16px rgba(5,150,105,0.35);">
                                <i class="fa-solid fa-credit-card" style="color: white; font-size: 1.5rem;"></i>
                            </div>
                            <div style="text-align: left;">
                                <h4 style="font-weight: 800; color: #065f46; margin: 0; font-size: 1.1rem;">ชำระด้วยบัตรเครดิต/เดบิต (SCB)</h4>
                                <p style="color: #047857; font-size: 0.85rem; margin: 0;">ขับเคลื่อนโดย 2C2P Payment Gateway</p>
                            </div>
                        </div>
                        <p style="color: #065f46; font-size: 0.9rem; margin-bottom: 1.5rem; line-height: 1.6;">
                            ชำระด้วยบัตร Visa, MasterCard, JCB ผ่านหน้าชำระเงินที่ปลอดภัย<br>
                            <strong>รับรองโดย SCB (ไทยพาณิชย์)</strong> · 3D Secure Verified
                        </p>
                        <div style="background: white; border-radius: 12px; padding: 1rem; margin-bottom: 1.5rem; border: 1px solid #86efac;">
                            <p style="font-size: 0.85rem; color: #6b7280; margin: 0;">ยอดที่ต้องชำระ</p>
                            <p style="font-size: 1.75rem; font-weight: 900; color: #065f46; margin: 0;">฿{{ number_format($order->total_amount, 2) }}</p>
                        </div>
                        <form action="{{ route('payment.2c2p.initiate', $order->id) }}" method="POST" x-data="{ paying: false }" @submit="paying = true">
                            @csrf
                            <input type="hidden" name="type" value="card">
                            <button type="submit" :disabled="paying"
                                style="width: 100%; padding: 1rem; background: linear-gradient(135deg, #059669, #047857); color: white; border: none; border-radius: 14px; font-size: 1.05rem; font-weight: 700; cursor: pointer; box-shadow: 0 6px 20px rgba(5,150,105,0.4); transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 0.75rem;">
                                <span x-show="!paying"><i class="fa-solid fa-lock"></i> ชำระเงินด้วยบัตรอย่างปลอดภัย</span>
                                <span x-show="paying" style="display: flex; align-items: center; gap: 0.5rem;">
                                    <svg class="animate-spin" style="width:20px;height:20px;" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                    กำลังเชื่อมต่อระบบ SCB...
                                </span>
                            </button>
                        </form>
                        <div style="margin-top: 1.25rem; display: flex; align-items: center; justify-content: center; gap: 1rem; flex-wrap: wrap;">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/200px-Visa_Inc._logo.svg.png" alt="Visa" style="height: 22px; object-fit: contain; opacity: 0.7;">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b7/MasterCard_Logo.svg/200px-MasterCard_Logo.svg.png" alt="MasterCard" style="height: 22px; object-fit: contain; opacity: 0.7;">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/40/JCB_logo.svg/200px-JCB_logo.svg.png" alt="JCB" style="height: 22px; object-fit: contain; opacity: 0.7;">
                        </div>
                        <div style="margin-top: 0.75rem; display: flex; align-items: center; justify-content: center; gap: 8px;">
                            <i class="fa-solid fa-shield-halved" style="color: #059669;"></i>
                            <span style="font-size: 0.8rem; color: #059669;">Secured by 2C2P · SCB Payment Gateway v4.3 · 3D Secure</span>
                        </div>
                    </div>
                </div>
                @endif

            </div>
        </div>
        </div>
    </div>
</div>

<!-- Custom Checkout styling -->
<style>
    .checkout-container {
        max-width: 1100px;
        margin: 3.5rem auto;
        padding: 0 1.5rem;
        font-family: 'Prompt', sans-serif;
    }
    
    .checkout-grid {
        display: grid;
        grid-template-columns: 1.1fr 1fr;
        gap: 2.5rem;
        align-items: start;
    }

    /* Left Card: Order Summary */
    .order-summary-card {
        background: white;
        border: 1px solid var(--color-silver);
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.02);
        padding: 2rem;
    }

    .summary-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--color-navy-dark);
        margin-top: 0;
        margin-bottom: 1.5rem;
        border-bottom: 2px solid var(--color-silver-light);
        padding-bottom: 0.75rem;
    }

    .items-list {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
        margin-bottom: 1.5rem;
        max-height: 280px;
        overflow-y: auto;
        padding-right: 5px;
    }

    .item-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        border-bottom: 1px dashed var(--color-silver-light);
        padding-bottom: 0.85rem;
    }

    .item-pic-info {
        display: flex;
        align-items: center;
        gap: 0.85rem;
    }

    .item-thumb {
        width: 52px;
        height: 52px;
        border-radius: 10px;
        object-fit: cover;
        border: 1px solid var(--color-silver-light);
        background: #fafafa;
    }

    .item-thumb-placeholder {
        width: 52px;
        height: 52px;
        border-radius: 10px;
        background: var(--color-silver-light);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .item-name {
        font-size: 0.92rem;
        font-weight: 600;
        color: var(--color-navy-dark);
        margin: 0 0 3px;
        max-width: 250px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .item-qty {
        font-size: 0.8rem;
        color: var(--color-grey-light);
        display: block;
    }

    .item-price {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--color-navy-dark);
    }

    .financials-box {
        background: #f8fafc;
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
    }

    .fin-row {
        display: flex;
        justify-content: space-between;
        font-size: 0.9rem;
        color: var(--color-grey);
        margin-bottom: 8px;
    }

    .fin-row.discount {
        color: var(--color-danger);
        font-weight: 500;
    }

    .summary-divider {
        border: 0;
        border-top: 1px solid var(--color-silver);
        margin: 10px 0;
    }

    .fin-row.total {
        margin-top: 5px;
        font-size: 1rem;
        font-weight: 700;
        color: var(--color-navy-dark);
        margin-bottom: 0;
    }

    .net-total-price {
        font-size: 1.5rem;
        color: var(--color-accent);
        font-weight: 800;
    }

    .shipping-info-brief {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 12px;
        padding: 1.25rem;
    }

    .shipping-info-brief h5 {
        margin: 0 0 6px;
        font-size: 0.92rem;
        font-weight: 700;
        color: #166534;
    }

    .shipping-info-brief p {
        margin: 0;
        font-size: 0.85rem;
        color: #1e3a1e;
        line-height: 1.5;
    }

    /* Right Card: Payment Form */
    .payment-card {
        background: white;
        border: 1px solid var(--color-silver);
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.02);
        overflow: hidden;
    }

    .payment-header {
        background: linear-gradient(135deg, #0284C7 0%, #0369A1 100%);
        color: white;
        padding: 1.75rem 2rem;
    }

    .payment-header h2 {
        font-size: 1.35rem;
        font-weight: 700;
        margin: 0 0 5px;
    }

    .payment-header p {
        margin: 0;
        font-size: 0.88rem;
        opacity: 0.85;
    }

    .error-banner {
        margin: 1.5rem 2rem 0;
        padding: 1rem;
        background: #fff5f5;
        border-left: 4px solid #ef4444;
        color: #b91c1c;
        border-radius: 0 8px 8px 0;
        font-size: 0.88rem;
        font-weight: 500;
    }

    .tabs-container {
        padding: 1.5rem 2rem 2rem;
    }

    /* Tabs Header */
    .tabs-buttons {
        display: flex;
        border-bottom: 2px solid var(--color-silver-light);
        margin-bottom: 1.5rem;
        gap: 5px;
    }

    .active-tab {
        flex: 1;
        padding: 12px 6px;
        border: none;
        background: none;
        border-bottom: 3px solid var(--color-accent);
        font-weight: 700;
        color: var(--color-navy-dark);
        font-family: inherit;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
    }

    .inactive-tab {
        flex: 1;
        padding: 12px 6px;
        border: none;
        background: none;
        border-bottom: 3px solid transparent;
        font-weight: 500;
        color: var(--color-grey-light);
        font-family: inherit;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
    }

    .inactive-tab:hover {
        color: var(--color-grey);
    }

    .tab-icon {
        font-size: 1.25rem;
    }

    .tab-content {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    /* PromptPay Tab Styles */
    .promptpay-box {
        background: #f8fafc;
        border: 1px solid var(--color-silver);
        border-radius: 16px;
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
        max-width: 320px;
        width: 100%;
        margin: 0 auto;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.01);
    }

    .promptpay-logo-container {
        display: flex;
        justify-content: center;
    }

    .promptpay-logo {
        height: 26px;
        object-fit: contain;
    }

    .qr-container {
        background: white;
        padding: 12px;
        border-radius: 12px;
        border: 1px solid var(--color-silver-light);
        display: inline-block;
        box-shadow: 0 4px 10px rgba(0,0,0,0.02);
    }

    .qr-image {
        width: 180px;
        height: 180px;
        display: block;
    }

    .account-details {
        text-align: center;
        font-size: 0.85rem;
        color: var(--color-navy-dark);
        line-height: 1.5;
    }

    .account-details p {
        margin: 0;
    }

    /* Uploader Form */
    .uploader-form {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    .file-input-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .file-label {
        font-weight: 700;
        color: var(--color-navy-dark);
        font-size: 0.92rem;
    }

    .file-control {
        width: 100%;
        padding: 10px;
        border: 1px solid var(--color-silver);
        border-radius: 8px;
        background: #f8fafc;
        font-family: inherit;
        font-size: 0.9rem;
    }

    .file-note {
        margin: 0;
        font-size: 0.78rem;
        color: var(--color-grey-light);
    }

    .actions-group {
        display: flex;
        gap: 12px;
        margin-top: 8px;
    }

    .btn-submit-payment {
        flex: 2;
        padding: 12px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.95rem;
        cursor: pointer;
        text-align: center;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .btn-submit-payment:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(16, 185, 129, 0.35);
    }

    .btn-later-payment {
        flex: 1;
        padding: 12px;
        border: 1px solid var(--color-silver);
        background: white;
        color: var(--color-navy-dark);
        text-decoration: none;
        text-align: center;
        font-weight: 600;
        border-radius: 10px;
        font-size: 0.95rem;
        transition: background 0.2s;
    }

    .btn-later-payment:hover {
        background: var(--color-grey-bg);
    }

    /* Direct Debit Tab Styles */
    .direct-debit-box {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    .direct-debit-box h4 {
        margin: 0;
        color: var(--color-navy-dark);
        font-weight: 700;
        font-size: 1rem;
        border-bottom: 1px solid var(--color-silver-light);
        padding-bottom: 8px;
    }

    .no-payment-methods {
        text-align: center;
        padding: 2.5rem 1.5rem;
        background: #fff5f5;
        border: 1px dashed #fecaca;
        border-radius: 16px;
    }

    .no-payment-methods h4 {
        margin: 0 0 4px;
        color: #991b1b;
        font-weight: 700;
        font-size: 1rem;
    }

    .no-payment-methods p {
        margin: 0 0 1.25rem;
        font-size: 0.85rem;
        color: #7f1d1d;
    }

    .btn-bind-now {
        display: inline-block;
        padding: 10px 20px;
        background: var(--color-navy);
        color: white;
        border-radius: 8px;
        font-weight: 700;
        text-decoration: none;
        font-size: 0.88rem;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        transition: transform 0.2s;
    }

    .btn-bind-now:hover {
        transform: translateY(-1px);
    }

    .bank-accounts-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-bottom: 1rem;
    }

    .bank-account-option {
        display: flex;
        align-items: center;
        gap: 12px;
        background: white;
        border: 1px solid var(--color-silver);
        padding: 1rem;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .bank-account-option:hover {
        border-color: var(--color-accent);
        background: #f8fafc;
    }

    .radio-input {
        accent-color: var(--color-accent);
        width: 18px;
        height: 18px;
    }

    .bank-details {
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    .bank-name {
        font-weight: 700;
        color: var(--color-navy-dark);
        font-size: 0.92rem;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .default-badge {
        font-size: 0.65rem;
        background: var(--color-success);
        color: white;
        padding: 1px 6px;
        border-radius: 4px;
        font-weight: 600;
    }

    .bank-acc-info {
        font-size: 0.82rem;
        color: var(--color-grey-light);
    }

    .btn-submit-debit {
        width: 100%;
        padding: 12px;
        background: linear-gradient(135deg, var(--color-navy) 0%, var(--color-navy-light) 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.98rem;
        cursor: pointer;
        text-align: center;
        box-shadow: 0 4px 12px rgba(27,42,71,0.2);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .btn-submit-debit:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(27,42,71,0.3);
    }

    /* Omise Tab Styles */
    .omise-box {
        text-align: center;
        max-width: 420px;
        width: 100%;
        border: 1px solid var(--color-silver);
        border-radius: 16px;
        padding: 2rem;
        background: #f8fafc;
        margin: 0 auto;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.01);
    }

    .omise-box h4 {
        margin: 0 0 6px;
        color: var(--color-navy-dark);
        font-weight: 700;
        font-size: 1.05rem;
    }

    .omise-box p {
        margin: 0 0 1.5rem;
        font-size: 0.85rem;
        color: var(--color-grey-light);
        line-height: 1.5;
    }

    .btn-submit-omise {
        width: 100%;
        padding: 12px;
        background: linear-gradient(135deg, #1A1F2C 0%, #303746 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.98rem;
        cursor: pointer;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .btn-submit-omise:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.22);
    }

    .secured-badge {
        margin-top: 1.25rem;
        display: flex;
        justify-content: center;
        gap: 8px;
        align-items: center;
        opacity: 0.7;
    }

    .secured-badge span {
        font-size: 0.75rem;
        color: var(--color-grey-light);
    }

    .secured-logo {
        height: 15px;
        object-fit: contain;
    }

    /* Responsive adjustments */
    @media (max-width: 860px) {
        .checkout-grid {
            grid-template-columns: 1fr;
            gap: 1.75rem;
        }
        .checkout-container {
            margin: 2rem auto;
        }
    }
    
    @media (max-width: 480px) {
        .tabs-buttons {
            flex-direction: column;
            border-bottom: none;
            gap: 8px;
        }
        .active-tab {
            border-bottom: none;
            border-left: 4px solid var(--color-accent);
            align-items: flex-start;
            padding: 8px 12px;
            background: #f8fafc;
            border-radius: 0 8px 8px 0;
            flex-direction: row;
        }
        .inactive-tab {
            border-bottom: none;
            border-left: 4px solid transparent;
            align-items: flex-start;
            padding: 8px 12px;
            flex-direction: row;
        }
        .actions-group {
            flex-direction: column;
        }
    }
</style>

<script src="https://cdn.omise.co/omise.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Set the public key for Omise Card (mock test key)
        OmiseCard.configure({
            publicKey: "pkey_test_5xyz999999999999999" // Mock public key
        });

        const payOmiseButton = document.getElementById("payOmiseButton");
        const omiseForm = document.getElementById("omiseForm");
        const omiseTokenInput = document.getElementById("omiseTokenInput");

        if (payOmiseButton && omiseForm) {
            payOmiseButton.addEventListener("click", function(event) {
                event.preventDefault();
                
                OmiseCard.open({
                    amount: {{ $order->total_amount * 100 }}, // Omise expects amount in satang/cents
                    currency: "THB",
                    defaultPaymentMethod: "credit_card",
                    onCreateTokenSuccess: (nonce) => {
                        // nonce is the Omise Card token
                        omiseTokenInput.value = nonce;
                        // Submit the form
                        omiseForm.dispatchEvent(new Event('submit'));
                        omiseForm.submit();
                    }
                });
            });
        }
    });
</script>
@endsection

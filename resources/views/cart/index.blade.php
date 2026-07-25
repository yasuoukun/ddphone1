@extends('layouts.store')

@section('content')
<div class="container" style="max-width: 1200px; margin: 0 auto; padding: 2rem 1rem;" x-data="{ 
    cart: {{ json_encode(session('cart', [])) }},
    selectedItems: Object.keys({{ json_encode(session('cart', [])) }}),
    updateQuantity(id, qty) {
        if(qty < 1) qty = 1;
        fetch('{{ route('cart.update') }}', {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ id: id, quantity: qty })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                this.cart[id].quantity = qty;
            }
        });
    },
    removeItem(id) {
        Swal.fire({
            title: 'ต้องการลบสินค้านี้?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'var(--color-navy)',
            cancelButtonColor: 'var(--color-danger)',
            confirmButtonText: 'ใช่, ลบเลย',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('{{ route('cart.remove') }}', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ id: id })
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        delete this.cart[id];
                        this.selectedItems = this.selectedItems.filter(item => item !== id);
                        Swal.fire({
                            title: 'ลบเรียบร้อยแล้ว!',
                            icon: 'success',
                            confirmButtonColor: 'var(--color-navy)'
                        });
                    }
                });
            }
        });
    },
    get total() {
        return Object.entries(this.cart).reduce((sum, [id, item]) => {
            if (this.selectedItems.includes(id)) {
                return sum + (item.price * item.quantity);
            }
            return sum;
        }, 0);
    }
}">
    <div style="text-align: center; margin-bottom: 2.5rem;">
        <span class="badge-yellow-fun bounce-fun" style="margin-bottom: 0.75rem;">MY SHOPPING CART</span>
        <h2 style="font-size: 2.2rem; color: var(--color-navy-dark); font-weight: 900; margin: 0.5rem 0 0;">🛒 ตะกร้าสินค้าของคุณ</h2>
    </div>

    <div style="display: flex; gap: 2rem; flex-wrap: wrap;">
        <!-- Cart Items List -->
        <div style="flex: 2 1 600px;">
            <template x-if="Object.keys(cart).length === 0">
                <div style="background: white; padding: 3.5rem 2rem; text-align: center; border-radius: 22px; border: 2px solid #E2E8F0; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                    <div style="font-size: 3.5rem; margin-bottom: 1rem;">📱</div>
                    <h3 style="font-size: 1.3rem; font-weight: 800; color: var(--color-navy-dark); margin: 0 0 0.5rem;">ไม่มีสินค้าในตะกร้า</h3>
                    <p style="color: #64748b; margin-bottom: 1.5rem; font-size: 0.95rem;">เลือกซื้อมือถือมือสองสภาพนางฟ้า รับประกัน 30 วัน ได้เลย!</p>
                    <a href="{{ route('products.index') }}" style="text-decoration: none;">
                        <button class="btn-yellow-fun">
                            <i class="fa-solid fa-mobile-screen-button"></i> เลือกซื้อมือถือมือสอง
                        </button>
                    </a>
                </div>
            </template>

            <template x-if="Object.keys(cart).length > 0">
                <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                    <template x-for="(item, id) in cart" :key="id">
                        <div class="card-fun-hover" style="background: white; border: 2px solid #E2E8F0; border-radius: 20px; padding: 1.35rem; display: flex; align-items: center; justify-content: space-between; gap: 1.5rem; flex-wrap: wrap; box-shadow: 0 4px 12px rgba(15, 23, 42, 0.03);">
                            <!-- Selection Checkbox -->
                            <div style="display: flex; align-items: center; padding-right: 5px;">
                                <input type="checkbox" :value="id" x-model="selectedItems" style="width: 22px; height: 22px; cursor: pointer; accent-color: #FF5722;">
                            </div>

                            <!-- Product Image -->
                            <div style="width: 85px; height: 85px; display: flex; align-items: center; justify-content: center; background: #F8FAFC; border-radius: 14px; border: 1px solid #FFE600; padding: 6px;">
                                <template x-if="item.image">
                                    <img :src="item.image.startsWith('http') ? item.image : '/storage/' + item.image" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                </template>
                                <template x-if="!item.image">
                                    <span style="font-size: 2rem; color: #94A3B8;">📱</span>
                                </template>
                            </div>

                            <!-- Product Info -->
                            <div style="flex: 1 1 200px;">
                                <h3 style="font-size: 1.1rem; font-weight: 800; color: var(--color-navy-dark); margin: 0 0 0.5rem;" x-text="item.name"></h3>
                                <p style="font-size: 1.25rem; font-weight: 900; color: #FF5722; margin: 0;">฿<span x-text="Number(item.price).toLocaleString()"></span></p>
                            </div>

                            <!-- Quantity Controller -->
                            <div style="display: flex; align-items: center; gap: 6px; border: 1.5px solid #FFE600; border-radius: 99px; padding: 3px 8px; background: #FFFDF0;">
                                <button @click="updateQuantity(id, item.quantity - 1)" style="border: none; background: none; width: 28px; height: 28px; font-size: 1.1rem; font-weight: 900; color: #0F172A; cursor: pointer; display: flex; align-items: center; justify-content: center;">-</button>
                                <span style="font-weight: 800; width: 28px; text-align: center; font-size: 0.95rem; color: #0F172A;" x-text="item.quantity"></span>
                                <button @click="updateQuantity(id, item.quantity + 1)" style="border: none; background: none; width: 28px; height: 28px; font-size: 1.1rem; font-weight: 900; color: #0F172A; cursor: pointer; display: flex; align-items: center; justify-content: center;">+</button>
                            </div>

                            <!-- Action -->
                            <div style="text-align: right;">
                                <button @click="removeItem(id)" style="background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3); color: #EF4444; border-radius: 8px; padding: 6px 12px; cursor: pointer; font-weight: 800; font-size: 0.85rem;">ลบออก</button>
                            </div>
                        </div>
                    </template>
                </div>
            </template>
        </div>

        <!-- Cart Summary / Order Checkout Card -->
        <template x-if="Object.keys(cart).length > 0">
            <div style="flex: 1 1 350px;">
                <div style="background: #070D1B; border: 2px solid #FFE600; border-radius: 22px; padding: 2rem; color: white; box-shadow: 0 10px 30px rgba(0,0,0,0.3); position: sticky; top: 100px;">
                    <h3 style="font-size: 1.35rem; font-weight: 900; color: #FFE600; margin-bottom: 1.5rem; border-bottom: 1px solid rgba(255,230,0,0.3); padding-bottom: 0.75rem; display: flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-receipt" style="color: #FF5722;"></i> สรุปคำสั่งซื้อ
                    </h3>
                    
                    <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; font-size: 1rem;">
                        <span style="color: #CBD5E1;">ยอดรวมสินค้า</span>
                        <span style="font-weight: 700; color: white;">฿<span x-text="total.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})"></span></span>
                    </div>

                    <div style="display: flex; justify-content: space-between; margin-bottom: 1.5rem; font-size: 1rem;">
                        <span style="color: #CBD5E1;">ค่าจัดส่งด่วน</span>
                        <span style="font-weight: 800; color: #FFE600;">จัดส่งฟรีทั่วไทย</span>
                    </div>

                    <hr style="border: 0; border-top: 1px solid rgba(255,255,255,0.1); margin-bottom: 1.5rem;">

                    <div style="display: flex; justify-content: space-between; margin-bottom: 2rem; font-size: 1.3rem; font-weight: 900;">
                        <span style="color: white;">ยอดชำระสุทธิ</span>
                        <span style="color: #FFE600;">฿<span x-text="total.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})"></span></span>
                    </div>

                    <a :href="selectedItems.length ? '{{ route('checkout.index') }}?items=' + selectedItems.join(',') : '#'"
                       @click="if(!selectedItems.length) { $event.preventDefault(); Swal.fire({icon: 'warning', title: 'กรุณาเลือกสินค้า', text: 'กรุณาเลือกสินค้าอย่างน้อย 1 ชิ้นเพื่อดำเนินชำระเงิน'}); }"
                       style="text-decoration: none; display: block;">
                        <button class="btn-yellow-fun yellow-glow" style="width: 100%; justify-content: center; font-size: 1.05rem !important; padding: 14px !important;">
                            <i class="fa-solid fa-credit-card"></i> ดำเนินการสั่งซื้อ / ชำระเงิน
                        </button>
                    </a>
                </div>
            </div>
        </template>
    </div>
</div>
@endsection

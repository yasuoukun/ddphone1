@extends('layouts.store')

@section('content')
<div class="container" x-data="{ tab: new URLSearchParams(window.location.search).get('tab') || 'profile', showReceipt: null, editAddress: null }" style="padding: 2rem 1rem; display: flex; gap: 2rem; max-width: 1200px; margin: 0 auto;">

    <!-- Left Sidebar Profile Navigation -->
    <aside style="width: 280px; flex-shrink: 0;">
        <div style="background: white; padding: 1.75rem; border-radius: 20px; border: 1px solid rgba(226, 232, 240, 0.8); box-shadow: 0 10px 30px rgba(27, 42, 71, 0.05); position: sticky; top: 100px;">
            <div style="text-align: center; margin-bottom: 2rem;">
                <div style="position: relative; width: 85px; height: 85px; margin: 0 auto 1.25rem;">
                    <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" style="width: 85px; height: 85px; border-radius: 50%; object-fit: cover; border: 3px solid var(--color-silver); box-shadow: 0 8px 20px rgba(0,0,0,0.1);">
                </div>
                <h3 style="font-size: 1.3rem; font-weight: 700; color: var(--color-navy-dark); margin-bottom: 0.35rem;">{{ auth()->user()->name }}</h3>
                <p style="font-size: 0.85rem; color: var(--color-grey-light); margin: 0; font-weight: 500;">{{ auth()->user()->email }}</p>
            </div>

            <nav style="display: flex; flex-direction: column; gap: 0.5rem;">
                <button @click="tab = 'profile'" :class="tab === 'profile' ? 'active-nav-btn' : 'inactive-nav-btn'">
                    <span>👤</span> ข้อมูลส่วนตัว
                </button>
                <button @click="tab = 'address'" :class="tab === 'address' ? 'active-nav-btn' : 'inactive-nav-btn'">
                    <span>📍</span> ที่อยู่จัดส่ง
                </button>
                <button @click="tab = 'orders'" :class="tab === 'orders' ? 'active-nav-btn' : 'inactive-nav-btn'">
                    <span>📦</span> ประวัติคำสั่งซื้อ
                </button>
                <button @click="tab = 'wishlist'" :class="tab === 'wishlist' ? 'active-nav-btn' : 'inactive-nav-btn'">
                    <span>❤️</span> สินค้าที่ชอบ
                </button>
                <button @click="tab = 'coupons'" :class="tab === 'coupons' ? 'active-nav-btn' : 'inactive-nav-btn'">
                    <span>🎟️</span> คูปองของฉัน
                </button>
                <button @click="tab = 'payment_methods'" :class="tab === 'payment_methods' ? 'active-nav-btn' : 'inactive-nav-btn'">
                    <span>💳</span> ช่องทางชำระเงิน
                </button>
                <button @click="tab = 'quotations'" :class="tab === 'quotations' ? 'active-nav-btn' : 'inactive-nav-btn'">
                    <span>📄</span> ใบเสนอราคาของฉัน
                </button>
                <button @click="tab = 'repairs'" :class="tab === 'repairs' ? 'active-nav-btn' : 'inactive-nav-btn'">
                    <span>🛠️</span> งานซ่อม/เคลมของฉัน
                </button>
                
                <hr style="border: 0; border-top: 1px solid var(--color-silver); margin: 1rem 0;">

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" style="padding: 12px; border-radius: 8px; text-decoration: none; color: var(--color-danger); font-weight: 500; display: flex; align-items: center; gap: 10px; transition: all 0.2s;" onmouseover="this.style.background='rgba(239, 68, 68, 0.08)'" onmouseout="this.style.background='transparent'">
                        <span>🚪</span> ออกจากระบบ
                    </a>
                </form>
            </nav>
        </div>
    </aside>

    <!-- Main Content Panel -->
    <div style="flex-grow: 1; background: white; padding: 2.5rem; border-radius: 20px; border: 1px solid rgba(226, 232, 240, 0.8); box-shadow: 0 10px 30px rgba(27, 42, 71, 0.04); min-height: 500px;">
        
        <!-- TAB 1: Profile Info -->
        <div x-show="tab === 'profile'">
            <h2 style="font-size: 1.6rem; color: var(--color-navy-dark); margin-bottom: 1.5rem; border-bottom: 2px solid var(--color-silver); padding-bottom: 0.75rem; font-weight: 700;">ข้อมูลส่วนตัว</h2>
            
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" style="max-width: 600px;">
                @csrf
                @method('patch')

                <!-- Avatar Upload Section -->
                <div style="margin-bottom: 1.75rem; display: flex; align-items: center; gap: 20px;">
                    <img id="avatar-preview" src="{{ auth()->user()->avatar_url }}" alt="Profile Avatar" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 2px solid var(--color-silver);">
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 0.35rem; color: var(--color-navy-dark); font-size: 0.95rem;">รูปภาพโปรไฟล์</label>
                        <input type="file" name="avatar" accept="image/*" onchange="if(this.files[0]) document.getElementById('avatar-preview').src = URL.createObjectURL(this.files[0])" style="font-size: 0.85rem; color: var(--color-grey);">
                        <p style="margin: 4px 0 0; font-size: 0.75rem; color: #94a3b8;">แนะนำเป็นรูปภาพสี่เหลี่ยมจัตุรัส ขนาดไม่เกิน 4MB (JPG, PNG, WEBP)</p>
                    </div>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--color-navy-dark); font-size: 0.95rem;">ชื่อ-นามสกุล</label>
                    <input type="text" name="name" value="{{ auth()->user()->name }}" required style="width: 100%; padding: 12px; border: 1px solid var(--color-silver); border-radius: 8px; font-family: inherit; font-size: 1rem; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--color-navy)'" onblur="this.style.borderColor='var(--color-silver)'">
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--color-navy-dark); font-size: 0.95rem;">อีเมล</label>
                    <input type="email" name="email" value="{{ auth()->user()->email }}" required style="width: 100%; padding: 12px; border: 1px solid var(--color-silver); border-radius: 8px; font-family: inherit; font-size: 1rem; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--color-navy)'" onblur="this.style.borderColor='var(--color-silver)'">
                </div>

                <div style="margin-bottom: 2rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--color-navy-dark); font-size: 0.95rem;">เบอร์โทรศัพท์ติดต่อ</label>
                    <input type="text" name="phone" value="{{ auth()->user()->phone }}" placeholder="เช่น 0812345678" style="width: 100%; padding: 12px; border: 1px solid var(--color-silver); border-radius: 8px; font-family: inherit; font-size: 1rem; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--color-navy)'" onblur="this.style.borderColor='var(--color-silver)'">
                </div>

                <button type="submit" style="padding: 12px 30px; background: linear-gradient(135deg, var(--color-navy) 0%, var(--color-navy-light) 100%); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; box-shadow: 0 4px 10px rgba(27, 42, 71, 0.25); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='translateY(0)'">
                    บันทึกการเปลี่ยนแปลง
                </button>
            </form>
        </div>

        <!-- TAB 2: Addresses -->
        <div x-show="tab === 'address'" style="display: none;">
            <h2 style="font-size: 1.6rem; color: var(--color-navy-dark); margin-bottom: 1.5rem; border-bottom: 2px solid var(--color-silver); padding-bottom: 0.75rem; font-weight: 700;">ที่อยู่จัดส่ง</h2>
            
            <div style="display: grid; grid-template-columns: 1fr; gap: 1.5rem; margin-bottom: 2.5rem;">
                @forelse($addresses as $addr)
                <div style="border: 1px solid var(--color-silver); padding: 1.25rem; border-radius: 8px; display: flex; justify-content: space-between; align-items: flex-start; background: var(--color-grey-bg);">
                    <div>
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 0.5rem;">
                            <span style="font-weight: 600; color: var(--color-navy-dark);">ที่อยู่จัดส่ง</span>
                            @if($addr->is_main)
                            <span style="background: var(--color-navy); color: white; font-size: 0.75rem; padding: 2px 8px; border-radius: 12px; font-weight: 500;">หลัก</span>
                            @endif
                        </div>
                        <p style="margin: 0 0 0.25rem; color: var(--color-navy-dark);">{{ $addr->address_line }}</p>
                        <p style="margin: 0; font-size: 0.9rem; color: var(--color-grey);">{{ $addr->subdistrict }}, {{ $addr->district }}, {{ $addr->province }}, {{ $addr->postal_code }}</p>
                        <p style="margin: 0.5rem 0 0; font-size: 0.9rem; color: var(--color-navy-dark);"><strong>เบอร์โทร:</strong> {{ $addr->phone }}</p>
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 8px; align-items: flex-end;">
                        <button @click="editAddress = { id: {{ $addr->id }}, address_line: '{{ addslashes($addr->address_line) }}', subdistrict: '{{ addslashes($addr->subdistrict) }}', district: '{{ addslashes($addr->district) }}', province: '{{ addslashes($addr->province) }}', postal_code: '{{ $addr->postal_code }}', phone: '{{ $addr->phone }}' }; window.scrollTo({top: document.body.scrollHeight, behavior: 'smooth'});" style="background: none; border: none; color: var(--color-navy); cursor: pointer; font-size: 0.9rem; font-weight: 600; text-decoration: underline;">แก้ไขที่อยู่</button>
                        
                        @if(!$addr->is_main)
                        <form action="{{ route('customer.addresses.set_main', $addr) }}" method="POST" style="margin: 0;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" style="background: none; border: none; color: var(--color-accent); cursor: pointer; font-size: 0.9rem; font-weight: 600; text-decoration: underline; padding: 0;">ตั้งเป็นที่อยู่หลัก</button>
                        </form>
                        @endif
                        <form action="{{ route('customer.addresses.destroy', $addr) }}" method="POST" style="margin: 0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; border: none; color: var(--color-danger); cursor: pointer; font-size: 0.9rem; font-weight: 600; padding: 0;">ลบ</button>
                        </form>
                    </div>
                </div>
                @empty
                <p style="color: var(--color-grey);">ยังไม่มีที่อยู่จัดส่งที่บันทึกไว้</p>
                @endforelse
            </div>

            <hr style="border: 0; border-top: 1px solid var(--color-silver); margin: 2rem 0;">

            <!-- Add Address Form -->
            <div x-show="!editAddress">
                <h3 style="font-size: 1.25rem; color: var(--color-navy-dark); margin-bottom: 1.25rem; font-weight: 600;">เพิ่มที่อยู่ใหม่</h3>
                <form action="{{ route('customer.addresses.store') }}" method="POST" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    @csrf
                    <div style="grid-column: span 2;">
                        <label style="display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 0.35rem;">ที่อยู่ (บ้านเลขที่, ถนน, ซอย)</label>
                        <input type="text" name="address_line" required style="width: 100%; padding: 10px; border: 1px solid var(--color-silver); border-radius: 6px;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 0.35rem;">แขวง/ตำบล</label>
                        <input type="text" name="subdistrict" required style="width: 100%; padding: 10px; border: 1px solid var(--color-silver); border-radius: 6px;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 0.35rem;">เขต/อำเภอ</label>
                        <input type="text" name="district" required style="width: 100%; padding: 10px; border: 1px solid var(--color-silver); border-radius: 6px;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 0.35rem;">จังหวัด</label>
                        <input type="text" name="province" required style="width: 100%; padding: 10px; border: 1px solid var(--color-silver); border-radius: 6px;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 0.35rem;">รหัสไปรษณีย์</label>
                        <input type="text" name="postal_code" required style="width: 100%; padding: 10px; border: 1px solid var(--color-silver); border-radius: 6px;">
                    </div>
                    <div style="grid-column: span 2;">
                        <label style="display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 0.35rem;">เบอร์โทรศัพท์ติดต่อ</label>
                        <input type="text" name="phone" required style="width: 100%; padding: 10px; border: 1px solid var(--color-silver); border-radius: 6px;">
                    </div>
                    <div style="grid-column: span 2; margin-top: 1rem;">
                        <button type="submit" style="padding: 10px 24px; background: var(--color-navy); color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer;">เพิ่มที่อยู่</button>
                    </div>
                </form>
            </div>

            <!-- Edit Address Form -->
            <div x-show="editAddress" style="display: none;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
                    <h3 style="font-size: 1.25rem; color: var(--color-navy-dark); font-weight: 600; margin: 0;">แก้ไขข้อมูลที่อยู่</h3>
                    <button @click="editAddress = null" style="background: none; border: none; color: var(--color-danger); cursor: pointer; font-weight: 600; font-size: 0.95rem; padding: 0;">ยกเลิกการแก้ไข</button>
                </div>
                <form :action="'{{ route('customer.addresses.store') }}/' + editAddress?.id" method="POST" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    @csrf
                    @method('PUT')
                    <div style="grid-column: span 2;">
                        <label style="display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 0.35rem;">ที่อยู่ (บ้านเลขที่, ถนน, ซอย)</label>
                        <input type="text" name="address_line" x-model="editAddress.address_line" required style="width: 100%; padding: 10px; border: 1px solid var(--color-silver); border-radius: 6px;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 0.35rem;">แขวง/ตำบล</label>
                        <input type="text" name="subdistrict" x-model="editAddress.subdistrict" required style="width: 100%; padding: 10px; border: 1px solid var(--color-silver); border-radius: 6px;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 0.35rem;">เขต/อำเภอ</label>
                        <input type="text" name="district" x-model="editAddress.district" required style="width: 100%; padding: 10px; border: 1px solid var(--color-silver); border-radius: 6px;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 0.35rem;">จังหวัด</label>
                        <input type="text" name="province" x-model="editAddress.province" required style="width: 100%; padding: 10px; border: 1px solid var(--color-silver); border-radius: 6px;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 0.35rem;">รหัสไปรษณีย์</label>
                        <input type="text" name="postal_code" x-model="editAddress.postal_code" required style="width: 100%; padding: 10px; border: 1px solid var(--color-silver); border-radius: 6px;">
                    </div>
                    <div style="grid-column: span 2;">
                        <label style="display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 0.35rem;">เบอร์โทรศัพท์ติดต่อ</label>
                        <input type="text" name="phone" x-model="editAddress.phone" required style="width: 100%; padding: 10px; border: 1px solid var(--color-silver); border-radius: 6px;">
                    </div>
                    <div style="grid-column: span 2; margin-top: 1rem; display: flex; gap: 10px;">
                        <button type="submit" style="padding: 10px 24px; background: var(--color-navy); color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer;">บันทึกการแก้ไข</button>
                        <button type="button" @click="editAddress = null" style="padding: 10px 24px; background: #cbd5e0; color: #4a5568; border: none; border-radius: 6px; font-weight: 600; cursor: pointer;">ยกเลิก</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- TAB 3: Orders History -->
        <div x-show="tab === 'orders'" style="display: none;">
            <h2 style="font-size: 1.6rem; color: var(--color-navy-dark); margin-bottom: 1.5rem; border-bottom: 2px solid var(--color-silver); padding-bottom: 0.75rem; font-weight: 700;">ประวัติคำสั่งซื้อ</h2>
            
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                @forelse($orders as $order)
                <div style="border: 1px solid var(--color-silver); border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.02); background: white;">
                    <!-- Order Header -->
                    <div style="background: var(--color-grey-bg); padding: 1rem 1.5rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--color-silver); flex-wrap: wrap; gap: 10px;">
                        <div>
                            <span style="font-size: 0.85rem; color: var(--color-grey);">คำสั่งซื้อ</span>
                            <h4 style="margin: 0; font-size: 1rem; color: var(--color-navy-dark); font-weight: 700;">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h4>
                        </div>
                        <div style="text-align: right;">
                            <span style="font-size: 0.85rem; color: var(--color-grey);">วันที่สั่งซื้อ</span>
                            <p style="margin: 0; font-size: 0.95rem; color: var(--color-navy-dark); font-weight: 600;">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <span style="display: inline-block; padding: 4px 12px; border-radius: 15px; font-size: 0.8rem; font-weight: 600; text-transform: uppercase; color: white; background: {{ $order->status == 'pending' ? 'var(--color-warning)' : ($order->status == 'pending_verification' ? '#3182ce' : ($order->status == 'confirmed' ? 'var(--color-navy-light)' : ($order->status == 'shipped' ? 'var(--color-accent)' : ($order->status == 'delivered' ? 'var(--color-success)' : 'var(--color-danger)')))) }}">
                                {{ $order->status == 'pending' ? 'รอชำระเงิน' : ($order->status == 'pending_verification' ? 'รอตรวจสอบการชำระเงิน' : ($order->status == 'confirmed' ? 'ยืนยันออเดอร์' : ($order->status == 'shipped' ? 'กำลังจัดส่ง' : ($order->status == 'delivered' ? 'ส่งมอบแล้ว' : 'ยกเลิก')))) }}
                            </span>
                        </div>
                    </div>
                    @if($order->tracking_number)
                    <div style="background: rgba(27, 42, 71, 0.04); border-bottom: 1px solid var(--color-silver-light); padding: 0.75rem 1.5rem; display: flex; align-items: center; justify-content: space-between; gap: 10px; flex-wrap: wrap;">
                        <span style="font-size: 0.9rem; color: var(--color-navy-dark); font-weight: 600;">
                            🚚 ข้อมูลการจัดส่ง: <span style="color: var(--color-accent);">{{ $order->shipping_courier ?? 'ขนส่งทั่วไป' }}</span>
                        </span>
                        <span style="font-size: 0.9rem; color: var(--color-navy-dark); font-weight: 600;">
                            เลขพัสดุ: <strong style="font-family: monospace; letter-spacing: 0.5px; font-size: 0.95rem; color: #FF4500;">{{ $order->tracking_number }}</strong>
                        </span>
                    </div>
                    @endif
                    <!-- Order Items -->
                    <div style="padding: 1.5rem;">
                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            @foreach($order->items as $item)
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <h5 style="margin: 0 0 0.25rem; font-size: 1rem; color: var(--color-navy-dark);">{{ $item->product->name ?? 'สินค้าถูกลบออกจากระบบ' }}</h5>
                                    <span style="font-size: 0.85rem; color: var(--color-grey);">จำนวน: {{ $item->quantity }} ชิ้น</span>
                                </div>
                                <span style="font-weight: 600; color: var(--color-navy-dark);">฿{{ number_format($item->price * $item->quantity, 2) }}</span>
                            </div>
                            @endforeach
                        </div>
                        <hr style="border: 0; border-top: 1px solid var(--color-silver); margin: 1.5rem 0;">
                        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                            <div>
                                @if($order->status == 'pending')
                                    <div style="display: flex; gap: 10px;">
                                        <a href="{{ route('checkout.pay', $order->id) }}" style="text-decoration: none; display: inline-block; background: #FF4500; color: white; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 600; cursor: pointer; font-family: 'Prompt', sans-serif; transition: background 0.2s;" onmouseover="this.style.background='#D03400'" onmouseout="this.style.background='#FF4500'">
                                            💳 ชำระเงิน / อัปโหลดสลิป
                                        </a>
                                        <form action="{{ route('orders.cancel', $order->id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการยกเลิกคำสั่งซื้อนี้?');">
                                            @csrf
                                            <button type="submit" style="background: white; border: 1px solid var(--color-danger); color: var(--color-danger); padding: 8px 16px; border-radius: 8px; font-weight: 600; cursor: pointer; font-family: 'Prompt', sans-serif; transition: all 0.2s;" onmouseover="this.style.background='var(--color-danger)'; this.style.color='white';" onmouseout="this.style.background='white'; this.style.color='var(--color-danger)';">
                                                ❌ ยกเลิกคำสั่งซื้อ
                                            </button>
                                        </form>
                                    </div>
                                @elseif($order->status == 'pending_verification')
                                    <button disabled style="background: var(--color-grey-light); color: white; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 600; cursor: not-allowed; font-family: 'Prompt', sans-serif;">
                                        ⏳ อยู่ระหว่างตรวจสอบการชำระเงิน
                                    </button>
                                @else
                                    <button @click="showReceipt = {{ $order->id }}" style="background: white; border: 1px solid var(--color-navy); color: var(--color-navy); padding: 8px 16px; border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px; font-family: 'Prompt', sans-serif;" onmouseover="this.style.background='var(--color-grey-bg)'" onmouseout="this.style.background='white'">
                                        🧾 ดูใบเสร็จรับเงิน
                                    </button>
                                @endif
                            </div>
                            <div style="text-align: right;">
                                <span style="font-weight: 600; color: var(--color-grey); font-size: 0.9rem;">ยอดชำระสุทธิ:</span>
                                <span style="font-size: 1.3rem; font-weight: 700; color: var(--color-accent); display: block;">฿{{ number_format($order->total_amount, 2) }}</span>
                            </div>
                        </div>

                        <!-- Modal for receipt -->
                        <div x-show="showReceipt === {{ $order->id }}" style="position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 9999; display: flex; align-items: center; justify-content: center; padding: 1rem;" x-cloak>
                            <div @click.away="showReceipt = null" style="background: white; border-radius: 16px; padding: 2.5rem; max-width: 600px; width: 100%; box-shadow: 0 20px 50px rgba(0,0,0,0.3); font-family: 'Prompt', sans-serif; position: relative; max-height: 90vh; overflow-y: auto;">
                                
                                <!-- Close Button -->
                                <button @click="showReceipt = null" style="position: absolute; top: 1.5rem; right: 1.5rem; background: none; border: none; font-size: 1.5rem; cursor: pointer; color: var(--color-grey);">&times;</button>
                                
                                <!-- Receipt Content -->
                                <div id="receipt-print-{{ $order->id }}" style="color: #333; text-align: left;">
                                    <div style="text-align: center; border-bottom: 2px dashed var(--color-silver); padding-bottom: 1.5rem; margin-bottom: 1.5rem;">
                                        <h3 style="margin: 0; font-size: 2rem; font-weight: 900; color: var(--color-navy); letter-spacing: 1px;">DDPHONE ดีดีโฟน</h3>
                                        <p style="margin: 5px 0 0; color: var(--color-grey); font-size: 0.95rem; font-weight: 500;">ใบเสร็จรับเงิน / Receipt</p>
                                        <div style="margin-top: 10px; font-size: 0.85rem; color: var(--color-grey);">
                                            <p style="margin: 2px 0;">เลขที่ใบสั่งซื้อ: #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
                                            <p style="margin: 2px 0;">วันที่สั่งซื้อ: {{ $order->created_at->format('d/m/Y H:i') }} น.</p>
                                            <p style="margin: 2px 0;">สถานะชำระเงิน: <span style="color: var(--color-success); font-weight: 600;">ชำระเงินสำเร็จ</span></p>
                                        </div>
                                    </div>
                                    
                                    <div style="margin-bottom: 1.5rem; background: var(--color-grey-bg); padding: 1rem; border-radius: 8px; border: 1px solid var(--color-silver-light);">
                                        <h5 style="margin: 0 0 0.5rem; font-size: 0.95rem; color: var(--color-navy-dark); font-weight: 700;">ที่อยู่จัดส่ง:</h5>
                                        <p style="margin: 0; font-size: 0.9rem; color: #555; line-height: 1.5;">{{ $order->shipping_info }}</p>
                                    </div>

                                    @if($order->tracking_number)
                                    <div style="margin-bottom: 1.5rem; background: rgba(27, 42, 71, 0.03); padding: 1rem; border-radius: 8px; border: 1px solid var(--color-silver-light);">
                                        <h5 style="margin: 0 0 0.5rem; font-size: 0.95rem; color: var(--color-navy-dark); font-weight: 700;">ข้อมูลการจัดส่ง:</h5>
                                        <p style="margin: 0 0 0.25rem; font-size: 0.9rem; color: #555;"><strong>ผู้ให้บริการ:</strong> {{ $order->shipping_courier ?? 'ขนส่งทั่วไป' }}</p>
                                        <p style="margin: 0; font-size: 0.9rem; color: #555;"><strong>เลขพัสดุ:</strong> <span style="font-family: monospace; color: #FF4500; font-weight: bold;">{{ $order->tracking_number }}</span></p>
                                    </div>
                                    @endif

                                    <div style="margin-bottom: 1.5rem;">
                                        <h5 style="margin: 0 0 0.75rem; font-size: 0.95rem; color: var(--color-navy-dark); font-weight: 700;">รายการสินค้า:</h5>
                                        <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
                                            <thead>
                                                <tr style="border-bottom: 2px solid var(--color-silver); text-align: left;">
                                                    <th style="padding: 8px 0; color: var(--color-navy-dark); font-weight: 600;">สินค้า</th>
                                                    <th style="padding: 8px 0; text-align: center; color: var(--color-navy-dark); width: 60px; font-weight: 600;">จำนวน</th>
                                                    <th style="padding: 8px 0; text-align: right; color: var(--color-navy-dark); width: 100px; font-weight: 600;">ราคา</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $subTotal = 0; @endphp
                                                @foreach($order->items as $item)
                                                @php $subTotal += $item->price * $item->quantity; @endphp
                                                <tr style="border-bottom: 1px solid var(--color-silver-light);">
                                                    <td style="padding: 10px 0; color: var(--color-navy-dark);">{{ $item->product->name ?? 'สินค้าถูกลบออกจากระบบ' }}</td>
                                                    <td style="padding: 10px 0; text-align: center; color: #666;">{{ $item->quantity }}</td>
                                                    <td style="padding: 10px 0; text-align: right; font-weight: 600; color: var(--color-navy-dark);">฿{{ number_format($item->price * $item->quantity, 2) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div style="border-top: 1.5px solid var(--color-silver); padding-top: 1rem; display: flex; flex-direction: column; gap: 8px; font-size: 0.95rem;">
                                        <div style="display: flex; justify-content: space-between;">
                                            <span style="color: #666;">ยอดรวมสินค้า:</span>
                                            <span style="font-weight: 600; color: var(--color-navy-dark);">฿{{ number_format($subTotal, 2) }}</span>
                                        </div>
                                        @if($order->coupon_code)
                                        <div style="display: flex; justify-content: space-between; color: var(--color-danger);">
                                            <span>ส่วนลดคูปอง ({{ $order->coupon_code }}):</span>
                                            <span style="font-weight: 600;">-฿{{ number_format($order->discount_amount, 2) }}</span>
                                        </div>
                                        @endif
                                        <div style="display: flex; justify-content: space-between;">
                                            <span style="color: #666;">ค่าจัดส่ง:</span>
                                            <span style="font-weight: 600; color: var(--color-success);">ฟรี</span>
                                        </div>
                                        <div style="display: flex; justify-content: space-between; font-size: 1.3rem; font-weight: 700; border-top: 2px dashed var(--color-silver); padding-top: 0.75rem; margin-top: 5px;">
                                            <span style="color: var(--color-navy-dark);">ยอดสุทธิ:</span>
                                            <span style="color: var(--color-accent);">฿{{ number_format($order->total_amount, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Action buttons -->
                                <div style="margin-top: 2.5rem; display: flex; gap: 12px; justify-content: flex-end;">
                                    <button @click="const printContent = document.getElementById('receipt-print-{{ $order->id }}').innerHTML; const originalContent = document.body.innerHTML; document.body.innerHTML = printContent; window.print(); document.body.innerHTML = originalContent; window.location.reload();" 
                                            style="background: var(--color-navy); color: white; border: none; padding: 10px 22px; border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px; font-family: 'Prompt', sans-serif;">
                                        🖨️ พิมพ์ใบเสร็จ
                                    </button>
                                    <button @click="showReceipt = null" style="background: var(--color-grey-light); color: white; border: none; padding: 10px 22px; border-radius: 8px; font-weight: 600; cursor: pointer; font-family: 'Prompt', sans-serif;">
                                        ปิดหน้าต่าง
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <p style="color: var(--color-grey); text-align: center; padding: 2rem 0;">ไม่มีรายการประวัติสั่งซื้อ</p>
                @endforelse
            </div>
        </div>

        <!-- TAB 4: Wishlist -->
        <div x-show="tab === 'wishlist'" style="display: none;">
            <h2 style="font-size: 1.6rem; color: var(--color-navy-dark); margin-bottom: 1.5rem; border-bottom: 2px solid var(--color-silver); padding-bottom: 0.75rem; font-weight: 700;">สินค้าที่ชอบ</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px;">
                @forelse($wishlists as $wl)
                    @if($wl->product)
                    <div style="background: white; border: 1px solid var(--color-silver); border-radius: 8px; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between; position: relative;">
                        <form action="{{ route('wishlist.toggle', $wl->product_id) }}" method="POST" style="position: absolute; top: 10px; right: 10px; z-index: 10;">
                            @csrf
                            <button type="submit" style="background: white; border: none; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 5px rgba(0,0,0,0.15); cursor: pointer; color: red;">❤️</button>
                        </form>
                        <a href="{{ route('products.show', $wl->product_id) }}" style="text-decoration: none; color: inherit; display: block; padding: 1rem; text-align: center;">
                            @if($wl->product->images->where('is_primary', true)->first())
                                @php $wlImg = $wl->product->images->where('is_primary', true)->first()->image_path; @endphp
                                <img src="{{ str_starts_with($wlImg, 'http') ? $wlImg : Storage::url($wlImg) }}" alt="{{ $wl->product->name }}" style="max-width: 100%; height: 120px; object-fit: contain;">
                            @else
                                <div style="width: 100%; height: 120px; background: #eee; display: flex; align-items: center; justify-content: center; color: #999;">No Image</div>
                            @endif
                        </a>
                        <div style="padding: 1rem; border-top: 1px solid var(--color-silver-light);">
                            <h4 style="font-size: 0.95rem; margin: 0 0 0.5rem; color: var(--color-navy-dark); font-weight: 600; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">{{ $wl->product->name }}</h4>
                            <span style="font-size: 1rem; font-weight: 700; color: var(--color-accent);">฿{{ number_format($wl->product->price, 2) }}</span>
                        </div>
                    </div>
                    @endif
                @empty
                <div style="grid-column: span 4; text-align: center; color: var(--color-grey); padding: 3rem 0;">ยังไม่มีสินค้าที่ชื่นชอบ</div>
                @endforelse
            </div>
        </div>

        <!-- TAB 5: My Coupons -->
        <div x-show="tab === 'coupons'" style="display: none;">
            <h2 style="font-size: 1.6rem; color: var(--color-navy-dark); margin-bottom: 1.5rem; border-bottom: 2px solid var(--color-silver); padding-bottom: 0.75rem; font-weight: 700;">คูปองของฉัน</h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
                @forelse($collectedCoupons as $cc)
                    @php
                        $c = $cc->coupon;
                        $isValid = \Carbon\Carbon::parse($c->expires_at)->isFuture();
                    @endphp
                    <div style="background: white; border: 1px solid var(--color-silver); border-radius: 12px; display: flex; flex-direction: column; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.02); opacity: {{ $cc->is_used || !$isValid ? '0.6' : '1' }}; border-left: 6px solid {{ $cc->is_used || !$isValid ? '#cbd5e0' : '#FF4500' }};">
                        <div style="padding: 1.25rem;">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem;">
                                <h4 style="margin: 0; font-size: 1rem; font-weight: bold; color: var(--color-navy-dark);">{{ $c->name }}</h4>
                                <span style="font-size: 0.75rem; padding: 2px 8px; border-radius: 10px; font-weight: bold; background: {{ $cc->is_used ? '#edf2f7' : ($isValid ? 'rgba(255, 69, 0, 0.1)' : '#fee2e2') }}; color: {{ $cc->is_used ? '#718096' : ($isValid ? '#FF4500' : '#ef4444') }};">
                                    {{ $cc->is_used ? 'ใช้แล้ว' : ($isValid ? 'ใช้งานได้' : 'หมดอายุ') }}
                                </span>
                            </div>
                            
                            <p style="margin: 0.5rem 0; font-size: 1.4rem; font-weight: 800; color: #FF4500;">
                                ส่วนลด ฿{{ number_format($c->discount_amount, 0) }}
                            </p>
                            
                            <p style="margin: 0; font-size: 0.85rem; color: var(--color-grey);">
                                @if($c->product)
                                    เฉพาะสินค้า: <strong style="color: var(--color-navy-dark);">{{ $c->product->name }}</strong>
                                @else
                                    ใช้ได้กับสินค้าทุกชิ้นในร้าน
                                @endif
                            </p>
                        </div>
                        
                        <div style="background: var(--color-grey-bg); padding: 10px 1.25rem; border-top: 1px solid var(--color-silver-light); display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-family: monospace; font-size: 0.9rem; font-weight: bold; color: var(--color-navy-dark);">{{ $c->code }}</span>
                            <span style="font-size: 0.75rem; color: var(--color-grey);">
                                หมดอายุ: {{ \Carbon\Carbon::parse($c->expires_at)->format('d/m/Y H:i') }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div style="grid-column: span 3; text-align: center; color: var(--color-grey); padding: 3rem 0;">
                        🎟️ ยังไม่มีคูปองที่เก็บสะสมไว้
                    </div>
                @endforelse
            </div>
        </div>

        <!-- TAB 6: Payment Methods -->
        <div x-show="tab === 'payment_methods'" style="display: none;">
            <h2 style="font-size: 1.6rem; color: var(--color-navy-dark); margin-bottom: 1.5rem; border-bottom: 2px solid var(--color-silver); padding-bottom: 0.75rem; font-weight: 700;">ช่องทางชำระเงินของฉัน</h2>
            
            <div style="display: grid; grid-template-columns: 1fr; gap: 1.5rem; margin-bottom: 2.5rem;">
                @forelse($paymentMethods as $pm)
                <div style="border: 1px solid var(--color-silver); padding: 1.25rem; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; background: var(--color-grey-bg);">
                    <div>
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 0.5rem;">
                            <span style="font-weight: 700; color: var(--color-navy-dark); font-size: 1.05rem;">
                                {{ $pm->provider }}
                            </span>
                            @if($pm->is_default)
                            <span style="background: var(--color-navy); color: white; font-size: 0.75rem; padding: 2px 8px; border-radius: 12px; font-weight: 500;">บัญชีหลัก</span>
                            @endif
                        </div>
                        <p style="margin: 0 0 0.25rem; color: var(--color-navy-dark); font-size: 0.95rem;">
                            <strong>ชื่อบัญชี:</strong> {{ $pm->account_name }}
                        </p>
                        <p style="margin: 0; font-size: 0.95rem; color: var(--color-navy-dark);">
                            <strong>เลขบัญชี:</strong> {{ $pm->account_number }}
                        </p>
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 8px; align-items: flex-end;">
                        @if(!$pm->is_default)
                        <form action="{{ route('customer.payment_methods.set_default', $pm) }}" method="POST" style="margin: 0;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" style="background: none; border: none; color: var(--color-accent); cursor: pointer; font-size: 0.9rem; font-weight: 600; text-decoration: underline; padding: 0;">ตั้งเป็นบัญชีหลัก</button>
                        </form>
                        @endif
                        <form action="{{ route('customer.payment_methods.destroy', $pm) }}" method="POST" style="margin: 0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; border: none; color: var(--color-danger); cursor: pointer; font-size: 0.9rem; font-weight: 600; padding: 0;">ลบบัญชี</button>
                        </form>
                    </div>
                </div>
                @empty
                <p style="color: var(--color-grey);">ยังไม่มีบัญชีชำระเงินที่บันทึกไว้</p>
                @endforelse
            </div>

            <hr style="border: 0; border-top: 1px solid var(--color-silver); margin: 2rem 0;">

            <h3 style="font-size: 1.25rem; color: var(--color-navy-dark); margin-bottom: 1.25rem; font-weight: 600;">ผูกบัญชีชำระเงินใหม่</h3>
            <form action="{{ route('customer.payment_methods.store') }}" method="POST" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; max-width: 600px;">
                @csrf
                <div style="grid-column: span 2;">
                    <label style="display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 0.35rem;">ธนาคาร / ผู้ให้บริการ</label>
                    <select name="provider" required style="width: 100%; padding: 10px; border: 1px solid var(--color-silver); border-radius: 6px; background: white; font-family: inherit; font-size: 0.95rem;">
                        <option value="">เลือกธนาคาร</option>
                        <option value="ธนาคารกสิกรไทย (KBANK)">ธนาคารกสิกรไทย (KBANK)</option>
                        <option value="ธนาคารไทยพาณิชย์ (SCB)">ธนาคารไทยพาณิชย์ (SCB)</option>
                        <option value="ธนาคารกรุงเทพ (BBL)">ธนาคารกรุงเทพ (BBL)</option>
                        <option value="ธนาคารกรุงไทย (KTB)">ธนาคารกรุงไทย (KTB)</option>
                        <option value="ธนาคารกรุงศรีอยุธยา (BAY)">ธนาคารกรุงศรีอยุธยา (BAY)</option>
                        <option value="ธนาคารทหารไทยธนชาต (TTB)">ธนาคารทหารไทยธนชาต (TTB)</option>
                        <option value="ธนาคารออมสิน (GSB)">ธนาคารออมสิน (GSB)</option>
                        <option value="พร้อมเพย์ (PromptPay)">พร้อมเพย์ (PromptPay)</option>
                    </select>
                </div>
                <div style="grid-column: span 2;">
                    <label style="display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 0.35rem;">ชื่อบัญชี (ภาษาไทย หรือ ภาษาอังกฤษตามหน้าสมุดบัญชี)</label>
                    <input type="text" name="account_name" placeholder="นาย/นาง/นางสาว..." required style="width: 100%; padding: 10px; border: 1px solid var(--color-silver); border-radius: 6px; font-family: inherit; font-size: 0.95rem;">
                </div>
                <div style="grid-column: span 2;">
                    <label style="display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 0.35rem;">เลขที่บัญชี หรือ เบอร์โทรศัพท์พร้อมเพย์</label>
                    <input type="text" name="account_number" placeholder="xxx-x-xxxxx-x หรือ เบอร์พร้อมเพย์ 10 หลัก" required style="width: 100%; padding: 10px; border: 1px solid var(--color-silver); border-radius: 6px; font-family: inherit; font-size: 0.95rem;">
                </div>
                <div style="grid-column: span 2; margin-top: 1rem;">
                    <button type="submit" style="padding: 10px 24px; background: var(--color-navy); color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; font-family: inherit; font-size: 0.95rem;">ผูกบัญชีธนาคาร</button>
                </div>
            </form>
        </div>

        <!-- TAB 7: Quotations -->
        <div x-show="tab === 'quotations'" style="display: none;">
            <h2 style="font-size: 1.6rem; color: var(--color-navy-dark); margin-bottom: 1.5rem; border-bottom: 2px solid var(--color-silver); padding-bottom: 0.75rem; font-weight: 700;">ใบเสนอราคาของฉัน</h2>
            
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                @forelse($quotations as $quote)
                <div style="border: 1px solid var(--color-silver); padding: 1.5rem; border-radius: 12px; background: var(--color-grey-bg); display: flex; flex-direction: column; gap: 1rem; box-shadow: 0 2px 5px rgba(0,0,0,0.02);">
                    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--color-silver); padding-bottom: 0.75rem; flex-wrap: wrap; gap: 10px;">
                        <div>
                            <span style="font-size: 0.85rem; color: var(--color-grey); font-weight: 500;">เลขที่ใบเสนอราคา</span>
                            <h4 style="margin: 2px 0 0; color: var(--color-navy-dark); font-size: 1.1rem; font-weight: 700;">{{ $quote->quote_no }}</h4>
                        </div>
                        <div style="text-align: right;">
                            <span style="font-size: 0.85rem; color: var(--color-grey); font-weight: 500;">วันที่ออกเอกสาร</span>
                            <p style="margin: 2px 0 0; color: var(--color-navy-dark); font-weight: 600; font-size: 0.95rem;">{{ $quote->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; font-size: 0.9rem;">
                        <div>
                            <p style="margin: 0; color: var(--color-grey);">ชื่อผู้ติดต่อ: <strong style="color: var(--color-navy-dark);">{{ $quote->cust_name }}</strong></p>
                            @if($quote->cust_org)
                            <p style="margin: 4px 0 0; color: var(--color-grey);">หน่วยงาน: <strong style="color: var(--color-navy-dark);">{{ $quote->cust_org }}</strong></p>
                            @endif
                        </div>
                        <div>
                            <p style="margin: 0; color: var(--color-grey);">เบอร์โทรศัพท์: <strong style="color: var(--color-navy-dark);">{{ $quote->cust_phone ?? '-' }}</strong></p>
                            <p style="margin: 4px 0 0; color: var(--color-grey);">ยอดสุทธิ: <strong style="color: var(--color-accent); font-size: 1.05rem;">฿{{ number_format($quote->net_total, 2) }}</strong></p>
                        </div>
                        <div>
                            <p style="margin: 0; color: var(--color-grey);">สถานะ: 
                                @if($quote->status === 'pending')
                                <span style="background: #fef3c7; color: #d97706; padding: 3px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">รอการตรวจสอบ</span>
                                @elseif($quote->status === 'approved')
                                <span style="background: #d1fae5; color: #059669; padding: 3px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">อนุมัติแล้ว</span>
                                @elseif($quote->status === 'rejected')
                                <span style="background: #fee2e2; color: #dc2626; padding: 3px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">ไม่อนุมัติ</span>
                                @elseif($quote->status === 'ordered')
                                <span style="background: #e0f2fe; color: #0284c7; padding: 3px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">สั่งซื้อแล้ว</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    <div style="border-top: 1px solid var(--color-silver-light); padding-top: 0.75rem; display: flex; justify-content: flex-end; gap: 10px;">
                        <a href="{{ route('quotation.generate') }}?items={{ collect($quote->items)->pluck('id')->join(',') }}" style="padding: 8px 16px; background: white; border: 1px solid var(--color-navy); color: var(--color-navy); text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 5px; transition: all 0.2s;" onmouseover="this.style.background='var(--color-navy)'; this.style.color='white'" onmouseout="this.style.background='white'; this.style.color='var(--color-navy)'">
                            🔄 ทำใบเสนอราคาใหม่
                        </a>
                        <button @click="window.open('{{ route('quotation.generate') }}?items={{ collect($quote->items)->pluck('id')->join(',') }}', '_blank')" style="padding: 8px 16px; background: linear-gradient(135deg, var(--color-navy) 0%, var(--color-navy-light) 100%); color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 0.85rem; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                            🖨️ เปิดพิมพ์ / ดาวน์โหลด PDF
                        </button>
                    </div>
                </div>
                @empty
                <div style="text-align: center; padding: 3rem; color: var(--color-grey);">
                    <p style="font-size: 3rem; margin: 0 0 1rem;">📄</p>
                    <p style="margin: 0; font-weight: 600;">ยังไม่เคยส่งใบเสนอราคาออนไลน์</p>
                    <a href="{{ route('quotation.generate') }}" style="display: inline-block; margin-top: 1rem; padding: 10px 20px; background: var(--color-navy); color: white; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 0.9rem;">
                        สร้างใบเสนอราคาเดี๋ยวนี้
                    </a>
                </div>
                @endforelse
            </div>
        </div>

        <!-- TAB 8: Repair Claims -->
        <div x-show="tab === 'repairs'" style="display: none;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 2px solid var(--color-silver); padding-bottom: 0.75rem;">
                <h2 style="font-size: 1.6rem; color: var(--color-navy-dark); margin: 0; font-weight: 700;">ติดตามงานซ่อม/เคลมของฉัน</h2>
                <a href="{{ route('service_center') }}" style="background: var(--color-navy-dark); color: white; text-decoration: none; padding: 8px 16px; border-radius: 8px; font-weight: 600; font-size: 0.85rem;">
                    + แจ้งส่งซ่อม/เคลมใหม่
                </a>
            </div>

            <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                @forelse($claims as $clm)
                <div style="border: 1px solid var(--color-silver); border-radius: 12px; padding: 1.5rem; background: white; box-shadow: 0 4px 12px rgba(0,0,0,0.02);">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem; border-bottom: 1px solid var(--color-silver-light); padding-bottom: 0.75rem;">
                        <div>
                            <span style="font-weight: 800; color: var(--color-navy); font-size: 1.1rem;">{{ $clm->id }}</span>
                            <span style="font-size: 0.85rem; color: var(--color-grey); margin-left: 10px;">{{ $clm->created_at->format('d/m/Y H:i') }}</span>
                            <h4 style="margin: 5px 0 0; color: var(--color-navy-dark); font-size: 1rem; font-weight: 700;">📱 {{ $clm->device_name }} {{ $clm->serial_number ? '(S/N: '.$clm->serial_number.')' : '' }}</h4>
                        </div>
                        <div>
                            @if($clm->status === 'pending')
                                <span style="background: #FEF3C7; color: #D97706; font-size: 0.8rem; font-weight: 700; padding: 4px 12px; border-radius: 99px;">⏳ ได้รับแจ้งเรื่อง</span>
                            @elseif($clm->status === 'received')
                                <span style="background: #DBEAFE; color: #2563EB; font-size: 0.8rem; font-weight: 700; padding: 4px 12px; border-radius: 99px;">📦 ได้รับเครื่องแล้ว</span>
                            @elseif($clm->status === 'in_progress')
                                <span style="background: #E0E7FF; color: #4F46E5; font-size: 0.8rem; font-weight: 700; padding: 4px 12px; border-radius: 99px;">🛠️ กำลังซ่อม/ดำเนินการ</span>
                            @elseif($clm->status === 'completed')
                                <span style="background: #D1FAE5; color: #059669; font-size: 0.8rem; font-weight: 700; padding: 4px 12px; border-radius: 99px;">✅ เสร็จสิ้นส่งคืน</span>
                            @else
                                <span style="background: #FEE2E2; color: #DC2626; font-size: 0.8rem; font-weight: 700; padding: 4px 12px; border-radius: 99px;">❌ ยกเลิก</span>
                            @endif
                        </div>
                    </div>

                    <div style="font-size: 0.9rem; color: var(--color-grey); margin-bottom: 1rem; line-height: 1.6;">
                        <strong>รายละเอียดปัญหา:</strong> {{ $clm->issue_description }}
                    </div>

                    @if($clm->estimated_cost)
                    <div style="background: #FFFBEB; border: 1px solid #FCD34D; border-radius: 8px; padding: 10px 14px; margin-bottom: 1rem; display: flex; justify-content: space-between; align-items: center;">
                        <span style="color: #92400E; font-size: 0.85rem; font-weight: 600;">💰 ค่าซ่อมประเมินเบื้องต้น:</span>
                        <strong style="color: #D97706; font-size: 1.1rem;">฿{{ number_format($clm->estimated_cost, 2) }}</strong>
                    </div>
                    @endif

                    @if(!empty($clm->admin_notes))
                    <div style="background: var(--color-grey-bg); padding: 10px 14px; border-radius: 8px; border-left: 3px solid var(--color-navy); margin-bottom: 1rem; font-size: 0.85rem; color: var(--color-navy-dark);">
                        <strong>✍️ อัปเดตจากช่าง:</strong> {{ $clm->admin_notes }}
                    </div>
                    @endif

                    <div style="display: flex; gap: 10px; justify-content: flex-end; align-items: center;">
                        <a href="{{ route('tracking', ['q' => $clm->id, 'type' => 'claim']) }}" style="background: white; border: 1px solid var(--color-silver); color: var(--color-navy-dark); text-decoration: none; padding: 6px 14px; border-radius: 6px; font-weight: 600; font-size: 0.8rem;">
                            🔍 ดูรายละเอียดในระบบติดตาม
                        </a>
                        <button type="button" onclick="window.dispatchEvent(new CustomEvent('open-customer-chat'))" style="background: var(--color-navy); color: white; border: none; padding: 6px 14px; border-radius: 6px; font-weight: 600; font-size: 0.8rem; cursor: pointer;">
                            💬 สอบถามแอดมินทางแชท
                        </button>
                    </div>
                </div>
                @empty
                <div style="text-align: center; padding: 4rem 2rem; color: var(--color-grey);">
                    <span style="font-size: 3rem; display: block; margin-bottom: 1rem;">🛠️</span>
                    <p style="margin: 0; font-weight: 600;">ยังไม่มีประวัติการส่งซ่อมหรือเคลมสินค้า</p>
                    <a href="{{ route('service_center') }}" style="display: inline-block; margin-top: 1rem; padding: 10px 20px; background: var(--color-navy); color: white; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 0.9rem;">
                        แจ้งส่งซ่อมของร้านเดี๋ยวนี้
                    </a>
                </div>
                @endforelse
            </div>
        </div>

    </div>
</div>

<style>
    .active-nav-btn {
        display: flex;
        align-items: center;
        gap: 12px;
        width: 100%;
        padding: 12px 20px;
        border: none;
        border-radius: 12px;
        text-align: left;
        font-family: inherit;
        font-size: 0.95rem;
        font-weight: 700;
        cursor: pointer;
        background: linear-gradient(135deg, var(--color-shopee) 0%, var(--color-lazada-pink) 100%);
        color: white;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 8px 20px rgba(238, 77, 45, 0.25);
        transform: scale(1.02);
    }
    .inactive-nav-btn {
        display: flex;
        align-items: center;
        gap: 12px;
        width: 100%;
        padding: 12px 20px;
        border: none;
        border-radius: 12px;
        text-align: left;
        font-family: inherit;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        background: transparent;
        color: var(--color-navy-dark);
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .inactive-nav-btn:hover {
        background: var(--color-silver-light);
        color: var(--color-shopee);
        padding-left: 24px;
    }
    @media (max-width: 768px) {
        .container {
            flex-direction: column;
        }
        aside {
            width: 100% !important;
        }
    }
</style>
@endsection

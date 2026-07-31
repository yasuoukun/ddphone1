@extends('layouts.store')

@section('content')
<style>
    .customer-dashboard-nav-btn {
        width: 100%;
        padding: 10px 14px;
        border-radius: 12px;
        font-weight: 800;
        font-size: 0.86rem;
        display: flex;
        align-items: center;
        gap: 8px;
        border: 1.5px solid transparent;
        cursor: pointer;
        transition: all 0.22s ease;
        text-align: left;
        white-space: nowrap;
    }
    .customer-dashboard-nav-btn.active {
        background: linear-gradient(135deg, #0891B2 0%, #0E7490 100%);
        color: #ffffff;
        border-color: #0891B2;
        box-shadow: 0 4px 12px rgba(8, 145, 178, 0.25);
    }
    .customer-dashboard-nav-btn.inactive {
        background: #F0F9FF;
        color: #0E7490;
        border-color: #BAE6FD;
    }
    .customer-dashboard-nav-btn.inactive:hover {
        background: linear-gradient(135deg, #0891B2 0%, #0E7490 100%);
        color: #ffffff;
        border-color: #0891B2;
        box-shadow: 0 4px 12px rgba(8, 145, 178, 0.2);
    }

    /* Mobile Responsive Dashboard Layout */
    @media (max-width: 768px) {
        .dashboard-main-wrapper {
            padding: 0.75rem 0.5rem !important;
            gap: 0.75rem !important;
        }

        .dashboard-sidebar {
            width: 100% !important;
        }

        .dashboard-sidebar-inner {
            padding: 0.75rem !important;
            border-radius: 16px !important;
            margin-bottom: 0 !important;
        }

        .dashboard-user-header {
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
            text-align: left !important;
            margin-bottom: 0.75rem !important;
            padding-bottom: 0.5rem !important;
            border-bottom: 1px solid #BAE6FD !important;
        }

        .dashboard-avatar-box {
            width: 48px !important;
            height: 48px !important;
            margin: 0 !important;
        }

        .dashboard-avatar-box img {
            width: 48px !important;
            height: 48px !important;
        }

        .dashboard-user-name {
            font-size: 1rem !important;
            margin-bottom: 1px !important;
        }

        .dashboard-user-email {
            font-size: 0.75rem !important;
        }

        .dashboard-nav-container {
            display: flex !important;
            flex-direction: row !important;
            overflow-x: auto !important;
            gap: 6px !important;
            padding-bottom: 4px !important;
            scrollbar-width: none !important;
        }
        .dashboard-nav-container::-webkit-scrollbar {
            display: none !important;
        }

        .customer-dashboard-nav-btn {
            width: auto !important;
            padding: 6px 12px !important;
            font-size: 0.76rem !important;
            border-radius: 99px !important;
            flex-shrink: 0 !important;
        }

        .dashboard-sidebar-hr,
        .dashboard-logout-form {
            display: none !important;
        }

        .dashboard-content-panel {
            padding: 1rem 0.85rem !important;
            border-radius: 16px !important;
            min-height: auto !important;
        }

        .dashboard-content-panel h2 {
            font-size: 1.1rem !important;
            margin-bottom: 0.85rem !important;
            padding-bottom: 0.5rem !important;
        }
    }
</style>

<div class="container fade-in dashboard-main-wrapper" x-data="{ 
    tab: new URLSearchParams(window.location.search).get('tab') || 'profile', 
    showReceipt: null, 
    editAddress: null,
    showNewAddressModal: false,
    showNewPaymentModal: false,
    orderSearchQuery: '',
    couponTab: 'active'
}" style="padding: 2rem 1rem; display: flex; gap: 2rem; max-width: 1200px; margin: 0 auto; flex-wrap: wrap;">

    <!-- Left Sidebar Profile Navigation -->
    <aside class="dashboard-sidebar" style="width: 280px; flex-shrink: 0;">
        <div class="dashboard-sidebar-inner" style="background: linear-gradient(180deg, #F0F9FF 0%, #ffffff 40%); padding: 1.5rem; border-radius: 24px; border: 2px solid #BAE6FD; box-shadow: 0 6px 24px rgba(8, 145, 178, 0.1); position: sticky; top: 100px;">
            <div class="dashboard-user-header" style="text-align: center; margin-bottom: 1.5rem;">
                <div class="dashboard-avatar-box" style="position: relative; width: 75px; height: 75px; margin: 0 auto 1rem;">
                    <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" style="width: 75px; height: 75px; border-radius: 50%; object-fit: cover; border: 3px solid #0891B2; box-shadow: 0 6px 16px rgba(8, 145, 178, 0.3);">
                </div>
                <div>
                    <h3 class="dashboard-user-name" style="font-size: 1.15rem; font-weight: 900; color: #0E7490; margin-bottom: 0.2rem; word-break: break-word;">{{ auth()->user()->name }}</h3>
                    <p class="dashboard-user-email" style="font-size: 0.78rem; color: #64748B; margin: 0; font-weight: 700; word-break: break-all; overflow-wrap: anywhere; line-height: 1.2;">{{ auth()->user()->email }}</p>
                </div>
            </div>

            <nav class="dashboard-nav-container" style="display: flex; flex-direction: column; gap: 0.5rem;">
                <button @click="tab = 'profile'" :class="tab === 'profile' ? 'customer-dashboard-nav-btn active' : 'customer-dashboard-nav-btn inactive'">
                    <span>👤</span> ข้อมูลส่วนตัว
                </button>
                <button @click="tab = 'address'" :class="tab === 'address' ? 'customer-dashboard-nav-btn active' : 'customer-dashboard-nav-btn inactive'">
                    <span>📍</span> ที่อยู่จัดส่ง
                </button>
                <button @click="tab = 'orders'" :class="tab === 'orders' ? 'customer-dashboard-nav-btn active' : 'customer-dashboard-nav-btn inactive'">
                    <span>📦</span> ประวัติคำสั่งซื้อ
                </button>
                <button @click="tab = 'wishlist'" :class="tab === 'wishlist' ? 'customer-dashboard-nav-btn active' : 'customer-dashboard-nav-btn inactive'">
                    <span>❤️</span> สินค้าที่ชอบ
                </button>
                <button @click="tab = 'coupons'" :class="tab === 'coupons' ? 'customer-dashboard-nav-btn active' : 'customer-dashboard-nav-btn inactive'">
                    <span>🎟️</span> คูปองของฉัน
                </button>
                <button @click="tab = 'repairs'" :class="tab === 'repairs' ? 'customer-dashboard-nav-btn active' : 'customer-dashboard-nav-btn inactive'">
                    <span>🛠️</span> งานซ่อม/เคลมของฉัน
                </button>
                
                <hr class="dashboard-sidebar-hr" style="border: 0; border-top: 1.5px solid #BAE6FD; margin: 0.75rem 0;">

                <form method="POST" action="{{ route('logout') }}" class="dashboard-logout-form">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" style="padding: 10px 14px; border-radius: 12px; text-decoration: none; color: #EF4444; font-weight: 800; display: flex; align-items: center; gap: 8px; transition: all 0.2s; font-size: 0.86rem;" onmouseover="this.style.background='#FEF2F2'" onmouseout="this.style.background='transparent'">
                        <span>🚪</span> ออกจากระบบ
                    </a>
                </form>
            </nav>
        </div>
    </aside>

    <!-- Main Content Panel -->
    <div class="dashboard-content-panel" style="flex: 1 1 600px; background: white; padding: 2rem; border-radius: 24px; border: 2px solid #BAE6FD; box-shadow: 0 6px 24px rgba(8, 145, 178, 0.08); min-height: 480px;">
        
        <!-- TAB 1: Profile Info -->
        <div x-show="tab === 'profile'">
            <h2 style="font-size: 1.6rem; color: #0E7490; margin-bottom: 1.5rem; border-bottom: 2px solid #BAE6FD; padding-bottom: 0.75rem; font-weight: 900;">ข้อมูลส่วนตัว</h2>
            
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" style="max-width: 600px;">
                @csrf
                @method('patch')

                <div style="margin-bottom: 1.75rem; display: flex; align-items: center; gap: 20px;">
                    <img id="avatar-preview" src="{{ auth()->user()->avatar_url }}" alt="Profile Avatar" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid #0891B2;">
                    <div>
                        <label style="display: block; font-weight: 800; margin-bottom: 0.35rem; color: #0F172A; font-size: 0.95rem;">รูปภาพโปรไฟล์</label>
                        <input type="file" name="avatar" accept="image/*" onchange="if(this.files[0]) document.getElementById('avatar-preview').src = URL.createObjectURL(this.files[0])" style="font-size: 0.85rem; color: #64748B;">
                    </div>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 800; margin-bottom: 0.5rem; color: #0E7490; font-size: 0.95rem;">ชื่อ-นามสกุล</label>
                    <input type="text" name="name" value="{{ auth()->user()->name }}" required style="width: 100%; padding: 12px 16px; border: 1.5px solid #BAE6FD; border-radius: 12px; font-family: inherit; font-size: 1rem; outline: none; font-weight: 700; color: #0F172A;" onfocus="this.style.borderColor='#0891B2'" onblur="this.style.borderColor='#BAE6FD'">
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 800; margin-bottom: 0.5rem; color: #0E7490; font-size: 0.95rem;">อีเมล</label>
                    <input type="email" name="email" value="{{ auth()->user()->email }}" required style="width: 100%; padding: 12px 16px; border: 1.5px solid #BAE6FD; border-radius: 12px; font-family: inherit; font-size: 1rem; outline: none; font-weight: 700; color: #0F172A;" onfocus="this.style.borderColor='#0891B2'" onblur="this.style.borderColor='#BAE6FD'">
                </div>

                <div style="margin-bottom: 2rem;">
                    <label style="display: block; font-weight: 800; margin-bottom: 0.5rem; color: #0E7490; font-size: 0.95rem;">เบอร์โทรศัพท์ติดต่อ</label>
                    <input type="text" name="phone" value="{{ auth()->user()->phone }}" placeholder="เช่น 0812345678" style="width: 100%; padding: 12px 16px; border: 1.5px solid #BAE6FD; border-radius: 12px; font-family: inherit; font-size: 1rem; outline: none; font-weight: 700; color: #0F172A;" onfocus="this.style.borderColor='#0891B2'" onblur="this.style.borderColor='#BAE6FD'">
                </div>

                <div style="margin-bottom: 2rem; border-top: 1.5px dashed #E2E8F0; padding-top: 1.5rem;">
                    <h3 style="font-size: 1.1rem; color: #0F172A; font-weight: 900; margin-bottom: 1rem;">🔑 เปลี่ยนรหัสผ่านใหม่ (กรอกเฉพาะเมื่อต้องการเปลี่ยน)</h3>
                    
                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-weight: 800; margin-bottom: 0.35rem; color: #0F172A; font-size: 0.88rem;">รหัสผ่านใหม่</label>
                        <input type="password" name="password" placeholder="อย่างน้อย 8 ตัวอักษร" style="width: 100%; padding: 10px 14px; border: 1.5px solid #E2E8F0; border-radius: 12px; font-family: inherit; font-size: 0.92rem; outline: none;" onfocus="this.style.borderColor='#0F172A'" onblur="this.style.borderColor='#E2E8F0'">
                    </div>

                    <div>
                        <label style="display: block; font-weight: 800; margin-bottom: 0.35rem; color: #0F172A; font-size: 0.88rem;">ยืนยันรหัสผ่านใหม่</label>
                        <input type="password" name="password_confirmation" placeholder="กรอกรหัสผ่านใหม่อีกครั้ง" style="width: 100%; padding: 10px 14px; border: 1.5px solid #E2E8F0; border-radius: 12px; font-family: inherit; font-size: 0.92rem; outline: none;" onfocus="this.style.borderColor='#0F172A'" onblur="this.style.borderColor='#E2E8F0'">
                    </div>
                </div>

                <button type="submit" style="padding: 14px 36px; background: linear-gradient(135deg, #0891B2 0%, #0E7490 100%); color: #ffffff; border: none; border-radius: 99px; font-weight: 900; cursor: pointer; box-shadow: 0 4px 15px rgba(8, 145, 178, 0.35); transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                    บันทึกการเปลี่ยนแปลง
                </button>
            </form>

            <!-- Security Audit Log Section -->
            <div style="margin-top: 2.5rem; border-top: 2px solid #BAE6FD; padding-top: 1.5rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 8px;">
                    <h3 style="font-size: 1.15rem; color: #0E7490; font-weight: 900; margin: 0; display: flex; align-items: center; gap: 8px;">
                        🛡️ ประวัติการเข้าสู่ระบบล่าสุด (Security Audit Log)
                    </h3>
                    <span style="font-size: 0.75rem; color: #64748B; font-weight: 700;">(แสดงสูงสุด 10 รายการล่าสุด)</span>
                </div>

                <div style="overflow-x: auto; border: 1.5px solid #BAE6FD; border-radius: 16px; background: #F8FAFC;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.85rem;">
                        <thead>
                            <tr style="background: #F0F9FF; border-bottom: 1.5px solid #BAE6FD; color: #0E7490; font-weight: 800;">
                                <th style="padding: 10px 14px;">วัน/เวลา</th>
                                <th style="padding: 10px 14px;">ช่องทาง</th>
                                <th style="padding: 10px 14px;">อุปกรณ์ & เบราว์เซอร์</th>
                                <th style="padding: 10px 14px;">IP Address</th>
                                <th style="padding: 10px 14px; text-align: right;">สถานะ</th>
                            </tr>
                        </thead>
                        <tbody style="divide-y divide-gray-100;">
                            @forelse($loginLogs ?? [] as $log)
                            <tr style="border-bottom: 1px solid #E2E8F0; background: white;">
                                <td style="padding: 10px 14px; font-weight: 700; color: #0F172A; white-space: nowrap;">
                                    {{ $log->created_at ? $log->created_at->format('d/m/Y H:i:s') : '-' }}
                                </td>
                                <td style="padding: 10px 14px; white-space: nowrap;">
                                    @if($log->login_method === 'google')
                                        <span style="display: inline-flex; align-items: center; gap: 4px; font-weight: 800; color: #1E293B;">
                                            <svg width="14" height="14" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/></svg> Google
                                        </span>
                                    @elseif($log->login_method === 'facebook')
                                        <span style="display: inline-flex; align-items: center; gap: 4px; font-weight: 800; color: #1877F2;">
                                            <i class="fa-brands fa-facebook-f"></i> Facebook
                                        </span>
                                    @else
                                        <span style="font-weight: 800; color: #475569;">
                                            ✉️ Email / Pass
                                        </span>
                                    @endif
                                </td>
                                <td style="padding: 10px 14px; font-weight: 700; color: #334155;">
                                    {{ $log->formatted_device }}
                                </td>
                                <td style="padding: 10px 14px; font-family: monospace; font-weight: 700; color: #64748B;">
                                    {{ $log->ip_address ?? '-' }}
                                </td>
                                <td style="padding: 10px 14px; text-align: right; white-space: nowrap;">
                                    @if($log->status === 'successful')
                                        <span style="background: #DCFCE7; color: #15803D; padding: 2px 9px; border-radius: 99px; font-size: 0.74rem; font-weight: 900;">✅ สำเร็จ</span>
                                    @elseif($log->status === 'lockout')
                                        <span style="background: #FEE2E2; color: #991B1B; padding: 2px 9px; border-radius: 99px; font-size: 0.74rem; font-weight: 900;">🛑 โดนล็อก</span>
                                    @else
                                        <span style="background: #FEF3C7; color: #92400E; padding: 2px 9px; border-radius: 99px; font-size: 0.74rem; font-weight: 900;">❌ รหัสผิด</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" style="padding: 24px; text-align: center; color: #94A3B8; font-weight: 700;">
                                    ยังไม่มีประวัติการเข้าสู่ระบบ
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- TAB 2: Shipping Addresses (Fix Blank Page Bug) -->
        <div x-show="tab === 'address'" style="display: none;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 2px solid #BAE6FD; padding-bottom: 0.75rem;">
                <h2 style="font-size: 1.6rem; color: #0E7490; margin: 0; font-weight: 900;">ที่อยู่จัดส่งสินค้า</h2>
                <button @click="showNewAddressModal = true" style="background: linear-gradient(135deg, #0891B2 0%, #0E7490 100%); color: white; border: none; padding: 10px 20px; border-radius: 99px; font-weight: 900; cursor: pointer; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(8,145,178,0.3);">
                    ➕ เพิ่มที่อยู่จัดส่งใหม่
                </button>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
                @forelse($addresses as $addr)
                <div style="border: 2px solid {{ $addr->is_main ? '#0F172A' : '#E2E8F0' }}; border-radius: 18px; padding: 1.5rem; background: {{ $addr->is_main ? '#F8FAFC' : 'white' }}; display: flex; flex-direction: column; justify-content: space-between; position: relative;">
                    @if($addr->is_main)
                        <span style="position: absolute; top: 12px; right: 12px; background: #0F172A; color: #FFE600; font-size: 0.72rem; font-weight: 900; padding: 3px 10px; border-radius: 99px;">ที่อยู่หลัก</span>
                    @endif
                    <div>
                        <h4 style="margin: 0 0 0.5rem; font-size: 1rem; font-weight: 900; color: #0F172A;">📍 ที่อยู่จัดส่ง</h4>
                        <p style="margin: 0 0 0.5rem; font-size: 0.92rem; color: #0F172A; font-weight: 700; line-height: 1.6;">{{ $addr->address_line }}</p>
                        <p style="margin: 0 0 0.5rem; font-size: 0.88rem; color: #64748B; font-weight: 700;">
                            {{ $addr->subdistrict ? 'ต. ' . $addr->subdistrict : '' }} 
                            {{ $addr->district ? 'อ. ' . $addr->district : '' }} 
                            {{ $addr->province ? 'จ. ' . $addr->province : '' }} 
                            {{ $addr->postal_code }}
                        </p>
                        <p style="margin: 0; font-size: 0.88rem; color: #0F172A; font-weight: 800;">📞 {{ $addr->phone }}</p>
                    </div>

                    <div style="display: flex; gap: 10px; margin-top: 1.25rem; border-top: 1px solid #E2E8F0; padding-top: 1rem;">
                        @if(!$addr->is_main)
                        <form action="{{ route('customer.addresses.set_main', $addr->id) }}" method="POST" style="margin: 0;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" style="background: none; border: 1px solid #0F172A; color: #0F172A; padding: 6px 12px; border-radius: 99px; font-weight: 800; font-size: 0.78rem; cursor: pointer;">
                                ตั้งเป็นที่อยู่หลัก
                            </button>
                        </form>
                        @endif

                        <form action="{{ route('customer.addresses.destroy', $addr->id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('ยืนยันลบที่อยู่นี้หรือไม่?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; border: 1px solid #EF4444; color: #EF4444; padding: 6px 12px; border-radius: 99px; font-weight: 800; font-size: 0.78rem; cursor: pointer;">
                                ลบ
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div style="grid-column: span 3; text-align: center; color: #94A3B8; padding: 3rem 0; font-weight: 800;">
                    📍 ยังไม่มีที่อยู่จัดส่งสินค้า
                </div>
                @endforelse
            </div>

            <!-- Modal Form for New Address -->
            <div x-show="showNewAddressModal" x-cloak style="position: fixed; inset: 0; background: rgba(15,23,42,0.6); display: flex; align-items: center; justify-content: center; z-index: 99999; padding: 1rem;">
                <div @click.away="showNewAddressModal = false" style="background: white; border-radius: 24px; padding: 2rem; width: 100%; max-width: 520px; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
                    <h3 style="font-size: 1.25rem; font-weight: 900; color: #0F172A; margin: 0 0 1.25rem;">➕ เพิ่มที่อยู่จัดส่งใหม่</h3>
                    <form action="{{ route('customer.addresses.store') }}" method="POST" style="display: flex; flex-direction: column; gap: 1rem;">
                        @csrf
                        <div>
                            <label style="display: block; font-weight: 800; font-size: 0.85rem; color: #0F172A; margin-bottom: 4px;">รายละเอียดที่อยู่ / บ้านเลขที่ / ถนน</label>
                            <input type="text" name="address_line" required placeholder="เช่น 123/45 หมู่ 2 ถ.ชัยประสิทธิ์" style="width: 100%; padding: 10px 14px; border: 1.5px solid #E2E8F0; border-radius: 12px; font-size: 0.9rem;">
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                            <div>
                                <label style="display: block; font-weight: 800; font-size: 0.85rem; color: #0F172A; margin-bottom: 4px;">จังหวัด</label>
                                <input type="text" name="province" required placeholder="เช่น ชัยภูมิ" style="width: 100%; padding: 10px 14px; border: 1.5px solid #E2E8F0; border-radius: 12px; font-size: 0.9rem;">
                            </div>
                            <div>
                                <label style="display: block; font-weight: 800; font-size: 0.85rem; color: #0F172A; margin-bottom: 4px;">อำเภอ / เขต</label>
                                <input type="text" name="district" required placeholder="เช่น เมืองชัยภูมิ" style="width: 100%; padding: 10px 14px; border: 1.5px solid #E2E8F0; border-radius: 12px; font-size: 0.9rem;">
                            </div>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                            <div>
                                <label style="display: block; font-weight: 800; font-size: 0.85rem; color: #0F172A; margin-bottom: 4px;">ตำบล / แขวง</label>
                                <input type="text" name="subdistrict" required placeholder="เช่น ในเมือง" style="width: 100%; padding: 10px 14px; border: 1.5px solid #E2E8F0; border-radius: 12px; font-size: 0.9rem;">
                            </div>
                            <div>
                                <label style="display: block; font-weight: 800; font-size: 0.85rem; color: #0F172A; margin-bottom: 4px;">รหัสไปรษณีย์</label>
                                <input type="text" name="postal_code" required placeholder="เช่น 36000" style="width: 100%; padding: 10px 14px; border: 1.5px solid #E2E8F0; border-radius: 12px; font-size: 0.9rem;">
                            </div>
                        </div>
                        <div>
                            <label style="display: block; font-weight: 800; font-size: 0.85rem; color: #0F172A; margin-bottom: 4px;">เบอร์โทรศัพท์ผู้รับ</label>
                            <input type="text" name="phone" required placeholder="เช่น 0812345678" style="width: 100%; padding: 10px 14px; border: 1.5px solid #E2E8F0; border-radius: 12px; font-size: 0.9rem;">
                        </div>
                        <div style="display: flex; justify-content: end; gap: 10px; margin-top: 1rem;">
                            <button type="button" @click="showNewAddressModal = false" style="background: #F1F5F9; border: none; padding: 10px 20px; border-radius: 99px; font-weight: 800; cursor: pointer;">ยกเลิก</button>
                            <button type="submit" style="background: #0F172A; color: #FFE600; border: none; padding: 10px 24px; border-radius: 99px; font-weight: 900; cursor: pointer;">บันทึกที่อยู่</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- TAB 3: Orders History -->
        <div x-show="tab === 'orders'" style="display: none;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 2px solid #E2E8F0; padding-bottom: 0.75rem; flex-wrap: wrap; gap: 12px;">
                <h2 style="font-size: 1.6rem; color: #0F172A; margin: 0; font-weight: 900;">ประวัติคำสั่งซื้อ</h2>
                <div style="position: relative; width: 280px; max-width: 100%;">
                    <input type="text" x-model="orderSearchQuery" placeholder="🔍 พิมพ์ค้นหาเลขคำสั่งซื้อ/ชื่อสินค้า..." 
                           style="width: 100%; padding: 8px 16px 8px 36px; border: 1.5px solid #2563EB; border-radius: 99px; font-size: 0.85rem; outline: none; font-weight: 700; color: #0F172A; background: #F8FAFC;">
                    <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #2563EB; font-size: 0.9rem;">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                @forelse($orders as $order)
                @php
                    $searchableText = strtolower('#' . str_pad($order->id, 5, '0', STR_PAD_LEFT) . ' ' . $order->tracking_number . ' ' . implode(' ', $order->items->map(fn($i) => $i->product->name ?? '')->toArray()));
                @endphp
                <div x-show="!orderSearchQuery || '{{ addslashes($searchableText) }}'.includes(orderSearchQuery.toLowerCase().trim())"
                     style="border: 1.5px solid #E2E8F0; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(15, 23, 42, 0.04); background: white;">
                    <div style="background: #F8FAFC; padding: 1rem 1.5rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1.5px solid #E2E8F0; flex-wrap: wrap; gap: 10px;">
                        <div>
                            <span style="font-size: 0.82rem; color: #64748B; font-weight: 800;">คำสั่งซื้อ</span>
                            <h4 style="margin: 0; font-size: 1.05rem; color: #0F172A; font-weight: 900;">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h4>
                        </div>
                        <div style="text-align: right;">
                            <span style="font-size: 0.82rem; color: #64748B; font-weight: 800;">วันที่สั่งซื้อ</span>
                            <p style="margin: 0; font-size: 0.92rem; color: #0F172A; font-weight: 800;">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <span style="display: inline-block; padding: 5px 14px; border-radius: 99px; font-size: 0.8rem; font-weight: 900; text-transform: uppercase; color: white; background: {{ $order->status == 'pending' ? '#F59E0B' : ($order->status == 'pending_verification' ? '#2563EB' : ($order->status == 'confirmed' ? '#0F172A' : ($order->status == 'shipped' ? '#FF5722' : ($order->status == 'delivered' ? '#10B981' : '#EF4444')))) }}">
                                {{ $order->status == 'pending' ? 'รอชำระเงิน' : ($order->status == 'pending_verification' ? 'รอตรวจสอบการชำระเงิน' : ($order->status == 'confirmed' ? 'ยืนยันออเดอร์' : ($order->status == 'shipped' ? 'กำลังจัดส่ง' : ($order->status == 'delivered' ? 'ส่งมอบแล้ว' : 'ยกเลิก')))) }}
                            </span>
                        </div>
                    </div>
                    
                    @if($order->tracking_number)
                    <div style="background: #EFF6FF; border-bottom: 1px solid #BFDBFE; padding: 0.75rem 1.5rem; display: flex; align-items: center; justify-content: space-between; gap: 10px; flex-wrap: wrap;">
                        <span style="font-size: 0.9rem; color: #0F172A; font-weight: 800;">
                            🚚 ข้อมูลการจัดส่ง: <span style="color: #2563EB;">{{ $order->shipping_courier ?? 'ขนส่งทั่วไป' }}</span>
                        </span>
                        <span style="font-size: 0.9rem; color: #0F172A; font-weight: 800;">
                            เลขพัสดุ: <strong style="font-family: monospace; letter-spacing: 0.5px; font-size: 0.95rem; color: #FF5722;">{{ $order->tracking_number }}</strong>
                        </span>
                    </div>
                    @endif

                    <div style="padding: 1.5rem;">
                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            @foreach($order->items as $item)
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div style="display: flex; gap: 12px; align-items: center;">
                                    @if(optional($item->product)->primary_image_url)
                                        <img src="{{ $item->product->primary_image_url }}" alt="{{ $item->product->name }}" style="width: 48px; height: 48px; object-fit: contain; border-radius: 10px; border: 1px solid #E2E8F0; background: #F8FAFC; padding: 2px;">
                                    @else
                                        <div style="width: 48px; height: 48px; border-radius: 10px; background: #F1F5F9; display: flex; align-items: center; justify-content: center; color: #94A3B8; font-size: 1.2rem;">
                                            <i class="fa-solid fa-mobile-screen"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <h5 style="margin: 0 0 0.25rem; font-size: 0.98rem; color: #0F172A; font-weight: 800;">{{ $item->product->name ?? 'สินค้าถูกลบออกจากระบบ' }}</h5>
                                        <span style="font-size: 0.82rem; color: #64748B; font-weight: 700;">จำนวน: {{ $item->quantity }} ชิ้น</span>
                                    </div>
                                </div>
                                <span style="font-weight: 900; color: #0F172A; font-size: 1.05rem;">฿{{ number_format($item->price * $item->quantity, 2) }}</span>
                            </div>
                            @endforeach
                        </div>
                        <hr style="border: 0; border-top: 1.5px solid #F1F5F9; margin: 1.25rem 0;">
                        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                            <div>
                                @if($order->status == 'pending')
                                    <a href="{{ route('checkout.pay', $order->id) }}" style="text-decoration: none; display: inline-block; background: #0F172A; color: #FFE600; border: none; padding: 10px 22px; border-radius: 99px; font-weight: 900; cursor: pointer; box-shadow: 0 4px 12px rgba(15,23,42,0.15);">
                                        💳 ชำระเงิน / อัปโหลดสลิป
                                    </a>
                                @endif
                            </div>
                            <div style="text-align: right;">
                                <span style="font-weight: 800; color: #64748B; font-size: 0.88rem;">ยอดชำระสุทธิ:</span>
                                <span style="font-size: 1.35rem; font-weight: 900; color: #EF4444; display: block;">฿{{ number_format($order->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div style="text-align: center; color: #94A3B8; padding: 3rem 0; font-weight: 800;">
                    ไม่มีรายการประวัติสั่งซื้อ
                </div>
                @endforelse
            </div>
        </div>

        <!-- TAB 4: Wishlist (Fix Blank Page Bug) -->
        <div x-show="tab === 'wishlist'" style="display: none;">
            <h2 style="font-size: 1.6rem; color: #0F172A; margin-bottom: 1.5rem; border-bottom: 2px solid #E2E8F0; padding-bottom: 0.75rem; font-weight: 900;">สินค้าที่ชอบ (Wishlist)</h2>
            <div class="product-grid-container" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 16px;">
                @forelse($wishlists as $wish)
                    @if($wish->product)
                    @php $product = $wish->product; @endphp
                    <div class="card-fun-hover shopee-card-style" style="background: white; border: 1px solid #E2E8F0; border-radius: 14px; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04); position: relative; transition: all 0.2s ease;">
                        
                        <!-- Image Box (Shopee 1:1 Square Ratio with Overlay Badges) -->
                        <a href="{{ route('products.show', $product->id) }}" style="text-decoration: none; color: inherit; display: block; position: relative; width: 100%; aspect-ratio: 1/1; background: #F8FAFC; overflow: hidden;">
                            @if($product->discount_price)
                                @php $percent = round((($product->price - $product->discount_price) / $product->price) * 100); @endphp
                                <span style="position: absolute; top: 6px; left: 6px; z-index: 10; font-size: 10px; font-weight: 900; background: #FF5722; color: white; padding: 2px 7px; border-radius: 4px; box-shadow: 0 2px 6px rgba(255,87,34,0.3);">
                                    -{{ $percent }}%
                                </span>
                            @else
                                <span style="position: absolute; top: 6px; left: 6px; z-index: 10; font-size: 10px; font-weight: 900; background: #EF4444; color: white; padding: 2px 7px; border-radius: 4px;">
                                    ❤️ ชอบ
                                </span>
                            @endif

                            @if($product->stock <= 0)
                                <span style="position: absolute; top: 6px; right: 6px; z-index: 10; font-size: 9px; font-weight: 900; background: #EF4444; color: white; padding: 2px 6px; border-radius: 4px;">หมด</span>
                            @else
                                <span style="position: absolute; top: 6px; right: 6px; z-index: 10; font-size: 9px; font-weight: 900; background: #FFE600; color: #0F172A; padding: 2px 6px; border-radius: 4px; border: 1px solid #EAB308;">พร้อมส่ง</span>
                            @endif

                            @if($product->primary_image_url)
                                <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: contain; padding: 0.6rem; transition: transform 0.3s ease;">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                                    <i class="fa-solid fa-mobile-screen text-4xl"></i>
                                </div>
                            @endif
                        </a>
                        
                        <!-- Details & Pricing Box -->
                        <div style="padding: 0.5rem 0.55rem 0.45rem; background: white; display: flex; flex-direction: column; justify-content: space-between; flex-grow: 1; gap: 3px;">
                            <a href="{{ route('products.show', $product->id) }}" style="text-decoration: none; color: inherit;">
                                <h3 style="font-size: 0.78rem; font-weight: 700; color: #0F172A; margin: 0; min-height: 2.1rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.3;">
                                    {{ $product->name }}
                                </h3>
                            </a>
                            
                            <div style="display: flex; flex-direction: column; gap: 2px;">
                                <div style="display: flex; align-items: baseline; gap: 4px;">
                                    @if($product->discount_price)
                                        <span style="font-size: 0.98rem; font-weight: 900; color: #FF5722; line-height: 1;">฿{{ number_format($product->discount_price) }}</span>
                                        <span style="font-size: 0.65rem; text-decoration: line-through; color: #94A3B8; line-height: 1;">฿{{ number_format($product->price) }}</span>
                                    @else
                                        <span style="font-size: 0.98rem; font-weight: 900; color: #FF5722; line-height: 1;">฿{{ number_format($product->price) }}</span>
                                    @endif
                                </div>

                                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 2px;">
                                    @php
                                        $avgRating = round($product->reviews()->avg('rating') ?? 5.0, 1);
                                        $reviewCount = $product->reviews()->count();
                                    @endphp
                                    <span style="font-size: 0.62rem; color: #64748B; font-weight: 600;">
                                        ⭐ {{ number_format($avgRating, 1) }} <span style="color: #CBD5E1;">|</span> {{ $reviewCount > 0 ? 'รีวิว ' . $reviewCount : 'สินค้าใหม่' }}
                                    </span>
                                    
                                    <div style="display: flex; gap: 4px; align-items: center;">
                                        <button type="button" class="wishlist-toggle-btn" data-product-id="{{ $product->id }}" onclick="animateHeartBtn(this)" title="ลบออกจากสินค้าที่ชอบ" style="background: #FEF2F2; border: 1px solid #FCA5A5; color: #EF4444; width: 24px; height: 24px; border-radius: 50%; cursor: pointer; font-size: 0.7rem; display: flex; align-items: center; justify-content: center; transition: all 0.2s;">
                                            <i class="fa-solid fa-heart"></i>
                                        </button>

                                        <form action="{{ route('cart.add', $product) }}" method="POST" class="ajax-add-to-cart-form" style="margin: 0;">
                                            @csrf
                                            <button type="submit" onclick="animateBasketBtn(this)" title="เพิ่มลงตะกร้า" style="background: #FF5722; color: white; border: none; width: 24px; height: 24px; border-radius: 50%; cursor: pointer; font-size: 0.7rem; font-weight: 900; display: flex; align-items: center; justify-content: center; transition: all 0.2s; box-shadow: 0 2px 6px rgba(255, 87, 34, 0.3);">
                                                <i class="fa-solid fa-basket-shopping"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                @empty
                    <div style="grid-column: 1 / -1; text-align: center; color: #94A3B8; padding: 3rem 0; font-weight: 800;">
                        ❤️ ยังไม่มีสินค้าที่กดชอบไว้
                    </div>
                @endforelse
            </div>
        </div>

        <!-- TAB 5: My Coupons -->
        <div x-show="tab === 'coupons'" style="display: none;">
            <style>
            .coupon-tab-btn {
                border-radius: 9999px !important;
                -webkit-border-radius: 9999px !important;
                -moz-border-radius: 9999px !important;
                padding: 6px 14px !important;
                border: none !important;
                font-weight: 800 !important;
                font-size: 0.78rem !important;
                cursor: pointer !important;
                transition: all 0.2s ease !important;
                outline: none !important;
                font-family: inherit !important;
                display: inline-flex !important;
                align-items: center !important;
                gap: 5px !important;
                white-space: nowrap !important;
            }
            .coupon-tab-btn.is-active {
                background: linear-gradient(135deg, #0284C7 0%, #0369A1 100%) !important;
                color: #FFFFFF !important;
                box-shadow: 0 3px 10px rgba(2, 132, 199, 0.25) !important;
            }
            .coupon-tab-btn.is-inactive {
                background: transparent !important;
                color: #64748B !important;
                box-shadow: none !important;
            }
            .coupon-tab-btn.is-inactive:hover {
                color: #0284C7 !important;
            }
            @media (max-width: 768px) {
                .coupon-tab-btn {
                    padding: 4px 10px !important;
                    font-size: 0.7rem !important;
                }
                .dash-coupon-grid {
                    grid-template-columns: 1fr !important;
                    gap: 10px !important;
                }
                .dash-coupon-card {
                    border-radius: 12px !important;
                }
                .dash-coupon-top {
                    padding: 0.65rem 0.85rem !important;
                }
                .dash-coupon-title {
                    font-size: 0.82rem !important;
                }
                .dash-coupon-amount {
                    font-size: 1.15rem !important;
                    margin: 0.2rem 0 !important;
                }
                .dash-coupon-bottom {
                    padding: 6px 0.85rem !important;
                }
                .dash-coupon-code {
                    font-size: 0.75rem !important;
                    padding: 1px 6px !important;
                }
                .dash-coupon-date {
                    font-size: 0.68rem !important;
                }
            }
            </style>
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; border-bottom: 1.5px solid #E2E8F0; padding-bottom: 0.5rem; flex-wrap: wrap; gap: 8px;">
                <h2 style="font-size: 1.25rem; color: #0F172A; margin: 0; font-weight: 900;">คูปองของฉัน</h2>
                <div style="display: flex; gap: 4px; background: #F0F9FF; padding: 3px; border-radius: 9999px; border: 1.5px solid #BAE6FD;">
                    <button @click="couponTab = 'active'"
                            class="coupon-tab-btn"
                            :class="couponTab === 'active' ? 'is-active' : 'is-inactive'">
                        🎟️ พร้อมใช้งาน
                    </button>
                    <button @click="couponTab = 'used'"
                            class="coupon-tab-btn"
                            :class="couponTab === 'used' ? 'is-active' : 'is-inactive'">
                        ⏰ ใช้แล้ว / หมดอายุ
                    </button>
                </div>
            </div>
            
            <div class="dash-coupon-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 14px;">
                @forelse($collectedCoupons as $cc)
                    @php
                        $c = $cc->coupon;
                        $isValid = \Carbon\Carbon::parse($c->expires_at)->isFuture();
                        $isUsable = !$cc->is_used && $isValid;
                    @endphp

                    <div class="dash-coupon-card" x-show="(couponTab === 'active' && {{ $isUsable ? 'true' : 'false' }}) || (couponTab === 'used' && {{ !$isUsable ? 'true' : 'false' }})"
                         style="background: white; border: 1.5px dashed #0F172A; border-radius: 14px; display: flex; flex-direction: column; overflow: hidden; box-shadow: 0 4px 12px rgba(15,23,42,0.04); opacity: {{ $isUsable ? '1' : '0.6' }};">
                        
                        <div class="dash-coupon-top" style="padding: 0.85rem 1rem; background: {{ $isUsable ? '#0F172A' : '#F8FAFC' }}; color: {{ $isUsable ? 'white' : '#0F172A' }};">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.35rem;">
                                <h4 class="dash-coupon-title" style="margin: 0; font-size: 0.9rem; font-weight: 900; color: {{ $isUsable ? '#FFE600' : '#0F172A' }};">{{ $c->name ?? 'โค้ดส่วนลด' }}</h4>
                                <span style="font-size: 0.68rem; padding: 2px 8px; border-radius: 99px; font-weight: 900; background: {{ $cc->is_used ? '#E2E8F0' : ($isValid ? '#FFE600' : '#FEF2F2') }}; color: {{ $cc->is_used ? '#64748B' : ($isValid ? '#0F172A' : '#EF4444') }}; flex-shrink: 0;">
                                    {{ $cc->is_used ? 'ใช้แล้ว' : ($isValid ? 'ใช้งานได้' : 'หมดอายุ') }}
                                </span>
                            </div>
                            
                            <p class="dash-coupon-amount" style="margin: 0.3rem 0; font-size: 1.3rem; font-weight: 900; color: {{ $isUsable ? '#FFE600' : '#EF4444' }};">
                                ส่วนลด ฿{{ number_format($c->discount_amount, 0) }}
                            </p>
                        </div>
                        
                        <div class="dash-coupon-bottom" style="background: #FAFAFA; padding: 8px 1rem; border-top: 1.5px dashed #E2E8F0; display: flex; justify-content: space-between; align-items: center;">
                            <span class="dash-coupon-code" style="font-family: monospace; font-size: 0.85rem; font-weight: 900; color: #0F172A; background: #FFE600; padding: 2px 6px; border-radius: 4px;">{{ $c->code }}</span>
                            <span class="dash-coupon-date" style="font-size: 0.72rem; color: #64748B; font-weight: 800;">
                                หมดอายุ: {{ \Carbon\Carbon::parse($c->expires_at)->format('d/m/Y') }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div style="grid-column: span 3; text-align: center; color: #94A3B8; padding: 3rem 0; font-weight: 800;">
                        🎟️ ยังไม่มีคูปองที่เก็บสะสมไว้
                    </div>
                @endforelse
            </div>
        </div>

        {{-- TAB 6: Payment Methods (Hidden for future use)
        <div x-show="tab === 'payment_methods'" style="display: none;">
            <h2 style="font-size: 1.6rem; color: #0F172A; margin-bottom: 1.5rem; border-bottom: 2px solid #E2E8F0; padding-bottom: 0.75rem; font-weight: 900;">ช่องทางชำระเงิน</h2>
            
            <div style="background: #F8FAFC; border: 1.5px solid #E2E8F0; border-radius: 18px; padding: 1.5rem; margin-bottom: 2rem;">
                <h4 style="font-size: 1.05rem; font-weight: 900; color: #0F172A; margin: 0 0 1rem; display: flex; align-items: center; gap: 8px;">
                    🏦 ช่องทางโอนชำระเงิน / สแกน QR Code (ร้าน DDPHONE)
                </h4>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 15px;">
                    <div style="background: white; padding: 1rem; border-radius: 14px; border: 1px solid #CBD5E1;">
                        <span style="font-size: 0.78rem; font-weight: 900; color: #0284C7; display: block; margin-bottom: 4px;">ธนาคารกสิกรไทย (KBank)</span>
                        <p style="margin: 0; font-weight: 800; color: #0F172A;">000-0-00000-0</p>
                        <p style="margin: 0; font-size: 0.8rem; color: #64748B;">ชื่อบัญชี: บจก. ดีดีโฟน</p>
                    </div>
                </div>
            </div>
            
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                @forelse($paymentMethods as $pm)
                    <div style="background: white; border: 1.5px solid #E2E8F0; padding: 1rem; border-radius: 12px; display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-weight: 800; color: #0F172A;">{{ $pm->name }}</span>
                        <span style="font-size: 0.85rem; color: #64748B;">{{ $pm->details }}</span>
                    </div>
                @empty
                <div style="color: #94A3B8; font-weight: 800; font-size: 0.9rem;">
                    ยังไม่มีช่องทางชำระเงินผูกไว้
                </div>
                @endforelse
            </div>
        </div>
        --}}

        {{-- TAB 7: My Quotations removed --}}

        <!-- TAB 8: My Repairs / Claims (Fix Blank Page Bug) -->
        <div x-show="tab === 'repairs'" style="display: none;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; border-bottom: 1.5px solid #E2E8F0; padding-bottom: 0.5rem; flex-wrap: wrap; gap: 8px;">
                <h2 style="font-size: 1.15rem; color: #0F172A; margin: 0; font-weight: 900;">🛠️ งานซ่อม & เคลมของฉัน</h2>
                <a href="{{ route('service_center') }}" style="background: #0F172A; color: #FFE600; text-decoration: none; padding: 6px 14px; border-radius: 99px; font-weight: 800; font-size: 0.76rem; box-shadow: 0 2px 8px rgba(15,23,42,0.12); white-space: nowrap; display: inline-flex; align-items: center; gap: 5px;">
                    🔧 แจ้งส่งซ่อม/เคลม
                </a>
            </div>

            <div style="display: flex; flex-direction: column; gap: 1rem;">
                @forelse($claims as $claim)
                @php
                    $claimTypeLabel = match($claim->claim_type) {
                        'warranty' => '🛡️ เคลมประกัน',
                        'repair'   => '🔧 ส่งซ่อมทั่วไป',
                        'setting'  => '⚙️ ตั้งค่า/ลงโปรแกรม',
                        default    => '📋 งานซ่อม',
                    };
                    $bgColor = match(true) {
                        in_array($claim->status, ['quoted']) => '#EFF6FF',
                        in_array($claim->status, ['completed']) => '#F0FDF4',
                        in_array($claim->status, ['cancelled']) => '#FEF2F2',
                        in_array($claim->status, ['in_repair', 'in_progress', 'device_received']) => '#EEF2FF',
                        in_array($claim->status, ['repaired_waiting_payment', 'return_shipped']) => '#FFFBEB',
                        default => 'white',
                    };
                    $borderColor = match(true) {
                        in_array($claim->status, ['quoted']) => '#BFDBFE',
                        in_array($claim->status, ['completed']) => '#86EFAC',
                        in_array($claim->status, ['cancelled']) => '#FECACA',
                        in_array($claim->status, ['in_repair', 'in_progress', 'device_received']) => '#C7D2FE',
                        in_array($claim->status, ['repaired_waiting_payment', 'return_shipped']) => '#FDE68A',
                        default => '#E2E8F0',
                    };
                @endphp
                <a href="{{ route('tracking', ['q' => $claim->id, 'type' => 'claim']) }}" style="text-decoration: none; color: inherit; display: block;">
                    <div style="border: 1.5px solid {{ $borderColor }}; border-radius: 16px; padding: 1.1rem 1.25rem; background: {{ $bgColor }}; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; transition: box-shadow 0.2s, transform 0.15s;" onmouseover="this.style.boxShadow='0 4px 16px rgba(15,23,42,0.10)'; this.style.transform='translateY(-1px)'" onmouseout="this.style.boxShadow='none'; this.style.transform='none'">
                        <div>
                            <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 3px;">
                                <span style="font-size: 0.68rem; font-weight: 800; color: #64748B; background: #F1F5F9; padding: 1px 8px; border-radius: 99px;">{{ $claimTypeLabel }}</span>
                                <span style="font-size: 0.68rem; color: #94A3B8; font-weight: 700;">{{ $claim->created_at->format('d/m/Y') }}</span>
                            </div>
                            <h4 style="margin: 0 0 2px; font-size: 0.82rem; font-weight: 900; color: #64748B; letter-spacing: 0.3px;">{{ $claim->id }}</h4>
                            <p style="margin: 0; font-size: 0.92rem; color: #0F172A; font-weight: 800;">{{ $claim->device_name }}</p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            @if(in_array($claim->status, ['quoted']))
                                <span style="font-size: 0.72rem; font-weight: 900; color: #1D4ED8; background: #DBEAFE; border: 1px solid #BFDBFE; padding: 3px 10px; border-radius: 99px; white-space: nowrap;">⚡ กดเพื่อยืนยัน</span>
                            @endif
                            <div>
                                <span class="{{ $claim->status_badge_class }}" style="font-size: 0.78rem; font-weight: 900; padding: 4px 12px; border-radius: 99px; border: 1px solid; white-space: nowrap; display: block; text-align: center;">
                                    {{ $claim->status_label }}
                                </span>
                            </div>
                            <i class="fa-solid fa-chevron-right" style="color: #CBD5E1; font-size: 0.75rem;"></i>
                        </div>
                    </div>
                </a>
                @empty
                <div style="text-align: center; color: #94A3B8; padding: 3rem 0; font-weight: 800;">
                    🛠️ ยังไม่มีรายการแจ้งส่งซ่อมหรือเคลมสินค้า<br>
                    <a href="{{ route('service_center') }}" style="display: inline-block; margin-top: 1rem; color: #0F172A; background: #FFE600; text-decoration: none; padding: 8px 20px; border-radius: 99px; font-weight: 900; font-size: 0.85rem;">แจ้งงานซ่อมแรก</a>
                </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection

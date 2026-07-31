@extends('layouts.store')

@section('content')
<div class="container tracking-container" style="max-width: 750px; margin: 0 auto; padding: 3rem 1rem;">
    <!-- Premium Header -->
    <div class="tracking-header" style="text-align: center; margin-bottom: 3.5rem;">
        <span class="badge-yellow-fun bounce-fun" style="margin-bottom: 0.75rem;">LIVE TRACKING SYSTEM</span>
        <h1 style="font-size: 2.3rem; font-weight: 900; color: var(--color-navy-dark); margin: 0.5rem 0 10px; font-family: 'Prompt', sans-serif;">📦 ติดตามออเดอร์ / สถานะเคลมประกัน 30 วัน</h1>
        <p style="color: #64748b; max-width: 600px; margin: 0 auto; font-size: 1.05rem; line-height: 1.6;">กรอกรหัสออเดอร์ หรือรหัสใบเคลมเพื่อติดตามสถานะพัสดุและการดำเนินงานได้ตลอด 24 ชม.</p>
    </div>

    <!-- Search Form Box -->
    <div class="card-fun-hover tracking-form-card" style="background: white; border: 2px solid #E2E8F0; border-radius: 22px; padding: 2rem; box-shadow: 0 10px 30px rgba(0,0,0,0.03); margin-bottom: 2.5rem;">
        <form action="{{ route('tracking') }}" method="GET">
            <div class="tracking-radio-group" style="display: flex; gap: 12px; margin-bottom: 18px; justify-content: center; flex-wrap: wrap;">
                <label style="cursor: pointer; font-weight: 800; padding: 10px 18px; border-radius: 12px; border: 2px solid {{ ($type ?? 'order') === 'order' ? '#FFE600' : '#E2E8F0' }}; background: {{ ($type ?? 'order') === 'order' ? '#070D1B' : 'white' }}; color: {{ ($type ?? 'order') === 'order' ? '#FFE600' : '#475569' }};">
                    <input type="radio" name="type" value="order" {{ ($type ?? 'order') === 'order' ? 'checked' : '' }} onchange="this.form.submit()"> 📦 ติดตามออเดอร์สินค้า
                </label>
                <label style="cursor: pointer; font-weight: 800; padding: 10px 18px; border-radius: 12px; border: 2px solid {{ ($type ?? 'order') === 'claim' ? '#FFE600' : '#E2E8F0' }}; background: {{ ($type ?? 'order') === 'claim' ? '#070D1B' : 'white' }}; color: {{ ($type ?? 'order') === 'claim' ? '#FFE600' : '#475569' }};">
                    <input type="radio" name="type" value="claim" {{ ($type ?? 'order') === 'claim' ? 'checked' : '' }} onchange="this.form.submit()"> 🔧 ติดตามงานซ่อม/เคลม
                </label>
            </div>

            <div class="tracking-input-group" style="display: flex; gap: 10px; flex-wrap: wrap;">
                <input type="text" name="q" value="{{ $q ?? '' }}" required placeholder="{{ ($type ?? 'order') === 'claim' ? 'ระบุรหัสใบเคลม เช่น CLM-XXXXXX' : 'ระบุรหัสออเดอร์ เช่น ORD-XXXXXX' }}" style="flex: 1 1 240px; padding: 12px 16px; border: 2px solid #FFE600; border-radius: 14px; outline: none; font-size: 0.95rem; font-weight: 600;" onfocus="this.style.borderColor='#FF5722'" onblur="this.style.borderColor='#FFE600'">
                <button type="submit" class="btn-capsule-yellow">
                    ค้นหา <span class="circle-icon"><i class="fa-solid fa-magnifying-glass"></i></span>
                </button>
            </div>
        </form>
    </div>

    <!-- Search Results Section -->
    @if(isset($result))
        <div class="tracking-result-box" style="background: white; border: 1px solid var(--color-silver); border-radius: 16px; padding: 2.5rem; box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
            
            @if($type === 'claim')
                <!-- Claim Details Header -->
                <div style="border-bottom: 2px solid #E2E8F0; padding-bottom: 1.5rem; margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: start; flex-wrap: wrap; gap: 12px;">
                    <div>
                        <div style="display: flex; gap: 8px; align-items: center; margin-bottom: 6px;">
                            <span style="background: #0F172A; color: #FFE600; font-size: 0.8rem; font-weight: 900; padding: 4px 12px; border-radius: 99px;">ใบเคลม/ส่งซ่อม</span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $result->status_badge_class }}">{{ $result->status_label }}</span>
                        </div>
                        <h2 style="font-size: 1.75rem; font-weight: 900; color: #0F172A; margin: 4px 0;">{{ $result->id }}</h2>
                        <p style="color: #64748b; font-size: 0.92rem; margin: 0; font-weight: 600;">📱 อุปกรณ์: <strong style="color: #0F172A;">{{ $result->device_name }}</strong> {{ $result->serial_number ? '(S/N: ' . $result->serial_number . ')' : '' }}</p>
                    </div>
                    <div style="text-align: right;">
                        <span style="font-size: 0.82rem; color: #64748b; font-weight: 600;">วันที่แจ้งเรื่อง</span>
                        <strong style="display: block; color: #0F172A; font-size: 1rem; font-weight: 800;">{{ $result->created_at->format('d/m/Y H:i') }} น.</strong>
                    </div>
                </div>

                <!-- Step Timeline Progress Bar (6-Step Interactive Timeline) -->
                <div style="margin-bottom: 2.5rem; background: #F8FAFC; border: 1.5px solid #E2E8F0; border-radius: 20px; padding: 1.75rem 1.25rem;">
                    <h4 style="color: #0F172A; font-weight: 900; margin-top: 0; margin-bottom: 1.5rem; font-size: 1.05rem;">📊 ความคืบหน้าการประเมินและดำเนินการซ่อม</h4>
                    
                    @php
                        $claimStepsMap = [
                            'pending' => 1, 'pending_assessment' => 1,
                            'quoted' => 2,
                            'confirmed_waiting_device' => 3,
                            'device_received' => 4, 'in_repair' => 4, 'in_progress' => 4,
                            'repaired_waiting_payment' => 5, 'return_shipped' => 5,
                            'completed' => 6,
                        ];
                        
                        $stepVal = $claimStepsMap[$result->status] ?? 1;
                        if ($result->status === 'cancelled') $stepVal = 0;

                        $steps = [
                            1 => ['title' => '1. แจ้งเรื่อง', 'desc' => 'รอประเมิน', 'icon' => '⏳'],
                            2 => ['title' => '2. เสนอราคา', 'desc' => 'เช็คประกัน', 'icon' => '💬'],
                            3 => ['title' => '3. ยืนยันซ่อม', 'desc' => 'รอพัสดุ', 'icon' => '🚚'],
                            4 => ['title' => '4. กำลังซ่อม', 'desc' => 'ช่างดำเนินการ', 'icon' => '🛠️'],
                            5 => ['title' => '5. ส่งคืนเครื่อง', 'desc' => 'จัดส่งพัสดุ', 'icon' => '📫'],
                            6 => ['title' => '6. เสร็จสมบูรณ์', 'desc' => 'ส่งมอบแล้ว', 'icon' => '✅'],
                        ];
                    @endphp

                    @if($result->status === 'cancelled')
                        <div style="background: #FEF2F2; color: #EF4444; border: 1.5px solid #FECACA; padding: 16px; border-radius: 16px; font-weight: 800; text-align: center; font-size: 0.95rem;">
                            ❌ รายการแจ้งเคลม/ส่งซ่อมนี้ถูกยกเลิกแล้ว
                        </div>
                    @else
                        <!-- Progress Row Container with Responsive Scroll -->
                        <div style="width: 100%; overflow-x: auto; scrollbar-width: none; -webkit-overflow-scrolling: touch; padding: 4px 0;">
                            <div style="display: grid; grid-template-columns: repeat(6, 1fr); min-width: 520px; gap: 8px; text-align: center; position: relative;">
                                @foreach($steps as $sNum => $sInfo)
                                    @php $isDone = $stepVal >= $sNum; $isCurrent = $stepVal === $sNum; @endphp
                                    <div style="display: flex; flex-direction: column; align-items: center; gap: 6px;">
                                        <div style="width: 38px; height: 38px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.05rem; font-weight: 900; background: {{ $isDone ? '#0F172A' : '#E2E8F0' }}; color: {{ $isDone ? '#FFE600' : '#64748B' }}; border: 2px solid {{ $isCurrent ? '#FFE600' : 'transparent' }}; box-shadow: {{ $isCurrent ? '0 0 12px rgba(255,230,0,0.8)' : 'none' }}; transition: all 0.3s; flex-shrink: 0;">
                                            {{ $sInfo['icon'] }}
                                        </div>
                                        <div>
                                            <div style="font-size: 0.75rem; font-weight: 800; color: {{ $isDone ? '#0F172A' : '#94A3B8' }}; line-height: 1.25; white-space: nowrap;">{{ $sInfo['title'] }}</div>
                                            <div style="font-size: 0.65rem; color: #94A3B8; font-weight: 600; white-space: nowrap;">{{ $sInfo['desc'] }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Warranty & Quote Action Box (Shown when Status is 'quoted', 'pending_assessment', or 'pending') -->
                @if(in_array($result->status, ['quoted', 'pending_assessment', 'pending']))
                <div style="background: linear-gradient(135deg, #EFF6FF 0%, #DBEAFE 100%); border: 2px solid #3B82F6; border-radius: 22px; padding: 2rem; margin-bottom: 2rem; box-shadow: 0 10px 30px rgba(59,130,246,0.15);">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 1rem;">
                        <span style="font-size: 1.8rem;">💬</span>
                        <div>
                            <h3 style="font-size: 1.25rem; font-weight: 900; color: #1E3A8A; margin: 0;">ผลการประเมินราคาซ่อมและสิทธิประกันจาก DDPHONE</h3>
                            <p style="font-size: 0.85rem; color: #2563EB; margin: 2px 0 0; font-weight: 700;">กรุณาตรวจสอบรายละเอียดและเลือกยืนยันการส่งซ่อมด้านล่างครับ</p>
                        </div>
                    </div>

                    <div style="background: white; border-radius: 16px; padding: 1.25rem; border: 1.5px solid #BFDBFE; margin-bottom: 1.5rem; display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px;">
                        <div>
                            <span style="font-size: 0.78rem; color: #64748B; font-weight: 700; block mb-1">สิทธิการรับประกัน:</span>
                            @if($result->warranty_status === 'in_warranty')
                                <span style="display: inline-block; background: #DCFCE7; color: #15803D; font-weight: 900; padding: 4px 12px; border-radius: 99px; font-size: 0.85rem;">🛡️ อยู่ในประกันร้าน 30 วัน (ซ่อมฟรี)</span>
                            @else
                                <span style="display: inline-block; background: #FEF2F2; color: #B91C1C; font-weight: 900; padding: 4px 12px; border-radius: 99px; font-size: 0.85rem;">💰 นอกประกันร้าน (มีค่าบริการ)</span>
                            @endif
                        </div>
                        <div>
                            <span style="font-size: 0.78rem; color: #64748B; font-weight: 700; block mb-1">ราคาประเมินซ่อม:</span>
                            <strong style="font-size: 1.3rem; font-weight: 900; color: #EF4444;">฿{{ number_format($result->estimated_cost ?? 0, 2) }}</strong>
                        </div>
                        <div>
                            <span style="font-size: 0.78rem; color: #64748B; font-weight: 700; block mb-1">ระยะเวลาซ่อมประเมิน:</span>
                            <strong style="font-size: 1.05rem; font-weight: 900; color: #0F172A;">{{ $result->estimated_days ?? 1 }} วันทำการ</strong>
                        </div>
                    </div>

                    @if($result->admin_notes)
                    <div style="background: white; border-left: 4px solid #2563EB; border-radius: 12px; padding: 1rem; margin-bottom: 1.5rem; font-size: 0.9rem; color: #1E293B; line-height: 1.6; font-weight: 600;">
                        <strong style="color: #2563EB; display: block; margin-bottom: 4px;">📝 ข้อความเสนอแนะจากช่าง:</strong>
                        {!! nl2br(e($result->admin_notes)) !!}
                    </div>
                    @endif

                    <!-- Direct Confirmation Form -->
                    <form action="{{ route('claims.confirm', $result->id) }}" method="POST" style="margin-bottom: 1rem;">
                        @csrf
                        <div style="background: white; border-radius: 14px; padding: 1rem; border: 1.5px solid #BFDBFE; margin-bottom: 1.25rem;">
                            <label style="display: block; font-weight: 800; color: #1E293B; font-size: 0.88rem; margin-bottom: 8px;">🚚 รูปแบบการส่งมอบเครื่อง:</label>
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px;">
                                <label style="display: flex; align-items: center; gap: 10px; padding: 10px 14px; border: 1.5px solid #CBD5E1; border-radius: 12px; cursor: pointer; background: #F8FAFC;">
                                    <input type="radio" name="delivery_method" value="shipping" {{ ($result->delivery_method ?? 'shipping') === 'shipping' ? 'checked' : '' }}>
                                    <div>
                                        <strong style="display: block; font-size: 0.88rem; color: #0F172A;">📦 จัดส่งทางพัสดุ (Flash, KEX, ไปรษณีย์)</strong>
                                        <span style="font-size: 0.75rem; color: #64748B;">แพ็คเครื่องส่งมาที่ร้าน DDPHONE ชัยภูมิ</span>
                                    </div>
                                </label>
                                <label style="display: flex; align-items: center; gap: 10px; padding: 10px 14px; border: 1.5px solid #CBD5E1; border-radius: 12px; cursor: pointer; background: #F8FAFC;">
                                    <input type="radio" name="delivery_method" value="dropoff" {{ ($result->delivery_method ?? '') === 'dropoff' ? 'checked' : '' }}>
                                    <div>
                                        <strong style="display: block; font-size: 0.88rem; color: #0F172A;">🏪 นำมาส่งหน้าร้าน DDPHONE ด้วยตนเอง</strong>
                                        <span style="font-size: 0.75rem; color: #64748B;">นำส่งหน้าร้าน อ.เมือง จ.ชัยภูมิ</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <button type="submit" style="width: 100%; background: #0284C7; color: white; border: none; padding: 14px 24px; border-radius: 99px; font-weight: 900; font-size: 1rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 6px 20px rgba(2,132,199,0.35); transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                            ✅ ยืนยันการส่งซ่อม
                        </button>
                    </form>

                    <form action="{{ route('claims.decline', $result->id) }}" method="POST" onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการยกเลิกการส่งซ่อมนี้?')" style="margin: 0;">
                        @csrf
                        <button type="submit" style="width: 100%; background: #F1F5F9; color: #64748B; border: 1.5px solid #CBD5E1; padding: 10px 20px; border-radius: 99px; font-weight: 800; font-size: 0.85rem; cursor: pointer;">
                            ❌ ปฏิเสธ / ยกเลิกรายการส่งซ่อม
                        </button>
                    </form>
                </div>
                @endif

                <!-- Inbound Parcel Submission Box (Shown when Status is 'confirmed_waiting_device') -->
                @if($result->status === 'confirmed_waiting_device')
                <div style="background: #F0FDF4; border: 2px solid #22C55E; border-radius: 22px; padding: 2rem; margin-bottom: 2rem; box-shadow: 0 10px 30px rgba(34,197,94,0.12);">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 1.25rem;">
                        <span style="font-size: 1.8rem;">📦</span>
                        <div>
                            <h3 style="font-size: 1.25rem; font-weight: 900; color: #14532D; margin: 0;">ลูกค้ายืนยันส่งซ่อมเรียบร้อยแล้ว</h3>
                            <p style="font-size: 0.88rem; color: #166534; margin: 2px 0 0; font-weight: 700;">กรุณาจัดส่งเครื่องมาที่หน้าร้าน DDPHONE แล้วแจ้งเลขพัสดุได้ที่นี่ครับ</p>
                        </div>
                    </div>

                    <!-- Shop Shipping Address Address Box -->
                    <div style="background: #0F172A; color: white; border-radius: 16px; padding: 1.25rem; border: 2px solid #FFE600; margin-bottom: 1.5rem; font-family: monospace; font-size: 0.88rem; line-height: 1.6;">
                        <strong style="color: #FFE600; display: block; margin-bottom: 4px; font-size: 0.95rem;">📍 จ่าหน้าพัสดุส่งมาที่ร้าน DDPHONE:</strong>
                        ผู้รับ: ฝ่ายเคลมและบริการ DDPHONE ดีดีโฟน<br>
                        ที่อยู่: 72/47-48ก ถนนชัยประสิทธิ์ ต.ในเมือง อ.เมือง จ.ชัยภูมิ 36000<br>
                        เบอร์โทรศัพท์: 086-869-9666<br>
                        <span style="color: #FFE600;">*(กรุณาเขียนรหัสใบเคลม "{{ $result->id }}" บนกล่องพัสดุ)*</span>
                    </div>

                    @if($result->inbound_tracking_number)
                        <div style="background: white; border: 1.5px solid #86EFAC; border-radius: 14px; padding: 1rem; color: #14532D; font-weight: 800; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                            <span>🚚 เลขพัสดุที่คุณแจ้งไว้: <strong>{{ $result->inbound_courier }}</strong> - <span style="font-family: monospace; color: #2563EB;">{{ $result->inbound_tracking_number }}</span></span>
                            <span style="font-size: 0.75rem; background: #DCFCE7; color: #15803D; padding: 2px 8px; border-radius: 99px;">บันทึกแล้ว</span>
                        </div>
                    @else
                        <!-- Form to input inbound tracking -->
                        <form action="{{ route('claims.submit_tracking', $result->id) }}" method="POST" style="background: white; border-radius: 16px; padding: 1.25rem; border: 1.5px solid #86EFAC; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
                            @csrf
                            <label style="display: block; font-weight: 900; color: #0F172A; font-size: 0.95rem; margin-bottom: 12px;">📮 แจ้งเลขพัสดุที่คุณจัดส่งมาที่ร้าน:</label>
                            <div style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
                                <div style="flex: 1 1 140px; min-width: 130px;">
                                    <input type="text" name="inbound_courier" value="Flash Express" required placeholder="บริษัทขนส่ง" style="width: 100%; box-sizing: border-box; padding: 11px 14px; border: 1.5px solid #CBD5E1; border-radius: 12px; outline: none; font-size: 0.88rem; font-weight: 700; color: #0F172A; background: #F8FAFC;" onfocus="this.style.borderColor='#16A34A'; this.style.background='#FFFFFF'" onblur="this.style.borderColor='#CBD5E1'; this.style.background='#F8FAFC'">
                                </div>
                                <div style="flex: 2 1 180px; min-width: 170px;">
                                    <input type="text" name="inbound_tracking_number" required placeholder="ระบุเลข Tracking พัสดุของคุณ" style="width: 100%; box-sizing: border-box; padding: 11px 14px; border: 1.5px solid #CBD5E1; border-radius: 12px; outline: none; font-size: 0.88rem; font-weight: 700; font-family: monospace; color: #0F172A; background: #F8FAFC;" onfocus="this.style.borderColor='#16A34A'; this.style.background='#FFFFFF'" onblur="this.style.borderColor='#CBD5E1'; this.style.background='#F8FAFC'">
                                </div>
                                <button type="submit" style="flex: 0 0 auto; min-width: 140px; white-space: nowrap; background: #16A34A; color: white; border: none; padding: 11px 22px; border-radius: 99px; font-weight: 900; font-size: 0.9rem; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 6px; box-shadow: 0 4px 12px rgba(22,163,74,0.3); transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                                    💾 บันทึกเลขพัสดุ
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
                @endif

                <!-- Return Shipping Parcel Box (Shown when status is return_shipped or completed) -->
                @if($result->return_tracking_number)
                <div style="background: #F0F9FF; border: 2px solid #0284C7; border-radius: 20px; padding: 1.5rem; margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px;">
                    <div>
                        <strong style="color: #0369A1; font-size: 0.95rem; display: block; margin-bottom: 4px;">📫 หมายเลขพัสดุที่ร้านจัดส่งเครื่องคืนให้คุณ:</strong>
                        <span style="color: #0F172A; font-size: 1.1rem; font-weight: 900; font-family: monospace;">{{ $result->return_courier ?? 'ขนส่งเอกชน' }}: {{ $result->return_tracking_number }}</span>
                    </div>
                    <button onclick="navigator.clipboard.writeText('{{ $result->return_tracking_number }}'); Swal.fire({icon: 'success', title: 'คัดลอกสำเร็จ!', text: 'คัดลอกหมายเลขพัสดุเรียบร้อยแล้ว', timer: 1500, showConfirmButton: false})" style="background: #0284C7; color: white; border: none; padding: 10px 18px; border-radius: 99px; cursor: pointer; font-size: 0.85rem; font-weight: 800;">
                        📋 คัดลอกเลขพัสดุ
                    </button>
                </div>
                @endif

                @if(!empty($result->image_paths) && count($result->image_paths) > 0)
                    <div style="margin-bottom: 1rem; background: var(--color-grey-bg); padding: 0.75rem; border-radius: 10px; border: 1px solid var(--color-silver-light);">
                        <strong style="color: var(--color-navy-dark); font-size: 0.78rem; display: block; margin-bottom: 6px;">📷 รูปถ่ายตัวเครื่องที่แนบไว้:</strong>
                        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                            @foreach($result->image_paths as $img)
                            <a href="{{ Storage::url($img) }}" target="_blank" style="width: 55px; height: 55px; border-radius: 6px; overflow: hidden; border: 1px solid var(--color-silver); display: block;">
                                <img src="{{ Storage::url($img) }}" style="width: 100%; height: 100%; object-fit: cover;">
                            </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($result->admin_notes)
                    <div style="background: var(--color-grey-bg); border-radius: 10px; padding: 0.85rem 1rem; border-left: 3px solid var(--color-navy); margin-bottom: 1rem;">
                        <strong style="color: var(--color-navy-dark); font-size: 0.82rem; display: block; margin-bottom: 3px;">✍️ บันทึกความคืบหน้าจากเจ้าหน้าที่:</strong>
                        <p style="color: var(--color-grey); font-size: 0.78rem; margin: 0; line-height: 1.4;">{!! nl2br(e($result->admin_notes)) !!}</p>
                    </div>
                @endif

                <!-- Contact Support -->
                <div style="border-top: 1px solid var(--color-silver); padding-top: 1rem; text-align: center; display: flex; flex-direction: column; gap: 8px; align-items: center;">
                    <p style="color: var(--color-grey); font-size: 0.76rem; margin: 0;">มีข้อสงสัยเกี่ยวกับงานซ่อม/เคลมชิ้นนี้? ติดต่อแอดมินได้ทันที</p>
                    <div style="display: flex; gap: 8px; justify-content: center; flex-wrap: wrap;">
                        <button type="button" onclick="window.dispatchEvent(new CustomEvent('open-customer-chat'))" style="background: var(--color-navy); color: white; border: none; padding: 6px 12px; border-radius: 6px; font-weight: 700; font-size: 0.76rem; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                            💬 แชทสอบถามงานซ่อม
                        </button>
                        <a href="https://line.me/ti/p/@ddphone" target="_blank" style="display: inline-flex; align-items: center; gap: 6px; background: #06c755; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-weight: 700; font-size: 0.76rem;">
                            <i class="fa-brands fa-line"></i> ทัก Line OA
                        </a>
                    </div>
                </div>

            @else
                <!-- Order Details -->
                <div style="border-bottom: 1px solid var(--color-silver); padding-bottom: 1.5rem; margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: start;">
                    <div>
                        <span style="background: rgba(27, 42, 71, 0.08); color: var(--color-navy); font-size: 0.8rem; font-weight: 700; padding: 4px 10px; border-radius: 6px; text-transform: uppercase;">รหัสออเดอร์</span>
                        <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--color-navy-dark); margin: 8px 0 4px;">{{ $result->id }}</h2>
                        <span style="font-size: 0.85rem; color: var(--color-grey);">สถานะออเดอร์: 
                            <strong style="color: var(--color-navy);">
                                @if($result->status === 'pending_payment') รอชำระเงิน
                                @elseif($result->status === 'pending_verification') รอตรวจสอบยอดโอน
                                @elseif($result->status === 'confirmed') ยืนยันคำสั่งซื้อ
                                @elseif($result->status === 'shipped') จัดส่งแล้ว
                                @elseif($result->status === 'completed') เสร็จสมบูรณ์
                                @elseif($result->status === 'cancelled') ยกเลิก
                                @endif
                            </strong>
                        </span>
                    </div>
                    <div style="text-align: right;">
                        <span style="font-size: 0.85rem; color: var(--color-grey);">วันที่สั่งซื้อ</span>
                        <strong style="display: block; color: var(--color-navy-dark); font-size: 1rem;">{{ $result->created_at->format('d/m/Y H:i') }}</strong>
                    </div>
                </div>

                <!-- Order Status Timeline -->
                <div style="margin-bottom: 2.5rem;">
                    <h4 style="color: var(--color-navy-dark); font-weight: 700; margin-bottom: 1.5rem;">📊 ความคืบหน้าออเดอร์</h4>
                    
                    @php
                        $orderStatuses = [
                            'pending_payment' => ['label' => 'รอจ่ายเงิน', 'icon' => '🪙', 'step' => 1],
                            'confirmed' => ['label' => 'ยืนยันออเดอร์', 'icon' => '📦', 'step' => 2],
                            'shipped' => ['label' => 'จัดส่งแล้ว', 'icon' => '🚚', 'step' => 3],
                            'completed' => ['label' => 'รับสินค้าแล้ว', 'icon' => '✅', 'step' => 4]
                        ];
                        
                        // Treat pending_verification as step 1.5 or 2 depending on visual mapping
                        $orderStep = 1;
                        if ($result->status === 'pending_verification') $orderStep = 1;
                        elseif ($result->status === 'confirmed') $orderStep = 2;
                        elseif ($result->status === 'shipped') $orderStep = 3;
                        elseif ($result->status === 'completed') $orderStep = 4;
                        elseif ($result->status === 'cancelled') $orderStep = 0;
                    @endphp

                    @if($result->status === 'cancelled')
                        <div style="background: rgba(239,68,68,0.08); color: #ef4444; padding: 15px; border-radius: 8px; font-weight: 600; text-align: center;">
                            ❌ คำสั่งซื้อนี้ถูกยกเลิกแล้ว
                        </div>
                    @else
                        <!-- Progress Steps -->
                        <div style="display: flex; justify-content: space-between; position: relative; margin-top: 1rem;">
                            <!-- Progress Bar Line -->
                            <div style="position: absolute; top: 15px; left: 5%; right: 5%; height: 4px; background: var(--color-silver); z-index: 1;">
                                <div style="height: 100%; background: var(--color-navy); transition: width 0.3s; width: {{ (($orderStep - 1) / 3) * 100 }}%"></div>
                            </div>
                            
                            @foreach($orderStatuses as $key => $statusInfo)
                                <div style="display: flex; flex-direction: column; align-items: center; width: 22%; z-index: 2; position: relative; text-align: center;">
                                    <div style="width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; background: {{ $orderStep >= $statusInfo['step'] ? 'var(--color-navy)' : 'var(--color-silver)' }}; color: white; font-weight: bold; border: 3px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                        {{ $statusInfo['icon'] }}
                                    </div>
                                    <span style="font-size: 0.8rem; font-weight: 600; margin-top: 8px; color: {{ $orderStep >= $statusInfo['step'] ? 'var(--color-navy-dark)' : 'var(--color-grey)' }};">{{ $statusInfo['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Tracking Info -->
                @if($result->tracking_number)
                    <div style="background: var(--color-grey-bg); border-radius: 8px; padding: 1.25rem; border-left: 4px solid var(--color-navy); margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <strong style="color: var(--color-navy-dark); font-size: 0.95rem; display: block; margin-bottom: 2px;">📦 หมายเลขพัสดุ:</strong>
                            <span style="color: var(--color-grey); font-size: 0.9rem; font-family: monospace;">{{ $result->tracking_number }} ({{ $result->carrier ?? 'ขนส่งเอกชน' }})</span>
                        </div>
                        <button onclick="navigator.clipboard.writeText('{{ $result->tracking_number }}'); Swal.fire({icon: 'success', title: 'คัดลอกสำเร็จ!', text: 'คัดลอกหมายเลขพัสดุเรียบร้อยแล้ว', timer: 1500, showConfirmButton: false})" style="background: white; border: 1px solid var(--color-silver); padding: 8px 12px; border-radius: 6px; cursor: pointer; font-size: 0.8rem; font-weight: 600; color: var(--color-navy-dark);">
                            📋 คัดลอกเลข
                        </button>
                    </div>
                @endif

                <!-- Items list -->
                <div style="margin-top: 1.5rem;">
                    <h5 style="font-weight: 700; color: var(--color-navy-dark); font-size: 0.95rem; margin-bottom: 10px;">รายการสินค้าในออเดอร์:</h5>
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        @foreach($result->items as $item)
                            <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.9rem;">
                                <span style="color: var(--color-grey);">{{ $item->product->name }} x {{ $item->quantity }}</span>
                                <strong style="color: var(--color-navy-dark);">฿{{ number_format($item->price * $item->quantity) }}</strong>
                            </div>
                        @endforeach
                        <hr style="border: 0; border-top: 1px solid var(--color-silver); margin: 5px 0;">
                        <div style="display: flex; justify-content: space-between; align-items: center; font-weight: 700; font-size: 1.05rem;">
                            <span>ยอดรวมสุทธิ:</span>
                            <span style="color: var(--color-navy-dark);">฿{{ number_format($result->net_total) }}</span>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    @elseif(request()->filled('q'))
        <div style="background: rgba(239, 68, 68, 0.05); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); border-radius: 12px; padding: 1.5rem; text-align: center; font-weight: 600;">
            ❌ ไม่พบข้อมูลสำหรับรหัส "{{ request('q') }}" กรุณาตรวจสอบความถูกต้องอีกครั้ง
        </div>
    @endif

</div>
@endsection

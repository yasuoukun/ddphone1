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
                <!-- Claim Details -->
                <div style="border-bottom: 1px solid var(--color-silver); padding-bottom: 1.5rem; margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: start;">
                    <div>
                        <span style="background: rgba(239, 68, 68, 0.08); color: #ef4444; font-size: 0.8rem; font-weight: 700; padding: 4px 10px; border-radius: 6px; text-transform: uppercase;">ใบซ่อม/เคลม</span>
                        <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--color-navy-dark); margin: 8px 0 4px;">{{ $result->id }}</h2>
                        <p style="color: var(--color-grey); font-size: 0.9rem; margin: 0;">อุปกรณ์: <strong>{{ $result->device_name }}</strong> {{ $result->serial_number ? '(S/N: ' . $result->serial_number . ')' : '' }}</p>
                    </div>
                    <div style="text-align: right;">
                        <span style="font-size: 0.85rem; color: var(--color-grey);">วันที่แจ้งเรื่อง</span>
                        <strong style="display: block; color: var(--color-navy-dark); font-size: 1rem;">{{ $result->created_at->format('d/m/Y H:i') }}</strong>
                    </div>
                </div>

                <!-- Claim Status Timeline -->
                <div style="margin-bottom: 2.5rem;">
                    <h4 style="color: var(--color-navy-dark); font-weight: 700; margin-bottom: 1.5rem;">📊 ความคืบหน้าการทำงาน</h4>
                    
                    @php
                        $claimStatuses = [
                            'pending' => ['label' => 'ได้รับแจ้งเรื่อง', 'icon' => '📩', 'step' => 1],
                            'received' => ['label' => 'ได้รับเครื่องแล้ว', 'icon' => '📦', 'step' => 2],
                            'in_progress' => ['label' => 'กำลังดำเนินการ', 'icon' => '🛠️', 'step' => 3],
                            'completed' => ['label' => 'เสร็จสิ้นส่งคืน', 'icon' => '✅', 'step' => 4]
                        ];
                        
                        $currentStep = isset($claimStatuses[$result->status]) ? $claimStatuses[$result->status]['step'] : 1;
                        if ($result->status === 'cancelled') $currentStep = 0;
                    @endphp

                    @if($result->status === 'cancelled')
                        <div style="background: rgba(239,68,68,0.08); color: #ef4444; padding: 15px; border-radius: 8px; font-weight: 600; text-align: center;">
                            ❌ งานเคลม/ซ่อมรายการนี้ถูกยกเลิกแล้ว
                        </div>
                    @else
                        <!-- Progress Steps -->
                        <div class="tracking-progress-row" style="display: flex; justify-content: space-between; position: relative; margin-top: 1rem;">
                            <!-- Progress Bar Line -->
                            <div style="position: absolute; top: 15px; left: 5%; right: 5%; height: 4px; background: var(--color-silver); z-index: 1;">
                                <div style="height: 100%; background: var(--color-navy); transition: width 0.3s; width: {{ (($currentStep - 1) / 3) * 100 }}%"></div>
                            </div>
                            
                            @foreach($claimStatuses as $key => $statusInfo)
                                <div class="tracking-progress-step" style="display: flex; flex-direction: column; align-items: center; width: 22%; z-index: 2; position: relative; text-align: center;">
                                    <div class="step-circle" style="width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; background: {{ $currentStep >= $statusInfo['step'] ? 'var(--color-navy)' : 'var(--color-silver)' }}; color: white; font-weight: bold; border: 3px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                        {{ $statusInfo['icon'] }}
                                    </div>
                                    <span class="step-label" style="font-size: 0.8rem; font-weight: 600; margin-top: 8px; color: {{ $currentStep >= $statusInfo['step'] ? 'var(--color-navy-dark)' : 'var(--color-grey)' }};">{{ $statusInfo['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Admin Notes & Estimated Cost -->
                @if($result->estimated_cost)
                    <div style="background: #FFFBEB; border: 1px solid #FCD34D; border-radius: 10px; padding: 0.75rem 1rem; margin-bottom: 1rem; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <span style="color: #92400E; font-size: 0.78rem; font-weight: 700; display: block;">💰 ค่าซ่อมประเมินเบื้องต้น:</span>
                            <span style="color: #B45309; font-size: 0.68rem;">(ประเมินโดยทีมช่าง DDPHONE)</span>
                        </div>
                        <strong style="color: #D97706; font-size: 1.15rem; font-weight: 900;">฿{{ number_format($result->estimated_cost, 2) }}</strong>
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
                        <a href="https://line.me/ti/p/@dditcom" target="_blank" style="display: inline-flex; align-items: center; gap: 6px; background: #06c755; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-weight: 700; font-size: 0.76rem;">
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

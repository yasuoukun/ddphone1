<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>สร้างใบเสนอราคา - บริษัท ดีดี.ไอที.คอม จำกัด</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&family=Sarabun:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --color-navy: #1e293b;
            --color-primary: #4f46e5;
            --color-primary-hover: #4338ca;
            --color-accent: #f59e0b;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: #f1f5f9;
            color: #1e293b;
            font-family: 'Prompt', sans-serif;
            -webkit-print-color-adjust: exact;
        }

        /* Top Header */
        .topbar {
            height: 65px;
            background: var(--color-navy);
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            position: relative;
            z-index: 10;
        }
        .topbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.25rem;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        .topbar-brand i {
            color: var(--color-accent);
        }
        .topbar-actions {
            display: flex;
            gap: 12px;
        }
        .btn-secondary {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.25);
            color: white;
            padding: 8px 18px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            font-size: 0.9rem;
            font-family: inherit;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }
        .btn-secondary:hover {
            background: rgba(255,255,255,0.2);
            border-color: rgba(255,255,255,0.4);
        }
        .btn-primary {
            background: var(--color-accent);
            color: var(--color-navy);
            border: none;
            padding: 8px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 700;
            font-size: 0.9rem;
            font-family: inherit;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.2);
            transition: all 0.2s;
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(245, 158, 11, 0.3);
        }

        /* Editor Layout */
        .app-layout {
            display: flex;
            height: calc(100vh - 65px);
            overflow: hidden;
        }
        .sidebar {
            width: 440px;
            min-width: 440px;
            background: white;
            border-right: 1px solid #e2e8f0;
            padding: 25px;
            overflow-y: auto;
            box-sizing: border-box;
            box-shadow: 4px 0 15px rgba(0,0,0,0.02);
        }
        .preview-area {
            flex-grow: 1;
            background: #cbd5e1;
            padding: 40px;
            overflow-y: auto;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            box-sizing: border-box;
        }

        /* Sidebar Forms styling */
        .form-section-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--color-navy);
            margin-top: 0;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #f1f5f9;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .form-section-title i {
            color: var(--color-primary);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #64748b;
            margin-bottom: 6px;
        }
        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-family: inherit;
            font-size: 0.9rem;
            outline: none;
            box-sizing: border-box;
            transition: all 0.2s;
            background: #f8fafc;
        }
        .form-control:focus {
            border-color: var(--color-primary);
            background: white;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }
        textarea.form-control {
            resize: vertical;
        }

        /* A4 Page View Structure */
        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 20mm;
            background: white;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            border: 1px solid #cbd5e0;
            border-radius: 6px;
            box-sizing: border-box;
            font-family: 'Sarabun', sans-serif;
            position: relative;
        }

        /* Document Design Elements */
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2rem;
            border-bottom: 3px double #1b2a47;
            padding-bottom: 1.5rem;
        }
        .company-info h1 {
            margin: 0 0 6px;
            font-size: 1.65rem;
            color: #1b2a47;
            font-weight: 700;
            line-height: 1.2;
        }
        .company-info p {
            margin: 3px 0;
            font-size: 0.8rem;
            color: #4a5568;
            line-height: 1.4;
        }
        .doc-title {
            text-align: right;
        }
        .doc-title h2 {
            margin: 0 0 12px;
            color: #1b2a47;
            font-size: 1.85rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .doc-title p {
            margin: 4px 0;
            font-size: 0.85rem;
            color: #2d3748;
        }
        
        .billing-grid {
            display: grid;
            grid-template-columns: 1.1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .billing-box {
            border: 1px solid #cbd5e0;
            border-radius: 6px;
            padding: 12px 15px;
            font-size: 0.82rem;
            line-height: 1.5;
            color: #2d3748;
        }
        .billing-box h3 {
            margin: 0 0 8px;
            color: #1b2a47;
            font-size: 0.9rem;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 5px;
            font-weight: 700;
        }

        .item-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2rem;
            font-size: 0.82rem;
        }
        .item-table th {
            background: #1b2a47;
            color: white;
            text-align: left;
            padding: 8px 10px;
            font-weight: 600;
            border: 1px solid #1b2a47;
        }
        .item-table td {
            padding: 10px 10px;
            border: 1px solid #e2e8f0;
        }

        .summary-section {
            display: grid;
            grid-template-columns: 1.1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .payment-info {
            font-size: 0.78rem;
            color: #4a5568;
            line-height: 1.6;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 12px;
            background: #fafafa;
        }
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
        }
        .summary-table td {
            padding: 5px 8px;
            text-align: right;
        }
        .summary-table tr.total-row td {
            font-weight: 700;
            font-size: 1.05rem;
            color: #1b2a47;
            border-top: 2px solid #1b2a47;
            border-bottom: 2px solid #1b2a47;
            padding: 8px;
        }

        .signature-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2.5rem;
            margin-top: 3.5rem;
            text-align: center;
            font-size: 0.8rem;
        }
        .signature-line {
            border-bottom: 1px dotted #718096;
            margin-bottom: 8px;
            height: 45px;
        }

        /* Print Media queries */
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: white;
                color: black;
                margin: 0;
                padding: 0;
            }
            .app-layout {
                display: block;
                height: auto;
                overflow: visible;
            }
            .preview-area {
                background: transparent;
                padding: 0;
                overflow: visible;
                display: block;
            }
            .page {
                width: 210mm;
                min-height: 297mm;
                padding: 12mm;
                margin: 0 auto;
                border: none;
                box-shadow: none;
                border-radius: 0;
                box-sizing: border-box;
            }
    </style>
    
    <script>
    window.quotationCreator = function() {
        return {
            custName: '{{ auth()->check() ? auth()->user()->name : '' }}',
            custOrg: '',
            custTaxId: '',
            custPhone: '',
            custEmail: '{{ auth()->check() ? auth()->user()->email : '' }}',
            custAddress: '',
            quoteNo: '{{ $quoteNo }}',
            date: '{{ $date }}',
            validUntil: '{{ $validUntil }}',
            preparedBy: 'ฝ่ายจัดจำหน่ายและบริการ บริษัท ดีดี.ไอที.คอม จำกัด',
            terms: '• ชำระเงินสดหรือโอนเข้าบัญชีเต็มจำนวนตามข้อตกลง\n• บัญชีธนาคาร: กสิกรไทย เลขที่ 095-8-12345-6 (ชื่อบัญชี บจก. ดีดี ไอที ชัยภูมิ)\n• กำหนดส่งสินค้าภายใน 1-3 วันนับจากได้รับยืนยันคำสั่งซื้อ',
            
            // Items array
            items: [
                @foreach($cart as $id => $item)
                {
                    id: '{{ $id }}',
                    name: '{{ addslashes($item['name']) }}',
                    price: {{ $item['price'] }},
                    quantity: {{ $item['quantity'] }}
                },
                @endforeach
            ],
            
            // All store products for selection
            storeProducts: @json($allProducts),
            selectedStoreProductId: '',
            
            // Custom item inputs
            newItemName: '',
            newItemPrice: 0,
            newItemQuantity: 1,
            
            // Methods
            addStoreProduct() {
                if (!this.selectedStoreProductId) return;
                const prod = this.storeProducts.find(p => p.id == this.selectedStoreProductId);
                if (prod) {
                    // Check if already in items
                    const existing = this.items.find(item => item.id == prod.id);
                    if (existing) {
                        existing.quantity++;
                    } else {
                        this.items.push({
                            id: prod.id,
                            name: prod.name,
                            price: parseFloat(prod.price),
                            quantity: 1
                        });
                    }
                    this.selectedStoreProductId = '';
                }
            },
            
            addCustomItem() {
                if (!this.newItemName) return;
                this.items.push({
                    id: 'custom-' + Date.now(),
                    name: this.newItemName,
                    price: parseFloat(this.newItemPrice) || 0,
                    quantity: parseInt(this.newItemQuantity) || 1
                });
                this.newItemName = '';
                this.newItemPrice = 0;
                this.newItemQuantity = 1;
            },
            
            removeItem(index) {
                this.items.splice(index, 1);
            },
            
            // Calculations
            getSubtotal() {
                return this.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            },
            
            getDiscount() {
                return {{ $discount }};
            },
            
            getNetTotal() {
                return Math.max(0, this.getSubtotal() - this.getDiscount());
            },
            
            getVat() {
                const net = this.getNetTotal();
                return net - (net / 1.07);
            },
            
            getBeforeVat() {
                return this.getNetTotal() - this.getVat();
            },
            
            formatMoney(val) {
                return new Intl.NumberFormat('th-TH', { minimumFractionDigits: 0, maximumFractionDigits: 2 }).format(val);
            },
            
            async submitQuotation() {
                if (!this.custName) {
                    alert('กรุณากรอกชื่อผู้ติดต่อ / Contact Name');
                    return;
                }
                if (this.items.length === 0) {
                    alert('กรุณาเพิ่มรายการสินค้าอย่างน้อย 1 รายการ');
                    return;
                }
                
                try {
                    const response = await fetch('{{ route("quotations.store") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            cust_name: this.custName,
                            cust_org: this.custOrg,
                            cust_tax_id: this.custTaxId,
                            cust_phone: this.custPhone,
                            cust_email: this.custEmail,
                            cust_address: this.custAddress,
                            items: this.items,
                            subtotal: this.getSubtotal(),
                            discount: this.getDiscount(),
                            net_total: this.getNetTotal(),
                            vat: this.getVat(),
                            before_vat: this.getBeforeVat(),
                            prepared_by: this.preparedBy,
                            terms: this.terms
                        })
                    });
                    
                    const result = await response.json();
                    if (result.success) {
                        alert(result.message + ' (เลขที่: ' + result.quote_no + ')');
                        window.location.href = result.redirect;
                    } else {
                        alert('เกิดข้อผิดพลาด: ' + (result.message || 'ไม่สามารถส่งข้อมูลได้'));
                    }
                } catch (error) {
                    console.error('Error submitting quotation:', error);
                    alert('เกิดข้อผิดพลาดในการส่งข้อมูล กรุณาลองใหม่อีกครั้ง');
                }
            }
        };
    };
    </script>
</head>
<body x-data="quotationCreator()">

    <!-- Top Navigation control bar -->
    <div class="topbar no-print">
        <div class="topbar-brand">
            <i class="fa-solid fa-file-invoice-dollar"></i>
            <span>สร้างและพิมพ์ใบเสนอราคา DDIT</span>
        </div>
        <div class="topbar-actions">
            <button onclick="window.location.href='{{ route('cart.index') }}'" class="btn-secondary">
                <i class="fa-solid fa-arrow-left"></i> กลับไปตะกร้าสินค้า
            </button>
            <button @click="submitQuotation()" class="btn-primary" style="background: #10b981; color: white; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);">
                <i class="fa-solid fa-cloud-arrow-up"></i> ส่งใบเสนอราคาออนไลน์
            </button>
            <button onclick="window.print()" class="btn-primary">
                <i class="fa-solid fa-print"></i> พิมพ์หรือบันทึก PDF
            </button>
        </div>
    </div>

    <!-- Main Workspace -->
    <div class="app-layout">
        <!-- Sidebar Input Form Panel -->
        <div class="sidebar no-print">
            
            <!-- Section 1: Customer info -->
            <div style="margin-bottom: 25px;">
                <h3 class="form-section-title">
                    <i class="fa-solid fa-user"></i> ข้อมูลผู้ซื้อ / ลูกค้า
                </h3>
                
                <div class="form-group">
                    <label>ชื่อผู้ติดต่อ / Contact Name</label>
                    <input type="text" x-model="custName" class="form-control" placeholder="ระบุชื่อผู้ติดต่อ">
                </div>

                <div class="form-group">
                    <label>หน่วยงาน / บริษัท / โรงเรียน</label>
                    <input type="text" x-model="custOrg" class="form-control" placeholder="ระบุหน่วยงาน หรือโรงเรียน">
                </div>

                <div class="form-group">
                    <label>เลขประจำตัวผู้เสียภาษี (ถ้ามี)</label>
                    <input type="text" x-model="custTaxId" class="form-control" placeholder="เช่น 036xxxxxxxxxx">
                </div>

                <div class="form-group">
                    <label>เบอร์โทรศัพท์ติดต่อ</label>
                    <input type="text" x-model="custPhone" class="form-control" placeholder="ระบุเบอร์โทรศัพท์">
                </div>

                <div class="form-group">
                    <label>อีเมลติดต่อ</label>
                    <input type="email" x-model="custEmail" class="form-control" placeholder="ระบุอีเมลผู้ติดต่อ">
                </div>

                <div class="form-group">
                    <label>ที่อยู่ / Address</label>
                    <textarea x-model="custAddress" class="form-control" rows="3" placeholder="ระบุที่อยู่เต็มในการจัดส่งหรือออกใบกำกับภาษี"></textarea>
                </div>
            </div>

            <!-- Section 4: Items in Quotation -->
            <div style="margin-bottom: 25px;">
                <h3 class="form-section-title">
                    <i class="fa-solid fa-list-check"></i> รายการสินค้า / บริการ
                </h3>
                
                <!-- Add from Store -->
                <div class="form-group" style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 12px; border-radius: 8px; margin-bottom: 15px;">
                    <label style="font-weight: 700; color: var(--color-navy);">เลือกสินค้าจากในร้าน</label>
                    <div style="display: flex; gap: 8px; margin-top: 5px;">
                        <select x-model="selectedStoreProductId" class="form-control" style="flex-grow: 1;">
                            <option value="">-- เลือกสินค้า --</option>
                            <template x-for="prod in storeProducts" :key="prod.id">
                                <option :value="prod.id" x-text="`${prod.name} (฿${formatMoney(prod.price)})`"></option>
                            </template>
                        </select>
                        <button type="button" @click="addStoreProduct" style="background: var(--color-primary); color: white; border: none; padding: 0 15px; border-radius: 8px; cursor: pointer; font-weight: 600; font-family: 'Prompt', sans-serif;">เพิ่ม</button>
                    </div>
                </div>

                <!-- Add Custom Item -->
                <div class="form-group" style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                    <label style="font-weight: 700; color: var(--color-navy);">เพิ่มรายการกำหนดเอง (บริการ/อื่นๆ)</label>
                    <div style="margin-top: 5px; display: flex; flex-direction: column; gap: 8px;">
                        <input type="text" x-model="newItemName" class="form-control" placeholder="ชื่อรายการ เช่น ค่าติดตั้งวางระบบเน็ตเวิร์ค">
                        <div style="display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 8px;">
                            <input type="number" x-model.number="newItemPrice" class="form-control" placeholder="ราคาต่อหน่วย">
                            <input type="number" x-model.number="newItemQuantity" class="form-control" placeholder="จำนวน">
                        </div>
                        <button type="button" @click="addCustomItem" style="background: #10b981; color: white; border: none; padding: 8px; border-radius: 8px; cursor: pointer; font-weight: 600; font-family: 'Prompt', sans-serif;">เพิ่มรายการกำหนดเอง</button>
                    </div>
                </div>

                <!-- Edit and List current Items -->
                <label style="font-weight: 700; color: #475569; display: block; margin-bottom: 8px;">รายการในปัจจุบัน (แก้ไขราคา/จำนวนได้)</label>
                <div style="display: flex; flex-direction: column; gap: 8px; max-height: 250px; overflow-y: auto; padding-right: 4px;">
                    <template x-for="(item, index) in items" :key="item.id">
                        <div style="background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px; display: flex; flex-direction: column; gap: 6px; box-shadow: 0 2px 4px rgba(0,0,0,0.01);">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 8px;">
                                <span style="font-size: 0.8rem; font-weight: 600; color: var(--color-navy); line-height: 1.3;" x-text="item.name"></span>
                                <button type="button" @click="removeItem(index)" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 0.9rem;" title="ลบรายการนี้"><i class="fa-solid fa-trash"></i></button>
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; align-items: center;">
                                <div style="display: flex; align-items: center; gap: 4px;">
                                    <span style="font-size: 0.75rem; color: #64748b;">ราคา:</span>
                                    <input type="number" x-model.number="item.price" class="form-control" style="padding: 4px 6px; font-size: 0.8rem;">
                                </div>
                                <div style="display: flex; align-items: center; gap: 4px;">
                                    <span style="font-size: 0.75rem; color: #64748b;">จำนวน:</span>
                                    <input type="number" x-model.number="item.quantity" class="form-control" style="padding: 4px 6px; font-size: 0.8rem;">
                                </div>
                            </div>
                        </div>
                    </template>
                    <template x-if="items.length === 0">
                        <div style="text-align: center; color: #94a3b8; font-size: 0.8rem; padding: 10px;">
                            ยังไม่มีรายการในใบเสนอราคา
                        </div>
                    </template>
                </div>
            </div>

            <!-- Section 2: Document Info -->
            <div style="margin-bottom: 25px;">
                <h3 class="form-section-title">
                    <i class="fa-solid fa-file-lines"></i> ข้อมูลเอกสาร
                </h3>
                
                <div class="form-group">
                    <label>เลขที่ใบเสนอราคา / Document No.</label>
                    <input type="text" x-model="quoteNo" class="form-control">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div class="form-group">
                        <label>วันที่ออกเอกสาร</label>
                        <input type="text" x-model="date" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>วันที่ยืนราคา</label>
                        <input type="text" x-model="validUntil" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label>ผู้ออกเอกสาร / Prepared By</label>
                    <input type="text" x-model="preparedBy" class="form-control">
                </div>
            </div>

            <!-- Section 3: Terms & Conditions -->
            <div style="margin-bottom: 20px;">
                <h3 class="form-section-title">
                    <i class="fa-solid fa-circle-info"></i> เงื่อนไข & บัญชีธนาคาร
                </h3>
                
                <div class="form-group">
                    <label>เงื่อนไขการเสนอราคา</label>
                    <textarea x-model="terms" class="form-control" rows="4" placeholder="ระบุเงื่อนไขเพิ่มเติมสำหรับการชำระเงิน"></textarea>
                </div>
            </div>

            <div style="margin-top: 30px; text-align: center; color: #94a3b8; font-size: 0.75rem;">
                <p>ดีดี.ไอที.คอม ชัยภูมิ - ตัวจริงเรื่องสินค้าไอที</p>
            </div>
        </div>

        <!-- A4 Page Live Preview Panel -->
        <div class="preview-area">
            <div class="page">
                <!-- Letter Header -->
                <div class="header">
                    <div class="company-info">
                        <h1>บริษัท ดีดี.ไอที.คอม จำกัด</h1>
                        <p>72/47-48ก ถนนชัยประสิทธิ์ ต.ในเมือง อ.เมือง จ.ชัยภูมิ 36000</p>
                        <p>เลขประจำตัวผู้เสียภาษี: 0365567000120 (สำนักงานใหญ่)</p>
                        <p>โทร: 086-869-9666 | อีเมล: ddphonechaiyaphume@gmail.com</p>
                    </div>
                    <div class="doc-title">
                        <h2>ใบเสนอราคา</h2>
                        <p><strong>เลขที่เอกสาร / No:</strong> <span x-text="quoteNo"></span></p>
                        <p><strong>วันที่ / Date:</strong> <span x-text="date"></span></p>
                        <p><strong>ยืนราคาถึง / Valid Until:</strong> <span x-text="validUntil"></span></p>
                    </div>
                </div>

                <!-- Billing / Customer info -->
                <div class="billing-grid">
                    <div class="billing-box">
                        <h3>ผู้ออกเอกสาร / Prepared By</h3>
                        <strong style="color: #1b2a47;">บริษัท ดีดี.ไอที.คอม จำกัด</strong><br>
                        <span x-text="preparedBy" style="font-size: 0.8rem; display: block; margin-top: 4px;"></span>
                        ฝ่ายจัดจำหน่ายระบบเทคโนโลยีสารสนเทศ
                    </div>
                    <div class="billing-box">
                        <h3>ลูกค้า / Customer Info</h3>
                        <strong>ชื่อลูกค้า/หน่วยงาน:</strong> <span x-text="custName || '___________________________________'"></span><br>
                        <template x-if="custOrg">
                            <div><strong>หน่วยงาน:</strong> <span x-text="custOrg"></span></div>
                        </template>
                        <template x-if="custTaxId">
                            <div><strong>เลขประจำตัวผู้เสียภาษี:</strong> <span x-text="custTaxId"></span></div>
                        </template>
                        <strong>เบอร์โทรศัพท์:</strong> <span x-text="custPhone || '___________________________________'"></span><br>
                        <strong>อีเมล:</strong> <span x-text="custEmail || '___________________________________'"></span><br>
                        <strong>ที่อยู่จัดส่ง:</strong> <span x-text="custAddress || '______________________________________________________________________'"></span>
                    </div>
                </div>

                <!-- Items Table -->
                <table class="item-table">
                    <thead>
                        <tr>
                            <th style="width: 5%; text-align: center;">#</th>
                            <th style="width: 55%;">รายละเอียดสินค้า / Description</th>
                            <th style="width: 15%; text-align: right;">ราคาต่อหน่วย (บาท)</th>
                            <th style="width: 10%; text-align: center;">จำนวน</th>
                            <th style="width: 15%; text-align: right;">ยอดรวม (บาท)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(item, index) in items" :key="item.id">
                            <tr>
                                <td style="text-align: center;" x-text="index + 1"></td>
                                <td>
                                    <strong style="color: #2d3748;" x-text="item.name"></strong>
                                </td>
                                <td style="text-align: right;" x-text="formatMoney(item.price)"></td>
                                <td style="text-align: center;" x-text="item.quantity"></td>
                                <td style="text-align: right;" x-text="formatMoney(item.price * item.quantity)"></td>
                            </tr>
                        </template>
                        <template x-if="items.length === 0">
                            <tr>
                                <td colspan="5" style="text-align: center; color: #94a3b8; padding: 2rem;">
                                    ยังไม่มีสินค้าในใบเสนอราคา กรุณาเพิ่มสินค้าด้านซ้าย
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>

                <!-- Summary section -->
                <div class="summary-section">
                    <div class="payment-info">
                        <strong style="color: #1b2a47; display: block; margin-bottom: 5px;">📝 เงื่อนไขการชำระเงินและการส่งมอบ:</strong>
                        <div style="white-space: pre-line; font-size: 0.78rem;" x-text="terms"></div>
                    </div>
                    <div>
                        <table class="summary-table">
                            <tr>
                                <td style="text-align: left; color: #4a5568;">รวมเป็นเงิน / Subtotal:</td>
                                <td style="font-weight: 600;" x-text="'฿' + formatMoney(getSubtotal())"></td>
                            </tr>
                            <template x-if="getDiscount() > 0">
                                <tr>
                                    <td style="text-align: left; color: #e53e3e;">ส่วนลดคูปอง / Discount:</td>
                                    <td style="color: #e53e3e; font-weight: 600;" x-text="'-฿' + formatMoney(getDiscount())"></td>
                                </tr>
                            </template>
                            <tr>
                                <td style="text-align: left; color: #4a5568;">มูลค่าก่อนภาษี / Before VAT:</td>
                                <td x-text="'฿' + formatMoney(getBeforeVat())"></td>
                            </tr>
                            <tr>
                                <td style="text-align: left; color: #4a5568;">ภาษีมูลค่าเพิ่ม 7% / VAT (Included):</td>
                                <td x-text="'฿' + formatMoney(getVat())"></td>
                            </tr>
                            <tr class="total-row">
                                <td style="text-align: left;">จำนวนเงินสุทธิ / Total Paid:</td>
                                <td x-text="'฿' + formatMoney(getNetTotal())"></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Signature lines -->
                <div class="signature-grid">
                    <div>
                        <div class="signature-line"></div>
                        <strong>ผู้อนุมัติเสนอราคา (Authorized Officer)</strong>
                        <p style="color: #718096; font-size: 0.75rem; margin-top: 4px;">วันที่เสนอ: ____/____/____</p>
                    </div>
                    <div>
                        <div class="signature-line"></div>
                        <strong>ผู้รับการเสนอราคา / ลูกค้าอนุมัติ</strong>
                        <p style="color: #718096; font-size: 0.75rem; margin-top: 4px;">วันที่อนุมัติ: ____/____/____</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>

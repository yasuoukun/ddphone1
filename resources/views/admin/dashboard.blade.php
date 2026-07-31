<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center justify-between">
            <span class="flex items-center gap-2">
                <i class="fa-solid fa-chart-line text-indigo-600"></i>
                {{ __('แผงควบคุมและสถิติการขาย') }}
            </span>
            <span class="text-xs bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full font-bold">General Admin</span>
        </h2>
    </x-slot>

    <!-- Include Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="py-8 bg-gray-50/50 min-h-screen fade-in">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Alert Session Messages -->
            <!-- Quick Product Management Shortcuts -->
            <div class="mb-8 p-6 rounded-3xl text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-4" style="background: linear-gradient(135deg, #070D1B 0%, #0F172A 100%); border: 2px solid #FFE600;">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-400/20 border border-amber-400/40 flex items-center justify-center text-[#FFE600] text-2xl">
                        <i class="fa-solid fa-square-plus"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-[#FFE600]">จัดการสินค้า & คลังสินค้า</h3>
                        <p class="text-xs text-slate-200 font-medium">แอดมินสามารถเพิ่มรายการสินค้าใหม่ ปรับแต่งข้อมูล ราคา สเปก และรูปภาพสินค้าได้ทันที</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('central_admin.products.create') }}" class="px-5 py-2.5 rounded-xl bg-[#FF5722] hover:bg-[#e64a19] text-white font-black text-xs shadow-lg flex items-center gap-2 transition-all hover:scale-105" style="border: 1px solid #FFE600;">
                        <i class="fa-solid fa-plus"></i> เพิ่มสินค้าใหม่
                    </a>
                    <a href="{{ route('central_admin.products.index') }}" class="px-5 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs border border-white/30 flex items-center gap-2 transition-all">
                        <i class="fa-solid fa-boxes-stacked"></i> ดูรายการสินค้าทั้งหมด
                    </a>
                </div>
            </div>




            <!-- Sales Growth Executive Summary Card Container -->
            <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm mb-8">
                <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-6">
                    <div>
                        <h3 class="text-lg font-black text-slate-800 flex items-center gap-2">
                            <i class="fa-solid fa-arrow-trend-up text-emerald-500"></i>
                            สรุปอัตราการเติบโตของยอดขาย (Sales Growth Summary)
                        </h3>
                        <p class="text-xs text-slate-400 mt-0.5">เปรียบเทียบผลประกอบการรายวัน รายสัปดาห์ และรายเดือนแบบเรียลไทม์</p>
                    </div>
                    <span class="text-xs font-extrabold bg-emerald-50 text-emerald-700 px-3 py-1.5 rounded-full border border-emerald-100 shadow-sm flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span> Live Comparison
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Daily Growth -->
                    <div class="p-5 rounded-2xl bg-slate-50/80 border border-slate-100 flex items-center justify-between">
                        <div>
                            <p class="text-xs text-slate-500 font-bold uppercase">ยอดขายวันนี้ (Today)</p>
                            <h4 class="text-xl font-black text-slate-800 mt-1">฿{{ number_format($todayRevenue, 2) }}</h4>
                            <div class="flex items-center gap-1.5 mt-2">
                                <span class="inline-flex items-center gap-1 text-xs font-black px-2 py-0.5 rounded-full {{ $dailyGrowth >= 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                    <i class="fa-solid {{ $dailyGrowth >= 0 ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }}"></i>
                                    {{ $dailyGrowth >= 0 ? '+' : '' }}{{ $dailyGrowth }}%
                                </span>
                                <span class="text-[11px] text-slate-400 font-medium">เทียบกับเมื่อวาน</span>
                            </div>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl shadow-sm">
                            <i class="fa-solid fa-calendar-day"></i>
                        </div>
                    </div>

                    <!-- Weekly Growth -->
                    <div class="p-5 rounded-2xl bg-slate-50/80 border border-slate-100 flex items-center justify-between">
                        <div>
                            <p class="text-xs text-slate-500 font-bold uppercase">ยอดขายสัปดาห์นี้ (This Week)</p>
                            <h4 class="text-xl font-black text-slate-800 mt-1">฿{{ number_format($thisWeekRevenue, 2) }}</h4>
                            <div class="flex items-center gap-1.5 mt-2">
                                <span class="inline-flex items-center gap-1 text-xs font-black px-2 py-0.5 rounded-full {{ $weeklyGrowth >= 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                    <i class="fa-solid {{ $weeklyGrowth >= 0 ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }}"></i>
                                    {{ $weeklyGrowth >= 0 ? '+' : '' }}{{ $weeklyGrowth }}%
                                </span>
                                <span class="text-[11px] text-slate-400 font-medium">เทียบกับสัปดาห์ก่อน</span>
                            </div>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl shadow-sm">
                            <i class="fa-solid fa-calendar-week"></i>
                        </div>
                    </div>

                    <!-- Monthly Growth -->
                    <div class="p-5 rounded-2xl bg-slate-50/80 border border-slate-100 flex items-center justify-between">
                        <div>
                            <p class="text-xs text-slate-500 font-bold uppercase">ยอดขายเดือนนี้ (This Month)</p>
                            <h4 class="text-xl font-black text-slate-800 mt-1">฿{{ number_format($monthlyRevenue, 2) }}</h4>
                            <div class="flex items-center gap-1.5 mt-2">
                                <span class="inline-flex items-center gap-1 text-xs font-black px-2 py-0.5 rounded-full {{ $monthlyGrowth >= 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                    <i class="fa-solid {{ $monthlyGrowth >= 0 ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }}"></i>
                                    {{ $monthlyGrowth >= 0 ? '+' : '' }}{{ $monthlyGrowth }}%
                                </span>
                                <span class="text-[11px] text-slate-400 font-medium">เทียบกับเดือนก่อน</span>
                            </div>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl shadow-sm">
                            <i class="fa-solid fa-calendar-days"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Grid Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <!-- Sales Statistics Line Chart with Period Filter Tabs -->
                <div class="lg:col-span-2 bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4 pb-3 border-b border-gray-100">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <i class="fa-solid fa-chart-line text-indigo-500"></i> 
                            <span id="sales-chart-title">สถิติยอดขาย (บาท)</span>
                        </h3>

                        <!-- Period Filter Tabs -->
                        <div class="inline-flex p-1 bg-gray-100/80 rounded-xl text-xs font-bold" id="sales-period-wrapper">
                            <button type="button" onclick="changeSalesPeriod('day', this)" class="period-tab-btn px-3 py-1.5 rounded-lg bg-indigo-600 text-white shadow-sm transition-all">
                                📅 รายวัน
                            </button>
                            <button type="button" onclick="changeSalesPeriod('week', this)" class="period-tab-btn px-3 py-1.5 rounded-lg text-gray-600 hover:text-gray-900 transition-all">
                                🗓️ รายสัปดาห์
                            </button>
                            <button type="button" onclick="changeSalesPeriod('month', this)" class="period-tab-btn px-3 py-1.5 rounded-lg text-gray-600 hover:text-gray-900 transition-all">
                                📊 รายเดือน
                            </button>
                            <button type="button" onclick="changeSalesPeriod('year', this)" class="period-tab-btn px-3 py-1.5 rounded-lg text-gray-600 hover:text-gray-900 transition-all">
                                📈 รายปี
                            </button>
                        </div>
                    </div>

                    <div style="position: relative; height: 320px; width: 100%;">
                        <canvas id="salesLineChart"></canvas>
                    </div>
                </div>

                <!-- Order Status Doughnut Chart -->
                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm flex flex-col justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-chart-pie text-amber-500"></i> สัดส่วนสถานะใบสั่งซื้อ
                        </h3>
                        <div style="position: relative; height: 240px; width: 100%;">
                            <canvas id="statusPieChart"></canvas>
                        </div>
                    </div>
                    <div class="text-xs text-slate-400 text-center mt-4">
                        สถิติอัปเดตแบบเรียลไทม์ตามฐานข้อมูลออเดอร์
                    </div>
                </div>
            </div>

            <!-- Product & Sales Intelligence Section -->
            @include('admin.dashboard_analytics')

        </div>
    </div>

    <!-- Chart Initializer Scripts -->
    <script>
        let salesChart = null;

        function changeSalesPeriod(period, btn) {
            document.querySelectorAll('.period-tab-btn').forEach(el => {
                el.classList.remove('bg-indigo-600', 'text-white', 'shadow-sm');
                el.classList.add('text-gray-600');
            });
            if (btn) {
                btn.classList.add('bg-indigo-600', 'text-white', 'shadow-sm');
                btn.classList.remove('text-gray-600');
            }

            const titleMap = {
                'day': 'สถิติยอดขายย้อนหลัง 7 วัน (บาท)',
                'week': 'สถิติยอดขายย้อนหลัง 8 สัปดาห์ (บาท)',
                'month': 'สถิติยอดขายรายเดือนย้อนหลัง 12 เดือน (บาท)',
                'year': 'สถิติยอดขายรายปีย้อนหลัง 5 ปี (บาท)'
            };

            const titleEl = document.getElementById('sales-chart-title');
            if (titleEl && titleMap[period]) titleEl.innerText = titleMap[period];

            const apiUrl = '{{ route("admin.dashboard.sales_chart") }}?period=' + period;
            fetch(apiUrl)
                .then(res => res.json())
                .then(resData => {
                    if (salesChart) {
                        salesChart.data.labels = resData.labels;
                        salesChart.data.datasets[0].data = resData.data;
                        salesChart.update();
                    }
                })
                .catch(err => console.error('Sales chart fetch error:', err));
        }

        document.addEventListener('DOMContentLoaded', function() {
            // 1. Line Chart (7 Days Sales)
            const salesCtx = document.getElementById('salesLineChart').getContext('2d');
            salesChart = new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($labelsLast7Days) !!},
                    datasets: [{
                        label: 'ยอดโอนสำเร็จ (บาท)',
                        data: {!! json_encode($salesLast7Days) !!},
                        borderColor: '#4f46e5',
                        backgroundColor: 'rgba(79, 70, 229, 0.08)',
                        borderWidth: 3,
                        pointBackgroundColor: '#4f46e5',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        tension: 0.35,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.04)'
                            },
                            ticks: {
                                font: {
                                    size: 11
                                },
                                callback: function(value) {
                                    return '฿' + value.toLocaleString();
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 11
                                }
                            }
                        }
                    }
                }
            });

            // 2. Pie Chart (Order Statuses)
            const statusCtx = document.getElementById('statusPieChart').getContext('2d');
            const orderStatusesData = {!! json_encode($orderStatuses) !!};
            
            const statusChart = new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(orderStatusesData),
                    datasets: [{
                        data: Object.values(orderStatusesData),
                        backgroundColor: [
                            '#e2e8f0', // pending
                            '#f87171', // pending_verification
                            '#34d399', // confirmed
                            '#60a5fa', // shipped
                            '#818cf8', // delivered
                            '#cbd5e1'  // cancelled
                        ],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                padding: 12,
                                font: {
                                    size: 11
                                }
                            }
                        }
                    },
                    cutout: '65%'
                }
            });
        });
    </script>
</x-app-layout>

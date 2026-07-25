@php
    $pendingOrdersCount = 0;
    $unreadMessagesCount = 0;
@endphp
<nav x-data="{ open: false }" class="bg-[#0F172A] border-b border-[#FFE600]/20 shadow-lg transition-all duration-300">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center mr-6">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 hover:scale-105 transition-transform duration-200">
                        <img src="{{ asset('images/logoddphone.png') }}" alt="DDPHONE Logo" class="h-10 w-auto object-contain" onerror="this.src='{{ asset('logoddphone.png') }}'">
                        <span class="font-black text-[#FFE600] text-lg tracking-wider">DDPHONE</span>
                    </a>
                </div>

                <!-- Navigation Links / Admin Icon Bar -->
                <div class="hidden sm:flex sm:items-center">
                    @if(auth()->user()->role !== 'customer')
                        @php
                            $lastViewedOrdersAt = session('last_viewed_orders_at');
                            $ordersQuery = \App\Models\Order::where('status', 'pending_verification');
                            if ($lastViewedOrdersAt) {
                                $ordersQuery->where('created_at', '>', $lastViewedOrdersAt);
                            }
                            $pendingOrdersCount = $ordersQuery->count();

                            $unreadMessagesCount = \App\Models\Message::whereNull('receiver_id')
                                ->where('is_read', false)
                                ->count();
                        @endphp
                    @endif
                    @if(auth()->user()->role === 'customer')
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-slate-300 hover:text-white border-transparent">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                    @else
                        <div class="flex items-center gap-2 my-auto h-11">
                            <!-- Dashboard -->
                            <a href="{{ auth()->user()->role === 'super_admin' ? route('central_admin.dashboard') : route('admin.dashboard') }}" 
                               class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('*.dashboard') ? 'bg-gradient-to-r from-indigo-600 to-blue-600 text-white shadow-md scale-105' : 'text-slate-300 hover:bg-[#2A3B5C] hover:text-white' }}"
                               title="แผงควบคุม">
                                <i class="fa-solid fa-gauge-high text-sm"></i>
                                <span class="hidden md:inline">แดชบอร์ด</span>
                            </a>

                            @if(in_array(auth()->user()->role, ['admin', 'super_admin']))
                                <!-- Dropdown 1: คลังสินค้า (Products, Categories, Brands, Stock) -->
                                <div x-data="{ open: false }" class="relative" @click.away="open = false">
                                    <button @click="open = !open" onclick="toggleAdminNavDropdown(this)"
                                            class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold transition-all {{ (request()->routeIs('central_admin.products.*') || request()->routeIs('central_admin.categories.*') || request()->routeIs('central_admin.brands.*') || request()->routeIs('admin.stock.*')) ? 'bg-gradient-to-r from-violet-600 to-purple-600 text-white shadow-md' : 'text-slate-300 hover:bg-[#2A3B5C] hover:text-white' }}">
                                        <i class="fa-solid fa-boxes-stacked text-sm"></i>
                                        <span>สินค้า & คลัง</span>
                                        <i class="fa-solid fa-chevron-down text-[9px] transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                                    </button>
                                    <div x-show="open" 
                                         x-transition:enter="transition ease-out duration-100"
                                         x-transition:enter-start="transform opacity-0 scale-95"
                                         x-transition:enter-end="transform opacity-100 scale-100"
                                         class="absolute left-0 mt-2 w-48 rounded-xl bg-slate-900 border border-slate-700/80 shadow-2xl py-2 z-50"
                                         style="display: none;">
                                        
                                        <a href="{{ route('central_admin.products.create') }}" 
                                           class="flex items-center gap-2 px-4 py-2 text-xs font-bold text-emerald-400 hover:bg-emerald-600 hover:text-white transition-all border-b border-slate-800">
                                            <i class="fa-solid fa-circle-plus w-4"></i> + เพิ่มสินค้าใหม่
                                        </a>
                                        <a href="{{ route('central_admin.products.index') }}" 
                                           class="flex items-center gap-2 px-4 py-2 text-xs font-bold transition-all {{ request()->routeIs('central_admin.products.index') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                                            <i class="fa-solid fa-mobile-screen-button w-4"></i> รายการสินค้าทั้งหมด
                                        </a>
                                        <a href="{{ route('central_admin.categories.index') }}" 
                                           class="flex items-center gap-2 px-4 py-2 text-xs font-bold transition-all {{ request()->routeIs('central_admin.categories.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                                            <i class="fa-solid fa-folder-open w-4"></i> หมวดหมู่สินค้า
                                        </a>
                                        <a href="{{ route('central_admin.brands.index') }}" 
                                           class="flex items-center gap-2 px-4 py-2 text-xs font-bold transition-all {{ request()->routeIs('central_admin.brands.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                                            <i class="fa-solid fa-tags w-4"></i> แบรนด์สินค้า
                                        </a>
                                        <a href="{{ route('admin.stock.index') }}" 
                                           class="flex items-center gap-2 px-4 py-2 text-xs font-bold transition-all {{ request()->routeIs('admin.stock.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                                            <i class="fa-solid fa-warehouse w-4"></i> จัดการสต๊อก
                                        </a>
                                    </div>
                                </div>
                            @endif

                            <!-- Dropdown 2: งานขาย & บริการ (Orders, Claims, Quotations) -->
                            <div x-data="{ open: false }" class="relative" @click.away="open = false">
                                <button @click="open = !open" onclick="toggleAdminNavDropdown(this)"
                                        class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold transition-all relative {{ (request()->routeIs('admin.orders.*') || request()->routeIs('admin.claims.*') || request()->routeIs('admin.quotations.*')) ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md' : 'text-slate-300 hover:bg-[#2A3B5C] hover:text-white' }}">
                                    <i class="fa-solid fa-cart-shopping text-sm"></i>
                                    <span>ขาย & บริการ</span>
                                    @if($pendingOrdersCount > 0)
                                        <span class="absolute -top-1 -right-1 bg-rose-600 text-white rounded-full text-[9px] w-4 h-4 flex items-center justify-center font-extrabold shadow-md animate-bounce">
                                            {{ $pendingOrdersCount }}
                                        </span>
                                    @endif
                                    <i class="fa-solid fa-chevron-down text-[9px] transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                                </button>
                                <div x-show="open" 
                                     x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     class="absolute left-0 mt-2 w-48 rounded-xl bg-slate-900 border border-slate-700/80 shadow-2xl py-2 z-50"
                                     style="display: none;">
                                    
                                    <a href="{{ route('admin.orders.index') }}" 
                                       class="flex items-center justify-between px-4 py-2 text-xs font-bold transition-all {{ request()->routeIs('admin.orders.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                                        <span class="flex items-center gap-2"><i class="fa-solid fa-receipt w-4"></i> ออเดอร์สั่งซื้อ</span>
                                        @if($pendingOrdersCount > 0)
                                            <span class="bg-rose-600 text-white text-[9px] px-1.5 py-0.5 rounded-full font-bold">{{ $pendingOrdersCount }}</span>
                                        @endif
                                    </a>
                                    <a href="{{ route('admin.claims.index') }}" 
                                       class="flex items-center gap-2 px-4 py-2 text-xs font-bold transition-all {{ request()->routeIs('admin.claims.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                                        <i class="fa-solid fa-wrench w-4"></i> งานซ่อม/เคลม
                                    </a>
                                    <a href="{{ route('admin.quotations.index') }}" 
                                       class="flex items-center gap-2 px-4 py-2 text-xs font-bold transition-all {{ request()->routeIs('admin.quotations.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                                        <i class="fa-solid fa-file-invoice-dollar w-4"></i> ใบเสนอราคา
                                    </a>
                                </div>
                            </div>

                            @if(in_array(auth()->user()->role, ['admin', 'super_admin']))
                                <!-- Dropdown 3: การตลาด & หน้าแรก (Coupons, Reviews, CMS) -->
                                <div x-data="{ open: false }" class="relative" @click.away="open = false">
                                    <button @click="open = !open" onclick="toggleAdminNavDropdown(this)"
                                            class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold transition-all {{ (request()->routeIs('central_admin.coupons.*') || request()->routeIs('central_admin.reviews.*') || request()->routeIs('central_admin.cms.*')) ? 'bg-gradient-to-r from-amber-500 to-orange-500 text-white shadow-md' : 'text-slate-300 hover:bg-[#2A3B5C] hover:text-white' }}">
                                        <i class="fa-solid fa-bullhorn text-sm"></i>
                                        <span>การตลาด & CMS</span>
                                        <i class="fa-solid fa-chevron-down text-[9px] transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                                    </button>
                                    <div x-show="open" 
                                         x-transition:enter="transition ease-out duration-100"
                                         x-transition:enter-start="transform opacity-0 scale-95"
                                         x-transition:enter-end="transform opacity-100 scale-100"
                                         class="absolute left-0 mt-2 w-48 rounded-xl bg-slate-900 border border-slate-700/80 shadow-2xl py-2 z-50"
                                         style="display: none;">
                                        
                                        <a href="{{ route('central_admin.coupons.index') }}" 
                                           class="flex items-center gap-2 px-4 py-2 text-xs font-bold transition-all {{ request()->routeIs('central_admin.coupons.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                                            <i class="fa-solid fa-ticket w-4"></i> คูปองส่วนลด
                                        </a>
                                        <a href="{{ route('central_admin.reviews.index') }}" 
                                           class="flex items-center gap-2 px-4 py-2 text-xs font-bold transition-all {{ request()->routeIs('central_admin.reviews.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                                            <i class="fa-solid fa-star w-4"></i> รีวิวของลูกค้า
                                        </a>
                                        <a href="{{ route('central_admin.articles.index') }}" 
                                           class="flex items-center gap-2 px-4 py-2 text-xs font-bold transition-all {{ request()->routeIs('central_admin.articles.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                                            <i class="fa-solid fa-newspaper w-4"></i> จัดการบทความ
                                        </a>
                                        <a href="{{ route('central_admin.notifications.index') }}" 
                                           class="flex items-center gap-2 px-4 py-2 text-xs font-bold transition-all {{ request()->routeIs('central_admin.notifications.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                                            <i class="fa-solid fa-bell w-4"></i> แจ้งเตือนลูกค้า
                                        </a>
                                        <a href="{{ route('central_admin.cms.index') }}" 
                                           class="flex items-center gap-2 px-4 py-2 text-xs font-bold transition-all {{ request()->routeIs('central_admin.cms.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                                            <i class="fa-solid fa-window-restore w-4"></i> จัดการหน้าแรก
                                        </a>
                                        @if(auth()->user()->role === 'super_admin')
                                        <a href="{{ route('central_admin.users.index') }}" 
                                           class="flex items-center gap-2 px-4 py-2 text-xs font-bold transition-all {{ request()->routeIs('central_admin.users.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                                            <i class="fa-solid fa-users-gear w-4"></i> จัดการสมาชิก & สิทธิ์
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- Chats -->
                            <a href="{{ route('admin.chats.index') }}" 
                               class="relative flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.chats.*') ? 'bg-gradient-to-r from-rose-600 to-pink-600 text-white shadow-md scale-105' : 'text-slate-300 hover:bg-[#2A3B5C] hover:text-white' }}"
                               title="แชทลูกค้า">
                                <i class="fa-solid fa-comment-dots text-sm"></i>
                                <span class="hidden md:inline">แชท</span>
                                <span class="nav-chat-badge absolute -top-1 -right-1 bg-blue-500 text-white rounded-full text-[9px] w-4 h-4 flex items-center justify-center font-extrabold shadow-md animate-pulse" style="{{ $unreadMessagesCount > 0 ? '' : 'display:none' }}">
                                    {{ $unreadMessagesCount }}
                                </span>
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-1.5 border border-[#2A3B5C] text-sm leading-4 font-medium rounded-xl text-slate-300 bg-[#121C30]/50 hover:text-white hover:border-slate-400 focus:outline-none transition ease-in-out duration-150">
                            <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}" class="w-6 h-6 rounded-full object-cover mr-2 border border-slate-400">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            👤 แก้ไขข้อมูลส่วนตัว
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                🚪 ออกจากระบบ
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-400 hover:text-white hover:bg-[#2A3B5C] focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-[#121C30]/95 border-t border-[#2A3B5C]">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-slate-300">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if(auth()->user()->role !== 'customer')
                @php
                    $lastViewedOrdersAt = session('last_viewed_orders_at');
                    $ordersQuery = \App\Models\Order::where('status', 'pending_verification');
                    if ($lastViewedOrdersAt) {
                        $ordersQuery->where('created_at', '>', $lastViewedOrdersAt);
                    }
                    $pendingOrdersCount = $ordersQuery->count();

                    $unreadMessagesCount = \App\Models\Message::whereNull('receiver_id')
                        ->where('is_read', false)
                        ->count();
                @endphp
                
                @if(in_array(auth()->user()->role, ['admin', 'super_admin']))
                    <x-responsive-nav-link :href="route('central_admin.products.index')" :active="request()->routeIs('central_admin.products.*')" class="text-slate-300">
                        📱 จัดการสินค้า
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('central_admin.categories.index')" :active="request()->routeIs('central_admin.categories.*')" class="text-slate-300">
                        📁 จัดการหมวดหมู่
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('central_admin.brands.index')" :active="request()->routeIs('central_admin.brands.*')" class="text-slate-300">
                        🏷️ จัดการแบรนด์
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('central_admin.coupons.index')" :active="request()->routeIs('central_admin.coupons.*')" class="text-slate-300">
                        🎟️ จัดการคูปอง
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('central_admin.reviews.index')" :active="request()->routeIs('central_admin.reviews.*')" class="text-slate-300">
                        ⭐ จัดการรีวิว
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('central_admin.articles.index')" :active="request()->routeIs('central_admin.articles.*')" class="text-slate-300">
                        📰 จัดการบทความ
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('central_admin.cms.index')" :active="request()->routeIs('central_admin.cms.*')" class="text-slate-300">
                        🖥️ จัดการหน้าแรก (CMS)
                    </x-responsive-nav-link>
                    @if(auth()->user()->role === 'super_admin')
                    <x-responsive-nav-link :href="route('central_admin.users.index')" :active="request()->routeIs('central_admin.users.*')" class="text-slate-300">
                        👥 จัดการสมาชิก & สิทธิ์ (Super Admin)
                    </x-responsive-nav-link>
                    @endif
                @endif

                <x-responsive-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.index')" class="text-slate-300 flex items-center justify-between">
                    <span>📦 จัดการคำสั่งซื้อ</span>
                    <span class="nav-order-badge px-2.5 py-0.5 text-[11px] bg-rose-600 text-white rounded-full font-bold shadow-sm animate-bounce" style="{{ $pendingOrdersCount > 0 ? '' : 'display:none' }}">
                        {{ $pendingOrdersCount }}
                    </span>
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('admin.stock.index')" :active="request()->routeIs('admin.stock.index')" class="text-slate-300">
                    📦 จัดการสต๊อกสินค้า
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('admin.claims.index')" :active="request()->routeIs('admin.claims.index')" class="text-slate-300">
                    🔧 จัดการงานซ่อม/เคลม
                </x-responsive-nav-link>
                
                <x-responsive-nav-link :href="route('admin.chats.index')" :active="request()->routeIs('admin.chats.index')" class="text-slate-300 flex items-center justify-between">
                    <span>💬 ห้องแชทบริการลูกค้า</span>
                    <span class="nav-chat-badge px-2.5 py-0.5 text-[11px] bg-blue-600 text-white rounded-full font-bold shadow-sm" style="{{ $unreadMessagesCount > 0 ? '' : 'display:none' }}">
                        {{ $unreadMessagesCount }}
                    </span>
                </x-responsive-nav-link>
            @endif
        </div>

@if(auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'super_admin'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentUnreadChats = {{ $unreadMessagesCount }};
        let currentPendingOrders = {{ $pendingOrdersCount }};

        // Synthesize nice digital chime for admin alerts using Web Audio API
        function playAdminNotificationSound() {
            try {
                let ctx = new (window.AudioContext || window.webkitAudioContext)();
                let playNote = (frequency, startTime, duration) => {
                    let osc = ctx.createOscillator();
                    let gain = ctx.createGain();
                    
                    osc.type = 'sine';
                    osc.frequency.setValueAtTime(frequency, startTime);
                    
                    gain.gain.setValueAtTime(0.15, startTime);
                    gain.gain.exponentialRampToValueAtTime(0.001, startTime + duration);
                    
                    osc.connect(gain);
                    gain.connect(ctx.destination);
                    
                    osc.start(startTime);
                    osc.stop(startTime + duration);
                };
                
                let now = ctx.currentTime;
                playNote(523.25, now, 0.12); // C5
                playNote(659.25, now + 0.08, 0.12); // E5
                playNote(783.99, now + 0.16, 0.25); // G5
            } catch(e) {
                console.log('Audio playback blocked or failed:', e);
            }
        }

        function pollNotifications() {
            fetch('/admin/notification-counts?_t=' + Date.now(), {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Cache-Control': 'no-cache',
                    'Pragma': 'no-cache'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.unread_chats > currentUnreadChats) {
                    playAdminNotificationSound();
                }
                
                currentUnreadChats = data.unread_chats;
                currentPendingOrders = data.pending_orders;

                // Update UI badges in the navigation bar (desktop and mobile responsive)
                document.querySelectorAll('.nav-chat-badge').forEach(el => {
                    el.textContent = data.unread_chats;
                    if (data.unread_chats > 0) {
                        el.style.display = 'inline-flex';
                    } else {
                        el.style.display = 'none';
                    }
                });

                document.querySelectorAll('.nav-order-badge').forEach(el => {
                    el.textContent = data.pending_orders;
                    if (data.pending_orders > 0) {
                        el.style.display = 'inline-flex';
                    } else {
                        el.style.display = 'none';
                    }
                });
            })
            .catch(err => console.error('Error polling admin notifications:', err));
        }

        // Poll every 3 seconds for real-time notifications
        setInterval(pollNotifications, 3000);

        // Real-time broadcast listener
        if (typeof window.Echo !== 'undefined') {
            window.Echo.channel('admin-notifications')
                .listen('.new.order', (e) => {
                    playAdminNotificationSound();
                    pollNotifications(); // Immediately refresh the counts
                });
        }
    });
</script>
@endif

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-[#2A3B5C]">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-slate-400">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-slate-300">
                    👤 แก้ไขข้อมูลส่วนตัว
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')" class="text-slate-300"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        🚪 ออกจากระบบ
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

<script>
    function toggleAdminNavDropdown(btn) {
        const container = btn.closest('.relative');
        if (!container) return;
        const menu = container.querySelector('.absolute');
        if (!menu) return;

        const isHidden = menu.style.display === 'none' || getComputedStyle(menu).display === 'none';

        // Close all other nav dropdowns first
        document.querySelectorAll('nav .relative .absolute').forEach(el => {
            if (el !== menu) el.style.display = 'none';
        });

        if (isHidden) {
            menu.style.display = 'block';
        } else {
            menu.style.display = 'none';
        }
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('nav .relative')) {
            document.querySelectorAll('nav .relative .absolute').forEach(el => {
                el.style.display = 'none';
            });
        }
    });
</script>

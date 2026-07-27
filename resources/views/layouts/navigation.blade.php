@php
    $pendingOrdersCount = 0;
    $unreadMessagesCount = 0;
@endphp
<nav x-data="{ open: false }" class="bg-[#0F172A] border-b border-[#FFE600]/20 shadow-lg transition-all duration-300 {{ !request()->routeIs('admin.*') && !request()->routeIs('central_admin.*') && !request()->routeIs('dashboard') ? 'hidden' : '' }}">
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
                            $pendingOrdersCount = \App\Models\Order::whereIn('status', ['pending_verification', 'pending'])->count();

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
                                         class="admin-nav-dropdown-menu absolute left-0 mt-2 w-48 rounded-xl bg-slate-900 border border-slate-700/80 shadow-2xl py-2 z-50"
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
                                    <span class="nav-order-badge absolute -top-1 -right-1 bg-rose-600 text-white rounded-full text-[9px] w-4 h-4 flex items-center justify-center font-extrabold shadow-md animate-bounce" style="{{ $pendingOrdersCount > 0 ? '' : 'display:none' }}">
                                        {{ $pendingOrdersCount }}
                                    </span>
                                    <i class="fa-solid fa-chevron-down text-[9px] transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                                </button>
                                <div x-show="open" 
                                     x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     class="admin-nav-dropdown-menu absolute left-0 mt-2 w-48 rounded-xl bg-slate-900 border border-slate-700/80 shadow-2xl py-2 z-50"
                                     style="display: none;">
                                    
                                    <a href="{{ route('admin.orders.index') }}" 
                                       class="flex items-center justify-between px-4 py-2 text-xs font-bold transition-all {{ request()->routeIs('admin.orders.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                                        <span class="flex items-center gap-2"><i class="fa-solid fa-receipt w-4"></i> ออเดอร์สั่งซื้อ</span>
                                        <span class="nav-order-badge bg-rose-600 text-white text-[9px] px-1.5 py-0.5 rounded-full font-bold" style="{{ $pendingOrdersCount > 0 ? '' : 'display:none' }}">{{ $pendingOrdersCount }}</span>
                                    </a>
                                    <a href="{{ route('admin.claims.index') }}" 
                                       class="flex items-center gap-2 px-4 py-2 text-xs font-bold transition-all {{ request()->routeIs('admin.claims.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                                        <i class="fa-solid fa-wrench w-4"></i> งานซ่อม/เคลม
                                    </a>
                                    {{-- Quotation link removed --}}
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
                                         class="admin-nav-dropdown-menu absolute left-0 mt-2 w-48 rounded-xl bg-slate-900 border border-slate-700/80 shadow-2xl py-2 z-50"
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
    if (!window.DDPhoneAudio) {
        window.DDPhoneAudio = (function() {
            let ctx = null;

            // Get or create AudioContext — NEVER plays any sound
            function getCtx() {
                if (!ctx) {
                    try {
                        ctx = new (window.AudioContext || window.webkitAudioContext)();
                    } catch(e) {}
                }
                return ctx;
            }

            // Resume suspended context silently (browser autoplay policy)
            function ensureRunning() {
                const c = getCtx();
                if (c && c.state === 'suspended') {
                    c.resume().catch(() => {});
                }
                return c;
            }

            // Auto-resume on ANY user gesture (no sound, just resumes context)
            const _resume = () => { ensureRunning(); };
            ['click','touchstart','keydown','scroll'].forEach(e =>
                window.addEventListener(e, _resume, {passive: true})
            );

            // Play a single oscillator tone — pure WebAudio, no HTML5 audio
            function playTone(freq, delay, dur, vol) {
                const c = ensureRunning();
                if (!c) return;
                try {
                    const now = c.currentTime;
                    const osc  = c.createOscillator();
                    const gain = c.createGain();
                    osc.type = 'triangle';
                    osc.frequency.setValueAtTime(freq, now + delay);
                    gain.gain.setValueAtTime(vol, now + delay);
                    gain.gain.exponentialRampToValueAtTime(0.0001, now + delay + dur);
                    osc.connect(gain);
                    gain.connect(c.destination);
                    osc.start(now + delay);
                    osc.stop(now + delay + dur + 0.05);
                } catch(e) {}
            }

            return {
                // Unlock ONLY resumes AudioContext — does NOT play any sound
                unlock() { ensureRunning(); },

                // Order notification: 4-note ascending chime
                playNotification() {
                    playTone(523.25, 0,    0.15, 0.7);
                    playTone(659.25, 0.18, 0.15, 0.8);
                    playTone(783.99, 0.36, 0.15, 0.9);
                    playTone(1046.5, 0.54, 0.25, 1.0);
                },

                // Chat notification: 2-note short ping
                playChat() {
                    playTone(1046.5,  0,    0.12, 0.7);
                    playTone(1318.51, 0.15, 0.18, 0.8);
                }
            };
        })();
    }

    document.addEventListener('DOMContentLoaded', function() {
        // ─── Initial state from server ────────────────────────────────────────
        let currentUnreadChats   = {{ $unreadMessagesCount }};
        let currentPendingOrders = {{ $pendingOrdersCount }};
        let isInitialPoll        = true;

        // ─── Persist alerted order IDs in sessionStorage (survives page navigation) ──
        const STORAGE_KEY = 'ddphone_alerted_order_ids';
        function getAlertedIds() {
            try { return new Set(JSON.parse(sessionStorage.getItem(STORAGE_KEY) || '[]')); }
            catch(e) { return new Set(); }
        }
        function saveAlertedId(id) {
            try {
                const ids = getAlertedIds();
                ids.add(id);
                // Keep only last 50 IDs to avoid storage bloat
                const arr = [...ids].slice(-50);
                sessionStorage.setItem(STORAGE_KEY, JSON.stringify(arr));
            } catch(e) {}
        }
        function hasAlerted(id) { return getAlertedIds().has(id); }

        // Cooldown timestamp (also persisted so page-change doesn't reset it)
        function getLastAlertTime() {
            return parseInt(sessionStorage.getItem('ddphone_last_alert_time') || '0');
        }
        function setLastAlertTime() {
            sessionStorage.setItem('ddphone_last_alert_time', String(Date.now()));
        }

        // ─── Play sound exactly 3 times then stop (with 900ms gap) ───────────
        function playOrderSound() {
            let played = 0;
            function tick() {
                if (played >= 3) return;
                played++;
                if (window.DDPhoneAudio) window.DDPhoneAudio.playNotification();
                if (played < 3) setTimeout(tick, 900);
            }
            tick();
        }

        // ─── Inline DOM Toast ─────────────────────────────────────────────────
        function showToast(emoji, title, text, bgColor, href) {
            const existing = document.getElementById('ddphone-admin-toast');
            if (existing) existing.remove();

            if (!document.getElementById('ddToastStyle')) {
                const st = document.createElement('style');
                st.id = 'ddToastStyle';
                st.textContent = `@keyframes ddToastIn{from{transform:translateY(-30px) scale(0.85);opacity:0}to{transform:translateY(0) scale(1);opacity:1}}`;
                document.head.appendChild(st);
            }

            const toast = document.createElement('div');
            toast.id = 'ddphone-admin-toast';
            toast.style.cssText = `position:fixed;top:20px;right:20px;z-index:99999;background:${bgColor};color:#fff;padding:14px 20px;border-radius:16px;box-shadow:0 8px 32px rgba(0,0,0,0.3);font-family:inherit;font-weight:700;max-width:340px;cursor:pointer;animation:ddToastIn 0.35s cubic-bezier(0.34,1.56,0.64,1);display:flex;flex-direction:column;gap:4px;`;
            toast.innerHTML = `<div style="font-size:1.05rem;">${emoji} ${title}</div><div style="font-size:0.83rem;opacity:0.92;font-weight:500;">${text}</div><div style="font-size:0.75rem;opacity:0.7;margin-top:2px;">คลิกเพื่อดูรายละเอียด →</div>`;
            if (href) toast.onclick = () => window.location.href = href;
            document.body.appendChild(toast);
            setTimeout(() => { if (toast.parentNode) toast.remove(); }, 12000);

            // SweetAlert2 (if loaded) — replaces DOM toast
            if (typeof Swal !== 'undefined') {
                toast.style.display = 'none';
                Swal.fire({
                    toast: true, position: 'top-end', icon: 'warning',
                    title: `${emoji} ${title}`, text: text,
                    showConfirmButton: true,
                    confirmButtonText: href && href.includes('order') ? '📦 ดูออเดอร์' : '💬 ดูแชท',
                    timer: 12000, timerProgressBar: true
                }).then(r => { if (r.isConfirmed && href) window.location.href = href; });
            }
        }

        // ─── Alert triggers ───────────────────────────────────────────────────
        function triggerOrderAlert(orderId, orderNum, count) {
            // Guard: don't alert if this specific order ID was already alerted in this session
            if (hasAlerted(orderId)) return;

            saveAlertedId(orderId);
            sessionStorage.setItem('ddphone_last_order_alert_time', String(Date.now()));

            playOrderSound(); // ring exactly 3 times then stop
            showToast(
                '🔔',
                'ลูกค้าชำระเงินแล้ว! #' + (orderNum || orderId),
                'มีสลิปโอนเงินรอตรวจสอบ ' + count + ' รายการ',
                'linear-gradient(135deg,#dc2626,#b91c1c)',
                "{{ route('admin.orders.index') }}"
            );
        }

        function triggerChatAlert(chatCount) {
            const now = Date.now();
            const lastChatAlert = parseInt(sessionStorage.getItem('ddphone_last_chat_alert_time') || '0');
            const CHAT_COOLDOWN = 15000; // 15s cooldown for chat alerts

            if ((now - lastChatAlert) < CHAT_COOLDOWN) return;
            sessionStorage.setItem('ddphone_last_chat_alert_time', String(now));

            if (window.DDPhoneAudio) window.DDPhoneAudio.playChat();
            showToast(
                '💬', 'มีข้อความแชทใหม่!',
                'มีลูกค้าทักแชทเข้ามา ' + chatCount + ' ข้อความ',
                'linear-gradient(135deg,#2563eb,#1d4ed8)',
                "{{ route('admin.chats.index') }}"
            );
        }

        // ─── Main Poll (every 3s) ─────────────────────────────────────────────
        function pollNotifications() {
            fetch('/admin/notification-counts?_t=' + Date.now(), {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Cache-Control': 'no-cache, no-store',
                    'Pragma': 'no-cache'
                }
            })
            .then(res => res.json())
            .then(data => {
                const newOrders = data.pending_orders  || 0;
                const newChats  = data.unread_chats    || 0;
                const latestId  = data.latest_order_id || null;
                const latestNum = data.latest_order_num || (latestId ? String(latestId).padStart(5,'0') : '');

                if (!isInitialPoll) {
                    // New paid order: latestId is known but not yet alerted
                    if (latestId && !hasAlerted(latestId) && newOrders > 0) {
                        triggerOrderAlert(latestId, latestNum, newOrders);
                    }
                    // New chat
                    if (newChats > currentUnreadChats) {
                        triggerChatAlert(newChats);
                    }
                }

                isInitialPoll        = false;
                currentUnreadChats   = newChats;
                currentPendingOrders = newOrders;

                // Update nav badges
                document.querySelectorAll('.nav-chat-badge').forEach(el => {
                    el.textContent   = newChats;
                    el.style.display = newChats  > 0 ? 'inline-flex' : 'none';
                });
                document.querySelectorAll('.nav-order-badge').forEach(el => {
                    el.textContent   = newOrders;
                    el.style.display = newOrders > 0 ? 'inline-flex' : 'none';
                });
            })
            .catch(err => console.warn('Notification poll error:', err));
        }

        setInterval(pollNotifications, 3000); // poll every 3s (stable & light)
        pollNotifications();                  // immediate first run

        // WebSocket fallback
        if (typeof window.Echo !== 'undefined') {
            window.Echo.channel('admin-notifications')
                .listen('.new.order', (e) => {
                    const oid  = e.order_id || null;
                    const onum = oid ? String(oid).padStart(5,'0') : '';
                    if (oid) triggerOrderAlert(oid, onum, currentPendingOrders + 1);
                    pollNotifications();
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
    // ใช้ data-attribute แทน style.display เพื่อไม่ชนกับ Alpine.js x-show
    function toggleAdminNavDropdown(btn) {
        const container = btn.closest('.relative');
        if (!container) return;

        // ดึง Alpine component instance ของ container นี้
        const alpineEl = container.__x;
        if (alpineEl) {
            // ปิด dropdown อื่นๆ ทั้งหมดก่อน (via Alpine)
            document.querySelectorAll('nav .relative[x-data]').forEach(el => {
                if (el !== container && el.__x) {
                    el.__x.$data.open = false;
                }
            });
            // Toggle ของตัวเอง
            alpineEl.$data.open = !alpineEl.$data.open;
        }
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('nav .relative')) {
            document.querySelectorAll('nav .relative[x-data]').forEach(el => {
                if (el.__x) el.__x.$data.open = false;
            });
        }
    });
</script>


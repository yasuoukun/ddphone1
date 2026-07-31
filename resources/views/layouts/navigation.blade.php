@php
    $pendingOrdersCount = 0;
    $unreadMessagesCount = 0;
@endphp
<nav id="mobile-admin-nav-bar" x-data="{ open: false }" class="bg-[#0F172A] border-b border-[#FFE600]/20 shadow-lg transition-all duration-300 {{ !request()->routeIs('admin.*') && !request()->routeIs('central_admin.*') && !request()->routeIs('dashboard') && !request()->routeIs('profile.edit') ? 'hidden' : '' }}">
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
                                <!-- Products -->
                                <a href="{{ route('central_admin.products.index') }}" 
                                   class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('central_admin.products.*') ? 'bg-gradient-to-r from-violet-600 to-purple-600 text-white shadow-md scale-105' : 'text-slate-300 hover:bg-[#2A3B5C] hover:text-white' }}">
                                    <i class="fa-solid fa-mobile-screen-button text-sm"></i>
                                    <span>สินค้า</span>
                                </a>

                                <!-- Orders -->
                                <a href="{{ route('admin.orders.index') }}" 
                                   class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold transition-all relative {{ request()->routeIs('admin.orders.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md scale-105' : 'text-slate-300 hover:bg-[#2A3B5C] hover:text-white' }}">
                                    <i class="fa-solid fa-receipt text-sm"></i>
                                    <span>ออเดอร์</span>
                                    <span class="nav-order-badge absolute -top-1 -right-1 bg-rose-600 text-white rounded-full text-[9px] w-4 h-4 flex items-center justify-center font-extrabold shadow-md animate-bounce" style="{{ $pendingOrdersCount > 0 ? '' : 'display:none' }}">
                                        {{ $pendingOrdersCount }}
                                    </span>
                                </a>

                                <!-- Claims -->
                                <a href="{{ route('admin.claims.index') }}" 
                                   class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold transition-all relative {{ request()->routeIs('admin.claims.*') ? 'bg-gradient-to-r from-orange-500 to-red-500 text-white shadow-md scale-105' : 'text-slate-300 hover:bg-[#2A3B5C] hover:text-white' }}">
                                    <i class="fa-solid fa-wrench text-sm"></i>
                                    <span>เคลมซ่อม</span>
                                    <span class="nav-claim-badge absolute -top-1 -right-1 bg-rose-600 text-white rounded-full text-[9px] w-4 h-4 flex items-center justify-center font-extrabold shadow-md animate-bounce" style="display:none">0</span>
                                </a>

                                <!-- More Settings Dropdown -->
                                <div x-data="{ open: false }" class="relative" @click.away="open = false">
                                    <button @click="open = !open" onclick="toggleAdminNavDropdown(this)"
                                            class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold transition-all {{ (request()->routeIs('central_admin.categories.*') || request()->routeIs('central_admin.brands.*') || request()->routeIs('admin.stock.*') || request()->routeIs('central_admin.coupons.*') || request()->routeIs('central_admin.reviews.*') || request()->routeIs('central_admin.cms.*')) ? 'bg-gradient-to-r from-amber-500 to-orange-500 text-white shadow-md' : 'text-slate-300 hover:bg-[#2A3B5C] hover:text-white' }}">
                                        <i class="fa-solid fa-bars text-sm"></i>
                                        <span>จัดการอื่นๆ</span>
                                        <i class="fa-solid fa-chevron-down text-[9px] transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                                    </button>
                                    <div x-show="open" 
                                         x-transition:enter="transition ease-out duration-100"
                                         x-transition:enter-start="transform opacity-0 scale-95"
                                         x-transition:enter-end="transform opacity-100 scale-100"
                                         class="admin-nav-dropdown-menu absolute left-0 mt-2 w-48 rounded-xl bg-slate-900 border border-slate-700/80 shadow-2xl py-2 z-50"
                                         style="display: none;">
                                        
                                        <a href="{{ route('central_admin.categories.index') }}" class="flex items-center gap-2 px-4 py-2 text-xs font-bold transition-all hover:bg-slate-800 text-slate-300 hover:text-white"><i class="fa-solid fa-folder-open w-4"></i> หมวดหมู่สินค้า</a>
                                        <a href="{{ route('central_admin.brands.index') }}" class="flex items-center gap-2 px-4 py-2 text-xs font-bold transition-all hover:bg-slate-800 text-slate-300 hover:text-white"><i class="fa-solid fa-tags w-4"></i> แบรนด์สินค้า</a>
                                        <a href="{{ route('admin.stock.index') }}" class="flex items-center gap-2 px-4 py-2 text-xs font-bold transition-all hover:bg-slate-800 text-slate-300 hover:text-white"><i class="fa-solid fa-warehouse w-4"></i> จัดการสต๊อก</a>
                                        <div class="border-t border-slate-700 my-1"></div>
                                        <a href="{{ route('central_admin.coupons.index') }}" class="flex items-center gap-2 px-4 py-2 text-xs font-bold transition-all hover:bg-slate-800 text-slate-300 hover:text-white"><i class="fa-solid fa-ticket w-4"></i> คูปองส่วนลด</a>
                                        <a href="{{ route('central_admin.reviews.index') }}" class="flex items-center gap-2 px-4 py-2 text-xs font-bold transition-all hover:bg-slate-800 text-slate-300 hover:text-white"><i class="fa-solid fa-star w-4"></i> รีวิวของลูกค้า</a>
                                        <a href="{{ route('central_admin.articles.index') }}" class="flex items-center gap-2 px-4 py-2 text-xs font-bold transition-all hover:bg-slate-800 text-slate-300 hover:text-white"><i class="fa-solid fa-newspaper w-4"></i> จัดการบทความ</a>
                                        <a href="{{ route('central_admin.notifications.index') }}" class="flex items-center gap-2 px-4 py-2 text-xs font-bold transition-all hover:bg-slate-800 text-slate-300 hover:text-white"><i class="fa-solid fa-bell w-4"></i> แจ้งเตือนลูกค้า</a>
                                        <a href="{{ route('central_admin.cms.index') }}" class="flex items-center gap-2 px-4 py-2 text-xs font-bold transition-all hover:bg-slate-800 text-slate-300 hover:text-white"><i class="fa-solid fa-window-restore w-4"></i> จัดการหน้าแรก</a>
                                        
                                        @if(auth()->user()->role === 'super_admin')
                                        <div class="border-t border-slate-700 my-1"></div>
                                        <a href="{{ route('central_admin.users.index') }}" class="flex items-center gap-2 px-4 py-2 text-xs font-bold transition-all hover:bg-slate-800 text-slate-300 hover:text-white"><i class="fa-solid fa-users w-4"></i> จัดการแอดมิน</a>
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

            <!-- Hamburger Mobile Menu Toggle (Only for customers) -->
            @if(auth()->check() && auth()->user()->role === 'customer')
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" 
                        class="w-10 h-10 rounded-xl bg-[#1E293B] border border-[#2A3B5C] text-[#FFE600] hover:text-white hover:bg-[#2A3B5C] flex items-center justify-center text-lg focus:outline-none transition-all duration-200 shadow-sm"
                        title="เปิด/ปิด เมนู">
                    <i class="fa-solid" :class="open ? 'fa-xmark text-xl text-rose-400' : 'fa-bars text-lg'"></i>
                </button>
            </div>
            @endif
        </div>
    </div>
</nav>

<!-- Admin Mobile Drawer Wrapper -->
<div x-data="{ showAdminDrawer: false }" @toggle-admin-drawer.window="showAdminDrawer = !showAdminDrawer">
    <!-- Invisible backdrop overlay to close popup on outside click -->
    <div class="mobile-drawer-overlay" :class="showAdminDrawer ? 'open' : ''" @click="showAdminDrawer = false"></div>

    <!-- Admin Mobile Floating Popup Modal Card (Shopee/Storefront Light Style) -->
    <div class="mobile-drawer shadow-2xl" :class="showAdminDrawer ? 'open' : ''" style="background: #FFFFFF !important; border: 1.5px solid #E2E8F0 !important;">
    @if(auth()->check() && auth()->user()->role !== 'customer')
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

        <!-- Header / User Profile -->
        <div style="padding: 0.5rem 0.25rem; border-bottom: 1px solid #F1F5F9; margin-bottom: 0.25rem;">
            <div style="display: flex; align-items: center; justify-content: space-between; padding: 8px 10px; border-radius: 14px; background: #F8FAFC; border: 1px solid #E2E8F0;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <img src="{{ Auth::user()->avatar_url }}" alt="" style="width: 34px; height: 34px; border-radius: 50%; object-fit: cover; border: 2px solid #6366F1; flex-shrink: 0;">
                    <div>
                        <div style="font-size: 0.84rem; font-weight: 800; color: #0F172A; line-height: 1.2;">{{ Auth::user()->name }}</div>
                        <div style="font-size: 0.68rem; color: #64748B; font-weight: 600; word-break: break-all; overflow-wrap: anywhere;">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <span style="font-size: 10px; font-weight: 900; text-transform: uppercase; padding: 4px 10px; border-radius: 99px; background: #EEF2FF; color: #4F46E5; border: 1px solid #C7D2FE;">{{ Auth::user()->role }}</span>
            </div>
        </div>

        <!-- Management Menu Grid -->
        <div style="padding: 0.25rem 0;">
            <div style="font-size: 0.74rem; font-weight: 900; color: #0F172A; text-transform: uppercase; margin-bottom: 8px; display: flex; align-items: center; justify-content: space-between; padding: 0 4px;">
                <span style="display: flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-layer-group" style="color: #6366F1;"></i> การจัดการระบบทั้งหมด
                </span>
                <span style="font-size: 10px; color: #94A3B8; font-weight: 700;">Admin Menu</span>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                <a href="{{ route('admin.chats.index') }}" class="menu-popup-item" style="display: flex; align-items: center; gap: 10px; padding: 9px 10px; border-radius: 14px; background: #F8FAFC; border: 1px solid #E2E8F0; text-decoration: none; color: #1E293B; font-size: 0.78rem; font-weight: 800; grid-column: span 2;">
                    <span style="width: 30px; height: 30px; border-radius: 10px; background: #DBEAFE; display: flex; align-items: center; justify-content: center; color: #2563EB; font-size: 0.88rem; flex-shrink: 0; position: relative;">
                        <i class="fa-solid fa-comment-dots"></i>
                        @if($unreadMessagesCount > 0)
                            <span style="position: absolute; top: -3px; right: -3px; width: 10px; height: 10px; background: #2563EB; border-radius: 50%; border: 2px solid #FFFFFF;"></span>
                        @endif
                    </span>
                    <span style="flex-grow: 1; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">แชทลูกค้า</span>
                    @if($unreadMessagesCount > 0)
                        <span style="font-size: 10px; font-weight: 900; background: #2563EB; color: white; padding: 2px 7px; border-radius: 99px;">{{ $unreadMessagesCount }}</span>
                    @endif
                </a>
                <a href="{{ route('central_admin.products.index') }}" class="menu-popup-item" style="display: flex; align-items: center; gap: 10px; padding: 9px 10px; border-radius: 14px; background: #F8FAFC; border: 1px solid #E2E8F0; text-decoration: none; color: #1E293B; font-size: 0.78rem; font-weight: 800;">
                    <span style="width: 30px; height: 30px; border-radius: 10px; background: #F3E8FF; display: flex; align-items: center; justify-content: center; color: #9333EA; font-size: 0.88rem; flex-shrink: 0;"><i class="fa-solid fa-mobile-screen-button"></i></span>
                    <span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">จัดการสินค้า</span>
                </a>
                <a href="{{ route('admin.stock.index') }}" class="menu-popup-item" style="display: flex; align-items: center; gap: 10px; padding: 9px 10px; border-radius: 14px; background: #F8FAFC; border: 1px solid #E2E8F0; text-decoration: none; color: #1E293B; font-size: 0.78rem; font-weight: 800;">
                    <span style="width: 30px; height: 30px; border-radius: 10px; background: #ECFDF5; display: flex; align-items: center; justify-content: center; color: #059669; font-size: 0.88rem; flex-shrink: 0;"><i class="fa-solid fa-warehouse"></i></span>
                    <span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">จัดการสต๊อก</span>
                </a>
                <a href="{{ route('central_admin.categories.index') }}" class="menu-popup-item" style="display: flex; align-items: center; gap: 10px; padding: 9px 10px; border-radius: 14px; background: #F8FAFC; border: 1px solid #E2E8F0; text-decoration: none; color: #1E293B; font-size: 0.78rem; font-weight: 800;">
                    <span style="width: 30px; height: 30px; border-radius: 10px; background: #FEF3C7; display: flex; align-items: center; justify-content: center; color: #D97706; font-size: 0.88rem; flex-shrink: 0;"><i class="fa-solid fa-folder-open"></i></span>
                    <span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">หมวดหมู่</span>
                </a>
                <a href="{{ route('central_admin.brands.index') }}" class="menu-popup-item" style="display: flex; align-items: center; gap: 10px; padding: 9px 10px; border-radius: 14px; background: #F8FAFC; border: 1px solid #E2E8F0; text-decoration: none; color: #1E293B; font-size: 0.78rem; font-weight: 800;">
                    <span style="width: 30px; height: 30px; border-radius: 10px; background: #EFF6FF; display: flex; align-items: center; justify-content: center; color: #2563EB; font-size: 0.88rem; flex-shrink: 0;"><i class="fa-solid fa-tags"></i></span>
                    <span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">แบรนด์</span>
                </a>
                <a href="{{ route('central_admin.coupons.index') }}" class="menu-popup-item" style="display: flex; align-items: center; gap: 10px; padding: 9px 10px; border-radius: 14px; background: #F8FAFC; border: 1px solid #E2E8F0; text-decoration: none; color: #1E293B; font-size: 0.78rem; font-weight: 800;">
                    <span style="width: 30px; height: 30px; border-radius: 10px; background: #FFE4E6; display: flex; align-items: center; justify-content: center; color: #E11D48; font-size: 0.88rem; flex-shrink: 0;"><i class="fa-solid fa-ticket"></i></span>
                    <span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">คูปองส่วนลด</span>
                </a>
                <a href="{{ route('central_admin.reviews.index') }}" class="menu-popup-item" style="display: flex; align-items: center; gap: 10px; padding: 9px 10px; border-radius: 14px; background: #F8FAFC; border: 1px solid #E2E8F0; text-decoration: none; color: #1E293B; font-size: 0.78rem; font-weight: 800;">
                    <span style="width: 30px; height: 30px; border-radius: 10px; background: #FEF9C3; display: flex; align-items: center; justify-content: center; color: #CA8A04; font-size: 0.88rem; flex-shrink: 0;"><i class="fa-solid fa-star"></i></span>
                    <span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">รีวิวลูกค้า</span>
                </a>
                <a href="{{ route('central_admin.articles.index') }}" class="menu-popup-item" style="display: flex; align-items: center; gap: 10px; padding: 9px 10px; border-radius: 14px; background: #F8FAFC; border: 1px solid #E2E8F0; text-decoration: none; color: #1E293B; font-size: 0.78rem; font-weight: 800;">
                    <span style="width: 30px; height: 30px; border-radius: 10px; background: #CFFAFE; display: flex; align-items: center; justify-content: center; color: #0891B2; font-size: 0.88rem; flex-shrink: 0;"><i class="fa-solid fa-newspaper"></i></span>
                    <span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">บทความ</span>
                </a>
                <a href="{{ route('central_admin.cms.index') }}" class="menu-popup-item" style="display: flex; align-items: center; gap: 10px; padding: 9px 10px; border-radius: 14px; background: #F8FAFC; border: 1px solid #E2E8F0; text-decoration: none; color: #1E293B; font-size: 0.78rem; font-weight: 800;">
                    <span style="width: 30px; height: 30px; border-radius: 10px; background: #CCFBF1; display: flex; align-items: center; justify-content: center; color: #0D9488; font-size: 0.88rem; flex-shrink: 0;"><i class="fa-solid fa-window-restore"></i></span>
                    <span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">หน้าแรก (CMS)</span>
                </a>
                <a href="{{ route('admin.claims.index') }}" class="menu-popup-item" style="display: flex; align-items: center; gap: 10px; padding: 9px 10px; border-radius: 14px; background: #F8FAFC; border: 1px solid #E2E8F0; text-decoration: none; color: #1E293B; font-size: 0.78rem; font-weight: 800; grid-column: span 2;">
                    <span style="width: 30px; height: 30px; border-radius: 10px; background: #FFEDD5; display: flex; align-items: center; justify-content: center; color: #EA580C; font-size: 0.88rem; flex-shrink: 0; position: relative;">
                        <i class="fa-solid fa-wrench"></i>
                        <span class="nav-claim-dot" style="position: absolute; top: -3px; right: -3px; width: 10px; height: 10px; background: #E11D48; border-radius: 50%; border: 2px solid #FFFFFF; display: none;"></span>
                    </span>
                    <span style="flex-grow: 1; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">งานซ่อม / เคลมประกัน</span>
                    <span class="nav-claim-drawer-badge" style="font-size: 10px; font-weight: 900; background: #E11D48; color: white; padding: 2px 7px; border-radius: 99px; display: none;">0</span>
                </a>
                @if(auth()->user()->role === 'super_admin')
                <a href="{{ route('central_admin.users.index') }}" class="menu-popup-item" style="display: flex; align-items: center; gap: 10px; padding: 9px 10px; border-radius: 14px; background: #F8FAFC; border: 1px solid #E2E8F0; text-decoration: none; color: #1E293B; font-size: 0.78rem; font-weight: 800; grid-column: span 2;">
                    <span style="width: 30px; height: 30px; border-radius: 10px; background: #FCE7F3; display: flex; align-items: center; justify-content: center; color: #DB2777; font-size: 0.88rem; flex-shrink: 0;"><i class="fa-solid fa-users-gear"></i></span>
                    <span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">จัดการสมาชิก & สิทธิ์</span>
                </a>
                @endif
            </div>
        </div>

        <!-- Footer Actions -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-top: 6px; padding-top: 8px; border-top: 1px solid #F1F5F9;">
            <a href="{{ route('profile.edit') }}" style="display: flex; align-items: center; justify-content: center; gap: 6px; padding: 9px; border-radius: 12px; background: #F1F5F9; border: 1px solid #E2E8F0; color: #334155; text-decoration: none; font-size: 0.78rem; font-weight: 800;">
                <i class="fa-solid fa-user-pen" style="color: #4F46E5;"></i> โปรไฟล์
            </a>

            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 6px; padding: 9px; border-radius: 12px; background: #FEF2F2; border: 1px solid #FECACA; color: #DC2626; cursor: pointer; font-size: 0.78rem; font-weight: 800; font-family: 'Prompt', sans-serif;">
                    <i class="fa-solid fa-right-from-bracket"></i> ออกจากระบบ
                </button>
            </form>
        </div>
    @endif
    </div>
</div>

<!-- Admin Mobile Bottom Navigation Bar -->
@if(auth()->check() && in_array(auth()->user()->role, ['admin', 'super_admin']) && (request()->routeIs('admin.*') || request()->routeIs('central_admin.*') || request()->routeIs('profile.edit')))
<div class="admin-mobile-bottom-nav">
    <a href="{{ auth()->user()->role === 'super_admin' ? route('central_admin.dashboard') : route('admin.dashboard') }}" 
       class="admin-nav-item {{ request()->routeIs('*.dashboard') ? 'active' : '' }}">
        <i class="fa-solid fa-gauge-high"></i>
        <span>แดชบอร์ด</span>
    </a>

    <a href="{{ route('central_admin.products.index') }}" 
       class="admin-nav-item {{ request()->routeIs('central_admin.products.*') ? 'active' : '' }}">
        <i class="fa-solid fa-mobile-screen"></i>
        <span>สินค้า</span>
    </a>

    <a href="{{ route('admin.orders.index') }}" 
       class="admin-nav-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
        <i class="fa-solid fa-receipt"></i>
        <span class="nav-order-badge absolute -top-1 right-2 bg-rose-600 text-white rounded-full text-[9px] px-1 font-bold animate-bounce" style="{{ $pendingOrdersCount > 0 ? '' : 'display:none' }}">{{ $pendingOrdersCount }}</span>
        <span>ออเดอร์</span>
    </a>

    <a href="{{ route('admin.chats.index') }}" 
       class="admin-nav-item {{ request()->routeIs('admin.chats.*') ? 'active' : '' }}">
        <i class="fa-solid fa-comment-dots"></i>
        <span class="nav-chat-badge absolute -top-1 right-2 bg-blue-600 text-white rounded-full text-[9px] px-1 font-bold" style="{{ $unreadMessagesCount > 0 ? '' : 'display:none' }}">{{ $unreadMessagesCount }}</span>
        <span>แชท</span>
    </a>

    <button type="button" x-data @click="$dispatch('toggle-admin-drawer')" class="admin-nav-item focus:outline-none border-0 bg-transparent w-full">
        <i class="fa-solid fa-bars"></i>
        <span>เมนู</span>
    </button>
</div>
@endif

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

    // Global Notification Polling Manager for Admin (Chats, Orders & Claims)
    (function() {
        let lastUnreadChats = null;
        let lastPendingOrders = null;
        let lastPendingClaims = null;

        function showAdminToast(title, message, icon) {
            if (typeof Swal !== 'undefined') {
                Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                }).fire({ icon: icon || 'info', title: title, text: message });
            }
            if ('Notification' in window) {
                if (Notification.permission === 'granted') {
                    new Notification(title, { body: message, icon: '/images/logoddphone.png' });
                } else if (Notification.permission !== 'denied') {
                    Notification.requestPermission();
                }
            }
        }

        function pollAdminGlobalCounts() {
            fetch('{{ route('admin.notification_counts') }}?_t=' + Date.now(), {
                headers: { 'Cache-Control': 'no-cache', 'Pragma': 'no-cache' }
            })
            .then(res => res.json())
            .then(data => {
                const unreadChats = data.unread_chats || 0;
                const pendingOrders = data.pending_orders || 0;
                const pendingClaims = data.pending_claims || 0;

                // 1. Update Chat Badges across Navbar & Mobile Drawer
                document.querySelectorAll('.nav-chat-badge').forEach(el => {
                    el.textContent = unreadChats;
                    el.style.display = unreadChats > 0 ? '' : 'none';
                });

                // 2. Update Order Badges across Navbar & Mobile Drawer
                document.querySelectorAll('.nav-order-badge').forEach(el => {
                    el.textContent = pendingOrders;
                    el.style.display = pendingOrders > 0 ? '' : 'none';
                });

                // 3. Update Claim Badges (Desktop pill + Mobile drawer dot & count)
                document.querySelectorAll('.nav-claim-badge').forEach(el => {
                    el.textContent = pendingClaims;
                    el.style.display = pendingClaims > 0 ? '' : 'none';
                });
                document.querySelectorAll('.nav-claim-dot').forEach(el => {
                    el.style.display = pendingClaims > 0 ? '' : 'none';
                });
                document.querySelectorAll('.nav-claim-drawer-badge').forEach(el => {
                    el.textContent = pendingClaims;
                    el.style.display = pendingClaims > 0 ? '' : 'none';
                });

                // 4. Trigger Sound & Toast for New Chat (if not on /admin/chats page to avoid duplicate sound)
                if (lastUnreadChats !== null && unreadChats > lastUnreadChats) {
                    if (!window.location.pathname.includes('/admin/chats')) {
                        if (window.DDPhoneAudio) window.DDPhoneAudio.playChat();
                        showAdminToast('💬 แชทใหม่จากลูกค้า', 'มีข้อความใหม่จากลูกค้าทักเข้ามาครับ', 'info');
                    }
                }

                // 5. Trigger Sound & Toast for New Pending Order
                if (lastPendingOrders !== null && pendingOrders > lastPendingOrders) {
                    if (window.DDPhoneAudio) window.DDPhoneAudio.playNotification();
                    const orderNum = data.latest_order_num ? (' #' + data.latest_order_num) : '';
                    showAdminToast('📦 ออเดอร์ใหม่รอตรวจสอบ' + orderNum, 'มีรายการสั่งซื้อใหม่แจ้งเข้ามาในระบบครับ', 'success');
                }

                // 6. Trigger Sound & Toast for New Claim (pending or customer confirmed)
                if (lastPendingClaims !== null && pendingClaims > lastPendingClaims) {
                    if (window.DDPhoneAudio) window.DDPhoneAudio.playRepair();
                    const claimId = data.latest_claim_id ? (' [' + data.latest_claim_id + ']') : '';
                    showAdminToast('🔧 งานซ่อมใหม่เข้ามา' + claimId, 'มีรายการแจ้งซ่อม/เคลมใหม่รอดำเนินการครับ', 'warning');
                }

                lastUnreadChats = unreadChats;
                lastPendingOrders = pendingOrders;
                lastPendingClaims = pendingClaims;
            })
            .catch(err => {});
        }

        // Initial run & Interval setup (every 4 seconds)
        pollAdminGlobalCounts();
        setInterval(pollAdminGlobalCounts, 4000);
    })();
</script>


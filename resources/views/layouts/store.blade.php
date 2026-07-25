<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DDIT | จำหน่ายโทรศัพท์มือถือและสินค้าไอทีทุกประเภท ครบวงจร</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3/dist/cdn.min.js" defer></script>
    
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="antialiased" data-logged-in="{{ auth()->check() ? 'true' : 'false' }}">
    <div x-data="{ mobileMenuOpen: false }">

    <!-- Top Bar -->
    <div class="topbar" style="position: relative; z-index: 1100;">
        <div class="topbar-left">
            <a href="#"><i class="fa-brands fa-facebook"></i> Facebook</a>
            <a href="#"><i class="fa-brands fa-line"></i> Line</a>
        </div>
        <div class="topbar-right" x-data="{ openProfile: false }">
            @auth
                <div style="position: relative; display: inline-block; z-index: 1200;">
                    <button @click="openProfile = !openProfile" @click.away="openProfile = false" style="background: none; border: none; color: white; cursor: pointer; font-weight: 600; display: flex; align-items: center; gap: 8px; font-family: 'Prompt', sans-serif;">
                        <img src="{{ auth()->user()->avatar_url }}" alt="" style="width: 26px; height: 26px; border-radius: 50%; object-fit: cover; border: 1.5px solid rgba(255,255,255,0.6);">
                        <span>{{ auth()->user()->name }}</span> <span style="font-size: 0.75rem;">▼</span>
                    </button>
                    <div x-show="openProfile" x-transition style="display: none; position: absolute; right: 0; top: 100%; margin-top: 8px; background: white; border: 1px solid var(--color-silver); border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.15); z-index: 9999; min-width: 180px; text-align: left; padding: 0.5rem 0;">
                        <a href="{{ route('dashboard') }}" style="display: block; padding: 10px 15px; color: var(--color-navy-dark); text-decoration: none; font-weight: 500; font-size: 0.9rem;" onmouseover="this.style.background='var(--color-grey-bg)'" onmouseout="this.style.background='transparent'">
                            💻 แดชบอร์ด/โปรไฟล์
                        </a>
                        <hr style="border: 0; border-top: 1px solid var(--color-silver); margin: 0.25rem 0;">
                        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                            @csrf
                            <button type="submit" style="width: 100%; text-align: left; background: none; border: none; padding: 10px 15px; color: var(--color-danger); cursor: pointer; font-weight: 600; font-size: 0.9rem; font-family: 'Prompt', sans-serif;" onmouseover="this.style.background='rgba(239, 68, 68, 0.08)'" onmouseout="this.style.background='transparent'">
                                🚪 ออกจากระบบ
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}">เข้าสู่ระบบ</a>
                <a href="{{ route('register') }}">สมัครสมาชิก</a>
            @endauth
            @auth
                @if(auth()->user()->role === 'customer')
                <a href="javascript:void(0)" onclick="window.dispatchEvent(new CustomEvent('open-customer-chat'))" title="แชทติดต่อสอบถามกับร้านค้า" style="margin-left: 1.25rem; position: relative; display: inline-flex; align-items: center; color: white;">
                    <i class="fa-solid fa-comment-dots" style="font-size: 1.15rem;"></i>
                    <span class="customer-nav-chat-badge" style="display: none; position: absolute; top: -7px; right: -8px; background: #ef4444; color: white; border-radius: 50%; padding: 1px 5px; font-size: 0.65rem; font-weight: bold; min-width: 14px; text-align: center; line-height: 1.2;"></span>
                </a>
                @endif
            @endauth
            <!-- Notification Bell -->
            <div x-data="{ openNotification: false }" style="position: relative; display: inline-block; margin-left: 1.25rem; z-index: 1200;">
                <button @click="openNotification = !openNotification" @click.away="openNotification = false" title="การแจ้งเตือน" style="background: none; border: none; color: white; cursor: pointer; display: flex; align-items: center; position: relative;">
                    <i class="fa-solid fa-bell" style="font-size: 1.1rem;"></i>
                    @auth
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span style="position: absolute; top: -6px; right: -8px; background: #ef4444; color: white; border-radius: 50%; padding: 1px 5px; font-size: 0.65rem; font-weight: bold; min-width: 14px; text-align: center; line-height: 1.2;">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    @endauth
                </button>
                @auth
                    <div x-show="openNotification" x-transition style="display: none; position: absolute; right: 0; top: 100%; margin-top: 15px; background: white; border: 1px solid var(--color-silver); border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.15); z-index: 9999; width: 320px; text-align: left; padding: 0; overflow: hidden;">
                        <div style="padding: 12px 15px; background: var(--color-grey-bg); border-bottom: 1px solid var(--color-silver); display: flex; justify-content: space-between; align-items: center;">
                            <h4 style="margin: 0; font-size: 0.95rem; font-weight: 700; color: var(--color-navy-dark);">การแจ้งเตือน</h4>
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <form action="{{ route('notifications.markAllAsRead') }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <button type="submit" style="background: none; border: none; color: var(--color-accent); font-size: 0.75rem; cursor: pointer; font-weight: 600;">อ่านทั้งหมด</button>
                                </form>
                            @endif
                        </div>
                        <div style="max-height: 300px; overflow-y: auto;">
                            @forelse(auth()->user()->notifications()->take(10)->get() as $notification)
                                <a href="{{ $notification->data['url'] ?? '#' }}" style="display: block; padding: 12px 15px; text-decoration: none; border-bottom: 1px solid rgba(226, 232, 240, 0.5); {{ $notification->read_at ? 'background: white;' : 'background: #f0fdfa;' }} transition: background 0.2s;" onmouseover="this.style.background='var(--color-grey-bg)'" onmouseout="this.style.background='{{ $notification->read_at ? 'white' : '#f0fdfa' }}'">
                                    <div style="display: flex; gap: 10px;">
                                        @if(isset($notification->data['image']) && $notification->data['image'])
                                            <img src="{{ Storage::url($notification->data['image']) }}" alt="" style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover; flex-shrink: 0;">
                                        @else
                                            <div style="width: 40px; height: 40px; border-radius: 8px; background: var(--color-accent); color: white; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 1.2rem;">
                                                <i class="fa-solid fa-bullhorn"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <h5 style="margin: 0 0 4px; font-size: 0.85rem; font-weight: 700; color: var(--color-navy-dark); line-height: 1.3;">{{ $notification->data['title'] ?? 'การแจ้งเตือน' }}</h5>
                                            <p style="margin: 0 0 6px; font-size: 0.75rem; color: #64748b; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $notification->data['message'] ?? '' }}</p>
                                            <span style="font-size: 0.65rem; color: #94a3b8;">{{ $notification->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div style="padding: 20px; text-align: center; color: #94a3b8; font-size: 0.85rem;">
                                    ไม่มีการแจ้งเตือน
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endauth
            </div>
            <a href="{{ route('dashboard', ['tab' => 'wishlist']) }}" title="สินค้าที่ชอบ" style="margin-left: 1.25rem;"><i class="fa-solid fa-heart" style="color: #ef4444; font-size: 1.1rem;"></i></a>
            <a href="{{ route('cart.index') }}" id="cart-badge-link" title="ตะกร้าสินค้า" style="margin-left: 1.25rem; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa-solid fa-basket-shopping" style="font-size: 1.1rem;"></i>
                <span id="cart-count" class="cart-count-badge" style="background: #ef4444; color: white; border-radius: 50%; padding: 1px 6px; font-size: 0.75rem; font-weight: bold; min-width: 18px; text-align: center; display: inline-block; line-height: 1.4;">{{ count(session('cart', [])) }}</span>
            </a>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar" id="main-navbar">
        <a href="{{ url('/') }}" class="navbar-brand" style="display: flex; align-items: center; gap: 10px; text-decoration: none;">
            <img src="{{ asset('images/logoddphone.png') }}" alt="DDPHONE Logo" style="height: 44px; width: auto; object-fit: contain; filter: drop-shadow(0 2px 6px rgba(0, 0, 0, 0.4));" onerror="this.src='{{ asset('logoddphone.png') }}'">
            <span style="font-size: 1.2rem; font-weight: 900; color: #FFFFFF; letter-spacing: 0.5px;">DDPHONE ดีดีโฟน</span>
        </a>
        <!-- Search Bar -->
        <form action="{{ route('products.index') }}" method="GET" style="margin: 0 0.5rem; display: flex; align-items: center; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); border-radius: 20px; padding: 6px 12px; width: 220px; max-width: 100%; flex-shrink: 0;">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="ค้นหามือถือ iPhone, iPad มือสอง..." style="background: none; border: none; outline: none; color: white; width: 100%; font-family: 'Prompt', sans-serif; font-size: 0.82rem;">
            <button type="submit" style="background: none; border: none; color: #FFE600; cursor: pointer; padding: 2px 0 2px 6px;">
                <i class="fa-solid fa-magnifying-glass" style="font-size: 0.85rem;"></i>
            </button>
        </form>
        <div class="navbar-links">
            <a href="{{ url('/') }}" class="nav-clean-link {{ request()->is('/') ? 'active-nav-tab' : '' }}" {!! request()->is('/') ? 'style="background: #FFE600 !important; color: #0F172A !important; font-weight: 900 !important;"' : '' !!}>หน้าแรก</a>
            <a href="{{ route('products.index') }}" class="nav-clean-link {{ request()->routeIs('products.*') ? 'active-nav-tab' : '' }}" {!! request()->routeIs('products.*') ? 'style="background: #FFE600 !important; color: #0F172A !important; font-weight: 900 !important;"' : '' !!}>📱 มือถือมือสองทั้งหมด</a>
            <a href="{{ route('promotions.index') }}" class="nav-clean-link {{ request()->routeIs('promotions.*') ? 'active-nav-tab' : '' }}" {!! request()->routeIs('promotions.*') ? 'style="background: #FFE600 !important; color: #0F172A !important; font-weight: 900 !important;"' : '' !!}>🔥 โปรเด็ดมือสอง</a>
            
            <!-- Service & Warranty Dropdown -->
            <div class="navbar-item-dropdown">
                <a href="#" class="navbar-dropdown-trigger nav-clean-link {{ (request()->routeIs('service_center') || request()->routeIs('tracking') || request()->routeIs('help_center')) ? 'active-nav-tab' : '' }}" {!! (request()->routeIs('service_center') || request()->routeIs('tracking') || request()->routeIs('help_center')) ? 'style="background: #FFE600 !important; color: #0F172A !important; font-weight: 900 !important;"' : '' !!} onclick="toggleStoreDropdown(this, event)">
                    🔧 ศูนย์ซ่อม & เคลมประกัน <span style="font-size: 0.65rem;">▼</span>
                </a>
                <div class="navbar-dropdown-menu">
                    <a href="{{ route('service_center') }}" class="dropdown-item-equal">🔧 ส่งซ่อม/เคลมประกัน</a>
                    <a href="{{ route('tracking') }}" class="dropdown-item-equal">📦 ติดตามสถานะงานซ่อม</a>
                    <a href="{{ route('help_center') }}" class="dropdown-item-equal">❓ ศูนย์ช่วยเหลือ & FAQ</a>
                </div>
            </div>

            <a href="{{ route('categoryblog') }}" class="nav-clean-link {{ (request()->routeIs('categoryblog') || request()->routeIs('blog.*') || request()->routeIs('articles.*')) ? 'active-nav-tab' : '' }}" {!! (request()->routeIs('categoryblog') || request()->routeIs('blog.*') || request()->routeIs('articles.*')) ? 'style="background: #FFE600 !important; color: #0F172A !important; font-weight: 900 !important;"' : '' !!}>📰 บทความ & รีวิว</a>
        </div>
        
        <!-- Mobile Actions -->
        <div class="mobile-actions">
            <a href="{{ route('cart.index') }}" title="ตะกร้าสินค้า" style="color: white; text-decoration: none; position: relative; display: flex; align-items: center; margin-right: 8px;">
                <i class="fa-solid fa-basket-shopping" style="font-size: 1.15rem;"></i>
                <span class="cart-count-badge" style="position: absolute; top: -8px; right: -8px; background: #ef4444; color: white; border-radius: 50%; padding: 1px 5px; font-size: 0.6rem; font-weight: bold; min-width: 13px; text-align: center; line-height: 1.2;">{{ count(session('cart', [])) }}</span>
            </a>
            <button type="button" onclick="toggleMobileMenu()" style="background: none; border: none; color: white; font-size: 1.15rem; cursor: pointer; display: flex; align-items: center; padding: 4px;">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>
    </nav>

    <!-- Mobile Drawer Backdrop Overlay -->
    <div class="mobile-drawer-overlay" onclick="toggleMobileMenu()"></div>

    <!-- Mobile Navigation Drawer -->
    <div class="mobile-drawer">
         
         <!-- Drawer Header -->
         <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 0.5rem;">
             <span style="font-size: 1.15rem; font-weight: 700; color: white; font-family: 'Prompt', sans-serif;">ดีดี.ไอที.คอม</span>
             <button type="button" onclick="toggleMobileMenu()" style="background: none; border: none; color: white; font-size: 1.5rem; cursor: pointer; display: flex; align-items: center; padding: 2px;">
                 <i class="fa-solid fa-xmark"></i>
             </button>
         </div>

         <!-- Mobile Search Bar (Compact) -->
         <form action="{{ route('products.index') }}" method="GET" style="margin: 0; display: flex; align-items: center; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; padding: 8px 12px;">
             <input type="text" name="q" value="{{ request('q') }}" placeholder="ค้นหาสินค้า..." style="background: none; border: none; outline: none; color: white; width: 100%; font-family: 'Prompt', sans-serif; font-size: 0.8rem;">
             <button type="submit" style="background: none; border: none; color: rgba(255,255,255,0.6); cursor: pointer; display: flex; align-items: center; padding: 0;">
                 <i class="fa-solid fa-magnifying-glass" style="font-size: 0.85rem;"></i>
             </button>
         </form>

         <!-- Mobile Menu Links (Compact) -->
         <div style="display: flex; flex-direction: column; gap: 0.9rem; font-family: 'Prompt', sans-serif;">
             <a href="{{ url('/') }}" style="color: white; text-decoration: none; font-size: 0.9rem; font-weight: 500; display: flex; align-items: center; gap: 10px;"><i class="fa-solid fa-house" style="width: 20px; color: var(--color-silver-light); font-size: 0.85rem;"></i> หน้าแรก</a>
             <a href="{{ route('about') }}" style="color: white; text-decoration: none; font-size: 0.9rem; font-weight: 500; display: flex; align-items: center; gap: 10px;"><i class="fa-solid fa-circle-info" style="width: 20px; color: var(--color-silver-light); font-size: 0.85rem;"></i> เกี่ยวกับเรา</a>
             <a href="{{ route('products.index') }}" style="color: white; text-decoration: none; font-size: 0.9rem; font-weight: 500; display: flex; align-items: center; gap: 10px;"><i class="fa-solid fa-box" style="width: 20px; color: var(--color-silver-light); font-size: 0.85rem;"></i> สินค้าทั้งหมด</a>
             <a href="{{ route('promotions.index') }}" style="color: white; text-decoration: none; font-size: 0.9rem; font-weight: 500; display: flex; align-items: center; gap: 10px;"><i class="fa-solid fa-tags" style="width: 20px; color: var(--color-silver-light); font-size: 0.85rem;"></i> โปรโมชันพิเศษ</a>

             <!-- Services Group -->
             <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                 <button type="button" onclick="toggleMobileSubmenu('services-sub', this)" style="background: none; border: none; padding: 6px 8px; color: white; font-size: 0.9rem; font-weight: 600; display: flex; align-items: center; justify-content: space-between; width: 100%; cursor: pointer; text-align: left; font-family: 'Prompt', sans-serif; border-radius: 6px;">
                     <span style="display: flex; align-items: center; gap: 10px; color: white;"><i class="fa-solid fa-handshake-angle" style="width: 20px; color: var(--color-silver-light); font-size: 0.85rem;"></i> บริการ & โซลูชัน</span>
                     <i class="fa-solid fa-chevron-down submenu-arrow" style="font-size: 0.75rem; transition: transform 0.2s ease; color: var(--color-silver-light);"></i>
                 </button>
                 <div id="services-sub" style="display: none; flex-direction: column; gap: 0.5rem; padding-left: 1.25rem; border-left: 1.5px solid rgba(255,255,255,0.08); margin-left: 18px; margin-top: 0.15rem;">
                     <a href="{{ route('services') }}" style="color: var(--color-silver); text-decoration: none; font-size: 0.8rem;">🛠️ บริการทั้งหมดของเรา</a>
                     <a href="{{ route('installment') }}" style="color: var(--color-silver); text-decoration: none; font-size: 0.8rem;">💳 บริการผ่อนชำระ</a>
                     <a href="{{ route('education') }}" style="color: var(--color-silver); text-decoration: none; font-size: 0.8rem;">🎓 โซลูชันเพื่อการศึกษา</a>
                     <a href="{{ route('business') }}" style="color: var(--color-silver); text-decoration: none; font-size: 0.8rem;">🏢 โซลูชันสำหรับธุรกิจองค์กร</a>
                 </div>
             </div>

             <!-- Service Center Group -->
             <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                 <button type="button" onclick="toggleMobileSubmenu('center-sub', this)" style="background: none; border: none; padding: 6px 8px; color: white; font-size: 0.9rem; font-weight: 600; display: flex; align-items: center; justify-content: space-between; width: 100%; cursor: pointer; text-align: left; font-family: 'Prompt', sans-serif; border-radius: 6px;">
                     <span style="display: flex; align-items: center; gap: 10px; color: white;"><i class="fa-solid fa-screwdriver-wrench" style="width: 20px; color: var(--color-silver-light); font-size: 0.85rem;"></i> ศูนย์ซ่อม & ติดตาม</span>
                     <i class="fa-solid fa-chevron-down submenu-arrow" style="font-size: 0.75rem; transition: transform 0.2s ease; color: var(--color-silver-light);"></i>
                 </button>
                 <div id="center-sub" style="display: none; flex-direction: column; gap: 0.5rem; padding-left: 1.25rem; border-left: 1.5px solid rgba(255,255,255,0.08); margin-left: 18px; margin-top: 0.15rem;">
                     <a href="{{ route('service_center') }}" style="color: var(--color-silver); text-decoration: none; font-size: 0.8rem;">🔧 ส่งซ่อม/เคลมออนไลน์</a>
                     <a href="{{ route('tracking') }}" style="color: var(--color-silver); text-decoration: none; font-size: 0.8rem;">📦 ติดตามสถานะงาน</a>
                     <a href="{{ route('help_center') }}" style="color: var(--color-silver); text-decoration: none; font-size: 0.8rem;">❓ ศูนย์ช่วยเหลือ & FAQ</a>
                 </div>
             </div>

             <a href="{{ route('categoryblog') }}" style="color: white; text-decoration: none; font-size: 0.9rem; font-weight: 500; display: flex; align-items: center; gap: 10px;"><i class="fa-solid fa-newspaper" style="width: 24px; color: var(--color-silver-light); font-size: 0.85rem;"></i> ข่าวสารและกิจกรรม</a>
             <a href="{{ route('quotation.generate') }}" style="color: white; text-decoration: none; font-size: 0.9rem; font-weight: 500; display: flex; align-items: center; gap: 10px;"><i class="fa-solid fa-file-invoice" style="width: 24px; color: var(--color-silver-light); font-size: 0.85rem;"></i> ขอใบเสนอราคา</a>
         </div>

         <hr style="border: 0; border-top: 1px solid rgba(255,255,255,0.06); margin: 0.25rem 0;">

         <!-- Mobile Auth/Profile (Compact) -->
         <div style="display: flex; flex-direction: column; gap: 0.6rem; font-family: 'Prompt', sans-serif;">
             @auth
                 <div style="color: white; font-weight: 600; font-size: 0.85rem; display: flex; align-items: center; gap: 8px;">👤 {{ auth()->user()->name }}</div>
                 <a href="{{ route('dashboard') }}" style="color: white; text-decoration: none; background: rgba(255,255,255,0.06); padding: 8px 12px; border-radius: 6px; text-align: center; font-weight: 600; font-size: 0.8rem; border: 1px solid rgba(255,255,255,0.1); display: block;">💻 โปรไฟล์/แดชบอร์ด</a>
                 <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                     @csrf
                     <button type="submit" style="width: 100%; background: var(--color-danger); color: white; border: none; padding: 8px 12px; border-radius: 6px; font-weight: 700; cursor: pointer; font-family: 'Prompt', sans-serif; font-size: 0.8rem;">🚪 ออกจากระบบ</button>
                 </form>
             @else
                 <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                     <a href="{{ route('login') }}" style="color: white; text-decoration: none; background: rgba(255,255,255,0.06); padding: 8px; border-radius: 6px; text-align: center; font-weight: 600; font-size: 0.78rem; border: 1px solid rgba(255,255,255,0.1);">เข้าสู่ระบบ</a>
                     <a href="{{ route('register') }}" style="color: white; text-decoration: none; background: var(--color-accent); padding: 8px; border-radius: 6px; text-align: center; font-weight: 600; font-size: 0.78rem;">สมัครสมาชิก</a>
                 </div>
             @endauth
         </div>
    </div>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Floating LINE OA Button -->
    <a href="https://line.me/ti/p/@dditcom" target="_blank" style="position: fixed; bottom: 25px; left: 25px; z-index: 9999; display: flex; align-items: center; justify-content: center; width: 60px; height: 60px; background-color: #06c755; color: white; border-radius: 50%; box-shadow: 0 4px 15px rgba(6,199,85,0.4); text-decoration: none; transition: all 0.3s ease;" onmouseover="this.style.transform='scale(1.1)'; this.style.boxShadow='0 6px 20px rgba(6,199,85,0.6)'" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 15px rgba(6,199,85,0.4)'" title="แอดไลน์สอบถามข้อมูล">
        <i class="fa-brands fa-line" style="font-size: 2.2rem;"></i>
    </a>

    <!-- Footer -->
    <footer class="footer" style="border-top: 1px solid rgba(255,255,255,0.05);">
        <div class="container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2.5rem;">
            <div>
                <h3 style="font-weight: 700; font-size: 1.3rem; color: white; margin-bottom: 1rem;">บริษัท ดีดี.ไอที.คอม จำกัด</h3>
                <p style="color: rgba(160, 174, 192, 0.9); line-height: 1.7; font-size: 0.9rem;">ผู้เชี่ยวชาญทางด้านสินค้าโทรศัพท์มือถือและสินค้าไอทีแบบครบวงจร</p>
                <p style="color: rgba(160, 174, 192, 0.7); font-size: 0.85rem; margin-top: 0.75rem;">📍 72/47-48ก ถนนชัยประสิทธิ์ ต.ในเมือง<br>อ.เมือง จ.ชัยภูมิ 36000</p>
                <a href="https://maps.app.goo.gl/YyGucac8fsKzP4q28" target="_blank" style="display: inline-flex; align-items: center; gap: 8px; margin-top: 12px; background: rgba(239, 68, 68, 0.15); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3); padding: 6px 14px; border-radius: 20px; font-size: 0.82rem; font-weight: 600; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='#ef4444'; this.style.color='white'" onmouseout="this.style.background='rgba(239, 68, 68, 0.15)'; this.style.color='#f87171'">
                    <i class="fa-solid fa-map-location-dot"></i> ดูแผนที่บน Google Maps ↗
                </a>
            </div>
            <div>
                <h3 style="font-weight: 700; font-size: 1rem; color: white; margin-bottom: 1rem;">ช่องทางติดต่อ</h3>
                <p style="color: rgba(160, 174, 192, 0.9); font-size: 0.9rem; margin-bottom: 0.5rem;">📞 083-828-941</p>
                <p style="color: rgba(160, 174, 192, 0.9); font-size: 0.9rem; margin-bottom: 0.5rem;">✉️ ddit.com.88@gmail.com</p>
                <p style="color: rgba(160, 174, 192, 0.7); font-size: 0.85rem; margin-top: 0.5rem;">⏰ ทำการทุกวัน: 09:00 - 19:00 น.</p>
                <div style="display: flex; gap: 12px; margin-top: 1rem;">
                    <a href="https://www.facebook.com/dditcom" target="_blank" style="width: 36px; height: 36px; background: rgba(255,255,255,0.08); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--color-silver); transition: all 0.2s; text-decoration: none;" onmouseover="this.style.background='#1877f2'; this.style.color='white'" onmouseout="this.style.background='rgba(255,255,255,0.08)'; this.style.color='var(--color-silver)'"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="https://line.me/ti/p/@dditcom" target="_blank" style="width: 36px; height: 36px; background: rgba(255,255,255,0.08); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--color-silver); transition: all 0.2s; text-decoration: none;" onmouseover="this.style.background='#06c755'; this.style.color='white'" onmouseout="this.style.background='rgba(255,255,255,0.08)'; this.style.color='var(--color-silver)'"><i class="fa-brands fa-line"></i></a>
                </div>
            </div>
            <div>
                <h3 style="font-weight: 700; font-size: 1rem; color: white; margin-bottom: 1rem;">บริการพิเศษ</h3>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <a href="{{ route('installment') }}" style="color: rgba(160, 174, 192, 0.9); text-decoration: none; font-size: 0.9rem; transition: color 0.2s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(160, 174, 192, 0.9)'">คำนวณยอดผ่อนชำระ</a>
                    <a href="{{ route('education') }}" style="color: rgba(160, 174, 192, 0.9); text-decoration: none; font-size: 0.9rem; transition: color 0.2s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(160, 174, 192, 0.9)'">โซลูชันเพื่อการศึกษา</a>
                    <a href="{{ route('business') }}" style="color: rgba(160, 174, 192, 0.9); text-decoration: none; font-size: 0.9rem; transition: color 0.2s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(160, 174, 192, 0.9)'">โซลูชันสำหรับธุรกิจองค์กร</a>
                </div>
            </div>
            <div>
                <h3 style="font-weight: 700; font-size: 1rem; color: white; margin-bottom: 1rem;">📍 แผนที่ร้านค้า (Google Maps)</h3>
                <a href="https://maps.app.goo.gl/YyGucac8fsKzP4q28" target="_blank" style="display: block; position: relative; border-radius: 12px; overflow: hidden; border: 1px solid rgba(255,255,255,0.12); box-shadow: 0 4px 15px rgba(0,0,0,0.2); text-decoration: none; transition: transform 0.2s ease;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                    <img src="{{ asset('images/store_map.png') }}" alt="แผนที่หน้าร้าน DD.IT.COM" style="width: 100%; height: 130px; object-fit: cover; display: block;">
                    <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(15, 23, 42, 0.95)); padding: 10px 12px; display: flex; align-items: center; justify-content: space-between; color: white;">
                        <span style="font-size: 0.8rem; font-weight: 600; display: flex; align-items: center; gap: 6px;">📍 นำทางไปยังร้านค้า</span>
                        <span style="font-size: 0.72rem; background: #ef4444; color: white; padding: 2px 8px; border-radius: 10px; font-weight: 700;">เปิด Google Maps ↗</span>
                    </div>
                </a>
            </div>
        </div>
        <div style="border-top: 1px solid rgba(255,255,255,0.06); margin-top: 2rem; padding-top: 1.5rem; text-align: center; color: rgba(160, 174, 192, 0.5); font-size: 0.8rem;">
            © {{ date('Y') }} บริษัท ดีดี.ไอที.คอม จำกัด — All rights reserved.
        </div>
    </footer>

    <x-chat-widget />

    @if (session('sweet_success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ!',
                text: '{{ session('sweet_success') }}',
                confirmButtonColor: '#1B2A47'
            });
        </script>
    @endif
    
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'ผิดพลาด',
                text: '{{ session('error') }}',
                confirmButtonColor: '#1B2A47'
            });
        </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ajax add to cart
            document.body.addEventListener('submit', function(e) {
                if (e.target && e.target.classList.contains('ajax-add-to-cart-form')) {
                    e.preventDefault();
                    const form = e.target;
                    const actionUrl = form.action;
                    const formData = new FormData(form);

                    fetch(actionUrl, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.querySelectorAll('.cart-count-badge').forEach(el => {
                                el.textContent = data.cart_count;
                            });
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2500,
                                timerProgressBar: true
                            });
                            Toast.fire({
                                icon: 'success',
                                title: data.message || 'เพิ่มสินค้าลงตะกร้าเรียบร้อยแล้ว!'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด',
                                text: data.message || 'ไม่สามารถเพิ่มสินค้าลงตะกร้าได้'
                            });
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        form.submit();
                    });
                }
            });

            // AJAX Wishlist Toggle (heart buttons)
            document.body.addEventListener('click', function(e) {
                const btn = e.target.closest('.wishlist-toggle-btn');
                if (!btn) return;
                e.preventDefault();

                const productId = btn.dataset.productId;
                const isLoggedIn = document.body.dataset.loggedIn === 'true';

                if (!isLoggedIn) {
                    window.location.href = '{{ route("login") }}';
                    return;
                }

                fetch('/wishlist/toggle/' + productId, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const icon = btn.querySelector('i');
                        if (data.added) {
                            icon.classList.remove('fa-regular');
                            icon.classList.add('fa-solid');
                            btn.style.color = '#ef4444';
                        } else {
                            icon.classList.remove('fa-solid');
                            icon.classList.add('fa-regular');
                            btn.style.color = '#94a3b8';
                        }
                    }
                })
                .catch(err => console.error(err));
            });
        });
    </script>
    <script>
        window.addEventListener('scroll', function() {
            const nav = document.getElementById('main-navbar');
            if (nav) {
                if (window.scrollY > 30) {
                    nav.classList.add('navbar-scrolled');
                } else {
                    nav.classList.remove('navbar-scrolled');
                }
            }
        });
        function toggleMobileMenu() {
            const drawer = document.querySelector('.mobile-drawer');
            const overlay = document.querySelector('.mobile-drawer-overlay');
            if (drawer && overlay) {
                drawer.classList.toggle('open');
                overlay.classList.toggle('open');
                if (drawer.classList.contains('open')) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';
                }
            }
        }
        function toggleMobileSubmenu(id, buttonEl) {
            const sub = document.getElementById(id);
            const arrow = buttonEl.querySelector('.submenu-arrow');
            if (sub) {
                if (sub.style.display === 'none' || sub.style.display === '') {
                    sub.style.display = 'flex';
                    if (arrow) arrow.style.transform = 'rotate(180deg)';
                } else {
                    sub.style.display = 'none';
                    if (arrow) arrow.style.transform = 'rotate(0deg)';
                }
            }
        function toggleStoreDropdown(element, event) {
            if (event) event.preventDefault();
            const parent = element.closest('.navbar-item-dropdown');
            if (!parent) return;
            
            document.querySelectorAll('.navbar-item-dropdown').forEach(item => {
                if (item !== parent) item.classList.remove('active');
            });

            parent.classList.toggle('active');
        }

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.navbar-item-dropdown')) {
                document.querySelectorAll('.navbar-item-dropdown').forEach(item => {
                    item.classList.remove('active');
                });
            }
        });
    </script>
</div>
</body>
</html>

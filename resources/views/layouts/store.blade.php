<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Primary Dynamic Meta Tags for SEO -->
    <title>@yield('title', 'DDPHONE ดีดีโฟน | ศูนย์รวมสมาร์ทโฟนและไอแพดคัดเกรด A+ คุณภาพสูง')</title>
    <meta name="title" content="@yield('meta_title', 'DDPHONE ดีดีโฟน | ศูนย์รวมสมาร์ทโฟนและไอแพดคัดเกรด A+ คุณภาพสูง')">
    <meta name="description" content="@yield('meta_description', 'ศูนย์รวมโทรศัพท์มือถือ iPhone, iPad และสมาร์ทโฟนคัดเกรด A+ คุณภาพสูง ตรวจเช็คเครื่องแท้ 100% พร้อมประกันร้าน 30 วันเต็ม และบริการซ่อมเปลี่ยนแบต/หน้าจอครบวงจร')">
    <meta name="keywords" content="@yield('meta_keywords', 'DDPHONE, ดีดีโฟน, มือถือ, ไอโฟน, ไอแพด, iPhone, iPad, สมาร์ทโฟน, ซ่อมมือถือ, ชัยภูมิ')">
    <meta name="robots" content="@yield('meta_robots', 'index, follow')">
    <link rel="canonical" href="@yield('canonical_url', url()->current())">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Open Graph / Facebook / Line Meta Tags -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="@yield('og_url', url()->current())">
    <meta property="og:title" content="@yield('og_title', 'DDPHONE ดีดีโฟน | ศูนย์รวมสมาร์ทโฟนคุณภาพสูง')">
    <meta property="og:description" content="@yield('og_description', 'ศูนย์รวมโทรศัพท์มือถือ iPhone, iPad และสมาร์ทโฟนคัดเกรด A+ พร้อมประกันร้าน 30 วัน')">
    <meta property="og:image" content="@yield('og_image', asset('images/logoddphone.png'))">
    <meta property="og:site_name" content="DDPHONE ดีดีโฟน">
    <meta property="og:locale" content="th_TH">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="@yield('og_url', url()->current())">
    <meta name="twitter:title" content="@yield('og_title', 'DDPHONE ดีดีโฟน | ศูนย์รวมสมาร์ทโฟนคุณภาพสูง')">
    <meta name="twitter:description" content="@yield('og_description', 'ศูนย์รวมโทรศัพท์มือถือ iPhone, iPad และสมาร์ทโฟนคัดเกรด A+ พร้อมประกันร้าน 30 วัน')">
    <meta name="twitter:image" content="@yield('og_image', asset('images/logoddphone.png'))">

    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@type": "LocalBusiness",
      "name": "DDPHONE ดีดีโฟน (บริษัท ดีดี.ไอที.คอม จำกัด)",
      "image": "{{ asset('images/logoddphone.png') }}",
      "@id": "{{ url('/') }}",
      "url": "{{ url('/') }}",
      "telephone": "086-869-9666",
      "priceRange": "฿฿",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "72/47-48ก ถนนชัยประสิทธิ์ ต.ในเมือง",
        "addressLocality": "เมืองชัยภูมิ",
        "addressRegion": "ชัยภูมิ",
        "postalCode": "36000",
        "addressCountry": "TH"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": 15.8078,
        "longitude": 102.0308
      },
      "openingHoursSpecification": {
        "@type": "OpeningHoursSpecification",
        "dayOfWeek": [
          "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"
        ],
        "opens": "09:00",
        "closes": "19:00"
      },
      "sameAs": [
        "https://www.facebook.com/DDPHONECP",
        "https://line.me/ti/p/@ddphone"
      ]
    }
    </script>

    <!-- Favicon / Website Icon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logoddphone.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logoddphone.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logoddphone.png') }}">

    <!-- Preconnect to speed up external resource loading -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://cdn.jsdelivr.net">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3/dist/cdn.min.js" defer></script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Use stable hash versioning so browser can cache theme.css across requests -->
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}?v={{ filemtime(public_path('css/theme.css')) }}">
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="antialiased" data-logged-in="{{ auth()->check() ? 'true' : 'false' }}">

    <!-- Vibrant Animated Ambient Background -->
    <div class="animated-bg-container" aria-hidden="true">
        <div class="bg-blob blob-1"></div>
        <div class="bg-blob blob-2"></div>
        <div class="bg-blob blob-3"></div>
        <div class="bg-blob blob-4"></div>
        <div class="bg-grid-pattern"></div>
        <div class="bg-particles">
            <div class="bg-particle"></div>
            <div class="bg-particle"></div>
            <div class="bg-particle"></div>
            <div class="bg-particle"></div>
            <div class="bg-particle"></div>
            <div class="bg-particle"></div>
        </div>
    </div>

    <div x-data="{ mobileMenuOpen: false }">

    @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'super_admin']))
        @include('layouts.navigation')
    @endif

    <!-- Fixed Translucent Glass Header Container (Guaranteed to follow screen on scroll) -->
    <header class="header-sticky-wrapper" style="position: fixed; top: 0; left: 0; right: 0; width: 100%; z-index: 9990;">
        <!-- Top Bar (Section 1: Soft Ice-Blue Glass Header) -->
        <div class="topbar">
            <div class="topbar-left" style="display: flex; align-items: center; gap: 15px;">
                <a href="https://www.facebook.com/DDPHONECP" target="_blank" style="display: inline-flex; align-items: center; gap: 5px; color: #0F172A;"><i class="fa-brands fa-facebook" style="color: #1877f2;"></i> <span class="topbar-txt-label">Facebook</span></a>
                <a href="https://line.me/ti/p/@ddphone" target="_blank" style="display: inline-flex; align-items: center; gap: 5px; color: #0F172A;"><i class="fa-brands fa-line" style="color: #06c755;"></i> <span class="topbar-txt-label">Line</span></a>
                <a href="tel:0868699666" style="display: inline-flex; align-items: center; gap: 5px; color: #0284C7;"><i class="fa-solid fa-phone" style="color: #0284C7;"></i> <span class="topbar-txt-label">086-869-9666</span></a>
            </div>
            <div class="topbar-right" style="display: flex; align-items: center; gap: 14px;" x-data="{ openProfile: false }">
                @auth
                    <!-- User Profile Title Box -->
                    <div style="position: relative; display: inline-block; z-index: 1200;">
                        <button @click="window.innerWidth < 1024 ? window.location.href='{{ route('dashboard') }}' : openProfile = !openProfile" @click.away="openProfile = false" style="background: rgba(2, 132, 199, 0.08); border: 1px solid rgba(2, 132, 199, 0.2); color: #0F172A; padding: 3px 12px; border-radius: 99px; cursor: pointer; font-weight: 800; display: flex; align-items: center; gap: 8px; font-family: 'Prompt', sans-serif; font-size: 0.8rem; transition: all 0.2s;" onmouseover="this.style.background='rgba(2, 132, 199, 0.15)'" onmouseout="this.style.background='rgba(2, 132, 199, 0.08)'">
                            <img src="{{ auth()->user()->avatar_url }}" alt="" style="width: 24px; height: 24px; border-radius: 50%; object-fit: cover; border: 1.5px solid #0F172A;">
                            <span>{{ auth()->user()->name }}</span> <span style="font-size: 0.7rem; color: #0F172A;">▼</span>
                        </button>
                        <div x-show="openProfile" x-transition style="display: none; position: absolute; right: 0; top: 100%; margin-top: 8px; background: white; border: 1.5px solid #E2E8F0; border-radius: 14px; box-shadow: 0 10px 30px rgba(15,23,42,0.18); z-index: 9999; min-width: 190px; text-align: left; padding: 0.5rem 0;">
                            <a href="{{ route('dashboard') }}" style="display: block; padding: 10px 16px; color: #0F172A; text-decoration: none; font-weight: 700; font-size: 0.88rem; transition: background 0.2s;" onmouseover="this.style.background='#F1F5F9'" onmouseout="this.style.background='transparent'">
                                👤 ข้อมูลส่วนตัว
                            </a>
                            <hr style="border: 0; border-top: 1px solid #E2E8F0; margin: 0.25rem 0;">
                            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                                @csrf
                                <button type="submit" style="width: 100%; text-align: left; background: none; border: none; padding: 10px 16px; color: #EF4444; cursor: pointer; font-weight: 800; font-size: 0.88rem; font-family: 'Prompt', sans-serif; transition: background 0.2s;" onmouseover="this.style.background='rgba(239, 68, 68, 0.08)'" onmouseout="this.style.background='transparent'">
                                    🚪 ออกจากระบบ
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" style="color: #0F172A; font-weight: 800; text-decoration: none; font-size: 0.82rem;">เข้าสู่ระบบ</a>
                    <span style="color: #94A3B8;">|</span>
                    <a href="{{ route('register') }}" style="color: #0284C7; font-weight: 800; text-decoration: none; font-size: 0.82rem;">สมัครสมาชิก</a>
                @endauth

                @auth
                    @if(auth()->user()->role === 'customer')
                    <a href="javascript:void(0)" onclick="window.dispatchEvent(new CustomEvent('open-customer-chat'))" title="แชทติดต่อสอบถามกับร้านค้า" style="position: relative; display: inline-flex; align-items: center; color: #0F172A; text-decoration: none;">
                        <i class="fa-solid fa-comment-dots" style="font-size: 1.15rem;"></i>
                        <span class="customer-nav-chat-badge" style="display: none; position: absolute; top: -7px; right: -8px; background: #ef4444; color: white; border-radius: 50%; padding: 1px 5px; font-size: 0.65rem; font-weight: bold; min-width: 14px; text-align: center; line-height: 1.2;"></span>
                    </a>
                    @endif
                @endauth

                <!-- Notification Bell - Alpine.js Real-time Component -->
                @auth
                <div x-data="notificationBell()" @click.away="open = false" style="position: relative; display: inline-block; z-index: 999998;">
                    <button type="button" @click="toggleBell()" title="การแจ้งเตือน" style="background: none; border: none; color: #0F172A; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; position: relative; padding: 4px; min-width: 36px; min-height: 36px; touch-action: manipulation; -webkit-tap-highlight-color: transparent;">
                        <i class="fa-solid fa-bell animate-bell-period" style="font-size: 1.15rem; pointer-events: none;"></i>
                        <span x-show="unreadCount > 0" 
                              x-text="unreadCount" 
                              style="position: absolute; top: -2px; right: -2px; background: #ef4444; color: white; border-radius: 50%; padding: 1px 5px; font-size: 0.65rem; font-weight: bold; min-width: 14px; text-align: center; line-height: 1.2; pointer-events: none;">
                        </span>
                    </button>
                    <!-- Dropdown pinned directly under notification bell (works on desktop & mobile) -->
                    <div x-show="open"
                         @click.stop
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         class="notif-dropdown-box"
                         style="display:none; background: white; border: 1.5px solid #E2E8F0; border-radius: 16px; box-shadow: 0 16px 45px rgba(15,23,42,0.25); text-align: left; padding: 0; overflow: hidden;">
                        <div style="padding: 12px 16px; background: linear-gradient(135deg, #F0F9FF 0%, #E0F2FE 100%); border-bottom: 1px solid #BAE6FD; display: flex; justify-content: space-between; align-items: center; border-radius: 16px 16px 0 0;">
                            <h4 style="margin: 0; font-size: 0.92rem; font-weight: 800; color: #0369A1; display: flex; align-items: center; gap: 7px;">🔔 การแจ้งเตือน</h4>
                            <span x-show="unreadCount > 0" style="background: #ef4444; color: white; font-size: 0.68rem; font-weight: 900; padding: 1px 8px; border-radius: 9999px;" x-text="unreadCount + ' ใหม่'"></span>
                        </div>
                        <div style="max-height: 340px; overflow-y: auto; border-radius: 0 0 16px 16px;">
                            <div x-show="notifications.length === 0" style="padding: 28px 16px; text-align: center; color: #94a3b8; font-size: 0.85rem;">
                                <div style="font-size: 1.8rem; margin-bottom: 6px;">🔕</div>
                                ไม่มีรายการแจ้งเตือนในขณะนี้
                            </div>
                            <template x-for="item in notifications" :key="item.id">
                                <div
                                     :style="item.is_read ? 'background: white;' : 'background: #EFF6FF;'"
                                     style="padding: 11px 14px; cursor: pointer; border-bottom: 1px solid #F1F5F9; transition: background 0.15s;"
                                     @mouseenter="$el.style.background='#F0F9FF'"
                                     @mouseleave="$el.style.background = item.is_read ? 'white' : '#EFF6FF'"
                                     @click="openNotifPopup(item)">
                                    <div style="display: flex; gap: 10px; pointer-events: none; align-items: flex-start;">
                                        <div x-show="item.image" style="flex-shrink: 0;">
                                            <img :src="item.image" style="width: 38px; height: 38px; border-radius: 8px; object-fit: cover;">
                                        </div>
                                        <div x-show="!item.image" style="width: 36px; height: 36px; border-radius: 9px; background: linear-gradient(135deg, #0284C7 0%, #0369A1 100%); color: white; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 0.95rem; box-shadow: 0 3px 8px rgba(2,132,199,0.25); margin-top: 1px;">
                                            <i class="fa-solid fa-bullhorn"></i>
                                        </div>
                                        <div style="flex-grow: 1; min-width: 0;">
                                            <h5 style="margin: 0 0 2px; font-size: 0.83rem; font-weight: 800; color: #0F172A; line-height: 1.3;" x-text="item.title"></h5>
                                            <p style="margin: 0 0 4px; font-size: 0.76rem; color: #64748b; line-height: 1.4; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" x-text="item.message"></p>
                                            <span style="font-size: 0.66rem; color: #0284C7; font-weight: 800;" x-text="item.time_ago"></span>
                                        </div>
                                        <div x-show="!item.is_read" style="flex-shrink: 0; width: 8px; height: 8px; background: #3B82F6; border-radius: 50%; margin-top: 5px;"></div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
                @endauth

                <!-- Heart Wishlist Icon with Periodic Motion -->
                <a href="{{ route('dashboard', ['tab' => 'wishlist']) }}" title="สินค้าที่ชอบ" style="display: inline-flex; align-items: center; color: #FF2A55; text-decoration: none;">
                    <i class="fa-solid fa-heart animate-heart-period" style="font-size: 1.15rem; color: #FF2A55 !important; filter: drop-shadow(0 2px 8px rgba(255, 42, 85, 0.45));"></i>
                </a>

                <!-- Cart Icon (Always renders badge, styled as notification badge overlay) -->
                <a href="{{ route('cart.index') }}" id="cart-badge-link" title="ตะกร้าสินค้า" style="display: inline-flex; align-items: center; justify-content: center; position: relative; width: 36px; height: 36px; color: #0F172A; text-decoration: none;">
                    <i class="fa-solid fa-basket-shopping" style="font-size: 1.25rem;"></i>
                    @php $cartCount = session('cart') ? count(session('cart')) : 0; @endphp
                    <span id="cart-count" class="cart-count-badge" style="{{ $cartCount > 0 ? '' : 'display: none !important;' }} position: absolute; top: -2px; right: -4px; background: #EF4444; color: white; border-radius: 9999px; padding: 2px 5px; font-size: 0.68rem; font-weight: 900; min-width: 17px; height: 17px; text-align: center; line-height: 1.1; box-shadow: 0 2px 6px rgba(239, 68, 68, 0.4); border: 1.5px solid white;">
                        {{ $cartCount }}
                    </span>
                </a>
            </div>
        </div>

        <!-- Main Navbar (Section 1: Translucent Golden-Yellow Glass Header) -->
        <nav class="navbar" id="main-navbar">
            <div style="display: flex; align-items: center; gap: 10px;">
                <a href="{{ url('/') }}" class="navbar-brand" style="display: flex; align-items: center; gap: 8px; text-decoration: none;">
                    <img src="{{ asset('images/logoddphone.png') }}" alt="DDPHONE Logo" style="height: 35px; width: auto; object-fit: contain; filter: drop-shadow(0 2px 4px rgba(15, 23, 42, 0.15));" onerror="this.src='{{ asset('logoddphone.png') }}'">
                    <span style="font-size: 1.12rem; font-weight: 900; color: #0F172A; letter-spacing: 0.3px;">DDPHONE ดีดีโฟน</span>
                </a>
                <!-- Search Bar Attached right next to Logo -->
                <form action="{{ route('products.index') }}" method="GET" style="margin: 0; display: flex; align-items: center; background: #FFFFFF; border: 1.5px solid rgba(15, 23, 42, 0.18); border-radius: 99px; padding: 2px 4px 2px 14px; width: 215px; max-width: 100%; flex-shrink: 0; box-shadow: 0 2px 8px rgba(15,23,42,0.06);">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="ค้นหามือถือ iPhone, iPad มือสอง..." style="background: none; border: none; outline: none; color: #0F172A; font-weight: 700; width: 100%; font-family: 'Prompt', sans-serif; font-size: 0.78rem;">
                    <button type="submit" style="background: #0F172A; border: none; color: #FFE600; cursor: pointer; width: 26px; height: 26px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'">
                        <i class="fa-solid fa-magnifying-glass" style="font-size: 0.72rem;"></i>
                    </button>
                </form>
            </div>



            <div class="navbar-links">
                <a href="{{ url('/') }}" class="nav-clean-link {{ request()->is('/') ? 'active-nav-tab' : '' }}">หน้าแรก</a>
                <a href="{{ route('products.index') }}" class="nav-clean-link {{ request()->routeIs('products.*') ? 'active-nav-tab' : '' }}">📱 มือถือทั้งหมด</a>
                <a href="{{ route('promotions.index') }}" class="nav-clean-link {{ request()->routeIs('promotions.*') ? 'active-nav-tab' : '' }}">🔥 โปรเด็ด</a>
                
                <!-- Service & Warranty Dropdown (Hover to Open seamlessly) -->
                <div class="navbar-item-dropdown">
                    <a href="javascript:void(0)" class="navbar-dropdown-trigger nav-clean-link {{ (request()->routeIs('service_center') || request()->routeIs('tracking') || request()->routeIs('help_center')) ? 'active-nav-tab' : '' }}">
                        🔧 ศูนย์ซ่อม & เคลมประกัน <span style="font-size: 0.65rem;">▼</span>
                    </a>
                    <div class="navbar-dropdown-menu">
                        <a href="{{ route('service_center') }}" class="dropdown-item-equal">🔧 ส่งซ่อม/เคลมออนไลน์</a>
                        <a href="{{ route('tracking') }}" class="dropdown-item-equal">📦 ติดตามสถานะงานซ่อม</a>
                        <a href="{{ route('help_center') }}" class="dropdown-item-equal">❓ ศูนย์ช่วยเหลือ & คำถามพบบ่อย</a>
                    </div>
                </div>

                <!-- Articles and Reviews -->
                <a href="{{ route('categoryblog') }}" class="nav-clean-link {{ request()->routeIs('categoryblog*') ? 'active-nav-tab' : '' }}">📰 บทความ & รีวิว</a>
            </div>
        </nav>
    </header>
    <!-- Spacer element to reserve header height so page content starts cleanly -->
    <div class="header-spacer"></div>

    <!-- Invisible overlay to close popup on outside click -->
    <div class="mobile-drawer-overlay" id="mobile-drawer-overlay" onclick="toggleMobileMenu()"></div>

    <!-- Mobile Navigation Dropdown Popup -->
    <div class="mobile-drawer" id="mobile-drawer-popup">

        <!-- User/Auth Section -->
        <div style="padding: 0.5rem 0.25rem; border-bottom: 1px solid #F1F5F9; margin-bottom: 0.25rem;">
            @auth
                <div style="display: flex; align-items: center; gap: 8px; padding: 6px 8px; border-radius: 10px; background: #F0F9FF;">
                    <img src="{{ auth()->user()->avatar_url }}" alt="" style="width: 28px; height: 28px; border-radius: 50%; object-fit: cover; border: 1.5px solid #0284C7; flex-shrink: 0;">
                    <div>
                        <div style="font-size: 0.78rem; font-weight: 800; color: #0F172A; line-height: 1.2;">{{ auth()->user()->name }}</div>
                        <div style="font-size: 0.65rem; color: #64748B; font-weight: 600; word-break: break-all; overflow-wrap: anywhere; max-width: 170px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ auth()->user()->email }}</div>
                    </div>
                </div>
            @else
                <div style="display: flex; gap: 6px;">
                    <a href="{{ route('login') }}" style="flex: 1; text-align: center; padding: 7px; border-radius: 8px; background: #F8FAFC; border: 1px solid #E2E8F0; color: #0F172A; text-decoration: none; font-size: 0.76rem; font-weight: 800; display: flex; align-items: center; justify-content: center; gap: 5px;">
                        🔑 เข้าสู่ระบบ
                    </a>
                    <a href="{{ route('register') }}" style="flex: 1; text-align: center; padding: 7px; border-radius: 8px; background: #0284C7; color: white; text-decoration: none; font-size: 0.76rem; font-weight: 800; display: flex; align-items: center; justify-content: center; gap: 5px;">
                        📝 สมัครสมาชิก
                    </a>
                </div>
            @endauth
        </div>

        <!-- Navigation Links -->
        <div style="display: flex; flex-direction: column; gap: 4px;">
            <a href="{{ url('/') }}" class="menu-popup-item" style="display: flex; align-items: center; gap: 12px; padding: 10px 12px; border-radius: 12px; text-decoration: none; color: #0F172A; font-size: 0.84rem; font-weight: 800; transition: all 0.15s ease;">
                <span class="menu-icon-box" style="width: 32px; height: 32px; background: #FEF9C3; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 0.95rem; flex-shrink: 0; transition: transform 0.2s ease;">🏠</span>
                <span style="flex-grow: 1;">หน้าแรก</span>
                <i class="fa-solid fa-chevron-right" style="font-size: 0.65rem; color: #CBD5E1;"></i>
            </a>
            <a href="{{ route('products.index') }}" class="menu-popup-item" style="display: flex; align-items: center; gap: 12px; padding: 10px 12px; border-radius: 12px; text-decoration: none; color: #0F172A; font-size: 0.84rem; font-weight: 800; transition: all 0.15s ease;">
                <span class="menu-icon-box" style="width: 32px; height: 32px; background: #EFF6FF; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 0.95rem; flex-shrink: 0; transition: transform 0.2s ease;">📱</span>
                <span style="flex-grow: 1;">มือถือทั้งหมด</span>
                <i class="fa-solid fa-chevron-right" style="font-size: 0.65rem; color: #CBD5E1;"></i>
            </a>
            <a href="{{ route('promotions.index') }}" class="menu-popup-item" style="display: flex; align-items: center; gap: 12px; padding: 10px 12px; border-radius: 12px; text-decoration: none; color: #0F172A; font-size: 0.84rem; font-weight: 800; transition: all 0.15s ease;">
                <span class="menu-icon-box" style="width: 32px; height: 32px; background: #FFF7ED; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 0.95rem; flex-shrink: 0; transition: transform 0.2s ease;">🔥</span>
                <span style="flex-grow: 1;">โปรเด็ด</span>
                <i class="fa-solid fa-chevron-right" style="font-size: 0.65rem; color: #CBD5E1;"></i>
            </a>
            <a href="{{ route('service_center') }}" class="menu-popup-item" style="display: flex; align-items: center; gap: 12px; padding: 10px 12px; border-radius: 12px; text-decoration: none; color: #0F172A; font-size: 0.84rem; font-weight: 800; transition: all 0.15s ease;">
                <span class="menu-icon-box" style="width: 32px; height: 32px; background: #F0FDF4; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 0.95rem; flex-shrink: 0; transition: transform 0.2s ease;">🔧</span>
                <span style="flex-grow: 1;">ส่งซ่อม / เคลมออนไลน์</span>
                <i class="fa-solid fa-chevron-right" style="font-size: 0.65rem; color: #CBD5E1;"></i>
            </a>
            <a href="{{ route('tracking') }}" class="menu-popup-item" style="display: flex; align-items: center; gap: 12px; padding: 10px 12px; border-radius: 12px; text-decoration: none; color: #0F172A; font-size: 0.84rem; font-weight: 800; transition: all 0.15s ease;">
                <span class="menu-icon-box" style="width: 32px; height: 32px; background: #F0F9FF; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 0.95rem; flex-shrink: 0; transition: transform 0.2s ease;">📦</span>
                <span style="flex-grow: 1;">ติดตามสถานะงานซ่อม</span>
                <i class="fa-solid fa-chevron-right" style="font-size: 0.65rem; color: #CBD5E1;"></i>
            </a>
            <a href="{{ route('categoryblog') }}" class="menu-popup-item" style="display: flex; align-items: center; gap: 12px; padding: 10px 12px; border-radius: 12px; text-decoration: none; color: #0F172A; font-size: 0.84rem; font-weight: 800; transition: all 0.15s ease;">
                <span class="menu-icon-box" style="width: 32px; height: 32px; background: #FDF4FF; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 0.95rem; flex-shrink: 0; transition: transform 0.2s ease;">📰</span>
                <span style="flex-grow: 1;">บทความและรีวิว</span>
                <i class="fa-solid fa-chevron-right" style="font-size: 0.65rem; color: #CBD5E1;"></i>
            </a>
        </div>

        <!-- Auth Actions (if logged in) -->
        @auth
        <div style="border-top: 1px solid #F1F5F9; margin-top: 0.25rem; padding-top: 0.5rem; display: flex; flex-direction: column; gap: 4px;">
            <a href="{{ route('dashboard') }}" style="display: flex; align-items: center; gap: 10px; padding: 9px 10px; border-radius: 10px; text-decoration: none; color: #0F172A; font-size: 0.82rem; font-weight: 700; background: #F8FAFC;">
                <span style="width: 28px; height: 28px; background: #F0F9FF; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; flex-shrink: 0;">👤</span>
                ข้อมูลส่วนตัว
            </a>
            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" style="width: 100%; display: flex; align-items: center; gap: 10px; padding: 9px 10px; border-radius: 10px; background: #FEF2F2; border: none; color: #EF4444; font-size: 0.82rem; font-weight: 800; cursor: pointer; font-family: 'Prompt', sans-serif; text-align: left;">
                    <span style="width: 28px; height: 28px; background: #FECACA; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; flex-shrink: 0;">🚪</span>
                    ออกจากระบบ
                </button>
            </form>
        </div>
        @endauth
    </div>


    <!-- Shopee-Style Mobile Bottom Floating Navigation Bar -->
    <div class="shopee-mobile-bottom-nav">
        <a href="{{ url('/') }}" class="nav-item {{ request()->is('/') ? 'active' : '' }}">
            <i class="fa-solid fa-house"></i>
            <span>หน้าแรก</span>
        </a>
        <a href="{{ route('products.index') }}" class="nav-item {{ request()->routeIs('products.*') ? 'active' : '' }}">
            <i class="fa-solid fa-mobile-screen"></i>
            <span>สินค้า</span>
        </a>
        <a href="{{ route('cart.index') }}" id="mobile-cart-bottom-link" class="nav-item {{ request()->routeIs('cart.*') ? 'active' : '' }}" style="position: relative;">
            <i class="fa-solid fa-cart-shopping"></i>
            @php $cartCount = session('cart') ? count(session('cart')) : 0; @endphp
            <span class="cart-count-badge bottom-cart-badge" style="{{ $cartCount > 0 ? '' : 'display: none !important;' }}">{{ $cartCount }}</span>
            <span>ตะกร้า</span>
        </a>
        <a href="{{ route('promotions.index') }}" class="nav-item {{ request()->routeIs('promotions.*') ? 'active' : '' }}">
            <i class="fa-solid fa-fire"></i>
            <span>โปรเด็ด</span>
        </a>
        <a href="javascript:void(0)" id="mobile-menu-toggle-btn" onclick="toggleMobileMenu()" class="nav-item">
            <i class="fa-solid fa-bars" id="mobile-menu-icon"></i>
            <span>เมนู</span>
        </a>
    </div>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Google Material Style Centered Multicolor Spinner (No Backdrop, Non-blocking) -->
    <style>
        @keyframes googleSpinnerRotate {
            100% {
                transform: rotate(360deg);
            }
        }
        @keyframes googleSpinnerDash {
            0% {
                stroke-dasharray: 1, 200;
                stroke-dashoffset: 0;
            }
            50% {
                stroke-dasharray: 130, 200;
                stroke-dashoffset: -35px;
            }
            100% {
                stroke-dasharray: 130, 200;
                stroke-dashoffset: -160px;
            }
        }
        @keyframes googleSpinnerColors {
            0%, 100% { stroke: #4285F4; } /* Google Blue */
            25%      { stroke: #EA4335; } /* Google Red */
            50%      { stroke: #FBBC05; } /* Google Yellow */
            75%      { stroke: #34A853; } /* Google Green */
        }
        .google-center-spinner-wrapper {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 99999999;
            pointer-events: none;
            opacity: 1;
            visibility: visible;
            transition: opacity 0.3s ease, visibility 0.3s ease, transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .google-spinner {
            width: 68px;
            height: 68px;
            animation: googleSpinnerRotate 1.4s linear infinite;
            filter: drop-shadow(0 6px 16px rgba(0, 0, 0, 0.22));
        }
        .google-spinner-path {
            stroke-dasharray: 1, 200;
            stroke-dashoffset: 0;
            animation: googleSpinnerDash 1.4s ease-in-out infinite, googleSpinnerColors 5.6s ease-in-out infinite;
            stroke-linecap: round;
        }
    </style>
    <div id="floating-mini-loader" class="google-center-spinner-wrapper">
        <svg class="google-spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
            <circle class="google-spinner-path" fill="none" stroke-width="5.5" stroke-linecap="round" cx="33" cy="33" r="27"></circle>
        </svg>
    </div>



    <!-- Footer -->
    <footer class="footer-houkbank-style">
        <div class="houkbank-top-waves-wrapper">
            <svg class="houkbank-top-waves-svg" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
                <defs>
                    <path id="gentle-wave-top-path" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
                </defs>
                <g class="parallax-waves">
                    <use href="#gentle-wave-top-path" x="48" y="0" fill="rgba(186, 230, 253, 0.4)" />
                    <use href="#gentle-wave-top-path" x="48" y="3" fill="rgba(14, 116, 144, 0.6)" />
                    <use href="#gentle-wave-top-path" x="48" y="5" fill="rgba(3, 105, 161, 0.85)" />
                    <use href="#gentle-wave-top-path" x="48" y="7" fill="#0C4A6E" />
                </g>
            </svg>
        </div>

        <div class="container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 2.5rem; max-width: 1200px; margin: 0 auto; padding-top: 3.5rem;">
            <div>
                <h3 style="font-weight: 900; font-size: 1.35rem; color: #FFE600; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 10px;">
                    <img src="{{ asset('images/logoddphone.png') }}" alt="DDPHONE Logo" style="height: 36px; width: auto; filter: drop-shadow(0 2px 4px rgba(255,230,0,0.3));" onerror="this.src='{{ asset('logoddphone.png') }}'">
                    <span>DDPHONE ดีดีโฟน</span>
                </h3>
                <p style="color: #FFFFFF; line-height: 1.7; font-size: 0.9rem; font-weight: 700;">
                    ศูนย์รวมโทรศัพท์มือถือ iPhone, iPad มือสองคัดเกรด A+ คุณภาพสูง รับประกันร้าน 30 วัน และบริการซ่อมครบวงจร (บริษัท ดีดี.ไอที.คอม จำกัด)
                </p>
                <p style="color: #FFFFFF; font-size: 0.88rem; margin-top: 1rem; font-weight: 800; line-height: 1.6;">
                    📍 <strong style="color: #FFE600;">ที่ตั้งหน้าร้าน:</strong> 72/47-48ก ถนนชัยประสิทธิ์ ต.ในเมือง อ.เมือง จ.ชัยภูมิ 36000
                </p>
            </div>

            <div>
                <h3 style="font-weight: 900; font-size: 1.15rem; color: #FFE600; margin-bottom: 1.25rem;">
                    📞 ติดต่อร้าน DDPHONE
                </h3>
                <p style="color: #FFFFFF; font-size: 0.92rem; margin-bottom: 0.6rem; font-weight: 700;">
                    📞 <strong style="color: #FFE600;">เบอร์โทรศัพท์:</strong> <a href="tel:0868699666" style="color: #FFFFFF; text-decoration: underline; font-weight: 900;">086-869-9666</a>
                </p>
                <p style="color: #FFFFFF; font-size: 0.92rem; margin-bottom: 0.6rem; font-weight: 700;">
                    ✉️ <strong style="color: #FFE600;">อีเมล:</strong> ddphonechaiyaphume@gmail.com
                </p>
                <p style="color: #FFFFFF; font-size: 0.88rem; margin-top: 0.6rem; font-weight: 700;">
                    ⏰ <strong style="color: #FFE600;">เวลาทำการ:</strong> เปิดให้บริการทุกวัน 09:00 - 19:00 น.
                </p>
                
                <div style="display: flex; gap: 12px; margin-top: 1.25rem;">
                    <a href="https://www.facebook.com/DDPHONECP" target="_blank" title="Facebook Page" 
                       style="width: 44px; height: 44px; background: #1877F2; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; transition: transform 0.2s; text-decoration: none; font-size: 1.25rem; box-shadow: 0 4px 12px rgba(24, 119, 242, 0.4);"
                       onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="https://line.me/ti/p/@ddphone" target="_blank" title="Line Official" 
                       style="width: 44px; height: 44px; background: #06C755; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; transition: transform 0.2s; text-decoration: none; font-size: 1.25rem; box-shadow: 0 4px 12px rgba(6, 199, 85, 0.4);"
                       onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                        <i class="fa-brands fa-line"></i>
                    </a>
                </div>
            </div>

            <div>
                <h3 style="font-weight: 900; font-size: 1.15rem; color: #FFE600; margin-bottom: 1.25rem;">
                    🔧 บริการ & ช่วยเหลือ
                </h3>
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <a href="{{ route('service_center') }}" style="color: #FFFFFF; text-decoration: none; font-size: 0.92rem; font-weight: 700; transition: color 0.2s;" onmouseover="this.style.color='#FFE600'" onmouseout="this.style.color='#FFFFFF'">🔧 ศูนย์ซ่อม & เคลมประกันออนไลน์</a>
                    <a href="{{ route('tracking') }}" style="color: #FFFFFF; text-decoration: none; font-size: 0.92rem; font-weight: 700; transition: color 0.2s;" onmouseover="this.style.color='#FFE600'" onmouseout="this.style.color='#FFFFFF'">📦 ติดตามสถานะงานซ่อม</a>
                    <a href="{{ route('help_center') }}" style="color: #FFFFFF; text-decoration: none; font-size: 0.92rem; font-weight: 700; transition: color 0.2s;" onmouseover="this.style.color='#FFE600'" onmouseout="this.style.color='#FFFFFF'">❓ ศูนย์ช่วยเหลือ & คำถามที่พบบ่อย (FAQ)</a>
                </div>
            </div>

            <div>
                <a href="https://maps.app.goo.gl/M46KgXmQrN4SMQATA" target="_blank" style="text-decoration: none; color: inherit; display: block;">
                    <h3 style="font-weight: 900; font-size: 1.15rem; color: #FFE600; margin-bottom: 1.25rem; display: flex; align-items: center; justify-content: space-between; gap: 8px;">
                        <span style="display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-map-location-dot" style="color: #FFE600;"></i> 📍 ปักหมุดหน้าร้าน DDPHONE
                        </span>
                        <span style="font-size: 0.72rem; background: rgba(255,230,0,0.2); color: #FFE600; padding: 3px 10px; border-radius: 99px; border: 1px solid #FFE600; white-space: nowrap; display: inline-flex; align-items: center; gap: 4px; flex-shrink: 0;">🗺️ เปิดแผนที่</span>
                    </h3>
                    <div style="border-radius: 18px; overflow: hidden; border: 2px solid #FFE600; box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4); background: #1E293B; transition: transform 0.25s ease;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                        <iframe src="https://maps.google.com/maps?q={{ urlencode('บริษัท ดีดี.ไอที.คอม จำกัด') }}&hl=th&z=17&output=embed" 
                                width="100%" height="145" style="border:0; display:block; pointer-events: none;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </a>
            </div>
        </div>

        <div style="border-top: 1.5px solid rgba(255, 255, 255, 0.1); margin-top: 3rem; padding-top: 1.5rem; text-align: center; color: #94A3B8; font-size: 0.85rem; font-weight: 700;">
            © {{ date('Y') }} DDPHONE ดีดีโฟน (บริษัท ดีดี.ไอที.คอม จำกัด) — สงวนลิขสิทธิ์ทุกประการ
        </div>
    </footer>

    <x-chat-widget />

    <script>
        // Global Crystal-Clear Web Audio Manager for DDPHONE Notifications & Chat
        window.DDPhoneAudio = (function() {
            let ctx = null;

            function getAudioContext() {
                if (!ctx) {
                    const AudioCtx = window.AudioContext || window.webkitAudioContext;
                    if (AudioCtx) {
                        ctx = new AudioCtx();
                    }
                }
                if (ctx && ctx.state === 'suspended') {
                    ctx.resume().catch(() => {});
                }
                return ctx;
            }

            const unlockEvents = ['click', 'touchstart', 'touchend', 'keydown', 'scroll', 'mousemove'];
            function unlockAudioContext() {
                const audioCtx = getAudioContext();
                if (audioCtx && audioCtx.state === 'running') {
                    unlockEvents.forEach(evt => window.removeEventListener(evt, unlockAudioContext, true));
                }
            }
            unlockEvents.forEach(evt => window.addEventListener(evt, unlockAudioContext, true));

            function playNote(freq, startTime, duration, type = 'sine', maxVol = 0.25) {
                const audioCtx = getAudioContext();
                if (!audioCtx) return;

                const triggerSound = () => {
                    try {
                        const osc = audioCtx.createOscillator();
                        const gain = audioCtx.createGain();

                        osc.type = type;
                        osc.frequency.setValueAtTime(freq, audioCtx.currentTime + startTime);

                        gain.gain.setValueAtTime(maxVol, audioCtx.currentTime + startTime);
                        gain.gain.exponentialRampToValueAtTime(0.0001, audioCtx.currentTime + startTime + duration);

                        osc.connect(gain);
                        gain.connect(audioCtx.destination);

                        osc.start(audioCtx.currentTime + startTime);
                        osc.stop(audioCtx.currentTime + startTime + duration);
                    } catch(e) {
                        console.warn('Audio tone play error:', e);
                    }
                };

                if (audioCtx.state === 'suspended') {
                    audioCtx.resume().then(triggerSound).catch(() => {});
                } else {
                    triggerSound();
                }
            }

            return {
                unlock() {
                    getAudioContext();
                },
                playNotification() {
                    // 3-note cheerful notification bell: G5 (783.99Hz) -> C6 (1046.50Hz) -> E6 (1318.51Hz)
                    playNote(783.99, 0, 0.18, 'sine', 0.25);
                    playNote(1046.50, 0.12, 0.22, 'sine', 0.28);
                    playNote(1318.51, 0.26, 0.35, 'sine', 0.30);
                },
                playChat() {
                    // 2-note message chime: High C6 (1046.50Hz) -> G6 (1567.98Hz)
                    playNote(1046.50, 0, 0.12, 'sine', 0.22);
                    playNote(1567.98, 0.09, 0.22, 'sine', 0.25);
                }
            };
        })();

        function notificationBell() {
            return {
                open: false,
                notifications: [],
                unreadCount: 0,
                lastId: null,
                polling: null,
                init() {
                    this.fetchNotifications(true);
                    // Poll every 4s for real-time customer notifications
                    this.polling = setInterval(() => {
                        this.fetchNotifications(false);
                    }, 4000);
                    if ('Notification' in window && Notification.permission === 'default') {
                        Notification.requestPermission();
                    }
                },
                playBellSound() {
                    if (window.DDPhoneAudio) {
                        window.DDPhoneAudio.playNotification();
                    }
                },
                showToast(title, message) {
                    if (typeof Swal !== 'undefined') {
                        Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 4000,
                            timerProgressBar: true,
                        }).fire({ icon: 'info', title: title, text: message });
                    }
                    if ('Notification' in window && Notification.permission === 'granted') {
                        new Notification(title, { body: message, icon: '/images/logoddphone.png' });
                    }
                },
                fetchNotifications(isInitial = false) {
                    fetch('/notifications/unread-data?_t=' + Date.now(), {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'Cache-Control': 'no-cache',
                        },
                        credentials: 'same-origin'
                    })
                    .then(res => { if (!res.ok) throw new Error(); return res.json(); })
                    .then(data => {
                        let newLatestId = data.latest_id;
                        let newUnread = data.unread_count || 0;
                        let newNotifs = data.notifications || [];

                        if (!isInitial) {
                            let hasNew = (newLatestId && this.lastId && newLatestId !== this.lastId)
                                      || (newUnread > this.unreadCount);
                            if (hasNew) {
                                this.playBellSound();
                                if (newNotifs.length > 0) this.showToast(newNotifs[0].title, newNotifs[0].message);
                                let bellEl = document.querySelector('.animate-bell-period');
                                if (bellEl) {
                                    bellEl.classList.add('bell-shake');
                                    setTimeout(() => bellEl.classList.remove('bell-shake'), 1000);
                                }
                            }
                        }
                        this.notifications = newNotifs;
                        this.unreadCount = newUnread;
                        this.lastId = newLatestId;
                    })
                    .catch(() => {});
                },
                openNotifPopup(item) {
                    this.open = false;
                    item.is_read = true;
                    if (typeof Swal === 'undefined') {
                        alert((item.title || '') + '\n\n' + (item.message || ''));
                        return;
                    }
                    Swal.fire({
                        title: item.title || 'การแจ้งเตือน',
                        html: '<div style="text-align:left;font-size:0.93rem;line-height:1.7;color:#0F172A;padding:6px 0">'
                            + '<p style="white-space:pre-wrap;font-weight:700;color:#334155;margin-bottom:12px">' + (item.message || '') + '</p>'
                            + '<div style="font-size:0.77rem;color:#0284C7;font-weight:800">🕒 ' + (item.time_ago || '') + '</div>'
                            + '</div>',
                        icon: 'info',
                        showCancelButton: !!(item.url && item.url !== '#'),
                        confirmButtonText: (item.url && item.url !== '#') ? 'ไปยังหน้าเกี่ยวข้อง ➔' : 'รับทราบ',
                        cancelButtonText: 'ปิด',
                        confirmButtonColor: '#0284C7',
                        cancelButtonColor: '#94A3B8',
                    }).then((result) => {
                        if (result.isConfirmed && item.url && item.url !== '#') {
                            window.location.href = item.url;
                        }
                    });
                },
                toggleBell() {
                    if (window.DDPhoneAudio) window.DDPhoneAudio.unlock();
                    this.open = !this.open;
                    if (this.open && this.unreadCount > 0) {
                        this.unreadCount = 0;
                        fetch('/notifications/mark-all-read', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            credentials: 'same-origin'
                        }).then(r => r.json())
                          .then(() => { this.notifications = this.notifications.map(n => ({...n, is_read: true})); })
                          .catch(() => {});
                    }
                }
            };
        }


        document.addEventListener('DOMContentLoaded', function() {

            // Ultra-Fluid 60/120fps Flying Basket Animation with Particle Trail & Impact Shockwave
            window.flyToCart = function(startBtn) {
                if (!startBtn) return;

                const isMobile = window.innerWidth <= 768;
                let targetCart = null;

                if (isMobile) {
                    targetCart = document.querySelector('#mobile-cart-bottom-link i') || 
                                 document.querySelector('#mobile-cart-bottom-link') ||
                                 document.querySelector('.shopee-mobile-bottom-nav a[href*="cart"]');
                }

                if (!targetCart) {
                    targetCart = document.querySelector('#cart-badge-link i') || 
                                 document.querySelector('#cart-badge-link') || 
                                 document.querySelector('.fa-basket-shopping');
                }

                if (!targetCart) return;

                const btnRect = startBtn.getBoundingClientRect();
                const cartRect = targetCart.getBoundingClientRect();

                const startX = btnRect.left + btnRect.width / 2;
                const startY = btnRect.top + btnRect.height / 2;
                const endX = cartRect.left + cartRect.width / 2;
                const endY = cartRect.top + cartRect.height / 2;

                // Create Main Glowing Flyer Element
                const flyer = document.createElement('div');
                flyer.innerHTML = '<i class="fa-solid fa-basket-shopping" style="color: #FFE600; font-size: 1.15rem; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.4));"></i>';
                flyer.style.cssText = `
                    position: fixed;
                    z-index: 9999999;
                    left: 0px;
                    top: 0px;
                    width: 40px;
                    height: 40px;
                    background: radial-gradient(circle, #1E293B 0%, #0F172A 100%);
                    border: 2px solid #FFE600;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    box-shadow: 0 0 20px rgba(255, 230, 0, 0.75), 0 8px 25px rgba(15, 23, 42, 0.6);
                    pointer-events: none;
                    will-change: transform, opacity;
                    transform-origin: center center;
                `;
                document.body.appendChild(flyer);

                // Smooth Parabola Control Point Calculation
                const isXRight = endX > startX;
                const distanceX = Math.abs(endX - startX);
                const distanceY = Math.abs(endY - startY);

                const controlX = isMobile 
                    ? startX + (isXRight ? distanceX * 0.35 : -distanceX * 0.35) 
                    : (startX + endX) / 2;
                    
                const controlY = Math.min(startY, endY) - (isMobile ? Math.min(distanceY * 0.5, 140) : 100);

                const duration = 680; // Ultra smooth ~0.68s
                const startTime = performance.now();
                let lastParticleTime = 0;

                function animate(currentTime) {
                    const elapsed = currentTime - startTime;
                    const rawProgress = Math.min(elapsed / duration, 1);

                    // Fluid Cubic-Bezier Ease Out Interpolation
                    const t = 1 - Math.pow(1 - rawProgress, 3.2);

                    // Quadratic Bezier Formula: (1-t)^2 * P0 + 2(1-t)t * P1 + t^2 * P2
                    const currentX = (1 - t) * (1 - t) * startX + 2 * (1 - t) * t * controlX + t * t * endX;
                    const currentY = (1 - t) * (1 - t) * startY + 2 * (1 - t) * t * controlY + t * t * endY;

                    // Fluid Scaling & Smooth Rotation along trajectory
                    const scale = 1.12 - 0.78 * t;
                    const rotation = t * 540; // 1.5 graceful spins
                    const opacity = rawProgress > 0.9 ? (1 - (rawProgress - 0.9) / 0.1) : 1;

                    flyer.style.transform = `translate3d(${currentX - 20}px, ${currentY - 20}px, 0) scale(${scale}) rotate(${rotation}deg)`;
                    flyer.style.opacity = opacity;

                    // Spawn Golden Sparkle Particle Trail
                    if (currentTime - lastParticleTime > 35 && rawProgress < 0.88) {
                        lastParticleTime = currentTime;
                        createSparkleParticle(currentX, currentY);
                    }

                    if (rawProgress < 1) {
                        requestAnimationFrame(animate);
                    } else {
                        if (flyer.parentNode) flyer.parentNode.removeChild(flyer);

                        // Elastic Ripple Impact Wobble on Target Cart Icon
                        triggerCartImpact(targetCart, isMobile);
                    }
                }

                // Sparkle Trail Generator
                function createSparkleParticle(x, y) {
                    const particle = document.createElement('div');
                    particle.style.cssText = `
                        position: fixed;
                        z-index: 9999998;
                        left: ${x - 4}px;
                        top: ${y - 4}px;
                        width: 8px;
                        height: 8px;
                        background: #FFE600;
                        border-radius: 50%;
                        pointer-events: none;
                        box-shadow: 0 0 10px #FFE600;
                        will-change: transform, opacity;
                        transition: all 0.4s ease-out;
                    `;
                    document.body.appendChild(particle);

                    requestAnimationFrame(() => {
                        particle.style.transform = `scale(0.2) translate(${(Math.random() - 0.5) * 16}px, ${(Math.random() - 0.5) * 16}px)`;
                        particle.style.opacity = '0';
                    });

                    setTimeout(() => {
                        if (particle.parentNode) particle.parentNode.removeChild(particle);
                    }, 400);
                }

                // Elastic Impact & Shockwave Ring
                function triggerCartImpact(target, isMobile) {
                    const bounceTarget = isMobile ? (document.querySelector('#mobile-cart-bottom-link') || target) : target;
                    if (!bounceTarget) return;

                    // Expanding Shockwave Ripple
                    const ripple = document.createElement('div');
                    const targetRect = bounceTarget.getBoundingClientRect();
                    ripple.style.cssText = `
                        position: fixed;
                        z-index: 999999;
                        left: ${targetRect.left + targetRect.width / 2 - 25}px;
                        top: ${targetRect.top + targetRect.height / 2 - 25}px;
                        width: 50px;
                        height: 50px;
                        border: 2px solid #FFE600;
                        border-radius: 50%;
                        pointer-events: none;
                        box-shadow: 0 0 15px #FFE600;
                        will-change: transform, opacity;
                        transition: all 0.4s cubic-bezier(0, 0, 0.2, 1);
                        transform: scale(0.3);
                        opacity: 1;
                    `;
                    document.body.appendChild(ripple);

                    requestAnimationFrame(() => {
                        ripple.style.transform = 'scale(1.8)';
                        ripple.style.opacity = '0';
                    });

                    setTimeout(() => {
                        if (ripple.parentNode) ripple.parentNode.removeChild(ripple);
                    }, 400);

                    // Elastic Spring Wobble Animation
                    bounceTarget.style.transition = 'transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.4)';
                    bounceTarget.style.transform = 'scale(1.35) rotate(-8deg)';
                    setTimeout(() => {
                        bounceTarget.style.transform = 'scale(0.95) rotate(4deg)';
                        setTimeout(() => {
                            bounceTarget.style.transform = 'scale(1) rotate(0deg)';
                        }, 150);
                    }, 150);
                }

                requestAnimationFrame(animate);
            };

            // AJAX add to cart
            document.body.addEventListener('submit', function(e) {
                if (e.target && e.target.classList.contains('ajax-add-to-cart-form')) {
                    e.preventDefault();
                    const form = e.target;
                    const actionUrl = form.action;
                    const formData = new FormData(form);
                    const submitBtn = form.querySelector('button[type="submit"]') || form.querySelector('button');

                    fetch(actionUrl, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json().then(data => ({ ok: response.ok, body: data })))
                    .then(res => {
                        const data = res.body;
                        if (res.ok && data.success) {
                            if (submitBtn) {
                                window.flyToCart(submitBtn);
                            }
                            document.querySelectorAll('.cart-count-badge').forEach(el => {
                                el.textContent = data.cart_count;
                                el.style.display = data.cart_count > 0 ? 'inline-block' : 'none';
                            });
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'bottom-end',
                                showConfirmButton: false,
                                timer: 2500,
                                timerProgressBar: true
                            });
                            Toast.fire({
                                icon: 'success',
                                title: data.message || '🛒 เพิ่มสินค้าลงตะกร้าเรียบร้อยแล้ว!'
                            });
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: 'ไม่สามารถเพิ่มสินค้าลงตะกร้าได้',
                                text: data.message || 'สินค้าชิ้นนี้หมดแล้ว หรือจำนวนสต๊อกมีไม่เพียงพอ',
                                confirmButtonColor: '#0F172A',
                                confirmButtonText: 'เข้าใจแล้ว'
                            });
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        form.submit();
                    });
                }
            });

            // AJAX Wishlist Toggle
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
            const btn = document.getElementById('mobile-menu-toggle-btn');
            const icon = document.getElementById('mobile-menu-icon');
            if (drawer && overlay) {
                const isOpening = !drawer.classList.contains('open');

                // Press bounce effect on the button
                if (btn) {
                    btn.style.transform = 'scale(0.82)';
                    btn.style.transition = 'transform 0.12s cubic-bezier(0.34, 1.56, 0.64, 1)';
                    setTimeout(() => {
                        btn.style.transform = 'scale(1.08)';
                        setTimeout(() => { btn.style.transform = 'scale(1)'; }, 100);
                    }, 90);
                }

                // Icon swap: bars ↔ xmark
                if (icon) {
                    icon.style.transform = 'rotate(90deg) scale(0.7)';
                    icon.style.transition = 'transform 0.18s ease';
                    setTimeout(() => {
                        if (isOpening) {
                            icon.className = 'fa-solid fa-xmark';
                        } else {
                            icon.className = 'fa-solid fa-bars';
                        }
                        icon.style.transform = 'rotate(0deg) scale(1)';
                    }, 160);
                }

                drawer.classList.toggle('open');
                overlay.classList.toggle('open');

                // No body scroll lock since it's a small popup now
                document.body.style.overflow = '';
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

        // Sticky Header & Smart Auto-Fold Topbar (100% Gapless Unified Motion)
        let lastScrollY = window.scrollY;

        window.addEventListener('scroll', function() {
            const currentScrollY = window.scrollY;
            const headerWrapper = document.querySelector('.header-sticky-wrapper');
            const nav = document.getElementById('main-navbar');
            
            if (currentScrollY > 40) {
                if (headerWrapper) headerWrapper.classList.add('scrolled-header');
                if (nav) nav.classList.add('navbar-scrolled');
                
                // Detect Scroll Direction to move the entire header wrapper as one solid block (0px gap!)
                if (currentScrollY > lastScrollY + 4) {
                    // Scrolling DOWN -> Shift entire wrapper up by 35px so topbar hides seamlessly
                    if (headerWrapper) headerWrapper.classList.add('topbar-hidden');
                } else if (currentScrollY < lastScrollY - 4) {
                    // Scrolling UP -> Shift entire wrapper down to reveal topbar seamlessly
                    if (headerWrapper) headerWrapper.classList.remove('topbar-hidden');
                }
            } else {
                // At top of page -> Keep both bars fully visible
                if (headerWrapper) {
                    headerWrapper.classList.remove('scrolled-header');
                    headerWrapper.classList.remove('topbar-hidden');
                }
                if (nav) nav.classList.remove('navbar-scrolled');
            }
            
            lastScrollY = currentScrollY;
        }, { passive: true });

        // Global Page Loading Progress Controller (YouTube / GitHub style top bar)
        (function() {
            const topBar = document.getElementById('top-loading-bar');
            
            function startLoading() {
                if (topBar) {
                    topBar.style.opacity = '1';
                    topBar.style.width = '35%';
                    setTimeout(() => { 
                        if (topBar.style.width === '35%') topBar.style.width = '75%'; 
                    }, 200);
                }
            }

            function finishLoading() {
                if (topBar) {
                    topBar.style.width = '100%';
                    setTimeout(() => {
                        topBar.style.opacity = '0';
                        setTimeout(() => { topBar.style.width = '0%'; }, 300);
                    }, 250);
                }
            }

            if (document.readyState === 'complete') {
                finishLoading();
            } else {
                window.addEventListener('load', finishLoading);
            }

            document.addEventListener('click', function(e) {
                const link = e.target.closest('a');
                if (link && link.href && !link.target && !link.hasAttribute('download') && !link.href.startsWith('javascript:')) {
                    try {
                        const url = new URL(link.href, window.location.origin);
                        if (url.origin === window.location.origin && !url.hash && url.pathname !== window.location.pathname) {
                            startLoading();
                        }
                    } catch(err) {}
                }
            });

            window.addEventListener('pageshow', function(e) {
                if (e.persisted) {
                    finishLoading();
                }
            });
        })();

        // Global Button Animation Helpers
        window.animateHeartBtn = function(btn) {
            if (!btn) return;
            btn.classList.add('heart-pop-anim');
            setTimeout(() => btn.classList.remove('heart-pop-anim'), 450);
        };

        window.animateBasketBtn = function(btn) {
            if (!btn) return;
            btn.classList.add('basket-bounce-anim');
            setTimeout(() => btn.classList.remove('basket-bounce-anim'), 450);
        };

        // Clean Center Multicolor Loader Script (Non-blocking)
        (function() {
            const loader = document.getElementById('floating-mini-loader');
            if (!loader) return;

            function showLoader() {
                loader.style.visibility = 'visible';
                loader.style.opacity = '1';
                loader.style.transform = 'translate(-50%, -50%) scale(1)';
            }

            function hideLoader() {
                setTimeout(() => {
                    loader.style.opacity = '0';
                    loader.style.transform = 'translate(-50%, -50%) scale(0.7)';
                    setTimeout(() => {
                        loader.style.visibility = 'hidden';
                    }, 250);
                }, 150);
            }

            if (document.readyState === 'complete') {
                hideLoader();
            } else {
                window.addEventListener('load', hideLoader);
            }

            setTimeout(hideLoader, 1500);

            document.addEventListener('click', function(e) {
                const link = e.target.closest('a');
                if (link && link.href && !link.target && !link.hasAttribute('download')) {
                    const href = link.getAttribute('href');
                    if (href && !href.startsWith('javascript:') && href !== '#') {
                        showLoader();
                    }
                }
            });

            document.addEventListener('submit', function(e) {
                if (e.target && !e.target.classList.contains('ajax-add-to-cart-form')) {
                    showLoader();
                }
            });

            window.addEventListener('pageshow', function(e) {
                if (e.persisted) hideLoader();
            });
        })();
    </script>
</div>
</body>
</html>

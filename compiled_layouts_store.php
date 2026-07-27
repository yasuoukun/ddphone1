<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DDIT | จำหน่ายโทรศัพท์มือถือและสินค้าไอทีทุกประเภท ครบวงจร</title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3/dist/cdn.min.js" defer></script>
    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/theme.css')); ?>?v=<?php echo e(time()); ?>">
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="antialiased" data-logged-in="<?php echo e(auth()->check() ? 'true' : 'false'); ?>">
    <div x-data="{ mobileMenuOpen: false }">

    <!-- Top Bar (Section 1: Soft Blue Gradient Header) -->
    <div class="topbar" style="position: relative; z-index: 1100;">
        <div class="topbar-left" style="display: flex; align-items: center; gap: 15px;">
            <a href="https://www.facebook.com/dditcom" target="_blank" style="display: inline-flex; align-items: center; gap: 5px;"><i class="fa-brands fa-facebook" style="color: #1877f2;"></i> <span class="topbar-txt-label">Facebook</span></a>
            <a href="https://line.me/ti/p/@dditcom" target="_blank" style="display: inline-flex; align-items: center; gap: 5px;"><i class="fa-brands fa-line" style="color: #06c755;"></i> <span class="topbar-txt-label">Line</span></a>
            <a href="tel:0868699666" style="display: inline-flex; align-items: center; gap: 5px;"><i class="fa-solid fa-phone" style="color: #0F172A;"></i> <span class="topbar-txt-label">086-869-9666</span></a>
        </div>
        <div class="topbar-right" style="display: flex; align-items: center; gap: 14px;" x-data="{ openProfile: false }">
            <?php if(auth()->guard()->check()): ?>
                <!-- User Profile Title Box -->
                <div style="position: relative; display: inline-block; z-index: 1200;">
                    <button @click="openProfile = !openProfile" @click.away="openProfile = false" style="background: rgba(15, 23, 42, 0.08); border: 1px solid rgba(15, 23, 42, 0.15); color: #0F172A; padding: 4px 12px; border-radius: 99px; cursor: pointer; font-weight: 800; display: flex; align-items: center; gap: 8px; font-family: 'Prompt', sans-serif; font-size: 0.85rem; transition: all 0.2s;" onmouseover="this.style.background='rgba(15, 23, 42, 0.15)'" onmouseout="this.style.background='rgba(15, 23, 42, 0.08)'">
                        <img src="<?php echo e(auth()->user()->avatar_url); ?>" alt="" style="width: 26px; height: 26px; border-radius: 50%; object-fit: cover; border: 1.5px solid #0F172A;">
                        <span><?php echo e(auth()->user()->name); ?></span> <span style="font-size: 0.7rem;">▼</span>
                    </button>
                    <div x-show="openProfile" x-transition style="display: none; position: absolute; right: 0; top: 100%; margin-top: 8px; background: white; border: 1.5px solid #E2E8F0; border-radius: 14px; box-shadow: 0 10px 30px rgba(15,23,42,0.18); z-index: 9999; min-width: 190px; text-align: left; padding: 0.5rem 0;">
                        <a href="<?php echo e(route('dashboard')); ?>" style="display: block; padding: 10px 16px; color: #0F172A; text-decoration: none; font-weight: 700; font-size: 0.88rem; transition: background 0.2s;" onmouseover="this.style.background='#F1F5F9'" onmouseout="this.style.background='transparent'">
                            👤 ข้อมูลส่วนตัว
                        </a>
                        <hr style="border: 0; border-top: 1px solid #E2E8F0; margin: 0.25rem 0;">
                        <form method="POST" action="<?php echo e(route('logout')); ?>" style="margin: 0;">
                            <?php echo csrf_field(); ?>
                            <button type="submit" style="width: 100%; text-align: left; background: none; border: none; padding: 10px 16px; color: #EF4444; cursor: pointer; font-weight: 800; font-size: 0.88rem; font-family: 'Prompt', sans-serif; transition: background 0.2s;" onmouseover="this.style.background='rgba(239, 68, 68, 0.08)'" onmouseout="this.style.background='transparent'">
                                🚪 ออกจากระบบ
                            </button>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" style="color: #0F172A; font-weight: 800; text-decoration: none; font-size: 0.85rem;">เข้าสู่ระบบ</a>
                <span style="color: #94A3B8;">|</span>
                <a href="<?php echo e(route('register')); ?>" style="color: #0F172A; font-weight: 800; text-decoration: none; font-size: 0.85rem;">สมัครสมาชิก</a>
            <?php endif; ?>

            <?php if(auth()->guard()->check()): ?>
                <?php if(auth()->user()->role === 'customer'): ?>
                <a href="javascript:void(0)" onclick="window.dispatchEvent(new CustomEvent('open-customer-chat'))" title="แชทติดต่อสอบถามกับร้านค้า" style="position: relative; display: inline-flex; align-items: center; color: #0F172A; text-decoration: none;">
                    <i class="fa-solid fa-comment-dots" style="font-size: 1.15rem;"></i>
                    <span class="customer-nav-chat-badge" style="display: none; position: absolute; top: -7px; right: -8px; background: #ef4444; color: white; border-radius: 50%; padding: 1px 5px; font-size: 0.65rem; font-weight: bold; min-width: 14px; text-align: center; line-height: 1.2;"></span>
                </a>
                <?php endif; ?>
            <?php endif; ?>

            <!-- Notification Bell with Alpine.js Real-time Component -->
            <?php if(auth()->guard()->check()): ?>
            <div x-data="notificationBell()" x-init="initBell()" style="position: relative; display: inline-block; z-index: 1200;">
                <button @click="toggleBell()" @click.away="open = false" title="การแจ้งเตือน" style="background: none; border: none; color: #0F172A; cursor: pointer; display: flex; align-items: center; position: relative; padding: 2px;">
                    <i class="fa-solid fa-bell animate-bell-period" style="font-size: 1.15rem;"></i>
                    <span x-show="unreadCount > 0" 
                          x-text="unreadCount" 
                          style="position: absolute; top: -6px; right: -8px; background: #ef4444; color: white; border-radius: 50%; padding: 1px 5px; font-size: 0.65rem; font-weight: bold; min-width: 14px; text-align: center; line-height: 1.2;">
                    </span>
                </button>
                <div x-show="open" x-cloak x-transition style="display: none; position: absolute; right: 0; top: 100%; margin-top: 15px; background: white; border: 1.5px solid #E2E8F0; border-radius: 16px; box-shadow: 0 10px 30px rgba(15,23,42,0.18); z-index: 9999; width: 320px; text-align: left; padding: 0; overflow: hidden;">
                    <div style="padding: 12px 15px; background: #F8FAFC; border-bottom: 1px solid #E2E8F0; display: flex; justify-content: space-between; align-items: center;">
                        <h4 style="margin: 0; font-size: 0.95rem; font-weight: 800; color: #0F172A;">การแจ้งเตือน</h4>
                    </div>
                    <div style="max-height: 300px; overflow-y: auto;">
                        <div x-show="notifications.length === 0" style="padding: 20px; text-align: center; color: #94a3b8; font-size: 0.85rem;">
                            ไม่มีรายการแจ้งเตือนในขณะนี้
                        </div>
                        <template x-for="item in notifications" :key="item.id">
                            <a :href="item.url || '#'" 
                               :style="item.is_read ? 'background: white;' : 'background: #EFF6FF;'"
                               style="display: block; padding: 12px 15px; text-decoration: none; border-bottom: 1px solid #F1F5F9; transition: background 0.2s;">
                                <div style="display: flex; gap: 10px;">
                                    <div x-show="item.image" style="flex-shrink: 0;">
                                        <img :src="item.image" style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover;">
                                    </div>
                                    <div x-show="!item.image" style="width: 40px; height: 40px; border-radius: 8px; background: #0F172A; color: #FFE600; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 1.2rem;">
                                        <i class="fa-solid fa-bullhorn"></i>
                                    </div>
                                    <div>
                                        <h5 style="margin: 0 0 4px; font-size: 0.85rem; font-weight: 800; color: #0F172A; line-height: 1.3;" x-text="item.title"></h5>
                                        <p style="margin: 0 0 6px; font-size: 0.75rem; color: #64748b; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;" x-text="item.message"></p>
                                        <span style="font-size: 0.65rem; color: #94a3b8;" x-text="item.time_ago"></span>
                                    </div>
                                </div>
                            </a>
                        </template>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Heart Wishlist Icon with Periodic Motion -->
            <a href="<?php echo e(route('dashboard', ['tab' => 'wishlist'])); ?>" title="สินค้าที่ชอบ" style="display: inline-flex; align-items: center; color: #EF4444; text-decoration: none;">
                <i class="fa-solid fa-heart animate-heart-period" style="font-size: 1.15rem;"></i>
            </a>

            <!-- Cart Icon (Badge shown ONLY if count > 0) -->
            <a href="<?php echo e(route('cart.index')); ?>" id="cart-badge-link" title="ตะกร้าสินค้า" style="display: inline-flex; align-items: center; gap: 6px; color: #0F172A; text-decoration: none;">
                <i class="fa-solid fa-basket-shopping" style="font-size: 1.15rem;"></i>
                <?php if(count(session('cart', [])) > 0): ?>
                <span id="cart-count" class="cart-count-badge" style="background: #ef4444; color: white; border-radius: 50%; padding: 1px 6px; font-size: 0.75rem; font-weight: bold; min-width: 18px; text-align: center; display: inline-block; line-height: 1.4;">
                    <?php echo e(count(session('cart', []))); ?>

                </span>
                <?php endif; ?>
            </a>
        </div>
    </div>

    <!-- Main Navbar (Section 1: Signature Yellow Header with Translucent Glass Scroll) -->
    <nav class="navbar" id="main-navbar">
        <div style="display: flex; align-items: center; gap: 14px;">
            <a href="<?php echo e(url('/')); ?>" class="navbar-brand" style="display: flex; align-items: center; gap: 10px; text-decoration: none;">
                <img src="<?php echo e(asset('images/logoddphone.png')); ?>" alt="DDPHONE Logo" style="height: 42px; width: auto; object-fit: contain; filter: drop-shadow(0 2px 4px rgba(15, 23, 42, 0.15));" onerror="this.src='<?php echo e(asset('logoddphone.png')); ?>'">
                <span style="font-size: 1.25rem; font-weight: 900; color: #0F172A; letter-spacing: 0.5px;">DDPHONE ดีดีโฟน</span>
            </a>
            <!-- Search Bar Attached right next to Logo -->
            <form action="<?php echo e(route('products.index')); ?>" method="GET" style="margin: 0; display: flex; align-items: center; background: #FFFFFF; border: 1.5px solid rgba(15, 23, 42, 0.15); border-radius: 99px; padding: 4px 6px 4px 16px; width: 230px; max-width: 100%; flex-shrink: 0; box-shadow: 0 2px 8px rgba(15,23,42,0.04);">
                <input type="text" name="q" value="<?php echo e(request('q')); ?>" placeholder="ค้นหามือถือ iPhone, iPad มือสอง..." style="background: none; border: none; outline: none; color: #0F172A; font-weight: 700; width: 100%; font-family: 'Prompt', sans-serif; font-size: 0.82rem;">
                <button type="submit" style="background: #0F172A; border: none; color: #FFE600; cursor: pointer; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'">
                    <i class="fa-solid fa-magnifying-glass" style="font-size: 0.8rem;"></i>
                </button>
            </form>
        </div>

        <div class="navbar-links">
            <a href="<?php echo e(url('/')); ?>" class="nav-clean-link <?php echo e(request()->is('/') ? 'active-nav-tab' : ''); ?>">หน้าแรก</a>
            <a href="<?php echo e(route('products.index')); ?>" class="nav-clean-link <?php echo e(request()->routeIs('products.*') ? 'active-nav-tab' : ''); ?>">📱 มือถือมือสองทั้งหมด</a>
            <a href="<?php echo e(route('promotions.index')); ?>" class="nav-clean-link <?php echo e(request()->routeIs('promotions.*') ? 'active-nav-tab' : ''); ?>">🔥 โปรเด็ดมือสอง</a>
            
            <!-- Service & Warranty Dropdown -->
            <div class="navbar-item-dropdown">
                <a href="#" class="navbar-dropdown-trigger nav-clean-link <?php echo e((request()->routeIs('service_center') || request()->routeIs('tracking') || request()->routeIs('help_center')) ? 'active-nav-tab' : ''); ?>" onclick="toggleStoreDropdown(this, event)">
                    🔧 ศูนย์ซ่อม & เคลมประกัน <span style="font-size: 0.65rem;">▼</span>
                </a>
                <div class="navbar-dropdown-menu">
                    <a href="<?php echo e(route('service_center')); ?>" class="dropdown-item-equal">🔧 ส่งซ่อม/เคลมออนไลน์</a>
                    <a href="<?php echo e(route('tracking')); ?>" class="dropdown-item-equal">📦 ติดตามสถานะงานซ่อม</a>
                    <a href="<?php echo e(route('help_center')); ?>" class="dropdown-item-equal">❓ ศูนย์ช่วยเหลือ & คำถามพบบ่อย</a>
                </div>
            </div>

            <!-- Articles and Reviews -->
            <a href="<?php echo e(route('categoryblog')); ?>" class="nav-clean-link <?php echo e(request()->routeIs('categoryblog*') ? 'active-nav-tab' : ''); ?>">📰 บทความ & รีวิว</a>
        </div>
    </nav>

    <!-- Mobile Navigation Drawer Backdrop & Overlay -->
    <div class="mobile-drawer-overlay" onclick="toggleMobileMenu()"></div>

    <!-- Mobile Navigation Drawer -->
    <div class="mobile-drawer">
         <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 0.6rem;">
             <span style="font-size: 1rem; font-weight: 900; color: #FFE600; font-family: 'Prompt', sans-serif; display: flex; align-items: center; gap: 6px;">
                 <img src="<?php echo e(asset('images/logoddphone.png')); ?>" style="height: 22px; width: auto;" onerror="this.src='<?php echo e(asset('logoddphone.png')); ?>'">
                 DDPHONE
             </span>
             <button type="button" onclick="toggleMobileMenu()" style="background: rgba(255,255,255,0.1); border: none; color: white; width: 28px; height: 28px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                 <i class="fa-solid fa-xmark" style="font-size: 0.9rem;"></i>
             </button>
         </div>

         <form action="<?php echo e(route('products.index')); ?>" method="GET" style="margin: 0; display: flex; align-items: center; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); border-radius: 99px; padding: 5px 10px;">
             <input type="text" name="q" value="<?php echo e(request('q')); ?>" placeholder="ค้นหาสินค้า..." style="background: none; border: none; outline: none; color: white; width: 100%; font-family: 'Prompt', sans-serif; font-size: 0.76rem;">
             <button type="submit" style="background: none; border: none; color: #FFE600; cursor: pointer; display: flex; align-items: center; padding: 0;">
                 <i class="fa-solid fa-magnifying-glass" style="font-size: 0.8rem;"></i>
             </button>
         </form>

         <div style="display: flex; flex-direction: column; gap: 0.6rem; font-family: 'Prompt', sans-serif;">
             <a href="<?php echo e(url('/')); ?>" style="color: white; text-decoration: none; font-size: 0.82rem; font-weight: 600; padding: 8px 10px; border-radius: 8px; background: rgba(255,255,255,0.04); display: flex; align-items: center; gap: 8px;"><i class="fa-solid fa-house" style="width: 16px; color: #FFE600; font-size: 0.8rem;"></i> หน้าแรก</a>
             <a href="<?php echo e(route('products.index')); ?>" style="color: white; text-decoration: none; font-size: 0.82rem; font-weight: 600; padding: 8px 10px; border-radius: 8px; background: rgba(255,255,255,0.04); display: flex; align-items: center; gap: 8px;"><i class="fa-solid fa-mobile-screen" style="width: 16px; color: #FFE600; font-size: 0.8rem;"></i> มือถือมือสองทั้งหมด</a>
             <a href="<?php echo e(route('promotions.index')); ?>" style="color: white; text-decoration: none; font-size: 0.82rem; font-weight: 600; padding: 8px 10px; border-radius: 8px; background: rgba(255,255,255,0.04); display: flex; align-items: center; gap: 8px;"><i class="fa-solid fa-fire" style="width: 16px; color: #FF5722; font-size: 0.8rem;"></i> โปรเด็ดมือสอง</a>
             <a href="<?php echo e(route('service_center')); ?>" style="color: white; text-decoration: none; font-size: 0.82rem; font-weight: 600; padding: 8px 10px; border-radius: 8px; background: rgba(255,255,255,0.04); display: flex; align-items: center; gap: 8px;"><i class="fa-solid fa-wrench" style="width: 16px; color: #FFE600; font-size: 0.8rem;"></i> ส่งซ่อม/เคลมออนไลน์</a>
             <a href="<?php echo e(route('tracking')); ?>" style="color: white; text-decoration: none; font-size: 0.82rem; font-weight: 600; padding: 8px 10px; border-radius: 8px; background: rgba(255,255,255,0.04); display: flex; align-items: center; gap: 8px;"><i class="fa-solid fa-magnifying-glass" style="width: 16px; color: #0284C7; font-size: 0.8rem;"></i> ติดตามสถานะงานซ่อม</a>
             <a href="<?php echo e(route('categoryblog')); ?>" style="color: white; text-decoration: none; font-size: 0.82rem; font-weight: 600; padding: 8px 10px; border-radius: 8px; background: rgba(255,255,255,0.04); display: flex; align-items: center; gap: 8px;"><i class="fa-solid fa-newspaper" style="width: 16px; color: #FFE600; font-size: 0.8rem;"></i> บทความและรีวิว</a>
         </div>

         <hr style="border: 0; border-top: 1px solid rgba(255,255,255,0.06); margin: 0.25rem 0;">

         <div style="display: flex; flex-direction: column; gap: 0.6rem; font-family: 'Prompt', sans-serif;">
             <?php if(auth()->guard()->check()): ?>
                 <div style="color: white; font-weight: 600; font-size: 0.85rem; display: flex; align-items: center; gap: 8px;">👤 <?php echo e(auth()->user()->name); ?></div>
                 <a href="<?php echo e(route('dashboard')); ?>" style="color: white; text-decoration: none; background: rgba(255,255,255,0.06); padding: 8px 12px; border-radius: 6px; text-align: center; font-weight: 600; font-size: 0.8rem; border: 1px solid rgba(255,255,255,0.1); display: block;">💻 ข้อมูลส่วนตัว</a>
                 <form method="POST" action="<?php echo e(route('logout')); ?>" style="margin: 0;">
                     <?php echo csrf_field(); ?>
                     <button type="submit" style="width: 100%; background: #ef4444; color: white; border: none; padding: 8px 12px; border-radius: 6px; font-weight: 700; cursor: pointer; font-family: 'Prompt', sans-serif; font-size: 0.8rem;">🚪 ออกจากระบบ</button>
                 </form>
             <?php else: ?>
                 <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                     <a href="<?php echo e(route('login')); ?>" style="color: white; text-decoration: none; background: rgba(255,255,255,0.06); padding: 8px; border-radius: 6px; text-align: center; font-weight: 600; font-size: 0.78rem; border: 1px solid rgba(255,255,255,0.1);">เข้าสู่ระบบ</a>
                     <a href="<?php echo e(route('register')); ?>" style="color: white; text-decoration: none; background: #0284C7; padding: 8px; border-radius: 6px; text-align: center; font-weight: 600; font-size: 0.78rem;">สมัครสมาชิก</a>
                 </div>
             <?php endif; ?>
         </div>
    </div>

    <!-- Main Content -->
    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Floating LINE OA Button -->
    <a href="https://line.me/ti/p/@dditcom" target="_blank" style="position: fixed; bottom: 25px; left: 25px; z-index: 9999; display: flex; align-items: center; justify-content: center; width: 60px; height: 60px; background-color: #06c755; color: white; border-radius: 50%; box-shadow: 0 4px 15px rgba(6,199,85,0.4); text-decoration: none; transition: all 0.3s ease;" onmouseover="this.style.transform='scale(1.1)'; this.style.boxShadow='0 6px 20px rgba(6,199,85,0.6)'" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 15px rgba(6,199,85,0.4)'" title="แอดไลน์สอบถามข้อมูล">
        <i class="fa-brands fa-line" style="font-size: 2.2rem;"></i>
    </a>

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
                    <img src="<?php echo e(asset('images/logoddphone.png')); ?>" alt="DDPHONE Logo" style="height: 36px; width: auto; filter: drop-shadow(0 2px 4px rgba(255,230,0,0.3));" onerror="this.src='<?php echo e(asset('logoddphone.png')); ?>'">
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
                    <a href="https://www.facebook.com/dditcom" target="_blank" title="Facebook Page" 
                       style="width: 44px; height: 44px; background: #1877F2; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; transition: transform 0.2s; text-decoration: none; font-size: 1.25rem; box-shadow: 0 4px 12px rgba(24, 119, 242, 0.4);"
                       onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="https://line.me/ti/p/@dditcom" target="_blank" title="Line Official" 
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
                    <a href="<?php echo e(route('service_center')); ?>" style="color: #FFFFFF; text-decoration: none; font-size: 0.92rem; font-weight: 700; transition: color 0.2s;" onmouseover="this.style.color='#FFE600'" onmouseout="this.style.color='#FFFFFF'">🔧 ศูนย์ซ่อม & เคลมประกันออนไลน์</a>
                    <a href="<?php echo e(route('tracking')); ?>" style="color: #FFFFFF; text-decoration: none; font-size: 0.92rem; font-weight: 700; transition: color 0.2s;" onmouseover="this.style.color='#FFE600'" onmouseout="this.style.color='#FFFFFF'">📦 ติดตามสถานะงานซ่อม</a>
                    <a href="<?php echo e(route('help_center')); ?>" style="color: #FFFFFF; text-decoration: none; font-size: 0.92rem; font-weight: 700; transition: color 0.2s;" onmouseover="this.style.color='#FFE600'" onmouseout="this.style.color='#FFFFFF'">❓ ศูนย์ช่วยเหลือ & คำถามที่พบบ่อย (FAQ)</a>
                </div>
            </div>

            <div>
                <h3 style="font-weight: 900; font-size: 1.15rem; color: #FFE600; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-map-location-dot" style="color: #FFE600;"></i> 📍 ปักหมุดหน้าร้าน DDPHONE
                </h3>
                <div style="border-radius: 18px; overflow: hidden; border: 2px solid #FFE600; box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4); background: #1E293B; transition: transform 0.25s ease;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                    <iframe src="https://maps.google.com/maps?q=15.8078,102.0308&hl=th&z=16&output=embed" 
                            width="100%" height="145" style="border:0; display:block;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>

        <div style="border-top: 1.5px solid rgba(255, 255, 255, 0.1); margin-top: 3rem; padding-top: 1.5rem; text-align: center; color: #94A3B8; font-size: 0.85rem; font-weight: 700;">
            © <?php echo e(date('Y')); ?> DDPHONE ดีดีโฟน (บริษัท ดีดี.ไอที.คอม จำกัด) — สงวนลิขสิทธิ์ทุกประการ
        </div>
    </footer>

    <?php if (isset($component)) { $__componentOriginal2f2d6d240d8b5bb0ae740a50d4cd2158 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2f2d6d240d8b5bb0ae740a50d4cd2158 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.chat-widget','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('chat-widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2f2d6d240d8b5bb0ae740a50d4cd2158)): ?>
<?php $attributes = $__attributesOriginal2f2d6d240d8b5bb0ae740a50d4cd2158; ?>
<?php unset($__attributesOriginal2f2d6d240d8b5bb0ae740a50d4cd2158); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2f2d6d240d8b5bb0ae740a50d4cd2158)): ?>
<?php $component = $__componentOriginal2f2d6d240d8b5bb0ae740a50d4cd2158; ?>
<?php unset($__componentOriginal2f2d6d240d8b5bb0ae740a50d4cd2158); ?>
<?php endif; ?>

    <script>
        let bellAudioCtx = null;
        function getBellAudioContext() {
            if (!bellAudioCtx) {
                bellAudioCtx = new (window.AudioContext || window.webkitAudioContext)();
            }
            if (bellAudioCtx && bellAudioCtx.state === 'suspended') {
                bellAudioCtx.resume();
            }
            return bellAudioCtx;
        }

        ['click', 'touchstart', 'keydown'].forEach(evt => {
            window.addEventListener(evt, function unlockAudioOnce() {
                getBellAudioContext();
            }, { once: true });
        });

        function notificationBell() {
            return {
                open: false,
                notifications: [],
                unreadCount: 0,
                lastId: null,
                polling: null,
                initBell() {
                    this.fetchNotifications(true);
                    // Poll ทุก 5 วิ (ลดภาระ server)
                    this.polling = setInterval(() => this.fetchNotifications(false), 5000);
                    // เปิด browser notification permission
                    if ('Notification' in window && Notification.permission === 'default') {
                        Notification.requestPermission();
                    }
                },
                playBellSound() {
                    try {
                        let ctx = getBellAudioContext();
                        if (!ctx) return;
                        let playNote = (freq, start, duration) => {
                            let osc = ctx.createOscillator();
                            let gain = ctx.createGain();
                            osc.type = 'sine';
                            osc.frequency.setValueAtTime(freq, start);
                            gain.gain.setValueAtTime(0.18, start);
                            gain.gain.exponentialRampToValueAtTime(0.001, start + duration);
                            osc.connect(gain);
                            gain.connect(ctx.destination);
                            osc.start(start);
                            osc.stop(start + duration);
                        };
                        let now = ctx.currentTime;
                        playNote(523.25, now, 0.25);
                        playNote(659.25, now + 0.1, 0.25);
                        playNote(783.99, now + 0.2, 0.35);
                        playNote(1046.50, now + 0.3, 0.45);
                    } catch(e) {
                        console.log('Audio error:', e);
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
                        }).fire({
                            icon: 'info',
                            title: title,
                            text: message,
                        });
                    }
                    // Browser push notification
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
                            'Pragma': 'no-cache'
                        },
                        credentials: 'same-origin'
                    })
                    .then(res => {
                        if (!res.ok) throw new Error('HTTP ' + res.status);
                        return res.json();
                    })
                    .then(data => {
                        let newLatestId = data.latest_id;
                        let newUnread = data.unread_count || 0;
                        let newNotifs = data.notifications || [];

                        if (!isInitial) {
                            let hasNew = (newLatestId && this.lastId && newLatestId !== this.lastId)
                                      || (newUnread > this.unreadCount);
                            if (hasNew) {
                                this.playBellSound();
                                // แสดง toast สำหรับ notification ใหม่ล่าสุด
                                if (newNotifs.length > 0) {
                                    let latest = newNotifs[0];
                                    this.showToast(latest.title, latest.message);
                                }
                                // กระดิ่งสั่น
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
                    .catch(err => {
                        // ไม่ log error ซ้ำๆ เพื่อลด console noise
                    });
                },
                toggleBell() {
                    getBellAudioContext();
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
                        }).then(res => res.json())
                          .then(data => {
                              // Mark all items as read in local state
                              this.notifications = this.notifications.map(n => ({...n, is_read: true}));
                          })
                          .catch(err => console.error('Mark read error:', err));
                    }
                }
            };
        }


        document.addEventListener('DOMContentLoaded', function() {

            // AJAX add to cart
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

            // AJAX Wishlist Toggle
            document.body.addEventListener('click', function(e) {
                const btn = e.target.closest('.wishlist-toggle-btn');
                if (!btn) return;
                e.preventDefault();

                const productId = btn.dataset.productId;
                const isLoggedIn = document.body.dataset.loggedIn === 'true';

                if (!isLoggedIn) {
                    window.location.href = '<?php echo e(route("login")); ?>';
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

<?php
    $pendingOrdersCount = 0;
    $unreadMessagesCount = 0;
?>
<nav x-data="{ open: false }" class="bg-[#0F172A] border-b border-[#FFE600]/20 shadow-lg transition-all duration-300">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center mr-6">
                    <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2 hover:scale-105 transition-transform duration-200">
                        <img src="<?php echo e(asset('images/logoddphone.png')); ?>" alt="DDPHONE Logo" class="h-10 w-auto object-contain" onerror="this.src='<?php echo e(asset('logoddphone.png')); ?>'">
                        <span class="font-black text-[#FFE600] text-lg tracking-wider">DDPHONE</span>
                    </a>
                </div>

                <!-- Navigation Links / Admin Icon Bar -->
                <div class="hidden sm:flex sm:items-center">
                    <?php if(auth()->user()->role !== 'customer'): ?>
                        <?php
                            $pendingOrdersCount = \App\Models\Order::whereIn('status', ['pending_verification', 'pending'])->count();

                            $unreadMessagesCount = \App\Models\Message::whereNull('receiver_id')
                                ->where('is_read', false)
                                ->count();
                        ?>
                    <?php endif; ?>
                    <?php if(auth()->user()->role === 'customer'): ?>
                        <?php if (isset($component)) { $__componentOriginalc295f12dca9d42f28a259237a5724830 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc295f12dca9d42f28a259237a5724830 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-link','data' => ['href' => route('dashboard'),'active' => request()->routeIs('dashboard'),'class' => 'text-slate-300 hover:text-white border-transparent']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('dashboard')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('dashboard')),'class' => 'text-slate-300 hover:text-white border-transparent']); ?>
                            <?php echo e(__('Dashboard')); ?>

                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $attributes = $__attributesOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__attributesOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $component = $__componentOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__componentOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
                    <?php else: ?>
                        <div class="flex items-center gap-2 my-auto h-11">
                            <!-- Dashboard -->
                            <a href="<?php echo e(auth()->user()->role === 'super_admin' ? route('central_admin.dashboard') : route('admin.dashboard')); ?>" 
                               class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold transition-all <?php echo e(request()->routeIs('*.dashboard') ? 'bg-gradient-to-r from-indigo-600 to-blue-600 text-white shadow-md scale-105' : 'text-slate-300 hover:bg-[#2A3B5C] hover:text-white'); ?>"
                               title="แผงควบคุม">
                                <i class="fa-solid fa-gauge-high text-sm"></i>
                                <span class="hidden md:inline">แดชบอร์ด</span>
                            </a>

                            <?php if(in_array(auth()->user()->role, ['admin', 'super_admin'])): ?>
                                <!-- Dropdown 1: คลังสินค้า (Products, Categories, Brands, Stock) -->
                                <div x-data="{ open: false }" class="relative" @click.away="open = false">
                                    <button @click="open = !open" onclick="toggleAdminNavDropdown(this)"
                                            class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold transition-all <?php echo e((request()->routeIs('central_admin.products.*') || request()->routeIs('central_admin.categories.*') || request()->routeIs('central_admin.brands.*') || request()->routeIs('admin.stock.*')) ? 'bg-gradient-to-r from-violet-600 to-purple-600 text-white shadow-md' : 'text-slate-300 hover:bg-[#2A3B5C] hover:text-white'); ?>">
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
                                        
                                        <a href="<?php echo e(route('central_admin.products.create')); ?>" 
                                           class="flex items-center gap-2 px-4 py-2 text-xs font-bold text-emerald-400 hover:bg-emerald-600 hover:text-white transition-all border-b border-slate-800">
                                            <i class="fa-solid fa-circle-plus w-4"></i> + เพิ่มสินค้าใหม่
                                        </a>
                                        <a href="<?php echo e(route('central_admin.products.index')); ?>" 
                                           class="flex items-center gap-2 px-4 py-2 text-xs font-bold transition-all <?php echo e(request()->routeIs('central_admin.products.index') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white'); ?>">
                                            <i class="fa-solid fa-mobile-screen-button w-4"></i> รายการสินค้าทั้งหมด
                                        </a>
                                        <a href="<?php echo e(route('central_admin.categories.index')); ?>" 
                                           class="flex items-center gap-2 px-4 py-2 text-xs font-bold transition-all <?php echo e(request()->routeIs('central_admin.categories.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white'); ?>">
                                            <i class="fa-solid fa-folder-open w-4"></i> หมวดหมู่สินค้า
                                        </a>
                                        <a href="<?php echo e(route('central_admin.brands.index')); ?>" 
                                           class="flex items-center gap-2 px-4 py-2 text-xs font-bold transition-all <?php echo e(request()->routeIs('central_admin.brands.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white'); ?>">
                                            <i class="fa-solid fa-tags w-4"></i> แบรนด์สินค้า
                                        </a>
                                        <a href="<?php echo e(route('admin.stock.index')); ?>" 
                                           class="flex items-center gap-2 px-4 py-2 text-xs font-bold transition-all <?php echo e(request()->routeIs('admin.stock.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white'); ?>">
                                            <i class="fa-solid fa-warehouse w-4"></i> จัดการสต๊อก
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Dropdown 2: งานขาย & บริการ (Orders, Claims, Quotations) -->
                            <div x-data="{ open: false }" class="relative" @click.away="open = false">
                                <button @click="open = !open" onclick="toggleAdminNavDropdown(this)"
                                        class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold transition-all relative <?php echo e((request()->routeIs('admin.orders.*') || request()->routeIs('admin.claims.*') || request()->routeIs('admin.quotations.*')) ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md' : 'text-slate-300 hover:bg-[#2A3B5C] hover:text-white'); ?>">
                                    <i class="fa-solid fa-cart-shopping text-sm"></i>
                                    <span>ขาย & บริการ</span>
                                    <span class="nav-order-badge absolute -top-1 -right-1 bg-rose-600 text-white rounded-full text-[9px] w-4 h-4 flex items-center justify-center font-extrabold shadow-md animate-bounce" style="<?php echo e($pendingOrdersCount > 0 ? '' : 'display:none'); ?>">
                                        <?php echo e($pendingOrdersCount); ?>

                                    </span>
                                    <i class="fa-solid fa-chevron-down text-[9px] transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                                </button>
                                <div x-show="open" 
                                     x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     class="admin-nav-dropdown-menu absolute left-0 mt-2 w-48 rounded-xl bg-slate-900 border border-slate-700/80 shadow-2xl py-2 z-50"
                                     style="display: none;">
                                    
                                    <a href="<?php echo e(route('admin.orders.index')); ?>" 
                                       class="flex items-center justify-between px-4 py-2 text-xs font-bold transition-all <?php echo e(request()->routeIs('admin.orders.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white'); ?>">
                                        <span class="flex items-center gap-2"><i class="fa-solid fa-receipt w-4"></i> ออเดอร์สั่งซื้อ</span>
                                        <span class="nav-order-badge bg-rose-600 text-white text-[9px] px-1.5 py-0.5 rounded-full font-bold" style="<?php echo e($pendingOrdersCount > 0 ? '' : 'display:none'); ?>"><?php echo e($pendingOrdersCount); ?></span>
                                    </a>
                                    <a href="<?php echo e(route('admin.claims.index')); ?>" 
                                       class="flex items-center gap-2 px-4 py-2 text-xs font-bold transition-all <?php echo e(request()->routeIs('admin.claims.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white'); ?>">
                                        <i class="fa-solid fa-wrench w-4"></i> งานซ่อม/เคลม
                                    </a>
                                    
                                </div>
                            </div>

                            <?php if(in_array(auth()->user()->role, ['admin', 'super_admin'])): ?>
                                <!-- Dropdown 3: การตลาด & หน้าแรก (Coupons, Reviews, CMS) -->
                                <div x-data="{ open: false }" class="relative" @click.away="open = false">
                                    <button @click="open = !open" onclick="toggleAdminNavDropdown(this)"
                                            class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold transition-all <?php echo e((request()->routeIs('central_admin.coupons.*') || request()->routeIs('central_admin.reviews.*') || request()->routeIs('central_admin.cms.*')) ? 'bg-gradient-to-r from-amber-500 to-orange-500 text-white shadow-md' : 'text-slate-300 hover:bg-[#2A3B5C] hover:text-white'); ?>">
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
                                        
                                        <a href="<?php echo e(route('central_admin.coupons.index')); ?>" 
                                           class="flex items-center gap-2 px-4 py-2 text-xs font-bold transition-all <?php echo e(request()->routeIs('central_admin.coupons.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white'); ?>">
                                            <i class="fa-solid fa-ticket w-4"></i> คูปองส่วนลด
                                        </a>
                                        <a href="<?php echo e(route('central_admin.reviews.index')); ?>" 
                                           class="flex items-center gap-2 px-4 py-2 text-xs font-bold transition-all <?php echo e(request()->routeIs('central_admin.reviews.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white'); ?>">
                                            <i class="fa-solid fa-star w-4"></i> รีวิวของลูกค้า
                                        </a>
                                        <a href="<?php echo e(route('central_admin.articles.index')); ?>" 
                                           class="flex items-center gap-2 px-4 py-2 text-xs font-bold transition-all <?php echo e(request()->routeIs('central_admin.articles.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white'); ?>">
                                            <i class="fa-solid fa-newspaper w-4"></i> จัดการบทความ
                                        </a>
                                        <a href="<?php echo e(route('central_admin.notifications.index')); ?>" 
                                           class="flex items-center gap-2 px-4 py-2 text-xs font-bold transition-all <?php echo e(request()->routeIs('central_admin.notifications.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white'); ?>">
                                            <i class="fa-solid fa-bell w-4"></i> แจ้งเตือนลูกค้า
                                        </a>
                                        <a href="<?php echo e(route('central_admin.cms.index')); ?>" 
                                           class="flex items-center gap-2 px-4 py-2 text-xs font-bold transition-all <?php echo e(request()->routeIs('central_admin.cms.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white'); ?>">
                                            <i class="fa-solid fa-window-restore w-4"></i> จัดการหน้าแรก
                                        </a>
                                        <?php if(auth()->user()->role === 'super_admin'): ?>
                                        <a href="<?php echo e(route('central_admin.users.index')); ?>" 
                                           class="flex items-center gap-2 px-4 py-2 text-xs font-bold transition-all <?php echo e(request()->routeIs('central_admin.users.*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white'); ?>">
                                            <i class="fa-solid fa-users-gear w-4"></i> จัดการสมาชิก & สิทธิ์
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Chats -->
                            <a href="<?php echo e(route('admin.chats.index')); ?>" 
                               class="relative flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold transition-all <?php echo e(request()->routeIs('admin.chats.*') ? 'bg-gradient-to-r from-rose-600 to-pink-600 text-white shadow-md scale-105' : 'text-slate-300 hover:bg-[#2A3B5C] hover:text-white'); ?>"
                               title="แชทลูกค้า">
                                <i class="fa-solid fa-comment-dots text-sm"></i>
                                <span class="hidden md:inline">แชท</span>
                                <span class="nav-chat-badge absolute -top-1 -right-1 bg-blue-500 text-white rounded-full text-[9px] w-4 h-4 flex items-center justify-center font-extrabold shadow-md animate-pulse" style="<?php echo e($unreadMessagesCount > 0 ? '' : 'display:none'); ?>">
                                    <?php echo e($unreadMessagesCount); ?>

                                </span>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <?php if (isset($component)) { $__componentOriginaldf8083d4a852c446488d8d384bbc7cbe = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dropdown','data' => ['align' => 'right','width' => '48']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['align' => 'right','width' => '48']); ?>
                     <?php $__env->slot('trigger', null, []); ?> 
                        <button class="inline-flex items-center px-3 py-1.5 border border-[#2A3B5C] text-sm leading-4 font-medium rounded-xl text-slate-300 bg-[#121C30]/50 hover:text-white hover:border-slate-400 focus:outline-none transition ease-in-out duration-150">
                            <img src="<?php echo e(Auth::user()->avatar_url); ?>" alt="<?php echo e(Auth::user()->name); ?>" class="w-6 h-6 rounded-full object-cover mr-2 border border-slate-400">
                            <div><?php echo e(Auth::user()->name); ?></div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                     <?php $__env->endSlot(); ?>

                     <?php $__env->slot('content', null, []); ?> 
                        <?php if (isset($component)) { $__componentOriginal68cb1971a2b92c9735f83359058f7108 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal68cb1971a2b92c9735f83359058f7108 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dropdown-link','data' => ['href' => route('profile.edit')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('profile.edit'))]); ?>
                            👤 แก้ไขข้อมูลส่วนตัว
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $attributes = $__attributesOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__attributesOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $component = $__componentOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__componentOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>

                        <!-- Authentication -->
                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <?php if (isset($component)) { $__componentOriginal68cb1971a2b92c9735f83359058f7108 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal68cb1971a2b92c9735f83359058f7108 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dropdown-link','data' => ['href' => route('logout'),'onclick' => 'event.preventDefault();
                                                this.closest(\'form\').submit();']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('logout')),'onclick' => 'event.preventDefault();
                                                this.closest(\'form\').submit();']); ?>
                                🚪 ออกจากระบบ
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $attributes = $__attributesOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__attributesOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $component = $__componentOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__componentOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>
                        </form>
                     <?php $__env->endSlot(); ?>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe)): ?>
<?php $attributes = $__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe; ?>
<?php unset($__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldf8083d4a852c446488d8d384bbc7cbe)): ?>
<?php $component = $__componentOriginaldf8083d4a852c446488d8d384bbc7cbe; ?>
<?php unset($__componentOriginaldf8083d4a852c446488d8d384bbc7cbe); ?>
<?php endif; ?>
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
            <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('dashboard'),'active' => request()->routeIs('dashboard'),'class' => 'text-slate-300']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('dashboard')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('dashboard')),'class' => 'text-slate-300']); ?>
                <?php echo e(__('Dashboard')); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>

            <?php if(auth()->user()->role !== 'customer'): ?>
                <?php
                    $lastViewedOrdersAt = session('last_viewed_orders_at');
                    $ordersQuery = \App\Models\Order::where('status', 'pending_verification');
                    if ($lastViewedOrdersAt) {
                        $ordersQuery->where('created_at', '>', $lastViewedOrdersAt);
                    }
                    $pendingOrdersCount = $ordersQuery->count();

                    $unreadMessagesCount = \App\Models\Message::whereNull('receiver_id')
                        ->where('is_read', false)
                        ->count();
                ?>
                
                <?php if(in_array(auth()->user()->role, ['admin', 'super_admin'])): ?>
                    <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('central_admin.products.index'),'active' => request()->routeIs('central_admin.products.*'),'class' => 'text-slate-300']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('central_admin.products.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('central_admin.products.*')),'class' => 'text-slate-300']); ?>
                        📱 จัดการสินค้า
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('central_admin.categories.index'),'active' => request()->routeIs('central_admin.categories.*'),'class' => 'text-slate-300']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('central_admin.categories.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('central_admin.categories.*')),'class' => 'text-slate-300']); ?>
                        📁 จัดการหมวดหมู่
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('central_admin.brands.index'),'active' => request()->routeIs('central_admin.brands.*'),'class' => 'text-slate-300']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('central_admin.brands.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('central_admin.brands.*')),'class' => 'text-slate-300']); ?>
                        🏷️ จัดการแบรนด์
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('central_admin.coupons.index'),'active' => request()->routeIs('central_admin.coupons.*'),'class' => 'text-slate-300']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('central_admin.coupons.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('central_admin.coupons.*')),'class' => 'text-slate-300']); ?>
                        🎟️ จัดการคูปอง
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('central_admin.reviews.index'),'active' => request()->routeIs('central_admin.reviews.*'),'class' => 'text-slate-300']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('central_admin.reviews.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('central_admin.reviews.*')),'class' => 'text-slate-300']); ?>
                        ⭐ จัดการรีวิว
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('central_admin.articles.index'),'active' => request()->routeIs('central_admin.articles.*'),'class' => 'text-slate-300']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('central_admin.articles.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('central_admin.articles.*')),'class' => 'text-slate-300']); ?>
                        📰 จัดการบทความ
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('central_admin.cms.index'),'active' => request()->routeIs('central_admin.cms.*'),'class' => 'text-slate-300']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('central_admin.cms.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('central_admin.cms.*')),'class' => 'text-slate-300']); ?>
                        🖥️ จัดการหน้าแรก (CMS)
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
                    <?php if(auth()->user()->role === 'super_admin'): ?>
                    <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('central_admin.users.index'),'active' => request()->routeIs('central_admin.users.*'),'class' => 'text-slate-300']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('central_admin.users.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('central_admin.users.*')),'class' => 'text-slate-300']); ?>
                        👥 จัดการสมาชิก & สิทธิ์ (Super Admin)
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('admin.orders.index'),'active' => request()->routeIs('admin.orders.index'),'class' => 'text-slate-300 flex items-center justify-between']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.orders.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('admin.orders.index')),'class' => 'text-slate-300 flex items-center justify-between']); ?>
                    <span>📦 จัดการคำสั่งซื้อ</span>
                    <span class="nav-order-badge px-2.5 py-0.5 text-[11px] bg-rose-600 text-white rounded-full font-bold shadow-sm animate-bounce" style="<?php echo e($pendingOrdersCount > 0 ? '' : 'display:none'); ?>">
                        <?php echo e($pendingOrdersCount); ?>

                    </span>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>

                <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('admin.stock.index'),'active' => request()->routeIs('admin.stock.index'),'class' => 'text-slate-300']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.stock.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('admin.stock.index')),'class' => 'text-slate-300']); ?>
                    📦 จัดการสต๊อกสินค้า
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>

                <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('admin.claims.index'),'active' => request()->routeIs('admin.claims.index'),'class' => 'text-slate-300']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.claims.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('admin.claims.index')),'class' => 'text-slate-300']); ?>
                    🔧 จัดการงานซ่อม/เคลม
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
                
                <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('admin.chats.index'),'active' => request()->routeIs('admin.chats.index'),'class' => 'text-slate-300 flex items-center justify-between']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.chats.index')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('admin.chats.index')),'class' => 'text-slate-300 flex items-center justify-between']); ?>
                    <span>💬 ห้องแชทบริการลูกค้า</span>
                    <span class="nav-chat-badge px-2.5 py-0.5 text-[11px] bg-blue-600 text-white rounded-full font-bold shadow-sm" style="<?php echo e($unreadMessagesCount > 0 ? '' : 'display:none'); ?>">
                        <?php echo e($unreadMessagesCount); ?>

                    </span>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
            <?php endif; ?>
        </div>

<?php if(auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'super_admin')): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentUnreadChats = <?php echo e($unreadMessagesCount); ?>;
        let currentPendingOrders = <?php echo e($pendingOrdersCount); ?>;
        let adminAudioCtx = null;

        let isInitialPoll = true;

        function getAdminAudioContext() {
            if (!adminAudioCtx) {
                adminAudioCtx = new (window.AudioContext || window.webkitAudioContext)();
            }
            if (adminAudioCtx && adminAudioCtx.state === 'suspended') {
                adminAudioCtx.resume().catch(() => {});
            }
            return adminAudioCtx;
        }

        // Unlock audio context quietly on first user interaction without playing queued sound
        ['click', 'touchstart', 'keydown'].forEach(evt => {
            window.addEventListener(evt, function unlockAdminAudio() {
                if (!adminAudioCtx) {
                    adminAudioCtx = new (window.AudioContext || window.webkitAudioContext)();
                }
                if (adminAudioCtx.state === 'suspended') {
                    adminAudioCtx.resume().catch(() => {});
                }
            }, { once: true });
        });

        // Digital Bell Chime sound using Web Audio API
        function playAdminNotificationSound() {
            try {
                // Only play if AudioContext is active and running (prevent queued sound on tab click)
                if (!adminAudioCtx || adminAudioCtx.state !== 'running') {
                    return;
                }

                let ctx = adminAudioCtx;

                let playNote = (frequency, startTime, duration, vol = 0.22) => {
                    let osc = ctx.createOscillator();
                    let gain = ctx.createGain();

                    osc.type = 'sine';
                    osc.frequency.setValueAtTime(frequency, startTime);

                    gain.gain.setValueAtTime(vol, startTime);
                    gain.gain.exponentialRampToValueAtTime(0.001, startTime + duration);

                    osc.connect(gain);
                    gain.connect(ctx.destination);

                    osc.start(startTime);
                    osc.stop(startTime + duration);
                };

                let now = ctx.currentTime;
                // High-pitch bell chime sequence (C5 -> E5 -> G5 -> C6)
                playNote(523.25, now, 0.18, 0.25);
                playNote(659.25, now + 0.12, 0.18, 0.25);
                playNote(783.99, now + 0.24, 0.25, 0.28);
                playNote(1046.50, now + 0.38, 0.45, 0.30);
            } catch(e) {
                console.log('Audio playback failed:', e);
            }
        }

        function triggerOrderAlert(count) {
            playAdminNotificationSound();

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'warning',
                    title: '🔔 มีออเดอร์ใหม่เข้ามา!',
                    text: 'มีคำสั่งซื้อรอตรวจสอบ ' + count + ' รายการ',
                    showConfirmButton: true,
                    confirmButtonText: '📦 ดูคำสั่งซื้อ',
                    timer: 8000,
                    timerProgressBar: true,
                    customClass: {
                        popup: 'colored-toast'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "<?php echo e(route('admin.orders.index')); ?>";
                    }
                });
            }
        }

        function triggerChatAlert() {
            playAdminNotificationSound();

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'info',
                    title: '💬 มีข้อความแชทใหม่!',
                    text: 'มีลูกค้าทักแชทเข้ามาใหม่',
                    showConfirmButton: true,
                    confirmButtonText: '💬 เปิดห้องแชท',
                    timer: 6000,
                    timerProgressBar: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "<?php echo e(route('admin.chats.index')); ?>";
                    }
                });
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
                let newOrders = data.pending_orders || 0;
                let newChats = data.unread_chats || 0;

                // Trigger alerts ONLY if not the initial page load poll
                if (!isInitialPoll) {
                    if (newOrders > currentPendingOrders) {
                        triggerOrderAlert(newOrders);
                    } else if (newChats > currentUnreadChats) {
                        triggerChatAlert();
                    }
                }

                isInitialPoll = false;
                currentUnreadChats = newChats;
                currentPendingOrders = newOrders;

                // Update UI badges in navigation bar
                document.querySelectorAll('.nav-chat-badge').forEach(el => {
                    el.textContent = newChats;
                    el.style.display = newChats > 0 ? 'inline-flex' : 'none';
                });

                document.querySelectorAll('.nav-order-badge').forEach(el => {
                    el.textContent = newOrders;
                    el.style.display = newOrders > 0 ? 'inline-flex' : 'none';
                });
            })
            .catch(err => console.error('Error polling admin notifications:', err));
        }

        // Poll every 15 seconds for real-time notifications
        setInterval(pollNotifications, 15000);
        // Run once on load immediately
        pollNotifications();

        // Real-time broadcast listener
        if (typeof window.Echo !== 'undefined') {
            window.Echo.channel('admin-notifications')
                .listen('.new.order', (e) => {
                    triggerOrderAlert(e.pending_orders || '1');
                    pollNotifications();
                });
        }
    });
</script>
<?php endif; ?>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-[#2A3B5C]">
            <div class="px-4">
                <div class="font-medium text-base text-white"><?php echo e(Auth::user()->name); ?></div>
                <div class="font-medium text-sm text-slate-400"><?php echo e(Auth::user()->email); ?></div>
            </div>

            <div class="mt-3 space-y-1">
                <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('profile.edit'),'class' => 'text-slate-300']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('profile.edit')),'class' => 'text-slate-300']); ?>
                    👤 แก้ไขข้อมูลส่วนตัว
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>

                <!-- Authentication -->
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>

                    <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('logout'),'class' => 'text-slate-300','onclick' => 'event.preventDefault();
                                        this.closest(\'form\').submit();']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('logout')),'class' => 'text-slate-300','onclick' => 'event.preventDefault();
                                        this.closest(\'form\').submit();']); ?>
                        🚪 ออกจากระบบ
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
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


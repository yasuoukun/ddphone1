<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center justify-between">
            <span class="flex items-center gap-2">
                <i class="fa-solid fa-users-gear text-indigo-600"></i>
                ระบบจัดการสมาชิก & กำหนดสิทธิ์ (Super Admin)
            </span>
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50/50 min-h-screen" x-data="{ openAddModal: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-center mb-6">
                <p class="text-sm text-slate-500 font-medium">จัดการผู้ใช้งาน กำหนดสิทธิ์ Admin หรือเพิ่มบัญชีแอดมินใหม่เข้าสู่ระบบ</p>
                <button @click="openAddModal = true" class="px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-500 hover:to-blue-500 text-white font-bold rounded-xl text-sm transition shadow-md flex items-center gap-2">
                    <i class="fa-solid fa-user-plus"></i> เพิ่มแอดมิน / สมาชิกใหม่
                </button>
            </div>
            
            @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-r-lg shadow-sm flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-emerald-500 text-xl"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            @endif

            @if(session('error'))
            <div class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 text-rose-800 rounded-r-lg shadow-sm flex items-center gap-3">
                <i class="fa-solid fa-circle-exclamation text-rose-500 text-xl"></i>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
            @endif

            <x-real-time-filter table-id="usersTable" placeholder="ค้นหาชื่อ, อีเมล หรือเบอร์โทร..." count-label="สมาชิก">
                <select id="rtf-usersTable-role" class="px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 text-sm font-semibold bg-white min-w-[180px]">
                    <option value="all">👥 ทุกสิทธิ์</option>
                    <option value="customer">👤 ลูกค้า (Customer)</option>
                    <option value="admin">🛠️ แอดมินร้าน (Admin)</option>
                    <option value="super_admin">👑 Super Admin</option>
                </select>
            </x-real-time-filter>

            <!-- Users Table -->
            <div class="bg-white md:overflow-hidden shadow-sm rounded-3xl border border-gray-100 md:overflow-x-auto">
                <table id="usersTable" class="w-full text-left border-collapse block md:table">
                    <thead class="hidden md:table-header-group">
                        <tr class="border-b border-gray-100 text-slate-500 text-xs font-semibold uppercase bg-slate-50/80">
                            <th class="py-4 px-4 text-center rounded-tl-xl">ผู้ใช้</th>
                            <th class="py-4 px-4">ชื่อ-นามสกุล / อีเมล</th>
                            <th class="py-4 px-4">เบอร์โทรศัพท์</th>
                            <th class="py-4 px-4 text-center">สิทธิ์การใช้งาน (Role)</th>
                            <th class="py-4 px-4 text-center">สถานะใช้งาน</th>
                            <th class="py-4 px-4 text-center rounded-tr-xl">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="block md:table-row-group divide-y-0 md:divide-y divide-gray-50 bg-transparent md:bg-white space-y-4 md:space-y-0 p-4 md:p-0">
                        @forelse($users as $user)
                        <tr class="hover:bg-slate-50/50 transition-colors block md:table-row bg-white border border-gray-100 md:border-0 rounded-2xl md:rounded-none shadow-sm md:shadow-none p-4 md:p-0 relative"
                            x-data="{ expanded: false }"
                            data-searchable="{{ strtolower($user->name . ' ' . $user->email . ' ' . ($user->phone ?? '')) }}"
                            data-filter-role="{{ $user->role }}">
                            
                            <td class="flex justify-between items-start md:table-cell py-2 md:py-4 md:px-4 md:text-center border-b border-gray-50 md:border-0">
                                <div class="flex items-center gap-4">
                                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-12 h-12 rounded-full object-cover border-2 border-gray-100 shadow-sm shrink-0">
                                    <div class="md:hidden">
                                        <div class="font-bold text-slate-800">{{ $user->name }}</div>
                                        <div class="text-xs text-slate-400 mt-0.5">{{ $user->email }}</div>
                                    </div>
                                </div>
                                <div class="md:hidden mt-2 shrink-0 ml-2">
                                    <button @click="expanded = !expanded" class="w-8 h-8 flex items-center justify-center bg-gray-100 text-gray-600 rounded-full">
                                        <i class="fa-solid fa-chevron-down transition-transform duration-300" :class="expanded ? 'rotate-180' : ''"></i>
                                    </button>
                                </div>
                            </td>
                            
                            <td class="hidden md:table-cell py-4 px-4 border-b border-gray-50 md:border-0">
                                <div class="font-bold text-slate-800">{{ $user->name }}</div>
                                <div class="text-xs text-slate-400 mt-0.5">{{ $user->email }}</div>
                            </td>
                            
                            <td class="flex justify-between items-center md:table-cell py-3 md:py-4 md:px-4 text-sm text-slate-600 font-medium border-b border-gray-50 md:border-0" :class="expanded ? 'flex' : 'hidden md:table-cell'">
                                <div class="text-[10px] text-slate-400 font-bold uppercase md:hidden">เบอร์โทรศัพท์</div>
                                {{ $user->phone ?? '-' }}
                            </td>
                            
                            <td class="flex justify-between items-center md:table-cell py-3 md:py-4 md:px-4 text-center border-b border-gray-50 md:border-0" :class="expanded ? 'flex' : 'hidden md:table-cell'">
                                <div class="text-[10px] text-slate-400 font-bold uppercase md:hidden">สิทธิ์การใช้งาน (Role)</div>
                                <form action="{{ route('central_admin.users.update_role', $user) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role" onchange="this.form.submit()" class="text-xs font-bold px-3 py-1.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-200 outline-none {{ $user->role === 'super_admin' ? 'bg-amber-50 text-amber-800 border-amber-200' : ($user->role === 'admin' ? 'bg-indigo-50 text-indigo-800 border-indigo-200' : 'bg-slate-50 text-slate-700') }}">
                                        <option value="customer" {{ $user->role === 'customer' ? 'selected' : '' }}>👤 Customer</option>
                                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>🛠️ Admin (ร้าน)</option>
                                        <option value="super_admin" {{ $user->role === 'super_admin' ? 'selected' : '' }}>👑 Super Admin</option>
                                    </select>
                                </form>
                            </td>
                            
                            <td class="flex justify-between items-center md:table-cell py-3 md:py-4 md:px-4 text-center border-b border-gray-50 md:border-0" :class="expanded ? 'flex' : 'hidden md:table-cell'">
                                <div class="text-[10px] text-slate-400 font-bold uppercase md:hidden">สถานะใช้งาน</div>
                                @if($user->is_active ?? true)
                                    <span class="px-3 py-1 text-xs font-bold bg-emerald-100 text-emerald-800 rounded-full">🟢 ปกติ</span>
                                @else
                                    <span class="px-3 py-1 text-xs font-bold bg-rose-100 text-rose-800 rounded-full">🔴 ถูกระงับ</span>
                                @endif
                            </td>
                            
                            <td class="block md:table-cell py-3 md:py-4 md:px-4 text-center border-b border-gray-50 md:border-0" :class="expanded ? 'block' : 'hidden md:table-cell'">
                                <div class="text-[10px] text-slate-400 font-bold uppercase mb-2 md:hidden text-left">จัดการ</div>
                                <div class="flex items-center justify-start md:justify-center gap-2">
                                    <!-- Toggle active status -->
                                    <form action="{{ route('central_admin.users.toggle_status', $user) }}" method="POST" class="flex-1 md:flex-none">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-3 py-2 md:py-1 text-xs font-bold rounded-lg transition w-full md:w-auto {{ $user->is_active ? 'bg-amber-100 text-amber-800 hover:bg-amber-200' : 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' }}">
                                            {{ $user->is_active ? '🔒 ระงับ' : '🔓 ปลดระงับ' }}
                                        </button>
                                    </form>

                                    <!-- Delete user -->
                                    @if($user->id !== auth()->id())
                                    <form action="{{ route('central_admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('ยืนยันลบบัญชีผู้ใช้ {{ $user->name }} ?')" class="flex-1 md:flex-none">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full md:w-auto px-3 py-2 md:py-1.5 md:p-1.5 text-rose-600 hover:bg-rose-50 rounded-lg transition flex justify-center items-center gap-1.5 bg-rose-50 md:bg-transparent" title="ลบบัญชี">
                                            <i class="fa-solid fa-trash-can text-sm"></i> <span class="md:hidden text-xs font-bold">ลบ</span>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr class="block md:table-row">
                            <td colspan="6" class="block md:table-cell py-12 text-center text-slate-400">
                                ไม่พบข้อมูลสมาชิกในระบบ
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

                <div class="p-4 border-t border-gray-100">
                    {{ $users->links() }}
                </div>
            </div>

        </div>

        <!-- Add User/Admin Modal -->
        <div x-show="openAddModal" x-transition style="display: none;" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
            <div @click.away="openAddModal = false" class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-gray-100 relative">
                <button @click="openAddModal = false" class="absolute top-5 right-5 text-gray-400 hover:text-gray-600 font-bold text-xl">
                    &times;
                </button>
                <h3 class="text-lg font-bold text-slate-800 mb-1 flex items-center gap-2">
                    <i class="fa-solid fa-user-plus text-indigo-600"></i> เพิ่มแอดมิน / สมาชิกใหม่
                </h3>
                <p class="text-xs text-slate-400 mb-6">กรอกข้อมูลผู้ใช้งานและเลือกกำหนดสิทธิ์เข้าถึงระบบ</p>

                <form action="{{ route('central_admin.users.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">ชื่อ-นามสกุล</label>
                        <input type="text" name="name" required placeholder="สมชาย ใจดี" class="w-full rounded-xl border-gray-200 text-sm focus:ring-2 focus:ring-indigo-200">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">อีเมล (Email)</label>
                        <input type="email" name="email" required placeholder="admin@example.com" class="w-full rounded-xl border-gray-200 text-sm focus:ring-2 focus:ring-indigo-200">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">เบอร์โทรศัพท์ (ถ้ามี)</label>
                        <input type="text" name="phone" placeholder="0812345678" class="w-full rounded-xl border-gray-200 text-sm focus:ring-2 focus:ring-indigo-200">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">สิทธิ์การใช้งาน (Role)</label>
                        <select name="role" required class="w-full rounded-xl border-gray-200 text-sm font-semibold focus:ring-2 focus:ring-indigo-200">
                            <option value="admin">🛠️ แอดมินร้าน (Admin)</option>
                            <option value="super_admin">👑 แอดมินกลาง (Super Admin)</option>
                            <option value="customer">👤 ลูกค้าทั่วไป (Customer)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">รหัสผ่าน (อย่างน้อย 8 ตัวอักษร)</label>
                        <input type="password" name="password" required placeholder="••••••••" class="w-full rounded-xl border-gray-200 text-sm focus:ring-2 focus:ring-indigo-200">
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                        <button type="button" @click="openAddModal = false" class="px-5 py-2.5 rounded-xl bg-slate-100 text-slate-600 font-bold text-xs hover:bg-slate-200">
                            ยกเลิก
                        </button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white font-bold text-xs hover:bg-indigo-700 shadow-md">
                            บันทึกบัญชีใหม่
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

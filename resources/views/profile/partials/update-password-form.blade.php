<section>
    <header class="border-b border-slate-100 pb-4 mb-6">
        <h2 class="text-lg font-black text-slate-800 flex items-center gap-2">
            <span class="text-amber-500">🔐</span> เปลี่ยนรหัสผ่านเข้าสู่ระบบ
        </h2>

        <p class="mt-1 text-xs text-slate-500 font-medium">
            เพื่อความปลอดภัยของบัญชี โปรดเลือกใช้รหัสผ่านที่รัดกุมและคาดเดายาก
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('รหัสผ่านปัจจุบัน')" class="font-extrabold text-slate-800 text-xs" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1.5 block w-full rounded-2xl border-slate-200 focus:border-sky-500 focus:ring-sky-500 text-sm font-medium" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1.5" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('รหัสผ่านใหม่')" class="font-extrabold text-slate-800 text-xs" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1.5 block w-full rounded-2xl border-slate-200 focus:border-sky-500 focus:ring-sky-500 text-sm font-medium" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1.5" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('ยืนยันรหัสผ่านใหม่')" class="font-extrabold text-slate-800 text-xs" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1.5 block w-full rounded-2xl border-slate-200 focus:border-sky-500 focus:ring-sky-500 text-sm font-medium" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1.5" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="px-6 py-2.5 bg-sky-600 hover:bg-sky-700 text-white font-black text-xs rounded-2xl transition duration-200 shadow-md flex items-center gap-2">
                <span>🔒 บันทึกรหัสผ่านใหม่</span>
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2500)"
                    class="text-xs font-bold text-emerald-600 flex items-center gap-1"
                >✓ เปลี่ยนรหัสผ่านเรียบร้อยแล้ว</p>
            @endif
        </div>
    </form>
</section>

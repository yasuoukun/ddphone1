<x-guest-layout>
    <div style="text-align: center; margin-bottom: 1.5rem;">
        <h2 style="font-size: 1.6rem; font-weight: 800; color: #121C30; margin: 0 0 4px; font-family: 'Prompt', sans-serif;">
            เข้าสู่ระบบ
        </h2>
        <p style="font-size: 0.85rem; color: #64748B; margin: 0; font-weight: 600;">DDPHONE ดีดีโฟน (ศูนย์รวมสมาร์ทโฟนมือสองคัดเกรด A+)</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4 text-emerald-800 bg-emerald-50 p-3 rounded-xl border border-emerald-200 text-xs font-medium" :status="session('status')" />

    @if(session('error'))
        <div style="margin-bottom: 1rem; padding: 0.75rem 1rem; background: #FEF2F2; border: 1px solid #FCA5A5; border-radius: 12px; color: #991B1B; font-size: 0.82rem; font-weight: 600; display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-circle-exclamation text-rose-500"></i> {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" style="display: flex; flex-direction: column; gap: 1rem;">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" style="display: block; font-size: 0.85rem; font-weight: 700; color: #1E293B; margin-bottom: 6px; text-align: left;">
                อีเมล
            </label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                   placeholder="กรอกอีเมลของคุณ"
                   class="auth-input-field">
            <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-xs text-rose-600 font-semibold" />
        </div>

        <!-- Password -->
        <div x-data="{ showPass: false }">
            <label for="password" style="display: block; font-size: 0.85rem; font-weight: 700; color: #1E293B; margin-bottom: 6px; text-align: left;">
                รหัสผ่าน
            </label>
            <div style="position: relative;">
                <input id="password" :type="showPass ? 'text' : 'password'" name="password" required autocomplete="current-password" 
                       placeholder="กรอกรหัสผ่าน"
                       class="auth-input-field" style="padding-right: 42px;">
                <button type="button" @click="showPass = !showPass" style="position: absolute; right: 14px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #94A3B8; cursor: pointer; font-size: 0.9rem;">
                    <i :class="showPass ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs text-rose-600 font-semibold" />
        </div>

        <!-- Remember Me & Forgot Password Row -->
        <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 4px;">
            <label for="remember_me" style="display: inline-flex; align-items: center; cursor: pointer; font-size: 0.82rem; color: #475569; font-weight: 600;">
                <input id="remember_me" type="checkbox" name="remember" style="accent-color: #1B2A47; width: 16px; height: 16px; margin-right: 6px;">
                <span>จดจำฉัน</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" style="font-size: 0.82rem; color: #2563EB; font-weight: 700; text-decoration: none;">
                    ลืมรหัสผ่าน?
                </a>
            @endif
        </div>

        <!-- Submit Button -->
            <button type="submit" class="btn-capsule-yellow" style="width: 100%; justify-content: center; font-size: 0.95rem !important;">
                เข้าสู่ระบบ <span class="circle-icon"><i class="fa-solid fa-right-to-bracket"></i></span>
            </button>
    </form>

    <!-- Divider & Secondary Action -->
    <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px dashed #CBD5E1; text-align: center; position: relative;">
        <span style="position: absolute; top: -10px; left: 50%; transform: translateX(-50%); background: #FFFFFF; padding: 0 12px; font-size: 0.78rem; color: #94A3B8; font-weight: 600;">หรือ</span>
        
        <p style="font-size: 0.82rem; color: #64748B; font-weight: 600; margin: 4px 0 12px;">
            ยังไม่มีบัญชีสมาชิก?
        </p>

        <a href="{{ route('register') }}" class="btn-secondary-gold">
            <i class="fa-solid fa-user-plus" style="font-size: 0.85rem;"></i> สมัครสมาชิกใหม่
        </a>
    </div>
</x-guest-layout>

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
        <button type="submit" class="btn-primary-navy">
            <i class="fa-solid fa-right-to-bracket" style="font-size: 0.95rem; color: #FFE600;"></i> เข้าสู่ระบบ
        </button>
    </form>

    <!-- Social Login Section -->
    <div style="margin-top: 1.25rem; text-align: center;">
        <div style="position: relative; margin-bottom: 1.15rem;">
            <hr style="border: 0; border-top: 1px dashed #CBD5E1; margin: 0;">
            <span style="position: absolute; top: -10px; left: 50%; transform: translateX(-50%); background: #FFFFFF; padding: 0 12px; font-size: 0.78rem; color: #64748B; font-weight: 700;">หรือเข้าสู่ระบบด้วย</span>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
            <a href="{{ route('social.redirect', 'google') }}" 
               style="display: flex; align-items: center; justify-content: center; gap: 8px; padding: 11px 14px; background: #FFFFFF; border: 1.5px solid #CBD5E1; border-radius: 14px; text-decoration: none; color: #1E293B; font-size: 0.85rem; font-weight: 800; box-shadow: 0 2px 8px rgba(0,0,0,0.04); transition: all 0.2s ease;"
               onmouseover="this.style.borderColor='#4285F4'; this.style.transform='translateY(-1px)'"
               onmouseout="this.style.borderColor='#CBD5E1'; this.style.transform='none'">
                <svg width="18" height="18" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                </svg>
                <span>Google</span>
            </a>

            <a href="{{ route('social.redirect', 'facebook') }}" 
               style="display: flex; align-items: center; justify-content: center; gap: 8px; padding: 11px 14px; background: #1877F2; border: 1.5px solid #1877F2; border-radius: 14px; text-decoration: none; color: #FFFFFF; font-size: 0.85rem; font-weight: 800; box-shadow: 0 2px 8px rgba(24,119,242,0.25); transition: all 0.2s ease;"
               onmouseover="this.style.opacity='0.92'; this.style.transform='translateY(-1px)'"
               onmouseout="this.style.opacity='1'; this.style.transform='none'">
                <i class="fa-brands fa-facebook-f" style="font-size: 0.95rem; color: #FFFFFF;"></i>
                <span>Facebook</span>
            </a>
        </div>
    </div>

    <!-- Divider & Secondary Action -->
    <div style="margin-top: 1.25rem; padding-top: 1.15rem; border-top: 1px dashed #CBD5E1; text-align: center; position: relative;">
        <span style="position: absolute; top: -10px; left: 50%; transform: translateX(-50%); background: #FFFFFF; padding: 0 12px; font-size: 0.78rem; color: #94A3B8; font-weight: 600;">หรือ</span>
        
        <p style="font-size: 0.82rem; color: #64748B; font-weight: 600; margin: 4px 0 12px;">
            ยังไม่มีบัญชีสมาชิก?
        </p>

        <a href="{{ route('register') }}" class="btn-secondary-gold">
            <i class="fa-solid fa-user-plus" style="font-size: 0.85rem;"></i> สมัครสมาชิกใหม่
        </a>
    </div>
</x-guest-layout>

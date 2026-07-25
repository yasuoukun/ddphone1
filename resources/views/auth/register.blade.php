<x-guest-layout>
    <div style="text-align: center; margin-bottom: 1.5rem;">
        <h2 style="font-size: 1.6rem; font-weight: 800; color: #121C30; margin: 0 0 4px; font-family: 'Prompt', sans-serif;">
            สมัครสมาชิกใหม่
        </h2>
        <p style="font-size: 0.85rem; color: #64748B; margin: 0; font-weight: 600;">DDPHONE ดีดีโฟน (ศูนย์รวมสมาร์ทโฟนมือสองคัดเกรด A+)</p>
    </div>

    <form method="POST" action="{{ route('register') }}" style="display: flex; flex-direction: column; gap: 1rem;">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" style="display: block; font-size: 0.85rem; font-weight: 700; color: #1E293B; margin-bottom: 6px; text-align: left;">
                ชื่อ-นามสกุล
            </label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                   placeholder="กรอกชื่อ-นามสกุลของคุณ"
                   class="auth-input-field">
            <x-input-error :messages="$errors->get('name')" class="mt-1.5 text-xs text-rose-600 font-semibold" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" style="display: block; font-size: 0.85rem; font-weight: 700; color: #1E293B; margin-bottom: 6px; text-align: left;">
                อีเมล
            </label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
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
                <input id="password" :type="showPass ? 'text' : 'password'" name="password" required autocomplete="new-password"
                       placeholder="ตั้งรหัสผ่านอย่างน้อย 8 ตัวอักษร"
                       class="auth-input-field" style="padding-right: 42px;">
                <button type="button" @click="showPass = !showPass" style="position: absolute; right: 14px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #94A3B8; cursor: pointer; font-size: 0.9rem;">
                    <i :class="showPass ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs text-rose-600 font-semibold" />
        </div>

        <!-- Confirm Password -->
        <div x-data="{ showPassConf: false }">
            <label for="password_confirmation" style="display: block; font-size: 0.85rem; font-weight: 700; color: #1E293B; margin-bottom: 6px; text-align: left;">
                ยืนยันรหัสผ่าน
            </label>
            <div style="position: relative;">
                <input id="password_confirmation" :type="showPassConf ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password"
                       placeholder="กรอกรหัสผ่านซ้ำอีกครั้ง"
                       class="auth-input-field" style="padding-right: 42px;">
                <button type="button" @click="showPassConf = !showPassConf" style="position: absolute; right: 14px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #94A3B8; cursor: pointer; font-size: 0.9rem;">
                    <i :class="showPassConf ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5 text-xs text-rose-600 font-semibold" />
        </div>

        <!-- Submit Button -->
        <div style="padding-top: 6px;">
            <button type="submit" class="btn-secondary-gold">
                <i class="fa-solid fa-user-plus" style="font-size: 0.85rem;"></i> สมัครสมาชิกใหม่
            </button>
        </div>
    </form>

    <!-- Divider & Secondary Action -->
    <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px dashed #CBD5E1; text-align: center; position: relative;">
        <span style="position: absolute; top: -10px; left: 50%; transform: translateX(-50%); background: #FFFFFF; padding: 0 12px; font-size: 0.78rem; color: #94A3B8; font-weight: 600;">หรือ</span>
        
        <p style="font-size: 0.82rem; color: #64748B; font-weight: 600; margin: 4px 0 12px;">
            เป็นสมาชิกอยู่แล้ว?
        </p>

        <a href="{{ route('login') }}" class="btn-primary-navy">
            เข้าสู่ระบบ
        </a>
    </div>
</x-guest-layout>

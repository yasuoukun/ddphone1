<x-guest-layout>
    <div style="text-align: center; margin-bottom: 1.5rem;">
        <h2 style="font-size: 1.6rem; font-weight: 800; color: #121C30; margin: 0 0 4px; font-family: 'Prompt', sans-serif;">
            ลืมรหัสผ่าน
        </h2>
        <p style="font-size: 0.85rem; color: #64748B; margin: 0; font-weight: 600;">DDPHONE ดีดีโฟน (ศูนย์รวมสมาร์ทโฟนมือสองคัดเกรด A+)</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4 text-emerald-800 bg-emerald-50 p-3 rounded-xl border border-emerald-200 text-xs font-medium" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" style="display: flex; flex-direction: column; gap: 1rem;">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" style="display: block; font-size: 0.85rem; font-weight: 700; color: #1E293B; margin-bottom: 6px; text-align: left;">
                อีเมล
            </label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                   placeholder="กรอกอีเมลของคุณ"
                   class="auth-input-field">
            <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-xs text-rose-600 font-semibold" />
        </div>

        <!-- Submit Button -->
        <div style="padding-top: 6px;">
            <button type="submit" class="btn-primary-navy">
                <i class="fa-solid fa-paper-plane" style="font-size: 0.85rem;"></i> ส่งลิงก์รีเซ็ตรหัสผ่าน
            </button>
        </div>
    </form>

    <!-- Divider & Secondary Action -->
    <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px dashed #CBD5E1; text-align: center; position: relative;">
        <span style="position: absolute; top: -10px; left: 50%; transform: translateX(-50%); background: #FFFFFF; padding: 0 12px; font-size: 0.78rem; color: #94A3B8; font-weight: 600;">หรือ</span>
        
        <p style="font-size: 0.82rem; color: #64748B; font-weight: 600; margin: 4px 0 12px;">
            จำรหัสผ่านได้แล้ว?
        </p>

        <a href="{{ route('login') }}" class="btn-secondary-gold">
            กลับหน้าเข้าสู่ระบบ
        </a>
    </div>
</x-guest-layout>

<section>
    <header class="border-b border-slate-100 pb-4 mb-6">
        <h2 class="text-lg font-black text-slate-800 flex items-center gap-2">
            <span class="text-sky-600">📌</span> ข้อมูลโปรไฟล์ส่วนตัว
        </h2>

        <p class="mt-1 text-xs text-slate-500 font-medium">
            อัปเดตข้อมูลบัญชี รูปภาพโปรไฟล์ ชื่อ-นามสกุล อีเมล และเบอร์โทรศัพท์ติดต่อของท่าน
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Profile Avatar Upload -->
        <div class="flex items-center gap-5 p-4 bg-slate-50/80 rounded-2xl border border-slate-100">
            <img id="avatar-preview" src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-16 h-16 rounded-2xl object-cover border-2 border-slate-800 shadow-md flex-shrink-0">
            <div>
                <x-input-label for="avatar" :value="__('เปลี่ยนรูปภาพโปรไฟล์')" class="font-extrabold text-slate-800 text-xs" />
                <input type="file" id="avatar" name="avatar" accept="image/*" class="mt-1.5 text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-extrabold file:bg-slate-900 file:text-amber-400 hover:file:bg-slate-800 cursor-pointer" onchange="if(this.files[0]) document.getElementById('avatar-preview').src = URL.createObjectURL(this.files[0])" />
                <x-input-error class="mt-1" :messages="$errors->get('avatar')" />
                <p class="text-[11px] text-slate-400 mt-1 font-medium">แนะนำเป็นรูปภาพสี่เหลี่ยมจัตุรัส ขนาดไม่เกิน 4MB (JPG, PNG, WEBP)</p>
            </div>
        </div>

        <div>
            <x-input-label for="name" :value="__('ชื่อ-นามสกุล')" class="font-extrabold text-slate-800 text-xs" />
            <x-text-input id="name" name="name" type="text" class="mt-1.5 block w-full rounded-2xl border-slate-200 focus:border-sky-500 focus:ring-sky-500 text-sm font-medium" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-1.5" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('อีเมลเข้าสู่ระบบ')" class="font-extrabold text-slate-800 text-xs" />
            <x-text-input id="email" name="email" type="email" class="mt-1.5 block w-full rounded-2xl border-slate-200 focus:border-sky-500 focus:ring-sky-500 text-sm font-medium" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-1.5" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-xs mt-2 text-slate-700">
                        {{ __('อีเมลของท่านยังไม่ได้ทำการยืนยัน') }}

                        <button form="send-verification" class="underline text-xs text-sky-600 font-bold hover:text-sky-800">
                            {{ __('คลิกที่นี่เพื่อส่งอีเมลยืนยันอีกครั้ง') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-bold text-xs text-emerald-600">
                            {{ __('ส่งลิงก์ยืนยันไปยังอีเมลของท่านเรียบร้อยแล้ว') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="phone" :value="__('เบอร์โทรศัพท์ติดต่อ')" class="font-extrabold text-slate-800 text-xs" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1.5 block w-full rounded-2xl border-slate-200 focus:border-sky-500 focus:ring-sky-500 text-sm font-medium" :value="old('phone', $user->phone)" placeholder="0812345678" />
            <x-input-error class="mt-1.5" :messages="$errors->get('phone')" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-amber-400 font-black text-xs rounded-2xl transition duration-200 shadow-md flex items-center gap-2">
                <span>💾 บันทึกข้อมูลส่วนตัว</span>
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2500)"
                    class="text-xs font-bold text-emerald-600 flex items-center gap-1"
                >✓ บันทึกข้อมูลเรียบร้อยแล้ว</p>
            @endif
        </div>
    </form>
</section>

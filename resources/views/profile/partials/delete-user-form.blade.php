<section class="space-y-6">
    <header class="border-b border-red-100 pb-4">
        <h2 class="text-lg font-black text-red-700 flex items-center gap-2">
            <span>⚠️</span> ลบบัญชีผู้ใช้ถาวร
        </h2>

        <p class="mt-1 text-xs text-slate-500 font-medium">
            เมื่อลบบัญชี ข้อมูลและทรัพยากรทั้งหมดจะถูกลบออกจากระบบอย่างถาวร ไม่สามารถกู้คืนกลับมาได้
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="rounded-2xl font-black text-xs px-5 py-2.5 shadow-sm"
    >🗑️ ลบบัญชีผู้ใช้ถาวร</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-black text-slate-800">
                คุณแน่ใจหรือไม่ว่าต้องการลบบัญชีผู้ใช้นี้ถาวร?
            </h2>

            <p class="mt-2 text-xs text-slate-500 font-medium leading-relaxed">
                เมื่อบัญชีผู้ใช้ถูกลบ ข้อมูลและประวัติทั้งหมดจะถูกลบออกจากระบบอย่างถาวร โปรดป้อนรหัสผ่านของท่านเพื่อยืนยันการลบบัญชีถาวร
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('รหัสผ่านเพื่อยืนยัน') }}" class="font-extrabold text-slate-800 text-xs" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1.5 block w-full sm:w-3/4 rounded-2xl border-slate-200 focus:border-red-500 focus:ring-red-500 text-sm font-medium"
                    placeholder="ป้อนรหัสผ่านของท่าน..."
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-1.5" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')" class="rounded-2xl font-bold text-xs px-4 py-2">
                    ยกเลิก
                </x-secondary-button>

                <x-danger-button class="rounded-2xl font-black text-xs px-5 py-2">
                    ยืนยันลบบัญชีถาวร
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>

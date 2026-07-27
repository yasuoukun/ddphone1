<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-xl text-slate-800 leading-tight flex items-center gap-2">
            <span class="p-2 bg-slate-900 text-amber-400 rounded-xl text-base shadow-sm">👤</span>
            {{ __('แก้ไขข้อมูลส่วนตัวและตั้งค่าความปลอดภัย') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-slate-50/60 min-h-[calc(100vh-160px)]">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Card 1: Profile Information -->
            <div class="p-6 sm:p-8 bg-white rounded-3xl shadow-sm border border-slate-100 transition duration-200 hover:shadow-md">
                <div class="max-w-2xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Card 2: Password Update -->
            <div class="p-6 sm:p-8 bg-white rounded-3xl shadow-sm border border-slate-100 transition duration-200 hover:shadow-md">
                <div class="max-w-2xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Card 3: Delete Account -->
            <div class="p-6 sm:p-8 bg-red-50/40 rounded-3xl shadow-sm border border-red-100 transition duration-200 hover:shadow-md">
                <div class="max-w-2xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

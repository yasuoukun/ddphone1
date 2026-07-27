<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('จัดการการแจ้งเตือน') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50/50 min-h-screen fade-in">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="bg-emerald-50 text-emerald-700 p-4 rounded-xl border border-emerald-100 flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-xl"></i>
                    <div>
                        <h4 class="font-bold">สำเร็จ!</h4>
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-rose-50 text-rose-700 p-4 rounded-xl border border-rose-100 flex items-center gap-3">
                    <i class="fa-solid fa-circle-xmark text-xl"></i>
                    <p class="text-sm font-semibold">{{ session('error') }}</p>
                </div>
            @endif

            {{-- Send Form --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="font-bold text-lg text-gray-800 flex items-center gap-2">
                        <i class="fa-solid fa-paper-plane text-indigo-500"></i> ส่งแจ้งเตือนใหม่
                    </h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('central_admin.notifications.send') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-5">
                            <label class="block text-sm font-bold text-gray-700 mb-2">หัวข้อแจ้งเตือน <span class="text-rose-500">*</span></label>
                            <input type="text" name="title" required placeholder="เช่น โปรโมชันลดกระหน่ำ 50%!" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            @error('title') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-5">
                            <label class="block text-sm font-bold text-gray-700 mb-2">รายละเอียด <span class="text-rose-500">*</span></label>
                            <textarea name="message" rows="3" required placeholder="ใส่รายละเอียดโปรโมชัน..." class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"></textarea>
                            @error('message') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-5">
                            <label class="block text-sm font-bold text-gray-700 mb-2">ลิงก์แนบ (URL)</label>
                            <input type="url" name="url" placeholder="https://..." class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            @error('url') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">แนบรูปภาพ</label>
                            <input type="file" name="image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
                            @error('image') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="px-6 py-2.5 bg-indigo-600 rounded-lg text-sm font-semibold text-white hover:bg-indigo-700 transition-colors shadow flex items-center gap-2">
                                <i class="fa-solid fa-paper-plane"></i> ส่งแจ้งเตือนให้ลูกค้าทุกคน
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Notification History --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
                <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-bold text-lg text-gray-800 flex items-center gap-2">
                        <i class="fa-solid fa-clock-rotate-left text-amber-500"></i> ประวัติการแจ้งเตือนที่ส่งแล้ว
                    </h3>
                    <span class="text-sm text-gray-400">{{ $notifications->total() }} รายการ</span>
                </div>

                @if($notifications->count() === 0)
                    <div class="p-12 text-center text-gray-400">
                        <i class="fa-regular fa-bell-slash text-4xl mb-3"></i>
                        <p class="font-semibold">ยังไม่มีประวัติการส่งแจ้งเตือน</p>
                    </div>
                @else
                    <div class="divide-y divide-gray-100">
                        @foreach($notifications as $notif)
                            @php
                                $data = is_array($notif->data)
                                    ? $notif->data
                                    : (json_decode($notif->data, true) ?? []);
                                $rawData = is_string($notif->data) ? $notif->data : json_encode($notif->data);
                            @endphp
                            <div class="p-5 flex items-start gap-4 hover:bg-gray-50 transition-colors">
                                {{-- Icon --}}
                                <div class="flex-shrink-0 w-11 h-11 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center">
                                    <i class="fa-solid fa-bullhorn"></i>
                                </div>

                                {{-- Content --}}
                                <div class="flex-1 min-w-0">
                                    <p class="font-bold text-gray-800 text-sm">{{ $data['title'] ?? '-' }}</p>
                                    <p class="text-gray-500 text-xs mt-0.5 line-clamp-2">{{ $data['message'] ?? '' }}</p>
                                    @if(!empty($data['url']))
                                        <a href="{{ $data['url'] }}" target="_blank" class="text-indigo-500 text-xs underline mt-0.5 inline-block truncate max-w-xs">{{ $data['url'] }}</a>
                                    @endif
                                    <div class="flex items-center gap-3 mt-1.5">
                                        <span class="text-xs text-gray-400">
                                            <i class="fa-regular fa-clock mr-1"></i>
                                            {{ \Carbon\Carbon::parse($notif->created_at)->locale('th')->diffForHumans() }}
                                        </span>
                                        <span class="text-xs bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded-full font-semibold">
                                            <i class="fa-solid fa-users mr-1"></i>{{ $notif->recipient_count }} คน
                                        </span>
                                    </div>
                                </div>

                                {{-- Delete Button --}}
                                <form action="{{ route('central_admin.notifications.destroy') }}" method="POST"
                                      onsubmit="return confirm('ยืนยันลบแจ้งเตือนนี้ออกจากระบบ? ลูกค้าจะไม่เห็นแจ้งเตือนนี้อีกต่อไป')">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="title" value="{{ $data['title'] ?? '' }}">
                                    <input type="hidden" name="message" value="{{ $data['message'] ?? '' }}">
                                    <input type="hidden" name="data" value="{{ base64_encode($rawData) }}">
                                    <button type="submit"
                                            class="flex-shrink-0 p-2 text-rose-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors"
                                            title="ลบแจ้งเตือนนี้">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    @if($notifications->hasPages())
                        <div class="p-4 border-t border-gray-100">
                            {{ $notifications->links() }}
                        </div>
                    @endif
                @endif
            </div>

        </div>
    </div>
</x-app-layout>

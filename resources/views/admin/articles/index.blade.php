<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center justify-between">
            <span class="flex items-center gap-2">
                <i class="fa-solid fa-newspaper text-indigo-600"></i>
                {{ __('จัดการบทความ / ข่าวสาร') }}
            </span>
            <a href="{{ route('central_admin.articles.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg text-sm transition-colors">
                <i class="fa-solid fa-plus mr-1"></i> เพิ่มบทความใหม่
            </a>
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50/50 min-h-screen fade-in">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-r-lg shadow-sm flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-emerald-500 text-xl"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            @endif

            <x-real-time-filter table-id="articlesTable" placeholder="ค้นหาชื่อบทความ หรือชื่อผู้เขียน..." count-label="บทความ">
                <select id="rtf-articlesTable-published" class="px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 text-sm font-semibold bg-white min-w-[160px]">
                    <option value="all">📰 ทุกสถานะ</option>
                    <option value="1">✅ เผยแพร่แล้ว</option>
                    <option value="0">📝 ฉบับร่าง</option>
                </select>
            </x-real-time-filter>

            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
                <div class="overflow-x-auto">
                    @if($articles->count() > 0)
                    <table id="articlesTable" class="w-full text-left border-collapse">
                        <thead class="bg-slate-50/80">
                            <tr class="border-b border-gray-100 text-slate-500 text-xs font-semibold uppercase">
                                <th class="py-4 px-6 rounded-tl-xl">บทความ</th>
                                <th class="py-4 px-6 text-center">สถานะ</th>
                                <th class="py-4 px-6">ผู้เขียน</th>
                                <th class="py-4 px-6 text-right rounded-tr-xl">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($articles as $article)
                            <tr class="hover:bg-slate-50/50 transition-colors"
                                data-searchable="{{ strtolower($article->title . ' ' . $article->author_name) }}"
                                data-filter-published="{{ $article->is_published ? '1' : '0' }}">
                                <td class="py-4 px-6">
                                <div class="flex items-center gap-4">
                                    <div class="flex-shrink-0 h-14 w-14 bg-gray-100 rounded-xl overflow-hidden flex items-center justify-center">
                                        @if($article->images && count($article->images) > 0)
                                            <img class="h-14 w-14 object-cover" src="{{ Storage::url($article->images[0]) }}" alt="">
                                        @else
                                            <i class="fa-solid fa-image text-gray-400 text-xl"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-gray-900">{{ Str::limit($article->title, 60) }}</div>
                                        <div class="text-xs text-gray-500 mt-1">{{ $article->created_at->format('d/m/Y') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if($article->is_published)
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800">✅ เผยแพร่</span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">📝 ฉบับร่าง</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-sm text-slate-600 font-medium">{{ $article->author_name }}</td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('central_admin.articles.edit', $article) }}" class="p-2 text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition" title="แก้ไข">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('central_admin.articles.destroy', $article) }}" method="POST" class="inline-block" onsubmit="return confirm('ยืนยันลบบทความนี้?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 text-rose-600 bg-rose-50 hover:bg-rose-100 rounded-lg transition" title="ลบ">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="py-16 text-center text-slate-400">
                        <i class="fa-solid fa-newspaper text-4xl mb-3 block text-slate-300"></i>
                        <p class="font-medium">ยังไม่มีบทความในระบบ</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

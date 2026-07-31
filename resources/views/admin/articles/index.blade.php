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

            <div class="bg-white md:overflow-hidden shadow-sm rounded-2xl border border-gray-100 md:overflow-x-auto">
                <table id="articlesTable" class="w-full text-left border-collapse block md:table">
                    <thead class="bg-slate-50/80 hidden md:table-header-group">
                        <tr class="border-b border-gray-100 text-slate-500 text-xs font-semibold uppercase">
                            <th class="py-4 px-6 rounded-tl-xl">บทความ</th>
                            <th class="py-4 px-6 text-center">สถานะ</th>
                            <th class="py-4 px-6">ผู้เขียน</th>
                            <th class="py-4 px-6 text-right rounded-tr-xl">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="block md:table-row-group divide-y-0 md:divide-y divide-gray-100 bg-transparent md:bg-white space-y-4 md:space-y-0 p-4 md:p-0">
                        @forelse($articles as $article)
                        <tr class="hover:bg-slate-50/50 transition-colors block md:table-row bg-white border border-gray-100 md:border-0 rounded-2xl md:rounded-none shadow-sm md:shadow-none p-4 md:p-0 relative"
                            x-data="{ expanded: false }"
                            data-searchable="{{ strtolower($article->title . ' ' . $article->author_name) }}"
                            data-filter-published="{{ $article->is_published ? '1' : '0' }}">
                            
                            <td class="flex justify-between items-start md:table-cell py-2 md:py-4 md:px-6 border-b border-gray-50 md:border-0">
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
                                <div class="md:hidden mt-2 shrink-0 ml-2">
                                    <button @click="expanded = !expanded" class="w-8 h-8 flex items-center justify-center bg-gray-100 text-gray-600 rounded-full">
                                        <i class="fa-solid fa-chevron-down transition-transform duration-300" :class="expanded ? 'rotate-180' : ''"></i>
                                    </button>
                                </div>
                            </td>
                            
                            <td class="flex justify-between items-center md:table-cell py-3 md:py-4 md:px-6 text-center border-b border-gray-50 md:border-0" :class="expanded ? 'flex' : 'hidden md:table-cell'">
                                <div class="text-[10px] text-slate-400 font-bold uppercase md:hidden">สถานะ</div>
                                @if($article->is_published)
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800">✅ เผยแพร่</span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">📝 ฉบับร่าง</span>
                                @endif
                            </td>
                            
                            <td class="flex justify-between items-center md:table-cell py-3 md:py-4 md:px-6 text-sm text-slate-600 font-medium border-b border-gray-50 md:border-0" :class="expanded ? 'flex' : 'hidden md:table-cell'">
                                <div class="text-[10px] text-slate-400 font-bold uppercase md:hidden">ผู้เขียน</div>
                                {{ $article->author_name }}
                            </td>
                            
                            <td class="block md:table-cell py-3 md:py-4 md:px-6 text-right border-b border-gray-50 md:border-0" :class="expanded ? 'block' : 'hidden md:table-cell'">
                                <div class="text-[10px] text-slate-400 font-bold uppercase mb-2 md:hidden text-left">จัดการ</div>
                                <div class="flex items-center justify-start md:justify-end gap-2">
                                    <a href="{{ route('central_admin.articles.edit', $article) }}" class="inline-flex items-center justify-center gap-1.5 p-2 text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition w-full md:w-auto" title="แก้ไข">
                                        <i class="fa-solid fa-pen-to-square"></i> <span class="md:hidden text-xs font-bold">แก้ไข</span>
                                    </a>
                                    <form action="{{ route('central_admin.articles.destroy', $article) }}" method="POST" class="inline-block w-full md:w-auto" onsubmit="return confirm('ยืนยันลบบทความนี้?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="inline-flex items-center justify-center gap-1.5 p-2 text-rose-600 bg-rose-50 hover:bg-rose-100 rounded-lg transition w-full md:w-auto" title="ลบ">
                                            <i class="fa-solid fa-trash-can"></i> <span class="md:hidden text-xs font-bold">ลบ</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        @empty
                        <tr>
                            <td colspan="4" class="py-16 text-center text-slate-400">
                                <i class="fa-solid fa-newspaper text-4xl mb-3 block text-slate-300"></i>
                                <p class="font-medium">ยังไม่มีบทความในระบบ</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

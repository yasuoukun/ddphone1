<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center justify-between">
            <span class="flex items-center gap-2">
                <i class="fa-solid fa-tag text-indigo-600"></i>
                จัดการแบรนด์สินค้า
            </span>
            <a href="{{ route('central_admin.brands.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold shadow-sm transition text-sm">
                <i class="fa-solid fa-plus"></i> เพิ่มแบรนด์ใหม่
            </a>
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50/50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-r-lg shadow-sm flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-emerald-500 text-xl"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            @endif

            <x-real-time-filter table-id="brandsTable" placeholder="ค้นหาชื่อแบรนด์..." count-label="แบรนด์">
            </x-real-time-filter>

            <div class="bg-white md:overflow-hidden shadow-sm rounded-3xl border border-gray-100 md:overflow-x-auto">
                <table id="brandsTable" class="w-full text-left border-collapse block md:table">
                    <thead class="hidden md:table-header-group">
                        <tr class="border-b border-gray-100 text-slate-500 text-xs font-semibold uppercase bg-slate-50/80">
                            <th class="py-4 px-5 rounded-tl-xl text-center">ID</th>
                            <th class="py-4 px-5">ชื่อแบรนด์</th>
                            <th class="py-4 px-5 text-center rounded-tr-xl">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="block md:table-row-group divide-y-0 md:divide-y divide-gray-50 bg-transparent md:bg-white space-y-4 md:space-y-0 p-4 md:p-0">
                        @forelse($brands as $item)
                        <tr class="hover:bg-indigo-50/30 transition-colors block md:table-row bg-white border border-gray-100 md:border-0 rounded-2xl md:rounded-none shadow-sm md:shadow-none p-4 md:p-0 relative"
                            x-data="{ expanded: false }"
                            data-searchable="{{ strtolower($item->name . ' ' . $item->id) }}">
                            
                            <td class="hidden md:table-cell py-4 px-5 text-center text-xs text-slate-400 font-mono">{{ $item->id }}</td>
                            
                            <td class="flex items-center justify-between md:table-cell py-2 md:py-4 md:px-5 border-b border-gray-50 md:border-0">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center text-sm font-bold shrink-0">
                                        {{ mb_strtoupper(mb_substr($item->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <span class="font-semibold text-slate-800">{{ $item->name }}</span>
                                        <div class="text-[10px] text-slate-400 md:hidden mt-0.5">ID: {{ $item->id }}</div>
                                    </div>
                                </div>
                                <div class="md:hidden">
                                    <button @click="expanded = !expanded" class="w-8 h-8 flex items-center justify-center bg-gray-100 text-gray-600 rounded-full">
                                        <i class="fa-solid fa-chevron-down transition-transform duration-300" :class="expanded ? 'rotate-180' : ''"></i>
                                    </button>
                                </div>
                            </td>
                            
                            <td class="block md:table-cell py-3 md:py-4 md:px-5 text-center border-b border-gray-50 md:border-0" :class="expanded ? 'block' : 'hidden md:table-cell'">
                                <div class="text-[10px] text-slate-400 font-bold uppercase mb-2 md:hidden">จัดการ</div>
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('central_admin.brands.edit', $item) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 rounded-xl transition w-full md:w-auto justify-center">
                                        <i class="fa-solid fa-pen-to-square"></i> แก้ไข
                                    </a>
                                    <form action="{{ route('central_admin.brands.destroy', $item) }}" method="POST" class="inline w-full md:w-auto" onsubmit="return confirm('ยืนยันการลบแบรนด์ {{ $item->name }}?')">
                                        @csrf @method("DELETE")
                                        <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-rose-600 bg-rose-50 hover:bg-rose-100 rounded-xl transition w-full md:w-auto justify-center">
                                            <i class="fa-solid fa-trash-can"></i> ลบ
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr class="block md:table-row">
                            <td colspan="3" class="block md:table-cell py-14 text-center text-slate-400">
                                <i class="fa-solid fa-tag text-4xl mb-2 block text-slate-300"></i>ยังไม่มีแบรนด์ในระบบ
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>
</x-app-layout>
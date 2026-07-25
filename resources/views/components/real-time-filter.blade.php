{{--
    Real-Time Table Filter Component (v2 - Pure Vanilla JS, no Alpine dependency)
    ============================================================
    Usage:
      <x-real-time-filter table-id="myTable" placeholder="..." count-label="รายการ">
          <select id="rtf-myTable-status" ...>...</select>
      </x-real-time-filter>

      In each <tr>:
        data-searchable="searchable text combined"
        data-filter-status="{{ $item->status }}"
        data-filter-category="{{ $item->category }}"
--}}
@props([
    'tableId'     => 'filterTable',
    'placeholder' => 'ค้นหาข้อมูล...',
    'countLabel'  => 'รายการ',
    'showStats'   => true,
])

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6" id="rtf-wrapper-{{ $tableId }}">
    <div class="flex flex-col md:flex-row gap-3 items-stretch md:items-center flex-wrap">

        {{-- Search Input --}}
        <div class="relative flex-grow min-w-[200px]">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
            <input
                type="text"
                id="rtf-search-{{ $tableId }}"
                placeholder="{{ $placeholder }}"
                autocomplete="off"
                class="w-full pl-10 pr-10 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 text-sm font-medium transition"
                oninput="RTF.filter('{{ $tableId }}')"
            >
            <button
                id="rtf-clear-search-{{ $tableId }}"
                onclick="document.getElementById('rtf-search-{{ $tableId }}').value=''; RTF.filter('{{ $tableId }}')"
                style="display:none"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition"
            >
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        {{-- Dynamic Dropdowns passed as slot --}}
        {{ $slot }}

        {{-- Clear All Button --}}
        <button
            id="rtf-clearall-{{ $tableId }}"
            onclick="RTF.clearAll('{{ $tableId }}')"
            style="display:none"
            class="flex items-center gap-1.5 px-3 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-xl text-xs font-bold transition border border-rose-100 whitespace-nowrap"
        >
            <i class="fa-solid fa-filter-circle-xmark"></i> ล้างตัวกรอง
        </button>

        {{-- Count Badge --}}
        @if($showStats)
        <div class="flex items-center gap-1.5 text-xs font-semibold text-slate-500 bg-slate-50 px-3 py-2.5 rounded-xl border border-slate-100 whitespace-nowrap flex-shrink-0">
            <i class="fa-solid fa-list-check text-indigo-400"></i>
            <span id="rtf-match-{{ $tableId }}">—</span>
            /
            <span id="rtf-total-{{ $tableId }}">—</span>
            <span>{{ $countLabel }}</span>
        </div>
        @endif
    </div>

    {{-- Active filter chips --}}
    <div id="rtf-chips-{{ $tableId }}" class="mt-3 flex flex-wrap gap-2" style="display:none!important">
    </div>
</div>

<script>
// Global RTF namespace (safe to load multiple times)
if (typeof window.RTF === 'undefined') {
    window.RTF = {
        filter(tableId) {
            const table  = document.getElementById(tableId);
            if (!table) return;
            const tbody  = table.querySelector('tbody');
            if (!tbody) return;

            const searchInput = document.getElementById('rtf-search-' + tableId);
            const searchVal   = searchInput ? searchInput.value.toLowerCase().trim() : '';

            // Collect all select filters for this table
            const selects = document.querySelectorAll('[id^="rtf-' + tableId + '-"]');

            const rows = tbody.querySelectorAll('tr[data-searchable]');
            let matched = 0;
            let total   = rows.length;

            rows.forEach(row => {
                const searchable = (row.getAttribute('data-searchable') || '').toLowerCase();
                let visible = searchVal === '' || searchable.includes(searchVal);

                if (visible) {
                    selects.forEach(sel => {
                        const key = sel.id.replace('rtf-' + tableId + '-', '');
                        const val = sel.value;
                        if (val && val !== '' && val !== 'all') {
                            const rowVal = (row.getAttribute('data-filter-' + key) || '').toLowerCase();
                            if (!rowVal.includes(val.toLowerCase())) {
                                visible = false;
                            }
                        }
                    });
                }

                row.style.display = visible ? '' : 'none';
                if (visible) matched++;
            });

            // Update counters
            const matchEl = document.getElementById('rtf-match-' + tableId);
            const totalEl = document.getElementById('rtf-total-' + tableId);
            if (matchEl) matchEl.textContent = matched;
            if (totalEl) totalEl.textContent = total;

            // Show/hide clear search X button
            const clearSearchBtn = document.getElementById('rtf-clear-search-' + tableId);
            if (clearSearchBtn) clearSearchBtn.style.display = searchVal !== '' ? 'block' : 'none';

            // Show/hide Clear All button
            const hasFilters = this.hasActiveFilters(tableId);
            const clearAllBtn = document.getElementById('rtf-clearall-' + tableId);
            if (clearAllBtn) clearAllBtn.style.display = hasFilters ? 'flex' : 'none';

            // Show/hide empty state row
            let emptyRow = tbody.querySelector('tr.rtf-empty-state');
            if (matched === 0) {
                if (!emptyRow) {
                    const colspan = table.querySelectorAll('thead th').length || 6;
                    emptyRow = document.createElement('tr');
                    emptyRow.className = 'rtf-empty-state';
                    emptyRow.innerHTML = `<td colspan="${colspan}" class="py-14 text-center">
                        <div class="flex flex-col items-center gap-2 text-slate-400">
                            <div class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center">
                                <i class="fa-solid fa-magnifying-glass text-2xl text-slate-300"></i>
                            </div>
                            <p class="font-semibold text-slate-500">ไม่พบข้อมูลที่ตรงกับคำค้นหา</p>
                            <p class="text-xs text-slate-400">ลองเปลี่ยนคำค้นหาหรือล้างตัวกรอง</p>
                        </div>
                    </td>`;
                    tbody.appendChild(emptyRow);
                }
                emptyRow.style.display = '';
            } else {
                if (emptyRow) emptyRow.style.display = 'none';
            }
        },

        hasActiveFilters(tableId) {
            const searchInput = document.getElementById('rtf-search-' + tableId);
            if (searchInput && searchInput.value.trim() !== '') return true;
            const selects = document.querySelectorAll('[id^="rtf-' + tableId + '-"]');
            for (const sel of selects) {
                if (sel.value && sel.value !== '' && sel.value !== 'all') return true;
            }
            return false;
        },

        clearAll(tableId) {
            const searchInput = document.getElementById('rtf-search-' + tableId);
            if (searchInput) searchInput.value = '';
            const selects = document.querySelectorAll('[id^="rtf-' + tableId + '-"]');
            selects.forEach(sel => { sel.value = sel.options[0]?.value ?? 'all'; });
            this.filter(tableId);
        },

        init(tableId) {
            const table = document.getElementById(tableId);
            if (!table) return;
            const tbody = table.querySelector('tbody');
            if (!tbody) return;
            const rows = tbody.querySelectorAll('tr[data-searchable]');
            const totalEl = document.getElementById('rtf-total-' + tableId);
            const matchEl = document.getElementById('rtf-match-' + tableId);
            if (totalEl) totalEl.textContent = rows.length;
            if (matchEl) matchEl.textContent = rows.length;

            // Auto-bind all selects for this table
            const selects = document.querySelectorAll('[id^="rtf-' + tableId + '-"]');
            selects.forEach(sel => {
                sel.addEventListener('change', () => RTF.filter(tableId));
            });
        }
    };
}

// Auto-init when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    RTF.init('{{ $tableId }}');
});
</script>

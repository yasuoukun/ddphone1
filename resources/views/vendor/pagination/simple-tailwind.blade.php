@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex gap-2 items-center justify-between">

        @if ($paginator->onFirstPage())
            <span class="inline-flex items-center px-4 py-2 text-xs font-bold text-slate-400 bg-slate-100 border border-slate-200 cursor-not-allowed rounded-xl">
                ‹ ก่อนหน้า
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center px-4 py-2 text-xs font-bold text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-all shadow-sm">
                ‹ ก่อนหน้า
            </a>
        @endif

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center px-4 py-2 text-xs font-bold text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-all shadow-sm">
                ถัดไป ›
            </a>
        @else
            <span class="inline-flex items-center px-4 py-2 text-xs font-bold text-slate-400 bg-slate-100 border border-slate-200 cursor-not-allowed rounded-xl">
                ถัดไป ›
            </span>
        @endif

    </nav>
@endif

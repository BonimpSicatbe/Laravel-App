@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center pt-5 gap-1">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="pagination-btn disabled bg-gray-300 text-gray-500 w-10 h-10 flex items-center justify-center rounded cursor-not-allowed">&laquo;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="pagination-btn w-10 h-10 flex items-center justify-center bg-white text-green-800 border border-green-800 rounded hover:bg-green-800 hover:text-white transition">&laquo;</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="pagination-ellipsis text-green-800 w-10 h-10 flex items-center justify-center">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="pagination-btn active w-10 h-10 flex items-center justify-center bg-green-800 text-white border border-green-800 rounded">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="pagination-btn w-10 h-10 flex items-center justify-center bg-white text-green-800 border border-green-800 rounded hover:bg-green-800 hover:text-white transition">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="pagination-btn w-10 h-10 flex items-center justify-center bg-white text-green-800 border border-green-800 rounded hover:bg-green-800 hover:text-white transition">&raquo;</a>
        @else
            <span class="pagination-btn disabled bg-gray-300 text-gray-500 w-10 h-10 flex items-center justify-center rounded cursor-not-allowed">&raquo;</span>
        @endif
    </nav>
@endif

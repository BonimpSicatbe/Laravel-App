@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-1 mx-1 text-gray-500 bg-gray-200 rounded" aria-disabled="true" aria-label="@lang('pagination.previous')">
                <span aria-hidden="true"><i class="fa-regular fa-chevron-left"></i></span>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1 mx-1 text-gray-700 bg-white border rounded hover:bg-gray-100" rel="prev" aria-label="@lang('pagination.previous')"><i class="fa-regular fa-chevron-left"></i></a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="px-3 py-1 mx-1 text-gray-700">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-1 mx-1 text-white bg-green-600 border rounded">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-1 mx-1 text-gray-700 bg-white border rounded hover:bg-gray-100">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1 mx-1 text-gray-700 bg-white border rounded hover:bg-gray-100" rel="next" aria-label="@lang('pagination.next')">&raquo;</a>
        @else
            <span class="px-3 py-1 mx-1 text-gray-500 bg-gray-200 rounded" aria-disabled="true" aria-label="@lang('pagination.next')">
                <span aria-hidden="true">&raquo;</span>
            </span>
        @endif
    </nav>
@endif

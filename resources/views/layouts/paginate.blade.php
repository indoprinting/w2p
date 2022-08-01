@if ($paginator->hasPages())
<div class="text-center">
    <nav aria-label="Page navigation">
        <ul class='pagination model1'>
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
            @else
            <li>
                <a class="prev" href="{{ $paginator->previousPageUrl() }}" rel="prev"
                    aria-label="@lang('pagination.previous')">&lsaquo;</a>
            </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
            <li class="disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
            @foreach ($element as $page => $url)
            @if ($page == $paginator->currentPage())
            <li><a class="active" href="">{{$page }}</a></li>
            @else
            <li><a class='page-numbers' href='{{ $url }}'>{{ $page }}</a></li>
            @endif
            @endforeach
            @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
            <li>
                <a class="next" href="{{ $paginator->nextPageUrl() }}" rel="next"
                    aria-label="@lang('pagination.next')"><span aria-hidden="true">&rsaquo;</a>
            </li>
            @else
            @endif
        </ul>
    </nav>
</div>
@endif
@if ($paginator->lastPage() >= 1)
<div class="pagination-links">
    @if ($paginator->hasPages())
        @if ($paginator->onFirstPage())
            <span class="disabled">‹</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}">‹</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="disabled">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="active-page">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}">Next »</a>
        @else
            <span class="disabled">Next »</span>
        @endif
    @else
        <span class="active-page">1</span>
    @endif
</div>
@endif
@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if (!$paginator->onFirstPage())
            <li><a class="noborder" href="{{ $paginator->toArray()['first_page_url'] }}" rel="canonical">В начало</a></li>
            <li><a class="noborder" href="{{ $paginator->previousPageUrl() }}" rel="prev">Назад</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- Array Of Links --}}
            @if (is_array($element))
                <?
                $cur = $paginator->currentPage();
                if($paginator->onFirstPage()) {
                    $from = 1;
                    $to = $paginator->count() > 3 ? 3 : $paginator->count();
                } elseif($cur == $paginator->lastPage()) {
                    $to = $paginator->lastPage();
                    $from = $to - ($paginator->count() > 2 ? 2 : $paginator->count());
                } else {
                    $from = $paginator->currentPage() - 1;
                    $to = $paginator->currentPage() + 1;
                }
                ?>
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active"><span>{{ $page }}</span></li>
                    @elseif($page >= $from && $page <= $to)
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a class="noborder" href="{{ $paginator->nextPageUrl() }}" rel="next">Вперёд</a></li>
            <li><a class="noborder" href="{{ $paginator->toArray()['last_page_url'] }}" rel="next">В конец</a></li>
        @endif
    </ul>
@endif

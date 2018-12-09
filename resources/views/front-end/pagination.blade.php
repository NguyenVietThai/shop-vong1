<?php
    // config
    $link_limit = 7; // maximum number of links (a little bit inaccurate, but will be ok for now)
?>
<style>
    .page-item {
        text-transform: capitalize;
    }
    .page-link {
        margin: 0px 3px;
        color: #717fe0 !important;
    }
    .active .page-link {
        border-color: #717fe0 !important;
        background: #717fe0 !important;
        color: #fff !important;
    }
    .disabled .page-link {
        color: #999 !important;
    }
</style>
@if ($paginator->lastPage() > 1)
    <ul class="pagination">
        <li class="page-item {{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}">
            <a class="page-link" href="{{ $paginator->url(1) }}" data-page="1">First</a>
         </li>
         <li class="page-item {{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}">
            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" data-page="{{$paginator->currentPage() - 1}}">Prev</a>
         </li>
        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            <?php
                $half_total_links = floor($link_limit / 2);
                $from = $paginator->currentPage() - $half_total_links;
                $to = $paginator->currentPage() + $half_total_links;
                if ($paginator->currentPage() < $half_total_links) {
                   $to += $half_total_links - $paginator->currentPage();
                }
                if ($paginator->lastPage() - $paginator->currentPage() < $half_total_links) {
                    $from -= $half_total_links - ($paginator->lastPage() - $paginator->currentPage()) - 1;
                }
            ?>
            @if ($from < $i && $i < $to)
                <li class="page-item {{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                    <a class="page-link" href="{{ $paginator->url($i) }}" data-page="{{$i}}">{{ $i }}</a>
                </li>
            @endif
        @endfor
        
        <li class="page-item {{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">
            <a class="page-link" href="{{ $paginator->nextPageUrl() }}" data-page="{{$paginator->currentPage() + 1}}">Next</a>
        </li>
        <li class="page-item {{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">
            <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}" data-page="{{$paginator->lastPage()}}">Last</a>
        </li>
    </ul>
@endif
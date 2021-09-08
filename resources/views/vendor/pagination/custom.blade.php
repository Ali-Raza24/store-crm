    <style>
        .pagination li{
            padding-left: 5px;
            padding-right: 5px;
        }
    </style>
@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" style="font-size: 1.2em !important;" aria-hidden="true"><img alt="" src="{{asset('business_assets/images/arrow-l.png')}}"></span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" style="font-size: 1.2em !important;" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                        <img alt="" src="{{asset('business_assets/images/arrow-r.png')}}" style="transform: rotate(180deg)">
                    </a>
                </li>
            @endif

            @if($paginator->currentPage() > 3)
                <li class="page-item" aria-current="page"><a class="page-link" href="{{ $paginator->url(1) }}">1</a></li>
            @endif
            @if($paginator->currentPage() > 4)
                <li class="page-item" aria-current="page"><span class="page-link">...</span></li>
            @endif
            @foreach(range(1, $paginator->lastPage()) as $i)
                @if($i >= $paginator->currentPage() - 2 && $i <= $paginator->currentPage() + 2)
                    @if ($i == $paginator->currentPage())
                        <li class="page-item" aria-current="page"><span class="page-link active">{{ $i }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                    @endif
                @endif
            @endforeach
            @if($paginator->currentPage() < $paginator->lastPage() - 3)
                <li class="page-item" aria-current="page"><span class="page-link">...</span></li>
            @endif
            @if($paginator->currentPage() < $paginator->lastPage() - 2)
                <li class="page-item" aria-current="page"><a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" style="font-size: 1.2em !important;" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                        <img alt="" src="{{asset('business_assets/images/arrow-r.png')}}">
                    </a>
                </li>
            @else
                <li class="page-item disabled" style="font-size: 1.2em !important;" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true"><img alt="" src="{{asset('business_assets/images/arrow-l.png')}}" style="transform: rotate(180deg)"></span>
                </li>
            @endif
        </ul>
    </nav>
@endif

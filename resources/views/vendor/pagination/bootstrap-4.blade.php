@if ($paginator->hasPages())
    <style>
        .pagination li{
            padding-left: 10px;
            padding-right: 10px;
        }
    </style>
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

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item" aria-current="page"><span class="page-link active">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

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

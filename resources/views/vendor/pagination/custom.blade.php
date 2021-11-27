@if ($paginator->hasPages())
    <ul class="pagination">
        @if ($paginator->onFirstPage())
            <li class="prev disabled"><a href="javascript:void(0);"> Prev </a></li>
        @else
            <li class="prev"><a href="{{ $paginator->previousPageUrl() }}">Prev</a></li>
        @endif
        
        @foreach ($elements as $element)
           
            @if (is_string($element))
                <li class="disabled"><span><a href="javascript:void(0);">{{ $element }}</a></span></li>
            @endif


           
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active my-active"><span><a href="javascript:void(0);">{{ $page }}</a></span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <li class="next"><a href="{{ $paginator->nextPageUrl() }}" rel="next">Next</a></li>
        @else
            <li class="disabled"><span><a href="javascript:void(0);">Next </a></span></li>
        @endif

         
    </ul>
@endif
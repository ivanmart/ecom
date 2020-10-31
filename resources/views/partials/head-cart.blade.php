@if($basket->totalItems())
    {{$basket->totalItems()}} <span>шт. на {{number_format($basket->total(), 0, '', '&nbsp;')}} &#x20bd;</span>
@endif
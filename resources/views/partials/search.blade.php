@if(count($items) > 0)
    @foreach ($items as $key => $item)
        <a class="search-result__item" href="/catalog/{{$item->categories[0]->slug}}/{{$item->slug}}/">
            <img src="{{$item->image1dark}}">
            <div>{{$item -> categories[0] -> item_name}} <strong>{{$item -> light -> collection -> name or ''}}</strong></div>
            {{number_format($item->price, 0, '', '&nbsp;')}} &#x20bd;
        </a>
    @endforeach
@else
    <div style="padding:20px">Ничего не найдено</div>
@endif
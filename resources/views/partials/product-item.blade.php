<a class="products-list__item" href="/catalog/{{$product->categories[0]->slug}}/{{$product->slug}}">
    <? if($product->{'image1' . $template}) $image = $product->{'image1' . $template};
        else $image = $product->image1dark ? $product->image1dark : $product->image1light; ?>
    <img src="{{$image}}">
    <p>{{$product -> categories[0] -> item_name}} {{$product -> light -> collection -> name or ''}}</p>
    <div class="item__article">арт. {{$product -> name}}</div>
    @if(!isset($show_price) || $show_price)
        {{number_format($product->price, 0, '', '&nbsp;')}} &#x20bd;
    @endif
</a>
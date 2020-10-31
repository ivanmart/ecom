<h1 itemprop="name">
    {{$product -> categories[0] -> item_name}} {{$product -> light -> collection -> name or ''}}
</h1>

<!-- <div class="detail__sku">арт. {{$product->name}}</div> -->

@if(!$main)
    <a class="detail__more" href="/catalog/{{$product->categories[0]->slug}}/{{$product->slug}}">Подробнее</a>
@endif


<div class="detail__params">
    <div class="detail__params-wrap"><div 
        class="detail__param detail__param-width">{{$product -> light -> width}} см</div><div 
        class="detail__param detail__param-height">{{$product -> light -> height}} см</div><div 
        class="detail__param detail__param-height_up">{{$product -> light -> height_up}} см</div><div 
        class="detail__param detail__param-protect">IP{{$product -> light -> protect}}</div><div
        class="detail__param detail__param-weight">{{$product -> light -> weight}} кг</div>@if($main)<div
            class="detail__param detail__param-more"><div>Все<br>характеристики</div></div>
        @endif
    </div>
</div>

<div class="chars-wrap">
    <div class="corner"></div>
    <div class="chars">
        <div class="chars__col">
            <h3>Производитель</h3>
            <div class="chars__row"><div><span><p>Бренд:</p></span><span><p>{{$product -> brand -> name}}</p></span></div></div>
            <div class="chars__row"><div><span><p>Страна:</p></span><span><p>Германия</p></span></div></div>
            <div class="chars__row"><div><span><p>Коллекция:</p></span><span><p>{{$product -> light -> collection -> name or ''}}</p></span></div></div>
            <div class="chars__row"><div><span><p>Гарантии:</p></span><span><p>6 месяцев</p></span></div></div>
        </div>
        <div class="chars__col">
            <h3>Размеры</h3>
            <div class="chars__row"><div><span><p>Высота:</p></span><span><p>{{$product -> light -> height}} см</p></span></div></div>
            <div class="chars__row"><div><span><p>Ширина:</p></span><span><p>{{$product -> light -> width}} см</p></span></div></div>
            <div class="chars__row"><div><span><p>Длина:</p></span><span><p>{{$product -> light -> length}} см</p></span></div></div>
            <div class="chars__row"><div><span><p>Диаметр:</p></span><span><p>{{$product -> light -> diameter}} см</p></span></div></div>
        </div>
        <div class="chars__col">
            <h3>Параметры освещения</h3>
            <div class="chars__row"><div><span><p>Кол-во ламп:</p></span><span><p>{{$product -> light -> bulbs_quantity}} шт.</p></span></div></div>
            <div class="chars__row"><div><span><p>Цоколь:</p></span><span><p>{{$product -> base}}</p></span></div></div>
            @if($product -> light -> bulbs_quantity)
                <div class="chars__row"><div><span><p>Мощность ламп:</p></span><span><p>{{$product -> light -> bulbs_quantity}} x {{$product -> light -> power / $product -> light -> bulbs_quantity}} В</p></span></div></div>
            @else
                <div class="chars__row"><div><span><p>Мощность ламп:</p></span><span><p>{{$product -> light -> power}} В</p></span></div></div>
            @endif
            <div class="chars__row"><div><span><p>Тип ламп:</p></span><span><p>{{$product -> light -> has_led}}</p></span></div></div>
            <div class="chars__row"><div><span><p>Площадь освещения:</p></span><span><p>{{$product -> light -> square}} м<sup>2</sup></p></span></div></div>
        </div>
    </div>
</div>

<div class="detail__price-tocart">
    <div class="detail__price">
        @if($product -> old_price)
            <span class="old-price">{{number_format($product->old_price, 0, '', '&nbsp;')}} &#x20bd;</span>
        @endif
        <span class="price">{{number_format($product->price, 0, '', '&nbsp;')}} &#x20bd;</span>
    </div>

    <button class="rounded-button detail__tocart" onclick="cartAdd($('[itemprop=sku]').prop('content'))">В корзину</button>
    
</div>

<ul class="detail__carousel">
    @for ($i = 0, $iLen = count($product -> images); $i < $iLen; $i++)
        <li class="detail__carousel-item">
            <a style="display:block" data-fancybox href="{{$product -> images[$i] -> file}}">
                <img src="{{$product -> images[$i] -> file}}"
                    alt="{{$product -> categories[0] -> item_name}} {{$product -> brand -> name}} {{$product -> light -> collection -> name or ''}}">
            </a>
        </li>
    @endfor
</ul>

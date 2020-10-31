<div class="header-logo">
    <a class="svg-icon" href="/">Ecom</a>
</div>
<div class="header-right">
    <nav class="header-nav">
        @foreach($top_menu as $item)
            <a href="{{ url($item->link) }}">{{$item->name}}</a>
        @endforeach
    <?
    use Lenius\Basket\Basket;
    use Lenius\Basket\Storage\Session;
    use Lenius\Basket\Identifier\Cookie;
    $basket = new Basket(new Session, new Cookie);
    $contains = $basket->totalItems() ? "contains" : "";
    ?><a
        class="header-nav__cart svg-icon {{$contains}}" href="{{ url('cart') }}">@include('partials.head-cart')</a><div class="cart-empty">Ваша карта пуста</div><a
        class="header-nav__search svg-icon" tabindex="0"><input id="search" placeholder="Поиск"><div class="search-result"></div></a>
    </nav>
    <div class="header-phone">
        <a href="tel:+74956498460">+7 495 649-84-60</a>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.carousel.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.theme.default.min.css" />

@extends('layouts.default')

<? $title = $product -> categories[0] -> item_name . ' ' . $product -> brand -> name . ' ' . (!$product -> light -> collection ?: $product -> light -> collection -> name) ?>

@section('title', $title)

@section('content')

@section('bodyclass', 'detail' . ($product->top_image ? ' has-top-image' : ''))

<div id="product" itemscope itemtype="http://schema.org/Product" data-sku="{{$product -> name}}">

@if($product->top_image)
    <div class="detail__top-image" style="background-image: url('{{$product->top_image}}')"></div>
@endif

@include('partials.detail-product', [
    'product' => $product,
    'main' => true
])


<meta itemprop="model" content="{{$product -> name}}">
<meta itemprop="productID" content="{{$product -> name}}">
<meta itemprop="brand" content="{{$product -> brand -> name}}">
<meta itemprop="sku" content="{{$product -> name}}">
<meta itemprop="mpn" content="{{$product -> name}}">
<link itemprop="url" href="{{url()->current()}}">

<div itemprop="offers" itemscope itemtype="https://schema.org/Offer">
    <meta itemprop="price" content="{{$product -> price}}">
    <meta itemprop="priceCurrency" content="RUB">
    <meta itemprop="itemCondition" href="https://schema.org/NewCondition" content="Новый">
    @if($product -> quantity)
        <link itemprop="availability" href="https://schema.org/InStock" content="В наличии">
    @endif
</div>

<div class="detail__params2">
    <h2>Наши преимущества</h2>
    <div class="params2__item">
        <div class="params2__item-title params2-delivery">Доставка<br>по России<span></span></div>
        <div class="params2__item-value">Бесплатно<span class="old-price">2 000 &#x20bd;</span></div>
    </div>
    <div class="params2__item">
        <div class="params2__item-title params2-install_price">Сборка<br>и установка<span></span></div>
        <div class="params2__item-value">Бесплатно<span class="old-price">2 000 &#x20bd;</span></div>
    </div>
    <div class="params2__item">
        <div class="params2__item-title params2-attached_light">Лампочки<br>в комплекте<span></span></div>
        <div class="params2__item-value">В комплекте<span class="old-price">2 000 &#x20bd;</span></div>
    </div>
<?/*    <div class="params2__item">
        <div class="params2__item-title params2-box">Пульт<br>управления<span></span></div>
        <div class="params2__item-value">Бесплатно<span class="old-price">15 000 &#x20bd;</span></div>
    </div>
    <div class="params2__item">
        <div class="params2__item-title params2-warranty">Расширенная<br>гарантия<span></span></div>
        <div class="params2__item-value">Бесплатно<span class="old-price">3 000 &#x20bd;</span></div>
    </div>
    <div class="params2__item">
        <div class="params2__item-title params2-box">Лифт<br>для люстры<span></span></div>
        <div class="params2__item-value">Бесплатно<span class="old-price">50 000 &#x20bd;</span></div>
    </div>
*/?>
</div>

<?if($product->images[0]->file || $product->images[1]->file || $product->images[2]->file || $product->images[3]->file) {?>
<div class="doublepan-wrap">
    <?if(isset($product->images[0])) {?>
    <div class="doublepan">
        <div class="doublepan__info">
            <h3>Преимущества модели</h3>
            <p>Материалы используемые при производстве (латунь, бронза, сусальное золото, мрамор, костяной фарфор, художественное стекло, мозаика, хромированные поверхности, качественная гальванизация металлов и хрусталя, высочайшее качество и экологичность хрусталя (безсвинцовый, сказать о его преимуществах), сложная огранка хрусталя). Хрустальные элементы выполнены из хрусталя Asfour и Swarovski STRASS с беспрецедентными параметрами прозрачности и чистоты.</p>
        </div><div class="doublepan__photos">
            <img src="{{$product->images[0]->file}}">
        </div>
    </div>
    <?}?>
    <?if(isset($product->images[1])) {?>
    <div class="doublepan">
        <div class="doublepan__info">
            <h3>Стилевые решения интерьера</h3>
            <p>Ручная работа (со сложными узорами, художественная ковка, обработка декоративных элементов). Ручная работа (со сложными узорами, художественная ковка, обработка декоративных элементов).<br>Ручная работа (со сложными узорами, художественная ковка, обработка декоративных элементов). Ручная работа (со сложными узорами, художественная ковка, обработка декоративных элементов).</p>
        </div><div class="doublepan__photos">
            <ul class="photos-carousel">
                <li><img src="{{$product->images[1]->file}}"></li>
            </ul>
        </div>
    </div>
    <?}?>
    <?if(isset($product->images[2])) {?>
    <div class="doublepan">
        <div class="doublepan__info">
            <h3>Технология производства</h3>
            <p>Ампир, готический, ренессанс, барокко, рококо, классицизм, прованс, кантри, модерн, ар-деко. Ампир, готический, ренессанс, барокко, рококо, классицизм, прованс, кантри, модерн, ар-деко. Статусность (люстры украшают. Ампир, готический, ренессанс, барокко, рококо, классицизм, прованс, кантри, модерн, ар-деко. Ампир, готический, ренессанс, барокко, рококо, классицизм, прованс, кантри, модерн, ар-деко.</p>
        </div><div class="doublepan__photos">
            <ul class="photos-carousel">
                <li><img src="{{$product->images[2]->file}}"></li>
            </ul>
        </div>
    </div>
    <?}?>
    <?if(count($product->interior_images)>0) {?>
    <div class="doublepan">
        <div class="doublepan__info">
            <h3>Тип помещения</h3>
            <p>Статусность (люстры украшают. Ампир, готический, ренессанс, барокко, рококо, классицизм, прованс, кантри, модерн, ар-деко. Ампир, готический, ренессанс, барокко, рококо, классицизм, прованс, кантри, модерн, ар-деко. Статусность (люстры украшают. Ампир, готический, ренессанс, барокко, рококо, классицизм, прованс, кантри, модерн, ар-деко. Ампир, готический, ренессанс, барокко, рококо, классицизм, прованс, кантри, модерн, ар-деко</p>
        </div><div class="doublepan__photos">
            <ul class="photos-carousel owl-carousel owl-theme">
                @foreach($product->interior_images as $image)
                    <li><img src="{{$image->file}}"></li>
                @endforeach
            </ul>
        </div>
    </div>
    <?}?>
</div>
<?}?>

@if($product->sku_video)
    <div class="video" itemscope itemtype="http://schema.org/VideoObject">
        <div class="video__wrap">
            <div class="video__thumbnail" id="play-button"><span></span><img width="100%" src="https://img.youtube.com/vi/{{str_replace("www.youtube.com/embed/", "", $product -> sku_video)}}/maxresdefault.jpg"></div>
            <div class="lamp-description video__player">
                <iframe id="yplayer" itemprop="url" width="100%" src="https://{{$product -> sku_video}}?enablejsapi=1" frameborder="0" allowfullscreen></iframe>
                <meta itemprop="isFamilyFriendly" content="True">
                <meta itemprop="name" content="<?=$title?>">
                <meta itemprop="description" content="<?=$title?>">
                <meta itemprop="thumbnail" content="{{$product -> sku_video}}">
            </div>
        </div>
    </div>
@endif

<div class="seealso">
    @foreach($family_products as $fp)
        @include('partials.detail-product', [
            'product' => $fp,
            'main' => false
        ])
        <hr/>
    @endforeach
</div>

@if($product->light->collection)
    @include('partials.large-list', [
        'items' => [$product->light->collection],
        'with_products' => true,
        'filter' => 'collection'
    ])
@endif

@if($product->light->style)
    @include('partials.large-list', [
        'items' => [$product->light->style],
        'with_products' => true,
        'filter' => 'style'
    ])
@endif

@include('partials.recently', [
    'items' => $recently
])

<script>

$(function(){

    // Product images slider
    $('.detail__carousel').imSlider();

    // Interior images carousel
    $('.owl-carousel').owlCarousel({
        loop:true,
        margin:10,
        dots:true,
        items:1,
    });

    // Picture zoom
    $('[data-fancybox]').fancybox();

    // 'Recently viewed' carousel
    $('.recently .listing1')
        .addClass('owl-carousel')
        .owlCarousel({
            'rewind': true,
            'nav': false,
            'dots': false,
            'items': 7,
        });

    // Scroll to characteristics
    $('.detail__param-more').click(function(){
        $(this).toggleClass('active');
        $(this).parent().parent().next().slideToggle();
    });

    // play video
    window.onYouTubePlayerAPIReady = function() {
        player = new YT.Player('yplayer', {events: {'onReady': function(){
            var playButton = document.getElementById("play-button");
            playButton.addEventListener("click", function() {
                $('#play-button').hide();
                player.playVideo();
            });
        }}});
    }

    // Inject YouTube API script
    if($('.video').length) {
        var tag = document.createElement('script');
        tag.src = "//www.youtube.com/player_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    }

});
</script>



@stop

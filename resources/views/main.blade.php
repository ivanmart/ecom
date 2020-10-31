<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.carousel.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.theme.default.min.css" />

@extends('layouts.default')

@section('title', 'Ecom')

@section('bodyclass', 'main')

@section('content')

@include('partials.banners', ['items' => $banners])

@include('partials.large-list', [
    'items' => $styles,
    'with_navigation' => false,
    'nav_prefix' => 'Стиль',
    'filter' => 'style'
])

@include('partials.large-list', [
    'items' => $collections,
    'with_navigation' => false,
    'nav_prefix' => 'Коллекция',
    'filter' => 'collection'
])

<div class="advantages">
    <h2>Наши преимущества</h2>
    <div class="advantages__item">
        <img src="/images/big-delivery.svg" width="130">
        <h3>Доставка по России</h3>
        Статусность (люстры украшают. Ампир, готический, ренессанс, барокко, рококо, классицизм, прованс, кантри, модерн, ар-деко.
        <div class="advantages__bottom">
            <span class="advantages__free">Бесплатно</span>
        </div>
    </div>
    <div class="advantages__item">
        <img src="/images/big-service.svg" width="130">
        <h3>Премиальный сервис</h3>
        Статусность (люстры украшают. Ампир, готический, ренессанс, барокко, рококо, классицизм, прованс, кантри, модерн, ар-деко.
        <div class="advantages__bottom">
            <span class="advantages__free">Бесплатно</span>
        </div>
    </div>
    <div class="advantages__item">
        <img src="/images/big-attached_light.svg" width="122">
        <h3>Лампочки в комплекте</h3>
        Статусность (люстры украшают. Ампир, готический, ренессанс, барокко, рококо, классицизм, прованс, кантри, модерн, ар-деко.
        <div class="advantages__bottom">
            <span class="advantages__free">В комплекте</span>
        </div>
    </div>
<?/*?>
    <div class="advantages__item">
        <img src="/images/big-warranty.svg" width="117">
        <h3>Расширенная гарантия</h3>
        Статусность (люстры украшают. Ампир, готический, ренессанс, барокко, рококо, классицизм, прованс, кантри, модерн, ар-деко.
        <div class="advantages__bottom">
            <span class="old-price">3 000 &#x20bd;</span><span class="advantages__free">Бесплатно</span>
        </div>
    </div>
    <div class="advantages__item">
        <img src="/images/big-box.svg" width="119">
        <h3>Дополнительные опции</h3>
        Статусность (люстры украшают. Ампир, готический, ренессанс, барокко, рококо, классицизм, прованс, кантри, модерн, ар-деко.
        <div class="advantages__bottom">
            <span class="old-price">3 000 &#x20bd;</span><span class="advantages__free">Бесплатно</span>
        </div>
    </div>
<?*/?>
</div>


<?/*?>
<div class="doublepan-wrap">
    <div class="doublepan">
    </div>
    <div class="doublepan">
        <div class="doublepan__info">
            <h3>Материалы</h3>
            <p>Материалы используемые при производстве (латунь, бронза, сусальное золото, мрамор, костяной фарфор, художественное стекло, мозаика, хромированные поверхности, качественная гальванизация металлов и хрусталя, высочайшее качество и экологичность хрусталя (безсвинцовый, сказать о его преимуществах), сложная огранка хрусталя). Хрустальные элементы выполнены из хрусталя Asfour и Swarovski STRASS с беспрецедентными параметрами прозрачности и чистоты. Светильники производятся из материалов высокого качества: латуни, бронзы, нержавеющей стали с покрытием из 24-каратного сусального золота, золота 999 пробы, серебра, хрома, никеля.</p>
        </div><div class="doublepan__photos">
            <img src="/images/dp-main1.jpg">
        </div>
    </div>
    <div class="doublepan">
        <div class="doublepan__info">
            <h3>Ручная работа</h3>
            <p>Ручная работа (со сложными узорами, художественная ковка, обработка декоративных элементов). Ручная работа (со сложными узорами, художественная ковка, обработка декоративных элементов).</p>
            <p>Ручная работа (со сложными узорами, художественная ковка, обработка декоративных элементов). Ручная работа (со сложными узорами, художественная ковка, обработка декоративных элементов).</p>
        </div><div class="doublepan__photos">
            <img src="/images/dp-main2.jpg">
        </div>
    </div>
    <div class="doublepan">
        <div class="doublepan__info">
            <h3>Премиальные стили исполнения</h3>
            <p>Ампир, готический, ренессанс, барокко, рококо, классицизм, прованс, кантри, модерн, ар-деко. Ампир, готический, ренессанс, барокко, рококо, классицизм, прованс, кантри, модерн, ар-деко. Статусность (люстры украшают. Ампир, готический, ренессанс, барокко, рококо, классицизм, прованс, кантри, модерн, ар-деко. Ампир, готический, ренессанс, барокко, рококо, классицизм, прованс, кантри, модерн, ар-деко.</p>
        </div><div class="doublepan__photos">
            <img src="/images/dp-main3.jpg">
        </div>
    </div>
    <div class="doublepan">
        <div class="doublepan__info">
            <h3>Статусность</h3>
            <p>Статусность (люстры украшают. Ампир, готический, ренессанс, барокко, рококо, классицизм, прованс, кантри, модерн, ар-деко. Ампир, готический, ренессанс, барокко, рококо, классицизм, прованс, кантри, модерн, ар-деко. Статусность (люстры украшают. Ампир, готический, ренессанс, барокко, рококо, классицизм, прованс, кантри, модерн, ар-деко. Ампир, готический, ренессанс, барокко, рококо, классицизм, прованс, кантри, модерн, ар-деко</p>
        </div><div class="doublepan__photos">
            <img src="/images/dp-main4.jpg">
        </div>
    </div>
</div>
<?*/?>


<div class="showroom">
    <h2>Шоу-рум</h2>
    <p>Люстры вы можете посмотреть в нашем шоу-руме в Москве.  Это самый большой шоу-рум в России (более 1 500 кв.м).<br>Помещение разделено на 11 зон, каждая зона выполнена в определенном стилевом решении. <a href="#">Подробнее</a></p>
    <p>Время работы с 9:00 до 21:00<br>Адрес: Москва, ул. Островитянова 10/1 <a href="#">Схема проезда</a></p>
    <img src="/uploads/initial/showroom.jpg">
    <p><a class="rounded-button" href="/catalog">Смотреть в каталоге</a></p>
</div>



<script>

var sync1 = $('.large-list');

// Start Carousel
sync1.addClass('owl-carousel owl-theme')
    .owlCarousel({
        items: 1,
        loop: false,
        dots: true,
        nav: true,
        navText: ['','']
    })
    .on('changed.owl.carousel', function (e) {
        $($(e.target).closest('.large-list')[0].nextElementSibling).find('.listing2').trigger('to.owl.carousel', e.item.index);
    });

// banner
$('.slider1')
    .addClass('owl-carousel owl-theme')
    .owlCarousel({
        itemSelector: '.lising1__item',
        dots: true,
        items: 1,
        loop: true,
        autoplay: true,
        nav: true,
        navText: ['','']
    });

</script>




@stop

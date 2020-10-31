@extends('pages.default')

@section('bodyclass', 'static service')

@section('content')
    <script>
        window.onpopstate = window.onload = function() {
            $('.multiple__page').hide();
            var hash = location.href.split('#');
            var menu = $('.multiple__menu');
            if(hash.length < 2) hash[1] = menu.find('a').attr('href').substr(1);
            var page = menu.attr('id') + String(menu.href).replace('#', '__');
            page = menu.attr('id') + '__' + hash[1];
            $('.' + page).show();
        }
    </script>
    
    <h1>{{$page['title']}}</h1>
    
    <nav id="service" class="lvl2-nav multiple__menu">
        <a href="#delivery">Доставка</a>
        <a href="#pay">Оплата</a>
        <a href="#install">Сборка и установка</a>
        <a href="#warranty">Гарантия</a>
        <a href="#certs">Сертификаты</a>
        <a href="#return">Возврат и обмен</a>
        <a href="#options">Дополнительные опции</a>
    </nav>
    
    <div class="content">
        {!! $page['content'] !!}
    </div>
@stop
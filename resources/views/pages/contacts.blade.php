@extends('layouts.default')

@section('title', $page['title'])

@section('bodyclass', 'static')

@section('content')

    <h1>{{$page['title']}}</h1>

    <div class="content contacts">
        {!! $page['content'] !!}

        <h2>Официальный интернет-магазин</h2>

        <div class="contacts__info">
            <p>Время работы: ежедневно 9:00-21:00 (время московское)</p>
            <p>
                Телефоны:<br>
                +7 888 888-88-88 - Москва <br>
                +7 888 888-88-88 - Санкт-Петербург <br>
                8 800 888-88-88 - бесплатный звонок по России
            </p>
            <p>E-mail: <a href="mailto:email_here">email_here</a></p>

            <h2>Шоу-рум в Москве</h2>
            <p>
                117513, г.Москва, ул. xxx 10/1 <br>
                (предварительная запись по телефону +7 888 888-88-88)
            </p>

        </div><div class="contacts__social">

            <p>Мы в социальных сетях:</p>
            <div class="social1">
                <a class="vk" href="">Вконтакте</a>
                <a class="fb" href="">Facebook</a>
                <a class="ig" href="">Instagram</a>
            </div>
        </div>

        <div class="contacts__map">
            <img src="/images/contacts-map.png" width="100%" alt="Контакты, адрес - на карте">
        </div>

        <h2>Как до нас добраться</h2>

        <div class="contacts__left">

            <h3>На машине</h3>
            <p>Точка перегиба, исключая очевидный случай, создает анормальный расходящийся ряд.</p>
            <p>Не доказано, что сумма ряда накладывает равновероятный график функции. Используя таблицу интегралов элементарных функций, получим: умножение вектора на число транслирует комплексный метод последовательных приближений. Замкнутое множество тривиально.</p>

        </div><div class="contacts__right">

            <h3>На общественном транспорте</h3>
            <p>Используя таблицу интегралов элементарных функций, получим: умножение вектора на число транслирует комплексный метод последовательных приближений. Замкнутое множество тривиально.</p>
            <p>Точка перегиба, исключая очевидный случай, создает анормальный расходящийся ряд. Не доказано, что сумма ряда накладывает равновероятный график функции.</p>

        </div>

        <h2>Юридические данные</h2>
        <p>
            ООО «nnn», Юр.адрес nnnnnn, г. Москва, nnn д.1 стр.1<br>
 ИНН 77nnnnnnnnn КПП 77nnnnnnn ОГРН 11nnnnnnn ОКПО nnnnnnn<br>
        </p>

        <div class="contacts__form">
            <form action="/contacts/send" method="post" class="form">
                {{ csrf_field() }}
                <h3>Написать нам</h3>
                <label
                    for="name">Ваше имя<sup>*</sup></label><label
                    for="email">Электронная почта<sup>*</sup></label><label
                    for="phone">Ваш мобильный телефон<sup>*</sup></label>
                <input
                    id="name" name="name" placeholder="Иван Иванов"><input
                    id="email" name="email" placeholder="your@email.com"><input
                    id="phone" name="phone" placeholder="8-999-123-45-67">
                Ваше сообщение<sup>*</sup>
                <textarea id="message" name="msg"></textarea>
                <button>Отправить</button>
            </form>
        </div>

        <script type="text/javascript" src="{{ url('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
  	    {!! JsValidator::formRequest('App\Http\Requests\ContactsFormPostRequest') !!}

    </div>
@stop

@extends('layouts.default')

@section('title', 'Заказ')

@section('bodyclass', 'order')

@section('content')

	<div class="cart-complete">

	    <h1>Заказ</h1>
	    <a href="/cart/" class="cart-list__back">< Назад в корзину</a>

		<div class="form cart-complete__form">
			<form action="/cart/order/complete" method="post" class="cart-form">
				{{ csrf_field() }}
				<input type="hidden" name="phone" value="{{$phone}}">
				<input type="hidden" name="email" value="{{$email}}">
				<input type="hidden" name="name" value="{{$name}}">
				<label for="city">Город</label>
		        <input id="city" name="city" placeholder="Город" value="{{$city}}">
				<label for="street">Улица</label>
		        <input id="street" name="street" placeholder="Ленина">
				<div class="col">
					<label for="house">Дом</label>
			        <input id="house" name="house" placeholder="12">
				</div>
				<div class="col">
					<label for="flat">Квартира</label>
			        <input id="flat" name="flat" placeholder="34">
				</div>
				<label for="pay-type">Способ оплаты</label>
				<div class="cart-form__radio">
					<input type="radio" id="pay-type-1" name="pay-type" value="Наличными при получении"><label for="pay-type-1">Наличными при получении</label><br>
					<input type="radio" id="pay-type-2" name="pay-type" value="Карты VISA / MASTERCARD / МИР"><label for="pay-type-2">Карты VISA / MASTERCARD / МИР</label><br>
					<input type="radio" id="pay-type-3" name="pay-type" value="Безналичная оплата от юр. лица"><label for="pay-type-3">Безналичная оплата от юр. лица</label><br>
					<input type="radio" id="pay-type-4" name="pay-type" value="Картой курьеру при получении"><label for="pay-type-4">Картой курьеру при получении</label><br>
				</div>
		        <button>Заказать</button>
		    </form>
		</div>

		<script type="text/javascript" src="{{ url('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
	    {!! JsValidator::formRequest('App\Http\Requests\CartOrderCompletePostRequest') !!}

		<div class="cart-complete__list">
		@foreach ($items as $item)
			<div class="cart-list__item">
				<div class="cart-list__image"><img src="{{$item->images[0]->file}}"></div>
				<div class="cart-list__name">{{$item->categories[0]->item_name}} {{$item->light->collection->name}}</div>
				<div class="cart-list__count">x {{$item->count}} шт.</div>
				<div class="cart-list__price">{{number_format($item->price * $item->count, 0, ' ', '&nbsp;')}} &#x20bd;</div>
				<ul class="cart-list__options">
					<li>Сборка и установка<span>Бесплатно</span></li>
					<li>Лампочки в комплекте<span>Бесплатно</span></li>
				</ul>
			</div>
		@endforeach
		<div class="cart-list__item">
			<div class="cart-list__delivery">Доставка по России</div>
			<div class="cart-list__price">{{$delivery ?: 'Бесплатно'}}</div>
		</div>
		<div class="cart-list__item">
			<div class="cart-list__total">Итого: {{number_format($total, 0, ' ', '&nbsp;')}} &#x20bd;</div>
		</div>
		</div>

	</div>
    
@stop

@extends('layouts.default')

@section('title', 'Заказ')

@section('bodyclass', 'order')

@section('content')

	<div class="cart-complete cart-complete__final">

	    <h1>Спасибо</h1>
	    <a href="/catalog" class="cart-list__forward">В интернет-магазин &gt;</a>
		
		<div class="cart-complete__ok">
			Ваш заказ отправлен.<br>
			Через несколько минут с вами свяжется наш менеджер,<br>
			чтобы уточнить детали доставки
		</div>
	
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

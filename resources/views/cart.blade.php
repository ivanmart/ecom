@extends('layouts.default')

@section('title', 'Корзина')

@section('bodyclass', 'cart')

@section('content')


	<div class="cart-list">

	    <h1>Корзина</h1>
	    <a href="/catalog/" class="cart-list__back">< Назад к покупкам</a>

		@foreach ($items as $item)
			<div class="cart-list__item">
				<div class="cart-list__image"><img src="{{$item->images[0]->file}}"></div>
				<div class="cart-list__name">{{$item->categories[0]->item_name}} {{$item->brand->name}} {{$item->light->collection->name}}</div>
				<div class="cart-list__price">{{number_format($item->price, 0, ' ', '&nbsp;')}} &#x20bd;</div>
				<div class="cart-list__count">
					<a class="count-minus" onclick="cartDel('{{$item->name}}')">&ndash;</a>
					<input id="count" class="count" value="{{$item->count}}" data-sku="{{$item->name}}" disabled="disabled">
					<a class="count-plus" onclick="cartAdd('{{$item->name}}')">+</a>
				</div>
			</div>
		@endforeach

	</div>

    <form action="/cart/order" method="post" class="form cart-form">
        {{ csrf_field() }}
        <h2>Оформить заказ на <span class="cart_total">{{number_format($total, 0, ' ', '&nbsp;')}}</span> &#x20bd;</h2>
        <input id="phone" name="phone" placeholder="8-987-654-32-10">
        <input id="email" name="email" placeholder="your@email.com">
        <input id="name" name="name" placeholder="Иван Иванов">
        <button>Оформить заказ</button>
    </form>

	<script type="text/javascript" src="{{ url('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\CartOrderPostRequest') !!}

@stop

<html>
	<head></head>
	<body>
		<h2>Заказ с сайта {{config('app.name')}}</h2>
		<p><strong>Имя:</strong> {{$name}}</p>
		<p><strong>Телефон:</strong> {{$phone}}</p>
        <p><strong>Email:</strong> {{$email}}</p>
        <p><strong>Город:</strong> {{$city}}</p>
        <p><strong>Адрес:</strong> ул.{{$street}}, д.{{$house}}, кв.{{$flat}}</p>
        <p><strong>Тип оплаты:</strong> {{$city}}</p>
		<p><strong>Товары:</strong></p>
        @foreach($items as $item)
            <p>{{$item->name}} - {{$item->price}}р. x{{$item->quantity}}шт.</p>
        @endforeach
        <p><strong>Итого:</strong> {{$total}}</p>
	</body>
</html>

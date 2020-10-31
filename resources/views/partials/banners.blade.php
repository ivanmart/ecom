<ul class="slider1">
	@foreach($items as $item)
		<li><a href="{{$item->url}}"><img src="{{$item->image}}" alt="{{$item->name}}"></a>
	@endforeach
</ul>
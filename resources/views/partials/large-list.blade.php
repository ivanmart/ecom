<div>

	<div class="large-list {{isset($with_products) || isset($with_navigation) ? 'large-list--with-items' : ''}}">

		@foreach($items as $item)
			<? $darken = $item->template == 'dark' ? 'linear-gradient( rgba(0, 0, 0, 0.0), rgba(0, 0, 0, 0.0), rgba(0, 0, 0, 0.0), rgb(0, 0, 0) ), ' : ''?>
		    <div class="large-list__item large-list__item-{{ $item->template }}"
				<? if(isset($item['background'])) {?>style="background-image:<?=$darken?>url(/<?=$item['background']?>); background-size: cover;"<?}?>
			>

				<div class="large-list__image">
					@if ($item->image)
						<img src="/{{ $item->image }}">
					@endif
				</div>

				<div class="large-list__description">
					<div class="vertical">
				        <h2>{!! isset($name_prefix) ? $name_prefix : '' !!}{{ $item->name }}</h2>
						<p>{!! $item->description !!}</p>
						<a class="rounded-button" href="{{$filter}}/{{$item->slug}}.html">Смотреть в каталоге</a>
					</div>
				</div>
				<div style="clear:both"></div>

				@if(isset($with_products))
					<div class="large-list__more">
						@include('partials.carousel', ['products' => $item->products()->onlyCeiling()->get(), 'template' => $item->template])
					</div>
				@endif
			
			</div>

		@endforeach

	</div>

	@if(isset($with_navigation) && $with_navigation)
		<div class="nav-carousel">
			@include('partials.nav-carousel', ['items' => $items, 'nav_prefix' => $nav_prefix])
		</div>
	@endif

	@if(isset($with_products))
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.carousel.min.css" />
		<script>
			$(document).ready(function(){
				$('.large-list__more .listing1')
					.addClass('owl-carousel')
					.owlCarousel({
						'rewind': true,
						'nav': true,
						'dots': false,
						'items': 5,
					});
			});
		</script>
	@endif

</div>
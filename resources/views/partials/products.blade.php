<ul class="catalog-filter">
	<li id="price">Цена <span class="arrow"></span><span class="clear"></span>
		<div class="corner"></div>
		<div class="pan">
			От <input type="text" class="from"/>
			до <input type="text" class="to"/> &#x20bd;
			<button>Найдено 0 товаров</button>
		</div>
	</li>
	<li id="square">Площадь освещения <span class="arrow"></span><span class="clear"></span>
		<div class="corner"></div>
		<div class="pan">
			От <input type="text" class="from"/>
			до <input type="text" class="to"/> м<sup>2</sup>
			<button>Найдено 0 товаров</button>
		</div>
	</li>
	<li id="height">Высота светильника <span class="arrow"></span><span class="clear"></span>
		<div class="corner"></div>
		<div class="pan">
			От <input type="text" class="from"/>
			до <input type="text" class="to"/> см
			<button>Найдено 0 товаров</button>
		</div>
	</li>
	<li id="style">Стиль <span class="arrow"></span><span class="clear"></span>
		<div class="corner"></div>
		<div class="pan">
			<ul><li
					data-id="20">Hi-tech</li><li
					data-id="25">Ампир</li><li
					data-id="21">Античный</li><li
					data-id="27">Ар-деко</li><li
					data-id="19">Барокко</li><li
					data-id="24">Готический</li><li
					data-id="29">Классицизм</li><li
					data-id="28">Модерн</li><li
					data-id="30">Поп-арт</li><li
					data-id="23">Ренессанс</li><li
					data-id="26">Рококо</li><li
					data-id="22">Романский</li></ul>
			<button>Найдено 0 товаров</button>
		</div>
	</li>
</ul>

<div>
	<div class="products-list">

	@foreach ($items as $key => $item)
		@include('partials.product-item', ['product' => $item, 'template' => $template])
	@endforeach

	</div>
	<div class="showmore">
		@if($items->currentPage() < $items->lastPage())
		<button class="rounded-button">Показать еще ...</button>
		@endif
	</div>

	<div class="pages" data-itemstotal="{{$total}}">{!! $items->appends($links)->links() !!}</div>
	
</div>

<script>
$(document).on('click', '.showmore button', function(){
	url = $('.pagination .active').next().find('a').attr('href');
	console.log(url);

	if(url == undefined) {
		$('.showmore').remove();
		return;
	}

	$('.products').addClass('products--loading');

	$.ajax({
		type: "GET",
		url: url,
		success: function (data) {
			$('.showmore').html($(data).find('.showmore').html());
			$('.pagination').html($(data).find('.pagination').html());
			$('.products-list').append($(data).find('.products-list').html());
			$('.products').removeClass('products--loading');
			history.pushState(null, null, url);
		}
	});
});
</script>

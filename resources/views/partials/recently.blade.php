@if(count($items))
    <div class="recently">
    <h2>Недавно смотрели</h2>

        <div class="listing1">
        @foreach($items as $item)
            <div class="listing1__item">
                @include('partials.product-item', [
                    'product' => $item,
                    'show_price' => false,
                    'template' => 'dark'
                ])
            </div>
        @endforeach
        </div>

    </div>
@endif
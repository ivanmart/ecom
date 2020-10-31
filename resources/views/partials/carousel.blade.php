<div class="listing1 owl-carousel">
@foreach($products as $product)
    <div class="listing1__item">
        @include('partials.product-item', ['product' => $product, 'template' => $template])
    </div>
@endforeach
</div>

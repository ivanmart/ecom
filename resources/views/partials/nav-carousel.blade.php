<div class="listing2 owl-carousel">
@foreach($items as $item)
    <div class="listing2__item listing2__item-{{ $item->template }}"
        <? if(isset($item['background'])) {?>style="background-image:url(/<?=$item['background']?>); background-size: cover"<?}?>>

        <div class="listing2__image">
            @if ($item->image)
                <img src="/{{ $item->image }}">
            @endif
        </div>

        <div class="listing2__description">
            <div class="vertical">
                <h2><span>{!! isset($nav_prefix) ? $nav_prefix : '' !!}</span>{{ $item->name }}</h2>
            </div>
        </div>

    </div>
@endforeach
</div>

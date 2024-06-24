<div class="box_quickview box_quickview_style_2">
    <a href="#" class="btn-quickview" data-id="{!! $item->id !!}">
        <span class="button_quickview">{!! $config['txt_quickview'] !!}</span>
    </a>
    @if($item->hasVariation)
    <a href="{!! Url::permalink($item->slug) !!}" class="btn-view" data-id="{{$item->id}}">
        <span class="button_view">{!! $config['txt_view'] !!}</span>
    </a>
    @else
    <a href="{!! Url::permalink($item->slug) !!}" class="btn-view product_add_to_cart" data-id="{{ $item->id }}">
        <span class="button_view">{!! $config['txt_buy'] !!}</span>
    </a>
    @endif
</div>
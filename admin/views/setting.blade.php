<div class="row mb-2 js_quick_view_style_main">
    <div class="col-md-3">
        <div class="ui-title-bar__group" style="padding-bottom:5px;">
            <h3 class="ui-title-bar__title" style="font-size:20px;">{!! $title !!}</h3>
            <p style="margin-top: 10px; margin-left: 1px; color: #8c8c8c">{{ $description }}</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box">
            <div class="view__select_box box-content p-2">
                <hr style="margin: 5px 0;">
                <div class="clearfix"></div>
                <div class="quick-view-style-wrapper d-flex">
                    @foreach ($styles as $styleKey => $style)
                        <div class="quick-view__select js_quick_view_style_item {!! ($styleKey == $active) ? 'active' : '' !!}" data-style="{!! $styleKey !!}">
                            {!! $style->review() !!}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="box js_quick_view_style_form">
            {!! Admin::loading() !!}
            <div class="box-content p-0" style="position: relative; min-height: 200px">
                <div style="position: relative; min-height: 200px"></div>
                <div class="box-footer text-right">
                    {!! Admin::button('save', ['type' => 'submit']) !!}
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .quick-view__select {
        position: relative;
        overflow: hidden;
        height: auto;
        width:32%;
        border:2px solid #E3E7FB; border-radius: 5px;
    }
    .quick-view__select img {
        width: 100%;
    }
    .quick-view__select.active {
        border:2px solid var(--theme-color);
    }
</style>


<?php
class QuickViewHelper {

    static function style($key = '') {

        $style = (new QuickViewFactory())->factory();

        if(isset($style[$key])) return Arr::get($style, $key);

        return apply_filters('quick_view_style', $style);
    }

    static function styleActive()
    {
        $active    = Option::get('quick_view_active');

        if(empty($active)) return 'none';

        return $active;
    }

    static function buildCss(): void
    {
        $storage = Storage::make(QV_PATH.'/assets');

        if($storage->fileExists('css/quick-view.build.css')) {
            $storage->delete('css/quick-view.build.css');
        }

        $css = $storage->get('css/style.css');

        $active = QuickViewHelper::styleActive();

        $object = QuickViewHelper::style($active);

        if(have_posts($object)) {
            $css .= $object->buildCss();
        }

        $storage->put('css/quick-view.build.css', $css);
    }
}
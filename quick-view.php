<?php
const QV_NAME = 'quick-view';

define('QV_PATH', Path::plugin(QV_NAME));

class Quick_View {

    private string $name = 'quick_view';

    function __construct() {
        $active  = Option::get('quick_view_active');
        if(!empty($active)) {
            add_action('theme_custom_assets', 'Quick_View::style', 20, 2);
            add_action('theme_custom_script_no_tag', array($this, 'script'));
            add_action('cle_header', array($this, 'checkRender'));
            add_action('product_object_after_image', array($this, 'render'));
        }
    }

    public function active() {}

    public function uninstall() {}

    public function script(): void
    {
        include 'styles/style.script.php';
    }

    public function checkRender(): void {

        $active = QuickViewHelper::styleActive();

        $quickViewStyle = QuickViewHelper::style($active);

        $quickViewStyle->config();

        Cms::setData('quickViewStyle', $quickViewStyle);
    }

    public function render($item): void
    {
        $object = Cms::getData('quickViewStyle');

        if(empty($object)) {

            $active = QuickViewHelper::styleActive();

            $object = QuickViewHelper::style($active);

            $object->config();
        }

        if(have_posts($object)) {

            $object->html($item, $object->config);
        }
    }

    static function style(AssetPosition $header): void
    {
        if(file_exists(QV_PATH.'/assets/css/quick-view.build.css')) {
            $header->add('quick-view', QV_PATH.'/assets/css/quick-view.build.css', ['minify' => true]);
        }
    }
}

new Quick_View();

include 'quick-view-factory.php';
include 'quick-view-helper.php';
include 'quick-view-ajax.php';
include 'admin/quick-view-admin.php';
include 'styles/style.php';

function QuickViewRender(\SkillDo\Http\Request $request, $model ): void
{
    $id = (int)$request->input('id');

    $object = Product::get( $id );

    if(have_posts($object)) {

        Cms::setData('object', $object);

        product_detail_cart_controllers($object);

        Plugin::view(QV_NAME, 'views/view', [
            'object' => $object
        ]);
    }
}
Ajax::client('QuickViewRender');
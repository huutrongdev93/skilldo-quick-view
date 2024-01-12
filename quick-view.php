<?php
/**
Plugin name     : Quick View - Xem Nhanh
Plugin class    : quick_view
Plugin uri      : http://sikido.vn
Description     : Plugin cho khách hàng xem nhanh thông tin sản phẩm.
Author          : Nguyễn Hữu Trọng
Version         : 1.1.2
*/
const QV_NAME = 'quick-view';

define( 'QV_PATH', plugin_dir_path( QV_NAME ) );

class Quick_View {

    private string $name = 'quick_view';

    function __construct() {
        $active  = Option::get('quick_view_active');
        if(!empty($active)) {
            add_action('theme_custom_css', array($this, 'css'));
            add_action('theme_custom_script_no_tag', array($this, 'script'));
            add_action('cle_header', array($this, 'cssCustom'), 1000);
            add_action('product_object_after_image', array($this, 'render'));
        }
    }

    public function active() {}

    public function uninstall() {}

    public function css(): void
    {
        include 'styles/style.css.php';
    }

    public function script(): void
    {
        include 'styles/style.script.php';
    }

    public function render($item): void
    {
        $active    = Option::get('quick_view_active');
        if(!empty($active)) {
            $config = static::style($active);
            include 'styles/html-item-'.$active.'.php';
        }
    }

    public function cssCustom(): void
    {
        $active = option::get('quick_view_active');
        $config = static::style($active);
        include 'styles/css-'.$active.'.php';
    }

    static public function style($key = '') {
        $active    = option::get('quick_view_active');
        $config    = option::get('quick_view_config');
        $style = [
            'style_1' => [
                'btn_bg_color'          => Option::get('theme_color'),
                'txt_color'             => '#fff',
                'btn_bg_color_hover'    => Option::get('theme_color'),
                'txt_color_hover'       => '#fff',
                'txt_quickview'         => htmlentities('<i class="far fa-eye"></i>'),
                'txt_buy'               => htmlentities('<i class="far fa-shopping-cart"></i>'),
                'txt_view'              => htmlentities('<i class="far fa-link"></i>'),
            ],
            'style_2' => [
                'btn_bg_color'          => Option::get('theme_color'),
                'txt_color'             => '#fff',
                'btn_bg_color_hover'    => Option::get('theme_color'),
                'txt_color_hover'       => '#fff',
                'txt_quickview'         => htmlentities('<i class="far fa-eye"></i>'),
                'txt_buy'               => htmlentities('<i class="far fa-shopping-cart"></i>'),
                'txt_view'              => htmlentities('<i class="far fa-link"></i>'),
            ],
            'style_3' => [
                'btn_bg_color'          => Option::get('theme_color'),
                'txt_color'             => '#fff',
                'btn_bg_color_hover'    => Option::get('theme_color'),
                'txt_color_hover'       => '#fff',
                'txt_quickview'         => htmlentities('Xem nhanh'),
                'txt_buy'               => htmlentities('Thêm vào giỏ hàng'),
                'txt_view'              => htmlentities('Xem chi tiết'),
            ],
        ];

        if(isset($style[$active]) && have_posts($config)) {
            $style[$active] = $config;
            $style[$active]['active'] = 1;
            if($key == 'active') return $style[$active];
        }

        if(isset($style[$key])) return $style[$key];

        return apply_filters( 'quick_view_style', $style );
    }
}

new quick_view();

include 'admin/quick-view-admin.php';

function QuickViewRender( $ci, $model ): void
{

    $id = (int)Request::get('id');

    $object = Product::get( $id );

    if(have_posts($object)) {

        $ci->data['object'] = $object;

        product_detail_cart_data($object);

		include 'views/view.php';
    }
}
Ajax::client('QuickViewRender');
<?php
class AdminQuickViewSystem {

    static function register($tabs)
    {
        $tabs['quick-view'] = [
            'label'         => trans('quickview.title'),
            'group'         => 'commerce',
            'description'   => trans('quickview.system.description'),
            'callback'      => 'AdminQuickViewSystem::render',
            'icon'          => '<i class="fa-duotone fa-telescope"></i>',
            'form'          => false
        ];

        return $tabs;
    }

    static function render(): void
    {
        $active = QuickViewHelper::styleActive();

        $styles = QuickViewHelper::style();

        Plugin::view(QV_NAME, 'admin/views/setting', [
            'title'       => trans('quickview.title'),
            'description' => trans('quickview.system.description'),
            'styles'      => $styles,
            'active'      => $active
        ]);

        Plugin::view(QV_NAME, 'admin/views/script');
    }
}

add_filter('skd_system_tab', 'AdminQuickViewSystem::register', 50);

if(!function_exists('admin_quick_view_ajax_object_save')) {

    function admin_quick_view_ajax_object_save($ci, $model) {

        $result['status'] 	= 'error';

        $result['message'] 	= 'Lưu dữ liệu không thành công!';

        if(Request::post()) {
            $data   = Request::post();
            $active = Request::Post('style');
            unset($data['action']);
            unset($data['post_type']);
            unset($data['cate_type']);
            unset($data['object_key']);
            unset($data['style']);
            Option::update('quick_view_active', $active);
            Option::update('quick_view_config', $data);
            $result['status'] = 'success';
            $result['message'] = 'Lưu dữ liệu thành công';
        }

        echo json_encode($result);
    }
    Ajax::admin('admin_quick_view_ajax_object_save');
}
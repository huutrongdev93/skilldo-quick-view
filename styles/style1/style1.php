<?php
class QuickViewStyle1 {

    public string $key = 'style_1';

    public array $config = [];

    public function form(SkillDo\Form\Form $form, $config): \SkillDo\Form\Form
    {
        $form->color('btn_bg_color', [
            'label' => 'Màu nền button',
            'start' => 6
        ], $config['btn_bg_color'] ?? '');

        $form->color('txt_color', [
            'label' => 'Màu chữ button',
            'start' => 6
        ], $config['txt_color'] ?? '');

        $form->color('btn_bg_color_hover', [
            'label' => 'Màu nền button (hover)',
            'start' => 6
        ], $config['btn_bg_color_hover'] ?? '');

        $form->color('txt_color_hover', [
            'label' => 'Màu chữ button (hover)',
            'start' => 6
        ], $config['txt_color_hover'] ?? '');

        $form->text('txt_quickview', [
            'label' => 'Chữ button quick view',
            'start' => 6
        ], $config['txt_quickview'] ?? '');

        $form->text('txt_buy', [
            'label' => 'Chữ button mua ngay',
            'start' => 6
        ], $config['txt_buy'] ?? '');

        $form->text('txt_view', [
            'label' => 'Chữ button view',
            'start' => 6
        ], $config['txt_view'] ?? '');

        if(Language::isMulti()) {

            foreach (Language::list() as $key => $lang) {

                if($key == Language::default()) continue;

                $form->text('txt_quickview_'.$key, [
                    'label' => 'Chữ button quick view ('.$lang['label'].')',
                    'start' => 6
                ], (isset($config['txt_quickview_'.$key])) ? $config['txt_quickview_'.$key] : '');

                $form->text('txt_buy_'.$key, [
                    'label' => 'Chữ button mua ngay ('.$lang['label'].')',
                    'start' => 6
                ], (isset($config['txt_buy_'.$key])) ? $config['txt_buy_'.$key] : '');

                $form->text('txt_view_'.$key, [
                    'label' => 'Chữ button view ('.$lang['label'].')',
                ], (isset($config['txt_view_'.$key])) ? $config['txt_view_'.$key] : '');
            }
        }

        return $form;
    }

    public function review()
    {
        return Template::img(Url::base().Path::plugin(QV_NAME).'/assets/images/style_1.png', '', ['return' => true]);
    }

    public function config(): array
    {
        $active = QuickViewHelper::styleActive();

        $this->config = [
            'btn_bg_color'          => Option::get('theme_color'),
            'txt_color'             => '#fff',
            'btn_bg_color_hover'    => Option::get('theme_color'),
            'txt_color_hover'       => '#fff',
            'txt_quickview'         => '<i class="far fa-eye"></i>',
            'txt_buy'               => '<i class="far fa-shopping-cart"></i>',
            'txt_view'              => '<i class="far fa-link"></i>',
        ];

        if($active == $this->key) {

            $configActive  = Option::get('quick_view_config');

            if(!empty($configActive)) {
                $this->config = $configActive;
            }
        }

        return $this->config;
    }

    public function save(\SkillDo\Http\Request $request, $config): void
    {
        $config['btn_bg_color'] = Str::clear($request->input('btn_bg_color'));
        $config['txt_color'] = Str::clear($request->input('txt_color'));
        $config['btn_bg_color_hover'] = Str::clear($request->input('btn_bg_color_hover'));
        $config['txt_color_hover'] = Str::clear($request->input('txt_color_hover'));
        $config['txt_quickview']    = $request->input('txt_quickview');
        $config['txt_buy']          = $request->input('txt_buy');
        $config['txt_view']         = $request->input('txt_view');
        Option::update('quick_view_config', $config);
    }

    /**
     * @throws Less_Exception_Parser
     * @throws Exception
     */
    public function buildCss(): string
    {
        $config = $this->config();

        $css['--quick-view-bg-color'] = $config['btn_bg_color'];

        $css['--quick-view-txt-color'] = $config['txt_color'];

        $css['--quick-view-bg-color-hover'] = $config['btn_bg_color_hover'];

        $css['--quick-view-txt-color-hover'] = $config['txt_color_hover'];

        $css = Plugin::partial(QV_NAME, 'styles/css-validator', ['css' => $css]);

        $css .= Template::less(file_get_contents(FCPATH.QV_PATH.'/styles/style1/css/style.less'))->getCss();

        return $css;
    }

    public function html($object, $config): void
    {
        $lang = Language::current();

        if(Language::default() != $lang) {

            $config['txt_quickview'] = (!empty($config['txt_quickview_'.$lang])) ? $config['txt_quickview_'.$lang] : $config['txt_quickview'];

            $config['txt_view'] = (!empty($config['txt_view_'.$lang])) ? $config['txt_view_'.$lang] : $config['txt_view'];

            $config['txt_buy'] = (!empty($config['txt_buy_'.$lang])) ? $config['txt_buy_'.$lang] : $config['txt_buy'];
        }

        Plugin::view(QV_NAME, 'styles/style1/view/view', [
            'item' => $object,
            'config' => $config
        ]);
    }
}
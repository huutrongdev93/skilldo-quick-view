<?php

use JetBrains\PhpStorm\NoReturn;

class QuickViewAjax {
    #[NoReturn]
    static function styleLoad(\SkillDo\Http\Request $request, $model): void
    {
        if($request->isMethod('post')) {

            $style = $request->input('style');

            if(empty($style)) {
                response()->error(trans('Bạn chưa chọn Style'));
            }

            $styleObject = QuickViewHelper::style($style);

            if(empty($styleObject)) {

                response()->error(trans('Style bạn chọn không tồn tại'));
            }

            $styleConfig = $styleObject->config();

            $form = form();

            $form->setIsValid(true);

            $form->setCallbackValidJs('quickViewStyle.save');

            $form = $styleObject->form($form, $styleConfig);

            $result = Plugin::partial(QV_NAME, 'admin/views/style-form', [
                'form' => $form,
            ]);

            $result = base64_encode($result);

            response()->success(trans('ajax.load.success'), $result);
        }

        response()->error(trans('ajax.load.error'));
    }

    #[NoReturn]
    static function objectSave(\SkillDo\Http\Request $request, $model ): void
    {
        if($request->isMethod('post')) {

            $style = $request->input('styleId');

            if(empty($style)) {
                response()->error(trans('Bạn chưa chọn style'));
            }

            $styleObject = QuickViewHelper::style($style);

            if(empty($styleObject)) {
                response()->error(trans('Style bạn chọn không tồn tại'));
            }

            $styleConfig = $styleObject->config();

            $form = form();

            $form = $styleObject->form($form, $styleConfig);

            $validations = $form->validations();

            if(!empty($validations)) {

                $validate = $request->validate($form);

                if ($validate->fails()) {
                    response()->error($validate->errors());
                }
            }

            $styleObject->save($request, $styleConfig);

            Option::update('quick_view_active', $style);

            QuickViewHelper::buildCss();

            response()->success(trans('ajax.save.success'));
        }

        response()->error(trans('ajax.save.error'));
    }
}

Ajax::admin('QuickViewAjax::styleLoad');

Ajax::admin('QuickViewAjax::objectSave');
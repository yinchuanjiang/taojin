<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AuthController as BaseAuthController;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;
use Encore\Admin\Facades\Admin;

class AuthController extends BaseAuthController
{

    /**
     * User setting page.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function getSetting(Content $content)
    {

        $form = $this->settingForm();
        $form->tools(function (Form\Tools $tools) {
            $tools->disableView();
            $tools->disableDelete();
            $tools->disableList();
        });
        $form->footer(function ($footer) {
            // 去掉`重置`按钮
            $footer->disableReset();
            // 去掉`提交`按钮
            //$footer->disableSubmit();
            // 去掉`查看`checkbox
            $footer->disableViewCheck();
            // 去掉`继续编辑`checkbox
            $footer->disableEditingCheck();
            // 去掉`继续创建`checkbox
            $footer->disableCreatingCheck();

        });

        return $content
            ->header(trans('admin.user_setting'))
            ->body($form->edit(Admin::user()->id));
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: yinchuanjiang
 * Date: 2019/3/8
 * Time: 上午12:08
 */
namespace App\Admin\Extensions\Form;
use Encore\Admin\Form\Field;

class UEditor extends Field
{
    public static $js = [
        '/vendor/ueditor/ueditor.config.js',
        '/vendor/ueditor/ueditor.all.js'
    ];

    protected $view = 'admin.ueditor';

    public function render()
    {
        $cs=csrf_token();

        $this->script = <<<EOT

        //解决第二次进入加载不出来的问题

        UE.delEditor("ueditor");

        // 默认id是ueditor

        var ue = UE.getEditor('ueditor'); 

        ue.ready(function () {

            ue.execCommand('serverparam', '_token', '$cs');

        });

EOT;
        return parent::render();
    }
}
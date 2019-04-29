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
        $name = $this->formatName($this->column);

        $this->script = <<<EOT
    //解决第二次进入加载不出来的问题
    UE.delEditor("container");
    var ue = UE.getEditor('container',{
    elementPathEnabled: false,
    enableContextMenu: false,
    autoClearEmptyNode: true,
    wordCount: false,
    imagePopup: false,
     autotypeset: {indent: true, imageBlockLine: 'center'}
    });
    ue.ready(function() {
      ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');

    });

EOT;
        return parent::render();
    }
}
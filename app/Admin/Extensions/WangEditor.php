<?php

namespace App\Admin\Extensions;
/**
 * Created by PhpStorm.
 * User: yinchuanjiang
 * Date: 2019/1/18
 * Time: 上午10:31
 */
use Encore\Admin\Form\Field;

class WangEditor extends Field
{
    protected $view = 'admin.wang-editor';

    protected static $css = [
        '/vendor/wangEditor-3.0.9/release/wangEditor.min.css',
    ];

    protected static $js = [
        '/vendor/wangEditor-3.0.9/release/wangEditor.min.js',
    ];

    public function render()
    {
        $name = $this->formatName($this->column);

        $this->script = <<<EOT

var E = window.wangEditor
var editor = new E('#{$this->id}');
editor.customConfig.zIndex = 0
editor.customConfig.uploadImgShowBase64 = true
editor.customConfig.onchange = function (html) {
    $('input[name=\'$name\']').val(html);
}
editor.create()

EOT;
        return parent::render();
    }
}


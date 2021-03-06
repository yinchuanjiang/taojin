<?php

/**
 * Laravel-admin - admin builder based on Laravel.
 * @author z-song <https://github.com/z-song>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * Encore\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * Encore\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */
use Encore\Admin\Form;
use App\Admin\Extensions\Form\UEditor;
use App\Admin\Extensions\Form\UEditorB;
use App\Admin\Extensions\WangEditor;
Form::forget(['map']);
Form::extend('weditor', WangEditor::class);
Form::extend('editor', uEditor::class);
//Form::extend('editor', uEditorB::class);
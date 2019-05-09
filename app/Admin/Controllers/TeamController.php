<?php

namespace App\Admin\Controllers;

use App\Models\User;

use Encore\Admin\Form;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Layout\Row;
use Encore\Admin\Tree;
use Encore\Admin\Widgets\Box;
use Illuminate\Support\Facades\DB;

class TeamController extends Controller
{
    use ModelForm;

    protected $header = '团队';

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header($this->header);
            $content->description('团队列表');

            $content->row(function (Row $row) {
                $row->column(12, $this->treeView()->render());
            });



        });
    }


    protected function treeView()
    {
        return User::tree(function (Tree $tree) {
            $tree->disableCreate();
            $tree->disableSave();
            return $tree;
        });
    }



    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header($this->header);
            $content->description('添加类型');

            $content->body($this->form());
        });
    }


    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(User::class, function (Form $form) {
        });
    }


    public function getCategoryOptions()
    {
        return DB::table('users')->select('id','mobile as text')->get();
    }
}
<?php

namespace App\Admin\Controllers;

use App\Models\Good;
use App\Models\GoodImg;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class GoodImgController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new GoodImg);
        $grid->model()->orderBy('good_id', 'asc');
        $grid->good_id('商品标题')->display(function ($goodId){
            $name = Good::find($goodId)->title;
            return "<span class='label label-info'>{$name}</span>";
        });
        $grid->img_url('图片')->image('',100);
        $grid->created_at('添加时间');
        $grid->filter(function ($filter) {
            $filter->equal('good_id', '所属模块')->select($abouts = Good::all()->pluck('title','id')->all());
            // 设置created_at字段的范围查询
            $filter->between('created_at', '创建日期')->datetime();
        });
        //禁用导出数据按钮
        $grid->disableExport();
        //设置分页选择器选项
        $grid->perPages([10, 20, 30, 40, 50]);
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(GoodImg::findOrFail($id));

        $show->good_id('Good id');
        $show->img_url('Img url');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new GoodImg);
        $goods = Good::all()->pluck('title','id')->all();

        $form->select('good_id', '商品')->options($goods);
        $form->image('img_url', '图片')->uniqueName()->removable();
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
        return $form;
    }
}

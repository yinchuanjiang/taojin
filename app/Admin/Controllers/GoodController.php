<?php

namespace App\Admin\Controllers;

use App\Models\Enum\GoodEnum;
use App\Models\Good;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class GoodController extends Controller
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
            ->header('编辑')
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
            ->header('新建')
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
        $grid = new Grid(new Good);
        $grid->id('Id')->sortable();
        $grid->title('标题')->editable();;
        $grid->price('价格')->editable();;
        $grid->sales_volume('销量')->editable();;
        $states = [
            'on'  => ['value' => GoodEnum::GOOD_STATUS_TRUE, 'text' => '启用', 'color' => 'success'],
            'off' => ['value' => GoodEnum::GOOD_STATUS_FALSE, 'text' => '关闭', 'color' => 'danger'],
        ];
        $grid->status('状态')->switch($states);
        $grid->stock('库存')->editable();
        $grid->created_at('创建日期');
        // filter($callback)方法用来设置表格的简单搜索框
        $grid->filter(function ($filter) {

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
        $show = new Show(Good::findOrFail($id));

        $show->id('Id');
        $show->title('Title');
        $show->price('Price');
        $show->sales_volume('Sales volume');
        $show->describe('Describe');
        $show->status('Status');
        $show->stock('Stock');
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
        $form = new Form(new Good);

        $form->text('title', '标题');
        $form->decimal('price', '价格');
        $form->number('sales_volume', '销量');
        $form->editor('describe', '内容')->placeholder('请输入内容')->rules('required');
        $form->switch('status', '启用？')->default(GoodEnum::GOOD_STATUS_TRUE);
        $form->number('stock', '库存');
        $form->multipleImage('pictures','商品图片')->removable();
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

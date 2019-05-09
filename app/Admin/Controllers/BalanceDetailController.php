<?php

namespace App\Admin\Controllers;

use App\Models\BalanceDetail;
use App\Http\Controllers\Controller;
use App\Models\Enum\BalanceDetailEnum;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class BalanceDetailController extends Controller
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
            ->header('资金管理')
            ->description('用户资金列表')
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
        $grid = new Grid(new BalanceDetail);

        $grid->user()->mobile('用户');
        $grid->type('类型')->display(function ($type){
            return BalanceDetailEnum::getStatusName($type);
        });
        $grid->cash('金额');
        $grid->before_balance('发生前余额');
        $grid->after_balance('发生后余额');
        $grid->remark('备注');
        $grid->created_at('Created at');

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
        $show = new Show(BalanceDetail::findOrFail($id));

        $show->id('Id');
        $show->user_id('User id');
        $show->withdraw_id('Withdraw id');
        $show->type('Type');
        $show->cash('Cash');
        $show->before_balance('Before balance');
        $show->after_balance('After balance');
        $show->remark('Remark');
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
        $form = new Form(new BalanceDetail);

        $form->number('user_id', 'User id');
        $form->number('withdraw_id', 'Withdraw id');
        $form->text('type', 'Type');
        $form->decimal('cash', 'Cash')->default(0.00);
        $form->decimal('before_balance', 'Before balance')->default(0.00);
        $form->decimal('after_balance', 'After balance')->default(0.00);
        $form->textarea('remark', 'Remark');

        return $form;
    }
}

<?php

namespace App\Admin\Controllers;

use App\Models\Enum\WithdrawEnum;
use App\Models\Withdraw;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class WithdrawController extends Controller
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
            ->header('提现管理')
            ->description('提现申请列表')
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
        $grid = new Grid(new Withdraw);
        $grid->model()->orderBy('id','desc');
        $grid->id('Id');
        $grid->user()->mobile('手机号');
        $grid->cash('提现金额');
        $grid->account('提现账户');
        $grid->real_name('真实姓名');
        $grid->bank_of_deposit('银行开户行');
        $grid->status('状态')->display(function ($status){
            if($status == WithdrawEnum::INVALID) {
                $color = 'label-default';
            }elseif ($status == WithdrawEnum::APPLY){
                $color = 'label-danger';
            }else{
                $color = 'label-success';
            }
            return "<span class='label {$color}'>".WithdrawEnum::getStatusName($status)."</span>";
        });
        $grid->created_at('申请时间');
        $grid->filter(function ($filter) {
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            //手机号查询
            $status = [
                WithdrawEnum::INVALID => WithdrawEnum::getStatusName(WithdrawEnum::INVALID),
                WithdrawEnum::APPLY => WithdrawEnum::getStatusName(WithdrawEnum::APPLY),
                WithdrawEnum::SUCCESS => WithdrawEnum::getStatusName(WithdrawEnum::SUCCESS),
            ];
            $filter->equal('status','状态')->select($status);
            $filter->where(function ($query) {
                $query->whereHas('user', function ($query) {
                    $query->where('mobile', 'like', "%{$this->input}%");
                });

            }, '手机号');
            // 设置created_at字段的范围查询
            $filter->between('created_at', '创建日期')->datetime();
        });
        //禁用批量删除
        $grid->tools(function ($tools) {
            $tools->batch(function ($batch) {
                $batch->disableDelete();
            });
        });
        //关闭行操作 删除
        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableView();
            $actions->disableEdit();
            if($actions->row->status == WithdrawEnum::APPLY)
                $actions->append('<a href="/admin/withdraws/'.$actions->row->id.'/edit"><i class="fa fa-edit"></i></a>');
        });
        //禁用导出数据按钮
        $grid->disableExport();
        $grid->disableCreateButton();
        $grid->disableRowSelector();
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
        $show = new Show(Withdraw::findOrFail($id));

        $show->id('Id');
        $show->user_id('User id');
        $show->cash('Cash');
        $show->account('Account');
        $show->real_name('Real name');
        $show->bank_of_deposit('Bank of deposit');
        $show->status('Status');
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
        $form = new Form(new Withdraw);

        $form->select('status', '状态')->options(
            [
                WithdrawEnum::INVALID => WithdrawEnum::getStatusName(WithdrawEnum::INVALID),
                WithdrawEnum::SUCCESS => WithdrawEnum::getStatusName(WithdrawEnum::SUCCESS)
            ]
        )->required();
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
        $form->tools(function (Form\Tools $tools) {
            $tools->disableView();
            $tools->disableDelete();
        });
        return $form;
    }
}

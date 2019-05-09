<?php

namespace App\Admin\Controllers;

use App\Models\Enum\OrderEnum;
use App\Models\Express;
use App\Models\Good;
use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Models\User;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class OrderController extends Controller
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
            ->header('订单管理')
            ->description('订单列表')
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
            ->header('订单管理')
            ->description('发货')
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
        $grid = new Grid(new Order);
        $grid->model()->orderBy('created_at','desc');
        $grid->user_id('用户手机号')->display(function ($userId){
            $name = User::find($userId)->mobile;
            return "<span class='label label-info'>{$name}</span>";
        });
        $grid->good_id('商品')->display(function ($goodId){
            $name = Good::find($goodId)->title;
            return "<span class='label label-info'>{$name}</span>";
        });
        $grid->sn('订单号');
        $grid->quantity('数量');
        $grid->total('总金额');
        $grid->status('状态')->display(function ($status){
            if($status == OrderEnum::CANCEL) {
                $color = 'label-default';
            }elseif ($status == OrderEnum::PAYED){
                $color = 'label-danger';
            }elseif ($status == OrderEnum::PAYING){
                $color = 'label-info';
            }else{
                $color = 'label-success';
            }
            return "<span class='label {$color}'>".OrderEnum::getStatusName($status)."</span>";
        });
        $grid->address('地址')->display(function ($address){
            $address = \GuzzleHttp\json_decode($address,true);
            return '收件人:'.$address['to_name'].' 联系方式: '.$address['mobile'].' 地址：'.$address['address'].$address['detail'];
        });
        $grid->created_at('创建时间');
        $grid->filter(function ($filter) {
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            //手机号查询
            $status = [
                OrderEnum::CANCEL => OrderEnum::getStatusName(OrderEnum::CANCEL),
                OrderEnum::PAYING => OrderEnum::getStatusName(OrderEnum::PAYING),
                OrderEnum::PAYED => OrderEnum::getStatusName(OrderEnum::PAYED),
                OrderEnum::POSTED => OrderEnum::getStatusName(OrderEnum::POSTED),
                OrderEnum::FINISH => OrderEnum::getStatusName(OrderEnum::FINISH),
            ];
            $filter->equal('status','订单状态')->select($status);
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
        $show = new Show(Order::findOrFail($id));

        $show->id('Id');
        $show->user_id('User id');
        $show->good_id('Good id');
        $show->sn('Sn');
        $show->quantity('Quantity');
        $show->total('Total');
        $show->status('Status');
        $show->address('Address');
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
        $form = new Form(new Order);

        $form->select('status', '状态')->options([OrderEnum::POSTED => OrderEnum::getStatusName(OrderEnum::POSTED)])->required();
        $express = Express::all()->pluck('name','id')->all();
        $form->select('express_id', '快递')->options($express)->required();
        $form->text('express_code', '快递单号')->options($express)->required();
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

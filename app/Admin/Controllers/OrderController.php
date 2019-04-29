<?php

namespace App\Admin\Controllers;

use App\Models\Enum\OrderEnum;
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
                $color = 'label-danfer';
            }elseif ($status == OrderEnum::FINISH){
                $color = 'label-success';
            }else{
                $color = 'label-info';
            }
            return "<span class='label {$color}'>".OrderEnum::getStatusName($status)."</span>";
        });
        $grid->address('地址')->display(function ($address){
            $address = \GuzzleHttp\json_decode($address,true);
            return '收件人:'.$address['to_name'].' 联系方式: '.$address['mobile'].' 地址：'.$address['address'].$address['detail'];
        });
        $grid->created_at('创建时间');

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

        $form->number('user_id', 'User id');
        $form->number('good_id', 'Good id');
        $form->text('sn', 'Sn');
        $form->number('quantity', 'Quantity');
        $form->decimal('total', 'Total');
        $form->switch('status', 'Status');
        $form->text('address', 'Address');

        return $form;
    }
}

<?php

namespace App\Admin\Controllers;

use App\Models\Enum\BalanceDetailEnum;
use App\Models\User;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;

class UserController extends Controller
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
            ->header('用户管理')
            ->description('用户列表')
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
        $grid = new Grid(new User);

        $grid->mobile('手机号');
        $grid->inviter()->mobile('邀请者')->display(function ($mobile){
            return "<span class='label label-info'>".$mobile."</span>";
        });
        $grid->balance('余额')->display(function (){
            return "<a href='/admin/balance-details?032c4d992253e992bf713c4f1a9446d5={$this->mobile}' class='label label-success'>".$this->balance."</a>";
        });
        $grid->created_at('注册时间');

        $grid->filter(function ($filter) {
            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            $filter->equal('mobile','手机号');
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
            // append一个操作
            $actions->append("<a href='/admin/teams?id={$actions->row->id}'><i class='fa fa-users'></i>查看团队</a>");
            $actions->disableDelete();
            $actions->disableView();
            $actions->disableEdit();
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
        $show = new Show(User::findOrFail($id));

        $show->id('Id');
        $show->mobile('Mobile');
        $show->password('Password');
        $show->avatar('Avatar');
        $show->wx_oauth('Wx oauth');
        $show->invite_id('Invite id');
        $show->balance('Balance');
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
        $form = new Form(new User);

        $form->mobile('mobile', 'Mobile');
        $form->password('password', 'Password');
        $form->image('avatar', 'Avatar');
        $form->text('wx_oauth', 'Wx oauth');
        $form->number('invite_id', 'Invite id');
        $form->decimal('balance', 'Balance')->default(0.00);

        return $form;
    }
}

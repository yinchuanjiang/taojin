<?php

namespace App\Admin\Controllers;

use App\Models\Enum\OrderEnum;
use App\Models\Enum\UserEnum;
use App\Models\Order;
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
                $row->column(12, str_replace('<span class="pull-right dd-nodrag">','<span class="pull-right dd-nodrag" style="display: none">',$this->treeView()->render()));
            });
        });
    }


    protected function treeView()
    {
        return User::tree(function (Tree $tree) {
            if(request('mobile')) {
                $tree->query(function ($model) {
                    /** @var User $user */
                    $user = $model->where('mobile',request('mobile'))->first();
                    if($user) {
                        $undeless = $user->underless()->pluck('id')->toArray();
                        $undeless[] = $user->id;
                        return $model->whereIn('invite_id', $undeless)->orWhere('id',$user->id);
                    }
                });
            }
            $tree->disableCreate();
            $tree->disableSave();
            $tree->branch(function ($branch) {
                $first_assist = '<span style="color: red">一级奖励未触发</span>';
                if($branch['first_assist'] == UserEnum::FIRST_ASSIST_TRUE)
                    $first_assist = '<span style="color: green">一级奖励已触发('.$branch['first_assist_at'].')</span>';
                $second_assist = '<span style="color: red">二级奖励未触发</span>';
                if($branch['second_assist'] == UserEnum::SECOND_ASSIST_TRUE)
                    $second_assist = '<span style="color: green">二级奖励已触发('.$branch['second_assist_at'].')</span>';
                $order = Order::where('user_id',$branch['id'])->where('status','>=',OrderEnum::PAYED)->count();
                $is_buye = '<span style="color: red">未购物</span>';
                if($order)
                    $is_buye = '<span style="color: green">已购物</span>';
                return "{$branch['mobile']} - {$is_buye} - {$first_assist} - {$second_assist}";
            });
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
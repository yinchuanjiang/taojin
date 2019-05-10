<?php

namespace App\Admin\Controllers;

use App\Models\Config;
use App\Http\Controllers\Controller;
use App\Models\Enum\ConfigEnum;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ConfigController extends Controller
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
            ->header('系统配置')
            ->description('公司资料信息配置')
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
        $config = Config::find($id);
        if(in_array($config->name,['APP_HOME','USER_AGREEMENT'])){
            return $content
                ->header('Edit')
                ->description('description')
                ->body($this->form('config')->edit($id));
        }else if(in_array($config->name,['ANDROID_VERSION','IOS_VERSION'])){
            return $content
                ->header('Edit')
                ->description('description')
                ->body($this->form('version')->edit($id));
        }else{
            return $content
                ->header('Edit')
                ->description('description')
                ->body($this->form('help')->edit($id));
        }
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
        $grid = new Grid(new Config);

        $grid->name('配置名称')->display(function ($name){
            return ConfigEnum::get($name);
        });

        $grid->created_at('创建时间');
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
        $show = new Show(Config::findOrFail($id));

        $show->id('Id');
        $show->name('Name');
        $show->value('Value');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($type = 'version')
    {
        $form = new Form(new Config);
        if($type == 'version') {
            $form->text('version', '版本号')->rules('required');
            $form->text('url', '下载地址')->rules('required');
            $form->textarea('value', '版本说明')->placeholder('请输入内容')->rules('required');
        }else if($type == 'config'){
            $form->weditor('value', '配置值')->placeholder('请输入内容')->rules('required');
        }else{
            $form->textarea('value', '配置值')->placeholder('请输入内容')->rules('required');
        }
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

<?php

namespace App\Admin\Controllers;

use App\Blog;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class BlogController extends Controller
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
        $grid = new Grid(new Blog);

        //默认展开过滤查询面板
//        $grid->expandFilter();

        // 设置初始查询条件
        // 设置初始排序条件
        $grid->model()->orderBy('id', 'desc');

        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            // 在这里添加字段过滤器
            $filter->like('title', '标题');
        });

//        $grid->disableCreateButton();
//        $grid->disableActions();
//        $grid->disablePagination();
        $grid->disableRowSelector();
        $grid->disableExport();


        $grid->title('标题');
        $grid->updated_at('更新时间');
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
        $show = new Show(Blog::findOrFail($id));
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Blog);
        // 显示记录id
        $form->display('id', 'ID');

        $form->text('title','标题')->rules('required|max:100');
        $form->text('content','内容')->rules('required|max:100');

        // 忽略掉不需要保存的字段
//        $form->ignore(['column1', 'column2', 'column3']);

        $form->footer(function ($footer) {
            // 去掉`重置`按钮
//            $footer->disableReset();
            // 去掉`提交`按钮
//            $footer->disableSubmit();
            // 去掉`查看`checkbox
            $footer->disableViewCheck();
            // 去掉`继续编辑`checkbox
            $footer->disableEditingCheck();
            // 去掉`继续创建`checkbox
            $footer->disableCreatingCheck();

        });

        $form->tools(function (Form\Tools $tools) {
            // 去掉`列表`按钮
//            $tools->disableList();
            // 去掉`删除`按钮
//            $tools->disableDelete();
            // 去掉`查看`按钮
//            $tools->disableView();
            // 添加一个按钮, 参数可以是字符串, 或者实现了Renderable或Htmlable接口的对象实例
//            $tools->add('<a class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>&nbsp;&nbsp;delete</a>');
        });

        //保存前回调
//        $form->saving(function (Form $form) {
//        });

        //保存后回调
//        $form->saved(function (Form $form) {
//        });
        return $form;
    }
}

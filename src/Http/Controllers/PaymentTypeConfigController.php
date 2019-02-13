<?php

/**
 * Created by JoseChan/Admin/ControllerCreator.
 * User: admin
 * DateTime: 2019-01-01 15:33:28
 */

namespace JoseChan\Payment\Http\Controllers;

use JoseChan\Payment\Models\PaymentType;
use JoseChan\Payment\Models\PaymentTypeConfig;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class PaymentTypeConfigController extends Controller
{

    use HasResourceActions;

    public function index()
    {
        return Admin::content(function (Content $content) {

            //页面描述
            $content->header('配置项管理');
            //小标题
            $content->description('配置项列表');

            //面包屑导航，需要获取上层所有分类，根分类固定
            $content->breadcrumb(
                ['text' => '首页', 'url' => '/'],
                ['text' => '配置项管理', 'url' => '/payment_type_configs']
            );

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('配置项管理');
            $content->description('编辑');

            //面包屑导航，需要获取上层所有分类，根分类固定
            $content->breadcrumb(
                ['text' => '首页', 'url' => '/'],
                ['text' => '配置项管理', 'url' => '/payment_type_configs'],
                ['text' => '编辑']
            );

            $content->body($this->form()->edit($id));
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

            $content->header('配置项管理');
            $content->description('新增');

            //面包屑导航，需要获取上层所有分类，根分类固定
            $content->breadcrumb(
                ['text' => '首页', 'url' => '/'],
                ['text' => '配置项管理', 'url' => '/payment_type_configs'],
                ['text' => '新增']
            );

            $content->body($this->form());
        });
    }

    public function grid()
    {
        return Admin::grid(PaymentTypeConfig::class, function (Grid $grid) {

            $type = $this->getType();
            $grid->column("id","id")->sortable();
            $grid->column("type","支付类型")->using($type);
            $grid->column("key","配置键值");
            $grid->column("name","说明");
            $grid->column("created_at","创建时间")->sortable();
            $grid->column("updated_at","最近更新时间")->sortable();
            $grid->column("status","状态")->using([0=>"冻结",1=>"启用"]);


            //允许筛选的项
            //筛选规则不允许用like，且搜索字段必须为索引字段
            //TODO: 使用模糊查询必须通过搜索引擎，此处请扩展搜索引擎
            $grid->filter(function (Grid\Filter $filter){

                $filter->equal("id","id");
                $filter->equal("status","状态")->select([0=>"冻结",1=>"启用"]);



            });


        });
    }

    protected function form()
    {
        return Admin::form(PaymentTypeConfig::class, function (Form $form) {

            $form->display('id',"id");
            $form->select('type',"支付类型")->options($this->getType());
            $form->text('key',"配置键值")->rules("required|string");
            $form->text('name',"说明")->rules("required|string");
            $form->datetime('created_at',"创建时间");
            $form->datetime('updated_at',"最近更新时间");
            $form->select("status","状态")->options([0=>"冻结",1=>"启用"]);



        });
    }

    protected function getType()
    {
        $type = PaymentType::all();

        $type_options = [];
        foreach($type as $value)
        {
            $type_options[$value['id']] = $value['name'];
        }

        return $type_options;
    }
}
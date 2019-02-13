<?php

/**
 * Created by JoseChan/Admin/ControllerCreator.
 * User: admin
 * DateTime: 2019-01-01 15:29:24
 */

namespace JoseChan\Payment\Http\Controllers;

use JoseChan\Payment\Models\App;
use JoseChan\Payment\Models\PaymentAccount;
use JoseChan\Payment\Models\PaymentChannel;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class PaymentChannelController extends Controller
{

    use HasResourceActions;

    public function index()
    {
        return Admin::content(function (Content $content) {

            //页面描述
            $content->header('支付渠道管理');
            //小标题
            $content->description('支付渠道列表');

            //面包屑导航，需要获取上层所有分类，根分类固定
            $content->breadcrumb(
                ['text' => '首页', 'url' => '/'],
                ['text' => '支付渠道管理', 'url' => '/payment_channel']
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

            $content->header('支付渠道管理');
            $content->description('编辑');

            //面包屑导航，需要获取上层所有分类，根分类固定
            $content->breadcrumb(
                ['text' => '首页', 'url' => '/'],
                ['text' => '支付渠道管理', 'url' => '/payment_channel'],
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

            $content->header('支付渠道管理');
            $content->description('新增');

            //面包屑导航，需要获取上层所有分类，根分类固定
            $content->breadcrumb(
                ['text' => '首页', 'url' => '/'],
                ['text' => '支付渠道管理', 'url' => '/payment_channel'],
                ['text' => '新增']
            );

            $content->body($this->form());
        });
    }

    public function grid()
    {
        return Admin::grid(PaymentChannel::class, function (Grid $grid) {

            $account = $this->getAccount();
            $app = $this->getApp();
            $grid->column("id","id")->sortable();
            $grid->column("name","名称");
            $grid->column("account_id","账号")->using($account);
            $grid->column("app_id","应用")->using($app);
            $grid->column("created_at","创建时间")->sortable();
            $grid->column("updated_at","更新时间")->sortable();
            $grid->column("status","状态")->using([0=>"冻结",1=>"启用"]);


            //允许筛选的项
            //筛选规则不允许用like，且搜索字段必须为索引字段
            //TODO: 使用模糊查询必须通过搜索引擎，此处请扩展搜索引擎
            $grid->filter(function (Grid\Filter $filter) use($account, $app){

                $filter->equal("id","id");
                $filter->equal("account_id","账号")->select($account);
                $filter->equal("app_id","应用")->select($app);
                $filter->equal("status","状态")->select([0=>"冻结",1=>"启用"]);



            });


        });
    }

    protected function form()
    {
        return Admin::form(PaymentChannel::class, function (Form $form) {

            $form->display('id',"id");
            $form->text('name',"名称")->rules("required|string");
            $form->select('account_id',"账号")->options($this->getAccount());
            $form->select('app_id',"应用")->options($this->getApp());
            $form->datetime('created_at',"创建时间");
            $form->datetime('updated_at',"更新时间");
            $form->select("status","状态")->options([0=>"冻结",1=>"启用"]);

        });
    }

    protected function getAccount()
    {
        $options = PaymentAccount::all();

        $return = [];
        foreach($options as $value)
        {
            $return[$value['id']] = $value['name'];
        }

        return $return;
    }

    protected function getApp()
    {
        $options = App::all();

        $return = [];
        foreach($options as $value)
        {
            $return[$value['id']] = $value['name'];
        }

        return $return;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2019-06-18
 * Time: 17:57
 */

namespace JoseChan\Payment\Http\Controllers;

use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use JoseChan\Payment\Models\PaymentAccount;
use JoseChan\Payment\Models\PaymentAccountConfig;
use JoseChan\Payment\Models\PaymentTypeConfig;

class PaymentAccountConfigController
{
    use HasResourceActions;

    public function index($account_id)
    {
        return Admin::content(function (Content $content) use ($account_id){

            //页面描述
            $content->header('支付配置');
            //小标题
            $content->description('支付配置项');

            //面包屑导航，需要获取上层所有分类，根分类固定
            $content->breadcrumb(
                ['text' => '首页', 'url' => '/'],
                ['text' => '支付账号管理', 'url' => '/payment_accounts'],
                ['text' => '支付账号配置', 'url' => "/payment_accounts/{$account_id}/configs"]
            );

            $content->body($this->grid($account_id));
        });
    }

    public function edit($account_id, $config_id)
    {
        return Admin::content(function (Content $content) use ($account_id, $config_id) {

            list($method, $id) = explode("_", $config_id);

            if($method == "option"){
                $description = "添加";
                $content->body($this->form($account_id, $config_id));
            }else{
                $description = "编辑";
                $content->body($this->form($account_id, $config_id)->edit($id));
            }

            $content->header('微信自定义菜单');
            $content->description($description);

            //面包屑导航，需要获取上层所有分类，根分类固定
            $content->breadcrumb(
                ['text' => '首页', 'url' => '/'],
                ['text' => '支付账号管理', 'url' => '/payment_accounts'],
                ['text' => '支付账号配置', 'url' => "/payment_accounts/{$account_id}/configs"],
                ['text' => $description, ]
            );
        });
    }

    public function grid($account_id)
    {
        return Admin::grid(PaymentAccountConfig::class,function (Grid $grid){
            $grid->column("name","配置项描述");
            $grid->column("key","配置项标签");
            $grid->column("value","配置值");
        });
    }

    protected function form($account_id, $config_id = 0)
    {
        return Admin::form(PaymentAccountConfig::class, function (Form $form) use ($account_id, $config_id) {

            list($method, $id) = explode("_", $config_id);
            if($method == "option")
            {
                $option = PaymentTypeConfig::where("id", $id)->first();
                $key = $option->key;
            }else{
                $config = PaymentAccountConfig::where("id", $id)->first();

                $key = $config->key;
                $option = PaymentTypeConfig::where("key", $key)->first();
            }

            $name = $option->name;

            $form->display('id',"id");
            $form->hidden('account_id',"account_id")->default($account_id);
            $form->display('name',"配置项")->default($name);
            $form->text('key',"配置项标签")->value($key);
            $form->text('value',"配置值");

            $form->ignore('name');

        });
    }

    public function update($account_id, $id)
    {
        return $this->form($account_id, "config_".$id)->update($id);
    }

    public function store($account_id, $config_id)
    {
        return $this->form($account_id, $config_id)->store();
    }

    public function show($account_id, $config_id)
    {
        list($method, $id) = explode("_", $config_id);

        $option = PaymentTypeConfig::where("id", $id)->first();

        $key = $option->key;

        $config = PaymentAccountConfig::where(["key" => $key, "account_id" => $account_id])->first();

        $cid = $config->id;
        return $this->edit($account_id, "config_".$cid);
    }

}
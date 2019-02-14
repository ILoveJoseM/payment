<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use JoseChan\Payment\Models\PaymentType as PaymentTypeModel;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $parent = [
            "title" => "支付管理",
            "icon" => "fa-money",
        ];

        $menuModel = config('admin.database.menu_model');

        $parent_obj = $menuModel::create($parent);

        $parent_id = $parent_obj->id;

        $data = [
            [
                "title" => "支付账号管理",
                "parent_id" => $parent_id,
                "icon" => "fa-newspaper-o",
                "uri" => "/payment_accounts",
            ],
            [
                "title" => "支付渠道管理",
                "parent_id" => $parent_id,
                "icon" => "fa-cc-paypal",
                "uri" => "/payment_channel",
            ],
            [
                "title" => "支付参数管理",
                "parent_id" => $parent_id,
                "icon" => "fa-buysellads",
                "uri" => "/payment_type_configs",
            ],
            [
                "title" => "支付方式管理",
                "parent_id" => $parent_id,
                "icon" => "fa-bitcoin",
                "uri" => "/payment_types",
            ],
        ];

        foreach ($data as $datum){
            $menuModel::create($datum);
        }
    }
}

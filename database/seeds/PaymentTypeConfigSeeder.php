<?php

use Illuminate\Database\Seeder;
use JoseChan\Payment\Models\PaymentTypeConfig as Model;

class PaymentTypeConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                "type" => 1,
                "key" => "app_id",
                "name" => "公众号app_id"
            ],
            [
                "type" => 1,
                "key" => "app_secret",
                "name" => "公众号密钥"
            ],
            [
                "type" => 1,
                "key" => "mch_id",
                "name" => "商户号"
            ],
            [
                "type" => 1,
                "key" => "mch_secrete",
                "name" => "商户密钥"
            ]
        ];



        foreach ($data as $datum){
            Model::create($datum);
        }
    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use JoseChan\Payment\Models\PaymentType as PaymentTypeModel;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [[
            "name" => "微信公众号支付",
            "status" => 1
        ]];

        $obj = new PaymentTypeModel();

        foreach ($data as $datum){
            $obj->setRawAttributes($datum);

            $obj->save();
        }
    }
}

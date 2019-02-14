<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2019/1/1
 * Time: 16:43
 */

namespace JoseChan\Api\Controllers;


use JoseChan\Api\Logic\PaymentLogic;
use \Illuminate\Http\Request;

class PaymentController extends BaseController
{

    public function createOrder(Request $request)
    {
        $data = $request->all();

        $this->validate($data, [
            "order_id" => "required|string",
            "app_id" => "required|integer",
            "amount" => "required|numeric"
        ]);

        return $this->response(
            PaymentLogic::getInstance()->createOrder(
                $data['app_id'],
                $data['order_id'],
                $data['amount'],
                isset($data['info'])?$data['info'] : ""
            )
        );

    }

    public function wechatOfficial(Request $request){

        $data = $request->all();

        $this->validate($data, [
            "channel_id" => "required|integer",
            "payment_id" => "required|string",
            "open_id" => "required|string"
        ]);

        return $this->response(
            PaymentLogic::getInstance()->wechatOfficial(
                $data['channel_id'],
                $data['payment_id'],
                $data['open_id']
            )
        );
    }
}
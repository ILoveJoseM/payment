<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2019/1/1
 * Time: 17:00
 */

namespace JoseChan\Payment\Api\Logic;


use JoseChan\Payment\Api\Constant\ErrorCode;
use JoseChan\Payment\Services\Payment\PaymentService;

class PaymentLogic extends Logic
{

    public function createOrder($app_id, $order_id, $amount, $info = "")
    {
        $sdk = new PaymentService();

        $result = $sdk->createOrder($app_id, $order_id, $amount, $info);

        if (!$result) {
            ErrorCode::error(ErrorCode::APP_NOT_EXISTS);
        }

        return ['payment_id' => $result];

    }

    public function wechatOfficial($channel_id, $payment_id, $openid)
    {
        $sdk = new PaymentService();

        $result = $sdk->wechatOfficial($channel_id, $payment_id, $openid);

        return $result;
    }

    public function notify($pay_sn)
    {
        $sdk = new PaymentService();

        $result = $sdk->notify($pay_sn);

        return $result;
    }
}

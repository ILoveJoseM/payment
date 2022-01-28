<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2019/1/1
 * Time: 16:43
 */

namespace JoseChan\Payment\Api\Controllers;


use JoseChan\Payment\Api\Constant\ErrorCode;
use JoseChan\Payment\Api\Logic\PaymentLogic;
use \Illuminate\Http\Request;
use JoseChan\Payment\Models\PaymentAccountConfig;
use JoseChan\Payment\Models\PaymentChannel;
use JoseChan\Payment\Models\PaymentTrade;
use Runner\NezhaCashier\Cashier;

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
                isset($data['info']) ? $data['info'] : ""
            )
        );

    }

    public function wechatOfficial(Request $request)
    {

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

    public function notify()
    {
//        $config = config("payment");
        $pay = new Cashier("wechat_official", []);

        $request = $pay->convertNotificationToArray($pay->receiveNotificationFromRequest());

        $payment_id = isset($request['order_id']) ? $request['order_id'] : null;

        if (empty($payment_id)) {
            echo $pay->fail();
            die();
        }

        //交易单
        $payment = PaymentTrade::where("payment_id", $payment_id)->first();

        if (empty($payment)) {
            ErrorCode::error(ErrorCode::PAYMENT_NOT_EXISTS);
        }

        //付款渠道
        $channel = PaymentChannel::find($payment->channel_id)->first();

        if (empty($channel)) {
            ErrorCode::error(ErrorCode::CHANNEL_NOT_EXISTS);
        }

        //取得收款账号的配置项
        /** @var \JoseChan\Payment\Collection\PaymentAccountConfig $account_configs */
        $account_configs = PaymentAccountConfig::query()->where(["account_id" => $channel->account_id])->get();
        $config = $account_configs->formatConfig();

        $pay = new Cashier("wechat_official", $config);

        $form = $pay->notify("charge");

        if ($form->get("status") === "paid") {
            if (PaymentLogic::getInstance()->notify($form->get('order_id'))) {
                echo $pay->success();
                die();
            }
        }

    }
}

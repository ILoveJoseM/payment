<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2019/1/1
 * Time: 16:10
 */

namespace JoseChan\Payment\Services\Payment;


use JoseChan\Payment\Api\Constant\ErrorCode;
use JoseChan\Payment\Models\App;
use JoseChan\Payment\Models\PaymentAccountConfig;
use JoseChan\Payment\Models\PaymentChannel;
use JoseChan\Payment\Models\PaymentTrade;
use JoseChan\Payment\Service\Service;
use Runner\NezhaCashier\Cashier;
use Runner\NezhaCashier\Utils\Amount;

class PaymentService extends Service
{
    public function createOrder($app_id, $order_id, $amount, $info = "")
    {
        $app = App::find($app_id);

        if(empty($app)){
            return false;
        }

        $payment = PaymentTrade::where([
            "order_id"=>$order_id,
            "app_id" => $app_id
        ])->first();

        if(!empty($payment) && $payment->status === 'ready'){
            return $payment->payment_id;
        }

        if(!empty($payment)){
            $payment->payment_id = $this->getPaymentId();
            $payment->status = "ready";
        }else{
            $payment = new PaymentTrade();

            $payment->setRawAttributes([
                "payment_id" => $this->getPaymentId(),
                "order_id" => $order_id,
                "app_id" => $app_id,
                "amount" => $amount,
                "tax_amount" => 0,
                "extra" => $info
            ]);
        }

        if($payment->save()){
            return $payment->payment_id;
        }

        return false;
    }

    public function wechatOfficial($channel_id, $payment_id, $openid)
    {
        //付款渠道
        $channel = PaymentChannel::find($channel_id)->first();

        if(empty($channel))
        {
            ErrorCode::error(ErrorCode::CHANNEL_NOT_EXISTS);
        }

        //交易单
        $payment = PaymentTrade::where("payment_id", $payment_id)->first();

        if(empty($payment))
        {
            ErrorCode::error(ErrorCode::PAYMENT_NOT_EXISTS);
        }

        //取得收款账号的配置项
        $account_configs = PaymentAccountConfig::where(["account_id" => $channel->account_id]);

        $config = [];

        $account_configs->each(function($item, $key) use (&$config)
        {
            $config[$item['key']] = $item['value'];
        });

        //创建交易
        $pay = new Cashier("wechat_official", $config);

        $order = [
            "order_id" => $payment_id,
            "amount" => Amount::dollarToCent($payment->amount),
            "subject" => $payment->extra?:"订单号".$payment->order_id,
            'currency' => 'CNY',
            'description' => $payment->extra,
            'extras' => ['open_id' => $openid],
//            'return_url' => $return_url,
        ];

        $params = $pay->charge($order)->get("parameters");
        if(!empty($params)){

            $payment->status = "apply";
            $payment->applied_at = date("Y-m-d H:i:s");
            $payment->save();

            $params['timeStamp'] = (string)$params['timeStamp'];
            return ["jsApiParameters" => json_encode($params, JSON_UNESCAPED_UNICODE)];
        }

    }

    protected function getPaymentId()
    {
        return microtime(true)*1000000;
    }
}
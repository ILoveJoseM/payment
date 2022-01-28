<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2019-06-24
 * Time: 17:51
 */

namespace JoseChan\Payment\Collection;



use Illuminate\Database\Eloquent\Collection;

class PaymentAccountConfig extends Collection
{
    public function formatConfig(){

        $config = [];

        $this->each(function($item, $key) use (&$config)
        {
            $config[$item['key']] = $item['value'];
        });

        return $config;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2019/1/1
 * Time: 11:17
 */

namespace JoseChan\Payment\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Request;

class PaymentAccountConfig extends Model
{
    public $incrementing = false;
    protected $keyType = "string";

    public function paginate()
    {
        $account_id = Request::segment(3);

        $account = PaymentAccount::where("id", $account_id)->first();

        $type = $account->type;

        $options = PaymentTypeConfig::where("type",$type)->get()->toArray();

        $account_configs = PaymentAccountConfig::where("account_id", $account_id)->get()->toArray();

        $config = [];
        foreach ($account_configs as $account_config)
        {
            $config[$account_config['key']] = ["id" => $account_config['id'],"value" => $account_config['value']];
        }

        foreach($options as &$option)
        {
            if(isset($config[$option['key']]))
            {
                $option['id'] = "config_".$config[$option['key']]['id'];
                $option['value'] = $config[$option['key']]['value'];
            }else{
                $option['id'] = "option_".$option['id'];
                $option['value'] = "未配置";
            }
        }


        $movies = static::hydrate($options);

        $paginator = new LengthAwarePaginator($movies, 1, 1);

        $paginator->setPath(url()->current());

        return $paginator;

    }

    public static function with($relations)
    {
        return new static;
    }
}
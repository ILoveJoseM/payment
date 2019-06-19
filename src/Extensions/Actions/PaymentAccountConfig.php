<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2019/1/25
 * Time: 22:22
 */

namespace JoseChan\Payment\Extensions\Actions;


use Illuminate\Contracts\Support\Renderable;

class PaymentAccountConfig implements Renderable
{
    protected $resource;
    protected $key;

    public function __construct($resource, $key)
    {
        $this->resource = $resource;
        $this->key = $key;
    }

    public function render()
    {
        $uri = url("/admin/payment_account_configs/{$this->key}/configs");

        return <<<EOT
<a href="{$uri}" title="支付配置">
    <i class="fa fa-cog"></i>
</a>
EOT;
    }

    public function __toString()
    {
        return $this->render();
    }
}
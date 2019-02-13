<?php

namespace JoseChan\Payment;

use Encore\Admin\Extension;

class Payment extends Extension
{
    public $name = 'payment';

    public $views = __DIR__.'/../resources/views';

    public $assets = __DIR__.'/../resources/assets';

    public $menu = [
        'title' => 'Payment',
        'path'  => 'payment',
        'icon'  => 'fa-gears',
    ];
}
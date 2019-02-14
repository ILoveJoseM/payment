<?php

use \Illuminate\Support\Facades\Route;
use \Illuminate\Routing\Router;

Route::namespace("\JoseChan\Payment\Http\Controllers")->group(function (Router $router)
{
    $router->resource('/apps',  "AppController");
    $router->resource('/payment_accounts', 'PaymentAccountController');
    $router->resource('/payment_channel', 'PaymentChannelController');
    $router->resource('/payment_type_configs', 'PaymentTypeConfigController');
    $router->resource('/payment_types', 'PaymentTypeController');
});
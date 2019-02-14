<?php

function (Router $router) {

    $router->resource('/apps', \JoseChan\Payment\Http\Controllers\AppController::class);
    $router->resource('/payment_accounts', \JoseChan\Payment\Http\Controllers\PaymentAccountController::class);
    $router->resource('/payment_channel', \JoseChan\Payment\Http\Controllers\PaymentChannelController::class);
    $router->resource('/payment_type_configs', \JoseChan\Payment\Http\Controllers\PaymentTypeConfigController::class);
    $router->resource('/payment_types', \JoseChan\Payment\Http\Controllers\PaymentTypeController::class);
}
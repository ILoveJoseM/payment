<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2019/2/14
 * Time: 10:48
 */

use \Illuminate\Support\Facades\Route;

Route::post("/", "PaymentController@createOrder");
Route::get("/wechat_official", "PaymentController@wechatOfficial");
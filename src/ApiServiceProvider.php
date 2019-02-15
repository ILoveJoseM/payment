<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2019/2/14
 * Time: 10:55
 */

namespace JoseChan\Payment;


use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->booted(function(){

            Route::prefix('api/payment')
                ->middleware('api')
                ->namespace("JoseChan\Payment\Api\Controllers")
                ->group(__DIR__.'/../routes/api.php');

        });
    }
}
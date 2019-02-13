<?php

namespace JoseChan\Payment;

use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot(Payment $extension)
    {
        if (! Payment::boot()) {
            return ;
        }

        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, 'payment');
        }

        if ($this->app->runningInConsole() && $assets = $extension->assets()) {
            $this->publishes(
                [$assets => public_path('vendor/jose-chan/payment')],
                'payment'
            );
        }

        $this->app->booted(function () {
            Payment::routes(__DIR__.'/../routes/web.php');
        });
    }
}
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Pattern\Cart\Cart;
use App\Shipping\Types\International;
use Illuminate\Support\Facades\Schema;
// use App\Payment\PaymentHandler;
// use Stripe\Stripe;
// use App\Pattern\Cart\Payments\Gateway;
// use App\Pattern\Cart\Payments\Gateways\StripeGateway;


class AppServiceProvider extends ServiceProvider
{
    protected $client;
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);
        // Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Cart::class, function ($app) {
            if ($app->auth->user()) {
                $app->auth->user()->load([
                  'cart.stock'
                ]);
            }

            return new Cart($app->auth->user());
        });

        // $this->app->bind(
        //     'App\Payment\Contract\PaymentContract',
        //     'App\Payment\XenditPayment'
        // );

        // $this->app->singleton(Gateway::class, function(){
        //   return new StripeGateway();
        // });

    }
}

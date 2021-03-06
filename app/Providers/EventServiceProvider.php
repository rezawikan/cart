<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Orders\OrderCreated' => [
            'App\Listeners\Order\EmptyCart',
            'App\Listeners\Order\ProcessPayment',
        ],


        'App\Events\Orders\OrderPaymentFailed' => [
          'App\Listeners\Order\MarkOrderPaymentFailed'
        ],

        'App\Events\Orders\OrderPending' => [
          'App\Listeners\Order\MarkOrderPending'
        ],

        'App\Events\Orders\OrderProcess' => [
          'App\Listeners\Order\MarkOrderProcessing'
        ],

        'App\Events\Orders\OrderCompleted' => [
          'App\Listeners\Order\AddCashflow',
          'App\Listeners\Order\MarkOrderCompleted'
        ],

        'App\Events\ReturnCreate\ReturnCreate' => [
          'App\Listeners\ReturnCreate\UpdateOrder',
          'App\Listeners\ReturnCreate\CreateReturn',
        ],

        'App\Events\ReturnUpdate\ReturnUpdate' => [
          'App\Listeners\ReturnUpdate\UpdateOrder',
          'App\Listeners\ReturnUpdate\UpdateVariationOrder'
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}

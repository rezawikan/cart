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
            'App\Listeners\Order\ProcessPaymanet',
        ],


        'App\Events\Orders\OrderPaymentFailed' => [
          'App\Listeners\Order\MarkOrderPaymentFailed'
        ],

        'App\Events\Orders\OrderPaid' => [
          'App\Listeners\Order\MarkOrderProcessing'
        ],

        'App\Events\Returns\ReturnProduct' => [
          'App\Listeners\Returns\UpdateProductOrder',
          'App\Listeners\Returns\CreateReturnOrder',
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

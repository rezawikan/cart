<?php

namespace App\Listeners\Order;

use App\Exceptions\PaymentFailedException;
use App\Events\Orders\OrderCreated;
use App\Events\Orders\OrderPaymentFailed;
use App\Events\Orders\OrderPaid;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Pattern\Cart\Payments\Gateway;

class ProcessPaymanet implements ShouldQueue
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  OrderCreated  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        $order = $event->order;

        try {
              switch ($event->order->paymentMethod->type) {
                case 'Cash':
                  event(new OrderPaid($order));
                  break;

                default:
                  // code...
                  break;
              }


        } catch (PaymentFailedException $e) {
              event(new OrderPaymentFailed($order));
        }


    }
}

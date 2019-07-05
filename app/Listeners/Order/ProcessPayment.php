<?php

namespace App\Listeners\Order;

use App\Events\Orders\OrderPending;
use App\Events\Orders\OrderCreated;
use App\Events\Orders\OrderCompleted;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\Orders\OrderPaymentFailed;
use App\Exceptions\PaymentFailedException;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessPayment
{

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
              switch ($order->paymentMethod->type) {
                case 'Cash':
                  event(new OrderCompleted($order));
                  break;

                case 'Bank Transfer':
                  event(new OrderProcess($order));
                  break;

                default:
                  event(new OrderPending($order));
                  break;
              }

        } catch (PaymentFailedException $e) {
              event(new OrderPaymentFailed($order));
        }
    }
}

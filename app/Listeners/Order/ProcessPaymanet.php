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

    protected $gateway;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Gateway $gateway)
    {
        $this->gateway = $gateway;
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
              $this->gateway->withUser($order->user)
                 ->getCustomer()
                 ->charge(
                   $order->paymentMethod, $order->total
                 );

              event(new OrderPaid($order));
        } catch (PaymentFailedException $e) {
              event(new OrderPaymentFailed($order));
        }


    }
}

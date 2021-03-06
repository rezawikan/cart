<?php

namespace App\Listeners\Order;

use App\Models\Order;
use App\Events\Orders\OrderPaymentFailed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MarkOrderPaymentFailed
{

    /**
     * Handle the event.
     *
     * @param  OrderPaymentFailed  $event
     * @return void
     */
    public function handle(OrderPaymentFailed $event)
    {
        $event->order->update([
          'status' => Order::PAYMENT_FAILED
        ]);
    }
}

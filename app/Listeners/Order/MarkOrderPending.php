<?php

namespace App\Listeners\Order;

use App\Models\Order;
use App\Events\Orders\OrderPending;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MarkOrderPending
{

    /**
     * Handle the event.
     *
     * @param  OrderPending  $event
     * @return void
     */
    public function handle(OrderPending $event)
    {
        $event->order->update([
          'status' => Order::PENDING
        ]);
    }
}

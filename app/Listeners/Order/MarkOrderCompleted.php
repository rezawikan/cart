<?php

namespace App\Listeners\Order;

use App\Models\Order;
use App\Events\Orders\OrderCompleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MarkOrderCompleted
{

    /**
     * Handle the event.
     *
     * @param  OrderCash  $event
     * @return void
     */
    public function handle(OrderCompleted $event)
    {
        $event->order->update([
          'status' => Order::COMPLETED
        ]);
    }
}

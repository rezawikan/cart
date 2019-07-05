<?php

namespace App\Listeners\Order;

use App\Models\Order;
use App\Events\Orders\OrderPaid;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MarkOrderProcessing
{

    /**
     * Handle the event.
     *
     * @param  OrderPaid  $event
     * @return void
     */
    public function handle(OrderPaid $event)
    {
      $event->order->update([
        'status' => Order::PROCESSING
      ]);
    }
}

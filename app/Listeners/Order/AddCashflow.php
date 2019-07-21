<?php

namespace App\Listeners\Order;

use App\Models\Cashflow;
use App\Events\Orders\OrderCompleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddCashflow
{

    /**
     * Handle the event.
     *
     * @param  OrderCompleted  $event
     * @return void
     */
    public function handle(OrderCompleted $event)
    {
        $latest = Cashflow::latest()->first();
        Cashflow::create([
          'type'    => 'debit',
          'amount'  => $event->order->revenue(),
          'info'    => 'Revenue from order id : '.$event->order->id,
          'total'   => ($latest['total'] ? $latest['total'] : 0) + $event->order->revenue(), //only first time
        ]);

    }
}

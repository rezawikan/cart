<?php

namespace App\Listeners\ReturnCreate;

use App\Models\Cashflow;
use App\Events\ReturnCreate\ReturnCreate;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateOrder
{

    /**
     * Handle the event.
     *
     * @param  ReturnCreate  $event
     * @return void
     */
    public function handle(ReturnCreate $event)
    {
        $beforeRevenue = $event->order->revenue() ? $event->order->revenue() : 0;
        $beforeTotal   = $event->order->total ? $event->order->total : 0;

        $event->order->update([
          'base_subtotal' => $event->order->newBaseSubTotal(),
          'subtotal' => $event->order->newSubTotal(),
          'total' => $event->order->newTotal()
        ]);

        $latest = Cashflow::latest()->first();
        Cashflow::create([
          'type'    => 'credit',
          'amount'  => $event->order->revenue(),
          'info'    => 'Credit Return from order id : '.$event->order->id,
          'total'   => ($latest['total'] ? $latest['total'] : 0) - $event->order->revenue(), //only first time
        ]);
    }
}

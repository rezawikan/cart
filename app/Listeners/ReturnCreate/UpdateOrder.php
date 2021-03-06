<?php

namespace App\Listeners\ReturnCreate;

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
        $event->order->update(['discount' => $event->order->discount - $event->discount]);
        $event->order->update([
          'base_subtotal' => $event->order->fresh()->newBaseSubTotal(),
          'subtotal' => $event->order->fresh()->newSubTotal(),
          'total' => $event->order->fresh()->newTotal(),
        ]);
    }
}

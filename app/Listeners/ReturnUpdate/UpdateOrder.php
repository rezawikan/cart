<?php

namespace App\Listeners\ReturnUpdate;

use App\Events\ReturnUpdate\ReturnUpdate;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateOrder
{

    /**
     * Handle the event.
     *
     * @param  ReturnUpdate  $event
     * @return void
     */
    public function handle(ReturnUpdate $event)
    {
        $event->returns->order()->update([
          'base_subtotal' => $event->returns->order->newBaseSubTotal(),
          'subtotal' => $event->returns->order->newSubTotal(),
          'total' =>   $event->returns->order->newTotal()
        ]);
    }
}

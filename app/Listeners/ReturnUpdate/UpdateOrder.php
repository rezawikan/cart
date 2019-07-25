<?php

namespace App\Listeners\ReturnUpdate;

use App\Models\Returns;
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
          'base_subtotal' => $event->returns->order->fresh()->newBaseSubTotal(),
          'subtotal'      => $event->returns->order->fresh()->newSubTotal(),
          'total'         => $event->returns->order->fresh()->newTotal(),
          // 'discount'      => ($event->returns->order->discount + $returnDiscount) - $event->request->discount
          // // 8000 + 3000  - 3000
        ]);
    }
}

<?php

namespace App\Listeners\ReturnUpdate;

use App\Events\ReturnUpdate\ReturnUpdate;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateVariationOrder
{
    /**
     * Handle the event.
     *
     * @param  ReturnUpdate  $event
     * @return void
     */
    public function handle(ReturnUpdate $event)
    {
        $variantOrder = $event->returns->order->products->where('pivot.product_variation_id', $event->request->product_variation_id)->first();
        $event->returns->order->products()->updateExistingPivot($variantOrder->id, [
          'quantity' => ($variantOrder->pivot->quantity + $event->returns->quantity) - $event->request->quantity,
          'status'   => $event->request->status
        ]);
    }
}

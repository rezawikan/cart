<?php

namespace App\Listeners\ReturnUpdate;

use App\Models\Cashflow;
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

        $currOrder    = ($variantOrder->pivot->quantity * $variantOrder->pivot->original_price) - $event->returns->discount;
        $currReturn   = ($event->returns->quantity * $event->returns->original_price) - $event->returns->discount;
        $newRequest   = ($event->request->quantity * $event->request->original_price) - $event->request->discount;

        if ($newRequest > $currReturn) {
            Cashflow::create([
              'type'    => 'credit',
              'amount'  => $newRequest - $currReturn,
              'info'    => 'Update Return from order id : '.$event->returns->order->id,
              'total'   => (empty($latest) ? 0 : $latest->total) - ($newRequest - $currReturn) //only first time
            ]);
        } else if ($newRequest < $currReturn) {
            Cashflow::create([
              'type'    => 'debit',
              'amount'  => $currReturn - $newRequest,
              'info'    => 'Update Return from order id : '.$event->returns->order->id,
              'total'   => (empty($latest) ? 0 : $latest->total) + ($currReturn - $newRequest) //only first time
            ]);
        }
    }
}

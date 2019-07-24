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

        $before  = ($variantOrder->quantity * $variantOrder->original_price) - $variantOrder->discount;
        $after   = ($event->returns->fresh()->quantity * $event->returns->fresh()->original_price) - $event->returns->fresh()->discount;
        $credit  = $before - $after;
        $debit   = $after - $before;
        $latest  = Cashflow::latest()->first();

        if ($event->returns->fresh()->quantity > $variantOrder->quantity) {
            Cashflow::create([
              'type'    => 'credit',
              'amount'  => $credit,
              'info'    => 'Update Return from order id : '.$event->returns->order->id,
              'total'   => (empty($latest) ? 0 : $latest->total) - $credit //only first time
            ]);
        } else {
            Cashflow::create([
              'type'    => 'credit',
              'amount'  => $debit,
              'info'    => 'Update Return from order id : '.$event->returns->order->id,
              'total'   => (empty($latest) ? 0 : $latest->total) - $debit //only first time
            ]);
        }
    }
}

<?php

namespace App\Listeners\ReturnUpdate;

use App\Models\Returns;
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
        $dataReturnFilter     = Returns::whereNotIn('id',[$event->returns->id])->where('order_id', $event->returns->order->id)->get();
        $returnDiscountFilter = $dataReturnFilter->sum(function($return) {
          return $return->discount;
        }); // 5000

        // 5000 + 2000
        $newReturn = $returnDiscountFilter + $event->request->discount; //7000

        $dataReturn     = Returns::where('order_id', $event->returns->order->id)->get();
        $returnDiscount =  $dataReturn->sum(function($return) {
          return $return['discount'];
        }); // 6000


        // (4000 + 6000) - 7000 = 3000
        $discount = ($event->returns->order->discount + $returnDiscount) - $newReturn;

        $event->returns->order()->update([
          'discount'      => $discount
        ]);

        // Update Variation Order
        $variantOrder = $event->returns->order->products->where('pivot.product_variation_id', $event->request->product_variation_id)->first();
        $event->returns->order->products()->updateExistingPivot($variantOrder->id, [
          'quantity' => ($variantOrder->pivot->quantity + $event->returns->quantity) - $event->request->quantity,
          'status'   => $event->request->status
        ]);

        // compare total order and return
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

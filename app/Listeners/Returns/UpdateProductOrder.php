<?php

namespace App\Listeners\Returns;

use App\Events\Returns\ReturnProduct;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateProductOrder
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ReturnProduct  $event
     * @return void
     */
    public function handle(ReturnProduct $event)
    {
      $event->order->update([
        'base_subtotal' => $event->order->newBaseSubTotal(),
        'subtotal' => $event->order->newSubTotal(),
        'total' => $event->order->newTotal()
      ]);
    }
}

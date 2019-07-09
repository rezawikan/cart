<?php

namespace App\Listeners\Order;

use App\Models\USer;
use App\Pattern\Cart\Cart;
use App\Events\Orders\OrderCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmptyCart
{

    /**
     * Handle the event.
     *
     * @param  OrderCreated  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        $user = User::find($event->order->user_id);
        $cart = new Cart($user);

        $cart->empty();
    }
}

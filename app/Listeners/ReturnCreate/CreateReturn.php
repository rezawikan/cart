<?php

namespace App\Listeners\ReturnCreate;

use Carbon\Carbon;
use App\Models\Returns;
use App\Models\Cashflow;
use App\Events\ReturnCreate\ReturnCreate;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateReturn
{
    /**
     * Handle the event.
     *
     * @param  ReturnCreate  $event
     * @return void
     */
    public function handle(ReturnCreate $event)
    {
        $total = collect($event->returns)->sum(function($return) {
          return ($return['original_price'] * $return['quantity']) - $return['discount'];
        });

        $latest = Cashflow::latest()->first();
        Cashflow::create([
          'type'    => 'credit',
          'amount'  => $total,
          'info'    => 'Credit Return from order id : '.$event->order->id,
          'total'   => (empty($latest) ? 0 : $latest->total) - $total //only first time
        ]);

        $returns = collect($event->returns)->map(function($return){
          return array_merge($return, [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
          ]);
        })->toArray();
        Returns::insert($returns);
    }
}

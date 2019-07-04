<?php

namespace App\Listeners\Returns;

use App\Events\Returns\ReturnProduct;
use App\Models\Returns;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateReturnOrder
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
        $returns = collect($event->returns)->map(function($return){
          return array_merge($return, [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
          ]);
        })->toArray();

        Returns::insert($returns);
    }
}

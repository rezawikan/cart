<?php

namespace App\Listeners\ReturnCreate;

use Carbon\Carbon;
use App\Models\Returns;
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
        $returns = collect($event->returns)->map(function($return){
          return array_merge($return, [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
          ]);
        })->toArray();
        Returns::insert($returns);
    }
}

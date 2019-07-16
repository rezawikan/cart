<?php

namespace App\Events\ReturnUpdate;

use App\Models\Returns;
use Illuminate\Http\Request;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ReturnUpdate
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $returns;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Request $request, Returns $returns)
    {
        $this->request = $request;
        $this->returns = $returns;
    }
}

<?php

namespace App\Events\ReturnCreate;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ReturnCreate
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $returns;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Order $order, $returns)
    {
        $this->order   = $order;
        $this->returns = $returns;
    }
}

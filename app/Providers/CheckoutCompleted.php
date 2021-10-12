<?php

namespace App\Providers;

use App\Models\Order;
use Illuminate\Foundation\Events\Dispatchable;

class CheckoutCompleted
{
    use Dispatchable;

    public $order;

    /**
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return [];
    }
}

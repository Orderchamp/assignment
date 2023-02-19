<?php

namespace App\Domain\Order\Events;

use App\Domain\Order\Models\OrderItem;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderItemCreated
{
    use Dispatchable, SerializesModels;

    public OrderItem $orderItem;
    public int $cartItemId;

    public function __construct(OrderItem $orderItem, int $cartItemId)
    {
        $this->orderItem = $orderItem;
        $this->cartItemId = $cartItemId;
    }
}

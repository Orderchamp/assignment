<?php

namespace App\Domain\Order\Services;

use App\Domain\Order\Models\Order;
use Illuminate\Database\Eloquent\Collection;

interface OrderItemServiceInterface
{
    public function createOrderItemsFromCartItems(Collection $cartItems, Order $order): void;
}

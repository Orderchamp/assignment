<?php

namespace App\Domain\Order\Services;

use App\Domain\Order\Events\OrderItemCreated;
use App\Domain\Order\Models\Order;
use App\Domain\Order\Models\OrderItem;
use Illuminate\Database\Eloquent\Collection;

class OrderItemService implements OrderItemServiceInterface
{
    public function createOrderItemsFromCartItems(Collection $cartItems, Order $order): void
    {
        foreach ($cartItems as $cartItem) {

            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $cartItem['product_id'];
            $orderItem->quantity = $cartItem['quantity'];
            $orderItem->price = $cartItem['price'];
            $orderItem->save();

            event(new OrderItemCreated($orderItem, $cartItem['id']));
        }
    }
}


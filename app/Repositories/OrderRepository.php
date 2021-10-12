<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\Order;
use App\Models\User;

class OrderRepository implements OrderRepositoryInterface
{
    public function create(Cart $cart, User $user): Order
    {
        return Order::create([
            'cart_id' => $cart->id,
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_address' => $user->address,
        ]);
    }
}

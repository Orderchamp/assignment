<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\Order;
use App\Models\User;

interface OrderRepositoryInterface
{
    /**
     * Create an order from a cart
     */
    public function create(Cart $cart, User $user): Order;
}

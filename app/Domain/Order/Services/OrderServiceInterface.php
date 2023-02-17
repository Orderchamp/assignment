<?php

namespace App\Domain\Order\Services;

use App\Domain\Order\Models\Order;

interface OrderServiceInterface
{
    public function createOrder(array $orderData, array $cartItems, array $orderContactInfo): Order;
}

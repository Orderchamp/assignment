<?php

namespace App\Domain\Order\Services;

use App\Domain\Exceptions\CannotApplyDiscountException;
use App\Domain\Exceptions\OrderQuantityMoreThanStockException;
use App\Domain\Exceptions\ProductOutOfStockException;
use App\Domain\Order\Models\Order;
use App\Http\Requests\CheckoutRequest;

interface OrderServiceInterface
{
    /**
     * @param CheckoutRequest $request
     * @return Order
     *
     * @throws ProductOutOfStockException
     * @throws OrderQuantityMoreThanStockException
     * @throws CannotApplyDiscountException
     */
    public function createOrder(CheckoutRequest $request): Order;
}

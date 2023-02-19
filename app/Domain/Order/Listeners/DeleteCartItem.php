<?php

namespace App\Domain\Order\Listeners;

use App\Domain\Cart\Services\CartItemServiceInterface;
use App\Domain\Order\Events\OrderItemCreated;

class DeleteCartItem
{
    protected CartItemServiceInterface $cartItemService;

    public function __construct(CartItemServiceInterface $cartItemService)
    {
        $this->cartItemService = $cartItemService;
    }

    public function handle(OrderItemCreated $event): void
    {
        $this->cartItemService->deleteCartItem($event->cartItemId);
    }
}


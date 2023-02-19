<?php

namespace App\Domain\Cart\Services;

use Illuminate\Database\Eloquent\Collection;

interface CartItemServiceInterface
{
    public function getAllCartItems(): Collection;

    public function getTotalPrice(): float|int;

    public function deleteCartItem(int $cartItemId = null): void;

    public function reassignCartItemsToLoggedInUser(string $guestCartId): void;
}

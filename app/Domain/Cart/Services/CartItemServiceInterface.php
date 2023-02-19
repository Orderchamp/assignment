<?php

namespace App\Domain\Cart\Services;

use App\Domain\Cart\Models\CartItem;
use App\Domain\Product\Models\Product;
use App\Http\Requests\AddProductToCartRequest;
use Illuminate\Database\Eloquent\Collection;

interface CartItemServiceInterface
{
    public function getAllCartItems(): Collection;

    public function getTotalPrice(): float|int;

    public function deleteCartItem(int $cartItemId = null): void;

    public function reassignCartItemsToLoggedInUser(string $guestCartId): void;

    public function addProductToCart(Product $product, AddProductToCartRequest $request): CartItem;
}

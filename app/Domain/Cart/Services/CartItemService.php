<?php

namespace App\Domain\Cart\Services;

use App\Domain\Cart\Repositories\CartItemRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cookie;

class CartItemService implements CartItemServiceInterface
{
    private CartItemRepositoryInterface $cartItemRepository;

    public function __construct(CartItemRepositoryInterface $cartItemRepository)
    {
        $this->cartItemRepository = $cartItemRepository;
    }

    public function getAllCartItems(): Collection
    {
        if (auth()->check()) {
            return $this->cartItemRepository->getByUserId(auth()->id());
        }

        return $this->cartItemRepository->getByGuestCartId(Cookie::get('guest_cart_id'));
    }

    public function getTotalPrice(): float|int
    {
        $totalPrice = 0;

        foreach ($this->getAllCartItems() as $cartItem) {
            $totalPrice += $cartItem?->product?->price * $cartItem->quantity;
        }

        return $totalPrice;
    }

    public function deleteCartItem(int $cartItemId = null): void
    {
        if (auth()->check()) {
            $this->cartItemRepository->deleteByUserId(auth()->id(), $cartItemId);
        }

        $this->cartItemRepository->deleteByGuestCartId(Cookie::get('guest_cart_id'), $cartItemId);
    }

    public function reassignCartItemsToLoggedInUser(string $guestCartId): void
    {
        foreach ($this->cartItemRepository->getByGuestCartId($guestCartId) as $cartItem) {

            $this->cartItemRepository->update($cartItem, [
                'user_id' => auth()->id(),
                'guest_cart_id' => null,
            ]);
        }
    }
}

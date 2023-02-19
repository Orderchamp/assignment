<?php

namespace App\Domain\Cart\Services;

use App\Domain\Cart\Models\CartItem;
use App\Domain\Cart\Repositories\CartItemRepositoryInterface;
use App\Domain\Product\Models\Product;
use App\Http\Requests\AddProductToCartRequest;
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

    public function addProductToCart(Product $product, AddProductToCartRequest $request): CartItem
    {
        $productId = $product->id;
        $qty = 1;

        $cartItem = new CartItem([
            'product_id' => $productId,
            'quantity' => $qty,
            'price' => $product->price,
            'user_id' => null,
            'guest_cart_id' => null,
        ]);

        if (auth()->check()) {
            $cartItem['user_id'] = auth()->id();
        } else {
            $guestCart = $request->session()->get('guest_cart');

            $guestCart['cart_items'][] = [
                'product_id' => $productId,
                'quantity' => $qty,
                'price' => $product->price,
            ];

            $request->session()->put('guest_cart', $guestCart);

            $cartItem['guest_cart_id'] = $request->cookie('guest_cart_id');
            $cartItem['user_id'] = 0;
        }

        $this->cartItemRepository->save($cartItem);

        return $cartItem;
    }
}

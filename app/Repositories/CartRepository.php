<?php

namespace App\Repositories;

use App\Exceptions\ProductOutOfStockException;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class CartRepository implements CartRepositoryInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    public function __construct(?ProductRepositoryInterface $productRepository = null) {
        $this->productRepository = $productRepository ?: (new ProductRepository());
    }

    public function create()
    {
        return Cart::create([
            'total' => 0,
        ]);
    }

    public function addItem(Cart $cart, Product $product, int $quantity): Cart
    {
        $cartItem = $this->getCartItem($cart, $product);

        if ($cartItem === null) {
            $this->productRepository->removeStock($product, $quantity);

            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'price' => $product->price,
                'quantity' => $quantity,
            ]);
        } else {
            $stockDifference = $cartItem->quantity - $quantity;

            if ($stockDifference > 0) {
                $this->productRepository->addStock($product, $stockDifference);
            } else if ($stockDifference < 0) {
                $this->productRepository->removeStock($product, $stockDifference);
            }

            $cartItem->quantity = $quantity;
            $cartItem->save();
        }

        $this->updateTotal($cart);

        return $cart;
    }

    public function getCartItem(Cart $cart, Product $product):? CartItem
    {
        return CartItem::where([
            'cart_id' => $cart->id,
            'product_id' => $product->id
        ])->first();
    }

    public function calculateTotal(Cart $cart): float
    {
        $cart->refresh();

        $totalPrice = $cart->items->sum(function($item) {
            return $item->price * $item->quantity;
        });

        return $totalPrice;
    }

    public function updateTotal(Cart $cart): void
    {
        $cart->total = $this->calculateTotal($cart);
        $cart->save();
    }

}

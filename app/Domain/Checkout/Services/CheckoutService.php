<?php

namespace App\Domain\Checkout\Services;

use App\Domain\Product\Repositories\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CheckoutService implements CheckoutServiceInterface
{
    public function getProductsForCheckout(Collection $cartItems, ProductRepositoryInterface $productRepository): array
    {
        $products = [];
        $total = 0;

        foreach ($cartItems as $productId => $cartItem) {

            if (!is_null($product = $productRepository->getById($cartItem->first()->product_id))) {
                $product->quantity = $cartItem->sum('quantity');
                $product->total = $cartItem->sum('quantity') * $product->price;
                $total += $product->total;
                $products[] = $product;
            }
        }

        return [
            'products' => $products,
            'total' => $total,
        ];
    }
}

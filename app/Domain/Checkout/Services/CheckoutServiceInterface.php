<?php

namespace App\Domain\Checkout\Services;

use App\Domain\Product\Repositories\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface CheckoutServiceInterface
{
    public function getProductsForCheckout(Collection $cartItems, ProductRepositoryInterface $productRepository): array;
}

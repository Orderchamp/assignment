<?php

namespace App\Repositories;

use App\Exceptions\ProductOutOfStockException;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

interface CartRepositoryInterface
{
    /**
     * Create an empty cart
     */
    public function create();

    /**
     * Add an item to a cart
     * @throws ProductOutOfStockException
     */
    public function addItem(Cart $cart, Product $product, int $quantity): Cart;

    /**
     * Get a CartItem based on the given cart and product
     */
    public function getCartItem(Cart $cart, Product $product):? CartItem;

    /**
     * Calculate the total of the cart
     */
    public function calculateTotal(Cart $cart): float;

    /**
     * Update the total of the cart
     */
    public function updateTotal(Cart $cart): void;
}

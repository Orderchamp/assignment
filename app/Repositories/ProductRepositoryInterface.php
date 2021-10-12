<?php

namespace App\Repositories;

use App\Exceptions\ProductOutOfStockException;
use App\Models\Product;

interface ProductRepositoryInterface
{
    /**
     * Add a given product quantity to the stock
     */
    public function addStock(Product $product, int $quantity);

    /**
     * Remove a given product quantity from stock
     * @throws ProductOutOfStockException
     */
    public function removeStock(Product $product, int $quantity);
}

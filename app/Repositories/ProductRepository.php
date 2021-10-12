<?php

namespace App\Repositories;

use App\Exceptions\ProductOutOfStockException;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function addStock(Product $product, int $quantity)
    {
        $product->stock = $product->stock + $quantity;
        $product->save();
    }

    public function removeStock(Product $product, int $quantity)
    {
        $product->stock = $product->stock + (abs($quantity) * -1);

        if ($product->stock < 0) {
            $product->refresh();

            throw new ProductOutOfStockException('The quantity you are ordering is not available in stock.');
        }

        $product->save();
    }
}

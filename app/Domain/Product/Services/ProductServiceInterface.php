<?php

namespace App\Domain\Product\Services;

use App\Domain\Product\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductServiceInterface
{
    public function getAllProducts(): LengthAwarePaginator;

    public function reduceProductQuantity(Product $product, int $reduceBy): Product;
}

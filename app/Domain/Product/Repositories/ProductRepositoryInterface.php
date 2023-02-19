<?php

namespace App\Domain\Product\Repositories;

use App\Domain\Product\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{
    public function getAll(): LengthAwarePaginator;

    public function getById(int $id): ?Product;

    public function update(Product $product, array $data): Product;
}

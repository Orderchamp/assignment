<?php

namespace App\Domain\Product\Repositories;

use App\Domain\Product\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAll(int $perPage = 10): LengthAwarePaginator
    {
        return Product::paginate($perPage);
    }

    public function getById(int $id): ?Product
    {
        return Product::find($id);
    }
}

<?php

namespace App\Domain\Product\Repositories;

use App\Domain\Product\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository implements ProductRepositoryInterface
{
    protected Product $productModel;

    public function __construct(Product $productModel)
    {
        $this->productModel = $productModel;
    }

    public function getAll(int $perPage = 10): LengthAwarePaginator
    {
        return $this->productModel::paginate($perPage);
    }

    public function getById(int $id): ?Product
    {
        return $this->productModel::find($id);
    }

    public function update(Product $product, array $data): Product
    {
        $product->update($data);

        return $product;
    }
}

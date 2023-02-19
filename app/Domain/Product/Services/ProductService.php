<?php

namespace App\Domain\Product\Services;

use App\Domain\Exceptions\OrderQuantityMoreThanStockException;
use App\Domain\Product\Models\Product;
use App\Domain\Product\Repositories\ProductRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService implements ProductServiceInterface
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllProducts(int $perPage = 10): LengthAwarePaginator
    {
        return $this->productRepository->getAll($perPage);
    }

    /**
     * @throws OrderQuantityMoreThanStockException
     */
    public function reduceProductQuantity(Product $product, int $reduceBy): Product
    {
        $proposedQuantity = $product->quantity - $reduceBy;

        if ($proposedQuantity < 0) {
            throw new OrderQuantityMoreThanStockException($reduceBy);
        }

        return $this->productRepository->update($product, ['quantity' => $proposedQuantity]);
    }
}

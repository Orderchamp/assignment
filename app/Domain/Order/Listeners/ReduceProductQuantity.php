<?php

namespace App\Domain\Order\Listeners;

use App\Domain\Order\Events\OrderCreated;
use App\Domain\Product\Services\ProductServiceInterface;

class ReduceProductQuantity
{
    protected ProductServiceInterface $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    public function handle(OrderCreated $event): void
    {
        foreach ($event->data as $product) {

            $this->productService->reduceProductQuantity($product['productObject'], $product['quantityToReduceBy']);
        }
    }
}


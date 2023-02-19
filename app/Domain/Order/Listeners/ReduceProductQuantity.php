<?php

namespace App\Domain\Order\Listeners;

use App\Domain\Order\Events\OrderCreated;
use App\Domain\Order\Models\OrderItem;
use App\Domain\Product\Models\Product;
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
        $order = $event->order;
        $orderItems = OrderItem::where('order_id', $order->id)->get();
        $reduceBy = $orderItems->sum('quantity');
        $product = Product::find($orderItems->first()->product_id);

        $this->productService->reduceProductQuantity($product, $reduceBy);
    }
}


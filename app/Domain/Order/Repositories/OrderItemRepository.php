<?php

namespace App\Domain\Order\Repositories;

use App\Domain\Order\Models\OrderItem;
use Illuminate\Support\Collection;

class OrderItemRepository implements OrderItemRepositoryInterface
{
    private OrderItem $orderModel;

    public function __construct(OrderItem $orderModel)
    {
        $this->orderModel = $orderModel;
    }

    public function getById(int $id): ?OrderItem
    {
        return $this->orderModel->find($id);
    }

    public function getAll(): Collection
    {
        return $this->orderModel->all();
    }

    public function save(OrderItem $order): void
    {
        $order->save();
    }

    public function delete(OrderItem $order): void
    {
        $order->delete();
    }
}

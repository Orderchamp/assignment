<?php

namespace App\Domain\Order\Repositories;

use App\Domain\Order\Models\Order;
use Illuminate\Support\Collection;

class OrderRepository implements OrderRepositoryInterface
{
    private Order $orderModel;

    public function __construct(Order $orderModel)
    {
        $this->orderModel = $orderModel;
    }

    public function getById(int $id): ?Order
    {
        return $this->orderModel->find($id);
    }

    public function getAll(): Collection
    {
        return $this->orderModel->all();
    }

    public function save(Order $order): void
    {
        $order->save();
    }

    public function delete(Order $order): void
    {
        $order->delete();
    }
}

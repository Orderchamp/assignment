<?php

namespace App\Domain\Order\Repositories;

use App\Domain\Order\Models\OrderItem;
use Illuminate\Support\Collection;

interface OrderItemRepositoryInterface
{
    public function getById(int $id): ?OrderItem;

    public function getAll(): Collection;

    public function save(OrderItem $order): void;

    public function delete(OrderItem $order): void;
}

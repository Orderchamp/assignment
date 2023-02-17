<?php

namespace App\Domain\Order\Repositories;

use App\Domain\Order\Models\Order;
use Illuminate\Support\Collection;

interface OrderRepositoryInterface
{
    public function getById(int $id): ?Order;

    public function getAll(): Collection;

    public function save(Order $order): void;

    public function delete(Order $order): void;
}

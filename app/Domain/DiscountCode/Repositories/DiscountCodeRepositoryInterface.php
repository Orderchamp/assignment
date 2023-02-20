<?php

namespace App\Domain\DiscountCode\Repositories;

use App\Domain\DiscountCode\Models\DiscountCode;
use App\Domain\Order\Models\Order;

interface DiscountCodeRepositoryInterface
{
    public function createDiscountCode(array $data): DiscountCode;

    public function findDiscountCodeByCode(string $code): DiscountCode;

    public function findDiscountCodeByStatusAndId(string $code): ?DiscountCode;

    public function markDiscountCodeAsUsed(Order $order, string $code): void;
}

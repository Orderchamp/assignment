<?php

namespace App\Domain\DiscountCode\Services;

use App\Domain\DiscountCode\Models\DiscountCode;
use App\Domain\Order\Models\Order;

interface DiscountCodeServiceInterface
{
    public function generateDiscountCode(int $userId, float $amount, int $expiresInMinutes): DiscountCode;

    public function applyDiscountCode(Order $order, string $code): void;
}

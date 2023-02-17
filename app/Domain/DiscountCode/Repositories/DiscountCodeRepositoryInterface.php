<?php

namespace App\Domain\DiscountCode\Repositories;

use App\Domain\DiscountCode\Models\DiscountCode;

interface DiscountCodeRepositoryInterface
{
    public function createDiscountCode(array $data): DiscountCode;

    public function findDiscountCodeByCode(string $code): ?DiscountCode;

    public function markDiscountCodeAsUsed(string $code): void;
}

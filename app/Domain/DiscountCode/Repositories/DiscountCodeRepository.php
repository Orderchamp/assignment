<?php

namespace App\Domain\DiscountCode\Repositories;

use App\Domain\DiscountCode\Models\DiscountCode;

class DiscountCodeRepository implements DiscountCodeRepositoryInterface
{
    public function createDiscountCode(array $data): DiscountCode
    {
        return DiscountCode::create($data);
    }

    public function findDiscountCodeByCode(string $code): ?DiscountCode
    {
        return DiscountCode::where('code', $code)->first();
    }

    public function markDiscountCodeAsUsed(string $code): void
    {
        $discountCode = DiscountCode::where('code', $code)->firstOrFail();
        $discountCode->is_used = true;
        $discountCode->save();
    }
}

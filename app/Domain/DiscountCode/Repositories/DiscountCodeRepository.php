<?php

namespace App\Domain\DiscountCode\Repositories;

use App\Domain\DiscountCode\Models\DiscountCode;

class DiscountCodeRepository implements DiscountCodeRepositoryInterface
{
    private DiscountCode $discountCodeModel;

    public function __construct(DiscountCode $discountCodeModel)
    {
        $this->discountCodeModel = $discountCodeModel;
    }

    public function createDiscountCode(array $data): DiscountCode
    {
        return $this->discountCodeModel->create($data);
    }

    public function findDiscountCodeByCode(string $code): ?DiscountCode
    {
        return $this->discountCodeModel->where('code', $code)->firstOrFail();
    }

    public function markDiscountCodeAsUsed(string $code): void
    {
        $discountCode = $this->findDiscountCodeByCode($code);
        $discountCode->is_used = true;
        $discountCode->save();
    }
}

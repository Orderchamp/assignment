<?php

namespace App\Domain\DiscountCode\Services;

use App\Domain\DiscountCode\Models\DiscountCode;
use App\Domain\DiscountCode\Repositories\DiscountCodeRepositoryInterface;
use App\Domain\Order\Models\Order;
use Illuminate\Support\Str;

class DiscountCodeService implements DiscountCodeServiceInterface
{
    protected DiscountCodeRepositoryInterface $discountCodeRepository;

    public function __construct(DiscountCodeRepositoryInterface $discountCodeRepository)
    {
        $this->discountCodeRepository = $discountCodeRepository;
    }

    public function generateDiscountCode(Order $order, float $amount): DiscountCode
    {
        $discountCodeData = [
            'order_id' => $order->id,
            'user_id' => $order->user_id,
            'discount_amount' => $amount,
            'code' => Str::random(10),
        ];

        return $this->discountCodeRepository->createDiscountCode($discountCodeData);
    }

    public function validateDiscountCode(string $code): bool
    {
        if (!is_null($this->discountCodeRepository->findDiscountCodeByStatusAndId($code))) {
            return true;
        }

        return false;
    }
}

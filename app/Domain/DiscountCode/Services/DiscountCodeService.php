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

    public function generateDiscountCode(int $userId, float $amount, int $expiresInMinutes): DiscountCode
    {
        $discountCode = new DiscountCode();
        $discountCode->user_id = $userId;
        $discountCode->amount = $amount;
        $discountCode->expires_at = now()->addMinutes($expiresInMinutes);
        $discountCode->code = Str::random(10);
        $discountCode->save();

        return $discountCode;
    }

    public function applyDiscountCode(Order $order, string $code): void
    {
        // TODO: Implement applyDiscountCode() method.
    }
}

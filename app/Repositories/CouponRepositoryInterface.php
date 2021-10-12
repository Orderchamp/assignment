<?php

namespace App\Repositories;

use App\Models\Coupon;

interface CouponRepositoryInterface
{
    /**
     * Get a coupon by code
     */
    public function getByCode(string $code): Coupon;
}

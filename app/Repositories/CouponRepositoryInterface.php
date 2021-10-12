<?php

namespace App\Repositories;

use App\Models\Coupon;

interface CouponRepositoryInterface
{
    /**
     * Create a new coupon
     */
    public function create(string $name, float $amount): Coupon;

    /**
     * Get a coupon by code
     */
    public function getByCode(string $code): Coupon;
}

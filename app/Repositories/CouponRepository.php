<?php

namespace App\Repositories;

use App\Models\Coupon;

class CouponRepository implements CouponRepositoryInterface
{
    public function create(string $name, float $amount): Coupon
    {
        return Coupon::create([
            'name' => $name,
            'amount' => $amount,
        ]);
    }

    public function getByCode(string $code): Coupon
    {
        return Coupon::where(['code' => $code])->firstOrFail();
    }
}

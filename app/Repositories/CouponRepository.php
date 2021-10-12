<?php

namespace App\Repositories;

use App\Models\Coupon;

class CouponRepository implements CouponRepositoryInterface
{

    public function getByCode(string $code): Coupon
    {
        return Coupon::where(['code' => $code])->firstOrFail();
    }
}

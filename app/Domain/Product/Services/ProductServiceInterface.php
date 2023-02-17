<?php

namespace App\Domain\Product\Services;

use Illuminate\Pagination\LengthAwarePaginator;

interface ProductServiceInterface
{
    public function getAllProducts(): LengthAwarePaginator;
}

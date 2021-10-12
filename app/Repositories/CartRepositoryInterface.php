<?php

namespace App\Repositories;

use App\Models\Cart;

interface CartRepositoryInterface
{
    /**
     * Create an empty cart
     */
    public function create();
}

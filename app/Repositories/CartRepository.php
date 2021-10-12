<?php

namespace App\Repositories;

use App\Models\Cart;

class CartRepository implements CartRepositoryInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    public function __construct(?ProductRepositoryInterface $productRepository = null) {
        $this->productRepository = $productRepository ?: (new ProductRepository());
    }

    public function create()
    {
        return Cart::create([
            'total' => 0,
        ]);
    }
}

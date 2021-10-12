<?php

namespace Tests\Feature\Repositories;

use App\Models\Cart;
use App\Repositories\CartRepository;
use Tests\TestCase;

class CartRepositoryTest extends TestCase
{
    private $cartRepository;
    private $cart;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cartRepository = new CartRepository(new ProductRepository());
        $this->cart = $this->cartRepository->create();
    }

    public function testEmptyCartIsCreated()
    {
        $this->assertInstanceOf(Cart::class, $this->cart);
        $this->assertEquals(0, $this->cart->total);
    }
}

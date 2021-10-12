<?php

namespace Tests\Feature;

use App\Models\Cart;
use Illuminate\Http\Response;
use Tests\TestCase;

class CartTest extends TestCase
{
    private $cart;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cart = Cart::factory()->create();
    }

    public function testCreateNewCart()
    {
        $this->post('/api/carts')
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure(['cart_key']);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Response;
use Tests\TestCase;

class CartTest extends TestCase
{
    private $cart;
    private $productInStock;
    private $productOutOfStock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cart = Cart::factory()->create();

        $this->productInStock = Product::factory()->create([
            'stock' => 100,
            'price' => 1.50,
        ]);

        $this->productOutOfStock = Product::factory()->create([
            'stock' => 0,
            'price' => 2.50,
        ]);
    }

    public function testCreateNewCart()
    {
        $this->post('/api/carts')
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure(['cart_key']);
    }

    public function testAddProductWithoutProduct()
    {
        $this->post('/api/carts/' . $this->cart->key, [
            'quantity' => 1,
        ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(['product_id' => ['The product id field is required.']]);
    }

    public function testAddProductToCartWhenProductDoesNotExist()
    {
        $this->post('/api/carts/' . $this->cart->key, [
            'product_id' => '9999992323',
            'quantity' => 1,
        ])
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJson(['message' => 'The selected product does not exist']);
    }

    public function testAddProductWithoutQuantity()
    {
        $this->post('/api/carts/' . $this->cart->key, [
            'product_id' => $this->productInStock->id,
        ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(['quantity' => ['The quantity field is required.']]);
    }

    public function testAddProductWithNegativeQuantity()
    {
        $this->post('/api/carts/' . $this->cart->key, [
            'product_id' => $this->productInStock->id,
            'quantity' => -3,
        ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(['quantity' => ['The quantity must be at least 1.']]);
    }

}

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

    public function testAddProductToCartWhenProductIsOutOfStock()
    {
        $this->post('/api/carts/' . $this->cart->key, [
            'product_id' => $this->productOutOfStock->id,
            'quantity' => 10,
        ])
            ->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJson([
                'message' => 'The quantity you are ordering is not available in stock.',
            ]);
    }

    public function testUpdateProductInCartWhenProductRunsOutOfStock()
    {
        $this->post('/api/carts/' . $this->cart->key, [
            'product_id' => $this->productInStock->id,
            'quantity' => 1,
        ])
            ->assertStatus(Response::HTTP_NO_CONTENT);

        $this->get('/api/products/' . $this->productInStock->id)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment(['stock' => $this->productInStock->stock - 1]);

        $this->post('/api/carts/' . $this->cart->key, [
            'product_id' => $this->productInStock->id,
            'quantity' => $this->productInStock->stock,
        ])
            ->assertStatus(Response::HTTP_NO_CONTENT);

        $this->get('/api/products/' . $this->productInStock->id)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment(['stock' => 0]);
    }

    public function testAddProductToCartWhenProductIsInStock()
    {
        $this->post('/api/carts/' . $this->cart->key, [
            'product_id' => $this->productInStock->id,
            'quantity' => 95,
        ])
            ->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function testCheckoutInvalidCartReturnsNotFound()
    {
        $this->post('/api/carts/asdfdsfsdf/checkout')
            ->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function testCheckoutWithoutProductsIsNotAllowed()
    {
        $this->post('/api/carts/' . $this->cart->key . '/checkout')
            ->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJson(['message' => 'Cart is empty']);
    }

    public function testCheckoutCartWithProducts()
    {
        $this->post('/api/carts/' . $this->cart->key, [
            'product_id' => $this->productInStock->id,
            'quantity' => 2,
        ])
            ->assertStatus(Response::HTTP_NO_CONTENT);

        $this->post('/api/carts/' . $this->cart->key . '/checkout')
            ->assertStatus(Response::HTTP_NO_CONTENT);

        $this->get('/api/carts/' . $this->cart->key)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment(['status' => 'complete']);
    }
}

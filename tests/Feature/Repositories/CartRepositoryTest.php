<?php

namespace Tests\Feature\Repositories;

use App\Exceptions\ProductOutOfStockException;
use App\Models\Cart;
use App\Models\Product;
use App\Repositories\CartRepository;
use App\Repositories\ProductRepository;
use Tests\TestCase;

class CartRepositoryTest extends TestCase
{
    private $cartRepository;
    private $cart;
    private $productInStock;
    private $productOutOfStock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cartRepository = new CartRepository(new ProductRepository());
        $this->cart = $this->cartRepository->create();

        $this->productInStock = Product::factory()->create([
            'stock' => 100,
            'price' => 1.50,
        ]);

        $this->productOutOfStock = Product::factory()->create([
            'stock' => 0,
            'price' => 2.50,
        ]);
    }

    public function testEmptyCartIsCreated()
    {
        $this->assertInstanceOf(Cart::class, $this->cart);
        $this->assertEquals(0, $this->cart->total);
    }

    public function testAddItemToCartWhenProductIsOutOfStockThrowsException()
    {
        $this->expectException(ProductOutOfStockException::class);
        $this->expectExceptionMessage('The quantity you are ordering is not available in stock.');

        $this->cartRepository->addItem($this->cart, $this->productOutOfStock, 1);
    }

}

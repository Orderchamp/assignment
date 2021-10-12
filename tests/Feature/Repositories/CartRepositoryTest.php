<?php

namespace Tests\Feature\Repositories;

use App\Exceptions\ProductOutOfStockException;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Product;
use App\Providers\CheckoutCompleted;
use App\Repositories\CartRepository;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;
use Tests\TestCase;

class CartRepositoryTest extends TestCase
{
    private $defaultUser;
    private $userRepository;
    private $coupon;
    private $cartRepository;
    private $cart;
    private $productInStock;
    private $productOutOfStock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepository = new UserRepository();
        $this->defaultUser = $this->userRepository->getDefaultUser();

        $this->coupon = Coupon::factory(['amount' => 5])->create();

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

    public function testProductStockIsUpdatedWhenItemIsAddedToCart()
    {
        $this->cartRepository->addItem($this->cart, $this->productInStock, 3);

        $this->assertEquals(97, $this->productInStock->stock);
    }

    public function testProductStockIsUpdatedWhenTheSameItemIsAddedToCart()
    {
        $this->cartRepository->addItem($this->cart, $this->productInStock, 3);
        $this->cartRepository->addItem($this->cart, $this->productInStock, 5);

        $this->assertEquals(95, $this->productInStock->stock);
    }

    public function testAddItemToCartUpdatesCartTotal()
    {
        $this->cartRepository->addItem($this->cart, $this->productInStock, 5);

        $this->assertEquals(7.5, $this->cart->total);
    }

    public function testAddItemToCartUpdatesCartTotalWhenTheSameItemIsAddedToCart()
    {
        $this->cartRepository->addItem($this->cart, $this->productInStock, 3);
        $this->assertEquals(4.5, $this->cart->total);

        $this->cartRepository->addItem($this->cart, $this->productInStock, 5);
        $this->assertEquals(7.5, $this->cart->total);

        $this->cartRepository->addItem($this->cart, $this->productInStock, 10);
        $this->assertEquals(15, $this->cart->total);
    }

    public function testCheckoutCart()
    {
        $this->cartRepository->addItem($this->cart, $this->productInStock, 3);
        $order = $this->cartRepository->checkout($this->cart, $this->defaultUser);

        $this->assertEquals($this->cart->id, $order->cart_id);
        $this->assertEquals('complete', $this->cart->status);
        $this->assertEquals(4.5, $this->cart->total);
    }

    public function testCheckoutCartWithACoupon()
    {
        $this->cartRepository->addItem($this->cart, $this->productInStock, 20);
        $this->assertEquals(30, $this->cart->total);

        $this->expectsEvents(CheckoutCompleted::class);

        $order = $this->cartRepository->checkout($this->cart, $this->defaultUser, $this->coupon->code);

        $this->coupon->refresh();

        $this->assertEquals($this->cart->id, $order->cart_id);
        $this->assertEquals('complete', $this->cart->status);
        $this->assertEquals(25, $this->cart->total);
        $this->assertEquals(1, $this->coupon->used);
    }
}

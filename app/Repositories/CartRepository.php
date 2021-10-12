<?php

namespace App\Repositories;

use App\Exceptions\CartIsEmptyException;
use App\Exceptions\ProductOutOfStockException;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class CartRepository implements CartRepositoryInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    /**
     * @var CouponRepositoryInterface
     */
    private $couponRepository;

    public function __construct(
        ?ProductRepositoryInterface $productRepository = null,
        ?OrderRepositoryInterface $orderRepository = null,
        ?CouponRepositoryInterface $couponRepository = null
    ) {
        $this->productRepository = $productRepository ?: (new ProductRepository());
        $this->orderRepository = $orderRepository ?: (new OrderRepository());
        $this->couponRepository = $couponRepository ?: (new CouponRepository());
    }

    public function create()
    {
        return Cart::create([
            'total' => 0,
        ]);
    }

    public function addItem(Cart $cart, Product $product, int $quantity): Cart
    {
        $cartItem = $this->getCartItem($cart, $product);

        if ($cartItem === null) {
            $this->productRepository->removeStock($product, $quantity);

            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'price' => $product->price,
                'quantity' => $quantity,
            ]);
        } else {
            $stockDifference = $cartItem->quantity - $quantity;

            if ($stockDifference > 0) {
                $this->productRepository->addStock($product, $stockDifference);
            } else if ($stockDifference < 0) {
                $this->productRepository->removeStock($product, $stockDifference);
            }

            $cartItem->quantity = $quantity;
            $cartItem->save();
        }

        $this->updateTotal($cart);

        return $cart;
    }

    public function getCartItem(Cart $cart, Product $product):? CartItem
    {
        return CartItem::where([
            'cart_id' => $cart->id,
            'product_id' => $product->id
        ])->first();
    }

    public function calculateTotal(Cart $cart): float
    {
        $cart->refresh();

        $totalPrice = $cart->items->sum(function($item) {
            return $item->price * $item->quantity;
        });

        if (!empty($cart->coupon)) {
            $totalPrice = max(0, $totalPrice - $cart->coupon->amount);
        }

        return $totalPrice;
    }

    public function updateTotal(Cart $cart): void
    {
        $cart->total = $this->calculateTotal($cart);
        $cart->save();
    }

    public function checkout(Cart $cart, User $user, ?string $couponCode = null): Order
    {
        if ($cart->items->count() <= 0) {
            throw new CartIsEmptyException('Cart is empty');
        }

        $order = $this->orderRepository->create($cart, $user);

        if ($couponCode) {
            $coupon = $this->couponRepository->getByCode($couponCode);
            $coupon->used = true;
            $coupon->save();

            $cart->coupon_id = $coupon->id;
        }

        $cart->status = 'complete';
        $cart->save();

        $this->updateTotal($cart);

        return $order;
    }
}

<?php

namespace App\Domain\Order\Services;

use App\Domain\Cart\Services\CartItemServiceInterface;
use App\Domain\Exceptions\OrderQuantityMoreThanStockException;
use App\Domain\Exceptions\ProductOutOfStockException;
use App\Domain\Order\Models\Order;
use App\Domain\Order\Models\OrderContactInfo;
use App\Domain\Order\Models\OrderItem;
use App\Domain\Order\Repositories\OrderRepositoryInterface;
use App\Domain\Product\Repositories\ProductRepositoryInterface;
use App\Http\Requests\CheckoutRequest;

class OrderService implements OrderServiceInterface
{
    private OrderRepositoryInterface $orderRepository;
    private CartItemServiceInterface $cartItemService;
    private ProductRepositoryInterface $productRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        CartItemServiceInterface $cartItemService,
        ProductRepositoryInterface $productRepository,
    ) {
        $this->orderRepository = $orderRepository;
        $this->cartItemService = $cartItemService;
        $this->productRepository = $productRepository;
    }

    /**
     * @throws ProductOutOfStockException
     * @throws OrderQuantityMoreThanStockException
     */
    public function createOrder(CheckoutRequest $request): Order
    {
        $cartItems = $this->cartItemService->getAllCartItems();
        $product = $this->productRepository->getById($cartItems->first()->product_id);

        $orderItems = [];
        $cartItemQuantities = 0;

        foreach ($cartItems as $cartItem) {

            if ($product) {
                $cartItemQuantities += $cartItem->quantity;

                $orderItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $cartItem->quantity,
                    'price' => $product->price,
                ];
            }
        }

        if ($product->quantity === 0) {
            throw new ProductOutOfStockException();
        }

        if ($cartItemQuantities > $product->quantity) {
            throw new OrderQuantityMoreThanStockException($cartItemQuantities);
        }

        $orderData = [
            'user_id' => auth()->check() ? auth()->id() : 0,
            'guest_email' => auth()->check() ? null : $request->validated('email'),
            'total_price' => collect($orderItems)->sum('price'),
        ];

        $order = new Order($orderData);
        $this->orderRepository->save($order);

        foreach ($cartItems as $cartItem) {

            // Should move this into service, no time though.
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $cartItem['product_id'];
            $orderItem->quantity = $cartItem['quantity'];
            $orderItem->price = $cartItem['price'];
            $orderItem->save();

            $this->cartItemService->deleteCartItem($cartItem['id']);
        }

        $orderContactInfo = $request->validated();

        // Should move this into service, no time though.
        $orderContactModel = new OrderContactInfo();
        $orderContactModel->order_id = $order->id;
        $orderContactModel->address = $orderContactInfo['address'];
        $orderContactModel->phone = $orderContactInfo['phone'];
        $orderContactModel->country = $orderContactInfo['country'];
        $orderContactModel->city = $orderContactInfo['city'];
        $orderContactModel->zip = $orderContactInfo['zip'];
        $orderContactModel->save();

        return $order;
    }
}


<?php

namespace App\Domain\Order\Services;

use App\Domain\Cart\Services\CartItemServiceInterface;
use App\Domain\Order\Models\Order;
use App\Domain\Order\Models\OrderContactInfo;
use App\Domain\Order\Models\OrderItem;
use App\Domain\Order\Repositories\OrderRepositoryInterface;

class OrderService implements OrderServiceInterface
{
    private OrderRepositoryInterface $orderRepository;
    private CartItemServiceInterface $cartItemService;

    public function __construct(OrderRepositoryInterface $orderRepository, CartItemServiceInterface $cartItemService)
    {
        $this->orderRepository = $orderRepository;
        $this->cartItemService = $cartItemService;
    }

    public function createOrder(array $orderData, array $cartItems, array $orderContactInfo): Order
    {
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


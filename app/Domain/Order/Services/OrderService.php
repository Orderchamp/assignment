<?php

namespace App\Domain\Order\Services;

use App\Domain\Cart\Services\CartItemServiceInterface;
use App\Domain\Exceptions\OrderQuantityMoreThanStockException;
use App\Domain\Exceptions\ProductOutOfStockException;
use App\Domain\Order\Events\OrderCreated;
use App\Domain\Order\Models\Order;
use App\Domain\Order\Models\OrderContactInfo;
use App\Domain\Order\Repositories\OrderRepositoryInterface;
use App\Domain\Product\Models\Product;
use App\Domain\Product\Repositories\ProductRepositoryInterface;
use App\Http\Requests\CheckoutRequest;

class OrderService implements OrderServiceInterface
{
    private OrderRepositoryInterface $orderRepository;
    private OrderItemServiceInterface $orderItemService;
    private CartItemServiceInterface $cartItemService;
    private ProductRepositoryInterface $productRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        OrderItemServiceInterface $orderItemService,
        CartItemServiceInterface $cartItemService,
        ProductRepositoryInterface $productRepository,
    ) {
        $this->orderRepository = $orderRepository;
        $this->orderItemService = $orderItemService;
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
        $products = Product::whereIn('id', $cartItems->pluck('product_id'))->get(); // make repo method
        $productsKeyedByProductIdWithQuantities = $products->pluck('quantity', 'id')->toArray(); // make repo method
        $summedQuantities = $cartItems->groupBy('product_id')->map(fn($group) => $group->sum('quantity'))->toArray(); // make repo method

        $orderItems = [];
        $prepareEventData = [];

        foreach ($cartItems as $cartItem) {

            if ($product) {

                $orderItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $cartItem->quantity,
                    'price' => $product->price,
                ];
            }
        }

        foreach ($products as $p) {

            if ($p->quantity === 0) {
                throw new ProductOutOfStockException();
            }

            if ($summedQuantities[$p->id] > $productsKeyedByProductIdWithQuantities[$p->id]) {
                throw new OrderQuantityMoreThanStockException($summedQuantities[$p->id], $productsKeyedByProductIdWithQuantities[$p->id]);
            }

            $prepareEventData[$p->id] = [
                'productObject' => $p,
                'quantityToReduceBy' => $summedQuantities[$p->id],
            ];
        }

        $orderData = [
            'user_id' => auth()->check() ? auth()->id() : 0,
            'guest_email' => auth()->check() ? null : $request->validated('email'),
            'total_price' => collect($orderItems)->sum('price'),
        ];

        $order = new Order($orderData);
        $this->orderRepository->save($order);
        $this->orderItemService->createOrderItemsFromCartItems($cartItems, $order);

        event(new OrderCreated($order, $prepareEventData));

        $orderContactInfo = $request->validated();

        // Should move this into service, no time though. +event
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


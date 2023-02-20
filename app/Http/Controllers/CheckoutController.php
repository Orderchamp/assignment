<?php

namespace App\Http\Controllers;

use App\Domain\Cart\Services\CartItemServiceInterface;
use App\Domain\Checkout\Services\CheckoutServiceInterface;
use App\Domain\Exceptions\CannotApplyDiscountException;
use App\Domain\Exceptions\OrderQuantityMoreThanStockException;
use App\Domain\Exceptions\ProductOutOfStockException;
use App\Domain\Order\Services\OrderServiceInterface;
use App\Domain\Product\Repositories\ProductRepositoryInterface;
use App\Domain\User\Services\UserServiceInterface;
use App\Http\Requests\CheckoutRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CheckoutController extends Controller
{
    protected CartItemServiceInterface $cartItemService;
    protected ProductRepositoryInterface $productRepository;
    protected OrderServiceInterface $orderService;
    protected CheckoutServiceInterface $checkoutService;

    public function __construct(
        CartItemServiceInterface $cartItemService,
        ProductRepositoryInterface $productRepository,
        OrderServiceInterface $orderService,
        CheckoutServiceInterface $checkoutService
    ) {
        $this->cartItemService = $cartItemService;
        $this->productRepository = $productRepository;
        $this->orderService = $orderService;
        $this->checkoutService = $checkoutService;
    }

    public function index(): Factory|View|Application|RedirectResponse
    {
        $cartItems = $this->cartItemService->getAllCartItems()->groupBy('product_id');

        if ($cartItems->count() === 0) {
            return redirect()->route('home')->with('error', 'You need to add items to your cart before checking out.');
        }

        $checkoutData = $this->checkoutService->getProductsForCheckout($cartItems, $this->productRepository);

        return view('checkout.index', ['products' => $checkoutData['products'], 'total' => $checkoutData['total']]);
    }

    public function store(CheckoutRequest $request, UserServiceInterface $userService): RedirectResponse
    {
        if ($request->input('has-password') === 'on') {

            if (!$userService->createAndLoginUser($request)) {
                return redirect()->route('home')->with('error', 'Could not register user while creating cart.');
            }
        }

        try {
            $this->orderService->createOrder($request);

            return redirect()->route('home')->with('success', 'Order completed!');
        } catch (ProductOutOfStockException|OrderQuantityMoreThanStockException|CannotApplyDiscountException $e) {
            return redirect()->route('home')->with('error', $e->getMessage());
        }
    }
}

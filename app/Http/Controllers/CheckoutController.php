<?php

namespace App\Http\Controllers;

use App\Domain\Cart\Services\CartItemServiceInterface;
use App\Domain\Order\Services\OrderServiceInterface;
use App\Domain\Product\Repositories\ProductRepositoryInterface;
use App\Http\Requests\CheckoutRequest;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CheckoutController extends Controller
{
    protected CartItemServiceInterface $cartItemService;
    protected ProductRepositoryInterface $productRepository;
    protected OrderServiceInterface $orderService;

    public function __construct(CartItemServiceInterface $cartItemService, ProductRepositoryInterface $productRepository, OrderServiceInterface $orderService)
    {
        $this->cartItemService = $cartItemService;
        $this->productRepository = $productRepository;
        $this->orderService = $orderService;
    }

    public function index(): Factory|View|Application|RedirectResponse
    {
        $cartItems = $this->cartItemService->getAllCartItems()->groupBy('product_id');

        if ($cartItems->count() === 0) {
            return redirect()->route('home')->with('error', 'You need to add items to your cart before checking out.');
        }

        $products = [];
        $total = 0;

        foreach ($cartItems as $productId => $cartItem) {
            $product = $this->productRepository->getById($cartItem->first()->product_id);
            $product->quantity = $cartItem->sum('quantity');
            $product->total = $cartItem->sum('quantity') * $product->price;
            $total += $product->total;
            $products[] = $product;
        }

        return view('checkout.index', compact('products', 'total'));
    }

    public function store(CheckoutRequest $request): RedirectResponse
    {
        if ($request->input('has-password') === 'on') {
            try {
                $userCreated = User::create([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'password' => Hash::make($request->input('password')),
                ]);

                Auth::login($userCreated);
            } catch (\Exception $exception) {
                return redirect()->back()->withErrors(['msg', 'Could not register user while creating cart.']);
            }
        }

        $cartItems = $this->cartItemService->getAllCartItems();

        $orderItems = [];

        foreach ($cartItems as $cartItem) {
            try {
                $product = $this->productRepository->getById($cartItem->product_id);
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['msg', 'Product not found']);
            }

            if ($cartItem->quantity > $product->quantity) {
                return redirect()->back()->withErrors(['msg', 'Product ' . $product->name . ' only has ' . $product->quantity . ' available in stock.']);
            }

            $orderItems[] = [
                'product_id' => $product->id,
                'quantity' => $cartItem->quantity,
                'price' => $product->price,
            ];
        }

        $orderData = [
            'user_id' => auth()->check() ? auth()->id() : 0,
            'guest_email' => auth()->check() ? null : $request->validated('email'),
            'total_price' => collect($orderItems)->sum('price'),
        ];

        $this->orderService->createOrder($orderData, $cartItems->toArray(), $request->validated());

        //$this->cartItemService->deleteAllCartItems();

        return redirect()->route('home')->with('success', 'Order completed!');
    }
}

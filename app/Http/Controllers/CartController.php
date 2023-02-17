<?php

namespace App\Http\Controllers;

use App\Domain\Cart\Models\CartItem;
use App\Domain\Cart\Repositories\CartItemRepositoryInterface;
use App\Domain\Cart\Services\CartItemServiceInterface;
use App\Domain\Product\Repositories\ProductRepositoryInterface;
use App\Http\Requests\AddProductToCartRequest;
use App\Http\Requests\DeleteCartItemRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class CartController extends Controller
{
    private CartItemRepositoryInterface $cartItemRepository;
    private ProductRepositoryInterface $productRepository;
    private CartItemServiceInterface $cartItemService;

    public function __construct(CartItemRepositoryInterface $cartItemRepository, ProductRepositoryInterface $productRepository, CartItemServiceInterface $cartItemService)
    {
        $this->cartItemRepository = $cartItemRepository;
        $this->productRepository = $productRepository;
        $this->cartItemService = $cartItemService;
    }

    public function index(): Factory|View|Application
    {
        return view('cart.index', ['cartItems' => $this->cartItemService->getAllCartItems()->groupBy('product_id'), 'total' => $this->cartItemService->getTotalPrice()]);
    }

    public function store(AddProductToCartRequest $request): JsonResponse
    {
        $product = $this->productRepository->getById($request->validated('productId'));
        $qty = $request->validated('qty', 1);

        if ($product) {
            $productId = $product->id;

            $cartItem = new CartItem([
                'product_id' => $productId,
                'quantity' => $qty,
                'price' => $product->price,
                'user_id' => null,
                'guest_cart_id' => null,
            ]);

            if (auth()->check()) {
                $cartItem['user_id'] = auth()->id();
            } else {
                $guestCart = $request->session()->get('guest_cart');

                $guestCart['cart_items'][] = [
                    'product_id' => $productId,
                    'quantity' => $qty,
                    'price' => $product->price,
                ];

                $request->session()->put('guest_cart', $guestCart);

                $cartItem['guest_cart_id'] = $request->cookie('guest_cart_id');
                $cartItem['user_id'] = 0;
            }

            $cartItem = $this->cartItemRepository->save($cartItem);

            return response()->json(['success' => true, 'cart_item' => $cartItem]);
        }

        return response()->json(['success' => false, 'message' => 'Product not found.']);
    }

    public function destroy(DeleteCartItemRequest $request): RedirectResponse
    {
        $this->cartItemService->deleteCartItem($request->validated('cart_item_id'));

        return redirect()->route('cart.index')->with('success', 'Cart item has been removed.');
    }
}

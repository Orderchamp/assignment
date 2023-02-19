<?php

namespace App\Http\Controllers;

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
    private ProductRepositoryInterface $productRepository;
    private CartItemServiceInterface $cartItemService;

    public function __construct(ProductRepositoryInterface $productRepository, CartItemServiceInterface $cartItemService)
    {
        $this->productRepository = $productRepository;
        $this->cartItemService = $cartItemService;
    }

    public function index(): Factory|View|Application
    {
        return view('cart.index', ['cartItems' => $this->cartItemService->getAllCartItems()->groupBy('product_id'), 'total' => $this->cartItemService->getTotalPrice()]);
    }

    public function store(AddProductToCartRequest $request): JsonResponse
    {
        if ($cartItemAdded = $this->cartItemService->addProductToCart($this->productRepository->getById($request->validated('productId')), $request)) {
            return response()->json(['success' => true, 'cart_item' => $cartItemAdded]);
        }

        return response()->json(['success' => false, 'message' => 'Product not found.']);
    }

    public function destroy(DeleteCartItemRequest $request): RedirectResponse
    {
        $this->cartItemService->deleteCartItem($request->validated('cart_item_id'));

        return redirect()->route('cart.index')->with('success', 'Cart item has been removed.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Exceptions\CartIsEmptyException;
use App\Exceptions\ProductOutOfStockException;
use App\Http\Requests\CartAddItemRequest;
use App\Http\Requests\CartCheckoutRequest;
use App\Models\Cart;
use App\Models\Product;
use App\Repositories\CartRepositoryInterface;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * @var CartRepositoryInterface
     */
    private $cartRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(CartRepositoryInterface $cartRepository, UserRepository $userRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Store a newly created Cart in storage and return the key to the user
     */
    public function store(Request $request)
    {
        $cart = $this->cartRepository->create();

        $data = [
            'cart_key' => $cart->key,
        ];

        return response()->json($data, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        return $cart;
    }

    /**
     * Add items to a cart
     */
    public function addItem(Cart $cart, CartAddItemRequest $request)
    {
        try {
            $quantity = $request->input('quantity');

            $product = Product::findOrFail($request->input('product_id'));

            $this->cartRepository->addItem($cart, $product, $quantity);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'The selected product does not exist'], Response::HTTP_NOT_FOUND);
        } catch (ProductOutOfStockException $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Checkout the cart
     */
    public function checkout(Cart $cart, CartCheckoutRequest $request)
    {
        try {
            $user = $this->userRepository->getDefaultUser();

            $couponCode = $request->input('coupon_code');

            $this->cartRepository->checkout($cart, $user, $couponCode);
        } catch (CartIsEmptyException $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}

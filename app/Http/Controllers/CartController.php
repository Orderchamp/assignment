<?php

namespace App\Http\Controllers;

use App\Models\Cart;
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
    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        return $cart;
    }
}

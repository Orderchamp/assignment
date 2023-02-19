<?php

namespace App\Domain\User\Services;

use App\Domain\Cart\Services\CartItemServiceInterface;
use App\Domain\User\Models\User;
use App\Http\Requests\CheckoutRequest;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    private CartItemServiceInterface $cartItemService;

    public function __construct(CartItemServiceInterface $cartItemService)
    {
        $this->cartItemService = $cartItemService;
    }

    public function createAndLoginUser(CheckoutRequest $request): bool
    {
        $userData = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ];

        $createdUser = $this->createUser($userData);

        if ($createdUser !== null) {
            $this->loginUser($createdUser);

            $this->cartItemService->reassignCartItemsToLoggedInUser(Cookie::get('guest_cart_id'));

            return true;
        }

        return false;
    }

    public function createUser($userData): ?User
    {
        try {
            $user = User::create($userData);
        } catch (Exception $e) {
            return null;
        }

        return $user;
    }

    public function loginUser(User $userToLogin): void
    {
        Auth::login($userToLogin);
    }
}

<?php

namespace App\Domain\User\Services;

use App\Domain\User\Models\User;
use App\Http\Requests\CheckoutRequest;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{

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

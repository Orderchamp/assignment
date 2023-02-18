<?php

namespace App\Domain\User\Services;

use App\Domain\User\Models\User;
use App\Http\Requests\CheckoutRequest;

interface UserServiceInterface
{
    public function createAndLoginUser(CheckoutRequest $request): bool;

    public function createUser(array $userData): ?User;

    public function loginUser(User $userToLogin): void;
}

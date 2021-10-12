<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use App\Repositories\UserRepositoryInterface;

class UserController extends Controller
{
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Create a new user
     */
    public function store(UserStoreRequest $request)
    {
        $user = $this->userRepository->create(
            $request->input('name'),
            $request->input('address'),
            $request->input('contact'),
            $request->input('email'),
            $request->input('password'),
        );

        return $user;
    }
}

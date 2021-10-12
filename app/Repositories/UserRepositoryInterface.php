<?php

namespace App\Repositories;

use App\Models\User;

interface UserRepositoryInterface
{
    /**
     * Create new user
     */
    public function create(string $name, string $address, string $contact, string $email, string $password): User;
}

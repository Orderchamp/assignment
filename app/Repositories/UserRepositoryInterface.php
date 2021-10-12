<?php

namespace App\Repositories;

use App\Exceptions\DefaultUserNotFoundException;
use App\Models\User;

interface UserRepositoryInterface
{
    /**
     * Create new user
     */
    public function create(string $name, string $address, string $contact, string $email, string $password): User;

    /**
     * Get the default user
     * @throws DefaultUserNotFoundException
     */
    public function getDefaultUser(): User;
}

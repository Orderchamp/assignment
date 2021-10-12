<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function create(string $name, string $address, string $contact, string $email, string $password): User
    {
        return User::create([
            'name' => $name,
            'address' => $address,
            'contact' => $contact,
            'email' => $email,
            'password' => $password,
        ]);
    }
}

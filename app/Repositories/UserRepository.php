<?php

namespace App\Repositories;

use App\Exceptions\DefaultUserNotFoundException;
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

    public function getDefaultUser(): User
    {
        $user = User::where(['email' => 'anderson@test.com'])->first();

        if (empty($user)) {
            throw new DefaultUserNotFoundException();
        }

        return $user;
    }
}

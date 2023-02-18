<?php

namespace App\Domain\User\Repositories;

use App\Domain\User\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function save(User $user): void
    {
        $user->save();
    }
}

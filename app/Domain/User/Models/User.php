<?php

namespace App\Domain\User\Models;

use App\Domain\Order\Models\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class User extends \App\Models\User
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    public function orders(): ?HasMany
    {
        return $this->hasMany(Order::class);
    }
}

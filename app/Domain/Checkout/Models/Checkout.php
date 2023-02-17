<?php

namespace App\Domain\Checkout\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;

    protected $table = 'checkouts';

    protected $fillable = ['user_id', 'total_price', 'billing_address', 'shipping_address'];
}

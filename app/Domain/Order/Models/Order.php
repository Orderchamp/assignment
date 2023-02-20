<?php

namespace App\Domain\Order\Models;

use App\Domain\DiscountCode\Models\DiscountCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = ['user_id', 'guest_email', 'total_price'];

    public function discount_code(): HasOne
    {
        return $this->hasOne(DiscountCode::class);
    }
}

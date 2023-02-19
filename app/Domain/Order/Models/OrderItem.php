<?php

namespace App\Domain\Order\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';

    protected $fillable = ['product_id', 'quantity', 'price', 'order_id'];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}

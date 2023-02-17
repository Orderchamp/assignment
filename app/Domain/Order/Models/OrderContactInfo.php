<?php


namespace App\Domain\Order\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderContactInfo extends Model
{
    protected $table = 'order_contact_info';
    protected $fillable = [
        'address',
        'phone',
        'country',
        'city',
        'zip',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}

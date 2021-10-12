<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Cart extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'key', 'user_id', 'coupon_id', 'total', 'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            if (empty($model->key)) {
                $model->key = static::generateKey();
                $model->save();
            }
        });
    }

    private static function generateKey(): string
    {
        return (string)Str::uuid();
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
}

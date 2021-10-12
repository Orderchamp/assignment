<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Coupon extends Model
{
    use HasFactory, SoftDeletes;

    public const MAX_LENGTH_CODE = 10;

    protected $fillable = [
        'name', 'code', 'amount', 'used',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            if (empty($model->code)) {
                $model->code = self::generateCode($model->id);
                $model->save();
            }
        });
    }

    private static function generateCode(int $id): string
    {
        $suffix = Str::random();
        $code = sprintf('%s%s', $id, $suffix);
        return substr($code, 0, static::MAX_LENGTH_CODE);
    }
}

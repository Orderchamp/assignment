<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    public const MAX_LENGTH_SLUG = 50;

    protected $fillable = [
        'name', 'description', 'price', 'stock',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            if (empty($model->slug)) {
                $model->slug = static::generateSlug($model->id, $model->name);
                $model->save();
            }
        });
    }

    private static function generateSlug(int $id, string $name): string
    {
        $slug = sprintf('%s-%s', $id, Str::slug($name));
        return substr($slug, 0, static::MAX_LENGTH_SLUG);
    }
}

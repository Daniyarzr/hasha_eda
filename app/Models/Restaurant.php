<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Restaurant extends Model
{
    use HasFactory;

    public const DEFAULT_IMAGE = '/images/restaurants/default.svg';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'cuisine',
        'address',
        'delivery_time',
        'delivery_fee',
        'min_order_amount',
        'rating',
        'image',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'delivery_fee' => 'decimal:2',
            'min_order_amount' => 'decimal:2',
            'rating' => 'decimal:1',
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Restaurant $restaurant): void {
            if (blank($restaurant->image)) {
                $restaurant->image = self::DEFAULT_IMAGE;
            }
        });

        static::updating(function (Restaurant $restaurant): void {
            if (blank($restaurant->image)) {
                $restaurant->image = self::DEFAULT_IMAGE;
            }
        });
    }

    public function getImageUrlAttribute(): string
    {
        return $this->image ?: self::DEFAULT_IMAGE;
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function dishes(): HasMany
    {
        return $this->hasMany(Dish::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'price',
        'original_price',
        'discount_percent',
        'rating',
        'sold_count',
        'stock',
        'location',
        'is_mall',
        'is_star',
        'is_flash_sale',
        'image_url',
        'description',
        'variants'
    ];

    protected $casts = [
        'price' => 'float',
        'original_price' => 'float',
        'discount_percent' => 'integer',
        'rating' => 'float',
        'sold_count' => 'integer',
        'stock' => 'integer',
        'is_mall' => 'boolean',
        'is_star' => 'boolean',
        'is_flash_sale' => 'boolean',
        'variants' => 'array',
    ];

    protected $appends = [
        'formatted_price',
        'formatted_original_price',
        'formatted_sold',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->latest();
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp' . number_format($this->price, 0, ',', '.');
    }

    public function getFormattedOriginalPriceAttribute(): string
    {
        if (!$this->original_price) return '';
        return 'Rp' . number_format($this->original_price, 0, ',', '.');
    }

    public function getFormattedSoldAttribute(): string
    {
        if ($this->sold_count >= 1000) {
            return number_format($this->sold_count / 1000, 1, ',', '.') . 'rb+';
        }
        return (string) $this->sold_count;
    }
}

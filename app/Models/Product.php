<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'price',
        'compare_at_price',
        'sku',
        'stock',
        'is_digital',
        'is_featured',
        'is_active',
        'platform_id',
        'publisher',
        'developer',
        'release_date',
        'product_type',
        'esrb_rating',
        'dimensions',
        'weight',
        'material',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'compare_at_price' => 'decimal:2',
        'is_digital' => 'boolean',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'release_date' => 'date',
    ];

    /**
     * Get the platform that the game belongs to.
     */
    public function platform(): BelongsTo
    {
        return $this->belongsTo(Platform::class);
    }

    /**
     * Get the images for the product.
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Get the categories for the product.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Get the product's primary image.
     */
    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    /**
     * Scope a query to only include active products.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include featured products.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to only include games.
     */
    public function scopeGames($query)
    {
        return $query->where('product_type', 'game');
    }

    /**
     * Scope a query to only include merchandise.
     */
    public function scopeMerchandise($query)
    {
        return $query->where('product_type', 'merchandise');
    }
}

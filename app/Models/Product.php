<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'product_id';

    protected $fillable = [
        'admin_id',
        'name',
        'description',
        'roast_level',
        'origin',
        'price',
        'stock',
        'image',
        'is_limited_edition',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'stock' => 'integer',
            'is_limited_edition' => 'boolean',
        ];
    }

    /**
     * Get the product image URL.
     * Returns the full URL for stored images or the original URL if it's a full URL.
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }

        // If it's already a full URL, return it as is
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        // If it's a storage path, return the storage URL
        // Use asset() helper for public storage files
        return asset('storage/' . $this->image);
    }

    /**
     * Get the admin that manages this product.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'admin_id');
    }

    /**
     * Get the cart items for this product.
     */
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class, 'product_id', 'product_id');
    }

    /**
     * Get the order items for this product.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'product_id', 'product_id');
    }

    /**
     * Scope a query to only include products in stock.
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Scope a query to search products by name or description.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%')
              ->orWhere('description', 'like', '%' . $search . '%');
        });
    }

    /**
     * Scope a query to filter by price range.
     */
    public function scopePriceRange($query, $min = null, $max = null)
    {
        if ($min !== null) {
            $query->where('price', '>=', $min);
        }
        if ($max !== null) {
            $query->where('price', '<=', $max);
        }
        return $query;
    }

    /**
     * Get formatted price attribute.
     */
    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->price, 2);
    }

    /**
     * Check if product is in stock.
     */
    public function getIsInStockAttribute()
    {
        return $this->stock > 0;
    }

    /**
     * Check if product is low on stock (less than 10 items).
     */
    public function getIsLowStockAttribute()
    {
        return $this->stock > 0 && $this->stock < 10;
    }

    /**
     * Scope a query to only include limited edition products.
     */
    public function scopeLimitedEdition($query)
    {
        return $query->where('is_limited_edition', true);
    }

    /**
     * Scope a query to filter products based on subscription tier access.
     */
    public function scopeAccessibleBy($query, $customer)
    {
        // All customers can see regular products
        $query->where('is_limited_edition', false);
        
        // Premium and Elite subscribers can also see limited edition products
        if ($customer && $customer->canAccessLimitedEdition()) {
            $query->orWhere('is_limited_edition', true);
        }
        
        return $query;
    }
}

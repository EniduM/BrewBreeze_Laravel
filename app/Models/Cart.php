<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'cart_id';

    protected $fillable = [
        'customer_id',
        'created_date',
    ];

    protected function casts(): array
    {
        return [
            'created_date' => 'datetime',
        ];
    }

    /**
     * Get the customer that owns this cart.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    /**
     * Get the cart items for this cart.
     */
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class, 'cart_id', 'cart_id');
    }

    /**
     * Get or create the active cart for a customer.
     * Ensures each customer has only ONE active cart.
     */
    public static function getOrCreateActiveCart($customerId)
    {
        return static::firstOrCreate(
            ['customer_id' => $customerId],
            ['created_date' => now()]
        );
    }

    /**
     * Calculate the total price of all items in the cart.
     */
    public function getTotalAttribute()
    {
        return $this->cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
    }

    /**
     * Get the total number of items in the cart.
     */
    public function getItemCountAttribute()
    {
        return $this->cartItems->sum('quantity');
    }

    /**
     * Scope a query to only include carts with items.
     */
    public function scopeWithItems($query)
    {
        return $query->whereHas('cartItems');
    }

    /**
     * Scope a query to only include empty carts.
     */
    public function scopeEmpty($query)
    {
        return $query->whereDoesntHave('cartItems');
    }

    /**
     * Check if cart is empty.
     */
    public function getIsEmptyAttribute()
    {
        return $this->cartItems->isEmpty();
    }

    /**
     * Get formatted total attribute.
     */
    public function getFormattedTotalAttribute()
    {
        return '$' . number_format($this->total, 2);
    }
}

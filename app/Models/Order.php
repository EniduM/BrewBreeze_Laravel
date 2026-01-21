<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'order_id';

    protected $fillable = [
        'customer_id',
        'date',
        'total',
        'status',
        'address',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'total' => 'decimal:2',
        ];
    }

    /**
     * Get the customer that placed this order.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    /**
     * Get the order items for this order.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }

    /**
     * Get the payment for this order.
     */
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class, 'order_id', 'order_id');
    }

    /**
     * Get the subscriptions placed by this order.
     */
    public function subscriptions(): BelongsToMany
    {
        return $this->belongsToMany(Subscription::class, 'order_subscription', 'order_id', 'subscription_id')
            ->withTimestamps();
    }

    /**
     * Scope a query to only include pending orders.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include paid orders.
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    /**
     * Scope a query to only include completed orders.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope a query to only include cancelled orders.
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * Get formatted total attribute.
     */
    public function getFormattedTotalAttribute()
    {
        return '$' . number_format($this->total, 2);
    }

    /**
     * Check if order is pending.
     */
    public function getIsPendingAttribute()
    {
        return $this->status === 'pending';
    }

    /**
     * Check if order is paid.
     */
    public function getIsPaidAttribute()
    {
        return $this->status === 'paid';
    }

    /**
     * Check if order is completed.
     */
    public function getIsCompletedAttribute()
    {
        return $this->status === 'completed';
    }

    /**
     * Get total items count.
     */
    public function getTotalItemsAttribute()
    {
        return $this->orderItems->sum('quantity');
    }
}

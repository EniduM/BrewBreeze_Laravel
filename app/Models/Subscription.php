<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'subscription_id';

    protected $fillable = [
        'customer_id',
        'tier',
        'start_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
        ];
    }

    /**
     * Get the customer that owns this subscription.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    /**
     * Get the orders that placed this subscription.
     */
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_subscription', 'subscription_id', 'order_id')
            ->withTimestamps();
    }

    /**
     * Scope a query to only include active subscriptions.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include pending subscriptions.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include cancelled subscriptions.
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * Scope a query to filter by tier.
     */
    public function scopeTier($query, string $tier)
    {
        return $query->where('tier', $tier);
    }

    /**
     * Get subscription tier information.
     */
    public function getTierInfoAttribute()
    {
        $tiers = config('subscriptions.tiers', []);
        return $tiers[$this->tier] ?? null;
    }

    /**
     * Get subscription tier name.
     */
    public function getTierNameAttribute()
    {
        return $this->tierInfo['name'] ?? ucfirst($this->tier);
    }

    /**
     * Get subscription tier price.
     */
    public function getTierPriceAttribute()
    {
        return $this->tierInfo['price'] ?? 0;
    }

    /**
     * Get formatted tier price.
     */
    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->tier_price, 2);
    }

    /**
     * Check if subscription is active.
     */
    public function getIsActiveAttribute()
    {
        return $this->status === 'active';
    }

    /**
     * Check if subscription is pending.
     */
    public function getIsPendingAttribute()
    {
        return $this->status === 'pending';
    }

    /**
     * Check if subscription is cancelled.
     */
    public function getIsCancelledAttribute()
    {
        return $this->status === 'cancelled';
    }

    /**
     * Get days since subscription started.
     */
    public function getDaysActiveAttribute()
    {
        return $this->start_date->diffInDays(now());
    }

    /**
     * Get next billing date (assuming monthly billing).
     */
    public function getNextBillingDateAttribute()
    {
        return $this->start_date->copy()->addMonth();
    }
}

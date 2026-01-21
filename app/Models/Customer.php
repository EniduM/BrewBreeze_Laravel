<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'customer_id';

    protected $fillable = [
        'admin_id',
        'first_name',
        'last_name',
        'name',
        'email',
        'password',
        'phone',
        'address',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * Get the admin that manages this customer.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'admin_id');
    }

    /**
     * Get the subscriptions for this customer.
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class, 'customer_id', 'customer_id');
    }

    /**
     * Get the messages sent by this customer.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'customer_id', 'customer_id');
    }

    /**
     * Get the cart for this customer.
     */
    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class, 'customer_id', 'customer_id');
    }

    /**
     * Get the orders placed by this customer.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'customer_id', 'customer_id');
    }

    /**
     * Get the active subscription for this customer.
     */
    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class, 'customer_id', 'customer_id')
            ->where('status', 'active')
            ->latest();
    }

    /**
     * Check if customer has an active subscription.
     */
    public function hasActiveSubscription(): bool
    {
        return $this->activeSubscription()->exists();
    }

    /**
     * Get the discount percentage based on subscription tier.
     */
    public function getSubscriptionDiscount(): float
    {
        $subscription = $this->activeSubscription()->first();
        
        if (!$subscription) {
            return 0;
        }

        // Discount based on tier
        return match($subscription->tier) {
            'basic' => 10,    // 10% discount
            'premium' => 15,  // 15% discount
            'elite' => 20,    // 20% discount
            default => 0,
        };
    }

    /**
     * Check if customer gets free shipping.
     */
    public function getsFreeShipping(): bool
    {
        return $this->hasActiveSubscription();
    }

    /**
     * Check if customer can access limited edition products.
     */
    public function canAccessLimitedEdition(): bool
    {
        $subscription = $this->activeSubscription()->first();
        
        if (!$subscription) {
            return false;
        }

        // Premium and Elite tiers get access to limited edition
        return in_array($subscription->tier, ['premium', 'elite']);
    }

    /**
     * Check if customer has early access to products.
     */
    public function hasEarlyAccess(): bool
    {
        $subscription = $this->activeSubscription()->first();
        
        if (!$subscription) {
            return false;
        }

        // Only Elite tier gets early access
        return $subscription->tier === 'elite';
    }

    /**
     * Get subscription tier level (null, 'basic', 'premium', 'elite').
     */
    public function getSubscriptionTier(): ?string
    {
        $subscription = $this->activeSubscription()->first();
        return $subscription ? $subscription->tier : null;
    }
}

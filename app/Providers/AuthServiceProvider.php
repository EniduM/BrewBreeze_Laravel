<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Subscription;
use App\Policies\OrderPolicy;
use App\Policies\ProductPolicy;
use App\Policies\SubscriptionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Product::class => ProductPolicy::class,
        Order::class => OrderPolicy::class,
        Subscription::class => SubscriptionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}

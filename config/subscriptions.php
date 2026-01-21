<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Subscription Tiers
    |--------------------------------------------------------------------------
    |
    | Define available subscription tiers with their pricing and features.
    |
    */

    'tiers' => [
        'basic' => [
            'name' => 'Basic Plan',
            'price' => 19.99,
            'billing_cycle' => 'monthly',
            'description' => 'Perfect for coffee enthusiasts who want regular deliveries',
            'features' => [
                '1 bag of premium coffee per month',
                'Free shipping',
                'Access to member-only discounts',
                'Cancel anytime',
            ],
        ],
        'premium' => [
            'name' => 'Premium Plan',
            'price' => 49.99,
            'billing_cycle' => 'monthly',
            'description' => 'For serious coffee lovers who want variety',
            'features' => [
                '3 bags of premium coffee per month',
                'Free shipping',
                'Access to member-only discounts',
                'Exclusive limited edition blends',
                'Priority customer support',
                'Cancel anytime',
            ],
        ],
        'elite' => [
            'name' => 'Elite Plan',
            'price' => 99.99,
            'billing_cycle' => 'monthly',
            'description' => 'The ultimate coffee subscription experience',
            'features' => [
                '6 bags of premium coffee per month',
                'Free express shipping',
                'Access to member-only discounts',
                'Exclusive limited edition blends',
                'VIP customer support',
                'Free coffee accessories included',
                'Early access to new products',
                'Cancel anytime',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Subscription Statuses
    |--------------------------------------------------------------------------
    |
    | Available subscription statuses.
    |
    */

    'statuses' => [
        'pending' => 'Pending',
        'active' => 'Active',
        'paused' => 'Paused',
        'cancelled' => 'Cancelled',
        'expired' => 'Expired',
    ],

];

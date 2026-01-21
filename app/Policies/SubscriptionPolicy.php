<?php

namespace App\Policies;

use App\Models\Subscription;
use App\Models\User;

class SubscriptionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Admins can view all subscriptions, customers can view their own subscriptions
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Subscription $subscription): bool
    {
        // Admins can view any subscription, customers can only view their own subscriptions
        return $user->isAdmin() || $user->id === $subscription->customer_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only customers can create subscriptions (subscribe)
        return $user->isCustomer();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Subscription $subscription): bool
    {
        // Only admins can update subscriptions (e.g., change tier, status)
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Subscription $subscription): bool
    {
        // Admins can delete any subscription, customers can cancel their own subscriptions
        return $user->isAdmin() || $user->id === $subscription->customer_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Subscription $subscription): bool
    {
        // Only admins can restore subscriptions
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Subscription $subscription): bool
    {
        // Only admins can permanently delete subscriptions
        return $user->isAdmin();
    }
}

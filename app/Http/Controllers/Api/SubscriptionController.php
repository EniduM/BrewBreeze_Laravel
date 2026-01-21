<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Get customer subscriptions.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $customer = $user->getOrCreateCustomer();

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to access customer account.',
            ], 403);
        }

        $subscriptions = Subscription::where('customer_id', $customer->customer_id)
            ->with('customer')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Subscriptions retrieved successfully',
            'data' => $subscriptions->map(function ($subscription) {
                return [
                    'id' => $subscription->subscription_id,
                    'tier' => $subscription->tier,
                    'tier_name' => $subscription->tier_name,
                    'tier_price' => $subscription->tier_price,
                    'formatted_price' => $subscription->formatted_price,
                    'start_date' => $subscription->start_date->toDateString(),
                    'status' => $subscription->status,
                    'is_active' => $subscription->is_active,
                    'days_active' => $subscription->days_active,
                    'next_billing_date' => $subscription->next_billing_date->toDateString(),
                    'created_at' => $subscription->created_at->toISOString(),
                ];
            }),
        ], 200);
    }

    /**
     * Create a new subscription.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'tier' => 'required|string|in:basic,premium,elite',
        ], [
            'tier.required' => 'Subscription tier is required.',
            'tier.in' => 'Invalid subscription tier. Allowed: basic, premium, elite.',
        ]);

        $user = $request->user();
        $customer = $user->getOrCreateCustomer();

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to access customer account.',
            ], 403);
        }

        // Check if customer already has an active subscription
        $activeSubscription = Subscription::where('customer_id', $customer->customer_id)
            ->where('status', 'active')
            ->first();

        if ($activeSubscription) {
            return response()->json([
                'success' => false,
                'message' => 'You already have an active subscription. Please cancel it before subscribing to a new one.',
            ], 400);
        }

        try {
            $subscription = Subscription::create([
                'customer_id' => $customer->customer_id,
                'tier' => $validated['tier'],
                'start_date' => now(),
                'status' => 'active',
            ]);

            \Illuminate\Support\Facades\Log::channel('api')->info('API Subscription created', [
                'subscription_id' => $subscription->subscription_id,
                'customer_id' => $customer->customer_id,
                'tier' => $validated['tier'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Subscription created successfully',
                'data' => [
                    'subscription' => [
                        'id' => $subscription->subscription_id,
                        'tier' => $subscription->tier,
                        'tier_name' => $subscription->tier_name,
                        'tier_price' => $subscription->tier_price,
                        'formatted_price' => $subscription->formatted_price,
                        'start_date' => $subscription->start_date->toDateString(),
                        'status' => $subscription->status,
                        'next_billing_date' => $subscription->next_billing_date->toDateString(),
                    ],
                ],
            ], 201);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::channel('api')->error('API Subscription creation failed', [
                'error' => $e->getMessage(),
                'customer_id' => $customer->customer_id,
                'tier' => $validated['tier'],
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to create subscription. Please try again.',
            ], 500);
        }
    }

    /**
     * Cancel a subscription.
     */
    public function destroy(Request $request, $subscriptionId): JsonResponse
    {
        $user = $request->user();
        $customer = $user->getOrCreateCustomer();

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to access customer account.',
            ], 403);
        }

        $subscription = Subscription::where('subscription_id', $subscriptionId)
            ->where('customer_id', $customer->customer_id)
            ->first();

        if (!$subscription) {
            return response()->json([
                'success' => false,
                'message' => 'Subscription not found.',
            ], 404);
        }

        if ($subscription->status === 'cancelled') {
            return response()->json([
                'success' => false,
                'message' => 'This subscription is already cancelled.',
            ], 400);
        }

        try {
            $subscription->update([
                'status' => 'cancelled',
            ]);

            \Illuminate\Support\Facades\Log::channel('api')->info('API Subscription cancelled', [
                'subscription_id' => $subscription->subscription_id,
                'customer_id' => $customer->customer_id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Subscription cancelled successfully',
                'data' => [
                    'subscription' => [
                        'id' => $subscription->subscription_id,
                        'tier' => $subscription->tier,
                        'status' => $subscription->status,
                    ],
                ],
            ], 200);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::channel('api')->error('API Subscription cancellation failed', [
                'error' => $e->getMessage(),
                'subscription_id' => $subscriptionId,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel subscription. Please try again.',
            ], 500);
        }
    }
}

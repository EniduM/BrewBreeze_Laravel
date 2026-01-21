<?php

namespace App\Livewire\Customer;

use App\Models\Subscription;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class SubscriptionManager extends Component
{
    public $subscriptions = [];
    public $showSubscribeForm = false;
    public $selectedTier = 'basic';
    public $tiers = [];

    protected $rules = [
        'selectedTier' => 'required|string|in:basic,premium,elite',
    ];

    protected $messages = [
        'selectedTier.required' => 'Please select a subscription tier.',
        'selectedTier.in' => 'Invalid subscription tier selected.',
    ];

    public function mount()
    {
        $this->tiers = config('subscriptions.tiers', []);
        $this->loadSubscriptions();
    }

    public function loadSubscriptions()
    {
        $customer = auth()->user()->getOrCreateCustomer();
        if ($customer) {
            $this->subscriptions = Subscription::where('customer_id', $customer->customer_id)
                ->with('customer')
                ->orderBy('created_at', 'desc')
                ->get();
        }
    }

    public function showSubscribe()
    {
        $this->showSubscribeForm = true;
    }

    public function hideSubscribe()
    {
        $this->showSubscribeForm = false;
        $this->selectedTier = 'basic';
    }

    public function subscribe()
    {
        $this->validate();

        $customer = auth()->user()->getOrCreateCustomer();
        if (!$customer) {
            session()->flash('error', 'Unable to access customer account.');
            return;
        }

        // Check if customer already has an active subscription
        $activeSubscription = Subscription::where('customer_id', $customer->customer_id)
            ->where('status', 'active')
            ->first();

        if ($activeSubscription) {
            session()->flash('error', 'You already have an active subscription. Please cancel it before subscribing to a new one.');
            return;
        }

        DB::beginTransaction();
        try {
            $subscription = Subscription::create([
                'customer_id' => $customer->customer_id,
                'tier' => $this->selectedTier,
                'start_date' => now(),
                'status' => 'active',
            ]);

            DB::commit();

            Log::channel('api')->info('Subscription created', [
                'subscription_id' => $subscription->subscription_id,
                'customer_id' => $customer->customer_id,
                'tier' => $this->selectedTier,
            ]);

            session()->flash('success', 'Subscription created successfully! Welcome to ' . $subscription->tier_name . '.');
            $this->hideSubscribe();
            $this->loadSubscriptions();
            
            // Dispatch event to refresh dashboard
            $this->dispatch('subscription-created');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('api')->error('Subscription creation failed', [
                'error' => $e->getMessage(),
                'customer_id' => $customer->customer_id,
                'tier' => $this->selectedTier,
            ]);
            session()->flash('error', 'Failed to create subscription. Please try again.');
        }
    }

    public function cancel($subscriptionId)
    {
        $customer = auth()->user()->getOrCreateCustomer();
        if (!$customer) {
            session()->flash('error', 'Unable to access customer account.');
            return;
        }

        $subscription = Subscription::where('subscription_id', $subscriptionId)
            ->where('customer_id', $customer->customer_id)
            ->first();

        if (!$subscription) {
            session()->flash('error', 'Subscription not found.');
            return;
        }

        if ($subscription->status === 'cancelled') {
            session()->flash('error', 'This subscription is already cancelled.');
            return;
        }

        DB::beginTransaction();
        try {
            $subscription->update([
                'status' => 'cancelled',
            ]);

            DB::commit();

            Log::channel('api')->info('Subscription cancelled', [
                'subscription_id' => $subscription->subscription_id,
                'customer_id' => $customer->customer_id,
            ]);

            session()->flash('success', 'Subscription cancelled successfully.');
            $this->loadSubscriptions();
            
            // Dispatch event to refresh dashboard
            $this->dispatch('subscription-cancelled');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('api')->error('Subscription cancellation failed', [
                'error' => $e->getMessage(),
                'subscription_id' => $subscriptionId,
            ]);
            session()->flash('error', 'Failed to cancel subscription. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.customer.subscription-manager', [
            'tiers' => $this->tiers,
            'subscriptions' => $this->subscriptions,
        ]);
    }
}

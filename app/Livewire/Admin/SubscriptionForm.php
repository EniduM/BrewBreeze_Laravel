<?php

namespace App\Livewire\Admin;

use App\Models\Subscription;
use Livewire\Component;

class SubscriptionForm extends Component
{
    public $subscriptionId;
    public $tier = '';
    public $status = '';
    public $start_date = '';

    protected $rules = [
        'tier' => 'required|string|max:255',
        'status' => 'required|string|max:255',
        'start_date' => 'required|date',
    ];

    public function mount($subscriptionId = null)
    {
        if ($subscriptionId) {
            $subscription = Subscription::findOrFail($subscriptionId);
            $this->subscriptionId = $subscription->subscription_id;
            $this->tier = $subscription->tier;
            $this->status = $subscription->status;
            $this->start_date = $subscription->start_date->format('Y-m-d');
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'tier' => $this->tier,
            'status' => $this->status,
            'start_date' => $this->start_date,
        ];

        if ($this->subscriptionId) {
            $subscription = Subscription::findOrFail($this->subscriptionId);
            $subscription->update($data);
            session()->flash('message', 'Subscription updated successfully.');
        }

        $this->dispatch('subscription-saved');
        $this->reset(['tier', 'status', 'start_date', 'subscriptionId']);
    }

    public function render()
    {
        return view('livewire.admin.subscription-form');
    }
}

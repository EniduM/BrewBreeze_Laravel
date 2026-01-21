<?php

namespace App\Livewire\Admin;

use App\Models\Subscription;
use Livewire\Component;
use Livewire\WithPagination;

class Subscriptions extends Component
{
    use WithPagination;

    public $search = '';
    public $showForm = false;
    public $editingSubscriptionId = null;

    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function edit($subscriptionId)
    {
        $this->editingSubscriptionId = $subscriptionId;
        $this->showForm = true;
    }

    public function closeForm()
    {
        $this->showForm = false;
        $this->editingSubscriptionId = null;
    }

    public function delete($subscriptionId)
    {
        $subscription = Subscription::findOrFail($subscriptionId);
        $subscription->delete();
        
        session()->flash('message', 'Subscription deleted successfully.');
    }

    public function render()
    {
        $query = Subscription::with('customer');

        if ($this->search) {
            $query->whereHas('customer', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            })->orWhere('tier', 'like', '%' . $this->search . '%')
              ->orWhere('status', 'like', '%' . $this->search . '%');
        }

        $subscriptions = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.admin.subscriptions', [
            'subscriptions' => $subscriptions,
        ]);
    }
}

<?php

namespace App\Livewire\Admin;

use App\Models\Message;
use Livewire\Component;
use Livewire\WithPagination;

class Messages extends Component
{
    use WithPagination;

    public $search = '';
    public $customerFilter = '';

    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCustomerFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Message::with('customer')
            ->orderBy('created_at', 'desc');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('subject', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhereHas('customer', function ($customerQuery) {
                      $customerQuery->where('name', 'like', '%' . $this->search . '%')
                                    ->orWhere('email', 'like', '%' . $this->search . '%');
                  });
            });
        }

        if ($this->customerFilter) {
            $query->where('customer_id', $this->customerFilter);
        }

        $messages = $query->paginate(15);

        // Get all customers for filter dropdown
        $customers = \App\Models\Customer::orderBy('name')->get();

        return view('livewire.admin.messages', [
            'messages' => $messages,
            'customers' => $customers,
        ]);
    }
}

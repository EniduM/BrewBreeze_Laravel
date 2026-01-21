<?php

namespace App\Livewire\Customer;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class Orders extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';

    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function getCustomer()
    {
        return auth()->user()->getOrCreateCustomer();
    }

    public function render()
    {
        $customer = $this->getCustomer();
        
        if (!$customer) {
            abort(403, 'Customer record not found.');
        }

        $query = Order::where('customer_id', $customer->customer_id)
            ->with('orderItems.product', 'payment')
            ->orderBy('created_at', 'desc');

        if ($this->search) {
            $query->where('order_id', 'like', '%' . $this->search . '%');
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        $orders = $query->paginate(10);

        return view('livewire.customer.orders', [
            'orders' => $orders,
        ]);
    }
}

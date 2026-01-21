<?php

namespace App\Livewire\Admin;

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

    public function render()
    {
        $query = Order::with('customer', 'orderItems.product');

        if ($this->search) {
            $query->whereHas('customer', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            })->orWhere('order_id', 'like', '%' . $this->search . '%');
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.admin.orders', [
            'orders' => $orders,
        ]);
    }
}

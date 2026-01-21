<?php

namespace App\Livewire\Admin;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $stats = [
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_customers' => Customer::count(),
        ];

        $recentOrders = Order::with('customer', 'orderItems.product')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return view('livewire.admin.dashboard', [
            'stats' => $stats,
            'recentOrders' => $recentOrders,
        ]);
    }
}

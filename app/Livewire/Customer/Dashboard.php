<?php

namespace App\Livewire\Customer;

use App\Models\Order;
use App\Models\Product;
use App\Models\Subscription;
use Livewire\Component;

class Dashboard extends Component
{
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

        // Get available products
        $products = Product::where('stock', '>', 0)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // Get active subscription
        $activeSubscription = Subscription::where('customer_id', $customer->customer_id)
            ->where('status', 'active')
            ->first();

        // Get recent orders
        $recentOrders = Order::where('customer_id', $customer->customer_id)
            ->with('orderItems.product')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('livewire.customer.dashboard', [
            'products' => $products,
            'activeSubscription' => $activeSubscription,
            'recentOrders' => $recentOrders,
        ]);
    }
}

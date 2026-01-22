<?php

namespace App\Livewire\Admin;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $startDate = Carbon::now()->subDays(6)->startOfDay();

        $stats = [
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_customers' => Customer::count(),
        ];

        $dailyOrders = Order::selectRaw('DATE(COALESCE(date, created_at)) as day')
            ->selectRaw('COUNT(*) as orders')
            ->selectRaw('COALESCE(SUM(total), 0) as revenue')
            ->whereDate(DB::raw('COALESCE(date, created_at)'), '>=', $startDate->toDateString())
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->keyBy('day');

        $orderTrendLabels = [];
        $orderTrendSeries = [];
        $revenueTrendSeries = [];

        for ($i = 0; $i < 7; $i++) {
            $current = $startDate->copy()->addDays($i);
            $key = $current->toDateString();

            $orderTrendLabels[] = $current->format('M j');
            $orderTrendSeries[] = (int) ($dailyOrders[$key]->orders ?? 0);
            $revenueTrendSeries[] = (float) ($dailyOrders[$key]->revenue ?? 0);
        }

        $topProducts = OrderItem::select('product_id')
            ->selectRaw('COALESCE(SUM(quantity), 0) as total_qty')
            ->selectRaw('COALESCE(SUM(quantity * price), 0) as total_revenue')
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        $recentOrders = Order::with('customer', 'orderItems.product')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return view('livewire.admin.dashboard', [
            'stats' => $stats,
            'recentOrders' => $recentOrders,
            'orderTrend' => [
                'labels' => $orderTrendLabels,
                'orders' => $orderTrendSeries,
                'revenue' => $revenueTrendSeries,
            ],
            'topProducts' => $topProducts,
        ]);
    }
}

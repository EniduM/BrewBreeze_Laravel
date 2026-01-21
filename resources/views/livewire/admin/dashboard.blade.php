<div>
    <!-- Welcome Banner -->
    <div class="bg-green-500 text-white py-4">
        <div class="container mx-auto px-4">
            <p class="text-lg font-semibold">Welcome back, Admin!</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-brew-brown mb-2">Admin Dashboard</h1>
            <p class="text-lg text-brew-dark-brown">Welcome back! Here's what's happening with your coffee shop.</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Products Card -->
            <div class="bg-white rounded-lg border border-brew-light-brown p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Total Products</p>
                        <p class="text-3xl font-bold text-brew-brown">{{ $stats['total_products'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-brew-light-brown rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-brew-brown" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Orders Card -->
            <div class="bg-white rounded-lg border border-brew-light-brown p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Total Orders</p>
                        <p class="text-3xl font-bold text-brew-brown">{{ $stats['total_orders'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-brew-light-brown rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-brew-brown" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Customers Card -->
            <div class="bg-white rounded-lg border border-brew-light-brown p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Total Customers</p>
                        <p class="text-3xl font-bold text-brew-brown">{{ $stats['total_customers'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-brew-light-brown rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-brew-brown" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Action Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Manage Products -->
            <a href="{{ route('admin.products.index') }}" class="bg-white rounded-lg border border-brew-light-brown p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-brew-light-brown rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-brew-brown" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-brew-brown">Manage Products</h3>
                </div>
                <p class="text-lg text-brew-dark-brown">Add, edit, or remove products</p>
            </a>

            <!-- View Orders -->
            <a href="{{ route('admin.orders.index') }}" class="bg-white rounded-lg border border-brew-light-brown p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-brew-light-brown rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-brew-brown" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-brew-brown">View Orders</h3>
                </div>
                <p class="text-lg text-brew-dark-brown">Monitor customer orders</p>
            </a>

            <!-- Manage Users -->
            <a href="{{ route('admin.subscriptions.index') }}" class="bg-white rounded-lg border border-brew-light-brown p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-brew-light-brown rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-brew-brown" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-brew-brown">Manage Users</h3>
                </div>
                <p class="text-lg text-brew-dark-brown">View customer accounts</p>
            </a>

            <!-- Add Product -->
            <a href="{{ route('admin.products.index') }}" class="bg-white rounded-lg border border-brew-light-brown p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-brew-light-brown rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-brew-brown" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-brew-brown">Add Product</h3>
                </div>
                <p class="text-lg text-brew-dark-brown">Create new product listing</p>
            </a>
        </div>

        <!-- Recent Orders Table -->
        <div class="bg-white rounded-lg border border-brew-light-brown shadow-sm overflow-hidden">
            <div class="p-6 border-b border-brew-light-brown">
                <h2 class="text-2xl font-bold text-brew-brown">Recent Orders</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ORDER ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CUSTOMER</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">TOTAL</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">STATUS</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DATE</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ACTION</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recentOrders as $order)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $order->order_id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->customer->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($order->total, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'processing' => 'bg-blue-100 text-blue-800',
                                            'completed' => 'bg-green-100 text-green-800',
                                            'cancelled' => 'bg-red-100 text-red-800',
                                            'paid' => 'bg-green-100 text-green-800',
                                        ];
                                        $color = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->date ? $order->date->format('M j, Y') : ($order->created_at ? $order->created_at->format('M j, Y') : 'N/A') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.orders.index') }}" class="text-brew-brown hover:text-brew-dark-brown">View Details</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">No orders found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-brew-light-brown text-center">
                <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center px-4 py-2 bg-brew-brown text-white rounded-lg hover:bg-brew-dark-brown transition font-medium">
                    View All Orders
                </a>
            </div>
        </div>
    </div>
</div>
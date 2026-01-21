<div>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-4xl md:text-5xl font-display font-bold text-brew-brown">Welcome, {{ auth()->user()->name }}!</h1>
                    <p class="mt-2 text-base text-brew-brown/70 font-sans">Your coffee subscription dashboard</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('customer.message') }}" class="inline-flex items-center px-5 py-3 bg-brew-light-brown hover:bg-brew-orange text-white font-sans font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Contact Us
                    </a>
                    <a href="{{ route('customer.cart') }}" class="inline-flex items-center px-5 py-3 bg-brew-light-brown hover:bg-brew-orange text-white font-sans font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        View Cart
                    </a>
                </div>
            </div>

            <!-- Active Subscription Card -->
            @if($activeSubscription)
                <div class="bg-white/95 backdrop-blur-lg shadow-xl rounded-2xl mb-8 border border-brew-light-brown/20 overflow-hidden">
                    <div class="p-6 md:p-8">
                        <h2 class="text-2xl font-display font-bold text-brew-brown mb-6">Active Subscription</h2>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xl font-bold text-brew-brown font-display">{{ $activeSubscription->tier }} Tier</p>
                                <p class="text-sm text-brew-brown/60 font-sans mt-1">Started: {{ $activeSubscription->start_date->format('M d, Y') }}</p>
                            </div>
                            <span class="px-4 py-2 text-sm font-bold rounded-full bg-green-100 text-green-800 font-sans uppercase tracking-wider">
                                {{ ucfirst($activeSubscription->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-amber-50/90 backdrop-blur-lg border-2 border-amber-300/50 rounded-2xl p-6 mb-8 shadow-lg">
                    <p class="text-amber-800 font-sans font-medium">You don't have an active subscription yet.</p>
                </div>
            @endif

            <!-- Available Products Section -->
            <div class="bg-white/95 backdrop-blur-lg shadow-xl rounded-2xl mb-8 border border-brew-light-brown/20 overflow-hidden">
                <div class="p-6 md:p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-display font-bold text-brew-brown">Available Products</h2>
                        <a href="{{ route('customer.products') }}" class="text-brew-light-brown hover:text-brew-orange font-sans font-bold transition-colors flex items-center gap-2">
                            View All 
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($products as $product)
                            <div class="border-2 border-brew-light-brown/20 rounded-xl overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 bg-white">
                                @if($product->image_url)
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                                @else
                                    <div class="w-full h-48 bg-gradient-to-br from-brew-cream to-brew-light-brown/20 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-brew-brown/30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="p-5">
                                    <h3 class="font-display font-bold text-xl text-brew-brown mb-2">{{ $product->name }}</h3>
                                    <p class="text-sm text-brew-brown/70 mb-4 line-clamp-2 font-sans">{{ $product->description }}</p>
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="text-xl font-bold text-brew-light-brown font-display">${{ number_format($product->price, 2) }}</p>
                                            <p class="text-xs text-brew-brown/50 font-sans">Stock: {{ $product->stock }}</p>
                                        </div>
                                        <a 
                                            href="{{ route('customer.products') }}"
                                            class="px-5 py-2.5 bg-brew-light-brown hover:bg-brew-orange text-white text-sm font-sans font-bold rounded-xl transition-all duration-200 inline-block text-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                                        >
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-3 text-center py-12 text-brew-brown/60 font-sans">
                                No products available at the moment.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Orders Section -->
            <div class="bg-white/95 backdrop-blur-lg shadow-xl rounded-2xl border border-brew-light-brown/20 overflow-hidden">
                <div class="p-6 md:p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-display font-bold text-brew-brown">Recent Orders</h2>
                        <a href="{{ route('customer.orders') }}" class="text-brew-light-brown hover:text-brew-orange font-sans font-bold transition-colors flex items-center gap-2">
                            View All 
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                    @if($recentOrders->count() > 0)
                        <div class="overflow-x-auto rounded-xl border border-brew-light-brown/20">
                            <table class="min-w-full divide-y divide-brew-light-brown/20">
                                <thead class="bg-brew-cream/50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-brew-brown uppercase tracking-wider font-sans">Order ID</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-brew-brown uppercase tracking-wider font-sans">Date</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-brew-brown uppercase tracking-wider font-sans">Total</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-brew-brown uppercase tracking-wider font-sans">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-brew-light-brown/10">
                                    @foreach($recentOrders as $order)
                                        <tr class="hover:bg-brew-cream/30 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-brew-brown font-sans">#{{ $order->order_id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-brew-brown/70 font-sans">{{ $order->date->format('M d, Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-brew-brown font-sans">${{ number_format($order->total, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-3 py-1.5 inline-flex text-xs leading-5 font-bold rounded-full font-sans uppercase tracking-wider
                                                    {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                                       ($order->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-brew-brown/60 text-center py-12 font-sans">You haven't placed any orders yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

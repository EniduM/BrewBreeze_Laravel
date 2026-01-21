<div>
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Page Header -->
        <div class="mb-10">
            <h1 class="text-4xl md:text-5xl font-display font-bold text-brew-cream mb-3">My Orders</h1>
            <p class="text-lg text-brew-cream/80 font-sans">Track your coffee orders and manage your purchase history.</p>
        </div>

        @if (session()->has('success'))
            <div class="mb-6 bg-green-50/90 backdrop-blur-lg border-2 border-green-300/50 text-green-800 px-6 py-4 rounded-2xl shadow-lg" role="alert">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-sans font-semibold">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-6 bg-red-50/90 backdrop-blur-lg border-2 border-red-300/50 text-red-800 px-6 py-4 rounded-2xl shadow-lg" role="alert">
                <span class="block sm:inline font-sans font-semibold">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Search and Filter -->
        <div class="bg-white/95 backdrop-blur-lg rounded-2xl border-2 border-brew-light-brown/20 p-6 mb-8 shadow-xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <input 
                        type="text" 
                        wire:model.live="search" 
                        placeholder="Search by order ID..." 
                        class="w-full px-5 py-3 border-2 border-brew-light-brown/30 rounded-xl focus:outline-none focus:ring-2 focus:ring-brew-light-brown focus:border-brew-light-brown bg-white text-brew-brown font-sans placeholder:text-brew-brown/50 transition-all"
                    >
                </div>
                <div>
                    <select 
                        wire:model.live="statusFilter" 
                        class="w-full px-5 py-3 border-2 border-brew-light-brown/30 rounded-xl focus:outline-none focus:ring-2 focus:ring-brew-light-brown focus:border-brew-light-brown bg-white text-brew-brown font-sans font-semibold transition-all"
                    >
                        <option value="">All Statuses</option>
                        <option value="pending">Pending</option>
                        <option value="paid">Paid</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Orders List -->
        @if($orders->count() > 0)
            <div class="space-y-6">
                @foreach($orders as $order)
                    <div class="bg-white/95 backdrop-blur-lg rounded-2xl border-2 border-brew-light-brown/20 overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="p-6 md:p-8">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                                <div>
                                    <h3 class="text-2xl font-display font-bold text-brew-brown mb-2">Order #{{ $order->order_id }}</h3>
                                    <p class="text-sm text-brew-brown/60 font-sans">Placed on {{ $order->date->format('M d, Y') }}</p>
                                </div>
                                <div class="text-left md:text-right">
                                    <span class="inline-block px-4 py-2 text-xs font-bold rounded-full font-sans uppercase tracking-wider
                                        {{ $order->status === 'paid' ? 'bg-green-100 text-green-800' : 
                                           ($order->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                    <p class="text-2xl font-display font-bold text-brew-light-brown mt-3">${{ number_format($order->total, 2) }}</p>
                                </div>
                            </div>

                            <!-- Order Items -->
                            <div class="border-t-2 border-brew-light-brown/10 pt-6 mt-4">
                                <h4 class="text-sm font-bold text-brew-brown mb-4 font-sans uppercase tracking-wider">Order Items:</h4>
                                <div class="space-y-4">
                                    @foreach($order->orderItems as $orderItem)
                                        <div class="flex justify-between items-center bg-brew-cream/30 rounded-xl p-4">
                                            <div class="flex items-center space-x-4">
                                                <div class="w-16 h-16 bg-gradient-to-br from-brew-cream to-brew-light-brown/20 rounded-xl flex items-center justify-center overflow-hidden">
                                                    @if($orderItem->product->image_url)
                                                        <img src="{{ $orderItem->product->image_url }}" alt="{{ $orderItem->product->name }}" class="w-full h-full object-cover">
                                                    @else
                                                        <svg class="w-8 h-8 text-brew-brown/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                                        </svg>
                                                    @endif
                                                </div>
                                                <div>
                                                    <p class="font-display font-bold text-brew-brown text-lg">{{ $orderItem->product->name }}</p>
                                                    <p class="text-brew-brown/60 font-sans text-sm">Qty: {{ $orderItem->quantity }} × ${{ number_format($orderItem->price, 2) }}</p>
                                                </div>
                                            </div>
                                            <p class="font-display font-bold text-brew-brown text-lg">${{ number_format($orderItem->quantity * $orderItem->price, 2) }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Payment Info -->
                            @if($order->payment)
                                <div class="border-t-2 border-brew-light-brown/10 pt-6 mt-6">
                                    <div class="grid grid-cols-2 gap-4 text-sm">
                                        <div class="bg-brew-cream/30 rounded-xl p-4">
                                            <span class="text-brew-brown/60 font-sans block mb-1">Payment Method</span>
                                            <span class="font-sans font-bold text-brew-brown capitalize">{{ str_replace('_', ' ', $order->payment->method) }}</span>
                                        </div>
                                        <div class="bg-brew-cream/30 rounded-xl p-4">
                                            <span class="text-brew-brown/60 font-sans block mb-1">Payment Date</span>
                                            <span class="font-sans font-bold text-brew-brown">{{ $order->payment->date->format('M d, Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- View Details Link -->
                            <div class="border-t-2 border-brew-light-brown/10 pt-6 mt-6">
                                <a href="{{ route('customer.orders.show', $order->order_id) }}" class="inline-flex items-center px-6 py-3 bg-brew-light-brown hover:bg-brew-orange text-white font-sans font-bold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    View Full Details
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-10">
                {{ $orders->links() }}
            </div>
        @else
            <div class="bg-white/95 backdrop-blur-lg rounded-2xl border-2 border-brew-light-brown/20 p-12 text-center shadow-xl">
                <div class="bg-gradient-to-br from-brew-brown to-brew-light-brown rounded-2xl p-8 mb-6 inline-block">
                    <svg class="w-20 h-20 text-white mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <h3 class="text-3xl font-display font-bold text-brew-brown mb-3">No Orders Yet</h3>
                <p class="text-brew-brown/70 font-sans font-semibold text-lg mb-2">Start Your Coffee Journey</p>
                <p class="text-sm text-brew-brown/60 font-sans mb-8 max-w-md mx-auto">Discover our premium coffee collection and place your first order to see it here.</p>
                <a href="{{ route('customer.products') }}" class="inline-flex items-center px-8 py-4 bg-brew-light-brown text-white rounded-xl hover:bg-brew-orange transition-all duration-200 font-sans font-bold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Browse Coffee Menu
                </a>
            </div>
        @endif
    </div>
</div>

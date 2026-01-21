<div>
    <div class="max-w-7xl mx-auto">
        <!-- Back Link -->
        <div class="mb-8">
            <a href="{{ route('customer.orders') }}" class="inline-flex items-center px-4 py-2 bg-brew-brown hover:bg-brew-dark-brown text-white font-medium rounded-lg transition-all duration-200 shadow-md hover:shadow-lg group">
                <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Orders
            </a>
        </div>

        <!-- Order Header with Coffee Theme -->
        <div class="bg-gradient-to-br from-brew-brown via-brew-dark-brown to-brew-brown rounded-2xl shadow-xl mb-8 overflow-hidden">
            <div class="p-8">
                <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-6">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="bg-brew-light-brown p-3 rounded-full shadow-lg">
                                <svg class="w-8 h-8 text-brew-cream" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-4xl font-bold text-brew-cream mb-1">Order #{{ $order->order_id }}</h1>
                                <div class="flex items-center text-brew-cream/80 text-sm">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Placed on {{ $order->date->format('F d, Y') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col items-end gap-3">
                        <span class="px-5 py-2.5 text-sm font-bold rounded-full shadow-lg transform hover:scale-105 transition-transform duration-200
                            {{ $order->status === 'paid' ? 'bg-green-500 text-white' : 
                               ($order->status === 'cancelled' ? 'bg-red-500 text-white' : 'bg-yellow-500 text-white') }}">
                            <span class="flex items-center gap-2">
                                @if($order->status === 'paid')
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                @endif
                                {{ ucfirst($order->status) }}
                            </span>
                        </span>
                        <div class="text-right bg-brew-light-brown px-6 py-3 rounded-xl shadow-lg">
                            <p class="text-xs text-brew-brown/80 font-semibold uppercase tracking-wide">Total Amount</p>
                            <p class="text-3xl font-bold text-brew-cream">${{ number_format($order->total, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items with Enhanced Design -->
        <div class="bg-white rounded-2xl shadow-lg mb-8 overflow-hidden border-2 border-brew-light-brown">
            <div class="bg-gradient-to-r from-brew-brown to-brew-dark-brown px-8 py-5 border-b-4 border-brew-light-brown">
                <div class="flex items-center gap-3">
                    <div class="bg-brew-light-brown p-2 rounded-lg">
                        <svg class="w-6 h-6 text-brew-cream" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-brew-cream">Your Coffee Selection</h2>
                </div>
            </div>
            <div class="p-8">
                <div class="space-y-6">
                    @foreach($order->orderItems as $index => $orderItem)
                        <div class="group relative bg-gradient-to-br from-brew-cream to-white rounded-xl border-2 border-brew-light-brown p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            <!-- Item Number Badge -->
                            <div class="absolute -top-3 -left-3 bg-brew-light-brown text-brew-cream w-10 h-10 rounded-full flex items-center justify-center font-bold text-lg shadow-lg">
                                {{ $index + 1 }}
                            </div>
                            
                            <div class="flex flex-col md:flex-row md:items-center gap-6">
                                <!-- Product Image -->
                                @if($orderItem->product->image_url)
                                    <div class="relative flex-shrink-0">
                                        <div class="w-32 h-32 rounded-xl overflow-hidden shadow-lg ring-4 ring-brew-light-brown/30 group-hover:ring-brew-light-brown/60 transition-all duration-300">
                                            <img src="{{ $orderItem->product->image_url }}" alt="{{ $orderItem->product->name }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-300">
                                        </div>
                                        <!-- Steam Effect on Hover -->
                                        <div class="absolute -top-2 -right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                            <svg class="w-8 h-8 text-brew-orange animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"/>
                                            </svg>
                                        </div>
                                    </div>
                                @endif
                                
                                <!-- Product Details -->
                                <div class="flex-1">
                                    <h3 class="text-2xl font-bold text-brew-brown mb-2 group-hover:text-brew-light-brown transition-colors duration-200">{{ $orderItem->product->name }}</h3>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                                        <div class="bg-white rounded-lg px-4 py-2 border border-brew-light-brown/30">
                                            <p class="text-gray-600 font-semibold text-xs uppercase tracking-wide">Quantity</p>
                                            <p class="font-bold text-brew-brown text-lg">{{ $orderItem->quantity }}×</p>
                                        </div>
                                        <div class="bg-white rounded-lg px-4 py-2 border border-brew-light-brown/30">
                                            <p class="text-gray-600 font-semibold text-xs uppercase tracking-wide">Unit Price</p>
                                            <p class="font-bold text-brew-brown text-lg">${{ number_format($orderItem->price, 2) }}</p>
                                        </div>
                                        <div class="bg-brew-light-brown rounded-lg px-4 py-2 col-span-2 md:col-span-1">
                                            <p class="text-brew-cream text-xs uppercase tracking-wide">Subtotal</p>
                                            <p class="font-bold text-brew-cream text-xl">${{ number_format($orderItem->quantity * $orderItem->price, 2) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Order Details Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column: Delivery & Payment -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Delivery Address -->
                @if($order->address)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-2 border-brew-light-brown transform hover:scale-[1.02] transition-transform duration-200">
                        <div class="bg-gradient-to-r from-brew-brown to-brew-dark-brown px-6 py-4 border-b-4 border-brew-light-brown">
                            <div class="flex items-center gap-3">
                                <div class="bg-brew-light-brown p-2 rounded-lg">
                                    <svg class="w-5 h-5 text-brew-cream" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <h2 class="text-xl font-bold text-brew-cream">Delivery Address</h2>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="bg-brew-cream rounded-lg p-4 border-l-4 border-brew-light-brown">
                                <p class="text-brew-brown font-semibold text-lg">{{ $order->address }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Payment Information -->
                @if($order->payment)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-2 border-brew-light-brown transform hover:scale-[1.02] transition-transform duration-200">
                        <div class="bg-gradient-to-r from-brew-brown to-brew-dark-brown px-6 py-4 border-b-4 border-brew-light-brown">
                            <div class="flex items-center gap-3">
                                <div class="bg-brew-light-brown p-2 rounded-lg">
                                    <svg class="w-5 h-5 text-brew-cream" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                    </svg>
                                </div>
                                <h2 class="text-xl font-bold text-brew-cream">Payment Information</h2>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                <div class="flex items-center justify-between bg-brew-cream rounded-lg p-4 border border-brew-light-brown">
                                    <div class="flex items-center gap-3">
                                        <div class="bg-brew-light-brown p-2 rounded-full">
                                            <svg class="w-5 h-5 text-brew-cream" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-600 font-semibold uppercase tracking-wide">Payment Method</p>
                                            <p class="font-bold text-brew-brown capitalize text-lg">{{ str_replace('_', ' ', $order->payment->method) }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between bg-brew-cream rounded-lg p-4 border border-brew-light-brown">
                                    <div class="flex items-center gap-3">
                                        <div class="bg-green-500 p-2 rounded-full">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-600 font-semibold uppercase tracking-wide">Amount Paid</p>
                                            <p class="font-bold text-green-700 text-xl">${{ number_format($order->payment->amount, 2) }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between bg-brew-cream rounded-lg p-4 border border-brew-light-brown">
                                    <div class="flex items-center gap-3">
                                        <div class="bg-brew-light-brown p-2 rounded-full">
                                            <svg class="w-5 h-5 text-brew-cream" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-600 font-semibold uppercase tracking-wide">Payment Date</p>
                                            <p class="font-bold text-brew-brown text-lg">{{ $order->payment->date->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Column: Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-gradient-to-br from-brew-brown via-brew-dark-brown to-brew-brown rounded-2xl shadow-2xl overflow-hidden border-4 border-brew-light-brown sticky top-6">
                    <div class="bg-brew-light-brown px-6 py-4 border-b-4 border-brew-cream">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6 text-brew-cream" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                            <h2 class="text-xl font-bold text-brew-cream">Order Summary</h2>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <!-- Items Count -->
                            <div class="bg-brew-cream/10 rounded-lg p-4 border border-brew-light-brown/30">
                                <div class="flex items-center justify-between">
                                    <span class="text-brew-cream/80 font-medium">Items</span>
                                    <span class="font-bold text-brew-cream text-lg">{{ $order->orderItems->count() }}</span>
                                </div>
                            </div>
                            
                            <!-- Subtotal -->
                            <div class="bg-brew-cream/10 rounded-lg p-4 border border-brew-light-brown/30">
                                <div class="flex items-center justify-between">
                                    <span class="text-brew-cream/80 font-medium">Subtotal</span>
                                    <span class="font-bold text-brew-cream text-lg">${{ number_format($order->total, 2) }}</span>
                                </div>
                            </div>
                            
                            <!-- Shipping -->
                            <div class="bg-brew-cream/10 rounded-lg p-4 border border-brew-light-brown/30">
                                <div class="flex items-center justify-between">
                                    <span class="text-brew-cream/80 font-medium">Shipping</span>
                                    <div class="flex items-center gap-2">
                                        <span class="px-2 py-1 bg-green-500 text-white text-xs font-bold rounded-full">FREE</span>
                                        <span class="font-bold text-brew-cream">$0.00</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Divider -->
                            <div class="border-t-2 border-brew-light-brown my-4"></div>
                            
                            <!-- Total -->
                            <div class="bg-brew-light-brown rounded-xl p-5 shadow-xl">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-brew-brown text-sm font-semibold uppercase tracking-wide">Grand Total</p>
                                        <p class="text-xs text-brew-brown/70 mt-1">All taxes included</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-3xl font-bold text-brew-cream">${{ number_format($order->total, 2) }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="space-y-3 pt-4">
                                <button wire:click="printReceipt" class="w-full bg-brew-cream hover:bg-white text-brew-brown font-bold py-3 px-4 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center gap-2 group">
                                    <svg class="w-5 h-5 group-hover:rotate-12 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                    </svg>
                                    Print Receipt
                                </button>
                                <a href="{{ route('customer.products') }}" class="w-full bg-brew-orange hover:bg-brew-orange/90 text-black font-bold py-3 px-4 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center gap-2 group">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    Order Again
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Spacing before footer -->
    <div class="h-12"></div>
</div>

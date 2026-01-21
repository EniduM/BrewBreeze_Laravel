<div>
    @if (session()->has('message'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Subscription Benefits Banner -->
    @if($subscription && $subscription->is_active)
        <div class="mb-6 bg-gradient-to-r from-green-50 to-blue-50 border-2 border-green-300 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="bg-green-500 rounded-full p-2">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-green-800 text-lg">{{ $subscription->tier_name }} Subscriber</h3>
                        <p class="text-sm text-green-700">
                            @if($subscription->tier === 'basic')
                                Enjoy 10% discount and FREE shipping on all orders!
                            @elseif($subscription->tier === 'premium')
                                Enjoy 15% discount, FREE shipping, and access to Limited Edition blends!
                            @elseif($subscription->tier === 'elite')
                                Enjoy 20% discount, FREE express shipping, and exclusive Elite benefits!
                            @endif
                        </p>
                    </div>
                </div>
                <a href="{{ route('customer.subscriptions') }}" class="text-green-700 hover:text-green-900 text-sm font-semibold underline">
                    Manage Subscription
                </a>
            </div>
        </div>
    @elseif($customer)
        <div class="mb-6 bg-yellow-50 border border-yellow-300 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-yellow-800">Unlock Exclusive Benefits!</h3>
                    <p class="text-sm text-yellow-700">Subscribe to get 10-20% discounts, FREE shipping, and access to Limited Edition products.</p>
                </div>
                <a href="{{ route('customer.subscriptions') }}" class="px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white font-semibold rounded-lg transition">
                    View Plans
                </a>
            </div>
        </div>
    @endif

    <!-- Search Bar -->
    <div class="mb-8">
        <div class="flex gap-3 max-w-3xl mx-auto">
            <input 
                type="text" 
                wire:model.live="search" 
                placeholder="Search coffee..." 
                class="flex-1 px-6 py-4 border-2 border-brew-brown/20 rounded-2xl focus:outline-none focus:ring-2 focus:ring-brew-light-brown focus:border-transparent bg-white shadow-md transition-all duration-300"
            >
            <button type="button" class="px-8 py-4 bg-brew-light-brown text-white font-semibold rounded-2xl hover:bg-brew-orange hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300">
                Search
            </button>
        </div>
    </div>

    <!-- Filter & Sort Section -->
    <div class="bg-white rounded-2xl p-6 mb-12 shadow-lg border border-brew-brown/10">
        <div class="flex items-center mb-6">
            <svg class="w-5 h-5 mr-3 text-brew-light-brown" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
            </svg>
            <h3 class="font-semibold text-brew-brown text-lg">Filter & Sort</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <select wire:model.live="roastLevel" class="px-4 py-3 border-2 border-brew-brown/20 rounded-xl focus:outline-none focus:ring-2 focus:ring-brew-light-brown focus:border-transparent bg-white shadow-sm transition-all duration-300">
                <option value="all">All Roast Levels</option>
                @foreach($roastLevels as $level)
                    <option value="{{ $level }}">{{ $level }}</option>
                @endforeach
            </select>
            <select wire:model.live="origin" class="px-4 py-3 border-2 border-brew-brown/20 rounded-xl focus:outline-none focus:ring-2 focus:ring-brew-light-brown focus:border-transparent bg-white shadow-sm transition-all duration-300">
                <option value="all">All Origins</option>
                @foreach($origins as $originItem)
                    <option value="{{ $originItem }}">{{ $originItem }}</option>
                @endforeach
            </select>
            <select wire:model.live="sortBy" class="px-4 py-3 border-2 border-brew-brown/20 rounded-xl focus:outline-none focus:ring-2 focus:ring-brew-light-brown focus:border-transparent bg-white shadow-sm transition-all duration-300">
                <option value="name">Name</option>
                <option value="price">Price</option>
                <option value="stock">Stock</option>
            </select>
            <select wire:model.live="sortOrder" class="px-4 py-3 border-2 border-brew-brown/20 rounded-xl focus:outline-none focus:ring-2 focus:ring-brew-light-brown focus:border-transparent bg-white shadow-sm transition-all duration-300">
                <option value="asc">Ascending (A-Z)</option>
                <option value="desc">Descending (Z-A)</option>
            </select>
        </div>
        <div class="flex justify-end gap-3">
            <button type="button" wire:click="applyFilters" class="px-6 py-3 bg-brew-light-brown text-white font-semibold rounded-xl hover:bg-brew-orange hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300">
                Apply Filters
            </button>
            <button type="button" wire:click="clearFilters" class="px-6 py-3 bg-white border-2 border-brew-light-brown text-brew-brown font-semibold rounded-xl hover:bg-brew-light-brown hover:text-white hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300">
                Clear All
            </button>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        @forelse($products as $product)
            <div class="group bg-white rounded-2xl border border-brew-brown/10 overflow-hidden hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 relative flex flex-col h-full">
                <!-- Limited Edition Badge -->
                @if($product->is_limited_edition)
                    <div class="absolute top-2 right-2 z-10">
                        <span class="px-2 py-1 bg-purple-600 text-white text-xs font-bold rounded-full shadow-lg">
                            ⭐ Limited Edition
                        </span>
                    </div>
                @endif
                
                <!-- Product Image -->
                <div class="w-full h-48 bg-gradient-to-br from-brew-cream to-brew-light-brown/20 flex items-center justify-center relative overflow-hidden">
                    @if($product->image_url)
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <svg class="w-16 h-16 text-brew-brown/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    @endif
                    
                    @if($product->is_limited_edition && (!$customer || !$customer->canAccessLimitedEdition()))
                        <!-- Limited Edition Overlay for non-subscribers -->
                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                            <div class="text-center text-white p-4">
                                <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                <p class="text-sm font-semibold">Premium/Elite Only</p>
                                <p class="text-xs mt-1">Subscribe to access</p>
                            </div>
                        </div>
                    @endif
                </div>
                
                <div class="p-5 flex flex-col flex-grow">
                    <!-- Origin and Limited Edition Badge -->
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-xs text-brew-light-brown font-semibold uppercase tracking-wider">{{ strtoupper(explode(' ', $product->name)[0] ?? 'PREMIUM') }}</p>
                        @if($product->is_limited_edition && $customer && $customer->canAccessLimitedEdition())
                            <span class="px-2 py-1 bg-purple-100 text-purple-700 text-xs font-bold rounded-lg">⭐ Limited</span>
                        @endif
                    </div>
                    
                    <!-- Product Name -->
                    <h3 class="font-display font-bold text-xl text-brew-brown mb-3 group-hover:text-brew-light-brown transition-colors duration-300 min-h-[3.5rem] line-clamp-2">{{ $product->name }}</h3>
                    
                    <!-- Description -->
                    <p class="text-sm text-gray-600 mb-4 line-clamp-2 leading-relaxed min-h-[2.5rem]">{{ $product->description }}</p>
                    
                    <!-- Spacer to push price and buttons to bottom -->
                    <div class="flex-grow"></div>
                    
                    <!-- Price and Stock -->
                    <div class="mb-4">
                        <div class="flex justify-between items-center">
                            @php
                                $discountPercent = $customer ? $customer->getSubscriptionDiscount() : 0;
                                $originalPrice = $product->price;
                                $discountedPrice = $discountPercent > 0 ? $originalPrice * (1 - $discountPercent / 100) : $originalPrice;
                            @endphp
                            <div class="flex-grow">
                                @if($discountPercent > 0)
                                    <div class="flex flex-col space-y-1">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-2xl font-bold text-brew-brown">${{ number_format($discountedPrice, 2) }}</span>
                                            <span class="text-sm text-gray-500 line-through">${{ number_format($originalPrice, 2) }}</span>
                                        </div>
                                        <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-lg inline-block w-fit">{{ $discountPercent }}% OFF</span>
                                    </div>
                                @else
                                    <span class="text-2xl font-bold text-brew-brown">${{ number_format($product->price, 2) }}</span>
                                @endif
                            </div>
                            <span class="px-3 py-1.5 bg-brew-light-brown/10 text-brew-brown text-xs font-semibold rounded-full whitespace-nowrap ml-2">{{ $product->roast_level ?? 'Medium' }}</span>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex gap-3">
                        @auth
                            @if(auth()->user()->isAdmin())
                                <!-- Admin view-only button -->
                                <div class="w-full px-4 py-3 bg-gray-100 text-gray-500 rounded-xl text-center text-sm font-semibold">
                                    View Only
                                </div>
                            @else
                                @if($product->is_limited_edition && (!$customer || !$customer->canAccessLimitedEdition()))
                                    <button 
                                        disabled
                                        class="flex-1 px-4 py-3 bg-gray-200 text-gray-500 rounded-xl cursor-not-allowed text-sm font-semibold"
                                        title="Subscribe to Premium or Elite plan to access Limited Edition products"
                                    >
                                        Premium/Elite Only
                                    </button>
                                    <a href="{{ route('customer.subscriptions') }}" 
                                       class="flex-1 px-4 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-xl transition-all duration-300 text-sm font-semibold text-center hover:shadow-lg">
                                        Subscribe
                                    </a>
                                @else
                                    <a href="{{ route('customer.products.show', $product->product_id) }}" 
                                       class="flex-1 text-center px-4 py-3 border-2 border-brew-light-brown text-brew-brown rounded-xl hover:bg-brew-light-brown hover:text-white hover:shadow-lg transition-all duration-300 text-sm font-semibold">
                                        View Details
                                    </a>
                                    <button 
                                        wire:click="addToCart({{ $product->product_id }})"
                                        @if($product->stock <= 0) disabled @endif
                                        class="flex-1 px-4 py-3 bg-brew-light-brown hover:bg-brew-orange disabled:bg-gray-300 disabled:cursor-not-allowed text-white rounded-xl transition-all duration-300 text-sm font-semibold hover:shadow-lg"
                                    >
                                        @if($product->stock > 0)
                                            Add to Cart
                                        @else
                                            Out of Stock
                                        @endif
                                    </button>
                                @endif
                            @endif
                        @else
                            <a href="{{ route('customer.products.show', $product->product_id) }}" 
                               class="flex-1 text-center px-4 py-3 border-2 border-brew-light-brown text-brew-brown rounded-xl hover:bg-brew-light-brown hover:text-white hover:shadow-lg transition-all duration-300 text-sm font-semibold">
                                View Details
                            </a>
                            <a href="{{ route('customer.login') }}" 
                               class="flex-1 px-4 py-3 bg-brew-light-brown hover:bg-brew-orange text-white rounded-xl transition-all duration-300 text-sm font-semibold text-center hover:shadow-lg">
                                Login to Order
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-lg">No products found.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $products->links() }}
    </div>
</div>

@script
<script>
    $wire.on('toast-notification', (event) => {
        window.dispatchEvent(new CustomEvent('toast-notification', {
            detail: event
        }));
    });
</script>
@endscript

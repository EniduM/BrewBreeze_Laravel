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

    <!-- Back Link -->
    <div class="mb-6">
        <a href="{{ route('customer.products') }}" class="inline-flex items-center text-brew-light-brown hover:text-brew-orange font-medium transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Products
        </a>
    </div>

    <!-- Product Detail Section -->
    <div class="bg-brew-cream rounded-2xl border border-brew-light-brown shadow-sm overflow-hidden mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8 p-6 lg:p-8">
            <!-- Product Image -->
            <div class="relative max-w-full">
                <div class="aspect-square w-full max-w-md mx-auto md:max-w-full bg-brew-light-brown rounded-2xl overflow-hidden flex items-center justify-center">
                    @if($product->image_url)
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <svg class="w-32 h-32 text-brew-brown" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    @endif
                    
                    @if($product->is_limited_edition)
                        <div class="absolute top-4 right-4">
                            <span class="px-3 py-1 bg-purple-600 text-white text-sm font-bold rounded-full shadow-lg">
                                ⭐ Limited Edition
                            </span>
                        </div>
                    @endif
                    
                    @if($product->is_limited_edition && !$canAccess)
                                        <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center rounded-2xl">
                            <div class="text-center text-white p-6">
                                <svg class="w-16 h-16 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                <p class="text-lg font-semibold mb-2">Premium/Elite Only</p>
                                <p class="text-sm mb-4">Subscribe to Premium or Elite plan to access this Limited Edition product</p>
                                <a href="{{ route('customer.subscriptions') }}" class="inline-block px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg transition">
                                    View Plans
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
                
                        @if($product->stock > 0 && $product->stock < 10)
                    <div class="mt-4 bg-yellow-50 border border-yellow-200 rounded-xl p-3">
                        <p class="text-sm text-yellow-800">
                            <span class="font-semibold">Low Stock:</span> Only {{ $product->stock }} left!
                        </p>
                    </div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="flex flex-col">
                <!-- Product Header -->
                <div class="mb-6">
                    @if($product->origin)
                        <p class="text-sm text-brew-dark-brown uppercase font-semibold mb-2">{{ $product->origin }}</p>
                    @endif
                    
                    <h1 class="text-4xl font-bold text-brew-brown mb-3">{{ $product->name }}</h1>
                    
                    @if($product->roast_level)
                        <div class="inline-flex items-center mb-4">
                            <span class="px-4 py-2 bg-brew-light-brown text-brew-brown text-sm font-semibold rounded-xl">
                                {{ ucfirst($product->roast_level) }} Roast
                            </span>
                        </div>
                    @endif
                </div>

                <!-- Price Section -->
                <div class="mb-6 pb-6 border-b border-brew-light-brown">
                    @if($discountPercent > 0)
                        <div class="flex items-baseline space-x-3 mb-2">
                            <span class="text-4xl font-bold text-brew-brown">${{ number_format($discountedPrice, 2) }}</span>
                            <span class="text-xl text-gray-500 line-through">${{ number_format($originalPrice, 2) }}</span>
                            <span class="px-3 py-1 bg-green-100 text-green-700 text-sm font-bold rounded-full">
                                {{ $discountPercent }}% OFF
                            </span>
                        </div>
                        @if($subscription)
                            <p class="text-sm text-green-600 font-medium">
                                Subscriber Discount Applied ({{ $subscription->tier_name }})
                            </p>
                        @endif
                    @else
                        <span class="text-4xl font-bold text-brew-brown">${{ number_format($originalPrice, 2) }}</span>
                    @endif
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-brew-brown mb-3">Description</h2>
                    <p class="text-gray-700 leading-relaxed">{{ $product->description ?? 'No description available.' }}</p>
                </div>

                <!-- Product Details -->
                <div class="mb-6 space-y-3">
                    <div class="flex justify-between py-2 border-b border-brew-light-brown">
                        <span class="text-gray-600 font-medium">Stock Available:</span>
                        <span class="font-semibold text-brew-brown">
                            @if($product->stock > 0)
                                {{ $product->stock }} in stock
                            @else
                                <span class="text-red-600">Out of Stock</span>
                            @endif
                        </span>
                    </div>
                    @if($product->roast_level)
                        <div class="flex justify-between py-2 border-b border-brew-light-brown">
                            <span class="text-gray-600 font-medium">Roast Level:</span>
                            <span class="font-semibold text-brew-brown">{{ ucfirst($product->roast_level) }}</span>
                        </div>
                    @endif
                    @if($product->origin)
                        <div class="flex justify-between py-2 border-b border-brew-light-brown">
                            <span class="text-gray-600 font-medium">Origin:</span>
                            <span class="font-semibold text-brew-brown">{{ $product->origin }}</span>
                        </div>
                    @endif
                    @if($product->is_limited_edition)
                        <div class="flex justify-between py-2">
                            <span class="text-gray-600 font-medium">Availability:</span>
                            <span class="font-semibold text-purple-600">Limited Edition</span>
                        </div>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="mt-auto space-y-4">
                    @if(!$canAccess)
                        <div class="bg-purple-50 border-2 border-purple-300 rounded-lg p-4 mb-4">
                            <div class="flex items-start space-x-3">
                                <svg class="w-6 h-6 text-purple-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <p class="font-semibold text-purple-900 mb-1">Premium/Elite Subscribers Only</p>
                                    <p class="text-sm text-purple-700 mb-3">This Limited Edition product is exclusive to Premium and Elite subscribers.</p>
                                    <a href="{{ route('customer.subscriptions') }}" class="inline-block px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg transition">
                                        Subscribe Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        @auth
                            @if(auth()->user()->isAdmin())
                                <div class="px-6 py-3 bg-gray-200 text-gray-500 rounded-lg text-center font-medium">
                                    Admins cannot place orders
                                </div>
                            @else
                                @if($product->stock > 0)
                                    <button 
                                        wire:click="addToCart"
                                        class="w-full px-6 py-4 bg-brew-light-brown hover:bg-brew-orange text-brew-white font-bold text-lg rounded-xl transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center space-x-2"
                                    >
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        <span>Add to Cart</span>
                                    </button>
                                @else
                                    <div class="px-6 py-4 bg-gray-300 text-gray-600 rounded-xl text-center font-semibold text-lg">
                                        Out of Stock
                                    </div>
                                @endif
                            @endif
                        @else
                            <a href="{{ route('login') }}" 
                               class="block w-full px-6 py-4 bg-brew-light-brown hover:bg-brew-orange text-brew-white font-bold text-lg rounded-xl transition-all duration-200 shadow-md hover:shadow-lg text-center">
                                Login to Order
                            </a>
                        @endauth
                    @endif
                </div>

                <!-- Subscription Benefits Banner (if subscribed) -->
                @if($subscription && $subscription->is_active)
                    <div class="mt-6 bg-gradient-to-r from-green-50 to-blue-50 border-2 border-green-300 rounded-xl p-4">
                        <div class="flex items-center space-x-3">
                            <svg class="w-6 h-6 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <div>
                                <p class="font-semibold text-green-800">{{ $subscription->tier_name }} Subscriber Benefits</p>
                                <p class="text-sm text-green-700">
                                    You're saving {{ $discountPercent }}% on this product + FREE shipping!
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- You May Also Like Section -->
    @if($relatedProducts && $relatedProducts->count() > 0)
        <div class="mt-12 pb-32">
            <h2 class="text-3xl font-bold text-brew-brown mb-6">You May Also Like</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $relatedProduct)
                    @php
                        $relatedDiscountPercent = $customer ? $customer->getSubscriptionDiscount() : 0;
                        $relatedOriginalPrice = (float) $relatedProduct->price;
                        $relatedDiscountedPrice = $relatedDiscountPercent > 0 
                            ? round($relatedOriginalPrice * (1 - $relatedDiscountPercent / 100), 2) 
                            : $relatedOriginalPrice;
                        $relatedCanAccess = !$relatedProduct->is_limited_edition || ($customer && $customer->canAccessLimitedEdition());
                    @endphp
                    
                    <div class="bg-brew-cream rounded-xl border border-brew-light-brown overflow-hidden hover:shadow-lg transition relative">
                        <!-- Limited Edition Badge -->
                        @if($relatedProduct->is_limited_edition)
                            <div class="absolute top-2 right-2 z-10">
                                <span class="px-2 py-1 bg-purple-600 text-white text-xs font-bold rounded-full shadow-lg">
                                    ⭐ Limited
                                </span>
                            </div>
                        @endif
                        
                        <!-- Product Image -->
                        <a href="{{ route('customer.products.show', $relatedProduct->product_id) }}">
                            <div class="w-full h-48 bg-brew-light-brown flex items-center justify-center overflow-hidden relative">
                                @if($relatedProduct->image_url)
                                    <img src="{{ $relatedProduct->image_url }}" alt="{{ $relatedProduct->name }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                @else
                                    <svg class="w-16 h-16 text-brew-brown" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                    </svg>
                                @endif
                                
                                @if($relatedProduct->is_limited_edition && !$relatedCanAccess)
                                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                        <div class="text-center text-white p-2">
                                            <svg class="w-8 h-8 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                            </svg>
                                            <p class="text-xs font-semibold">Premium/Elite</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </a>
                        
                        <div class="p-4">
                            <!-- Product Name -->
                            <a href="{{ route('customer.products.show', $relatedProduct->product_id) }}">
                                <h3 class="font-bold text-lg text-brew-brown mb-2 hover:text-brew-dark-brown transition">{{ $relatedProduct->name }}</h3>
                            </a>
                            
                            <!-- Description -->
                            <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ Str::limit($relatedProduct->description ?? '', 80) }}</p>
                            
                            <!-- Price and Stock -->
                            <div class="flex justify-between items-center mb-3">
                                <div>
                                    @if($relatedDiscountPercent > 0)
                                        <div class="flex items-center space-x-2">
                                            <span class="text-lg font-bold text-brew-brown">${{ number_format($relatedDiscountedPrice, 2) }}</span>
                                            <span class="text-sm text-gray-500 line-through">${{ number_format($relatedOriginalPrice, 2) }}</span>
                                            <span class="px-2 py-0.5 bg-green-100 text-green-700 text-xs font-semibold rounded">{{ $relatedDiscountPercent }}% OFF</span>
                                        </div>
                                    @else
                                        <span class="text-lg font-bold text-brew-brown">${{ number_format($relatedOriginalPrice, 2) }}</span>
                                    @endif
                                </div>
                                @if($relatedProduct->roast_level)
                                    <span class="px-2 py-1 bg-brew-light-brown text-brew-brown text-xs rounded-xl">{{ ucfirst($relatedProduct->roast_level) }}</span>
                                @endif
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="flex gap-2">
                                <a href="{{ route('customer.products.show', $relatedProduct->product_id) }}" 
                                   class="flex-1 text-center px-3 py-2 border-2 border-brew-light-brown text-brew-brown rounded-xl hover:bg-brew-light-brown hover:text-brew-white transition-all duration-200 text-sm">
                                    View
                                </a>
                                @auth
                                    @if($relatedCanAccess && $relatedProduct->stock > 0 && !auth()->user()->isAdmin())
                                        <a href="{{ route('customer.products.show', $relatedProduct->product_id) }}" 
                                           class="flex-1 px-3 py-2 bg-brew-light-brown hover:bg-brew-orange text-brew-white rounded-lg transition text-sm font-medium text-center">
                                            Add
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
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

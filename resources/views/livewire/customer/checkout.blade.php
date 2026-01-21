<div>
    <div class="max-w-6xl mx-auto">
        <!-- Page Header -->
        <div class="text-center mb-8">
            <h1 class="text-5xl font-display font-bold text-brew-brown mb-2">Checkout</h1>
            <p class="text-lg text-gray-600 font-sans">Complete your order</p>
        </div>

        @if (session()->has('error'))
            <div class="mb-6 bg-red-50/95 backdrop-blur-sm border-2 border-red-200 text-red-800 px-6 py-4 rounded-xl shadow-lg" role="alert">
                <span class="block sm:inline font-medium">{{ session('error') }}</span>
            </div>
        @endif

        @if (session()->has('success'))
            <div class="mb-6 bg-green-50/95 backdrop-blur-sm border-2 border-green-200 text-green-800 px-6 py-4 rounded-xl shadow-lg" role="alert">
                <span class="block sm:inline font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Order Summary -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white/95 backdrop-blur-lg rounded-2xl shadow-2xl overflow-hidden border border-brew-light-brown/30">
                    <div class="bg-brew-cream/80 p-6 border-b border-brew-light-brown/30">
                        <h2 class="text-3xl font-display font-bold text-brew-brown">Order Summary</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($cartItems as $item)
                                <div class="flex items-center justify-between border-b border-brew-light-brown pb-4 last:border-0 last:pb-0">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-20 h-20 bg-brew-light-brown rounded-xl flex items-center justify-center overflow-hidden">
                                            @if($item->product->image_url)
                                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                            @else
                                                <svg class="w-10 h-10 text-brew-brown" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                                </svg>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-semibold text-brew-brown text-lg">{{ $item->product->name }}</p>
                                            <p class="text-sm text-gray-600">Quantity: {{ $item->quantity }}</p>
                                            <p class="text-sm text-gray-500">${{ number_format($item->product->price, 2) }} each</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-brew-brown text-lg">${{ number_format($item->quantity * $item->product->price, 2) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        @if($subscription)
                            <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-xl">
                                <div class="flex items-center mb-2">
                                    <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="font-semibold text-green-800">Subscriber Benefits Applied!</span>
                                </div>
                                <p class="text-sm text-green-700">You're subscribed to {{ $subscription->tier_name }} - Enjoy your benefits!</p>
                            </div>
                        @endif
                        
                        <div class="mt-6 pt-4 border-t border-brew-light-brown">
                            <div class="space-y-2 mb-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Subtotal:</span>
                                    <span class="font-semibold text-brew-brown">${{ number_format($subtotal, 2) }}</span>
                                </div>
                                
                                @if($discountAmount > 0)
                                    <div class="flex justify-between text-green-600">
                                        <span>Member Discount ({{ $discountPercent }}%):</span>
                                        <span class="font-semibold">-${{ number_format($discountAmount, 2) }}</span>
                                    </div>
                                @endif
                                
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Shipping:</span>
                                    @if($freeShipping)
                                        <span class="font-semibold text-green-600">FREE <span class="text-xs text-gray-500">(Subscriber Benefit)</span></span>
                                    @else
                                        <span class="font-semibold text-brew-brown">${{ number_format($shippingCost, 2) }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex justify-between items-center pt-3 border-t border-brew-light-brown">
                                <span class="text-xl font-semibold text-brew-brown">Total:</span>
                                <span class="text-3xl font-bold text-brew-brown">${{ number_format($total, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Form -->
                <div class="bg-white/95 backdrop-blur-lg rounded-2xl shadow-2xl overflow-hidden border border-brew-light-brown/30">
                    <div class="bg-brew-cream/80 p-6 border-b border-brew-light-brown/30">
                        <h2 class="text-3xl font-display font-bold text-brew-brown">Payment Information</h2>
                    </div>
                    <div class="p-6">
                        <form wire:submit.prevent="processCheckout">
                            <div class="space-y-6">
                                <!-- Delivery Address -->
                                <div>
                                    <label for="address" class="block text-sm font-semibold text-brew-brown mb-2">Delivery Address <span class="text-red-500">*</span></label>
                                    <textarea 
                                        id="address"
                                        wire:model="address" 
                                        rows="3"
                                        placeholder="Enter your complete delivery address (street, city, state, zip code)"
                                        class="w-full px-4 py-3 border-2 border-brew-light-brown/30 rounded-xl focus:ring-2 focus:ring-brew-orange focus:border-brew-orange bg-white text-brew-brown resize-none shadow-sm"
                                    ></textarea>
                                    @error('address') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    <p class="text-xs text-gray-500 mt-1">Please provide your complete delivery address</p>
                                </div>

                                <!-- Payment Method -->
                                <div>
                                    <label for="paymentMethod" class="block text-sm font-semibold text-brew-brown mb-2">Payment Method</label>
                                    <select 
                                        id="paymentMethod"
                                        wire:model="paymentMethod" 
                                        class="w-full px-4 py-3 border-2 border-brew-light-brown/30 rounded-xl focus:ring-2 focus:ring-brew-orange focus:border-brew-orange bg-white text-brew-brown shadow-sm"
                                    >
                                        <option value="credit_card">Credit Card</option>
                                        <option value="debit_card">Debit Card</option>
                                        <option value="paypal">PayPal</option>
                                        <option value="bank_transfer">Bank Transfer</option>
                                    </select>
                                    @error('paymentMethod') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                <!-- Card Details (shown only for credit/debit card) -->
                                @if(in_array($paymentMethod, ['credit_card', 'debit_card']))
                                    <div>
                                        <label for="cardNumber" class="block text-sm font-semibold text-brew-brown mb-2">Card Number</label>
                                        <input 
                                            type="text" 
                                            id="cardNumber"
                                            wire:model="cardNumber" 
                                            placeholder="1234 5678 9012 3456"
                                            maxlength="16"
                                            class="w-full px-4 py-3 border-2 border-brew-light-brown/30 rounded-xl focus:ring-2 focus:ring-brew-orange focus:border-brew-orange bg-white text-brew-brown shadow-sm"
                                        >
                                        @error('cardNumber') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="cardExpiry" class="block text-sm font-semibold text-brew-brown mb-2">Expiry Date</label>
                                            <input 
                                                type="text" 
                                                id="cardExpiry"
                                                wire:model="cardExpiry" 
                                                placeholder="MM/YY"
                                                maxlength="5"
                                                class="w-full px-4 py-3 border-2 border-brew-light-brown/30 rounded-xl focus:ring-2 focus:ring-brew-orange focus:border-brew-orange bg-white text-brew-brown shadow-sm"
                                            >
                                            @error('cardExpiry') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>

                                        <div>
                                            <label for="cardCvv" class="block text-sm font-semibold text-brew-brown mb-2">CVV</label>
                                            <input 
                                                type="text" 
                                                id="cardCvv"
                                                wire:model="cardCvv" 
                                                placeholder="123"
                                                maxlength="3"
                                                class="w-full px-4 py-3 border-2 border-brew-light-brown/30 rounded-xl focus:ring-2 focus:ring-brew-orange focus:border-brew-orange bg-white text-brew-brown shadow-sm"
                                            >
                                            @error('cardCvv') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                @endif

                                <!-- PayPal Note -->
                                @if($paymentMethod === 'paypal')
                                    <div class="bg-blue-50/80 border-2 border-blue-200 rounded-xl p-4">
                                        <p class="text-sm text-blue-900 font-medium">You will be redirected to PayPal to complete your payment.</p>
                                    </div>
                                @endif

                                <!-- Bank Transfer Note -->
                                @if($paymentMethod === 'bank_transfer')
                                    <div class="bg-amber-50/80 border-2 border-amber-200 rounded-xl p-4">
                                        <p class="text-sm text-amber-900 font-medium">Bank transfer details will be provided after order confirmation.</p>
                                    </div>
                                @endif

                                <!-- Submit Button -->
                                <div class="pt-4">
                                    <button 
                                        type="submit" 
                                        wire:loading.attr="disabled"
                                        class="w-full px-6 py-4 bg-brew-brown hover:bg-brew-light-brown text-white font-display font-bold rounded-xl transition-all transform hover:scale-[1.02] text-lg disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2 shadow-xl"
                                    >
                                        <span wire:loading.remove>Complete Order</span>
                                        <span wire:loading class="flex items-center gap-2">
                                            <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            Processing Order...
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white/95 backdrop-blur-lg rounded-2xl shadow-2xl sticky top-4 overflow-hidden border border-brew-light-brown/30">
                    <div class="bg-brew-cream/80 p-6 border-b border-brew-light-brown/30">
                        <h3 class="text-2xl font-display font-bold text-brew-brown">Order Details</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Items:</span>
                                <span class="font-semibold text-brew-brown">{{ $cartItems->sum('quantity') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal:</span>
                                <span class="font-semibold text-brew-brown">${{ number_format($subtotal, 2) }}</span>
                            </div>
                            
                            @if($discountAmount > 0)
                                <div class="flex justify-between text-green-600">
                                    <span>Member Discount ({{ $discountPercent }}%):</span>
                                    <span class="font-semibold">-${{ number_format($discountAmount, 2) }}</span>
                                </div>
                            @endif
                            
                            <div class="flex justify-between">
                                <span class="text-gray-600">Shipping:</span>
                                @if($freeShipping)
                                    <span class="font-semibold text-green-600">FREE <span class="text-xs text-gray-500">(Subscriber)</span></span>
                                @else
                                    <span class="font-semibold text-brew-brown">${{ number_format($shippingCost, 2) }}</span>
                                @endif
                            </div>
                            
                            @if($subscription)
                                <div class="pt-2 border-t border-brew-light-brown">
                                    <div class="flex items-center text-xs text-green-600">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>Subscriber: {{ $subscription->tier_name }}</span>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="border-t border-brew-light-brown pt-3 mt-3">
                                <div class="flex justify-between">
                                    <span class="text-lg font-bold text-brew-brown">Total:</span>
                                    <span class="text-2xl font-bold text-brew-brown">${{ number_format($total, 2) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-brew-light-brown">
                            <a href="{{ route('customer.cart') }}" class="text-brew-brown hover:text-brew-dark-brown text-sm font-medium flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Back to Cart
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script>
    $wire.on('toast-notification', (event) => {
        window.dispatchEvent(new CustomEvent('toast-notification', {
            detail: event
        }));
    });
    
    $wire.on('redirect-after-delay', (event) => {
        // Show toast first, then redirect after 2 seconds
        setTimeout(() => {
            window.location.href = event.url;
        }, 2000);
    });
</script>
@endscript

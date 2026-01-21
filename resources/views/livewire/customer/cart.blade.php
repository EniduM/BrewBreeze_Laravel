<div>
    @if (session()->has('message'))
        <div class="mb-6 bg-green-50/95 backdrop-blur-sm border-2 border-green-200 text-green-800 px-6 py-4 rounded-xl shadow-lg" role="alert">
            <span class="block sm:inline font-medium">{{ session('message') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-6 bg-red-50/95 backdrop-blur-sm border-2 border-red-200 text-red-800 px-6 py-4 rounded-xl shadow-lg" role="alert">
            <span class="block sm:inline font-medium">{{ session('error') }}</span>
        </div>
    @endif

    @if($cartItems->count() > 0)
        <div class="bg-white/95 backdrop-blur-lg rounded-2xl shadow-2xl overflow-hidden border border-brew-light-brown/30">
            <div class="bg-brew-cream/80 p-6">
                <h1 class="text-3xl font-display font-bold text-brew-brown">Your Shopping Cart</h1>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-brew-cream/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-display font-bold text-brew-brown uppercase tracking-wider">Product</th>
                            <th class="px-6 py-4 text-left text-xs font-display font-bold text-brew-brown uppercase tracking-wider">Price</th>
                            <th class="px-6 py-4 text-left text-xs font-display font-bold text-brew-brown uppercase tracking-wider">Quantity</th>
                            <th class="px-6 py-4 text-left text-xs font-display font-bold text-brew-brown uppercase tracking-wider">Total</th>
                            <th class="px-6 py-4 text-left text-xs font-display font-bold text-brew-brown uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-brew-light-brown/20">
                        @foreach($cartItems as $item)
                            @if($item->product)
                            <tr class="hover:bg-brew-cream/30 transition">
                                <td class="px-6 py-5">
                                    <div class="flex items-center">
                                        <div class="w-20 h-20 bg-gradient-to-br from-brew-light-brown to-brew-cream rounded-xl flex items-center justify-center mr-4 shadow-md overflow-hidden">
                                            @if($item->product->image_url)
                                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                            @else
                                                <svg class="w-10 h-10 text-brew-brown" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                                </svg>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="text-base font-display font-bold text-brew-brown">{{ $item->product->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-base font-semibold text-brew-brown">
                                    ${{ number_format($item->product->price, 2) }}
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="flex items-center space-x-3">
                                        <button 
                                            wire:click="decreaseQuantity({{ $cart->cart_id }}, {{ $item->product_id }})"
                                            class="w-9 h-9 flex items-center justify-center bg-white border-2 border-brew-brown rounded-lg hover:bg-brew-light-brown hover:scale-110 disabled:opacity-50 disabled:cursor-not-allowed text-brew-brown transition transform shadow-md"
                                            @if($item->quantity <= 1) disabled @endif
                                        >
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                            </svg>
                                        </button>
                                        <input 
                                            type="number" 
                                            min="1" 
                                            max="{{ $item->product->stock }}"
                                            value="{{ $item->quantity }}"
                                            wire:change="updateQuantity({{ $cart->cart_id }}, {{ $item->product_id }}, $event.target.value)"
                                            class="w-16 px-3 py-2 border-2 border-brew-brown rounded-lg text-center focus:ring-2 focus:ring-brew-orange focus:border-brew-orange bg-white text-brew-brown font-semibold shadow-sm"
                                        >
                                        <button 
                                            wire:click="increaseQuantity({{ $cart->cart_id }}, {{ $item->product_id }})"
                                            class="w-9 h-9 flex items-center justify-center bg-white border-2 border-brew-brown rounded-lg hover:bg-brew-light-brown hover:scale-110 disabled:opacity-50 disabled:cursor-not-allowed text-brew-brown transition transform shadow-md"
                                            @if($item->quantity >= $item->product->stock) disabled @endif
                                        >
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-lg font-display font-bold text-brew-brown">
                                    ${{ number_format($item->quantity * $item->product->price, 2) }}
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-sm font-medium">
                                    <button 
                                        wire:click="removeItem({{ $cart->cart_id }}, {{ $item->product_id }})"
                                        wire:confirm="Are you sure you want to remove this item?"
                                        class="flex items-center px-4 py-2 text-red-700 hover:text-white bg-red-50 hover:bg-red-600 rounded-lg transition transform hover:scale-105 shadow-sm"
                                    >
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Remove
                                    </button>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="bg-gradient-to-r from-brew-cream to-white p-8 border-t-2 border-brew-light-brown/30">
                <div class="flex justify-between items-center max-w-md ml-auto mb-6">
                    <span class="text-lg font-display font-bold text-brew-brown">Order Total:</span>
                    <span class="text-3xl font-display font-bold text-brew-brown">${{ number_format($total, 2) }}</span>
                </div>
                
                <div class="flex justify-end gap-4">
                    <button 
                        wire:click="clearCart"
                        wire:confirm="Are you sure you want to clear your cart?"
                        class="px-8 py-3 bg-white border-2 border-brew-brown text-brew-brown rounded-xl hover:bg-brew-brown hover:text-white transition transform hover:scale-105 font-display font-bold shadow-lg"
                    >
                        Clear Cart
                    </button>
                    <a 
                        href="{{ route('customer.checkout') }}"
                        class="px-8 py-3 bg-brew-brown text-white rounded-xl hover:bg-brew-light-brown transition transform hover:scale-105 font-display font-bold shadow-xl"
                    >
                        Proceed to Checkout
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white/95 backdrop-blur-lg rounded-2xl shadow-2xl p-16 text-center border border-brew-light-brown/30">
            <div class="w-16 h-16 bg-gradient-to-br from-brew-light-brown to-brew-cream rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl">
                <svg class="w-8 h-8 text-brew-brown" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
            </div>
            <h3 class="text-4xl font-display font-bold text-brew-brown mb-4">Your cart is empty</h3>
            <p class="text-lg text-gray-600 mb-8 font-sans">Start adding some products to your cart!</p>
            <a href="{{ route('customer.products') }}" class="inline-block px-8 py-4 bg-brew-brown text-white rounded-xl hover:bg-brew-light-brown transition transform hover:scale-105 font-display font-bold shadow-xl">
                Browse Products
            </a>
        </div>
    @endif
</div>

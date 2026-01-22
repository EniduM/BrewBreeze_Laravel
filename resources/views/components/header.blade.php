@props(['transparent' => false])

<style>
    [x-cloak] { display: none !important; }
</style>
<header class="{{ $transparent ? 'bg-transparent' : 'bg-brew-brown' }} text-brew-white">
    <nav class="px-6 py-8 md:px-12 lg:px-20">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center gap-3">
                <a href="{{ route('landing') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="BrewBreeze Logo" class="w-12 h-12 object-contain rounded-lg">
                    <span class="text-3xl font-display font-bold text-white">BrewBreeze</span>
                </a>
            </div>

            <!-- Right Side: Nav Links + Auth Buttons -->
            <div class="flex items-center gap-8">
                <!-- Nav Links - Desktop -->
                <div class="hidden md:flex items-center gap-8 text-white font-sans">
                    <a href="{{ route('landing') }}" class="hover:text-brew-light-brown transition-colors text-sm font-semibold uppercase tracking-wider {{ request()->routeIs('landing') ? 'text-brew-light-brown' : '' }}">Home</a>
                    <a href="{{ route('about') }}" class="hover:text-brew-light-brown transition-colors text-sm font-semibold uppercase tracking-wider {{ request()->routeIs('about') ? 'text-brew-light-brown' : '' }}">About</a>
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('customer.products') }}" class="hover:text-brew-light-brown transition-colors text-sm font-semibold uppercase tracking-wider {{ request()->routeIs('customer.products*') ? 'text-brew-light-brown' : '' }}">Coffee Menu</a>
                            <!-- Admin Dropdown -->
                            <div class="relative" x-data="{ open: false }" x-cloak>
                                <button @click="open = !open" class="hover:text-brew-light-brown transition-colors text-sm font-semibold uppercase tracking-wider {{ request()->routeIs('admin.*') ? 'text-brew-light-brown' : '' }} flex items-center space-x-1">
                                    <span>Admin</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div x-show="open" @click.away="open = false" x-transition class="absolute left-0 mt-2 w-48 bg-brew-cream rounded-lg shadow-lg py-2 z-50 border border-brew-light-brown">
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-brew-brown hover:bg-brew-light-brown hover:text-white {{ request()->routeIs('admin.dashboard') ? 'bg-brew-light-brown text-white font-semibold' : '' }}">Dashboard</a>
                                    <a href="{{ route('admin.products.index') }}" class="block px-4 py-2 text-brew-brown hover:bg-brew-light-brown hover:text-white {{ request()->routeIs('admin.products.*') ? 'bg-brew-light-brown text-white font-semibold' : '' }}">Products</a>
                                    <a href="{{ route('admin.orders.index') }}" class="block px-4 py-2 text-brew-brown hover:bg-brew-light-brown hover:text-white {{ request()->routeIs('admin.orders.*') ? 'bg-brew-light-brown text-white font-semibold' : '' }}">Orders</a>
                                    <a href="{{ route('admin.subscriptions.index') }}" class="block px-4 py-2 text-brew-brown hover:bg-brew-light-brown hover:text-white {{ request()->routeIs('admin.subscriptions.*') ? 'bg-brew-light-brown text-white font-semibold' : '' }}">Subscriptions</a>
                                    <a href="{{ route('admin.messages.index') }}" class="block px-4 py-2 text-brew-brown hover:bg-brew-light-brown hover:text-white {{ request()->routeIs('admin.messages.*') ? 'bg-brew-light-brown text-white font-semibold' : '' }}">Messages</a>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('customer.products') }}" class="hover:text-brew-light-brown transition-colors text-sm font-semibold uppercase tracking-wider {{ request()->routeIs('customer.products*') ? 'text-brew-light-brown' : '' }}">Coffee Menu</a>
                            <a href="{{ route('customer.orders') }}" class="hover:text-brew-light-brown transition-colors text-sm font-semibold uppercase tracking-wider {{ request()->routeIs('customer.orders*') ? 'text-brew-light-brown' : '' }}">My Orders</a>
                            <a href="{{ route('customer.subscriptions') }}" class="hover:text-brew-light-brown transition-colors text-sm font-semibold uppercase tracking-wider {{ request()->routeIs('customer.subscriptions*') ? 'text-brew-light-brown' : '' }}">Subscriptions</a>
                        @endif
                    @else
                        <a href="{{ route('customer.products') }}" class="hover:text-brew-light-brown transition-colors text-sm font-semibold uppercase tracking-wider">Coffee Menu</a>
                    @endauth
                </div>

                <!-- Auth Buttons / User Actions -->
                @auth
                    <div class="flex items-center gap-4">
                        @if(!auth()->user()->isAdmin())
                            <!-- Cart Icon -->
                            <a href="{{ route('customer.cart') }}" class="relative text-white hover:text-brew-light-brown transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                @php
                                    try {
                                        $customer = auth()->user()->getOrCreateCustomer();
                                        $cart = $customer ? \App\Models\Cart::where('customer_id', $customer->customer_id)->first() : null;
                                        $cartCount = $cart ? $cart->cartItems->sum('quantity') : 0;
                                    } catch (\Exception $e) {
                                        $cartCount = 0;
                                    }
                                @endphp
                                @if($cartCount > 0)
                                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">{{ $cartCount }}</span>
                                @endif
                            </a>
                        @endif
                        <!-- User Profile Button -->
                        <div class="relative" x-data="{ open: false }" x-cloak>
                            <button @click="open = !open" class="flex items-center space-x-2 text-white hover:text-brew-light-brown transition">
                                <div class="w-8 h-8 bg-brew-light-brown rounded-full flex items-center justify-center text-brew-brown font-semibold">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <span class="hidden md:inline text-sm font-semibold uppercase tracking-wider">{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-brew-cream rounded-lg shadow-lg py-2 z-50 border border-brew-light-brown">
                                <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-brew-brown hover:bg-brew-light-brown hover:text-white">My Profile</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-brew-brown hover:bg-brew-light-brown hover:text-white">Sign Out</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="flex items-center gap-4">
                        <a href="{{ route('login') }}" class="px-6 py-2.5 bg-transparent border-2 border-white text-white hover:bg-white hover:text-brew-brown transition-all rounded-full font-sans font-medium text-sm uppercase tracking-wide shadow-lg">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="px-6 py-2.5 bg-brew-light-brown text-white hover:bg-brew-orange transition-all rounded-full font-sans font-medium text-sm uppercase tracking-wide shadow-xl">
                            Register
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>
</header>
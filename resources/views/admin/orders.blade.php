<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Order Management - {{ config('app.name', 'BrewBreeze') }}</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:700,900|inter:400,500,600" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        .font-display { font-family: 'Playfair Display', serif; }
        .font-sans { font-family: 'Inter', sans-serif; }
        body { background: #fdf7f2; }
        @keyframes float-soft { from { transform: translateY(0); } to { transform: translateY(-10px); } }
        @keyframes fade-in-up { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="antialiased overflow-x-hidden">
    <div class="relative min-h-screen bg-gradient-to-br from-[#fbeae2] via-[#fff8f4] to-[#f3e5dc] text-brew-brown">
        <div class="pointer-events-none absolute inset-0 overflow-hidden">
            <div class="absolute -left-10 top-10 w-60 h-60 bg-brew-light-brown/15 blur-3xl rounded-full animate-[float-soft_6s_ease-in-out_infinite_alternate]"></div>
            <div class="absolute right-0 bottom-10 w-72 h-72 bg-brew-orange/10 blur-3xl rounded-full animate-[float-soft_7s_ease-in-out_infinite_alternate]"></div>
            <div class="absolute left-1/2 -translate-x-1/2 top-32 w-full max-w-5xl h-64 bg-white/40 rounded-3xl shadow-[0_40px_120px_rgba(0,0,0,0.06)]"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 lg:px-8 py-10">
            <div class="grid lg:grid-cols-[260px,1fr] gap-8">
                <aside class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl border border-white/60 p-6 h-fit sticky top-6" style="animation: fade-in-up 0.7s ease forwards;">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 rounded-2xl bg-brew-brown text-white flex items-center justify-center font-display text-2xl shadow-lg">B</div>
                        <div>
                            <p class="text-xs uppercase text-gray-500">BrewBreeze</p>
                            <p class="text-lg font-bold text-brew-brown">Admin Panel</p>
                        </div>
                    </div>
                    <div class="space-y-1 text-sm font-semibold text-brew-brown">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-brew-light-brown/15 transition-all">
                            <span class="w-8 h-8 rounded-lg bg-brew-light-brown/25 flex items-center justify-center">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12l9-8 9 8"></path><path d="M9 21V9h6v12"></path></svg>
                            </span>
                            Dashboard
                        </a>
                        <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-brew-light-brown/15 transition-all">
                            <span class="w-8 h-8 rounded-lg bg-brew-light-brown/25 flex items-center justify-center">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="7" width="18" height="13" rx="2"></rect><path d="M3 11h18"></path></svg>
                            </span>
                            Products
                        </a>
                        <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl transition-all bg-brew-brown text-white shadow-md">
                            <span class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 6h16"></path><path d="M4 12h16"></path><path d="M4 18h16"></path></svg>
                            </span>
                            Orders
                        </a>
                        <a href="{{ route('admin.subscriptions.index') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-brew-light-brown/15 transition-all">
                            <span class="w-8 h-8 rounded-lg bg-brew-light-brown/25 flex items-center justify-center">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16v4H4z"></path><path d="M4 12h16v8H4z"></path></svg>
                            </span>
                            Subscriptions
                        </a>
                        <a href="{{ route('admin.messages.index') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-brew-light-brown/15 transition-all">
                            <span class="w-8 h-8 rounded-lg bg-brew-light-brown/25 flex items-center justify-center">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 6h16v9H5l-1 3z"></path></svg>
                            </span>
                            Messages
                        </a>
                    </div>
                    <div class="mt-6 p-4 rounded-xl bg-brew-light-brown/10 border border-brew-light-brown/30">
                        <p class="text-xs uppercase text-gray-500 mb-2">Quick actions</p>
                        <div class="space-y-3 text-sm font-semibold">
                            <a href="{{ route('admin.products.index') }}" class="flex items-center justify-between px-3 py-2 rounded-lg bg-white/70 border border-white/40 shadow-sm hover:shadow-md transition">
                                <span>Add product</span>
                                <span>+</span>
                            </a>
                            <a href="{{ route('admin.orders.index') }}" class="flex items-center justify-between px-3 py-2 rounded-lg bg-white/70 border border-white/40 shadow-sm hover:shadow-md transition">
                                <span>View orders</span>
                                <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        </div>
                    </div>
                </aside>

                <main class="space-y-6" style="animation: fade-in-up 0.8s ease forwards;">
                    <div class="bg-white/80 backdrop-blur-xl rounded-2xl p-6 shadow-lg border border-white/60">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-xs uppercase text-gray-500">Manage</p>
                                <h1 class="text-2xl font-bold text-brew-brown">Orders</h1>
                            </div>
                        </div>
                        <div class="bg-white/50 rounded-xl">
                            @livewire('admin.orders')
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <x-footer />
    @livewireScripts
</body>
</html>


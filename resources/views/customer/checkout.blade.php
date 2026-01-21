<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Checkout - {{ config('app.name', 'BrewBreeze') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:700,900|inter:400,500,600" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        .font-display { font-family: 'Playfair Display', serif; }
        .font-sans { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-white" style="background: linear-gradient(to bottom, #ffffff 0%, #fef7f0 20%, #ffffff 40%, #fef7f0 60%, #ffffff 80%, #fef7f0 100%); background-attachment: fixed;">
    <!-- Back Button -->
    <div class="container mx-auto px-4 pt-6">
        <a href="{{ route('customer.cart') }}" class="inline-flex items-center text-brew-brown hover:text-brew-light-brown transition-colors font-sans font-semibold">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Cart
        </a>
    </div>

    <div class="container mx-auto px-4 pt-4">
        @livewire('customer.checkout')
    </div>

    <x-footer />
    @livewireScripts
</body>
</html>


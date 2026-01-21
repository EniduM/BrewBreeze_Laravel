<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Order Details - {{ config('app.name', 'BrewBreeze') }}</title>
    
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
<body class="bg-transparent" style="background: linear-gradient(rgba(59, 42, 42, 0.55), rgba(42, 31, 31, 0.7)), url('{{ asset('images/image 1.jpg') }}'); background-size: cover; background-repeat: no-repeat; background-attachment: fixed; background-position: center; min-height: 100vh;">
    <x-header transparent="true" />

    <div class="container mx-auto px-4 pt-4">
        @livewire('customer.order-detail', ['orderId' => $orderId])
    </div>

    <x-footer />
    @livewireScripts
</body>
</html>


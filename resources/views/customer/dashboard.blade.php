<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - {{ config('app.name', 'BrewBreeze') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:700,900|inter:400,500,600" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        .font-display { font-family: 'Playfair Display', serif; }
        .font-sans { font-family: 'Inter', sans-serif; }
        body {
            background: linear-gradient(to bottom, #ffffff 0%, #fef7f0 20%, #ffffff 40%, #fef7f0 60%, #ffffff 80%, #fef7f0 100%);
            background-attachment: fixed;
        }
    </style>
</head>
<body class="antialiased overflow-x-hidden">
    <x-header />
    <div class="w-full h-2" style="background: linear-gradient(to bottom, #3B2A2A 0%, transparent 100%);"></div>

    @if(session('status'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-lg">
                <p class="text-green-700">{{ session('status') }}</p>
            </div>
        </div>
    @endif

    <div class="container mx-auto px-4 pt-4">
        @livewire('customer.dashboard')
    </div>

    <x-footer />
    @livewireScripts
</body>
</html>

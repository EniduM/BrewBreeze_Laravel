<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Customer Messages - {{ config('app.name', 'BrewBreeze') }}</title>
    
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
    
    <!-- Gradient Transition -->
    <div class="w-full h-16" style="background: linear-gradient(to bottom, #3B2A2A 0%, rgba(59, 42, 42, 0.9) 20%, rgba(59, 42, 42, 0.7) 40%, rgba(59, 42, 42, 0.4) 60%, rgba(59, 42, 42, 0.2) 80%, transparent 100%);"></div>

    <main class="min-h-screen pb-12">
        @livewire('admin.messages')
    </main>

    <x-footer />
    @livewireScripts
</body>
</html>


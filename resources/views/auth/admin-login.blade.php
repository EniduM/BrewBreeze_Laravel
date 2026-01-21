<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Sign In - {{ config('app.name', 'BrewBreeze') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-brew-cream min-h-screen">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Logo Icon -->
            <div class="flex justify-center">
                <div class="w-20 h-20 bg-brew-brown rounded-full flex items-center justify-center">
                    <span class="text-white text-3xl font-bold">B</span>
                </div>
            </div>

            <!-- Title -->
            <div class="text-center">
                <h2 class="text-3xl font-bold text-brew-brown">Admin Sign In</h2>
                <p class="mt-2 text-sm text-brew-brown">
                    Access the admin dashboard
                </p>
            </div>

            <!-- Demo Account Info -->
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <p class="text-sm font-semibold text-red-800 mb-2">⚠️ Admin Access Only</p>
                <p class="text-xs text-red-700 mb-2">Demo admin account:</p>
                <p class="text-xs text-red-700">Email: admin@brewbreeze.com</p>
                <p class="text-xs text-red-700">Password: password</p>
            </div>

            <!-- Form -->
            <form class="mt-8 space-y-6" method="POST" action="{{ route('admin.login.post') }}">
                @csrf

                <x-validation-errors class="mb-4" />

                @session('status')
                    <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-3 rounded">
                        {{ $value }}
                    </div>
                @endsession

                <div class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-brew-brown mb-1">Email address</label>
                        <input id="email" name="email" type="email" autocomplete="email" required 
                               class="appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-brew-brown focus:border-transparent bg-white"
                               placeholder="Enter your admin email" value="{{ old('email') }}">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-brew-brown mb-1">Password</label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                               class="appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-brew-brown focus:border-transparent bg-white"
                               placeholder="Enter your password">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-brew-brown focus:ring-brew-brown border-gray-300 rounded">
                        <label for="remember_me" class="ml-2 block text-sm text-brew-dark-brown">Remember me</label>
                    </div>

                    @if (Route::has('password.request'))
                        <div class="text-sm">
                            <a href="{{ route('password.request') }}" class="font-medium text-brew-brown hover:underline">
                                Forgot password?
                            </a>
                        </div>
                    @endif
                </div>

                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-brew-white bg-brew-light-brown hover:bg-brew-orange focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brew-light-brown transition">
                        Sign in as Admin
                    </button>
                </div>
            </form>

            <!-- Link back to customer login -->
            <div class="text-center">
                <a href="{{ route('customer.login') }}" class="text-sm text-brew-brown hover:underline">
                    ← Back to Customer Login
                </a>
            </div>
        </div>
    </div>

    @livewireScripts
</body>
</html>

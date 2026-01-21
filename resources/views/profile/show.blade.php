<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>My Profile - {{ config('app.name', 'BrewBreeze') }}</title>
    
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
        /* Apply background image to navbar only */
        nav {
            background: url('{{ asset('images/profile page background.jpg') }}') !important;
            background-size: cover !important;
            background-position: center !important;
            background-repeat: no-repeat !important;
        }
    </style>
</head>
<body class="antialiased overflow-x-hidden">
    <x-header />
    <div class="w-full h-2" style="background: linear-gradient(to bottom, rgba(59, 42, 42, 0.3) 0%, transparent 100%);"></div>

    @if(session('status'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
            <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-xl shadow-lg">
                <p class="text-green-700 font-sans">{{ session('status') }}</p>
            </div>
        </div>
    @endif

    <div class="container mx-auto px-4 py-12">
        <div class="max-w-7xl mx-auto">
            <!-- Page Header -->
            <div class="mb-12">
                <h1 class="text-4xl md:text-5xl font-display font-bold text-brew-brown">My Profile</h1>
                <p class="mt-3 text-base text-brew-brown/70 font-sans">Manage your account settings and preferences</p>
            </div>

            <div class="space-y-8">
                @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                    <div class="bg-white/95 backdrop-blur-lg shadow-xl rounded-2xl border border-brew-light-brown/20 overflow-hidden">
                        @livewire('profile.update-profile-information-form')
                    </div>
                @endif

                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                    <div class="bg-white/95 backdrop-blur-lg shadow-xl rounded-2xl border border-brew-light-brown/20 overflow-hidden">
                        @livewire('profile.update-password-form')
                    </div>
                @endif

                @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                    <div class="bg-white/95 backdrop-blur-lg shadow-xl rounded-2xl border border-brew-light-brown/20 overflow-hidden">
                        @livewire('profile.two-factor-authentication-form')
                    </div>
                @endif

                <div class="bg-white/95 backdrop-blur-lg shadow-xl rounded-2xl border border-brew-light-brown/20 overflow-hidden">
                    @livewire('profile.logout-other-browser-sessions-form')
                </div>

                @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                    <div class="bg-white/95 backdrop-blur-lg shadow-xl rounded-2xl border border-brew-light-brown/20 overflow-hidden">
                        @livewire('profile.delete-user-form')
                    </div>
                @endif
            </div>
        </div>
    </div>

    <x-footer />
    @livewireScripts
</body>
</html>

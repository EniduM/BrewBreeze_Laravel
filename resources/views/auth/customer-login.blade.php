<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Customer Sign In - {{ config('app.name', 'BrewBreeze') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:700,900|inter:400,500,600" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        .font-display { font-family: 'Playfair Display', serif; }
        .font-sans { font-family: 'Inter', sans-serif; }
        
        @keyframes fade-in {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes slide-in-right {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .animate-fade-in {
            animation: fade-in 0.8s ease-out;
        }
        
        .animate-fade-in-up {
            animation: fade-in-up 0.8s ease-out;
            animation-fill-mode: both;
        }
        
        .animate-slide-in-right {
            animation: slide-in-right 0.6s ease-out;
            animation-fill-mode: both;
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
    </style>
</head>
<body class="antialiased overflow-x-hidden">
    <!-- Background with overlay -->
    <div class="min-h-screen bg-cover bg-center bg-no-repeat bg-fixed" style="background-image: linear-gradient(rgba(30, 20, 20, 0.88), rgba(20, 15, 15, 0.92)), url('{{ asset('images/background.jpg') }}');">
        <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-md w-full space-y-8">
                <!-- Logo Icon -->
                <div class="flex justify-center animate-fade-in">
                    <div class="bg-brew-light-brown p-4 rounded-2xl shadow-2xl backdrop-blur-sm transform hover:scale-105 transition-transform duration-300">
                        <img src="{{ asset('images/logo.png') }}" alt="BrewBreeze Logo" class="w-16 h-16 object-contain rounded-lg">
                    </div>
                </div>

                <!-- Title -->
                <div class="text-center animate-fade-in-up" style="animation-delay: 0.2s;">
                    <h2 class="font-display text-5xl font-black text-white mb-3 tracking-tight drop-shadow-lg">Welcome Back</h2>
                    <p class="text-white font-sans text-lg drop-shadow-md">
                        Sign in to continue to BrewBreeze
                    </p>
                </div>

                <!-- Form Card -->
                <div class="glass-card rounded-2xl shadow-2xl p-8 border border-brew-light-brown/20 animate-fade-in-up" style="animation-delay: 0.3s;">
                    <form class="space-y-6" id="loginForm">
                        @csrf

                        <div id="error-messages" class="hidden mb-4 font-medium text-sm text-red-600 bg-red-50 p-3 rounded-lg border border-red-200"></div>

                        @session('status')
                            <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-3 rounded-lg border border-green-200">
                                {{ $value }}
                            </div>
                        @endsession

                        <div class="space-y-5">
                            <div class="animate-slide-in-right" style="animation-delay: 0.4s;">
                                <label for="email" class="block text-sm font-bold text-brew-brown mb-2 font-sans">Email Address</label>
                                <input id="email" name="email" type="email" autocomplete="email" required 
                                       class="appearance-none relative block w-full px-4 py-3.5 border border-gray-300 placeholder-gray-400 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-brew-orange focus:border-brew-orange bg-white/80 font-sans transition-all duration-300 hover:bg-white hover:border-brew-light-brown"
                                       placeholder="you@example.com" value="{{ old('email') }}">
                            </div>

                            <div class="animate-slide-in-right" style="animation-delay: 0.5s;">
                                <label for="password" class="block text-sm font-bold text-brew-brown mb-2 font-sans">Password</label>
                                <input id="password" name="password" type="password" autocomplete="current-password" required
                                       class="appearance-none relative block w-full px-4 py-3.5 border border-gray-300 placeholder-gray-400 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-brew-orange focus:border-brew-orange bg-white font-sans transition-all duration-300 hover:border-brew-light-brown"
                                       placeholder="Enter your password">
                            </div>
                        </div>

                        <div class="flex items-center justify-between animate-slide-in-right" style="animation-delay: 0.6s;">
                            <div class="flex items-center">
                                <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-brew-orange focus:ring-brew-orange border-gray-300 rounded transition">
                                <label for="remember_me" class="ml-2 block text-sm font-medium text-brew-brown font-sans">Remember me</label>
                            </div>

                            @if (Route::has('password.request'))
                                <div class="text-sm">
                                    <a href="{{ route('password.request') }}" class="font-bold text-brew-brown hover:text-brew-orange font-sans transition-colors">
                                        Forgot password?
                                    </a>
                                </div>
                            @endif
                        </div>

                        <div class="animate-fade-in-up" style="animation-delay: 0.7s;">
                            <button type="submit" id="loginButton" class="group relative w-full flex justify-center py-4 px-4 border border-transparent text-sm font-bold rounded-lg text-brew-white bg-brew-light-brown hover:bg-brew-orange focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brew-light-brown transition-all duration-300 shadow-lg hover:shadow-2xl font-sans uppercase tracking-wider transform hover:-translate-y-0.5">
                                <span class="flex items-center gap-2">
                                    Sign In
                                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                    </svg>
                                </span>
                            </button>
                        </div>

                        <div class="text-center space-y-3 animate-fade-in" style="animation-delay: 0.8s;">
                            <p class="text-sm text-gray-900 font-sans font-medium">
                                Don't have an account? 
                                <a href="{{ route('register') }}" class="font-bold text-gray-900 hover:text-brew-orange transition-colors underline">Create Account</a>
                            </p>
                            <p class="text-sm">
                                <a href="{{ route('landing') }}" class="font-semibold text-gray-900 hover:text-brew-orange transition-colors inline-flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                    </svg>
                                    Back to Home
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @livewireScripts
    
    <script>
        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const button = document.getElementById('loginButton');
            const errorDiv = document.getElementById('error-messages');
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const remember = document.getElementById('remember_me').checked;
            
            // Disable button
            button.disabled = true;
            button.innerHTML = '<span class="flex items-center gap-2">Signing in...</span>';
            errorDiv.classList.add('hidden');
            
            try {
                // Call the web API login endpoint (with session support)
                const response = await axios.post('/api-login', {
                    email: email,
                    password: password,
                    remember: remember
                });
                
                console.log('Login response:', response.data);
                
                if (response.data.success) {
                    // Check if 2FA is required
                    if (response.data.data.requires_2fa) {
                        console.log('2FA required, redirecting...');
                        window.location.href = response.data.data.redirect;
                        return;
                    }
                    
                    // Store the Bearer token in localStorage
                    localStorage.setItem('auth_token', response.data.data.token);
                    
                    // Set the token in axios headers for subsequent requests
                    window.axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.data.token}`;
                    
                    console.log('Token stored, redirecting...');
                    
                    // Redirect to dashboard or landing page
                    window.location.href = '{{ route("landing") }}';
                }
            } catch (error) {
                console.error('Login error:', error);
                console.error('Error response:', error.response);
                
                // Display error messages
                button.disabled = false;
                button.innerHTML = '<span class="flex items-center gap-2">Sign In<svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg></span>';
                
                errorDiv.classList.remove('hidden');
                if (error.response && error.response.data && error.response.data.message) {
                    errorDiv.textContent = error.response.data.message;
                } else if (error.response && error.response.data && error.response.data.errors) {
                    const errors = Object.values(error.response.data.errors).flat();
                    errorDiv.innerHTML = errors.join('<br>');
                } else {
                    errorDiv.textContent = 'An error occurred during login. Please try again.';
                }
            }
        });
    </script>
</body>
</html>

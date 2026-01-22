<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>BrewBreeze - Premium Coffee Subscription</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=playfair-display:700,900|inter:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            .font-display { font-family: 'Playfair Display', serif; }
            .font-sans { font-family: 'Inter', sans-serif; }
            body {
                background: linear-gradient(to bottom, #ffffff 0%, #fef7f0 20%, #ffffff 40%, #fef7f0 60%, #ffffff 80%, #fef7f0 100%);
                background-attachment: fixed;
            }
            @keyframes fade-in {
                from { opacity: 0; }
                to { opacity: 1; }
            }
            @keyframes fade-in-up {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            .animate-fade-in {
                animation: fade-in 0.8s ease-out forwards;
            }
            .animate-fade-in-up {
                animation: fade-in-up 1s ease-out forwards;
                opacity: 0;
            }
        </style>
    </head>
    <body class="antialiased overflow-x-hidden">
        <!-- Hero Section with Background -->
        <div class="relative min-h-screen bg-cover bg-center bg-no-repeat" style="background-image: linear-gradient(rgba(59, 42, 42, 0.7), rgba(42, 31, 31, 0.8)), url('{{ asset('images/background.jpg') }}');">
            <!-- Navigation -->
            <div class="absolute top-0 left-0 right-0 z-50">
                <x-header transparent="true" />
            </div>

            <!-- Hero Content -->
            <div class="relative z-10 flex items-center justify-center min-h-screen px-6 md:px-12 pt-32">
                <div class="max-w-7xl mx-auto text-center">
                    <!-- Established Badge -->
                    <div class="mb-10 flex items-center justify-center gap-4 animate-fade-in">
                        <div class="flex items-center gap-4 bg-brew-brown/40 backdrop-blur-md px-8 py-4 rounded-full border-2 border-brew-light-brown/50 shadow-xl">
                            <div class="w-12 h-12 rounded-full bg-brew-light-brown flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-brew-cream" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M2,21H20V19H2M20,8H18V5H20M20,3H4V13A4,4 0 0,0 8,17H14A4,4 0 0,0 18,13V10H20A2,2 0 0,0 22,8V5C22,3.89 21.1,3 20,3Z"/>
                                </svg>
                            </div>
                            <div class="flex items-center gap-5 text-white font-sans text-sm uppercase tracking-widest">
                                <span class="font-semibold">ESTABLISHED</span>
                                <div class="w-px h-6 bg-brew-light-brown/60"></div>
                                <span class="font-bold text-base">SINCE 1998</span>
                            </div>
                        </div>
                    </div>

                    <!-- Main Heading -->
                    <h1 class="font-display font-black text-6xl md:text-8xl lg:text-9xl text-white mb-6 leading-none animate-fade-in-up" style="animation-delay: 0.2s;">
                        BrewBreeze
                        <br>
                        <span class="text-brew-light-brown">Cafe!</span>
                    </h1>

                    <!-- Logo Badge -->
                    <div class="inline-block mb-8 animate-fade-in-up" style="animation-delay: 0.4s;">
                        <div class="bg-brew-cream px-8 py-6 rounded-2xl shadow-2xl border-4 border-brew-light-brown transform -rotate-2">
                            <img src="{{ asset('images/logo.png') }}" alt="BrewBreeze Logo" class="w-24 h-24 object-contain">
                        </div>
                    </div>

                    <!-- Tagline -->
                    <p class="text-white text-lg md:text-xl lg:text-2xl font-sans max-w-3xl mx-auto mb-16 leading-relaxed animate-fade-in-up font-light tracking-wide" style="animation-delay: 0.6s;">
                        DISCOVER THE PERFECT <span class="text-brew-light-brown font-bold">BLEND</span> OF COFFEE AND<br>
                        COMMUNITY AT BREWBREEZE CAFE.
                    </p>

                    <!-- CTA Button with Scroll Indicator -->
                    <div class="animate-fade-in-up" style="animation-delay: 0.8s;">
                        <a href="#features" class="inline-flex items-center justify-center w-16 h-16 bg-brew-orange hover:bg-brew-light-brown text-brew-cream rounded-full transition-all transform hover:scale-110 shadow-2xl">
                            <svg class="w-8 h-8 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Video Carousel Section -->
        <div class="bg-gradient-to-b from-white via-brew-cream/5 to-brew-cream/10 py-20 px-6 md:px-12 overflow-hidden">
            <div class="max-w-7xl mx-auto">
                <!-- Text Label -->
                <div class="text-center mb-12">
                    <h2 class="font-display text-3xl md:text-5xl text-brew-brown mb-3">Experience BrewBreeze</h2>
                    <p class="text-gray-600 text-lg font-sans">Discover our coffee journey</p>
                </div>
                
                <div class="relative flex items-center justify-center h-[400px] md:h-[500px]">
                    <!-- Video 1 -->
                    <div class="video-card video-1 absolute left-0 md:left-[5%] z-10 w-64 h-64 md:w-80 md:h-80 transition-all duration-700 cursor-pointer hover:scale-105" 
                         onclick="goToSlide(1)">
                        <div class="relative w-full h-full rounded-2xl overflow-hidden shadow-2xl border-4 border-white">
                            <video class="w-full h-full object-cover" autoplay muted loop playsinline>
                                <source src="{{ asset('images/video 1.mp4') }}" type="video/mp4">
                            </video>
                        </div>
                    </div>

                    <!-- Video 2 -->
                    <div class="video-card video-2 absolute left-1/2 -translate-x-1/2 z-30 w-80 h-80 md:w-[450px] md:h-[450px] transition-all duration-700 cursor-pointer hover:scale-105" 
                         onclick="goToSlide(2)">
                        <div class="relative w-full h-full rounded-3xl overflow-hidden shadow-[0_20px_60px_rgba(0,0,0,0.3)] border-[6px] border-white">
                            <video class="w-full h-full object-cover" autoplay muted loop playsinline>
                                <source src="{{ asset('images/video 2.mp4') }}" type="video/mp4">
                            </video>
                        </div>
                    </div>

                    <!-- Video 3 -->
                    <div class="video-card video-3 absolute right-0 md:right-[5%] z-10 w-64 h-64 md:w-80 md:h-80 transition-all duration-700 cursor-pointer hover:scale-105" 
                         onclick="goToSlide(3)">
                        <div class="relative w-full h-full rounded-2xl overflow-hidden shadow-2xl border-4 border-white">
                            <video class="w-full h-full object-cover" autoplay muted loop playsinline>
                                <source src="{{ asset('images/video 3.mp4') }}" type="video/mp4">
                            </video>
                        </div>
                    </div>

                    <!-- Navigation Arrows -->
                    <button onclick="previousSlide()" 
                            class="absolute left-2 md:left-8 top-1/2 -translate-y-1/2 z-40 bg-white/90 hover:bg-white text-brew-brown p-3 md:p-4 rounded-xl transition-all hover:scale-110 shadow-xl backdrop-blur-sm">
                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>

                    <button onclick="nextSlide()" 
                            class="absolute right-2 md:right-8 top-1/2 -translate-y-1/2 z-40 bg-white/90 hover:bg-white text-brew-brown p-3 md:p-4 rounded-xl transition-all hover:scale-110 shadow-xl backdrop-blur-sm">
                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>

                    <!-- Carousel Indicators -->
                    <div class="absolute bottom-0 left-1/2 -translate-x-1/2 z-40 flex gap-3">
                        <button onclick="goToSlide(1)" class="carousel-indicator w-3 h-3 rounded-full bg-brew-brown/40 hover:bg-brew-brown transition-all cursor-pointer" data-slide="1"></button>
                        <button onclick="goToSlide(2)" class="carousel-indicator w-3 h-3 rounded-full bg-brew-brown/40 hover:bg-brew-brown transition-all cursor-pointer active" data-slide="2"></button>
                        <button onclick="goToSlide(3)" class="carousel-indicator w-3 h-3 rounded-full bg-brew-brown/40 hover:bg-brew-brown transition-all cursor-pointer" data-slide="3"></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Coffee Menu Preview Section -->
        <div id="menu" class="bg-gradient-to-b from-brew-cream/5 via-brew-cream/10 to-brew-cream/5 py-20 px-6 md:px-12">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16">
                    <p class="text-brew-brown text-sm uppercase tracking-[0.2em] mb-3 font-sans font-bold">Premium Selection</p>
                    <h2 class="font-display text-4xl md:text-6xl text-brew-brown mb-5">Our Coffee Selection</h2>
                    <p class="text-gray-600 text-lg font-sans">Explore our carefully curated coffee varieties</p>
                </div>
                
                <div class="grid md:grid-cols-2 gap-8 mb-12">
                    <!-- Light Roast Card -->
                    <div class="group bg-white border border-brew-brown/20 rounded-xl p-8 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 hover:border-brew-orange">
                        <div class="flex items-start gap-4">
                            <div class="w-14 h-14 bg-brew-cream rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-brew-orange transition-colors duration-300">
                                <svg class="w-7 h-7 text-brew-brown group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-semibold text-brew-brown mb-2 font-display">Light Roast</h3>
                                <p class="text-gray-600 leading-relaxed">Bright and crisp with delicate flavors</p>
                            </div>
                        </div>
                    </div>

                    <!-- Medium Roast Card -->
                    <div class="group bg-white border border-brew-brown/20 rounded-xl p-8 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 hover:border-brew-orange">
                        <div class="flex items-start gap-4">
                            <div class="w-14 h-14 bg-brew-cream rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-brew-orange transition-colors duration-300">
                                <svg class="w-7 h-7 text-brew-brown group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-semibold text-brew-brown mb-2 font-display">Medium Roast</h3>
                                <p class="text-gray-600 leading-relaxed">Balanced flavor with moderate acidity</p>
                            </div>
                        </div>
                    </div>

                    <!-- Dark Roast Card -->
                    <div class="group bg-white border border-brew-brown/20 rounded-xl p-8 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 hover:border-brew-orange">
                        <div class="flex items-start gap-4">
                            <div class="w-14 h-14 bg-brew-cream rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-brew-orange transition-colors duration-300">
                                <svg class="w-7 h-7 text-brew-brown group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-semibold text-brew-brown mb-2 font-display">Dark Roast</h3>
                                <p class="text-gray-600 leading-relaxed">Bold, rich, and full-bodied flavor</p>
                            </div>
                        </div>
                    </div>

                    <!-- Espresso Card -->
                    <div class="group bg-white border border-brew-brown/20 rounded-xl p-8 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 hover:border-brew-orange">
                        <div class="flex items-start gap-4">
                            <div class="w-14 h-14 bg-brew-cream rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-brew-orange transition-colors duration-300">
                                <svg class="w-7 h-7 text-brew-brown group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-semibold text-brew-brown mb-2 font-display">Espresso</h3>
                                <p class="text-gray-600 leading-relaxed">Perfect for espresso and strong coffee</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="text-center">
                    <a href="{{ auth()->check() ? route('customer.products') : route('customer.products') }}" 
                       class="inline-block px-8 py-3 bg-brew-brown text-white hover:bg-brew-light-brown transition-colors font-sans">
                        View Full Menu →
                    </a>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div id="features" class="bg-gradient-to-b from-brew-cream/5 via-white to-brew-cream/5 py-20 px-6 md:px-12">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16">
                    <p class="text-brew-brown text-sm uppercase tracking-[0.2em] mb-3 font-sans font-bold">Why Choose Us</p>
                    <h2 class="font-display text-4xl md:text-6xl text-brew-brown mb-5">Why Choose BrewBreeze?</h2>
                    <p class="text-gray-600 text-lg font-sans">Premium coffee delivered to your doorstep</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Premium Beans Card -->
                    <div class="group bg-white border border-brew-brown/20 rounded-xl p-8 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 hover:border-brew-orange text-center">
                        <div class="w-16 h-16 bg-brew-cream rounded-xl flex items-center justify-center mx-auto mb-6 group-hover:bg-brew-orange transition-colors duration-300">
                            <svg class="w-9 h-9 text-brew-brown group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                        </div>
                        <h3 class="font-display text-2xl text-brew-brown mb-4 leading-tight">Premium Beans</h3>
                        <p class="text-gray-600 font-sans leading-relaxed">Sourced from the finest coffee regions around the world</p>
                    </div>

                    <!-- Fast Delivery Card -->
                    <div class="group bg-white border border-brew-brown/20 rounded-xl p-8 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 hover:border-brew-orange text-center">
                        <div class="w-16 h-16 bg-brew-cream rounded-xl flex items-center justify-center mx-auto mb-6 group-hover:bg-brew-orange transition-colors duration-300">
                            <svg class="w-9 h-9 text-brew-brown group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <h3 class="font-display text-2xl text-brew-brown mb-4 leading-tight">Fast Delivery</h3>
                        <p class="text-gray-600 font-sans leading-relaxed">Fresh coffee delivered to your door within 24 hours</p>
                    </div>

                    <!-- Subscription Plans Card -->
                    <div class="group bg-white border border-brew-brown/20 rounded-xl p-8 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 hover:border-brew-orange text-center">
                        <div class="w-16 h-16 bg-brew-cream rounded-xl flex items-center justify-center mx-auto mb-6 group-hover:bg-brew-orange transition-colors duration-300">
                            <svg class="w-9 h-9 text-brew-brown group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="font-display text-2xl text-brew-brown mb-4 leading-tight">Subscription Plans</h3>
                        <p class="text-gray-600 font-sans leading-relaxed">Flexible plans with exclusive discounts for members</p>
                    </div>
                </div>
            </div>
        </div>

        <style>
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
            
            .animate-fade-in {
                animation: fade-in 1s ease-out;
            }
            
            .animate-fade-in-up {
                animation: fade-in-up 1s ease-out;
                animation-fill-mode: both;
            }

            /* Carousel Indicator Styles */
            .carousel-indicator.active {
                @apply bg-brew-brown w-8 scale-125;
            }

            /* Video Card Transitions */
            .video-card {
                transition: all 0.7s cubic-bezier(0.4, 0, 0.2, 1);
            }
        </style>

        <script>
            let currentSlide = 2; // Start with center video
            const totalSlides = 3;

            function showSlide(n) {
                // Get all video cards
                const video1 = document.querySelector('.video-1');
                const video2 = document.querySelector('.video-2');
                const video3 = document.querySelector('.video-3');

                // Reset all to small size and side positions
                [video1, video2, video3].forEach(card => {
                    if (card) {
                        card.classList.remove('w-80', 'h-80', 'md:w-[450px]', 'md:h-[450px]', 'z-30');
                        card.classList.add('w-64', 'h-64', 'md:w-80', 'md:h-80', 'z-10');
                    }
                });

                // Position based on which slide is active
                if (n === 1) {
                    // Video 1 in center
                    video1.style.left = '50%';
                    video1.style.transform = 'translateX(-50%)';
                    video1.classList.remove('w-64', 'h-64', 'md:w-80', 'md:h-80', 'z-10');
                    video1.classList.add('w-80', 'h-80', 'md:w-[450px]', 'md:h-[450px]', 'z-30');
                    
                    video2.style.left = '0';
                    video2.style.transform = 'translateX(0)';
                    
                    video3.style.left = '100%';
                    video3.style.transform = 'translateX(-100%)';
                } else if (n === 2) {
                    // Video 2 in center
                    video1.style.left = '0';
                    video1.style.transform = 'translateX(0)';
                    
                    video2.style.left = '50%';
                    video2.style.transform = 'translateX(-50%)';
                    video2.classList.remove('w-64', 'h-64', 'md:w-80', 'md:h-80', 'z-10');
                    video2.classList.add('w-80', 'h-80', 'md:w-[450px]', 'md:h-[450px]', 'z-30');
                    
                    video3.style.left = '100%';
                    video3.style.transform = 'translateX(-100%)';
                } else if (n === 3) {
                    // Video 3 in center
                    video1.style.left = '0';
                    video1.style.transform = 'translateX(0)';
                    
                    video2.style.left = '0';
                    video2.style.transform = 'translateX(0)';
                    
                    video3.style.left = '50%';
                    video3.style.transform = 'translateX(-50%)';
                    video3.classList.remove('w-64', 'h-64', 'md:w-80', 'md:h-80', 'z-10');
                    video3.classList.add('w-80', 'h-80', 'md:w-[450px]', 'md:h-[450px]', 'z-30');
                }

                // Update indicators
                document.querySelectorAll('.carousel-indicator').forEach(indicator => {
                    indicator.classList.remove('active');
                });
                document.querySelector(`.carousel-indicator[data-slide="${n}"]`)?.classList.add('active');
            }

            function nextSlide() {
                currentSlide = (currentSlide % totalSlides) + 1;
                showSlide(currentSlide);
            }

            function previousSlide() {
                currentSlide = ((currentSlide - 2 + totalSlides) % totalSlides) + 1;
                showSlide(currentSlide);
            }

            function goToSlide(n) {
                currentSlide = n;
                showSlide(currentSlide);
            }

            // Initialize carousel on page load
            document.addEventListener('DOMContentLoaded', function() {
                showSlide(currentSlide);
            });
        </script>

    <!-- Call to Action Section -->
    <section class="py-16 text-white" style="background-color: #4A3535;">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-4xl font-bold mb-4">Ready to Experience Premium Coffee?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">
                Join thousands of coffee lovers who have discovered the perfect cup with BrewBreeze.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ auth()->check() ? route('customer.products') : route('register') }}" 
                   class="px-8 py-3 bg-brew-light-brown text-brew-white rounded-lg font-semibold hover:bg-brew-orange transition">
                    Get Started
                </a>
                <a href="{{ auth()->check() ? route('customer.products') : route('register') }}" 
                   class="px-8 py-3 bg-transparent border-2 border-brew-white text-brew-white rounded-lg font-semibold hover:bg-brew-light-brown hover:text-brew-brown transition">
                    View Menu
                </a>
            </div>
        </div>
    </section>

    <!-- Spacer between content and footer -->
    <div class="h-16 bg-transparent"></div>

    <x-footer />
    @livewireScripts
</body>
</html>

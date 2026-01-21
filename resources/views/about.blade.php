<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>About - BrewBreeze</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=playfair-display:700,900|inter:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        
        <style>
            .font-display { font-family: 'Playfair Display', serif; }
            .font-sans { font-family: 'Inter', sans-serif; }
        </style>
    </head>
    <body class="antialiased overflow-x-hidden">
        <!-- Hero Section with Background -->
        <div class="relative min-h-screen bg-cover bg-center bg-no-repeat" style="background-image: linear-gradient(rgba(59, 42, 42, 0.6), rgba(42, 31, 31, 0.7)), url('{{ asset('images/coffee-beans.jpg') }}');">
            <!-- Navigation -->
            <div class="absolute top-0 left-0 right-0 z-50">
                <x-header transparent="true" />
            </div>

            <!-- Hero Content -->
            <div class="relative z-10 flex items-center justify-center min-h-screen px-6 md:px-12 pt-32">
                <div class="max-w-4xl mx-auto text-center">
                    <h1 class="text-5xl md:text-7xl font-display font-bold text-white mb-6">About BrewBreeze</h1>
                    <p class="text-xl md:text-2xl text-brew-cream font-sans mb-8 leading-relaxed">
                        Crafting the perfect blend since 1998
                    </p>
                </div>
            </div>
        </div>

        <!-- About Content -->
        <div class="bg-gradient-to-b from-white via-brew-cream/5 to-white py-20 px-6 md:px-12">
            <div class="max-w-4xl mx-auto">
                <!-- Mission Statement -->
                <div class="mb-16">
                    <h2 class="text-4xl md:text-5xl font-display font-bold text-brew-brown mb-8 text-center">Our Mission</h2>
                    <p class="text-lg text-gray-700 font-sans leading-relaxed text-center mb-8">
                        At BrewBreeze, we believe that great coffee brings people together. Since our founding in 1998, 
                        we've been committed to sourcing the finest coffee beans from around the world and crafting them 
                        into exceptional blends that elevate every moment.
                    </p>
                    <p class="text-lg text-gray-700 font-sans leading-relaxed text-center">
                        We're passionate about sustainability, quality, and community. Every cup of BrewBreeze coffee 
                        represents our dedication to excellence and our love for the art of coffee making.
                    </p>
                </div>

                <!-- Story Section -->
                <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 mb-16 border border-brew-light-brown/20">
                    <h3 class="text-3xl font-display font-bold text-brew-brown mb-6">Our Story</h3>
                    <div class="space-y-6 text-gray-700 font-sans leading-relaxed">
                        <p>
                            BrewBreeze Cafe was born from a simple passion: to serve exceptional coffee to our community. 
                            What started as a small neighborhood cafe has grown into a beloved destination for coffee enthusiasts 
                            and community members alike.
                        </p>
                        <p>
                            Over the past two decades, we've perfected our craft through continuous learning, experimentation, 
                            and feedback from our valued customers. We've built relationships with coffee farmers around the world, 
                            ensuring that every bean we source meets our rigorous standards for quality and sustainability.
                        </p>
                        <p>
                            Today, BrewBreeze remains committed to the values that founded us: quality without compromise, 
                            community at the heart of everything we do, and an unwavering dedication to bringing the perfect 
                            cup of coffee to your hands.
                        </p>
                    </div>
                </div>

                <!-- Values Section -->
                <div class="mb-16">
                    <h3 class="text-3xl font-display font-bold text-brew-brown mb-12 text-center">Our Values</h3>
                    <div class="grid md:grid-cols-3 gap-8">
                        <!-- Quality -->
                        <div class="bg-brew-cream/50 rounded-xl p-8 border border-brew-light-brown/20">
                            <div class="w-16 h-16 bg-brew-orange rounded-full flex items-center justify-center mb-6 mx-auto">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h4 class="text-xl font-display font-bold text-brew-brown mb-3 text-center">Quality</h4>
                            <p class="text-gray-700 font-sans text-center leading-relaxed">
                                We never compromise on quality. Every coffee bean is carefully selected and expertly roasted 
                                to perfection.
                            </p>
                        </div>

                        <!-- Sustainability -->
                        <div class="bg-brew-cream/50 rounded-xl p-8 border border-brew-light-brown/20">
                            <div class="w-16 h-16 bg-brew-orange rounded-full flex items-center justify-center mb-6 mx-auto">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20H7m6-4h.01M9 20h6"></path>
                                </svg>
                            </div>
                            <h4 class="text-xl font-display font-bold text-brew-brown mb-3 text-center">Sustainability</h4>
                            <p class="text-gray-700 font-sans text-center leading-relaxed">
                                We're committed to environmentally responsible practices and fair trade partnerships 
                                with coffee farmers worldwide.
                            </p>
                        </div>

                        <!-- Community -->
                        <div class="bg-brew-cream/50 rounded-xl p-8 border border-brew-light-brown/20">
                            <div class="w-16 h-16 bg-brew-orange rounded-full flex items-center justify-center mb-6 mx-auto">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 8.646 4 4 0 010-8.646M12 14H8m4 0h4m-8 2h8a2 2 0 002-2V8a2 2 0 00-2-2h-8a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <h4 class="text-xl font-display font-bold text-brew-brown mb-3 text-center">Community</h4>
                            <p class="text-gray-700 font-sans text-center leading-relaxed">
                                We believe great coffee brings people together. Our cafe is a place where connections 
                                are made and memories are created.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- CTA Section -->
                <div class="bg-brew-brown text-white rounded-2xl p-12 text-center">
                    <h3 class="text-3xl font-display font-bold mb-4">Join the BrewBreeze Family</h3>
                    <p class="text-lg font-sans mb-8 text-brew-cream">
                        Experience exceptional coffee and become part of our community
                    </p>
                    <a href="{{ route('customer.products') }}" class="inline-block px-8 py-3 bg-brew-orange hover:bg-brew-light-brown text-white font-sans font-bold rounded-xl transition-all transform hover:scale-105">
                        Explore Our Coffee
                    </a>
                </div>
            </div>
        </div>

        <x-footer />
    </body>
</html>

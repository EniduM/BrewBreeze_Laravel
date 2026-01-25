<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Two Factor Authentication - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="antialiased" style="background-image: url('/images/auth-bg.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed;">
    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <!-- Modern Card Container -->
        <div class="w-full max-w-md">
            <div class="bg-brew-cream rounded-3xl shadow-2xl p-8 md:p-12" x-data="twoFactorChallenge()">
                
                <!-- Lock Icon -->
                <div class="flex justify-center mb-6">
                    <div class="w-20 h-20 rounded-full bg-brew-orange/20 flex items-center justify-center">
                        <svg class="w-10 h-10 text-brew-brown" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Title -->
                <h1 class="text-3xl md:text-4xl font-bold text-brew-brown text-center mb-3">Easy peasy</h1>

                <!-- Subtitle -->
                <p class="text-brew-light-brown text-center mb-8">Enter 6-digit code from your two factor authenticator APP.</p>

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700">{{ $errors->first() }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- 6-Digit Input Form -->
                <form method="POST" action="{{ route('two-factor.login') }}" x-show="!showRecovery">
                    @csrf
                    
                    <!-- Hidden input to store the complete code -->
                    <input type="hidden" name="code" x-model="fullCode">
                    
                    <!-- 6 Individual Digit Boxes -->
                    <div class="flex justify-center gap-2 md:gap-3 mb-6">
                        <template x-for="i in 6" :key="i">
                            <input
                                type="text"
                                :id="'digit-' + i"
                                maxlength="1"
                                inputmode="numeric"
                                pattern="[0-9]"
                                class="w-12 h-14 md:w-14 md:h-16 text-center text-2xl font-semibold border-2 border-brew-light-brown/30 rounded-xl focus:border-brew-brown focus:ring-2 focus:ring-brew-orange/30 focus:outline-none transition-all bg-white text-brew-brown"
                                x-model="digits[i-1]"
                                @input="handleInput($event, i)"
                                @keydown="handleKeydown($event, i)"
                                @paste="handlePaste($event)"
                                autocomplete="off"
                            />
                        </template>
                    </div>

                    <!-- Digits Left Message -->
                    <div class="text-center mb-6">
                        <div class="inline-block bg-brew-orange/10 px-6 py-3 rounded-full">
                            <span class="text-brew-light-brown font-medium" x-text="digitsLeft + ' digits left'"></span>
                        </div>
                    </div>

                    <!-- Auto-submit when complete -->
                    <template x-if="fullCode.length === 6">
                        <div x-init="$nextTick(() => $el.closest('form').submit())"></div>
                    </template>
                </form>

                <!-- Recovery Code Form (Hidden by default) -->
                <form method="POST" action="{{ route('two-factor.login') }}" x-show="showRecovery" x-cloak>
                    @csrf
                    
                    <div class="mb-6">
                        <label for="recovery_code" class="block text-sm font-medium text-brew-brown mb-2">Recovery Code</label>
                        <input
                            id="recovery_code"
                            type="text"
                            name="recovery_code"
                            class="w-full px-4 py-3 border-2 border-brew-light-brown/30 rounded-xl focus:border-brew-brown focus:ring-2 focus:ring-brew-orange/30 focus:outline-none transition-all bg-white text-brew-brown"
                            placeholder="Enter recovery code"
                            autocomplete="off"
                        />
                    </div>

                    <button type="submit" class="w-full bg-brew-brown hover:bg-brew-light-brown text-brew-white font-semibold py-3 px-6 rounded-full transition-all duration-200 shadow-lg hover:shadow-xl">
                        Verify Recovery Code
                    </button>
                </form>

                <!-- Toggle Recovery Code Link -->
                <div class="text-center mt-6">
                    <button
                        type="button"
                        @click="showRecovery = !showRecovery; if(!showRecovery) resetDigits()"
                        class="text-sm text-brew-light-brown hover:text-brew-brown underline transition-colors"
                        x-text="showRecovery ? 'Use authentication code' : 'Use a recovery code'"
                    ></button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function twoFactorChallenge() {
            return {
                digits: ['', '', '', '', '', ''],
                showRecovery: false,
                
                get fullCode() {
                    return this.digits.join('');
                },
                
                get digitsLeft() {
                    const filled = this.digits.filter(d => d !== '').length;
                    return 6 - filled;
                },
                
                handleInput(event, position) {
                    const value = event.target.value;
                    
                    // Only allow numbers
                    if (value && !/^\d$/.test(value)) {
                        this.digits[position - 1] = '';
                        return;
                    }
                    
                    // Move to next input if value entered
                    if (value && position < 6) {
                        const nextInput = document.getElementById('digit-' + (position + 1));
                        if (nextInput) nextInput.focus();
                    }
                },
                
                handleKeydown(event, position) {
                    // Handle backspace
                    if (event.key === 'Backspace') {
                        if (!this.digits[position - 1] && position > 1) {
                            // Move to previous input if current is empty
                            const prevInput = document.getElementById('digit-' + (position - 1));
                            if (prevInput) {
                                prevInput.focus();
                                this.digits[position - 2] = '';
                            }
                        }
                    }
                    
                    // Handle arrow keys
                    if (event.key === 'ArrowLeft' && position > 1) {
                        event.preventDefault();
                        document.getElementById('digit-' + (position - 1)).focus();
                    }
                    if (event.key === 'ArrowRight' && position < 6) {
                        event.preventDefault();
                        document.getElementById('digit-' + (position + 1)).focus();
                    }
                },
                
                handlePaste(event) {
                    event.preventDefault();
                    const pastedData = event.clipboardData.getData('text').trim();
                    
                    // Check if pasted data is 6 digits
                    if (/^\d{6}$/.test(pastedData)) {
                        this.digits = pastedData.split('');
                        // Focus last input
                        document.getElementById('digit-6').focus();
                    }
                },
                
                resetDigits() {
                    this.digits = ['', '', '', '', '', ''];
                    this.$nextTick(() => {
                        const firstInput = document.getElementById('digit-1');
                        if (firstInput) firstInput.focus();
                    });
                },
                
                init() {
                    // Auto-focus first input
                    this.$nextTick(() => {
                        const firstInput = document.getElementById('digit-1');
                        if (firstInput) firstInput.focus();
                    });
                }
            }
        }
    </script>
</body>
</html>

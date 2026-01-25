<x-action-section>
    <x-slot name="title">
        {{ __('Two Factor Authentication') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Add additional security to your account using two factor authentication.') }}
    </x-slot>

    <x-slot name="content">
        <h3 class="text-lg font-sans font-semibold text-brew-brown mb-4">
            @if ($this->enabled)
                @if ($showingConfirmation)
                    {{ __('Finish enabling two factor authentication.') }}
                @else
                    {{ __('You have enabled two factor authentication.') }}
                @endif
            @else
                {{ __('You have not enabled two factor authentication.') }}
            @endif
        </h3>

        <div class="mt-4 max-w-xl text-sm text-brew-brown/70 font-sans">
            <p>
                {{ __('When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone\'s Google Authenticator application.') }}
            </p>
        </div>

        @if ($this->enabled)
            @if ($showingQrCode)
                <div class="mt-4 max-w-xl text-sm text-gray-600">
                    <p class="font-semibold">
                        @if ($showingConfirmation)
                            {{ __('To finish enabling two factor authentication, scan the following QR code using your phone\'s authenticator application or enter the setup key and provide the generated OTP code.') }}
                        @else
                            {{ __('Two factor authentication is now enabled. Scan the following QR code using your phone\'s authenticator application or enter the setup key.') }}
                        @endif
                    </p>
                </div>

                <div class="mt-4 p-2 inline-block bg-white">
                    {!! $this->user->twoFactorQrCodeSvg() !!}
                </div>

                <div class="mt-4 max-w-xl text-sm text-gray-600">
                    <p class="font-semibold">
                        {{ __('Setup Key') }}: {{ decrypt($this->user->two_factor_secret) }}
                    </p>
                </div>

                @if ($showingConfirmation)
                    <form wire:submit.prevent="confirmTwoFactorAuthentication" class="mt-4">
                        <x-label for="code" value="{{ __('Code') }}" />

                        <!-- Modern rounded input field -->
                        <input 
                            id="code" 
                            type="text" 
                            name="code" 
                            class="block mt-1 w-full md:w-1/2 border-gray-300 focus:border-[#6B4423] focus:ring focus:ring-[#6B4423] focus:ring-opacity-50 rounded-lg shadow-sm" 
                            inputmode="numeric" 
                            autofocus 
                            autocomplete="one-time-code"
                            wire:model.live="code"
                            placeholder="Enter 6-digit code"
                            maxlength="6" />

                        @error('code')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        
                        @if($code)
                            <p class="text-xs text-gray-500 mt-1">Current code: {{ $code }}</p>
                        @endif
                        
                        <!-- Modern rounded Confirm button -->
                        <button type="submit" 
                            class="inline-flex items-center px-6 py-3 bg-[#6B4423] hover:bg-[#5A3A1E] border border-transparent rounded-full font-semibold text-sm text-white tracking-wide hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-[#6B4423] focus:ring-offset-2 disabled:opacity-50 transition-all duration-200 mt-3"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="confirmTwoFactorAuthentication">{{ __('Confirm') }}</span>
                            <span wire:loading wire:target="confirmTwoFactorAuthentication">Confirming...</span>
                        </button>
                    </form>
                @endif
            @endif

            @if ($showingRecoveryCodes)
                <div class="mt-4 max-w-xl text-sm text-gray-600">
                    <p class="font-semibold">
                        {{ __('Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.') }}
                    </p>
                </div>

                <div class="grid gap-1 max-w-xl mt-4 px-4 py-4 font-mono text-sm bg-gray-100 rounded-lg">
                    @foreach (json_decode(decrypt($this->user->two_factor_recovery_codes), true) as $code)
                        <div>{{ $code }}</div>
                    @endforeach
                </div>
            @endif
        @endif

        <div class="mt-5">
            @if (! $this->enabled)
                <!-- Modern rounded Enable button with coffee theme -->
                <button type="button" 
                    wire:click="enableTwoFactorAuthentication" 
                    class="inline-flex items-center px-6 py-3 bg-[#6B4423] hover:bg-[#5A3A1E] border border-transparent rounded-full font-semibold text-sm text-white tracking-wide hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-[#6B4423] focus:ring-offset-2 disabled:opacity-50 transition-all duration-200"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove>{{ __('Enable') }}</span>
                    <span wire:loading>Enabling...</span>
                </button>
                
                <p class="text-xs text-gray-500 mt-3">Note: You will be asked to confirm your password</p>
            @else
                @if ($showingRecoveryCodes)
                    <!-- Modern rounded secondary button -->
                    <button type="button" 
                        wire:click="regenerateRecoveryCodes"
                        class="inline-flex items-center px-6 py-3 bg-white hover:bg-gray-50 border border-gray-300 rounded-full font-semibold text-sm text-gray-700 tracking-wide shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-[#6B4423] focus:ring-offset-2 disabled:opacity-50 transition-all duration-200 me-3">
                        {{ __('Regenerate Recovery Codes') }}
                    </button>
                @elseif (!$showingConfirmation)
                    <button type="button" 
                        wire:click="showRecoveryCodes"
                        class="inline-flex items-center px-6 py-3 bg-white hover:bg-gray-50 border border-gray-300 rounded-full font-semibold text-sm text-gray-700 tracking-wide shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-[#6B4423] focus:ring-offset-2 disabled:opacity-50 transition-all duration-200 me-3">
                        {{ __('Show Recovery Codes') }}
                    </button>
                @endif

                @if (!$showingConfirmation)
                    <!-- Modern rounded danger button -->
                    <button type="button" 
                        wire:click="disableTwoFactorAuthentication"
                        class="inline-flex items-center px-6 py-3 bg-red-600 hover:bg-red-500 border border-transparent rounded-full font-semibold text-sm text-white tracking-wide hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:opacity-50 transition-all duration-200"
                        wire:loading.attr="disabled">
                        {{ __('Disable') }}
                    </button>
                @else
                    <button type="button" 
                        wire:click="disableTwoFactorAuthentication"
                        class="inline-flex items-center px-6 py-3 bg-white hover:bg-gray-50 border border-gray-300 rounded-full font-semibold text-sm text-gray-700 tracking-wide shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-[#6B4423] focus:ring-offset-2 disabled:opacity-50 transition-all duration-200"
                        wire:loading.attr="disabled">
                        {{ __('Cancel') }}
                    </button>
                @endif

            @endif
        </div>
    </x-slot>
</x-action-section>

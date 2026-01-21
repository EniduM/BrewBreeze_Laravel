<div>
    <div class="max-w-6xl mx-auto px-4 py-8">
        <!-- Page Header -->
        <div class="text-center mb-10">
            <h1 class="text-4xl md:text-5xl font-display font-bold text-brew-cream mb-3">My Subscriptions</h1>
            <p class="text-lg text-brew-cream/80 font-sans">Manage your coffee subscription plans</p>
        </div>

        @if (session()->has('error'))
            <div class="mb-6 bg-red-50/90 backdrop-blur-lg border-2 border-red-300/50 text-red-800 px-6 py-4 rounded-2xl shadow-lg" role="alert">
                <span class="block sm:inline font-sans font-semibold">{{ session('error') }}</span>
            </div>
        @endif

        @if (session()->has('success'))
            <div class="mb-6 bg-green-50/90 backdrop-blur-lg border-2 border-green-300/50 text-green-800 px-6 py-4 rounded-2xl shadow-lg" role="alert">
                <span class="block sm:inline font-sans font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Subscribe Button -->
        @if(!$subscriptions->where('status', 'active')->first())
            <div class="mb-8 text-center">
                <button 
                    wire:click="showSubscribe"
                    class="px-8 py-4 bg-brew-light-brown hover:bg-brew-orange text-white font-sans font-bold rounded-xl transition-all duration-200 text-lg shadow-xl hover:shadow-2xl transform hover:-translate-y-0.5"
                >
                    Subscribe Now
                </button>
            </div>
        @endif

        <!-- Subscribe Form Modal -->
        @if($showSubscribeForm)
            <div class="fixed inset-0 bg-black/80 backdrop-blur-md flex items-center justify-center z-[100] overflow-hidden" wire:click="hideSubscribe" style="margin: 0 !important;">
                <div class="bg-white rounded-3xl shadow-2xl w-full max-w-5xl mx-4 border-2 border-brew-light-brown/30" wire:click.stop>
                    <div class="p-8">
                        <div class="flex justify-between items-center mb-8">
                            <h2 class="text-3xl font-display font-bold text-brew-brown">Choose Your Subscription Plan</h2>
                            <button 
                                wire:click="hideSubscribe"
                                class="text-brew-brown/50 hover:text-brew-brown transition-colors"
                            >
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <form wire:submit="subscribe">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                                @foreach($tiers as $tierKey => $tier)
                                    <div 
                                        class="border-2 rounded-2xl p-6 cursor-pointer transition-all duration-300 transform hover:-translate-y-1 {{ $selectedTier === $tierKey ? 'border-brew-light-brown bg-brew-cream/50 shadow-2xl scale-105' : 'border-brew-light-brown/30 hover:border-brew-light-brown hover:shadow-xl' }}"
                                        wire:click="$set('selectedTier', '{{ $tierKey }}')"
                                    >
                                        <div class="text-center mb-6">
                                            <h3 class="text-2xl font-display font-bold text-brew-brown mb-3">{{ $tier['name'] }}</h3>
                                            <div class="text-4xl font-display font-bold text-brew-light-brown mb-2">
                                                ${{ number_format($tier['price'], 2) }}
                                            </div>
                                            <span class="text-sm font-sans text-brew-brown/60">/month</span>
                                        </div>
                                        <p class="text-brew-brown/70 font-sans text-sm mb-6 text-center">{{ $tier['description'] }}</p>
                                        <ul class="space-y-3 mb-6">
                                            @foreach($tier['features'] as $feature)
                                                <li class="flex items-start text-sm text-brew-brown font-sans">
                                                    <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    {{ $feature }}
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="text-center">
                                            <input 
                                                type="radio" 
                                                name="subscription_tier"
                                                wire:model="selectedTier"
                                                value="{{ $tierKey }}"
                                                id="tier-{{ $tierKey }}"
                                                class="w-5 h-5 text-brew-light-brown border-brew-light-brown/30 focus:ring-brew-light-brown cursor-pointer"
                                            />
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @error('selectedTier') 
                                <div class="mb-4 text-red-600 text-sm font-sans font-semibold">{{ $message }}</div>
                            @enderror

                            <div class="flex justify-end space-x-4">
                                <button 
                                    type="button"
                                    wire:click="hideSubscribe"
                                    class="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition-all duration-200 font-sans font-semibold"
                                >
                                    Cancel
                                </button>
                                <button 
                                    type="submit"
                                    class="px-8 py-3 bg-brew-light-brown hover:bg-brew-orange text-white font-sans font-bold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl"
                                >
                                    <span wire:loading.remove wire:target="subscribe">Subscribe Now</span>
                                    <span wire:loading wire:target="subscribe">Processing...</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        <!-- Current Subscriptions -->
        <div class="space-y-6">
            @if($subscriptions->isEmpty())
                <div class="bg-white/95 backdrop-blur-lg rounded-2xl border-2 border-brew-light-brown/20 shadow-xl p-12 text-center">
                    <div class="bg-gradient-to-br from-brew-brown to-brew-light-brown rounded-2xl p-8 inline-block mb-6">
                        <svg class="w-20 h-20 text-white mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                    </div>
                    <h3 class="text-3xl font-display font-bold text-brew-brown mb-3">No Subscriptions Yet</h3>
                    <p class="text-brew-brown/70 font-sans text-lg mb-8">Start your coffee journey with a subscription plan.</p>
                    <button 
                        wire:click="showSubscribe"
                        class="px-8 py-4 bg-brew-light-brown hover:bg-brew-orange text-white font-sans font-bold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                    >
                        Browse Plans
                    </button>
                </div>
            @else
                @foreach($subscriptions as $subscription)
                    <div class="bg-white/95 backdrop-blur-lg rounded-2xl border-2 border-brew-light-brown/20 shadow-xl hover:shadow-2xl transition-all duration-300">
                        <div class="p-6 md:p-8">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                                <div>
                                    <h3 class="text-3xl font-display font-bold text-brew-brown mb-3">{{ $subscription->tier_name }}</h3>
                                    <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-brew-brown/60 font-sans">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            Started: {{ $subscription->start_date->format('M d, Y') }}
                                        </span>
                                        <span>•</span>
                                        <span>Active for {{ $subscription->days_active }} days</span>
                                    </div>
                                </div>
                                <div>
                                    @if($subscription->status === 'active')
                                        <span class="inline-block px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-bold font-sans uppercase tracking-wider">Active</span>
                                    @elseif($subscription->status === 'pending')
                                        <span class="inline-block px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full text-sm font-bold font-sans uppercase tracking-wider">Pending</span>
                                    @elseif($subscription->status === 'cancelled')
                                        <span class="inline-block px-4 py-2 bg-red-100 text-red-800 rounded-full text-sm font-bold font-sans uppercase tracking-wider">Cancelled</span>
                                    @else
                                        <span class="inline-block px-4 py-2 bg-gray-100 text-gray-800 rounded-full text-sm font-bold font-sans uppercase tracking-wider">{{ ucfirst($subscription->status) }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="border-t-2 border-brew-light-brown/10 pt-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div class="bg-brew-cream/30 rounded-xl p-6">
                                        <p class="text-sm text-brew-brown/60 mb-2 font-sans uppercase tracking-wider">Monthly Price</p>
                                        <p class="text-3xl font-display font-bold text-brew-light-brown">{{ $subscription->formatted_price }}</p>
                                    </div>
                                    <div class="bg-brew-cream/30 rounded-xl p-6">
                                        <p class="text-sm text-brew-brown/60 mb-2 font-sans uppercase tracking-wider">Next Billing Date</p>
                                        <p class="text-3xl font-display font-bold text-brew-light-brown">{{ $subscription->next_billing_date->format('M d, Y') }}</p>
                                    </div>
                                </div>

                                @if($subscription->tierInfo && isset($subscription->tierInfo['features']))
                                    <div class="mb-6 bg-brew-cream/20 rounded-xl p-6">
                                        <p class="text-sm font-bold text-brew-brown mb-4 font-sans uppercase tracking-wider">Features:</p>
                                        <ul class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                            @foreach($subscription->tierInfo['features'] as $feature)
                                                <li class="flex items-start text-sm text-brew-brown font-sans">
                                                    <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    {{ $feature }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @if($subscription->status === 'active')
                                    <div class="flex justify-end border-t-2 border-brew-light-brown/10 pt-6">
                                        <button 
                                            wire:click="cancel({{ $subscription->subscription_id }})"
                                            wire:confirm="Are you sure you want to cancel this subscription? You will continue to have access until the end of the billing period."
                                            class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-sans font-bold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl"
                                        >
                                            <span wire:loading.remove wire:target="cancel({{ $subscription->subscription_id }})">Cancel Subscription</span>
                                            <span wire:loading wire:target="cancel({{ $subscription->subscription_id }})">Cancelling...</span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

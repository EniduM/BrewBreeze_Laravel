<div>
    <div class="py-8">
        <div class="max-w-3xl mx-auto">
            <!-- Page Header -->
            <div class="mb-8 text-center">
                <h1 class="text-4xl md:text-5xl font-display font-bold text-brew-brown mb-3">Contact Us</h1>
                <p class="text-base text-brew-brown/70 font-sans">We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
            </div>

            @if (session()->has('message'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-xl shadow-md" role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-green-700 font-sans font-medium">{{ session('message') }}</span>
                    </div>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-xl shadow-md" role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-red-700 font-sans font-medium">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Message Form -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                <div class="p-8">
                    <form wire:submit="sendMessage">
                        <div class="space-y-6">
                            <div>
                                <label for="subject" class="block text-sm font-semibold text-brew-brown mb-2 font-sans">Subject</label>
                                <input 
                                    type="text" 
                                    id="subject"
                                    wire:model="subject" 
                                    placeholder="What's this about?"
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brew-orange focus:ring-brew-orange font-sans transition-all duration-200"
                                >
                                @error('subject') <span class="text-red-500 text-xs mt-1 block font-sans">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-semibold text-brew-brown mb-2 font-sans">Message</label>
                                <textarea 
                                    id="description"
                                    wire:model="description" 
                                    rows="8"
                                    placeholder="Tell us what's on your mind..."
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brew-orange focus:ring-brew-orange font-sans transition-all duration-200"
                                ></textarea>
                                @error('description') <span class="text-red-500 text-xs mt-1 block font-sans">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                                <button 
                                    type="button" 
                                    wire:click="$set('subject', '')"
                                    wire:click="$set('description', '')"
                                    onclick="this.form.reset();"
                                    class="px-6 py-2.5 border-2 border-brew-brown/20 rounded-xl text-brew-brown hover:bg-brew-brown/5 font-sans font-semibold transition-all duration-200"
                                >
                                    Clear
                                </button>
                                <button 
                                    type="submit" 
                                    class="px-8 py-2.5 bg-brew-brown hover:bg-brew-orange text-white font-semibold rounded-xl transition-all duration-200 shadow-md hover:shadow-lg font-sans"
                                >
                                    Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Additional Info Section -->
            <div class="mt-8 text-center">
                <p class="text-sm text-brew-brown/60 font-sans">
                    Need immediate assistance? Check out our 
                    <a href="{{ route('dashboard') }}" class="text-brew-orange hover:text-brew-brown font-semibold transition-colors">Dashboard</a> 
                    or view your 
                    <a href="{{ route('customer.orders') }}" class="text-brew-orange hover:text-brew-brown font-semibold transition-colors">Orders</a>.
                </p>
            </div>
        </div>
    </div>
</div>

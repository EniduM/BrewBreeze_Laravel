<div>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Contact Us</h1>
                <p class="mt-1 text-sm text-gray-600">Send a message to the admin</p>
            </div>

            @if (session()->has('message'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('message') }}</span>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Message Form -->
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form wire:submit="sendMessage">
                        <div class="space-y-4">
                            <div>
                                <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                                <input 
                                    type="text" 
                                    id="subject"
                                    wire:model="subject" 
                                    placeholder="Enter message subject"
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brew-light-brown focus:ring-brew-light-brown"
                                >
                                @error('subject') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                                <textarea 
                                    id="description"
                                    wire:model="description" 
                                    rows="6"
                                    placeholder="Enter your message here..."
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brew-light-brown focus:ring-brew-light-brown"
                                ></textarea>
                                @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex justify-end space-x-3 pt-4">
                                <button 
                                    type="button" 
                                    wire:click="$set('subject', '')"
                                    wire:click="$set('description', '')"
                                    onclick="this.form.reset();"
                                    class="px-4 py-2 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50"
                                >
                                    Clear
                                </button>
                                <button 
                                    type="submit" 
                                    class="px-6 py-2 bg-brew-light-brown hover:bg-brew-orange text-brew-white font-medium rounded-xl transition-all duration-200"
                                >
                                    Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

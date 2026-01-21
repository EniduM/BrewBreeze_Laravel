<div>
    <div class="container mx-auto px-4 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-brew-brown mb-2">Customer Messages</h1>
            <p class="text-lg text-brew-dark-brown">View and manage customer messages</p>
        </div>

            <!-- Search and Filter -->
            <div class="bg-white rounded-lg border border-brew-light-brown shadow-sm mb-8">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <input 
                                type="text" 
                                wire:model.live="search" 
                                placeholder="Search by subject, message, or customer..." 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-brew-brown focus:border-brew-brown"
                            >
                        </div>
                        <div>
                            <select 
                                wire:model.live="customerFilter" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-brew-brown focus:border-brew-brown"
                            >
                                <option value="">All Customers</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->customer_id }}">{{ $customer->name }} ({{ $customer->email }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Messages List -->
            @if($messages->count() > 0)
                <div class="space-y-4">
                    @foreach($messages as $message)
                        <div class="bg-white rounded-lg border border-brew-light-brown shadow-sm overflow-hidden">
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $message->subject }}</h3>
                                        <div class="mt-1 flex items-center space-x-4 text-sm text-gray-500">
                                            <span>From: {{ $message->customer->name ?? 'N/A' }}</span>
                                            <span>•</span>
                                            <span>{{ $message->customer->email ?? 'N/A' }}</span>
                                            <span>•</span>
                                            <span>{{ $message->date->format('M d, Y') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-t pt-4">
                                    <p class="text-gray-700 whitespace-pre-wrap">{{ $message->description }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $messages->links() }}
                </div>
            @else
                <div class="bg-white rounded-lg border border-brew-light-brown shadow-sm p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No messages found</h3>
                    <p class="mt-1 text-sm text-gray-500">There are no customer messages at the moment.</p>
                </div>
            @endif
        </div>
    </div>
</div>

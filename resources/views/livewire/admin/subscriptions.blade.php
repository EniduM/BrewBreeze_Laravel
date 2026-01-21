<div>
    <div class="container mx-auto px-4 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-brew-brown mb-2">Subscription Management</h1>
            <p class="text-lg text-brew-dark-brown">Manage customer subscription tiers and status</p>
        </div>
            @if (session()->has('message'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('message') }}</span>
                </div>
            @endif

            <!-- Search -->
            <div class="bg-white rounded-lg border border-brew-light-brown shadow-sm mb-8">
                <div class="p-6">
                    <input 
                        type="text" 
                        wire:model.live="search" 
                        placeholder="Search subscriptions by customer, tier, or status..." 
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-brew-brown focus:border-brew-brown"
                    >
                </div>
            </div>

            <!-- Subscriptions Table -->
            <div class="bg-white rounded-lg border border-brew-light-brown shadow-sm overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tier</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($subscriptions as $subscription)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $subscription->customer->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $subscription->tier }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $subscription->start_date->format('M d, Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $subscription->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $subscription->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button 
                                        wire:click="edit({{ $subscription->subscription_id }})" 
                                        class="text-amber-600 hover:text-amber-900 mr-3"
                                    >
                                        Edit
                                    </button>
                                    <button 
                                        wire:click="delete({{ $subscription->subscription_id }})" 
                                        wire:confirm="Are you sure you want to delete this subscription?"
                                        class="text-red-600 hover:text-red-900"
                                    >
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No subscriptions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $subscriptions->links() }}
            </div>

            <!-- Subscription Form Modal -->
            @if ($showForm)
                <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click="closeForm">
                    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white" wire:click.stop>
                        <div class="mt-3">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Subscription</h3>
                            @livewire('admin.subscription-form', ['subscriptionId' => $editingSubscriptionId], key($editingSubscriptionId))
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @script
    <script>
        $wire.on('subscription-saved', () => {
            $wire.closeForm();
        });
    </script>
    @endscript
</div>

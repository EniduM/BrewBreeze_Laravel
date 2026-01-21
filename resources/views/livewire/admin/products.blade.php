<div>
    <div class="container mx-auto px-4 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-brew-brown mb-2">Product Management</h1>
            <p class="text-lg text-brew-dark-brown">Create, update, and manage your coffee products</p>
        </div>
            @if (session()->has('message'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('message') }}</span>
                </div>
            @endif

        <!-- Search and Create Button -->
        <div class="bg-white rounded-lg border border-brew-light-brown shadow-sm mb-8">
            <div class="p-6">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="w-full md:w-1/2">
                        <input 
                            type="text" 
                            wire:model.live="search" 
                            placeholder="Search products..." 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brew-brown focus:border-brew-brown bg-white"
                        >
                    </div>
                    <button 
                        wire:click="create" 
                        class="w-full md:w-auto px-6 py-2 bg-brew-brown hover:bg-brew-dark-brown text-white font-medium rounded-lg transition-colors"
                    >
                            Create Product
                        </button>
                    </div>
                </div>
            </div>

            <!-- Products Table -->
            <div class="bg-white rounded-lg border border-brew-light-brown shadow-sm overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($products as $product)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $product->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ Str::limit($product->description, 50) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($product->price, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $product->stock }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button 
                                        type="button"
                                        wire:click="edit({{ $product->product_id }})" 
                                        class="text-amber-600 hover:text-amber-900 mr-3 font-medium"
                                    >
                                        Edit
                                    </button>
                                    <button 
                                        type="button"
                                        wire:click="delete({{ $product->product_id }})" 
                                        wire:confirm="Are you sure you want to delete this product?"
                                        class="text-red-600 hover:text-red-900 font-medium"
                                    >
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No products found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $products->links() }}
            </div>

            <!-- Product Form Modal -->
            @if ($showForm)
                <div class="fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto" wire:click="closeForm">
                    <div class="min-h-screen flex items-center justify-center p-4 py-8">
                        <div class="relative bg-white rounded-lg border border-brew-light-brown shadow-xl max-w-2xl w-full flex flex-col max-h-[calc(100vh-4rem)] my-auto" wire:click.stop>
                            <div class="flex-shrink-0 bg-white border-b border-brew-light-brown px-6 py-4 flex justify-between items-center rounded-t-lg">
                                <h3 class="text-2xl font-bold text-brew-brown">
                                    {{ $editingProductId ? 'Edit Product' : 'Create Product' }}
                                </h3>
                                <button type="button" wire:click="closeForm" class="text-gray-400 hover:text-gray-600 transition">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="flex-1 overflow-y-auto p-6">
                                @livewire('admin.product-form', ['productId' => $editingProductId], key($editingProductId ?? 'new'))
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @script
    <script>
        $wire.on('product-saved', () => {
            $wire.closeForm();
        });
    </script>
    @endscript
</div>

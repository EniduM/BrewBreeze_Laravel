<div>
    <form wire:submit="save" class="space-y-6">
        <div class="space-y-4">
            <div>
                <label for="name" class="block text-sm font-medium text-brew-brown mb-1">Name</label>
                <input 
                    type="text" 
                    id="name"
                    wire:model="name" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brew-brown focus:border-brew-brown bg-white text-gray-900"
                    placeholder="Enter product name"
                >
                @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-brew-brown mb-1">Description</label>
                <textarea 
                    id="description"
                    wire:model="description" 
                    rows="4"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brew-brown focus:border-brew-brown bg-white text-gray-900 resize-none"
                    placeholder="Enter product description"
                ></textarea>
                @error('description') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="roastLevel" class="block text-sm font-medium text-brew-brown mb-1">Roast Level</label>
                    <select 
                        id="roastLevel"
                        wire:model="roastLevel" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brew-brown focus:border-brew-brown bg-white text-gray-900"
                    >
                        <option value="">Select Roast Level</option>
                        <option value="Light">Light</option>
                        <option value="Medium">Medium</option>
                        <option value="Dark">Dark</option>
                    </select>
                    @error('roastLevel') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="origin" class="block text-sm font-medium text-brew-brown mb-1">Origin</label>
                    <input 
                        type="text" 
                        id="origin"
                        wire:model="origin" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brew-brown focus:border-brew-brown bg-white text-gray-900"
                        placeholder="e.g., Colombia, Ethiopia, Blend"
                    >
                    @error('origin') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="price" class="block text-sm font-medium text-brew-brown mb-1">Price</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                        <input 
                            type="number" 
                            id="price"
                            wire:model="price" 
                            step="0.01"
                            min="0"
                            class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brew-brown focus:border-brew-brown bg-white text-gray-900"
                            placeholder="0.00"
                        >
                    </div>
                    @error('price') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="stock" class="block text-sm font-medium text-brew-brown mb-1">Stock</label>
                    <input 
                        type="number" 
                        id="stock"
                        wire:model="stock" 
                        min="0"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brew-brown focus:border-brew-brown bg-white text-gray-900"
                        placeholder="0"
                    >
                    @error('stock') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label for="image" class="block text-sm font-medium text-brew-brown mb-1">Product Image</label>
                
                @if($imagePreview)
                    <div class="mb-4">
                        <img src="{{ $imagePreview }}" alt="Preview" class="w-32 h-32 object-cover rounded-lg border border-brew-light-brown">
                        <p class="text-xs text-gray-500 mt-2">{{ $image ? 'New Image Preview' : 'Current Image' }}</p>
                    </div>
                @endif

                <div class="mt-2">
                    <label for="image" class="cursor-pointer">
                        <div class="flex items-center justify-center w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-brew-brown transition bg-white">
                            <div class="text-center">
                                <svg class="mx-auto h-8 w-8 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <p class="mt-2 text-sm text-gray-600">
                                    <span class="font-medium text-brew-brown">Click to upload</span> or drag and drop
                                </p>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                            </div>
                        </div>
                    </label>
                    <input 
                        type="file" 
                        id="image"
                        wire:model="image" 
                        accept="image/*"
                        class="hidden"
                    >
                </div>
                @error('image') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                
                @if($image)
                    <p class="text-xs text-gray-500 mt-2">Selected: {{ $image->getClientOriginalName() }}</p>
                @endif
            </div>
        </div>

        <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
            <button 
                type="button" 
                wire:click="$dispatch('product-saved')"
                class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition"
            >
                Cancel
            </button>
            <button 
                type="submit" 
                class="px-6 py-3 bg-brew-brown hover:bg-brew-dark-brown text-white rounded-lg font-medium transition"
            >
                {{ $productId ? 'Update Product' : 'Create Product' }}
            </button>
        </div>
    </form>
</div>

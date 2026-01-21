<div>
    <form wire:submit="save">
        <div class="space-y-4">
            <div>
                <label for="tier" class="block text-sm font-medium text-gray-700">Tier</label>
                <input 
                    type="text" 
                    id="tier"
                    wire:model="tier" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500"
                >
                @error('tier') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select 
                    id="status"
                    wire:model="status" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500"
                >
                    <option value="">Select Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="cancelled">Cancelled</option>
                    <option value="pending">Pending</option>
                </select>
                @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                <input 
                    type="date" 
                    id="start_date"
                    wire:model="start_date" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500"
                >
                @error('start_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end space-x-3 pt-4">
                <button 
                    type="button" 
                    wire:click="$dispatch('subscription-saved')"
                    class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50"
                >
                    Cancel
                </button>
                <button 
                    type="submit" 
                    class="px-4 py-2 bg-brew-brown hover:bg-brew-dark-brown text-white rounded-md"
                >
                    Update
                </button>
            </div>
        </div>
    </form>
</div>

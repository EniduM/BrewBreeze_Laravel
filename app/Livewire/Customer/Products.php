<?php

namespace App\Livewire\Customer;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Products extends Component
{
    use WithPagination;

    public $search = '';
    public $roastLevel = 'all';
    public $origin = 'all';
    public $sortBy = 'name';
    public $sortOrder = 'asc';

    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingRoastLevel()
    {
        $this->resetPage();
    }

    public function updatingOrigin()
    {
        $this->resetPage();
    }

    public function updatingSortBy()
    {
        $this->resetPage();
    }

    public function updatingSortOrder()
    {
        $this->resetPage();
    }

    public function applyFilters()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->roastLevel = 'all';
        $this->origin = 'all';
        $this->sortBy = 'name';
        $this->sortOrder = 'asc';
        $this->resetPage();
    }

    public function addToCart($productId)
    {
        // Prevent admins from adding to cart
        if (auth()->check() && auth()->user()->isAdmin()) {
            session()->flash('error', 'Admins cannot place orders. This feature is for customers only.');
            return;
        }

        $customer = auth()->user()->getOrCreateCustomer();
        
        if (!$customer) {
            session()->flash('error', 'Unable to access customer account.');
            return;
        }

        $product = Product::findOrFail($productId);

        if ($product->stock <= 0) {
            session()->flash('error', 'Product is out of stock.');
            $this->dispatch('toast-notification', message: 'Product is out of stock.', type: 'error');
            return;
        }

        // Get or create cart for customer (ensures one active cart per customer)
        $cart = Cart::getOrCreateActiveCart($customer->customer_id);

        // Check if cart item already exists
        $cartItem = CartItem::where('cart_id', $cart->cart_id)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            // Update existing cart item
            $newQuantity = $cartItem->quantity + 1;
            if ($newQuantity > $product->stock) {
                session()->flash('error', 'Not enough stock available.');
                $this->dispatch('toast-notification', message: 'Not enough stock available.', type: 'error');
                return;
            }
            
            CartItem::where('cart_id', $cart->cart_id)
                ->where('product_id', $productId)
                ->update(['quantity' => $newQuantity]);
        } else {
            // Create new cart item
            CartItem::insert([
                'cart_id' => $cart->cart_id,
                'product_id' => $productId,
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        session()->flash('message', 'Product added to cart successfully!');
        $this->dispatch('cart-updated');
        $this->dispatch('toast-notification', message: 'Product added to cart!', type: 'success');
        
        // Refresh to show updated cart count
        $this->dispatch('$refresh');
    }

    public function render()
    {
        $customer = null;
        if (auth()->check() && !auth()->user()->isAdmin()) {
            try {
                $customer = auth()->user()->getOrCreateCustomer();
            } catch (\Exception $e) {
                // If customer creation fails, continue without customer
            }
        }
        
        // Base query - filter by subscription access
        $query = Product::where('stock', '>', 0);
        
        // Apply subscription-based access filtering
        if ($customer) {
            // All customers see regular products
            $query->where(function ($q) use ($customer) {
                $q->where('is_limited_edition', false);
                
                // Premium and Elite subscribers can see limited edition products
                if ($customer->canAccessLimitedEdition()) {
                    $q->orWhere('is_limited_edition', true);
                }
            });
        } else {
            // Non-authenticated or non-customers only see regular products
            $query->where('is_limited_edition', false);
        }

        // Search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Roast level filter
        if ($this->roastLevel && $this->roastLevel !== 'all') {
            $query->where('roast_level', $this->roastLevel);
        }

        // Origin filter
        if ($this->origin && $this->origin !== 'all') {
            $query->where('origin', $this->origin);
        }

        // Sorting
        $sortColumn = match($this->sortBy) {
            'price' => 'price',
            'stock' => 'stock',
            default => 'name',
        };

        $sortDirection = $this->sortOrder === 'desc' ? 'desc' : 'asc';
        $query->orderBy($sortColumn, $sortDirection);

        $products = $query->paginate(12);
        
        // Get subscription info for display
        $subscription = $customer ? $customer->activeSubscription()->first() : null;

        // Get unique origins and roast levels for filter dropdowns
        $origins = Product::whereNotNull('origin')
            ->where('stock', '>', 0)
            ->distinct()
            ->pluck('origin')
            ->filter()
            ->sort()
            ->values();

        $roastLevels = Product::whereNotNull('roast_level')
            ->where('stock', '>', 0)
            ->distinct()
            ->pluck('roast_level')
            ->filter()
            ->sort()
            ->values();

        return view('livewire.customer.products', [
            'products' => $products,
            'origins' => $origins,
            'roastLevels' => $roastLevels,
            'subscription' => $subscription,
            'customer' => $customer,
        ]);
    }
}

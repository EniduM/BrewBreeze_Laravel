<?php

namespace App\Livewire\Customer;

use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Livewire\Component;
use Illuminate\Support\Str;

class ProductDetail extends Component
{
    public $productId;

    public function mount($productId)
    {
        $this->productId = $productId;
    }

    public function getCustomer()
    {
        if (!auth()->check() || auth()->user()->isAdmin()) {
            return null;
        }
        
        try {
            return auth()->user()->getOrCreateCustomer();
        } catch (\Exception $e) {
            return null;
        }
    }

    public function addToCart()
    {
        $customer = $this->getCustomer();
        
        if (!$customer) {
            session()->flash('error', 'Please log in to add items to cart.');
            return;
        }

        $product = Product::findOrFail($this->productId);

        if ($product->stock <= 0) {
            session()->flash('error', 'Product is out of stock.');
            $this->dispatch('toast-notification', message: 'Product is out of stock.', type: 'error');
            return;
        }

        // Get or create cart for customer
        $cart = \App\Models\Cart::getOrCreateActiveCart($customer->customer_id);

        // Check if cart item already exists
        $cartItem = \App\Models\CartItem::where('cart_id', $cart->cart_id)
            ->where('product_id', $this->productId)
            ->first();

        if ($cartItem) {
            // Update existing cart item
            $newQuantity = $cartItem->quantity + 1;
            if ($newQuantity > $product->stock) {
                session()->flash('error', 'Not enough stock available.');
                $this->dispatch('toast-notification', message: 'Not enough stock available.', type: 'error');
                return;
            }
            
            \App\Models\CartItem::where('cart_id', $cart->cart_id)
                ->where('product_id', $this->productId)
                ->update(['quantity' => $newQuantity]);
        } else {
            // Create new cart item
            \App\Models\CartItem::insert([
                'cart_id' => $cart->cart_id,
                'product_id' => $this->productId,
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        session()->flash('message', 'Product added to cart successfully!');
        $this->dispatch('cart-updated');
        $this->dispatch('toast-notification', message: 'Product added to cart!', type: 'success');
    }

    public function render()
    {
        $product = Product::findOrFail($this->productId);
        $customer = $this->getCustomer();
        
        // Get subscription info for pricing
        $subscription = $customer ? $customer->activeSubscription()->first() : null;
        $discountPercent = $customer ? $customer->getSubscriptionDiscount() : 0;
        $originalPrice = (float) $product->price;
        $discountedPrice = $discountPercent > 0 
            ? round($originalPrice * (1 - $discountPercent / 100), 2) 
            : $originalPrice;

        // Check if customer can access limited edition products
        $canAccess = !$product->is_limited_edition || ($customer && $customer->canAccessLimitedEdition());

        // Get related products (same origin or roast level, excluding current product)
        $relatedProducts = Product::where('product_id', '!=', $this->productId)
            ->where('stock', '>', 0)
            ->where(function ($query) use ($product, $customer) {
                // Same origin or roast level
                if ($product->origin) {
                    $query->where('origin', $product->origin);
                }
                if ($product->roast_level) {
                    $query->orWhere('roast_level', $product->roast_level);
                }
            })
            ->limit(4)
            ->get();

        // If not enough related products, get any other products in stock
        if ($relatedProducts->count() < 4) {
            $additionalProducts = Product::where('product_id', '!=', $this->productId)
                ->where('stock', '>', 0)
                ->whereNotIn('product_id', $relatedProducts->pluck('product_id'))
                ->limit(4 - $relatedProducts->count())
                ->get();
            
            $relatedProducts = $relatedProducts->merge($additionalProducts);
        }

        // Apply subscription access filtering for related products
        if ($customer) {
            $relatedProducts = $relatedProducts->filter(function ($relatedProduct) use ($customer) {
                if ($relatedProduct->is_limited_edition) {
                    return $customer->canAccessLimitedEdition();
                }
                return true;
            });
        } else {
            $relatedProducts = $relatedProducts->where('is_limited_edition', false);
        }

        return view('livewire.customer.product-detail', [
            'product' => $product,
            'customer' => $customer,
            'subscription' => $subscription,
            'discountPercent' => $discountPercent,
            'originalPrice' => $originalPrice,
            'discountedPrice' => $discountedPrice,
            'canAccess' => $canAccess,
            'relatedProducts' => $relatedProducts->take(4),
        ]);
    }
}

<?php

namespace App\Livewire\Customer;

use App\Models\Cart as CartModel;
use App\Models\CartItem;
use Livewire\Component;

class Cart extends Component
{
    protected $listeners = ['cart-updated' => '$refresh'];

    public function getCustomer()
    {
        return auth()->user()->getOrCreateCustomer();
    }

    public function increaseQuantity($cartId, $productId)
    {
        $cartItem = CartItem::where('cart_id', $cartId)
            ->where('product_id', $productId)
            ->with('product')
            ->first();

        if (!$cartItem) {
            session()->flash('error', 'Cart item not found.');
            return;
        }

        if (!$cartItem->product) {
            session()->flash('error', 'Product no longer available.');
            $this->removeItem($cartId, $productId);
            return;
        }

        $newQuantity = $cartItem->quantity + 1;

        // Validate stock availability
        if ($newQuantity > $cartItem->product->stock) {
            session()->flash('error', 'Not enough stock available. Maximum: ' . $cartItem->product->stock);
            return;
        }

        // Prevent negative quantities
        if ($newQuantity < 1) {
            session()->flash('error', 'Quantity cannot be less than 1.');
            return;
        }

        // Use update() instead of save() for composite primary key
        CartItem::where('cart_id', $cartId)
            ->where('product_id', $productId)
            ->update(['quantity' => $newQuantity]);

        session()->flash('message', 'Quantity updated.');
    }

    public function decreaseQuantity($cartId, $productId)
    {
        $cartItem = CartItem::where('cart_id', $cartId)
            ->where('product_id', $productId)
            ->with('product')
            ->first();

        if (!$cartItem) {
            session()->flash('error', 'Cart item not found.');
            return;
        }

        if (!$cartItem->product) {
            session()->flash('error', 'Product no longer available.');
            $this->removeItem($cartId, $productId);
            return;
        }

        $newQuantity = $cartItem->quantity - 1;

        // If quantity becomes 0 or less, remove the item
        if ($newQuantity <= 0) {
            $this->removeItem($cartId, $productId);
            return;
        }

        // Prevent negative quantities
        if ($newQuantity < 1) {
            session()->flash('error', 'Quantity cannot be less than 1.');
            return;
        }

        // Use update() instead of save() for composite primary key
        CartItem::where('cart_id', $cartId)
            ->where('product_id', $productId)
            ->update(['quantity' => $newQuantity]);

        session()->flash('message', 'Quantity updated.');
    }

    public function updateQuantity($cartId, $productId, $quantity)
    {
        // Convert quantity to integer
        $quantity = (int) $quantity;

        // Prevent negative quantities
        if ($quantity < 0) {
            session()->flash('error', 'Quantity cannot be negative.');
            return;
        }

        if ($quantity == 0) {
            $this->removeItem($cartId, $productId);
            return;
        }

        $cartItem = CartItem::where('cart_id', $cartId)
            ->where('product_id', $productId)
            ->with('product')
            ->first();

        if (!$cartItem) {
            session()->flash('error', 'Cart item not found.');
            return;
        }

        if (!$cartItem->product) {
            session()->flash('error', 'Product no longer available.');
            $this->removeItem($cartId, $productId);
            return;
        }

        // Validate stock availability
        if ($quantity > $cartItem->product->stock) {
            session()->flash('error', 'Not enough stock available. Maximum: ' . $cartItem->product->stock);
            return;
        }

        // Use update() instead of save() for composite primary key
        CartItem::where('cart_id', $cartId)
            ->where('product_id', $productId)
            ->update(['quantity' => $quantity]);

        session()->flash('message', 'Quantity updated.');
    }

    public function removeItem($cartId, $productId)
    {
        $cartItem = CartItem::where('cart_id', $cartId)
            ->where('product_id', $productId)
            ->with('product')
            ->first();

        if ($cartItem) {
            $productName = $cartItem->product ? $cartItem->product->name : 'Item';
            // Use delete() on query builder for composite primary key
            CartItem::where('cart_id', $cartId)
                ->where('product_id', $productId)
                ->delete();
            session()->flash('message', $productName . ' removed from cart.');
        }
    }

    public function clearCart()
    {
        $customer = $this->getCustomer();
        
        if (!$customer) {
            session()->flash('error', 'Customer record not found.');
            return;
        }

        $cart = CartModel::where('customer_id', $customer->customer_id)->first();
        
        if ($cart) {
            CartItem::where('cart_id', $cart->cart_id)->delete();
            session()->flash('message', 'Cart cleared successfully.');
        }
    }

    public function render()
    {
        $customer = $this->getCustomer();
        
        if (!$customer) {
            abort(403, 'Customer record not found.');
        }

        // Get or create cart for customer (ensures one active cart per customer)
        $cart = CartModel::with('cartItems.product')
            ->where('customer_id', $customer->customer_id)
            ->first();

        // If no cart exists, create one
        if (!$cart) {
            $cart = CartModel::getOrCreateActiveCart($customer->customer_id);
            $cart->load('cartItems.product');
        }

        $cartItems = $cart ? $cart->cartItems : collect();
        
        // Clean up and filter out items with deleted products
        $validCartItems = collect();
        $removedItems = false;
        
        foreach ($cartItems as $item) {
            if ($item->product === null) {
                // Remove cart item with deleted product
                CartItem::where('cart_id', $item->cart_id)
                    ->where('product_id', $item->product_id)
                    ->delete();
                $removedItems = true;
            } else {
                $validCartItems->push($item);
            }
        }
        
        // Show message if items were removed
        if ($removedItems) {
            session()->flash('message', 'Some products are no longer available and have been removed from your cart.');
        }
        
        $cartItems = $validCartItems;
        
        // Calculate total dynamically
        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        // Calculate item count
        $itemCount = $cartItems->sum('quantity');

        return view('livewire.customer.cart', [
            'cart' => $cart,
            'cartItems' => $cartItems,
            'total' => $total,
            'itemCount' => $itemCount,
        ]);
    }
}

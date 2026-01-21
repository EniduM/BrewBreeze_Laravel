<?php

namespace App\Livewire\Customer;

use App\Models\Cart as CartModel;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Checkout extends Component
{
    public $paymentMethod = 'credit_card';
    public $cardNumber = '';
    public $cardExpiry = '';
    public $cardCvv = '';
    public $address = '';

    protected $rules = [
        'paymentMethod' => 'required|string|in:credit_card,debit_card,paypal,bank_transfer',
        'address' => 'required|string|min:10|max:500',
        'cardNumber' => 'required_if:paymentMethod,credit_card,debit_card|nullable|string|size:16',
        'cardExpiry' => 'required_if:paymentMethod,credit_card,debit_card|nullable|string',
        'cardCvv' => 'required_if:paymentMethod,credit_card,debit_card|nullable|string|size:3',
    ];

    protected $messages = [
        'paymentMethod.required' => 'Please select a payment method.',
        'paymentMethod.in' => 'Invalid payment method selected.',
        'address.required' => 'Please enter your delivery address.',
        'address.min' => 'Address must be at least 10 characters.',
        'address.max' => 'Address must not exceed 500 characters.',
        'cardNumber.required_if' => 'Card number is required.',
        'cardNumber.size' => 'Card number must be 16 digits.',
        'cardExpiry.required_if' => 'Card expiry is required.',
        'cardCvv.required_if' => 'CVV is required.',
        'cardCvv.size' => 'CVV must be 3 digits.',
    ];

    public function getCustomer()
    {
        return auth()->user()->getOrCreateCustomer();
    }

    public function mount()
    {
        $customer = $this->getCustomer();
        if ($customer && $customer->address) {
            $this->address = $customer->address;
        }

        // Check if cart is empty and redirect
        $cart = $this->getCart();
        if (!$cart || $cart->cartItems->isEmpty()) {
            session()->flash('error', 'Your cart is empty.');
            $this->redirect(route('customer.cart'), navigate: true);
        }
    }

    public function getCart()
    {
        $customer = $this->getCustomer();
        if (!$customer) {
            return null;
        }

        return CartModel::with('cartItems.product')
            ->where('customer_id', $customer->customer_id)
            ->first();
    }

    public function processCheckout()
    {
        $this->validate();

        $customer = $this->getCustomer();
        if (!$customer) {
            session()->flash('error', 'Unable to access customer account.');
            return;
        }

        $cart = $this->getCart();
        if (!$cart || $cart->cartItems->isEmpty()) {
            session()->flash('error', 'Your cart is empty.');
            return redirect()->route('customer.cart');
        }

        // Validate stock availability before checkout
        foreach ($cart->cartItems as $cartItem) {
            if ($cartItem->quantity > $cartItem->product->stock) {
                session()->flash('error', $cartItem->product->name . ' has insufficient stock. Available: ' . $cartItem->product->stock);
                return;
            }
        }

        // Use database transaction for safety
        DB::beginTransaction();
        try {
            // Calculate subtotal
            $subtotal = $cart->cartItems->sum(function ($item) {
                return $item->quantity * $item->product->price;
            });

            // Apply subscription discount if customer has active subscription
            $discountPercent = $customer->getSubscriptionDiscount();
            $discountAmount = round($subtotal * ($discountPercent / 100), 2);
            
            // Shipping cost (free for subscribers)
            $shippingCost = $customer->getsFreeShipping() ? 0 : 10.00;
            
            // Calculate final total
            $total = round($subtotal - $discountAmount + $shippingCost, 2);

            // Store discount and shipping info for order record
            $discountPercent = $customer->getSubscriptionDiscount();
            $discountAmount = round($subtotal * ($discountPercent / 100), 2);
            $freeShipping = $customer->getsFreeShipping();
            $shippingCost = $freeShipping ? 0 : 10.00;
            $finalTotal = round($subtotal - $discountAmount + $shippingCost, 2);

            // Create order
            $order = Order::create([
                'customer_id' => $customer->customer_id,
                'date' => now(),
                'total' => $finalTotal,
                'status' => 'pending',
                'address' => $this->address,
            ]);

            // Create order items from cart items
            foreach ($cart->cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->order_id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price, // Store price at time of order
                ]);

                // Update product stock
                $cartItem->product->decrement('stock', $cartItem->quantity);
            }

            // Create payment record
            Payment::create([
                'order_id' => $order->order_id,
                'amount' => $finalTotal,
                'method' => $this->paymentMethod,
                'date' => now(),
            ]);
            
            // Log subscription benefits applied
            if ($customer->hasActiveSubscription()) {
                \Log::channel('api')->info('Subscription benefits applied to order', [
                    'order_id' => $order->order_id,
                    'customer_id' => $customer->customer_id,
                    'subscription_tier' => $customer->getSubscriptionTier(),
                    'discount_percent' => $discountPercent,
                    'discount_amount' => $discountAmount,
                    'free_shipping' => $freeShipping,
                    'original_total' => $subtotal,
                    'final_total' => $finalTotal,
                ]);
            }

            // Update order status to paid
            $order->update(['status' => 'paid']);

            // Clear cart (delete cart items)
            $cart->cartItems()->delete();

            DB::commit();

            // Clear the form
            $this->reset(['address', 'cardNumber', 'cardExpiry', 'cardCvv']);
            
            // Dispatch toast notification
            $this->dispatch('toast-notification', message: '🎉 Thank You For Placing Your Order! Order #' . $order->order_id . ' is confirmed and on its way!', type: 'success');
            
            // Store success message and order ID in session for redirect
            session()->flash('order_success', $order->order_id);
            
            // Delay redirect to allow toast to show
            $this->dispatch('redirect-after-delay', url: route('customer.orders'));
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'An error occurred during checkout. Please try again.');
            \Log::error('Checkout error: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $cart = $this->getCart();
        $cartItems = $cart ? $cart->cartItems : collect();
        $customer = $this->getCustomer();
        
        // Calculate subtotal
        $subtotal = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        // Get subscription benefits
        $subscription = $customer ? $customer->activeSubscription()->first() : null;
        $discountPercent = $customer ? $customer->getSubscriptionDiscount() : 0;
        $discountAmount = $subtotal * ($discountPercent / 100);
        $freeShipping = $customer ? $customer->getsFreeShipping() : false;
        $shippingCost = $freeShipping ? 0 : 10.00;
        
        // Calculate total
        $total = $subtotal - $discountAmount + $shippingCost;

        return view('livewire.customer.checkout', [
            'cart' => $cart,
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'discountPercent' => $discountPercent,
            'discountAmount' => $discountAmount,
            'shippingCost' => $shippingCost,
            'freeShipping' => $freeShipping,
            'total' => $total,
            'subscription' => $subscription,
        ]);
    }
}

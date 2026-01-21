<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddToCartRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    /**
     * Add product to cart.
     */
    public function store(AddToCartRequest $request): JsonResponse
    {
        $user = $request->user();
        $customer = $user->getOrCreateCustomer();

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to access customer account.',
            ], 403);
        }

        $product = Product::findOrFail($request->product_id);

        // Check stock availability
        if ($product->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock available. Available: ' . $product->stock,
            ], 400);
        }

        // Get or create cart
        $cart = Cart::getOrCreateActiveCart($customer->customer_id);

        // Check if cart item already exists
        $cartItem = CartItem::where('cart_id', $cart->cart_id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            // Update existing cart item
            $newQuantity = $cartItem->quantity + $request->quantity;
            if ($newQuantity > $product->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock available. Available: ' . $product->stock,
                ], 400);
            }
            
            CartItem::where('cart_id', $cart->cart_id)
                ->where('product_id', $request->product_id)
                ->update(['quantity' => $newQuantity]);
        } else {
            // Create new cart item
            CartItem::insert([
                'cart_id' => $cart->cart_id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Reload cart with items
        $cart->load('cartItems.product');

        // Calculate subtotal
        $subtotal = $cart->cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        // Get subscription benefits
        $discountPercent = $customer->getSubscriptionDiscount();
        $discountAmount = round($subtotal * ($discountPercent / 100), 2);
        $freeShipping = $customer->getsFreeShipping();
        $shippingCost = $freeShipping ? 0 : 10.00;
        $total = round($subtotal - $discountAmount + $shippingCost, 2);

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully',
            'data' => [
                'cart' => [
                    'id' => $cart->cart_id,
                    'items' => $cart->cartItems->map(function ($item) use ($discountPercent) {
                        $originalPrice = $item->product->price;
                        $discountedPrice = $discountPercent > 0 
                            ? round($originalPrice * (1 - $discountPercent / 100), 2) 
                            : $originalPrice;
                        
                        return [
                            'product_id' => $item->product_id,
                            'product_name' => $item->product->name,
                            'quantity' => $item->quantity,
                            'original_price' => (float) $originalPrice,
                            'price' => (float) $discountedPrice,
                            'discount_percent' => $discountPercent,
                            'subtotal' => (float) round($item->quantity * $discountedPrice, 2),
                        ];
                    }),
                    'subtotal' => (float) $subtotal,
                    'discount_percent' => $discountPercent,
                    'discount_amount' => (float) $discountAmount,
                    'shipping_cost' => (float) $shippingCost,
                    'free_shipping' => $freeShipping,
                    'total' => (float) $total,
                    'subscription_benefits_applied' => $customer->hasActiveSubscription(),
                    'subscription_tier' => $customer->getSubscriptionTier(),
                ],
            ],
        ], 201);
    }
}

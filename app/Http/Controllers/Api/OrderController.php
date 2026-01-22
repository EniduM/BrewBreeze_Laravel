<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreateOrderRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    use AuthorizesRequests;

    /**
     * Create order from cart.
     */
    public function store(CreateOrderRequest $request): JsonResponse
    {
        $user = $request->user();
        $customer = $user->getOrCreateCustomer();

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to access customer account.',
            ], 403);
        }

        $cart = Cart::with('cartItems.product')
            ->where('customer_id', $customer->customer_id)
            ->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty.',
            ], 400);
        }

        // Validate stock availability
        foreach ($cart->cartItems as $cartItem) {
            if ($cartItem->quantity > $cartItem->product->stock) {
                return response()->json([
                    'success' => false,
                    'message' => $cartItem->product->name . ' has insufficient stock. Available: ' . $cartItem->product->stock,
                ], 400);
            }
        }

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
            $freeShipping = $customer->getsFreeShipping();
            $shippingCost = $freeShipping ? 0 : 10.00;
            
            // Calculate final total
            $total = round($subtotal - $discountAmount + $shippingCost, 2);

            // Create order
            $order = Order::create([
                'customer_id' => $customer->customer_id,
                'date' => now(),
                'total' => $total,
                'status' => 'pending',
                'address' => $request->address ?? null,
            ]);

            // Create order items
            foreach ($cart->cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->order_id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price,
                ]);

                // Update product stock
                $cartItem->product->decrement('stock', $cartItem->quantity);
            }

            // Process payment through payment service
            $paymentService = new PaymentService();
            try {
                $paymentResult = $paymentService->processPayment(
                    $request->payment_method,
                    $total,
                    [
                        'currency' => $request->currency ?? 'usd',
                        'address' => $request->address ?? null,
                    ]
                );

                // Create payment record
                $payment = Payment::create([
                    'order_id' => $order->order_id,
                    'amount' => $total,
                    'method' => $request->payment_method,
                    'date' => now(),
                ]);
                
                // Log subscription benefits applied
                if ($customer->hasActiveSubscription()) {
                    \Illuminate\Support\Facades\Log::channel('api')->info('API Subscription benefits applied to order', [
                        'order_id' => $order->order_id,
                        'customer_id' => $customer->customer_id,
                        'subscription_tier' => $customer->getSubscriptionTier(),
                        'discount_percent' => $discountPercent,
                        'discount_amount' => $discountAmount,
                        'free_shipping' => $freeShipping,
                        'original_total' => $subtotal,
                        'final_total' => $total,
                    ]);
                }

                // Update order status based on payment result
                $orderStatus = $paymentResult['status'] === 'succeeded' || $paymentResult['status'] === 'approved' 
                    ? 'paid' 
                    : 'pending';
                $order->update(['status' => $orderStatus]);

                Log::channel('api')->info('Order payment processed', [
                    'order_id' => $order->order_id,
                    'payment_id' => $paymentResult['payment_id'] ?? null,
                    'status' => $paymentResult['status'],
                    'method' => $request->payment_method,
                ]);
            } catch (\Exception $e) {
                // Log payment error but don't fail the order creation
                Log::channel('api')->error('Payment processing failed', [
                    'order_id' => $order->order_id,
                    'error' => $e->getMessage(),
                ]);

                // Create payment record with pending status
                $payment = Payment::create([
                    'order_id' => $order->order_id,
                    'amount' => $total,
                    'method' => $request->payment_method,
                    'date' => now(),
                ]);

                $order->update(['status' => 'pending']);
            }

            // Clear cart
            $cart->cartItems()->delete();

            DB::commit();

            $order->load('orderItems.product', 'payment');

            return response()->json([
                'success' => true,
                'message' => 'Order created successfully',
                'data' => [
                    'order' => [
                        'id' => $order->order_id,
                        'date' => $order->date->toDateString(),
                        'subtotal' => (float) $subtotal,
                        'discount_percent' => $discountPercent,
                        'discount_amount' => (float) $discountAmount,
                        'shipping_cost' => (float) $shippingCost,
                        'free_shipping' => $freeShipping,
                        'total' => (float) $order->total,
                        'status' => $order->status,
                        'subscription_benefits_applied' => $customer->hasActiveSubscription(),
                        'subscription_tier' => $customer->getSubscriptionTier(),
                        'items' => $order->orderItems->map(function ($item) {
                            return [
                                'product_id' => $item->product_id,
                                'product_name' => $item->product->name,
                                'quantity' => $item->quantity,
                                'price' => (float) $item->price,
                                'subtotal' => (float) ($item->quantity * $item->price),
                            ];
                        }),
                        'payment' => [
                            'method' => $payment->method,
                            'amount' => (float) $payment->amount,
                            'date' => $payment->date->toDateString(),
                        ],
                    ],
                ],
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the order.',
            ], 500);
        }
    }

    /**
     * Get paginated list of orders (admin or customer).
     */
    public function index(): JsonResponse
    {
        $user = request()->user();
        
        if ($user->isAdmin()) {
            $orders = Order::withDetails()->recent()->paginate(15);
        } else {
            $customer = $user->getOrCreateCustomer();
            $orders = Order::where('customer_id', $customer->customer_id)
                ->withDetails()
                ->recent()
                ->paginate(15);
        }

        return response()->json([
            'data' => $orders->items(),
            'meta' => [
                'total' => $orders->total(),
                'per_page' => $orders->perPage(),
                'current_page' => $orders->currentPage(),
            ],
        ]);
    }

    /**
     * Get a single order.
     */
    public function show(Order $order): JsonResponse
    {
        $this->authorize('view', $order);

        return response()->json([
            'data' => $order->load('orderItems.product'),
        ]);
    }
}

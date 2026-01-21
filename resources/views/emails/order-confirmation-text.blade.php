Thank You for Your Order!

Hello {{ $customer->name ?? 'Valued Customer' }},

Thank you for shopping with BrewBreeze! We're excited to prepare your order and get it to you as soon as possible.

ORDER DETAILS
-------------------
Order Number: #{{ $order->order_id }}
Order Date: {{ $order->date->format('F j, Y - g:i A') }}
Status: {{ ucfirst($order->status) }}

ORDER SUMMARY
-------------------
@foreach($orderItems as $item)
{{ $item->product->name }}
Quantity: {{ $item->quantity }} × ${{ number_format($item->price, 2) }} = ${{ number_format($item->quantity * $item->price, 2) }}

@endforeach

TOTALS
-------------------
Subtotal: ${{ number_format($subtotal, 2) }}
@if($discountAmount > 0)
Subscriber Discount ({{ $customer->getSubscriptionDiscount() }}%): -${{ number_format($discountAmount, 2) }}
@endif
Shipping: @if($shippingCost > 0)${{ number_format($shippingCost, 2) }}@else FREE @endif

Total: ${{ number_format($total, 2) }}

SHIPPING ADDRESS
-------------------
{{ $order->address }}

View your order status at: {{ route('customer.orders') }}

If you have any questions about your order, please don't hesitate to contact us.

-------------------
BrewBreeze Coffee
Your Premium Coffee Subscription Service

This is an automated email. Please do not reply to this message.

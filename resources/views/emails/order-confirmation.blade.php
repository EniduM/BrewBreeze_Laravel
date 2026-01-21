<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
            color: #ffffff;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        .header p {
            margin: 10px 0 0;
            font-size: 16px;
            opacity: 0.9;
        }
        .content {
            padding: 30px;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #8B4513;
        }
        .order-info {
            background-color: #FFF8DC;
            border-left: 4px solid #8B4513;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .order-info h3 {
            margin: 0 0 10px;
            color: #8B4513;
            font-size: 16px;
        }
        .order-info p {
            margin: 5px 0;
            font-size: 14px;
        }
        .order-items {
            margin: 20px 0;
        }
        .order-items h3 {
            color: #8B4513;
            border-bottom: 2px solid #D4A574;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .item {
            display: flex;
            justify-content: space-between;
            padding: 12px;
            border-bottom: 1px solid #eee;
        }
        .item:last-child {
            border-bottom: none;
        }
        .item-details {
            flex: 1;
        }
        .item-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 4px;
        }
        .item-quantity {
            color: #666;
            font-size: 14px;
        }
        .item-price {
            font-weight: 600;
            color: #8B4513;
            text-align: right;
        }
        .totals {
            background-color: #f9f9f9;
            padding: 20px;
            margin-top: 20px;
            border-radius: 4px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 15px;
        }
        .total-row.discount {
            color: #28a745;
        }
        .total-row.final {
            border-top: 2px solid #8B4513;
            margin-top: 10px;
            padding-top: 15px;
            font-size: 18px;
            font-weight: 700;
            color: #8B4513;
        }
        .shipping-address {
            background-color: #f9f9f9;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
            border: 1px solid #eee;
        }
        .shipping-address h4 {
            margin: 0 0 10px;
            color: #8B4513;
            font-size: 16px;
        }
        .button {
            display: inline-block;
            background-color: #8B4513;
            color: #ffffff;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 4px;
            margin: 20px 0;
            font-weight: 600;
        }
        .footer {
            background-color: #f9f9f9;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 14px;
            border-top: 1px solid #eee;
        }
        .footer p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 Thank You for Your Order!</h1>
            <p>Your coffee journey begins here</p>
        </div>
        
        <div class="content">
            <p class="greeting">Hello {{ $customer->name ?? 'Valued Customer' }},</p>
            
            <p>Thank you for shopping with BrewBreeze! We're excited to prepare your order and get it to you as soon as possible.</p>
            
            <div class="order-info">
                <h3>Order Details</h3>
                <p><strong>Order Number:</strong> #{{ $order->order_id }}</p>
                <p><strong>Order Date:</strong> {{ $order->date->format('F j, Y - g:i A') }}</p>
                <p><strong>Status:</strong> <span style="color: #28a745; font-weight: 600;">{{ ucfirst($order->status) }}</span></p>
            </div>
            
            <div class="order-items">
                <h3>Order Summary</h3>
                @foreach($orderItems as $item)
                    <div class="item">
                        <div class="item-details">
                            <div class="item-name">{{ $item->product->name }}</div>
                            <div class="item-quantity">Quantity: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}</div>
                        </div>
                        <div class="item-price">
                            ${{ number_format($item->quantity * $item->price, 2) }}
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="totals">
                <div class="total-row">
                    <span>Subtotal:</span>
                    <span>${{ number_format($subtotal, 2) }}</span>
                </div>
                
                @if($discountAmount > 0)
                    <div class="total-row discount">
                        <span>Subscriber Discount ({{ $customer->getSubscriptionDiscount() }}%):</span>
                        <span>-${{ number_format($discountAmount, 2) }}</span>
                    </div>
                @endif
                
                <div class="total-row">
                    <span>Shipping:</span>
                    <span>
                        @if($shippingCost > 0)
                            ${{ number_format($shippingCost, 2) }}
                        @else
                            <span style="color: #28a745; font-weight: 600;">FREE</span>
                        @endif
                    </span>
                </div>
                
                <div class="total-row final">
                    <span>Total:</span>
                    <span>${{ number_format($total, 2) }}</span>
                </div>
            </div>
            
            <div class="shipping-address">
                <h4>Shipping Address</h4>
                <p>{{ $order->address }}</p>
            </div>
            
            <center>
                <a href="{{ route('customer.orders') }}" class="button">View Order Status</a>
            </center>
            
            <p style="margin-top: 30px; color: #666;">
                If you have any questions about your order, please don't hesitate to contact us.
            </p>
        </div>
        
        <div class="footer">
            <p><strong>BrewBreeze Coffee</strong></p>
            <p>Your Premium Coffee Subscription Service</p>
            <p style="margin-top: 15px; font-size: 12px; color: #999;">
                This is an automated email. Please do not reply to this message.
            </p>
        </div>
    </div>
</body>
</html>

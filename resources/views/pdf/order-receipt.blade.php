<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order Receipt - #{{ $order->order_id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #3B2A2A;
            padding: 40px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #D4A574;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #3B2A2A;
            margin-bottom: 10px;
        }
        .subtitle {
            color: #666;
            font-size: 11px;
        }
        .order-info {
            background: #FEF7F0;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .order-info h2 {
            font-size: 18px;
            color: #3B2A2A;
            margin-bottom: 10px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            padding: 5px 0;
        }
        .label {
            color: #666;
            font-weight: 600;
        }
        .value {
            color: #3B2A2A;
            font-weight: bold;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #3B2A2A;
            margin: 25px 0 15px 0;
            padding-bottom: 8px;
            border-bottom: 2px solid #D4A574;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        thead {
            background: #3B2A2A;
            color: white;
        }
        th {
            padding: 12px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid #E5E5E5;
        }
        tbody tr:hover {
            background: #FEF7F0;
        }
        .text-right {
            text-align: right;
        }
        .total-section {
            margin-top: 30px;
            float: right;
            width: 300px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 15px;
            margin-bottom: 5px;
        }
        .total-row.grand {
            background: #D4A574;
            color: white;
            font-weight: bold;
            font-size: 16px;
            padding: 15px;
            border-radius: 5px;
            margin-top: 10px;
        }
        .address-box {
            background: #FEF7F0;
            padding: 15px;
            border-left: 4px solid #D4A574;
            margin-bottom: 20px;
        }
        .payment-box {
            background: #FEF7F0;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .payment-detail {
            margin-bottom: 10px;
            padding: 8px 0;
            border-bottom: 1px solid #D4A574;
        }
        .payment-detail:last-child {
            border-bottom: none;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
        }
        .status-paid {
            background: #10B981;
            color: white;
        }
        .status-pending {
            background: #F59E0B;
            color: white;
        }
        .status-cancelled {
            background: #EF4444;
            color: white;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            padding-top: 20px;
            border-top: 2px solid #D4A574;
            color: #666;
            font-size: 10px;
        }
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">☕ BrewBreeze</div>
        <div class="subtitle">Premium Coffee Delivered to Your Doorstep</div>
    </div>

    <div class="order-info">
        <h2>Order Receipt #{{ $order->order_id }}</h2>
        <div class="info-row">
            <span class="label">Order Date:</span>
            <span class="value">{{ $order->date->format('F d, Y') }}</span>
        </div>
        <div class="info-row">
            <span class="label">Order Status:</span>
            <span class="value">
                <span class="status-badge status-{{ $order->status }}">
                    {{ ucfirst($order->status) }}
                </span>
            </span>
        </div>
        <div class="info-row">
            <span class="label">Customer:</span>
            <span class="value">{{ $order->customer->name ?? $order->customer->first_name . ' ' . $order->customer->last_name }}</span>
        </div>
    </div>

    @if($order->address)
    <h3 class="section-title">Delivery Address</h3>
    <div class="address-box">
        {{ $order->address }}
    </div>
    @endif

    <h3 class="section-title">Order Items</h3>
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
            <tr>
                <td><strong>{{ $item->product->name }}</strong></td>
                <td>{{ $item->quantity }}×</td>
                <td>${{ number_format($item->price, 2) }}</td>
                <td class="text-right"><strong>${{ number_format($item->quantity * $item->price, 2) }}</strong></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if($order->payment)
    <h3 class="section-title">Payment Information</h3>
    <div class="payment-box">
        <div class="payment-detail">
            <span class="label">Payment Method:</span>
            <span class="value">{{ ucfirst(str_replace('_', ' ', $order->payment->method)) }}</span>
        </div>
        <div class="payment-detail">
            <span class="label">Payment Date:</span>
            <span class="value">{{ $order->payment->date->format('M d, Y') }}</span>
        </div>
        <div class="payment-detail">
            <span class="label">Amount Paid:</span>
            <span class="value">${{ number_format($order->payment->amount, 2) }}</span>
        </div>
    </div>
    @endif

    <div class="clearfix">
        <div class="total-section">
            <div class="total-row">
                <span>Subtotal:</span>
                <span>${{ number_format($order->total, 2) }}</span>
            </div>
            <div class="total-row">
                <span>Shipping:</span>
                <span>FREE</span>
            </div>
            <div class="total-row grand">
                <span>GRAND TOTAL:</span>
                <span>${{ number_format($order->total, 2) }}</span>
            </div>
        </div>
    </div>

    <div class="footer">
        <p><strong>Thank you for your order!</strong></p>
        <p>BrewBreeze - 123 Coffee St, Brew City, BC 12345</p>
        <p>Email: info@brewbreeze.com | Phone: (555) 123-4567</p>
    </div>
</body>
</html>

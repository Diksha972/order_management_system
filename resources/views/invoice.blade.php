<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        body { font-family: sans-serif; }
        .invoice-box {
            max-width: 600px;
            padding: 20px;
            border: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <h2>Invoice</h2>

        <p><strong>Order ID:</strong> {{ $order->id }}</p>
        <p><strong>User:</strong> {{ $user->name }} ({{ $user->email }})</p>
        <p><strong>Shipping Address:</strong> {{ $order->address }}</p>

        <hr>

        <p><strong>Product:</strong> {{ $product->name }}</p>
        <p><strong>Description:</strong> {{ $product->description }}</p>
        <p><strong>Quantity Ordered:</strong> {{ $order->quantity }}</p>
        <p><strong>Shipping Phone:</strong> {{ $order->phone }}</p>
        <p><strong>Unit Price:</strong> {{ number_format($product->price, 2) }}</p>
        <p><strong>Total Price:</strong> {{ number_format($order->total_price, 2) }}</p>

        <hr>

        <p><strong>Order Date:</strong> {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y, h:i A') }}</p>
        <p><strong>Delivery Date:</strong>
            {{ $order->delivered_date ? \Carbon\Carbon::parse($order->delivered_date)->format('d M Y, h:i A') : 'Pending' }}
        </p>
</body>
</html>

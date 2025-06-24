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
        <p><strong>Product:</strong> {{ $product->name }}</p>
        <p><strong>Description:</strong> {{ $product->description }}</p>
        <p><strong>Quantity:</strong> {{ $order->quantity }}</p>
        <p><strong>Total:</strong> ₹{{ $order->quantity * $product->price }}</p>
        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
        <p><strong>Order Date:</strong> {{ $order->created_at->format('d M Y, h:i A') }}</p>
    </div>
</body>
</html>

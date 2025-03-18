<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
</head>
<body>
    <h1>Order Confirmation</h1>
    <p>Thank you for your order!</p>
    <p>Order ID: {{ $order->id }}</p>
    <p>Total Amount: RM{{ number_format($order->total_amount, 2) }}</p>
    <p>Status: {{ ucfirst($order->status) }}</p>
</body>
</html>
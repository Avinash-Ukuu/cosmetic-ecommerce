<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
</head>
<body>
    <h1>Your Order has been Confirmed!</h1>
    <p>Dear {{ $order->customer->name }},</p>
    <p>Your order #{{ $order->order_number }} has been confirmed.</p>
    <p>Total Amount: AED  {{ number_format($order->total_amount, 2) }}</p>
    <p>Thank you for shopping with us!</p>
</body>
</html>

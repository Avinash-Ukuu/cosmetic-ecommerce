<!DOCTYPE html>
<html>
<head>
    <title>Payment Canceled</title>
</head>
<body>
    <h1>Order Payment Canceled</h1>
    <p>Dear {{ $order->customer->name }},</p>
    <p>We regret to inform you that the payment for your order #{{ $order->order_number }} was canceled.</p>
    <p>Please contact support if you have any questions.</p>
</body>
</html>

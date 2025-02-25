<!DOCTYPE html>
<html>
<head>
    <title>Order Status Updated</title>
</head>
<body>
    <h1>Hello, {{ $orderData['customer_name'] }}</h1>
    <p>Your order <strong>#{{ $orderData['order_number'] }}</strong> has been updated.</p>
    <p><strong>Product:</strong> {{ $orderData['product_name'] }}</p>
    <p><strong>Quantity:</strong> {{ $orderData['quantity'] }}</p>
    <p><strong>Status:</strong> {{ $orderData['status'] }}</p>
    <p>Thank you for shopping with us!</p>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link rel="stylesheet" href="{{ asset('assets/skydash/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 80%; margin: auto; padding: 20px; }
        .header { text-align: right; font-size: 22px; font-weight: bold; color: #666; }
        .invoice-title { font-size: 24px; font-weight: bold; }
        .company-details, .customer-details { margin-top: 20px; }
        .details-table { width: 100%; margin-top: 20px; border-collapse: collapse; }
        .details-table th, .details-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .total-table { width: 100%; margin-top: 10px; }
        .total-table td { padding: 5px; text-align: right; }
        .discount-text { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Glamify</div>
        <div class="invoice-title">Invoice</div>
        <p><strong>Invoice Number:</strong> {{ $order->order_number }}</p>
        <p><strong>Date of Issue:</strong> {{ $order->created_at->format('M d, Y') }}</p>

        <div class="row">
            <div class="company-details">
                <strong>Glamify</strong><br>
                Alnawahy-st<br>
                33<br>
                United Arab Emirates<br>
                +971 56 169 4415
            </div>

            <div class="customer-details">
                <strong>Bill to:</strong><br>
                Name: <b>{{ $order->address->full_name ?? 'N/A' }}</b><br>
                Email: <b>{{ $order->address->email ?? 'N/A' }} </b><br>
                Mobile Number: <b>{{ $order->address->mobile_number ?? 'N/A' }} </b><br>
                Building Name: <b>{{ $order->address->building_name ?? 'N/A' }} </b><br>
                Street Address:<b>{{ $order->address->street_address ?? 'N/A' }} </b><br>
                Area: <b>{{ $order->address->area ?? 'N/A' }} </b><br>
                Emirate: <b>{{ $order->address->emirate ?? 'N/A' }} </b><br>
                PO Box: <b>{{ $order->address->po_box ?? 'N/A' }} </b><br>
                Landmark: <b>{{ $order->address->landmark ?? 'N/A' }} </b><br>
                Delivery Instructions: <b>{{ $order->address->delivery_instructions ?? 'N/A' }} </b><br>
            </div>

            <h3>AED{{ number_format($order->total_amount, 2) }} due {{ $order->created_at->addDays(7)->format('M d, Y') }}</h3>
        </div>

        <table class="details-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Qty</th>
                    <th>Unit Price</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>AED{{ number_format($item->price, 2) }}</td>
                        <td>AED{{ number_format($item->quantity * $item->price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <table class="total-table">
            @php
                $subtotal = $order->total_amount + ($order->discount_amount ?? 0);
            @endphp
            <tr>
                <td>Subtotal:</td>
                <td>AED{{ number_format($subtotal, 2) }}</td>
            </tr>

            @if($order->coupon)
                <tr class="discount-text">
                    <td>Coupon Discount ({{ $order->coupon->code }}):</td>
                    <td>- AED{{ number_format($order->discount_amount, 2) }}</td>
                </tr>
            @endif

            <tr>
                <td><strong>Total:</strong></td>
                <td><strong>AED{{ number_format($order->total_amount, 2) }}</strong></td>
            </tr>
            <tr>
                <td><strong>Amount Due:</strong></td>
                <td><strong>AED{{ number_format($order->total_amount, 2) }}</strong></td>
            </tr>
        </table>

        <p>EXAMPLE-{{ $order->order_number }} - AED{{ number_format($order->total_amount, 2) }} due {{ $order->created_at->addDays(7)->format('M d, Y') }}</p>
    </div>
</body>
</html>

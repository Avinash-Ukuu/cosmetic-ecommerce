@extends('cms.layouts.master')
@section('headerLinks')
    <style>
        #salesChart {
    max-height: 300px !important; /* Set a fixed height */
    width: 100% !important;
}
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h3 class="font-weight-bold">Welcome {{ auth()->user()->name }}</h3>
                    <h6 class="font-weight-normal mb-0">here's what's happening with your store today</h6>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-4 mb-4 stretch-card transparent">
            <div class="card card-inverse-primary">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <p class="mb-4">Total Orders</p>
                            <p class="fs-30 mb-2">{{ $totalOrders }}</p>
                        </div>
                        <div class="col-6 text-right">
                            <i class="fa fa-cart-plus menu-icon fa-5x"></i>
                        </div>
                    </div>
                    <div class="row d-flex flex-column align-items-center">
                        <a href="{{ route('order.index') }}" style="text-decoration:none" class="text-black">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4 stretch-card transparent">
            <div class="card card-inverse-success">
                <div class="card-body row">
                    <div class="col-6">
                        <p class="mb-4">Total Revenue</p>
                        <p class="fs-30 mb-2">AED {{ number_format($totalRevenue, 2) }}</p>
                    </div>
                    <div class="col-6 text-right">
                        <i class="fa fa-money menu-icon fa-5x"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4 stretch-card transparent">
            <div class="card card-inverse-info">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <p class="mb-4">Total Customers</p>
                            <p class="fs-30 mb-2">{{ $totalCustomers }}</p>
                        </div>
                        <div class="col-6 text-right">
                            <i class="fa fa-users menu-icon fa-5x"></i>
                        </div>
                    </div>
                    <div class="row d-flex flex-column align-items-center">
                        <a href="{{ route('customer.index') }}" style="text-decoration:none" class="text-black">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Pending Orders -->
        <div class="col-md-4 mb-4 stretch-card transparent">
            <div class="card card-inverse-warning">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <p class="mb-4">Pending Orders</p>
                            <p class="fs-30 mb-2">{{ $pendingOrders }}</p>
                        </div>
                        <div class="col-6 text-right">
                            <i class="fa fa-cart-plus menu-icon fa-5x"></i>
                        </div>
                    </div>
                    <div class="row d-flex flex-column align-items-center">
                        <a href="{{ route('order.index') }}" style="text-decoration:none" class="text-black">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Products -->

        <div class="col-md-4 mb-4 stretch-card transparent">
            <div class="card card-inverse-info">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <p class="mb-4">Total Products</p>
                            <p class="fs-30 mb-2">{{ $totalProducts }}</p>
                        </div>
                        <div class="col-6 text-right">
                            <i class="fa fa-cubes menu-icon fa-5x"></i>
                        </div>
                    </div>
                    <div class="row d-flex flex-column align-items-center">
                        <a href="{{ route('product.index') }}" style="text-decoration:none" class="text-black">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4 stretch-card transparent">
            <div class="card @if($activeCoupons == 0) card-inverse-danger @else card-inverse-success @endif">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <p class="mb-4">Active Coupons</p>
                            <p class="fs-30 mb-2">{{ $activeCoupons }}</p>
                        </div>
                        <div class="col-6 text-right">
                            <i class="fa fa-book menu-icon fa-5x"></i>
                        </div>
                    </div>
                    <div class="row d-flex flex-column align-items-center">
                        <a href="{{ route('coupon.index') }}" style="text-decoration:none" class="text-black">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales Chart -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Monthly Sales</h4>
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Recent Orders</h4>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentOrders as $order)
                                <tr>
                                    <td>{{ $order->order_number }}</td>
                                    <td>{{ $order->customer->name ?? 'N/A' }}</td>
                                    <td>AED {{ number_format($order->total_amount, 2) }}</td>
                                    <td><label
                                            class="badge badge-{{ $order->status == 'completed' ? 'success' : 'warning' }}">{{ ucfirst($order->status) }}</label>
                                    </td>
                                    <td>{{ $order->order_created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footerScripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var ctx = document.getElementById("salesChart").getContext("2d");

        var salesData = @json(array_values($salesData));

        var salesChart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Monthly Sales (AED)",
                    data: salesData,
                    backgroundColor: "rgba(54, 162, 235, 0.6)",
                    borderColor: "rgba(54, 162, 235, 1)",
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Ensure it doesn't stretch
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endsection

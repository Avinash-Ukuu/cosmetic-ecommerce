@extends('cms.layouts.master')
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
        <!-- Summary Cards -->
        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h4>Total Orders</h4>
                    <h2>{{ $totalOrders }}</h2>
                    <i class="mdi mdi-cart-outline icon-lg float-right"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h4>Total Revenue</h4>
                    <h2>₹{{ number_format($totalRevenue, 2) }}</h2>
                    <i class="mdi mdi-cash-multiple icon-lg float-right"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h4>Total Customers</h4>
                    <h2>{{ $totalCustomers }}</h2>
                    <i class="mdi mdi-account-group icon-lg float-right"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Pending Orders -->
        <div class="col-md-6 stretch-card grid-margin">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h4>Pending Orders</h4>
                    <h2>{{ $pendingOrders }}</h2>
                    <i class="mdi mdi-timer-sand icon-lg float-right"></i>
                </div>
            </div>
        </div>
        <!-- Total Products -->
        <div class="col-md-6 stretch-card grid-margin">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h4>Total Products</h4>
                    <h2>{{ $totalProducts }}</h2>
                    <i class="mdi mdi-package-variant-closed icon-lg float-right"></i>
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
                                    <td>{{ $order->user->name }}</td>
                                    <td>₹{{ number_format($order->total_amount, 2) }}</td>
                                    <td><label
                                            class="badge badge-{{ $order->status == 'delivered' ? 'success' : 'warning' }}">{{ ucfirst($order->status) }}</label>
                                    </td>
                                    <td>{{ $order->order_created_at->format('d M, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

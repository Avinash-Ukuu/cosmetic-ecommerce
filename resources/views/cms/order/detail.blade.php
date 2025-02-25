@extends('cms.layouts.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-12 col-xl-12 text-right">
                    <div class="justify-content-end d-flex">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-custom">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('order.index') }}">Order List</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><span>Order Detail</span></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card px-2">
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row my-5">
                        <h3 class="col-6 text-left">Order Detail</h3>
                        <h3 class="col-6 text-right">Invoice&nbsp;&nbsp;{{ $order->order_number }}</h3>
                    </div>
                    <hr>
                </div>
                <div class="container-fluid d-flex justify-content-between">
                    <div class="col-lg-3 ps-0">
                        <p class="mt-5 mb-2"><b>Customer Detail</b></p>
                        <p>{{ $order->customer->name ?? 'N/A' }},<br>{{ $order->customer->email ?? 'N/A' }},<br>{{ $order->customer->customer->phone_number ?? 'N/A' }}.</p>
                    </div>
                    <div class="col-lg-3 pr-0">
                        <p class="mt-5 mb-2"><b>Shipping Address</b></p>
                        <p>
                            {{ $order->address->full_name ?? 'N/A'}}<br> {{ $order->address->mobile_number ?? 'N/A'}}<br>
                            {{ $order->address->email ?? 'N/A'}}, {{ $order->address->building_name ?? 'N/A'}}, {{ $order->address->street_address ?? 'N/A' }},
                            {{ $order->address->area ?? 'N/A' }}, {{ $order->address->emirate ?? 'N/A' }}, {{ $order->address->po_box ?? 'N/A' }}, {{ $order->address->landmark ?? 'N/A' }},
                            {{ $order->address->delivery_instructions ?? 'N/A' }}.</p>
                    </div>
                    {{-- <div class="col-lg-3 pr-0">
                        <p class="mt-5 mb-2 "><b>Payment Detail</b></p>
                        <p>
                            Payment Method : <b>{{ strtoupper($order->payment->payment_method) }}</b><br>
                            Payment Reference : <b>{{ strtoupper($order->payment->payment_reference) }}</b>,<br>
                            Payment Status : <label class="badge badge-outline-success">{{ strtoupper($order->payment->payment_status) }}</label></p>
                    </div> --}}
                </div>
                <div class="container-fluid d-flex justify-content-between">
                    <div class="col-lg-3 ps-0">
                        <p class="mb-0 mt-5">Order Date : {{ $order->order_created_at }}</p>
                    </div>
                </div>
                <div class="container-fluid mt-5 d-flex justify-content-center w-100">
                    <div class="table-responsive w-100">
                        <table class="table">
                            <thead>
                                <tr class="bg-dark text-white">
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $orderItem)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $orderItem->product->name ?? 'N/A'}}</td>
                                        <td>{{ $orderItem->price }}</td>
                                        <td>{{ $orderItem->quantity }}</td>
                                        <td>{{ $orderItem->quantity * $orderItem->price }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="container-fluid mt-5 w-100">
                    {{-- <p class="text-right mb-2">Sub - Total amount: $12,348</p>  --}}
                    {{-- <p class="text-right">vat (10%) : $138</p> --}}
                    <h4 class="text-right mb-5">Total : {{ $order->total_amount }}</h4>
                    @if($order->status == 'completed')
                        <h4 class="text-right mb-5">Order Status : <label class="badge badge-outline-success">Order Delivered</label></h4>
                    @endif
                    <hr>
                </div>
                {{-- <div class="container-fluid w-100">
                    <a href="#" class="btn btn-primary float-right mt-4 ms-2"><i class="ti-printer me-1"></i>Print</a>
                    <a href="#" class="btn btn-success float-right mt-4"><i class="ti-export me-1"></i>Send
                        Invoice</a>
                </div> --}}
            </div>
        </div>
    </div>
@endsection

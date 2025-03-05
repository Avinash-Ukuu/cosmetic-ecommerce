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
                        <h3 class="col-6 text-right">Invoice&nbsp;&nbsp;{{ $object->order_number }}</h3>
                    </div>
                    <hr>
                </div>
                <div class="container-fluid d-flex justify-content-between">
                    <div class="col-lg-3 ps-0">
                        <p class="mt-5 mb-2"><b>Customer Detail</b></p>
                        <p>{{ $object->customer->name ?? 'N/A' }},<br>{{ $object->customer->email ?? 'N/A'}},<br>{{ $object->customer->customer->phone_number ?? 'N/A'}}.</p>
                    </div>
                    <div class="col-lg-3 pr-0">
                        <p class="mt-5 mb-2"><b>Shipping Address</b></p>
                        <p>
                            {{ $object->country->name ?? 'N/A'}},
                            {{ $object->city->name ?? 'N/A'}},
                            {{ $object->shippingOption->name ?? 'N/A'}}<br>
                            {{ $object->address->full_name ?? 'N/A'}}<br> {{ $object->address->mobile_number ?? 'N/A'}}<br>
                            {{ $object->address->email ?? 'N/A'}}, {{ $object->address->building_name ?? 'N/A'}}, {{ $object->address->street_address ?? 'N/A' }},
                            {{ $object->address->area ?? 'N/A' }}, {{ $object->address->emirate ?? 'N/A' }}, {{ $object->address->po_box ?? 'N/A' }}, {{ $object->address->landmark ?? 'N/A' }},
                            {{ $object->address->delivery_instructions ?? 'N/A' }}.</p>
                    </div>
                    {{-- <div class="col-lg-3 pr-0">
                        <p class="mt-5 mb-2 "><b>Payment Detail</b></p>
                        <p>
                            Payment Method : <b>{{ strtoupper($object->payment->payment_method) }}</b><br>
                            Payment Reference : <b>{{ strtoupper($object->payment->payment_reference) }}</b>,<br>
                            Payment Status : <label class="badge badge-outline-success">{{ strtoupper($object->payment->payment_status) }}</label></p>
                    </div> --}}
                </div>
                <div class="container-fluid d-flex justify-content-between">
                    <div class="col-lg-3 ps-0">
                        <p class="mb-0 mt-5">Order Date : {{ $object->order_created_at }}</p>
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
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($object->orderItems as $orderItem)
                                    {!! Form::open(['url' => route('updateOrderItemStatus',['id'=>$orderItem->id]), 'method' => 'POST']) !!}
                                        <input type="hidden" value="{{$orderItem->product_id}}" name="product_id">
                                        <input type="hidden" value="{{$orderItem->quantity}}" name="quantity">
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $orderItem->product->name ?? 'N/A'}}</td>
                                            <td>{{ $orderItem->price }}</td>
                                            <td>{{ $orderItem->quantity }}</td>
                                            @if($orderItem->status == 'delivered')
                                                <td><label class="badge badge-outline-success">{{ ucfirst($orderItem->status) }}</label></td>
                                                <td><label class="badge badge-outline-success">Order Delivered</label></td>
                                            @else
                                                <td>{!! Form::select("status",$status,$orderItem->status,['class' => 'form-control  ']) !!}</td>
                                                <td>{!! Form::submit('Update Status', ['class' => 'btn btn-primary']) !!}</td>
                                            @endif
                                        </tr>
                                    {!! Form::close() !!}
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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

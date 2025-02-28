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
                              <li class="breadcrumb-item active" aria-current="page"><span>Top Selling Product List</span></li>
                            </ol>
                          </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Top Selling Products</h4>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Product Name</th>
                                    <th>Total Sold</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topProducts as $key => $product)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <img src="{{ $product->product_image ? asset('uploads/products/'.$product->id.'/'.$product->product_image) : asset('uploads/products/default-product.jpg') }}"
                                             class="img-fluid rounded"
                                             alt="{{ $product->name }}"
                                             style="width: 50px; height: 50px; object-fit: cover;">
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->total_sold }}</td>
                                    <td>AED {{ number_format($product->sale_price, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


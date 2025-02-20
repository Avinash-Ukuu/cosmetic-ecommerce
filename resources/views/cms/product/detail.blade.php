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
                              <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Product List</a></li>
                              <li class="breadcrumb-item active" aria-current="page"><span>Product Detail</span></li>
                            </ol>
                          </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-10">
                        <h4 class="card-title">Product Detail</h4>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <div class="tbody">
                            <tr>
                                <td>Product</td>
                                <td>{{ $product->name }}</td>
                            </tr>
                            <tr>
                                <td>Category</td>
                                <td>{{ $product->category->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td>Brand</td>
                                <td>{{ $product->brand->name ?? 'N/A'}}</td>
                            </tr>
                            <tr>
                                <td>Weight</td>
                                <td>{{ $product->weight }}</td>
                            </tr>
                            {{-- <tr>
                                <td>Unit</td>
                                <td>{{ $product->unit }}</td>
                            </tr> --}}
                            <tr>
                                <td>Quantity</td>
                                <td>{{ $product->quantity }}</td>
                            </tr>
                            <tr>
                                <td>Price Without Tax</td>
                                <td>{{ $product->price_without_tax }}</td>
                            </tr>
                            <tr>
                                <td>Tax</td>
                                <td>{{ $product->tax }} %</td>
                            </tr>
                            <tr>
                                <td>Sale Price</td>
                                <td>{{ $product->sale_price }}</td>
                            </tr>
                            <tr>
                                <td>MRP Price</td>
                                <td>{{ $product->mrp_price ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td>Description</td>
                                <td style="white-space: break-spaces;">{!! $product->description !!}</td>
                            </tr>
                        </div>
                    </table>
                </div>

                @if($product->productImages->isNotEmpty())
                    <div class="row">
                        <h5 class="ml-3 mt-3">Product Images</h5>
                        <div class="container mt-5">
                            <div id="productCarousel" class="carousel slide" data-ride="carousel">
                                <!-- Indicators (optional) -->
                                <ol class="carousel-indicators">
                                    @foreach($product->productImages as $key => $image)
                                        <li data-target="#productCarousel" data-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}"></li>
                                    @endforeach
                                </ol>

                                <!-- Carousel items -->
                                <div class="carousel-inner">
                                    @foreach($product->productImages as $key => $image)
                                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                            <img src="{{ asset('uploads/products/'.$image->product_id.'/'.$image->url) }}" class="d-block h-100" alt="image">
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Controls -->
                                <a class="carousel-control-prev" href="#productCarousel" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only text-black">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#productCarousel" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only text-black">Next</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('footerScripts')
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script>

    </script>
@endsection


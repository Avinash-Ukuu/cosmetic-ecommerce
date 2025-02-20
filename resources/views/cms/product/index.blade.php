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
                              <li class="breadcrumb-item active" aria-current="page"><span>Product List</span></li>
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
                        <h4 class="card-title">Product Table</h4>
                    </div>
                    <div class="col-2 text-right">
                        <a href="{{ route('product.create') }}"><label class="badge badge-outline-primary"><i class="mdi mdi-account-plus"></i> Add</label></a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped" id="example1">
                        <thead>
                            <tr>
                                <th>
                                    Product
                                </th>
                                <th>
                                    Category
                                </th>
                                <th>
                                    Brand
                                </th>
                                <th>
                                    Sale Price
                                </th>
                                <th>
                                    MRP Price
                                </th>
                                <th>
                                    Weight
                                </th>
                                <th>
                                    Quantity
                                </th>
                                <th>
                                    Publish Type
                                </th>
                                <th>
                                    Info
                                </th>
                                <th>
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footerScripts')
    <script>
        $(document).ready(function() {
            $('#example1').DataTable({
                "responsive": true,
                "processing": true,
                "serverSide": true,
                ajax: "{{ route('product.index') }}",
                order: [],
                sorting: true,
                columns: [
                    {
                        data: 'product',
                        name: 'product',
                        orderable: false,
                    },
                    {
                        data: 'category',
                        name: 'category',
                    },
                    {
                        data: 'brand',
                        name: 'brand',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'sale_price',
                        name: 'sale_price',
                    },
                    {
                        data: 'mrp_price',
                        name: 'mrp_price',
                    },
                    {
                        data: 'weight',
                        name: 'weight',
                    },
                    {
                        data: 'quantity',
                        name: 'quantity',
                    },
                    {
                        data: 'publish_type',
                        name: 'publish_type',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'info',
                        name: 'info',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });

        function isPublishAction(id, checkbox) {
            let status = checkbox.checked ? 'publish' : 'unpublish';

            $.ajax({
                url: "{{ route('isPublishAction') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: id,
                    publish_type: status,
                    table: 'products',
                    module: 'product',
                },
                success: function(response) {
                    if (status == 'publish') {
                        message = "Product is publish";
                    }else{
                        message = "Product is not publish";
                    }
                    toastr.success(message);
                    location.reload();
                },
                error: function(xhr) {
                    alert('An error occurred.');
                }
            });
        }
    </script>
@endsection


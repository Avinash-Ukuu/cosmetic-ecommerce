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
                              <li class="breadcrumb-item active" aria-current="page"><span>Order List</span></li>
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
                        <h4 class="card-title">Order Table</h4>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped" id="example1">
                        <thead>
                            <tr>
                                <th>
                                    Order Number
                                </th>
                                <th>
                                    Date
                                </th>
                                <th>
                                    Status
                                </th>
                                @if(auth()->user()->hasRole('admin'))
                                    <th>
                                        Grand Total
                                    </th>
                                @endif
                                <th>
                                    Payment Status
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
                ajax: "{{ route('order.index') }}",
                order: [],
                sorting: true,
                columns: [
                    {
                        data: 'order_number',
                        name: 'order_number',
                    },
                    {
                        data: 'order_created_at',
                        name: 'order_created_at',
                    },
                    {
                        data: 'status',
                        name: 'status',
                    },
                    @if(auth()->user()->hasRole('admin'))
                    {
                        data: 'total_amount',
                        name: 'total_amount',
                    },
                    @endif
                    {
                        data: 'payment_status',
                        name: 'payment_status',
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

    </script>
@endsection


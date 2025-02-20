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
                              <li class="breadcrumb-item active" aria-current="page"><span>Vendor List</span></li>
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
                        <h4 class="card-title">Vendor Table</h4>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped" id="example1">
                        <thead>
                            <tr>
                                <th>
                                    Vendor
                                </th>
                                <th>
                                    Name
                                </th>
                                <th>
                                    Email
                                </th>
                                <th>
                                    Phone Number
                                </th>
                                <th>
                                    Store Name
                                </th>
                                <th>
                                    Vendor Type
                                </th>
                                <th>
                                    Status
                                </th>
                                <th>
                                    About
                                </th>
                                @if(isset(auth()->user()->super_admin))
                                    <th>
                                        Action
                                    </th>
                                @endif
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
                ajax: "{{ route('vendor.index') }}",
                order: [],
                sorting: true,
                columns: [
                    {
                        data: 'vendor',
                        name: 'vendor',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'email',
                        name: 'email',
                    },
                    {
                        data: 'phone_number',
                        name: 'phone_number',
                    },
                    {
                        data: 'store_name',
                        name: 'store_name',
                        orderable: false,
                    },
                    {
                        data: 'vendor_type',
                        name: 'vendor_type',
                        orderable: false,
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false
                    },
                    {
                        data: 'about',
                        name: 'about',
                        orderable: false,
                        searchable: false
                    },
                    @if(isset(auth()->user()->super_admin))
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    @endif

                ]
            });
        });
    </script>
@endsection


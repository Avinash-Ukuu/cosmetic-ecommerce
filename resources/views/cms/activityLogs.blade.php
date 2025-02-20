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
                                <li class="breadcrumb-item active" aria-current="page"><span>Activity Logs</span></li>
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
                        <h4 class="card-title">Activity Logs</h4>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="example1" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Module</th>
                                <th>Action</th>
                                <th>ActionBy</th>
                                <th>Message</th>
                                <th>Time</th>
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
                ajax: "{{ route('activityLogs') }}",
                order: [
                    [5, "desc"]
                ],
                sorting: true,
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'Index',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'Module',
                        name: 'Module',
                    },
                    {
                        data: 'Action',
                        name: 'Action',
                    },
                    {
                        data: 'Responsible',
                        name: 'Responsible',
                    },
                    {
                        data: 'Message',
                        name: 'Message',
                    },
                    {
                        data: 'Time',
                        name: 'Time',
                    },
                ]
            });
        });
    </script>
@endsection

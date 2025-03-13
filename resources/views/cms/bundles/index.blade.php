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
                              <li class="breadcrumb-item active" aria-current="page"><span>Product Bundle List</span></li>
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
                        <h4 class="card-title">Product Bundle Table</h4>
                    </div>
                    <div class="col-2 text-right">
                            <a href="{{ route('bundle.create') }}"><label class="badge badge-outline-primary"><i class="mdi mdi-account-plus"></i> Add</label></a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>
                                    Id
                                </th>
                                <th>
                                    Name
                                </th>
                                <th>
                                    Publish Type
                                </th>
                                <th>
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bundles as $bundle)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $bundle->name }}</td>
                                    <td>
                                        @if($bundle->publish_type == 'publish')
                                            <label class="badge badge-outline-success">Publish</label>
                                        @else
                                            <label class="badge badge-outline-danger">Un Publish</label>
                                        @endif
                                    </td>
                                    <td><a href="{{ route('bundle.edit',['bundle'=>$bundle->id]) }}"><i class="fa fa-edit"></i></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

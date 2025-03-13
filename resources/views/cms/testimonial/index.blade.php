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
                              <li class="breadcrumb-item active" aria-current="page"><span>Testimonial List</span></li>
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
                        <h4 class="card-title">Testimonial Table</h4>
                    </div>
                    <div class="col-2 text-right">
                            <a href="{{ route('testimonial.create') }}"><label class="badge badge-outline-primary"><i class="mdi mdi-account-plus"></i> Add</label></a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    Name
                                </th>
                                <th>
                                    Image
                                </th>
                                <th>
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($testimonials as $testimonial)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $testimonial->name }}</td>
                                    <td><img src="{{ asset('uploads/testimonial/'.$testimonial->image.'/') }}" alt="image"></td>
                                    <td>
                                        <div class="row">
                                            <a href="{{ route('testimonial.edit', ['testimonial' => $testimonial->id]) }}"><i
                                                    class="fa fa-edit"></i></a>
                                            <form
                                                action="{{ route('testimonial.destroy', ['testimonial' => $testimonial->id]) }}"
                                                method="post">
                                                @csrf
                                                @method('Delete')
                                                <button type="button" onclick="confirmBox(this)"
                                                    style="border: 0px;background-color:transparent;"><i
                                                        class="fa fa-trash text-danger"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

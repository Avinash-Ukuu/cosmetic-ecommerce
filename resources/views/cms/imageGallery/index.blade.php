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
                              <li class="breadcrumb-item active" aria-current="page"><span>Image Gallery List</span></li>
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
                        <h4 class="card-title">Image Gallery Table</h4>
                    </div>
                    <div class="col-2 text-right">
                            <a href="{{ route('image-gallery.create') }}"><label class="badge badge-outline-primary"><i class="mdi mdi-account-plus"></i> Add</label></a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
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
                            @foreach($imageGalleries as $imageGallery)
                                <tr>
                                    <td>{{ $imageGallery->name }}</td>
                                    <td><img src="{{ asset('uploads/imageGallery/'.$imageGallery->image.'/') }}" alt="image"></td>
                                    <td>
                                        <div class="row">
                                            <a href="{{ route('image-gallery.edit', ['image_gallery' => $imageGallery->id]) }}"><i
                                                    class="fa fa-edit"></i></a>
                                            <form
                                                action="{{ route('image-gallery.destroy', ['image_gallery' => $imageGallery->id]) }}"
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

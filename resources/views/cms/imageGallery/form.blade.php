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
                                <li class="breadcrumb-item"><a href="{{ route('image-gallery.index') }}">Image Gallery</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><span>Image Gallery Form</span></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <h4 class="card-title">Image Gallery form</h4>
                    </div>
            </div>

                {!! Form::model($object, [
                    'url' => $url,
                    'method' => $method,
                    'onSubmit' => "document.getElementById('submit').disabled=true;",
                    'files' => true,
                    'class' => 'forms-sample',
                ]) !!}
                <input type="hidden" name="id" value="{{ $object->id }}">

                <div class="form-group">
                    {!! Form::label('name', 'Name') !!}<span style="color: red;"> *</span>
                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter Name', 'required']) !!}
                </div>

                <div class="form-group" id="image">
                    {{ Form::label('image', 'Image') }}
                    {{ Form::file('image', ['class' => 'file-upload-default','id'=>'bannerImage', 'accept' => 'image/jpg, image/jpeg, image/png']) }}
                    <div class="input-group col-xs-12 d-flex align-items-center">
                        <input type="text" class="form-control file-upload-info" disabled=""
                            placeholder="Upload Image">
                        <span class="input-group-append ms-2">
                            <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                    </div>
                    <div class="row">
                        <div class="file-preview mb-2 mt-2 mr-2 ml-2" id="banner_preview"></div>
                        <div class="image-preview mt-2  ml-2">
                            @if (!empty($object->image) && file_exists("uploads/imageGallery/" . $object->image))
                            {{ Form::label('image', 'Image',['class'=>'mr-2']) }}
                                <img style="background:thistle;max-height: 150px;"
                                    src={{ asset('uploads/imageGallery/' . $object->image) }} />
                            @endif
                        </div>
                    </div>
                </div>


                <button type="submit" id="submit" class="btn btn-primary me-2">Submit</button>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@section('footerScripts')
    <script>
        $(document).ready(function() {
            $('#bannerImage').on('change', function() {
                validateFile(this, ['image/jpeg', 'image/jpg',, 'image/png'], 2 * 1024 * 1024, '#banner_preview');
            });

            function updateFileLabel(input, previewElement) {
                var fileName = $(input).val().split('\\').pop();
                $(input).next('.file-upload-default').html(fileName);

                var file = input.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var previewHtml = '';
                        if (file.type.startsWith('image')) {
                            previewHtml = '<label>Preview:</label><img style="background:thistle;max-height: 150px;" src="' + e.target.result + '" class="img-fluid">';
                        }
                        $(previewElement).html(previewHtml);
                    };
                    reader.readAsDataURL(file);
                } else {
                    $(previewElement).html('');
                }
            }

            function validateFile(input, allowedTypes, maxSize, previewElement) {
                var file = input.files[0];
                if (file) {
                    var fileType = file.type;
                    var fileSize = file.size;
                    var isValidType = allowedTypes.includes(fileType);
                    var isValidSize = fileSize <= maxSize;

                    if (!isValidType) {
                        alert('Invalid file type. Please select a valid file.');
                        $(input).val('');
                        $(input).next('.file-upload-default').html('Choose file');
                        $(previewElement).html('');
                        return false;
                    }

                    if (!isValidSize) {
                        alert('File size exceeds 2 MB. Please select a smaller file.');
                        $(input).val('');
                        $(input).next('.file-upload-default').html('Choose file');
                        $(previewElement).html('');
                        return false;
                    }

                    updateFileLabel(input, previewElement);
                    return true;
                }
                return false;
            }
        });
    </script>
@endsection

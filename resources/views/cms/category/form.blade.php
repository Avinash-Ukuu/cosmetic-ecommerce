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
                                <li class="breadcrumb-item"><a href="{{ route('category.index') }}">Category List</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><span>Category Form</span></li>
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
                <h4 class="card-title">Category form</h4>

                {!! Form::model($object, [
                    'url' => $url,
                    'method' => $method,
                    'onSubmit' => "document.getElementById('submit').disabled=true;",
                    'files' => true,
                    'class' => 'forms-sample',
                ]) !!}
                    <input type="hidden" name="id" value="{{ $object->id }}">
                    <div class="row">
                        <div class="form-group col-3">
                            {!! Form::label('name', 'Name') !!}<span style="color: red;"> *</span>
                            {!! Form::text('name', null, ['class' => 'form-control name', 'placeholder' => 'Enter Name', 'required']) !!}
                        </div>

                        <div class="form-group col-3" id="image">
                            {{ Form::label('image', 'Image') }}
                            {{ Form::file('image', ['class' => 'file-upload-default','id'=>'categoryImage', 'accept' => 'image/jpg, image/jpeg, image/png']) }}
                            <div class="input-group col-xs-12 d-flex align-items-center">
                                <input type="text" class="form-control file-upload-info" disabled=""
                                    placeholder="Upload Image">
                                <span class="input-group-append ms-2">
                                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                </span>
                            </div>
                            <div class="row">
                                <div class="file-preview mb-2 mt-2 mr-2 ml-2" id="category_preview"></div>
                                <div class="image-preview mt-2  ml-2">
                                    @if (!empty($object->image) && file_exists("uploads/categories/" . $object->image))
                                    {{ Form::label('image', 'Image',['class'=>'mr-2']) }}
                                        <img style="background:thistle;max-height: 150px;"
                                            src={{ asset('uploads/categories/' . $object->image) }} />
                                    @endif
                                </div>
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
            var name = $(".name").val();
            if (name == "") {
                $('#submit').prop('disabled', true);
            }
            $('.name').on('input', function() {
                var inputValue = $(this).val();
                var numeric = /^\d/;
                var specialCharacter = "!@#\\$%\^*()_\\-+=\\[\\]{};':\",./<>?\\|`~";
                var emojiRegex = /[\uD800-\uDBFF][\uDC00-\uDFFF]|[\u2600-\u27FF]/;
                var hasSpecialCharacter = false;
                var hasnumeric = false;

                for (var i = 0; i < specialCharacter.length; i++) {
                    if (inputValue.includes(specialCharacter[i])) {
                        hasSpecialCharacter = true;
                        break;
                    }
                }

                if (/\d/.test(inputValue)) {
                    hasnumeric = true;
                }

                if (hasSpecialCharacter || emojiRegex.test(inputValue) || hasnumeric) {
                    $('#submit').prop('disabled', true);
                } else {
                    $('#submit').prop('disabled', false);
                }
            });

            function toggleCategoryType() {
                var parentIdValue = $('select[name="parent_id"]').val();
                var categoryType = $('select[name="category_type_id"]');

                if (parentIdValue) {
                    categoryType.val(null).trigger('change');
                    categoryType.prop('disabled', true);
                    categoryType.prop('required', false);
                } else {
                    categoryType.prop('disabled', false);
                    categoryType.prop('required', true);
                }
            }

            toggleCategoryType();
            $('select[name="parent_id"]').on('change', function() {
                    toggleCategoryType();
            });

            $('#categoryImage').on('change', function() {
                validateFile(this, ['image/jpeg', 'image/jpg'], 2 * 1024 * 1024, '#category_preview');
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

@extends('cms.layouts.master')
@section('headerLinks')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-select/bootstrap-select.css') }}">
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-12 col-xl-12 text-right">
                    <div class="justify-content-end d-flex">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-custom">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('sub-category.index') }}">Sub Category List</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><span>Sub Category Form</span></li>
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
                <h4 class="card-title">Sub Category form</h4>

                {!! Form::model($object, [
                    'url' => $url,
                    'method' => $method,
                    'onSubmit' => "document.getElementById('submit').disabled=true;",
                    'files' => true,
                    'class' => 'forms-sample',
                ]) !!}
                    <input type="hidden" name="id" value="{{ $object->id }}">
                    <div class="row">
                        <div class="form-group col-6">
                            {!! Form::label('category_id', 'Select Sub Category') !!}<span style="color: red;"> *</span>
                            {!! Form::select('category_id', $categories, null, [
                                'class' => 'form-control select2',
                                'id' => 'category_id',
                                'required',
                                'data-placeholder' => 'Select Category',
                                'placeholder' => 'Select Category',
                            ]) !!}
                        </div>
                        <div class="form-group col-6">
                            {!! Form::label('name', 'Name') !!}<span style="color: red;"> *</span>
                            {!! Form::text('name', null, ['class' => 'form-control name', 'placeholder' => 'Enter Name', 'required']) !!}
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
                var specialCharacter = "!@#\\$%\^*()\\+=\\[\\]{};:\",./<>?\\|`~";
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

        });
    </script>
@endsection

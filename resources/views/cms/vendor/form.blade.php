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
                                <li class="breadcrumb-item"><a href="{{ route('vendor.index') }}">Vendor List</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><span>Vendor Form</span></li>
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
                        <h4 class="card-title">Vendor form</h4>
                    </div>
                <div class="col-6 text-right">
                    @php
                        $badgeClasses = [
                            'approved'  => 'badge-outline-success',
                            'rejected'  => 'badge-outline-danger',
                            'pending'   =>  'badge-outline-warning'
                        ];
                    @endphp
                    <span class="badge {{ $badgeClasses[$object->status]}}">{{ ucFirst($object->status) }}</span>
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
                <div class="row">
                    <div class="form-group col-4">
                        {!! Form::label('name', 'Name') !!}<span style="color: red;"> *</span>
                        {!! Form::text('name', null, ['class' => 'form-control name', 'placeholder' => 'Enter Name', 'required']) !!}
                    </div>
                    <div class="form-group col-4">
                        {!! Form::label('email', 'Email') !!}<span style="color: red;"> *</span>
                        {!! Form::text('email', null, [
                            'class' => 'form-control',
                            'placeholder' => 'Enter Email',
                            'required',
                            'id' => 'email',
                        ]) !!}
                        <small id="emailError" style="color: red; display: none;">Invalid email type. Please enter an @gmail.com
                        </small>
                    </div>
                    <div class="form-group col-4">
                        {!! Form::label('phone_number', 'Phone Number') !!}<span style="color: red;"> *</span>
                        {!! Form::text('phone_number', null, ['class' => 'form-control phone_number', 'placeholder' => 'Enter Phone Number', 'required']) !!}
                        <small id="phoneError" style="color: red; display: none;"> Please enter numeric value  and maximum 10 digit.
                        </small>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-2">
                        {!! Form::label('dob', 'Date Of Birth') !!}<span style="color: red;"> *</span>
                        {!! Form::date('dob', null, ['class' => 'form-control name', 'placeholder' => 'Enter Date Of Birth', 'required']) !!}
                    </div>
                    <div class="form-group col-2">
                        {!! Form::label('gender', 'Gender') !!}<span style="color: red;"> *</span>
                        <div class="row">
                            <div class="form-check mr-2">
                                <label class="form-check-label">
                                <input type="radio" class="form-check-input" @if($object->gender == 'male') checked @endif name="gender" id="male" value="male">
                                Male
                                <i class="input-helper"></i></label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                <input type="radio" class="form-check-input" @if($object->gender == 'female') checked @endif name="gender" id="female" value="female">
                                Female
                                <i class="input-helper"></i></label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-4">
                        {!! Form::label('residential_address', 'Residential Address') !!}<span style="color: red;"> *</span>
                        {!! Form::text('residential_address', null, ['class' => 'form-control residential_address', 'placeholder' => 'Enter Residential Address', 'required']) !!}
                    </div>

                    <div class="form-group col-4">
                        {!! Form::label('city', 'City') !!}<span style="color: red;"> *</span>
                        {!! Form::text('city', null, ['class' => 'form-control city', 'placeholder' => 'Enter City', 'required']) !!}
                    </div>

                </div>

                <div class="row">
                    <div class="form-group col-4">
                        {!! Form::label('store_name', 'Store Name') !!}<span style="color: red;"> *</span>
                        {!! Form::text('store_name', null, ['class' => 'form-control store_name', 'placeholder' => 'Enter Store Name', 'required']) !!}
                    </div>
                    <div class="form-group col-4">
                        {!! Form::label('store_address', 'Store Address') !!}<span style="color: red;"> *</span>
                        {!! Form::text('store_address', null, ['class' => 'form-control store_address', 'placeholder' => 'Enter Store Address', 'required']) !!}
                    </div>
                    <div class="form-group col-4">
                        {!! Form::label('gst_number', 'GST Number') !!}<span style="color: red;"> *</span>
                        {!! Form::text('gst_number', null, ['class' => 'form-control gst_number', 'placeholder' => 'Enter GST Number']) !!}
                    </div>


                    {{-- <div class="form-group col-4" id="image">
                        {{ Form::label('profile_pic', 'Profile Picture') }}
                        {{ Form::file('profile_pic', ['class' => 'file-upload-default','id'=>'profile_pic', 'accept' => 'image/jpg, image/jpeg']) }}
                        <div class="input-group col-xs-12 d-flex align-items-center">
                            <input type="text" class="form-control file-upload-info" disabled=""
                                placeholder="Upload Image">
                            <span class="input-group-append ms-2">
                                <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                            </span>
                        </div>
                        <div class="row">
                            <div class="file-preview mb-2 mt-2 mr-2 ml-2" id="profile_preview"></div>
                            <div class="image-preview mt-2  ml-2">
                                @if (!empty($object->profile_pic) && file_exists("uploads/vendors/" . $object->profile_pic))
                                {{ Form::label('profile_pic', 'Profile Picture',['class'=>'mr-2']) }}
                                    <img style="background:thistle;max-height: 150px;"
                                        src={{ asset('uploads/vendors/' . $object->profile_pic) }} />
                                @endif
                            </div>
                        </div>
                    </div> --}}

                </div>

                <div class="row">
                    <div class="form-group col-3">
                        {{Form::label("business_type","Business Type",[])}}<span style="color: red;"> *</span>
                        {{Form::select("business_type",$businessTypes, null, ['class'=>'form-control','placeholder'=>'Select Business Type','data-placeholder'=>'Select Business Type','required'])}}
                    </div>

                    <div class="form-group col-3" id="image">
                        {{ Form::label('aadhar_card', 'Aadhar Card') }}
                        {{ Form::file('aadhar_card', ['class' => 'file-upload-default','id'=>'aadhar_card', 'accept' => 'application/pdf']) }}
                        <div class="input-group col-xs-12 d-flex align-items-center">
                            <input type="text" class="form-control file-upload-info" disabled=""
                                placeholder="Upload Image">
                            <span class="input-group-append ms-2">
                                <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                            </span>
                        </div>
                        <div class="row">
                            <div class="file-preview mb-2 mt-2 mr-2 ml-2" id="aadhar_card_preview"></div>
                            <div class="image-preview mt-4">
                                @if (!empty($object->aadhar_card) && file_exists("uploads/vendorDocuments/". $object->id . '/' . $object->aadhar_card))
                                {{ Form::label('aadhar_card', 'Aadhar Card Preview :',['class'=>'mr-2']) }}
                                <a href="{{ asset('uploads/vendorDocuments/' . $object->id . '/' . $object->aadhar_card) }}"
                                    target="_blank"><i class="fa fa-file-pdf-o"></i></a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-3" id="driving_licence_div">
                        {{ Form::label('dl', 'Driving Licence') }}
                        {{ Form::file('dl', ['class' => 'file-upload-default','id'=>'driving_licence', 'accept' => 'application/pdf']) }}
                        <div class="input-group col-xs-12 d-flex align-items-center">
                            <input type="text" class="form-control file-upload-info" disabled=""
                                placeholder="Upload Driving Licence">
                            <span class="input-group-append ms-2">
                                <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                            </span>
                        </div>
                        <div class="row">
                            <div class="file-preview mb-2 mt-2 mr-2 ml-2" id="driving_licence_preview"></div>
                            <div class="image-preview mt-4">
                                @if (!empty($object->dl) && file_exists("uploads/vendorDocuments/". $object->id . '/' . $object->dl))
                                {{ Form::label('dl', 'Driving Licence Preview :',['class'=>'mr-2']) }}
                                <a href="{{ asset('uploads/vendorDocuments/' . $object->id . '/' . $object->dl) }}"
                                    target="_blank"><i class="fa fa-file-pdf-o"></i></a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-3" id="voter_card_div">
                        {{ Form::label('voter_card', 'Voter Card') }}
                        {{ Form::file('voter_card', ['class' => 'file-upload-default','id'=>'voter_card', 'accept' => 'application/pdf']) }}
                        <div class="input-group col-xs-12 d-flex align-items-center">
                            <input type="text" class="form-control file-upload-info" disabled=""
                                placeholder="Upload Voter Card">
                            <span class="input-group-append ms-2">
                                <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                            </span>
                        </div>
                        <div class="row">
                            <div class="file-preview mb-2 mt-2 mr-2 ml-2" id="voter_card_preview"></div>
                            <div class="image-preview mt-4">
                                @if (!empty($object->voter_card) && file_exists("uploads/vendorDocuments/". $object->id . '/' . $object->voter_card))
                                {{ Form::label('voter_card', 'Driving Licence Preview :',['class'=>'mr-2']) }}
                                <a href="{{ asset('uploads/vendorDocuments/' . $object->id . '/' . $object->voter_card) }}"
                                    target="_blank"><i class="fa fa-file-pdf-o"></i></a>
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
                var specialCharacter = "!@#\\$%\^&*()_\\-+=\\[\\]{};':\",./<>?\\|`~";
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


            const $emailError = $('#emailError');
            $('#email').on('input', function() {
                const email = $('#email').val().trim();
                const gmailRegex = /@gmail\.com$/i;

                if (email === '' || gmailRegex.test(email)) {
                    $emailError.hide();
                    $('#submit').prop('disabled', false);
                } else {
                    $emailError.show();
                    $('#submit').prop('disabled', true);
                }
            });

            $('.phone_number').on('input', function() {
                var phoneNumber = $(this).val();
                var isValidPhoneNumber = /^\d{10}$/.test(phoneNumber);

                if (isValidPhoneNumber) {
                    $('#phoneError').hide();
                    $('#submit').prop('disabled', false);
                } else {
                    $('#phoneError').show();
                    $('#submit').prop('disabled', true);
                }
            });

            $('#aadhar_card').on('change', function() {
                validateFile(this, ['application/pdf'], 2 * 1024 * 1024, '#aadhar_card_preview');
            });


            $('#driving_licence').on('change', function() {
                validateFile(this, ['application/pdf'], 2 * 1024 * 1024, '#driving_licence_preview');
            });

            $('#voter_card').on('change', function() {
                validateFile(this, ['application/pdf'], 2 * 1024 * 1024, '#voter_card_preview');
            });

            function updateFileLabel(input, previewElement) {
                var fileName = $(input).val().split('\\').pop();
                $(input).next('.file-upload-default').html(fileName);

                var file = input.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var previewHtml = '';
                        if (file.type === 'application/pdf') {
                            previewHtml = '<label>Preview:</label><iframe src="' + e.target.result + '" style="width:100%; height:300px;" frameborder="0"></iframe>';
                        } else if (file.type.startsWith('image')) {
                            previewHtml = '<label>Preview:</label><img style="background:thistle; max-height: 150px;" src="' + e.target.result + '" class="img-fluid">';
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

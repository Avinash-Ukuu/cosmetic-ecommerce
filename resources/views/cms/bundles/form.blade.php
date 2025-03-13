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
                                <li class="breadcrumb-item"><a href="{{ route('bundle.index') }}">Product Bundle List</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><span>Product Bundle Form</span></li>
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
                <h4 class="card-title">Product Bundle form</h4>

                {!! Form::model($object, [
                    'url' => $url,
                    'method' => $method,
                    'onSubmit' => "document.getElementById('submit').disabled=true;",
                    'files' => true,
                    'class' => 'forms-sample',
                ]) !!}
                <input type="hidden" name="id" value="{{ $object->id }}">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            {!! Form::label('name', 'Name') !!}<span style="color: red;"> *</span>
                            {!! Form::text('name', null, ['class' => 'form-control name', 'placeholder' => 'Enter Name', 'required']) !!}
                        </div>

                        <div class="row">
                            <div class="form-group col-6">
                                {!! Form::label('mrp_price', 'MRP Price (Optional)') !!}
                                {!! Form::number('mrp_price', null, [
                                    'class' => 'form-control price',
                                    'placeholder' => 'Enter MRP Price',
                                    'required','step'=>'0.01',
                                    'min' => '0',
                                ]) !!}
                            </div>
                            <div class="form-group col-6">
                                {!! Form::label('sale_price', 'Sale Price') !!}
                                {!! Form::number('sale_price', null, [
                                    'class' => 'form-control','id'=> 'sale_price',
                                    'placeholder' => 'Sale Price',
                                    'min' => '0',
                                ]) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('products[]', 'Select Products') !!}
                            {!! Form::select('products[]', $products,null, [
                                'class' => 'form-control select2',
                                'placeholder' => 'Select Products',
                                'data-placeholder' => 'Select Products',
                                'required','multiple',!empty($object->id) ? 'disabled' : ''
                            ]) !!}
                        </div>

                        @if (!empty($object->id))
                            <div class="form-group">
                                {!! Form::label('publish_type', 'Select Publish Type') !!}
                                {!! Form::select('publish_type', ['publish'=>'Publish','unpublish'=>'Unpublish'],null, [
                                    'class' => 'form-control select2',
                                    'placeholder' => 'Select Publish Type',
                                    'data-placeholder' => 'Select Publish Type',
                                    'required'
                                ]) !!}
                            </div>
                        @endif

                    </div>

                    <div class="col-6">
                        <div class="form-group ">
                            {!! Form::label('description', 'Description') !!}<span style="color: red;"> *</span>
                            {!! Form::textArea('description', null, [
                                'class' => 'form-control description',
                                'placeholder' => 'Enter Description',
                                'required',"id"=>"summernote"
                            ]) !!}
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
                var emojiRegex = /[\uD800-\uDBFF][\uDC00-\uDFFF]|[\u2600-\u27FF]/;

                if (emojiRegex.test(inputValue)) {
                    $('#submit').prop('disabled', true);
                } else {
                    $('#submit').prop('disabled', false);
                }
            });


        });
    </script>
@endsection

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
                                <li class="breadcrumb-item"><a href="{{ route('coupon.index') }}">Coupon List</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><span>Coupon Form</span></li>
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
                <h4 class="card-title">Coupon form</h4>

                {!! Form::model($object, [
                    'url' => $url,
                    'method' => $method,
                    'onSubmit' => "document.getElementById('submit').disabled=true;",
                    'class' => 'forms-sample',
                    'files'=>true
                ]) !!}
                <input type="hidden" name="id" value="{{ $object->id }}">

                <div class="row">
                    <div class="col-md-3 form-group">
                        {!! Form::label('name', 'Name') !!}
                        {!! Form::text('name', null, [
                            'class' => 'form-control name',
                            'placeholder' => 'Enter Name',
                            'required',
                        ]) !!}
                    </div>

                    <div class="col-md-3 form-group">
                        {!! Form::label('code', 'Code') !!}
                        {!! Form::text('code', null, [
                            'class' => 'form-control Code',
                            'placeholder' => 'Enter code',
                            'required',
                        ]) !!}
                    </div>

                    <div class="col-md-3 form-group">
                        {!! Form::label('discount', 'Discount') !!}
                        {!! Form::number('discount', null, [
                            'class' => 'form-control discount',
                            'placeholder' => 'Enter Discount','min'=>'0',
                            'required',
                        ]) !!}
                    </div>

                    <div class="col-md-3 form-group">
                        {!! Form::label('discount_type', 'Discount Type') !!}
                        {!! Form::select('discount_type',['fixed'=>'Fixed','percentage'=>'Percentage'] ,null, [
                            'class' => 'select2 form-control discount_type',
                            'placeholder' => 'Select Discount Type',
                            'data-placeholder' => 'Select Discount Type',
                            'required',
                        ]) !!}
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-3 form-group">
                        {!! Form::label('minimum_purchase', 'Minimum Purchase ') !!}
                        {!! Form::number('minimum_purchase', null, [
                                'class' => 'form-control minimum_purchase',
                                'placeholder' => 'Enter Minimum Purchase','min'=>'0'
                            ]) !!}
                    </div>
                    <div class="col-md-3 form-group">
                        {!! Form::label('expiry_date', 'Expiry Date') !!}
                        {!! Form::date('expiry_date', null, [
                                'class' => 'form-control','id'=>'expiry_date',
                                'placeholder' => 'Enter Expiry Date',
                                'required',
                            ]) !!}
                    </div>
                    <div class="col-md-3 form-group">
                        {!! Form::label('usage_limit', 'Usage Limit ( Optional )') !!}
                        {!! Form::number('usage_limit', null, [
                                'class' => 'form-control usage_limit',
                                'placeholder' => 'Enter Usage Limit','min'=>'0'
                            ]) !!}
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
        $(document).ready(function () {
            // Handle date selection
            $("#expiry_date").on("change", function () {
                const expiryDateValue = new Date($(this).val()); // Get the selected date
                const today = new Date();
                today.setHours(0, 0, 0, 0); // Normalize today's date to midnight

                // Check if the expiry date is less than today
                if (expiryDateValue < today) {
                    if ($(this).next(".error-message").length === 0) {
                        // Add error message if not already present
                        $("<p class='error-message' style='color: red;'>The expiry date cannot be in the past.</p>").insertAfter(this);
                    }
                    $(this).val('');
                } else {
                    // Remove error message if the date is valid
                    $(this).next(".error-message").remove();
                }
            });
        });
    </script>
@endsection

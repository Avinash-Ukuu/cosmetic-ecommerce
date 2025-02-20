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
                                <li class="breadcrumb-item active" aria-current="page"><span>{{ $vendor->name }}</span></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="text-center pb-4">
                        @if (!empty($vendor->user->profile_pic) && file_exists('uploads/users/' . $vendor->user->profile_pic))
                            <img src="{{ asset('uploads/users/' . $vendor->user->profile_pic . '') }}" alt="profile"
                                class="img-lg rounded-circle mb-3">
                        @else
                            <img src="{{ asset('images/default.png') }}" alt="profile" class="img-lg rounded-circle mb-3">
                        @endif
                        <div class="mb-2">
                            <h3>{{ $vendor->name }}</h3>
                            <h6 class="mb-2 me-2 text-muted"><b>Email : </b>{{ $vendor->email }}</h6>
                            <h6 class="mb-2 me-2 text-muted"><b>Mobile : </b>{{ $vendor->phone_number }}</h6>
                        </div>
                        @if ($vendor->status == 'pending')
                            <div class="d-flex justify-content-center">
                                {{ Form::open(['url' => route('updateVendorStatus', ['id' => $vendor->id]), 'class' => 'row', 'method' => 'POST', 'onSubmit' => "document.getElementById('submit').disabled=true;"]) }}
                                <input type="hidden" name="id" value="{{ $vendor->id }}">
                                <div class="form-group col-12">
                                    {!! Form::label('status', 'Status') !!}
                                    {!! Form::select('status', ['approved' => 'Approved', 'rejected' => 'Rejected'], null, [
                                        'class' => 'form-control  ',
                                        'id' => 'status',
                                        'data-placeholder' => 'Select Status',
                                        'placeholder' => 'Select Status',
                                        'required',
                                    ]) !!}
                                </div>
                                <div class="form-group col-12" id="reasonField">
                                    {!! Form::label('reason', 'Reason for Rejection') !!}
                                    {!! Form::text('reason', null, [
                                        'class' => 'form-control',
                                        'placeholder' => 'Enter reason',
                                        'id' => 'reason',
                                        'disabled' => true,
                                    ]) !!}
                                </div>
                                <div class="col-12 text-center">
                                    <button type="submit" id="submit" class="btn btn-primary">Submit</button>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        @else
                            @if ($vendor->status == 'approved')
                                <span class="badge badge-success">{{ ucFirst($vendor->status) }}</span>
                            @elseif($vendor->status == 'rejected')
                                <span class="badge badge-danger mb-2">{{ ucFirst($vendor->status) }}</span>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Detail</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>DOB</td>
                                    <td>{{ $vendor->dob ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td>Gender</td>
                                    <td>{{ $vendor->gender ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td>Residential Address</td>
                                    <td>{{ $vendor->residential_address ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td>City</td>
                                    <td>{{ $vendor->city ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td>Store Name</td>
                                    <td>{{ $vendor->store_name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td>Store Address</td>
                                    <td>{{ $vendor->store_address ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td>GST Number</td>
                                    <td>{{ $vendor->gst_number ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td>Business Type</td>
                                    <td>{{ $vendor->business_type ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td>Aadhar Card</td>
                                    @if (!empty($vendor->aadhar_card) && file_exists('uploads/vendorDocuments/' . $vendor->id . '/' . $vendor->aadhar_card))
                                        <td><a href="{{ asset('uploads/vendorDocuments/' . $vendor->id . '/' . $vendor->aadhar_card) }}"
                                                target="_blank"><i class="fa fa-file-pdf-o"></i></a></td>
                                    @else
                                        <td>N/A</td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>Driving Licence</td>
                                    @if (!empty($vendor->dl) && file_exists('uploads/vendorDocuments/' . $vendor->id . '/' . $vendor->dl))
                                        <td><a href="{{ asset('uploads/vendorDocuments/' . $vendor->id . '/' . $vendor->dl) }}"
                                                target="_blank"><i class="fa fa-file-pdf-o"></i></a></td>
                                    @else
                                        <td>N/A</td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>Voter Card</td>
                                    @if (!empty($vendor->voter_card) && file_exists('uploads/vendorDocuments/' . $vendor->id . '/' . $vendor->voter_card))
                                        <td><a href="{{ asset('uploads/vendorDocuments/' . $vendor->id . '/' . $vendor->voter_card) }}"
                                                target="_blank"><i class="fa fa-file-pdf-o"></i></a></td>
                                    @else
                                        <td>N/A</td>
                                    @endif
                                </tr>
                                @if (!empty($vendor->reason))
                                    <tr>
                                        <td>Reason</td>
                                        <td>{{ $vendor->reason ?? 'N/A' }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footerScripts')
    <script>
        $(document).ready(function() {
            $('#status').change(function() {
                if ($(this).val() == 'rejected') {
                    $('#reason').prop('required', true);
                    $('#reason').prop('disabled', false);
                } else {
                    $('#reason').prop('required', false);
                    $('#reason').prop('disabled', true);
                }
            });
        });
    </script>
@endsection

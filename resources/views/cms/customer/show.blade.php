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
                                <li class="breadcrumb-item"><a href="{{ route('customer.index') }}">Customer List</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><span>Customer Detail</span></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="border-bottom text-center">
                                @if (!empty($customer->user->profile_pic) && file_exists("uploads/users/" . $customer->user->profile_pic))
                                <img src="{{asset('uploads/users/' . $customer->user->profile_pic)}}" alt="profile"
                                    class="img-lg rounded-circle mb-3">
                                @else
                                    <img src="{{ asset('images/default.png') }}"  class="img-lg rounded-circle mb-3" alt="image">
                                @endif
                                <div class="mb-3">
                                    <h3>{{ $customer->user->name }}</h3>
                                    <div class="d-flex align-items-center justify-content-center">
                                        {{-- <h5 class="mb-0 me-2 text-muted">{{ $customer->user->email }}</h5> --}}
                                    </div>
                                </div>
                                {{-- <div class="d-flex justify-content-center">
                                    <button class="btn btn-success me-1">Hire Me</button>
                                    <button class="btn btn-success">Follow</button>
                                </div> --}}
                            </div>
                            <div class="py-4">
                                <p class="clearfix">
                                    <span class="float-left">
                                        Status
                                    </span>
                                    <span class="float-right text-muted">
                                        @if($customer->user->is_active == 1) <label class="badge badge-outline-success">Active</label> @else <label class="badge badge-outline-danger">Not Active </label>@endif
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">
                                        Phone
                                    </span>
                                    <span class="float-right text-muted">
                                        {{ $customer->phone_number }}
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">
                                        Mail
                                    </span>
                                    <span class="float-right text-muted">
                                        {{ $customer->user->email }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="d-block d-md-flex justify-content-between mt-4 mt-md-0">
                                <h3>Address Detail</h3>
                            </div>
                            <div class="profile-feed">
                                @if($customer->addresses->isNotEmpty())
                                    @foreach($customer->addresses as $address)
                                    <div class="d-flex align-items-start profile-feed-item">
                                            <span class="float-left">
                                                Address {{ $loop->iteration }}
                                            </span>
                                            <address class="float-right text-muted ml-5">
                                                {{ $address->full_name }}, {{ $address->mobile_number ?? 'N/A'}}, {{ $address->email }}, {{ $address->building_name }}, {{ $address->street_address }},
                                                {{ $address->area }}
                                                {{ $address->emirate }}
                                                {{ $address->po_box ?? 'N/A'}}
                                                {{ $address->landmark ?? 'N/A'}}
                                                {{ $address->delivery_instructions ?? 'N/A' }}
                                            </address>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footerScripts')
    <script></script>
@endsection

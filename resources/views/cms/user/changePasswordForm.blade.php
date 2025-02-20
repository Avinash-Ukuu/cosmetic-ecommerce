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
                                <li class="breadcrumb-item active" aria-current="page"><span>Change Password Form</span></li>
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
                <h4 class="card-title">Change Password Form</h4>

                <form method="POST" action="{{ route('updatePassword') }}" onsubmit="document.getElementById('submit').disabled=true;">
                    @csrf

                    <div class="form-group">
                        <label for="exampleInputPassword2">New Password</label>
                        <input type="text" class="form-control" id="exampleInputPassword2" name="password"
                            value="{{ old('password') }}" placeholder="New Password">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword3">Confirm Password</label>
                        <input type="text" class="form-control" id="exampleInputPassword3" name="password_confirmation"
                            value="{{ old('password_confirmation') }}" placeholder="Confirm Password">
                    </div>

                    <button type="submit" id="submit" class="btn btn-primary me-2">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@extends('cms.layouts.master')
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h3 class="font-weight-bold">Welcome {{ auth()->user()->name }}</h3>
                    <h6 class="font-weight-normal mb-0">here's what's happening with your store today</h6>
                </div>
            </div>
        </div>
    </div>


@endsection

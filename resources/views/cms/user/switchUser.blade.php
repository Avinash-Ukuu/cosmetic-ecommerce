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
                                <li class="breadcrumb-item active" aria-current="page"><span>Switch User Form</span></li>
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
                <h4 class="card-title">Switch User Form</h4>

                {{ Form::open(['url' => route('switchUser'), 'method' => 'POST', 'onSubmit' => "document.getElementById('submit').disabled=true;"]) }}
                    <div class="form-group row">
                        {!! Form::label('user_id', 'Select User') !!}
                        {!! Form::select('user_id', $users, null, [
                            'class' => 'form-control  select2',
                            'data-placeholder' => 'Select User',
                            'placeholder' => 'Select User',
                            'required',
                        ]) !!}
                    </div>
                    <button type="submit" id="submit" class="btn btn-primary">Submit</button>
                {{ Form::close() }}


            </div>
        </div>
    </div>

@endsection

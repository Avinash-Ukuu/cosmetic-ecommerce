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
                                <li class="breadcrumb-item"><a href="{{ route('user.index') }}">User List</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><span>{{ $user->name }}</span></li>
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
                <h4 class="card-title">Assign Role Form</h4>

                {{ Form::open(['url' => route('submitRole'), 'method' => 'POST', 'onSubmit' => "document.getElementById('submit').disabled=true;"]) }}
                <input type="hidden" name="id" value="{{ $user->id }}">
                @php $assignedRoles =  $user->roles->isEmpty() ? [] : $user->roles->pluck("name","id")->toArray()  @endphp

                <div class="row">
                    @foreach ($roles as $key => $role)
                        <div class="col-sm-3 mt-2">
                            <div class="form-check">
                                <input id="{{ $key }}" class="form-check-input ml-1" type="checkbox" name="role_id[]"
                                    value="{{ $key }}" @if (array_key_exists($key, $assignedRoles)) checked @endif>
                                <label for="{{ $key }}" class="form-check-label">{{ $role }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button type="submit" id="submit" class="btn btn-primary me-2">Submit</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

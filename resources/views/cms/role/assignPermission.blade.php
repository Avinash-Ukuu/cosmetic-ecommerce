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
                                <li class="breadcrumb-item"><a href="{{ route('role.index') }}">Role List</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><span>{{ $role->name }}</span></li>
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
                <h4 class="card-title">Assign Permission Form</h4>

                {{ Form::open(['url' => route('submitPermission'), 'method' => 'POST', 'onSubmit' => "document.getElementById('submit').disabled=true;"]) }}
                <input type="hidden" name="id" value="{{ $role->id }}">

                <div class="row">
                    @foreach ($modulePermissions as $name => $permissions)
                        <h6 class="mt-2 ml-2"><b>{{ $name }}</b></h6>
                        @foreach ($permissions as $permission)
                            <div class="col-12 mt-2 ml-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permission_id[]"
                                        value="{{ $permission->id }}" @if (array_key_exists($permission->id, $assignedPermissions)) checked @endif>
                                    <label class="form-check-label">{{ $permission->name }}</label>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>

                <button type="submit" id="submit" class="btn btn-primary me-2">Submit</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

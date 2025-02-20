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
                                <li class="breadcrumb-item active" aria-current="page"><span>Category List</span></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-10">
                        <div class="row">
                            <h4 class="card-title">Category List</h4>
                        </div>
                    </div>
                    <div class="col-2 text-right"><a href="{{ route('category.create') }}"><label
                                class="badge badge-outline-primary"><i class="mdi mdi-account-plus"></i> Add</label></a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="example1" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Active</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr id="{{ $category->id }}">
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->slug }}</td>
                                    <td>
                                        <div
                                            class="custom-control custom-switch
                                                    custom-switch-off-danger custom-switch-on-success">
                                            <input type="checkbox" class="custom-control-input"
                                                @if ($category->is_active) checked @endif
                                                onchange="isActiveAction('{{ $category->id }}',this)"
                                                id="customActiveSwitch{{ $loop->iteration }}">
                                            <label class="custom-control-label"
                                                for="customActiveSwitch{{ $loop->iteration }}"></label>
                                        </div>
                                    </td>

                                    <td>
                                        @if (auth()->user()->cannot('admin', auth()->user()))
                                            N/A
                                        @else
                                            <div class="row">
                                                <a href="{{ route('category.edit', ['category' => $category->id]) }}"><i
                                                        class="fa fa-edit"></i></a>
                                                @if (isset(auth()->user()->super_admin))
                                                    <form
                                                        action="{{ route('category.destroy', ['category' => $category->id]) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('Delete')
                                                        <button type="button" onclick="confirmBox(this)"
                                                            style="border: 0px;background-color:transparent;"><i
                                                                class="fa fa-trash text-danger"></i></button>
                                                    </form>
                                                @endif
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footerScripts')

<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#example1').DataTable({
                "ordering": false,
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
            });

        });

        function isActiveAction(id, check) {
            let isCheck = "";

            if ($(check).is(":checked")) {
                isCheck = 1;
            } else {
                isCheck = 0;
            }

            $.ajax({
                url: "{{ route('isActiveAction') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: id,
                    table: 'categories',
                    is_active: isCheck,
                },
                success: function(response) {
                    let message = "Category In Active";
                    if (isCheck) {
                        message = "Category Active";
                    }
                    toastr.success(message);
                    location.reload();
                },error: function(response)
                {
                    if(response.responseJSON && response.responseJSON.message) {
                        alert(response.responseJSON.message);
                    } else {
                        toastr.error('An error occurred while updating the category status.');
                    }
                    location.reload();
                }
            });
        }
    </script>
@endsection

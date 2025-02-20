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
                                <li class="breadcrumb-item active" aria-current="page"><span>Brand List</span></li>
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
                        <h4 class="card-title">Brand List</h4>
                    </div>
                    <div class="col-2 text-right"><a href="{{ route('brand.create') }}"><label
                                class="badge badge-outline-primary"><i class="mdi mdi-account-plus"></i> Add</label></a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="example1" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Slug</th>
                                @can('admin',auth()->user())
                                    <th>Active</th>
                                @endcan
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody  @if(auth()->user()->hasRole('admin')) id="sortable" @endif>
                            @foreach ($brands as $brand)
                                <tr id="{{ $brand->id }}">
                                    <td>{{ $brand->name }}</td>
                                    <td>{{ $brand->slug }}</td>
                                    @can('admin',auth()->user())
                                        <td>
                                            <div
                                                class="custom-control custom-switch
                                                        custom-switch-off-danger custom-switch-on-success">
                                                <input type="checkbox" class="custom-control-input"
                                                    @if ($brand->is_active) checked @endif
                                                    onchange="isActiveAction('{{ $brand->id }}',this)"
                                                    id="customActiveSwitch{{ $loop->iteration }}">
                                                <label class="custom-control-label"
                                                    for="customActiveSwitch{{ $loop->iteration }}"></label>
                                            </div>
                                        </td>
                                    @endcan

                                    <td>
                                        @if (auth()->user()->cannot('admin', auth()->user()))
                                            N/A
                                        @else
                                            <div class="row">
                                                <a href="{{ route('brand.edit', ['brand' => $brand->id]) }}"><i
                                                        class="fa fa-edit"></i></a>
                                                @if (isset(auth()->user()->super_admin))
                                                    <form
                                                        action="{{ route('brand.destroy', ['brand' => $brand->id]) }}"
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

            $("#sortable").sortable({

                stop: function(event, ui) {

                    var itemOrder = $('#sortable').sortable("toArray");
                    var selectedLength = $('#example1').DataTable().page.len();
                    if (selectedLength !== -1) {
                        alert("Please select 'All' option from entries for sorting");
                        return false;
                    }
                    $.ajax({
                        url: "{{ route('sortRows') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "POST",
                        data: {
                            order: itemOrder,
                            table: "brands"
                        },
                        success: function(response) {
                            toastr.success("Sorted Successfully");
                            $('#example1').DataTable();
                        },
                        error: function() {
                            alert("Something went wrong");
                        },
                    })

                }
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
                    is_active: isCheck,
                    table: "brands",
                    module: "Brand",
                },
                success: function(response) {
                    let message = "Brand In Active";
                    if (isCheck) {
                        message = "Brand Active";
                    }
                    toastr.success(message);

                }
            });
        }
    </script>
@endsection

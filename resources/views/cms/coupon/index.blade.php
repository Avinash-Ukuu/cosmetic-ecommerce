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
                                <li class="breadcrumb-item active" aria-current="page"><span>Coupon List</span></li>
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
                        <h4 class="card-title">Coupon Table</h4>
                    </div>
                        <div class="col-2 text-right">
                            <a href="{{ route('coupon.create') }}"><label class="badge badge-outline-primary"><i
                                        class="mdi mdi-account-plus"></i> Add</label></a>
                        </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped" id="example1">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    Name
                                </th>
                                <th>
                                    Code
                                </th>
                                <th>
                                    Discount
                                </th>
                                <th>
                                    Discount Type
                                </th>
                                <th>
                                    Minimum Purchase
                                </th>
                                <th>
                                    Expiry Date
                                </th>
                                <th>
                                    Usage Limit
                                </th>
                                <th>
                                    Active
                                </th>
                                <th>
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($coupons as $coupon)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $coupon->name }}</td>
                                    <td>{{ $coupon->code }}</td>
                                    <td>{{ ucFirst($coupon->coupon_type) }}</td>
                                    <td>{{ $coupon->discount }}</td>
                                    <td>{{ ucfirst($coupon->discount_type) }}</td>
                                    <td>{{ $coupon->minimum_purchase }}</td>
                                    <td>{{ $coupon->expiry_date }}</td>
                                    <td>{{ $coupon->usage_limit }}</td>
                                    <td>
                                        <div
                                            class="custom-control custom-switch
                                                    custom-switch-off-danger custom-switch-on-success">
                                            <input type="checkbox" class="custom-control-input"
                                                @if ($coupon->is_active) checked @endif
                                                onchange="isActiveAction('{{ $coupon->id }}',this)"
                                                id="customActiveSwitch{{ $loop->iteration }}">
                                            <label class="custom-control-label"
                                                for="customActiveSwitch{{ $loop->iteration }}"></label>
                                        </div>
                                    </td>
                                    <td><a href="{{ route('coupon.edit',['coupon'=>$coupon->id]) }}" ><i class="fa fa-edit"></i></a></td>
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
    <script>
        $(document).ready(function() {
            $('#example1').DataTable();
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
                    table: "coupons",
                    module: "coupon",
                },
                success: function(response) {
                    let message = "Coupon In Active";
                    if (isCheck) {
                        message = "Coupon Active";
                    }
                    toastr.success(message);

                }
            });
        }
    </script>
@endsection

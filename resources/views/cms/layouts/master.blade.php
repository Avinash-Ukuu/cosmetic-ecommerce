<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Glamify Beauty</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('assets/skydash/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/skydash/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/skydash/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('assets/skydash/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/skydash/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/skydash/js/select.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/skydash/vendors/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/skydash/vendors/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('assets/skydash/css/vertical-layout-light/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('assets/skydash/images/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/skydash/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/skydash/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/skydash/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.min.css') }}">
    <link href="{{ asset('assets/css/summernote.min.css')}}" rel="stylesheet">
    @yield('headerLinks')
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo mr-5" href="index.html"><img
                        src="{{ asset('assets/skydash/images/logo.svg') }}" class="mr-2" alt="logo" /></a>
                <a class="navbar-brand brand-logo-mini" href="index.html"><img
                        src="{{ asset('assets/skydash/images/logo-mini.svg') }}" alt="logo" /></a>
            </div>

            @include('cms.layouts.navbar')
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_settings-panel.html -->
            {{-- <div class="theme-setting-wrapper">
                <div id="settings-trigger"><i class="ti-settings"></i></div>
                <div id="theme-settings" class="settings-panel">
                    <i class="settings-close ti-close"></i>
                    <p class="settings-heading">SIDEBAR SKINS</p>
                    <div class="sidebar-bg-options selected" id="sidebar-light-theme">
                        <div class="img-ss rounded-circle bg-light border mr-3"></div>Light
                    </div>
                    <div class="sidebar-bg-options" id="sidebar-dark-theme">
                        <div class="img-ss rounded-circle bg-dark border mr-3"></div>Dark
                    </div>
                    <p class="settings-heading mt-2">HEADER SKINS</p>
                    <div class="color-tiles mx-0 px-4">
                        <div class="tiles success"></div>
                        <div class="tiles warning"></div>
                        <div class="tiles danger"></div>
                        <div class="tiles info"></div>
                        <div class="tiles dark"></div>
                        <div class="tiles default"></div>
                    </div>
                </div>
            </div> --}}
            {{-- @include('cms.layouts.rightSidebar') --}}
            <!-- partial -->
            <!-- partial:partials/_sidebar.html -->
            @include('cms.layouts.sidebar')
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">

                    @yield('content')

                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2024.
                            Premium from Glamify. All rights reserved.</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made
                            with <i class="ti-heart text-danger ml-1"></i></span>
                    </div>
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Made by <a
                                href="javaScript:void(0)">Avinash</a></span>
                    </div>
                </footer>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <!-- plugins:js -->
    <script src="{{ asset('assets/skydash/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ asset('assets/skydash/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/skydash/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/skydash/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/skydash/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('assets/skydash/vendors/typeahead.js/typeahead.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/skydash/vendors/select2/select2.min.js') }}"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('assets/skydash/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/skydash/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assets/skydash/js/template.js') }}"></script>
    <script src="{{ asset('assets/skydash/js/settings.js') }}"></script>
    <script src="{{ asset('assets/skydash/js/todolist.js') }}"></script>
    <script src="{{ asset('assets/skydash/js/file-upload.js') }}"></script>
    <script src="{{ asset('assets/skydash/js/typeahead.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="{{ asset('assets/skydash/js/dashboard.js') }}"></script>
    <script src="{{ asset('assets/skydash/js/Chart.roundedBarCharts.js') }}"></script>
    <script src="{{ asset('assets/skydash/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/skydash/js/select2.js') }}"></script>
    <script src="{{ asset('assets/js/summernote.min.js') }}"></script>
    <!-- End custom js for this page-->
    <script>
        $(document).ready(function() {
            $(".select2").select2();

            $('#summernote').summernote({
                height: 300,
            });
        });
        if ("{{ session()->has('success') }}") {
            let message = "{{ session()->get('success') }}";
            toastr.success(message);
        }

        if ("{{ session()->has('error') }}") {
            let message = "{{ session()->get('error') }}";
            toastr.error(message);
        }

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif

        function confirmBox(submitBtnTarget) {
            let result = confirm("Want to delete?");
            if (result) {
                $(submitBtnTarget).closest("form").submit();
            }

        }

        function deleteItem(path) {
            var sure = confirm('are you sure');
            if (!sure) {
                return false;
            }

            $.ajax({
                url: path,
                type: 'DELETE',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    toastr.success('Successfully Deleted');
                    location.reload();
                },
                error: function(response) {
                    if (response.status == '404') {
                        alert("Item not found");
                    } else
                        alert(response.statusText);
                }
            });
        }
    </script>
    @yield('footerScripts')
</body>

</html>

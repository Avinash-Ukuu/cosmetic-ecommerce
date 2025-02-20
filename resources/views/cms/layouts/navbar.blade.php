<div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
        <span class="icon-menu"></span>
    </button>
    {{-- <ul class="navbar-nav mr-lg-2">
        <li class="nav-item nav-search d-none d-lg-block">
            <div class="input-group">
                <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
                    <span class="input-group-text" id="search">
                        <i class="icon-search"></i>
                    </span>
                </div>
                <input type="text" class="form-control" id="navbar-search-input" placeholder="Search now"
                    aria-label="search" aria-describedby="search">
            </div>
        </li>
    </ul> --}}
    <ul class="navbar-nav navbar-nav-right">
        {{-- <li class="nav-item dropdown">
            <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#"
                data-toggle="dropdown">
                <i class="icon-bell mx-0"></i>
                <span class="count"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                aria-labelledby="notificationDropdown">
                <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
                <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                        <div class="preview-icon bg-success">
                            <i class="ti-info-alt mx-0"></i>
                        </div>
                    </div>
                    <div class="preview-item-content">
                        <h6 class="preview-subject font-weight-normal">Application Error</h6>
                        <p class="font-weight-light small-text mb-0 text-muted">
                            Just now
                        </p>
                    </div>
                </a>
                <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                        <div class="preview-icon bg-warning">
                            <i class="ti-settings mx-0"></i>
                        </div>
                    </div>
                    <div class="preview-item-content">
                        <h6 class="preview-subject font-weight-normal">Settings</h6>
                        <p class="font-weight-light small-text mb-0 text-muted">
                            Private message
                        </p>
                    </div>
                </a>
                <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                        <div class="preview-icon bg-info">
                            <i class="ti-user mx-0"></i>
                        </div>
                    </div>
                    <div class="preview-item-content">
                        <h6 class="preview-subject font-weight-normal">New user registration</h6>
                        <p class="font-weight-light small-text mb-0 text-muted">
                            2 days ago
                        </p>
                    </div>
                </a>
            </div>
        </li> --}}

        <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                @if (!empty(auth()->user()->profile_pic) && file_exists("uploads/users/" . auth()->user()->profile_pic))
                    <img src="{{ asset('uploads/users/'.auth()->user()->profile_pic) }}" alt="profile">
                @else
                    <img src="{{ asset('images/default.png') }}" alt="profile">
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                <a href="{{ route('userProfile',['id'=>auth()->user()->id])}}" class="dropdown-item">
                    <i class="ti-id-badge text-primary"></i>
                    Profile
                </a>
                <a href="{{ route('changePassword')}}" class="dropdown-item">
                    <i class="ti-settings text-primary"></i>
                    Change Passord
                </a>

                @can('superAdmin', new App\Models\User())
                    <a href="{{ route('switchUserForm') }}" class="dropdown-item"><i class="ti-reload text-primary"></i> Switch User </a>
                @endcan
                @if (session()->has('original_user'))
                    <a href="{{ route('logoutSwitchUser') }}" class="dropdown-item"><i class="ti-power-off text-primary"></i> Return Back</a>
                @else
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <a href=" {{ route('logout') }} " class="dropdown-item" onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            <i class="ti-power-off text-primary"></i>
                            Logout
                        </a>
                    </form>
                @endif
            </div>
        </li>
        {{-- <li class="nav-item nav-settings d-none d-lg-flex">
            <a class="nav-link" href="#">
                <i class="icon-ellipsis"></i>
            </a>
        </li> --}}
    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
        data-toggle="offcanvas">
        <span class="icon-menu"></span>
    </button>
</div>

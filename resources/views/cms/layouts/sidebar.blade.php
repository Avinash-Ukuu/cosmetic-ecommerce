<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">

        <!-- Dashboard -->
        <li class="nav-item @if (Route::currentRouteName() == 'dashboard') active @endif">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        <!-- User Management -->
        @can('admin',auth()->user())
            <li class="nav-item @if (in_array(Route::currentRouteName(), ['user.index', 'role.index', 'permission.index', 'module.index'])) active @endif">
                <a class="nav-link @if (in_array(Route::currentRouteName(), ['user.index', 'role.index', 'permission.index', 'module.index'])) collapsed @endif" data-toggle="collapse"
                    href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                    <i class="icon-head menu-icon"></i>
                    <span class="menu-title">User Management &nbsp;</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse @if (in_array(Route::currentRouteName(), ['user.index', 'role.index', 'permission.index', 'module.index'])) show @endif" id="ui-basic">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link @if (Route::currentRouteName() == 'user.index') active @endif"
                                href="{{ route('user.index') }}">User</a></li>
                        <li class="nav-item"> <a class="nav-link @if (Route::currentRouteName() == 'role.index') active @endif"
                                href="{{ route('role.index') }}">Role</a></li>
                        @can('superAdmin',auth()->user())
                            <li class="nav-item"> <a class="nav-link @if (Route::currentRouteName() == 'permission.index') active @endif"
                                    href="{{ route('permission.index') }}">Permission</a>
                            <li class="nav-item"> <a class="nav-link @if (Route::currentRouteName() == 'module.index') active @endif"
                                    href="{{ route('module.index') }}">Module</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </li>
        @endcan

        @can('admin',auth()->user())


            <li class="nav-item @if(Route::currentRouteName() == 'customer.index') active @endif">
                <a class="nav-link" href="{{ route('customer.index') }}">
                    <i class="icon-tag menu-icon"></i>
                    <span class="menu-title">Customer</span>
                </a>
            </li>

            <!-- Category -->

            <li class="nav-item @if(Route::currentRouteName() == 'category.index') active @endif">
                <a class="nav-link" href="{{ route('category.index') }}">
                    <i class="icon-box menu-icon"></i>
                    <span class="menu-title">Categories</span>
                </a>
            </li>
        @endcan

        <!-- Inventory -->

        @canany(['create','view','update'], new App\Models\Product())
            <li class="nav-item @if (in_array(Route::currentRouteName(), ['product.index', 'lowProduct'])) active @endif">
                <a class="nav-link @if (in_array(Route::currentRouteName(), ['product.index', 'lowProduct'])) collapsed @endif" data-toggle="collapse"
                    href="#inventory-management" aria-expanded="false" aria-controls="inventory-management">
                    <i class="icon-box menu-icon"></i>
                    <span class="menu-title">Inventory &nbsp;</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse @if (in_array(Route::currentRouteName(), ['product.index', 'lowProduct.index'])) show @endif" id="inventory-management">
                    <ul class="nav flex-column sub-menu">
                        <!-- Product -->
                        <li class="nav-item"> <a class="nav-link @if (Route::currentRouteName() == 'product.index') active @endif"
                                href="{{ route('product.index') }}">Product</a></li>

                        <!-- Low Stock -->
                        <li class="nav-item"> <a class="nav-link @if (Route::currentRouteName() == 'lowProduct') active @endif"
                                href="{{ route('lowProduct') }}">Low Stock</a></li>

                    </ul>
                </div>
            </li>
        @endcanany



        <!-- Orders -->
        <li class="nav-item @if (in_array(Route::currentRouteName(), ['order.index'])) active @endif">
            <a class="nav-link @if (in_array(Route::currentRouteName(), ['order.index'])) collapsed @endif" data-toggle="collapse"
                href="#order-management" aria-expanded="false" aria-controls="order-management">
                <i class=" icon-bag menu-icon"></i>
                <span class="menu-title">Orders &nbsp;</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse @if (in_array(Route::currentRouteName(), ['order.index'])) show @endif" id="order-management">
                <ul class="nav flex-column sub-menu">

                <!-- Product Orders -->
                    <li class="nav-item"> <a class="nav-link @if (Route::currentRouteName() == 'order.index') active @endif"
                        href="{{ route('order.index') }}">Product</a></li>

                </ul>
            </div>
        </li>



        @can('admin',auth()->user())

            <!-- Coupon -->
            <li class="nav-item @if(Route::currentRouteName() == 'coupon.index') active @endif">
                <a class="nav-link" href="{{ route('coupon.index') }}">
                    <i class="icon-tag menu-icon"></i>
                    <span class="menu-title">Coupon</span>
                </a>
            </li>

            <!-- BLOG -->
            <li class="nav-item @if(Route::currentRouteName() == 'blog.index') active @endif">
                <a class="nav-link" href="{{ route('blog.index') }}">
                    <i class="icon-paper menu-icon"></i>
                    <span class="menu-title">Blog</span>
                </a>
            </li>

            <!-- Brand -->
            <li class="nav-item @if(Route::currentRouteName() == 'brand.index') active @endif">
                <a class="nav-link" href="{{ route('brand.index') }}">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">Brand</span>
                </a>
            </li>
        @endcan

        <!-- Activity  Log -->
        @if(isset(auth()->user()->super_admin))
            <li class="nav-item @if(Route::currentRouteName() == 'activityLogs') active @endif">
                <a class="nav-link" href="{{ route('activityLogs') }}">
                    <i class="icon-clock menu-icon"></i>
                    <span class="menu-title">Activity Logs</span>
                </a>
            </li>
        @endif
    </ul>
</nav>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- SidebarSearch Form -->
        {{-- <div class="form-inline mt-2">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> --}}

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                         class="nav-link @if(request()->routeIs('dashboard')) active @endif">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                {{-- <li class="nav-item @if(request()->routeIs('orders.*')) menu-open @endif">
                    <a href="#" class="nav-link @if(request()->routeIs('orders.*')) active @endif">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>
                            Order
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('orders.index') }}" 
                                class="nav-link">
                                <i class="{{ request()->routeIs('orders.index') ? 'fas' : 'far' }} fa-circle nav-icon"></i>
                                <p>Order List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('orders.create') }}" 
                                class="nav-link">
                                <i class="{{ request()->routeIs('orders.create') ? 'fas' : 'far' }} fa-circle nav-icon"></i>
                                <p>Add Order</p>
                            </a>
                        </li>
                    </ul>
                </li> --}}
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

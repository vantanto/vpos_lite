<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- SidebarSearch Form -->
        <div class="form-inline mt-2">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                         class="nav-link @if(Request::routeIs('dashboard')) active @endif">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item @if(Request::routeIs('orders.*')) menu-open @endif">
                    <a href="#" class="nav-link @if(Request::routeIs('orders.*')) active @endif">
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
                                <i class="{{ Request::routeIs('orders.index') ? 'fas' : 'far' }} fa-circle nav-icon"></i>
                                <p>Order List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('orders.create') }}" 
                                class="nav-link">
                                <i class="{{ Request::routeIs('orders.create') ? 'fas' : 'far' }} fa-circle nav-icon"></i>
                                <p>Add Order</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item @if(Request::routeIs('purchases.*')) menu-open @endif">
                    <a href="#" class="nav-link @if(Request::routeIs('purchases.*')) active @endif">
                        <i class="nav-icon fas fa-cart-plus"></i>
                        <p>
                            Purchase
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('purchases.index') }}" 
                                class="nav-link">
                                <i class="{{ Request::routeIs('purchases.index') ? 'fas' : 'far' }} fa-circle nav-icon"></i>
                                <p>Purchase List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('purchases.create') }}" 
                                class="nav-link">
                                <i class="{{ Request::routeIs('purchases.create') ? 'fas' : 'far' }} fa-circle nav-icon"></i>
                                <p>Add Purchase</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @php $routeIs_MasterData = Request::routeIs('categories.*') || Request::routeIs('customers.*') || Request::routeIs('products.*')
                    || Request::routeIs('suppliers.*'); 
                @endphp
                <li class="nav-item @if($routeIs_MasterData) menu-open @endif">
                    <a href="#" class="nav-link @if($routeIs_MasterData) active @endif">
                        <i class="nav-icon fas fa-th-list"></i>
                        <p>
                            Master Data
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('categories.index') }}" 
                                class="nav-link">
                                <i class="{{ Request::routeIs('categories.*') ? 'fas' : 'far' }} fa-circle nav-icon"></i>
                                <p>Category</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('customers.index') }}" 
                                class="nav-link">
                                <i class="{{ Request::routeIs('customers.*') ? 'fas' : 'far' }} fa-circle nav-icon"></i>
                                <p>Customer</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('products.index') }}" 
                                class="nav-link">
                                <i class="{{ Request::routeIs('products.*') ? 'fas' : 'far' }} fa-circle nav-icon"></i>
                                <p>Product</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('suppliers.index') }}" 
                                class="nav-link">
                                <i class="{{ Request::routeIs('suppliers.*') ? 'fas' : 'far' }} fa-circle nav-icon"></i>
                                <p>Supplier</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('settings.index') }}" 
                        class="nav-link @if(Request::routeIs('settings.*')) active @endif">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>Setting</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

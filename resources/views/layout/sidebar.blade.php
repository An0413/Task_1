    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" style="line-height: 1.5"
       href="">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Let's go<sup></sup></div>
    </a>

    <hr class="sidebar-divider my-0">
        <li class="nav-item {{Route::is('products') ? 'active' : '' }}">
            <a class="nav-link"
               href="{{route('products')}}">
                <i class="fas fa-store"></i>
                <span>Products</span>
            </a>
        </li>
        <li class="nav-item {{Route::is('orders') ? 'active' : '' }}">
            <a class="nav-link"
               href="{{route('orders')}}">
                <i class="fas fa-clipboard"></i>
                <span>Orders</span>
            </a>
        </li>
        <li class="nav-item {{Route::is('warehouses') ? 'active' : '' }}">
            <a class="nav-link"
               href="{{route('warehouses')}}">
                <i class="fas fa-warehouse"></i>
                <span>Warehouses</span>
            </a>
        </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>

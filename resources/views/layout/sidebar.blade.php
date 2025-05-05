    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    {{--    @include('admin.layout.menu_items')--}}
    @php
        $menu_items = [
            [
                'url' => 'admin_list',
                'name' => 'admin_list',
                'label' => 'Ադմիններ',
                'params' => null,
                'role' => 3,
                'icon' => 'fas fa-users'
            ],
            [
                'url' => 'admin_menu_list',
                'name' => 'menu_list',
                'label' => 'Մենյու',
                'params' => null,
                'role' => 2,
                'icon' => 'fas fa-bars'
            ],
             [
                'url' => 'product_list',
                'name' => 'product_list',
                'label' => 'Ապրանք',
                'params' => [0],
                'role' => 3,
                'icon' => 'fas fa-couch'
            ],
            [
                'url' => 'product_type',
                'name' => 'prod_type_list',
                'label' => 'Ապրանքի տիպ',
                'params' => null,
                'role' => 1,
                'icon' => 'fas fa-clipboard'
            ],
            [
                'url' => 'companies_list',
                'name' => 'company_list',
                'label' => 'Կազմակերպություններ',
                'params' => null,
                'role' => 2,
                'icon' => 'fas fa-briefcase'
            ],
            [
                'url' => 'shop_list',
                'name' => 'market_list',
                'label' => 'Խանութներ',
                'params' => [0],
                'role' => 3,
                'icon' => 'fas fa-store'
            ],
            [
                'url' => 'admin_category_list',
                'name' => 'category_list',
                'label' => 'Կատեգորիաներ',
                'params' => null,
                'role' => 1,
                'icon' => 'fas fa-layer-group'
            ],
            [
                'url' => 'product_category',
                'name' => 'prod_category_list',
                'label' => 'Պրոդուկտի կատեգորիաներ',
                'params' => null,
                'role' => 1,
                'icon' => 'fas fa-file'

            ],
            [
                'url' => 'contract_request_list',
                'name' => 'contract_list',
                'label' => 'Պայմանագրի հայտեր',
                'params' => null,
                'role' => 1,
                'icon' => 'fas fa-handshake'
            ],
             [
                'url' => 'payment',
                'name' => 'payment_list',
                'label' => 'Վճարումներ',
                'params' => null,
                'role' => 1,
                'icon' => 'fas fa-wallet'
            ],
            [
                'url' => 'discount_by_payment',
                'name' => 'discount_by_payment',
                'label' => 'Վճարումների զեղչեր',
                'params' => null,
                'role' => 1,
                'icon' => 'fas fa-percent'
            ],
            [
                'url' => 'discount_by_shop',
                'name' => 'discount_by_shop',
                'label' => 'Զեղչ ըստ խանութների',
                'params' => null,
                'role' => 1,
                'icon' => 'fas fa-percent'
            ],
            [
                'url' => 'price_by_product',
                'name' => 'price_by_product',
                'label' => 'Գին ըստ պրոդուկտի',
                'params' => null,
                'role' => 1,
                'icon' => 'fas fa-tags'
            ],
              [
                'url' => 'not_create',
                'name' => 'notification',
                'label' => 'Հաղորդագրություն',
                'params' => null,
                'role' => 1,
                'icon' => 'fas fa-envelope'
            ]
    ];
        $page = Session::get('page');
    @endphp

    <a class="sidebar-brand d-flex align-items-center justify-content-center" style="line-height: 1.5"
       href="">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Let's go<sup></sup></div>
    </a>

    <hr class="sidebar-divider my-0">

{{--    @foreach($menu_items as $item)--}}
{{--        @if(Auth::guard('admin')->user()->role_id <= $item['role'] )--}}
{{--            <li class="nav-item @if($page == $item['name']) menu_active_item @endif">--}}
{{--                <a class="nav-link"--}}
{{--                   href="{{ (!is_null($item['params'])) ? route($item['url'], $item['params']) : route($item['url']) }}">--}}
{{--                    <i class="{{$item['icon']}}"></i>--}}
{{--                    <span>{{$item['label']}}</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--        @endif--}}
{{--    @endforeach--}}

{{--    @if(Session::get('page')=='update-password'||Session::get('page')=='update-admin-details')--}}
{{--        @php--}}
{{--            $active = "active";--}}
{{--        @endphp--}}
{{--    @else--}}
{{--        @php--}}
{{--            $active = "";--}}
{{--        @endphp--}}
{{--    @endif--}}
{{--    <li class="nav-item">--}}
{{--        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"--}}
{{--           aria-expanded="true" aria-controls="collapseTwo">--}}
{{--            <i class="fas fa-fw fa-cog"></i>--}}
{{--            <span>Կարգավորումներ</span>--}}
{{--        </a>--}}
{{--        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">--}}
{{--            <div class="bg-white py-2 collapse-inner rounded">--}}
{{--                <h6 class="collapse-header">Հիմնական Կարգավորումներ</h6>--}}
{{--                <a class="collapse-item nav-link set_class" href="{{url('admin/update-password')}}">Փոխել գաղտնաբառը</a>--}}
{{--                <a class="collapse-item nav-link set_class" href="{{url('admin/update-admin-details')}}">Ադմինի--}}
{{--                    տվյալների <br>թարմացում</a>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--    </li>--}}

    <!-- Nav Item - Utilities Collapse Menu -->
{{--    <li class="nav-item">--}}
{{--        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"--}}
{{--           aria-expanded="true" aria-controls="collapseUtilities">--}}
{{--            <i class="fas fa-fw fa-wrench"></i>--}}
{{--            <span>Utilities</span>--}}
{{--        </a>--}}
{{--        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"--}}
{{--             data-parent="#accordionSidebar">--}}
{{--            <div class="bg-white py-2 collapse-inner rounded">--}}
{{--                <h6 class="collapse-header">Custom Utilities:</h6>--}}
{{--                <a class="collapse-item" href="utilities-color.html">Colors</a>--}}
{{--                <a class="collapse-item" href="utilities-border.html">Borders</a>--}}
{{--                <a class="collapse-item" href="utilities-animation.html">Animations</a>--}}
{{--                <a class="collapse-item" href="utilities-other.html">Other</a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </li>--}}

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Addons
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
{{--    <li class="nav-item">--}}
{{--        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"--}}
{{--           aria-expanded="true" aria-controls="collapsePages">--}}
{{--            <i class="fas fa-fw fa-folder"></i>--}}
{{--            <span>Pages</span>--}}
{{--        </a>--}}
{{--        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">--}}
{{--            <div class="bg-white py-2 collapse-inner rounded">--}}
{{--                <h6 class="collapse-header">Login Screens:</h6>--}}
{{--                <a class="collapse-item" href="login.html">Login</a>--}}
{{--                <a class="collapse-item" href="register.html">Register</a>--}}
{{--                <a class="collapse-item" href="forgot-password.html">Forgot Password</a>--}}
{{--                <div class="collapse-divider"></div>--}}
{{--                <h6 class="collapse-header">Other Pages:</h6>--}}
{{--                <a class="collapse-item" href="404.html">404 Page</a>--}}
{{--                <a class="collapse-item" href="blank.html">Blank Page</a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </li>--}}

    <!-- Nav Item - Charts -->
{{--    <li class="nav-item">--}}
{{--        <a class="nav-link" href="charts.html">--}}
{{--            <i class="fas fa-fw fa-chart-area"></i>--}}
{{--            <span>Charts</span></a>--}}
{{--    </li>--}}

    <!-- Nav Item - Tables -->
{{--    <li class="nav-item">--}}
{{--        <a class="nav-link" href="tables.html">--}}
{{--            <i class="fas fa-fw fa-table"></i>--}}
{{--            <span>Tables</span></a>--}}
{{--    </li>--}}

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>

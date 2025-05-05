<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>


    <ul class="navbar-nav ml-auto">


        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>

            <!-- Counter - Alerts -->
{{--                @if($countn)--}}
{{--                    <span class="badge badge-danger badge-counter not_num">{{ $countn}}</span>--}}
{{--                @endif--}}
            </a>
            <!-- Dropdown - Alerts -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                 aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    ԾԱՆՈՒՑՈՒՄՆԵՐ
                </h6>
{{--                @foreach($notification as $item)--}}
{{--                    <a class="dropdown-item d-flex align-items-center notific" href="javascript:void(0);"--}}
{{--                       data-value="{{$item->id}}" type="button" data-toggle="modal" data-status="{{$item->status}}"--}}
{{--                       data-target="#notification">--}}
{{--                        <div class="mr-3">--}}
{{--                            <div class="icon-circle bg-primary">--}}
{{--                                <i class="fas fa-bell fa-fw text-light"></i>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="not_div">--}}
{{--                            <h6 class="not_title">{{$item->title}}--}}
{{--                                @if($item->status == 1)--}}
{{--                                    <span class="checkmark">&#10003;--}}
{{--                                        <span class="second_mark">&#10003;</span>--}}
{{--                                    </span>--}}
{{--                                @endif--}}
{{--                            </h6>--}}
{{--                            <p class="font-weight-bold message">{{substr($item->message, 0, 50) . '...'}}</p>--}}
{{--                            <p class="small text-gray-500">{{$item->created_at}}</p>--}}
{{--                        </div>--}}
{{--                    </a>--}}
{{--                @endforeach--}}
                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
            </div>
        </li>

        <!-- Nav Item - Messages -->
{{--        @if($admin->role_id == 1)--}}
            <li class="nav-item dropdown no-arrow mx-1">
{{--                @php--}}
{{--                    $messages = \App\Models\Messages::orderBy('id', 'asc');--}}
{{--                    $count = DB::table('messages')->where('status', 0)->count();--}}
{{--                @endphp--}}
                <a class="nav-link dropdown-toggle" href="" role="button" aria-haspopup="true"
                   aria-expanded="false">
                    <i class="fas fa-envelope fa-fw"></i>
{{--                    @if($count)--}}
{{--                        <span class="badge badge-danger badge-counter count_messages">{{ $count}}</span>--}}
{{--                    @endif--}}
                </a>
            </li>
{{--        @endif--}}
        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"></span>
{{--                @if(!empty(Auth::guard('admin')->user()->image))--}}
{{--                    <img class="img-profile rounded-circle"--}}
{{--                         src="{{url('/images/admin/'.Auth::guard('admin')->user()->image)}}" alt="no_image">--}}
{{--                @else--}}
{{--                    <img class="img-profile rounded-circle"--}}
{{--                         src="{{url('/admin/img/user.png')}}" alt="no_image">--}}
{{--                @endif--}}
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                 aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Settings
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                    Activity Log
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{url('admin/login')}}" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>

<!-- Modal -->
<div class="modal fade" id="notification" tabindex="-1" aria-labelledby="notification" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modal_h" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal_m">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

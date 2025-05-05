<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SB Admin 2 - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="{{asset('/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('/css/sb-admin-2.min.css') }}"  rel="stylesheet">
    <link href="{{ asset('/css/sb-admin-2.css') }}"  rel="stylesheet">
    <link href="{{ asset('/css/style.css') }}"  rel="stylesheet">
    <script src="{{asset('/vendor/jquery/jquery.min.js')}}"></script>
    <link href="{{ asset('/vendor/datatables/dataTables.bootstrap4.min.css') }}"  rel="stylesheet">

    <link href="{{ asset('/css/style.css') }}"  rel="stylesheet">

</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    @include('layout.sidebar')
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        @include('layout.header')
        <!-- Main Content -->
       @yield('content')
        <!-- End of Main Content -->

        <!-- Footer -->
@include('layout.footer')
        <!-- End of Footer -->

    </div>

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Համոզված եք,որ ցանկանում եք լքել էջը?</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Չգիտեմ</button>
                <a class="btn btn-primary" href="{{url('admin/login')}}">Այո</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
{{--<script src="{{asset('admin/vendor/jquery/jquery.min.js')}}"></script>--}}
<script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendor/bootstrap/js/bootstrap.min.js')}}"></script>


<!-- Core plugin JavaScript-->
<script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>

<!-- Custom scripts for all pages-->
<script src="{{asset('js/sb-admin-2.min.js')}}"></script>

<!-- Page level plugins -->
<script src="{{asset('vendor/chart.js/Chart.min.js')}}"></script>

<!-- Page level custom scripts -->
<script src="{{asset('js/demo/chart-area-demo.js')}}"></script>
<script src="{{asset('js/demo/chart-pie-demo.js')}}"></script>
<!--  Custom script -->
<script src="{{asset('js/custom.js')}}"></script>
<script src="{{asset('js/contracts/contract.js')}}"></script>
<script src="{{asset('js/products/product.js')}}"></script>
{{--<script src="{{asset('admin/js/admin/create.js')}}"></script>--}}
</body>

</html>

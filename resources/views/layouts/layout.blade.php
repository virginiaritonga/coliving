<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">

<title>Safira Halim Co-Living Management</title>

<!-- Custom fonts for this template-->
<link href="{{asset('css/all.min.css')}}" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

<!-- Select2 -->
<link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

<!-- Custom styles for this template-->
<link href="{{asset('css/sb-admin-2.min.css')}}" rel="stylesheet">
<link href="{{asset('css/custom.css')}}" rel="stylesheet">

<!--chart-->
<link href="{{asset('css/Chart.min.css')}}" rel="stylesheet" type="text/css">

<!--datatable-->
<link href="{{asset('datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css">

<!--Toaster -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion customsidebar" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{action('HomeController@index')}}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-building"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Co-Living Management</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <li class="nav-item {{ Request::path() ==  'home' ? 'active' : ''  }}">
        <a class="nav-link" href="{{action('HomeController@index')}}">
            <i class="fas fa-fw fa-home"></i>
            <span>Dashboard</span></a>
        </li>

        <li class="nav-item {{ Request::path() ==  'search-room' ? 'active' : ''  }}">
        <a class="nav-link" href="{{action('RoomController@search')}}">
            <i class="fas fa-fw fa-search"></i>
            <span>Search Room</span></a>
        </li>

        <li class="nav-item {{ Request::path() ==  'booking' ? 'active' : ''  }}">
        <a class="nav-link" href="{{action('BookingController@index')}}">
            <i class="fas fa-fw fa-book"></i>
            <span>Bookings</span></a>
        </li>

        <li class="nav-item {{ Request::path() ==  'room' ? 'active' : ''  }}">
        <a class="nav-link" href="{{action('RoomController@index')}}">
            <i class="fas fa-fw fa-bed"></i>
            <span>Rooms</span></a>
        </li>

        <li class="nav-item {{ Request::path() ==  'type' ? 'active' : ''  }}">
        <a class="nav-link" href="{{action('TypeController@index')}}">
            <i class="fas fa-fw fa-th-list"></i>
            <span>Types</span></a>
        </li>

        <li class="nav-item {{ Request::path() ==  'tenant' ? 'active' : ''  }}">
        <a class="nav-link" href="{{action('TenantController@index')}}">
            <i class="fas fa-fw fa-user"></i>
            <span>Tenants</span></a>
        </li>

        <li class="nav-item {{ Request::path() ==  'report' ? 'active' : ''  }}">
        <a class="nav-link" href="{{action('ReportController@index')}}">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Report</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
            </button>
            <h2 class="banner"> Safira Halim Co-Living Management </h2>

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">
            <div class="topbar-divider d-none d-sm-block"></div>
            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{Auth::user()->name}}</span>
                <img class="img-profile rounded-circle" src="{{asset('img/user.png')}}">
                </a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{url('/profile')}}">
                    <i class="fas fa-user-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{route('logout')}}" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
                </div>
            </li>

            </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
            @yield('content')
        </div>
        <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

    </div>
    <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn btn-primary" type="submit">Logout</button>
            </form>
        </div>
        </div>
    </div>
    </div>


    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('js/jquery.easing.min.js')}}"></script>
    <!-- Chart JS -->
    <script src="{{asset('js/Chart.min.js')}}"></script>
    <!-- Popper JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('js/sb-admin-2.min.js')}}"></script>

    <!-- DataTable -->
    <script src="{{asset('datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('datatables/dataTables.bootstrap4.min.js')}}"></script>

    @yield('script')


    @stack('scripts')

    <!-- Select2 -->
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
    <script>
    //untuk pilih sensor di form create device
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
        theme: 'bootstrap4'
        })

        //Bootstrap Duallistbox
        // $('.duallistbox').bootstrapDualListbox()

        $("input[data-bootstrap-switch]").each(function() {
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
        });
    })
    </script>



</body>

</html>

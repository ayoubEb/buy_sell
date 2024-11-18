

<!doctype html>
<html lang="en">

  <head>
    <meta charset="utf-8" />
    <title>buy sell</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    @include('layouts.vendor-css')
    @vite('resources/sass/style.scss')
</head>


<body data-sidebar="dark">

<!-- Loader -->
{{-- <div id="preloader">
    <div id="status">
        <div class="spinner"></div>
    </div>
</div> --}}

<!-- Begin page -->
<div id="layout-wrapper">
  @include('layouts.topbar')

    <!-- ========== Left Sidebar Start ========== -->
    @include('layouts.sidebar')

    <!-- Left Sidebar End -->

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
          {{-- @include('layouts.sidebar') --}}
          @yield('content')
        </div>
        <!-- End Page-content -->

        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        ©
                        <script>document.write(new Date().getFullYear())</script> Fonik<span class="d-none d-sm-inline-block"> -
                            Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand.</span>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->


<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

@include('layouts.vendor-js')
@yield('script')
</body>

</html>
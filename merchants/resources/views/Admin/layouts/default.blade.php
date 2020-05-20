<!DOCTYPE html>

<html>
    <head>
        @include('Admin.includes.head')
        @yield('mystyles')
    </head>
    <body class="hold-transition skin-blue sidebar-mini" >
        <div class="wrapper">

            @include('Admin.includes.header')
            <!-- Left side column. contains the logo and sidebar -->
            @if(Session::get('loggedinAdminId') && Session::get('login_user_type') == 3)
                @include('Admin.includes.distributorSidebar')
            @elseif(Session::get('loggedinAdminId') && Session::get('login_user_type') == 5)
                @include('Admin.includes.supplierSidebar')
            @else
                @include('Admin.includes.sidebar')
            @endif

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                @yield('content')
            </div><!-- /.content-wrapper -->

            @include('Admin.includes.footer')

        </div><!-- ./wrapper -->
        @include('Admin.includes.foot')
        @yield('myscripts')
    </body>
</html>

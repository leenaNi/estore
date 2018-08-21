<!DOCTYPE html>
<html lang="en">
    <head>
        @include('Admin.Includes.head')
        @yield('mystyles')
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            @include('Admin.Includes.header')
            <!-- Left side column. contains the logo and sidebar -->
            @if(Auth::guard('bank-users-web-guard')->check() !== false)
            @include('Admin.Includes.sidebarbank')
            @endif
            
             @if(Auth::guard('merchant-users-web-guard')->check() !== false)
            @include('Admin.Includes.sidebarMerchant')
            @endif
            
            @if(Auth::guard('vswipe-users-web-guard')->check() !== false)
            @include('Admin.Includes.sidebar')
            @endif



            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                @yield('contents')
            </div>
            <!-- /.content-wrapper -->
            <footer class="main-footer">
                @include('Admin.Includes.footer')
            </footer>

            <!-- Control Sidebar -->
            @include('Admin.Includes.controlSidebar')
            <!-- /.control-sidebar -->
            <!-- Add the sidebar's background. This div must be placed
                 immediately after the control sidebar -->
            <div class="control-sidebar-bg"></div>
        </div>
        <!-- ./wrapper -->

        <!-- jQuery 2.2.3 -->
    <foot>
        @include('Admin.Includes.foot') 
        @yield('myscripts')
    </foot>
</body>
</html>

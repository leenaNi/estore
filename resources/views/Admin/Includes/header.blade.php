<?php
$sSettings = App\Library\Helper::getSettings();
//dd(App\Models\Currency::find($sSettings->currency_id)->unicode);
?>
<style>

    .skin-blue .main-header .navbar,.skin-blue .main-header a > .logo {
        background-color: <?php echo "#" . $sSettings->primary_color . " !important"; ?>;
    }
    .skin-blue .wrapper, .skin-blue .main-sidebar, .skin-blue .left-side,.skin-blue .main-header li.user-header{
        background-color: <?php echo "#" . $sSettings->secondary_color . " !important"; ?>;
    }
    .skin-blue .sidebar-menu > li:hover > a, .skin-blue .sidebar-menu > li.active > a{
        background-color: <?php echo "#" . $sSettings->primary_color . " !important"; ?>;
    }

    .skin-blue .sidebar-menu > li > .treeview-menu{
        background-color: <?php echo "#" . $sSettings->primary_color . " !important"; ?>;
        opacity:1;
    }
</style>
<header class="main-header">

    <!-- Logo -->
    <a href="" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>V</b>S</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg" style="background-image: url({{asset("public/admin/uploads/settings/".$sSettings->logo."")}})">
        </span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">


                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ asset(Config('constants.AdminDistImgPath').'user2-160x160.jpg') }}" class="user-image" alt="User Image">
                        <span class="hidden-xs">{{@(Auth::guard('merchant-users-web-guard')->check() !== true)? ucwords(Session::get('authUserData')->roles()->first()->name):'-'}}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="{{ asset(Config('constants.AdminDistImgPath').'user2-160x160.jpg') }}" class="img-circle" alt="User Image">
                            <p>
                                {{  Session::get('authUserData')->name  }}
<!--                                <small>Member since {{ date('M-Y',strtotime(Session::get('authUserData')->created_at))}}</small>-->
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <!--          <li class="user-body">
                                   <div class="row">
                                     <div class="col-xs-4 text-center">
                                       <a href="#">Followers</a>
                                     </div>
                                     <div class="col-xs-4 text-center">
                                       <a href="#">Sales</a>
                                     </div>
                                     <div class="col-xs-4 text-center">
                                       <a href="#">Friends</a>
                                     </div>
                                   </div>
                                 </li> -->
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="text-center">
                                <?php
                                if (Auth::guard('vswipe-users-web-guard')->check() !== false) {
                                    $logout = route('admin.vswipe.logout');
                                } else if (Auth::guard('bank-users-web-guard')->check() !== false) {
                                    $logout = route('admin.bank.logout');
                                } else if (Auth::guard('merchant-users-web-guard')->check() !== false) {
                                    $logout = route('admin.merchant.logout');
                                }
                                ?>

                                <a href="{{ $logout }}" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                <!--          <li>
                            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                          </li>-->
            </ul>
        </div>
    </nav>
</header>
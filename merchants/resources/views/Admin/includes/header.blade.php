<header class="main-header">
 
    <!-- Logo -->
    <a href="{{route('admin.dashboard')}}" class="logo" style="background: rgba(0,0,0,0.2)!important;">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b><img src="{{ Config('constants.adminImgPath').'/logo-mini.png' }}" class="user-image" alt="User"></b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">
        <img src="{{ Session::get('storelogo') }}" height="55">

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>              
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
             
            <ul class="nav navbar-nav">   
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?php
                        $profileimg= App\Models\User::find(Session::get('loggedinAdminId'))->profile;
                        ?>
                      
                        <img src="{{ Config('constants.adminImgPath') }}/{{($profileimg)?$profileimg:'default-profile-picture.png'}}" class="user-image" alt="User">
                        <span class="hidden-xs">{{ @App\Models\User::find(Session::get('loggedinAdminId'))->first_name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{route('adminEditProfile',['id'=>(Session::get('loggedinAdminId'))])}}"> <i class="fa fa-user-circle-o" aria-hidden="true"></i> Edit Profile</a></li>
                                                <li><a href="#" data-toggle="modal" data-target="#shortcut-popup"><i class="fa fa-keyboard-o" aria-hidden="true"></i> Keyboard Shortcuts</a></li>

                        <li><a href="{{ route('adminLogout') }}"> <i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
                        <!-- User image -->
                        <!-- <li class="user-header" style="background: #FFFFFF!important;">
                            <img src="{{ asset('public/Admin/dist/img/default-profile-picture.png') }}" class="img-circle" alt="User">
                            <p>
                                {{ @App\Models\User::find(Session::get('loggedinAdminId'))->first_name }}
                            </p>
                        </li>-->
                        <!-- Menu Body -->

                        <!-- Menu Footer-->
                        <!--<li class="user-footer">
                            <div class="pull-left">
                                <a class="btn btn-primary btn-flat" data-toggle="modal" data-target="#shortcut-popup">Keyboard Shortcuts</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('adminLogout') }}" class="btn btn-primary btn-flat">Sign out</a>
                            </div>
                        </li> -->
                    </ul>
                </li>
            </ul>
        </div>
        <div class="pull-right storeBtn">
            <a href="{{ route('home') }}" target="_balak" class="btn btn-block btn-sm view-storeBtn"> View Store </a>
        </div>
    </nav>



</header>
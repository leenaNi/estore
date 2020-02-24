<header class="main-header">
    <!-- Logo -->
    <!-- <a href="{{route('admin.dashboard')}}" class="logo" style="background: rgba(0,0,0,0.2)!important;"> -->
    <a href="{{route('admin.dashboard')}}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b><img src="{{ Config('constants.adminImgPath').'/logo-mini.png' }}" class="user-image" alt="User"></b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">
            <img src="{{ Session::get('storelogo') }}" height="55">
            <!-- <img src="{{ Config('constants.adminImgangePath') }}/{{'logo.png'}}"> -->
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
                                <img src="{{ Config('constants.adminImgangePath') }}/icons/{{'gear.svg'}}" alt="Setting"> 
                            </a>
                        </li>
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <?php
                                $profileimg = (Session::get('loggedinAdminId'))? App\Models\User::find(Session::get('loggedinAdminId'))->profile: '';
                                $date1 = date_create(date("2018-09-10"));//date_create(App\Library\Helper::getSettings()['created_date']);
                                $expiry = date_create(App\Library\Helper::getSettings()['expiry_date']);
                                $date2 = date_create(date("Y-m-d"));
                                $diff = date_diff($date2, $date1);
                                $expiryd = date_diff($date2, $expiry);
                                $dayused = $diff->format("%a");
                                $expirydate = $expiryd->format("%a");
                                $server = $_SERVER['HTTP_HOST'];
                                $host_names = explode(".", $server);
                                $bottom_host_name = $host_names[1] . "." . $host_names[2];
//dd($bottom_host_name);
                                if ($dayused < 30) {
                                    $dayremain = 30 - $dayused;
                                }
                                ?>
                                <img src="{{ Config('constants.adminImgangePath') }}/{{($profileimg)?$profileimg:'/icons/user.svg'}}" class="user-image" alt="User">
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
<!--                 <div class="pull-right storeBtn">
                    <a href="{{ route('home') }}" target="_balak" class="btn btn-block btn-sm view-storeBtn"> View Store </a>
                </div>
               @if($dayused < 30)
                <div class="pull-right storeBtn">
                    <p class="btn btn-block btn-sm view-storeBtn"> Your free trial version of store will be expire after {{30 - $dayused}} days.</p>
                </div>
                @endif-->
               <!-- @if($expirydate)
                       <div class="pull-right storeBtn">
                     <a href="#" class="btn btn-block renewStore"  style="cursor:pointor;"> Renew Now </a>
                </div>
                <div class="pull-right storeBtn">
                    <p class="btn btn-block btn-sm view-storeBtn"> Your  store will be expire after {{$expirydate}} days.If you want to continue please renew it.
                    <form method="post" action="#"  target="_parent" onsubmit="window.open('https://veestores.com/get-city-pay', '_blank', 'scrollbars=no,menubar=no,height=600,width=800,resizable=yes,toolbar=no,status=no');
                            return true;"> -->
                   
<!--                        <input type="hidden" name="store_id" value="{{Session::get('store_id')}}" >
                        <input type="button" id="renewStore" value="submit" class="btn btn-primary renewStore">-->
                    <!--</form>
                    </p>
                </div>-->
               
                @endif
            </nav>
            </header>
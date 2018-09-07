<!-- Header -->
<style>
    div.logo {
        position: relative;
    }

    div.logo .updateLogo {
        position: absolute;
        right: 0px !important;
        top: 30% !important;
    }
    div.logo .updateLogo a {
        color: #fff !important;
        font-size: 12px;
        font-weight: 600;
    }
    .updateLogo i {
        color: #fff;
        font-size: 20px;
    }

    span.editicons {
        position: absolute;
        top: 35%;
        right: 0px;
        cursor: pointer;
    }
    span.editicons i {
        color: #fff;
        font-size: 14px;
    }
    .updateHomeBanner {
        position: absolute;
        left: 0%;
        top: 60%;
        z-index: 999;
        width: 100%;
        text-align: center;
    }
</style>
<header id="header" class="transparent-header full-header" data-sticky-class="dark" style="background: #000;">

    <div id="header-wrap">

        <div class="container clearfix">

            <div id="primary-menu-trigger"><i class="icon-reorder"></i></div>

            <!-- Logo
              ============================================= -->
            <div id="logo" class="logo noRightBorder">
                <a href="{{ route('home') }}" class="standard-logo" data-dark-logo="{{ (App\Library\Helper::getSettings()['logo'])?App\Library\Helper::getSettings()['logo']:asset(Config('constants.defaultImgPath').'default-logo.png') }}"><img src="{{ (App\Library\Helper::getSettings()['logo'])?App\Library\Helper::getSettings()['logo']:asset(Config('constants.defaultImgPath').'default-logo.png') }}" alt="Logo">
                </a>
                <a href="{{ route('home') }}" class="retina-logo" data-dark-logo="{{ (App\Library\Helper::getSettings()['logo'])?App\Library\Helper::getSettings()['logo']:asset(Config('constants.defaultImgPath').'default-logo.png') }}"><img src="{{ (App\Library\Helper::getSettings()['logo'])?App\Library\Helper::getSettings()['logo']:asset(Config('constants.defaultImgPath').'default-logo.png') }}" alt="Logo">
                </a>
                @if(Session::get('login_user_type') == 1)
                <div class="updateLogo"><a href="#"><i class="fa fa-pencil fa-lg"></i></a></div>
                @endif
            </div><!-- #logo end -->

            <!-- Primary Navigation
              ============================================= -->
            <nav id="primary-menu" class="white">

                <ul>

                    <li class="current"><a href="{{ route('home') }}"><div>Home</div></a></li>


                    @foreach($menu as $getm)
                    {{ App\Library\Helper::getmenu($getm) }}
                    @endforeach

                    @if(count($staticManuPage) >0)
                    @foreach($staticManuPage as $menuPage) 
                    <li><a href="{{route($menuPage->url_key)}}"><div>{{$menuPage->page_name}}</div></a></li>
                    @endforeach
                    @endif
                    <!--<li><a href="{{route('contact-us')}}"><div>Contact</div></a></li>-->
                    @if(Session::get('loggedin_user_id'))
                    <li  class="mobileMyAccount">

                        <a href="{{ route('myProfile')  }}">My Account</a>
                    </li>
                    <li class="">
                        <a href="{{ route('logout')  }}">Logout</a>
                    </li>
                    @else
                    <li class="">
                        <a href="{{ route('loginUser') }}">Login / Register</a> 
                    </li> 
                    @endif

                    @if(Session::get('login_user_type') == 1)
                    <li class=""> 
                        <a href="#" class="label label-success manageCate nobg mobTextLeft" style="cursor:pointor;"> <div>Manage Categories</div></a></li>
                    @endif

                    @if(Session::get('login_user_type') == 1)
                    <li class="mobMenuAlign">
                        <?php
                        $redirectUrl = '';
                        if ($_SERVER['REQUEST_URI'] == "/") {
                            $redirectUrl = route('adminLogin');
                        } else {
                            $getUrl = explode("/", $_SERVER['REQUEST_URI']);
                            $redirectUrl = $getUrl[0] . "/admin";
                        }
                        ?>
                        <a href="{{ $redirectUrl }}" class="label" target="_blank" style="cursor:pointor;" data-toggle="tooltip" data-placement="bottom" title="Go to Store Admin"> <img src="{{ Config('constants.frontendPublicImgPath').'/store-admin-icon.png'}}"> <span class="mobDisplay">Go to Store Admin</span></a></li> 
                    @endif
                    <li class="">
                        <a href="#" class="label label-success tracking nobg mobilealignmenu" style="cursor:pointor;"> <div>Track Your Order</div></a>
                    </li>
                </ul>
                <!-- Top Cart
                  ============================================= -->
                <div id="top-cart" class="white">
                    <a href="{{ route('cart') }}"><i class="icon-shopping-cart"></i><span class="shop-cart">{{(Cart::instance("shopping")->count())?Cart::instance("shopping")->count():0}}</span></a>
                </div><!-- #top-cart end -->

                <!-- Top Search
                  ============================================= -->
                <div id="top-search" class="white">
                    <a href="#" id="top-search-trigger"><i class="icon-search3"></i><i class="icon-line-cross"></i></a>

                    <form action="{{route('category') }}" method="get">
                        <input  class="form-control"  type="text" value="{{ (Input::get('searchTerm'))?Input::get('searchTerm'):'' }}" name="searchTerm" placeholder="Type &amp; Hit Enter.." required>

                    </form>
                </div><!-- #top-search end -->

            </nav><!-- #primary-menu end -->

        </div>

    </div>

</header><!-- #header end -->
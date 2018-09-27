<div id="top-bar" class="">

    <div class="container clearfix">
        @if(count($contactDetails) >0)
        <div class="col_half nobottommargin mobText-center mobFullWidthCol">
            <?php $contact = json_decode($contactDetails->contact_details); ?>
            <p class="nobottommargin"><strong>Call:</strong> {{$contact->mobile}} | <strong>Email:</strong> {{$contact->email}} </p>

        </div>
        @endif
        <div class="col_half col_last fright nobottommargin mobFullWidthCol">


            <!-- Top Links
            ============================================= -->
            <div class="top-links">
                <ul>

                    @if(count($socialMedia) >0)
                    <li class="socialDisplay">
                        <div>
                            @foreach($socialMedia as $media)
                            <a target="_blank" href="{{$media->link}}" class="social-icon headsocial-icon si-borderless si-text-color si-{{$media->media}}" title="{{$media->media}}">
                                <i class="icon-{{$media->media}}"></i>
                                <i class="icon-{{$media->media}}"></i>
                            </a>
                            @endforeach


                        </div>
                    </li>
                    @endif
                    <li>  @if(Session::get('loggedin_user_id'))
                        <a href="{{ route('myProfile')  }}">My Account</a>  <a href="{{ route('logout')  }}">Logout</a>

                        @else
                        <a href="{{ route('loginUser') }}">Login / Register</a>  
                        @endif</li>
                    <li>
                    <li class="">
                        <a href="#" class="label label-success tracking nobg mobilealignmenu" style="cursor:pointor;">Track Your Order</a>
                    </li>
                    <!-- Top Cart
        ============================================= -->
                    <div id="top-bar-cart">
                        <a href="{{ route('cart') }}" id=""><i class="icon-shopping-cart"></i><span class="shop-cart">{{(Cart::instance("shopping")->count())?Cart::instance("shopping")->count():0}}</span></a>
                    </div><!-- #top-cart end --></li>
                </ul>
            </div><!-- .top-links end -->

        </div>

    </div>

</div>
<!-- Header
============================================= -->
<header id="header">

    <div id="header-wrap">

        <div class="container clearfix">

            <div id="primary-menu-trigger"><i class="icon-reorder"></i></div>

            <!-- Logo
            ============================================= -->
            <div id="logo">
                <a href="{{ route('home') }}" class="standard-logo" data-dark-logo="{{ (App\Library\Helper::getSettings()['logo'])?App\Library\Helper::getSettings()['logo']:asset(Config('constants.defaultImgPath').'default-logo.png') }}"><img src="{{ (App\Library\Helper::getSettings()['logo'])?App\Library\Helper::getSettings()['logo']:asset(Config('constants.defaultImgPath').'default-logo.png') }}" alt="Logo"></a>

                <a href="{{ route('home') }}" class="retina-logo" data-dark-logo="{{ (App\Library\Helper::getSettings()['logo'])?App\Library\Helper::getSettings()['logo']:asset(Config('constants.defaultImgPath').'default-logo.png') }}"><img src="{{ (App\Library\Helper::getSettings()['logo'])?App\Library\Helper::getSettings()['logo']:asset(Config('constants.defaultImgPath').'default-logo.png') }}" alt="Logo"></a>
                @if(Session::get('login_user_type') == 1)
                <!-- <div class="updateLogoBlack"><a href="#"><i class="fa fa-pencil fa-lg"></i></a></div> -->
                <div class="updateLogo updateLogoBlack"><a href="#"><i class="fa fa-pencil fa-lg"></i></a></div>
                @endif
            </div><!-- #logo end -->

            <!-- Primary Navigation
            ============================================= -->
            <nav id="primary-menu" class="dark">

                <ul>                  
                    <li class="current"><a href="{{route('home')}}"><div>Home</div></a></li>
                    @foreach($menu as $getm)
                    {{ App\Library\Helper::getmenu($getm) }}
                    @endforeach
            
                    @if(count($staticManuPage) >0)
                    @foreach($staticManuPage as $menuPage) 
                    <li><a href="{{route($menuPage->url_key)}}"><div>{{$menuPage->page_name}}</div></a></li>
                    @endforeach
                    @endif
                    <!--<li><a href="{{route('contact-us')}}"><div>Contact</div></a></li>-->
                    @if(Session::get('login_user_type') == 1)
                    <li>
                        <a  href="#"  class="label label-success manageCate nobg mobTextLeft" style="cursor:pointor;"> <div class="black-dashBorder">Manage Categories</div></a>
                    </li>
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
                        <a href="{{ $redirectUrl }}" class="label" target="_blank" style="cursor:pointor;" data-toggle="tooltip" data-placement="bottom" title="Go to Store Admin">  <img src="{{Config('constants.frontendPublicImgPath').'/store-admin-icon-black.png'}}"> <span class="mobDisplay">Go to Store Admin</span></a>
                    </li>
                    @endif
                
                </ul>



                <!-- Top Search
                ============================================= -->
                <div id="top-search">
                    <a href="#" id="top-search-trigger"><i class="icon-search3"></i><i class="icon-line-cross"></i></a>
                    <form  action="{{route('category') }}" method="get">
                        <input type="text" name="searchTerm" class="form-control" value="{{ (Input::get('searchTerm'))?Input::get('searchTerm'):'' }}" placeholder="Type &amp; Hit Enter.." required>
                    </form>
                </div><!-- #top-search end -->


                <div id="top-bar-cart" class="mobileCart">
                    <a href="{{ route('cart') }}" id=""><i class="icon-shopping-cart"></i><span class="shop-cart">{{(Cart::instance("shopping")->count())?Cart::instance("shopping")->count():0}}</span></a>
                </div>

            </nav><!-- #primary-menu end -->

        </div>

    </div>

</header><!-- #header end -->
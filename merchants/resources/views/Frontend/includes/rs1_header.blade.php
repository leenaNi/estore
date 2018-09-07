<link rel="icon" type="image/png" href="images/restro/favicon.png">
<div id="top-bar" class="" style="z-index: 9;">

    <div class="topbar-innerbox clearfix">
        @if(count($contactDetails) >0)
        <div class="col_half nobottommargin">
            @foreach($contactDetails as $contact)
            <p class="nobottommargin"><strong>Call:</strong> {{$contact->phone_no}} | <strong>Email:</strong> {{$contact->email}} </p>
            @endforeach
        </div>
        @endif
        <div class="col_half col_last fright nobottommargin">


            <!-- Top Links
            ============================================= -->
            <div class="top-links">
                <ul>

                    @if(count($socialMedia) >0)
                    <li class="hidden-xs">
                        <div>
                            @foreach($socialMedia as $media)
                            <a href="{{$media->link}}" class="social-icon headsocial-icon si-borderless si-text-color si-{{$media->media}}" title="{{$media->media}}">
                                <i class="icon-{{$media->media}}"></i>
                                <i class="icon-{{$media->media}}"></i>
                            </a>
                            @endforeach
                            <!--								<a href="#" class="social-icon headsocial-icon si-borderless si-text-color si-twitter" title="Twitter">
                                                                                                    <i class="icon-twitter"></i>
                                                                                                    <i class="icon-twitter"></i>
                                                                                            </a>
                                                                                            <a href="#" class="social-icon headsocial-icon si-borderless si-text-color si-gplus" title="Google Plus">
                                                                                                    <i class="icon-gplus"></i>
                                                                                                    <i class="icon-gplus"></i>
                                                                                            </a>-->

                        </div>
                    </li>
                    @endif
                    <li>@if(Session::get('loggedin_user_id'))
                        <a href="{{ route('myProfile')  }}">My Account</a>  <a href="{{ route('logout')  }}">Logout</a>

                        @else
                        <a href="{{ route('loginUser') }}">Login | Register</a>  
                        @endif</li>
                    <li>
                    <li class="">
                        <a href="#" class="label label-success tracking nobg mobilealignmenu" style="cursor:pointor;"> <div>Track Your Order</div></a>
                    </li>
                    <!-- Top Cart
        ============================================= -->
                    <div id="top-bar-cart">
                        <a href="{{route('cart')}}" id=""><i class="icon-shopping-cart"></i><span class="shop-cart">{{(Cart::instance("shopping")->count())?Cart::instance("shopping")->count():0}}</span></a>
                    </div><!-- #top-cart end --></li>
                </ul>
            </div><!-- .top-links end -->

        </div>

    </div>

</div>
<header id="header" class="transparent-header dark sweet full-header no-sticky">

    <div id="header-wrap">

        <div class="container clearfix">

            <div id="primary-menu-trigger"><i class="icon-reorder"></i></div>

            <!-- Logo
            ============================================= -->
            <div id="logo">
                <a href="{{route('home')}}" class="standard-logo" data-dark-logo="{{ (App\Library\Helper::getSettings()['logo'])?App\Library\Helper::getSettings()['logo']:asset(Config('constants.defaultImgPath').'default-logo.png') }}"><img src="{{ (App\Library\Helper::getSettings()['logo'])?App\Library\Helper::getSettings()['logo']:asset(Config('constants.defaultImgPath').'default-logo.png') }}" alt="Logo"></a>

                <a href="{{route('home')}}" class="retina-logo" data-dark-logo="{{ (App\Library\Helper::getSettings()['logo'])?App\Library\Helper::getSettings()['logo']:asset(Config('constants.defaultImgPath').'default-logo.png') }}"><img src="{{ (App\Library\Helper::getSettings()['logo'])?App\Library\Helper::getSettings()['logo']:asset(Config('constants.defaultImgPath').'default-logo.png') }}" alt="Logo"></a>
                @if(Session::get('login_user_type') == 1)
                <div class="updateLogo"><a href="#"><i class="fa fa-pencil fa-lg"></i></a></div>
                @endif
            </div><!-- #logo end -->

            <!-- Primary Navigation
            ============================================= -->
            <nav id="primary-menu">

                <ul>
                    @if(Session::get('login_user_type') == 1)
                    <a  href="#"  class="label label-success manageCate" style="cursor:pointor;"> Manage Categories</a>
                    @endif
                    <li class="current"><a href="{{route('home')}}"><div>Menu</div></a></li>
                    @foreach($menu as $getm)
                    {{ App\Library\Helper::getmenu($getm) }}
                    @endforeach
                    <li><a href="#">Farm to  fork</a></li>    
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">Convenience</a></li>    
                    @if(count($staticManuPage) >0)
                    @foreach($staticManuPage as $menuPage) 
                    <li><a href="{{route($menuPage->url_key)}}"><div>{{$menuPage->page_name}}</div></a></li>
                    @endforeach
                    @endif   
                    <li><a href="#">Reach us</a></li>								
                </ul>

                <!-- Top Search
                ============================================= -->
                <div id="top-search" class="white">
                    <a href="#" id="top-search-trigger"><i class="icon-search3"></i><i class="icon-line-cross"></i></a>
                    <form action="{{route('category') }}" method="get">
                        <input type="text" name="searchTerm" class="form-control" value="{{ (Input::get('searchTerm'))?Input::get('searchTerm'):'' }}" placeholder="Type &amp; Hit Enter.." required>
                    </form>
                </div><!-- #top-search end -->

            </nav><!-- #primary-menu end -->

        </div>

    </div>

</header><!-- #header end -->

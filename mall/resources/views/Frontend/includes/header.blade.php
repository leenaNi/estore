<!-- Top Bar
        ============================================= -->
<div id="top-bar">

    <div class="container clearfix">

        <div class="col_full nobottommargin">

            <!-- Top Links
            ============================================= -->
            <div class="top-links fright">
                <ul>
                    <li><a href="#">About</a></li>
                    <!-- <li><a href="#">FAQs</a></li> -->
                    <li><a href="#">Contact</a></li>

                    @if(Session::get('loggedin_user_id'))
                    <li> <a href="{{route('logoutUser')}}" >Logout</a></li>

                    @else
                    <li><a href="{{ route('loginUser') }}">Login / Register</a></li>
                    @endif
                </ul> 
            </div><!-- .top-links end -->

        </div>
    </div>

</div><!-- #top-bar end -->
<!-- Header
        ============================================= -->

<header id="header" class="box-header">

    <div id="header-wrap">

        <div class="container clearfix">
            <!-- left navbar button -->
            <button class="lno-btn-toggle hidden">
                <span class="fa fa-bars"></span>
            </button>
            <!-- Line left navbar for secondary navbar on small devices -->
            <div class="line-navbar-left hidden">
                <p class="lnl-nav-title">Categories</p>
                <ul class="lnl-nav">
                    <!-- The list will be automatically cloned from mega menu via jQuery -->
                </ul>
            </div> <!-- /.line-navbar-left -->

            <!-- Logo
            ============================================= -->
            <div id="logo">
                <a href="{{ route('home') }}" class="standard-logo" data-dark-logo="{{ (App\Library\Helper::getSettings()['logo'])?App\Library\Helper::getSettings()['logo']:asset(Config('constants.defaultImgPath').'default-logo.png') }}"><img src="{{ (App\Library\Helper::getSettings()['logo'])?App\Library\Helper::getSettings()['logo']:asset(Config('constants.defaultImgPath').'default-logo.png') }}" alt="{{App\Library\Helper::getSettings()['storeName']}}"></a>
                <a href="{{ route('home') }}" class="retina-logo" data-dark-logo="{{ (App\Library\Helper::getSettings()['logo'])?App\Library\Helper::getSettings()['logo']:asset(Config('constants.defaultImgPath').'default-logo.png') }}"><img src="{{ (App\Library\Helper::getSettings()['logo'])?App\Library\Helper::getSettings()['logo']:asset(Config('constants.defaultImgPath').'default-logo.png') }}" alt="{{App\Library\Helper::getSettings()['storeName']}} logo">
                </a>
            </div><!-- #logo end -->

            <!-- Line secondary navbar -->
            <nav class="navbar navbar-static-top line-navbar-two">
                <div class="">
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="line-navbar-collapse-2">
                        <ul class="nav navbar-nav lnt-nav-mega">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                  <!-- <span class="fa fa-dot-circle-o"></span> -->
                                    Shop by Categories
                                    <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu" role="menu">
                                    <div class="lnt-dropdown-mega-menu">
                                        <!-- List of categories -->
                                       
             
                   
                                        <ul class="lnt-category list-unstyled">
                                            <?php
                                           echo App\Library\Helper::getMallMenu($menu);
                                            
                                            ?>
                                            
                                            <li class="active"><a href="#subcategory-fashion">Fashion</a></li>
                                            <li><a href="#subcategory-electronics">Electronics</a></li>
                                            <li><a href="#subcategory-restaurant">Restaurants</a></li>
                                            <li><a href="#subcategory-arts">Arts & Crafts </a></li>
                                            <li><a href="#subcategory-beauty">Beauty & Wellness</a></li>
                                            <li><a href="#subcategory-home">Home Decor</a></li>
                                            <li><a href="#subcategory-gifts">Gifts & Flowers</a></li>
                                            <li><a href="#subcategory-toys">Toys & Sports</a></li>
                                            <li><a href="#subcategory-jewellery">Jewellery</a></li>
                                            <li><a href="#subcategory-kitchen">Kitchen & Homeware</a></li>
                                            <li><a href="#subcategory-footwear">Footwear</a></li>
                                            <li><a href="#subcategory-books">Books & Stationary</a></li>
                                            <li><a href="#subcategory-others">Others</a></li>
                                        </ul>
                                        <!-- Subcategory and carousel wrap -->
                                        <div class="lnt-subcategroy-carousel-wrap container-fluid">
                                            <div id="subcategory-fashion" class="active">
                                                <!-- Sub categories list-->
                                                <div class="lnt-subcategory col-sm-8 col-md-8">
                                                    <h3 class="lnt-category-name">Fashion</h3>
                                                    <ul class="list-unstyled col-sm-6">
                                                        <li><a href="http://google.com/">Category 1</a></li>
                                                        <li><a href="#">Category 2</a></li>
                                                        <li><a href="#">Category 3</a></li>
                                                        <li><a href="#">Category 4</a></li>
                                                        <li><a href="#">Category 5</a></li>
                                                        <li><a href="#">Category 6</a></li>
                                                    </ul>
                                                    <ul class="list-unstyled col-sm-6">
                                                        <li><a href="#">Category 7</a></li>
                                                        <li><a href="#">Category 8</a></li>
                                                        <li><a href="#">Category 9</a></li>
                                                        <li><a href="#">Category 10</a></li>
                                                        <li><a href="#">Category 11</a></li>
                                                        <li><a href="#">Category 12</a></li>
                                                    </ul>
                                                </div>
                                         
                                            </div> <!-- /.subcategory-fashion -->
                                            <div id="subcategory-electronics">
                                                <!-- Sub categories list-->
                                                <div class="lnt-subcategory col-sm-8 col-md-8">
                                                    <h3 class="lnt-category-name">Electronics</h3>
                                                    <ul class="list-unstyled col-sm-6">
                                                        <li><a href="http://google.com/">Category 1</a></li>

                                                        <li><a href="#">Category 2</a></li>
                                                        <li><a href="#">Category 3</a></li>
                                                        <li><a href="#">Category 4</a></li>
                                                        <li><a href="#">Category 5</a></li>
                                                        <li><a href="#">Category 6</a> 
                                                          <!-- <span class="label label-info">Popular</span> -->
                                                        </li>
                                                    </ul>
                                                    <ul class="list-unstyled col-sm-6">
                                                        <li><a href="#">Category 7</a></li>
                                                        <li><a href="#">Category 8</a> 
                                                          <!-- <span class="label label-danger">hot</span> -->
                                                        </li>
                                                        <li><a href="#">Category 9</a></li>
                                                        <li><a href="#">Category 10</a></li>
                                                        <li><a href="#">Category 11</a></li>
                                                        <li><a href="#">Category 12</a></li>

                                                    </ul>
                                                </div>

                                            </div> <!-- /.subcategory-electronics -->
                                            <div id="subcategory-restaurant">
                                                <!-- Sub categories list-->
                                                <div class="lnt-subcategory col-sm-8 col-md-8">
                                                    <h3 class="lnt-category-name">Restaurants</h3>
                                                    <ul class="list-unstyled col-sm-6">
                                                        <li><a href="http://google.com/">Category 1</a></li>

                                                        <li><a href="#">Category 2</a></li>
                                                        <li><a href="#">Category 3</a></li>
                                                        <li><a href="#">Category 4</a></li>
                                                        <li><a href="#">Category 5</a></li>
                                                        <li><a href="#">Category 6</a> 
                                                          <!-- <span class="label label-info">Popular</span> -->
                                                        </li>
                                                    </ul>
                                                    <ul class="list-unstyled col-sm-6">
                                                        <li><a href="#">Category 7</a></li>
                                                        <li><a href="#">Category 8</a> 
                                                          <!-- <span class="label label-danger">hot</span> -->
                                                        </li>
                                                        <li><a href="#">Category 9</a></li>
                                                        <li><a href="#">Category 10</a></li>
                                                        <li><a href="#">Category 11</a></li>
                                                        <li><a href="#">Category 12</a></li>

                                                    </ul>
                                                </div>

                                            </div> <!-- /.subcategory-restaurants -->
                                            <div id="subcategory-arts">
                                                <div class="lnt-subcategory col-sm-8 col-md-8">
                                                    <h3 class="lnt-category-name">Arts & Crafts</h3>
                                                    <ul class="list-unstyled col-sm-6">
                                                        <li><a href="http://google.com/">Category 1</a></li>

                                                        <li><a href="#">Category 2</a></li>
                                                        <li><a href="#">Category 3</a></li>
                                                        <li><a href="#">Category 4</a></li>
                                                        <li><a href="#">Category 5</a></li>
                                                        <li><a href="#">Category 6</a> 
                                                          <!-- <span class="label label-info">Popular</span> -->
                                                        </li>
                                                    </ul>
                                                    <ul class="list-unstyled col-sm-6">
                                                        <li><a href="#">Category 7</a></li>
                                                        <li><a href="#">Category 8</a> 
                                                          <!-- <span class="label label-danger">hot</span> -->
                                                        </li>
                                                        <li><a href="#">Category 9</a></li>
                                                        <li><a href="#">Category 10</a></li>
                                                        <li><a href="#">Category 11</a></li>
                                                        <li><a href="#">Category 12</a></li>

                                                    </ul>
                                                </div>

                                            </div> <!-- /.subcategory-arts & crafts -->
                                            <div id="subcategory-beauty">
                                                <!-- Sub categories list-->
                                                <div class="lnt-subcategory col-sm-8 col-md-8">
                                                    <h3 class="lnt-category-name">Beauty and Wellness</h3>
                                                    <ul class="list-unstyled col-sm-6">
                                                        <li><a href="http://google.com/">Category 1</a></li>

                                                        <li><a href="#">Category 2</a></li>
                                                        <li><a href="#">Category 3</a></li>
                                                        <li><a href="#">Category 4</a></li>
                                                        <li><a href="#">Category 5</a></li>
                                                        <li><a href="#">Category 6</a> 
                                                          <!-- <span class="label label-info">Popular</span> -->
                                                        </li>
                                                    </ul>
                                                    <ul class="list-unstyled col-sm-6">
                                                        <li><a href="#">Category 7</a></li>
                                                        <li><a href="#">Category 8</a> 
                                                          <!-- <span class="label label-danger">hot</span> -->
                                                        </li>
                                                        <li><a href="#">Category 9</a></li>
                                                        <li><a href="#">Category 10</a></li>
                                                        <li><a href="#">Category 11</a></li>
                                                        <li><a href="#">Category 12</a></li>

                                                    </ul>
                                                </div>

                                            </div> <!-- /.subcategory-beauty & wellness -->
                                            <div id="subcategory-home">
                                                <!-- Sub categories list-->
                                                <div class="lnt-subcategory col-sm-8 col-md-8">
                                                    <h3 class="lnt-category-name">Home Decor</h3>
                                                    <ul class="list-unstyled col-sm-6">
                                                        <li><a href="http://google.com/">Category 1</a></li>

                                                        <li><a href="#">Category 2</a></li>
                                                        <li><a href="#">Category 3</a></li>
                                                        <li><a href="#">Category 4</a></li>
                                                        <li><a href="#">Category 5</a></li>
                                                        <li><a href="#">Category 6</a> 
                                                          <!-- <span class="label label-info">Popular</span> -->
                                                        </li>
                                                    </ul>
                                                    <ul class="list-unstyled col-sm-6">
                                                        <li><a href="#">Category 7</a></li>
                                                        <li><a href="#">Category 8</a> 
                                                          <!-- <span class="label label-danger">hot</span> -->
                                                        </li>
                                                        <li><a href="#">Category 9</a></li>
                                                        <li><a href="#">Category 10</a></li>
                                                        <li><a href="#">Category 11</a></li>
                                                        <li><a href="#">Category 12</a></li>

                                                    </ul>
                                                </div>

                                            </div> <!-- /.category-home decor -->

                                            <div id="subcategory-gifts">
                                                <!-- Sub categories list-->
                                                <div class="lnt-subcategory col-sm-8 col-md-8">
                                                    <h3 class="lnt-category-name">Gifts & Flowers</h3>
                                                    <ul class="list-unstyled col-sm-6">
                                                        <li><a href="http://google.com/">Category 1</a></li>

                                                        <li><a href="#">Category 2</a></li>
                                                        <li><a href="#">Category 3</a></li>
                                                        <li><a href="#">Category 4</a></li>
                                                        <li><a href="#">Category 5</a></li>
                                                        <li><a href="#">Category 6</a> 
                                                          <!-- <span class="label label-info">Popular</span> -->
                                                        </li>
                                                    </ul>
                                                    <ul class="list-unstyled col-sm-6">
                                                        <li><a href="#">Category 7</a></li>
                                                        <li><a href="#">Category 8</a> 
                                                          <!-- <span class="label label-danger">hot</span> -->
                                                        </li>
                                                        <li><a href="#">Category 9</a></li>
                                                        <li><a href="#">Category 10</a></li>
                                                        <li><a href="#">Category 11</a></li>
                                                        <li><a href="#">Category 12</a></li>

                                                    </ul>
                                                </div>
                                            </div> <!-- /.subcategory-gifts & flowers -->
                                            <div id="subcategory-toys">
                                                <!-- Sub categories list-->
                                                <div class="lnt-subcategory col-sm-8 col-md-8">
                                                    <h3 class="lnt-category-name">Toys & Sports</h3>
                                                    <ul class="list-unstyled col-sm-6">
                                                        <li><a href="http://google.com/">Category 1</a></li>

                                                        <li><a href="#">Category 2</a></li>
                                                        <li><a href="#">Category 3</a></li>
                                                        <li><a href="#">Category 4</a></li>
                                                        <li><a href="#">Category 5</a></li>
                                                        <li><a href="#">Category 6</a> 
                                                          <!-- <span class="label label-info">Popular</span> -->
                                                        </li>
                                                    </ul>
                                                    <ul class="list-unstyled col-sm-6">
                                                        <li><a href="#">Category 7</a></li>
                                                        <li><a href="#">Category 8</a> 
                                                          <!-- <span class="label label-danger">hot</span> -->
                                                        </li>
                                                        <li><a href="#">Category 9</a></li>
                                                        <li><a href="#">Category 10</a></li>
                                                        <li><a href="#">Category 11</a></li>
                                                        <li><a href="#">Category 12</a></li>

                                                    </ul>
                                                </div>

                                            </div> <!-- /.subcategory-toys & sports -->

                                            <div id="subcategory-jewellery">
                                                <!-- Sub categories list-->
                                                <div class="lnt-subcategory col-sm-8 col-md-8">
                                                    <h3 class="lnt-category-name">Jewellery</h3>
                                                    <ul class="list-unstyled col-sm-6">
                                                        <li><a href="http://google.com/">Category 1</a></li>

                                                        <li><a href="#">Category 2</a></li>
                                                        <li><a href="#">Category 3</a></li>
                                                        <li><a href="#">Category 4</a></li>
                                                        <li><a href="#">Category 5</a></li>
                                                        <li><a href="#">Category 6</a> 
                                                          <!-- <span class="label label-info">Popular</span> -->
                                                        </li>
                                                    </ul>
                                                    <ul class="list-unstyled col-sm-6">
                                                        <li><a href="#">Category 7</a></li>
                                                        <li><a href="#">Category 8</a> 
                                                          <!-- <span class="label label-danger">hot</span> -->
                                                        </li>
                                                        <li><a href="#">Category 9</a></li>
                                                        <li><a href="#">Category 10</a></li>
                                                        <li><a href="#">Category 11</a></li>
                                                        <li><a href="#">Category 12</a></li>

                                                    </ul>
                                                </div>

                                            </div> <!-- /.subcategory-jewellery -->

                                            <div id="subcategory-kitchen">
                                                <!-- Sub categories list-->
                                                <div class="lnt-subcategory col-sm-8 col-md-8">
                                                    <h3 class="lnt-category-name">Kitchen & Homeware</h3>
                                                    <ul class="list-unstyled col-sm-6">
                                                        <li><a href="http://google.com/">Category 1</a></li>

                                                        <li><a href="#">Category 2</a></li>
                                                        <li><a href="#">Category 3</a></li>
                                                        <li><a href="#">Category 4</a></li>
                                                        <li><a href="#">Category 5</a></li>
                                                        <li><a href="#">Category 6</a> 
                                                          <!-- <span class="label label-info">Popular</span> -->
                                                        </li>
                                                    </ul>
                                                    <ul class="list-unstyled col-sm-6">
                                                        <li><a href="#">Category 7</a></li>
                                                        <li><a href="#">Category 8</a> 
                                                          <!-- <span class="label label-danger">hot</span> -->
                                                        </li>
                                                        <li><a href="#">Category 9</a></li>
                                                        <li><a href="#">Category 10</a></li>
                                                        <li><a href="#">Category 11</a></li>
                                                        <li><a href="#">Category 12</a></li>

                                                    </ul>
                                                </div>

                                            </div> <!-- /.subcategory-kitchen & homeware -->

                                            <div id="subcategory-footwear">
                                                <!-- Sub categories list-->
                                                <div class="lnt-subcategory col-sm-8 col-md-8">
                                                    <h3 class="lnt-category-name">Footwear</h3>
                                                    <ul class="list-unstyled col-sm-6">
                                                        <li><a href="http://google.com/">Category 1</a></li>

                                                        <li><a href="#">Category 2</a></li>
                                                        <li><a href="#">Category 3</a></li>
                                                        <li><a href="#">Category 4</a></li>
                                                        <li><a href="#">Category 5</a></li>
                                                        <li><a href="#">Category 6</a> 
                                                          <!-- <span class="label label-info">Popular</span> -->
                                                        </li>
                                                    </ul>
                                                    <ul class="list-unstyled col-sm-6">
                                                        <li><a href="#">Category 7</a></li>
                                                        <li><a href="#">Category 8</a> 
                                                          <!-- <span class="label label-danger">hot</span> -->
                                                        </li>
                                                        <li><a href="#">Category 9</a></li>
                                                        <li><a href="#">Category 10</a></li>
                                                        <li><a href="#">Category 11</a></li>
                                                        <li><a href="#">Category 12</a></li>

                                                    </ul>
                                                </div>

                                            </div> <!-- /.subcategory-footwear -->

                                            <div id="subcategory-books">
                                                <!-- Sub categories list-->
                                                <div class="lnt-subcategory col-sm-8 col-md-8">
                                                    <h3 class="lnt-category-name">Books & Stationary</h3>
                                                    <ul class="list-unstyled col-sm-6">
                                                        <li><a href="http://google.com/">Category 1</a></li>

                                                        <li><a href="#">Category 2</a></li>
                                                        <li><a href="#">Category 3</a></li>
                                                        <li><a href="#">Category 4</a></li>
                                                        <li><a href="#">Category 5</a></li>
                                                        <li><a href="#">Category 6</a> 
                                                          <!-- <span class="label label-info">Popular</span> -->
                                                        </li>
                                                    </ul>
                                                    <ul class="list-unstyled col-sm-6">
                                                        <li><a href="#">Category 7</a></li>
                                                        <li><a href="#">Category 8</a> 
                                                          <!-- <span class="label label-danger">hot</span> -->
                                                        </li>
                                                        <li><a href="#">Category 9</a></li>
                                                        <li><a href="#">Category 10</a></li>
                                                        <li><a href="#">Category 11</a></li>
                                                        <li><a href="#">Category 12</a></li>

                                                    </ul>
                                                </div>

                                            </div> <!-- /.subcategory-books & stationary -->
                                            <div id="subcategory-others">
                                                <!-- Sub categories list-->
                                                <div class="lnt-subcategory col-sm-8 col-md-8">
                                                    <h3 class="lnt-category-name">Others</h3>
                                                    <ul class="list-unstyled col-sm-6">
                                                        <li><a href="http://google.com/">Category 1</a></li>

                                                        <li><a href="#">Category 2</a></li>
                                                        <li><a href="#">Category 3</a></li>
                                                        <li><a href="#">Category 4</a></li>
                                                        <li><a href="#">Category 5</a></li>
                                                        <li><a href="#">Category 6</a> 
                                                          <!-- <span class="label label-info">Popular</span> -->
                                                        </li>
                                                    </ul>
                                                    <ul class="list-unstyled col-sm-6">
                                                        <li><a href="#">Category 7</a></li>
                                                        <li><a href="#">Category 8</a> 
                                                          <!-- <span class="label label-danger">hot</span> -->
                                                        </li>
                                                        <li><a href="#">Category 9</a></li>
                                                        <li><a href="#">Category 10</a></li>
                                                        <li><a href="#">Category 11</a></li>
                                                        <li><a href="#">Category 12</a></li>

                                                    </ul>
                                                </div>

                                            </div> <!-- /.subcategory-others -->

                                        </div> <!-- /.lnt-subcategroy-carousel-wrap -->
                                    </div> <!-- /.lnt-dropdown-mega-menu -->
                                </div> <!-- /.dropdown-menu -->
                            </li> <!-- /.dropdown -->
                        </ul> <!-- /.lnt-nav-mega -->
                        <form class="navbar-form navbar-left lnt-search-form" role="search">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-btn lnt-search-category">
                                        <button type="button" class="btn btn-default dropdown-toggle selected-category-btn" data-toggle="dropdown" aria-expanded="false">
                                            <span class="selected-category-text">All </span>
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="#">Fashion</a></li>
                                            <li><a href="#">Electronics</a></li>
                                            <li><a href="#">Restaurants</a></li>
                                            <li><a href="#">Arts & Crafts</a></li>
                                            <li><a href="#">Beauty & Wellness</a></li>
                                            <li><a href="#">Home Decor</a></li>
                                            <li><a href="#">Gifts & Flowers</a></li>
                                            <li><a href="#">Toys & Sports</a></li>
                                            <li><a href="#">Jewellery</a></li>
                                            <li><a href="#">Kitchen & Homeware</a></li>
                                            <li><a href="#">Footwear</a></li>
                                            <li><a href="#">Books & Stationary</a></li>
                                            <li><a href="#">Others</a></li>
                                        </ul>
                                    </div><!-- /btn-group -->
                                    <input type="text" class="form-control lnt-search-input" aria-label="Search" placeholder="Search here...">
                                </div><!-- /input-group -->
                            </div>

                            <button type="submit" class="btn btn-search"><span class="fa fa-search"></span></button>
                        </form> <!-- /.lnt-search-form -->
                        <ul class="nav navbar-nav navbar-right lnt-shopping-cart">
                            <li class="">
                                <div id="top-cart">
                                    <a href="{{ route('cart') }}"><i class="icon-shopping-cart"></i><span  class="shop-cart">{{(Cart::instance("shopping")->count())?Cart::instance("shopping")->count():0}}</span></a>
                                </div>
                            </li>
                        </ul> <!-- /.lnt-shopping-cart -->
                    </div> <!-- /.navbar-collapse -->
                </div> <!-- /.container -->
            </nav> <!-- /.line-navbar-two -->

        </div>

    </div>

</header><!-- #header end --><!-- #header end -->

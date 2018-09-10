<!-- Header
        ============================================= -->
<style>
    @media (max-width: 991px){
        #primary-menu-trigger {
            color: #fff !important;
        }
    }
</style>
<?php session_start(); ?>
<header id="header" class="transparent-header full-header" data-sticky-class="dark" style="background: #000;">
    <?php //print_r($_GET['link']); ?>
    <!--<div class="applyTheme-stickyHeader"><div class="text-center">If you wish to apply theme please <a href="#" data-mId="2" class="applythemelink">click here</a><a href="#" class="applyTheme"><div> Apply Theme</div></a></div></div>-->
    <?php //} ?>
    <div id="header-wrap">
        <div class="container clearfix">
            <div id="primary-menu-trigger"><i class="icon-reorder"></i></div>
            <!-- Logo
            ============================================= -->
            <div id="logo">
                <a href="#" class="standard-logo" data-dark-logo="images/logo.png"><img src="images/logo.png" alt="Veestores Logo"></a>

                <a href="#" class="retina-logo" data-dark-logo="images/logo.png"><img src="images/logo.png" alt="Veestores Logo"></a>
            </div><!-- #logo end -->
            <!-- Primary Navigation
            ============================================= -->
            <nav id="primary-menu" class="white">
                <ul>
                    <li class="current"><a href="#"><div>Home</div></a></li>
                    <li><a href="fs1_product_listing.php"><div>Shirts</div></a>
                        <ul class="submenulisting">
                            <li><a href="fs1_product_listing.php"><div>Formal</div></a></li>
                            <li><a href="fs1_product_listing.php"><div>Casual</div></a></li>
                            <li><a href="fs1_product_listing.php"><div>Party Wear</div></a></li>
                            <li><a href="fs1_product_listing.php"><div>Half Sleeves</div></a></li>
                        </ul>							
                    </li>
                    <li><a href="fs1_product_listing.php"><div>T-Shirts</div></a>
                        <ul class="submenulisting">
                            <li><a href="fs1_product_listing.php"><div>Polo</div></a></li>
                            <li><a href="fs1_product_listing.php"><div>Graphic</div></a></li>
                            <li><a href="fs1_product_listing.php"><div>Full Sleeves</div></a></li>
                        </ul></li>
                    <li><a href="about-us.php"><div>About</div></a></li>
                    <li><a href="contact-us.php"><div>Contact</div></a></li>
                    <li><a href="login-register.php"><div>Login / Register</div></a></li>
                    <!-- <li><a href="http://infini.net.in/veestore/congrats.php" class="thmbtn"><div> Apply Theme</div></a></li> -->
                </ul>
                <!-- Top Cart
                ============================================= -->
                <div id="top-cart" class="white">
                    <a href="cart.php"><i class="icon-shopping-cart"></i><span>1</span></a>
                </div><!-- #top-cart end -->
                <!-- Top Search
                ============================================= -->
                <div id="top-search" class="white">
                    <a href="#" id="top-search-trigger"><i class="icon-search3"></i><i class="icon-line-cross"></i></a>
                    <form action="#" method="get">
                        <input type="text" name="q" class="form-control" value="" placeholder="Type &amp; Hit Enter..">
                    </form>
                </div><!-- #top-search end -->
            </nav><!-- #primary-menu end -->
        </div>
    </div>
</header><!-- #header end -->
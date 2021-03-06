<!DOCTYPE html>
<html dir="ltr" lang="en-US">
    <head>


        <?php include( 'includes/head.php'); ?>
    </head>

    <body class="stretched">

        <!-- Document Wrapper
        ============================================= -->
        <div id="wrapper" class="clearfix">

            <?php include( 'includes/header_style2.php'); ?>

            <div class="container clearfix topmargin-sm">

                <div class="col_three_fourth nobottommargin">

                    <div class="fslider" data-arrows="false">
                        <div class="flexslider">
                            <div class="slider-wrap">
                                <div class="slide">
                                    <a href="#"> <img src="images/kitchen-homeware/slider/1.jpg" alt="Shop Image"> 
                                        <div class="flex-caption">
                                            <h2>The kitchen is the art of the HOME</h2>
                                        </div></a>
                                </div>
                                <div class="slide">
                                    <a href="#"> <img src="images/kitchen-homeware/slider/2.jpg" alt="Shop Image"> 
                                        <div class="flex-caption">
                                            <h2>Home is where your heart is</h2>
                                        </div></a>
                                </div>
                                <div class="slide">
                                    <a href="#"> <img src="images/kitchen-homeware/slider/3.jpg" alt="Shop Image"> 
                                        <div class="flex-caption">
                                            <h2>Vintage is the new saga</h2>
                                        </div></a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col_one_fourth nobottommargin col_last">

                    <div class="col_full bottommargin-26">
                        <a href="#"><img src="images/kitchen-homeware/featurebox/1.jpg" alt="">
                        </a>
                        <div class="overlayContentBox">
                            <div>
                                <h3 class="nobottommargin text-center">Cutlery</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col_full bottommargin-26">
                        <a href="#"><img src="images/kitchen-homeware/featurebox/2.jpg" alt="">
                        </a>
                        <div class="overlayContentBox">
                            <div>
                                <h3 class="nobottommargin text-center">Bedsheets</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col_full bottommargin-sm">
                        <a href="#"><img src="images/kitchen-homeware/featurebox/3.jpg" alt="">
                        </a>
                        <div class="overlayContentBox">
                            <div>
                                <h3 class="nobottommargin text-center">Curtains</h3>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="clear"></div>

            </div>



            <!-- Content
            ============================================= -->
            <section id="content">

                <div class="content-wrap">
                    <div class="container clearfix">
                        <div class="fancy-title title-bottom-border">
                            <h3>Trending Products</h3>
                        </div>
                        <div id="shop" class="shop clearfix">
                            <div class="product clearfix product-item productbox">
                                <div class="product-image">
                                    <a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>"><img src="images/kitchen-homeware/products/default-product.jpg" alt="">
                                    </a>
                                    <div class="product-overlay2">
                                        <a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>" class="center-icon"><i class="icon-line-plus"></i></a>

                                    </div>
                                </div>
                                <div class="product-desc product-desc-transparent">
                                    <div class="product-title"><h3><a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>">Your Product Name</a></h3></div>
                                    <div class="product-price"><del><i class="icon-rupee"></i> 499</del> <ins><i class="icon-rupee"></i> 399</ins></div>
                                </div>
                                <div class="add-to-cart-btn">
                                    <a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>" class="button button-grey full-width-btn"><span>View Detail</span></a>
                                </div>
                            </div>



                        </div>
                    </div>
                    <div class="section footer-touch">
                        <h4 class="uppercase center">Testimonials</h4>
                        <div class="fslider testimonial testimonial-full bottommargin" data-animation="fade" data-arrows="false">
                            <div class="flexslider">
                                <div class="slider-wrap">
                                    <div class="slide">
                                        <div class="testi-image">
                                            <a href="#"><img src="images/default-female.png" alt="Customer Testimonails"></a>
                                        </div>
                                        <div class="testi-content">
                                            <p>Similique fugit repellendus expedita excepturi iure perferendis provident quia eaque. Repellendus, vero numquam?</p>
                                            <div class="testi-meta">
                                                XYZ, Super Market
                                            </div>
                                        </div>
                                    </div>
                                    <div class="slide">
                                        <div class="testi-image">
                                            <a href="#"><img src="images/default-male.png" alt="Customer Testimonails"></a>
                                        </div>
                                        <div class="testi-content">
                                            <p>Quod necessitatibus quis expedita harum provident eos obcaecati id culpa corporis molestias.</p>
                                            <div class="testi-meta">
                                                ABC, Infini
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </section><!-- #content end -->

            <?php include( 'includes/footer_style2.php'); ?> </div>

    </div><!-- #wrapper end -->

    <?php include( 'includes/foot.php'); ?> 

</body>
</html>
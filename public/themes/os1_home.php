<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<?php include( 'includes/head.php'); ?>

<body class="stretched">
  <!-- Document Wrapper
	============================================= -->
  <div id="wrapper" class="clearfix">
    <?php include( 'includes/header_style1.php'); ?>
    <section id="slider" class="slider-parallax full-screen clearfix">
      <div class="slider-parallax-inner">
        <div class="fslider" data-arrows="true" data-pagi="false">
          <div class="flexslider">
            <div class="slider-wrap">
              <div class="slide">
                <a href="#"> <img src="images/others/slider/1.jpg" alt="Shop Image"> 
                <div class="flex-caption">
                                <h2>Design to match your style</h2>
                            </div></a>
              </div>
              <div class="slide">
                <a href="#"> <img src="images/others/slider/2.jpg" alt="Shop Image"> 
                <div class="flex-caption">
                                <h2>Go crazy</h2>
                            </div></a>
              </div>
              <div class="slide">
                <a href="#"> <img src="images/others/slider/3.jpg" alt="Shop Image"> 
                <div class="flex-caption">
                                <h2>Eyes are gifts, so we protect them</h2>
                            </div></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <div class="clearfix"></div>
    <!-- Content
		============================================= -->
    <section id="content">
      <div class="content-wrap">
        <div class="container clearfix">
          <div class="col_one_third">
            <a href="#"><img src="images/others/featurebox/1.jpg" alt="">
            </a>
            <div class="overlayContentBox">
                    <div>
                        <h3 class="nobottommargin text-center">Sunglasses 20% off</h3>
                    </div>
                </div>
          </div>
          <div class="col_one_third">
            <a href="#"><img src="images/others/featurebox/2.jpg" alt="">
            </a>
            <div class="overlayContentBox">
                    <div>
                        <h3 class="nobottommargin text-center">Frames under 999/-</h3>
                    </div>
                </div>
          </div>
          <div class="col_one_third col_last">
            <a href="#"><img src="images/others/featurebox/3.jpg" alt="">
            </a>
            <div class="overlayContentBox">
                    <div>
                        <h3 class="nobottommargin text-center">Best Sellers</h3>
                    </div>
                </div>
          </div>
        </div>
        <div class="container clearfix">
          <div class="fancy-title title-dotted-border title-center">
            <h3>Trending</h3> </div>
          <div id="shop" class="shop clearfix">
            <div class="product clearfix">
              <div class="product-image producImgBoxSize_4Col">
                <a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>"><img src="images/others/products/default-product.jpg" alt="">
                </a>
                <div class="product-overlay"> <a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>" class="add-to-cart"><i class="icon-eye"></i><span> View Details</span></a></div>
              </div>
              <div class="product-desc">
                <div class="product-title">
                  <h3><a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>">Your Product Name</a></h3>
                </div>
                <div class="product-price"><del><i class="icon-rupee"></i> 499</del> <ins><i class="icon-rupee"></i> 399</ins>
                </div>
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

      </div>
        
    </section>
    <!-- #content end -->
    <?php include( 'includes/footer_style1.php'); ?> </div>
    <!-- #wrapper end -->
    <?php include( 'includes/foot.php'); ?> </body>

</html>
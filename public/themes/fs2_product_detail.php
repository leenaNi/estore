<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<?php include( 'includes/head.php'); ?>

<body class="stretched">
  <!-- Document Wrapper
	============================================= -->
  <div id="wrapper" class="clearfix">
    <?php include( 'includes/header_style2.php'); ?>
    <!-- Content
		============================================= -->
    <section id="content">
      <div class="content-wrap">
        <div class="container clearfix">
          <div class="single-product">
            <div class="product">
              <div class="col_half">
                <!-- Product Single - Gallery
								============================================= -->
                <div class="product-image">
                  <div class="fslider" data-pagi="false" data-autoplay="false" data-arrows="false" data-thumbs="true">
                    <div class="flexslider">
                      <div class="slider-wrap" data-lightbox="gallery" style="width:100% !important;">
                        <div class="slide" data-thumb="images/fashion/products/default-product.jpg">
                          <a href="images/fashion/products/default-product.jpg" title="" data-lightbox="gallery-item"><img src="images/fashion/products/default-product.jpg" alt="" class="zoom-me zoom-me1" data-zoom-image="images/fashion/products/default-product.jpg"> </a>
                        </div>
                        <div class="slide" data-thumb="images/fashion/products/default-product.jpg">
                          <a href="images/fashion/products/default-product.jpg" title="" data-lightbox="gallery-item"><img src="images/fashion/products/default-product.jpg" alt="" class="zoom-me zoom-me1" data-zoom-image="images/fashion/products/default-product.jpg"> </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Product Single - Gallery End -->
              </div>
              <div class="col_last col_half product-desc">
                <h1 class="product_title">Your Product Name</h1>
                <div class="product-rating">
                  <p>PRODUCT CODE: BAER 0045</p>
                </div>
                <div class="product-price"> <del><i class="icon-rupee"></i>  499</del> <ins><i class="icon-rupee"></i>  399</ins></div> <span class="span2" style="color:red;">STOCK LEFT - 6</span>
                <div class="clear"></div>
                <div class="line"></div>
                <!-- Product Single - Quantity & Cart Button
								============================================= -->
                <form class="cart nobottommargin clearfix" method="post" enctype='multipart/form-data'>
                  <div class="quantity clearfix">
                    <input type="button" value="-" class="minus">
                    <input type="text" step="1" min="1" name="quantity" value="1" title="Qty" class="qty" size="4" />
                    <input type="button" value="+" class="plus"> </div>
                  <a class="add-to-cart button nomargin" onclick="location.href='cart.php';">Add to cart</a>
                  <button type="submit" class="add-to-cart button nomargin"><i class="icon-heart" style="margin-right:0px;"></i></button>
                </form>
                <!-- Product Single - Quantity & Cart Button End -->
                <div class="clear"></div>
                <div class="line"></div>
                <!-- Product Single - Short Description
								============================================= -->
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero velit id eaque ex quae laboriosam nulla optio doloribus! Perspiciatis, libero, neque, perferendis at nisi optio dolor!</p>
              
                <div class="line"></div>
                <div class="clear"></div>
                <!-- Product Single - Share
								============================================= -->
                <div class="si-share noborder clearfix"> <span class="pull-left">Share:</span>
                  <div class="pull-left">
                    <a href="#" class="social-icon si-borderless si-facebook"> <i class="icon-facebook"></i> <i class="icon-facebook"></i> </a>
                    <a href="#" class="social-icon si-borderless si-twitter"> <i class="icon-twitter"></i> <i class="icon-twitter"></i> </a>
                    <a href="#" class="social-icon si-borderless si-pinterest"> <i class="icon-pinterest"></i> <i class="icon-pinterest"></i> </a>
                    <a href="#" class="social-icon si-borderless si-gplus"> <i class="icon-gplus"></i> <i class="icon-gplus"></i> </a>
                    <a href="#" class="social-icon si-borderless si-rss"> <i class="icon-rss"></i> <i class="icon-rss"></i> </a>
                    <a href="#" class="social-icon si-borderless si-email3"> <i class="icon-email3"></i> <i class="icon-email3"></i> </a>
                  </div>
                </div>
                <!-- Product Single - Share End -->
              </div>
              <div class="col_full nobottommargin">
                <div class="tabs clearfix nobottommargin ui-tabs ui-widget ui-widget-content ui-corner-all" id="tab-1" style="border: 0px;">
                                    <ul class="tab-nav clearfix ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" role="tablist" style="background: #fff; border: 0px; border-bottom: 1px solid #ddd;">
                                        <li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active" role="tab" tabindex="0" aria-controls="tabs-1" aria-labelledby="ui-id-1" aria-selected="true" aria-expanded="true"><a href="#tabs-1" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-1"><span>Additional Description</span></a> </li></li> 
                                    </ul>
                                    <div class="tab-container">
                                        <div class="tab-content tabBox clearfix ui-tabs-panel ui-widget-content ui-corner-bottom" id="tabs-1" aria-labelledby="ui-id-1" role="tabpanel" aria-hidden="false">
                                            <div>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero velit id eaque ex quae laboriosam nulla optio doloribus! Perspiciatis, libero, neque, perferendis at nisi optio dolor!</div>                                     
                                        </div>
                                    </div>
                                </div>
              </div>
            </div>
          </div>
          <div class="clear"></div>
          <div class="line"></div>
          <div class="col_full nobottommargin">
            <h4>Related Products</h4>
            <div id="oc-product" class="owl-carousel product-carousel carousel-widget" data-margin="30" data-pagi="false" data-autoplay="5000" data-items-xxs="1" data-items-sm="2" data-items-md="3" data-items-lg="4">
              <div class="oc-item">
                <div class="product clearfix mobwidth100 relatedProduct">
                <div class="product-image">
										<a href="fs2_product_detail.php"><img src="images/fashion/products/default-product.jpg" alt="">
                </a>
											<div class="product-overlay2">
											<a href="fs2_product_detail.php" class="center-icon"><i class="icon-line-plus"></i></a>
											
											</div>
										</div>
										<div class="product-desc product-desc-transparent">
											<div class="product-title"><h3><a href="fs2_product_detail.php">Your Product Name</a></h3></div>
											<div class="product-price"><del><i class="icon-rupee"></i>  499</del> <ins><i class="icon-rupee"></i>  399</ins></div>
										</div>
											<div class="add-to-cart-btn">
												<a href="fs2_product_detail.php" class="button button-grey full-width-btn"><span>View Detail</span></a>
											</div>
                </div>
              </div>
              <div class="oc-item">
                <div class="product clearfix mobwidth100 relatedProduct">
                <div class="product-image">
										<a href="fs2_product_detail.php"><img src="images/fashion/products/default-product.jpg" alt="">
                </a>
											<div class="product-overlay2">
											<a href="fs2_product_detail.php" class="center-icon"><i class="icon-line-plus"></i></a>
											
											</div>
										</div>
										<div class="product-desc product-desc-transparent">
											<div class="product-title"><h3><a href="fs2_product_detail.php">Your Product Name</a></h3></div>
											<div class="product-price"><del><i class="icon-rupee"></i>  499</del> <ins><i class="icon-rupee"></i>  399</ins></div>
										</div>
											<div class="add-to-cart-btn">
												<a href="fs2_product_detail.php" class="button button-grey full-width-btn"><span>View Detail</span></a>
											</div>
                </div>
              </div>
              <div class="oc-item">
                <div class="product clearfix mobwidth100 relatedProduct">
                <div class="product-image">
										<a href="fs2_product_detail.php"><img src="images/fashion/products/default-product.jpg" alt="">
                </a>
											<div class="product-overlay2">
											<a href="fs2_product_detail.php" class="center-icon"><i class="icon-line-plus"></i></a>
											
											</div>
										</div>
										<div class="product-desc product-desc-transparent">
											<div class="product-title"><h3><a href="fs2_product_detail.php">Your Product Name</a></h3></div>
											<div class="product-price"><del><i class="icon-rupee"></i>  499</del> <ins><i class="icon-rupee"></i>  399</ins></div>
										</div>
											<div class="add-to-cart-btn">
												<a href="fs2_product_detail.php" class="button button-grey full-width-btn"><span>View Detail</span></a>
											</div>
                </div>
              </div>
              <div class="oc-item">
                <div class="product clearfix mobwidth100 relatedProduct">
                <div class="product-image">
										<a href="fs2_product_detail.php"><img src="images/fashion/products/default-product.jpg" alt="">
                </a>
											<div class="product-overlay2">
											<a href="fs2_product_detail.php" class="center-icon"><i class="icon-line-plus"></i></a>
											
											</div>
										</div>
										<div class="product-desc product-desc-transparent">
											<div class="product-title"><h3><a href="fs2_product_detail.php">Your Product Name</a></h3></div>
											<div class="product-price"><del><i class="icon-rupee"></i>  499</del> <ins><i class="icon-rupee"></i>  399</ins></div>
										</div>
											<div class="add-to-cart-btn">
												<a href="fs2_product_detail.php" class="button button-grey full-width-btn"><span>View Detail</span></a>
											</div>
                </div>
              </div>
              <div class="oc-item">
                <div class="product clearfix mobwidth100 relatedProduct">
                <div class="product-image">
										<a href="fs2_product_detail.php"><img src="images/fashion/products/default-product.jpg" alt="">
                </a>
											<div class="product-overlay2">
											<a href="fs2_product_detail.php" class="center-icon"><i class="icon-line-plus"></i></a>
											
											</div>
										</div>
										<div class="product-desc product-desc-transparent">
											<div class="product-title"><h3><a href="fs2_product_detail.php">Your Product Name</a></h3></div>
											<div class="product-price"><del><i class="icon-rupee"></i>  499</del> <ins><i class="icon-rupee"></i>  399</ins></div>
										</div>
											<div class="add-to-cart-btn">
												<a href="fs2_product_detail.php" class="button button-grey full-width-btn"><span>View Detail</span></a>
											</div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>
    <!-- #content end -->
    <?php include( 'includes/footer_style2.php'); ?> </div>
    <!-- #wrapper end -->
    <?php include( 'includes/foot.php'); ?> </body>

</html>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<?php include( 'includes/head.php'); ?>

<body class="stretched">
  <!-- Document Wrapper
	============================================= -->
  <div id="wrapper" class="clearfix">
  <?php
    if($_GET['theme'] == 'fs1' ||  $_GET['theme'] == 'fs3' || $_GET['theme'] == 'ac1' ||  $_GET['theme'] == 'ac3' ||  $_GET['theme'] == 'bs1' ||  $_GET['theme'] == 'bs3' ||  $_GET['theme'] == 'bw1' ||  $_GET['theme'] == 'bw3' ||  $_GET['theme'] == 'el1' ||  $_GET['theme'] == 'el3' ||  $_GET['theme'] == 'fg1' ||  $_GET['theme'] == 'fg3' ||  $_GET['theme'] == 'ft1' ||  $_GET['theme'] == 'ft3' ||  $_GET['theme'] == 'hd1' ||  $_GET['theme'] == 'hd3' ||  $_GET['theme'] == 'jw1' ||  $_GET['theme'] == 'jw3' ||  $_GET['theme'] == 'kh1' ||  $_GET['theme'] == 'kh3' ||  $_GET['theme'] == 'os1' ||  $_GET['theme'] == 'os3' ||  $_GET['theme'] == 'rs1' ||  $_GET['theme'] == 'rs3' ||  $_GET['theme'] == 'ts1' ||  $_GET['theme'] == 'ts3')
    include( 'includes/header_style1.php');

    if($_GET['theme'] == 'fs2' || $_GET['theme'] == 'ac2' ||  $_GET['theme'] == 'bs2' ||  $_GET['theme'] == 'bw2' ||  $_GET['theme'] == 'el2' ||  $_GET['theme'] == 'fg2' ||  $_GET['theme'] == 'ft2' ||  $_GET['theme'] == 'hd2' ||  $_GET['theme'] == 'jw2' ||  $_GET['theme'] == 'kh2' ||  $_GET['theme'] == 'os2' ||  $_GET['theme'] == 'rs2' ||  $_GET['theme'] == 'ts2')
    include( 'includes/header_style2.php');
     ?>
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
                        <div class="slide" data-thumb="images/fash/products/default-product.jpg">
                          <a href="images/fash/products/default-product.jpg" title="" data-lightbox="gallery-item"><img src="images/fash/products/default-product.jpg" alt="" class="zoom-me zoom-me1" data-zoom-image="images/fash/products/default-product.jpg"> </a>
                        </div>
                        <div class="slide" data-thumb="images/fash/products/default-product.jpg">
                          <a href="images/fash/products/default-product.jpg" title="" data-lightbox="gallery-item"><img src="images/fash/products/default-product.jpg" alt="" class="zoom-me zoom-me1" data-zoom-image="images/fash/products/default-product.jpg"> </a>
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
                <div class="product-price prodDetailPrice"> <del><i class="icon-rupee"></i> 499</del> <ins><i class="icon-rupee"></i> 399</ins></div> <span class="span2" style="color:red;">STOCK LEFT - 6</span>
                <div class="clear"></div>
                <div class="line"></div>
                <!-- Product Single - Quantity & Cart Button
								============================================= -->
                <form class="cart nobottommargin clearfix" method="post" enctype='multipart/form-data'>
                  <div class="quantity clearfix mobMB15">
                    <input type="button" value="-" class="minus">
                    <input type="text" step="1" min="1" name="quantity" value="1" title="Qty" class="qty" size="4" />
                    <input type="button" value="+" class="plus"> </div>
                  <a class="add-to-cart button nomargin addToCartB addToCart mobMB15" href="cart.php?theme=<?php echo $_GET['theme']; ?>"">Add to cart</a>
                  <button type="submit" class="add-to-wishlist button nomargin"><i class="icon-heart" style="margin-right:0px;"></i></button>
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
                                        <!-- <div class="tab-content tabBox clearfix" id="tabs-2">
                                            <div ng-bind-html="product.add_desc | toTrust"></div> 
                                        </div> -->
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
                    <a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>"><img src="images/fash/products/default-product.jpg" alt="" class="boxSizeImage"> </a>
                    <div class="product-overlay"> <a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>" class="add-to-cart"><i class="icon-eye"></i><span> View Details</span></a></div>
                  </div>
                  <div class="product-desc">
                    <div class="product-title">
                      <h3><a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>">Your Product Name</a></h3> </div>
                    <div class="product-price"><del><i class="icon-rupee"></i> 499</del> <ins><i class="icon-rupee"></i> 399</ins> </div>
                  </div>
                </div>
              </div>
              <div class="oc-item">
              <div class="product clearfix mobwidth100 relatedProduct">
                  <div class="product-image">
                    <a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>"><img src="images/fash/products/default-product.jpg" alt="" class="boxSizeImage"> </a>
                    <div class="product-overlay"> <a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>" class="add-to-cart"><i class="icon-eye"></i><span> View Details</span></a></div>
                  </div>
                  <div class="product-desc">
                    <div class="product-title">
                      <h3><a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>">Your Product Name</a></h3> </div>
                    <div class="product-price"><del><i class="icon-rupee"></i> 499</del> <ins><i class="icon-rupee"></i> 399</ins> </div>
                  </div>
                </div>
              </div>
              <div class="oc-item">
              <div class="product clearfix mobwidth100 relatedProduct">
                  <div class="product-image">
                    <a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>"><img src="images/fash/products/default-product.jpg" alt="" class="boxSizeImage"> </a>
                    <div class="product-overlay"> <a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>" class="add-to-cart"><i class="icon-eye"></i><span> View Details</span></a></div>
                  </div>
                  <div class="product-desc">
                    <div class="product-title">
                      <h3><a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>">Your Product Name</a></h3> </div>
                    <div class="product-price"><del><i class="icon-rupee"></i> 499</del> <ins><i class="icon-rupee"></i> 399</ins> </div>
                  </div>
                </div>
              </div>
              <div class="oc-item">
              <div class="product clearfix mobwidth100 relatedProduct">
                  <div class="product-image">
                    <a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>"><img src="images/fash/products/default-product.jpg" alt="" class="boxSizeImage"> </a>
                    <div class="product-overlay"> <a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>" class="add-to-cart"><i class="icon-eye"></i><span> View Details</span></a></div>
                  </div>
                  <div class="product-desc">
                    <div class="product-title">
                      <h3><a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>">Your Product Name</a></h3> </div>
                    <div class="product-price"><del><i class="icon-rupee"></i> 499</del> <ins><i class="icon-rupee"></i> 399</ins> </div>
                  </div>
                </div>
              </div>
              <div class="oc-item">
              <div class="product clearfix mobwidth100 relatedProduct">
                  <div class="product-image">
                    <a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>"><img src="images/fash/products/default-product.jpg" alt="" class="boxSizeImage"> </a>
                    <div class="product-overlay"> <a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>" class="add-to-cart"><i class="icon-eye"></i><span> View Details</span></a></div>
                  </div>
                  <div class="product-desc">
                    <div class="product-title">
                      <h3><a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>">Your Product Name</a></h3> </div>
                    <div class="product-price"><del><i class="icon-rupee"></i> 499</del> <ins><i class="icon-rupee"></i> 399</ins> </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>
    <!-- #content end -->
    <?php
    if($_GET['theme'] == 'fs1' ||  $_GET['theme'] == 'fs3' || $_GET['theme'] == 'ac1' ||  $_GET['theme'] == 'ac3' ||  $_GET['theme'] == 'bs1' ||  $_GET['theme'] == 'bs3' ||  $_GET['theme'] == 'bw1' ||  $_GET['theme'] == 'bw3' ||  $_GET['theme'] == 'el1' ||  $_GET['theme'] == 'el3' ||  $_GET['theme'] == 'ft1' ||  $_GET['theme'] == 'ft3' ||  $_GET['theme'] == 'hd1' ||  $_GET['theme'] == 'hd3' ||  $_GET['theme'] == 'jw1' ||  $_GET['theme'] == 'jw3' ||  $_GET['theme'] == 'kh1' ||  $_GET['theme'] == 'kh3' ||  $_GET['theme'] == 'fg1' ||  $_GET['theme'] == 'fg3' ||  $_GET['theme'] == 'rs1' ||  $_GET['theme'] == 'rs3' ||  $_GET['theme'] == 'os1' ||  $_GET['theme'] == 'os3' ||  $_GET['theme'] == 'ts1' ||  $_GET['theme'] == 'ts3')
    include( 'includes/footer_style1.php');

    if($_GET['theme'] == 'fs2' || $_GET['theme'] == 'ac2' ||  $_GET['theme'] == 'bs2' ||  $_GET['theme'] == 'bw2' ||  $_GET['theme'] == 'el2' ||  $_GET['theme'] == 'ft2' ||  $_GET['theme'] == 'hd2' ||  $_GET['theme'] == 'jw2' ||  $_GET['theme'] == 'kh2' ||  $_GET['theme'] == 'fg2' ||  $_GET['theme'] == 'os2' ||  $_GET['theme'] == 'rs2' ||  $_GET['theme'] == 'ts2')
    include( 'includes/footer_style2.php');
     ?>
     </div>
    <!-- #wrapper end -->
    <?php include( 'includes/foot.php'); ?> </body>

</html>
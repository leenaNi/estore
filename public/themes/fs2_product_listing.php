<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<?php include( 'includes/head.php'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" type="text/css" />	
<body class="stretched">
  <!-- Document Wrapper
	============================================= -->
  <div id="wrapper" class="clearfix">
    <?php include( 'includes/header_style2.php'); ?>
    <section id="page-title">
      <div class="container clearfix">
        <h1>PRODUCT CATEGORY NAME</h1>
        <ol class="breadcrumb">
          <li><a href="index.php">Home</a> </li>
          <li class="active">PRODUCT CATEGORY NAME</li>
        </ol>
      </div>
    </section>
    <!-- Content
		============================================= -->
    <section id="content">
      <div class="content-wrap">
        <div class="container clearfix">
          <div class="col-md-12 clearfix">
            <select class="form-control pull-right sort-dropdown">
              <option value="1" selected="selected">Default sorting</option>
              <option value="2">Popularity</option>
              <option value="4">Price Low-High</option>
              <option value="5">Price High-Low</option>
            </select>
          </div>
          <div class="sidebar nobottommargin col-md-2">
            <div class="sidebar-widgets-wrap">
              <div class="widget clearfix">
              <aside class="widget">
                                <h4 class="widget-title pricerange-titlebox">Filter By Price </h4>
                                <div class="f-price price-rangebox">
                                    <span> <strong id="amount" ></strong></span>
                                    <div class="minPriceBox"><span class="currency-sym"><i class="icon-rupee"></i></span>
                                        <input type="text" id="min_price" name="min_price" min="0" placeholder="Min price" class="min-price-filter"></div><div class="priceHypen">-</div>
                                        <div class="maxPriceBox"><span class="currency-sym"><i class="icon-rupee"></i></span> 
                                            <input type="text" id="max_price" name="max_price" placeholder="Max price" class="max-price-filter">
                                        </div>
                                        <div class="clearfix"></div>
                                        <div id="slider-range"></div>
                                        <div class="filterbtn-box"><button class="btn btn-dashed textup themebtn-color"  type="button">Apply</button></div>
                                    </div>
                                </aside> 
              
              <div class="widget clearfix">
                <div class="accordion accordion-bg clearfix">

							<div class="acctitle cat-title">Categories</div>
							<div class="acc_content clearfix">
							<ul class="cat-list">
                 <li><a href="#"><div>
										<input id="checkbox-1" class="checkbox-style" name="checkbox-1" type="checkbox" checked="">
										<label for="checkbox-1" class="checkbox-style-3-label">Category 1</label>
									</div></a> </li>
                   <li><a href="#"><div>
										<input id="checkbox-2" class="checkbox-style" name="checkbox-2" type="checkbox">
										<label for="checkbox-2" class="checkbox-style-3-label">Category 2</label>
									</div></a> </li>
									
									 <li><a href="#"><div>
										<input id="checkbox-3" class="checkbox-style" name="checkbox-3" type="checkbox">
										<label for="checkbox-3" class="checkbox-style-3-label">Category 3</label>
									</div></a> </li>
									 <li><a href="#"><div>
										<input id="checkbox-4" class="checkbox-style" name="checkbox-4" type="checkbox">
										<label for="checkbox-4" class="checkbox-style-3-label">Category 4</label>
									</div></a> </li>
									
									 <li><a href="#"><div>
										<input id="checkbox-5" class="checkbox-style" name="checkbox-5" type="checkbox">
										<label for="checkbox-5" class="checkbox-style-3-label">Category 5</label>
									</div></a> </li>
									
								
								</ul>
							</div>						

						</div>
              </div>
            </div>
					</div>
</div>
          <!-- .sidebar end -->
          <div id="shop" class="shop col-md-9 product-3 clearfix bottommargin-sm  noRightPadding">

									<div class="product clearfix product-item productbox">
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
									
									<div class="product clearfix product-item productbox">
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
									
									<div class="product clearfix product-item productbox">
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
									
									<div class="product clearfix product-item productbox">
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

									<div class="product clearfix product-item productbox">
										<div class="product-image">
										<a href="fs2_product_detail.php"><img src="images/fashion/products/default-product.jpg" alt="">
                </a>
											<div class="product-overlay2">
											<a href="fs2_product_detail.php" class="center-icon"><i class="icon-line-plus"></i></a>
											
											</div>
										</div>
										<div class="product-desc product-desc-transparent">
											<div class="product-title"><h3><a href="fs2_product_detail.php">Your Product Name</a></div>
											<div class="product-price"><del><i class="icon-rupee"></i>  499</del> <ins><i class="icon-rupee"></i>  399</ins></div>
										</div>
											<div class="add-to-cart-btn">
												<a href="fs2_product_detail.php" class="button button-grey full-width-btn"><span>View Detail</span></a>
											</div>
									</div>
									
									<div class="product clearfix product-item productbox">
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
									
									<div class="product clearfix product-item productbox">
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
									
									<div class="product clearfix product-item productbox">
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
									
									<div class="product clearfix product-item productbox">
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
									
									<div class="clearfix"></div>
<div class="text-center col-md-12 col-xs-12"><a href="#" class="button button-large button-dark topmargin-sm">Load More</a></div>
								</div>
          <div class="clearfix"></div>
        </div>
    </section>
    <!-- #content end -->
    <?php include( 'includes/footer_style2.php'); ?> </div>
    <!-- #wrapper end -->
    <?php include( 'includes/foot.php'); ?> </body>

</html>
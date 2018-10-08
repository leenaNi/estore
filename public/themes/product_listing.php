<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<?php include( 'includes/head.php'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" type="text/css" />	
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
    <section id="page-title">
      <div class="container clearfix">
        <h1>Product Category Name</h1>
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
          <div id="shop" class="shop col-md-9 product-3 clearfix bottommargin-sm noRightPadding">
          <div class="product clearfix">
              <div class="product-image producImgBoxSize_4Col"> 
                <a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>"><img src="images/fash/products/default-product.jpg" alt="">
                </a>
                <div class="product-overlay"> <a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>" class="add-to-cart"><i class="icon-eye"></i><span> View Details</span></a></div>
              </div>
              <div class="product-desc">
                <div class="product-title">
                  <h3><a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>">Your Product Name</a></h3>
                </div>
                <div class="product-price"><del><i class="icon-rupee"></i>  499</del> <ins><i class="icon-rupee"></i>  399</ins>
                </div>
              </div>
            </div>
            <div class="product clearfix">
              <div class="product-image producImgBoxSize_4Col">
                <a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>"><img src="images/fash/products/default-product.jpg" alt="">
                </a>
                <div class="product-overlay"> <a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>" class="add-to-cart"><i class="icon-eye"></i><span> View Details</span></a></div>
              </div>
              <div class="product-desc">
                <div class="product-title">
                  <h3><a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>">Your Product Name</a></h3>
                </div>
                <div class="product-price"><del><i class="icon-rupee"></i>  499</del> <ins><i class="icon-rupee"></i>  399</ins>
                </div>
              </div>
            </div>
            <div class="product clearfix">
              <div class="product-image producImgBoxSize_4Col">
                <a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>"><img src="images/fash/products/default-product.jpg" alt="">
                </a>
                <div class="product-overlay"> <a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>" class="add-to-cart"><i class="icon-eye"></i><span> View Details</span></a></div>
              </div>
              <div class="product-desc">
                <div class="product-title">
                  <h3><a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>">Your Product Name</a></h3>
                </div>
                <div class="product-price"><del><i class="icon-rupee"></i>  499</del> <ins><i class="icon-rupee"></i>  399</ins>
                </div>
              </div>
            </div>

            <div class="product clearfix">
              <div class="product-image producImgBoxSize_4Col">
                <a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>"><img src="images/fash/products/default-product.jpg" alt="">
                </a>
                <div class="product-overlay"> <a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>" class="add-to-cart"><i class="icon-eye"></i><span> View Details</span></a></div>
              </div>
              <div class="product-desc">
                <div class="product-title">
                  <h3><a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>">Your Product Name</a></h3>
                </div>
                <div class="product-price"><del><i class="icon-rupee"></i>  499</del> <ins><i class="icon-rupee"></i>  399</ins>
                </div>
              </div>
            </div>
            
            
            <div class="product clearfix">
              <div class="product-image producImgBoxSize_4Col">
                <a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>"><img src="images/fash/products/default-product.jpg" alt="">
                </a>
                <div class="product-overlay"> <a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>" class="add-to-cart"><i class="icon-eye"></i><span> View Details</span></a></div>
              </div>
              <div class="product-desc">
                <div class="product-title">
                  <h3><a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>">Your Product Name</a></h3>
                </div>
                <div class="product-price"><del><i class="icon-rupee"></i>  499</del> <ins><i class="icon-rupee"></i>  399</ins>
                </div>
              </div>
            </div>

            <div class="product clearfix">
              <div class="product-image producImgBoxSize_4Col">
                <a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>"><img src="images/fash/products/default-product.jpg" alt="">
                </a>
                <div class="product-overlay"> <a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>" class="add-to-cart"><i class="icon-eye"></i><span> View Details</span></a></div>
              </div>
              <div class="product-desc">
                <div class="product-title">
                  <h3><a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>">Your Product Name</a></h3>
                </div>
                <div class="product-price"><del><i class="icon-rupee"></i>  499</del> <ins><i class="icon-rupee"></i>  399</ins>
                </div>
              </div>
            </div><div class="product clearfix">
              <div class="product-image producImgBoxSize_4Col">
                <a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>"><img src="images/fash/products/default-product.jpg" alt="">
                </a>
                <div class="product-overlay"> <a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>" class="add-to-cart"><i class="icon-eye"></i><span> View Details</span></a></div>
              </div>
              <div class="product-desc">
                <div class="product-title">
                  <h3><a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>">Your Product Name</a></h3>
                </div>
                <div class="product-price"><del><i class="icon-rupee"></i>  499</del> <ins><i class="icon-rupee"></i>  399</ins>
                </div>
              </div>
            </div>
            <div class="product clearfix">
              <div class="product-image producImgBoxSize_4Col">
                <a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>"><img src="images/fash/products/default-product.jpg" alt="">
                </a>
                <div class="product-overlay"> <a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>" class="add-to-cart"><i class="icon-eye"></i><span> View Details</span></a></div>
              </div>
              <div class="product-desc">
                <div class="product-title">
                  <h3><a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>">Your Product Name</a></h3>
                </div>
                <div class="product-price"><del><i class="icon-rupee"></i>  499</del> <ins><i class="icon-rupee"></i>  399</ins>
                </div>
              </div>
            </div>
            <div class="product clearfix">
              <div class="product-image producImgBoxSize_4Col">
                <a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>"><img src="images/fash/products/default-product.jpg" alt="">
                </a>
                <div class="product-overlay"> <a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>" class="add-to-cart"><i class="icon-eye"></i><span> View Details</span></a></div>
              </div>
              <div class="product-desc">
                <div class="product-title">
                  <h3><a href="product_detail.php?theme=<?php echo $_GET['theme']; ?>">Your Product Name</a></h3>
                </div>
                <div class="product-price"><del><i class="icon-rupee"></i>  499</del> <ins><i class="icon-rupee"></i>  399</ins>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="text-center col-md-12"><a href="#" class="button button-large button-dark  topmargin-sm">Load More</a> </div>
          </div>
          <div class="clearfix"></div>
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
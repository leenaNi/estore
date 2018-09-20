<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<?php include( 'includes/head.php'); ?>

<body class="stretched">
  <!-- Document Wrapper
	============================================= -->
  <div id="wrapper" class="clearfix">
  <?php
    if($_GET['theme'] == 'fs1' ||  $_GET['theme'] == 'fs3')
     include( 'includes/header_style1.php');

     if($_GET['theme'] == 'fs2')
     include( 'includes/header_style2.php');
     
     
     ?>

    <!-- Content
		============================================= -->
    <section id="content">
      <div class="content-wrap">
        <div class="container clearfix">
          <div class="col_full_fourth nobottommargin">
            <div class="ordersuccess-block center">
              <h2>Your Order Is Complete!</h2> <span class="divcenter">You will soon recive an e-mail confirming you transaction.</span>
              <br>
              <h4>Your Order Id Is 12345</h4> </div>
            <div class="table-responsive nobottommargin">
              <table class="table table-bordered cart">
                <thead>
                  <tr>
                    <th class="cart-product-thumbnail">Product</th>
                    <th class="cart-product-detail">Detail</th>
                    <th class="cart-product-price">Price</th>
                    <th class="cart-product-quantity">Quantity</th>
                    <th class="cart-product-subtotal">Total</th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="cart_item">
                    <td class="cart-product-thumbnail">
                      <a href="#"><img width="64" height="64" src="images/fashion/products/4.jpg" alt="">
                      </a>
                    </td>
                    <td class="cart-product-name"> <a href="#">Gritstones Men Blue Regular Fit T-shirt</a> </td>
                    <td class="cart-product-price"> <span class="amount">Rs. 399</span> </td>
                    <td class="cart-product-quantity">
                      <div class=""> 2 </div>
                    </td>
                    <td class="cart-product-subtotal"> <span class="amount">Rs. 399</span> </td>
                  </tr>
                </tbody>
              </table>
              <div class="col-md-12 col-sm-12 col-xs-12 text-center"> 
              <a href="#" class="button button-black">Print</a> 
              <a href="myaccount.php?theme=fs1" class="button button-default">My Account</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- #content end -->
    <?php
    if($_GET['theme'] == 'fs1' ||  $_GET['theme'] == 'fs3')
     include( 'includes/footer_style1.php');

     if($_GET['theme'] == 'fs2')
     include( 'includes/footer_style2.php');
     
     
     ?>
      </div>
  <!-- #wrapper end -->
  <?php include( 'includes/foot.php'); ?> </body>

</html>
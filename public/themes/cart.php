<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<?php include( 'includes/head.php'); ?>

<body class="stretched">
  <!-- Document Wrapper
	============================================= -->
  <div id="wrapper" class="clearfix">
  <?php
    if($_GET['theme'] == 'fs1' ||  $_GET['theme'] == 'fs3' || $_GET['theme'] == 'ac1' ||  $_GET['theme'] == 'ac3' ||  $_GET['theme'] == 'bs1' ||  $_GET['theme'] == 'bs3' ||  $_GET['theme'] == 'el1' ||  $_GET['theme'] == 'el3' ||  $_GET['theme'] == 'fg1' ||  $_GET['theme'] == 'fg3' ||  $_GET['theme'] == 'ft1' ||  $_GET['theme'] == 'ft3' ||  $_GET['theme'] == 'hd1' ||  $_GET['theme'] == 'hd3' ||  $_GET['theme'] == 'jw1' ||  $_GET['theme'] == 'jw3' ||  $_GET['theme'] == 'kh1' ||  $_GET['theme'] == 'kh3' ||  $_GET['theme'] == 'os1' ||  $_GET['theme'] == 'os3' ||  $_GET['theme'] == 'rs1' ||  $_GET['theme'] == 'rs3' ||  $_GET['theme'] == 'ts1' ||  $_GET['theme'] == 'ts3')
    include( 'includes/header_style1.php');

    if($_GET['theme'] == 'fs2' || $_GET['theme'] == 'ac2' ||  $_GET['theme'] == 'bs2' ||  $_GET['theme'] == 'el2' ||  $_GET['theme'] == 'fg2' ||  $_GET['theme'] == 'ft2' ||  $_GET['theme'] == 'hd2' ||  $_GET['theme'] == 'jw2' ||  $_GET['theme'] == 'kh2' ||  $_GET['theme'] == 'os2' ||  $_GET['theme'] == 'rs2' ||  $_GET['theme'] == 'ts2')
     include( 'includes/header_style2.php');
     
     
     ?>
    <section id="page-title">
      <div class="container clearfix">
        <h1>Cart</h1>
        <ol class="breadcrumb">
          <li><a href="#">Home</a>
          </li>
          <li class="active">Cart</li>
        </ol>
      </div>
    </section>
    <!-- Content
		============================================= -->
    <div id="content" class="site-content single-product" style="margin-bottom: 0px;">


<div class="container">
            <form class="cart-form" action="#">
        <div class="table-responsive">
            <table class="table table-bordered cart-table cartT">
                <thead>
                    <tr>
                        <th></th>
                        <th class="text-left">Product</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Coupon Discount </th>
                        <th>Tax</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                <td class="product-remove">
                <span style="cursor: pointer;" class="remove removeCartItem"><i class="icon-line2-trash"></i></span>
                </td>
                <td class="cartProductName" valign="top">
                <div class="CPN-Box">
                <div class="CPN-BoxLeft">
                <img src="images/fashion/products/4.jpg" class="cart-prodimg">
                </div>
                <div class="CPN-BoxRight">
                <div>Gritstones Men Black Regular Fit T-shirt
                <div class="clearfix"></div>
                </div>
                <div class="cart-quanitiy">Black</div>
                </div>
                </div>
                </td>
                <td>82.13<br>
                </td>
                <td class="cartQuantityBox-td cart-product-quantity">
                <div class="quantity clearfix">
                        <input type="button" value="-" class="minus">
                        <input type="text" name="quantity" value="1" class="qty" />
                        <input type="button" value="+" class="plus">
                </div>
                </td>
                <td>
                <span class="tax_amt"> 0.00</span>
                </td>
                <td>
                <span class=""> 0.00</span>
                </td>
                <td>
                <span>82.13</span>
                </td>
                </tr>
                </tbody>
            </table>
        </div>
    </form>
    <div class="cart-collaterals row">
    <div class="col-md-6 col-sm-6 col-xs-12 mobMB15">
     <div class="cal-shipping  mar-bot15">
     <h4 class="heading-title">HAVE A COUPON?</h4>
     <form class="checkout_coupon ng-pristine ng-valid" method="post">
     <div class="cart-input">
     <input name="coupon_code" class="userCouponCode sm-form-control" id="" value="" placeholder="Enter Coupon Code " type="text"> 
     </div>
     <div class="">
     <input class="button applycoupenbtn bold default" name="apply_coupon" id="couponApply" value="Apply Coupon" type="submit">
     </div>
     </form>
     <div class="col-md-12 col-xs-12 space3">
     <span class="cmsg" style="display:none;color:red;font-size:13px;margin-top:15px"></span>
     </div>
     </div><!-- .cal-shipping -->
     </div>
        

        <div class="col-md-6 col-sm-6 col-xs-12 pull-right">
            <div class="cal-shipping table-responsive">
                <h4 class="heading-title ">Cart Total</h4>
                <table class="table cart">
                <tbody><tr class="cart-subtotal">
                        <th>Sub-Total: </th>
                        <td><strong><span class="amount allSubtotal" id="amountallSubtotal">82.13</span></strong></td>
                    </tr>
                    <tr class="shipping">
                        <th>Coupon<span class="coupCode"></span>: </th>
                        <td>
                        <strong><span class="couponUsedAmount" id="couponUsedAmount">0.00</span></strong>
                        </td>
                    </tr>
                    <tr class="order-total">
                        <th><div class="black-bg">Total: </div></th>
                        <td><div class="black-bg"><strong><span class="amount finalAmt">82.13</span></strong></div></td>
                    </tr>
                    </tbody></table>
            </div><!-- .cal-shipping -->
        </div>
        <div class="clearfix"></div>
        <div class="col-md-12 col-sm-12 col-xs-12">

            <div class="cart-actions clearfix">
                <form action="#" class="ng-pristine ng-valid">
                    <a class="button bold default" href="checkout.php?theme=fs1">PROCEED TO CHECKOUT</a>
                    <a class="button bold default" href="/">Continue Shopping</a>
                </form>
            </div><!-- .cart-actions -->
        </div>
    </div><!-- .cart-collaterals -->
        </div><!-- .container -->
</div>

    <!-- #content end -->
    <?php
    if($_GET['theme'] == 'fs1' ||  $_GET['theme'] == 'fs3' || $_GET['theme'] == 'ac1' ||  $_GET['theme'] == 'ac3' ||  $_GET['theme'] == 'bs1' ||  $_GET['theme'] == 'bs3' ||  $_GET['theme'] == 'el1' ||  $_GET['theme'] == 'el3' ||  $_GET['theme'] == 'ft1' ||  $_GET['theme'] == 'ft3' ||  $_GET['theme'] == 'hd1' ||  $_GET['theme'] == 'hd3' ||  $_GET['theme'] == 'jw1' ||  $_GET['theme'] == 'jw3' ||  $_GET['theme'] == 'kh1' ||  $_GET['theme'] == 'kh3' ||  $_GET['theme'] == 'fg1' ||  $_GET['theme'] == 'fg3' ||  $_GET['theme'] == 'rs1' ||  $_GET['theme'] == 'rs3' ||  $_GET['theme'] == 'os1' ||  $_GET['theme'] == 'os3' ||  $_GET['theme'] == 'ts1' ||  $_GET['theme'] == 'ts3')
    include( 'includes/footer_style1.php');

    if($_GET['theme'] == 'fs2' || $_GET['theme'] == 'ac2' ||  $_GET['theme'] == 'bs2' ||  $_GET['theme'] == 'el2' ||  $_GET['theme'] == 'ft2' ||  $_GET['theme'] == 'hd2' ||  $_GET['theme'] == 'jw2' ||  $_GET['theme'] == 'kh2' ||  $_GET['theme'] == 'fg2' ||  $_GET['theme'] == 'os2' ||  $_GET['theme'] == 'rs2' ||  $_GET['theme'] == 'ts2')
    include( 'includes/footer_style2.php');
     ?>
      </div>
  <!-- #wrapper end -->
  <?php include( 'includes/foot.php'); ?> </body>

</html>
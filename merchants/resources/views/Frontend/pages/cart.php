<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<?php include( 'includes/head.php'); ?>

<body class="stretched">
  <!-- Document Wrapper
	============================================= -->
  <div id="wrapper" class="clearfix">
    <?php include( 'includes/header_style1.php'); ?>
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
    <section id="content">
      <div class="content-wrap">
        <div class="container clearfix">
          <div class="col_three_fourth nobottommargin">
            <div class="table-responsive nobottommargin">
              <table class="table table-bordered cart">
                <thead>
                  <tr>
                    <th class="cart-product-remove">Action</th>
                    <th class="cart-product-thumbnail">Product</th>
                    <th class="cart-product-detail">Detail</th>
                    <th class="cart-product-price">Unit Price</th>
                    <th class="cart-product-quantity">Quantity</th>
                    <th class="cart-product-subtotal">Total</th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="cart_item">
                    <td class="cart-product-remove"> <a href="#" class="remove" title="Remove this item"><i class="icon-trash2"></i></a> </td>
                    <td class="cart-product-thumbnail">
                      <a href="#"><img width="64" height="64" src="images/shop/blue-tshirt2.jpg" alt="">
                      </a>
                    </td>
                    <td class="cart-product-name"> <a href="#">Gritstones Men Black Regular Fit T-shirt</a> </td>
                    <td class="cart-product-price"> <span class="amount"><?php echo htmlspecialchars_decode(Session::get('currency_symbol')); ?> 399</span> </td>
                    <td class="cart-product-quantity">
                      <div class="quantity clearfix">
                        <input type="button" value="-" class="minus flt-left-force">
                        <input type="text" name="quantity" value="1" class="qty flt-left-force" />
                        <input type="button" value="+" class="plus flt-left-force"> </div>
                    </td>
                    <td class="cart-product-subtotal"> <span class="amount"><?php echo htmlspecialchars_decode(Session::get('currency_symbol')); ?> 399</span> </td>
                  </tr>
                  <tr class="cart_item">
                    <td colspan="6">
                      <div class="row clearfix">
                      <div class="col-md-12 col-xs-12"> 
                        <a href="checkout.php" class="button button-3d notopmargin fright">Checkout</a>                         
                        <a href="product_listing.php" class="button button-3d nomargin fright">Continue Shopping</a> 
                      </div>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="col_one_fourth col_last nobottommargin">
            <div class="table-responsive">
              <h4>Cart Totals</h4>
              <table class="table cart">
                <tbody>
                  <tr class="cart_item">
                    <td class="cart-product-name"> <strong>Cart Subtotal</strong> </td>
                    <td class="cart-product-name"> <span class="amount"><?php echo htmlspecialchars_decode(Session::get('currency_symbol')); ?> 399</span> </td>
                  </tr>
                  <tr class="cart_item">
                    <td class="cart-product-name"> <strong>Shipping</strong> </td>
                    <td class="cart-product-name"> <span class="amount">Free Delivery</span> </td>
                  </tr>
                  <tr class="cart_item">
                    <td class="cart-product-name"> <strong>Total</strong> </td>
                    <td class="cart-product-name"> <span class="amount color lead"><strong><?php echo htmlspecialchars_decode(Session::get('currency_symbol')); ?> 399</strong></span> </td>
                  </tr>
                </tbody>
              </table>
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
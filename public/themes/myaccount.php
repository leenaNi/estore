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
    <section id="page-title">
      <div class="container clearfix">
        <h1>My Account</h1>
        <ol class="breadcrumb">
          <li><a href="fs1_home.php">Home</a>
          </li>
          <li class="active">My Account</li>
        </ol>
      </div>
    </section>
    <!-- Content
		============================================= -->
    <section id="content">
      <div class="content-wrap">
        <div class="container clearfix">
          <div class="col-lg-3">
            <div class="panel panel-default border-radiusNone">
              <div class="panel-body">
              <div class="col-md-12 nobottommargin editprofchoose">
                            <h4 id="userProfile" class="mb15">Aparna</h4> 
                            <div class="emailbox"><strong>Email:</strong> aparna@infiniteit.biz</div>
                            <div class="mobilebox"><strong>Mobile:</strong> 97693707222</div>
                            <div class="mobilebox"><strong>Referral Code:</strong> APA24872</div>
                            <div class="mobilebox"><strong>Loyalty:</strong> -743011.7698585</div>
                          </div>
               
              </div>
            </div>
          </div>
          <div class="col-lg-9">
            <div class="tabs tabs-justify tabs-bordered clearfix tabwhite" id="tab-2">
              <ul class="tab-nav clearfix" role="tablist">
                <li><a href="#tabs-1" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-1"> My Profile</a>
                </li>
                <li><a href="#tabs-2" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-3"> My Orders</a>
                </li>
                <li><a href="#tabs-3" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-4"> My Wishlist</a>
                </li>
                <li><a href="#tabs-4" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-2"> Change Password</a>
                </li>
              </ul>
              <div class="tab-container">
                <div class="tab-content clearfix" id="tabs-1">
                  <form class="nobottommargin" id="editProfileForm" action="#" method="post" novalidate="novalidate">
                    <div class="col_half">
                      <label for="template-contactform-name">First Name <small>*</small>
                      </label>
                      <input type="text" name="firstname" value="Aparna" class="sm-form-control"> </div>
                    <div class="col_half col_last">
                      <label for="template-contactform-name">Last Name </label>
                      <input type="text" name="lastname" value="" class="sm-form-control"> </div>
                    <div class="col_half ">
                      <label for="template-contactform-email">Email <small>*</small>
                      </label>
                      <input type="email" name="email" value="aparna@infiniteit.biz" class="email sm-form-control" disabled=""> </div>
                    <div class="col_half col_last">
                      <label for="template-contactform-phone">Mobile <small>*</small>
                      </label>
                      <input type="text" id="template-contactform-phone" name="telephone" value="9769143142" class="sm-form-control" disabled=""> </div>
                    <div class="col_full">
                      <button class="button nomargin" value="submit">Update</button>
                    </div>
                  </form>
                </div>
                <div class="tab-content clearfix" id="tabs-4">
                  <form class="nobottommargin" id="resetPasswordAccount" method="post" novalidate="novalidate">
                    <div class="col_full"> <span id="passUpdate" style="color: #1B2987"></span> </div>
                    <div class="col_full">
                      <input type="hidden" placeholder="email" name="email" value="bhavana@infiniteit.biz" readonly="readonly">
                      <label for="template-contactform-name">CURRENT PASSWORD<small>*</small>
                      </label>
                      <input type="password" name="old_password" placeholder="Current Password" class="sm-form-control required" aria-required="true">
                      <div id="old_password_validate" style="color:red;"></div>
                    </div>
                    <div class="col_full">
                      <label for="template-contactform-name">NEW PASSWORD <small>*</small>
                      </label>
                      <input type="password" id="password" name="password" placeholder="New Password" class="sm-form-control required" aria-required="true">
                      <div id="password_validate" style="color:red;"></div>
                    </div>
                    <div class="col_full">
                      <label for="template-contactform-email">CONFIRM NEW PASSWORD <small>*</small>
                      </label>
                      <input type="password" name="conf_password" placeholder="Confirm New Password" class="required sm-form-control" aria-required="true">
                      <div id="conf_password_validate" style="color:red;"></div>
                    </div>
                    <div class="col_full">
                      <button class="button button-3d nomargin" type="submit" name="template-contactform-submit" value="submit">SAVE</button>
                    </div>
                  </form>
                </div>
                <div class="tab-content clearfix" id="tabs-2" aria-labelledby="ui-id-3" role="tabpanel" aria-hidden="true" style="display: none;">
                  <div class="table-responsive">
                    <table class="table cart">
                      <thead>
                        <tr bgcolor="#F2F2F2">
                          <th class="text-center">Order Id</th>
                          <th class="text-center">Order Amount</th>
                          <th class="text-center">Date</th>
                          <th class="text-center">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td class="tdfont text-center">101408</td>
                          <td class="tdfont text-center">Rs. 2000</td>
                          <td class="tdfont text-center">23-Jun-2016 </td>
                          <td data-th="Subtotal" class="text-center"><a href="order-details.php?theme=fs1" class="button button-3d button-mini button-rounded">View Detail</a>
                          </td>
                        </tr>
                        <tr>
                          <td class="tdfont text-center">101408</td>
                          <td class="tdfont text-center">Rs. 2000</td>
                          <td class="tdfont text-center">23-Jun-2016 </td>
                          <td data-th="Subtotal" class="text-center"><a href="order-details.php?theme=fs1" class="button button-3d button-mini button-rounded">View Detail</a>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="tab-content clearfix" id="tabs-3" aria-labelledby="ui-id-3" role="tabpanel" aria-hidden="true" style="display: none;">
                  <div class="table-responsive">
                    <table class="table cart">
                      <thead>
                        <tr bgcolor="#F2F2F2">
                          <th class="cart-product-thumbnail">&nbsp;</th>
                          <th class="cart-product-name">Product</th>
                          <th class="cart-product-price">Price</th>
                          <th class="cart-product-quantity">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr class="cart_item">
                          <td class="cart-product-thumbnail">
                            <a href="#"><img width="64" height="64" src="images/fashion/products/default-product.jpg" alt="img">
                            </a>
                          </td>
                          <td class="cart-product-name"> <a href="#">Gritstones Men Black Regular Fit T-shirt</a> </td>
                          <td class="cart-product-price"> <span class="amount">Rs. 399</span> </td>
                          <td class="cart-product-remove"> <a href="#" class="remove" title="Remove this item"><i class="icon-trash2 fa-2x"></i></a> </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
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
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
        <h1>Checkout</h1>
        <ol class="breadcrumb">
          <li><a href="#">Home</a>
          </li>
          <li class="active">Checkout</li>
        </ol>
      </div>
    </section>
    <!-- Content
		============================================= -->
    <section id="content">
      <div class="content-wrap">
        <div class="container clearfix">
          <div class="panel-group nobottommargin" id="accordion">
            <div class="panel panel-default">
              <div class="panel-heading"> <a data-toggle="collapse" data-parent="#accordion" href="#loginReg">
							  <h5 class="nomargin">Login / New User</h5>
							</a> </div>
              <div id="loginReg" class="panel-collapse collapse in">
                <div class="panel-body">
                  <div class="col_three_fifth nobottommargin">
                    <div class="tabs divcenter nobottommargin clearfix" id="tab-login-register" style="max-width: 500px;">
                      <ul class="tab-nav tab-nav2 clearfix">
                        <li class="inline-block"><a class="button button-black nomargin" href="#tab-login">Login</a>
                        </li>
                        <li class="inline-block"><a class="button button-black nomargin" href="#new-user">New User</a>
                        </li>
                        <li class="inline-block"><a class="button button-black nomargin" href="#tab-guest">Guest</a>
                        </li>
                      </ul>
                      <div class="tab-container">
                        <div class="tab-content clearfix" id="tab-login">
                          <div class="panel panel-default nobottommargin noborder noshadow">
                            <div class="panel-body padd0">
                              <form class="nobottommargin" action="#" method="post">
                                <div class="col_full">
                                  <input type="text" placeholder="Email" value="" class="form-control" /> </div>
                                <div class="col_full">
                                  <input type="password" placeholder="Password" value="" class="form-control" /> </div>
                                <div class="col_full nobottommargin">
                                  <button class="button button-default nomargin" value="">Continue</button>
                                  <button class="button button-black nomargin" value="">Cancel</button> <a href="forgot-password.php" class="fright">Forgot Password?</a> </div>
                              </form>
                            </div>
                          </div>
                        </div>
                        <div class="tab-content clearfix" id="new-user">
                          <div class="panel panel-default nobottommargin noborder noshadow">
                            <div class="panel-body padd0">
                              <form class="nobottommargin" action="#" method="post">
                                <div class="col_half">
                                  <input type="text" placeholder="First Name " class="sm-form-control"> </div>
                                <div class="col_half col_last">
                                  <input type="text" placeholder="Last Name " class="sm-form-control"> </div>
                                <div class="col_half">
                                  <input type="email" placeholder="Email *" class="sm-form-control"> </div>
                                <div class="col_half col_last">
                                  <input placeholder="Mobile Number *" type="text" class="sm-form-control"> </div>
                                <div class="col_half">
                                  <input type="password" placeholder="Password *" id="password" class="sm-form-control"> </div>
                                <div class="col_half col_last">
                                  <input type="password" placeholder="Confirm Password *" class="sm-form-control"> </div>
                                <div class="col_full nobottommargin">
                                  <button class="button button-default nomargin" value="">Continue</button>
                                  <button class="button button-black nomargin" value="">Cancel</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                        <div class="tab-content clearfix" id="tab-guest">
                          <div class="panel panel-default nobottommargin noborder noshadow">
                            <div class="panel-body padd0">
                              <form class="nobottommargin" action="#" method="post">
                                <div class="col_full">
                                  <input type="text" placeholder="Email" value="" class="form-control" /> </div>
                                <div class="col_full nobottommargin">
                                  <button class="button button-default nomargin" value="">Continue</button>
                                  <button class="button button-black nomargin" value="">Cancel</button> <a href="#" class="fright">Forgot Password?</a> </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col_two_fifth col_last nobottommargin">
                    <div class="verticaldivider">
                      <div class="vertical-desk-or-divider-text">OR</div>
                    </div>
                    <div class="social_media_login">
                      <a href="#" class="col-md-12 col-sm-6 col-xs-12"> <img src="images/fb_login.jpg" class="fb_login_btn"> </a>
                      <a href="#" class="col-md-12 col-sm-6 col-xs-12"> <img src="images/g_login.jpg" class="g_login_btn"> </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="panel panel-default">
              <div class="panel-heading"> <a data-toggle="collapse" data-parent="#accordion" href="#shippingAdd">
               <h5 class="nomargin">Shipping Address</h5>
             </a> </div>
             <div id="shippingAdd" class="panel-collapse collapse">
              <div class="panel-body">
                <div class="shpng_addrs_col">
                  <h4 class="heading-title">SELECT ADDRESS</h4>
                  <div class="row">
                    <div id="forAddress" class="">
                      <div class="col-md-4">
                        <div class="adrs_col">
                          <h3 class="bxtitle ">
                            <input type="radio">
                            <label class="addL m100none"> Address  (1)</label>
                            <a href="" class="pull-right box_action">
                              <i class="icon-line-delete"></i>
                            </a>
                            <a href="#addNewAddForm" class="pull-right box_action">
                              <i class="icon-pencil"></i></a>
                            </h3>
                            <div class="adrs_cont">
                              <p>Mr. Chintan Lad </p>
                              <p>Neelkanth Business Park,</p>
                              <p>Vidya Vihar West,</p>
                              <p>Mumbai- 400086</p>
                              <p>Maharashtra, India,</p>
                              <p>Mobile No: <span class="chkPhoneNo">+91-9833224568</span>
                              </p>
                            </div>
                          </div>
                        </div>
                        <!-- end ngRepeat: add in addressData -->
                      </div>
                      <div class="col-md-4 addAddress" id="continueStep">
                        <div class="add_adrs_col">
                          <a href="#addNewAddForm"> <i class="icon-line-circle-plus plus_icon"></i>
                            <br> Add Address </a>
                          </div>
                        </div>
                        <form role="form" method="post" action="#">
                          <div class="col_full nobottommargin newAddFormDiv">
                            <div class="form-group col-md-6">
                              <input type="text" class="sm-form-control" name="" required="true" placeholder="First Name *"> </div>
                              <div class="form-group col-md-6">
                                <input type="text" class="sm-form-control" name="" required="true" placeholder="Last Name *"> </div>
                                <div class="clearfix"></div>
                                <div class="form-group col-md-6">
                                  <input type="text" class="sm-form-control" name="" required="true" placeholder="Address Line 1 *"> </div>
                                  <div class="form-group col-md-6">
                                    <input type="text" class="sm-form-control" name="" required="true" placeholder="Address Line 2"> </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group col-md-6">
                                      <select class="sm-form-control" required="true">
                                        <option value="">Country *</option>
                                        <option value="">India</option>
                                      </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                      <input type="number" class="sm-form-control" name="" required="true" placeholder="Pin Code *"> </div>
                                      <div class="clearfix"></div>
                                      <div class="form-group col-md-6">
                                        <select class="sm-form-control" required="true">
                                          <option value="">City *</option>
                                          <option value="">India</option>
                                        </select>
                                      </div>
                                      <div class="form-group col-md-6">
                                        <select class="sm-form-control" required="true">
                                          <option value="">State *</option>
                                          <option value="">India</option>
                                        </select>
                                      </div>
                                      <div class="clearfix"></div>
                                      <div class="form-group col-md-6">
                                        <input type="number" class="sm-form-control" name="" required="true" placeholder="Mobile Number *"> </div>
                                        <div class="clearfix"></div>

                                        <div class="col-md-12 col-sm-12 text-right loginpad">
                                          <button class="button button-black nomargin" value="">Cancel</button>
                                          <button class="button button-default nomargin" value="">Continue</button>
                                        </div>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
            <div class="panel panel-default">
              <div class="panel-heading"> <a data-toggle="collapse" data-parent="#accordion" href="#BillSum">
							 <h5 class="nomargin">Bill Summary</h5>
							</a> </div>
              <div id="BillSum" class="panel-collapse collapse">
                <div class="panel-body">
                  <div class="bill_summry_col">
                    <div class="row">
                      <div class="col-md-5">
                        <h4 class="heading-title">Bill</h4>
                        <div class="summry_col">
                          <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" role="tablist">
                            <li>Subtotal : <span class="pull-right"> <?php echo htmlspecialchars_decode(Session::get('currency_symbol')); ?> 399</span>
                            </li>
                            <li>Shipping : <span class="pull-right"> <?php echo htmlspecialchars_decode(Session::get('currency_symbol')); ?> 0.00</span>
                            </li>
                            <li>Coupon : <span class="pull-right"> <?php echo htmlspecialchars_decode(Session::get('currency_symbol')); ?> 0.00</span>
                            </li>
                          </ul>
                          <h4>Total <span class="amount"> <span class="pull-right TotalCartAmt amount"> <?php echo htmlspecialchars_decode(Session::get('currency_symbol')); ?> 399</span></span></h4> </div>
                      </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="text-right loginpad">
                     <button class="button button-black nomargin" value="">Cancel</button>
                     <button class="button button-default nomargin" value="">Continue</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="panel panel-default">
              <div class="panel-heading"> <a data-toggle="collapse" data-parent="#accordion" href="#paymentMode">
							<h5 class="nomargin">Payment Mode?</h5>
							</a> </div>
              <div id="paymentMode" class="panel-collapse collapse">
                <div class="panel-body">
                  <form method="post" action="#" name="frmTransaction" class="codSubmit">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="pymt_mtd_col">
                          <h4 class="heading-title">Shipping Details</h4>
                          <div class="pymt_mtd_cont">
                              <p>Mr. Chintan Lad </p>
                              <p>Neelkanth Business Park,</p>
                              <p>Vidya Vihar West,</p>
                              <p>Mumbai- 400086</p>
                              <p>Maharashtra, India,</p>
                              <p>Mobile No: <span class="chkPhoneNo">+91-9833224568</span>
                          </div>  
                          <hr class="line nomargin"><br>
                          <h5>Bill Amount : <span class="amount"><b class="finalamt ng-binding"><?php echo htmlspecialchars_decode(Session::get('currency_symbol')); ?> 399</b></span></h5> </div>
                      </div>
                      <div class="col-md-6">
                        <div class="summry_col">
                          <h4 class="heading-title"> Select Payment Method  </h4>
                          <ul ng-init="payOpt = 1">
                            <li ng-show="toPayment.ccavenueStatus == 1" class="ng-hide">
                              <input type="radio" class="chk_cod chk_CCAvenue" ng-model="payOpt" value="1">
                              <label for="radioCCAvenue"> CCAvenue</label>
                            </li>
                            <li>
                              <div>
                                <input name="paymentMethod" type="radio" class="chk_cod cod codChk" id="radioCod" value="3">
                                <label for="radioCod" class="codText"> CASH ON DELIVERY (<?php echo htmlspecialchars_decode(Session::get('currency_symbol')); ?>200)</label>
                              </div>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="text-right loginpad">
                      <button class="button button-black nomargin" value="">Cancel</button>
                      <a href="order-success.php" class="button button-default nomargin">PLACE ORDER</a>
                    </div>
                  </form>
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
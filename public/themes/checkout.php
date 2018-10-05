<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<?php include( 'includes/head.php'); ?>
<style>
  div#tab-login-register ul li {
    width: 31.33%;
    max-width: 100%;
    color: #fff !important;
}
  div#tab-login-register ul li a {
    color: #fff !important;
}
  </style>
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
    <div id="content" class="site-content single-product">
    <div class="container">
        <div class="checkout">
            <div class="panel-group"  id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel loginPanel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <span class=" ">1.</span> Login / Register
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6 col-sm-8 col-xs-12 login_form_col">
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
                            <div class="panel-body padd0" style="padding:0;">
                            <form method="post">
                                        <div class="loginF login_form" style="display: block; margin-bottom: 20px;">
                                            <div class="form-group">
                                                <input type="text" name="loginemail" class="form-control ExistEmail" id="userEmail" placeholder="Mobile / Email *">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="loginpassword" class="form-control ExistPassword ExistingUserPassword" id="pwd" placeholder="Password *">
                                            </div>
                                            <div class="form-group">
                                                <div class="col-xs-12 continue-cancel-btnbox">
                                                    <input type="submit" id="ExistUserCon" class="button new_user_btn ExistUserLogin continueStep" data-continue="loginPanel" value="CONTINUE">
                                                    <button type="button" class="button login_btn">CANCEL</button>
                                                    <div class="pull-right">
                                                        <label> <a href="/forgot-password" class="pull-right forgot-link"> Forgot Password ? </a></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                            </div>
                          </div>
                        </div>
                        <div class="tab-content clearfix" id="new-user">
                          <div class="panel panel-default nobottommargin noborder noshadow">
                            <div class="panel-body padd0" style="padding:0;">
                            <form role="form" method="post" class="login_form loginFormNewUser" style="display: block; margin-bottom: 20px;" id="checkoutRegisterFormid">
                              <div class="row">
                                        <div class="form-group col-md-6">
                                            <input name="firstname" type="text" class="form-control" placeholder="First Name *">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input name="lastname" type="text" class="form-control" placeholder="Last Name">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <input name="telephone" type="text" id="regtelephone" class="form-control" placeholder="Mobile *">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <input name="email" type="email" id="regEmail" class="form-control" placeholder="Email">
                                            
                                        </div>                                       
                                        <div class="form-group col-md-12">
                                            <input name="password" type="password" id="password" class="form-control" placeholder="Password *">

                                        </div>
                                        <div class="form-group col-md-12">
                                            <input name="cpassword" type="password" class="form-control" placeholder="Confirm Password *">
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12 continue-cancel-btnbox">
                                                <input type="submit"vaue="CONTINUE" class="button">                                    
                                                <input type="button" value="CANCEL" class="button login_btn newUserCancel">
                                            </div>    
                                        </div>
</div>
                                    </form>
                            </div>
                          </div>
                        </div>
                        <div class="tab-content clearfix" id="tab-guest">
                          <div class="panel panel-default nobottommargin noborder noshadow">
                            <div class="panel-body padd0" style="padding:0;">
                            <form id="guestCheckoutFrm" method="post">
                                        <div class="guestCheckoutFrm" style="display: block; margin-bottom: 20px;">
                                            <div class="form-group">
                                                <input name="guestemail" type="text" class="form-control ExistGEmail" id="guestEmail" placeholder="E-mail">
                                            </div>
                                            <div class="form-group">
                                                <div class="col-xs-12 continue-cancel-btnbox">
                                                    <input type="submit" class="button new_user_btn ExistUserLogin continueStep" data-continue="loginPanel" value="CONTINUE">
                                                    <button type="button"  class="button login_btn guestCheckoutCancel">CANCEL</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>                                   
                                
                                </div>
                                <div class="col-md-1 col-sm-1 col-xs-12 hidden-xs">
                                    <div class="or-vertical"></div>
                                    <div class="or-text-vertical text-center">OR</div>
                                </div>
                                <div class="or_horizantal"></div>
                                <div class="col-md-5 col-sm-3 col-xs-12">
                                    <span class="oricon hidden-sm hidden-xs"></span>
                                   <div class="social_media_login">
                                        <a id="fbLink"  class="col-md-12 col-sm-6 col-xs-12 fb_login_btn">
                                            <img src="images/fb_login.jpg" class="fb_login_btn"></img>
                                        </a>
                                        <a  href="#" class="col-md-12 col-sm-6 col-xs-12">
                                            <img src="images/g_login.jpg" class="g_login_btn"></img>
                                        </a>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel addressPanel panel-default">
                    <div class="panel-heading" role="tab" id="headingTwo">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <span class=" ">2.</span> Shipping Address
                            </a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body">
                        <div class="shpng_addrs_col">
                  <h4 class="heading-title">SELECT ADDRESS</h4>
                  <div class="row">
                    <div id="forAddress" class="">
                    <div class="col-md-4 ng-scope">
                                            <div class="adrs_col"> 
                                                <h1 class="bxtitle">
                                                    <div class="pull-left"><input class="pincod" type="radio" phno="97693707222" name="adddata"  value="34" ><label class="addL m100none"  for="radio2"><span><span></span></span>Address  (1)</label></div><div class="pull-right"> 
                                                        <a href="#addNewAddForm" class="box_action"><i class="icon-edit"></i> </a><a href="" class="box_action"><i class="icon-trash"></i> </a></div>
                                                    <div class="clearfix"></div></h1>
                                                <div class="adrs_cont" style="cursor:pointer;" codmsg="" id="adrs_34">
                                                    <p> Aparna  </p> 
                                                    <p>C/504, Neelkanth Business Park</p>
                                                    <p>Near Vidyavihar Station</p>
                                                    <p>India</p>
                                                    <p>Maharashtra</p> 
                                                    <p>Mumbai- 400021 </p>
                                                    <p>Mobile No: <span class="chkPhoneNo">97693707222</span></p>
                                                </div>

                                            </div>
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
                                          <option value="">City *</option>
                                          <option value="">India</option>
                                        </select>
                                      </div>
                                    <div class="form-group col-md-6">
                                      <input type="number" class="sm-form-control" name="" required="true" placeholder="Pin Code *"> </div>
                                      <div class="clearfix"></div>
                                      <div class="form-group col-md-6">
                                        <select class="sm-form-control" required="true">
                                          <option value="">State *</option>
                                          <option value="">India</option>
                                        </select>
                                      </div>
                                    <div class="form-group col-md-6">
                                      <select class="sm-form-control" required="true">
                                        <option value="">Country *</option>
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
                    </div>
                </div>
                <div class="panel billPanel panel-default">
                    <div class="panel-heading" role="tab" id="headingThree">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <span class=" ">3.</span> Bill Summary
                            </a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                        <div class="panel-body">
                            <div class="bill_summry_col">
                                <div class="row">
                                    <div class="col-md-5 col-sm-6 col-xs-12 ">
                                    <div class="summry_col">
                                            <h4 class="heading-title"><span class="pull-left summry_title">Bill</span></h4>
                                            <ul>
                                                <li>Subtotal: <span class="pull-right total_update_amt">31.48</span></li>                                <li>Referral Code: <span class="pull-right referalDiscount">0.00</span></li>
                                              </ul>
                                            <h2>Total <span class="currency-sym-in-braces">(€)</span><span class="pull-right TotalCartAmt">31.48</span></h2>
                                        </div>
                                    </div>
                                    <div class="col-md-7 col-sm-6 col-xs-12">
                                    <div class="summry_col">
                                            <h4 class="heading-title">
                                              <span class="pull-left summry_title">Current Reward Points</span>
                                              <span class="pull-right rwd_pont curRewPointsOld">0.00</span>
                                                <span class="pull-right rwd_pont curRewPointsNew" style="display:none;"></span>
                                              </h4>
                                            <ul class="sumcol-rightlist"> 
                                              <div>
                                                <li >
                                                  <div>
                                                    <div class="form-group">
                                                      <div class="col-sm-12 col-xs-12"> 
                                                        <p class="blue_text">Applicable only for first time users.</p>
                                                      </div>
                                                      <label for="email" class="col-md-12">REFERRAL</label>
                                                      <p class="col-md-8">
                                                        <input name="require_referal" type="text" class="form-control requireReferal cartinput" placeholder="Enter Referral Code">
                                                      </p>
                                                      <p class="col-md-4"><button type="button" class="btn new_user_btn full-width referalCodeClass"  id="requireReferalApply">APPLY</button>
                                                      </p>
                                                      </div>
                                                    </div>
                                                    </li>
                                                  </div>
                                                  <li>
                                                    <div class="form-group">
                                                        <p class="col-md-12 nomargin">
                                                            <textarea name="commentText" id="commentTT" class="form-control full-width" style="margin: 0px;width: 352px;height: 99px; resize: none;" placeholder="Enter additional comment if any."></textarea>
                                                        </p>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="small ptb10 pull-left red_text">*Discounts/Offers Not Applicable on International Orders and Official Merchandise.</div>
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <div class="col-md-12 form-group continue-cancel-btnbox">    
                                                               
                                            <button type="button" class="btn new_user_btn continueStep checkcod_yesno"  style="margin:5px 0 0 0;">CONTINUE</button>    
                                            <button ng-click="backToAddress()" class="button login_btn">BACK</button>  
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel paymentPanel panel-default">
                    <div class="panel-heading" role="tab" id="headingFour">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                <span class=" ">4.</span>  Payment 
                            </a>
                        </h4>
                    </div>
                    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                        <div class="panel-body">
                            <form method="post" name="frmTransaction" id="frmTransaction" class="codSubmit">
                                <div class="row">
                                <div class="col-md-5 pymt_mtd_colBox">
                                        <div class="pymt_mtd_col">
                                            <h4 class="heading-title">Shipping Details</h4>
                                            <div class="pymt_mtd_cont">
                                                <p>Aparna </p>
                                                <p>C/504, Neelkanth Business Park</p>
                                                <p>Near Vidyavihar Station</p>
                                                <p>India</p>
                                                <p>Maharashtra</p>
                                                <p>Mumbai- 400021</p> <span><u></u></span>
                                                <p>Mobile No: 97693707222</p>
                                            </div>
                                            <h5>Bill Amount: <b class="finalamt">31.48</b></h5>
                                            <p style="display:none;" class="codCharges">0</p>
                                        </div>
                                                                                <table class="table table-striped table-hover additional-charge">
                                            <tbody>
                                              <tr class="order-total">
                                                <th>Service charge </th>
                                                <td>0.00</td> 
                                            </tr>
                                            <tr class="order-total">
                                                <th>Transport charge </th>
                                                <td>0.00</td> 
                                            </tr>
                                                                                            <tr>
                                                    <th>Total <span class="currency-sym-in-braces">(€)</span></th>
                                                    <td><span class="total_amt ng-binding">31.48</span> </td> 
                                                </tr>
                                            </tbody></table>                                       
                                    </div>
                                    <div class="col-md-6">
                                        <div class="summry_col">
                                            <h4 class="heading-title"><span class="pull-left summry_title">Select Payment Method </span></h4>
                                            <ul>
                                                <li>
                                                    <input name="paymentMethod" data-method="" type="radio" class="chk_cod chk_EBS" id="radioEbs" value="1"><label for="radioEbs"><span><span></span></span> EBS</label>
                                                </li>
                                                <li>
                                                    <input name="paymentMethod" data-method="" type="radio" class="chk_cod chk_payUmoney" id="radioPayUmoney" value="2"><label for="radioPayUmoney"><span><span></span></span> PayU</label>
                                                </li>
                                                
                                                <div ng-show="toPayment.is_cod == 1"> 
                                                    <li>
                                                        <input name="paymentMethod" type="radio" class="chk_cod cod codChk" data-method="cod" id="radioCod" value="3"><label for="radioCod"><span><span></span></span> CASH ON DELIVERY </label>
                                                    </li> 
                                                </div>                                                   
                                                <li>
                                                    <input name="paymentMethod" type="radio" data-method="" class="chk_cod chk_paypal" id="radioPaypal" value="4"><label for="radioPaypal"><span><span></span></span> PAYPAL</label>
                                                </li>
                                                <li>
                                                    <input name="paymentMethod" type="radio" data-method="" class="chk_cod chk_razPay" id="radioRazpay" value="5"><label for="radioRazpay"><span><span></span></span> RAZORPAY</label>
                                                </li>
                                                <li>
                                                    <input name="paymentMethod" data-method="" type="radio" class="chk_cod chk_citrus" id="radioCitrus" value="6"><label for="radioCitrus"><span><span></span></span> Citrus</label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                <div class="clearfix"></div>
                                <div class="form-group">  
                                
                                    <div class="col-md-12 form-group continue-cancel-btnbox">                         
                                            <a onclick="location.href='order-success.php?theme=fs1';"><input type="button" value="PLACE ORDER" class="btn new_user_btn"> </a>
                                            <button type="button"  class="btn login_btn">BACK</button> 
                                    </div>  
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
                <div id="OutofStockPopUp" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-body">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title center">Oops! Please check your cart items</h4>
                                </div>
                                <div class="modal-body row">
                                    <div class="col-md-12 center">    
                                        <p>Your order cannot be processed as one or more product(s) in your cart is out of stock. Sorry for the inconvenience caused.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
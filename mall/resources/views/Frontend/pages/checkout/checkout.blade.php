@extends('Frontend.layouts.default')
@section('content')
<style>
    .hidepanel{opacity: .5; pointer-events: none;}
    .pincodeMessage{color:#1ABC9C}
</style>
<section id="page-title">
    <div class="container clearfix">
        <h1>Checkout</h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('home')}}">Home</a>
            </li>
            <li class="active">Checkout</li>
        </ol>
    </div>
</section>
<div id="content" class="site-content single-product">
    <input type="hidden" id="pincodeStatus" value="{{ @$pincodeStatus->status}}">
    <div class="container">
        <div class="checkout" ng-controller="checkoutController">
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
                                    <form role="form" class="login_form_btn clearfix">
                                        <div class="form-group col-md-12 clearfix nobottommargin">
                                            
                                                <a href="#loginEX" class="button login_btn existUserLog full-width-btn marRight-Bottom10">LOGIN</a>
                                            
                                            <!--  <div class="col-md-1 col-sm-4 col-xs-12 hidden-lg hidden-md">
                                                 <span class="btn or_btn">OR</span>
                                             </div>
                                             <div class="col-md-1 hidden-xs hidden-sm"><span class="or_small">OR</span></div> -->
                                            
                                                <button type="button" class="button new_user_btn newUserB full-width-btn marRight-Bottom10">NEW USER</button> 
                                           
                                            <!-- <div class="col-md-1 hidden-xs hidden-sm"><span class="or_small">OR</span></div> -->
                                            @if(isset($checkGuestCheckoutEnabled) && count($checkGuestCheckoutEnabled)>0)
                                            
                                                <button type="button" class="button new_user_btn guestCheckoutBtn full-width-btn norightMargin">Guest Checkout</button>
                                            
                                            @endif
                                            <small class="field_error newUserErr" style="color:red;display: none"></small>                                    
                                            <!--  <div class="col-md-12 col-sm-12 col-xs-12">
                                                 <label> <a href="{{ Route('forgotPassword')}}" style="color: #212c35; margin:5px;" class="pull-right"> Forgot Password ? </a></label>
                                             </div> -->
                                        </div>
                                        <div class="clearfix"></div>
                                    </form>
                                    <div class="form-group col-md-12">
                                        <small class="existUserError field_error" style="color:red;">[[ newUserError ]]</small>
                                    </div>
                                    <form id="loginEX" method='post' action="{{ route('get_exist_user_login_new')}}">
                                        <div class="loginF login_form">
                                            <div class="form-group col-md-12">
                                                <input type="text" name="loginemail" class="form-control ExistEmail"  id="userEmail" placeholder="Mobile / Email *">
                                                <div id="loginemail_checkout_re_validate" class="newerror"></div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <input type="password"  name="loginpassword"  class="form-control ExistPassword ExistingUserPassword" id="pwd" placeholder="Password *">
                                                <div id="loginpassword_checkout_re_validate" class="newerror"></div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-xs-12 continue-cancel-btnbox">
                                                    <input type="submit" ng-click="loginExistingUser()" id="ExistUserCon" class="button new_user_btn ExistUserLogin continueStep" data-continue="loginPanel" value="CONTINUE">
                                                    <button type="button" ng-click="loginExistingCancel()" class="button login_btn">CANCEL</button>
                                                    <div class="forgotBox">
                                                        <a href="{{ Route('forgotPassword')}}" class="pull-right forgot-link"> Forgot Password ? </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <form role="form" method='post' class="login_form loginFormNewUser" action='{{ route('new_user_login_new')}}' style="display:none; margin-bottom:20px;" id='checkoutRegisterFormid'>
                                        <div class="form-group col-md-6">
                                            <lable>First Name</lable>
                                            <input name='firstname' type="text" class="form-control" placeholder="First Name *">
                                            <div id="firstname_checkout_re_validate" class="newerror"></div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <lable>Last Name</lable>
                                            <input name='lastname' type="text" class="form-control" placeholder="Last Name">
                                            <div id="lastname_checkout_re_validate" class="newerror"></div>
                                        </div>
                                          <div class="form-group col-md-12">
                                            <lable>Country Code</lable>
                                                <select class="form-control county_code" required="true" name="country_code">
                                     <option value="">Select Country Code</option>
                                     <option value="+91">(+91) India</option>
                                      <option value="+880">(+880) Bangladesh</option>
                                     </select>
                                      
                                            <div id="country_code_checkout_re_validate" class="newerror"></div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <lable>Mobile</lable>
                                            <input  name='telephone' type="text" id="regtelephone"  class="form-control" placeholder="Mobile *">
                                            <p id="telephone_exists" style="color:red;margin-bottom:0px;"></p>
                                            <div id="telephone_checkout_re_validate" class="newerror"></div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <lable>Email</lable>
                                            <input  name='email' type="email" id="regEmail" class="form-control" placeholder="Email">
                                            <div id="email_checkout_re_validate" class="newerror"></div>
                                            <p id="email_exists" style="color:red;margin-bottom:0px;"></p>
                                        </div>                                       
                                        <div class="form-group col-md-12">
                                            <lable>Password</lable>
                                            <input  name='password' type="password" id='password' class="form-control" placeholder="Password *">
                                            <div id="password_checkout_re_validate" class="newerror"></div>

                                        </div>
                                        <div class="form-group col-md-12">
                                            <lable>Confirm Password</lable>
                                            <input name='cpassword' type="password" class="form-control" placeholder="Confirm Password *">
                                            <div id="cpassword_checkout_re_validate" class="newerror"></div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12 continue-cancel-btnbox">
                                                <input type="submit" ng-click="newUserLog()" value='CONTINUE' class="button">                                    
                                                <input type="button" value="CANCEL" class="button login_btn newUserCancel">
                                            </div>    
                                        </div>
                                    </form>
                                    <form id="guestCheckoutFrm" method="post">
                                        <div class="guestCheckoutFrm" style="display:none; margin-bottom:20px;">
                                            <div class="form-group col-md-12">
                                                <input name="guestemail" type="text" class="form-control ExistGEmail"  id="guestEmail" placeholder="E-mail">
                                                <div id="guestemail_checkout_re_validate" class="newerror"></div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-xs-12 continue-cancel-btnbox">
                                                    <input  type="submit" ng-click="doGuestCheckout()" class="button new_user_btn ExistUserLogin continueStep" data-continue="loginPanel" value="CONTINUE">
                                                    <button type="button" ng-click="loginExistingCancel1()" class="button login_btn guestCheckoutCancel">CANCEL</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-1 col-sm-1 col-xs-12 hidden-xs">
                                    <div class="or-vertical"></div>
                                    <div class="or-text-vertical text-center">OR</div>
                                </div>
                                <div class="or_horizantal"></div>
                                <div class="col-md-5 col-sm-3 col-xs-12">
                                    <span class="oricon hidden-sm hidden-xs"></span>
                                   <div class="social_media_login">
                                        <?php // route('home')}}/login/facebook/{{Crypt::encrypt(Request::url())?>
                                        <a id="fbLink"  class="col-md-12 col-sm-6 col-xs-12 fb_login_btn"  onclick="fbLogin()">
                                            <img src="{{ Config('constants.frontendPublicImgPath').'/fb_login.jpg'}}" class="fb_login_btn"></img>
                                        </a>
                                        <?php //route('home')}}/login/google/{{Crypt::encrypt(Request::url())?>
                                        <a  href="{{route('home')}}/login/google/{{Crypt::encrypt(Request::url())}}"   class="col-md-12 col-sm-6 col-xs-12">
                                            <img src="{{Config('constants.frontendPublicImgPath').'/g_login.jpg'}}" class="g_login_btn"></img>
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
                                <h5>SELECT ADDRESS</h5>
                                <div class="row">
                                    <div id='forAddress' class="" >
                                        <div class="col-md-4"   ng-repeat="add in addressData">
                                            <div class="adrs_col"  ng-init="addid = add.id" > 
                                                <h1 class="bxtitle">
                                                    <div class="pull-left"><input ng-init="adddata = addressData[0].id" data-cod="[[ add.cod ]]" codmsg="[[ add.codmsg ]]" class="pincod" type="radio" phno='[[ add.phone_no ]]' addCodMsg="[[ add.codmsg ]]" name="adddata" ng-model="adddata" value="[[ add.id ]]"  ng-click="addSel(addid)" /><label class="addL m100none" for="radio2" ><span><span></span></span>Address  ([[$index +1]])</label></div><div class="pull-right"> 
                                                        <a href="#addNewAddForm" data-ng-click="editAdd(addid)" class="box_action"><i class="icon-edit"></i> </a><a href=""  data-ng-click="deleteAdd(addid)" class="box_action"><i class="icon-trash"></i> </a></div>
                                                    <div class="clearfix"></div></h1>
                                                <div class="adrs_cont" ng-click="selAddB(addid)" style="cursor:pointer;" codmsg="[[add.codmsg]]" id="adrs_[[addid]]" >
                                                    <p> [[ add.firstname ]] [[ add.lastname ]] </p> 
                                                    <p>[[ add.address1 ]]</p>
                                                    <p>[[ add.address2 ]]</p>
                                                    <p>[[ add.countryname ]]</p>
                                                    <p>[[ add.statename ]]</p> 
                                                    <p>[[ add.city ]]- [[ add.postcode ]] <span ng-show="add.codmsg != ''">- <u> [[ add.codmsg ]]</u></span></p>
                                                    <p>Mobile No: <span class='chkPhoneNo'>[[ add.phone_no ]]</span></p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- <span id="editAdd"></span> -->
                                    <div class="col-md-4" id="continueStep">
                                        <div class="add_adrs_col">
                                            <a data-ng-click="showNewAddDiv();">
                                                <i class="icon-line-circle-plus plus_icon"></i><br>
                                                Add Address 
                                            </a>
                                        </div>
                                    </div>  
                                    <div class="clearfix"></div>                              
                                    <div class="col-lg-12 newAddFormDiv" style="display:none;">
                                        <form role="form" class="login_form" id='addNewAddForm' novalidate method='post' style="margin:0px;">
                                            <div class="form-group col-md-6">
                                                <lable>First Name *</lable>
                                                <input type="hidden" name="id" id="addI" ng-value="getAddData.id">
                                                <input type="text" class="form-control" name='firstname' required="true" ng-model="getAddData.firstname">
                                                <div id="firstname_checkout_new_add_form" class="newerror"></div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <lable>Last Name </lable>
                                                <input type="text" class="form-control" name='lastname'  ng-model="getAddData.lastname">
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="form-group col-md-6">
                                                <lable>Address Line 1 *</lable>
                                                <input type="text" class="form-control" name='address1'  required="true" maxlength='35'  ng-model="getAddData.address1">
                                                <div id="address1_checkout_new_add_form" class="newerror"></div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <lable>Address Line 2 </lable>
                                                <input type="text" class="form-control" name='address2' maxlength='35'  ng-model="getAddData.address2"> 
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="form-group col-md-6">
                                                <lable>City *</lable>
                                                <input type="text" name='city' class="form-control"  required="true"  ng-model="getAddData.city" >
                                                <div id="city_checkout_new_add_form" class="newerror"></div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <lable>Pin Code *</lable>                                             
                                                <i style="display: none" class="icon-refresh fa-spin pincodeMessageLoader "></i>  <span class="pincodeMessage"></span>
                                                <input type="text" name='postal_code' id="pincode_check" class="form-control" autocomplete="false"  ng-model="getAddData.postcode">
                                                <div id="postal_code_checkout_new_add_form" class="newerror"></div>
                                            </div>
                                            <div class="clearfix"></div>                                           
                                            <div class="form-group col-md-6">
                                                <lable>State *</lable>
                                                <select name="state" class="form-control zone" required="true" 
                                                        ng-model="getAddData.zoneid"> 
                                                    <option value="">Please Select </option>
                                                    <option ng-repeat="zone in zones" value="[[ zone.id ]]" >[[ zone.name ]]</option>
                                                </select>
                                                <div id="state_checkout_new_add_form" class="newerror"></div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <lable>Country *</lable>
                                                <select name="country_id"   class="form-control" required="true"  ng-change="countryChangedValue(getAddData.countryid)"
                                                        ng-model="getAddData.countryid">
                                                    <option value="">Please Select </option>
                                                    <option ng-repeat="contr in country"  value="[[ contr.id ]]">[[ contr.name  ]] </option>
                                                </select>
                                                <div id="country_id_checkout_new_add_form" class="newerror"></div>
                                            </div> 
                                            <div class="clearfix"></div>
                                            <div class="form-group col-md-6">
                                                <lable>Mobile No. *</lable>
                                                <input type="text" name='phone_no' class="form-control"  required="true" ng-model="getAddData.phone_no">
                                                <div id="phone_no_checkout_new_add_form" class="newerror"></div>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="form-group">
                                                <!--                                                <div class="col-md-3 col-sm-4 col-xs-12">
                                                                                                  <button type="submit" id="newAdFB" ng-click="addNewAddSubmit()" class="btn new_user_btn" style="margin:5px 0;">SUBMIT</button>
                                                                                                </div>-->
                                                <!--                                                <div class="col-md-3 col-sm-4 col-xs-12">
                                                                                                  <a href="#shippingPanel"><button type="button"  ng-click="addNewAddCancel()" class="btn login_btn" style="margin:5px 0 0 0">CANCEL</button></a>
                                                                                                </div>-->
                                            </div>
                                    </div>
                                    <div class="hidden-lg hidden-md" style="float:left; width:100%;"><br></div>
                                    <div class="col-md-12 form-group continue-cancel-btnbox mobPadd0-15">     
                                    <input type="submit" ng-click="addressContinue()" class="button new_user_btn toBillSummary continueStep" data-continue="shippingPanel" value="CONTINUE">
                                        <a href="{{ route('cart')}}" class="button new_user_btn pull-right">BACK</a>    
                                       
                                    </div>
                                    </form>
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
                                                <li>Subtotal: <span class="pull-right total_update_amt">[[billSummary.subtotal * billSummary.currency_val| number: 2 ]]</span></li>
<!--                                                <li>Shipping: <span class="pull-right">[[(billSummary.shipping)?billSummary.shipping:'-' ]]</span></li>-->
                                                <!--<li>Voucher: <span class="pull-right voucherUsedAmount">0</span></li>-->

                                                @if(@$feature['coupon'] == 1)
                                                <li>Coupon: <span class="pull-right">[[billSummary.coupon* billSummary.currency_val | number: 2]]</span></li>
                                                @endif

                                                @if(@$feature['manual-discount'] == 1)
<!--                                                <li>Discount: <span class="pull-right discountUsedAmount">[[billSummary.discount * billSummary.currency_val| number: 2]]</span></li>-->
                                                @endif                                             
                                                @if(@$feature['loyalty'] == 1)
                                                <li>Reward Points: <span class="pull-right  cashbackUsedAmount">0.00</span></li>
                                                @endif
                                                <!-- <li>Gifting Charges: <span class="pull-right">[[billSummary.gifting ]]</span></li> -->
                                                @if(@$feature['referral'] == 1)
                                                <li>Referral Code: <span class="pull-right referalDiscount">0.00</span></li>
                                                @endif
                                            </ul>
                                            <h2>Total <span class="currency-sym-in-braces">(<?php //echo !empty(Session::get('currency_symbol')) ? Session::get('currency_symbol') : '';  ?>)</span><span class="pull-right TotalCartAmt">[[billSummary.finaltotal * billSummary.currency_val| number:2 ]]</span></h2>
                                        </div>
                                    </div>
                                    <div class="col-md-7 col-sm-6 col-xs-12">
                                        <div class="summry_col">
                                            <h4 class="heading-title" ng-show="billSummary.cashback > 0">
                                                @if(@$feature['loyalty'] == 1)
                                                <span class="pull-left summry_title">Current Reward Points</span>
                                                <span class="pull-right rwd_pont curRewPointsOld">[[billSummary.cashback * billSummary.currency_val| number: 2   ]]</span>
                                                <span class="pull-right rwd_pont curRewPointsNew hide" style=""></span>
                                                @endif
                                            </h4>
                                            <ul class="sumcol-rightlist"> 
                                                @if(@$feature['loyalty'] == 1)
                                                <li ng-if="[[billSummary.cashback]] > 0"><div class="cashbackAmt"><input id="checkbox1" ng-model="cashback" ng-change="reqCashback()" class="requireCashback" type="checkbox" name="requireCashback" value="1" > <label for="checkbox1"><p><a href="" target="_blank" class="blue_text">Check Reward Points</a></p></label>
                                                        <p class="cashbackMsg" style="display:none;" ></p></div>
                                                </li>
                                                @endif
                                                <div ng-if="[[billSummary.address.country_id]] == 99">
                                                    @if(@$feature['referral'] == 1)
                                                    <li ng-if="billSummary.orderCount <= 0">
                                                        <div ng-if="billSummary.checkReferral == 1" >

                                                            <div class="form-group"  >
                                                                <div class="col-sm-12 col-xs-12"> 
                                                                    <p class="blue_text">Applicable only for first time users.</p>
                                                                    <p class="referalMsg" style="display:none;color:red;font-size:13px;margin-top:15px" ></p>
                                                                </div>
                                                                <label for="email" class="col-md-12">REFERRAL</label>
                                                                <p class="col-md-8 mb15"><input name="require_referal" type="text" class="sm-form-control requireReferal cartinput" placeholder="Enter Referral Code"></p>
                                                                <p class="col-md-4 mb15"><button type="button" class="btn new_user_btn full-width referalCodeClass" ng-model="referalCode" ng-click="applyReferal()" id="requireReferalApply">APPLY</button></p>

                                                            </div>
                                                        </div>
                                                    </li>
                                                    @endif
                                                    <div ng-if="billSummary.checkVoucher == 1">
                                                        @if(@$feature['des'] == 1)
                                                        <!--                                                        <li> 
                                                                                                                    <div class="form-group">
                                                                                                                        <label for="email" class="col-md-12">GIFT VOUCHER</label>
                                                                                                                        <p class="col-md-8"><input name="user_voucher_code" type="text" class="form-control userVoucherCode cartinput" placeholder="Enter Voucher Code"></p>
                                                                                                                        <p class="col-md-4"><button type="button" class="btn new_user_btn" ng-click="voucherApply()" id="voucherApply">APPLY</button></p>
                                                                                                                        <div class="col-sm-12 col-xs-12"><p class="vMsg" style="display:none;color:red;font-size:13px;margin-top:15px" ></p></div>
                                                                                                                    </div>
                                                                                                                </li>-->
                                                        @endif
                                                    </div>
                                                    @if(@$feature['manual-discount'] == 1)
<!--                                                    <li>   
                                                        <div class="form-group">
                                                            <label for="email" class="col-md-12 lbl-discount">Discount</label>
                                                            <span class="col-md-4">
                                                                <select class="form-control full-width" name="user-level-disc-type" id="user-level-disc" >
                                                                    <option >Please Select</option>
                                                                    <option value="1">Percentage</option>
                                                                    <option value="2">Absolute</option>
                                                                </select> 
                                                            </span>
                                                            <span class="col-md-4">
                                                                <input name="user_level_discount" type="text" class="form-control userLevelDiscount full-width" placeholder="Enter value for discount">
                                                            </span>
                                                            <span class="col-md-4">
                                                                <button type="button" class="btn new_user_btn full-width" ng-click="userlevelDiscApply()" id="userlevelDiscApply">APPLY</button>
                                                            </span>
                                                            <div class="col-sm-12 col-xs-12">
                                                                <p class="dMsg" style="display:none;color:red;font-size:13px;margin-top:15px" ></p>
                                                            </div>
                                                        </div>
                                                    </li> -->
                                                    @endif
                                                </div>
                                                <li>
                                                    <div class="form-group">
                                                        <p class="col-md-12 mb15">
                                                            <textarea name="commentText" id="commentTT" class="sm-form-control full-width"  placeholder="Enter additional comment if any."></textarea>
                                                        </p>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="small ptb10 pull-left red_text" ng-if='billSummary.address.country_id != 99'>*Discounts/Offers Not Applicable on International Orders and Official Merchandise.</div>
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <div class="col-md-12 form-group continue-cancel-btnbox">    
                                                               
                                            <button type="button" class="btn new_user_btn continueStep checkcod_yesno" ng-click="toPaymentF()" data-continue="billPanel" style="margin:5px 0 0 0;">CONTINUE</button>    
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
                            <form method="post"  action="[[toPayment.frmAction ]]" name="frmTransaction" id="frmTransaction" class="codSubmit">
                                <div class="row">
                                    <div class="col-md-5 pymt_mtd_colBox">
                                        <div class="pymt_mtd_col">
                                            <h4 class="heading-title">Shipping Details</h4>
                                            <div class="pymt_mtd_cont">
                                                <p>[[ toPayment.address.firstname ]] [[ toPayment.address.lastname ]]</p>
                                                <p>[[ toPayment.address.address1 ]]</p>
                                                <p>[[ toPayment.address.address2 ]]</p>
                                                <p>[[ toPayment.address.countryname ]]</p>
                                                <p>[[ toPayment.address.statename ]]</p>
                                                <p>[[ toPayment.address.city ]]- [[ toPayment.address.postcode ]]</p> <span><u>[[ toPayment.cod_msg ]]</u></span>
                                                <p>Mobile No: [[ toPayment.address.phone_no ]]</p>
                                            </div>
                                            <h5>Bill Amount: <span class="currency-sym"><?php //echo !empty(Session::get('currency_symbol')) ? Session::get('currency_symbol') : '';  ?></span>  <b class="finalamt">[[ toPayment.payamt | number : 2 ]]</b></h5>
                                            <p style="display:none;" class="codCharges">0</p>
                                        </div>
                                        @if(@$feature['additional-charge'] == 1)
                                        <table class="table table-striped table-hover additional-charge">
                                            <tr class="order-total" ng-repeat="x in toPayment.additional_charge.details">
                                                <th>[[ x.label| capitalize ]]  <span class="currency-sym-in-braces"></span></th>
                                                <td>[[ x.applied * toPayment.currency_val | number: 2 ]]</td> 
                                            </tr>
                                            @else 
                                            <table class="table table-striped table-hover additional-charge">
                                                @endif
                                                <tr>
                                                    <th>Total <span class="currency-sym-in-braces"></span><?php //echo !empty(Session::get('currency_symbol')) ? "(".Session::get('currency_symbol').")" : '';  ?></th>
                                                    <td><span class="total_amt">[[ toPayment.finalAmt | number: 2]]</span> </td> 
                                                </tr>
                                            </table>                                       
                                    </div>
                                    <input type="hidden" name="mode" value="[[toPayment.ebsMode ]]">
                                    <input type="hidden" name="account_id" value="[[toPayment.ebsAccountId ]]">
                                    <input type="hidden" name="reference_no" value="[[ toPayment.orderId ]]">
                                    <input type="hidden" name="return_url" value="[[ toPayment.retUrl ]]">
                                    <input type="hidden" name="amount" value="[[ toPayment.payamt ]]" class='amtChkClass orderAmt'>
                                    <input type="hidden" name="description" value="[[ toPayment.commentDesc ]]" class=''>
                                    <input type="hidden" name="name" value='[[ toPayment.address.firstname +" "+ toPayment.address.lastname]]'>
                                    <input type="hidden" name="address" value='[[ toPayment.address.address1 + " " + toPayment.address.address2]]'>
                                    <input type="hidden" name="city" value="[[toPayment.address.city]]">
                                    <input type="hidden" name="state" value="[[toPayment.address.zone_id]]">
                                    <input type="hidden" name="postal_code" value="[[toPayment.address.postcode]]">
                                    <input type="hidden" name="country" value="[[toPayment.address.countryIsoCode]]">
                                    <input type="hidden" name="phone" value="[[toPayment.address.phone_no]]">
                                    <input type="hidden" name="email" value="[[ toPayment.email ]]">
                                    <div class="col-md-6" ng-if="toPayment.finalAmt > 0">
                                        <div class="summry_col">
                                            <h4 class="heading-title"><span class="pull-left summry_title">Select Payment Method </span></h4>
                                            <ul ng-init="payOpt = 1">
                                                <li ng-show="toPayment.ebsStatus == 1">
                                                    <input name="paymentMethod"   data-method = '' type="radio" class="chk_cod chk_EBS" ng-model="payOpt" ng-click="paymentmethodChk($event)" id="radioEbs"  name="radio" value="1"><label for="radioEbs"   ><span><span></span></span> EBS</label>
                                                </li>
                                                <li ng-show="toPayment.payUmoneyStatus == 1">
                                                    <input name="paymentMethod"   data-method = '' type="radio" class="chk_cod chk_payUmoney" ng-model="payOpt" ng-click="paymentmethodChk($event)" id="radioPayUmoney"  name="radio" value="2"><label for="radioPayUmoney"   ><span><span></span></span> PayU</label>
                                                </li>
                                                <!--                                                <li ng-show="toPayment.address.country_id == 99 && toPayment.codStatus == 1">-->
                                                <div ng-show="toPayment.is_cod == 1"> 
                                                    <li>
                                                        <input  name="paymentMethod" type="radio" ng-model="payOpt" ng-click="paymentmethodChk($event)" class="chk_cod cod codChk" data-method = 'cod' name="radio"  id="radioCod"  value="3"><label for="radioCod"   ><span><span></span></span> CASH ON DELIVERY <span ng-show="toPayment.cod_charges > 0">(<span class="currency-sym"></span> <?php //echo !empty(Session::get('currency_symbol')) ? Session::get('currency_symbol') : '';  ?>[[ toPayment.cod_charges * toPayment.currency_val |number :2 ]])</span></label>
                                                    </li> 
                                                </div>                                                   
<!--                                                <li>
                                                    <input   name="paymentMethod" type="radio"  data-method = '' class="chk_cod chk_paypal"  ng-model="payOpt" ng-click="paymentmethodChk($event)"  id="radioPaypal"  name="radio" value="4"><label  for="radioPaypal"   for="radio2"><span><span></span></span> PAYPAL</label>
                                                </li>-->
<!--                                                <li>
                                                    <input name="paymentMethod" type="radio"  data-method = '' class="chk_cod chk_razPay"  ng-model="payOpt" ng-click="paymentmethodChk($event)"  id="radioRazpay" name="radio" value="5"><label   for="radioRazpay"  for="radio2"><span><span></span></span> RAZORPAY</label>
                                                </li>-->
<!--                                                <li ng-show="toPayment.citrusPayStatus == 1">
                                                    <input name="paymentMethod"   data-method = '' type="radio" class="chk_cod chk_citrus" ng-model="payOpt" ng-click="paymentmethodChk($event)" id="radioCitrus"  name="radio" value="6"><label for="radioCitrus"   ><span><span></span></span> Citrus</label>
                                                </li>-->
                                                <li >
                                                    <input name="paymentMethod"   data-method = '' type="radio" class="chk_cod chk_cit_pay" ng-model="payOpt" ng-click="paymentmethodChk($event)" id="radioCityPay"  name="radio" value="7"><label for="radioCityPay"   ><span><span></span></span> PayOnline</label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group">  
                                
                                    <div class="col-md-12 form-group continue-cancel-btnbox">                         
                                            <input type="button" ng-click="placeOrder($event)" value="PLACE ORDER" class="btn new_user_btn">  

                                            <button type="button"  class="btn login_btn" ng-click="backToBill()">BACK</button> 
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
                                        <p>Your order cannot be processed as one or more product(s) in your cart is out of stock or disabled. Sorry for the inconvenience caused.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                  <div id="internationallyProdPopUp" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-body">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title center">Oops! Please check your Country</h4>
                                </div>
                                <div class="modal-body row">
                                    <div class="col-md-12 center">    
                                        <p>Your order cannot be processed as we are not deliver International. Sorry for the inconvenience caused.</p>
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
@stop
@section('myscripts')
<script type="text/javascript">
    $('#pincode_check').keydown(function () {
        $(".pincodeMessageLoader").show();
        $(".pincodeMessage").hide();
        $(".pincodeMessageLoader").hide();
        setTimeout(function () {
            var pincode = $('#pincode_check').val();
          if(pincode==''){
              $(".pincodeMessage").css('color', "");
              return false;
          }
            console.log(pincode);
            $.ajax({
                url: "{{route('checkPincodeHome')}}",
                type: 'POST',
                data: {pincode: pincode},
                success: function (data) {
                    $(".pincodeMessage").css('color', "");
                    if (data.errorType == 'error') {
                        $(".pincodeMessage").show();
                        $(".pincodeMessage").css('color', 'red');
                        $(".pincodeMessage").text(data.message);
                    }
                    if (data.errorType == 'success') {
                        $(".pincodeMessage").show();
                        $(".pincodeMessage").text(data.message);
                    }

                    if (data.errorType == 'errorNotCont') {
                        //  console.log('inside err type');
                        $(".pincodeMessage").show();
                        $(".pincodeMessage").css('color', 'red');
                        $(".pincodeMessage").text(data.message);
                        $(".toBillSummary").attr('disabled', 'disabled');
                    } else {
                        $(".toBillSummary").removeAttr('disabled');
                    }
                },
                error: function (data) {
                    console.log(data);
                    $(".pincodeMessageLoader").hide();
                }

            });
        }, 0);
    });
    $(".total_update_amt").text();
    $(".finalamt").text();

    function editAddInt() {
        console.log("edit adsdfsdfsdfd");
        $("#internationallyProdPopUp").modal("hide");
    }

    $(document).ready(function () {

     
        $(".newUserB").click(function () {
            $(".loginF").css("display", "none");
            $(".guestCheckoutFrm").css("display", "none");
            $(".loginFormNewUser").css("display", "block");
        });

        $(".existUserLog").click(function () {
            $(".loginF").css("display", "block");
            $(".loginFormNewUser").css("display", "none");
            $(".guestCheckoutFrm").css("display", "none");
        });
        $(".newUserCancel").click(function () {
            $(".error").text("");
            $('.loginFormNewUser').find("input[type=text], textarea,input[type=password],input[type=email]").val("");
            $(".loginFormNewUser").css("display", "none");
        });
        $(".guestCheckoutBtn").click(function () {
            $(".loginF").css("display", "none");
            $(".loginFormNewUser").css("display", "none");
            $(".guestCheckoutFrm").css("display", "block");
            console.log('guest');
        });
        $(".guestCheckoutCancel").click(function () {
            $(".error").text("");
            $('.guestCheckoutFrm').find("input[type=email]").val("");
            $(".guestCheckoutFrm").css("display", "none");
        });
        $('.loginF').keypress(function (e) {
            var key = e.which;
            if (key == 13)  // the enter key code
            {
                $('#ExistUserCon').click();
                return false;
            }
        });
        $('.newAddFormDiv').keypress(function (e) {
            var key = e.which;
            if (key == 13)  // the enter key code
            {
                $('#newAdFB').click();
                return false;
            }
        });
     

       });  

     

    function getAdditionalcharge() {
        var coupon_amt = parseInt($("#coupon_amt_used").val());
        var order_amt = parseInt($(".ordT").val());
        var price = order_amt - coupon_amt;
        var total_amt = 0;
        $.ajax({
            url: "{{ route('admin.additional-charges.getAditionalCharge') }}",
            type: 'POST',
            data: {price: price},
            cache: false,
            success: function (msg) {
                //  console.log($("tr.order-total").nextAll().html());
                $(".additional-charge").empty();
                $.each(JSON.parse(msg), function (i, v) {
                    if (i == 'list') {
                        $.each(v, function (j, w) {
                            $(".additional-charge").append('<tr><th>' + j + '</th><td>' + w + '</td>');
                        })
                    }

                    total_amt = price + v;
                });

                $(".additional-charge").append('<tr><th>Total (included aditional charges)</th><td>' + total_amt.toFixed(2) + '</td>');
                $(".ordP").val(total_amt.toFixed(2));
            }
        });

    }
</script>
<script>
    $(document).ready(function () {
        var height = Math.max($(".sameheight1").height(), $(".sameheight2").height());
        $(".sameheight1").height(height);
        $(".sameheight2").height(height);
    });

// $('#userEmail').blur(function(){
//   
//    var ep_emailval = $('#userEmail').val();
//    console.log(ep_emailval);
//    var intRegex = /[0-9 -()+]+$/;
//
//if(intRegex.test(ep_emailval)) {
//   console.log("is phone");
//   if((ep_emailval.length < 10) || (!intRegex.test(ep_emailval)))
//    {
//     alert('Invalid Email/Phone.');
//     //return false;
//    }
//
//} else{
// var eml = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;       
//        console.log("is email");
//        if (eml.test(ep_emailval) == false) {
//    alert("Invalid Email/Phone.");
//   // $("#<%=txtEmail.ClientID %>").focus();
//    //return false;
// }
//    }
//});

    $('#regEmail').blur(function () {
        var email = $(this).val();
        if(email==''){
             $('#regEmail').removeClass('error');
            return false;
        }
        $.ajax({
            type: 'POST',
            url: "{{route('checkExistingUser')}}",
            data: {email: email},
            success: function (response) {
                console.log('@@@@' + response['status']);
                if (response['status'] == 'success') {
                    $('#regEmail').removeClass('error');
                    $('#email_exists').html('');
                } else if (response['status'] == 'fail') {
                    $('#regEmail').addClass('error');
                    $('#regEmail').val('');
                    $('#email_exists').html('<label class="error">' + response['msg'] + '</label>');
                }
            },
            error: function (e) {
                console.log(e.responseText);
            }
        });
    });

    $('#regtelephone').blur(function () {
        var telephone = $(this).val();
        if(telephone==''){
             $('#regtelephone').removeClass('error');
            return false;
        }
        $.ajax({
            type: 'POST',
            url: "{{route('checkExistingMobileNo')}}",
            data: {telephone: telephone},
            success: function (response) {
                console.log('@@@@' + response['status']);
                if (response['status'] == 'success') {
                    $('#regtelephone').removeClass('error');
                    $('#telephone_exists').html('');
                } else if (response['status'] == 'fail') {
                    $('#regtelephone').addClass('error');
                    $('#regtelephone').val('');
                    $('#telephone_exists').html('<label class="error">' + response['msg'] + '</label>');
                }
            },
            error: function (e) {
                console.log(e.responseText);
            }
        });
    });
    $(window).load(function () {
        getCur();
    });
</script>
@stop
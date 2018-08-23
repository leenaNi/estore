 <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <style>
        .box-border {
            border: 1px solid gray;
        }
        
        .clear-fix {
            clear: both;
        }
        
        .header-title {
            float: left;
            width: 100%;
            margin: 0px;
            padding: 0px;
        }
    </style>
</head>

<body ng-app="inficart1">
    <div class="checkout" ng-controller="CheckoutCtrl">
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          <span class=" ">1</span> Login/ New User
        </a>
      </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        <div class="col-md-7">
                            <form role="form" class="login_form_btn">
                                <div class="form-group">
                                    <div class="col-md-5 col-sm-4 col-xs-12">
                                        <a href="#loginEX"><button type="button" class="btn login_btn existUserLog" ng-click="toggleLogin()">LOGIN</button></a>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12 hidden-lg hidden-md">
                                        <span class="btn or_btn">OR</span>
                                    </div>
                                    <div class="col-md-2 hidden-xs hidden-sm"><span class="or_small">OR</span></div>
                                    <div class="col-md-5 col-sm-4 col-xs-12">
                                        <button type="button" class="btn new_user_btn newUserB continueStep" data-continue="newUser_btn" ng-click="toggleRegister()">NEW USER</button>
                                    </div>
                                    <small class="field_error newUserErr"></small>
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <label> <a href=""  class="pull-right"> Forgot Password ? </a></label>
                                    </div>
                                </div>
                            </form>
                            <div class="clear-fix"></div>
                            <div class="login-form" ng-if="isLoginVisible">
                                <form id="loginEX" >
                                    <div class="loginF login_form">
                                        <div class="form-group col-md-12">
                                            <small class="existUserError field_error"></small>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <input type="email" class="form-control ExistEmail" id="userEmail" placeholder="E-mail">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <input type="password" class="form-control ExistPassword ExistingUserPassword" id="pwd" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <button type="button" ng-click="loginExistingUser()" id="ExistUserCon" class="btn new_user_btn ExistUserLogin continueStep"
                                                    data-continue="loginPanel">CONTINUE</button>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <button type="button"  ng-click="toggleLogin()" class="btn login_btn">CANCEL</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="clear-fix"></div>
                            
                            <div class="register-form" ng-if="isRegisterVisible">
                                <form role="form" method="post" class="login_form loginFormNewUser">
                                    <div class="form-group col-md-6">
                                        <lable>First Name</lable>
                                        <input name="firstname" type="text" class="form-control">
                                        <div id="firstname_checkout_re_validate" class="newerror"></div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <lable>Last Name</lable>
                                        <input name="lastname" type="text" class="form-control">
                                        <div id="lastname_checkout_re_validate" class="newerror"></div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <lable>E-mail Address</lable>
                                        <input name="email" type="email" class="form-control">
                                        <small class="errExUser field_error ng-binding"></small>
                                        <div id="email_checkout_re_validate" class="newerror"></div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <lable>Phone No.</lable>
                                        <input name="telephone" type="text" class="form-control">
                                        <div id="telephone_checkout_re_validate" class="newerror"></div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <lable>Password</lable>
                                        <input name="password" type="password" id="password" class="form-control">
                                        <div id="password_checkout_re_validate" class="newerror"></div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <lable>Confirm Password</lable>
                                        <input name="cpassword" type="password" class="form-control">
                                        <div id="cpassword_checkout_re_validate" class="newerror"></div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="submit" value="CONTINUE" class="btn new_user_btn newUserContinue">
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="button" ng-click="toggleRegister()" value="CANCEL" class="btn login_btn newUserCancel">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <span class="oricon hidden-sm hidden-xs"></span>
                            <div class="social_media_login">
                                <a href="#" class="col-md-12 col-sm-6 col-xs-12">
 Sign in using Facebook
</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingTwo">
                    <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          <span class=" ">2</span> Shipping Address
        </a>
      </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body">
                        <div id="forAddress" class="">
                            <div class="col-md-4 box-border">
                                <div class="add_adrs_col">
                                    <a ng-click="toggleAddAddress()">
                                        <i class="fa fa-plus-circle plus_icon"></i><br> Add Address
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4 box-border">
                                <div class="adrs_col">
                                    <h1><input  type="radio" name="adddata">
        <label class="addL m100none ng-binding" for="radio2"> 
            Address (1)</label> <a href=""   class="pull-right box_action"><i class="fa fa-times"> Delete</i></a>
<a href="#addNewAddForm"  class="pull-right box_action"><i class="fa fa-pencil">Edit </i></a></h1>
                                    <div class="adrs_cont" id="adrs_125169">
                                        <p class=""> Swapnil Patwa </p>
                                        <p class="">504</p>
                                        <p class=""></p>
                                        <p class="">Mumbai</p>
                                        <p class="">India</p>
                                        <p class="">Pincode : 400050</p>
                                        <p class="">Mobile No :7566999975</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 box-border">
                                <div class="adrs_col">
                                    <h1><input  type="radio" name="adddata">
        <label class="addL m100none ng-binding" for="radio2"> 
            Address (2)</label> <a href=""   class="pull-right box_action"><i class="fa fa-times">Delete </i></a>
<a href="#addNewAddForm"  class="pull-right box_action"><i class="fa fa-pencil">Edit </i></a></h1>
                                    <div class="adrs_cont" id="adrs_125169">
                                        <p class=""> Swapnil Patwa </p>
                                        <p class="">504</p>
                                        <p class=""></p>
                                        <p class="">Nagpur</p>
                                        <p class="">India</p>
                                        <p class="">Pincode : 400050</p>
                                        <p class="">Mobile No :7566999975</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="add-address" ng-if="addAddress">
                            <div class="col-lg-12 newAddFormDiv">
                                <form role="form" class="login_form" id="addNewAddForm" novalidate="novalidate" method="post">
                                    <div class="form-group col-md-6">
                                        <lable>First Name</lable>
                                        <input type="hidden" name="id" id="addI" ng-value="getAddData.id" value="">
                                        <input type="text" class="form-control" name="firstname" required="true">
                                        <div id="firstname_checkout_new_add_form" class="newerror"></div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <lable>Last Name</lable>
                                        <input type="text" class="form-control" name="lastname">
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group col-md-6">
                                        <lable>Address Line 1</lable>
                                        <input type="text" class="form-control" name="address1" required="true" maxlength="35" ng-model="getAddData.address1">
                                        <div id="address1_checkout_new_add_form" class="newerror"><label for="address1" generated="true" class="error"> </label></div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <lable>Address Line 2</lable>
                                        <input type="text" class="form-control " name="address2" maxlength="35" ng-model="getAddData.address2">
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group col-md-6">
                                        <lable>Country</lable>
                                        <select name="country_id" class="form-control" required="true">
<option value="">Please Select </option>
 <option ng-repeat="country in country" value="13" class="ng-binding ng-scope">Australia </option> 
</select>
                                        <div id="country_id_checkout_new_add_form" class="newerror"></div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <lable>Pin Code</lable>
                                        <input type="text" name="postal_code" class="form-control" ng-model="getAddData.postcode" required="true">
                                        <div id="postal_code_checkout_new_add_form" class="newerror"><label for="postal_code" generated="true" class="error"> </label></div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group col-md-6">
                                        <lable>City</lable>
                                        <input type="text" name="city" class="form-control" required="true" ng-model="getAddData.city">
                                        <div id="city_checkout_new_add_form" class="newerror"><label for="city" generated="true" class="error"> </label></div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <lable>State</lable>
                                        <select name="state" class="form-control zone" required="true" ng-model="getAddData.zoneid">
<option value="">Please Select </option>
 <option ng-repeat="zone in zones" value="1475" class="ng-binding ng-scope">Andaman and Nicobar Islands</option>  </select>
                                        <div id="state_checkout_new_add_form" class="newerror"><label for="state" generated="true" class="error"> </label></div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group col-md-6">
                                        <lable>Phone No.</lable>
                                        <input type="text" name="phone_no" class="form-control" required="true" ng-model="getAddData.phone_no">
                                        <div id="phone_no_checkout_new_add_form" class="newerror"><label for="phone_no" generated="true" class="error"> </label></div>
                                    </div>
                                    <div class="clearfix"></div>
                                     
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingThree">
                    <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
         <span class=" ">3</span> Bill Summery
        </a>
      </h4>
                </div>
                <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                    <div class="panel-body">
                        <div class="panel-body">
                            <div class="bill_summry_col">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="summry_col">
                                            <h1><span class="pull-left summry_title header-title ">Bill</span></h1>
                                            <ul class="clear-fix">
                                                <li>Subtotal : <span class="pull-right">499</span></li>
                                                <li>Shipping : <span class="pull-right">0</span></li>
                                                <li>Voucher : <span class="pull-right voucherUsedAmount">0</span></li>
                                                <li>Coupon : <span class="pull-right">0</span></li>
                                                <li>Reward Points : <span class="pull-right cashbackUsedAmount">0</span></li>
                                                <li>Gifting Charges : <span class="pull-right">0</span></li>
                                                <li>Referral Code : <span class="pull-right referalDiscount">0</span></li>
                                            </ul>
                                            <h2>Total <span>(<?php echo htmlspecialchars_decode(Session::get('currency_symbol')); ?>)</span><span class="pull-right TotalCartAmt">499</span></h2>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="summry_col">
                                            <h1>
<span class="pull-left summry_title header-title ">Current Reward Points</span>
<span class="pull-right rwd_pont curRewPointsOld">0</span>
<span class="pull-right rwd_pont curRewPointsNew" ></span>
</h1>
                                            <ul class="clear-fix">
                                                <div>

                                                </div>
                                                <li>
                                                    <div class="col-sm-12 col-xs-12">
                                                        <textarea name="commentText" id="commentTT" class="form-control" placeholder="Enter additional comment if any."></textarea>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <div class="col-md-3 col-sm-4 col-xs-12 pull-right ">
                                        <button type="button" class="btn new_user_btn continueStep" ng-click="toPaymentF()" data-continue="billPanel">CONTINUE</button>
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-xs-12 pull-right">
                                        <button type="button" class="btn login_btn" ng-click="backToAddress()">BACK</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingFour">
                    <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
          <span class=" ">4</span> Select Payment Method
        </a>
      </h4>
                </div>
                <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                    <div class="panel-body">
                        <form method="post" name="frmTransaction" id="frmTransaction" class="codSubmit">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="pymt_mtd_col">
                                        <h1>Shipping Details</h1>
                                        <div class="pymt_mtd_cont">
                                            <p class="">Swapnil Patwa</p>
                                            <p class="">504</p>
                                            <p class=""></p>
                                            <p class="">Mumbai</p>
                                            <p class="">India</p>
                                            <p class="">Pincode :400050</p>
                                            <p class="">Mobile No : 7566999975</p>
                                        </div>
                                        <h1>Bill Amount : <span><?php echo htmlspecialchars_decode(Session::get('currency_symbol')); ?></span> <b class="finalamt ">499</b></h1>
                                        <p style="display:none;" class="codCharges">0</p>
                                    </div>
                                </div> 
                                <div class="col-md-4">
                                    <div class="summry_col">
                                        <h1><span class="pull-left summry_title">Select Payment Method</span></h1>
                                        <ul class="clear-fix">
                                            <li>
                                                <div>

                                                    <input name="paymentMethod" type="radio" class="chk_cod chk_EBS" ng-model="payOpt" ng-click="paymentmethodChk($event)" id="radioEbs"
                                                        value="1">
                                                    <label
                                                        for="radioEbs"><span><span></span></span>CARDS / NET BANKING</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div>
                                                    <input name="paymentMethod" type="radio" ng-model="payOpt" ng-click="paymentmethodChk($event)" class="chk_cod cod codChk "
                                                        data-method="cod" id="radioCod" value="2">
                                                    <label
                                                        for="radioCod"><span><span></span></span> CASH ON DELIVERY (<?php echo htmlspecialchars_decode(Session::get('currency_symbol')); ?>50)</label>
                                                </div>
                                                <div ng-show="toPayment.rprd == 1" class="ng-hide">
                                                    <p class="error">COD not available for Crowdfunded products!</p>
                                                </div>
                                                <div ng-show="(toPayment.is_cod == 1 &amp;&amp; toPayment.pin == '')" class="ng-hide">
                                                    <p class="error">COD not available for this Pincode!</p>
                                                </div>
                                            </li>
                                            <li>
                                                <input name="paymentMethod" type="radio" data-method="" class="chk_cod chk_paypal  ng-dirty -parse ng-touched" ng-model="payOpt"
                                                    ng-click="paymentmethodChk($event)" id="radioPaypal" value="3">
                                                <label for="radioPaypal"><span><span></span></span> PAYPAL</label>
                                            </li>
                                            <li>
                                                <input name="paymentMethod" type="radio" data-method="" class="chk_cod chk_razPay ng-pristine ng-untouched " ng-model="payOpt"
                                                    ng-click="paymentmethodChk($event)" id="radioRazpay" value="4">
                                                <label
                                                    for="radioRazpay"><span><span></span></span>RAZORPAY</label>
                                            </li>
                                        </ul>
                                    </div>
                                </div> 
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group">
                                <div class="col-md-3 col-sm-4 col-xs-12 pull-right">
                                    <button type="button" ng-click="placeOrder()" class="btn new_user_btn" style="margin:5px 0 0 0;">Place Order</button>
                                </div>
                                <div class="col-md-3 col-sm-4 col-xs-12 pull-right">
                                    <button type="button" class="btn login_btn" ng-click="backToBill()" style="margin:5px 0">BACK</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.12.2.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.0/angular.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        angular.module('inficart1', [])
    	.controller('CheckoutCtrl', ['$scope', function($scope){
            $scope.isLoginVisible = false;
            $scope.isRegisterVisible = false;
    		$scope.addAddress = false;
            $scope.toggleLogin = function (param) {
                $scope.isLoginVisible = !$scope.isLoginVisible;
            }
            $scope.toggleRegister = function (param) {
                $scope.isRegisterVisible = !$scope.isRegisterVisible;
            }
            $scope.toggleAddAddress = function (param) {
                $scope.addAddress = !$scope.addAddress;
            }
    	}])
    </script>
</body>

</html>
@extends('Admin.layouts.default')
@section('mystyles')
<script>
         //function that display value
         function dis(val)
         {
             document.getElementById("result").value+=val
         }

         //function that evaluates the digit and return result
         function solve()
         {
             let x = document.getElementById("result").value
             let y = eval(x)
             document.getElementById("result").value = y
         }

         //function that clear the display
         function clr()
         {
             document.getElementById("result").value = ""
         }
      </script>
      <!-- for styling -->
      <style>
         .caltitle{
         margin-bottom: 10px;
         text-align:center;
         width: 210px;
         color:green;
         border: solid black 2px;
         }

         input[type="button"].calbtn
         {
         background-color:#359bdb;
         color: #fff;
         border: solid white 2px;
         width:100%
         }

         input[type="text"].calresult
         {
         background-color:white;
         border: solid white 2px;
         width:100%
         }
      </style>
<style>
    .error{
        color:red;
        font-size: 13;
    }
    .trError{
        background-color: #ffece6 !important;

    }
    .nav-tabs-custom>.nav-tabs>li>a, .nav-tabs-custom>.nav-tabs>li>a:hover{cursor: not-allowed;}
    .cashbackAmt input {
        margin-right: 10px;
        position: relative;
        top: -18px;
    }
    ul.adminListing {
        list-style: none;
        padding-left: 0px !important;
        margin-top: 30px;
    }
    ul.adminListing li{margin-bottom: 15px;}
    .cashbackAmt p a {
        color: #0c00b3;
    }
    .mar-bot15{margin-bottom: 15px;}
</style>
<?php
/*echo "<pre>";
$data = session()->all();
echo "all session::".print_r($data);
echo "logged in admin id::".Session::get('loggedinAdminId');
exit;*/
?>
@stop
@section('content')
<section class="content-header">
    <h1>
        Orders
        <small>Create Order</small>
    </h1>
    <ol class="breadcrumb">
        <li> <i class="fa fa-cart-arrow-down"></i> Orders</li>
        <li class="active">Create Order</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="msg"></div>
            <div class="nav-tabs-custom orderContent">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#product-details" data-toggle="tab" aria-expanded="true">Product Details</a></li>
                    <li class=""><a href="#customer-details" data-toggle="tab" aria-expanded="true">Customer Details</a></li>
                    <li class=""><a href="#shipping-address" data-toggle="tab" aria-expanded="true">Shipping Address</a></li>

                </ul>
                <div  class="tab-content" >
                    <div class="tab-pane" id="customer-details">
                        <div class="panel-body noMobilePadding">
                            {{ Form::open(['id'=>'custInfo','class'=>'custInfo']) }}
                            <div class="line line-dashed b-b line-lg pull-in"></div>
                            <div class="form-group col-md-12">
                                {!! Form::label('Email Id', 'Mobile Number ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                                {!! Form::text('s_phone',null, ["autofocus" =>"autofocus","id"=>'customerEmail',"class"=>'form-control customerEmail validate[required]' ,"placeholder"=>'Enter Mobile Number', "required","tabindex"=>1]) !!}
                            </div>
                            <div class="line line-dashed b-b line-lg pull-in"></div>
                            <div class="form-group custdata col-md-6 mob-marBottom15" style="display: none;">
                                {!! Form::label('First Name', 'First Name ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                                {!! Form::text('cust_firstname',null, ["class"=>'form-control inpt validate[required]']) !!}
                            </div>
                            <div class="line line-dashed b-b line-lg pull-in"></div>
                            <div class="form-group custdata col-md-6 mob-marBottom15" style="display: none;">
                                {!! Form::label('Last Name', 'Last Name',['class'=>'control-label']) !!}
                                {!! Form::text('cust_lastname',null, ["class"=>'form-control inpt']) !!}
                            </div>
                            <div class="line line-dashed b-b line-lg pull-in" ></div>

                            <div class="form-group custdata col-md-6" style="display: none;">
                                {!! Form::label('Email Id', 'Email Id',['class'=>'control-label']) !!}
                                {!! Form::email('email_id',null, ["class"=>'form-control inpt']) !!}
                            </div>
                            <div class="line line-dashed b-b line-lg pull-in"></div>

                            <div class="form-group custdata col-md-6" style="display: none;">
                                {!! Form::label('Telephone', 'Mobile Number',['class'=>'control-label']) !!}
                                {!! Form::text('cust_telephone',null, ["class"=>'form-control inpt']) !!}
                            </div>

                            <div class="line line-dashed b-b line-lg pull-in" ></div>

                            {{ Form::hidden("customer_id",null,['class'=>'inpt']) }}
                            <div class="row">
                            <div class="col-md-12">
                                <div class="">
                                    <h4><b>Customer Credit<small>(Till Date)</small>: </b>
                                        <span class="currency-sym"></span><span class="customer-credit"></span>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <!---- START Coupon Section --->
                        <div class="col-md-6 noLeftpadding">
                                <div class="cal-shipping  mar-bot15">
                                    @if($feature['coupon'] == 1)
                                    <h4 class="heading-title">Apply Coupon</h4>
                                    <div class="list-group">
                                        <div class="list-group-item">
                                            <label class="ui-radio-inline">
                                                <input type="radio" name="radioEg" checked value="none">
                                                <span>None</span>
                                            </label>
                                            <p class="list-group-item-text">No coupon applicable</p>
                                        </div>
                                        @if(!$coupons->isEmpty())
                                        @foreach($coupons as $coupon)
                                        <div class="list-group-item">
                                            <label class="ui-radio-inline">
                                                <input type="radio" name="radioEg" value="{{ $coupon->coupon_code }}">
                                                <span>{{ $coupon->coupon_code }}</span>
                                            </label>
                                            <p class="list-group-item-text">{{ $coupon->coupon_name }}</p>
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                    @endif
                                </div><!-- .cal-shipping -->
                            </div>
                            <!--- END Coupon Section --->
                            <!--- START USER DISCOUNT --->
                            <div class="col-md-6 noLeftpadding">
                                <!-- Start voucher refferel Cashback Discount -->
                                <div class="summry_col">
                                    @if($feature['loyalty'] == 1)
                                    <!-- <h3>
                                        <span class="pull-left summry_title">Current Reward Points</span>&nbsp;&nbsp;
                                        <span class="currency-sym"></span>&nbsp;
                                        <span class="rwd_pont curRewPointsOld">0</span>
                                        <span class="pull-right rwd_pont curRewPointsNew" style="display:none;"></span>
                                    </h3> -->
                                    <ul class="adminListing">
                                        <!-- <li><div class="cashbackAmt"><input id="checkbox1"  class="requireCashback" type="checkbox" name="requireCashback" value="1" ><label for="checkbox1"><span></span>Apply Reward Points <p><a href="" target="_blank" class="blue_text">Check Reward Points</a></p></label>
                                                <p class="cashbackMsg" style="display:none;" ></p></div>
                                        </li> -->
                                        @endif
                                        <div>
                                            <div>
                                                <!-- <li>
                                                    <div class="form-group">
                                                        <label for="email" class="col-md-12">GIFT VOUCHER</label>
                                                        <p class="col-md-8"><input name="user_voucher_code" type="text" class="form-control userVoucherCode cartinput" placeholder="Enter Voucher Code"></p>
                                                        <p class="col-md-4"><button type="button" class="btn new_user_btn" id="voucherApply">APPLY</button></p>
                                                        <div class="col-sm-12 col-xs-12"><p class="vMsg" style="display:none;color:red;font-size:13px;margin-top:15px" ></p></div>
                                                    </div>
                                                </li>-->
                                                @if($feature['manual-discount'] == 1)
                                                <li class="clearfix  mar-bot15">
                                                    <div class="form-group">
                                                        <label for="email" class="col-md-12 noMobilePadding">Discount</label>
                                                        <span class="col-md-4">
                                                            <select class="form-control" name="user-level-disc-type" id="user-level-disc" >
                                                                <option >Please Select</option>
                                                                <option value="1">Percentage</option>
                                                                <option value="2">Absolute</option>
                                                            </select>
                                                        </span>
                                                        <span class="col-md-4">
                                                            <input name="user_level_discount" type="text" class="form-control userLevelDiscount" placeholder="Enter discount value">
                                                        </span>
                                                        <span class="col-md-4 col-xs-12 noMobilePadding">
                                                            <button type="button" class="btn new_user_btn noMob-leftmargin fullMobile-width" id="userlevelDiscApply">APPLY</button>
                                                        </span>
                                                        <div class="col-sm-12 col-xs-12">
                                                            <p class="dMsg" style="display:none;color:red;font-size:13px;margin-top:15px" ></p>
                                                        </div>
                                                    </div>
                                                </li>
                                                @endif
                                                @if($feature['referral'] == 1)
                                                <!-- <li>
                                                    <div class="form-group">
                                                        <label for="email" class="col-md-12 noMobilePadding">REFERRAL</label>
                                                        <p class="col-md-8 noMobilePadding"><input name="require_referal" type="text" class="form-control requireReferal cartinput" placeholder="Enter Referral Code"></p>
                                                        <p class="col-md-4 noMobilePadding"><button type="button" class="btn new_user_btn referalCodeClass noMob-leftmargin fullMobile-width" id="requireReferalApply">APPLY</button></p>
                                                        <div class="col-sm-12 col-xs-12 noMobilePadding">
                                                            <p class="blue_text">Applicable only for first time users.</p>
                                                            <p class="referalMsg" style="display:none;color:red;font-size:13px;margin-top:15px" ></p>
                                                        </div>
                                                    </div>
                                                </li> -->
                                                @endif
                                            </div>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                            <!--- END USER DISCOUNT --->
                            <!--- START Billing Info --->
                            <div class="clear-fix"></div>
                            <div class="col-md-6 noRightpadding noMobilePadding"></div>
                            <div class="col-md-6 noRightpadding noMobilePadding">
                                <table class="table tableVaglignMiddle table-hover priceTable">
                                   <!-- <tr class="shipping">
                                       <th>Subtotal</th>
                                       <td> 500<span class="couponUsedAmount" id=""> </span></td>
                                   </tr> -->
                                    <!-- <tr class="shipping">
                                        <th>Coupon Applied</th>
                                        <td><span class="couponUsedAmount" id="couponUsedcode"> </span></td>
                                    </tr>
                                    <tr class="shipping">
                                        <th>Coupon Value</th>
                                        <td><span class="couponUsedAmount" id="couponUsedAmount"> </span></td>
                                    </tr> -->
                                    <!--   <tr class="shipping">
                                        <th>Total ({{htmlspecialchars_decode(Session::get('currency_symbol'))}})</th>
                                        <td><strong> 450</strong><span class="couponUsedAmount" id="couponUsedAmount"> </span></td>
                                    </tr> -->
                                    <tr class="sub-total-amt">
                                        <th><div class="black-bg">Subtotal</div></th>
                                        <td><div class="black-bg"><strong> <span class="amount finalAmt"></span></strong></div></td>
                                    </tr>
                                    <tr class="order-total">
                                    </tr>
                                </table>
                            </div>
                            <!--- END Billing Info --->
                            <div class="form-group col-sm-12 noallMargin noallpadding">
                                <div class="custdata pull-right">
                                <button class="btn btn-black custBack mobileSpecialfullBTN">Back</button>
                                {!! Form::button('Next<i class="fa fa-spinner"></i>',["class" => "btn btn-primary custDetailsNext"]) !!}

                                <!-- <button class="btn btn-black cancelBtn pull-right">Cancel</button> -->
                                {!! Form::button('Place Order <i class="fa fa-spinner placeorderSpinner" aria-hidden="true"></i>',["class" => "btn btn-primary custplaceOrder mobileSpecialfullBTN"]) !!}
                                </div>

                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                    <div class="tab-pane" id="shipping-address">
                        <div class="panel-body">
                            <div  class="col-md-6 noallMargin noallpadding">
                                {!! Form::open(['id'=>'custAddForm']) !!}
                                <div class="row form-group">
                                    <div class="col-md-6 mob-marBottom15">
                                        {!! Form::label('First Name', 'First Name ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                                        {!! Form::text('firstname',null, ["class"=>'form-control inptAdd validate[required]', 'placeholder'=>'First Name']) !!}
                                    </div>
                                    <div class="col-md-6 mob-marBottom15">
                                        {!! Form::label('Last Name', 'Last Name',['class'=>'control-label']) !!}
                                        {!! Form::text('lastname',null, ["class"=>'form-control inptAdd','placeholder'=>'Last Name']) !!}
                                    </div>
                                </div>
                                <div class="line line-dashed b-b line-lg pull-in"></div>
                                <div class="row form-group">
                                    <div class="col-md-6 mob-marBottom15">
                                        {!! Form::label('Address Line 1', 'Address Line 1 ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                                        {!! Form::text('address1',null, ["class"=>'form-control inptAdd validate[required]','placeholder'=>'Address Line 1']) !!}
                                    </div>
                                    <div class="col-md-6 mob-marBottom15">
                                        {!! Form::label('Address Line 2', 'Address Line 2  ',['class'=>'control-label']) !!}
                                        {!! Form::text('address2',null, ["class"=>'form-control inptAdd','placeholder'=>'Address Line 2']) !!}
                                    </div>
                                </div>
                                <div class="line line-dashed b-b line-lg pull-in"></div>
                                <div class="row form-group">
                                    <div class="col-md-6 mob-marBottom15">
                                        {!! Form::label('Address Line 3', 'Address Line 3',['class'=>'control-label']) !!}
                                        {!! Form::text('address3',null, ["class"=>'form-control','placeholder'=>'Address Line 3']) !!}
                                    </div>
                                    <div class="col-md-6 mob-marBottom15">
                                        {!! Form::label('City', 'City ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                                        {!! Form::text('city',null,["class"=>'form-control inptAdd validate[required]', 'placeholder'=>'City']) !!}
                                    </div>
                                </div>
                                <div class="line line-dashed b-b line-lg pull-in"></div>
                                <div class="row form-group">
                                    <div class="col-md-6 mob-marBottom15">
                                        {!! Form::label('Pin Code', 'Pin Code ',['class'=>'control-label']) !!}
                                        {!! Form::text('postcode',null,["class"=>'form-control inptAdd','placeholder'=>'Pin Code']) !!}
                                    </div>
                                    <div class="col-md-6 mob-marBottom15">
                                        {!! Form::label('Country', 'Country ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                                        {!! Form::select('country_id',$ordcountries,null ,["class"=>'form-control country inptAdd validate[required]']) !!}      </div>

                                </div>
                                <div class="line line-dashed b-b line-lg pull-in"></div>
                                <div class="row form-group">
                                    <div class="col-md-6 mob-marBottom15">
                                        {!! Form::label('State', 'State/Zone ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                                        {!! Form::select('zone_id',$ordstates,null ,["class"=>'form-control inptAdd validate[required]', 'id'=>'state','placeholder'=>'Select State']) !!}

                                    </div>

                                    <div class="col-md-6 mob-marBottom15">
                                        {!! Form::label('Telephone', 'Mobile Number ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                                        {!! Form::text('phone_no',null,["class"=>'form-control inptAdd validate[required,custom[phone]]','placeholder'=>'Mobile Number']) !!}
                                    </div>
                                </div>
                                <div class="line line-dashed b-b line-lg pull-in"></div>
                                <div class="form-group noallMargin noallpadding">
                                    <button class="btn btn-black addBack noLeftMargin">Back</button>
                                    <button class="btn btn-black cancelBtn">Cancel</button>
                                    <!-- <button type="button" class="btn btn-warning skipAddress"> Skip</button> -->
                                    {!! Form::button('Place Order <i class="fa fa-spinner placeorderSpinner" aria-hidden="true"></i>',["class" => "btn btn-primary placeOrder mobileSpecialfullBTN"]) !!}
                                    <!-- {!! Form::submit('Next',["class" => "btn btn-primary NextAdd"]) !!} -->
                                </div>
                                {{ Form::hidden('address_id',null) }}
                                {{ Form::hidden('user_id',null) }}
                                {{ Form::hidden('cashback_hidden',null) }}
                                {{ Form::close() }}
                            </div>
                            <div  class="col-md-6 addressDiv pull-right"> </div>
                        </div>
                    </div>
                    <div class="tab-pane active" id="product-details">
                        <address class="pull-left col-md-6" class="shippedAdd"></address>
                        <div class="pull-right">
                            <button  class="btn sbtn btn-primary margin addCourse ">Add New Product</button>
                        </div>
                        <div class="pull-right">
                            <button  class="btn sbtn btn-primary margin openCal" >Show Calculator</button>
                            <!-- <a  class="btn sbtn btn-primary margin" href="#addcalculator" data-toggle="modal">Open Calculator</a> -->
                        </div>                        
                        <div class="panel-body">
                            {{ Form::open(['method'=>'post','route'=>'admin.orders.saveCartData','id'=>'prodDetailsForm']) }}
                            {{ Form::hidden('addressid',null) }}
                            {{ Form::hidden('userid',null) }}
                            <table class="table table-striped tableVaglignMiddle table-hover prodTable">
                                <thead>
                                <th width="30%">Product</th>
                                <th width="20%">Variant</th>
                                <th width="20%">Quantity </th>
                                <th width="20%">Offer Name </th>
                                <th width="20%">Offer Quantity </th>
                                <th width="20%">Unit Price ({{htmlspecialchars_decode(Session::get('currency_symbol'))}})</th>
                                <th width="20%">Discount </th>
                                <th width="20%">Price ({{htmlspecialchars_decode(Session::get('currency_symbol'))}})</th>
                                @if($feature['tax']==1)
                                <th width="20%">Tax ({{htmlspecialchars_decode(Session::get('currency_symbol'))}})</th>
                                @endif
                                <th width="5%">Action</th>
                                </thead>
                                <tbody class="newRow">
                                    <tr>
                                        <td width="30%">
                                            <input type="text" class="form-control prodSearch validate[required]" placeholder="Search Product" name="prod_search" >
                                        </td >
                                        <td width="20%">
                                            {{ Form::select("cartData[prod_id][sub_prod_id]",[],null,['class'=>'form-control subprodid validate[required]','style'=>"display:none;"]) }}
                                        </td>
                                        <td width="20%">
                                            <span class='prodQty' style="display:none"><input type="number" name='cartData[prod_id][qty] validate[required]' class='qty form-control' min="1" value="1"></span><span class="prdStock"></span>
                                        </td>
                                        <td width="20%">
                                            <span class='offer_name'>-</span>
                                        </td>
                                        <td width="20%">
                                            <span class='qty'>-</span>
                                        </td>
                                        <td width="20%">
                                            <span class='prodUnitPrice'>0</span>
                                        </td>
                                        <td width="20%">
                                            <span class='prodDiscount'>0</span>
                                        </td>
                                        <td width="20%">
                                            <span class='prodPrice'>0</span>
                                        </td>
                                        @if($feature['tax']==1)
                                        <td width="20%">
                                            <span class='taxAmt'>0</span>
                                        </td>
                                        @endif
                                        <td width='5%' class="text-center">
                                            <span class="delRow" data-toggle="tooltip" title="Delete" data-original-title="Remove"><i class="fa fa-trash fa-fw"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                                <tr style="border-bottom: 1px solid #f4f4f4;">
                                    <td colspan="2">
                                        <div class="pay-method">
                                            <label>Pay By</label>
                                            <select name='payment_mode' class="form-control paymode validate[required]">
                                                <option value="">Select Payment Mode</option>
                                                @foreach($paymentMethods as $paymentMethod)
                                                    @if ($paymentMethod->name == 'Cash')
                                                        <option selected value="{{ $paymentMethod->id }}">{{ $paymentMethod->name }}</option>
                                                    @else
                                                        <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td><span class="store-credit hide"><input type="text" onblur="updateRemainigAmount()" name='pay_amt' class='form-control validate_decimal' max="1" value="0" />
                                    </span></td>
                                    <td><span class="store-credit hide"><b>Remaining Amount:</b> <span class="" id="remaining-amt">0</span></span></td>

                                    <td>&nbsp;</td>
                                    <td colspan="2"> Subtotal: <b><span class="subtotal"><span class="currency-sym"></span> 0</span></b></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr id="validate_credit_amt" style="display: none">
                                    <td></td>
                                    <td><span style="color: red">Amount should be less than payable amount</span></td>
                                    <td></td><td></td>
                                </tr>
                                <tr style="border-bottom: 1px solid #f4f4f4;">
                                    <td colspan="1">
                                        <label class="custom-checkbox">
                                            <input type="checkbox" id="checkAll" />
                                            <span class="checkmark"></span>
                                        </label>
                                        <span class="cc-text">is Delivered</span>
                                    <!-- <label><input type="checkbox" value="1" class="form-inline" name="order_status" />is Delivered</label> -->
                                </td>
                                    <td colspan="2">{{ Form::textarea("remarks",null,['class'=>'form-control remark','rows'=>"1",'cols'=>"50","Placeholder"=>'Remarks (If any)']) }}</td>
                                    <td colspan="6"></td>
                                </tr>
                            </table>
                            <!------CAlculator -------->
                            <div class="row hide" id="calculator">
                                <div class="col-md-6">
                                    <table class="" style="padding: 5px;" border="1">
                                        <tr>
                                            <td style="padding: 5px;" colspan="3"><input class="calresult" type="text" id="result"/></td>
                                            <td style="padding: 5px;"><input class="calbtn" type="button" value="c" onclick="clr()"/> </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 5px;"><input class="calbtn" type="button" value="1" onclick="dis('1')"/> </td>
                                            <td style="padding: 5px;"><input class="calbtn" type="button" value="2" onclick="dis('2')"/> </td>
                                            <td style="padding: 5px;"><input class="calbtn" type="button" value="3" onclick="dis('3')"/> </td>
                                            <td style="padding: 5px;"><input class="calbtn" type="button" value="/" onclick="dis('/')"/> </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 5px;"><input class="calbtn" type="button" value="4" onclick="dis('4')"/> </td>
                                            <td style="padding: 5px;"><input class="calbtn" type="button" value="5" onclick="dis('5')"/> </td>
                                            <td style="padding: 5px;"><input class="calbtn" type="button" value="6" onclick="dis('6')"/> </td>
                                            <td style="padding: 5px;"><input class="calbtn" type="button" value="-" onclick="dis('-')"/> </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 5px;"><input class="calbtn" type="button" value="7" onclick="dis('7')"/> </td>
                                            <td style="padding: 5px;"><input class="calbtn" type="button" value="8" onclick="dis('8')"/> </td>
                                            <td style="padding: 5px;"><input class="calbtn" type="button" value="9" onclick="dis('9')"/> </td>
                                            <td style="padding: 5px;"><input class="calbtn" type="button" value="+" onclick="dis('+')"/> </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 5px;"><input class="calbtn" type="button" value="." onclick="dis('.')"/> </td>
                                            <td style="padding: 5px;"><input class="calbtn" type="button" value="0" onclick="dis('0')"/> </td>
                                            <td style="padding: 5px;"><input class="calbtn" type="button" value="=" onclick="solve()"/> </td>
                                            <td style="padding: 5px;"><input class="calbtn" type="button" value="*" onclick="dis('*')"/> </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <!------End CAlculator-------->
                            <div class="form-group text-right col-sm-12 noallMargin noAllpadding">
                                <div class="custdata pull-right">
                                    {!! Form::button('Next<i class="fa fa-spinner"></i>',["class" => "btn btn-primary prodNext"]) !!}
                                </div>
                                <button class="btn btn-black cancelBtn mobileSpecialfullBTN">Cancel</button>
                            </div>
                            {{ Form::close() }}
                        </div>
                        <table  style="display:none;">
                            <tbody class="toClonetr">
                                <tr>
                                    <td width="30%">
                                        <input type="text" class="form-control prodSearch validate[required]" placeholder="Search Product" name="prod_search">
                                    </td>
                                    <td width="20%">
                                        {{ Form::select("cartData[prod_id][sub_prod_id]",[],null,['class'=>'form-control subprodid validate[required]','style'=>"display:none;"]) }}
                                    </td>
                                    <td width="20%" >
                                        <span class='prodQty' style="display:none"><input type="number" min="1" value="1" name='cartData[prod_id][qty]' class='qty form-control'></span>
                                        <span class="prdStock"></span
                                    </td>
                                    <td width="20%">
                                        <span class='offer_name'>-</span>
                                    </td>
                                    <td width="20%">
                                        <span class='qty'>-</span>
                                    </td>
                                    <td width="20%">
                                        <span class='prodUnitPrice'>0</span>
                                    </td>
                                    <td width="20%">
                                        <span class='prodDiscount'>0</span>
                                    </td>
                                    <td width="20%">
                                        <span class='prodPrice'>0</span>
                                    </td>
                                    @if($feature['tax']==1)
                                    <td width="20%">
                                        <span class='taxAmt'>0</span>
                                    </td>
                                    @endif
                                    <td width="5%" class="text-center">
                                        <span class="delRow" data-toggle="tooltip" title="Delete" data-original-title="Remove"><i class="fa fa-trash fa-fw"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>                        
                        <!-- <div class="error">
                            <p>Note: Already purchased courses of customer will not be shown. </p>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
     <!-- <div id="addcalculator" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Calculate</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table border="1">
                            <tr>
                                <td colspan="3"><input class="calresult" type="text" id="result"/></td>
                                <td><input class="calbtn" type="button" value="c" onclick="clr()"/> </td>
                            </tr>
                            <tr>
                                <td><input class="calbtn" type="button" value="1" onclick="dis('1')"/> </td>
                                <td><input class="calbtn" type="button" value="2" onclick="dis('2')"/> </td>
                                <td><input class="calbtn" type="button" value="3" onclick="dis('3')"/> </td>
                                <td><input class="calbtn" type="button" value="/" onclick="dis('/')"/> </td>
                            </tr>
                            <tr>
                                <td><input class="calbtn" type="button" value="4" onclick="dis('4')"/> </td>
                                <td><input class="calbtn" type="button" value="5" onclick="dis('5')"/> </td>
                                <td><input class="calbtn" type="button" value="6" onclick="dis('6')"/> </td>
                                <td><input class="calbtn" type="button" value="-" onclick="dis('-')"/> </td>
                            </tr>
                            <tr>
                                <td><input class="calbtn" type="button" value="7" onclick="dis('7')"/> </td>
                                <td><input class="calbtn" type="button" value="8" onclick="dis('8')"/> </td>
                                <td><input class="calbtn" type="button" value="9" onclick="dis('9')"/> </td>
                                <td><input class="calbtn" type="button" value="+" onclick="dis('+')"/> </td>
                            </tr>
                            <tr>
                                <td><input class="calbtn" type="button" value="." onclick="dis('.')"/> </td>
                                <td><input class="calbtn" type="button" value="0" onclick="dis('0')"/> </td>
                               <td><input class="calbtn" type="button" value="=" onclick="solve()"/> </td>
                                <td><input class="calbtn" type="button" value="*" onclick="dis('*')"/> </td>
                            </tr>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
</section>
@stop
@section('myscripts')

<script>
$('button.openCal').click(function (){
    $('#calculator').toggleClass('hide');
    if($('#calculator').hasClass('hide')){
        $(this).text('Show Calculator');
    } else {
        $(this).text('Hide Calculator');
    }
});
var onSelectCustomer = 0;
var loggedInUserType = 0;
<?php
if (!empty(Session::get("login_user_type"))) {?>
    loggedInUserType =  <?php echo Session::get("login_user_type") ?>;
<?php
}
?>

var prodoffer = 0;
    jQuery.validator.addMethod("phonevalidate", function (telephone, element) {
        telephone = telephone.replace(/\s+/g, "");
        return this.optional(element) || telephone.length > 9 &&
                telephone.match(/^[\d\-\+\s/\,]+$/);
    }, "Please specify a valid Mobile number");
    $(".placeorderSpinner").hide();
    $('.nav-tabs a[href="#shipping-address"]').removeAttr('data-toggle');
    $('.nav-tabs a[href="#product-details"]').removeAttr('data-toggle');
    // $('.nav-tabs a[href="#product-details"]').tab('show');

    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }
    function calc() {
        prodPrice = 0;
        $.each($(".prodPrice"), function (prodpv) {
            prodPrice += parseInt($(this).text());
        });
        //console.log( prodPrice);exite;
        $(".subtotal").text(prodPrice);
    }

    function setValuesToInpt(custid, firstname, lastname, telephone, emailid, credit) {
        //alert("set val point::"+telephone);
        $("input[name='s_phone']").val(telephone);
        $("input[name='customer_id']").val(custid);
        $("input[name='cust_firstname']").val(firstname);
        $("input[name='cust_lastname']").val(lastname);
        $("input[name='cust_telephone']").val(telephone);
        $("input[name='email_id']").val(emailid);
        $(".customer-credit").html(credit);
        $(".customerEmail").css("border-color", "");
        $(".inpt").prop('readonly', false);
    }
    function removeError(thisEle) {
        thisEle.parent().parent().removeClass('trError');
    }
    function getAdd(addid) {
        addData = addid
        $.post("{{ route('admin.orders.getCustomerAdd') }}", {addData: addData}, function (data) {
            $.each(data, function (addk, addv) {
                $("input[name='" + addk + "']").val("");
                $("input[name='" + addk + "']").val(addv);
                if (addk == 'country_id' || addk == 'zone_id') {
                    $("select[name='" + addk + "']").val("");
                    $("select[name='" + addk + "']").val(addv);
                }
                if (addk == 'id')
                    $("input[name='address_id']").val(addv);
            });
        });
    }

    function getSubprods(prodid, ele) {
        var rows = $(".newRow").find('tr');
        //console.log($(".newRow").find('tr'));
        var selected_prod = [];
        var subprodid = 0;
        jQuery.each(rows, function (i, item) {
            subprodid = parseInt($(this).find('.subprodid').val());
            if (subprodid != "" && subprodid != null && subprodid != 'NaN') {

                if(subprodid == 'NaN')
                {
                    subprodid = 0;
                    selected_prod = [];
                }
                else
                {
                    selected_prod.push(subprodid);
                }

            }
        });
        prodid = prodid;
        prodSel = ele;
        removeError(prodSel);
        prodSel.attr("name", "cartData[" + prodid + "]");
        $.post("{{ route('admin.orders.getSubProds') }}", {prodid: prodid, data: selected_prod}, function (subprods) {
            prodSel.parent().parent().find('.subprodid').html("");
            // prodSel.parent().parent().find('.prodPrice').text(0);
            prodSel.parent().parent().find('.prodQty').show();
            if (subprods.length > 0) {
                prodSel.parent().parent().find('.subprodid').show();
                // attr('data-subpr', ui.item.id);
                subProdOpt = "<option value=''>Please select</option>";
                $.each(subprods, function (subprdk, subprdv) {
                    subprodname = subprdv.product.split("Variant (");
                    if (selected_prod.indexOf(subprdv.id) == -1) {
                        subProdOpt += "<option value='" + subprdv.id + "'>" + subprodname[1].replace(")", "") + "</option>";
                    }
                });
                prodSel.parent().parent().find('.subprodid').html(subProdOpt);
            } else {
                qty = prodSel.parent().parent().find('.qty').val();
                parentprdid = prodid;
                //console.log(parentprdid);exite;
                $.post("{{route('admin.orders.getProdPrice')}}", {parentprdid: parentprdid, qty: qty, pprd: 1, offerid:prodoffer}, function (price) {
                    //console.log(JSON.stringify(price));
                    prodSel.parent().parent().find('.prodUnitPrice').text(price.unitPrice);
                    prodSel.parent().parent().find('.prodDiscount').text(price.offer);
                    prodSel.parent().parent().find('.prodPrice').text(price.price);

                    if(typeof price.offerName === 'undefined')
                    {
                        prodSel.parent().parent().find('.offer_name').text('-');

                    }
                    else
                    {
                        prodSel.parent().parent().find('.offer_name').text(price.offerName);
                    }

                    if(typeof price.offerQty === 'undefined')
                    {
                        prodSel.parent().parent().find('.qty').text('-');

                    }
                    else
                    {
                        prodSel.parent().parent().find('.qty').text(price.offerQty);
                    }
                    $(".subtotal").text(price.price);
                    $(".finalAmt").text(price.price);
                    $("#amountallSubtotal").text(price.price);

                    if(price.offertype==2){
                        var countprod = price.offerProdCount;
                        $(".newRow").append(price.offerProd);
                        // while(countprod > 0){
                        //     $(".newRow").append($(".toClonetr").html());
                        //     countprod --;
                        // }
                    }

                    //prodSel.parent().parent().find('.prodPrice').text((price.price).toFixed(2));
                    <?php if ($feature['tax'] == 1) {?>
                    prodSel.parent().parent().find('.taxAmt').text((price.tax).toFixed(2));
                    <?php }?>
                    // calc();
                });
                prodSel.parent().parent().find('.subprodid').hide();
                clearAllDiscount();
            }
        });
    }

    $(".cancelBtn").on("click", function () {
        window.location.href = "{{ route('admin.orders.view') }}";
    });
    $("#customerEmail").autocomplete({
        source: "{{ route('admin.orders.getCustomerEmails') }}",
        minLength: 1,
        select: function (event, ui) {
            onSelectCustomer = 1;
            $(".msg").html('');
            ele = event.target;
            setValuesToInpt(ui.item.id, ui.item.firstname, ui.item.lastname, ui.item.telephone, ui.item.email , ui.item.credit);
            $(".custdata").show();

        }
    });
    $(".customerEmail").on("keyup", function () {
        //console.log("texbox click");
        //console.log("inselect sutomer val flag::"+onSelectCustomer);

        //console.log("logged in user type::"+loggedInUserType);
        if((parseInt(loggedInUserType) == 3) && (parseInt(onSelectCustomer) == 0))//if logged inusertype is distributor(3)
        {
            //alert("if");
            //dont submit the new user data
            $(".msg").html('please select user from suggestion list').css( "color", "red");
            return false;
        }
        else
        {
            //alert("else");
            $(".custdata").show();
        }

    });
    $(".customerEmail").on("change", function () {

        if((parseInt(loggedInUserType) == 3) && (parseInt(onSelectCustomer) == 0))//if logged inusertype is distributor(3)
        {
            //dont submit the new user data
            $(".custdata").hide();
            return false;
        }
        else
        {
            $(".custdata").show();
        }

        term = $(this).val();
        thisEle = $(this);
        thisEle.css("border-color", "");
        thisEle.closest("p").remove();
        $.post("{{route('admin.orders.getCustomerEmails') }}", {term: term}, function (res) {
            resp = JSON.parse(res);
            chkLengh = Object.keys(resp).length;
            //alert("check length::"+chkLengh);
            if (chkLengh == 1) {
                setValuesToInpt(resp[0].id, resp[0].firstname, resp[0].lastname, resp[0].telephone, resp[0].email, resp[0].credit);
            } else if (chkLengh == 0) {
                $(".inpt").removeAttr('readonly');
                $(".inpt").val('');
                phonev = $("input[name='s_phone']").val();
                $("input[name='cust_telephone']").val(phonev);
            }
        });
    });
    $(".skipAddress").on("click", function () {
        $('.nav-tabs a[href="#customer-details"]').removeAttr('data-toggle');
        $('.nav-tabs a[href="#shipping-address"]').removeAttr('data-toggle');
        $('.nav-tabs a[href="#product-details"]').tab('show');
        $("input[name='address_id']").val('')
    });
    $(".fa-spinner").hide();
    $(".custDetailsNext").on("click", function () {
        var valid = $("#custInfo").validationEngine('validate');
        //  if ($("#custInfo").valid()) {
        if (valid) {
            $(".fa-spinner").show();
            $.ajax({
                type: "POST",
                url: "{{ route('admin.orders.getCustomerData') }}",
                data: $(".custInfo").serialize(),
                cache: false,
                success: function (data) {
                    $(".fa-spinner").hide();
                    $("input[name='customer_id']").val(data.id);
                    $("input[name='user_id']").val(data.id);
                    $("input[name='firstname']").val(data.firstname);
                    $("input[name='lastname']").val(data.lastname);
                    $("input[name='phone_no']").val(data.telephone);
                    $(".curRewPointsOld").text(data.cashback);
                    $("input[name='cashback_hidden']").val(data.cashback);
                    address = data.addresses;
                    addDiv = "";
                    $.each(address, function (addk, addv) {
                        addData = JSON.stringify(addv);
                        addDiv += "<div class='col-md-6'><div class='box addressColumn paddingAll10'>";
                        addDiv += "<input data-add='" + addv.id + "' id='opt_" + addv.id + "'  class='addRadio pull-left marginright10' type='radio' value='" + addv.id + "' name='addRedioBut' >";
                        addDiv += "<div data-adddiv='" + addv.id + "' class='appendedAddDiv'  style='cursor:pointer;'><p>" + addv.firstname + " " + addv.lastname + "</p>";
                        addDiv += "<p>" + addv.address1 + " " + addv.address2 + " " + addv.address3 + "</p>";
                        addDiv += "<p>" + addv.city + " - " + addv.postcode + "</p>";
                        addDiv += "<p>" + addv.statename + "</p>";
                        addDiv += "<p>" + addv.countryname + "</p>";
                        addDiv += "<p> Contact Number: " + addv.phone_no + "</p>";
                        addDiv += "</div></div></div>";
                    });
                    $(".addressDiv").html(addDiv);
                    $("input[type='radio']:first").trigger('click');
                    $('.nav-tabs a[href="#shipping-address"]').tab('show')
                    $('.nav-tabs a[href="#customer-details"]').removeAttr('data-toggle');
                    $('.nav-tabs a[href="#product-details"]').removeAttr('data-toggle');
                }
            });
        } else {
            $("#custInfo").validationEngine();
        }
    });
    $(".addressDiv").delegate(".appendedAddDiv", "click", function (e) {
        att = $(this).attr('data-adddiv');
        $('#opt_' + att).prop('checked', true);
        getAdd(att);
    });
    $(".addressDiv").delegate(".addRadio", "click", function () {
        var addData = $(this).attr('data-add');
        getAdd(addData);
    });
    $(".country").on("change", function () {
        countryid = $(this).val();
        $.ajax({
            type: "POST",
            url: "{{ route('admin.orders.getCustomerZone') }}",
            data: {countryid: countryid},
            cache: false,
            success: function (data) {
                $("#state").html(data);
            }
        });
    });

    $(".prodNext").on("click", function (e) {
        var rowCount = $(".newRow").find('tr');
        if ($('.prodSearch').val() == '') {
            $('input[name=prod_search]').blur();
            $('input[name=prod_search]').focus();
            return false;
        }
        $(".product-empty").remove();

        if (rowCount.length <= 0) {
            $(".prodTable tbody.newRow").append('<tr class="product-empty" style="color:red"><th colspan="4">Please select at least one product </th></tr>');
            return false;
        }
        $.each($(".prodTable .prodPrice"), function () {
            if ($(this).text() == 0) {
                $(this).parent().parent().addClass("trError");
                $(".finalAmt").text('0.00');
            } else {
                $(this).parent().parent().removeClass("trError");
            }
        });

        $('.nav-tabs a[href="#customer-details"]').tab('show');
        $('.nav-tabs a[href="#shipping-address"]').removeAttr('data-toggle')
        $('.nav-tabs a[href="#product-details"]').removeAttr('data-toggle');
        $('.nav-tabs a[href="#customer-details"]').tab('show');

    });

    $(".NextAdd").on("click", function (e) {
        var valid = $("#custAddForm").validationEngine('validate');
        //  if ($("#custInfo").valid()) {
        e.preventDefault();
        if (valid) {
            $(".fa-spinner").show();
            $.ajax({
                type: "POST",
                url: "{{ route('admin.orders.saveCustomerAdd') }}",
                data: $("#custAddForm").serialize(),
                cache: false,
                success: function (res) {
                    if (res !== 0) {
                        $("input[name=addressid]").val(res.addressid);
                        $("input[name=userid]").val(res.userid);
                        // var  addData = $("input[name='address_id']").val();
                        $('.nav-tabs a[href="#product-details"]').tab('show');
                        $('.nav-tabs a[href="#shipping-address"]').removeAttr('data-toggle')
                        $('.nav-tabs a[href="#customer-details"]').removeAttr('data-toggle');
                        $('.nav-tabs a[href="#product-details"]').tab('show');
                    }
                }
            })
        } else {
            $("#custAddForm").validationEngine();
        }
    })

    $(".inptAdd").on('change', function () {
        $("input[name='address_id']").val("");
    });


    $(".prodSearch").autocomplete({
        source: "{{route('admin.orders.getSearchProds')}}",
        /* source: function(req, response){
         var rows = $(".newRow").find('tr');
         var selected_prod = [];
         jQuery.each(rows, function(i, item) {
         var prod_id = $(this).find('.prodSearch').attr('data-prdid');
         var subprodid = $(this).find('.subprodid').val();
         selected_prod.push({prod_id:prod_id,subprodid:subprodid});
         });
         console.log(selected_prod);
         $.ajax({
         type: "get",
         url:"{{route('admin.orders.getSearchProds')}}",
         data: {data:selected_prod,req:req},
         dataType:"json",
         success:response,
         })
         }, */
        minLength: 1,
        select: function (event, ui) {
            prodoffer = ui.item.offer;
            getSubprods(ui.item.id, $(this));
            $(this).attr('data-prdid', ui.item.id);
            $(this).attr('data-prdtype', ui.item.type);
            $(this).attr('data-prdoffer', ui.item.offer);

        }
    });

    $("table").delegate(".subprodid", "change", function () {
        subprdid = $(this).val();
        subp = $(this);

        parentprodid = subp.parent().parent().find('.prodSearch').attr('data-prdid');
        parentprodtype = subp.parent().parent().find('.prodSearch').attr('data-prdtype');
        prodoffer = subp.parent().parent().find('.prodSearch').attr('data-prdoffer');

        removeError(subp);
        $(this).attr("name", "cartData[" + parentprodid + "][subprodid]");
        qty = subp.parent().parent().find('.qty').val();
        subp.parent().parent().find('.qty').attr('subprod-id', subprdid);

        var that = $(this);
        if(parentprodtype != 2)
            var params = {subprdid: subprdid, qty: qty, pprd: 0,offerid:prodoffer};
        else
            var params = {qty: qty, parentprdid: parentprodid, pprd: 1, offerid:prodoffer};

        //$.post("{{route('admin.orders.getProdPrice')}}", {subprdid: subprdid, qty: qty, pprd: 0}, function (data) {
        $.post("{{route('admin.orders.getProdPrice')}}", params, function (data) {
            //subp.parent().parent().find('.prodPrice').text((data.price).toFixed(2));
            $("#selected_product_price").val(data.price);
            subp.parent().parent().find('.prodPrice').text(data.price);
            subp.parent().parent().find('.prodDiscount').text(data.offer);
            //that.closest('td').next('td').next('td').next('td').next('td').find('.prodPrice').text(data.price);
            $('.subtotal').text(data.price);
            $(".finalAmt").text(data.price);


            <?php if ($feature['tax'] == 1) {?>
                subp.parent().parent().find('.taxAmt').text((data.tax).toFixed(2));
            <?php }?>
            clearAllDiscount();
        });
    });
    $(".addCourse").on("click", function () {
        $(".product-empty").remove();
        $(".newRow").append($(".toClonetr").html());
        $(".prodSearch").autocomplete({
            source: "{{route('admin.orders.getSearchProds')}}",
            minLength: 1,
            select: function (event, ui) {
                getSubprods(ui.item.id, $(this));
                $(this).attr('data-prdid', ui.item.id);
                //$("#couponApply").click();
                // ApplyCoupon();
                //  clearAllDiscount();
            }
        });
    });

    $("table").delegate(".delRow", "click", function () {
        $(this).parent().parent().remove();
        clearAllDiscount();
    });

    $(".placeOrder").on("click", function () {

        chk = 0;
        $.each($(".prodTable tr"), function () {
            if ($(this).hasClass('trError')) {
                chk = 1;
            }
        });
        var rows = $(".newRow").find('tr');
        var prod = [];
        jQuery.each(rows, function (i, item) {
            if ($(item).attr('data-ppid') != "") {
                var prod_id = $(this).find('.prodSearch').attr('data-prdid');
                var subprodid = $(this).find('.subprodid').val();
                var qty = $(this).find('.qty').val();
                var prodPrice = $(this).find('.prodPrice').text();
                var data = {prod_id: prod_id, subprodid: subprodid, qty: qty, prodPrice: prodPrice};
                prod.push(data);
            }
        });
        var address_id = $("input[name=address_id]").val();
        var user_id = $("input[name=user_id]").val();
        var payment_mode = $(".paymode").val();
        var pay_amt = $("input[name=pay_amt]").val();
        var order_status = ($("input[name=order_status]").is(":checked"))? 1: 0;
        var remark = $(".remark").val();
        var post_data = {mycart: prod, pay_amt: pay_amt, order_status: order_status, payment_mode: payment_mode, remark: remark, user_id: user_id, address_id: address_id};
        if (chk == 0) {
            $(".placeorderSpinner").show();
            $.post("{{ route('admin.orders.saveCartData') }}", post_data, function (res) {
                $(".placeorderSpinner").hide();
                if (res == 1)
                    $("#invalidCoursePopUp").modal('show');
                if (res == 2)
                    $("#alreadyAdeedCoursePopUp").modal('show');
                if (res.status == 3) {
                    if($("input[name=order_status]").is(":checked")){
                        updateOrderStatus(res.orderId);
                    }
                    $(".orderContent").hide();
                    $(".msg").addClass("alert alert-success").text("Order Placed successfully.");
                } else if (res.status == 4) {
                    $(".msg").addClass("alert alert-danger").text("Error being place order. Please try again.");
                }
            });
        }
    });

    $(".custplaceOrder").on("click", function () {
        //add cust
        $("input[name='address_id']").val('');
        var valid = $("#custInfo").validationEngine('validate');
        //  if ($("#custInfo").valid()) {
        if (valid) {
            $(".fa-spinner").show();
            $.ajax({
                type: "POST",
                url: "{{ route('admin.orders.getCustomerData') }}",
                data: $(".custInfo").serialize(),
                cache: false,
                success: function (data) {
                    $(".fa-spinner").hide();
                    $("input[name='customer_id']").val(data.id);
                    $("input[name='user_id']").val(data.id);
                    $("input[name='firstname']").val(data.firstname);
                    $("input[name='lastname']").val(data.lastname);
                    $("input[name='phone_no']").val(data.telephone);
                    $(".curRewPointsOld").text(data.cashback);
                    $("input[name='cashback_hidden']").val(data.cashback);
                    address = data.addresses;
                    addDiv = "";

                }
            });
        } else {
            $("#custInfo").validationEngine();
        }
        //end

        chk = 0;
        $.each($(".prodTable tr"), function () {
            if ($(this).hasClass('trError')) {
                chk = 1;
            }
        });
        var rows = $(".newRow").find('tr');
        var prod = [];
        jQuery.each(rows, function (i, item) {
            if ($(item).attr('data-ppid') != "") {
                var prod_id = $(this).find('.prodSearch').attr('data-prdid');
                var subprodid = $(this).find('.subprodid').val();
                var qty = $(this).find('.qty').val();
                var prodPrice = $(this).find('.prodPrice').text();
                var data = {prod_id: prod_id, subprodid: subprodid, qty: qty, prodPrice: prodPrice};
                prod.push(data);
            }
        });
        var address_id = $("input[name=address_id]").val();
        var user_id = $("input[name=user_id]").val();
        var payment_mode = $(".paymode").val();
        var pay_amt = $("input[name=pay_amt]").val();
        var order_status = ($("input[name=order_status]").is(":checked"))? 1: 0;
        var remark = $(".remark").val();
        var post_data = {mycart: prod, pay_amt: pay_amt, order_status: order_status, payment_mode: payment_mode, remark: remark, user_id: user_id, address_id: address_id};
        if (chk == 0) {
            $(".placeorderSpinner").show();
            $.post("{{ route('admin.orders.saveCartData') }}", post_data, function (res) {
                $(".placeorderSpinner").hide();
                if (res == 1)
                    $("#invalidCoursePopUp").modal('show');
                if (res == 2)
                    $("#alreadyAdeedCoursePopUp").modal('show');
                if (res.status == 3) {
                    if($("input[name=order_status]").is(":checked")){
                        updateOrderStatus(res.orderId);
                    }
                    $(".orderContent").hide();
                    $(".msg").addClass("alert alert-success").text("Order Placed successfully.");
                } else if (res.status == 4) {
                    $(".msg").addClass("alert alert-danger").text("Error being place order. Please try again.");
                }
            });
        }
    });

    function updateOrderStatus(orderId) {
        var postData = { OrderIds: orderId, notify: 0, commentChanges: 1, status: 3, remark: 'Marked Delivered by admin POS', responseType: 'json'};
        $.post("{{ route('admin.orders.update.status') }}", postData, function (res) {
        });
    }
    $(".addBack").on("click", function (e) {
        e.preventDefault();
        $('.nav-tabs a[href="#customer-details"]').tab('show');
        $('.nav-tabs a[href="#shipping-address"]').removeAttr('data-toggle');
        $('.nav-tabs a[href="#product-details"]').removeAttr('data-toggle');
    });
    $(".custBack").on("click", function (e) {
        e.preventDefault();
        $('.nav-tabs a[href="#product-details"]').tab('show');
        $('.nav-tabs a[href="#customer-details"]').removeAttr('data-toggle');
        $('.nav-tabs a[href="#shipping-address"]').removeAttr('data-toggle');
    });
    $(".placeOrderBack").on("click", function (e) {
        e.preventDefault();
        $('.nav-tabs a[href="#shipping-address"]').tab('show');
        $('.nav-tabs a[href="#customer-details"]').removeAttr('data-toggle');
        $('.nav-tabs a[href="#product-details"]').removeAttr('data-toggle');
    });

    $("table").delegate(".qty", "change", function () {
        //console.log("inside qty");
        var qty = $(this).val();
        var qtty = $(this);
        var subprdid = $(this).parents("td").prev().find(".subprodid").val();
        var parentprdid = $(this).parents("td").siblings().find(".prodSearch").attr('data-prdid');
        if (subprdid == null || subprdid == "") {
            var prod = $("[data-prdid=" + parentprdid + "]");
            var pprd = 1;
            var data = {qty: qty, parentprdid: parentprdid, pprd: pprd, offerid:prodoffer};
        } else {
            var prod = $("[data-prdid=" + subprdid + "]");
            var pprd = 0;
            var data = {qty: qty, subprdid: subprdid, pprd: pprd, offerid:prodoffer};
        }

        //qtty.parent().parent().find('.prodPrice').attr('data-prdid', subprdid);


        $.ajax({
            type: "POST",
            url: "{{ route('admin.orders.getProdPrice') }}",
            data: data,
            cache: false,
            success: function (price) {
                qtty.closest("td").next('td').next('td').next('td').next('td').next('td').find('.prodPrice').text(price.price);
                //prod.parent().parent().find('.prodPrice').text((price.price));
                $(".subtotal").text(price.price);
                $(".finalAmt").text(price.price);
                prod.parent().parent().find('.prodDiscount').text(price.offer);
                var pqty = prodSel.parent().parent().find('.qty').val();
                var pstock = price.stock;
                if(pqty > pstock){
                    prodSel.parent().parent().find('.prdStock').text('Avalilabe Stock : '+price.stock).css('color', 'red');
                    var pqty = prodSel.parent().parent().find('.qty').val('');
                }else{
                    prodSel.parent().parent().find('.prdStock').text('');
                }

                <?php if ($feature['tax'] == 1) {?>
                qtty.parents("td").next().next().find('.taxAmt').text((price.tax));
                <?php }?>
                // ApplyCoupon();
                clearAllDiscount();
            }

        });
    });

    $("input[name='radioEg']").change(function () {
        event.preventDefault();
        ApplyCoupon();
    });


    function ApplyCoupon() {
        $(".code-err").remove();
        var rows = $(".newRow").find('tr');
        var input_code = $("input[name='radioEg']:checked").parent();
        var couponCode = $("input[name='radioEg']:checked").val()
        var prod = [];
        jQuery.each(rows, function (i, item) {
            if ($(item).attr('data-ppid') != "") {
                var prod_id = $(this).find('.prodSearch').attr('data-prdid');
                var subprodid = $(this).find('.subprodid').val();
                var qty = $(this).find('.qty').val();
                var prodPrice = $(this).find('.prodPrice').text();
                var data = {prod_id: prod_id, subprodid: subprodid, qty: qty, prodPrice: prodPrice, offerid:prodoffer};
                prod.push(data);
            }
        });
        // if (prod.length <= 0) {
        //     $(".finalAmt").text('0.00');
        //     getAdditionalcharge();
        //     return false;
        // }
        $.ajax({
            type: "POST",
            url: "{{ route('admin.orders.checkOrderCoupon') }}",
            data: {mycart: prod, couponCode: couponCode},
            dataType: "json",
            cache: false,
            success: function (msg) {
                $(".cmsg").css("display", "block");
                if (msg['remove'] == 1) {
                    if (couponCode != 'none') {
                        input_code.parent().append("<p class='code-err' style='color:red'>Coupon Code Invalid OR Not applicable on current cart value.</p>");
                    }
                    priceTaxUpdate(msg['cart']);
                    $(".coupon-code").remove();
                    $(".coupon-value").remove();
                    $(".subtotal").text(msg['subtotal'].toFixed(2));
                    $(".subtotal").text(msg['subtotal'].toFixed(2));
                    $(".finalAmt").text(msg['orderAmount'].toFixed(2));
                    $(".disc_indv").text("0.00");
                    $("#amountallSubtotal").text(msg[4]);
                } else {
                    $(".coupon-code").remove();
                    $(".coupon-value").remove();
                    var usedCouponAmount = (msg['disc']);
                    $.each(msg['individual_disc_amt'], function (key, value) {
                        $(".disc_indv" + key).text(value);
                    });
                    priceTaxUpdate(msg['cart']);
                    var coupon_td = '<tr class="coupon-code"><th>Coupon Applied</th><td><span class="couponUsedAmount" id="couponUsedcode">' + couponCode + '</span></td></tr><tr class="coupon-value"><th>Coupon Value</th><td><span class="couponUsedAmount" id="couponUsedAmount">' + usedCouponAmount.toFixed(2) + ' </span></td></tr>';
                    $(".priceTable tbody").prepend(coupon_td);
                    $(".subtotal").text(msg['subtotal'].toFixed(2));
                    $(".finalAmt").text(msg['orderAmount'].toFixed(2));
                    $("#amountallSubtotal").text(msg[4]);
                }
                updateRemainigAmount();
                getAdditionalcharge();
            }
        });
    }

    function getAdditionalcharge() {
        var price = parseFloat($(".finalAmt").text());
        var total_amt = 0;
        $.ajax({
            url: "{{ route('admin.additional-charges.getAditionalCharge') }}",
            type: 'POST',
            // data: {price : price},
            cache: false,
            success: function (msg) {
                $(".order-total").nextAll().remove();
                var data = JSON.parse(msg);
                if (!isEmpty(data)) {
                    $.each(JSON.parse(msg), function (i, v) {
                        if (i == 'list') {
                            $.each(v, function (j, w) {
                                $(".order-total").after('<tr><th>' + j + '</th><td>' + (w * <?php echo Session::get("currency_val") ?>) + '</td>');
                            })
                        }
                        total_amt = price + (v * <?php echo Session::get("currency_val") ?>);
                    });
                } else {
                    total_amt = price;
                }
                $(".order-total").parent().append('<tr><th>Total (Rs.)</th><td>' + total_amt.toFixed(2) + '</td>');
            }
        });
    }

    $(".requireCashback").click(function () {
        var user_id = $("input[name='user_id']").val();
        console.log(user_id);
        var checkbox = $("#checkbox1");
        var isChecked = checkbox.is(':checked');
        if (isChecked) {
            $.ajax({
                url: "{{ route('admin.orders.applyCashback') }}",
                type: 'POST',
                data: {userId: user_id},
                cache: false,
                success: function (data) {
                    $(".subtotal").text(data['subtotal'].toFixed(2));
                    $(".finalAmt").text(data['orderAmount'].toFixed(2));
                    $(".curRewPointsOld").text(data.cashbackRemain);
                    var cashback_td = '<tr class="cashback-code"><th>Cashback Applied</th><td><span class="cashbackUsedAmount" id="couponUsedcode">' + (data.cashbackUsedAmt).toFixed(2) + '</span></td></tr>';
                    $(".priceTable tbody").prepend(cashback_td);
                    priceTaxUpdate(data.cart);
                    updateRemainigAmount()
                    getAdditionalcharge();
                }
            });
        } else {
            $.ajax({
                url: "{{ route('admin.orders.applyCashback') }}",
                type: 'POST',
                data: '',
                cache: false,
                success: function (data) {
                    $(".subtotal").text(data['subtotal'].toFixed(2));
                    $(".finalAmt").text(data['orderAmount'].toFixed(2));
                    $(".cashback-code").remove();
                    $(".curRewPointsOld").text(data.cashbackRemain);
                    priceTaxUpdate(data.cart);
                    updateRemainigAmount();
                    getAdditionalcharge();
                }
            });
        }
    });

    function applyVoucher(voucherCode) {
        $.ajax({
            url: "{{ route('admin.orders.applyVoucher') }}",
            type: 'POST',
            data: {voucherCode: voucherCode},
            cache: false,
            success: function (data) {
                if (data != "invalid data") {
                    var VoucherVal = data.voucherAmount;
                    priceTaxUpdate(data.cart);
                    if (data.voucherAmount != null) {
                        $(".vMsg").css("display", "block");
                        $("#voucherApply").attr("disabled", "disabled");
                        $(".userVoucherCode").attr("disabled", "disabled");
                        var Cmsg = "<span style='color:green;'>Voucher Code Applied!</span> <a href='#' style='border-bottom: 1px dashed;' onclick='clearVouch()'>Remove!</a>";
                        $(".vMsg").html(Cmsg);
                        $(".subtotal").text(data['subtotal'].toFixed(2));
                        $(".finalAmt").text(data['orderAmount'].toFixed(2));
                        $(".curRewPointsOld").text(data.cashbackRemain);
                        var voucher_td = '<tr class="voucher-code"><th>Voucher Applied</th><td><span class="cashbackUsedAmount" id="couponUsedcode">' + (data.voucherAmount).toFixed(2) + '</span></td></tr>';
                        $(".priceTable tbody").prepend(voucher_td);
                    } else {
                        $("#voucherApply").removeAttr("disabled");
                        $(".userVoucherCode").removeAttr("disabled");
                        $(".subtotal").text(data['subtotal'].toFixed(2));
                        $(".finalAmt").text(data['orderAmount'].toFixed(2));
                        $(".voucher-code").remove();
                        if (data.clearCoupon) {
                            $(".vMsg").css("display", "none");
                        } else {
                            $(".vMsg").css("display", "block");
                            $(".vMsg").html("Invalid Voucher!");
                        }
                    }
                    updateRemainigAmount();
                    getAdditionalcharge();
                }
            }
        });
    }
    $("#voucherApply").click(function () {
        var voucherCode = $(".userVoucherCode").val();
        applyVoucher(voucherCode);
    });

    function clearVouch() {
        var voucherCode = '';
        applyVoucher(voucherCode);
    }

    function priceTaxUpdate(cart) {
        $.each(cart, function (key, value) {
            var id = value.id;
            var price = value.subtotal;
            if (value.options.tax_type == 2) {
                price = price + value.options.tax_amt;
            }
            var is_subprod = $("[subprod-id=" + value.options.sub_prod + "]").get();
            if (is_subprod != null && is_subprod != "") {
                var prod = $("[subprod-id=" + value.options.sub_prod + "]");
            } else {
                var prod = $("[data-prdid=" + id + "]");
            }
            prod.parent().parent().find('.prodPrice').text((price * <?php echo Session::get('currency_val'); ?>).toFixed(2));
            prod.parent().parent().find('.taxAmt').text((value.options.tax_amt * <?php echo Session::get('currency_val'); ?>).toFixed(2));
        });
    }

    function applyUserLevelDisc(discVal) {
        var discType = $('#user-level-disc').val();
        $("#userlevelDiscApply").attr('disabled', true);
        $.ajax({
            url: "{{ route('admin.orders.applyUserLevelDisc') }}",
            type: 'POST',
            data: {discType: discType, discVal: discVal},
            cache: false,
            success: function (data) {
                priceTaxUpdate(data.cart);
                $(".subtotal").text(data['subtotal'].toFixed(2));
                $(".finalAmt").text(data['orderAmount'].toFixed(2));
                if (data['discAmt'] != null && data['discAmt'] != 0) {
                    var msg = "<span style='color:green;'>Discount Code Applied!</span> <a href='javascript:void(0);' style='border-bottom: 1px dashed;' onclick='clearDisc()' class='clearDiscount' id='discAmt'>Remove!</a>"
                    $(".dMsg").css("display", "block");
                    $(".dMsg").html(msg);
                    var userdisc_td = '<tr class="discount-code"><th>Discount Applied</th><td><span class="cashbackUsedAmount" id="couponUsedcode">' + (data.discAmt).toFixed(2) + '</span></td></tr>';
                    $(".priceTable tbody").prepend(userdisc_td);
                } else {
                    $("#userlevelDiscApply").attr('disabled', false);
                    var err = "<span style='color:red;'>Invalid Code</span>"
                    $(".discount-code").remove();
                    if (data.clearDisc) {
                        $(".vMsg").css("display", "none");
                    } else {
                        $(".vMsg").css("display", "block");
                        $(".vMsg").html(err);
                    }
                }
                updateRemainigAmount();
                getAdditionalcharge();
            }
        });
    }
    $("#userlevelDiscApply").click(function () {
        var discVal = $('input[name="user_level_discount"]').val();
        applyUserLevelDisc(discVal);
    });

    function clearDisc() {
        var discVal = 0;
        applyUserLevelDisc(discVal);
    }

    function applyReferal(RefCode) {
        // var RefCode = $(".requireReferal").val();
        $.ajax({
            url: "{{ route('admin.orders.applyReferel')}}",
            type: 'POST',
            data: {RefCode: RefCode},
            cache: false,
            success: function (data) {
                $(".referalMsg").show();
                priceTaxUpdate(data.cart);
                getAdditionalcharge();
                $(".subtotal").text(data['subtotal'].toFixed(2));
                $(".finalAmt").text(data['orderAmount'].toFixed(2));
                if (data['referalCodeAmt'] != null && data['referalCodeAmt'] != 0) {
                    $(".referalCodeClass").attr("disabled", "disabled");
                    $(".requireReferal").attr("disabled", "disabled");
                    var Cmsg = "<span style='color:green;'>Referral Code Applied!</span> <a href='javascript:void(0);' class='clearRef' onclick='clearRef()' style='border-bottom: 1px dashed;'>Remove!</a>";
                    $(".referalMsg").html(Cmsg);
                    var userdisc_td = '<tr class="referal-code"><th>Referral Applied</th><td><span class="cashbackUsedAmount" id="couponUsedcode">' + (data.referalCodeAmt).toFixed(2) + '</span></td></tr>';
                    $(".priceTable tbody").prepend(userdisc_td);
                    // if ($(".referalCodeText").text() == 0) {
                    //     var newCartAmt = msg.split(":-")[2];
                    //     $(".referalCodeText").text(msg.split(":-")[1]);
                    //     $(".refDisc").val(msg.split(":-")[1]);
                    //     $(".referalDiscount").text(msg.split(":-")[1]);
                    //     $(".TotalCartAmt").text(newCartAmt);
                    // }
                } else {
                    $(".referalCodeClass").removeAttr("disabled");
                    $(".requireReferal").removeAttr("disabled");

                    $(".referal-code").remove();
                    if (data.clearReferrel) {
                        $(".referalMsg").css("display", "none");
                    } else {
                        $(".vMsg").css("display", "block");
                        $(".referalMsg").text("Invalid Referral Code!");
                    }
                    // if ($(".referalCodeText").text() != 0) {
                    //     var newCartAmt = msg.split(":-")[2];
                    //     $(".referalCodeText").text(0);
                    //     $(".refDisc").val(0);
                    //     $(".referalDiscount").text(0);
                    //     $(".TotalCartAmt").text(newCartAmt);
                    // }
                }
                updateRemainigAmount();
                getAdditionalcharge();
            }
        });
    }

    $("#requireReferalApply").click(function () {
        var RefCode = $(".requireReferal").val();
        applyReferal(RefCode);
    });

    function clearRef() {
        var RefCode = '';
        applyReferal(RefCode);
    }

    function clearAllDiscount() {

        //cashback remove
        $('#checkbox1').attr('checked', false);
        $("input[name='cashback_used']").val(0);
        $(".cashback-code").remove();
        var cashback = $("input[name='cashback_hidden']").val()
        $(".curRewPointsOld").text(cashback);

        // remove refereal code
        $(".referalCodeClass").removeAttr("disabled");
        $(".requireReferal").removeAttr("disabled");
        $(".referal-code").remove();
        $(".referalMsg").css("display", "none");
        $("input[name='referal_code_amt']").val(0);

        //remove User Level Discount
        $("#userlevelDiscApply").attr('disabled', false);
        $(".discount-code").remove();
        $(".dMsg").css("display", "none");

        //Remove Voucher Discount
        $("#voucherApply").removeAttr("disabled");
        $(".userVoucherCode").removeAttr("disabled");
        $("input[name='voucher_amt_used']").val(0);
        $(".voucher-code").remove();
        $(".vMsg").css("display", "none");

        //ApplyCoupon();

    }

    $('select[name=payment_mode]').change(function(){
        var payMode = $('select[name=payment_mode]').val();
        console.log(payMode);
        if(payMode == 10) {
            // $(this).parent().attr('colspan', '');
            $('.store-credit').removeClass('hide');
        } else {
            // $(this).parent().attr('colspan', '3');
            $('.store-credit').addClass('hide');
        }
    });

    function updateRemainigAmount() {
        var finalamt = $(".finalAmt").text();
        if(finalamt == ''){
            var totalPayAmt = 0;
        }else{
            var totalPayAmt = parseInt($(".finalAmt").text());
        }

        var currentPayingAmt = parseInt($('input[name="pay_amt"]').val());
        var remainingPayAmt = totalPayAmt - currentPayingAmt;
        console.log("Remaining Amt", remainingPayAmt, totalPayAmt, currentPayingAmt);
        if(currentPayingAmt > totalPayAmt) {
            //alert("This amount can not be greater than total payable amount!");
            $("#validate_credit_amt").show();
            $('input[name="pay_amt"]').val('0');
        } else {
            $("#validate_credit_amt").hide();
            $("#remaining-amt").text(remainingPayAmt.toFixed(2));
        }
        // var remainigPayAmt = parseInt($('#remaining-amt').text());
    }

    // to check is object empty
    function isEmpty(obj) {
        for (var prop in obj) {
            if (obj.hasOwnProperty(prop))
                return false;
        }
        return true;
    }
</script>
@stop
@extends('Frontend.layouts.default')
@section('content')
<!--{{ "amt=Helper==== ".App\Library\Helper::getAmt()  }}
{{ "<br/>amt=Session==== ".App\Library\Helper::getAmt()  }}-->
<div>
    <div class="container"'>
        <?php if (count($cart) > 0) { ?>
            <h2>Cart </h2>    
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th></th>
                        <th>Product</th>
                        <th>Details</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Subtotal(Rs.)</th>
                        <th>Discount amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $k => $item)
                    <tr>
                        <td><span style="cursor: pointer;" data-rowid='{{ $item->rowid}}' data-pid='{{ $item->options->sub_prod}}' class="remove removeCartItem"><i class="fa fa-times-circle"></i><b>X</b></span></td>
                        <td>
                            <img src="{{ config('constants.productImgPath').$item->options->image}}" style="height:80px;width:80px" />
                            <!-- </td> -->
                            <?php
                            if ($item->options->combos == !null) {
                                foreach ($item->options->combos as $cproduct) {
                                    if ($cproduct['img']) {
                                        ?>
                                        <img src="{{ config('constants.productImgPath').$cproduct['img']}}" style="height:80px;width:80px" />
                                    <?php } else {
                                        ?>
                                        <img src="{{ config('constants.productImgPath')}}/default-image.jpg" style="height:80px;width:80px" /> 
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </td>
                        <td>
                            {{ $item->name}}<br/>
                            <?php
                            if ($item->options->options) {
                                foreach ($item->options->options as $key => $value) {
                                    echo @App\Models\AttributeValue::find($value)->option_name . " ";
                                }
                            }
                            if ($item->options->options) {
                                foreach ($item->options->options as $key => $value) {
                                    if (!empty($value->options)) {
                                        foreach ($value->options as $opt => $optval) {
                                            echo @App\Models\AttributeValue::find($optval)->option_name . " ";
                                        }
                                    }
                                }
                            }
                            ?>
                        </td>
                        <td class="realamt realamt{{$item->options->sub_prod}}">{{ $item->price}}</td>
                        <td><input  type="number" id="quantity" value="{{ $item->qty}}" data-productid="{{ $item->options->sub_prod}}" data-rowid ="{{$item->rowid}}"  onkeypress="return isNumber(event);" onchange="numbercount('{{$k}}','{{$item->options->sub_prod}}','{{$item->rowid}}');"  class="qty{{$k}} cddd realquntity{{$item->options->sub_prod}}" min="1" max="1000"/></td>
                        <td data-pid="{{$item->options->sub_prod}}"  class="get_do subtotal{{$item->options->sub_prod}}">{{ $item->subtotal}} </td>
                <input type="hidden" data-pid="{{$item->options->sub_prod}}"  class="get_doc subtotal{{$item->options->sub_prod}}" value="{{ $item->subtotal}}" />
                <td data-dpid="{{$item->options->sub_prod}}" class="dsubtotal dsubtotal{{$item->options->sub_prod}}"></td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="5" style="text-align: right;">Total(Rs.)</td>
                    <td class="finalTotal">@if(Session::has('amount')) {{ Cart::instance("shopping")->total() - Session::get('amount') }} @else {{ Cart::instance("shopping")->total() }} @endif</td>
                    <td class="discountAmt"></td>
                </tr>
                </tbody>
            </table>
            @if($chkC == 1)
            <div class="col-md-6">
                <h3 class="underlined">Have a coupon?</h3>
                <form class="checkout_coupon" method="post">
                    <div class="coupon">
                        <input name="coupon_code" class="userCouponCode" id="" value="" placeholder="Coupon code"  type="text"> 
                        <input class="btn big" name="apply_coupon" id="couponApply" value="Apply Coupon" type="submit">
                    </div>
                </form>

                <br/>
                <br/>
                <div ng-controller="giftcouponcntrl">
                    @if(Session::has('code'))
                    <div id="Isvisible"> <h5>Coupon applied</h5>
                        <br/>&nbsp;&nbsp;&nbsp;
                        <input type="text" value="{{Session::get('code')}}" style="width:65px;font:15px;font-family: sans-serif;text-align: center" disabled/> 
                        <input type="button" value="X" style="color:red;font-size:13px;" ng-click="resetall()"/>
                    </div>

                    @else  
                    <div id="giftcoupon" >

                        <input name="giftcoupon_code" id="giftcoupon_code"   placeholder="Gift Coupon code" value=""  type="text"/> 
                        <input class="btn big" name="apply_giftcoupon" id="giftcouponApply" ng-click="sendcouponcode()" value="Apply Gift Coupon" type="submit">
                    </div>
                    @endif
                </div>

                <div class="space3"><p class="cMsg" style="display:none;color:red;font-size:13px;margin-top:15px" ></p></div>
            </div>
            <div class="col-md-6">
                <div class="cal-shipping">
                    <h4 class="heading-title">Cart Total</h4>
                    <table>
                        <tbody><tr class="cart-subtotal">
                                <th>Subtotal</th>
                                <td><strong><span class="amount allSubtotal" id="amountallSubtotal">{{ Cart::instance("shopping")->total() }}</span></strong></td>
                            </tr>
                            <tr class="shipping">
                                <th>Coupon Amount</th>
                                <td> -<span class="coupon UsedAmount" id="couponUsedAmount"> @if(Session::has('amount')) {{ Session::get('amount') }} @else 0.00  @endif </span></td>
                            </tr>
                            <tr class="order-total">
                                <th><div class="black-bg">Total (Rs.)</div></th>
                        <td><div class="black-bg"><strong> <span class="amount finalAmt" id="amountfinalAmt">@if(Session::has('amount')) {{ Cart::instance("shopping")->total() - Session::get('amount') }} @else {{ Cart::instance("shopping")->total() }} @endif</span></strong></div></td>
                        </tr>
                        </tbody></table>
                </div><!-- .cal-shipping -->
            </div>
            @endif        
            <br/>
            <br/>
            <br/>
            <a href="{{route('checkout')}}"><input type="button" class="btn big pull-right" value="Checkout"></a>
        <?php } else { ?>
            <h4> Your cart is empty! </h4>
        <?php } ?>
    </div>
</div>
<div id="loader" class=""></div>
<pre><?php //print_r(Session::all());        ?></pre>
<input type="hidden" id="delete_pro" />
<input type="hidden" id="proIds" />
<input type="hidden" id="distval" value="<?php echo Session::get('couponUsedAmt'); ?>"/>
<input type="hidden" id="disv" value="<?php echo Session::get('couponUsedAmtFixed'); ?>" />
<input type="hidden" id="disty" value="<?php echo Session::get('couponDisType'); ?>" />
<input type="hidden" id="min" value="<?php echo Session::get('minOrderAmount'); ?>" />
<input type="hidden" id="cpro" value="<?php
if (is_array(Session::get('product_ids'))) {
    echo implode(Session::get('product_ids'), ',');
}
?>" /> <?php
       $g = [];
       if (isset(Session::all()['cart']['shopping'])) {
           $r = json_decode(Session::all()['cart']['shopping']);
           foreach ($r as $d) {
               $g[] = $d->options->sub_prod;
           }
       }
       ?><input type="hidden" value="<?php echo implode($g, ','); ?>" id="sesPid" />
@stop
@section("myscripts")
<style>
    /* Absolute Center Spinner */
    .loading {
        position: fixed;
        z-index: 999;
        height: 2em;
        width: 2em;
        overflow: show;
        margin: auto;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
    }

    /* Transparent Overlay */
    .loading:before {
        content: '';
        display: block;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.3);
    }

    /* :not(:required) hides these rules from IE9 and below */
    .loading:not(:required) {
        /* hide "loading..." text */
        font: 0/0 a;
        color: transparent;
        text-shadow: none;
        background-color: transparent;
        border: 0;
    }

    .loading:not(:required):after {
        content: '';
        display: block;
        font-size: 10px;
        width: 1em;
        height: 1em;
        margin-top: -0.5em;
        -webkit-animation: spinner 1500ms infinite linear;
        -moz-animation: spinner 1500ms infinite linear;
        -ms-animation: spinner 1500ms infinite linear;
        -o-animation: spinner 1500ms infinite linear;
        animation: spinner 1500ms infinite linear;
        border-radius: 0.5em;
        -webkit-box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.5) -1.5em 0 0 0, rgba(0, 0, 0, 0.5) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
        box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) -1.5em 0 0 0, rgba(0, 0, 0, 0.75) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
    }

    /* Animation */

    @-webkit-keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
    @-moz-keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
    @-o-keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
    @keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
</style>
<script>
                    function isNumber(evt) {
                    evt = (evt) ? evt : window.event;
                            var charCode = (evt.which) ? evt.which : evt.keyCode;
                            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                    }
                    return true;
                    }
            var d;
                    function numbercount(k, id, rowid)
                    {
                    var qty = $(".qty" + k).val();
                            $.ajax({
                            type: "POST",
                                    url: "{{ route('editCart') }}",
                                    data: {qty: qty, rowid:rowid},
                                    cache: false,
                                    beforeSend:function(){
                                    $("#loader").addClass('loading');
                                    },
                                    success: function (result) {
                                            var result = result.split("||||||||||");
                                            if ($.inArray(id, $("#cpro").val().split(",")) > - 1){
                                            var disty = $("#disty").val();
                                            if (disty == 1){
                                                    var a = parseInt($(".realamt" + id).text()) * parseInt($(".realquntity" + id).val())
                                                    var f = a * $("#disv").val();
                                                    var m = f / 100;
                                                    var ssd = a - m;
                                                    $(".subtotal" + id).text(ssd);
                                                    $(".dsubtotal" + id).text(m);
                                                    sum_persentage();
                                            } else if (disty == 2){
                                                     $(".subtotal" + id).text(result[0] - d);
                                            }

                                    } else{
                                    $(".subtotal" + id).text(result[0]);
                                    }
                                    $(".allSubtotal").text(result[1]);
                                            var cmt = result[1] - $(".UsedAmount").text();
                                            console.log(cmt);
                                            $(".finalAmt").text(cmt);
                                            $(".finalTotal").text(cmt);
                                            var ss = sum_add_remove();
                                            if (ss >= $("#min").val()){
                                    $("#loader").removeClass('loading');
                                    } else{
                                    $(".clearCoup").click();
                                            setTimeout(function(){
                                            $(".finalTotal,#amountfinalAmt").text($("#amountallSubtotal").text());
                                                    $("#loader").removeClass('loading');
                                                    alert('Coupon has been removed ,because minimum amount for the specific product is ' + $("#min").val());
                                                    $("#min").val('');
                                            }, 3000);
                                    }
                                    update_sasa();
                                    }
                            });
                    }

            function sum_add_remove(){
            var sum = 0;
                    $(".dsubtotal").each(function(index, val) {
            var f, d = 0;
                    d = $(this).attr('data-dpid');
                    if ($(this).text().length > 0){
            f = parseInt($(".realamt" + d).text()) * parseInt($(".realquntity" + d).val());
                    sum = sum + parseInt(f);
            } else{
            sum += parseInt(0);
            }
            });
                    return sum;
            }

            //$(document).ready(function () {
            // $("#quantity").bind('keyup mouseup', function () {
            //       var maxvalue = parseInt($('#quantity').attr('max'));
            //       console.log(maxvalue);

            //       var currentVal = parseInt($('#quantity').val());
            //       console.log(currentVal);

            //       if (!isNaN(currentVal) && (currentVal < maxvalue)) {
            //           // Increment
            //           //$('.plus').css('pointer-events', '');
            //           $('#quantity').val(parseInt(currentVal));

            //           var rowid = $('#quantity').attr('data-rowid');
            //           var productId = $('#quantity').attr('data-productid');
            //           $.ajax({
            //               type: "POST",
            //               url: "{{ route('editCart') }}",
            //               data: {qty: qty, rowid: rowid, productId: productId},
            //               cache: false,
            //               success: function (result) {
            //                   var result = result.split("||||||||||");
            //                   console.log('result' + result);
            //                   // alert("result0===" + result[0]);
            //                   $(".subtotal" + productId).text(result[0]);
            //                   // alert("result1===" + result[1]);
            //                   $(".allSubtotal").text(result[1]);
            //                   $(".finalAmt").text(result[2]);
            //                   //  $(".couponAmt").text(result[2]);
            //                   $('.shop-cart').replaceWith(result[3]);
            //               }
            //           });
            //       } else if (currentVal >= maxvalue) {
            //           console.log(maxvalue);
            //           //$('.plus').css('pointer-events', 'none');
            //            $('#quantity').val(parseInt(maxvalue));
            //       } else {
            //           // Otherwise put a 0 there
            //            $('#quantity').val(1);
            //       }
            //   });
            /*$(".qty").bind('keyup mouseup', function () {
             var qty = $(this).val();
             console.log('qty ='+qty);
             var rowid = $(this).attr('data-rowid');
             var productId = $(this).attr('data-productid');
             $.ajax({
             type: "POST",
             url: "{{ route('editCart') }}",
             data: {qty: qty, rowid: rowid, productId: productId},
             cache: false,
             success: function (result) {
             var result = result.split("||||||||||");
             $(".subtotal" + productId).text(result[0]);
             console.log("subtotal====" + result[0]);
             $(".finalTotal").text(result[1]);
             $(".allSubtotal").text(result[1]);
             var cmt = result[1] - $(".couponUsedAmount").text();
             // console.log(cmt);
             $(".finalAmt").text(cmt);
             console.log("subtotal====" + result[1]);
             }
             });
             });
             */
            // });
            $(".removeCartItem").click(function () {
            realamt();
                    var getRowid = $(this).attr("data-rowid");
                    var getRemoveEle = $(this);
                    var pid = $(this).attr("data-pid");
                    $("#delete_pro").val(pid);
                    // alert(getRowid);
                    $.ajax({
                    type: "POST",
                            url: "{{ route('deleteCart') }}",
                            data: {rowid: getRowid},
                            cache: false,
                            beforeSend:function(){
                            $("#loader").addClass('loading');
                            },
                            success: function (result) {
                            console.log(result);
                                    result = result.split("||||||||||");
                                    getRemoveEle.parent().parent().remove();
                                    $(".finalTotal").text(result[1] - $(".couponUsedAmount").text());
                                    //$(".finalTotal").text(result[4]);
                                    $(".allSubtotal").text(result[4]);
                                    $(".finalAmt").text(result[1] - $(".couponUsedAmount").text());
                                    $('.shop-cart').replaceWith(result[2]);
                                    if (result[3] == 0) {
                            window.location = "{{ route('home') }}";
                            }
                            var copCode = <?php echo "'" . Session::get('usedCouponCode') . "'"; ?>;
                                    if (copCode != '') {
                            $("#couponApply").click();
                            }
                            $("#loader").removeClass('loading');
                            }
                    });
            });
            
            
                    function update_sasa(){
                             var ar = [];
                        $(".get_do").each(function(index, val) {
                            var d = '';
                            var f = $(this).attr('data-pid');
                            var seid = $(".realquntity" + f).attr('data-rowid');
                            var text = $(this).text();
                            var q = $.trim($(".realquntity" + f).val());
                            var j = parseFloat(text) / q;
                            d = { "sid":seid, "rc":j }
                            ar.push(d);
                        });
                        $.ajax({
                                url: "{{ route('UpdateCartRamt') }}",
                                type: 'POST',
                                data: {d:ar},
                                cache: false,
                                dataType:'json',
                                success: function (msg) {

                                }
                        });
                           
                    }
                    
                    
                    
            function realamt(){

            $(".get_doc").each(function(index, val) {
            var f = $(this).attr('data-pid');
                    var h = parseInt($(".realamt" + f).text()) * parseInt($(".realquntity" + f).val());
                    var j = $(".realquntity" + f).val();
                    $(".subtotal" + f).text(h);
                    $(".dsubtotal" + f).text('');
            });
            }



            coupon_asign($("#cpro").val());
                    sum_persentage();
                    function coupon_asign(ty){
                    var ar = [];
                            var dd = [];
                            $(".get_do").each(function(index, val) {
                    var f = $(this).attr('data-pid');
                            if ($.inArray(f, ty.split(",")) > - 1){
                    var l = $.trim($(".realamt" + f).text()) * $.trim($(".realquntity" + f).val());
                            ar.push({ amt:l, pid:f});
                            dd.push(f);
                    }
                    });
                            var disty = $("#disty").val();
                            $.each(ar, function(index, jo){
                            if (disty == 1){
                            var f = parseInt($(".realamt" + jo.pid).text()) * parseInt($(".realquntity" + jo.pid).val()) * $("#disv").val();
                                    var m = f / 100;
                                    var ssd = jo.amt - m;
                console.log("Discount val "+ $("#disv").val());
                console.log("Array length "+ f);
                console.log("discount "+ m);
                                    $(".subtotal" + jo.pid).text(ssd);
                                    $(".dsubtotal" + jo.pid).text(m);
                                    $(".finalTotal").text($("#amountfinalAmt").text());
                                    $("#amountfinalAmt").text($("#amountfinalAmt").text());
                                    $(".discountAmt").text("-" + $("#distval").val());
                                    $("#couponUsedAmount").text($("#distval").val());
                                    sum_persentage();
                            } else if (disty == 2){
                            d = $("#disv").val() / ar.length;
                                    var ssd = jo.amt - d;
                                    if(ssd < 0){
                                        ssd = 0;
                                    }
                                    $(".subtotal" + jo.pid).text(ssd);
                                    $(".dsubtotal" + jo.pid).text(d);
                                    $(".finalTotal").text($("#amountallSubtotal").text() - $("#disv").val());
                                    $("#amountfinalAmt").text($("#amountallSubtotal").text() - $("#disv").val());
                                    $(".discountAmt").text("-" + $("#disv").val());
                                    $("#couponUsedAmount").text($("#disv").val());
                            }
                            console.log("pid : " + jo.pid + " amt : " + jo.amt + " minus amount " + ssd);
                            });
                            $("#delete_pro").val('');
                            update_sasa();
                    }


            function sum_persentage(){
            var sum = 0;
                    $(".dsubtotal").each(function(index, val) {
            if ($(this).text().length > 0){
            sum = sum + parseInt($(this).text());
            } else{
            sum += parseInt(0);
            }
            });
                    $(".discountAmt").text(sum);
                    $("#couponUsedAmount").text(sum);
            }


            $("#couponApply").click(function () {
            realamt();
                    var couponCode = $(".userCouponCode").val();
                    $.ajax({
                    url: "{{ route('check_coupon') }}",
                            type: 'POST',
                            data: {couponCode: couponCode},
                            cache: false,
                            async: false,
                            dataType:'json',
                            beforeSend:function(){
                            //  $("#loader").addClass('loading');
                            },
                            success: function (msg) {
                            var ty = '';
                                    if (msg.nl == 'not login'){
                            alert('You have to login for applying this coupon ');
                            } else{
                            $(".cMsg").css("display", "block");
                                    var Cmsg = msg.newamt;
                                    if (msg.errMsg != "Coupon Not Valid") {
                            $("#couponApply").attr("disabled", "disabled");
                                    $(".userCouponCode").attr("disabled", "disabled");
                                    Cmsg = "<span style='color:green;'>Coupon Applied!</span> <a href='javascript:void(0);' style='border-bottom: 1px dashed;' class='clearCoup'>Remove!</a>";
                                    var newAmount = msg.newamt;
                                    var usedCouponAmount = msg.couponUsedAmtFixed;
                                    $("#min").val(msg.min);
                                    $("#distval").val(msg.discount_val);
                                    $("#disty").val(msg.discount_type);
                                    $("#disv").val(msg.coupon_value);
                                    $("#couponUsedAmount,.discountAmt").text(usedCouponAmount);
                                    $(".finalTotal").text(newAmount);
                                    $(".finalAmt").text(newAmount);
                                    //$(".couponUsedAmount").text(usedCouponAmount);
                                    $(".cMsg").html(Cmsg);
                                    $("#proIds").val(msg.allowedProduct);
                                    var ty = msg.allowedProduct;
                                    $("#cpro").val(ty);
                            } else {
                            $("#cpro,#distval,#proIds,#disv").val('');
                                    $("#couponUsedAmount,.discountAmt").text("0");
                                    var newCartAmt = parseInt(msg.couponValR);
                                    $(".finalTotal").text(newCartAmt);
                                    $(".finalAmt").text(newCartAmt);
                                    $(".cMsg").html(msg.v_msg);
                                    // $(".cMsg").html("Coupon Code Invalid OR Not applicable on current cart value.");
                            }
                            coupon_asign(ty);
                            }
                            }

                    });
                    return false;
            });
                    //remove coupon
                    $("body").on("click", ".clearCoup", function () {

            var couponCode = '';
                    $.ajax({
                    url: "{{ route('check_coupon') }}",
                            type: 'POST',
                            data: {couponCode: couponCode},
                            cache: false,
                            dataType:'json',
                            success: function (msg) {
                            $("#cpro,#distval,#proIds,#disv,#disty").val('');
                                    console.log(msg);
                                    $(".cMsg").css("display", "block");
                                    var Cmsg = msg.errMsg;
                                    if (msg.couponValR > 0) {
                            var newCartAmt = msg.couponValR;
                                    console.log(msg.couponValR);
                                    $(".finalTotal").text(msg.couponValR);
                                    $(".finalAmt").text(msg.couponValR);
                            }
                            $("#couponUsedAmount,.discountAmt").text("0");
                                    $(".cMsg").html("Coupon Removed!");
                                    $("#couponApply").removeAttr("disabled");
                                    $(".userCouponCode").removeAttr("disabled");
                                    $(".userCouponCode").val("");
                                    realamt();
                                    update_sasa();
                            }
                    });
            });
                    var chkcouponapplied = "";
<?php if (!empty(Session::get('usedCouponId'))) { ?>
                var chkcouponapplied = <?php echo Session::get('usedCouponId'); ?>;
                        var copCode = <?php echo "'" . Session::get('usedCouponCode') . "'"; ?>;
<?php } ?>
            if (chkcouponapplied) {
            $("#couponApply").attr("disabled", "disabled");
                    $(".userCouponCode").attr("disabled", "disabled");
                    $(".userCouponCode").val(copCode);
                    $("#couponApply").click();
                    $("#loader").removeClass('loading');
            }

</script>
@stop
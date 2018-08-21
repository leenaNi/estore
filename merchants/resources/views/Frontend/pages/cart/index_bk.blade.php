@extends('Frontend.layouts.default')
@section('content')
<div id="content" class="site-content single-product">
    <div class="breadcrumb">
        <div class="container">
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><span class="current">Cart</span></li>
            </ul>
        </div><!-- .container -->
    </div><!-- .breadcrumb -->
    <div class="container">
        <form class="cart-form" action="#">
            <div class="table-responsive">
                <table class="table cart-table cartT">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Discount</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cart as $k => $item)
                        <tr>
                            <td class="product-remove">
                                <span style="cursor: pointer;" data-rowid='{{ $item->rowid }}'  class="remove removeCartItem"><i class="fa fa-close"></i></span>
                            </td>
                            <?php
                            ?>
                            <td style="text-align:left;">
                                <?php if ($item->options->image != "") { ?>
                                    <img src="{{ config('constants.productImgPath').$item->options->image }}" style="height:80px;width:80px;border:1px solid #eee; padding:5px;" />
                                <?php } else { ?>
                                    <img src="{{ config('constants.productImgPath')}}/default-image.jpg" style="height:80px;width:80px;border:1px solid #eee; padding:5px;" />
                                <?php } ?>
                                {{ $item->name }}
                                <?php
                                if ($item->options->CatType != '') {
                                    echo "(" . $item->options->CatType . ")";
                                }
                                ?>
                                <br/>
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
                            <td> <i class="fa fa-<?php echo strtolower(Session::get('currency_code')); ?>"></i> {{ number_format($item->price * Session::get('currency_val'), 2) }}</td>
                            <td>
                                <div class="quantity">
                                    <input  type="number" name="quantity" id="quantity" value="{{ $item->qty}}" data-productid="{{ $item->options->sub_prod}}" data-rowid ="{{$item->rowid}}"  onkeypress="return isNumber(event);"  class="qty qty{{$k}} cddd realquntity{{$item->options->sub_prod}}" min="1" max="{{$item->options->is_stock!=0? $item->options->stock:'10000'}}"/>
<!--                                    <input  type="number" name="quantity" id="quantity" value="{{ $item->qty }}" data-productid="{{ $item->id }}" data-rowid ="{{$item->rowid  }}"  onkeypress="return isNumber(event);"  class="qty" min="1" max="{{ $item->options['stock'] }}" />-->
                                </div>
                            </td>
                            <td>
                                <span class="disc_indv{{$item->rowid}} disc_indv" rowid='{{$item->rowid}}'> 0</span>
                            </td>

                            <td>
                                <span data-pid="{{$item->options->sub_prod}}"  class="get_do subtotal{{$item->options->sub_prod}}">{{ number_format($item->subtotal, 2)}}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>
        <div class="cart-collaterals row">
            @if($chkC == 1)
            <div class="col-md-6">
                <div class="cal-shipping  mar-bot15">
                    <h4 class="heading-title">HAVE A COUPON?</h4>
                    <form class="checkout_coupon" method="post">
                        <div class="cart-input">
                            <input name="coupon_code" class="userCouponCode" id="" value="" placeholder="Coupon code"  type="text"> 
                        </div>
                        <div class="input-submit">
                            <input class="button bold default" name="apply_coupon" id="couponApply" value="Apply Coupon" type="submit">
                        </div>
                    </form>
                    <div class="col-md-12 col-xs-12 space3">
                        <p class="cmsg" style="display:none;color:red;font-size:13px;margin-top:15px" ></p>
                    </div>
                </div><!-- .cal-shipping -->
            </div>
            @endif
            <div class="col-md-6">
                <div class="cal-shipping">
                    <h4 class="heading-title">Cart Total</h4>
                    <table>
                        <tr class="cart-subtotal">
                            <th>Subtotal</th>
                            <td><strong><span class="amount allSubtotal" id="amountallSubtotal">{{ number_format(Cart::instance("shopping")->total(), 2) }}</span></strong></td>
                        </tr>
                        <tr class="shipping">
                            <th>Coupon Amount</th>
                            <td> -<span class="couponUsedAmount" id="couponUsedAmount"> {{ number_format(Session::get('couponUsedAmt'), 2) }}</span></td>
                        </tr>
                        <tr class="order-total">
                            <th><div class="black-bg">Total (<?php echo htmlspecialchars_decode(Session::get('currency_symbol')); ?>)</div></th>
                            <td><div class="black-bg"><strong> <span class="amount finalAmt">{{ number_format(App\Library\Helper::getAmt(), 2) }}</span></strong></div></td>
                        </tr>
                    </table>
                </div><!-- .cal-shipping -->
            </div>
            <div class="col-md-12">

                <div class="cart-actions clearfix">
                    <form action="#">
                        <a class="button bold default pull-right" href="{{route('checkout')}}">PROCESS TO CHECK OUT</a>
                        <a class="button bold default pull-right" href="{{ route('home') }}">Continue Shopping</a>
                    </form>
                </div><!-- .cart-actions -->
            </div>
        </div><!-- .cart-collaterals -->
    </div><!-- .container -->
</div><!-- .site-content -->
@stop
@section("myscripts")
<script>
    function calc(thisQty) {
        var qty = thisQty.val();
        var maxvalue = parseInt(thisQty.attr('max'));
        var currentVal = parseInt(thisQty.val());
        if (!isNaN(currentVal) && (currentVal <= (maxvalue - 1))) {
            // Increment
            //$('.plus').css('pointer-events', '');
            thisQty.val(parseInt(currentVal));
            var rowid = thisQty.attr('data-rowid');
            var productId = thisQty.attr('data-productid');
            $.ajax({
                type: "POST",
                url: "{{ route('editCart') }}",
                data: {qty: qty, rowid: rowid, productId: productId},
                cache: false,
                success: function (result) {
                    console.log(result);
                    //var result = result.split("||||||||||");                    
                    // alert("result0===" + result[0]);
                    $(".subtotal" + productId).text(result[0]);
                    $(".allSubtotal").text(result[1]);
                    if (result[2]) {
                        $(".finalAmt").text(result[1]);
                        $("#couponApply").click();
                    } else {
                        $(".finalAmt").text(result[1]);
                    }
                    $('#shop-cart-cnt').html(result[3]);

                }
            });
        } else if (currentVal >= maxvalue) {
            //$('.plus').css('pointer-events', 'none');
            thisQty.val(parseInt(maxvalue));
            alert("Specified quantity is not available!");
        } else {
            // Otherwise put a 0 there
            thisQty.val(1);
        }

    }
    $(document).ready(function () {
        $(".qty").bind('keyup mouseup', function () {
            var thisQty = $(this);
            calc(thisQty);
        });
        $(".minus").click(function () {
            var thisQty = $(this).parent().find(".qty");
            calc(thisQty);

        });
        $(".removeCartItem").click(function () {
            var getRowid = $(this).attr("data-rowid");
            var getRemoveEle = $(this);
            // alert(getRowid);
            $.ajax({
                type: "POST",
                url: "{{ route('deleteCart') }}",
                data: {rowid: getRowid},
                cache: false,
                success: function (result) {
                    //result = result.split("||||||||||");
                    getRemoveEle.parent().parent().remove();
                    $(".allSubtotal").text(result[0]);
                    $(".finalAmt").text(result[3]);
                    $("#amountallSubtotal").text(result[3]);
                    $('.shop-cart').replaceWith(result[2]);
                    console.log(result[3]);
                    if (result[3] == 0) {
                        window.location = "{{ route('home') }}";
                    }
                    if (result[4]) {
                        console.log("inside coupon code");
                        $("#couponApply").click();
                    } else {

                    }
                }
            });
        });
        $('.plus').click(function () {
            // Stop acting like a button
            // Get the field name
            var thisQty = $(this).parent().find(".qty");
            calc(thisQty);
        });
    });

    $("#couponApply").click(function () {
        var couponCode = $(".userCouponCode").val();

        //alert(couponCode);
        $.ajax({
            url: "{{ route('check_coupon') }}",
            type: 'POST',
            data: {couponCode: couponCode},
            cache: false,
            success: function (msg) {
                //alert("check_coupon response "+ msg );
                $(".cmsg").css("display", "block");
                if (msg['remove'] == 1) {
                    $(".cmsg").html("Coupon Code Invalid OR Not applicable on current cart value.");
//                    $.each(msg['individual_disc_amt'], function (key, value) {
//                        $(".disc_indv" + key).text(0);
//                    });                    
                    $("#couponUsedAmount").text("0.00");
                    $("#couponApply").removeAttr("disabled");
                    $("#userCouponCode").val('');
                    $("#userCouponCode").removeAttr("disabled");
                    $(".allSubtotal").text(msg['subtotal'].toFixed(2));
                    $(".finalAmt").text(msg['orderAmount'].toFixed(2));
                    $(".disc_indv").text("0.00");
                    $("#amountallSubtotal").text(msg[4]);

                } else {
                    $("#couponApply").attr("disabled", "disabled");
                    $(".userCouponCode").attr("disabled", "disabled");
                    coupon_msg = "<span style='color:green;'>Coupon Applied!</span> <a href='javascript:void(0);' style='border-bottom: 1px dashed;' class='clearCoup'>Remove!</a>";
                    var newAmount = msg['new_amt'];
                    var usedCouponAmount = (msg['disc'])//.toFixed(2);                   
                    $.each(msg['individual_disc_amt'], function (key, value) {
                        $(".disc_indv" + key).text(value.toFixed(2));
                    });
                    $(".finalAmt").text(newAmount);
                    $("#couponUsedAmount").text(usedCouponAmount);
                    $(".cmsg").html(coupon_msg);
                    $("#amountallSubtotal").text(msg[4]);
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
            success: function (msg) {
                console.log('msg' + msg['remove']);
                if (msg['remove'] == 1) {
                    $("#couponUsedAmount").text("0.00");
                    $(".cmsg").html("Coupon Removed!");
                    $("#couponApply").removeAttr("disabled");
                    $(".userCouponCode").removeAttr("disabled");
                    $(".finalAmt").text(msg['orderAmount'].toFixed(2));
                    $(".disc_indv").text("0.00");
                    $('.userCouponCode ').val('');
                }
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
    }
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
    jQuery(document).ready(function () {
        // This button will increment the value
        $('.plus').click(function (e) {
            console.log('Inside');
            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            var fieldName = $(this).attr('field');
            var maxvalue = parseInt($('input[name="quantity"]').attr('max'));
            console.log('Inside' + maxvalue);
            console.log('Inside fieldName' + fieldName);
            // Get its current value
            var currentVal = parseInt($('input[name=' + fieldName + ']').val());
            // If is not undefined
            if (!isNaN(currentVal) && (currentVal <= maxvalue)) {
                // Increment
                $('input[name=' + fieldName + ']').val(currentVal + 1);
            } else if (currentVal >= maxvalue) {
                alert("Specified quantity is not available!");
            } else {
                // Otherwise put a 0 there
                $('input[name=' + fieldName + ']').val(0);
            }
        });
        // This button will decrement the value till 0
        $(".minus").click(function (e) {
            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            fieldName = $(this).attr('field');
            // Get its current value
            var currentVal = parseInt($('input[name=' + fieldName + ']').val());
            // If it isn't undefined or its greater than 0
            if (!isNaN(currentVal) && currentVal > 0) {
                // Decrement one
                $('input[name=' + fieldName + ']').val(currentVal - 1);
            } else {
                // Otherwise put a 0 there
                $('input[name=' + fieldName + ']').val(0);
            }
        });
    });
</script>
@stop
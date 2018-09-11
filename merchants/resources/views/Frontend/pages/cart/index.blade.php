@extends('Frontend.layouts.default')
@section('content')
<section id="page-title">
    <div class="container clearfix">
        <h1>Cart</h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}">Home</a>
            </li>
            <li class="active">Cart</li>
        </ol>
    </div>
</section>
<div id="content" class="site-content single-product">


    <div class="container">
        @if(!empty($cart->toArray()))
        <form class="cart-form" action="#">
            <div class="table-responsive">
                <table class="table table-bordered cart-table cartT">
                    <thead>
                        <tr>
                            <th></th>
                            <th class="text-left">Product</th>
                            <th>Price <span class="currency-sym-in-braces"></span></th>
                            <th>Qty</th>

                            @if(@$feature['coupon'] == 1)
                            <th>Coupon Discount <span class="currency-sym-in-braces"></span></th>
                            @endif
                            @if(@$feature['tax'] == 1)
                            <th>Tax <span class="currency-sym-in-braces"></span></th>
                            @endif

                            <th>Subtotal <span class="currency-sym-in-braces"></span></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($cart as $k => $item)
                        <tr>
                            <td class="product-remove">
                                <span style="cursor: pointer;" data-rowid='{{ $item->rowid }}'  class="remove removeCartItem"><i class="icon-line2-trash"></i></span>
                            </td>
                            <?php
                            ?>
                            <td class="cartProductName" valign="top">
                                <div class="CPN-Box">
                                <div class="CPN-BoxLeft">
                                    <a href="{{ route('home')}}/{{$item->options->url}}">
                                <?php if ($item->options->image != "") { ?>
                                    <img src="{{ config('constants.productImgPath').'/'.$item->options->image }}" class="cart-prodimg"/>
                                <?php } else { ?>
                                    <img src="{{ (Config('constants.defaultImgPath').'/default-product.jpg') }}" class="cart-prodimg"/>
                                <?php } ?>
                                    </a>
                                </div>
                                <div class="CPN-BoxRight">
                                    <div><a href="{{ route('home')}}/{{$item->options->url}}">{{ $item->name }}</a>
                                <div class="clearfix"></div></div>
                                <?php
                                if ($item->options->CatType != '') {
                                    echo "(" . $item->options->CatType . ")";
                                }
                                ?>
                                <div class="cart-quanitiy">
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
                                </div>
                                </div>
                                </div>
                            </td>
                            <td>{{ number_format($item->price * Session::get('currency_val'), 2, '.', '') }}<br/>
                                @if(@$feature['tax'] == 1)
                                @if($item->options->tax_type == 2)
                                <small>{Excl. of Tax)</small>
                                @elseif($item->options->tax_type == 1)
                                <small>(Inc. of Tax)</small> 
                                @endif
                                @endif
                            </td>
                            <td class="cartQuantityBox-td">
                                <?php
                                if ($isstock == 1) {
                                    $max = $item->options->is_stock != 0 ? $item->options->stock : '1000000';
                                } else {
                                    $max = '1000000';
                                }
                                ?>

                                <div class="quantity cart-quantity-box">
                                    <input type="button" value="-" class="minus" field="quantity">
                                    <input  type="text" name="quantity" id="quantity" value="{{ $item->qty}}" data-productid="{{ $item->options->sub_prod}}" data-rowid ="{{$item->rowid}}"  onkeypress="return isNumber(event);"  class="qty qty{{$k}} cddd realquntity{{$item->options->sub_prod}}" min="1" max="{{$max}}"/>
<!--                                    <input  type="number" name="quantity" id="quantity" value="{{ $item->qty }}" data-productid="{{ $item->id }}" data-rowid ="{{$item->rowid  }}"  onkeypress="return isNumber(event);"  class="qty" min="1" max="{{ $item->options['stock'] }}" />-->
                                    <input type="button" value="+" class="plus" field="quantity">
                                </div>
                            </td>

                            @if(@$feature['coupon'] == 1)
                            <td>
                                <span class="disc_indv{{$item->rowid}} disc_indv" rowid='{{$item->rowid}}'> 0.00</span>

                            </td>
                            @endif


                            @if(@$feature['tax'] == 1)
                            <td>
                                <span class="tax_{{$item->rowid}} tax_amt" rowid='{{$item->rowid}}'> {{  number_format($item->options->tax_amt * Session::get('currency_val'), 2, '.', '')}}</span>

                            </td>
                            <!-- <td>
                                @if($item->options->tax_type == 2)
                                Exclusive of Tax
                                @elseif($item->options->tax_type == 1)
                                Inclusive of Tax
                                @else
                                No Tax
                                @endif
                            </td> -->
                            @endif
                            <td>
                                <?php $subTotalAmt = ($item->options->tax_type == 2 ) ? $item->subtotal + $item->options->tax_amt : $item->subtotal; ?>
                                <span data-pid="{{$item->options->sub_prod}}"  class="get_do subtotal{{$item->rowid}}">{{ number_format($subTotalAmt * Session::get('currency_val'), 2, '.', '')}}</span>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>
        <div class="cart-collaterals row">
            @if($chkC == 1)
            <div class="col-md-6 col-sm-6 col-xs-12 mobMB15">
                <div class="cal-shipping  mar-bot15">
                    <h4 class="heading-title">HAVE A COUPON?</h4>
                    <form class="checkout_coupon" method="post">
                        <div class="cart-input">
                            <input name="coupon_code" class="userCouponCode sm-form-control" id="" value="" placeholder="Enter Coupon Code "  type="text"> 
                        </div>
                        <div class="">
                            <input class="button applycoupenbtn bold default" name="apply_coupon" id="couponApply" value="Apply Coupon" type="submit">
                        </div>
                    </form>
                    <div class="col-md-12 col-xs-12 space3">
                        <span class="cmsg" style="display:none;color:red;font-size:13px;margin-top:15px" ></span>
                    </div>
                </div><!-- .cal-shipping -->
            </div>
            @endif


            <div class="col-md-6 col-sm-6 col-xs-12 pull-right">
                <div class="cal-shipping table-responsive">
                    <h4 class="heading-title ">Cart Total</h4>
                    <table class="table cart">

                        <tr class="cart-subtotal">
                            <th>Sub-Total: <span class="currency-sym-in-braces"></span></th>
                            <td><strong><span class="amount allSubtotal" id="amountallSubtotal">{{ number_format($cart_amt['sub_total'] * Session::get('currency_val'), 2, '.', '') }}</span></strong></td>
                        </tr>

                        @if($chkC == 1)
                        <tr class="shipping">
                            <th>Coupon<span class="coupCode"></span>:<span class="currency-sym-in-braces"></span> </th>
                            <td>
                            <strong><span class="couponUsedAmount" id="couponUsedAmount">{{ number_format(Session::get('couponUsedAmt')* Session::get('currency_val'), 2, '.', '') }}</span></strong>
                            </td>
                        </tr>
                        @endif

                        <tr class="order-total">
                            <th><div class="black-bg">Total:<span class="currency-sym-in-braces"></span> </div></th>
                            <td><div class="black-bg"><strong><span class="amount finalAmt">{{ number_format($cart_amt['total']* Session::get('currency_val'), 2, '.', '') }}</span></strong></div></td>
                        </tr>

                    </table>
                </div><!-- .cal-shipping -->
            </div>
            <div class="clearfix"></div>
            <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="cart-actions clearfix">
                    <form action="#">
                        <a class="button bold default" href="{{route('checkout')}}">PROCEED TO CHECKOUT</a>
                        <a class="button bold default" href="{{ route('home') }}">Continue Shopping</a>
                    </form>
                </div><!-- .cart-actions -->
            </div>
        </div><!-- .cart-collaterals -->
        @else
        <div class="row">
            <div class="col-md-12 col-md-12" style="text-align: center;">
                <h3>Your shopping cart is empty.</h3>
            </div>
        </div>
        @endif
    </div><!-- .container -->
</div><!-- .site-content -->
@stop
@section("myscripts")
<script>
    function calc(thisQty) {
        var qty = thisQty.val();
        var maxvalue = parseInt(thisQty.attr('max'));
        var currentVal = parseInt(thisQty.val());

        if (!isNaN(currentVal) && (currentVal <= (maxvalue))) {
            // Increment
            //$('.plus').css('pointer-events', '');
            //  alert(parseInt(thisQty.val()));
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
                    $(".subtotal" + rowid).text((result['subtotal']).toFixed(2));
                    $(".allSubtotal").text((result['total']).toFixed(2));
                    $(".finalAmt").text((result['finaltotal']).toFixed(2));
                    if (result['coupon_amount']) {
                        $("#couponApply").click();
                    }
                    $(".tax_" + rowid).text((result['tax'] * <?php echo Session::get('currency_val'); ?>).toFixed(2));
                    $('.shop-cart').text(result['cart_count']);

                }
            });
        } else if (currentVal >= maxvalue) {
            // Need to write ajax call for cart count.
            thisQty.val(parseInt(maxvalue));
            calc(thisQty);
            $.ajax({
                type: "POST",
                url: "{{ route('getCartCount') }}",
                cache: false,
                success: function (cartCount) {

                    $('.shop-cart').text(cartCount);
                }
            });
            alert("Specified quantity is not available!");

        } else {
            // Otherwise put a 0 there
            thisQty.val(1);
        }

    }
    $(document).on("click", '.plus', function () {
        //alert("sdf");
        var fieldName = $(this).attr("field");
        //   var maxValue = parseInt($('input[name="quantity"]').attr('max'));
        var thisQty = $(this).parent().find('input[name=' + fieldName + ']');
        //  $(this).parent().find('input[name=' + fieldName + ']').val();
        thisQty.val(parseInt(thisQty.val()) + 1);
        calc(thisQty);
//                $(this).parent().find('input[name=' + fieldName + ']').val(currentVal + 1);
    });

    $(document).on("click", '.minus', function () {
        //alert("sdf");
        var fieldName = $(this).attr("field");
        //   var maxValue = parseInt($('input[name="quantity"]').attr('max'));
        var thisQty = $(this).parent().find('input[name=' + fieldName + ']');
        // $(this).parent().find('input[name=' + fieldName + ']').val(currentVal - 1);
        var currentVal = $(this).parent().find('input[name=' + fieldName + ']').val()
        if (!isNaN(currentVal) && (currentVal > 1)) {
            thisQty.val(parseInt(thisQty.val() - 1));
            calc(thisQty);
        } else {
            thisQty.val(parseInt(1));
            calc(thisQty);
        }

//                $(this).parent().find('input[name=' + fieldName + ']').val(currentVal + 1);
    });
    $(document).ready(function () {
//        $(".qty").bind('keyup mouseup', function () {
//            var thisQty = $(this);
//            calc(thisQty);
//        });

//        $(".minus").click(function () {
//            var thisQty = $('#quantity');
//             thisQty.val(parseInt(thisQty.val()-1));
//           // alert(thisQty.val());
//            calc(thisQty);
//
//        });
//         $(".plus").click(function () {
//            var thisQty = $('#quantity');
//              thisQty.val(parseInt(thisQty.val())+1);
//           // alert(thisQty.val());
//            calc(thisQty);
//        });

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
                    // result = result.split("||||||||||");
                    getRemoveEle.parent().parent().remove();
                    $(".allSubtotal").text((result[0] * <?php echo Session::get('currency_val'); ?>).toFixed(2));
                    $(".finalAmt").text((result[3] * <?php echo Session::get('currency_val'); ?>).toFixed(2));
                    $("#amountallSubtotal").text((result[3] * <?php echo Session::get('currency_val'); ?>).toFixed(2));

                    $('.shop-cart').text(result[2]);
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
//        $('.plus').click(function () {
//            // Stop acting like a button
//            // Get the field name
//            var thisQty = $(this).parent().find(".qty");
//            calc(thisQty);
//        });
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
                $.each(msg['cart'], function (i, v) {
                    var sub_total = v.subtotal;
                    console.log("SUB TOTAL " + sub_total);
                    $.each(v, function (key, val) {
                        console.log(typeof val);
                        if (typeof val === 'object') {
                            console.log("TAX VAL " + JSON.stringify(val.options));
                            if (val.tax_amt) {
                                console.log("TAX PRESENT");
//                        $(".tax_" + i).text((parseFloat(val.tax_amt) * parseFloat()).toFixed(2));
                                $(".tax_" + i).text(parseFloat(val.tax_amt * <?php echo Session::get('currency_val'); ?>).toFixed(2));
                                if (val.tax_type == 2) {
                                    sub_total = (sub_total + val.tax_amt);
                                }
                            }
                            $(".subtotal" + i).text((sub_total * <?php echo Session::get('currency_val'); ?>));
                        }
                    });
                    $(".subtotal" + i).text((sub_total * <?php echo Session::get('currency_val'); ?>).toFixed(2));
                });
                //alert("check_coupon response "+ msg );
                $(".cmsg").css("display", "block");
                if (msg['remove'] == 1) {
                    $(".cmsg").html(msg['cmsg']);
                    $("#couponUsedAmount").text("0.00");
                    $("#couponApply").removeAttr("disabled");
                    $("#userCouponCode").val('');
                    $("#userCouponCode").removeAttr("disabled");
                    $(".coupCode").text(" ");
                    // $(".allSubtotal").text(msg['subtotal'].toFixed(2));
                    $(".finalAmt").text(parseFloat((msg['orderAmount'])).toFixed(2));
                    $(".disc_indv").text("0.00");
                    $("#amountallSubtotal").text(parseFloat((msg['subtotal'])).toFixed(2));
                } else {
                    //  alert('test............');
                    $("#couponApply").attr("disabled", "disabled");
                    $(".userCouponCode").attr("disabled", "disabled");
                    var coupon_msg = "<span style='color:green;'>Coupon Applied!</span> <a href='javascript:void(0);' style='border-bottom: 1px dashed;' class='clearCoup'>Remove!</a>";
                    $(".coupCode").text("[" + $(".userCouponCode").val() + "]");
                    var newAmount = msg['orderAmount'];
                    // var newAmount = msg['new_amt'];
                    var usedCouponAmount = (msg['disc'] * <?php echo Session::get('currency_val'); ?>).toFixed(2);
                    // console.log(msg['cart']);
                    $.each(msg['cart'], function (key, value) {
                        $(".disc_indv" + key).text((parseFloat(value.options.disc * <?php echo Session::get('currency_val'); ?>)).toFixed(2));
                        // console.log('-------sss------'+key);
                    });
                    $(".finalAmt").text(parseFloat((newAmount)).toFixed(2));
                    $("#couponUsedAmount").text(parseFloat((usedCouponAmount)).toFixed(2));
                    $(".cmsg").html(coupon_msg);
                    $("#amountallSubtotal").text(parseFloat((msg['subtotal'])).toFixed(2));

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
                // alert(msg);
                console.log('msg' + msg['remove']);
                if (msg['remove'] == 1) {
                    $.each(msg['cart'], function (i, v) {
                        var sub_total = v.subtotal;
                        $.each(v, function (key, val) {
                            console.log(typeof val);
                            if (typeof val === 'object') {
                                console.log("Remove " + JSON.stringify(val));
                                if (val.tax_amt) {
                                    console.log("TAX PRESENT");
                                    $(".tax_" + i).text(parseFloat((val.tax_amt) * <?php echo Session::get('currency_val'); ?>).toFixed(2));
                                    if (val.tax_type == 2) {
                                        sub_total = sub_total + val.tax_amt;
                                    }
                                    $(".subtotal" + i).text((parseFloat(sub_total * <?php echo Session::get('currency_val'); ?>)).toFixed(2));
                                }
                            }
                        });
                        $(".subtotal" + i).text((parseFloat(sub_total * <?php echo Session::get('currency_val'); ?>)).toFixed(2));
                    });
                    $("#couponUsedAmount").text("0.00");
                    $(".cmsg").html("Coupon Removed!");
                    $(".coupCode").text(" ");
                    $("#couponApply").removeAttr("disabled");
                    $(".userCouponCode").removeAttr("disabled");
                    $(".finalAmt").text((msg['orderAmount']).toFixed(2));
                    $(".allSubtotal").text((msg['subtotal']).toFixed(2));
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
//    jQuery(document).ready(function () {
//        // This button will increment the value
//        $('.plus').click(function (e) {
//            console.log('Inside');
//            // Stop acting like a button
//            e.preventDefault();
//            // Get the field name
//            var fieldName = $(this).attr('field');
//            var maxvalue = parseInt($('input[name="quantity"]').attr('max'));
//            console.log('Inside' + maxvalue);
//            console.log('Inside fieldName' + fieldName);
//            // Get its current value
//            var currentVal = parseInt($('input[name=' + fieldName + ']').val());
//            // If is not undefined
//            if (!isNaN(currentVal) && (currentVal <= maxvalue)) {
//                // Increment
//                $('input[name=' + fieldName + ']').val(currentVal + 1);
//            } else if (currentVal >= maxvalue) {
//                alert("Specified quantity is not available!");
//            } else {
//                // Otherwise put a 0 there
//                $('input[name=' + fieldName + ']').val(0);
//            }
//        });
//        // This button will decrement the value till 0
//        $(".minus").click(function (e) {
//            // Stop acting like a button
//            e.preventDefault();
//            // Get the field name
//            fieldName = $(this).attr('field');
//            // Get its current value
//            var currentVal = parseInt($('input[name=' + fieldName + ']').val());
//            // If it isn't undefined or its greater than 0
//            if (!isNaN(currentVal) && currentVal > 0) {
//                // Decrement one
//                $('input[name=' + fieldName + ']').val(currentVal - 1);
//            } else {
//                // Otherwise put a 0 there
//                $('input[name=' + fieldName + ']').val(0);
//            }
//        });
//    });
</script>

@stop
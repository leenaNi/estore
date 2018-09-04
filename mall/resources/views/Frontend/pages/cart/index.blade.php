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
        {{dd($cart);}}
        @if(!empty($cart->toArray()))
        <form class="cart-form" action="#">
            <div class="table-responsive">
                <table class="table table-bordered cart-table cartT">
                    <thead>
                        <tr>
                            <th></th>
                            <th class="text-left">Product</th>
                            <th>Price <span class="currency-sym-in-braces"></span></th>
                            <th>Quantity</th>
                            <th>Sold By</th>
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
                                        <?php if ($item->options->image != "") { ?>
                                            <img src="{{ $item->options->image_with_path.'/'.$item->options->image }}" class="cart-prodimg"/>
                                        <?php } else { ?>
                                            <img src="{{ $item->options->image_with_path.'/default-product.jpg' }}" class="cart-prodimg"/>
                                        <?php } ?>
                                    </div>
                                    <div class="CPN-BoxRight">
                                        <div>{{ $item->name }}
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
                            <td>
                                {{$item->options->store_name }}
                            </td>
                            @if(@$feature['tax'] == 1)
                            <td>
                                <span class="tax_{{$item->rowid}} tax_amt" rowid='{{$item->rowid}}'> {{  number_format($item->options->tax_amt * Session::get('currency_val'), 2, '.', '')}}</span>
                            </td>
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
            <div class="col-md-6 col-sm-6 col-xs-12 pull-right">
                <div class="cal-shipping">
                    <!--<h4 class="heading-title mb15 mobMarginTop20">Cart Total</h4>-->
                    <div class="table-responsive">
                        <table class="table table-bordered cart">
                            <tr class="cart-subtotal">
                                <th colspan="2"><h4 class="heading-title mobMarginTop20">Cart Total</h4></th>
                            </tr>
                            <tr class="cart-subtotal">
                                <th>Sub-Total: <span class="currency-sym-in-braces"></span></th>
                                <td class="text-right"><strong><span class="amount allSubtotal" id="amountallSubtotal">{{ number_format($cart_amt['sub_total'] * Session::get('currency_val'), 2, '.', '') }}</span></strong></td>
                            </tr>
                            <tr class="order-total">
                                <th><div class="black-bg">Total:<span class="currency-sym-in-braces"></span> </div></th>
                                <td class="text-right"><strong><span class="amount finalAmt">{{ number_format($cart_amt['total']* Session::get('currency_val'), 2, '.', '') }}</span></strong></td>
                            </tr>
                        </table>
                    </div>
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
        var fieldName = $(this).attr("field");
        //   var maxValue = parseInt($('input[name="quantity"]').attr('max'));
        var thisQty = $(this).parent().find('input[name=' + fieldName + ']');
        //  $(this).parent().find('input[name=' + fieldName + ']').val();
        thisQty.val(parseInt(thisQty.val()) + 1);
        calc(thisQty);
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
    });
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>
@stop
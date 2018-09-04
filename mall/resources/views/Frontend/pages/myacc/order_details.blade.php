@extends('Frontend.layouts.default')
@section('content')
<style>
    .margin-top-5{
        margin-top: 5px;
    }
    .modal-lg{
        width: 83%!important;
    }
</style>
<?php
$currency_val = 1;
$cols = 5;
$currency_code = "inr";
?>

<div itemscope itemtype="#" class="container">
    <div class="page-content">
        <div class="sidebar-position-left">
            <div class="row">
                <div class="col-md-1">
                </div>
                <div class="col-md-10 col-xs-12 margin-top-5">
                    @if(Session::get('successMsg'))
                    <div class="alert alert-success">{{ Session::get('successMsg') }}</div>
                    @endif
                    <div class="col-lg-12 col-md-12">
                        <div class="wpb_column vc_column_container ">
                            <div class="wpb_wrapper">
                                <div class="vc_separator wpb_content_element vc_separator_align_left vc_sep_width_100 vc_sep_pos_align_center vc_sep_color_black">
                                    <div class="ordersuccess-block">
                                        <h2>Order Details</h2>
                                    </div>
                                    <span class="vc_sep_holder vc_sep_holder_r"><span class="vc_sep_line"></span></span>
                                </div>
                                <div id="contactsMsgs"></div>
                                <form action="#" method="post">
                                    <div class="mb-top15">
                                        <table class=".table-condensed table-bordered mb-mb0 orderdetail-steps" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th class="product-name text-center">ORDER ID: <span class="cart-item-details">{{ $order->id }}</span></th>
                                                    <th class=" text-center">Date: <span class="cart-item-details"> {{ date("d-M-Y",strtotime($order->created_at)) }}</span></th>
                                                    <!--<th class="product-quantity text-center">-->
                                                        <!---Status: <span class="cart-item-details">Status </span>--->
                                                    <!--</th>-->
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="wpb_column vc_column_container ">
                            <div class="wpb_text_column wpb_content_element ">
                                <div class="wpb_wrapper">
                                    <form action="#" method="post">                                    
                                        <div class="table-responsive shop-table">
                                            <table class="shop_table cart table table-bordered" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th class="product-name text-center" style="width:20%;">Product Details</th>
                                                        <th class="product-price text-center" style="width:15%;">Price</th>
                                                        <th class="product-quantity text-center" style="width:12%;">Qty</th>
                                                        @if(@$feature['tax'] == 1)
                                                        <th>Tax </th>
                                                        <th class="product-quantity text-center" style="width:12%;">Status</th>
                                                        @endif
                                                        <th class="product-subtotal text-center"  style="width:15%;">Subtotal</th>
                                                        <?php $cols = 5; ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $cartData = json_decode($order->cart, true);
                                                    $gettotal = 0;
                                                    ?> 
                                                    @foreach($orderProds as $key => $ordProd) 
                                                    <?php
                                                    $prd = App\Library\Helper::getCartProd($cartData, $ordProd->prod_id, $ordProd->sub_prod_id);
                                                    dd($prd);
                                                    ?>
                                                    <tr class="cart_item">
                                                <input type="hidden" id="oid" value="{{ $order->id }}" />
                                                <td class="text-center">
                                                    <div class="cart-item-details">
                                                        <?php if ($prd['options']['image'] != '') { ?>
                                                            <img src="{{$prd['options']['image_with_path']."/".@$prd['options']['image'] }}" height="50px" width="50px">
                                                        <?php } else { ?>
                                                            <img src="{{ $prd['options']['image_with_path']}}/default-image.jpg" height="50px" width="50px">
                                                        <?php } ?>
                                                        <br>
                                                        <span class="customer-name">{{ $prd['name'] }}</span><br>
                                                        <?php
                                                        $descript = '';
                                                        if (!empty($prd['options']['options'])) {
                                                            $descript = "";
                                                            foreach ($prd['options']['options'] as $key => $value) {
                                                                $descript .= App\Models\AttributeValue::find($value)->option_name . ",";
                                                            }
                                                        }
                                                        if (!empty($prd['options']['combos'])) {
                                                            foreach ($prd['options']['combos'] as $key => $value) {
                                                                //  echo $key['options']."<br/>";
                                                                if (!empty($value['options'])) {
                                                                    foreach ($value['options'] as $opt => $optval) {
                                                                        echo "<span class='product-size'>" . @App\Models\AttributeValue::find($optval)->option_name . "</span> ";
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        @$descript = rtrim(@$descript, ",");
                                                        echo "<span class='product-size'>" . @$descript . "</span>";
                                                        ?>   
                                                        <?php if ($order->payment_status === 4 && isset($prd['options']['prod_type']) && $prd['options']['prod_type'] == 5) { ?> <button type="button" class="downloadid" value="{{ $prd['id'] }}">Download</button><span class="d{{$prd['id']}}"></span><?php } ?>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <?php
                                                    $currency_val = 1;
                                                    $currency_code = "inr";
                                                    if ($order->currency_id != Session::get('currency_id')) {
                                                        $ordCurrency = DB::table('has_currency')->where('id', Session::get('currency_id'))->first();
                                                    } else {
                                                        $ordCurrency = DB::table('has_currency')->where('id', $order->currency_id)->first();
                                                    }
                                                    $currency_val = $ordCurrency->currency_val;
                                                    $currency_code = $ordCurrency->currency;
                                                    //at
                                                    ?>
                                                    <span class="cart-item-details"><span class=""><span class="currency-sym"></span>
                                                            {{ number_format($prd['price'] * Session::get('currency_val'), 2) }}<br/>
                                                            @if(@$feature['tax'] == 1)
                                                            @if($prd['options']['tax_type'] == 2)
                                                            <small>{Excl. of Tax)</small>
                                                            @elseif($prd['options']['tax_type'] == 1)
                                                            <small>(Inc. of Tax)</small> 
                                                            @endif
                                                            @endif
                                                        </span></span>                   
                                                </td>
                                                <td class="text-center" align="center">
                                                    <div class="product-quntity">{{$prd['qty'] }}</div>
                                                </td>
                                                @if(@$feature['tax'] == 1)
                                                <td>
                                                    <span class="currency-sym"></span>  <span class="tax_{{$prd['rowid']}} tax_amt" rowid='{{$prd['rowid']}}'> {{  number_format($prd['options']['tax_amt'] * Session::get('currency_val'), 2 )}}</span>
                                                </td>
                                                @endif
                                                <td>
                                                    {{$ordProd->orderstatus->order_status}}
                                                </td>
                                                <?php
                                                $subTotal = ($prd['options']['tax_type'] == 2 ) ? $prd['subtotal'] + $prd['options']['tax_amt'] : $prd['subtotal'];
                                                $gettotal += $subTotal;
                                                ?>
                                                <td class="product-subtotal text-right">
                                                    <span class="cart-item-details"><span class="product-total"><span class="currency-sym"></span> {{ number_format($subTotal * Session::get('currency_val'), 2, '.', '' )}}</span></span>                   
                                                </td>
                                                </tr>
                                                @endforeach
                                                <tr class="cart_item">
                                                    <td class="text-right" colspan="{{$cols}}">
                                                        <div class="product-quntity"><strong>Sub-Total</strong></div>
                                                    </td>
                                                    <td class="product-subtotal text-right">
                                                        <span class="cart-item-details">
                                                            <span class="product-total"><span class="currency-sym"></span> {{ number_format($gettotal * $currency_val,2) }}</span></span>                   
                                                    </td>
                                                </tr>
                                                @if($order->coupon_used)
                                                <tr class="cart_item">
                                                    <td class="text-right" colspan="{{$cols}}">
                                                        <div class="product-quntity"> <strong>Coupon Used ({{ $order->coupon['coupon_code'] }}):</strong></div>
                                                    </td>
                                                    <td class="product-subtotal text-right">
                                                        <span class="cart-item-details"><span class="product-total"><span class="currency-sym"></span> {{ number_format(($order->coupon_amt_used * $currency_val),2) }} </span></span>                   
                                                    </td>
                                                </tr>
                                                @endif
                                                @if($order->cod_charges > 0)
                                                <tr class="cart_item">
                                                    <td class="text-right" colspan="{{$cols}}">
                                                        <div class="product-quntity"> <strong>COD Charges</strong></div>
                                                    </td>
                                                    <td class="product-subtotal text-right">
                                                        <span class="cart-item-details"><span class="product-total"><span class="currency-sym"></span> {{ number_format(($order->cod_charges * $currency_val),2) }} </span></span>                   
                                                    </td> 
                                                </tr>
                                                @endif
                                                <?php
                                                if ($order->cod_charges > 0) {
                                                    $addcharge = json_decode($order->additional_charge, true);
                                                    if (array_key_exists('details', $addcharge)) {
                                                        foreach ($addcharge['details'] as $addC) {
                                                            ?>
                                                            <tr class="cart_item">
                                                                <td class="text-right" colspan="{{$cols}}">
                                                                    <div class="product-quntity"> <strong>{{ucfirst($addC['label'])}}</strong></div>
                                                                </td>
                                                                <td class="product-subtotal text-right">
                                                                    <span class="cart-item-details"><span class="product-total"><span class="currency-sym"></span> {{ number_format(($addC['applied'] * $currency_val),2) }} </span></span>                   
                                                                </td> 
                                                            </tr>
                                                            <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                                @if($feature['manual-discount'] == 1 && $order->discount_amt>0)
                                                <tr class="cart_item">
                                                    <td class="text-right" colspan="{{$cols}}">
                                                        <div class="product-quntity"> <strong>Discount</strong></div>
                                                    </td>
                                                    <td class="product-subtotal text-right">
                                                        <span class="cart-item-details"><span class="product-total"><span class="currency-sym"></span> {{ number_format(($order->discount_amt * Session::get('currency_val')), 2, '.', '') }} </span></span>                   
                                                    </td> 
                                                </tr>
                                                @endif
                                                <tr class="cart_item">
                                                    <td class="text-right" colspan="{{$cols}}">
                                                        <div class="product-quntity"><strong>Total</strong></div>
                                                    </td>
                                                    <td class="product-subtotal text-right">
                                                        <span class="cart-item-details"><span class="product-total"><span class="currency-sym"></span> {{ number_format(($order->pay_amt * $currency_val),2) }}</span></span>                   
                                                    </td> 
                                                </tr>
                                                <?php if ($order->order_status == 3) { ?>
                                                    <tr class="cart_item">
                                                        <td colspan="6" class="product-subtotal hide">
                                                            <span class="cart-item-details"><input type="button" class="returnprod" data-oid="{{ $order->id }}" value="Return product's" /><span id="ret{{ $order->id }}"></span></span>                   
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                //Cancel Order Row
                                                //if ($order->order_status == 1) {
                                                ?>
<!--                                                    <tr class="cart_item ">
                                        <td colspan="6" class="product-subtotal text-right">
                                            <a href="javascript:void(0)" class="button button-3d button-mini button-rounded orderCancelled"  >Cancel Order</a>
                                        </td>
                                    </tr>-->
                                                <?php
                                                //}
                                                ?>
                                                </tbody>
                                            </table>
                                            <div id='cancelMsg'></div>
                                        </div>
                                        <div class="clearfix"> </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Cancel Order</h4>
            </div>
            <div class="modal-body ">
                <form action="{{route("statusOrderCancel")}}" id="cancelForm"  method="post">  
                    {{Form::hidden("orderId",@$order->id,[])}}
                    {{Form::hidden("returnAmount",$order->pay_amt,[])}}
                    <div class="row">
                        <div class="col-md-12">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="form_message">Remark</label>
                                <textarea id="form_message" name="remark" class="form-control" placeholder="Remark *" rows="4" required="required" data-error="Please,leave us a message."></textarea>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <input type="button" class="btn btn-success btn-send cancelSubmit" value="Submit">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script  src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js" ></script>

<script>
$(document).on("click", ".orderCancelled", function () {
    console.log("sdf");
    $("#cancelModal").modal("show");
})
$(document).on("click", ".cancelSubmit", function () {
    $("#cancelForm").validate();
    if (!$("#cancelForm").valid()) {
        return false;
    }
    $("#cancelForm").submit();
});

function validate(id) {
    $(".orderReturnForm").validate();
    if (!$(".orderReturnForm").valid()) {
        return false;
    }
    //console.log("sdf");
    var getVal = parseInt($('#' + id).val());
    var getMin = parseInt($('#' + id).attr("min"));
    var getMax = parseInt($('#' + id).attr("max"));
    //console.log("getMax--" + getMax);
    if (getVal >= getMin && getVal <= getMax) {
        return true
    } else {
        alert("Value must be less than or equal to " + getMax);
        return false
    }
}

$(document).ready(function () {
    $(".returnQty").bind('keyup mouseup', function () {
        var thisQty = $(this);
        var price = thisQty.attr("prod-price");
        var id = thisQty.attr("id");

        var varintQty = $('.exchPrdSelect :selected').attr("stock-data");
        if (thisQty.val() > varintQty) {
            alert("Specify Quantity not available!")
            thisQty.val(varintQty);
        } else {
            $(".prod_price_" + id).text(((thisQty.val() * price) * <?php echo Session::get('currency_val'); ?>).toFixed(2));
            $(".prod_amount_" + id).val((thisQty.val() * price));
        }


    });
});
$(document).on("change", ".exchPrdSelect", function () {
    var getSelectedStock = $('option:selected', this).attr('stock-data');
//$(".returnProduct").attr("max", getSelectedStock)
})
$(document).on("click", '.orderReturnTypeClick', function () {
    var orderType = $(this).attr("order-type");
    var mainQty = $(".returnProduct").attr("main-qty");
    console.log(mainQty);
    if (orderType == 1 || orderType == 2) {
        // $(".returnProduct").attr("max", mainQty);
        $(".exchTh").hide();
    } else {
        //  $(".returnProduct").attr("max", mainQty);
        $(".exchPrdSelect").val("");
        $(".exchTh").show();
    }
    $(".orderType").val(orderType);
    $(".returnProduct").select();
});
$(document).on("click", ".returnProduct", function () {
    $(".returnProduct").select();
})
$(document).ready(function () {
    $("html body").on('click', '.tooglelist', function () {
        var d = $(this).attr('data-fid');
        $("#" + d).slideToggle();
    });
    $("html body").on('click', '.tooglelistc', function () {
        var id = $(this).attr('data-target');
        if ($(this).is(':checked'))
        {
            $("#" + id).addClass("in");
            $("#" + id).attr("aria-expanded", "true");
            $("#" + id).css("height", "40px");
        } else {
            $("#" + id).removeClass("in");
            $("#" + id).attr("aria-expanded", "false");
            $("#" + id).css("height", "0px");
        }
    });
    $("html body").on('click', '.returnprod', function () {
        var d = $(this).attr("data-oid");
        var df = "{{ route('orderDetailsJson') }}";
        var str = "id=" + d;
        $("#myModal").modal("show");
        $("#myModal").css("display", "block");
        $.ajax({
            data: str,
            url: df,
            type: "post",
            beforeSend: function () {
                $("#ret" + d).text("Please Wait");
                $(".returndiv").html("Please Wait");
            },
            success: function (a) {
                var t = $(".returnprod").attr("data-oid");
                $("#ret" + t).text('');
                $(".returndiv").html(a);
            }
        });
    });
    $(".cancelprod").click(function () {
        var ordId = $(this).attr("data-oid");
        $.ajax({
            data: {'ordId': ordId},
            url: "{{ route('cancel-order') }}",
            type: "post",
            // dataType: "json",
            beforeSend: function () {
                $(".cancelprod").text("Please Wait");
            },
            success: function (response) {
                if (response['status'] == 'success') {
                    $(".cancelprod").addClass("hide");
                    $('#cancelMsg').html(response['msg']);
                } else {
                    $('#cancelMsg').html(response['msg']);
                }
            }
        });
    });
});
</script>
@stop

@extends('Frontend.layouts.default')

@section('content')
<!--<div class="page-heading bc-type-3">
    <div class="bc-type-order bg-pos-crumb">
        <div class="container">
            <div class="row">
                <div class="col-md-12 a-center">
                    <h1 class="title">Order Details</h1>
                    <nav class="woocommerce-breadcrumb" itemprop="breadcrumb">
                        <a href="#">Home</a> <span class="delimeter">/</span> 
                        <a href="#">Order Details</a> 
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>-->

<div class="breadcrumb">
    <div class="container">
        <ul>
            <li><a href="{{ route('myProfile') }}">Home</a></li>
            <li><span class="current">Order Details</span></li>
        </ul>
    </div><!-- .container -->
</div><!-- .breadcrumb -->

<div itemscope itemtype="#" class="container">
    <div class="page-content">
        <div class="page-content sidebar-position-left">
            <div class="row">
                <div class="col-md-3">
                    @include('Frontend.includes.myacc')
                </div>

                <div class="col-md-9 col-xs-12">
                    <div class="col-lg-12 col-md-12">
                        <div class="wpb_column vc_column_container ">
                            <div class="wpb_wrapper">
                                <div class="vc_separator wpb_content_element vc_separator_align_left vc_sep_width_100 vc_sep_pos_align_center vc_sep_color_black">
                                    <h4>Order Details</h4>
                                    <span class="vc_sep_holder vc_sep_holder_r"><span class="vc_sep_line"></span></span>
                                </div>
                                <div id="contactsMsgs"></div>
                                <form action="#" method="post">
                                    <div class="mb-top15">
                                        <table class=".table-condensed table-bordered mb-mb0" style="background:#000; color:#fff;" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th class="product-name" style="width:30%;">Order ID: <span class="cart-item-details">{{ $order->id }}</span></th>
                                                    <th class="product-price" style="width:30%;">Date: <span class="cart-item-details">{{ date("d-M-Y",strtotime($order->created_at)) }}</span></th>
                                                    <th class="product-quantity" style="width:40%;">Status: <span class="cart-item-details">{{ $order->orderstatus['order_status'] }}</span></th>
                                                </tr>
                                            </thead>
                                        </table>
                                </form>
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
                                                    <th class="product-name" style="width:20%;">Product Details</th>
                                                    <th class="product-price" style="width:20%;">Price</th>
                                                    <th class="product-quantity" style="width:20%;">QTY</th>
                                                    <th class="product-subtotal" style="width:20%;">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $cartData = json_decode($order->cart, true);
                                                //  echo "<pre>";print_r(json_decode($order));print_r($cartData);echo "</pre>";
                                                $gettotal = 0;
//                                                $descript = "";
                                                ?> 
                                                @foreach($cartData as $prd)  
                                                <tr class="cart_item">
                                            <input type="hidden" id="oid" value="{{ $order->id }}" />
                                            <td class="">
                                                <div class="cart-item-details">
                                                    <?php if ($prd['options']['image'] != '') { ?>
                                                        <img src="{{ @asset(Config('constants.productImgPath'))."/".@$prd['options']['image'] }}" height="50px" width="50px">
                                                    <?php } else { ?>
                                                        <img src="{{ @asset(Config('constants.productImgPath'))}}/default-image.jpg" height="50px" width="50px">
                                                    <?php } ?>

<!--<img src="{{ asset(Config('constants.productImgPath').@App\Models\Product::find($prd['id'])->catalogimgs()->where('image_mode',1)->first()->filename) }}" height="50px" width="50px">-->

                                                    <a href="javascript:void(0)">
                                                        <span class="customer-name">{{ $prd['name'] }}</span><br>
                                                        <?php
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
                                                    </a> 

                                                    <?php if ($order->payment_status === 4 && isset($prd['options']['prod_type']) && $prd['options']['prod_type'] == 5) { ?> <button type="button" class="downloadid" value="{{ $prd['id'] }}">Download</button><span class="d{{$prd['id']}}"></span><?php } ?>
                                                </div>
                                            </td>
                                            <td class="">
                                                <?php
                                                $currency_val = 1;
                                                $currency_code = "inr";
                                                if (isset($order->currency->currency_val)) {
                                                    $currency_val = $order->currency->currency_val;
                                                    $currency_code = $order->currency->currency;
                                                }
                                                ?>
                                                <span class="cart-item-details"><span class="product-price"><i class="fa fa-{{ $currency_code }}"></i> {{ number_format($prd['price'] * $currency_val,2) }}</span></span>                   
                                            </td>
                                            <td class="">
                                                <div class="product-quntity">{{$prd['qty'] }}</div>
                                            </td>

<?php $gettotal += $prd['subtotal']; ?>

                                            <td class="product-subtotal">
                                                <span class="cart-item-details"><span class="product-total"><i class="fa fa-{{ $currency_code }}"></i> {{ number_format($prd['subtotal'] * $currency_val,2) }}</span></span>                   
                                            </td>
                                            </tr>
                                            @endforeach
                                            <tr class="cart_item">
                                                <td class="">
                                                    <div class="cart-item-details">
                                                        <a href="#">
                                                            <span class="customer-name">&nbsp;</span>
                                                        </a>                                                
                                                    </div>
                                                </td>
                                                <td class="">
                                                    <span class="cart-item-details">&nbsp;</span>                   
                                                </td>
                                                <td class="">
                                                    <div class="product-quntity">Sub Total</div>
                                                </td>
                                                <td class="product-subtotal">
                                                    <span class="cart-item-details"><span class="product-total"><i class="fa fa-{{ $currency_code }}"></i> {{ number_format($gettotal * $currency_val,2) }}</span></span>                   
                                                </td>
                                            </tr>
                                            @if($order->coupon_used)
                                            <tr class="cart_item">
                                                <td class="">
                                                    <div class="cart-item-details">
                                                        <a href="#">
                                                            <span class="customer-name">&nbsp;</span>
                                                        </a>                                                
                                                    </div>
                                                </td>
                                                <td class="">
                                                    <span class="cart-item-details">&nbsp;</span>                   
                                                </td>
                                                <td class="">
                                                    <div class="product-quntity"> Coupon Used: ({{ $order->coupon['coupon_code'] }}):</div>
                                                </td>
                                                <td class="product-subtotal">
                                                    <span class="cart-item-details"><span class="product-total"><?php echo htmlspecialchars_decode(Session::get('currency_symbol')); ?>{{ number_format($order->coupon_amt_used,2) }} </span></span>                   
                                                </td>
                                            </tr>
                                            @else
                                            <tr class="cart_item">
                                                <td class="">
                                                    <div class="cart-item-details">
                                                        <a href="#">
                                                            <span class="customer-name">&nbsp;</span>
                                                        </a>                                                
                                                    </div>
                                                </td>
                                                <td class="">
                                                    <span class="cart-item-details">&nbsp;</span>                   
                                                </td>
                                                <td class="">
                                                    <div class="product-quntity"> Coupon Used: </div>
                                                </td>
                                                <td class="product-subtotal">
                                                    <span class="cart-item-details"><span class="product-total"><i class="fa fa-{{ $currency_code }}"></i> 0.00</span></span>                   
                                                </td>
                                            </tr>
                                            @endif
                                            @if($order->cod_charges > 0)
                                            <tr class="cart_item">
                                                <td class="">
                                                    <div class="cart-item-details">
                                                        <a href="#">
                                                            <span class="customer-name">&nbsp;</span>
                                                        </a>                                                
                                                    </div>
                                                </td>
                                                <td class="">
                                                    <span class="cart-item-details">&nbsp;</span>                   
                                                </td>
                                                <td class="">
                                                    <div class="product-quntity"> Cod Charges:</div>
                                                </td>
                                                <td class="product-subtotal">
                                                    <span class="cart-item-details"><span class="product-total"><i class="fa fa-{{ $currency_code }}"></i> {{ number_format($order->cod_charges,2) }} </span></span>                   
                                                </td>
                                            </tr>
                                            @endif
                                            <tr class="cart_item">
                                                <td class="">
                                                    <div class="cart-item-details">
                                                        <a href="#">
                                                            <span class="customer-name">&nbsp;</span>
                                                        </a>                                                
                                                    </div>
                                                </td>
                                                <td class="">
                                                    <span class="cart-item-details">&nbsp;</span>                   
                                                </td>
                                                <td class="">
                                                    <div class="product-quntity"> Total</div>
                                                </td>
                                                <td class="product-subtotal">
                                                    <span class="cart-item-details"><span class="product-total"><i class="fa fa-{{ $currency_code }}"></i> {{ number_format($order->pay_amt,2) }}</span></span>                   
                                                </td>
                                            </tr>
<?php if ($order->order_status == 3) { ?>
                                                <tr class="cart_item">
                                                    <td colspan="4" class="product-subtotal">
                                                        <span class="cart-item-details"><input type="button" class="returnprod" data-oid="{{ $order->id }}" value="Return product's" /><span id="ret{{ $order->id }}"></span></span>                   
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            if ($order->order_status == 1) {
                                                ?>
                                                <tr class="cart_item">
                                                    <td colspan="4" class="product-subtotal">
                                                        <span class="cart-item-details"><input type="button" class="cancelprod" data-oid="{{ $order->id }}" value="Cancel Order" /><span id="ret{{ $order->id }}"></span></span>                   
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                           
                                            </tbody>
                                        </table>
                                         <div id='cancelMsg'></div>
                                    </div>

                                    <div class="clearfix"> </div>
                                    <!--                    <div class="actions contfooter">
                                                          <input class="btn gray big" name="Cancel" value="Cancel" type="submit"> 
                                                          <input class="btn gray big" name="Return" value="Return" type="submit"> 
                                                          <input class="btn gray big" name="Exchange" value="Exchange" type="submit"> 
                                                        </div>-->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Return Order</h4>
            </div>
            <div class="modal-body returndiv">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<script  src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js" ></script>
<script>
$(document).ready(function () {

    $('html body').on('submit', '#returnOrder', function () {
        $.ajax({
            url: "{{ route('UpdateReturnOrderStatusf') }}",
            type: 'post',
            data: new FormData(this),
            processData: false,
            contentType: false,
            beforeSend: function () {
                $(".submitReturn").attr("disabled", "disabled");
            },
            success: function (res) {
                window.location.href = "";
            }
        });
        return false;
    });

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


    $("html body").on('submit', '#return_cal_quantity', function () {
        $.ajax({
            url: "{{ route('orderReturnCal') }}",
            type: 'post',
            data: new FormData(this),
            processData: false,
            contentType: false,
            //   dataType: 'json',
            beforeSend: function () {
                // $("#barerr" + id).text('Please wait');
            },
            success: function (res) {
                //     $("#tempHtml").html(res);
                console.log(res);
            }
        });
        return false;
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

    $(".downloadid").click(function () {
        var d = $(this).val();
        var f = $("#oid").val();
        var df = "{{ route('downloadEfiles') }}";
        var str = "i=" + d + "&f=" + f;
        $.ajax({
            data: str,
            url: df,
            type: "post",
            dataType: "json",
            beforeSend: function () {
                $(".d" + d).text("Please Wait");
            },
            success: function (a) {
                if (a.errCode == 0 || a.errCode == 1) {
                    $(".d" + d).text(a.msg);
                } else if (a.errCode == 2) {
                    $(".d" + d).text('Thank you for downloading');
                    var t = "{{ route('filedown') }}/" + a.msg;
                    window.location = t;
                }
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

@extends('Frontend.layouts.default')
@section('content')
<style>
    .margin-top-5{
        margin-top: 5px;
    }
    .modal-lg{
        width: 83%!important;
    }
     .rating {
  /*display: inline-block;*/
  position: relative;
  height: 50px;
  line-height: 50px;
  font-size: 50px;
}

.rating label {
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  cursor: pointer;
}

.rating label:last-child {
  position: static;
}

.rating label:nth-child(1) {
  z-index: 5;
}

.rating label:nth-child(2) {
  z-index: 4;
}

.rating label:nth-child(3) {
  z-index: 3;
}

.rating label:nth-child(4) {
  z-index: 2;
}

.rating label:nth-child(5) {
  z-index: 1;
}

.rating label input {
  position: absolute;
  top: 0;
  left: 0;
  opacity: 0;
}

.rating label .icon {
  float: left;
  color: transparent;
  font-size: xx-large;
}

.rating label:last-child .icon {
  color: #000;
}

.rating:not(:hover) label input:checked ~ .icon,
.rating:hover label:hover input ~ .icon {
  color: #09f;
}

.rating label input:focus:not(:checked) ~ .icon:last-child {
  color: #000;
  text-shadow: 0 0 5px #09f;
}   
</style>
<?php
$currency_val = 1;
    $cols=5;
$currency_code = "inr";
if (isset($order->currency->currency_val)) {
    $currency_val = $order->currency->currency_val;
    $currency_code = $order->currency->currency;
}
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
                                                    <th class="product-quantity text-center">Status: <span class="cart-item-details">{{isset($checkCancelOrder[0]) && count($checkCancelOrder[0])==1 && isset($checkCancelOrder[0]->status) && $checkCancelOrder[0]->status==0? "Cancel Order Requested":$order->orderstatus['order_status'] }} </span></th>
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
                                                        @if(@$feature['coupon'] == 1)
                                                        <th>Coupon Discount</th>
                                                        @endif
                                                        @if(@$feature['tax'] == 1)
                                                        <th>Tax </th>
                                                        @endif
                                                        <th class="product-subtotal text-center"  style="width:15%;">Subtotal</th>
                                                        <th>Action</th>
                                                        @if(isset($order->orderstatus['id']) && $order->orderstatus['id']==3)
                                                        <?php $cols=6; ?>
                                                        <th style="width:15%;"></th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $cartData = json_decode($order->cart, true);
                                                    //  echo "<pre>";print_r(json_decode($order));print_r($cartData);echo "</pre>";
                                                    $gettotal = 0;
//                                                $descript = "";
                                                    $collectProductWithId = [];
                                                    ?> 
                                                    @foreach($cartData as $key => $prd)  

                                                    <?php
                                                    $collectProductWithId[$prd['id']] = $prd;
                                                    ?>
                                                    <?php
                                                    // dd($collectOrderProduct[$prd["id"]]->attributeset->attributes)
                                                    ?>
                                        <tr class="cart_item">
                                        <input type="hidden" id="oid" value="{{ $order->id }}" />
                                        <td class="text-center">
                                        <div class="cart-item-details">
                                        <?php if ($prd['options']['image'] != '') { ?>
                                        <img src="{{ @asset(Config('constants.productImgPath'))."/".@$prd['options']['image'] }}" height="50px" width="50px">
                                        <?php } else { ?>
                                        <img src="{{ @asset(Config('constants.productImgPath'))}}/default-image.jpg" height="50px" width="50px">
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
                                        $ordCurrency = App\Models\HasCurrency::where('id', Session::get('currency_id'))->first();
                                        } else {
                                        $ordCurrency = App\Models\HasCurrency::where('id', $order->currency_id)->first();
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
                                         @if(@$feature['coupon'] == 1)
                                        <td>
                                          <span class="currency-sym"></span>  <span class="disc_indv{{$prd['rowid']}} disc_indv" rowid='{{$prd["rowid"]}}'> {{ number_format($prd['options']['disc'] * Session::get('currency_val'), 2 )}}</span>

                                        </td>
                                        @endif
                                        @if(@$feature['tax'] == 1)
                                        <td>
                                          <span class="currency-sym"></span>  <span class="tax_{{$prd['rowid']}} tax_amt" rowid='{{$prd['rowid']}}'> {{  number_format($prd['options']['tax_amt'] * Session::get('currency_val'), 2 )}}</span>
                                        </td>
                                        @endif
                                       

                                        <?php 
                                        $subTotal = ($prd['options']['tax_type']== 2 ) ? $prd['subtotal'] + $prd['options']['tax_amt'] : $prd['subtotal']; 
                                        $gettotal += $subTotal; ?> 

                                        <td class="product-subtotal text-right">
                                        <span class="cart-item-details"><span class="product-total"><span class="currency-sym"></span> {{ number_format($subTotal * Session::get('currency_val'), 2, '.', '' )}}</span></span>                   
                                        </td>
                                        <td class="{{isset($order->orderstatus['id']) && $order->orderstatus['id']==3?"":"hide"}}">

                                        <?php
                                        //print_r(@$getReturnRequestSum);

                                        $sumOfRequestAndComplete = @$getReturnRequestSum[$prd['options']['sub_prod']];
                                        $returnSumqtycom = @$returnSumqty[$prd['options']['sub_prod']];
                                        //  echo $sumOfRequestAndComplete .' prod ' .$prd['options']['sub_prod'] ."<br>"; 

                                        ?>

                                        @if(count($returnProductStatus)>0)
                                        @if($sumOfRequestAndComplete==$prd['options']['sub_prod'])
                                        <p>Check Replacement Status</p>
                                        @else
                                        @if(isset($order->order_status) && $order->order_status==3)
                                        @if(isset($prd['options']['prod_type']) && $prd['options']['prod_type']==3)
                                        <a href="#" class="button button-3d button-mini button-rounded orderReturnTypeClick" data-toggle="modal" order-type='2'  data-target="#viewDetail{{$prd['options']['sub_prod']}}" data-backdrop="static" data-keyboard="false">Return Item</a>
                                        <a href="#" class="button button-3d button-mini button-rounded orderReturnTypeClick" data-toggle="modal" order-type='3' data-target="#viewDetail{{$prd['options']['sub_prod']}}">Exchange Item</a>
                                        @else
                                        <a href="#" class="button button-3d button-mini button-rounded orderReturnTypeClick" data-toggle="modal" order-type='2'  data-target="#viewDetail{{$prd['id']}}">Return Item</a>
                                        @endif
                                        <!--                                                    @if(isset($prd['options']['prod_type']) && $prd['options']['prod_type']==3)
                                                                                
                                                                                @endif-->
                                        @else       
                                        <a href="#" class="button hide button-3d button-mini button-rounded orderReturnTypeClick" data-toggle="modal" order-type='1' data-target="#viewDetail{{$prd['id']}}" >Cancel Item</a>
                                        @endif
                                        @endif
                                        @else
                                        <p>Return not available</p>
                                        @endif
                                        @if(isset($prd['options']['prod_type']) && $prd['options']['prod_type']==3)
                                        <div class="modal fade viewDetailModal" id="viewDetail{{$prd['options']['sub_prod']}}" role="dialog">
                                        @else
                                        <div class="modal fade viewDetailModal" id="viewDetail{{$prd['id']}}" role="dialog">
                                        @endif
                                        <div class="modal-dialog  modal-lg">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Product Details</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="clearfix"></div>
                                                <form action="#" method="post" class="">  </form>
                                                <?php $prodId=empty($sub_prod_id) ? $prd["id"] : $sub_prod_id; ?>
                                                <form action="{{route('orderReturnCal')}}" onsubmit="return validate($prodId)" method="post" class="orderReturnForm">            
                                                    {{csrf_field()}}
                                                    {!! Form::hidden('order_status','',['class'=>'orderType']) !!}
                                                    <div class="table-responsive shop-table">

                                                        <table class="shop_table cart table table-bordered" cellspacing="0">
                                                            <thead>
                                                                <tr>
                                                                    <th class="product-name text-left" style="width:35%">Name</th>
                                                                    <th style="width:10%" class="product-quantity text-center">QTY</th>
                                                                    @if(isset($prd['options']['prod_type']) && $prd['options']['prod_type']==3)
                                                                    <th class="product-quantity text-center exchTh" style="width:30%">Exchange With</th>
                                                                    @endif
                                                                    <th class="product-quantity text-center" style="width:20%">Reason</th>
                                                                    <th class="product-price text-center" style="width:10%">Price</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                                <tr class="cart_item">
                                                            <input type="hidden" name="oid" value="{{ $order->id }}">
                                                            <td class="text-left">
                                                                <div class="cart-item-details">
                                                                    <?php if ($prd['options']['image'] != '') { ?>
                                                                        <img src="{{ @asset(Config('constants.productImgPath'))."/".@$prd['options']['image'] }}" height="50px" width="50px">
                                                                    <?php } else { ?>
                                                                        <img src="{{ @asset(Config('constants.productImgPath'))}}/default-image.jpg" height="50px" width="50px">
                                                                    <?php } ?> 

                                                                    <a href="javascript:void(0)">
                                                                        <?php
                                                                        $getProduct = @$collectOrderProduct[@$prd['id']];
                                                                        //dd($getProduct);
                                                                        $configName = @json_decode(@$getProduct->pivot->product_details)->name;
                                                                        ?><br>
                                                                        <span class="customer-name">{{ isset($configName)?$configName:$prd['name'] }}</span><br>
                                                                    </a> 
                                                                </div>
                                                            </td>
                                                            <td class="">
                                                                <?php 
                                                                $mainQty = isset($returnSumqtycom) && $returnSumqtycom != 0 ? $prd['qty'] - $returnSumqtycom : $prd['qty'];
                                                                ?>
                                                                <div class="product-quntity">
                                                                    <input type='number' main-qty="{{$mainQty}}"prod-type="{{$prd['options']['prod_type']}}" prod-price="{{$prd['price']}}" name="return_product[{{$prd['id']}}][quantity]" class="form-control returnProduct returnQty" min='1' max="{{$mainQty}}" value="1"  id="{{ empty($sub_prod_id) ? $prd['id'] : $sub_prod_id }}">
                                                                </div>
                                                            </td>
                                                            @if(isset($prd['options']['prod_type']) && $prd['options']['prod_type']==3)
                                                            <td class="exchTh">
                                                                <?php
                                                                $data = @$collectOrderProduct[$prd["id"]]->subproducts;
                                                                $subProdId = @$collectOrderProduct[$prd["id"]]->pivot->sub_prod_id;
                                                                ?>
                                                                <select name="return_product[{{$prd['id']}}][exchange_product_id]" class="form-control exchPrdSelect required">
                                                                    <option value="">Select Item</option>
                                                                    @foreach($data as $getItem)
                                                                    @if($getItem->id != $subProdId)
                                                                   <?php if($feature['stock']==1){
                                                                       $stock= $prd['options']['is_stock']==1?$getItem->stock:'1000';
                                                                       if($prd['options']['is_stock']==1 && $getItem->stock <= 0){
                                                                          continue;
                                                                       }
                                                                   }else{
                                                                       $stock='10000';
                                                                   }
                                                                      
                                                                   ?>
                                                                    <option  stock-data="{{$stock}}" class="checkStock" value="{{@$getItem->id}}">{{@$getItem->product}}</option>
                                                                    @endif
                                                                    @endforeach
                                                                </select>

                                                            </td>
                                                            @endif
                                                            <td class="orderReturnSelect">
                                                                {{ Form::select("return_product[".$prd['id']."][reason]",$orderReturnReason,null,['class'=>'form-control ']) }}
                                                                {{ Form::hidden("return_product[".$prd['id']."][amount]",$prd['price'],['class'=>"prod_amount_$prodId" ]) }}
                                                                {{ Form::hidden("return_product[".$prd['id']."][sub_prod]",$prd['options']['sub_prod'],['class'=>'']) }}
                                                            </td>


                                                            <td class="">
                                                                <span class="cart-item-details"><span class="product-price">
                                                                        <span class="currency-sym "></span> <span class="prod_price_{{$prodId}}">{{ number_format($prd['price'] * $currency_val,2) }}</span></span>
                                                                </span>   
                                                            </td>
                                                            </tr>
                                                            <tr class="cart_item">
                                                                <td colspan="5" class="product-subtotal text-left">
                                                                    <span class="cart-item-details"><input type="submit" class=" button closeModal" value="Submit"><span id="ret24"></span></span>                   
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                        <div id="cancelMsg"></div>
                                                    </div>
                                                    <div class="clearfix"> </div> 
                                                </form>
                                            </div>
                                        </div>

                                        </div>
                                        </div>
                                        </td>
                                        <td>
                                            <button class="button button-3d button-mini button-rounded" data-toggle="modal"  id="rev{{$prd['id']}}" onclick="getReviewData('{{$prd['id']}}','{{$order->id}}')"> Review</button>
                                           
                                        </td>
                                        </tr>
                                                @endforeach
                                                <tr class="cart_item">
                                                    <!-- <td class="">
                                                        <div class="cart-item-details">
                                                            <a href="#">
                                                                <span class="customer-name">&nbsp;</span>
                                                            </a>                                                
                                                        </div>
                                                    </td>
                                                    <td class="">
                                                        <span class="cart-item-details">&nbsp;</span>                   
                                                    </td> -->
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
                                                    <!-- <td class="">
                                                        <div class="cart-item-details">
                                                            <a href="#">
                                                                <span class="customer-name">&nbsp;</span>
                                                            </a>                                                
                                                        </div>
                                                    </td>
                                                    <td class="">
                                                        <span class="cart-item-details">&nbsp;</span>                   
                                                    </td> -->
                                                    <td class="text-right" colspan="{{$cols}}">
                                                        <div class="product-quntity"> <strong>Coupon Used ({{ $order->coupon['coupon_code'] }}):</strong></div>
                                                    </td>
                                                    <td class="product-subtotal text-right">
                                                        <span class="cart-item-details"><span class="product-total"><span class="currency-sym"></span> {{ number_format(($order->coupon_amt_used * $currency_val),2) }} </span></span>                   
                                                    </td>
                                                </tr>
                                                @else
                                                <tr class="cart_item">
                                                    <!-- <td class="">
                                                        <div class="cart-item-details">
                                                            <a href="#">
                                                                <span class="customer-name">&nbsp;</span>
                                                            </a>                                                
                                                        </div>
                                                    </td>
                                                    <td class="">
                                                        <span class="cart-item-details">&nbsp;</span>                   
                                                    </td> -->
                                                    <td class="text-right" colspan="{{$cols}}">
                                                        <div class="product-quntity"> <strong>Coupon Used</strong> </div>
                                                    </td>
                                                    <td class="product-subtotal text-right">
                                                        <span class="cart-item-details"><span class="product-total"><span class="currency-sym"></span> 0.00</span></span>                   
                                                    </td> 
                                                </tr>
                                                @endif
                                                @if($order->cod_charges > 0)
                                                <tr class="cart_item">
                                                    <!-- <td class="">
                                                        <div class="cart-item-details">
                                                            <a href="#">
                                                                <span class="customer-name">&nbsp;</span>
                                                            </a>                                                
                                                        </div>
                                                    </td>
                                                    <td class="">
                                                        <span class="cart-item-details">&nbsp;</span>                   
                                                    </td> -->
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
                                                    if(array_key_exists('details', $addcharge))
                                                    {
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
                                                @if($feature['manual-discount'] == 1)
                                                <tr class="cart_item">
                                                    <!-- <td class="">
                                                        <div class="cart-item-details">
                                                            <a href="#">
                                                                <span class="customer-name">&nbsp;</span>
                                                            </a>                                                
                                                        </div>
                                                    </td>
                                                    <td class="">
                                                        <span class="cart-item-details">&nbsp;</span>                   
                                                    </td> -->
                                                    <td class="text-right" colspan="{{$cols}}">
                                                        <div class="product-quntity"> <strong>Discount</strong></div>
                                                    </td>
                                                    <td class="product-subtotal text-right">
                                                        <span class="cart-item-details"><span class="product-total"><span class="currency-sym"></span> {{ number_format(($order->discount_amt * Session::get('currency_val')), 2, '.', '') }} </span></span>                   
                                                    </td> 
                                                </tr>
                                                @endif
                                                <tr class="cart_item">
                                                    <!-- <td class="">
                                                        <div class="cart-item-details">
                                                            <a href="#">
                                                                <span class="customer-name">&nbsp;</span>
                                                            </a>                                                
                                                        </div>
                                                    </td>
                                                    <td class="">
                                                        <span class="cart-item-details">&nbsp;</span>                   
                                                    </td> -->
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
                                                if ($order->order_status == 1) {
                                                    ?>
                                                    @if(isset($checkCancelOrder) && count($checkCancelOrder)==0)
                                                    <tr class="cart_item ">
                                                        <td colspan="6" class="product-subtotal text-right">
                                                            <a href="javascript:void(0)" class="button button-3d button-mini button-rounded orderCancelled"  >Cancel Order</a>
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    <?php
                                                }
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
                  <div class="clearfix"></div>
            @if(isset($getReturnRequest) && count($getReturnRequest)>0)

                    <div class="col-lg-12 col-md-12 replace-statBox">
                        <div class="wpb_column vc_column_container ">
                            <div class="wpb_wrapper">
                                <div class="vc_separator wpb_content_element vc_separator_align_left vc_sep_width_100 vc_sep_pos_align_center vc_sep_color_black">
                                    <h4>Replacement Status</h4>
                                    <span class="vc_sep_holder vc_sep_holder_r"><span class="vc_sep_line"></span></span>
                                </div>
                            </div>
                            <div class="wpb_wrapper table-responsive">
                                <table class="shop_table cart table table-bordered" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="product-name " >Name</th>
                                            <th class="product-quantity ">Qty</th>
                                            <th class="product-quantity ">Price</th>
                                            <th class="product-quantity ">Requested For</th>
                                            <th class="product-quantity ">Requested On</th>
                                            <th class="product-quantity ">Completed On</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @foreach($getReturnRequest as $returnRequest) 
                                        @if(isset($collectProductWithId[$returnRequest->product_id]))
                                        <?php
                                        $getProduct = $collectOrderProduct[$returnRequest->product_id];
                                        $configName = @json_decode($getProduct->pivot->product_details)->name;
                                        $collectProduct = $collectProductWithId[$returnRequest->product_id];
                                        ?>
                                        <tr class="cart_item">
                                    <input type="hidden" name="oid" value="35">
                                    <td class="text-left" style="border-right: 1px solid #ddd !important;">
                                        <div class="cart-item-details">
                                            <?php if ($collectProduct['options']['image'] != '') { ?>
                                                <img src="{{ @asset(Config('constants.productImgPath'))."/".@$collectProduct['options']['image'] }}" height="50px" width="50px">
                                            <?php } else { ?>
                                                <img src="{{ @asset(Config('constants.productImgPath'))}}/default-image.jpg" height="50px" width="50px">
                                            <?php } ?>
                                            <br>
                                            
                                                <span class="customer-name">{{isset($prd['options']['prod_type']) && $prd['options']['prod_type']==3?$configName: $collectProduct['name'] }}</span><br>
                                                <span class="product-size"></span>   
                                          
                                            @if($prd['options']['prod_type']==3 && isset($returnRequest->exchangeProduct->product))
                                            <span class="product-size"><b>Exchanged Product</b>:  {{@$returnRequest->exchangeProduct->product}}</span>   
                                            @endif
                                        </div>
                                    </td>

                                    <td style="border-right: 1px solid #ddd !important;">
                                        <div class="product-quntity">{{@$returnRequest->quantity}}</div>
                                    </td>
                                    <td style="border-right: 1px solid #ddd !important;">
                                        <span class="cart-item-details">
                                            <span class="product-quntity">
                                                <span class="currency-sym"></span> {{ number_format($collectProduct['price'] * $currency_val,2) }}
                                            </span>
                                        </span>                   
                                    </td>

                                    <?php
                                    $orderStatus = [1 => 'Cancelled', 2 => 'Returned', 3 => 'Exchange'];
                                    ?>
                                    <td style="border-right: 1px solid #ddd !important;">  {{ @$orderStatus[$returnRequest->order_status] }}</td>
                                    <td style="border-right: 1px solid #ddd !important;">
                                        {{ date("d-m-Y h:i a",strtotime($returnRequest->created_at)) }}
                                    </td>
                                    <td style="border-right: 1px solid #ddd !important;">
                                        {{$returnRequest->return_status==2? date("d-m-Y h:i a",strtotime($returnRequest->updated_at)):"-" }}
                                    </td>
                                    <td>
                                        {{@$returnRequest->return_status_id->status}}
                                    </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif  
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
                            <div class="form-group">
                                <label for="form_email">Reason</label>
                                {{ Form::select("reasonId",@$orderReturnReason,null,['class'=>'form-control ']) }}
                                <div class="help-block with-errors"></div>
                            </div>
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
<!-- Modal -->
  <div class="modal fade" id="reviewModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <form method="post" id="reviewForm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Review</h4>
        </div>
        <div class="modal-body">
          <div class="col_full">
            <label for="template-contactform-name">Title <small>*</small>
            </label>
            <input type="title" name="title" placeholder="Title" class="sm-form-control required" aria-required="true">
            <div id="title_validate" style="color:red;"></div>
        </div>
        <div class="col_full">
            <label for="template-contactform-name">Description <small>*</small>
            </label>
            <textarea class="sm-form-control required" rows="5" name="desc"></textarea>
         </div>
         <input type="hidden" name="pid" id="apid" value="{{$prd['id']}}">
         <input type="hidden" name="ord_id" id="aoid" value="{{$order->id}}">
          <div class="col_full">
         <label for="template-contactform-name">Rating <small>*</small>
            </label>
    
        <div class="rating">
  <label>
    <input type="radio" name="stars" value="1" />
    <span class="icon">★</span>
  </label>
  <label>
    <input type="radio" name="stars" value="2" />
    <span class="icon">★</span>
    <span class="icon">★</span>
  </label>
  <label>
    <input type="radio" name="stars" value="3" />
    <span class="icon">★</span>
    <span class="icon">★</span>
    <span class="icon">★</span>   
  </label>
  <label>
    <input type="radio" name="stars" value="4" />
    <span class="icon">★</span>
    <span class="icon">★</span>
    <span class="icon">★</span>
    <span class="icon">★</span>
  </label>
  <label>
    <input type="radio" name="stars" value="5" />
    <span class="icon">★</span>
    <span class="icon">★</span>
    <span class="icon">★</span>
    <span class="icon">★</span>
    <span class="icon">★</span>
  </label>
</div> </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-primary add_review_btn" value="Submit" name="add_review_btn">  
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
     
      </div>
      </div>
      </form>
    </div>
  </div>

  <div class="modal fade" id="editreviewModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <form method="post" id="editreviewForm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Review</h4>
        </div>
        <div class="modal-body">
          <div class="col_full">
            <label for="template-contactform-name">Title <small>*</small>
            </label>
            <input type="title" id="title" name="title" placeholder="Title" class="sm-form-control required" aria-required="true">
            <div id="title_validate" style="color:red;"></div>
        </div>
        <div class="col_full">
            <label for="template-contactform-name">Description <small>*</small>
            </label>
            <textarea class="sm-form-control required" rows="5" name="desc" id="desc"></textarea>
         </div>
         <input type="hidden" name="pid" id="epid" value="">
         <input type="hidden" name="ord_id" id="eoid" value="">
          <div class="col_full">
         <label for="template-contactform-name">Rating <small>*</small>
            </label>
    
        <div class="rating">
  <label>
    <input type="radio" name="stars" id="stars1" value="1" />
    <span class="icon">★</span>
  </label>
  <label>
    <input type="radio" name="stars" id="stars2" value="2" />
    <span class="icon">★</span>
    <span class="icon">★</span>
  </label>
  <label>
    <input type="radio" name="stars" id="stars3" value="3" />
    <span class="icon">★</span>
    <span class="icon">★</span>
    <span class="icon">★</span>   
  </label>
  <label>
    <input type="radio" name="stars" id="stars4" value="4" />
    <span class="icon">★</span>
    <span class="icon">★</span>
    <span class="icon">★</span>
    <span class="icon">★</span>
  </label>
  <label>
    <input type="radio" name="stars" id="stars5" value="5" />
    <span class="icon">★</span>
    <span class="icon">★</span>
    <span class="icon">★</span>
    <span class="icon">★</span>
    <span class="icon">★</span>
  </label>
</div> </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-primary edit_review_btn" id="updatebtn" value="Submit">  
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
     
      </div>
      </div>
      </form>
    </div>
  </div>
<script  src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js" ></script>

<script>

$(':radio').change(function() {
  console.log('New star rating: ' + this.value);
});

$(".add_review_btn").click(function(e){
        e.preventDefault();
        var formdata = $("#reviewForm").serialize();
        //alert(formdata);
        $.ajax({
           type:'POST',
           url:domain + '/save_review',
           data:formdata,
           success:function(data){
              $("#reviewForm")[0].reset();
              $('#reviewModal').modal('toggle');
           }
        });
    });

$(".edit_review_btn").click(function(e){
        e.preventDefault();
        var editformdata = $("#editreviewForm").serialize();
        //alert(formdata);
        $.ajax({
           type:'POST',
           url:domain + '/save_review',
           data:editformdata,
           success:function(data){
              $('#editreviewModal').modal('toggle');
           }
        });
    });

function getReviewData(pid,orderid)
{
    $.ajax({
       type:'POST',
       url:domain + '/get_review',
       data:{id:pid,orderid:orderid},
       success:function(data){
        //alert(data.id);
        if(data !='')
        {
            $("#title").val(data.title);
            $("#desc").val(data.description);
            $("#epid").val(data.product_id);
            $("#eoid").val(data.order_id);
            var rb = data.rating;
            var status = data.publish;
            if(status==1 || status==2)
            {
                $("#updatebtn").hide();
            }
            else{
                $("#updatebtn").show();
            }
            $("input[name=stars][value=" + rb + "]").prop('checked', true); 
            $('#editreviewModal').modal('show');
           
        }
        else{
            $("#apid").val(pid);
            $("#aoid").val(orderid);
            $('#reviewModal').modal('show');
            //$('#editreviewModal').modal('toggle');
        }  
       }
    });
}

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
//function validate(event) {
//$(".orderReturnForm").validate();
//if (!$(".orderReturnForm").valid()) {
//    return false;
//}
//console.log(" return " +JSON.stringify(event));
//alert(" return " +event.find(".returnProduct").val());
// 
//var getVal = parseInt($('.returnProduct').val());
//var getMin = parseInt($('.returnProduct').attr("min"));
//var getMax = parseInt($('.returnProduct').attr("max"));
//if (getVal >= getMin && getVal <= getMax) {
//    return false
//} else {
//    alert("Value must be less than or equal to " + getMax);
//    return false
//}
//}

function validate(id) {
   $(".orderReturnForm").validate();
   if (!$(".orderReturnForm").valid()) {
       return false;
   }
   //console.log("sdf");
   var getVal = parseInt($('#'+id).val());
   var getMin = parseInt($('#'+id).attr("min"));
   var getMax = parseInt($('#'+id).attr("max"));
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
          var price= thisQty.attr("prod-price");
          var id= thisQty.attr("id");
         
           var varintQty=$('.exchPrdSelect :selected').attr("stock-data");
          if(thisQty.val() > varintQty ){
            alert("Specify Quantity not available!")  
            thisQty.val(varintQty);
          }else{
           $(".prod_price_"+id).text(((thisQty.val()* price) * <?php echo Session::get('currency_val'); ?>).toFixed(2));
          $(".prod_amount_"+id).val((thisQty.val()* price));  
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

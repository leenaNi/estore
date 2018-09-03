@extends('Frontend.layouts.default')
@section('content')
<style type="text/css">
    @media print
    {
        body * { visibility: hidden; }
        #printcontent * { visibility: visible; }
        #printcontent { position: absolute; top: 40px; left: 30px; }
    }
</style>
<div class="clearfix"></div>
<!-- Content
            ============================================= -->
<section id="content">
    <div class="content-wrap">
        <div class="container clearfix" id="printcontent">
            <div class="col_full_fourth nobottommargin">
                <div class="ordersuccess-block center">
                    <h2>Your order has been placed successfully.</h2> <span class="divcenter">You will soon receive an e-mail confirming your transaction.</span>
                    <br>
                    <h4>ORDER ID: {{$order->id}}</h4> </div>
                <div class="table-responsive nobottommargin">
                    <table class="table table-bordered cart">
                        <thead>
                            <tr>
                                <th class="cart-product-thumbnail">Product</th>
                                <th class="cart-product-detail">Detail</th>
                                <th class="cart-product-price">Price</th>
                                <th class="cart-product-quantity">Qty</th>
                                @if($feature['tax']==1)
                                <th class="cart-product-quantity">Tax</th>
                                @endif
                                <th class="cart-product-subtotal">Total</th>
                            </tr>
                        </thead>
                        <tbody class="noTopBorder">
                            <?php
                            $cartData = json_decode($order->cart, true);
                            $gettotal = 0;
                            ?>
                            @foreach($cartData as $cart)
                            <?php $option = ''; ?>

                            <tr class="cart_item">
                                <td class="cart-product-thumbnail">
                                    @if($cart['options']['image']!='')
                                    <a href="#"><img width="64" height="64" src="{{ $cart['options']['image_with_path'].'/'.$cart['options']['image'] )}}" alt="">
                                    </a>
                                    @else 
                                    <img width="64" height="64" src="{{ $cart['options']['image_with_path']}}/default-image.jpg" alt="">
                                    @endif
                                </td>
                                <td class="cart-product-name"> {{$cart['name']}}
                                    <br>
                                    <small><a href="#"> <?php
                                            if (!empty($cart['options']['options'])) {
                                                foreach ($cart['options']['options'] as $key => $value) {
                                                    $option .= ' '.App\Models\AttributeValue::find($value)->option_name;
                                                }
                                            }
                                            echo $option;
                                            ?></a></small></td>
                                <td class="cart-product-price">
                                    <span class="amount">
                                        <span class="currency-sym"></span> 
                                        {{number_format($cart['price']* Session::get('currency_val'), 2, '.', '')}}
                                    </span> </td>
                                <td class="cart-product-quantity">
                                    <div class=""> {{$cart['qty']}}</div>
                                </td>
                                @if($feature['tax']==1)
                                <td class="cart-product-quantity">
                                    <div class=""> <span class="currency-sym"></span> {{$cart['options']['tax_amt']}}</div>
                                  <?php 
                                        $subTotal = ($cart['options']['tax_type']== 2 ) ? $cart['subtotal'] + $cart['options']['tax_amt'] : $cart['subtotal']; 
                                        $gettotal += $subTotal; ?> 
                                </td>
                                @else
                                <?php 
                                 $subTotal =  $cart['subtotal']; 
                                 $gettotal += $subTotal; ?> 
                                  @endif
                   
                                <td class="cart-product-subtotal">
                                    <span class="amount">
                                      <span class="currency-sym"></span> {{number_format(($subTotal)* Session::get('currency_val'), 2, '.', '')}}
                                    </span>
                                </td>
                            </tr>                 
                            @endforeach
                        </tbody>
                        <tr>
                            <td colspan="4" class="text-right"><b>Subtotal</b></td>
                            <td colspan="2" class="text-right"><span class="currency-sym"></span> {{number_format( $gettotal * Session::get('currency_val'), 2, '.', '')}}
                            </td>
                        </tr>
                        @if($order->cod_charges)
                        <tr>
                            <td colspan="4" class="text-right"><b>COD Charges </b></td>
                            <td colspan="2" class="text-right"><span class="currency-sym"></span> {{ number_format(($order->cod_charges * Session::get('currency_val') ), 2, '.', '') }}
                            </td>
                        </tr>
                        @endif
                        @if($feature['additional-charge'] == 1)
                        <?php
                        $addcharge = json_decode($order->additional_charge);
                        ?>
                        @foreach($addcharge->details as $addC)
                        <tr>
                            <td colspan="4" class="text-right"><b> {{ucfirst($addC->label) }}</b></td>
                            <td colspan="2" class="text-right"><span class="currency-sym"></span>{{ number_format(($addC->applied *Session::get('currency_val') ), 2, '.', '') }}</td>
                        </tr>
                        @endforeach
                        @endif
                        <tr>
                            <td colspan="4" class="text-right"><b>Total</b></td>
                            <td colspan="2"class="text-right"><span class="currency-sym"></span> {{number_format( $order->pay_amt* Session::get('currency_val'), 2, '.', '')}}</td>
                        </tr>
                    </table>
                    <!--              <div class="col-md-12 col-sm-12 col-xs-12 text-center"> 
                                  <a href="#" class="button button-black" onclick="window.print()">Print</a> 
                                  <a href="{{route('myProfile')}}" class="button button-default">My Account</a>
                                  </div>-->
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12 text-center"> 
            <a href="#" class="button button-black" onclick="window.print()">Print</a> 
            <a href="{{route('myProfile')}}" class="button button-default">My Account</a>
        </div>  
    </div>
</section>
@stop
<!--<a href="{{ route('home') }}">Home</a>
<div class="container">
    <h2 style="text-align: center;">Thank You. Order has been placed successfully.</h2>
</div>
{{ Cart::instance("shopping")->destroy() }}-->
<!--{{Session::forget('orderId')}}
{{Session::forget('couponUsedAmt')}}
{{Session::forget('usedCouponId')}}
{{Session::forget('usedCouponCode')}}
{{Session::forget('ReferalId')}}
{{Session::forget('ReferalCode')}}
{{Session::forget('referalCodeAmt')}}
{{Session::forget('userReferalPoints')}}
{{ Session::forget('couponDiscount')}}
{{Session::forget('codCharges')}}-->







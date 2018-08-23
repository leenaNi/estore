<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Untitled Document</title>
    </head>
    <body>
        <table width="900" border="0" align="center" cellpadding="10" cellspacing="0" style="font-family:Source Sans Pro Light, Geneva, sans-serif;">
            <tr>
                <td height="55" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="26%"><a href="{{ route('home') }}">
                                    <img src="{{ asset(Config('constants.publicFrontendPathImg').'elogo.png',null,array('width'=>"236","height"=>"234")) }}"></img>

                                         </td>
                                         <td width="74%" align="left" valign="bottom"><table width="100%" border="0" cellspacing="0" cellpadding="3">
                                            <tr>
                                                <td align="right" style="font-family:Source Sans Pro, Geneva, sans-serif; color:#58595B;"><h3 style="margin:0; color:#D22333; padding:0;" >www.cartini.cruxservers.in</h3></td>
                                            </tr>
                                            <tr>
                                                <td align="right">Follow Us</td>
                                            </tr>
                                            <tr>
        
                                            </tr>
                                        </table></td>
                                        </tr>
                                        </table></td>
                                        </tr>
                                        <tr>
                                            <td align="left" valign="top" style="color:#58595B;">
                                                <p style="font-family:Source Sans Pro, Geneva, sans-serif; margin:0; padding:0;">Hi  {{ ucfirst($order->users['firstname']) }},</p>

                                            </td>
                                        </tr>

                                        <tr>
                                            <td align="left" valign="top" style="color:#58595B;">
                                                <strong style="font-family:Source Sans Pro, Geneva, sans-serif;">ORDER ID:</span></strong> {{ @$myt."".$order->id }} <br/>
                                                <strong style="font-family:Source Sans Pro, Geneva, sans-serif;"> DATE:</strong> {{ date('d-M-Y',strtotime($order->created_at)) }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td align="left" valign="top" style="color:#58595B; text-align:justify; font-family:Source Sans Pro Light, Geneva, sans-serif;">
                                                This is to inform you that your order has been dispatched from our warehouse. Below is a table with the summary of your order. <br/>

                                                <!-- We are pleased to inform you that the following item/s in your order {{ $order->id }}  with tracking number {{ $order->shiplabel_tracking_id }} have been dispatched.
                            
                                                
                                    To track your order please click on the link below:<br/>
                                    <a href="#">Click here</a>
                                                -->

                                            </td>
                                        </tr>





<!--            <tr>
                <td style="color:#58595B;">
                    <h4 style="font-family:Source Sans Pro, Geneva, sans-serif;">ADDRESS:</h4>

                    @if(!empty($order->first_name))

                    {{ @$order->first_name }}  {{ @$order->last_name }} <br/>
                    {{ @$order->address1 }}  <br/>
                    {{ @$order->address2 }}  <br/>
                    {{ @$order->city }}       {{ @$order->postal_code }}  <br/>

                    {{ @$order->zone_id }}  <br/>

                    {{ @$order->country_id }}  




                    @else

                    {{ @User::find($order->user_id)->firstname }} {{ @User::find($order->user_id)->lastname }} <br/>
                    {{ @User::find($order->user_id)->addresses()->first()->address1 }} <br/>
                    {{ @User::find($order->user_id)->addresses()->first()->address2 }}<br/>
                    {{ @User::find($order->user_id)->addresses()->first()->city }}       {{ @User::find($order->user_id)->addresses()->first()->postcode }} <br>
                        {{ @Zone::find(User::find($order->user_id)->addresses()->first()->zone_id)->name}}  <br/>
                        {{ @Country::find(User::find($order->user_id)->addresses()->first()->country_id)->name}}.

                        @endif
                </td>
            </tr>-->




                                        @if(!empty($order->shiplabel_tracking_id) && strlen($order->shiplabel_tracking_id) >=10)
                                        <tr>
                                            <td style="color:#58595B;">
                                                <h5> 

                                                    @if($order->courier == 1)
                                                    Courier Service Provider: Fedex (www.fedex.com)<br/>
                                                    @elseif($order->courier == 2)
                                                    Courier Service Provider: Delhivery (www.delhivery.com)<br/>
                                                    @elseif($order->courier == 3)
                                                    Courier Service Provider: $order->courier_service_name<br/>
                                                    @endif

                                                    Tracking Number:  {{ @$order->shiplabel_tracking_id }}
                                                </h5>

                                            </td>
                                        </tr>

<!--            <tr>
    <td style="color:#58595B;">
        You can track your shipment at any time by going to <a href="http://www.fedex.com" target="_blank">www.fedex.com</a> and using your tracking number.

    </td>
</tr>-->
                                        @endif


                                        <tr>
                                            <td>
                                                <table border="0" cellspacing="0" cellpadding="12" style="border:1px dashed #ccc; border-radius:10px; width:100%; font-family:Source Sans Pro Light, Geneva, sans-serif;">
                                                    <tr>
                                                        <td width="30%" style="color:#58595B; border-bottom:1px dashed #ccc; border-right:1px dashed #ccc; font-family:Source Sans Pro Light, Geneva, sans-serif;"><h4 style="padding:0; margin:0; font-family:Source Sans Pro, Geneva, sans-serif;">PRODUCT</h4></td>

                                                        <td width="19%" style="color:#58595B; border-bottom:1px dashed #ccc; border-right:1px dashed #ccc; font-family:Source Sans Pro Light, Geneva, sans-serif;"><h4 style="padding:0; margin:0; font-family:Source Sans Pro, Geneva, sans-serif;">PRODUCT TYPE</h4></td>

                                                        <td align="right" style="color:#58595B; border-bottom:1px dashed #ccc; border-right:1px dashed #ccc;"><h4 style="padding:0; margin:0; font-family:Source Sans Pro, Geneva, sans-serif;">QTY</h4></td>


                                                        <td align="right" style="color:#58595B; border-bottom:1px dashed #ccc; border-right:1px dashed #ccc;"><h4 style="padding:0; margin:0; font-family:Source Sans Pro, Geneva, sans-serif;">PRICE</h4></td>
                                                        <td align="right" style="color:#58595B; border-bottom:1px dashed #ccc;"><h4 style="padding:0; margin:0; font-family:Source Sans Pro, Geneva, sans-serif;">TOTAL</h4></td>
                                                    </tr>

                                                    <?php
                                                    $prods = json_decode($order->cart, true);
                                                    ?>
                                                    @foreach($prods as $prod)  

                                                    <tr>
                                                        <td valign="top" align="left" style="color:#58595B;border-right:1px dashed #ccc; border-bottom:1px dashed #ccc;">
                                                            <p>
                                                                <p>

                                                                    {{$prod['name'] }} <br/>

                                                                    @if(!empty($prod['options']['options']))

                                                                    @foreach($prod['options']['options'] as $key => $val )
                                                                    <p><span><strong>{{ $key }}:</strong> {{ $val }}</span></p>
                                                                    @endforeach
                                                                    @endif
                                                                    @if(!empty($prod['options']['combos']))
                                                                    @foreach(!empty($prod['options']['combos']) as $key => $val )                                        
                                                                    @if(isset($val['options']))
                                                                    <p><strong><i>{{ $val["name"] }}</i></strong></p>
                                                                    @foreach($val['options'] as $opt => $vl )
                                                                    <p><span><strong>{{ $opt }}:</strong> {{ $vl }}</span></p>
                                                                    @endforeach
                                                                    @endif                                    
                                                                    @endforeach
                                                                    @endif
                                                                </p>
                                                        </td>
                                                        
                                                        <td  valign="top" align="right" style="color:#58595B; border-right:1px dashed #ccc; border-bottom:1px dashed #ccc;">{{ $prod['qty'] }}</td>
                                                        <td  valign="top" align="right" style="color:#58595B; border-right:1px dashed #ccc; border-bottom:1px dashed #ccc;">Rs.{{ number_format($prod['price']) }}</td>
                                                        <td valign="top" align="right" style="color:#58595B;border-bottom:1px dashed #ccc;">Rs.{{  number_format($prod['subtotal']) }}</td>
                                                    </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td colspan="4" align="right" style="color:#58595B; border-right:1px dashed #ccc; border-bottom:1px dashed #ccc;font-family:Source Sans Pro, Geneva, sans-serif;"" ><strong>SUB-TOTAL</strong></td>
                                                        <td align="right" style="color:#58595B; border-bottom:1px dashed #ccc;">Rs.{{ number_format($order->order_amt)  }}</td>
                                                    </tr>
                                                    @if(!empty($order->voucher_used))
                                                    <tr>
                                                        <td colspan="4" align="right"  style="color:#58595B; border-right:1px dashed #ccc; border-bottom:1px dashed #ccc;font-family:Source Sans Pro, Geneva, sans-serif;"><strong>VOUCHER USED({{ isset($order->voucher_used)?$order->voucher['voucher_code']:"" }})</strong></td>
                                                        <td align="right" style="color:#58595B; border-bottom:1px dashed #ccc;">Rs.{{ number_format(isset($order->voucher_amt_used)?$order->voucher_amt_used:0) }}</td>
                                                    </tr>
                                                    @endif
                                                    @if(!empty($order->coupon_amt_used))
                                                    <tr>
                                                        <td colspan="4" align="right"  style="color:#58595B; border-right:1px dashed #ccc; border-bottom:1px dashed #ccc;font-family:Source Sans Pro, Geneva, sans-serif;"><strong>COUPON USED({{ isset($order->coupon_used)?$order->coupon['voucher_code']:"" }})</strong></td>
                                                        <td align="right" style="color:#58595B; border-bottom:1px dashed #ccc;">Rs.{{ number_format(isset($order->coupon_amt_used)?$order->coupon['voucher_val']:0) }}</td>
                                                    </tr>
                                                    @endif
                                                    @if(!empty($order->cashback_used))
                                                    <tr>
                                                        <td colspan="4" align="right"  style="color:#58595B; border-right:1px dashed #ccc; border-bottom:1px dashed #ccc;font-family:Source Sans Pro, Geneva, sans-serif;"><strong>REWARD POINTS USED</strong></td>
                                                        <td align="right" style="color:#58595B; border-bottom:1px dashed #ccc;">Rs.{{ number_format(isset($order->cashback_used)?$order->cashback_used:0) }}</td>
                                                    </tr>
                                                    @endif
                                                    @if(!empty($order->voucher_amt_used))
                                                    <tr>
                                                        <td colspan="4" align="right"  style="color:#58595B; border-right:1px dashed #ccc; border-bottom:1px dashed #ccc;font-family:Source Sans Pro, Geneva, sans-serif;"><strong>VOUCHER  USED({{ isset($order->voucher_used)?$order->voucher['voucher_code']:"" }})</strong></td>
                                                        <td align="right" style="color:#58595B; border-bottom:1px dashed #ccc;">Rs.{{ number_format(isset($order->voucher_amt_used)?$order->voucher_amt_used:0) }}</td>
                                                    </tr>
                                                    @endif
                                                    @if(!empty($order->shipping_amt)) 
                                                    <tr>
                                                        <td colspan="4" align="right"  style="color:#58595B; border-right:1px dashed #ccc; border-bottom:1px dashed #ccc;font-family:Source Sans Pro, Geneva, sans-serif;"><strong>SHIPPING</strong></td>
                                                        <td align="right" style="color:#58595B; border-bottom:1px dashed #ccc;">Rs.{{ number_format(isset($order->shipping_amt)?$order->shipping_amt:0) }}</td>
                                                    </tr>
                                                    @endif
                                                    @if(!empty($order->referal_code_amt))
                                                    <tr>
                                                        <td colspan="4" align="right"  style="color:#58595B; border-right:1px dashed #ccc; border-bottom:1px dashed #ccc;font-family:Source Sans Pro, Geneva, sans-serif;"><strong>Referal Code({{ $order->referal_code }});</strong></td>
                                                        <td align="right" style="color:#58595B; border-bottom:1px dashed #ccc;">Rs.{{number_format(isset($order_details->referal_code_amt)?$order->referal_code_amt:0)}}</td>
                                                    </tr>
                                                    @endif
                                                    @if(!empty($order->cod_charges))
                                                    <tr>
                                                        <td colspan="4" align="right"  style="color:#58595B; border-right:1px dashed #ccc; border-bottom:1px dashed #ccc; font-family:Source Sans Pro, Geneva, sans-serif;"><strong>CASH ON DELIVERY FEE</strong></td>
                                                        <td align="right" style="color:#58595B; border-bottom:1px dashed #ccc;">Rs.{{number_format($order->cod_charges) }}</td>
                                                    </tr>
                                                    @endif
                                                    @if(!empty($order->gifting_charges))
                                                    <tr>
                                                        <td colspan="4" align="right"  style="color:#58595B; border-right:1px dashed #ccc; border-bottom:1px dashed #ccc; font-family:Source Sans Pro, Geneva, sans-serif;"><strong>GIFT WRAPPING CHARGES</strong></td>
                                                        <td align="right" style="color:#58595B; border-bottom:1px dashed #ccc;">Rs.{{number_format($order->gifting_charges) }}</td>
                                                    </tr>
                                                    @endif
                                                    <tr>
                                                        <td colspan="4" align="right"  style="color:#58595B; border-right:1px dashed #ccc; font-family:Source Sans Pro, Geneva, sans-serif;"><strong>TOTAL</strong></td>
                                                        <td align="right" style="color:#58595B; ">Rs.{{ number_format($order->pay_amt) }}</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>   
                                        <tr>
                                            <td style="color:#58595B;">
                                                <h4 style="font-family:Source Sans Pro, Geneva, sans-serif;">DELIVERY TIMES:</h4>
                                                <p>
                                                    Orders within India are delivered within 7 - 8 working days, and International orders are delivered within 10 to 15 working days. Delivery time may vary depending upon the shipping address. Please note that this is the maximum time for delivery.</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="color:#58595B;">
                                                <h4 style="font-family:Source Sans Pro, Geneva, sans-serif;">REWARD POINTS PROGRAM:</h4>
                                                <p>You have earned <strong>{{ isset($order->cashback_earned)?$order->cashback_earned:0 }}</strong> reward points with this purchase. Your reward points will be added to your wallet which can be redeemed on your future purchases. You can check your current reward points by logging into your account.</p>

                                                <p>You can also earn Reward Points by spreading the word and sharing your referral code with your friends/ family. You can find your personal referral code by logging into your account. The more your referral code is used, the more you earn.</p>

                                                <p> To know more about our Reward Points Program, <a href="#" >click here</a>.</p>

                                                <p><small>*You can only be eligible to earn Rewards Points if you are registered with <a href="{{ route('home') }}" target="_blank">cartini.com</a></small></p>
                                                <p>We are always striving to improve our services and make the whole experience of shopping with us even better. Any feedback from you would be extremely valuable to us and help us grow. Please feel free to drop us an email, call us, or get in touch with us on our various social media channels.</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="color:#58595B;">Have a soulful day.<br/>
                                                Cartini Team</td>
                                        </tr>
                            <!--            <tr>
                                            <td style="color:#58595B;">PS: If the size you have ordered does not fit you, then go to your account and initiate an exchange for a new size. </td>
                                        </tr>-->
                                        <tr>
                                            <td><div style="border-bottom:1px #ccc solid;"></div></td>
                                        </tr>
                                        
                                        <tr>
                                            <td align="right">
                                                C - 504, Infini Systems, Neelkanth Business Park,<br/>
                                                Vidyavihar (West), Mumbai - 400086 <br/>
                                                Email: connect@cartini.com      Phone: 022-1223456
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                        </tr>
                                        </table>
                                        </body>
                                        </html>



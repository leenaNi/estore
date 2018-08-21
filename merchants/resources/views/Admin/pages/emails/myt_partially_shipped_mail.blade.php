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
                                    {{ HTML::image(Config('constants.publicFrontendPathImg').'elogo.png',null,array('width'=>"236","height"=>"234")) }}</a>

                            </td>
                            <td width="74%" align="left" valign="bottom"><table width="100%" border="0" cellspacing="0" cellpadding="3">
                                    <tr>
                                        <td align="right" style="font-family:Source Sans Pro, Geneva, sans-serif; color:#58595B;"><h3 style="margin:0; color:#D22333; padding:0;" >www.thesouledstore.com</h3></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Follow Us</td>
                                    </tr>
                                    <tr>
                                        <td align="right">

                                            <a href="http://instagram.com/TheSouledStore/" style="display:block; float:right; margin-left:5px;">
                                                {{ HTML::image(Config('constants.publicFrontendPathImg').'instragram.png',null,array('width'=>'31','height'=>'30','alt'=>'','border'=>'0')) }}      
                                            </a>

                                            <a href="https://www.pinterest.com/thesouledstore/" style="display:block; float:right; margin-left:5px;">
                                                {{HTML::image(Config('constants.publicFrontendPathImg').'pinterest.png',null,array('width'=>'31','height'=>'30','alt'=>'','border'=>'0')) }}
                                            </a>
                                            <a href="https://twitter.com/TheSouledStore" style="display:block; float:right; margin-left:5px;">
                                                {{ HTML::image(Config('constants.publicFrontendPathImg').'twitter.png',null,array('width'=>'31','height'=>'30','border'=>'0','alt'=>'')) }}
                                            </a>

                                            <a href="https://www.facebook.com/SouledStore" style="display:block; float:right; margin-left:5px;">
                                                {{ HTML::image(Config('constants.publicFrontendPathImg').'facebook.png',null,array('alt'=>'logo','height'=>'30','width'=>'31','border'=>'0','alt'=>'')) }}

                                            </a>

                                        </td>
                                    </tr>
                                </table></td>
                        </tr>
                    </table></td>
            </tr>
            <tr>
                <td align="left" valign="top" style="color:#58595B;">
                    <p style="font-family:Source Sans Pro, Geneva, sans-serif; margin:0; padding:0;">Hi  {{ ucfirst($orderUser->users['firstname']) }},</p>

                </td>
            </tr>
            <tr>
                <td align="left" valign="top" style="color:#58595B;">
                    <strong style="font-family:Source Sans Pro, Geneva, sans-serif;">ORDER ID:</span></strong> {{ "MYT".$orderUser->id }} <br/>
                </td>
            </tr>
            <tr>
                <td align="left" valign="top" style="color:#58595B; text-align:justify; font-family:Source Sans Pro Light, Geneva, sans-serif;">
                    This is to inform you that your order has partially been dispatched from our warehouse. You will be notified when the remaining items in your order are shipped. Crowdfunded products will be shipped out on the date mentioned.
                </td>
            </tr>

            <tr>
                <td>
                    <table border="0" cellspacing="0" cellpadding="12" style="border:1px dashed #ccc; border-radius:10px; width:100%; font-family:Source Sans Pro Light, Geneva, sans-serif;">
                        <tr>
                            <td width="49%" style="color:#58595B; border-bottom:1px dashed #ccc; border-right:1px dashed #ccc; font-family:Source Sans Pro Light, Geneva, sans-serif;"><h4 style="padding:0; margin:0; font-family:Source Sans Pro, Geneva, sans-serif;">PRODUCT</h4></td>
                            <td align="right" style="color:#58595B; border-bottom:1px dashed #ccc; border-right:1px dashed #ccc;"><h4 style="padding:0; margin:0; font-family:Source Sans Pro, Geneva, sans-serif;">PRICE</h4></td>
                            <td align="right" style="color:#58595B; border-bottom:1px dashed #ccc;"><h4 style="padding:0; margin:0; font-family:Source Sans Pro, Geneva, sans-serif;">TOTAL</h4></td>
                        </tr>

                        <?php
                        $prods = json_decode($order->order_details, true);
                        ?>
                        @foreach($prods as $prod)  
                        @if($prd['value'] != 0)

                        <tr>
                            <td valign="top" align="left" style="color:#58595B;border-right:1px dashed #ccc; border-bottom:1px dashed #ccc;">
                                <p>
                                    {{"T-Shirt : ".substr($prod['name'],3)}}
                                    <!--  <ul>
                                          <li>Frame Size: 6*8</li>
                                          <li>Frame Color: Black</li>
                                      </ul> -->
                                </p>

                            </td>
                            <td  valign="top" align="right" style="color:#58595B; border-right:1px dashed #ccc; border-bottom:1px dashed #ccc;">Rs.{{ number_format($prod['value']) }}</td>
                            <td valign="top" align="right" style="color:#58595B;border-bottom:1px dashed #ccc;">Rs.{{  number_format($prod['value'] * $order->prod_price) }}</td>
                        </tr>

                        @endif
                        @endforeach
                        <tr>
                            <td colspan="2" align="right" style="color:#58595B; border-right:1px dashed #ccc; border-bottom:1px dashed #ccc;font-family:Source Sans Pro, Geneva, sans-serif;"" ><strong>SUB-TOTAL</strong></td>
                            <td align="right" style="color:#58595B; border-bottom:1px dashed #ccc;">Rs.{{ number_format($order->order_amount)  }}</td>
                        </tr>
                        <tr>
                            <td colspan="2" align="right"  style="color:#58595B; border-right:1px dashed #ccc; border-bottom:1px dashed #ccc; font-family:Source Sans Pro, Geneva, sans-serif;"><strong>DISCOUNT</strong></td>
                            <td align="right" style="color:#58595B; border-bottom:1px dashed #ccc;">Rs.{{number_format($order->final_amount - $order->order_amount)  }}</td>
                        </tr>











                        <tr>
                            <td colspan="2" align="right"  style="color:#58595B; border-right:1px dashed #ccc; font-family:Source Sans Pro, Geneva, sans-serif;"><strong>TOTAL</strong></td>
                            <td align="right" style="color:#58595B; ">Rs.{{ number_format($order->final_amount) }}</td>
                        </tr>
                    </table>

                </td>
            </tr>



            <tr>
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
            </tr>
            <tr>
                <td style="color:#58595B;">
                    <h5> 
                        Courier Service Provider: FedEx<br/>
                        Tracking Number:  {{ $order->myt_shiplabel_tracking_id }}
                    </h5>

                </td>
            </tr>
            <tr>
                <td style="color:#58595B;">
                    You can track your shipment at any time by going to <a href="http://www.fedex.com" target="_blank">www.fedex.com</a> and using your tracking number.
                </td>
            </tr>
            <tr>
                <td style="color:#58595B;">
                    <h4 style="font-family:Source Sans Pro, Geneva, sans-serif;">DELIVERY TIMES:</h4>
                    Tier 1 Cities like Mumbai, Delhi, Bangalore etc: 3-5 days. <br/>
                    Tier 2 Cities like Aurangabad, Gurgaon etc: 6-8 days.<br/>
                    Tier 3 Cities like Vellore, Manipal etc: 7-10 days.<br/>
                    Cities in East India: 10-12 days. <br/>
                    Please note that this is the maximum time for delivery.
                </td>
            </tr>
            <tr>
                <td style="color:#58595B;">
                    <h4 style="font-family:Source Sans Pro, Geneva, sans-serif;">Reward Points Program:</h4>
                    <p>You have earned <strong>{{ isset($orderUser->cashback_earned)?$orderUser->cashback_earned:0 }}</strong> reward points with this purchase. Your reward points will be added to your wallet which can be redeemed on your future purchases. You can check your current reward points by logging into your account.</p>
                    <p>You can also earn Reward Points by spreading the word and sharing your referral code with your friends/ family. You can find your personal referral code by logging into your account. The more your referral code is used, the more you earn.</p>
                    <p> To know more about our Reward Points Program,  <a href="{{ route('loyalty_reward') }}" >click here</a>.</p>
                    <p><small>*You can only be eligible to earn Rewards Points if you are registered with <a href="{{ route('home') }}" target="_blank">thesouledstore.com</a></small></p>
                    <p>We’re always open to feedback. So don’t feel shy and shoot some our way. You can email/ call us or get in touch with us on our various social media channels.</p>

                </td>
            </tr>

            <tr>
                <td style="color:#58595B;">Have a soulful day.<br/>
                     Cartini Team</td>
            </tr>
            <tr>
                <td style="color:#58595B;">PS: If the size you have ordered does not fit you, then go to your account and initiate an exchange for a new size. </td>
            </tr>
            <tr>
                <td><div style="border-bottom:1px #ccc solid;"></div></td>
            </tr>
            <tr>
                <td align="right">
                    <div style="float:right; font-family:Source Sans Pro, Geneva, sans-serif;">
                        {{ HTML::image(Config('constants.publicFrontendPathImg').'dot.jpg',null,array('width'=>'31','align'=>'absmiddle','alt'=>''));}}

                        <a href="{{ route('exchange_policy') }}" style="color:#58595B; text-decoration:none;"><strong>RETURN POLICY</strong></a></div>

                    <div style="float:right; font-family:Source Sans Pro, Geneva, sans-serif;">

                        {{ HTML::image(Config('constants.publicFrontendPathImg').'dot.jpg',null,array('width'=>'31','align'=>'absmiddle','alt'=>''));}}


                        <a href="{{ route('terms_of_service') }}" style="color:#58595B; text-decoration:none;"><strong>TERMS & CONDITIONS</strong></a></div>

                    <div style="float:right; color:#58595B; font-family:Source Sans Pro, Geneva, sans-serif;">

                        {{ HTML::image(Config('constants.publicFrontendPathImg').'dot.jpg',null,array('width'=>'31','align'=>'absmiddle','alt'=>''));}}


                        <a href="{{ route('careers') }}" style="color:#58595B; text-decoration:none;"><strong>CAREERS</strong></a></div>

                    <div style="float:right; font-family:Source Sans Pro, Geneva, sans-serif;">
                        {{ HTML::image(Config('constants.publicFrontendPathImg').'dot.jpg',null,array('width'=>'31','align'=>'absmiddle','alt'=>''));}}

                        <a href="{{ route('about_us') }}" style="color:#58595B; text-decoration:none;"><strong>ABOUT US</strong></a></div>


                </td>
            </tr>
            <tr>
                <td align="right">
                    {{  HTML::image(Config('constants.publicFrontendPathImg').'paymenimage.png',null,array('height'=>'18','width'=>'217')); }}
                </td>
            </tr>
            <tr>
                <td align="right">To receive our newsletter <a href="{{ route('home') }}#footSubscribe">click here.</a></td>
            </tr>
            <tr>
                <td align="right">
                    Cartini - 224, Tantia Jogani Industrial Premises, J. R. Boricha Marg,<br/>
                    Lower Parel (East), Mumbai - 400011 <br/>
                    Email: connect@thesouledstore.com      Phone:+91 8767221221
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
        </table>
    </body>
</html>


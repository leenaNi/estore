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
                                    {{ Html::image(Config('constants.publicFrontendPathImg').'elogo.png',null,array('width'=>"236","height"=>"234")) }}</a>

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
                                                {{ Html::image(Config('constants.publicFrontendPathImg').'instragram.png',null,array('width'=>'31','height'=>'30','alt'=>'','border'=>'0')) }}      
                                            </a>

                                            <a href="https://www.pinterest.com/thesouledstore/" style="display:block; float:right; margin-left:5px;">
                                                {{Html::image(Config('constants.publicFrontendPathImg').'pinterest.png',null,array('width'=>'31','height'=>'30','alt'=>'','border'=>'0')) }}
                                            </a>
                                            <a href="https://twitter.com/TheSouledStore" style="display:block; float:right; margin-left:5px;">
                                                {{ Html::image(Config('constants.publicFrontendPathImg').'twitter.png',null,array('width'=>'31','height'=>'30','border'=>'0','alt'=>'')) }}
                                            </a>

                                            <a href="https://www.facebook.com/SouledStore" style="display:block; float:right; margin-left:5px;">
                                                {{ Html::image(Config('constants.publicFrontendPathImg').'facebook.png',null,array('alt'=>'logo','height'=>'30','width'=>'31','border'=>'0','alt'=>'')) }}

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
                    <strong style="font-family:Source Sans Pro, Geneva, sans-serif;">ORDER ID:</span></strong> {{ @$myt."".$orderUser->id }} <br/>
                    <strong style="font-family:Source Sans Pro, Geneva, sans-serif;">ORDER DATE:</span></strong> {{ date("d-M-Y",strtotime($orderUser->created_at)) }} <br/>

                </td>
            </tr>
            <tr>
                <td align="left" valign="top" style="color:#58595B; text-align:justify; font-family:Source Sans Pro Light, Geneva, sans-serif;">
                    This email is to inform you that we are facing a slight delay in shipping out your complete order due to a slight operational glitch at our end. Your order has been partially shipped and we will be shipping theremaining order out in 2-3 days. You will be notified once your complete order has been shipped.            </tr>

            <tr>

                <tr>
                    <td align="left" valign="top" style="color:#58595B; text-align:justify; font-family:Source Sans Pro Light, Geneva, sans-serif;">
                        We are always striving to improve our services and make the whole experience of shopping with us even better. Any feedback from you would be extremely valuable to us and help us grow. Please feel free to drop us an email, call us, or get in touch with us on our various social media channels.            
                </tr>
             

                <tr>
                    <td style="color:#58595B;">Have a soulful day.<br/>
                         Cartini Team</td>
                </tr>
    
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


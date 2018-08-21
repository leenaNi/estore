<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Delivered order</title>
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
                                        <td align="right" style="font-family:Source Sans Pro, Geneva, sans-serif; color:#58595B;"><h3 style="margin:0; color:#D22333; padding:0;" >www.cartini.com</h3></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Follow Us</td>
                                    </tr>
                                    <tr>
                                        <td align="right">

              
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
                This is to confirm that your order has been delivered. We hope you had a wonderful shopping experience and we hope to see you in the future. If we managed to put a smile across your face, it would be great if you could spread the word and tell your friends and family about us.
                </td>
            </tr>
            
                        <tr>
                <td align="left" valign="top" style="color:#58595B; text-align:justify; font-family:Source Sans Pro Light, Geneva, sans-serif;">
We are always striving to improve our services and make the whole experience of shopping with us even better. Any feedback from you would be extremely valuable to us and help us grow. Please feel free to drop us an email, call us, or get in touch with us on our various social media channels.                </td>
            </tr>
            





            <tr>
                <td style="color:#58595B;">Have a soulful day.<br/>
                    cartini Team</td>
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


<!-- Footer
                ============================================= -->
<footer id="footer" class="dark">
    <div class="container-fluid footer-cust-color p0">
        <div class="container">

            <!-- Footer Widgets
            ============================================= -->
            <div class="footer-widgets-wrap clearfix text-center">
                <!-- <div class="footer-androidappbox text-center bottommargin-sm">
                    <a href="{{ asset(Config('constants.frontendPublicImgPath').'/veestores-merchant-app.apk') }}" target="_blank"><img src="{{ asset(Config('constants.frontendPublicImgPath').'/androidapp.png') }}" alt="Image"></a>
                </div> -->
              <!--   <div class="copyright-social bottommargin-xs">
                    <a href="https://www.facebook.com/VeestoresGlobal/" target="_blank" class="social-icon-footer" style="color: #fff;">
                        <i class="icon-facebook"></i>
                    </a>

                    <a href="https://twitter.com" target="_blank" class="social-icon-footer" style="color: #fff;">
                        <i class="icon-twitter"></i>
                    </a>

                    <a href="https://plus.google.com" target="_blank" class="social-icon-footer" style="color: #fff;">
                        <i class="icon-gplus"></i>
                    </a>


                </div> -->


                <div class="copyright-links">
                <!-- <a href="/about">About</a> /  -->
                <!-- <a href="/logistic-partners">Logistic Partner</a> /  -->
                    <!-- <a href="/faqs">FAQs</a> / 
                    <a href="#">Store set-up assistance</a> / <a href="#">Merchant Agreement</a> /  -->
                    <a href="/terms-condition">Terms &amp; Condition</a> / <a href="/privacy-policy">Privacy Policy</a> / <a href="/contact">Contact</a></div>
            </div><!-- .footer-widgets-wrap end -->

        </div>

    </div>

    <div id="copyrights">

        <div class="container center clearfix">

            <div style="color: #aaa;"> Copyright @ <?php echo date("Y"); ?>. eStorifi. All Rights Reserved.</div>

        </div>

    </div>

</footer><!-- #footer end -->
<div class="modal fade loginpop" id="loginPOPUP" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-sm">
        <div class="modal-body">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Login</h4>

                </div>
                <div class="modal-body">
                    <div class="logErr nobg"></div>
                     <div class="errorMessage alert-danger bottommargin-xs"></div>
                    <form id="veestoreLoginForm" class="veeLoginF" method="post" >
                        <div class="input-group" id="top-login-username">
                            <span class="input-group-addon"><i class="icon-phone"></i></span>
                            <input type="text" name="mobile_email" class="form-control" placeholder="Mobile / Email" required="true">
                        </div>
                        <div class="clearfix bottommargin-xs"></div>
                        <div class="input-group" id="top-login-password">
                            <span class="input-group-addon"><i class="icon-key"></i></span>
                            <input type="password" class="form-control" name="password" placeholder="Password" required="true">
                        </div>
                        <!--                        <div class="text-center bottommargin-xs">
                                                    <a href="javascript:void(0);"   class="forgotPassLink">Forgot Password?</a>
                                                </div>-->
                        <div class="clearfix bottommargin-xs"></div>
                        <button class="btn theme-btn btn-block veestoreLoginBtn" type="button">Login</button>
                    </form>
                    <div class="text-center marginBottom20">
                        <!--               <a href="{{ route('login',['provider'=>'facebook']) }}"  class="col-md-12 col-sm-6 col-xs-12" style="margin-bottom:11px;">-->
                        <a class="btn btn-block btn-social btn-facebook" onclick="fbLog()" id="fbLink" class="fb_login_btn">
                            <span class="icon-facebook"></span> Login with Facebook</a>
                    </div>


                </div>

            </div>
        </div>
    </div>




</div>

<div class="modal fade forgotPasspop" id="forgotPasspop" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-body">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title " >Forgot Password?</h4>
                </div>
                <div class="modal-body">


                    <form method="post" action="{{ route('merchantForgotPassword') }}" id='merchantForgotPassForm' >
                        <div class="input-group bottommargin-xs full-width">
                            <input name="phone_email" type="text" class="form-control" placeholder="Enter registered Mobile/Email" required="true">
                        </div>
                        <div class="text-center bottommargin-xs">
                            <input  class="btn theme-btn btn-block" type="submit" value="Send">
                        </div>
                    </form>
                    <!--                        <hr/>
                                            <div class="input-group bottommargin-xs full-width">
                                                <input type="text" class="form-control" placeholder="Enter OTP" required="">
                                            </div>
                                            <div class="text-center bottommargin-xs">
                                                <a href="#">Resend OTP</a>
                                            </div>
                                            <button class="btn theme-btn btn-block" type="submit">Submit</button>-->

                </div>
            </div>
        </div>
    </div>
</div>


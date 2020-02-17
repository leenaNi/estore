<!DOCTYPE html>
<html>
    <head>
        @include('Admin.includes.head')

    </head>
    <body class="hold-transition login-page loginBG">
        <div class="login-box">
            <div class="login-box-body">
                <div class="col-md-12 col-lg-12">
                    <h3>Powered By <br>            
                    <span class="logo-holder">       
                        <img src="{{ Config('constants.adminImgPath').'/login-logo.svg' }}" alt="eStorifi logo"></h3>
                    </span>
                </div>
                <!-- <p style="color: red;text-align: center;" class="errorMessage">{{ Session::get('invalidUser') }}</p> -->
                <!-- <p class="login-box-msg">Sign in to start your session</p> -->
                <div class="clearfix"></div>
                <form action="{{ route('check_admin_user') }}" method="post" id="adminLogin">
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" name="phone" placeholder="Mobile" id="phone">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span><p id="phone_re_validate"></p>
                    </div>
                    <div class="form-group has-feedback" style="display:none" id="otpdiv">
                        <input type="number" class="form-control" name="otp" placeholder="Enter OTP" required="true">
                        <span class="glyphicon glyphicon-lock form-control-feedback" id="otperr"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 text-center marginBottom-lg">
                            <button type="button" class="btn btn-primary fullWidthBtn" id="sendotp">Send OTP</button>
                            <button type="button" class="btn btn-primary bottommargin-xs fullWidthBtn" style="display:none" id="loginbtn">Sign In</button>
                        </div><!-- /.col -->
                    </div>
                </form>
                <!-- <div class="col-md-12 orDivider-box">
                    <div class="orDivider">
                        OR
                    </div>
                  
                </div>
         <div class="col-md-12 fbBTN" >
             <div class="fbBtnfull">
            <img src="{{ Config('constants.frontendPublicImgPath').'/fb_login.jpg'}}" onclick="fbLogin()" id="fbLink" class="fb_login_btn"></div>
        </div> -->
         <div class="col_full nobottommargin for-pass text-center topmargin-sm"> <a href="{{ Route('adminForgotPassword') }}" class="">Forgot Password?</a> </div>
                <!--        <div class="social-auth-links text-center">
                          <p>- OR -</p>
                          <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a>
                          <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a>
                        </div> /.social-auth-links -->


            </div><!-- /.login-box-body -->
        </div><!-- /.login-box -->

        <!-- jQuery 2.1.4 -->
        <script src="{{  Config('constants.adminPlugins').'/jQuery/jQuery-2.1.4.min.js' }}"></script>
        <!-- Bootstrap 3.3.5 -->
        <script src="{{  Config('constants.adminBootstrapJsPath').'/bootstrap.min.js' }}"></script>
        <!-- iCheck -->
        <script src="{{  Config('constants.adminPlugins').'/iCheck/icheck.min.js' }}"></script>
        <script src="{{  Config('constants.adminDistJsPath').'/jquery.validate.min.js' }}"></script>

        <script>

$("#sendotp").click(function(){
    var phone = $("#phone").val();
    console.log(phone);
    $.ajax({
            type: 'POST',
            url: "{{route('checkExistingphone')}}",
            data: {phone_no: phone},
            success: function (response) {
                console.log('@@@@' + response);
                if (response['status'] == 'success') {
                    $("#otpdiv").show();    
                    $("#loginbtn").show();    
                    $("#sendotp").hide(); 
                    $("#phone").hide();
                    $("#phone_re_validate").html(''); 
                } else if (response['status'] == 'fail') {
                    $("#phone_re_validate").css("color", "red").html('Mobile number is not registered')
                }
            },
            error: function (e) {
                console.log(e.responseText);
            }
        });
});

$("#loginbtn").click(function(){
    var otp = $("input[name=otp]").val();
    console.log(otp);
    $.ajax({
            type: 'POST',
            url: "{{route('checkOtp')}}",
            data: {otp: otp},
            success: function (response) {
                if (response == '1') {
                    $("#adminLogin").submit();
                } else if (response == '2') {
                    $("#otperr").html('Incorrect OTP'); 
                }
            },
            error: function (e) {
                console.log(e.responseText);
            }
        });
});
        </script>
  <script>
window.fbAsyncInit = function() {
    // FB JavaScript SDK configuration and setup
    FB.init({
      appId      : '644176742612237', // FB App ID
      cookie     : true,  // enable cookies to allow the server to access the session
      xfbml      : true,  // parse social plugins on this page
      version    : 'v3.0' // use graph api version 2.8
    });

};
function fbLogout() {
    FB.logout(function() {
    });
}
// Load the JavaScript SDK asynchronously
(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

// Facebook login with JavaScript SDK
function fbLogin() {
    FB.login(function (response) {
        if (response.authResponse) {
            // Get and display the user profile data
            getFbUserData();
        } else {
            document.getElementById('status').innerHTML = 'User cancelled login or did not fully authorize.';
        }
    }, {scope: 'email'});
}

function getFbUserData(){
    FB.api('/me', {locale: 'en_US', fields: 'id,first_name,last_name,email'},
    function (response) {
       //if()
        console.log("out side");
        if(response){
            console.log(JSON.stringify(response));
         $('.errorMessage').empty();
        $.ajax({
            type: "POST",
            timeout: 10000,
            url: "{{route('check_fb_admin_user')}}",
            data: {userData: response},
            cache: false,
            success: function (resp) {
                 console.log("response"+JSON.stringify(resp));
                 
                 if(resp.status==1){
                        fbLogout();
                      window.location=resp.route;
                 }else if(resp.status==0){
                    $('.errorMessage').append(resp.msg);
                   fbLogout();
            }

            }
        });
        }
   });
}

</script>
    </body>
</html>

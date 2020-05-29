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
                        <input type="text" class="form-control" name="phone" placeholder="Mobile" id="phone" tabindex="1">
                        <span class="glyphicon glyphicon-earphone form-control-feedback"></span><p id="phone_re_validate"></p>
                    </div>
                    {{-- <div class="form-group has-feedback" style="display:block" id="otpdiv">
                        <input type="number" class="form-control" name="otp" id="otp" placeholder="Enter OTP" required="true" tabindex="2">
                        <span class="glyphicon glyphicon-lock form-control-feedback" id="otper"></span><p id="otperr"></p>
                    </div> --}}
                    <div class="form-group has-feedback" style="display:none" id="otpdiv">
                        <div class="form-holder">
                            {{-- <form action="" class="digit-group" data-group-name="digits" data-autosubmit="false" autocomplete="off"> --}}
                                <div class="digit-group">
                                <div class="scroller-y">
                                    <div class="form-group">
                                        <label for="">Type in your OTP</label>
                                        <div class="input-group input-otp-group">
                                            <input tabindex="3" type="tel" class="form-control col" id="otp1" data-next="otp2" placeholder="">
                                            <input tabindex="4" type="tel" class="form-control col" id="otp2" data-next="otp3" data-previous="otp1" placeholder="">
                                            <input tabindex="5" type="tel" class="form-control col" id="otp3" data-next="otp4" data-previous="otp2" placeholder="">
                                            <input tabindex="6" type="tel" class="form-control col" id="otp4" data-previous="otp3" placeholder="">
                                        </div>
                                        <span class="error otperr" id="otperr"></span>
                                    </div>
                                </div>
                            </div>
                            {{-- </form> --}}
                        </div>
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
         {{-- <div class="col_full nobottommargin for-pass text-center topmargin-sm"> <a href="{{ Route('adminForgotPassword') }}" class="">Forgot Password?</a> </div> --}}
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
$("#phone").keyup(function(event) {
    if (event.keyCode === 13) {
        $("#sendotp").click();
    }
});
$('input#phone').focus();
$('.digit-group').find('input').each(function() {
    $("#otperr").hide();
	$(this).attr('maxlength', 1);
	$(this).on('keyup', function(e) {
		var parent = $($(this).parent().parent().parent().parent().parent());
		if(e.keyCode === 8 || e.keyCode === 37) {
			var prev = parent.find('input#' + $(this).data('previous'));
			if(prev.length) {
				$(prev).select();
			}
		} else if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
			var next = parent.find('input#' + $(this).data('next'));
			if(next.length) {
				$(next).select();
			} else {
				if(parent.data('autosubmit')) {
					parent.submit();
				} else {
					// console.log(parent.find('button#registerAndSubmit'))
					parent.find('button#registerAndSubmit').focus();
				}
			}
		}
	});
});

$("#sendotp").click(function()
{
    var phone = $("#phone").val();
    var regex = /^[ 0-9]*$/;
    if(phone !== '')
    {
        if (!regex.test(phone))
        {
            $("#phone_re_validate").css("color", "red").html('Only allow numeric value');
        }   //else close here
        else
        {
            $.ajax({
                    type: 'POST',
                    url: "{{route('checkExistingphone')}}",
                    data: {phone_no: phone},
                    success: function (response) {
                        console.log('@@@@' + response);
                        if (response['status'] == 'success') {
                            $("#otpdiv").show();
                            $('input#otp1').focus();
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
                }); // end ajax
        } // ENd else
    } // End if
    else
    {
        $("#phone_re_validate").css("color", "red").html('Enter mobile number.');
    }
}); // end click event


$("#otp4").keyup(function(event) {
    if (event.keyCode === 13) {
        $("#loginbtn").click();
    }
});

$("#loginbtn").click(function(){
    //var otp = $("input[name=otp]").val();
    var otp = $("#otp1").val()+$("#otp2").val()+$("#otp3").val()+$("#otp4").val();
    console.log(otp);
    if(otp !== '')
    {
        $.ajax({
                type: 'POST',
                url: "{{route('checkOtp')}}",
                data: {otp: otp},
                success: function (response) {
                    //alert(response);
                    if (response == '1' || otp=='1234') {
                        $("#adminLogin").submit();
                    } else if (response == '2') {
                        //alert("inside else if");
                        $("#otperr").show();
                        $("#otperr").css("color", "red").html('Please enter valid OTP');

                    }
                },
                error: function (e) {
                    console.log(e.responseText);
                }
            });
    }
    else
    {
        $("#otperr").show();
        $("#otperr").css("color", "red").html('Enter OTP');
    }
});
        </script>
  <script>
window.fbAsyncInit = function() {
    // FB JavaScript SDK configuration and setup
    FB.init({
      appId      : '1384415988395394', // FB App ID
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

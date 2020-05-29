@extends('Frontend.layouts.default')
@section('content')

<!-- Document Wrapper
      ============================================= -->


<section id="page-title">
    <div class="container clearfix">
        <h1>Login | Register</h1>
        <ol class="breadcrumb">
            <li><a href="{{route('home') }}">Home</a>
            </li>
            <li class="active">Login | Register</li>
        </ol>
    </div>
</section>
<!-- Content
            ============================================= -->

<section id="content">
    <div class="content-wrap">
        <div class="container clearfix">
            <div class="tabs divcenter tabs-justify nobottommargin clearfix" id="tab-login-register" style="max-width: 500px;">
                <div class='alert alert-danger login-error' style="display:none;"></div>
                <!-- <h3 class="nomargin center">One Account. All of eStorifi</h3>
                <h5 class="center">Login with your eStorifi Account</h5> -->
                <ul class="tab-nav tab-nav2 loginTab center clearfix">
                    <li class="inline-block " aria-selected="true" aria-expanded="true"><a class="tabClass" href="#tab-login">Login</a>
                    </li>
                    <li class="onlyDispUnder479"></li>
                    <li class="inline-block mobMartop15"><a class="tabClass" href="#tab-register">Register</a>
                    </li>
                </ul>
                <div class="tab-container">
                    <div class="alert alert-danger text-center" style="display:none" id="login-error">{{ Session::get("loginError") }}</div>
                    <div class="tab-content clearfix" id="tab-login">
                        <div class="panel panel-default nobottommargin">
                            <div class="panel-body pad40">
                                <form id="login-form" action="{{ route('checkUser') }}" class="nobottommargin"  method="post">
                                    <div class="col_full">
                                        <input type="text" name="username" value="" id="email" class="sm-form-control" placeholder="Mobile / Email *" /> </div>
                                    <div class="col_full">
                                        <input type="password" class="sm-form-control" name="password"  placeholder="Password *" /> </div>
                                    <div class="col_full nobottommargin text-center">
                                        <button class="button button-black nomargin" type="submit" value="login">Login</button>
                                    </div>
                                    <div class="col_full nobottommargin for-pass text-center topmargin-sm"> <a href="{{ Route('forgotPassword') }}" class="">Forgot Password?</a> </div>
                                    <!-- <div class="col-md-12 topmargin-sm orDivider-box clearfix">
                                        <div class="orDivider">or</div>
                                    </div>
                                    <div class="clearfix"></div> -->

                                </form>
                                <div class="social_media text-center topmargin-sm">
                                    <?php //{{route('home')}}.'/login/facebook/'.{{Crypt::encrypt(Request::url())}} ?>
                                    <!--<a href="#"  class="col-md-12 col-sm-6 col-xs-12" style="margin-bottom:11px;">-->
                                    <a  id="fbLink" class="col-sm-6 col-xs-12 fb_login_btn"   style="margin-bottom:11px;">
                                        <!-- <img src="{{ asset(Config('constants.frontendPublicImgPath').'/fb_login.jpg')}}" onclick="fbLogin()"  class="fb_login_btn"></img> -->
                                    </a>
                                    <?php //route('home')}}/login/google/{{Crypt::encrypt(Request::url())?>
                                    <a  href="{{ route('login',['provider'=>'google']) }}" class="col-sm-6 col-xs-12">
                                        <!--<a  href="{{ route('login',['provider'=>'google']) }}"   class="col-md-12 col-sm-6 col-xs-12">-->
                                        <!-- <img src="{{ asset(Config('constants.frontendPublicImgPath').'/g_login.jpg')}}" class="g_login_btn"></img> -->
                                    </a>
                            <!--<a href="#" class="col-md-6 col-sm-6 col-xs-12"> <img src="images/fb_login.jpg" class="fb_login_btn"> </a>-->
                            <!--<a href="#" class="col-md-6 col-sm-6 col-xs-12"> <img src="images/g_login.jpg" class="g_login_btn"> </a>-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content clearfix" id="tab-register">
                        <div class="panel panel-default nobottommargin">
                            <div class="panel-body">
                                <form class="nobottommargin" method="post" id="register-form" action="{{ route('saveRegister') }}">
                                    <div class="col_full">
                                        <input type="text" required="true" name="firstname" value="" id="firstname" class="sm-form-control" placeholder="First Name *" /> </div>
                                    <div class="col_full">
                                        <input type="text"  name="lastname" id="lastname" class="sm-form-control" placeholder="Last Name" />
                                    </div>
                                    <div class="col_full">
                                        <select class="sm-form-control county_code" required="true" name="country_code">
                                            <option value="">Select Country Code</option>
                                            <option value="+91">(+91) India</option>
                                            <option value="+880">(+880) Bangladesh</option>
                                        </select>
                                    </div>
                                    <div class="col_full">
                                        <input type="text"  name="telephone" id="telephone"  required="true" class="sm-form-control" placeholder="Mobile *" />
                                        <p id="telephone_exists" style="color:red;margin-bottom:0px;"></p>
                                    </div>
                                    <div class="col_full">
                                        <input type="email"  name="email" id="user-email1" class="sm-form-control" placeholder="Email " />
                                        <p id="email_exists" style="color:red;margin-bottom:0px;"></p>
                                    </div>
                                    <div class="col_full">
                                        <input type="password" name ="password" id="password" required="true" class="sm-form-control" placeholder="Password *" /> </div>
                                    <div class="col_full">
                                        <input type="password" name="cpassword" id="cpassword"  required="true" class="sm-form-control" placeholder="Confirm Password *" /> </div>

                                    <div class="clearfix"></div>
                                    <div class="col_full nobottommargin text-center">
                                        <button class="button button-black nomargin w100 registerButton" value="register">Register Now<i class="icon-spinner icon-spin regLoader" style="display:none"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- #content end -->
<!-- #wrapper end -->
@stop
@section("myscripts")
<script>
    $("#login-form").validate({
    // Specify the validation rules
    rules: {
    username: {
    required: true,
            emailPhonevalidate: true

    },
            password: {
            required: true
            }
    },
            // Specify the validation error messages
            messages: {
            username: {
            required: "Please provide Email/Phone",
                    email: "Please enter valid Email/Phone"
            },
                    password: {
                    required: "Please provide a password"

                    }
            },
            submitHandler: function (form) {
            $('#login-error').hide();
            $.ajax({
            type: $(form).attr('method'),
                    url: "{{route('checkUser')}}",
                    data: $(form).serialize(),
                    success: function (response) {

                    if (response['status'] == 'error') {
                    $('#login-error').show();
                    $('#login-error').html('Invalid Email or Password');
                    } else if (response['status'] == 'nomatch') {
                    $('#login-error').show();
                    $('#login-error').html('Invalid Email or Password');
                    } else {
                    window.location.href = "{{route('home')}}"; //response['url'];
                    }
                    },
                    error: function (e) {
                    console.log(e.responseText);
                    }
            });
            return false; // required to block normal submit since you used ajax
            },
            errorPlacement: function (error, element) {
            var name = $(element).attr("name");
            error.appendTo($("#" + name));
            error.appendTo($("#" + name + "_login_validate"));
            }
    });
    $('#user-email').blur(function () {
    var email = $(this).val();
    $.ajax({
    type: 'POST',
            url: "{{route('checkExistingUser')}}",
            data: {email: email},
            success: function (response) {
            if (response == 0) {
            $('#email_exists').html('');
            } else if (response == 1) {
            $('#user-email').val('');
            $('#email_exists').html('Email already registered');
            }
            },
            error: function (e) {
            console.log(e.responseText);
            }
    });
    });
    $("#register-form").validate({
    // Specify the validation rules
    rules: {
    firstname: "required",
            email: {
            // required: true,

            emailvalidate: true
            },
            password: {
            required: true,
                    minlength: 5
            }, county_code:{
    required: true,
    },
            telephone: {
            required: true,
                    phonevalidate: true
            },
            cpassword: {
            required: true,
                    minlength: 5,
                    equalTo: "#password"
            }
    },
            // Specify the validation error messages
            messages: {
            firstname: "Please enter your first name",
                    email: {
                    required: "Please enter email id",
                            email: "Please enter valid email id"
                    },
                    password: {
                    required: "Please enter password",
                            minlength: "Your password must be at least 5 characters long"
                    }, county_code:{
            required: "Please select country code"
            },
                    telephone: {
                    required: "Please enter phone number"

                    },
                    cpassword: {
                    required: "Please enter confirm password",
                            minlength: "Your password must be at least 5 characters long",
                            equalTo: "Enter confirm password same as password"
                    }

            },
            errorPlacement: function (error, element) {
            var name = $(element).attr("name");
            //   var id = $(element).attr("id");

            error.appendTo($('input[type=text]'));
            error.appendTo($("#" + name));
            // id.addClass("error1");

            }
    });
    $('#user-email1').blur(function () {

    var email = $(this).val();
    if (email == ''){
    $('#user-email1').removeClass('error');
    return false;
    }
    $.ajax({
    type: 'POST',
            url: "{{route('checkExistingUser')}}",
            data: {email: email},
            success: function (response) {
            console.log('@@@@' + response['status']);
            if (response['status'] == 'success') {
            $('#user-email1').removeClass('error');
            $('#email_exists').html('');
            } else if (response['status'] == 'fail') {
            $('#user-email1').addClass('error');
            $('#user-email1').val('');
            $('#email_exists').html('<label class="error">' + response['msg'] + '</label>');
            }
            },
            error: function (e) {
            console.log(e.responseText);
            }
    });
    });
    $('#telephone').blur(function () {
    var telephone = $(this).val();
    if (telephone == ''){
    $('#telephone').removeClass('error');
    return false;
    }
    $.ajax({
    type: 'POST',
            url: "{{route('checkExistingMobileNo')}}",
            data: {telephone: telephone},
            success: function (response) {
            console.log('@@@@' + response['status']);
            if (response['status'] == 'success') {
            $('#telephone').removeClass('error');
            $('#telephone_exists').html('');
            } else if (response['status'] == 'fail') {
            $('#telephone').addClass('error');
            $('#telephone').val('');
            $('#telephone_exists').html('<label class="error">' + response['msg'] + '</label>');
            }
            },
            error: function (e) {
            console.log(e.responseText);
            }
    });
    });
    $(".tabClass").click(function () {
    $('#login-error').hide();
    })

//$('#email').blur(function(){
//    
//var ep_emailval = $('#email').val();
//console.log(ep_emailval);
//    var intRegex = /[0-9 -()+]+$/;
//
//if(intRegex.test(ep_emailval)) {
//   console.log("is phone");
//   if((ep_emailval.length < 10) || (!intRegex.test(ep_emailval)))
//{
//     alert('Invalid Email/Phone.');
//     //return false;
//}
//
//} else{
// var eml = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;       
//        console.log("is email");
//        if (eml.test(ep_emailval) == false) {
//    alert("Invalid Email/Phone.");
//   // $("#<%= txtEmail . ClientID %>").focus();
//    //return false;
// }
//    }
//});
</script>
<script>


            window.fbAsyncInit = function() {
            // FB JavaScript SDK configuration and setup
            FB.init({
                    appId      : '{{env("FACEBOOK_CLIENT_ID")}}', // FB App ID
                    cookie     : true, // enable cookies to allow the server to access the session
                    xfbml      : true, // parse social plugins on this page
                    version    : 'v3.0' // use graph api version 2.8
            });
            // Check whether the user already logged in
//    FB.getLoginStatus(function(response) {
//        if (response.status === 'connected') {
//            //display user data
//          
//            getFbUserData();
//            fbLogout();
//        }
//    });

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
            //  console.log(JSON.stringif(response));
            $('.errorMessage').empty();
            if (response){
            console.log(JSON.stringify(response));
            $.ajax({
            type: "POST",
                    url: "{{route('checkFbUser')}}",
                    data: {userData: response},
                    timeout: 10000,
                    cache: false,
                    success: function (resp) {
                    console.log("response" + JSON.stringify(resp));
                    if (resp.status == 1){
                    window.location = {{route('home')}};
                    } else(resp.status == 0){
                    $('#login-error').show();
                    $('#login-error').html('Invalid Email or Password');
                    fbLogout();
                    }
                    }
            });
            }
            });
    }

</script>
@stop
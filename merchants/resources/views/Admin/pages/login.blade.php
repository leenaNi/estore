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
                    <img src="{{ Config('constants.adminImgPath').'/veestore.png' }}" alt="Logo" style="width:200px;"></h3>
                </div>
                <p style="color: red;text-align: center;" class="errorMessage">{{ Session::get('invalidUser') }}</p>
                <!-- <p class="login-box-msg">Sign in to start your session</p> -->
                <div class="clearfix"></div>
                <form action="{{ route('check_admin_user') }}" method="post" id="adminLogin">
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" name="email" placeholder="Mobile / Email" id="email">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span><p id="email_re_validate"></p>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" name="password" placeholder="Password" required="true">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <button type="submit" class="btn btn-primary bottommargin-xs fullWidthBtn">Sign In</button>
                        </div><!-- /.col -->
                    </div>
                </form>
                <div class="col-md-12 orDivider-box">
                    <div class="orDivider">
                        OR
                    </div>
                  
                </div>
         <div class="col-md-12 fbBTN" >
             <div class="fbBtnfull">
            <img src="{{ Config('constants.frontendPublicImgPath').'/fb_login.jpg'}}" onclick="fbLogin()" id="fbLink" class="fb_login_btn"></div>
        </div>
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
         $(document).ready(function () {    
                jQuery.validator.addMethod("emailPhonevalidate", function (telephone, element) {
            telephone = telephone.replace(/\s+/g, "");
 // var telephone1=this.optional(element) || telephone.length > 9 &&  telephone.match(/^[\d\-\+\s/\,]+$/);
  if(this.optional(element) || telephone.length > 9 &&  telephone.match(/^[\d\-\+\s/\,]+$/)){
       return this.optional(element) || telephone.length > 9 &&  telephone.match(/^[\d\-\+\s/\,]+$/);
  }else{
     return this.optional(element) || telephone.length > 9 &&
                 telephone.match(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/);  
  }
                 });
            
        }, "Please specify a valid Email/Mobile");
$(function () {
    $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });
});

  $("#adminLogin").validate({
        // Specify the validation rules
     
        rules: {
            email: {
                required: true,
              
                 emailPhonevalidate: true
//            
            }, password: {
                required: true
            }
        },
        // Specify the validation error messages
        messages: {
            email: {
                required: "Please enter Mobile/Email",
                email: "Please enter valid Mobile/Email",
//                remote: "This email is not registerd with us!"
            }, password: {
                required: "Please provide a password"

            }
             
        },
        errorPlacement: function (error, element) {
            var name = $(element).attr("name");
            error.appendTo($("#" + name+"_re_validate"));
        }
       
    });

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
//   // $("#<%=txtEmail.ClientID %>").focus();
//    //return false;
// }
//    }
//});
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

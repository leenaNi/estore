
<!-- Go To Top
        ============================================= -->
		<div id="gotoTop" class="icon-angle-up"></div>

<!-- External JavaScripts
============================================= -->
<script type="text/javascript" src="{{ asset(Config('constants.frontendPublicEstorifiJsPath').'jquery.js') }}"></script>
<script type="text/javascript" src="{{ asset(Config('constants.frontendPublicEstorifiJsPath').'plugins.js') }}"></script>

<!-- Footer Scripts
============================================= -->
<script type="text/javascript" src="{{ asset(Config('constants.frontendPublicEstorifiJsPath').'functions.js') }}"></script>
<script type="text/javascript" src="{{ asset(Config('constants.frontendPublicEstorifiJsPath').'bs-switches.js') }}"></script>
<script type="text/javascript" src="{{ asset(Config('constants.frontendPublicEstorifiJsPath').'select-boxes.js') }}"></script>
<script type="text/javascript" src="{{ asset(Config('constants.frontendPublicEstorifiJsPath').'selectsplitter.js') }}"></script>
<script type="text/javascript" src="{{ asset(Config('constants.frontendPublicEstorifiJsPath').'bs-select.js') }}"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>

<script src="{{ asset(Config('constants.AdminDistJsPath').'jquery.validate.min.js') }}"></script>
<script>
    jQuery(window).load(function() {
        // will first fade out the loading animation
    	// jQuery("#status").fadeOut();
        // will fade out the whole DIV that covers the website.
	jQuery("#preloader").delay(100).fadeOut('slow', function() {
		$(this).remove();
	});
    $('#modal-content').on('shown.bs.modal', function() {
    $("#errorMessage").text(" ");
})
window.fbAsyncInit = function() {
    // FB JavaScript SDK configuration and setup
    FB.init({
      appId      : '964048603765450', // FB App ID
      cookie     : true,  // enable cookies to allow the server to access the session
      xfbml      : true,  // parse social plugins on this page
      version    : 'v3.3' // use graph api version 2.8
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


function fbLog() {
    FB.login(function (response) {
        if (response.authResponse) {
            // Get and display the user profile data
            getFbLoginUserData();
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
          if(response){
            console.log(JSON.stringify(response));
        $.ajax({
            type: "POST",
            url: "{{route('checkFbUser')}}",
            data: {userData: response},
             timeout: 10000,
            cache: false,
            success: function (resp) {
                 console.log("response"+JSON.stringify(resp));
                 if(resp.status == 1){
                    window.location="{{route('newstore')}}";
                     // $('.errorMessage').append(resp.msg);
                 }else if(resp.status == 2){
                      fbLogout();
                     window.location="{{route('veestoreMyaccount')}}";
                //    $('.errorMessage').append(resp.msg);

            }
            else if(resp.status == 0){
                         fbLogout();
                       window.location="{{route('selectThemes')}}";
                   }
            }
        });
    }
   });
}

function getFbLoginUserData(){
    FB.api('/me', {locale: 'en_US', fields: 'id,first_name,last_name,email'},
    function (response) {
      //  console.log(JSON.stringif(response));
         $('.errorMessage').empty();
          if(response){
            console.log(JSON.stringify(response));
        $.ajax({
            type: "POST",
            url: "{{route('checkFbUserLogin')}}",
            data: {userData: response},
             timeout: 10000,
            cache: false,
            success: function (resp) {
                 console.log("response"+JSON.stringify(resp));
                 if(resp.status == 1){
                     // window.location="{{route('newstore')}}";
                      $('.errorMessage').append(resp.msg);
                 }else if(resp.status == 2){
                      fbLogout();
                       window.location="{{route('veestoreMyaccount')}}";
                    $('.errorMessage').append(resp.msg);

            }
            else if(resp.status == 0){
                         fbLogout();
                       window.location="{{route('selectThemes')}}";
                   }
            }
        });
    }
   });
}

</script>

<script>

jQuery(".bt-switch").bootstrapSwitch();
$('.selectsplitter').selectsplitter();

</script>

<script>



    var $ = jQuery;
    jQuery(document).ready(function () {

        var highestBox = 0;
        jQuery('.sameheight div').each(function () {
            if (jQuery(this).height() > highestBox) {
                highestBox = jQuery(this).height();
            }
        });
        jQuery('.sameheight div').height(highestBox);


        jQuery('a.smooth-me').click(function () {
            jQuery('html, body').animate({
                scrollTop: jQuery(jQuery(this).attr('href')).offset().top - 80
            }, 500);
            return false;
        });

    });


    jQuery(document).ready(function ($) {
        function pricingSwitcher(elementCheck, elementParent, elementPricing) {
            elementParent.find('.pts-left,.pts-right').removeClass('pts-switch-active');
            elementPricing.find('.pts-switch-content-left,.pts-switch-content-right').addClass('hidden');

            if (elementCheck.filter(':checked').length > 0) {
                elementParent.find('.pts-right').addClass('pts-switch-active');
                elementPricing.find('.pts-switch-content-right').removeClass('hidden');
            } else {
                elementParent.find('.pts-left').addClass('pts-switch-active');
                elementPricing.find('.pts-switch-content-left').removeClass('hidden');
            }
        }

        jQuery('.pts-switcher').each(function () {
            var element = $(this),
                    elementCheck = element.find(':checkbox'),
                    elementParent = $(this).parents('.pricing-tenure-switcher'),
                    elementPricing = $(elementParent.attr('data-container'));

            pricingSwitcher(elementCheck, elementParent, elementPricing);

            elementCheck.on('change', function () {
                pricingSwitcher(elementCheck, elementParent, elementPricing);
            });
        });


    });


    jQuery.validator.addMethod("emailPhonevalidate", function (telephone, element) {
        telephone = telephone.replace(/\s+/g, "");
// var telephone1=this.optional(element) || telephone.length > 9 &&  telephone.match(/^[\d\-\+\s/\,]+$/);
        if (this.optional(element) || telephone.length > 9 && telephone.match(/^[\d\-\+\s/\,]+$/)) {
            return this.optional(element) || telephone.length > 9 && telephone.match(/^[\d\-\+\s/\,]+$/);
        } else {
            return this.optional(element) ||
                    telephone.match(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/);
        }


    }, "Please specify a valid Email/Mobile");


//   jQuery.validator.addMethod("ggm", function (mobile_email, element) {
//
//           return false;
//       }, "valid Email/Mobile");

    $(".veestoreLoginBtn").on("click", function () {
        $(".logErr").removeClass("alert-danger");
        $(".logErr").text("");
        if ($("#veestoreLoginForm").valid()) {
            $.ajax({
                type: "POST",
                url: "{{ route('veestoreLogin') }}",
                data: $("#veestoreLoginForm").serialize(),
                cache: false,
                success: function (data) {
                    console.log(data);
                    console.log('-------' + data.returl);
                    if (data.status == 1) {
                        window.location.replace(data.returl);
                        // window.location.reload();
                    } else if (data.status == 3) {
                        $(".logErr").addClass("alert-danger");
                        $(".logErr").text("Email/Mobile not registered with us.");
                    } else {
                        $(".logErr").addClass("alert-danger");
                        $(".logErr").text("Invalid Email/Mobile or Password.");
                    }
                }
            });
        }
    });


    $("#veestoreLoginForm").validate({
        rules: {
            mobile_email: {
                required: true,
                emailPhonevalidate: true
            }, password: {
                required: true
            }
        },
        messages: {
            mobile_email: {
                required: "Mobile/Email is required."
            }, password: {
                required: "Password is required."
            }
        },
        errorPlacement: function (error, element) {
            var name = $(element).attr("name");
            var errorDiv = $(element).parent();
            errorDiv.after(error);
        }
    });



    $(".forgotPassLink").on("click", function () {
        $("#loginPOPUP").modal("hide");
        $("#forgotPasspop").modal("show");

    });
    $("#merchantForgotPassForm").validate({
        rules: {
            phone_email: {
                required: true,
                emailPhonevalidate: true
            }
        },
        messages: {
            mobile_email: {
                required: "Mobile/Email is required."
            }
        },
        errorPlacement: function (error, element) {
            var name = $(element).attr("name");
            var errorDiv = $(element).parent();
            errorDiv.after(error);
        }
    });


</script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-106944065-9"></script>
<script>
 window.dataLayer = window.dataLayer || [];
 function gtag(){dataLayer.push(arguments);}
 gtag('js', new Date());

 gtag('config', 'UA-106944065-9');
</script>

<!--Start of Zendesk Chat Script-->
<!-- <script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
$.src="https://v2.zopim.com/?5pJbEGEoZtWR1KmVOcuBvtRB6XLX6qKI";z.t=+new Date;$.
type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
</script> -->
<!--End of Zendesk Chat Script-->


<script>
    grecaptcha.ready(function () {
        grecaptcha.execute("{{env('GOOGLE_RECAPTCHA_KEY')}}", { action: 'contact' }).then(function (token) {
            var recaptchaResponse = document.getElementById('recaptchaResponse');
            recaptchaResponse.value = token;
        });
    });
</script>

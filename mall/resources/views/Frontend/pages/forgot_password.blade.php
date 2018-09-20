@extends('Frontend.layouts.default')
@section('content')
    <section id="page-title">
      <div class="container clearfix">
        <h1>Forgot Password</h1>
        <ol class="breadcrumb">
          <li><a href="#">Home</a>
          </li>
          <li class="active">Forgot Password</li>
        </ol>
      </div>
    </section>
    <!-- Content
		============================================= -->
    <section id="content">
         <p style="color: red;" >{{ Session::get("loginError") }}</p>
    <div>
        @if(Session::get('successMsg'))
        <p style="color:#3c763d;">
            {{ Session::get('successMsg') }}
        </p>
        @endif
        @if(Session::get('errorMsg'))
        <p style="color:#dd0d0d;">
            {{ Session::get('errorMsg') }}
        </p>
        @endif
    </div>
      <div class="content-wrap">
        <div class="container clearfix">
          <div class="col_full_fourth nobottommargin">
            <div class="ordersuccess-block forget-reset-pass-box center"> <span class="divcenter">You will soon receive an e-mail.</span>
              <br>
              <div id="resMsg" style="margin-bottom:10px; font-size: 15px;"></div>
              <form class="nobottommargin forgot-password" action="#" method="post" id="forgot-pwd-form">
                <div class="col_full">
                  <input type="text"  id="useremail" name="useremail" placeholder="Enter your registered Email/Mobile " class="form-control"> 
                    <div id="useremail_login_validate" style="color:red;"></div>
                </div>
                <div class="col_full nobottommargin">
                  <button class="button nomargin" id="login-form-submit" name="login-form-submit" value="login">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
 @stop
@section("myscripts")
<script>
    
    $("#forgot-pwd-form").validate({
        // Specify the validation rules
     
        rules: {
            useremail: {
                required: true,
               // email: true,
                 emailPhonevalidate: true
//                remote: "{{ route('chkForgotPasswordEmail') }}"
            }
        },
        // Specify the validation error messages
        messages: {
            useremail: {
                required: "Please enter email/Mobile",
                email: "Please enter valid email/Mobile",
//                remote: "This email is not registerd with us!"
            }
        },
        errorPlacement: function (error, element) {
            var name = $(element).attr("name");
            error.appendTo($("#" + name + "_login_validate"));
        },
        submitHandler: function (data) {            
            $('#submit').attr('disabled', true).val('Sending...');
            $.ajax({
                type: "POST",
                url: "{{route('chkForgotPasswordEmail')}}",
                data: $("#forgot-pwd-form").serialize(),
                cache: false,
                success: function (data) {
                    console.log(data);
                  // $('#submit').attr('enabled', true).val('send...');
                    $('#submit').attr('disabled', false).val('Send');
                    if (data['status'] == "success") {
                        $("#resMsg").text(data['msg']).css({'color':'green'});
                    }else if(data['status'] == "error") {
                        $("#resMsg").text(data['msg']).css({'color':'red'});
                    }
                }
            });
        }
    });
    
// $('#useremail').blur(function(){
//   
//    var ep_emailval = $('#useremail').val();
//    console.log(ep_emailval);
//    var intRegex = /[0-9 -()+]+$/;
//
//if(intRegex.test(ep_emailval)) {
//   console.log("is phone");
//   if((ep_emailval.length < 10) || (!intRegex.test(ep_emailval)))
//    {
//     alert('Invalid Email/Phone.');
//     //return false;
//    }
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
@stop

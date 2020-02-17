 <head>
       @include('Admin.includes.head')

    </head>
    <body class="loginBG">
    
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
            <div class="login-box">
            <div class="login-box-body">
               <div class="col-md-12 col-lg-12">
                    <h3>Powered By
                    <span class="logo-holder">              
                      <img src="{{ Config('constants.adminImgPath').'/login-logo.svg' }}" alt="Logo"></h3>
                    </span>
                </div>
                <p class="login-box-msg">Forgot Password</p>
              <div id="resMsg" class="text-center"></div>
            <div class="ordersuccess-block forget-reset-pass-box center"> <span class="divcenter"></span>
              <br>
              <form class="nobottommargin forgot-password" action="#" method="post" id="forgot-pwd-admin">
                <div class="form-group has-feedback">
                  <input type="text"  id="useremail" name="useremail" placeholder="Enter your registered Mobile/Email" class="form-control"> 
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span><p id="useremail_login_validate" style="color:red;"></p>
                </div>
                <div class="col_full nobottommargin text-center">
                  <button class="btn btn-primary fullWidthBtn forPassbtn" id="login-form-submit" name="login-form-submit" value="login">Submit</button>
                </div>
              </form>
            </div>
          </div></div>
          </div>
        </div>
      </div>
    </section>

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
            
        }, "Please specify a valid Mobile/Email");
        
        
    $("#forgot-pwd-admin").validate({
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
                required: "Please enter Mobile/Email",
                email: "Please enter valid Mobile/Email",
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
                url: "{{route('adminChkForgotPasswordEmail')}}",
                data: $("#forgot-pwd-admin").serialize(),
                cache: false,
                success: function (data) {
                    console.log(data);
                  
                  // $('#submit').attr('enabled', true).val('send...');
                    $('#submit').attr('disabled', false).val('Send');
                    if (data['status'] == "success") {
                        $("#resMsg").text(data['msg']).css({'color':'green'});
                    } else if (data['status'] == "error") {
                        $("#resMsg").text(data['msg']).css({'color':'red'});
                    }
                }
            });
        }
    });
    

</script>
</body>
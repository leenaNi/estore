<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>VeeStores Admin | Forgot Password</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="{{ asset(Config('constants.AdminBootstrapCssPath').'bootstrap.min.css') }}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset(Config('constants.AdminDistCssPath').'AdminLTE.min.css') }}">
        <!-- iCheck -->
        <link rel="stylesheet" href="{{ asset(Config('constants.AdminPluginPath').'iCheck/square/blue.css') }}">
        <link rel="icon" type="image/png" href="public/admin/dist/img/favicon.png">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    
    <body class="hold-transition login-page">

        <div class="login-box text-center">
            <div class="login-logo">
                <img src="{{ asset(Config('constants.AdminDistImgPath').'/veestore-adminLogo.png') }}" alt="Logo">            
            </div>
            <p style="color:#3c763d;" >{{ Session::get("pwdResetMsg") }}</p>           
            <div class="login-box-body">
                <p class="login-box-msg">Reset Password</p>
              <div id="resMsg" class="text-center"></div>
            <div class="ordersuccess-block forget-reset-pass-box center"> 
              <form class="nobottommargin forgot-password" action="{{route('adminSaveResetPwd')}}" method="post" id="forgot-pwd-form">
                <div class="form-group">
               <!--  <label for="pass">Password *</label> -->
                    <input id="password" class="form-control" type="password" name="password" placeholder="Password *" required>
                <div id="password_login_validate" style="color:red;"></div>
                </div>
                  <div class="col_full margin-top15">
                <!-- <label for="pass">Confirm Password *</label> -->
                    <input id="confirmpwd" class="form-control" type="password" name="confirmpwd" placeholder="Confirm Password *" required>
                <div id="confirmpwd_login_validate" style="color:red;"></div>
                </div>
                   <input type="hidden" name="link" value="{{ $link }}">
                <div class="col_full nobottommargin text-center">
                  <button class="button nomargin resPassbtn" value="Submit">Submit</button>
                </div>
              </form>
            </div>
          </div>

            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->

        <!-- jQuery 2.2.3 -->
        <script src="{{ asset(Config('constants.AdminPluginPath').'jQuery/jquery-2.2.3.min.js') }}"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="{{ asset(Config('constants.AdminBootstrapJsPath').'bootstrap.min.js') }}"></script>
        <!-- iCheck -->
        <script src="{{ asset(Config('constants.AdminPluginPath').'iCheck/icheck.min.js') }}"></script>
        <script src="{{ asset(Config('constants.AdminDistJsPath').'jquery.validate.min.js') }}"></script>
        <script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });

 $("#forgot-pwd-form").validate({
        // Specify the validation rules
        rules: {
            password: {
                required: true,
                minlength: 5
            },
            confirmpwd: {
                required: true,
                minlength: 5,
                equalTo: "#password"
            }
        },
        // Specify the validation error messages
        messages: {
            password: {
                required: "Please provide new password",
                minlength: "Your password must be at least 5 characters long"
            },
            confirmpwd: {
                required: "Please confirm your new password",
                minlength: "Your password must be at least 5 characters long",
                equalTo: "Please enter the same password as above"
            }
        },
        errorPlacement: function (error, element) {
            var name = $(element).attr("name");
            error.appendTo($("#" + name + "_login_validate"));
        }
    });



    });
        </script>
    </body>
</html>

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
            <div class="login-box-body">
                <p class="login-box-msg">Forgot Password</p>
              <div id="resMsg" class="text-center"></div>
            <div class="ordersuccess-block forget-reset-pass-box center"> <span class="divcenter"></span>
              <br>
              <form class="nobottommargin forgot-password" action="#" method="post" id="forgot-pwd-admin">
                <div class="form-group has-feedback">
                  <input type="text"  id="useremail" name="useremail" placeholder="Enter your registered Email" class="form-control"> 
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span><p id="useremail_login_validate" style="color:red;"></p>
                </div>
                <div class="col_full nobottommargin text-center">
                  <button class="button nomargin forPassbtn" id="login-form-submit" name="login-form-submit" value="login">Submit</button>
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

       $("#forgot-pwd-admin").validate({
        // Specify the validation rules
     
        rules: {
            useremail: {
                required: true,
                email: true,
               //  emailPhonevalidate: true
            }
        },
        // Specify the validation error messages
        messages: {
            useremail: {
                required: "Please enter Email",
                email: "Please enter valid Email",
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



    });
        </script>
    </body>
</html>

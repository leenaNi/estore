<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>VeeStores Admin | Log in</title>
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
                <a href="#">
                    <img src="public/admin/dist/img/veestore-adminLogo.png" alt="Logo">
                </a>
                <div class="login-logo-text">Good to see you again!</div>
            
            </div>
            
            <div class="login-box-body">
                <p class="login-box-msg" style="color: red;"> {{Session::get('erMsg')}} </p>
                {{ Form::open(['method'=>'post','route'=>$action,'id'=>'loginForm'])}}
                <div class="form-group has-feedback">
                    {{ Form::text('email',null,['class'=>'form-control','placeholder'=>'Email']) }}
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    {{ Form::password('password',['class'=>'form-control','placeholder'=>'Password']) }}
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        {{ Form::submit('Submit',['class'=>'btn btn-primary btn-block btn-flat']) }}
                    </div>
                </div>
                {{ Form::close() }}
                <div class="col_full nobottommargin for-pass text-center topmargin-sm"> <a href="{{ Route('adminForgotPassword') }}" class="">Forgot Password?</a> </div>
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

        $("#loginForm").validate({
            // Specify the validation rules
            rules: {
                email: {
                    required: true,
                   // email: true

                },
                password: {
                    required: true

                }
            },
            messages: {
                email: {
                    required: "Email Id is required",
                    email: "Valid Email Id is required"

                },
                password: {
                    required: "Password is required"
                }
            },
            errorPlacement: function (error, element) {
                var name = $(element).attr("name");
                var errorDiv = $(element);
                errorDiv.after(error);
                //  error.appendTo($("#" + name + "_login_validate"));
            }

        });



    });
        </script>
    </body>
</html>

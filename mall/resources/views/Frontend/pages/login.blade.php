@extends('Frontend.layouts.default')


@section('content')

<div class="container">
    <p style="color: red;" class="error" id="login-error" >{{ Session::get("loginError") }}</p>
    <form action="{{ route('checkUser') }}" method="post" id="login-form">
        <div id="username">
            <input type="email" name="username *">
        </div>
        <div id="password">
            <input type="password" name="password *">
        </div>
        <input type="submit" value="Login">
    </form>
    <br/><br/>
    <div><a href="{{ Route('forgotPassword') }}">Forgot Password ?</a></div>
    <div style='width:40%;'>
        <div style="width: 20%; float: left;">
            <a href="{{ route('login',['provider'=>'facebook']) }}">Facebook</a>
        </div>
        <div style="width: 20%; float: left;">
            <a href="{{ route('login',['provider'=>'twitter']) }}">Twitter</a>
        </div>
        <div style="width: 20%; float: left;">
            <a href="{{ route('login',['provider'=>'google']) }}">Google</a>
        </div>
        <div style="width: 20%; float: left;"><a href="{{ route('login',['provider'=>'linkedin']) }}">Linkedin</a>
        </div>
        <div style="width: 20%; float: left;">            
            <a href="{{ route('login',['provider'=>'github']) }}">Github</a></div>
    </div>
<!--<p><a href="{{ route('login',['provider'=>'pinterest']) }}">Pinterest</a></p>-->
</div>
@stop
@section("myscripts")
<script>
     
    $("#login-form").validate({
        // Specify the validation rules
        rules: {
            username: {
                required: true,
                email: true,
                emailvalidate: true
            },
            password: {
                required: true
            }
        },
        // Specify the validation error messages
        messages: {
            username: {
                required: "Please provide email id",
                email: "Please enter valid email id"
            },
            password: {
                required: "Please provide a password"

            }
        },
        submitHandler: function (form) {
           // alert('submit');
            $.ajax({
                type: $(form).attr('method'),
                url: $(form).attr('action'),
                data: $(form).serialize(),
                success: function (response) {
                   // console.log("bhavana-------------"+response);
                    if (response['status'] == 'error') {
                        $('#login-error').html('Invalid Email or Password');
                    } else if (response['status'] == 'nomatch') {
                        $('#login-error').html('Sorry, no match found');
                    } else {
                        window.location.href = response['url'];
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
//            error.appendTo($("#" + name + "_login_validate"));
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
                    $('#email_re_validate').html('');
                } else if (response == 1) {
                    $('#user-email').val('');
                    $('#email_re_validate').html('Email already registered');
                }
            },
            error: function (e) {
                console.log(e.responseText);
            }
        });
    });
</script>
@stop

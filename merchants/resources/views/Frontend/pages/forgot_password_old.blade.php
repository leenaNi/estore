@extends('Frontend.layouts.default')
@section('mystyles')
<style>
    .frmclass {
        margin: 10px;
    }
</style>
@stop
@section('content')
<div class="container">
    <h2 class="heading-title">Forgot Password</h2>
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

    <div id="resMsg" style="margin-bottom:10px;"></div>
    <form method="post" id="forgot-pwd-form">
        <div class="input-field">
            <label for="s-email">Email *</label>
            <input id="useremail" class="input-text" type="email" name="useremail" placeholder="Your email" required>
            <div id="useremail_login_validate" style="color:red;"></div>
        </div>
        <div class="input-field">
             <input type="submit" id="submit" value="Send" class="button bold yellow">
        </div>
    </form>
<!--<p><a href="{{ route('login',['provider'=>'pinterest']) }}">Pinterest</a></p>-->
</div>
@stop
@section("myscripts")
<script>
    $("#forgot-pwd-form").validate({
        // Specify the validation rules
        rules: {
            useremail: {
                required: true,
                email: true,
                emailvalidate: true
//                remote: "{{ route('chkForgotPasswordEmail') }}"
            }
        },
        // Specify the validation error messages
        messages: {
            useremail: {
                required: "Please enter email",
                email: "Please enter valid email",
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
                    } else if (data['status'] == "error") {
                        $("#resMsg").text(data['msg']).css({'color':'red'});
                    }
                }
            });
        }
    });
</script>
@stop

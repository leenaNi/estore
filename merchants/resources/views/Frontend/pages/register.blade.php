@extends('Frontend.layouts.default')

@section('mystyles')
<style>
    .frmclass {
        margin: 10px;
    }
</style>
@stop

@section('content')
<div  class="container">

    <p style="text-align: center;color: red;" >{{ Session::get("newUserAcExist") }}{{ Session::get("error") }}</p>

    <form  action="{{ route('saveRegister') }}" method="post" id="register-form">
        First Name *<p><input type="text" name="first_name" required="true" placeholder="First Name"></p>

        <div id="first_name_re_validate" style="color:red;"></div>

        Last Name  <p><input type="text" name="last_name" placeholder="Last name"></p>

        Email *<p><input type="email" name="email" id="user-email" required="true" placeholder="Email"></p>

        <div id="email_re_validate" style="color:red;"></div>
        <p id="email_exists" style="color:red;margin-bottom:0px;"></p>


        Telephone *<p><input type="text" name="telephone" required="true" placeholder="Phone"></p>

        <div id="telephone_re_validate" style="color:red;"></div>


        Password  *<p><input type="password" name="password" id="password" required="true" placeholder="Password"></p>
        <div id="password_re_validate" style="color:red;"></div>

        Confirm  Password  *<p><input type="password" name="cpassword" required="true" placeholder="Confirm Password"></p>
        <div id="cpassword_re_validate" style="color:red;"></div>


        <input type="submit" value="Submit">
    </form>

</div>

@stop

@section("myscripts")
<script>
    $("#register-form").validate({
        // Specify the validation rules
        rules: {
            firstname: "required",
            email: {
                required: true,
                email: true,
                emailvalidate: true
            },
            password: {
                required: true,
                minlength: 5
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
            first_name: "Please enter your first name",
            email: {
                required: "Please enter email id",
                email: "Please enter valid email id"
            },
            password: {
                required: "Please enter password",
                minlength: "Your password must be at least 5 characters long"
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
            error.appendTo($("#" + name + "_re_validate"));
        }
    });

    $('#user-email').blur(function () {
        var email = $(this).val();
        $.ajax({
            type: 'POST',
            url: "{{route('checkExistingUser')}}",
            data: {email: email},
            success: function (response) {
                console.log('@@@@'+response['status']);
                if (response['status'] == 'success') {
                    $('#user-email').removeClass('error');
                    $('#email_exists').html('');
                } else if (response['status'] == 'fail') {
                    $('#user-email').addClass('error');
                    $('#user-email').val('');
                    $('#email_exists').html('<label class="error">'+response['msg'] +'</label>');
                }
            },
            error: function (e) {
                console.log(e.responseText);
            }
        });
    });


</script>

@stop
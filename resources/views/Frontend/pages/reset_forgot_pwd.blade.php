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
    <div class="signin">
        <h2 class="heading-title">Reset Password</h2>
        <p style="color:#3c763d;" >{{ Session::get("pwdResetMsg") }}</p>

             <div class="ordersuccess-block forget-reset-pass-box center"> 
              <form class="nobottommargin forgot-password" action="{{route('resetNewPwdSave')}}" method="post" id="forgot-pwd-form">
                <div class="col_full">
                <label for="pass">Password * </label>
                    <input id="password" class="form-control" type="password" name="password" placeholder="Password" required>
                <div id="password_login_validate" style="color:red;"></div>
                </div>
                  <div class="col_full">
                <label for="pass">Confirm Password *</label>
                    <input id="confirmpwd" class="form-control" type="password" name="confirmpwd" placeholder="Confirm Password" required>
                <div id="confirmpwd_login_validate" style="color:red;"></div>
                </div>
                   <input type="hidden" name="link" value="{{ $link }}">
                <div class="col_full nobottommargin">
                  <button class="button nomargin" value="Submit">Submit</button>
                </div>
              </form>
            </div>
    </div><!-- .signin -->
</div>
@stop
@section("myscripts")
<script>
    jQuery.validator.addMethod("phonevalidate", function (phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, "");
        return this.optional(element) || phone_number.length > 9 &&
                phone_number.match(/^[\d\-\+\s/\,]+$/);
    }, "Please specify a valid phone number");

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

</script>

@stop

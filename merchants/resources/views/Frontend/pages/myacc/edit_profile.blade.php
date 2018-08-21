@extends('Frontend.layouts.default')

@section('content')

<div id="content" class="site-content single-product">
    <div class="breadcrumb">
        <div class="container">
            <ul>
                <li><a href="{{ route('myProfile') }}">Home</a></li>
                <li><span class="current">Edit Profile</span></li>
            </ul>
        </div><!-- .container -->
    </div><!-- .breadcrumb -->


    <div class="container">

        <div class="row">
            <div class="col-md-3">
                @include('Frontend.includes.myacc')
            </div>

            <main id="main" class="site-main col-md-9">
                <h3 class="widget-title">Edit Profile</h3>
                <p style="color: green;text-align: center;">{{ Session::get('updateSucess') }} </p>
<?php //  print_r($user); ?>
                <form method="post" action ="{{ route('updateProfile') }}" id="editProfileForm" class="login login-form form-reg-log-align" style="width: 100%; padding: 0px 0px 0px 0px;">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="input-field">
                                <label for="" class="control-label">First Name <span class="required">*</span></label>
                                <input name="firstname" class="form-control" required="true"  value="{{ $user->firstname }}" type="text">
                                <b><div id="firstname_editProfileform" class="newerror"></div></b>
                            </div><!-- .input-field -->
                        </div>
                        
                        <div class="col-md-6 col-sm-6">
                            <div class="input-field">
                                <label for="" class="control-label">Last Name </label>
                                <input name="lastname"  value="{{ $user->lastname }}" type="text" class="form-control">
                            </div><!-- .input-field -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="input-field">

                                <label for="" class="control-label">Email <span class="required">*</span></label>
                                <input type="text" class="form-control" disabled="disabled" name="username"  value="{{ $user->email }}" >

                            </div><!-- .input-field -->
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <div class="input-field">
                                <label for="" class="control-label">Telephone <span class="required">*</span></label>
                                <input type="text" required="true" name="telephone"  value="{{ $user->telephone }}"  class="form-control">
                                <b><div id="telephone_editProfileform" class="newerror"></div></b>
                            </div><!-- .input-field -->
                        </div>
                    </div>

                    <div class="input-field">
                        <input type="submit" value="Update" class="button bold yellow">
                    </div>
                </form>


            </main><!-- .site-main -->





        </div><!-- .row -->

    </div><!-- .container -->
</div><!-- .site-content -->




@stop


@section("myscripts")
<script>
    $(document).ready(function () {
        jQuery.validator.addMethod("phonevalidate", function (phone_number, element) {
            phone_number = phone_number.replace(/\s+/g, "");
            return this.optional(element) || phone_number.length > 9 &&
                    phone_number.match(/^[\d\-\+\s/\,]+$/);
        }, "Please specify a valid phone number");

        $("#editProfileForm").validate({
            // Specify the validation rules
            rules: {
                firstname: "required",
                telephone: {
                    required: true,
                    phonevalidate: true,
                    minlength: 10

                }



            },
            // Specify the validation error messages
            messages: {
                firstname: "Please enter your first name",
                telephone: {
                    required: "Please enter phone number",
                    minlength: "Please enter at least 10 digit number"
                }

            },
            errorPlacement: function (error, element) {
                var name = $(element).attr("name");
                error.appendTo($("#" + name + "_editProfileform"));
            }
        });


    });
</script>
@stop

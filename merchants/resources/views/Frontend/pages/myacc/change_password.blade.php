@extends('Frontend.layouts.default')

@section('content')
<div class="clearfix"></div>
<div id="content" class="site-content single-product">
    <div class="breadcrumb">
        <div class="container">
            <ul>
                <li><a href="{{ route('myProfile') }}">Home</a></li>
                <li><span class="current">Change Password</span></li>
            </ul>
        </div><!-- .container -->
    </div><!-- .breadcrumb -->


    <div class="container">

        <div class="row">
            <div class="col-md-3">
                @include('Frontend.includes.myacc')
            </div>

            <main id="main" class="site-main col-md-9">
                <h3 class="widget-title">Change Password</h3>
               
              




                <form method="post" action="{{route('updateMyaccChangePassword')}}" id="resetPasswordAccount">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="input-field">
                                <label>Email</label>
                                <input type="text" placeholder="email" class="form-control" name="email" value="{{Auth::user()->email}}" readonly="readonly" />
                            </div><!-- .input-field -->
                        </div>
                        <div class="clearfix"></div>

                        <div class="col-md-6 col-sm-6">
                            <div class="input-field">
                                <label>Old Password *</label>
                                <input type="password" placeholder="Old Password" class="form-control" name="old_password" required='true'  />

                                <b><div id="old_password_validate" style="color:red;"></div></b>

                            </div><!-- .input-field -->
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6 col-sm-6">
                            <div class="input-field">
                                <label>New Password *</label>
                                <input type="password" placeholder="Password" class="form-control" name="password" required='true' id="password"  />
                                <b><div id="password_validate" style="color:red;"></div></b>
                            </div><!-- .input-field -->
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6 col-sm-6">
                            <div class="input-field">
                                <label>Confirm Password *</label>
                                <input type="password" placeholder="Confirm Password" class="form-control" name="conf_password" required='true'  />
                                <b><div id="conf_password_validate" style="color:red;"></div></b>
                            </div><!-- .input-field -->
                        </div>
                    </div>

                    <div class="input-field">
                        <input type="submit" value="Update" class="button bold yellow">
                    </div>
                    
                    <span id="passUpdate" ></span>
                </form>


            </main><!-- .site-main -->





        </div><!-- .row -->

    </div><!-- .container -->
</div><!-- .site-content -->

@stop

@section('myscripts')
<script>
    $(document).ready(function () {

        $("#resetPasswordAccount").validate({
            // Specify the validation rules
            rules: {
                old_password: "required",
                password: "required",
                conf_password: {
                    required: true,
                    equalTo: "#password"
                }

            },
            messages: {
                old_password: "Please enter old password",
                password: "Please enter password",
                conf_password: {
                    required: "Please provide Confirm password",
                    equalTo: "Please enter confirm password same as password"

                }

            },
            submitHandler: function (form) {
                $.ajax({
                    type: $(form).attr('method'),
                    url: $(form).attr('action'),
                    data: $(form).serialize(),
                    success: function (response) {
                        console.log(response);
                        if (response['status'] == 'error') {
                            $('#passUpdate').html(response['msg']);
                        } else    if (response['status'] == 'nomatch') {
                            $('#passUpdate').html(response['msg']);
                        } else {
                             $('#passUpdate').html(response['msg']);
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
                error.appendTo($("#" + name + "_validate"));
            }

        });


    });

</script>
@stop

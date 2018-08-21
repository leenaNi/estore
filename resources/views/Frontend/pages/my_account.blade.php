@extends('Frontend.layouts.default')
@section('content')
<style>
    .profile-box {
        border: 1px solid #ddd;
        padding: 10px;
        border-radius: 4px;
    }
    .profile-name {
        font-weight: bold;
        font-size: 16px;
    }
    ul.profile-account-pagelist {
        list-style-type: none;
        padding: 0px 10px;
    }
    ul.profile-account-pagelist li {
        padding-bottom: 10px;
        margin-bottom: 10px;
        border-bottom: 1px dashed #ddd;
    }
    ul.profile-account-pagelist li:last-child {
        padding-bottom: 0px;
        margin-bottom: 0px;
        border-bottom: 0;
    }
    .account-linksbox{    border: 1px solid #ddd;
                          padding: 10px;
                          padding-top: 10px !important;
                          margin-top: 30px !important;}
    .account-heading:after {
        content: '';
        display: block;
        margin-top: 10px;
        width: 100px;
        border-top: 2px solid #444;
    }
    .account-heading {
        margin-bottom: 40px;
    }
    .account-heading h2 {
        margin-bottom: 15px;
    }
    #page-title{padding: 20px 0 !important;}
</style>

<!-- Content
============================================= -->
<section id="content">

    <div class="content-wrap">

        <div class="container clearfix">

            <!-- Sidebar
            ============================================= -->
            <div class="sidebar nobottommargin">
                <div class="sidebar-widgets-wrap">
                    <div class="profile-box">
                        <div class="profile-name text-center topmargin-xs clearfix">{{$merchant->firstname}} {{$merchant->lastname}}</div>
                        <div class="email-profile text-center topmargin-xs clearfix"><strong><i class="icon-envelope"></i></strong>   {{$merchant->email}}</div>
                        <div class="mobile-profile text-center topmargin-xs bottommargin-xs clearfix"><strong><i class="icon-mobile"></i></strong> {{$merchant->phone}}</div>
                    </div>

                    <div class="widget account-linksbox clearfix">
                        <ul class="profile-account-pagelist nobottommargin">
                            <li><a href="{{route('veestoresTutorial')}}"> Tutorial</a></li>
                            @if(Session::get('merchantstorecount') >0)				
                            <li><a href="http://{{$merchant->my_Store}}"> Go to My Store</a></li>
                            <li><a href="http://{{$merchant->my_Store_admin}}">Go to My Store Admin</a></li>
                            @endif
                            <li><a href="#">Edit Profile</a></li>
                            <li><a href="{{route('veestoresChangePassword')}}">Change Password</a></li>
                            <li><a href="{{ route('veestoresLogout') }}">Logout</a></li>  
                        </ul>
                    </div>

                </div>
            </div><!-- .sidebar end -->
            <!-- Post Content
            ============================================= -->
            <div class="postcontent nobottommargin col_last" id="myprofile">
                <div class="col_full"> <span id="profileUpdate" style="color: #1B2987"></span> </div>
                <div class="profile-content">
                    <div class="account-heading">
                        <h2>Edit Profile</h2>
                    </div>
                    <div class="contact-widget">

                        <form id="editProfileForm" action="{{ route('veestoresUpdateProfile') }}"  method="post" class="nobottommargin">
                            <div class="col_half">
                                <input type="text"  name="firstname" value="{{$merchant->firstname}}" class="sm-form-control" placeholder="Your First Name">
                                <b><span id="firstname_editProfileform" class="newerror"></span></b>
                            </div>
                            <div class="col_half col_last">
                                <input type="text" name="lastname" value="{{$merchant->lastname}}" class="sm-form-control" placeholder="Your Last Name">
                            </div>
                            <div class="col_half">
                                <input type="email" name="email" value="{{$merchant->email}}" class="sm-form-control" placeholder="Your Email Id" {{$merchant->email?'readonly':''}}>
                            </div>
                            <div class="col_half col_last">
                                <input type="number" name="phone" value="{{$merchant->phone}}" class="sm-form-control" placeholder="Your Mobile" maxlength="10" {{$merchant->phone?'readonly':''}}>
                            </div>
                            <div class="clear"></div>
                            <center>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <button class="button nomargin" value="submit">Update</button>
                                </div>
                            </center>
                        </form>
                    </div>
                </div><!-- .postcontent end -->
            </div>

        </div>

    </div>

</section><!-- #content end -->

@stop

@section('myscripts')
<script>
    jQuery.validator.addMethod("phonevalidate", function (phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, "");
        return this.optional(element) || (phone_number.length > 9 && phone_number.length < 11) &&
                phone_number.match(/^[\d\-\+\s/\,]+$/);
    }, "Please specify a valid phone number");

    $("#editProfileForm").validate({
        // Specify the validation rules
        rules: {
            firstname: "required",
            phone: {
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
        submitHandler: function (form) {
            $.ajax({
                type: $("#editProfileForm").attr('method'),
                url: $("#editProfileForm").attr('action'),
                data: $('#editProfileForm').serialize(),
                success: function (response) {
                    console.log(response['merchant']);
                    if (response['status'] == 'success') {
                        $('#profileUpdate').html(response['msg']);
                        $('#userProfile').html('Hello ' + response['user']['firstname'] + ' ' + response['user']['lastname'])
                    } else {
                        $('#profileUpdate').html(response['msg']);
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
            error.appendTo($("#" + name + "_editProfileform"));
        }
    });

</script>
@stop
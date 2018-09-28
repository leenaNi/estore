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
            <div class="sidebar nobottommargin sidbarCustomwidth">
                <div class="sidebar-widgets-wrap">

                    <div class="profile-box">
                        <div class="profile-name text-center topmargin-xs clearfix">{{$merchant->firstname}} {{$merchant->lastname}}</div>
                        <div class="email-profile text-center topmargin-xs clearfix"><strong><i class="icon-icon-envelope"></i></strong> {{$merchant->email}} </div>
                        <div class="mobile-profile text-center topmargin-xs bottommargin-xs clearfix"><strong><i class="icon-mobile"></i></strong> {{$merchant->phone}} </div>
                    </div>

                    <div class="widget account-linksbox clearfix">
                        <ul class="profile-account-pagelist nobottommargin">
                           <li><a href="{{route('veestoresTutorial')}}"> Tutorial</a></li>
                            @if(Session::get('merchantstorecount') >0)				
                            <li><a href="http://{{$merchant->my_Store}}"> Go to My Store</a></li>
                            <li><a href="http://{{$merchant->my_Store_admin}}">Go to My Store Admin</a></li>
                            @endif
                            <li><a href="{{ route('veestoreMyaccount') }}" >Edit Profile</a></li>
                            <li><a href="#">Change Password</a></li>
                            <li><a href="{{ route('veestoresLogout') }}">Logout</a></li>
                        </ul>
                    </div>

                </div>
            </div><!-- .sidebar end -->
            <!-- Post Content
            ============================================= -->
            <div class="postcontent nobottommargin col_last widthAuto">
                <div class="profile-content">
                    <div class="account-heading">
                        <h2>Change Password</h2>
                    </div>
                    <div class="contact-widget">
                        <form id="resetPasswordAccount" action="{{ route('veestoresUpdateChangePassword') }}" method="post" class="nobottommargin">
                            <div class="col_full"> <span id="passUpdate" style="color: #1B2987"></span> </div>
                            <div class="form-process"></div>
                            <div class="col_half">
                                <input type="text" name="phone" value="{{$merchant->phone}} " class="sm-form-control" placeholder="Mobile" readonly="">
                            </div>
                            <div class="col_half col_last">
                                <input type="password" name="old_password" value="" id="old_password" class="sm-form-control" placeholder="Current Password">
                            </div>
                            <div class="col_half">
                                <input type="password" name="password" id="password" value="" class="sm-form-control" placeholder="New Password">
                            </div>
                            <div class="col_half col_last">
                                <input type="password" name="conf_password" id="conf_password" value="" class="sm-form-control" placeholder="Confirm New Password">
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
            old_password: "Please enter current password",
            password: "Please enter password",
            conf_password: {
                required: "Please provide confirm password",
                equalTo: "Please enter confirm password same as password"

            }

        },
        submitHandler: function (form) {
            $.ajax({
                type: $(form).attr('method'),
                url: $(form).attr('action'),
                data: $(form).serialize(),
                success: function (response) {

                    if (response['status'] == 'error') {
                        $('#passUpdate').html(response['msg']);
                    } else if (response['status'] == 'nomatch') {
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
</script>
@stop
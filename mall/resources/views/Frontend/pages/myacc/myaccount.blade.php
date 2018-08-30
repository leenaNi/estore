@extends('Frontend.layouts.default')

@section('content')
<style>
    .orderReturnSelect{
        width:22%;
    }
</style>
<section id="page-title">
    <div class="container clearfix">
        <h1>My Account</h1>
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}">Home</a>
            </li>
            <li class="active">My Account</li>
        </ol>
    </div>
</section>
<!-- Content
            ============================================= -->
<section id="content">
    <div class="content-wrap">
        <div class="container clearfix">
            <div class="col-lg-3 margin-top-md">
                <div class="panel panel-default border-radiusNone">
                    <div class="panel-body">
                        <!-- <div class="testi-image profile-image"> 
                            
                          <center>
                             <img src="{{ ($user->profile)?asset('public/Frontend/images/')."/".$user->profile:asset('public/Frontend/images/default-profile.jpg') }}" alt="Profile Pic" draggable="false">
                          </center>
                        </div>-->
                        <div class="col-md-12 nobottommargin editprofchoose">
                            <h4 id="userProfile" class="mb15">{{$user->firstname}} <!--  {{$user->lastname}} --></h4> 
                            <div class="emailbox"><strong>Email:</strong> {{ @$user->email}}</div>
                            <div class="mobilebox"><strong>Mobile:</strong> {{ $user->telephone}}</div>
                            @if($feature['referral']==1)
                            <div class="mobilebox"><strong>Referral Code:</strong> {{ $user->referal_code}}</div>
                         @endif
                             @if($feature['loyalty']==1)                     
                             <div class="mobilebox"><strong>Loyalty:</strong> <span class="currency-sym"></span>  {{ number_format($user->cashback * Session::get('currency_val'),2) }}</div>
                       @endif
                        </div>
                        <?php if ($user->provider_id == 0) { ?>
                            <!--                <form method="post" action=" {{ route('updateProfileImage') }}" enctype="multipart/form-data" id="updateProfileImage">
                                              <div class="col-md-12 notopmargin bottommargin-sm">
                                                <input id="user_profile" name="user_profile" type="file" class="file-loading "> </div>
                                              <div class="col-md-12 bottommargin-xs editprofchoose">
                                                <button class="button nomargin update-profile " type="submit">Upload Profile</button>
                                              </div>
                                            </form>-->
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 margin-top-md">
                <div class="tabs tabs-justify tabs-bordered clearfix tabwhite nobottommargin" id="tab-2">
                    <ul class="tab-nav clearfix" role="tablist">
                        <li><a href="#tabs-1" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-1"> My Profile</a>
                        </li>
                        <li><a href="#tabs-2" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-3"> My Orders</a>
                        </li>
                        <li><a href="#tabs-3" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-4"> My Wishlist</a>
                        </li>
                        <li><a href="#tabs-4" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-2"> Change Password</a>
                        </li>
                    </ul>
                    <div class="tab-container">
                        <div class="tab-content clearfix" id="tabs-1">
                            <p class="update-success" style="color:green">  </p>
                            <div class="col_full nobottommargin"> <span id="profileUpdate" style="color: #1B2987"></span> </div>
                            <form class="nobottommargin" id="editProfileForm"  method="post" novalidate="novalidate">
                                <div class="col_half">
                                    <label for="template-contactform-name">First Name <small>*</small>
                                    </label>
                                    <input type="text" name="firstname" id="firstname" value="{{$user->firstname}}" class="sm-form-control">
                                    <b><div id="firstname_editProfileform" class="newerror"></div></b>
                                </div>
                                <div class="col_half col_last">
                                    <label for="template-contactform-name">Last Name </label>
                                    <input type="text" name="lastname" id="lastname" value="{{$user->lastname}}" class="sm-form-control"> 
                                </div>
                                <div class="col_half ">
                                    <label for="template-contactform-email">Email <small>*</small>
                                    </label>
                                    <input type="email" name="email" value="{{$user->email}}" class="email sm-form-control" {{$user->email?'readonly':''}}> 
                                </div>
                                <div class="col_half col_last">
                                    <label for="template-contactform-phone">Mobile <small>*</small>
                                    </label>
                                    <input type="text" id="telephone" name="telephone" value="{{$user->telephone}}" class="sm-form-control" readonly="">
                                    <b><div id="telephone_editProfileform" class="newerror"></div></b>
                                </div>


                                <div class="col_full noMobBottMargin nobottommargin">
                                    <button class="button nomargin">Update</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-content clearfix" id="tabs-4">
                            <p class="password-update-success" style="color:green">  </p>
                            <p class="password-update-fail" style="color:red">  </p>
                            <form class="nobottommargin ng-pristine ng-valid" action="{{ route('updateMyaccChangePassword') }}"  id="resetPasswordAccount" method="post" novalidate="novalidate">
                                <div class="col_full"> <span id="passUpdate" style="color: #1B2987"></span> </div>
                                <div class="col_full">
                                    <input type="hidden"  name="email" value="{{$user->email}}" readonly="readonly">
                                    <input type="hidden"  name="telephone" value="{{$user->telephone}}" readonly="readonly">
                                    <label for="template-contactform-name">CURRENT PASSWORD <small>*</small>
                                    </label>
                                    <input type="password" name="old_password" placeholder="Current Password" class="sm-form-control required" aria-required="true">
                                    <div id="old_password_validate" style="color:red;"></div>
                                </div>
                                <div class="col_full">
                                    <label for="template-contactform-name">NEW PASSWORD <small>*</small>
                                    </label>
                                    <input type="password" id="password" name="password" placeholder="New Password" class="sm-form-control required" aria-required="true">
                                    <div id="password_validate" style="color:red;"></div>
                                </div>
                                <div class="col_full">
                                    <label for="template-contactform-email">CONFIRM NEW PASSWORD <small>*</small>
                                    </label>
                                    <input type="password" name="conf_password" id="conf_password" placeholder="Confirm New Password" class="required sm-form-control" aria-required="true">
                                    <div id="conf_password_validate" style="color:red;"></div>
                                </div>
                                <div class="col_full">
                                    <button class="button button-3d nomargin changePassword" type="submit" name="template-contactform-submit" value="submit">SAVE</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-content clearfix" id="tabs-2" aria-labelledby="ui-id-3" role="tabpanel" aria-hidden="true" style="display: none;">
                            <div class="table-responsive">
                                <table class="table cart">
                                    <thead>
                                        <tr bgcolor="#F2F2F2">
                                            <th class="text-center">Order ID</th>
                                            <th class="text-center">Order Amount</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($orders) > 0)
                                        @foreach($orders as $ord)  
                                        <?php
                                        if ($ord->currency_id != Session::get('currency_id')) {
                                            $ordCurrency = DB::table('has_currency')->where('id', Session::get('currency_id'))->first();
                                        } else {
                                            $ordCurrency = DB::table('has_currency')->where('id', $ord->currency_id)->first();
                                        }
                                        ?>
                                        <tr>
                                            <td class="tdfont text-center">{{$ord->id}}</td>
                                            <td class="tdfont text-center"><span class="currency-sym"></span>  {{number_format(($ord->pay_amt*$ordCurrency->currency_val), 2, '.', '')}}</td>
                                            <td class="tdfont text-center">{{date("d-M-Y",strtotime($ord->created_at))}} </td>
                                            <td data-th="Subtotal" class="text-center">
                                                <a href="{{route('orderDetails',$ord->id)}}" class="button button-3d button-mini button-rounded ">View Detail</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="4">No order found.</td>
                                        </tr>
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-content clearfix" id="tabs-3" aria-labelledby="ui-id-3" role="tabpanel" aria-hidden="true" style="display: none;">
                            <div class="table-responsive">
                                <table class="table cart">
                                    <thead>
                                        <tr bgcolor="#F2F2F2">
                                            <th class="cart-product-thumbnail">&nbsp;</th>
                                            <th class="cart-product-name">Product</th>
                                            <th class="cart-product-price">Price</th>
                                            <th class="cart-product-quantity">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($wishlist) > 0)
                                        @foreach($wishlist as $prod)
                                        <tr class="cart_item">

                                            <td class="cart-product-thumbnail">
                                                @if(($prod->image_path) != '')

                                                <a href="{{route('home').'/'.$prod->url_key}}"><img width="64" height="64" src="{{$prod->image_path }}" alt="img">
                                                </a>
                                                @else
                                                <a href="#"><img width="64" height="64" src="{{ asset(Config('constants.defaultImgPath').'default-product.jpg') }}" alt="img">
                                                </a>
                                                @endif
                                            </td>
                                            <td class="cart-product-name"> <a href="{{route('home').'/'.$prod->url_key}}">{{$prod->product}}</a> </td>
                                            <td class="cart-product-price">
                                                @if($prod->spl_price > 0 && $prod->spl_price < $prod->price)
                                                <div class="product-price">
                                                    <del><span class="currency-sym"></span> {{number_format($prod->price * Session::get('currency_val'), 2, '.', '')}}</del> <span class="currency-sym"></span> {{number_format($prod->spl_price * Session::get('currency_val'), 2, '.', '')}} 
                                                </div> 

                                                @else
                                                <div class="product-price">
                                                    <span class="currency-sym"></span> {{number_format($prod->price * Session::get('currency_val'), 2, '.', '')}}
                                                </div> 
                                                @endif
                                            </td>
                                            <td class="cart-product-remove"> <a href="javascript:void(0)" data-prodId="{{$prod->id}}" class="remove removeWishlist" title="Remove this item"><i class="icon-trash2 fa-2x"></i></a> </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr class="cart_item"><td colspan="4">No record found.</td></tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop
@section("myscripts")

<script>
    $(document).on("click", '.closeModal', function () {
        $(".viewDetailModal").modal("hide");
    })
    $(document).ready(function () {
        jQuery.validator.addMethod("phonevalidate", function (phone_number, element) {
            phone_number = phone_number.replace(/\s+/g, "");
            return this.optional(element) || (phone_number.length > 9 && phone_number.length < 11) &&
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
            submitHandler: function (form) {
                $.ajax({
                    type: $("#editProfileForm").attr('method'),
                    url: '{{ route('updateProfile') }}', //$("#editProfileForm").attr('action'),
                    data: $('#editProfileForm').serialize(),
                    success: function (response) {
                        console.log(response['user']);
                        if (response['status'] == 'success') {
                            $('#profileUpdate').html(response['msg']);
                            $('#userProfile').html('Hello ' + response['user']['firstname'] + ' ' + response['user']['lastname']);
                            $('.emailbox').html('<strong>Email:</strong> ' + response['user']['email']);
                        } else {
                            $('#profileUpdate').html("<span style='color:red;'>"+response['msg']+"</span");
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
    });

    $(document).on("click", '.removeWishlist', function () {
//        $(this).closest('tr').remove();
//        return false;
        //alert("sdf");
        var current = $(this);
        var prodId = current.attr("data-prodId");
        //   alert(prodId);
        //alert("fdsfsadf");
        $.ajax({
            url: "{{ route('removeWishlist') }}",
            type: 'post',
            data: {prodid: prodId},
            success: function (res) {
                // if(res==0)
                current.closest('tr').remove();
//                $('#firstname').text(res[0].firstname);
//                $('#lastname').text(res[0].lastname);
//                $('#telephone').text(res[0].telephone);
//                $('.update-success').text("Profile updated successfully");
                //  alert(JSON.stringify(res));
                //  window.location.href = "";
            }
        });
        return false;
    });



    $("#resetPasswordAccount").validate({
        // Specify the validation rules
        rules: {
            old_password: "required",
         
              password: {
                required: true,
                minlength: 6
            },
            conf_password: {
                required: true,
                minlength: 6,
                equalTo: "#password"
            }

        },
        messages: {
            old_password: "Please enter current password",
            password:{
            password: "Please enter password",
            minlength: "Your password must be at least 6 characters long"
             },
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

    $('html body').on('submit', '#updateProfileImage', function () {

        //alert("fdsfsadf");
        $.ajax({
            url: "{{ route('updateProfileImage') }}",
            type: 'post',
            data: new FormData(this),
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            beforeSend: function () {
                $(".changePassword").attr("disabled", "disabled");
            },
            success: function (res) {
//                if(res['status']=='success'){
//                 $('.password-update-success').text(res['msg']);   
//             }else{
//                  $('.password-update-fail').text(res['msg']);   
//             }  
//                $('#firstname').text(res[0].firstname);
//                $('#lastname').text(res[0].lastname);
//                $('#telephone').text(res[0].telephone);
//                $('.password-update-success').text("Profile updated successfully");
                //  alert(JSON.stringify(res));
                window.location.href = "";
            }
        });
        return false;
    });

</script>
@stop
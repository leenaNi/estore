@extends('Frontend.layouts.default')
@section('content')
<section id="slider" class="full-screen dark newStoreSlider" style="background: url('{{ asset(Config('constants.frontendPublicImgPath').'/static.jpg') }}') center center no-repeat; background-size: cover" style="height:820px !important;">
    <div class="">
        <div class="container vertical-middle clearfix">
            @if(!empty(Session::get('message')))
            <div class="alert alert-danger" role="alert">
                {{ Session::get('message') }}
            </div>
            @endif
            <form action="{{route('selectThemes')}}" method="post" id='newStoreForm' role="form" class="landing-wide-form clearfix newStoreForm reg-form">
                <div class="">
                    <div class="col_full bottommargin-xs customTab">
                        <div class="tab">
                            <label>
                                <input type="radio" id="merchants" name="storeType" value="merchant" checked>
                                <span class="selection">Merchant</span>
                            </label>
                            <label>
                                <input type="radio" id="distributor" name="storeType" value="distributor">
                                <span class="selection">Distributor</span>
                            </label>
                        </div>
                    </div>
                    <div class="col_full bottommargin-xs"> 
                        <div class="customDomainfield">
                            <div class="input-group custom-inputGroup">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">https://</span>
                                </div>
                                <input type="text" class="form-control custom-formControl required checkAvailability"  value="" name="domain_name" id="domain_name" placeholder="Domain Name (Cannot be changed later)">
                                <div class="input-group-append">
                                    <?php $hname = "." . str_replace("www", "", $_SERVER['HTTP_HOST']);?>
                                    <span class="input-group-text">{{ str_replace("..",".",$hname)  }}</span>
                                </div>
                            </div>
                            <span class="checkAvail"><i class="fa fa-clock availCL"></i></span>
                        </div>
                    </div>
                    <div class="col_half bottommargin-xs">
                        <input type="text" class="sm-form-control stName" required="true" id="store_name" name="store_name" value=""  placeholder="Store Name * (don't worry you can change it later)">
                    </div>
                    <div class="col_half  col_last bottommargin-xs">
                        <input type="text" class="sm-form-control"   required="true" id="first_name" name="firstname" value="{{Session::get('merchantName')}}"  placeholder="First Name *" >
                    </div>
                    <div class="col_half bottommargin-xs">
                        <select class="sm-form-control county_code" required="true" name="country_code">
                            <option value="">Select Country Code</option>
                            <option value="+91">(+91) India</option>
                            <option value="+880">(+880) Bangladesh</option>
                        </select>
                          <span id="country_code_re_validate"></span>
                    </div>
                    <div class="col_half col_last bottommargin-xs">
                        <input type="text" class="sm-form-control telephone"  required="true" id="telephone" name="phone" value="" placeholder="Mobile *">
                    </div>
                    <div class="col_half bottommargin-xs">
                        <input type="email" class="sm-form-control email"   name="email" id="email" value="{{Session::get('merchantEmail')}}" placeholder="Email" {{Session::get('merchantEmail')?'readonly':''}}>
                        <span id="email_re_validate"></span>
                    </div>
                    <div class="col_half col_last bottommargin-xs">
                        <select class="sm-form-control" name="currency" required="true">
                            <option value="">Store Currency *</option>
                            @foreach($curr as $cur)
                            <option value="{{$cur->id}}">{{ $cur->currency_code." - ".ucwords(strtolower($cur->name)) }}</option>
                            @endforeach
                        </select>
                    </div>
                    @if(empty(Session::get("fbId")))
                    <div class="col_half  bottommargin-xs">
                        <input type="password" class="sm-form-control" id='password'  required="true"  name="password" id="password" value="" placeholder="Password *">
                        <span id="password_re_validate"></span>
                    </div>
                    <div class="col_half col_last  bottommargin-xs">
                        <input type="password" class="sm-form-control" name="cpassword" id="cpassword1" value="" placeholder="Confirm Password *">
                        <span id="cpassword_re_validate"></span>
                    </div>
                    @else
                    <input type="hidden" name="provider_id" value="{{Session::get("fbId")}}">
                    @endif
                    <div class="col_half bottommargin-xs" id="divForMerchant">
                        {{ Form::select('m_business_type[]',$cat,'',['id'=>'m_business_type','class'=>'sm-form-control select-box-alsell busType','required'=>'true']) }}
                       
                    </div>
                    <div class="col_half bottommargin-xs" id="divForDistributor" style="display: none;">
                        <select id="d_business_type"  name="d_business_type[]" class="selectpicker sm-form-control select-box-alsell busType" multiple required="true">
                        @foreach($cat as $catId=>$catName)
                        <option value="{{$catId}}">{{$catName}}</option>
                        @endforeach
                        </select>

                        {{-- {{ Form::select('business_type[]',$cat,'',['id'=>'business_type','class'=>'selectpicker sm-form-control select-box-alsell busType','required'=>'true']) }} <!--, 'noneSelectedText'=>'Top'--> --}}
                    </div>
                    <div class="col_half col_last  bottommargin-xs" id="storeOptionDiv">
                        <select class="selectpicker sm-form-control select-box-alsell" multiple required="true" name="already_selling[]">
                            <option value="Just checking out features">Just checking out features</option>
                            <option value="Have retail store">Have retail store</option>
                            <option value="Have online store">Have online store</option>
                            <option value="Selling on facebook">Selling on facebook</option>
                        </select>
                    </div>
                    <div class="col_full bottommargin-xs" id="storeVersionDiv">
                        <select class="sm-form-control" required="true" name="store_version">
                            <option value="1">Starter Version - a simple online store with minimum features activated (FREE)</option>
                            <option value="2">Advanced Version - a complex online store with highend features activated (FREE)</option>
                        </select>
                    </div>
                </div>
                <div class="clear"></div>
                <p class="text-center topmargin-xs bottommargin-xs">By registering, you agree to our <a href="/terms-condition" target="_blank">Terms &amp; Condition</a> <!-- | <a href="#">Privacy Policy</a> -->
                </p>
                <input type="hidden" name="storename" value="{{ Session::get('storename') }}">
                <input type="hidden" name="company_name" value="estorifi">
                <input type="hidden" name="business_name" value="" id="bussiness_name">
                <input type="button" class="btn btn-default theme-btn btn-block nomargin reg-sub-btn sendOtpOnMobile" value="Send OTP on Mobile" >
               <!--<input type="submit" class="btn btn-default theme-btn btn-block nomargin reg-sub-btn " value="Submit & Continue" >-->
            </form>
            <div class="col_full nobottommargin">
                <!-- Modal -->
                <div class="modal fade otpPopup" id="sendOTP" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-body">
                            <div class="modal-content">
                                <div class="modal-header no-bot-border">
                                    <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="myModalLabel">Verify Your Mobile</h4>
                                </div>
                                <div class="modal-body">
                                    <form id="otpForm">
                                        <div class="col-md-12"><p>Enter the OTP that we have sent to your mobile number.</p></div>
                                        <div class="col-md-12 bottommargin-sm">
                                            <input type="text" class="sm-form-control otpTxt" value="" name="input_otp" placeholder="Enter OTP here">
                                        </div>
                                        <div class="col-md-12 bottommargin-sm"><a href="javascript:void(0);">Didn't receive OTP? Resend it.</a></div>
                                        <div class="col-md-12 otpBtn">
                                            <input type="button" class="btn btn-default theme-btn registerAndSubmit" id="registerAndSubmit" value="Submit &amp; Register"></div>
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop
@section('myscripts')
<script>
    
    $('#store_name').keyup(function(){
        var storeName = this.value;
        if(storeName != '')
        {
            storeName = storeName.replace(/[^a-zA-Z0-9 ]/g, "").split(" ").join("").toLowerCase();
            $("#domain_name").val(storeName);
        }
    })

    $('.busType').change(function(){
        var bname = $('.busType option:selected').html();
        $('#bussiness_name').val(bname);
    })

//    function checkAvailability(){
//       if($(this).hasClass('error') == true){
//
//           $(".availCL").removeClass("icon-ok green-ok");
//           $(".availCL").addClass("icon-remove red-close");
//       }else{
//             console.log('false madhe');
//            $(".availCL").removeClass("icon-remove red-close");
//           $(".availCL").addClass("icon-ok green-ok");
//       }
//    }
//    jQuery.validator.addMethod("specialChrs", function (element, value) {
//            return new RegExp('^[a-zA-Z0-9 ]+$').test(value)
//        }, "Special Characters not permitted");


    $('input[type=radio][name=storeType]').change(function(){
        var seletedUserType = this.value;
        $("#business_type").val('');
        if(seletedUserType == 'distributor'){
            $("#storeOptionDiv").hide();
            $("#storeVersionDiv").hide();
            $("#divForDistributor").show();
            $("#divForMerchant").hide();
            $("#newStoreForm").attr("action","{{route('distributorSignup')}}");
        }
        else if(seletedUserType == 'merchant'){
            $("#storeOptionDiv").show();
            $("#storeVersionDiv").show();
            $("#divForDistributor").hide();
            $("#divForMerchant").show();
            $("#newStoreForm").attr("action","{{route('selectThemes')}}");
        }
    });

    jQuery.validator.addMethod("phone", function (phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, "");
        return this.optional(element) || phone_number.length > 4 &&
                phone_number.match(/^[\d\-\+\s/\,]+$/);
    }, "Please specify a valid phone number");


//      jQuery.validator.addMethod("noSpace", function(value, element) {
//  return value.indexOf(" ") < 0 && value != "";
//}, "No space please and don't leave it empty");
    jQuery.validator.addMethod("specialChrs", function (value, element) {
        return this.optional(element) || /^[a-z0-9-_]+$/.test(value);
    }, "Invalid Domain Name.");

    $("#newStoreForm").validate({
        
        // Specify the validation rules
        rules: {
            firstname: {
                required: true
            }, store_name: {
                required: true
            },currency:{
                 required: true
            },
            email: {
                email: true,
                remote: function () {
                    var emal = $('.email').val().replace(/\s/g, '');
                    var storeType = $("input[name='storeType']:checked"). val();
                  
                    var r = {
                        url: "{{route('checkExistingUser')}}",
                        type: "post",
                        cache: false,
                        data: 
                        {
                            email: emal,
                            storeType: storeType
                        },
                        dataFilter: function (response) {
                            
                            if (response == 1)
                                return false; //return true or false
                            else
                                return true;
                        }
                    };
                    return r;
                }
            },
            phone: {
                required: true,
                phone: true,
                remote: function () {
                    var tele = $('.telephone').val().replace(/\s/g, '');
                    var storeType = $("input[name='storeType']:checked"). val();
                    var r = {
                        url: "{{route('checkExistingphone')}}",
                        type: "post",
                        cache: false,
                        data: 
                        {
                            phone_no: tele,
                            storeType: storeType
                        },
                        dataFilter: function (response) {
                            if (response == 1)
                                return false; //return true or false
                            else
                                return true;
                        }
                    };
                    return r;
                }
            }, password: {
                required: true
            },
            cpassword: {
                required: true,
                equalTo: "#password"
            }, business_type: {
                required: true
            },country_code:{
                 required: true
            },already_selling: {
                required: true
            }, domain_name: {
                required: true,
                specialChrs: true,
                onkeyup: function (element) {
                    $(".availCL").removeClass("icon-clock icon-ok green-ok icon-remove red-close");
                    if ($(element).val() == '') {

                        $(".availCL").addClass("icon-clock");
                    } else {
                        if ($(element).hasClass('error') == true) {
                            $(".availCL").removeClass("icon-ok green-ok");
                            $(".availCL").addClass("icon-remove red-close");
                        } else {
                            $(".availCL").removeClass("icon-remove red-close");
                            $(".availCL").addClass("icon-ok green-ok");
                        }
                    }
                },
                remote: function () {
                    var domainNm = $('.checkAvailability').val().replace(/\s/g, '');
                    var r = {
                        url: "{{route('checkDomainAvail')}}",
                        type: "post",
                        cache: false,
                        data: {domain_name: domainNm},
                        dataFilter: function (response) {
                            if (response == 1)
                                return false; //return true or false
                            else
                                return true;
                        }
                    };
                    return r;
                }
            }
        },
        messages: {
            firstname: {
                required: "First Name is required."
            },
            store_name: {
                required: "Store Name is required."
            },currency: {
                required: "Currency is required."
            },
            phone: {
                required: "Mobile is required.",
                remote: "Mobile already in use."

            }, password: {
                required: "Password is required"
            }, country_code: {
                required: "Country code is required"
            },
            email: {
                email: "Email should be valid.",
                remote: "Email already in use."
            },
            cpassword: {
                required: "Confirm Password is required."
            }, business_type: {
                required: "Industry is required."
            }, already_selling: {
                required: "This field is required."
            }, domain_name: {
                required: "Domain Name is required.",
                remote: "Domain Name already in use."
            }
        },
        errorPlacement: function (error, element) {
            //   checkAvailability();
            if ($(element).attr('name') == 'domain_name') {
                $(element).parent().after(error);
            } else {
                $(element).after(error);
            }
        }
    });

    $(".sendOtpOnMobile").on("click", function () {
       
        //$("#newStoreForm").submit();
        
       if ($("#newStoreForm").valid()) {
            $("#sendOTP").modal('show');
            var country=$('.county_code').val();
            var mobile= $('.telephone').val();
            //  alert(country + '' +mobile);
            $.ajax({
                type: 'POST',
                url: "{{route('sendOpt')}}",
                data: {mobile: mobile,country:country},
                success: function (response) {
                    console.log('@@@@' + response['otp']);
                    if (response['status'] == 'success') {
                            $('.sendOtpOnMobile').html('<label class="error">' + response['msg'] + '</label>');
                    } else if (response['status'] == 'fail') {
                    }
                },
                error: function (e) {
                    console.log(e.responseText);
                }
            });
        }
    });

//    $("#otpForm").validate({
//        // Specify the validation rules
//        rules: {
//            input_otp: {
//                required: true
//            }
//
//        },
//        messages: {
//            input_otp: {
//                required: "OTP is required."
//            }
//        },
//        errorPlacement: function (error, element) {
//            $(element).after(error);
//
//        }
//    });
//$(document).ready(function() {
//
//
//$("#registerAndSubmit").validate({
//        rules: {
//            input_otp: {
//                required: true,
//                remote: function () {
//                    var otp = $('input[name="input_otp"]').val().replace(/\s/g, '');
//                    var r = {
//                        url: "{{route('checkOtp')}}",
//                        type: "post",
//                        cache: false,
//                        data: {inputotp:otp},
//
//                        dataFilter: function (response) {
//                            if (response == 2) {
//                                return false;
//                            } else if (response == 1) {
//                                return true;
//                            }
//                        }
//                    };
//                    return r;
//                }
//
//
//            }
//        },
//        messages: {
//            input_otp: {
//                required: "Otp is required.",
//                remote: "Invalid otp."
//            }
//        },
//        submitHandler: function (form) { // for demo
//         $("#newStoreForm").submit();
//
//        },
//        errorPlacement: function (error, element) {
//            var elename = $(element);
//            elename.parent().after(error);
//        }
//    });
//});
    $(".registerAndSubmit").on("click", function () {
        $("input[name='input_otp']").find("label").remove();
        $("input[name='input_otp']").removeClass('error');
        var otp = $('input[name="input_otp"]').val().replace(/\s/g, '');
        console.log("dasdassa" +otp);
        if ($("#otpForm").valid()) {
            $.ajax({
                type: 'POST',
                url: "{{route('checkOtp')}}",
                data: {inputotp: otp},
                success: function (response) {
                console.log("response" +response);
                    if (response==otp) {
                        $("#newStoreForm").submit();
                    } else  {
                        $("input[name='input_otp']").find("label").remove();
                        $("input[name='input_otp']").addClass('error');
                        $("input[name='input_otp']").after("<label class='error'>Invalid OTP. </label>");
                    }
                },
                error: function (e) {
                    console.log(e.responseText);
                }
            });
        }
    });

    function toTitleCase(str) {
        return str.replace(/(?:^|\s)\w/g, function (match) {
            return match.toUpperCase();
        });
    }

    function toLowerCase(str) {
        return str.replace(/(?:^|\s)\w/g, function (match) {
            return match.toLowerCase();
        });
    }

    $(".stName").on("keyup", function () {
        $(this).val(toTitleCase($(this).val()));
    });


    $(".availCL").addClass('icon-clock');
    $("input[name='domain_name']").on("keyup", function () {
        myinpt = $(this).val();
        if (myinpt.length <= 0) {
            $(".availCL").addClass('icon-clock');
        } else {
            $(".availCL").removeClass('icon-clock');
        }
        //  console.log(myinpt);
        $(this).val(myinpt.toLowerCase());
    });
</script>

@stop

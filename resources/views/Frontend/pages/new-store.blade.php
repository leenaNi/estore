@extends('Frontend.layouts.default')
@section('content')
	
	<!--==========================
	    step1 Section starts
	  ============================-->
	<section class="steps-section">
		<div class="vert-middle-container" id="step1">
			<div class="container">
				<div class="log-reg-form-container">
					<div class="row">
						<div class="col-md-5 description sh h-100">
							<div class="description-content">
								<div class="logo">
									<img src="{{ asset('public/Frontend/images/logo.svg')}}">
								</div>
								<div class="title">
									<h3>Let’s create your account</h3>
								</div>
								<div class="desc-box">
									<p>Just a few things to get you going</p>
								</div>
							</div>
						</div>
						<div class="col-md-7 form-fields sh h-100">
							<div class="form-holder">
								<form method="post" action="{{route('selectThemes')}}" id="createStore">
								<input type="hidden" name="currency_code" value="{{$settings->currency_id}}" />
								<div class="">
									<div class="scroller-y">
										<div class="form-group">
											<label>Business Name <!--<span class="mand">*</span>--></label>
											<div class="input-group">
												<input type="text" class="form-control" name="store_name" id="store_name" placeholder="Business Name">
												<span>
													<img src="{{ asset('public/Frontend/images/success-tick.svg')}}" alt="success"/ class="success-tick">
													<img src="{{ asset('public/Frontend/images/wrong-input.svg')}}" alt="success"/ class="error-mark hidden">
												</span>
												<input type="hidden" class="form-control custom-formControl required checkAvailability"  value="" name="domain_name" id="domain_name" placeholder="Domain Name (Cannot be changed later)">
											</div>
											<span class="error" style="display:none" id="business_name_err">Business name can not be blank</span>
										</div>
										
										<div class="form-group">
											<label for="">Mobile Number</label>
											<div class="mob-num-ctcode">
												<div class="ct-select">
													<select name="country_code" id="country_code">
                                                    <option value="{{$settings->country_code}}" selected data-image="{{ asset('public/Frontend/images/india.png')}}">{{$settings->country_code}}</option>
														
													</select>
												</div>
												<div class="input-group">
													<input type="text" name="phone" class="form-control" id="mobNumber" placeholder="Mobile Number">
													
													<span>
														<img src="{{ asset('public/Frontend/images/success-tick.svg')}}" alt="success" class="success-tick hidden">
														<img src="{{ asset('public/Frontend/images/wrong-input.svg')}}" alt="success" class="error-mark">
													</span>
												</div>
											</div>
										
											<span class="error" style="display:none" id="mobileno_err">Please enter valid mobile number</span>
										</div>
										<div class="form-group">
											<label for="">Who are you?</label>
											<div class="role-radio-group">
												<ul>
													<li>
														<input type="radio" name="roleType"  id="merchant" value="merchant" class="input-hidden" checked />
														<label for="merchant"> 
															<img src="{{ asset('public/Frontend/images/merchant-grey.svg')}}" alt="merchant" class="dective-merchant" />
															<img src="{{ asset('public/Frontend/images/merchant.svg')}}" alt="merchant" class="active-merchant" />
															<span>Merchant</span>
														</label>
													</li>
													<li>
														<input type="radio" name="roleType" id="distributor" value="distributor" class="input-hidden" />
														<label for="distributor"> 
															<img src="{{ asset('public/Frontend/images/distributor-grey.svg')}}" alt="distributor" class="dective-distributor" />
															<img src="{{ asset('public/Frontend/images/distributor.svg')}}" alt="distributor" class="active-distributor" />
															<span>Distributor</span>
														</label>
													</li>
												</ul>
											</div>
										</div>
									</div>
</div>
										<div class="form-group text-center">
											<p>By registering with us, you accept our <a href="#">Terms & Conditions.</a></p>
										</div>

										<div class="form-group text-center mb-0">
											<button type="button" class="theme-btn dark-theme-btn full-width-btn" id="nextstep">Next</button>
										</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
         <!-- otp verify -->
        <div class="vert-middle-container" id="step2" style="display:none">
			<div class="container">
				<div class="log-reg-form-container">
					<div class="row">
						<div class="col-md-5 description sh h-100">
							<div class="description-content">
								<div class="logo">
									<img src="{{ asset('public/Frontend/images/logo.svg')}}">
								</div>
								<div class="title">
									<h3>OTP Verification</h3>
								</div>
								<div class="desc-box">
									<p>Enter the 4-digit code sent to</p>
									<p id="mobno">+91 8923412310</p>
								</div>
								<div class="link">
									<a href="#" id="backbtn"><img src="{{ asset('public/Frontend/images/left-arrow-preview.svg')}}" class="changeno-arrow"/> Change Number</a>
								</div>
							</div>
						</div>
						<div class="col-md-7 form-fields sh h-100">
							<div class="form-holder">
								<form action="" >
									<div class="">
									<div class="scroller-y">
										<div class="form-group">
											<label for="">Type in your OTP</label>
											<div class="input-group input-otp-group">
												<input type="tel" max="1" class="form-control col" id="otp1" placeholder="">
												<input type="tel" max="1" class="form-control col" id="otp2" placeholder="">
												<input type="tel" class="form-control col" id="otp3" placeholder="">
												<input type="tel" class="form-control col" id="otp4" placeholder="">
												
											</div>
											<span class="error otperr">Please enter valid OTP</span>
										</div>
										
									</div>
</div>
										<div class="form-group text-center">
											<button type="button" id="registerAndSubmit" class="theme-btn dark-theme-btn full-width-btn">Submit</button>
										</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<script>
$("#nextstep").click(function(){
    if($("input[name=store_name]").val() == '' && $("input[name=phone]").val() == '')
    {
        $("#business_name_err").show();
        $("#mobileno_err").show();
    }  
    else if($("input[name=store_name]").val() == ''){
        $("#business_name_err").show();
        $("#mobileno_err").hide();
    }
    else if($("input[name=phone]").val() == ''){
        $("#mobileno_err").show();
        $("#business_name_err").hide();
    }
    else{
        $("#business_name_err").hide();
        $("#mobileno_err").hide();
        $("#step2").show();
        $("#step1").hide();
        var country=$('#country_code').val();
        var mobile= $("input[name=phone]").val();
		$("#mobno").html(mobile);
        //  alert(country + '' +mobile);
        $.ajax({
            type: 'POST',
            url: "{{route('sendOpt')}}",
            data: {mobile: mobile,country:country},
            success: function (response) {
                console.log('@@@@' + response['otp']);
                if (response['status'] == 'success') {
                        $('.otperr').html('<label class="error">' + response['msg'] + '</label>');
                } else if (response['status'] == 'fail') {
                }
            },
            error: function (e) {
                console.log(e.responseText);
            }
        });
    }
    
});
$("#backbtn").click(function(e){
    $("#step2").hide();
    $("#step1").show();
});

$('input[type=radio][name=roleType]').change(function(){
        var seletedUserType = this.value;
        //alert(seletedUserType);
        if(seletedUserType == 'distributor'){
            $("#createStore").attr("action","{{route('distributorSignup')}}");
        }
        else if(seletedUserType == 'merchant'){
            
            $("#createStore").attr("action","{{route('selectThemes')}}");
        }
});

$('#store_name').keyup(function(){
        var storeName = this.value;
        if(storeName != '')
        {
            storeName = storeName.replace(/[^a-zA-Z0-9 ]/g, "").split(" ").join("").toLowerCase();
            $("#domain_name").val(storeName);
        }
    });

$("#registerAndSubmit").on("click", function () {
        $(".otperr").find("label").remove();
        $(".otperr").removeClass('error');
        var otp = $("#otp1").val()+$("#otp2").val()+$("#otp3").val()+$("#otp4").val();
        console.log(otp);
        //console.log("otp" +otp);
            $.ajax({
                type: 'POST',
                url: "{{route('checkOtp')}}",
                data: {inputotp: otp},
                success: function (response) {
                    if (response==otp) {
                        $("#createStore").submit();
                    } else  {
                        $(".otperr").find("label").remove();
                        $(".otperr").removeClass('error');
                        //$("input[name='input_otp']").addClass('error');
                        $("input[name='input_otp']").after("<label class='error'>Invalid OTP. </label>");
                    }
                },
                error: function (e) {
                    console.log(e.responseText);
                }
            });
});
</script>
@stop
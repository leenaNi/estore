@extends('Frontend.layouts.default')
@section('content')
<!--==========================
	    step1 Section starts
	  ============================-->
      <section class="settingup-section auto-height">
		<div class="vert-middle-container not-vert-mob">
		<div class="container h-100">
	      	<div class="row">
		        <div class="col-md-7 intro-info">
					<div class="setup-img">
						<img src="{{ asset('public/Frontend/images/like.png')}}" alt=""> 
					</div>
		          	<h1>Congratulations!</h1>
                      <p class="mb-30">Your Online Store is ready to use.</p>
                    <div class="setup-onlinestore-box">
                        <div class="setup-box">
                            <a href="{{$storedata->store_domain}}">
                                <div class="img-holder">
                                    <img src="{{ asset('public/Frontend/images/setup.png')}}" alt=""> 
                                </div>
                                <div class="content-holder">
                                    <h5>Setup</h5>
                                    <p>Manage Products, Orders, etc. of your Online Store</p>
                                </div>
                                <div class="right-arrow">
                                    <img src="{{ asset('public/Frontend/images/setup-right-arrow.png')}}" alt=""> 
                                </div>
                            </a>

                        </div>
                        <div class="online-box">
                            <a href="{{$storedata->store_domain}}">
                                <div class="img-holder">
                                    <img src="{{ asset('public/Frontend/images/shopping-online.png')}}" alt=""> 
                                </div>
                                <div class="content-holder">
                                    <h5>Online Store</h5>
                                    <p>E-Commerce website where your customers will shop</p>
                                </div>
                                <div class="right-arrow">
                                    <img src="{{ asset('public/Frontend/images/setup-right-arrow.png')}}" alt=""> 
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="app-btn-links">
                        <p>Manage your Store at your fingertips</p>
                        <div class="app-btn-links-btns">
                            <a href=""><img src="{{ asset('public/Frontend/images/google-play.png')}}" alt=""> </a>
                            <a href=""><img src="{{ asset('public/Frontend/images/ios.png')}}" alt=""> </a>
                        </div>
                    </div>
		          	<!-- <div class="button-center-align">
					  <a href="{{$storedata->store_domain}}" class="theme-btn dark-theme-btn">Go to your Online Store</a>
					  <a href="{{$storedata->store_domain}}/admin" class="theme-btn dark-theme-btn">Let's setup your Store</a>
					</div>
					<div class="store-links">
						<p>Store Admin Link</p>
						<a target="_blank" href="{{$storedata->store_domain}}/admin">{{$storedata->store_domain}}/admin</a>
                        @if($storedata->store_type == 'merchant')
						<p>Online Store Link</p>
						<a target="_blank" href="{{$storedata->store_domain}}">{{$storedata->store_domain}}</a>
                        @endif
						<p>To manage your online store, click on the Store Admin link or download eStorifi Merchant app and login with the same credentials used to create the store.</p>
						<a href="#" class="download-app-btn"><img src="{{ asset('public/Frontend/images/download-app.png')}}" alt=""> </a>
					</div> -->
		        </div>
			</div>
		</div>
		</div>
	</section>
	
	  <!--==========================
	      step1 Section ends
	    ============================-->
@stop

@section('myscripts')
<script>
    $(document).ready(function(){
        var storeType = '<?= $storedata->store_type ?>';
        var merchantId = '<?= $storedata->merchant_id ?>';
        //alert("storeType >> "+storeType+" :: merchantId >> "+merchantId);
        if(storeType == 'merchant')
        {
            merchantphone = <?= App\Models\Merchant::where(['id' => $storedata->merchant_id])->pluck('phone') ?>;
        }
        else
        {
            merchantphone = <?= App\Models\Vendor::where(['id' => $storedata->merchant_id])->pluck('phone_no') ?>;
        }
        $("#hdnmMerchantPhoneNo").val(merchantphone);
       //alert("merchantphone >> "+merchantphone);
        $("#hdnStoreType").val(storeType);
    });
    

    $(".yourOnlineStore").on("click",function(){
        var merchantphone = $("#hdnmMerchantPhoneNo").val();
        form = "";
        form += '<input type="hidden" name="telephone" value="'+merchantphone+'">';
        $('<form action="{{$storedata->store_domain}}/get-log" method="POST" target="_blank">'+form+'</form>').appendTo('body').submit();  
    });
    
    $(".setUpStoreButton").on("click",function(){
        var merchantphone = $("#hdnmMerchantPhoneNo").val();
       
        form = "";
        form += '<input type="hidden" name="telephone" value="'+merchantphone+'">';
        $('<form action="{{$storedata->store_domain}}/get-login" method="POST" target="_blank">'+form+'</form>').appendTo('body').submit();
    });
    
   
</script>
@stop
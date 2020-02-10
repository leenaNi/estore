@extends('Frontend.layouts.default')
@section('content')
<style>
    body{overflow-x:hidden;}
</style>
<section id="slider" class="full-screen dark" style="background: url({{ asset(Config('constants.frontendPublicImgPath').'/static.jpg') }}) center center no-repeat; background-size: cover">

    <div class="">

        <div class="container vertical-middle clearfix" style="top: 45% !important;">
            <div class="heading-block center nobottomborder nobottommargin">
                <h1 data-animate="fadeInUp">Congrats!</h1>
                <span data-animate="fadeInUp" data-delay="300">Your Online Store <strong><u>{{@$storedata->store_name}}</u></strong> is ready</span>
            </div>
            
            <div class="clearfix text-center setUpStoreBtn">
            <!-- <a href='#' class="btn theme-btn yourOnlineStore">Go to your Online Store </a> -->
            <a href='#' test='{{$storedata->store_domain}}/admin' class="btn theme-btn setUpStoreButton">Let's Set up your Store</a>
            </div>
           
        <div class="table-responsive">
            <form action="#" method="post" role="form" class="landing-wide-form congrats-form clearfix">
                <table class="table nobottommargin">
                    <tbody>
                       
                        <tr>
                            <td colspan="2">Store Admin Link<br/><a target="_blank" href="{{$storedata->store_domain}}/admin">{{$storedata->store_domain}}/admin</a></td>
                        </tr>
                        @if($storedata->store_type == 'merchant')
                        <tr>
                            <td colspan="2">Online Store Link<br/><a target="_blank" href="{{$storedata->store_domain}}">{{$storedata->store_domain}}</a></td>
                        </tr>
                        @endif
                        <tr>
                            <td colspan="2" class="text-center">To manage your online store, click on the Store Admin link or download eStorifi Merchant app and login with the same credentials used to create the store.
                               <div class="clearfix androidBtn">
                            <a href="https://play.google.com/store/apps/details?id=com.app.veestores" target="_blank"><img src="https://veestores.com/public/Frontend/images//androidapp.png" alt="Download App Image"></a></div></td>
                        </tr>
                    </tbody>
                </table>
                <input type="hidden" id="hdnStoreType" name="hdnStoreType" value="">
                <input type="hidden" id="hdnmMerchantPhoneNo" name="hdnmMerchantPhoneNo" value="">
            </form>
        </div>
        </div>

    </div>

</section>
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
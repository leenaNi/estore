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
            <a href='#' class="btn theme-btn yourOnlineStore">Go to your Online Store </a>
            <a href='#' test='{{$storedata->store_domain}}/admin' class="btn theme-btn setUpStoreButton">Let's Set up your Store</a>
            </div>
           
			
<div class="table-responsive">
            <form action="#" method="post" role="form" class="landing-wide-form congrats-form clearfix">
                <table class="table nobottommargin">

                    <tbody>
                        <tr>
                            <td colspan="2">Store Admin Link<br/><a target="_blank" href="{{$storedata->store_domain}}/admin">{{$storedata->store_domain}}/admin</a></td>
                        </tr>
                        <tr>
                            <td colspan="2">Online Store Link<br/><a target="_blank" href="{{$storedata->store_domain}}">{{$storedata->store_domain}}</a></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-center">To manage your online store, click on the Store Admin link or download VeeStores Merchant app and login with the same credentials used to create the store.
                               <div class="clearfix androidBtn">
                            <a href="https://play.google.com/store/apps/details?id=com.app.veestores" target="_blank"><img src="https://veestores.com/public/Frontend/images//androidapp.png" alt="Download App Image"></a></div></td>
                        </tr>
                    </tbody>
                </table>

            </form>
        </div>
        </div>

    </div>

</section>
@stop

@section('myscripts')
<script>
    
      $(".yourOnlineStore").on("click",function(){
          merchantphone = <?= App\Models\Merchant::find($storedata->merchant_id)->phone ?>;
            form = "";
            form += '<input type="hidden" name="telephone" value="'+merchantphone+'">';
            $('<form action="{{$storedata->store_domain}}/get-log" method="POST" target="_blank">'+form+'</form>').appendTo('body').submit();
        
        
    });
    
    $(".setUpStoreButton").on("click",function(){
        merchantphone = <?= App\Models\Merchant::find($storedata->merchant_id)->phone ?>;
            form = "";
            form += '<input type="hidden" name="telephone" value="'+merchantphone+'">';
            $('<form action="{{$storedata->store_domain}}/get-login" method="POST" target="_blank">'+form+'</form>').appendTo('body').submit();
        
        
    });
    
    
</script>


@stop
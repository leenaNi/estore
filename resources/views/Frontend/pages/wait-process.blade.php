@extends('Frontend.layouts.default')
@section('content')
<style>
    header#header, footer#footer {
    display: none !important;
}
.divcenter.text-center img {
    max-width: 400px;
    margin: 0 auto;
    text-align: center;
}
.heading-block.title-center.nobottomborder {
    margin-bottom: 0px !important;
}
.content-wrap {
    position: relative;
    padding: 70px 0px 0px 0px;
}
.heading-block p {
    font-size: 14px;
    color: #444;
    margin-bottom: 15px;
}
.heading-block h3{letter-spacing: 0px;}
body, #wrapper, #content {
    background-color: #e6f3e7 !important;;
}
</style>
<section id="content">
    <div class="content-wrap">
        <div class="container clearfix">
        <div class="heading-block title-center nobottomborder">
            <h3>Now sit back &amp; relax while we create your online store</h3>
            <p>Do not hit refresh or browser back button or close this window. This process and creation of primary domain might take some time. Please be patient.</p>
        </div>
        <div class="divcenter text-center">
        <img src="{{ asset(Config('constants.frontendPublicImgPath').'/pageLoader1.gif') }}" alt="Process..." class="img-responsive"> 
        </div>

        </div>
    </div>
</div>
@stop
@section('myscripts')
<script>
    $(document).ready(function(){
        allinput = <?= $themeInput ?>;
        console.log(allinput);
     $.ajax({
        type:"POST",
       // dataType:"json",
        data:{themeInput:allinput},
        url:"{{ route('congrats') }}",
        cache:false,
        success:function(data){
            console.log(data);
            if(data.status == 'success'){
                form = "";
                form += '<input type="hidden" name="id" value="'+data.id+'">';
            $('<form action="{{route("getcongrats")}}" method="POST">'+form+'</form>').appendTo('body').submit();
            }
        }
     });
    });

</script>
@stop
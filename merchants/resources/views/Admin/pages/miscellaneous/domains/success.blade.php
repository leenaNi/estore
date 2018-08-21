@extends('Admin.layouts.default')
@section('content')
<style>
.circleBase {
    border-radius: 50%;
    behavior: url(PIE.htc); /* remove if you don't care about IE8 */
}
.type2 {
    width: 50px;
    height: 50px;
}
</style>
<section class="content-header">
    <h1>
        Thank you 
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Domains</li>
    </ol>
</section>
<section class="content">
    <div class="row">

        <div class="col-sm-12">
            <div class="panel">
                <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <img src="{{ asset('public/Admin/dist/img/help-desktop.png') }}">
                    </div>
                    <div class="col-sm-6 col-md-8 col-md-offset-2">
                        <h1 class="text-center">You have added a custom domain</h1>
                        <h4 class="text-center">Your customer can now easily find your site by visiting the web address below</h4>
                    </div>
                    <div class="succesMsg col-sm-6 col-md-6 col-md-offset-3 text-center">
                        <div class="alert text-center cust-success">
                        <i class="fa fa-check"></i> vikram.com
                        </div>
                    </div>
                    
                    <div class="warnMsg col-sm-6 col-md-6 col-md-offset-3 text-center">
                        <div class="alert text-center cust-warining">
                        Please login to your domain provider account to complete custom domain setup.<br/>
Add a CNAME record and ponted it to vikram.veestores.com. please note that domain changes can take up to 24 hours to take effect. <a href="#">Learn more</a>.
                        </div>
                    </div>
                    <div class="col-md-12 text-center">
                    <div class="actions">
                    <a class="btn btn-default">Go to Domain Setting</a>
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
 
</script>

@stop
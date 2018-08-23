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
        Domains
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Domains</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div >
                @if(!empty(Session::get('message')))
                <div class="alert alert-danger" role="alert">
                    {{ Session::get('message') }}
                </div>
                @endif
                @if(!empty(Session::get('msg')))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('msg') }}
                </div>
                @endif
        </div>
        <div class="col-sm-12">
            <div class="panel">
                <div class="panel-body">
             <div class="row">
             <div class="col-md-12 marginBottom15">
                <div class="primary-domainBox">
                    <div class="domain-description">
                        <img class="image" src="{{ Config('constants.adminImgPath').'/p-domain.jpg' }}" alt="page-connect-logo">
                        <div class="title">Primary Domain</div>
                        <div>Your primary domain is the default domain which is assigned to your store by Veestores</div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="primary-domain-selection"> 
                        <input type="text" disabled="true" class="form-control" value="{{ $_SERVER['HTTP_HOST'] }}">
<!--                        <select class="form-control"><option value="" selected="" disabled="TRUE">{{ $_SERVER['HTTP_HOST'] }}</option></select>-->
<!--                        <input type="submit" name="commit" class="btn btn-primary form-control domSavebtn" value="Save">-->
                    </div>
                </div>
             </div>
             <div class="clearfix"></div>
             <div class="col-md-6 mob-marBottom15">                
                <div class="connect-domainBox">
                    <div class="domain-img text-center">
                    <img class="image" src="{{  Config('constants.adminImgPath').'/godaddy.png' }}" alt="godaddy-logo">
                    </div>
                    <div class="domain-description text-center">
                        
                        <div class="title">Connect to GoDaddy Domain</div>
                        <div>Make your site more professional,  memorable and easy to find with your own GoDaddy domain. Here are the steps with which you can connect your domain bought from GoDaddy to Veestores Primary Domain.</div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="actions">
                        <a class="btn btn-default" data-toggle="modal" data-target="#stepGodaddy">View Steps</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mob-marBottom15">                
                <div class="connect-domainBox">
                    <div class="domain-img text-center">
                    <img class="image" src="{{  Config('constants.adminImgPath').'/c-domain.jpg' }}" alt="page-connect-logo">
                    </div>
                    <div class="domain-description text-center">
                        <div class="title">Connect to Other Service Provider Domain</div>
                        <div>Make your site more professional,  memorable and easy to find with your own custom domain.  Here are the steps with which you can connect your domain bought from Other Service Provider to Veestores Primary Domain.</div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="actions">
                        <a class="btn btn-default" data-toggle="modal" data-target="#connCustDomain">View Steps</a>
                    </div>
                </div>
            </div>
        </div>
                </div>
            </div>
        </div>
    </div>
<!-- Modal -->
<div class="modal fade" id="stepGodaddy" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">x</button>
          <h4 class="modal-title text-left">Steps to Connect GoDaddy Domain</h4>
        </div>
        <div class="modal-body padd30">
          <div class="row">
              <div class="col-md-12">
                <ol start="1" class="stepsList">
                    <li>Go to <a href="https://in.godaddy.com/" target="_blank">www.godaddy.com</a> and Sign in with the Username or Customer and Password used to purchase the domain</li>
                    <li>Click on the 'DNS' button of the domain you want to connect</li>
                    <li>Delete Type A for name @/domain name</li>
                    <li>Click on 'ADD' select type as 'CNAME' in the dropdown. Enter  Host as '@' and Points to your primary domain i.e. 'yourstorename.veestores.com'</li>
                    <li>Click on 'Save'</li>
                    <li>You are done. Your new domain will be connected to Veestores online Store automatically. Please note that domain changes can take up to 24 hours to take effect</li>
                    <li>Contact us on <a href="mailto:info@infiniteit.biz" target="_blank">info@infiniteit.biz</a> if you need any help. We are more than happy to guide you.</li>
                </ol>
              </div>
         </div>
        </div>
        <div class="clearfix"></div>
      </div>
      
    </div>
  </div>
<!-- Modal -->
<div class="modal fade" id="connCustDomain" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">x</button>
          <h4 class="modal-title text-left">Steps to Connect Other Service Provider Domain</h4>
        </div>
        <div class="modal-body padd30">
          <div class="row">
              <div class="col-md-12">
                <ol start="1" class="stepsList">
                <li>Go to your domain provider website and login with the Username/Email and Password used to purchase the domain</li>
                <li>Click on the 'DNS' option of the domain you want to connect</li>
                <li>Add a CNAME record and pointed it to 'yourstorename.veestores.com'</li>
                <li>You are done. Your new domain will be connected to Veestores online Store automatically. Please note that domain changes can take up to 24 hours to take effect</li>
                <li>Contact us on <a href="mailto:info@infiniteit.biz" target="_blank">info@infiniteit.biz</a> if you need any help. We are more than happy to guide you.</li>
                </ol>
              </div>
         </div>
        <div class="clearfix"></div>
      </div>
      
    </div>
        <div class="clearfix"></div>
  </div>
        <div class="clearfix"></div>
</section>
@stop

@section('myscripts')
<script>
 
</script>

@stop
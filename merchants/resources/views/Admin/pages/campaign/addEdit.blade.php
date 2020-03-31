@extends('Admin.layouts.default')
@section('content')
<style type="text/css">
    input[type=checkbox]{display:none;}
</style>
<section class="content-header">
    <h1>
        SMS Campaign
        <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"><a href="{{route('admin.campaign.view')}}" >SMS Campaign </a></li>
        <li class="active">Add/Edit</li>
    </ol>
</section>

<section class="content">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            @if(in_array(Route::currentRouteName(),['admin.coupons.edit','admin.coupons.history']))

            <li class="{{ in_array(Route::currentRouteName(),['admin.coupons.edit']) ? 'active' : '' }}">
                <a href="{!! route('admin.coupons.edit', ['id' => Input::get('id')]) !!}" aria-expanded="false">Coupons</a>
            </li>
            <li class="{{ in_array(Route::currentRouteName(),['admin.coupons.history']) ? 'active' : '' }}">
                <a href="{!! route('admin.coupons.history', ['id' => Input::get('id')]) !!}"  aria-expanded="false">History</a>
            </li>
            @else
            <li class="{{ Route::currentRouteName()=='admin.coupons.add' ? 'active' : '' }}">
                <a href="{!! route('admin.coupons.add') !!}" aria-expanded="false">SMS Details</a>
            </li>
            @endif
        </ul>
        <div  class="tab-content" >
            <div class="active tab-pane" id="activity">
                <div class="row">
                    
                    <div class="col-md-12">
                        <div class="box noShadow noBorder">
                            <div class="box-body">
                               <div class="alert alert-success" style="display: none" role="alert" id="successmsg">
                     
                                 </div> 
                                <!-- <form action="{{$action}}" method="post"> -->
                                    {!! Form::model($smsCampaign, ['method' => 'post', 'files'=> true, 'url' => $action , 'id'=>'save_message' ]) !!}
                                <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('title', 'Message Title ',['id'=>'msg_title','class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                                        {!! Form::hidden('id',null) !!}
                                       
                                        <input type="hidden" name="return_url" value="{{ Route::currentRouteName()=='admin.campaign.add' ? 'active' : '' }}" />                                    
                                        {!! Form::text('title',null, ["class"=>'form-control validate[required] ' ,"placeholder"=>'Message Title']) !!}
                                        <div id="coupon_name_re_validate" style="color:red;"></div>
                                    </div>                                    
                                </div>
                                </div>
                                <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('content', 'Message Content ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                                        {!! Form::textarea('content',null, ["id"=>"msg_content","rows"=>5,"class"=>'form-control validate[required]' ,"placeholder"=>'Message Content']) !!}
                                        <span id="error_msg"></span>
                                        <div id="coupon_code_re_validate" style="color:red;"></div>
                                    </div>
                                </div>
                                </div>
                             
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <input type="submit" value="Save as draft" class="btn btn-primary pull-right mobFloatLeft noMob-leftmargin" >
                                        <button type="button" class="btn btn-primary pull-right mobFloatLeft noMob-leftmargin" data-toggle="modal" data-target="#sendSmsModal">Send Test SMS </button>
                                        <input type="button" onclick="sendBulkSms()" value="Send Bulk SMS" class="btn btn-primary pull-right mobFloatLeft noMob-leftmargin" >
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section> 
<div class="modal fade" id="sendSmsModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <form method="post" id="sendSms">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Send Test SMS</h4>
        </div>
        <div class="modal-body">
            <div class="col-md-12">
                <div class="form-group">    
                    <label>Mobile No. </label>
                        <input class="form-control" id="contactno" name="contactno" type="text">
                </div>
            </div>
        </div>    
        
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="publishbtn" onclick="sendSms()">Send SMS</button>  
          
        </div>
     
      </div>
      </form>
    </div>
  </div>
@stop 

@section('myscripts')

<script>
    function sendSms()
    {
        var contactno = $("#contactno").val();
        var title = $("#msg_title").val();
        var content = $("#msg_content").val();
          // alert(contactno);
            $.ajax({
                type: "POST",
                url: "{{ route('admin.campaign.sendsms') }}",
                data: {contactno: contactno,title:title,content:content},
                cache: false,
                success: function (response) {
                    $('#sendSmsModal').modal('toggle');
                    $("#successmsg").show();
                    $("#successmsg").html('SMS Send Successfully');
                   
                }, error: function (e) {
                    console.log(e.responseText);
                }
            });
    }

    function sendBulkSms()
    {
        var title = $("#msg_title").val();
        var content = $("#msg_content").val();
          // alert(contactno);
            $.ajax({
                type: "POST",
                url: "{{ route('admin.campaign.sendbulksms') }}",
                data: {title:title,content:content},
                cache: false,
                success: function (response) {
                    //$('#sendSmsModal').modal('toggle');
                    $("#successmsg").show();
                    $("#successmsg").html('SMS Send Successfully');
                   
                }, error: function (e) {
                    console.log(e.responseText);
                }
            });
    }

    $("#fromdatepicker").datepicker({dateFormat: 'yy-mm-dd'});
    $("#todatepicker").datepicker({dateFormat: 'yy-mm-dd'});


</script>


@stop
@extends('Admin.layouts.default')
@section('content')
<style type="text/css">
    input[type=checkbox]{display:none;}
    #contentss {
    z-index: 1;
}
</style>

<section class="content-header">
    <h1>
        Email Campaign
        <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"><a href="{{route('admin.campaign.view')}}" >Email Campaign </a></li>
        <li class="active">Add/Edit</li>
    </ol>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<section class="content">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            @if(in_array(Route::currentRouteName(),['admin.coupons.edit','admin.coupons.history']))

            <li class="{{ in_array(Route::currentRouteName(),['admin.coupons.edit']) ? 'active' : '' }}">
                <a href="{!! route('admin.coupons.edit', ['id' => Input::get('id')]) !!}" aria-expanded="false">Email</a>
            </li>
            <li class="{{ in_array(Route::currentRouteName(),['admin.coupons.history']) ? 'active' : '' }}">
                <a href="{!! route('admin.coupons.history', ['id' => Input::get('id')]) !!}"  aria-expanded="false">History</a>
            </li>
            @else
            <li class="{{ Route::currentRouteName()=='admin.coupons.add' ? 'active' : '' }}">
                <a href="{!! route('admin.coupons.add') !!}" aria-expanded="false">Email Details</a>
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
                                    {!! Form::model($emailCampaign, ['method' => 'post', 'files'=> true, 'url' => $action , 'id'=>'save_email' ]) !!}
                                <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('title', 'Title ',['id'=>'msg_title','class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                                        {!! Form::hidden('id',null) !!}
                                       
                                        <input type="hidden" name="return_url" value="{{ Route::currentRouteName()=='admin.campaign.add' ? 'active' : '' }}" />                                    
                                        {!! Form::text('title',null, ["class"=>'form-control validate[required] ' ,"placeholder"=>'Title']) !!}
                                        <div id="title_re_validate" style="color:red;"></div>
                                    </div>                                    
                                </div>
                                </div>
                                <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('subject', 'Subject ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                                        {!! Form::text('subject',null, ["class"=>'form-control validate[required] ' ,"placeholder"=>'Subject']) !!}
                                        <div id="subject_re_validate" style="color:red;"></div>
                                    </div>
                                </div>
                                </div>
                             <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                     <div class="col-sm-12">                        
                        {!! Form::label('content', '',['class'=>'control-label']) !!}
                       
                            <ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#editTemplate">Edit</a></li>
  <li><a data-toggle="tab" href="#previewTemplate">Preview</a></li>
</ul>

<div class="tab-content">
  <div id="editTemplate" class="tab-pane fade in active">
   <div id="contentss">
                                {!! Form::textarea('content',null,["class"=>'form-control editor',"placeholder"=>"Enter Description", "rows" => "4"]) !!}
                            </div>
  </div>
  <div id="previewTemplate" class="tab-pane fade">
                                <span id="htmlOut"></span>
  </div>
    
</div>     
  
                        </div>
                    </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <input type="submit" value="Save as draft" class="btn btn-primary pull-right mobFloatLeft noMob-leftmargin" >
                                        @if(!empty($emailCampaign->title))
                                        <button type="button" class="btn btn-primary pull-right mobFloatLeft noMob-leftmargin" data-toggle="modal" data-target="#sendEmailModal">Send Test Email </button>
                                        <input type="button" value="Send Bulk Email" class="btn btn-primary pull-right mobFloatLeft noMob-leftmargin" >
                                        @endif
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
<div class="modal fade" id="sendEmailModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <form method="post" id="sendSms">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Send Test Email</h4>
        </div>
        <div class="modal-body">
            <div class="col-md-12">
                <div class="form-group">    
                    <label>Email Address </label>
                        <input class="form-control" id="useremail" name="useremail" type="email">
                </div>
            </div>
        </div>    
        
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="publishbtn" onclick="sendEmail()">Send Email</button>  
          
        </div>
     
      </div>
      </form>
    </div>
  </div>
@stop 

@section('myscripts')

<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
  //tinymce.init({ selector:'textarea' });
$("#htmlOut").html($("#content").val());
 window.onload = function () {
        tinymce.get('content').on('keyup',function(e){
           var r = this.getContent();
            $("#htmlOut").html(r);
        });
        tinymce.get('content').on('load',function(e){
           var r = this.getContent();
            $("#htmlOut").html(r);
        });
         tinymce.get('content').on('change',function(e){
           var r = this.getContent();
            $("#htmlOut").html(r);
        });
    }
</script>
<script>
    function sendEmail()
    {
        var title = $("input[name=title]").val();
        var subject = $("input[name=subject]").val();
        var content = $("textarea[name=content]").val();
        var textAreaByName = $("#content").val();

        var email = $("#useremail").val();
          alert(textAreaByName);
            $.ajax({
                type: "POST",
                url: "{{ route('admin.emailcampaign.sendemail') }}",
                data: {subject: subject,title:title,content:content,email:email},
                cache: false,
                success: function (response) {
                    $('#sendEmailModal').modal('toggle');
                    $("#successmsg").show();
                    $("#successmsg").html('Email Send Successfully');
                   
                }, error: function (e) {
                    console.log(e.responseText);
                }
            });
    }

 
</script>

@stop
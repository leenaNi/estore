@extends('Admin.layouts.default')




@section('content')

<section class="content-header">
    <h1>
      General Setting

    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <?php
        // $urlT = App\Models\GeneralSetting::where('url_key',Input::get('url_key'))->first()->type;

        // if ($urlT == 3) {
        //     $textinfo = "Advance setting";
        //     $getUrl = route('admin.advanceSetting.view');
        // }

        // if ($urlT == 2) {
        //     $textinfo = "Payment setting";
        //     $getUrl = route('admin.paymentSetting.view');
        // }


        // if ($urlT == 1) {
        //     $textinfo = "General setting";
        //     $getUrl =  route('admin.generalSetting.view');
        // }
        ?>
        <li class="active"> General Setting </li>
    </ol>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">   
                <div class="box-body">
                    {!! Form::model($templates, ['method' => 'post', 'files'=> true, 'url' => $action ]) !!}
                    {!! Form::hidden('id') !!}
                    <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('name', 'Name',['class'=>'control-label']) !!}
                            {!! Form::text('name',null, ["class"=>'form-control' ,"placeholder"=>'Enter Name', "required","disabled"=>true]) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('Status', 'Status',['class'=>'control-label']) !!}

                            {!! Form::select('status',[''=>'Please Select','1'=>'Enabled','2'=>'Disabled'],null,["class"=>'form-control' ,"required"]) !!}
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-6">
                     <div class="form-group">
                        {!! Form::label('subject', 'Subject',['class'=>'control-label']) !!}
                            {!! Form::text('subject',null, ["class"=>'form-control' ,"placeholder"=>'Enter Name', "required"]) !!}
                        </div>
                    </div>

                    <div class="line line-dashed b-b line-lg pull-in"></div>
                        <!-- Enter Massage here  col-sm-2 -->
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
                    <div class="col-md-12 marginTop20">
                    <div class="form-group">
                        <div class="pull-right">
                            {!! Form::submit('Update',["class" => "btn btn-primary noLeftMargin"]) !!}
                            {!! Form::close() !!}     
                            <a class="btn btn-default" href="{{ route('admin.templateSetting.view') }}"> Close </a>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    #contentss {
    z-index: 1;
}
    
</style>
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
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
@stop


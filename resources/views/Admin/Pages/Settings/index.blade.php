@extends('Admin.Layouts.default')
@section('contents')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> Settings </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Settings</li>
    </ol>
</section>
<section class="content">
    <div class="box box-info">
        @if(Session::get('msg'))<span class="alert">{{Session::get('msg')}} </span>@endif
        <div class="box-body" style="padding: 30px;">
            <div class="row">
                <div class="col-md-6">
                    {{ Form::model($settings,['class'=>'form-horizontal','method'=>'post','id'=>'store_save','files'=>true]) }}
                    {{ Form::hidden('id',null) }}
                    <div class="form-group">
                        <label>Logo:</label>
                        <input type="file" id="logo_img" name="logo_img" class="form-control">
                        <input type="hidden" name="logo" value="{{@$settings->logo}}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Primary Color:</label>
                        {{Form::text('primary_color',null,['class'=>'form-control jscolor', 'id' =>'primary_color', 'required'=>'true']) }}
                    </div>
                    <div class="form-group">
                        <label>Secondary picker:</label>
                        {{Form::text('secondary_color',null ,['class'=>'form-control jscolor', 'id' =>'secondary_color', 'required'=>'true']) }}
                    </div>
                    <div class="form-group">
                        <label>Currency:</label>
                        {{Form::select('currency_id',$selCurr ,null, ['class'=>'form-control','required'=>'true']) }}
                    </div>
                    <div class="form-group">
                        <label>Preferred Language:</label>
                        {{Form::select('language_id',$selLang ,null, ['class'=>'form-control','required'=>'true']) }}
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Save" class="btn btn-primary pull-left">
                    </div>
                    {{ Form::close() }}
                </div><!-- /.col -->
                <div class="col-md-2">
                    <label>&nbsp; </label>
                    <?php 
                    if(!empty($settings->logo))
                    $logo =   $settings->logo;
                    else
                        $logo = 'default-bank -logo.png';
                        ?>
                    
                    
              
                        <img src="{{ asset(Config('constants.AdminUploadPath').'settings/'.$logo) }}" class="img-responsive banklogo" />

                 
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->
@stop

@section('myscripts')
<script>
    
        function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            console.log(reader);
            reader.onload = function (e) {
                $('.banklogo').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            $('.banklogo').attr('src', "{{$logo}}");
        }
    }


    $("#logo_img").change(function () {
        readURL(this);
    });
</script>

@stop


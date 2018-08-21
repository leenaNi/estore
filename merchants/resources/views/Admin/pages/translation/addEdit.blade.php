
@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
      Languages Translations
        <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ route('admin.translation.view') }}"><i class="fa fa-coffee"></i> Languages Translations</a></li>
        <li class="active">Add/Edit</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div>
            <p style="color: red;text-align: center;">{{ Session::get('message') }}</p>
        </div>

        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    
                    {!! Form::model($translation, ['method' => 'post', 'files'=> true, 'url' => $action  ]) !!}

                 {!! Form::hidden('id',null) !!}
                    <div class="col-md-6">
                    <div class="form-group">
                        {!!Form::label('hindi','Hindi ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                            {!! Form::text('hindi',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Enter Hindi']) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                        {!!Form::label('english','English ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                            {!! Form::text('english',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Enter English']) !!}

                        </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                        {!!Form::label('bangali','Bengali ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                            {!! Form::text('bengali',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Enter Bengali']) !!}

                        </div>
                    </div>
                 <div class="col-md-6">
                    <div class="form-group">
                        {!!Form::label('translate_for','Translate For ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                            {!! Form::select('translate_for',['backend' => 'Backend','frontend' => 'Frontend'],null, ["class"=>'form-control']) !!}

                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-6">
                    <div class="form-group">
                        {!!Form::label('is_specific','Is Specific ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                            {!! Form::select('is_specific',['all' => 'All','page' => 'Page'],null, ["class"=>'form-control is_specific']) !!}

                        </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group" id="pages">
                        {!!Form::label('page','Page ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                            {!! Form::text('page',null, ["class"=>'form-control' ,"placeholder"=>'Enter pages separated by comma',"required"]) !!}

                        </div>
                    </div>
                   
                    <div class="col-md-12">
                    <div class="form-group">
                        <div class="pull-right">
                            {!! Form::submit('Submit',["class" => "btn btn-primary"]) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section> 
@stop 

@section('myscripts')
<script>
$(function(){
    showHidePage();
})

$(".is_specific").change(function(){
   showHidePage();
})

function showHidePage(){
    var specific = $(".is_specific").val();
     if(specific == 'page'){
        $("#pages").show();
        $("input[name='page']").attr('required',true)
    }else{
        console.log('dfgfdh');
        $("#pages").hide();
        $("input[name='page']").removeAttr('required')
    }
}
</script>
@stop


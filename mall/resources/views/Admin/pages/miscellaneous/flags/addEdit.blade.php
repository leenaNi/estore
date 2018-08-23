@extends('Admin.layouts.default')

@section('content')
<section class="content-header">
    <h1>
        Flags
        <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class=""><a href="{{route('admin.miscellaneous.flags')}}" >Flags</a></li>
        <li class="active">Add/Edit</li>
    </ol>
</section>
<section class="content">
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-body">
                {!! Form::model($flags, ['method' => 'post', 'url' => $action , 'class' => 'form-horizontal' ]) !!}

                <div class="form-group">
                    <div class="col-md-2 text-right mobTextLeft">
                    {!! Form::label('Flag Name', 'Flag Name', ["class"=>'control-label'] ) !!} 
                     <span class="red-astrik"> *</span>
                    </div>
                    <div class="col-md-7">
                        {!! Form::text('flag',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Flag Name']) !!}
                        
                    </div>
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <div class="col-md-2 text-right mobTextLeft">
                    {!! Form::label('Flag Value ', 'Flag Color', ["class"=>'control-label']) !!} <span class="red-astrik"> *</span>
                    </div>
                    <div class="col-md-7">
                        {!! Form::text('value',null, ["class"=>'form-control jscolor validate[required]' ,"placeholder"=>' Flag Value']) !!}
                    </div>
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <div class="col-md-2 text-right mobTextLeft">
                    {!! Form::label('Description', 'Description', ["class"=>'control-label']) !!}
                    </div>
                    <div class="col-md-7">
                        {!! Form::text('desc',null, ["class"=>'form-control' ,"placeholder"=>'Description']) !!}
                    </div>
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                {!! Form::hidden('id') !!}
                {!! Form::hidden('status',"1", ["class"=>'form-control' ,"placeholder"=>'Status']) !!}
                <div class="form-group">
                    <div class="col-md-2 text-right mobTextLeft">
                        {!! Form::submit('Submit',["class" => "btn btn-primary noMob-leftmargin"]) !!}
                        {!! Form::close() !!}
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
    $(document).ready(function () {

    });
</script>
@stop
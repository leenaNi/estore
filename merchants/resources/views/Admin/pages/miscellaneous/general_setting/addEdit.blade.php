@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        General Setting
         <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"> Settings </li>
        <li class="active"> General Settings </li>
       
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    {!! Form::model($settings, ['method' => 'post', 'files'=> true, 'url' => $action ]) !!}
                    <div class="col-sm-6">
                    <div class="form-group">
                        {!! Form::label('Name', 'Name',['class'=>'control-label']) !!}
                        {!! Form::hidden('id',null) !!}
                            {!! Form::text('name',null, ["class"=>'form-control' ,"placeholder"=>'Enter Name', "required","readonly"=>'true']) !!}
                        </div>
                    </div>

                    <div class="col-sm-6">
                    <div class="form-group">
                        {!! Form::label('Status', 'Active',['class'=>'control-label']) !!}
                            {!! Form::select('status',[''=>'Please Select','1'=>'Yes','2'=>'No'],null,["class"=>'form-control' , "required"]) !!}
                        </div>
                    </div>

                    <input type="hidden" name="type" value="1">

                    <div class="col-sm-12">
                    <div class="form-group">
                        <div class="pull-right">
                            {!! Form::submit('Submit',["class" => "btn btn-primary noLeftMargin"]) !!}
                            {!! Form::close() !!}    
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@stop


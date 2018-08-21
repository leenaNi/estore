@extends('Admin.layouts.default')
@section('content')
<div class="bg-light lter b-b wrapper-md">
    <h1 class="m-n font-thin h3">Add New Permission</h1>
</div>

<div class="panel panel-default">

    <div class="panel-body">

        {!! Form::model($permissions, ['method' => 'post', 'route' => $action , 'class' => 'form-horizontal' ]) !!}
        <div class="form-group">
            {!!Form::label('Name','Name',['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
                {!! Form::text('pname',null, ["class"=>'form-control' ,"placeholder"=>'Name', "required"]) !!}
            </div>
        </div>
        <div class="line line-dashed b-b line-lg pull-in"></div>

        <div class="form-group">
            {!!Form::label('Description','Description',['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
                {!! Form::text('description',null, ["class"=>'form-control' ,"placeholder"=>'Description', "required"]) !!}
            </div>
        </div>
        <div class="line line-dashed b-b line-lg pull-in"></div>

        <div class="form-group">
            {!!Form::label('Role','Role',['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              
                {!! Form::select('roles',$roleOptions,null ,["class"=>'form-control m-b' , "required"]) !!}

            </div>
        </div>


        <div class="line line-dashed b-b line-lg pull-in"></div>
        <div class="form-group">
            <div class="col-sm-4 col-sm-offset-2">
                {!! Form::submit('Submit',["class" => "btn btn-primary"]) !!}
                {!! Form::close() !!}     


            </div>
        </div>
        </form>
    </div>
</div>

@stop 
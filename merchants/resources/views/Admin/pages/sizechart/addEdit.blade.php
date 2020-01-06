@extends('Admin.layouts.default')




@section('content')
<section class="content-header">
    <h1>
        Size Chart
        <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add/Edit Size chart</li>
    </ol>
</section>  
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
               <div class="box-body">
                {{ Form::model($sizechart, ['method' => 'post', 'url' => $action , 'class' => 'form-horizontal bucket-form','files'=>true ]) }}

                <div class=" form-group">
                    {{ Form::label('name', 'Size Chart  Name', ["class"=>'col-md-2 control-label']) }}
                    <div class="col-md-10 ">
                        {{ Form::text('name',null, ["class"=>'form-control' ,"placeholder"=>'Size Chart Name', "required"]) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Image', 'Image', ["class"=>'col-md-2 control-label']) }}
                    <div class="col-md-10 ">
                        {{ Form::file('image',["class"=>'form-control',"id"=>"fileupload"]) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('Is Active', 'Is Active ? ',  ["class"=>'col-md-2 control-label']) }}
                    <div class="col-md-10">
                        {{ Form::radio('status',1,null, []) }}Active

                        {{ Form::radio('status',0,true,[]) }}Inactive
                    </div>
                </div>

                

                {{ Form::hidden('id') }}

                <div class="col-md-12 form-group">
                 <div class="col-md-2 control-label"></div>
                 <div class="col-md-10">
                    {{ Form::submit('Submit',["class" => "noLeftMargin btn btn-primary"]) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        
    </div>
</div>
</div>
</section>
@stop




@extends('Admin.layouts.default')




@section('content')

<section class="content-header">
    <h1>
        Countries
        <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Countries</li>
        <li class="active">Add/Edit</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    {!! Form::model($country, ['method' => 'post', 'files'=> true, 'url' => $action]) !!}

                    <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('Name', 'Name',['class'=>'control-label']) !!}
                        {!! Form::hidden('id',null) !!}
                            {!! Form::text('name',$country->name, ["class"=>'form-control' ,"placeholder"=>'Enter Name', "required"]) !!}
                        </div>
                    </div>
                   
                    <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('Status', 'Status',['class'=>'control-label']) !!}
                            <!--                            {!! Form::select('status',array("0"=>"Disable","1"=>"Enable"), ["class"=>'form-control' ,"placeholder"=>'Enter Value', "required"]) !!}-->
                            <select name="status" class='form-control' required="" >

                                <option value="0" <?php if($country->status =='0') echo "selected"; ?>>Disabled</option>
                                <option value="1" <?php if($country->status =='1') echo "selected"; ?>>Enabled</option>
                            </select>
                            
                        </div>
                    </div>

                    <div class="col-md-12">
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


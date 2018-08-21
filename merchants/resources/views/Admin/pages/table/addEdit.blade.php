
@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        Manage Tables
        <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('admin.tables.view') }}"><i class="fa fa-coffee"></i>Manage Tables</a></li>
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

                    {!! Form::model($table, ['method' => 'post', 'files'=> true, 'url' => $action ]) !!}

                    {!! Form::hidden('id',null) !!}
                    <div class='col-md-6'>
                        <div class="form-group">
                            {!!Form::label('name','Table No ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                            {!! Form::text('table_no',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Enter Table Number']) !!}
                        </div>
                    </div>
                    
                    <div class='col-md-6'>
                        <div class="form-group">
                            {!!Form::label('name','Table Name ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                            {!! Form::text('table_label',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Enter Table Name']) !!}
                        </div>
                    </div>
                    <div class='col-md-6'>
                        <div class="form-group">
                            {!!Form::label('name','Table Capacity ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                            {!! Form::number('chairs',null, ["class"=>'form-control validate[required,custom[number]]' ,"placeholder"=>'Enter Table Capacity']) !!}
                        </div>
                    </div>
                    <div class='col-md-6'>
                        <div class="form-group">
                            {!!Form::label('name','Table Shape ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                            {!! form::select('table_type',[""=>"Select Table Shape","1"=>"Square","2"=>"Rectangle", "3" => "Circle"],null,["class"=>'form-control validate[required]', "placeholder"=>'Select Status']) !!}

                        </div>
                    </div>
                    <div class='col-md-12'>
                        <div class="form-group">
                            {!!form::label('status','Status ', ["class"=> 'control-label']) !!}<span class="red-astrik"> *</span>
                            {!! form::select('status',["1"=>"Enabled","0"=>"Disabled"],($table)?$table->status:1,["class"=>'form-control validate[required]', "placeholder"=>'Select Status']) !!}
                        </div>
                    </div>
                    <div class='col-md-12'>
                        <div class="form-group">
                            <div class="pull-right mobFloatLeft">
                                {!! Form::submit('Submit',["class" => "btn btn-primary noMob-leftmargin"]) !!}
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
</script>



@stop


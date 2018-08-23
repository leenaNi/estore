@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
       Cities
        <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('admin.cities.view') }}"><i class="fa fa-coffee"></i> Cities</a></li>
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
                    
                    {!! Form::model($city, ['method' => 'post', 'files'=> true, 'url' => $action ]) !!}

                 {!! Form::hidden('id',null) !!}

                <div class="col-md-6">
                    <div class="form-group">
                        {!!Form::label('state_id','State Name ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                        {!! Form::select('state_id',$state,null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Select State Name']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    {!!Form::label('city_name','City Name ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                        {!! Form::text('city_name',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Enter City Name']) !!}
                    </div>
                </div>
                  
                <div class="col-md-6">
                    <div class="form-group">
                        {!!form::label('delivary_status','Delivary Status ', ["class"=> 'control-label']) !!}<span class="red-astrik"> *</span>
                        {!! form::select('delivary_status',["1"=>"Delivary Applicable","0"=>"Delivary Not Applicable"],null,["class"=>'form-control validate[required]', "placeholder"=>'Select Delivary Status']) !!}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                    {!!form::label('cod_status','Cod Status ', ["class"=> 'control-label']) !!}<span class="red-astrik"> *</span>
                        {!! form::select('cod_status',["1"=>"COD Applicable","0"=>"COD Not Applicable"],null,["class"=>'form-control validate[required]', "placeholder"=>'Select COD Status']) !!}
                    </div>
                </div>
                
                <div class="col-md-6"> 
                   <div class="form-group">
                    {!!form::label('status','Status ', ["class"=> 'col-sm-2 control-label']) !!}<span class="red-astrik"> *</span>
                    {!! form::select('status',["1"=>"Active","0"=>"Inactive"],null,["class"=>'form-control validate[required]', "placeholder"=>'Status']) !!}
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
</script>



@stop



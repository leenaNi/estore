@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
       States
        <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ route('admin.state.view') }}"><i class="fa fa-coffee"></i> States</a></li>
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
                    
                    {!! Form::model($state, ['method' => 'post', 'files'=> true, 'url' => $action]) !!}

                 {!! Form::hidden('id',null) !!}
                <div class="col-md-6">
                  <div class="form-group">
                  {!!Form::label('country_name','Country Name ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                    {!! Form::select('country_id',$coutries,null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Select Country']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!!Form::label('state_name','State Name ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                        {!! Form::text('state_name',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'State Name']) !!}
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


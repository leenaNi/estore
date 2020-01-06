
@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
       Languages
        <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('admin.language.view') }}"><i class="fa fa-coffee"></i> Languages</a></li>
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
                    
                    {!! Form::model($language, ['method' => 'post', 'files'=> true, 'url' => $action ]) !!}

                 {!! Form::hidden('id',null) !!}
                    <div class='col-md-6'>
                    <div class="form-group">
                        {!!Form::label('name','Language ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                            {!! Form::text('name',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Language']) !!}
                        </div>
                    </div>
                    <div class='col-md-6'>
                     <div class="form-group">
                     {!!form::label('status','Status ', ["class"=> 'control-label']) !!}<span class="red-astrik"> *</span>
                        {!! form::select('status',["1"=>"Enabled","0"=>"Disabled"],null,["class"=>'form-control validate[required]', "placeholder"=>'Select Status']) !!}
                        </div>
                    </div>
                    <div class='col-md-12'>
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


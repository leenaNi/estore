@extends('Admin.layouts.default')
@section('content')


<section class="content-header">
    <h1>
        Currency Conversion
        <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Currency Conversion</li>
        <li class="active"> Add/Edit </li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    {!! Form::model($currency, ['method' => 'post', 'files'=> true, 'url' => $action]) !!}
                    <div class="col-sm-6">
                    <div class="form-group">
                        {!! Form::label('currency_code', 'Currency Code',['class'=>'control-label']) !!}
                        {!! Form::hidden('id',null) !!}
                            {!! Form::text('currency_code',$currency->currency_code, ["class"=>'form-control' ,"placeholder"=>'Enter Name', "required"]) !!}
                        </div>
                    </div>
                    <div class="col-sm-6">
                    <div class="form-group">
                        {!! Form::label('currency_val', 'Currency Value',['class'=>'control-label']) !!}
                            {!! Form::text('currency_val',$currency->currency_val, ["class"=>'form-control' ,"placeholder"=>'Enter Value', "required"]) !!}
                        </div>
                    </div>
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


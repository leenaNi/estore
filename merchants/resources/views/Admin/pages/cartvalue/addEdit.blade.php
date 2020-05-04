@extends('Admin.layouts.default')

@section('mystyles')

<link rel="stylesheet" href="{{ asset('public/Admin/dist/css/jquery.tagit.css') }}">

<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/flick/jquery-ui.css">


@stop

@section('content')
<section class="content-header">
    <div class="flash-message"><b>{{ Session::get("ProductCode") }} {{ Session::get("errorMessage") }}</b></div>
    <h1>
        Cart Value

    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class=""><a href="{{route('admin.courier.view')}}">Cart Value</a></li>
        <li class="active">Add/Edit</li>
    </ol>
</section>
<section class='content'>
    <div class="nav-tabs-custom">




        <div class="tab-content">
            <div class="tab-pan-active" id="activity">
                <div class="panel-body">
                <div class="row">
                    {!! Form::model($charges, ['method' => 'post', 'files'=> true, 'url' => $action ,'id'=>'EditGeneralInfo']) !!}

                    {!! Form::hidden('id',null) !!}
                        {!! Form::hidden('store_id', Session::get('store_id')) !!}

                    <div class="col-md-12">
                        <div class="form-group">
                        {!! Form::label('charges', 'Minimum Charges') !!}<span class="red-astrik"> *</span>
                            <input type="text" value="{{$charges}}" placeholder="Cart Charges" class="form-control" name="charges" required>
                        </div>
                    </div>
                        

                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group col-sm-12 ">
                        {!! Form::submit('Submit',["class" => "btn btn-primary margin-left0"]) !!}

                    </div>
                    {!! Form::close() !!}
                </div>
                </div>
            </div>
        </div>
    </div>
</section>

@stop

@section('myscripts')
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
<script src="{{ asset('public/Admin/dist/js/tag-it.min.js') }}"></script>
@stop
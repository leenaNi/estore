@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        Tax
        <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> Offer </li>
        <li class="active">Add/Edit</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div>
            <p style="color: red;text-align: center;">{{ Session::get('messege') }}</p>
        </div>

        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    {!! Form::model($tax, ['method' => 'post', 'files'=> true, 'url' => $action , 'class' => 'form-horizontal' ]) !!}

                    <div class="form-group">
                        {!! Form::label('name', 'Tax Name',['class'=>'col-sm-2 control-label']) !!}
                        {!! Form::hidden('id',null) !!}
                        {!! Form::hidden('updated_by', Session::get('loggedinAdminId')) !!}
                        <div class="col-sm-10">
                            {!! Form::text('name',null, ["class"=>'form-control' ,"placeholder"=>'Enter Tax Name', "required", (Input::get('id'))? "readonly": ""]) !!}
                        </div>
                    </div>

                    <div class="line line-dashed b-b line-lg pull-in"></div>

                    <div class="form-group">
                        {!!Form::label('tax_type','Tax Type',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            @if(Input::get('id'))
                            {!! Form::text('tax_type', ($tax->type==1)? "Order Level": "Category Level", ["class"=>'form-control' , "required", (Input::get('id'))? "readonly": ""]) !!}
                            {!! Form::hidden('type', null, ["class"=>'form-control', "required", (Input::get('id'))? "readonly": ""]) !!}
                            @else
                            {!! Form::select('type',["2" => "Category Level", "1" => "Order Level"],null,["class"=>'form-control', (Input::get('id'))? "readonly": ""]) !!}
                            @endif
                        </div>
                    </div>

                    <div class="line line-dashed b-b line-lg pull-in"></div>

                    <div class="form-group">
                        {!!Form::label('rate','Tax Rate',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('rate',null,["class"=>'form-control',"placeholder"=>"Enter Tax Rate", "required"]) !!}
                        </div>
                    </div>

                    <div class="line line-dashed b-b line-lg pull-in"></div>

                    <div class="form-group">
                        {!!Form::label('tax_number','Tax Number',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('tax_number',null,["class"=>'form-control',"placeholder"=>"Enter Tax Number", (Input::get('id'))? "readonly": "" ]) !!}
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
        </div>
    </div>
</section> 
@stop 

@section('myscripts')
<script>

</script>

@stop
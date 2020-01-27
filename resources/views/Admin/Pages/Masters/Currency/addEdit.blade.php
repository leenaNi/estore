@extends('Admin.Layouts.default')

@section('contents')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Add/Edit
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.masters.currency.view') }}"><i class="fa fa-dashboard"></i>Currency</a></li>
        <li class="active">Add/Edit</li>
    </ol>
</section>
<section class="content">
    <div class="row">

        <div class="col-xs-12">
            <div class="box pt50">
                {{ Form::model($currency, ['route' => ['admin.masters.currency.saveUpdate', $currency->id], 'class'=>'form-horizontal','id'=>'currencyForm','method'=>'post']) }}
                {{ Form::hidden('id',(Input::get('id')?Input::get('id'):null)) }}
                <div class="box-body">
                    <div class="form-group">
                        {{ Form::label('Country *', 'Country *', ['class' => 'col-sm-3 control-label']) }}
                        <div class="col-sm-6 col-xs-12">
                            {{Form::text('name',  null, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('Currency Code *', 'Currency Code *', ['class' => 'col-sm-3 control-label']) }}
                        <div class="col-sm-6 col-xs-12">
                            {{Form::text('currency_code',  null, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('ISO Code *', 'ISO Code *', ['class' => 'col-sm-3 control-label']) }}
                        <div class="col-sm-6 col-xs-12">
                            {{Form::text('iso_code',  null, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('Currency Value *', 'Currency Value *', ['class' => 'col-sm-3 control-label']) }}
                        <div class="col-sm-6 col-xs-12">
                            {{Form::text('currency_val',  null, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('CSS Code', 'CSS Code', ['class' => 'col-sm-3 control-label']) }}
                        <div class="col-sm-6 col-xs-12">
                            {{Form::text('css_code',  null, ['class'=>'form-control']) }}
                        </div>
                    </div>
                     
                    <div class="form-group">
                        {{ Form::label('Status *', 'Status *', ['class' => 'col-sm-3 control-label']) }}
                        <div class="col-sm-6 col-xs-12">
                            {{Form::select('status',[''=>'Please Select Status','1'=>'Enabled','0'=>'Disabled'],null ,['class'=>'form-control']) }}
                        </div>
                    </div>

                </div>

                <div class="box-footer">
                <div class="row">
                    <div class="col-md-3 col-md-offset-3 text-left">
                        {{Form::submit('Save & Exit', ['class'=>'btn btn-info mr10']) }}
                    </div>
                </div> 
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</section>
<!-- /.content -->

@stop

@section('myscripts')
<script>

    $("#currencyForm").validate({
        // Specify the validation rules
        rules: {
            name: {
                required: true
            },
            currency_code: {
                required: true
            },
            iso_code: {
                required: true
            },
            currency_val: {
                required: true
            },
            css_code{
                required: true
            },
            status: {
                required: true

            }
        },
        messages: {
            name: {
                required: "Please enter currency name"

            },
            currency_code: {
                required: "Please enter currency code"
            },
            iso_code: {
                required: "Please enter iso code"
            },
            currency_val: {
                required: "Please enter currency value"
            },
            css_code{
                required: "Please enter css value"
            },
            status: {
                required: "Please select status"
            }
        },
        errorPlacement: function (error, element) {
            var name = $(element).attr("name");
            var errorDiv = $(element).parent();
            errorDiv.append(error);
            //  error.appendTo($("#" + name + "_login_validate"));
        }

    });
</script>
@stop
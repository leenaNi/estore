@extends('Admin.Layouts.default')

@section('contents')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Add/Edit
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.masters.country.view') }}"><i class="fa fa-dashboard"></i>Country</a></li>
        <li class="active">Add/Edit</li>
    </ol>
</section>
<section class="content">
    <div class="row">

        <div class="col-xs-12">
            <div class="box pt50">
                {{ Form::model($country, ['route' => ['admin.masters.country.saveUpdate', $country->id], 'class'=>'form-horizontal','id'=>'countryForm','method'=>'post']) }}
                {{ Form::hidden('id',(Input::get('id')?Input::get('id'):null)) }}
                <div class="box-body">
                    <div class="form-group">
                        {{ Form::label('Country *', 'Country *', ['class' => 'col-sm-3 control-label']) }}
                        <div class="col-sm-6 col-xs-12">
                            {{Form::text('name',  null, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('Country Code *', 'Country Code *', ['class' => 'col-sm-3 control-label']) }}
                        <div class="col-sm-6 col-xs-12">
                            {{Form::text('country_code',  null, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('ISO Code 2 *', 'ISO Code 2 *', ['class' => 'col-sm-3 control-label']) }}
                        <div class="col-sm-6 col-xs-12">
                            {{Form::text('iso_code_2',  null, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('ISO Code 3 *', 'ISO Code 3 *', ['class' => 'col-sm-3 control-label']) }}
                        <div class="col-sm-6 col-xs-12">
                            {{Form::text('iso_code_3',  null, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('Address Format', 'Address Format', ['class' => 'col-sm-3 control-label']) }}
                        <div class="col-sm-6 col-xs-12">
                            {{Form::text('address_format',  null, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('Postcode Required *', 'Postcode Required *', ['class' => 'col-sm-3 control-label']) }}
                        <div class="col-sm-6 col-xs-12">
                            {{Form::select('postcode_required',[''=>'Please Select Status','1'=>'Enabled','0'=>'Disabled'],null ,['class'=>'form-control']) }}
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

    $("#countryForm").validate({
        // Specify the validation rules
        rules: {
            name: {
                required: true
            },
            country_code: {
                required: true
            },
            iso_code_2: {
                required: true
            },
            iso_code_3: {
                required: true
            },
            postcode_required: {
                required: true
            },
            status: {
                required: true

            }
        },
        messages: {
            name: {
                required: "Please enter county name"

            },
            country_code: {
                required: "Please enter county code"
            },
            iso_code_2: {
                required: "Please enter iso code 2"
            },
            iso_code_3: {
                required: "Please enter iso code 3"
            },
            postcode_required: {
                required: "Please select postcode status"
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
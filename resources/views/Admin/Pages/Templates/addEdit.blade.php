@extends('Admin.Layouts.default')

@section('contents')
<!-- Content Header (Page header) -->
<style>
        .error{
            color:red;
        }
    </style>
<section class="content-header">
    <h1>Template Add/Edit </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Template</a></li>
        <li class="active">Add/Edit</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div>
                    <p style="color:green;text-align: center;">{{ @Session::get('successMessage') }}</p>
                    <p style="color:red;text-align: center;">{{ @Session::get('errorMessage') }}</p>
                </div>
                <div class="nav-tabs-custom">
                    
                    <div >
                        <div class="tab-pane active" id="bank_tab_1">
                            <div class="row"> 
                                <div class="col-md-8 col-xs-12"> 
                                        {{ Form::model($template, ['route' => [$action], 'class'=>'form-horizontal bankGeneral','id'=>'bankGeneral','method'=>'post','files'=>true, 'novalidate' => 'novalidate']) }}
                                        {{ Form::hidden('id',(Input::get('id')?Input::get('id'):null)) }}
                                        <div class="box-body">
                                            <div class="form-group">
                                                {{ Form::label('Template Name', 'Template Name *', ['class' => 'col-sm-3 control-label']) }}
                                                <div class="col-sm-9">
                                                    {{Form::text('name',  null, ['class'=>'form-control','required'=>'true']) }}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                {{ Form::label('Template File', $form_type=='add' ? 'Template File *':'Template File', ['class' => 'col-sm-3 control-label']) }}
                                                <div class="col-sm-9">
                                                    <input name="file" type="file" class="form-control" {{$form_type=='add' ? 'required':''}} />
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                {{ Form::label('Screenshot', $form_type=='add' ? 'Screenshot *':'Screenshot', ['class' => 'col-sm-3 control-label']) }}
                                                <div class="col-sm-9">
                                                    <input name="screenshot" type="file" class="form-control" {{$form_type=='add' ? 'required':''}} />
                                                </div>
                                            </div>

                                        </div>
                                        <!-- /.box-body -->
                                        <div class="box-footer">
                                            {{Form::submit('Save', ['class'=>'btn btn-info pull-right saveTemplate']) }} 
                                        </div>
                                        <!-- /.box-footer -->
                                        {{ Form::close() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
        </div>
    </div>
</div>
</section>
<!-- /.content -->
@stop

@section('myscripts')

<script>
    $(document).ready(function() {
    $("#bankGeneral").validate({
        rules: {
            name: {
                required: true
            },
            file: {
                extension: "zip"
              }
        },
        messages: {            
            name: {
                required: "Template Name is required."
            },
            file: {
                required: "Template File is required.",
                extension: "Please upload .zip file."
               
            }, screenshot: {
                required: "Screenshot is required."
            }           
        },
        errorPlacement: function (error, element) {
            var name = $(element).attr("name");
            var errorDiv = $(element).parent();
            errorDiv.append(error);
        }
    });
    
     //validate file extension custom  method.
           

    });
</script>
@stop
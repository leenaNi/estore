@extends('Admin.Layouts.default')

@section('contents')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Add/Edit

    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.masters.language.view') }}"><i class="fa fa-dashboard"></i>Language</a></li>
        <li class="active">Add/Edit</li>
    </ol>
</section>
<section class="content">
    <div class="row">


        <div class="col-xs-12">
            <div class="box pt50">
                {{ Form::model($language, ['route' => ['admin.masters.language.saveUpdate', $language->id], 'class'=>'form-horizontal','id'=>'languageForm','method'=>'post']) }}
                {{ Form::hidden('id',(Input::get('id')?Input::get('id'):null)) }}
                <div class="box-body">
                    <div class="form-group">
                        {{ Form::label('Language *', 'Language *', ['class' => 'col-sm-3 control-label']) }}
                        <div class="col-sm-6 col-xs-12">
                            {{Form::text('name',  null, ['class'=>'form-control']) }}
                        </div>

                    </div>
                    <div class="form-group">
                        {{ Form::label('Status *', 'Status *', ['class' => 'col-sm-3 control-label']) }}
                        <div class="col-sm-6 col-xs-12">
                            {{Form::select('status',[''=>'Please Select Status','1'=>'Enabled','0'=>'Disabled'] ,['class'=>'form-control']) }}
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

    $("#languageForm").validate({
        // Specify the validation rules
        rules: {
            name: {
                required: true

            },
            status: {
                required: true

            }
        },
        messages: {
            name: {
                required: "Please Select Language"

            },
            status: {
                required: "Please Select Status"
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
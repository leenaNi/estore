@extends('Admin.Layouts.default')

@section('contents')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Database Update
       
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Database Updates</li>
    </ol>
</section>
<section class="content">

    <div class="row">


        <div class="col-xs-12">

            <div class="box">

                {{ Form::open() }}

                <div class="box-body">
                    <div class="form-group">
                    
                            {{Form::textarea('query',  null, ['class'=>'form-control','placeholder'=>'Run the query']) }}
                       
                    </div>
                  

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    {{Form::submit('Execute', ['class'=>'btn btn-info pull-right']) }}

                </div>
                <!-- /.box-footer -->

                {{ Form::close() }}

            </div>

        </div>
    </div>
</section>
<!-- /.content -->

@stop
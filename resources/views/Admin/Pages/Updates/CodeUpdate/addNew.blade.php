@extends('Admin.Layouts.default')

@section('contents')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Code Update

    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Code Updates</li>
    </ol>
</section>
<section class="content">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#updatefiles" data-toggle="tab" aria-expanded="true">Update Existing Files</a></li>
            <li class=""><a href="#addfiles" data-toggle="tab" aria-expanded="true">Add New Files</a></li>

        </ul>
        <div  class="tab-content" >
            <div class="tab-pane active" id="updatefiles">
                {{ Form::model(null, ['route' => ['admin.updates.codeUpdate.save'], 'class'=>'form-horizontal','method'=>'post','files'=>true]) }}
                {!! Form::hidden('id',null) !!}
                <div class="row col-sm-8 form-group existingImg">
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-4">
                        <input  name="files[]" type="file" class="form-control filestyle"  data-input="false">
                    </div>
                    <div class="col-sm-4">
                        {!! Form::text('path[]',null, ["class"=>'form-control' ,"placeholder"=>'Path', "required"=>"true"]) !!}
                    </div>
                    {!! Form::hidden('id_doc[]',null) !!}
                    <div class='clearfix'></div>
                </div>
                <div class="col-md-2">
                    <a href="javascript:void();" class="label label-success active addMoreDoc" >Add More</a> 
                </div>
                <div class='clearfix'></div>
                <div class="box-footer">
                    {{Form::submit('Update Files', ['class'=>'btn btn-info pull-right']) }}
                    {{ Form::close() }}
                </div>
            </div>

            <div class="tab-pane" id="addfiles">
                {{ Form::model(null, ['route' => ['admin.updates.codeUpdate.saveNew'], 'class'=>'form-horizontal','method'=>'post','files'=>true]) }}
                {!! Form::hidden('id',null) !!}
                <div class="row col-sm-8 form-group existingImg">
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-4">
                        <input  name="files[]" type="file" class="form-control filestyle"  data-input="false">
                    </div>
                    <div class="col-sm-4">
                        {!! Form::text('path[]',null, ["class"=>'form-control' ,"placeholder"=>'Path', "required"=>"true"]) !!}
                    </div>
                    {!! Form::hidden('id_doc[]',null) !!}
                    <div class='clearfix'></div>
                </div>
                <div class="col-md-2">
                    <a href="javascript:void();" class="label label-success active addMoreDoc" >Add More</a> 
                </div>
                <div class='clearfix'></div>
                <div class="box-footer">
                    {{Form::submit('Update Files', ['class'=>'btn btn-info pull-right']) }}
                    {{ Form::close() }}
                </div>
            </div>

            <div class="addNew" style="display: none;">
                <div class="clearfix mt15">
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-4">
                        <input  name="files[]" type="file" class="form-control filestyle" data-input="false">
                    </div>
                    <div class="col-sm-4">
                        {!! Form::text('path[]',null, ["class"=>'form-control' ,"placeholder"=>'Path', "required"=>"true"]) !!}
                    </div>
                    <div class="col-sm-2">
                        {!! Form::hidden('id_doc[]',null) !!}
                        <a href="javascript:void();" class="label label-danger active deleteImg">Delete</a> 
                    </div>
                </div> 
            </div>
        </div>
    </div>
    <div class="row">


        <div class="col-xs-12">
            <div class="box">

                <div class="box-body pt50">

                </div>


            </div>

        </div>
    </div>
</section>
<!-- /.content -->

@stop

@section('myscripts')
<script>
//$('.nav-tabs a[href="#tab_1"]').tab('show');

    $(".addMoreDoc").click(function () {
        $(".existingImg").append($(".addNew").html());
    });

    $("body").on("click", ".deleteImg", function () {

        $(this).parent().parent().remove();
    });

</script>
@stop
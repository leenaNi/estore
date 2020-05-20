@extends('Admin.layouts.default')


@section('content')

<section class="content-header">
    <h1>
        Attribute 
        <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class=""><a href="{{route('admin.attributes.view')}} "> Attribute</a></li>
        <li class="active">Add/Edit</li>
    </ol>
</section>




<section class="content">   
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">

                    {!! Form::model($attrs, ['method' => 'post', 'files'=> true, 'url' => $action]) !!}

                    {!! Form::hidden('id',null) !!}
                    <div class="col-md-6">
                        <div class="form-group">
                        {!! Form::label('Attribute Sets', 'Attribute Sets ') !!}<span class="red-astrik"> *</span>
                        {!! Form::select('attr_set[]',$attrSets , $attrSetsSelected, ["class"=>'form-control validate[required]', "multiple", "style"=>'padding:24px 10px!important'] ) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        {!! Form::label('Attribute type', 'Attribute Type ') !!}<span class="red-astrik"> *</span>
                            {!! Form::select('attr_type',$attr_types , null, ["class"=>'form-control validate[required] attr_type'] ) !!}                            
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        {!! Form::label('Attribute Name', 'Attribute Name ') !!}<span class="red-astrik"> *</span>
                            {!! Form::text('attr',null, ["id"=>"attrName","class"=>'form-control validate[required]' ,"placeholder"=>'Enter Attribute Name']) !!}
                            <span id="error_msg"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        {!! Form::label('placeholder', 'Placeholder') !!}
                            {!! Form::text('placeholder' ,null, ["class"=>'form-control', "placeholder"=>"Attribute Placeholder"]) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        {!! Form::label('sort order', 'Sort Order') !!}
                            {!! Form::number('att_sort_order' ,null, ["class"=>'form-control', "placeholder"=>"Sort Order"]) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        {!! Form::label('is_filterable', 'Is Filterable') !!}
                            {!! Form::select('is_filterable',["0" => "No", "1" => "Yes"],null,["class"=>'form-control validate[required]']) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        {!! Form::label('is_required', 'Is Required') !!}
                            {!! Form::select('is_required',["0"=>"No","1"=>"Yes"] ,null, ["class"=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        {!! Form::label('status', 'Status ') !!}<span class="red-astrik"> *</span>
                            {!! Form::select('status',["0"=>"Disabled","1"=>"Enabled"] ,null, ["class"=>'form-control validate[required]']) !!}
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>

                    @if(isset($attrs->attr_type))
                    <div class="form-group attr-options" style="{{  $attrs->attr_type == 1 || $attrs->attr_type == 2 || $attrs->attr_type == 4 || $attrs->attr_type == 5 ? 'display:block;' : 'display:none;'}}">
                        @else 
                        <div class="form-group attr-options" style="display:none;">
                            @endif             
                            {!! Form::label('Attribute Options', 'Attribute Options',['class'=>'col-sm-2 control-label']) !!}

                            <div class="col-sm-9 col-md-9  attrOptn">
                                @if(isset($attrs->attr_type))
                                @if(count($attrs->attributeoptions) > 0)
                                @foreach($attrs->attributeoptions as $opt)
                                <div class="row form-group">
                                    <div class="col-sm-3">
                                        {!! Form::text('option_name[]',$opt->option_name, ["class"=>'form-control validate[required]' ,"placeholder"=>'Enter Option Name']) !!}
                                    </div>
                                    <div class="col-sm-3">
                                        {!! Form::text('option_value[]',$opt->option_value, ["class"=>'form-control validate[required]' ,"placeholder"=>'Enter Option Value']) !!}
                                    </div>
                                    <div class="col-sm-3">
                                        {!! Form::select('is_active[]',["0" => "No", "1" => "Yes"],$opt->is_active,["class"=>'form-control'],"required") !!}
                                    </div>
                                    <div class="col-sm-2">
                                        {!! Form::text('sort_order[]',$opt->sort_order, ["class"=>'form-control validate[required,custom[number]]' ,"placeholder"=>'Enter Sort Order']) !!}
                                    </div>

                                    {!! Form::hidden('idd[]',$opt->id) !!}

                                </div>
                                @endforeach
                                 @endif
                                @else
                                
                             <div class="row form-group">
                                <div class="col-sm-3">
                                    {!! Form::text('option_name[]',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Enter Option Name']) !!}
                                </div>
                                <div class="col-sm-3">
                                    {!! Form::text('option_value[]',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Enter Option Value']) !!}
                                </div>
                                <div class="col-sm-3">
                                    {!! Form::select('is_active[]',[ "1" => "Yes", "0" => "No"],null,["class"=>'form-control'],"required") !!}
                                </div>
                                <div class="col-sm-2">
                                    {!! Form::text('sort_order[]',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Enter Sort Order']) !!}
                                </div>

                            </div>
                               
                                @endif
                            </div>

                            <div class="col-sm-1">
                                {!! Form::hidden('idd[]',null) !!}
                                <a href="javascript:void()" data-toggle="tooltip" title="Add" class="addMore"><i class="fa fa-plus" aria-hidden="true"></i></a> 
                            </div>
                        </div>
                        <div class="line line-dashed b-b line-lg pull-in"></div>
                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-2">
                                {!! Form::submit('Submit',["class" => "btn btn-primary pull-right"]) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>


<div id="toClone" style="display: none;">
    <div class="row form-group">
        <div class="col-sm-3">
            {!! Form::text('option_name[]',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Enter Option Name',]) !!}
        </div>
        <div class="col-sm-3">
            {!! Form::text('option_value[]',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Enter Option Value']) !!}
        </div>
        <div class="col-sm-3">
            {!! Form::select('is_active[]',["1" => "Yes", "0" => "No"],null,["class"=>'form-control validate[required]']) !!}
        </div>
        <div class="col-sm-2">
            {!! Form::text('sort_order[]',null, ["class"=>'form-control validate[required,custom[number]]' ,"placeholder"=>'Enter Sort Order']) !!}
        </div>
        <div class="col-sm-1">
            {!! Form::hidden('idd[]',null) !!}
            <a href="javascript:void();" data-toggle="tooltip" title="Delete" class="deleteOpt" ><i class="fa fa-trash-o" aria-hidden="true"></i></a> 
        </div>
    </div>
</div>

@stop

@section('myscripts')

<script>
<?php
if (isset($attrs->attr_type))
    if (!in_array($attrs->attr_type, [1, 2, 4, 5])):
        ?>
            $(".attr-options").find('input,select').prop('disabled', true);
<?php  endif; ?>
    $(".attr_type").change(function () {
        $this = $(this);
        if ($this.val() == 1 || $this.val() == 2 || $this.val() == 4 || $this.val() == 5) {
            $(".attr-options").show().find('input,select').prop('disabled', false);
        } else {
            $(".attr-options").hide().find('input,select').prop('disabled', true);
        }
    });
    $(".addMore").click(function () {


        $(".attrOptn").append($("#toClone").html());
    });


    $("body").on("click", ".deleteOpt", function () {
        $(this).parent().parent().remove();
    });

//    $(document).ready(function() {
//        //console.log("sdf");
//        
//        alert("asdf");
//
//
//    });

    $(document).ready(function () {
        $("#attrName").blur(function () {
            var attr = $(this).val();

            $.ajax({
                type: "POST",
                url: "{{ route('admin.attributes.checkattr') }}",
                data: {attr: attr},
                cache: false,
                success: function (response) {
                    // console.log('@@@@'+response['msg'])
                    if (response['status'] == 'success') {
                        $('#attrName').val('');
                        $('#error_msg').text(response['msg']).css({'color': 'red'});
                    } else
                        $('#error_msg').text('');
                }, error: function (e) {
                    console.log(e.responseText);
                }
            });
        });
    });
</script>

@stop
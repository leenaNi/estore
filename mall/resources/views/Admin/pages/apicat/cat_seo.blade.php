@extends('Admin.layouts.default')
@section('content')


<section class="content-header">
    <h1>
        Categories
        <small>SEO</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('admin.apicat.view') }}"><i class="fa fa-coffee"></i> Category</a></li>
        <li class="active">Add/Edit</li>
    </ol>
</section>
<section class='content'>
    <?php 
    //print_r($category);
    ?>
    <div class="nav-tabs-custom"> 
        <ul class="nav nav-tabs" role="tablist">
            @if(!empty($category))
            <li class="{{ in_array(Route::currentRouteName(),['admin.apicat.edit']) ? 'active' : '' }}"><a href="{!! route('admin.apicat.edit',['id'=>$category->id]) !!}"  aria-expanded="false">Category Add/Edit</a></li>
            @endif
            @if(!empty(Input::get("parent_id")))
            <li class="{{ in_array(Route::currentRouteName(),['admin.apicat.add']) ? 'active' : '' }}"><a href="{!! route('admin.apicat.add',['parent_id'=>Input::get('parent_id')]) !!}"  aria-expanded="false">Category Add/Edit</a></li>
            @endif
            <li class="{{ in_array(Route::currentRouteName(),['admin.apicat.catSeo']) ? 'active' : '' }}"><a href="{!! route('admin.apicat.catSeo',['id'=>Input::get('id')]) !!}"  aria-expanded="false">SEO</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pan-active" id="activity">            
                <div>
                    <p style="color: red;text-align: center;">{{ Session::get('messege') }}</p>
                </div>            
                <div class="panel-body">
                    {!! Form::model($category, ['method' => 'post', 'files'=> true, 'url' => $action , 'class' => 'form-horizontal','id'=>'catSeoF' ]) !!}
                    {!! Form::hidden('id',null) !!}
                    <div class="form-group col-md-4">
                        <div class="col-md-12">
                            {!! Form::label('meta_title', 'Meta Title',['class'=>'control-label']) !!}
                            {!! Form::text('meta_title',null, ["class"=>'form-control' ,"placeholder"=>'Enter Meta Title']) !!}
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="col-md-12">
                            {!! Form::label('meta_keys', 'Meta Keywords',['class'=>'control-label']) !!}
                            {!! Form::text('meta_keys',null,["class"=>'form-control',"placeholder"=>"Enter Meta Keywords"]) !!}
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="col-md-12">
                            {!! Form::label('meta_desc', 'Meta Description',['class'=>'control-label']) !!}
                            {!! Form::text('meta_desc',null,["class"=>'form-control',"placeholder"=>"Enter Meta Keywords"]) !!}
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group col-md-6">
                        <div class="col-md-12">
                            {!! Form::label('meta_robot', 'Meta Robots',['class'=>'control-label']) !!}
                            {!! Form::text('meta_robot',null,["class"=>'form-control',"placeholder"=>"Enter Meta Keywords"]) !!}
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="col-md-12">
                            {!! Form::label('canonical', 'Canonical',['class'=>'control-label']) !!}
                            {!! Form::text('canonical',null,["class"=>'form-control',"placeholder"=>"Enter Meta Keywords"]) !!}
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group col-md-3">
                        <div class="col-md-12">
                            {!! Form::label('og_title', 'Og  Title',['class'=>'control-label']) !!}
                            {!! Form::text('og_title',null,["class"=>'form-control',"placeholder"=>"Enter Meta Keywords"]) !!}
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <div class="col-md-12">
                            {!! Form::label('og_desc', 'Og Description',['class'=>'control-label']) !!}
                            {!! Form::text('og_desc',null,["class"=>'form-control',"placeholder"=>"Enter Meta Keywords"]) !!}
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <div class="col-md-12">
                            {!! Form::label('og_image', 'Og Image',['class'=>'control-label']) !!}
                            {!! Form::text('og_image',null,["class"=>'form-control',"placeholder"=>"Enter Meta Keywords"]) !!}
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <div class="col-md-12">
                            {!! Form::label('og_url', 'Og URL',['class'=>'control-label']) !!}
                            {!! Form::text('og_url',null,["class"=>'form-control',"placeholder"=>"Enter Meta Keywords"]) !!}
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group col-md-3">
                        <div class="col-md-12">
                            {!! Form::label('twitter_url', 'Twitter URL',['class'=>'control-label']) !!}
                            {!! Form::text('twitter_url',null,["class"=>'form-control',"placeholder"=>"Enter Meta Keywords"]) !!}
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <div class="col-md-12">
                            {!! Form::label('twitter_title', 'Twitter Title',['class'=>'control-label']) !!}
                            {!! Form::text('twitter_title',null,["class"=>'form-control',"placeholder"=>"Enter Meta Keywords"]) !!}
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <div class="col-md-12">
                            {!! Form::label('twitter_desc', 'Twitter Description',['class'=>'control-label']) !!}
                            {!! Form::text('twitter_desc',null,["class"=>'form-control',"placeholder"=>"Enter Meta Keywords"]) !!}
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <div class="col-md-12">
                            {!! Form::label('twitter_image', 'Twitter Image',['class'=>'control-label']) !!}
                            {!! Form::text('twitter_image',null,["class"=>'form-control',"placeholder"=>"Enter Meta Keywords"]) !!}
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <div class="col-md-12">
                            {!! Form::label('other_meta', 'Other Meta',['class'=>'control-label']) !!}
                            {!! Form::text('other_meta',null,["class"=>'form-control',"placeholder"=>"Enter Other Meta"]) !!}
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group">
                        {!! Form::hidden('return_url',null,['class'=>'rtUrl']) !!}
                        <div class="form-group col-sm-12 ">
                            {!! Form::button('Save & Exit',["class" => "btn btn-primary pull-right saveCatSeoExit"]) !!}
                            {!! Form::button('Save & Continue',["class" => "btn btn-primary pull-right saveCatSeoContine"]) !!}
                            {!! Form::submit('Save & Next',["class" => "btn btn-primary pull-right saveCatSeoNext"]) !!}
                        </div>
                        <div class="col-sm-4 col-sm-offset-2">
                            {!! Form::close() !!}     
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop
@section('myscripts')
<script>
    $(".AddMoreImg").click(function () {
        $(".existingDiv").append($(".toClone").html());
    });

    $("body").on("click", ".delImgDiv", function () {
        //   alert("sdfsdf");
        $(this).parent().parent().parent().remove();
    });
    $(".saveCatSeoExit").click(function () {
        $(".rtUrl").val("{!!route('admin.apicat.view')!!}");
        $("#catSeoF").submit();

    });
    $(".saveCatSeoContine").click(function () {
        $(".rtUrl").val("{!!route('admin.apicat.catSeo',[<?=((Input::get('id'))?"'id'=>Input::get('id')":"");?>])!!}");

        $("#catSeoF").submit();
    });

    $(".saveCatSeoNext").click(function () {
        $(".rtUrl").val("{!!route('admin.apicat.view')!!}");
        $("#catSeoF").submit();
    });
</script>
@stop
@extends('Admin.Layouts.default')
@section('content')


<section class="content-header">
    <h1>
        Categories
        <small>SEO</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('admin.category.view') }}"><i class="fa fa-coffee"></i> Category</a></li>
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
            <li class="{{ in_array(Route::currentRouteName(),['admin.category.edit']) ? 'active' : '' }}"><a href="{!! route('admin.category.edit',['id'=>$category->id]) !!}"  aria-expanded="false">Category Add/Edit</a></li>
            @endif
            @if(!empty(Input::get("parent_id")))
            <li class="{{ in_array(Route::currentRouteName(),['admin.category.add']) ? 'active' : '' }}"><a href="{!! route('admin.category.add',['parent_id'=>Input::get('parent_id')]) !!}"  aria-expanded="false">Category Add/Edit</a></li>
            @endif
            <li class="{{ in_array(Route::currentRouteName(),['admin.category.catSeo']) ? 'active' : '' }}"><a href="{!! route('admin.category.catSeo',['id'=>Input::get('id')]) !!}"  aria-expanded="false">SEO</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pan-active" id="activity">            
                <div>
                    <p style="color: red;text-align: center;">{{ Session::get('messege') }}</p>
                </div>            
                <div class="panel-body">
                    {!! Form::model($category, ['method' => 'post', 'files'=> true, 'url' => $action , 'id'=>'catSeoF' ]) !!}
                    {!! Form::hidden('id',null) !!}
                    <div class="row"> 
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('meta_title', 'Meta Title',['class'=>'control-label']) !!}
                            {!! Form::text('meta_title',null, ["class"=>'form-control' ,"placeholder"=>'Enter Meta Title']) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('meta_keys', 'Meta Keywords',['class'=>'control-label']) !!}
                            {!! Form::text('meta_keys',null,["class"=>'form-control',"placeholder"=>"Enter Meta Keywords"]) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('meta_desc', 'Meta Description',['class'=>'control-label']) !!}
                            {!! Form::text('meta_desc',null,["class"=>'form-control',"placeholder"=>"Enter Meta Description"]) !!}
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('meta_robot', 'Meta Robots',['class'=>'control-label']) !!}
                            {!! Form::text('meta_robot',null,["class"=>'form-control',"placeholder"=>"Enter Meta Robots"]) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('canonical', 'Canonical',['class'=>'control-label']) !!}
                            {!! Form::text('canonical',null,["class"=>'form-control',"placeholder"=>"Enter Meta Canonical"]) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('Social Shared Title', 'Social Shared Title',['class'=>'control-label']) !!}
                            {!! Form::text('title',null,["class"=>'form-control',"placeholder"=>"Enter Social Shared Title"]) !!}
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('Social Shared Description', 'Social Shared Description',['class'=>'control-label']) !!}
                            {!! Form::text('desc',null,["class"=>'form-control',"placeholder"=>"Enter Social Shared Description"]) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('Social Shared Image URL', 'Social Shared Image URL',['class'=>'control-label']) !!}
                            {!! Form::text('image',null,["class"=>'form-control',"placeholder"=>"Enter Social Shared Image URL"]) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('Social Shared URL', 'Social Shared URL',['class'=>'control-label']) !!}
                            {!! Form::text('url',null,["class"=>'form-control',"placeholder"=>"Enter Social Shared URL"]) !!}
                        </div>
                    </div>                
                    <div class="clearfix"></div>
                   <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('other_meta', 'Other Scripts (Don\'t include script tag)',['class'=>'control-label']) !!}
                            {!! Form::textarea('other_meta',null,["class"=>'form-control',"placeholder"=>"Enter Other Meta"]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::hidden('return_url',null,['class'=>'rtUrl']) !!}
                        <div class="form-group col-sm-12 ">
                            {!! Form::button('Save & Exit',["class" => "btn btn-primary pull-right saveCatSeoExit"]) !!}
                            {!! Form::button('Save & Continue',["class" => "btn btn-primary pull-right saveCatSeoContine"]) !!}
                           
                        </div>
                        <div class="col-sm-4 col-sm-offset-2">
                            {!! Form::close() !!}     
                        </div>
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
        $(".rtUrl").val("{!!route('admin.category.view')!!}");
        $("#catSeoF").submit();

    });
    $(".saveCatSeoContine").click(function () {
        $(".rtUrl").val("{!!route('admin.category.catSeo',['id'=>Input::get('id')])!!}");
        $("#catSeoF").submit();
    });

    $(".saveCatSeoNext").click(function () {
        $(".rtUrl").val("{!!route('admin.category.view')!!}");
        $("#catSeoF").submit();
    });
</script>
@stop
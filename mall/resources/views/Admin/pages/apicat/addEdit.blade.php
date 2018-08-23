@extends('Admin.layouts.default')
@section('content')


<section class="content-header">
    <h1>
        Categories
        <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> Category </li>
        <li class="active">Add/Edit</li>
    </ol>
</section>
<section class='content'>
    <div class="nav-tabs-custom"> 
        <ul class="nav nav-tabs" role="tablist">
            @if(!empty(Input::get("id")))
            <li class="{{ in_array(Route::currentRouteName(),['admin.apicat.edit']) ? 'active' : '' }}"><a href="{!! route('admin.apicat.edit',['id'=>Input::get('id')]) !!}"  aria-expanded="false">Category Add/Edit</a></li>
            @endif
            @if(in_array(Route::currentRouteName(),['admin.apicat.add']))
            <li class="{{ in_array(Route::currentRouteName(),['admin.apicat.add']) ? 'active' : '' }}"><a href="{!! route('admin.apicat.add',['parent_id'=>Input::get('parent_id')]) !!}"  aria-expanded="false">Category Add/Edit</a></li>
            @endif
            <li class="{{ in_array(Route::currentRouteName(),['admin.apicat.catSeo']) ? 'active' : '' }}"><a href="{!! (Input::get('id'))?route('admin.apicat.catSeo',['id'=>Input::get('id')]):'#' !!}"      aria-expanded="false">SEO</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pan-active" id="activity">
                <div>
                    <p style="color: red;text-align: center;">{{ Session::get('messege') }} </p>
                </div>
                <div class="panel-body">
                    {!! Form::model($category, ['method' => 'post', 'files'=> true, 'url' => $action , 'class' => 'form-horizontal' ,'id'=>'CatF' ]) !!}
                    <div class="form-group">
                        {!!Form::label('Has Tax ?','Has Tax ?',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('has_tax[]',$allTaxes,$category_taxes,["class"=>'form-control', "multiple"]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('category', 'Category Name',['class'=>'col-sm-2 control-label']) !!}
                        {!! Form::hidden('id',null) !!}
                        <div class="col-sm-10">
                            {!! Form::text('category',null, ["class"=>'form-control' ,"placeholder"=>'Enter Category Name', "required"]) !!}
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        {!!Form::label('is_home','Show in Home ?',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::hidden('is_home','1',["class"=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        {!!Form::label('is_nav','Show in Menu ?',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::hidden('is_nav','1',["class"=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        {!!Form::label('status','Active',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            <label> {!! Form::radio('status',1,null,['checked']) !!} Yes </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <label>{!! Form::radio('status',0,null,[]) !!} No </label>
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        {!!Form::label('sort_order','Sort Order',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::number('sort_order',null,["class"=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        {!!Form::label('url_key','Enter Url key',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('url_key',null,["class"=>'form-control',"placeholder"=>"Enter URL Key"]) !!}
                        </div>
                    </div>

                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        {!!Form::label('short_desc','Enter Short Description',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::textarea('short_desc',null,["class"=>'form-control wysihtml5',"placeholder"=>"Enter Short Description", "rows" => "9"]) !!}
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        {!!Form::label('long_desc','Enter Long Description',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::textarea('long_desc',null,["class"=>'form-control wysihtml5',"placeholder"=>"Enter Long Description", "rows" => "9"]) !!}
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="existingDiv">
                        @if($category->catimgs()->count() > 0)  
                        @foreach($category->catimgs()->get() as $cImg)
                        <div class="clearfix"></div>
                        <div class="form-group col-md-5">
                            <div class='col-md-6'>
                                <img src="{{ asset(Config("constants.catImgUploadPath").$cImg->filename) }}" class="img-responsive form-group" style="height: 20%;width: 20%;" />
                            </div>
                            <div class='col-md-6'>
                                {!! Form::file('images[]',["class"=>'form-control']) !!}   
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <div class='col-md-12'>
                                {!! Form::text('img_sort_order[]',$cImg->sort_order,["class"=>'form-control',"placeholder"=>"Sort Order"]) !!}      
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <div class='col-md-12'>
                                {!! Form::text('alt_text[]',$cImg->alt_text,["class"=>'form-control',"placeholder"=>"Alt Text"]) !!}     
                            </div>
                        </div>
                        {!! Form::hidden('catImgs[]',$cImg->id)  !!}
                        @endforeach
                        @else
                        <div class="form-group col-md-3">
                            <div class='col-md-12'>
                                {!! Form::file('images[]',["class"=>'form-control']) !!}   
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <div class='col-md-12'>
                                {!! Form::text('img_sort_order[]',null,["class"=>'form-control',"placeholder"=>"Sort Order"]) !!}      
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <div class='col-md-12'>
                                {!! Form::text('alt_text[]',null,["class"=>'form-control',"placeholder"=>"Alt Text"]) !!}     
                            </div>
                        </div>
                        {!! Form::hidden('catImgs[]',null)  !!}
                        @endif               
                        <div class="form-group col-md-3">
                            <div class='col-md-12'>
                                <a href='javascript:void()' class="AddMoreImg" data-toggle="tooltip" title="Add"><i class="fa fa-plus" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="clearfix"></div>
<!--                            <input type="hidden" name="parent_id" value="{{ @Input::get('parent_id') }}">-->
                    <div class="col-md-12 form-group">
                        {!! Form::label('parent_id', 'Select Parent Category') !!}
                        <?php
                        $categories = App\Models\Category::where("status", '1')->where('id', 1)->with('children')->orderBy("id", "asc")->get();
                        echo "<ul  id='catTree' class='tree icheck catTrEE'>";
                        foreach ($categories as $categoriesval) {
                            echo "<li><input type='checkbox' name='parent_id' id='" . $categoriesval->id . "' value='" . $categoriesval->id . "' " . (($category->parent_id == $categoriesval->id) ? "checked" : "" ) . "  " . (Input::get("parent_id") == $categoriesval->id ? "checked" : "" ) . ">" . $categoriesval->category . "";
                            foreach ($categoriesval->children as $childval) {
                                echo "<ul  id='catTree' class='tree icheck catTrEE'>";
                                echo "<li><input type='checkbox' name='parent_id' id='" . $childval->id . "' value='" . $childval->id . "' " . (($category->parent_id == $childval->id ) ? "checked" : "") . "/>" . $childval->category . ""
                                . '</li>'
                                . '</ul>';
                            }
                            echo "</li>";
                        }
                        echo "</ul>";
                        ?> 
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2">
                            {!! Form::hidden('new_prod_cat',!empty(Input::get('new_prod_cat'))?Input::get('new_prod_cat'):null) !!}
                            {!! Form::hidden('return_url',null,['class'=>'rtUrl']) !!}
                            <div class="form-group col-sm-12 ">
                                {!! Form::button('Save & Exit',["class" => "btn btn-primary pull-right saveCatExit", "style"=>"margin:left:10px"]) !!}
                                {!! Form::button('Save & Continue',["class" => "btn btn-primary pull-right saveCatContine", "style"=>"margin:left:10px"]) !!}
                                {!! Form::button('Save & Next',["class" => "btn btn-primary pull-right saveCatNext", "style"=>"margin:left:10px"]) !!}
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}  
                </div>
                <div class="toClone" style="display: none;">
                    <div class="clearfix"></div>
                    <div class="CloneImg">
                        <div class="form-group col-md-3">
                            <div class='col-md-12'>
                                {!! Form::file('images[]',["class"=>'form-control',"placeholder"=>"Image"]) !!}           
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <div class='col-md-12'>
                                {!! Form::text('img_sort_order[]',null,["class"=>'form-control',"placeholder"=>"Sort Order"]) !!}        
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <div class='col-md-12'>
                                {!! Form::text('alt_text[]',null,["class"=>'form-control',"placeholder"=>"Alt Text"]) !!}        
                            </div>
                        </div>
                        {!! Form::hidden('catImgs[]',null)  !!}
                        <div class="form-group col-md-3">
                            <div class='col-md-12'>
                                <a href = "javascript:void()" class="delImgDiv" data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
    $(".saveCatExit").click(function () {
        $(".rtUrl").val("{!!route('admin.apicat.view')!!}");
        $("#CatF").submit();
    });
    $(".saveCatContine").click(function () {
        $(".rtUrl").val("{!!route('admin.apicat.edit')!!}?id=<?php echo Input::get('id'); ?>");
        $("#CatF").submit();
    });
    $(".saveCatNext").click(function () {
        $(".rtUrl").val("{!!route('admin.apicat.catSeo')!!}?id=<?php echo Input::get('id'); ?>");
        $("#CatF").submit();
    });
</script>
@stop
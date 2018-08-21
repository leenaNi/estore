@extends('Admin.layouts.default')
@section('content')
<style type="text/css">
    input[type=checkbox]{display:none;}
    select.form-control{ padding: 11px!important; }
</style>
<section class="content-header">
    <h1>
        Category
        <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class=""><a href="{{route('admin.category.view')}} " >Category </a></li>
        <li class="active">Add/Edit</li>
    </ol>
</section>
<section class='content'>
    <div class="nav-tabs-custom"> 
        <ul class="nav nav-tabs" role="tablist">
            @if(!empty(Input::get("id")))
            <li class="{{ in_array(Route::currentRouteName(),['admin.category.edit']) ? 'active' : '' }}"><a href="{!! route('admin.category.edit',['id'=>Input::get('id')]) !!}"  aria-expanded="false">Category Add/Edit</a></li>
            @endif
            @if(in_array(Route::currentRouteName(),['admin.category.add']))
            <li class="{{ in_array(Route::currentRouteName(),['admin.category.add']) ? 'active' : '' }}"><a href="{!! route('admin.category.add',['parent_id'=>Input::get('parent_id')]) !!}"  aria-expanded="false">Category Add/Edit</a></li>
            @endif
            @if($feature['sco'] == 1)
            <li class="{{ in_array(Route::currentRouteName(),['admin.category.catSeo']) ? 'active' : '' }} {{$storeViesion}}"><a href="{!! (Input::get('id'))?route('admin.category.catSeo',['id'=>Input::get('id')]):'#' !!}"      aria-expanded="false">SEO</a></li>
            @endif
        </ul>

        <div class="tab-content">
            <div class="tab-pan-active" id="activity">
                <div>
                    <p style="color: red;text-align: center;">{{ Session::get('messege') }} </p>
                </div>
                <div class="panel-body">
                    <div class="row"> 
                    {!! Form::model($category, ['method' => 'post', 'files'=> true, 'url' => $action , 'id'=>'CatF' ]) !!}
                    
                    <div class="col-md-12">
                        <div class="box box-solid boxNew">
                            <div class="box-header boxHeaderNew with-border">
                                <h3 class="box-title">Basic Details</h3>
                            </div>
                            <div class="box-body text-center">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('category', 'Category Name ',['class'=>'pull-left']) !!}<span class="red-astrik pull-left ml-3"> *</span>
                                            {!! Form::hidden('id',null,["id"=>"cat_category"]) !!}
                                            {!! Form::text('category',null, ["id"=>"category","class"=>'form-control validate[required]' ,"placeholder"=>'Enter Category Name', "required"]) !!}
                                            <span id="catnameerror"></span>
                                        </div>
                                    </div> 

<!--                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!!Form::label('is_home','Show in Home ?',['class'=>'pull-left']) !!}
                                            {!! Form::select('is_home',["0" => "No", "1" => "Yes"],null,["class"=>'form-control']) !!}
                                        </div>
                                    </div>-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!!Form::label('is_nav','Show in Menu',['class'=>'pull-left']) !!}
                                            {!! Form::select('is_nav',["0" => "No", "1" => "Yes"],null,["class"=>'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!!Form::label('status','Status ',['class'=>'pull-left']) !!}<span class="red-astrik pull-left mb-3"> *</span>
                                            <div class="clearfix"></div>
                                            <label class="pull-left"> {!! Form::radio('status',1,null,['checked']) !!} Enabled </labeles> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <label class="pull-left marginright10">{!! Form::radio('status',0,null,[]) !!} Disabled </label>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                  
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!!Form::label('sort_order','Sort Order',['class'=>'pull-left']) !!}
                                            {!! Form::number('sort_order',null,["class"=>'form-control validate[custom[number]]']) !!}
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-6">
                                        <div class="form-group">
                                            {!!Form::label('url_key','Enter URL key',['class'=>'pull-left']) !!}
                                            {!! Form::text('url_key',null,["class"=>'form-control',"placeholder"=>"Enter URL Key"]) !!}
                                        </div>
                                    </div> -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {!!Form::label('short_desc','Enter Description',['class'=>'pull-left']) !!}
                                            {!! Form::textarea('short_desc',null,["class"=>'form-control wysihtml5',"placeholder"=>"Enter  Description", "rows" => "5"]) !!}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="box box-solid boxNew">
                            <div class="box-header boxHeaderNew with-border">
                            <h3 class="box-title">Image</h3>
                            </div>
                            <div class="box-body text-center">
                                <div class="row">

                                    <div class="existingDiv">
                                        <div class="row"> 
                                            @if($category->catimgs()->count() > 0)  
                                            @foreach($category->catimgs()->get() as $cImg)
                                            <div class="clearfix"></div>
                                            <div class="form-group col-md-5">
                                                <div class='col-md-3'>
                                                <img src="{{Config("constants.catImgPath").'/'.$cImg->filename }}" class="img-responsive form-group admin-profile-picture" />
                                                </div>
                                                <div class='col-md-9'>
                                                    {!! Form::file('images[]',["class"=>'form-control']) !!}   
                                                </div>
                                            </div>
<!--                                            <div class="form-group col-md-3">
                                                <div class='col-md-12'>
                                                    {!! Form::text('img_sort_order[]',$cImg->sort_order,["class"=>'form-control',"placeholder"=>"Sort Order"]) !!}      
                                                </div>
                                            </div>-->
                                            <div class="form-group col-md-3">
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
<!--                                            <div class="form-group col-md-3">
                                                <div class='col-md-12'>
                                                    {!! Form::text('img_sort_order[]',null,["class"=>'form-control',"placeholder"=>"Sort Order"]) !!}      
                                                </div>
                                            </div>-->
                                            <div class="form-group col-md-3">
                                                <div class='col-md-12'>
                                                    {!! Form::text('alt_text[]',null,["class"=>'form-control',"placeholder"=>"Alt Text"]) !!}     
                                                </div>
                                            </div>
                                            {!! Form::hidden('catImgs[]',null)  !!}
                                            @endif               
<!--                                            <div class="form-group col-md-1">
                                                <div class='col-md-12'>
                                                    <a href='javascript:void()' class="AddMoreImg" data-toggle="tooltip" title="Add"><i class="fa fa-plus btn btn-lg btn-plen"></i></a>
                                                </div>
                                            </div>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="box box-solid boxNew">
                            <div class="box-header boxHeaderNew with-border">
                                <h3 class="box-title"> {!! Form::label('parent_id', 'Select Parent Category') !!}</h3>
                            </div>
                            <div class="box-body text-center">
                                <div class="row">
                                    <div class="col-md-12 form-group">

                                        <?php
                                        $roots = App\Models\Category::roots()->get();
                                        echo "<ul id='catTree' class='tree icheck'>";
                                        foreach ($roots as $root)
                        //echo $root."||||||".$category;
                                            renderNode($root, $category);
                                        echo "</ul>";

                                        function renderNode($node, $category) { 
                                           $classStyle=($category->parent_id == $node->id? 'checkbox-highlight':'');
                            //  echo $classStyle;
                                           // $style=(Input::get("parent_id")  == $node->id? 'checkbox-highligh':'');                    
                                           echo "<li class='tree-item fl_left ps_relative_li'>";
                                           echo '<div class="checkbox">
                                           <label   class="i-checks checks-sm text-left '.$classStyle.'"><input type="checkbox"  name="parent_id" value="' . $node->id . '" ' . ($category->parent_id == $node->id ? "checked" : "" ) . '' . (Input::get("parent_id") == $node->id ? "checked" : "" ) . '/><i></i>' . $node->category . '</label>
                                       </div>';
                                       if ($node->children()->count() > 0) {
                                        echo "<ul class='treemap fl_left'>";
                                        foreach ($node->children as $child)
                                            renderNode($child, $category);
                                        echo "</ul>";
                                    }
                                    echo "</li>";
                                }
                                ?>
                            </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    <!--model to display size chart -->
                     <button id="trigger_model" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" style="display: none;">Open Modal</button>
                    <!-- Modal -->
                    <div id="myModal" class="modal fade" role="dialog">
                      <div class="modal-dialog modal-md">

                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Size Chart </h4>
                          </div>
                            <img id="size_chart_image" height="400" width="100%"/>
                        
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>

                      </div>
                    </div>
                      <!--End model to display size chart -->
<!--                            <input type="hidden" name="parent_id" value="{{ @Input::get('parent_id') }}">-->

                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2">
                            {!! Form::hidden('new_prod_cat',!empty(Input::get('new_prod_cat'))?Input::get('new_prod_cat'):null ,['class'=>'new_prod']) !!}
                            {!! Form::hidden('return_url',null,['class'=>'rtUrl']) !!}
                            <div class="form-group col-sm-12 ">
                                {!! Form::button('Save & Exit',["class" => "btn btn-primary pull-right saveCatExit mobileSpecialfullBTN", "style"=>"margin:left:10px"]) !!}
                                {!! Form::button('Save & Continue',["class" => "btn btn-primary pull-right saveCatContine mobileSpecialfullBTN", "style"=>"margin:left:10px"]) !!}
                                @if($feature['sco']==1)
                                {!! Form::button('Save & Next',["class" => "btn btn-primary pull-right saveCatNext mobileSpecialfullBTN $storeViesion", "style"=>"margin:left:10px"]) !!}
                           @endif
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}  
                </div>
                <div class="toClone" style="display: none;">
                    <div class="clearfix"></div>
                    <div class="CloneImg">
                    <div class="row">
                        <div class="form-group col-md-5">
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
                        <div class="form-group col-md-1">
                            <div class='col-md-12'>
                                <a href = "javascript:void()" class="delImgDiv" data-toggle="tooltip" title="Delete"><i class="fa fa-trash btn-lg btn btn-plen"></i></a>
                            </div>
                        </div>
                      </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<?php  $public_path =Config('constant.sizeChartImgPath');?>
@stop
@section('myscripts')
<script>
   $(document).ready(function () {
         var ids=$("#chart_id").val();
         
         if(ids==0){
           $("#chart_button").addClass('disabled');    
         }
       $('.size_chart_id').change(function(){
          if($("#chart_id").val()==0){
               $("#chart_button").addClass('disabled');
          }else{
               $("#chart_button").removeClass('disabled'); 
          }
       });  
           
         
    $('#chart_button').click(function(){
     
     var id=$("#chart_id").val();  
    if(id !=0){
    
      $.ajax({
            type: "POST",
            url: "{!! route('admin.category.sizeChart') !!}",
            data: {id:id},
            success: function(msg){
                var data = msg;           
                 $('#size_chart_image')
                    .attr('src', "{{$public_path}}/"+data.image);       
                $("#trigger_model").click();
            }
        });
    }
      });  
    });
    
    $(".AddMoreImg").click(function () {
        $(".existingDiv").append($(".toClone").html());
    });
    $("body").on("click", ".delImgDiv", function () {
        //   alert("sdfsdf");
        $(this).parent().parent().parent().remove();
    });
    $(".saveCatExit").click(function () {
        var prodId=$('.new_prod').val();
       // if ($('#category').val() != "") {
       if(prodId){
            $(".rtUrl").val("{!!route('admin.products.general.info',['id'=>Input::get('new_prod_cat')])!!}");
       }else{
            $(".rtUrl").val("{!!route('admin.category.view')!!}");
        }
            $("#CatF").submit();
       // } else {
          //  $('#catnameerror').text('Please enter category name').css({'color': 'red'});
       // }
    });
    $(".saveCatContine").click(function () {
       // if ($('#category').val() != "") {
           
            if("{{Input::get('id')}}" != ''){
               $(".rtUrl").val("{!!route('admin.category.edit',['id'=>Input::get('id')])!!}");  
            }else{
               $(".rtUrl").val("{!!route('admin.category.edit')!!}");  
            }
         
            $("#CatF").submit();
      //  } else {
          //  $('#catnameerror').text('Please enter category name').css({'color': 'red'});
       // }
    });
    $(".saveCatNext").click(function () {
       // if ($('#category').val() != "") {
          if("{{Input::get('id')}}" != ''){
            $(".rtUrl").val("{!!route('admin.category.catSeo',['id'=>Input::get('id')])!!}");  
          }else{
            $(".rtUrl").val("{!!route('admin.category.catSeo')!!}");  
          }
            
            $("#CatF").submit();
        //} else {
           //  $('#catnameerror').text('Please enter category name').css({'color': 'red'});
       // }
    });
   $(document).ready(function () {
        $("#category").keyup(function () {
            var catname = $(this).val();
        $.ajax({
            type: "POST",
            url: "{{ route('admin.category.checkcat') }}",
            data: {catname: catname},
            cache: false,
            success: function (response) {
               
                if (response['status'] == 'success') {
                    $('#category').val('');
                    $('#catnameerror').text(response['msg']).css({'color': 'red'});
                } else
                    $('#catnameerror').text('');
            }, error: function (e) {
                console.log(e.responseText);
            }
        });
     });
 });

</script>
@stop
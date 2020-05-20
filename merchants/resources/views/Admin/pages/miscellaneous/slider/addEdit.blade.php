@extends('Admin.layouts.default')
@section('content')
<section class="content-header">
    <h1>
       Home Page Slider
        <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active"> Home Page Slider </li>
        <li class="active">Add/Edit</li>
    </ol>
</section>  
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                 <div class="box-body">
                {{ Form::model($slider, ['method' => 'post', 'url' => $action ,'files'=> true ]) }}

                <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('title', 'Title',['class'=>'control-label']) }}
                    {{ Form::text('title',null, ["class"=>'form-control' ,"placeholder"=>'Enter title']) }}
                    </div>
                </div>       
                <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('Link', 'Link',['class'=>'control-label']) }}
                    {{ Form::text('link',null, ["class"=>'form-control' ,"placeholder"=>'Enter Link']) }}
                    </div>
                </div>
                <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('Sort Order', 'Sort Order',['class'=>'control-label']) }}
                    {{ Form::text('sort_order',null, ["class"=>'form-control' ,"placeholder"=>'Sort Order']) }}
                    </div>
                </div>
                 <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('Alt', 'Alt',['class'=>'control-label']) }}
                    {{ Form::text('alt',null, ["class"=>'form-control' ,"placeholder"=>'Alt text']) }}
                    </div>
                </div>
                <div class="col-md-6">                
                <div class="form-group">
                    {{ Form::label('Is Active', 'Is Active ? ',['class'=>'control-label']) }}
                    <div class="clearfix"></div>
                    {{ Form::radio('is_active',1,null, []) }} Yes
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    {{ Form::radio('is_active',0,true,[]) }} No
                    </div>
                </div>

                <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('Image', 'Image',['class'=>'control-label']) }}    
                    {{ Form::file('image',["class"=>'form-control',"id"=>"fileupload"]) }}
                    </div>

                    <div class="form-group  showImage" id="dvPreview">
                        <?php
                        if (!empty($slider->image)) {
                            $img = $slider->image;
                            ?>
                            <div class="col-md-2 form-group imgslide">
                                {{ Html::image("public/Admin/uploads/slider/".$img ,'',['class' => "img-responsive"] ) }}
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="col-md-6">
                <div class="form-group">
                    <label for="master_slider" class="control-label">Master Slider</label>
                   <select class="form-control " name="slider_id">
                       <?php foreach ($masterSiders as $key => $value) { ?>

                       <option value="<?php echo $value->id; ?>"><?php echo $value->slider; ?></option>
                       <?php } ?>                   
                   </select>
                   </div>
                </div>

                <div class="col-md-12">
                <div class="form-group">
                {{ Form::hidden('id') }}          
                    <div class="pull-right"> 
                        {{ Form::submit('Submit',["class" => "noLeftMargin btn btn-primary"]) }}
                         {{ Form::close() }}
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
    $(document).ready(function () {
        $(".showImage").hide();

        $("#fileupload").change(function () {
            if (typeof (FileReader) != "undefined") {
                var dvPreview = $("#dvPreview");
                dvPreview.html("");
                //var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
                var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.png|.gif)$");
                $($(this)[0].files).each(function () {
                    var file = $(this);

                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var img = $("<img />");
                        //   img.attr("style", "class => img-responsive");
                        img.attr("src", e.target.result);
                        img.attr("style", "width: 180px");
                        $(".showImage").show();
                        $(".imgslide").hide();
                        dvPreview.append(img);



                    }
                    reader.readAsDataURL(file[0]);

                });
            } else {
                alert("This browser does not support HTML5 FileReader.");
            }
        });
    });
</script>
@stop
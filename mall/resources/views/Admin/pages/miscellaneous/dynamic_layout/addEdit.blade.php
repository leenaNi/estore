@extends('Admin.layouts.default')
@section('content')
<section class="content-header">
    <h1> Home Page 3 Boxes
     <small>Add/Edit</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home Page 3 Boxes</a></li>
         <li class="active"> Home Page 3 Boxes </li>
        <li class="active"> Add/Edit </li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">   
                <div class="box-body">
                    {!! Form::model($layout, ['method' => 'post', 'files'=> true, 'url' => $action ]) !!}
                    {!! Form::hidden('id',null) !!}

                    <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('Name', 'Title',['class'=>'control-label']) !!}
                            {!! Form::text('name',null, ["class"=>'form-control' ,"placeholder"=>'Enter Name', "required",]) !!}
                        </div>
                    </div>

                    <div class="col-md-6">
                     <div class="form-group">
                        {!! Form::label('description', 'Description',['class'=>'control-label']) !!}
                            {!! Form::textarea('description',null, ["class"=>'form-control' ,"placeholder"=>'Enter Description', "required", "rows"=>"1"]) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('Url', 'Url',['class'=>'control-label']) !!}
                            {!! Form::text('url',null, ["class"=>'form-control' ,"placeholder"=>'Enter Url', "required",]) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('Sort Order', 'Sort Order',['class'=>'control-label']) !!}
                            {!! Form::text('sort_order',null, ["class"=>'form-control' ,"placeholder"=>'Enter Name', "required",]) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                    <div class=" form-group">
                        {{ Form::label('Image', 'Image ', ['class'=>'control-label']) }} 
                            {{ Form::file('image',["class"=>'form-control',"id"=>"fileupload"]) }}
                        </div>
                    <?php
                    if (!empty($layout->image)) {
                        $img = $layout->image;
                        ?>
                        <div class="form-group imgslide">
                            {{ Html::image("public/Admin/uploads/layout/".$img ,'',['class' => "img-responsive admin-profile-picture",'required'] ) }}
                        </div>
                        <?php
                    }
                    ?>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('Status', 'Active',['class'=>'control-label']) !!}
                            {!! Form::select('status',[''=>'Please Select','1'=>'Enable','0'=>'Disable'],null,["class"=>'form-control' ,"required"]) !!}
                        </div>                    
                     </div> 
                     <div class="col-md-12">
                    <div class="form-group">
                        <div class="pull-right">
                            {!! Form::submit('Update',["class" => "btn btn-primary noLeftMargin"]) !!}
                            {!! Form::close() !!}     
                            <a class="btn btn-default" href="{{ route('admin.dynamicLayout.view') }}"> Close </a>
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
    $(document).ready(function () {
        $(".showImage").hide();

        $("#fileupload").change(function () {
            if (typeof (FileReader) != "undefined") {
                var dvPreview = $("#dvPreview");
                dvPreview.html("");
                var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
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
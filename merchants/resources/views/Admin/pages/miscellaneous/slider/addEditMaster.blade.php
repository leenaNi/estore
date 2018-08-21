@extends('Admin.layouts.default')
@section('content')
<section class="content-header">
    <h1>
       Sliders
        <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> Sliders </li>
        <li class="active">Add/Edit Master</li>
    </ol>
</section>  
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                {{ Form::model($slider, ['method' => 'post', 'url' => $action ,'files'=> true,]) }}

                <div class="col-sm-6">
                    <div class="form-group">
                        {{ Form::label('slider', 'Title',['class'=>'control-label']) }}
                        {{ Form::text('slider',null, ["class"=>'form-control' ,"placeholder"=>'Enter title' ,'required'=>"true"]) }}
                    </div>
                </div>

                <div class="col-sm-6">
                <div class="form-group">
                    {{ Form::label('Is Active', 'Is Active ? ',['class'=>'control-label']) }}
                    <div class="clearfix"></div>
                    {{ Form::radio('is_active',0,null, []) }} Yes &nbsp;&nbsp;&nbsp;&nbsp;
                    {{ Form::radio('is_active',1,true,[]) }} No
                    </div>
                </div>


                {{ Form::hidden('id') }}

                <div class="col-md-12">
                <div class="form-group">
                    <div class="pull-right">
                    {{ Form::submit('Submit',["class" => "btn btn-primary noLeftMargin"]) }}
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
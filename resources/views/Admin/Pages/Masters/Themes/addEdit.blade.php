@extends('Admin.Layouts.default')

@section('contents')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Add/Edit

    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.masters.themes.view') }}"><i class="fa fa-dashboard"></i>Theme</a></li>
        <li class="active">Add/Edit</li>
    </ol>
</section>
<section class="content">
    <div class="row">


        <div class="col-xs-12">
            <div class="box pt50">
                {{ Form::model($themes, ['route' => ['admin.masters.themes.saveUpdate', $themes->id], 'class'=>'form-horizontal','method'=>'post','files'=>true]) }}
                {{ Form::hidden('id',(Input::get('id')?Input::get('id'):null)) }}
                <div class="box-body">
                    <div class="form-group">
                        {{ Form::label('Category *', 'Category *', ['class' => 'col-sm-3 control-label']) }}
                        <div class="col-sm-6 col-xs-12">
                            {{Form::select('cat_id', $categories ,null, ['class'=>'form-control validate[required]']) }}
                        </div>
                        @if ($errors->has('cat_id'))
                        <div class="error" style="color: red;text-align: center;">{{ $errors->first('cat_id') }}</div>
                        @endif
                    </div>

                    <div class="form-group">
                        {{ Form::label('Theme Category *', 'Theme Category *', ['class' => 'col-sm-3 control-label']) }}
                        <div class="col-sm-6 col-xs-12">
                            {{Form::select('theme_category',['fs1'=>'fs1','fs2'=>'fs2','fs3'=>'fs3'],  null, ['class'=>'form-control validate[required]']) }}
                        </div>
                        @if ($errors->has('theme_category'))
                        <div class="error" style="color: red;text-align: center;">{{ $errors->first('theme_category') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        {{ Form::label('Name *', 'Name *', ['class' => 'col-sm-3 control-label']) }}
                        <div class="col-sm-6 col-xs-12">
                            {{Form::text('name', null, ['class'=>'form-control validate[required]']) }}
                        </div>
                        @if ($errors->has('name'))
                        <div class="error" style="color: red;text-align: center;">{{ $errors->first('name') }}</div>
                        @endif
                    </div>

                    <div class="form-group">
                        {{ Form::label('Status *', 'Status *', ['class' => 'col-sm-3 control-label']) }}
                        <div class="col-sm-6 col-xs-12">
                            {{Form::select('status',['1'=>'Enabled','2'=>'Disabled'],null ,['class'=>'form-control  validate[required]']) }}
                        </div>
                        @if ($errors->has('status'))
                        <div class="error" style="color: red;text-align: center;">{{ $errors->first('status') }}</div>
                        @endif
                    </div>

                    <div class="form-group">
                        {{ Form::label('theme_type *', 'Theme Type *', ['class' => 'col-sm-3 control-label']) }}
                        <div class="col-sm-6 col-xs-12">
                            {{Form::select('theme_type',['1'=>'Free','2'=>'Paid'],null ,['class'=>'form-control','placeholder'=>'select Theme Type']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('sort_order', 'Sort Order *', ['class' => 'col-sm-3 control-label']) }}
                        <div class="col-sm-6 col-xs-12">
                            {{Form::text('sort_orders',null ,['class'=>'form-control','placeholder'=>'Sort Order']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <?php
                        $display_img = [];
                        $display_img['class'] = 'form-control themeFUp';
                        if (empty(Input::get('id')))
                            $display_img['validate["required"]'] = true;
                        ?>
                        {{ Form::label('Display Image', 'Display Image *', ['class' => 'col-sm-3 control-label']) }}
                        <div class="col-sm-6">
                            {{Form::file('image', $display_img) }}
                        </div>
                    </div>
                    <div class="existingImg">
                        <div class="form-group">
                            <div class="col-sm-3 col-sm-offset-3">
                                <?php
                                if (!empty($themes->image)) {
                                    $slogo = asset('public/admin/themes/') . "/" . @$themes->image;
                                } else {
                                    $slogo = asset('public/admin/themes/') . "/default-theme.png";
                                }
                                ?>

                                <img src="{{ $slogo }}" class="displayImage img-responsive" style="width: 100%;">
                            </div>
                        </div>
                        <label>Home Page Banners</label>

                        <?php
                        if (!empty($themes->banner_image)) {

                            $threeBox = json_decode(($themes->banner_image), true);

                            foreach ($threeBox as $key => $box) {

                                $threeBoxlogo = asset('public/admin/themes/') . "/" . @$box['banner'];
                                ?>
                                <div class="row form-group">   
                                    <input type="hidden" name="rowid[]" value="{{$key}}">
                                    <input type="hidden" name="slectedImage[]" value="{{@$box['banner']}}">
                                    <div class="col-sm-2 text-right">
                                        <img src="{{$threeBoxlogo }}" class="bannerImage" id="img_{{$key}}" height="40%" width="60%"> 
                                    </div>
                                    <div class="col-sm-2">
                                        <input  name="banner[]" type="file" id="{{$key}}" class="form-control bannerImages filestyle "  data-input="false">
                                    </div>
                                    <div class="col-sm-2">
                                        {!! Form::text('sort_order[]',$box['sort_order'], ["class"=>'form-control ' ,"placeholder"=>'Sort Order']) !!}

                                    </div>
                                    <div class="col-sm-2">
                                        {{ Form::select("banner_status[]",["1"=>"Enabled","0"=>"Disabled"],$box['banner_status'],['class'=>'form-control']) }}
                                    </div>

                                    <div class="col-sm-2">
                                        {{ Form::text("banner_text[]",$box['banner_text'],['class'=>'form-control',"placeholder"=>'Default  Text']) }}
                                    </div>
                                    <a href="javascript:void();"  data-toggle="tooltip" title="Add New" class="addMoreImg"><i class="fa fa-plus btn btn-lg btn-plen"></i></a> 
                                    <a href="{{ route('admin.masters.themes.deleteBanner') }}?rowid={{$key}}&id={{$themes->id}}"><i class="fa fa-trash btn btn-lg btn-plen"></i></a>    
                                </div>        

                            <?php }
                        } else { ?>
                            <div class="row form-group">
    <?php $row = rand(); ?>
                                <div class="col-sm-2 text-right">
                                    <img src="{{$row}}" class="bannerImage" id="img_{{$row}}" height="40%" width="60%"> 
                                </div>
                                <div class="col-sm-2">

                                    <input type="hidden" name="rowid[]" value="{{$row}}">
                                    <input  name="banner[]" type="file" class="form-control bannerImages filestyle"  id="{{$row}}" data-input="false">
                                    <input type="hidden" name="exists" value="0">
                                    <!-- <input  name="images[]" type="file"imd_123 class="form-control"  > -->
                                </div>

                                <div class="col-sm-2">
                                    {!! Form::text('sort_order[]',null, ["class"=>'form-control ' ,"placeholder"=>'Sort Order']) !!}

                                </div>
                                <div class="col-sm-2">
                                    {{ Form::select("banner_status[]",["1"=>"Enabled","0"=>"Disabled"],null,['class'=>'form-control']) }}
                                </div>
                                <div class="col-sm-2">
                                    {{ Form::text("banner_text[]",null,['class'=>'form-control',"placeholder"=>'Default  Text']) }}
                                </div>

                                <a href="javascript:void();"  data-toggle="tooltip" title="Add New" class="addMoreImg"><i class="fa fa-plus btn btn-lg btn-plen"></i></a> 
                            </div>


<?php } ?>

                    </div>
                </div>

                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-3 col-md-offset-3 text-left">
                            {{Form::submit('Save & Exit', ['class'=>'btn btn-info mr10']) }}
                        </div>
                    </div>
                </div>


                {{ Form::close() }}
            </div>
        </div>
        <!--          <div class="addNew" style="display: none;">
<?php $row1 = rand(); ?>
                            <div class="row form-group">
                                <input type="hidden" name="rowid[]" value="{{$row1}}">
                                <div class="col-sm-2">
                                 <img src="{{$row1}}" class="bannerImage" id="img_{{$row1}}" height="40%" width="60%"> 
                                </div>
                                <div class="col-sm-2">
                                  <input  name="banner[]" type="file" class="form-control bannerImages filestyle" id="{{$row1}}" data-input="false">
        
                                </div>
                                <div class="col-sm-2">
                                            {!! Form::text("sort_order[]",null, ["class"=>"form-control" ,"placeholder"=>"Sort Order"]) !!}
                                            
                                </div>                       
                                <div class="col-sm-2">
                                            {{ Form::select("banner_status[]",[""=>"Select Status","1"=>"Enabled","0"=>"Disabled"],null,["class"=>"form-control"]) }}
                                        </div>
                                <div class="col-sm-1">
                                  
                                    <a href="javascript:void();"  data-toggle="tooltip" title="Delete" class="deleteImg"><i class="fa fa-trash btn-lg btn btn-plen"></i></a> 
                                </div>
                            </div> 
                        </div>-->
    </div>
</section>
<!-- /.content -->

@stop

@section('myscripts')
<script>

    $(".addMoreImg").click(function() {
    var rand = Math.floor(Math.random() * 90000) + 10000;
    //alert(rand);
    var addNew = '';
    addNew += '<div class="addNew"><div class="row form-group"><input type="hidden" name="rowid[]" value="' + rand + '"><div class="col-sm-2"><img src="test" class="bannerImage" id="img_' + rand + '" height="40%" width="60%"></div> <div class="col-sm-2"><input  name="banner[]" type="file" class="form-control bannerImages filestyle" id="' + rand + '" data-input="false"></div> <div class="col-sm-2"> {!! Form::text("sort_order[]",null, ["class"=>"form-control" ,"placeholder"=>"Sort Order"]) !!}</div><div class="col-sm-2"> {{ Form::select("banner_status[]",[""=>"Select Status","1"=>"Enabled","0"=>"Disabled"],null,["class"=>"form-control"]) }}</div> <div class="col-sm-2"> {{ Form::text("banner_text[]",null,['class'=>'form - control',"placeholder"=>'Default  Text']) }}</div><div class="col-sm-1"> <a href="javascript:void();"  data-toggle="tooltip" title="Delete" class="deleteImg"><i class="fa fa-trash btn-lg btn btn-plen"></i></a></div></div></div>';
    $(".existingImg").append(addNew);
    });
    $("body").on("click", ".deleteImg", function() {

    //   alert("sdfsdf");
    $(this).parent().parent().remove();
    });
    function readURL(input) {

    if (input.files && input.files[0]) {
    var reader = new FileReader();
    console.log(reader);
    reader.onload = function (e) {
    $('.displayImage').attr('src', e.target.result);
    };
    reader.readAsDataURL(input.files[0]);
    } else {
    $('.displayImage').attr('src', "{{$slogo}}");
    }
    }


    $(".themeFUp").change(function () {
    readURL(this);
    });
    $(document).on('change', '.bannerImages', function(e) {

    readURL1(this);
    });
    function readURL1(input) {
    var id = $(input).attr('id');
    if (input.files && input.files[0]) {
    var reader = new FileReader();
    console.log(reader);
    reader.onload = function (e) {
    $('#img_' + id).attr('src', e.target.result);
    };
    reader.readAsDataURL(input.files[0]);
    }
    }
//    $("#themeForm").validate({
//        rules: {
//            cat_id: {
//                required: true
//
//            },
//            status: {
//                required: true
//
//            }, name: {
//                required: true
//            }
//            
//        },
//        messages: {
//            cat_id: {
//                required: "Category is required."
//            },
//            status: {
//                required: "Status is required."
//            },
//            name: {
//                required: "Name is required."
//            },
//            image:{
//                required:"Display Image is required."
//            }
//        },
//        errorPlacement: function (error, element) {
//            var name = $(element).attr("name");
//            var errorDiv = $(element).parent();
//            errorDiv.append(error);
//            //  error.appendTo($("#" + name + "_login_validate"));
//        }
//
//    });


</script>
@stop
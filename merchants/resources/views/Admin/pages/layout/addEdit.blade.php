@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
       {{$layout->name}}

        <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"><a href="{{route('admin.dynamic-layout.view',['slug'=>$layout->url_key]) }}" >  {{$layout->name}}</a>  </li>
        <li class="active">Add/Edit</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div>
            <p style="color: red;text-align: center;">{{ Session::get('messege') }}</p>
        </div>

        <div class="col-md-12">
            <div class="box">
                <div class="box-body">


                    {!! Form::model($layoutPage, ['method' => 'post', 'files'=> true, 'url' => $action,'id'=>'addSlider' ] ) !!}

                    <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('page_name', 'Banner Text ',['class'=>'control-label']) !!}
                        {!! Form::hidden('id',null) !!}
                        {!! Form::hidden('store_id', Session::get('store_id')) !!}
                            {!! Form::text('name',null, ["class"=>'form-control ',"id"=>'page_name' ,"placeholder"=>'Banner Text']) !!}
                          {!! Form::hidden('layout_id',$layout->id, array('id' => 'layout_id')) !!}
                          {!! Form::hidden('url',$layout->url_key) !!}
                        </div>
                    </div>
                           <div class="col-md-6">

                    <div class="form-group">
                         {!!Form::label('link','Link ',['class'=>'control-label']) !!}
                        {!! Form::text('link',null, ["class"=>'form-control validate[custom[url]]',"id"=>'link' ,"placeholder"=>'Link']) !!}

                              <p id="url_error" style="color:red"></p>
                        </div>

                    </div>


<input type="hidden" name="desc" value=" ">


                     <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('sort_order', 'Sort Order',['class'=>'control-label']) !!}
                            {!! Form::number('sort_order',null, ["class"=>'form-control',"id"=>'status' ,"placeholder"=>'Sort Order']) !!}
                        </div>
                    </div>
                     <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('is_active', 'Status ',['class'=>'control-label']) !!} <span class="red-astrik"> *</span>
                            {!! Form::select('is_active',["0"=>"Disabled","1"=>"Enabled"],null, ["class"=>'form-control validate[required]',"id"=>'status' ,"placeholder"=>'Select Status']) !!}

                        </div>
                    </div>
                     <div class="clearfix"></div>
                    <div class="col-md-6">
                    <div class="form-group">
                        <?php
$img_dim = '';
if ($layout->id == 1) {
    $img_dim = "(1920px W X 1080px H)";
}

if ($layout->id == 4) {
    $img_dim = "(548px W X 308px H)";
}

?>
                        {!!Form::label('image','Image '.$img_dim ,['class'=>'control-label ']) !!}
                        <span class="red-astrik">*</span>
                            <input type="file" name="sliderImg" id="sliderImg"  class="form-control"   />
                            <input type="hidden" name="old_image" value="{{$layoutPage->image}}">

                            <!-- <img id="select_image" src="#" alt="Selected Image" style="display: none;" /> -->
<!--                            <span type="button"  class="label label-danger delimg" style="cursor: pointer;" >Delete</span>-->

                        </div>
                         <span id="error-banner" class="text-danger"></span>
                    </div>
                    @if(!empty($layoutPage->image))
                    <div class="col-md-3">
                        <img src="{{  asset(Config('constants.layoutUploadPath').$layoutPage->image)}}" width="150" height="80" />
                     </div>
                     @endif
                    <div class="clearfix"></div>

                        <div class="col-md-6">
                            <div class="form-group">
                               <div class="box-2">
                                  <div class="result-slider" style="height: 350px"></div>
                              </div>
                               <div class="options-slider hide"> </div>
                            </div>
                        </div>
                    <div class="clearfix"></div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="pull-right">
                                {!! Form::submit('Submit',["class" => "btn btn-primary noLeftMargin","id"=>"saveSlider"]) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@stop

@section('myscripts')
<script src="{{ asset('public/Admin/plugins/ckeditor/ckeditor.js') }}"></script>

<script>
//Banner Cropping script
console.log($("#layout_id").val());

var widthSlider=0, heightSlider=0;
if($("#layout_id").val() == 1)
{
    widthSlider = 1920; heightSlider=1080;
}
else if($("#layout_id").val() == 4)
{
    widthSlider = 548; heightSlider=308;
}

var resultSlider = document.querySelector('.result-slider'),
        save = document.querySelector('#saveSlider'),
        upload = document.querySelector('#sliderImg'),
        cropper = '';
// on change show image with crop options
upload.addEventListener('change', function (e) {
    if (e.target.files.length) {
        // start file reader
        var reader = new FileReader();
        reader.onload = function (e) {
            if (e.target.result) {
                // create new image
                var img = document.createElement('img');
                img.id = 'image';
                img.src = e.target.result;
                // clean result before
                resultSlider.innerHTML = '';
                resultSlider.appendChild(img);
                //console.log(resultSlider);
                // init cropper

                cropper = new Cropper(img, {
                    aspectRatio: 1.77,
                    dragMode: 'move',
                    cropBoxMovable: true,
                    cropBoxResizable: true,
                    zoom: -0.1,
                    built: function () {
                        $toCrop.cropper("setCropBoxData", {width: widthSlider, height: heightSlider});
                    }
                });
            }
        };
        reader.readAsDataURL(e.target.files[0]);
    }
});
// save on click
$('#saveSlider').on('click', function (e) {
    e.preventDefault();
    if($("#sliderImg").val() != '')
    {
        var fileUpload = $("#sliderImg")[0];
        //Check whether the file is valid Image.
        var imageExt = fileUpload.value.split('.');
        var validImageTypes = ["gif", "jpeg", "jpg", "png","bmp"];

       // var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.gif)$");
        //if (regex.test(fileUpload.value.toLowerCase())) {
        if ($.inArray(imageExt[1], validImageTypes) == true || $.inArray(imageExt[1], validImageTypes) != -1) {    
            //Check whether HTML5 is supported.
            if (typeof (fileUpload.files) != "undefined") {
                var form = $('#addSlider');
                var formdata = false;
                if (window.FormData) {
                    formdata = new FormData(form[0]);
                }
                var ImageURL = cropper.getCroppedCanvas({
                    width: widthSlider // input value
                }).toDataURL();
                formdata.append("slider_img_url", ImageURL);
                $.ajax({
                    url: "{{route('admin.dynamic-layout.save')}}",
                    type: 'post',
                    data: formdata,
                    processData: false,
                    contentType: false,
                    success: function (res) {
                       // console.log("success");
                        console.log(res);
                        history.go(-1);
                        //window.location.href = res ;
                        //$("#addNewSliderImage").modal('hide');
                       // $("#manageSlider").load(location.href + " #manageSlider>", "");
                    }
                });
            } else
            {
                $("#error-banner").html("This browser does not support HTML5.");
                return false;
            }
        } else
        {
            $("#error-banner").html("Please select a valid Image file.");
            return false;
        }
    }else{
        $('#addSlider').submit();
    }

});</script>


<script>

    // $(".delimg").on("click",function(){
    //     $("#select_image").hide();
    //     $(".delimg").hide();
    //     $("input[name='old_image']").val("");

    // });

    function is_validUrl(url1)
{
      $('#url_error').html('')
  var url=(url1.value);
        var result= url.match(/^(ht|f)tps?:\/\/[a-z0-9-\.]+\.[a-z]{2,4}\/?([^\s<>\#%"\,\{\}\\|\\\^\[\]`]+)?$/);
        if(result==null){
            $('#url_error').html("Please Enter a valid url");
           return false;
        }else{
            return true;
        }
}
  //  CKEDITOR.replace( 'description' );
    function readURL(input) {
          $(".delimg").show();
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#select_image')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(200);
            };

            reader.readAsDataURL(input.files[0]);
            $("#select_image").show();
        }
    }


   @php
        if($layoutPage->image){
            @endphp
            $('#select_image')
                    .attr('src', "{{asset(Config('constants.layoutUploadPath')).'/'.$layoutPage->image}}")
                    .width(150)
                    .height(200);
            $("#select_image").show();
            @php
        }
    @endphp
//   $(document).ready(function(){
//    ("#img").click(function () {
//       ("#select_image").remove();
//    });
//});
//





</script>



@stop

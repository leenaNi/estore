@extends('Admin.layouts.default')
@section('content')
<style>  
    .box-2 {
        padding: 0.5em;
        width: calc(100%/2 - 1em);
    }
    .options label, .options input{ width:4em; padding:0.5em 1em; }
    .result-logo1 {
        width: 400px; height: 200px;
    }
    .cropper-container.cropper-bg {
        width: 400px !important;
        height: 200px !important;
    }

</style>

<script src="{{  Config('constants.adminPlugins').'/jQuery/jQuery-2.1.4.min.js' }}"></script>
<section class="content-header">
    <h1>

        Store Setting
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Store Setting</li>
    </ol>
</section>

<?php
$jsonString = App\Library\Helper::getSettings();
$data = (object) $jsonString;
//    print_r($data);
?>


<?php
if (isset($data->expiry_date)) {
    $datetime1 = new DateTime($data->expiry_date);
    $datetime2 = new DateTime(date('y-m-d'));
    $diff = $datetime1->diff($datetime2);
    if (date('Y-m-d', strtotime($data->expiry_date)) < date('Y-m-d')) {
        echo "<b><i><u style='color:red;' class='pull-right'> Your store has been expired.</u></i></b>";
    } else if (($diff->days) < 30 && ($diff->days > 0)) {
        echo "<p>Your Store is gogin to Expire On:" . $data->expiry_date . "</p>";
        echo "<b><i><u>Your store will get expire after " . $diff->days . " days.</u></i></b>";
    }
}
?>


<!--<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.4/cropper.min.css'>-->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <div class="col-md-6">
                        <form id="store_settings_save" enctype="multipart/form"> 
                            <div class="form-group">
                                <label>Logo (170px W X 100px H)</label>

                                <input type="file"  name="logo_img" id="logoF1" class="form-control">
                            </div>
                            <div class="form-group logo-store">
                                <div class="box-2">
                                    <div class="result-logo1"></div>
                                </div>
                                <div class="options hide">                      
                                </div>
                            </div>

                            <div class="text-center col-md-12 topmargin-sm custom-chooselogo storeSettingORBox">
                                <div class="text-center storeSettingOR">or</div>
                                <a href="https://www.logocrisp.com/logomaker/" target="_blank" class="btn btn-default btn-success">Auto Logo Generator</a>
                                <p class="nobottommargin topMargin5">Note: This is a third party feature and it is paid.</p>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group">
                                <label>Store Name </label><span class="red-astrik"> *</span>
                                <input type="text" id="store_name" value="{{ $data->storeName }}" name="store_name" class="form-control validate[required]">
                            </div>
                            <div class="form-group">
                                <label> Primary Theme Color</label><span class="red-astrik"> *</span>
                                <input type="text" id="primary_color" value="{{ $data->primary_color }}"  name="primary_color" class="form-control jscolor validate[required]">
                            </div>
                            <div class="form-group">
                                <label> Left Menu Background Color </label><span class="red-astrik"> *</span>
                                <input type="text" id="secondary_color" value="{{ $data->secondary_color }}"  name="secondary_color" class="form-control jscolor validate[required]">
                            </div>

                            <div class="form-group">
                                <label>Primary Button Color </label><span class="red-astrik"> *</span>
                                <input type="text" id="btn_color" value="{{ @$data->btn_color }}"  name="btn_color" class="form-control jscolor validate[required]">
                            </div>

                            <div class="form-group">
                                <label>Secondary Button Color </label><span class="red-astrik"> *</span>
                                <input type="text" id="sbtn_color" value="{{ @$data->sbtn_color }}"  name="sbtn_color" class="form-control jscolor validate[required]">
                            </div>

                            <!--                  <div class="form-group">
                                                <label>Standard Delivery Days</label>-->
                            <input type="hidden" id="standard_delivary_days" value="{{ $data->standard_delivary_days }}"  name="standard_delivary_days" class="form-control">

                            <!--                </div>-->
                            <!-- 
                            <div class="form-group">
                                <label>COD Option Available</label>
                                <select name="cod_option" value="{{ $data->cod_option }}" class="form-control" >
                                    <option value="1" {{ $data->cod_option==1?'selected':'' }}  >Yes </option>
                                    <option  value="0" {{ $data->cod_option ==0 ? 'selected' : ''}}  >No </option>
                                </select>
                               
                            </div> -->

                            @if($settingStatus['27'] == 1) 
                            <div class="form-group">
                                <label>Store Admin Language</label>
                                <select name="language"  class="form-control" >
                                    @foreach($languages as $language1)
                                    @if($language1->name == 'English')
                                    <option value="{{$language1->name}}" {{ $data->language== $language1->name?'selected':'' }}   >{{$language1->name}} </option>
                                    @endif
                                    @endforeach
                                </select>

                            </div>
                            @endif

                            <div class="form-group">
                                <label>Store Version</label>
                                <select class="form-control"  name="store_version">
                                    <option value="1"  <?= ($data->store_version == 1) ? 'selected' : ''; ?>  >Starter Version</option>
                                    <option value="2" <?= ($data->store_version == 2) ? 'selected' : ''; ?> >Advance Version</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Store Currency</label>
                                <select name="currency"  class="form-control" >

                                    @foreach($currency as $currency1)

                                    <option value="{{$currency1->iso_code}}" {{ $data->currencyId== $currency1->iso_code?'selected':'' }} >{{$currency1->currency_code." - ".$currency1->currency_name}} </option>

                                    @endforeach
                                </select>

                            </div>
                            <div class="form-group">
                                <label>Theme</label>
                                <select name="theme"  class="form-control themes validate[required]"  >

                                    @foreach($themes as $k => $t)

                                    <optgroup label="{{$k}}">
                                        @foreach($themes[$k] as $th)
                                        <?php $selected = strtolower($data->theme) == strtolower($th['name']) ? 'selected' : ''; ?> 
                                        <option value="{{$th['id']}} " {{$selected}} >{{$th['name']}} </option>
                                        @endforeach
                                    </optgroup>
                                    @endforeach
                                </select>

                            </div>
                            <div class="form-group" id='demo'>

                            </div>

                            <div class="form-group">
                                <input type="submit" value="Save" id="saveLogo1" class="btn noLeftMargin btn-primary pull-left">
                            </div>
                        </form>
                    </div><!-- /.col -->
                    <div class="col-md-6" >
                        <img src="{{ $data->logo }}" height="100" width="150" id="image_upload_preview" />           

                    </div>
                    <!--{
                        "primary": "fff",
                        "secondary": "fff",
                        "store_name": "Cartini",
                        "logo_path" : ""
                    }-->

                </div> 
            </div>
        </div>
    </div>
</section>
@stop 
@section('myscripts')
<!--<script src='https://cdnjs.cloudflare.com/ajax/libs/cropperjs/0.8.1/cropper.min.js'></script>-->
<script>
$(document).ready(function () {
    $(".logo-store").hide();
    // vars
    var result = document.querySelector('.result-logo1'),
            // img_result = document.querySelector('.img-result'),
            //img_w = document.querySelector('.img-w'),
            // img_h = document.querySelector('.img-h'),
            options = document.querySelector('.options'),
            save = document.querySelector('#saveLogo1'),
            cropped = document.querySelector('.cropped'),
            dwn = document.querySelector('.download'),
            upload = document.querySelector('#logoF1'),
            cropper = '';

// on change show image with crop options
    upload.addEventListener('change', function (e) {
        $(".logo-store").show();
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
                    result.innerHTML = '';
                    // append new image
                    result.appendChild(img);
                    // show save btn and options
                    save.classList.remove('hide');
                    options.classList.remove('hide');
                    // init cropper
                    cropper = new Cropper(img, {
                        aspectRatio: 1.70,
                        dragMode: 'move',
                        cropBoxMovable: true,
                        cropBoxResizable: true,
                        zoom: -0.1,
                        built: function () {
                            $toCrop.cropper("setCropBoxData", {width: "170", height: "100"});
                        }
                    });
                }
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    });

// save on click
    save.addEventListener('click', function (e) {
        e.preventDefault();
        var form = $('#store_settings_save');
        var formdata = false;
        if (window.FormData) {
            formdata = new FormData(form[0]);
        }

        if ($("#logoF1").val() == "")
        {
            formdata.append("logo_img_url", '');
            $.ajax({
                url: "{{ route('admin.storeSetting.add') }}",
                type: 'post',
                data: formdata,
                processData: false,
                contentType: false,
                //   dataType: 'json',
                beforeSend: function () {
                    // $("#barerr" + id).text('Please wait');
                },
                success: function (res) {
                    //  alert(res);
                    window.location.href = "";
                }
            });
        }
        else
        {
            var fileUpload = $("#logoF1")[0];
            //Check whether the file is valid Image.
            console.log(fileUpload.value.toLowerCase());
            //var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.gif)$");
            if ((/\.(gif|jpg|jpeg|tiff|png)$/i).test(fileUpload.value.toLowerCase())) {
                //if (regex.test(fileUpload.value.toLowerCase())) {
                //Check whether HTML5 is supported.
                if (typeof (fileUpload.files) != "undefined") {

                    var ImageURL = cropper.getCroppedCanvas({
                        width: 170 // input value
                    }).toDataURL();
                    formdata.append("logo_img_url", ImageURL);
                    console.log(ImageURL);
                    $.ajax({
                        url: "{{ route('admin.storeSetting.add') }}",
                        type: 'post',
                        data: formdata,
                        processData: false,
                        contentType: false,
                        //   dataType: 'json',
                        beforeSend: function () {
                            // $("#barerr" + id).text('Please wait');
                        },
                        success: function (res) {
                            console.log(res);
                            window.location.href = "";
                        }
                    });

                }
                else
                {
                    $("#error-logo").html("This browser does not support HTML5.");
                    return false;
                }
            }
            else
            {
                $("#error-logo").html("Please select a valid Image file.");
                return false;
            }
        }


    });



    $(".themes").on('change', function () {
        $('#demo').empty();
        var theme = $(".themes option:selected").text();
        var url = "{{route('home')}}" + '/themes/' + (theme.toLowerCase()).trim() + '_home.php';
        $('#demo').append('<button id="viewDemo" class="btn btn-primary" ><a href="' + url + '" target="_blank">view Demo</a></button>');
        //alert("{{route('home')}}"+'/themes/'+(theme.toLowerCase()).trim()+'_home.php');
    });

    function readImage(inputElement) {
        var deferred = $.Deferred();

        var files = inputElement.get(0).files;
        if (files && files[0]) {
            var fr = new FileReader();
            fr.onload = function (e) {
                deferred.resolve(e.target.result);
            };
            fr.readAsDataURL(files[0]);
        } else {
            deferred.resolve(undefined);
        }

        return deferred.promise();
    }
});
</script>
@stop


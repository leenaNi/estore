@extends('Admin.layouts.default')
@section('content')


<section class="content-header">
    <div class="flash-message"><b>{{ Session::get("ProductCode") }} {{ Session::get("errorMessage") }}</b></div>
    <h1>
        Products

    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Products</li>
        <li class="active">Add/Edit</li>
    </ol>
</section>


<section class='content'>

    <div class="nav-tabs-custom"> 
        {!! view('Admin.includes.productHeader',['id' => $prod->id, 'prod_type' => $prod->prod_type]) !!}
        <div class="tab-content">
            <div class="tab-pan-active" id="activity">

                <div class="panel-body">
                    {!! Form::model($images, ['method' => 'post', 'files' => true, 'url' => $action ,'id'=>'CataLogImg' ,'class' => 'form-horizontal','files'=>true ]) !!}
                    {!! Form::hidden('id',null) !!}
                    {!! Form::hidden('updated_by', Auth::id()) !!}
                    {!! Form::hidden('prod_id',$prod->id) !!}

                    <p class="successDel" style="color:green;"></p>

                    <div class="form-group">



                        <?php
                        $prodImages = $prod->catalogimgs()->where("image_type", "=", 1)->get();
                //dd($prodImages);
                        ?>
                        <div class="col-sm-11 existingImg">
                            @if($prodImages->count()>0)
                            <?php $mode = 0; ?>
                            @foreach($prodImages as $key=>$prodimg)

                            <div class="row form-group">
                                <div class="col-sm-1">
                                    <img src="{{Config('constants.productImgPath')."/".$prodimg->filename}}" class="img-responsive thumbnail"   >
                                </div>
                                <div class="col-sm-4">
                                   
                                    <input name="images[]" type="file" class="form-control filestyle image_up " data-id="{{ $prodimg->id }}" data-input="false" id="{{ $mode }}">
                                  <input type="hidden" name="extimg[]" value="{{$prodimg->filename}}">
                                  <input type="hidden" name="prod_img_url_{{ $mode }}" value="" class="prod_img_url_{{ $mode }}">
                                  
                                </div>                               


                                <div class="col-sm-2">
                                    {!! Form::text('sort_order[]',$prodimg->sort_order, ["class"=>'form-control validate[required,custom[number]]' ,"placeholder"=>'Sort Order *']) !!}
                                </div>
                                <div class="col-sm-3">
                                    {!! Form::text('alt_text[]',$prodimg->alt_text,["class"=>'form-control validate[required]' ,"placeholder"=>'Alt Text *']) !!}
                                </div>
                                <div class="col-sm-1">
                                    <a  data-value="{!! $prodimg->id !!}" href="javascript:void();" class="DelImg" data-toggle="tooltip" title="Delete"><i class="fa fa-trash btn-lg btn btn-plen"></i></a> 
                                </div>
                                {!! Form::hidden('id_img[]',$prodimg->id) !!}
                                {!! Form::hidden('filename[]',$prodimg->filename) !!}
                                {!! Form::hidden('file_upload_status[]',0,["class" => "image_temp image_temp$prodimg->id"]) !!}
                                <div class="clearfix"></div>
                               <div class="error-product-{{$mode}}" class="text-danger" style="float:left;color:red"></div>
                                <div class="col-md-6">
                                    <div class="product-result-{{$mode}}" style="max-width: 400px; max-height: 250px">
                                        
                                    </div>
                                </div>
                            </div>
                            <?php $mode++; ?>
                            @endforeach
                            @else

                            <div class="row form-group">
                                <div class="col-sm-1">
                                </div>
                                <div class="col-sm-4">
                                    <input  name="images[]" id="0" type="file" class="form-control filestyle image_up validate[required]"  data-input="false"><span class="span-mand span-mand-setright"> *</span>
                                </div>

                                <div class="col-sm-2">
                                    {!! Form::text('sort_order[]',null, ["class"=>'form-control validate[required,custom[number]]' ,"placeholder"=>'Sort Order']) !!}
                                    <span class="span-mand span-mand-setright"> *</span>
                                </div>
                                <input type="hidden" name="prod_img_url_0" value="" class="prod_img_url_0">
                                <div class="col-sm-3">
                                    {!! Form::text('alt_text[]',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Alt Text', ]) !!}
                                <span class="span-mand span-mand-setright"> *</span>
                                </div>
                                <div class="clearfix"></div>
                               <div class="error-product-0" class="text-danger" style="float:left;color:red"></div>
                                <div class="col-md-6">
                                    <div class="product-result-0" style="max-width: 400px; max-height: 250px">                                        
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="col-sm-1">
                            {!! Form::hidden('file_upload_status[]',1) !!}
                            {!! Form::hidden('id_img[]',null) !!}
                            <a href="#"  data-toggle="tooltip" title="Add New" class="addMoreImg"><i class="fa fa-plus btn btn-lg btn-plen"></i></a> 
                        </div>

                    </div>
                    <div class="form-group">
                        {!! Form::hidden('return_url',null,['class'=>'rtUrl']) !!}
                        <div class="form-group col-sm-12 ">
                            {!! Form::button('Save & Exit',["class" => "btn btn-primary pull-right saveImgExit"]) !!}
                            {!! Form::button('Save & Continue',["class" => "btn btn-primary pull-right saveImgContine"]) !!}
                            {!! Form::button('Save & Next',["class" => "btn btn-primary pull-right saveImgNext"]) !!}
                        </div>


                        <div class="col-sm-4 col-sm-offset-2">

                            {!! Form::close() !!}     
                        </div>
                    </div>

                </div>
                <!-- <div class="addNew" style="display: none;">

                    <div class="row form-group">
                        <div class="col-sm-1">
                        </div>
                        <div class="col-sm-4">
                          <input  name="images[]" type="file" class="form-control filestyle validate[required]" data-input="false"><span class="span-mand  span-mand-setright">*</span>

                        </div>



                        <div class="col-sm-2">
                            {!! Form::text('sort_order[]',null, ["class"=>'form-control validate[required,custom[number]]' ,"placeholder"=>'Sort Order']) !!}
                        </div>
                        <div class="col-sm-3">
                            {!! Form::text('alt_text[]',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Alt Text']) !!}
                        </div>
                        <div class="col-sm-1">
                            {!! Form::hidden('id_img[]',null) !!}
                            {!! Form::hidden('filename[]','') !!}
                            {!! Form::hidden('file_upload_status[]',1) !!}
                            <a href="javascript:void();"  data-toggle="tooltip" title="Delete" class="deleteImg"><i class="fa fa-trash btn-lg btn btn-plen"></i></a> 
                        </div>
                    </div> 
                    <div class="clearfix"></div>
                    <div class="col-md-12">
                        <div class="cropperImgBox">
                            sdsd
                        </div>
                    </div>
                </div> -->



            </div>
        </div>
    </div>

</section>

@stop 

@section('myscripts')
<script>
  function getobjCrop(img){
        var crop = new Cropper(img, {
                    aspectRatio: 1,
                    dragMode: 'move',
                    cropBoxMovable: true,
                    cropBoxResizable: false,
                    zoom: -0.1,
                    built: function () {
                        $toCrop.cropper("setCropBoxData", {width: "1000", height: "1000"});
                    }
                });

        return crop;

    }

    function redirectToURL(className)
    {        
        if(className.indexOf('saveImgExit') != -1){
            $(".rtUrl").val("{!!route('admin.products.view')!!}");
            $('#CataLogImg').submit();
        }
        if(className.indexOf('saveImgContine') != -1){
            $(".rtUrl").val("{!!route('admin.products.images',['id'=>Input::get('id')])!!}");
            $("#CataLogImg").submit();
        }
        if(className.indexOf('saveImgNext') != -1){
          var like_product = "{{ $feature['like-product'] }}";
              var sco = "{{ $feature['sco'] }}";
              var storeversion = "{{ $store_version_id }}";
            var related_prod = "{{ $feature['related-products']}}";
            var prod_type = "{{ $prod->prod_type }}";
            var feature = '<?= $feature["market-place"] ?>';
            console.log(feature + "----" +prod_type );
            //if(feature == 1 && prod_type == 3){
            if(prod_type == 3){
            $(".rtUrl").val("{!!route('admin.products.configurable.attributes',['id'=>Input::get('id')])!!}");
           
            }else if(feature == 1 && prod_type == 1){
              $(".rtUrl").val("{!!route('admin.product.vendors',['id'=>$prod->id])!!}");
        
            }else if(feature == 0 && related_prod == 1){
              $(".rtUrl").val("{!! route('admin.products.upsell.related',['id' => $prod->id]) !!}");    
            }else if(feature==0 && like_product==1){
               $(".rtUrl").val("{!! route('admin.products.upsell.product',['id'=>$prod->id])!!}");              
            }else if(feature==0 && sco==1 && storeversion==2){
               $(".rtUrl").val("{!! route('admin.products.prodSeo',['id'=>$prod->id])!!}");   
            }else{
                 $(".rtUrl").val("{!!route('admin.products.view')!!}");
            }
            $("#CataLogImg").submit();
        }
    }
var cropperArr ={};
var myarr = [];
var counter = "{{ ($prodImages->count() >0) ? ($prodImages->count()- 1) : 0  }}";
console.log('foreach counter---'+ counter);
// on change show image with crop options
$(document).on('change', '.image_up', function(e) { 
//$('.image_up').on('change', function (e) {
    getthis = $(this);
    $(".error-product-"+$(this).attr('id')).html("");
   // console.log('=='+ $(this).attr('id'));
    //console.log("cropper "+ eval(cropper));
    var result = document.querySelector('.product-result-'+ $(this).attr('id'));
    if (e.target.files.length) {
        var reader = new FileReader();
        reader.onload = function (e) {
            if (e.target.result) {
                var img = document.createElement('img');
                img.id = 'image';
                img.src = e.target.result;
                result.innerHTML = '';
                result.appendChild(img);



            cropperArr[getthis.attr('id')]=getobjCrop(img);

            myarr.push(cropperArr);
                
            }
        };
         
        reader.readAsDataURL(e.target.files[0]);
    }
});


// save on click
//save.addEventListener('click', function (e) {
$(".saveImgExit, .saveImgContine, .saveImgNext").on('click', function (e) {  
   
   var className = $(this).attr('class');
    var collection = $(".image_up");
        collection.each(function() {

        var id = $(this).attr('id');
              
        //console.log(cropper);
        var fileUpload = $(this)[0];
        var imageExt = fileUpload.value.split('.');
        var validImageTypes = ["gif", "jpeg", "jpg", "png","bmp","svg"];
        if($(this).val() != ''){
            //Check whether the file is valid Image.

            //var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.gif)$");
            //if (regex.test(fileUpload.value.toLowerCase())) {
            if ($.inArray(imageExt[1], validImageTypes) == true || $.inArray(imageExt[1], validImageTypes) != -1) {
                //console.log("inside regex");
                //Check whether HTML5 is supported.
                if (typeof (fileUpload.files) != "undefined") {
                     console.log("!undefined");
                  $(".error-product-"+id).html("");
                    var form = $('#CataLogImg');
                    var formdata = false;
                    if (window.FormData) {
                        formdata = new FormData(form[0]);
                    }
                    var ImageURL = myarr[0][id].getCroppedCanvas({
                        width: "1000" // input value
                    }).toDataURL();
                    // console.log("ImageURL--"+ImageURL);

                    $(".prod_img_url_"+id).val(ImageURL);
                     //console.log("formdata");
                    // console.log("class--"+className);
                    redirectToURL(className);
                    //$('#CataLogImg').submit();

                } 
                else
                {
                    $(".error-product-"+id).html("This browser does not support HTML5.");
                    return false;
                }
            } else
            {
                //console.log("outside regex");
                $(".error-product-"+id).html("Please select a valid Image file.");
                return false;
            }
         }
         else
         {
            //console.log("class--"+className);
            redirectToURL(className);
            //$('#CataLogImg').submit();
         }
    });

    

});
</script>

<script>
    $(".addMoreImg").on('click',function(){  
        counter = parseInt(counter) + 1;        
        var addNew = '';
         addNew += '<div class="row form-group"><div class="col-sm-1"></div><div class="col-sm-4"><div class="form-validation-field-0formError parentFormCataLogImg formError" style="opacity: 0.87; position: absolute; top: 0px; left: 272px; right: initial; margin-top: -50px;"><div class="formErrorContent">* This field is required</div><div class="formErrorArrow"><div class="line10"></div><div class="line9"></div><div class="line8"></div><div class="line7"><!-- --></div><div class="line6"></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div></div></div><input name="images[]" type="file" class="form-control filestyle image_up validate[required]" id="'+ counter +'"><input type="hidden" name="prod_img_url_'+ counter +'" value="" class="prod_img_url_'+ counter +'" required><span class="span-mand  span-mand-setright">*</span></div><div class="col-sm-2"><input class="form-control validate[required,custom[number]]" placeholder="Sort Order" name="sort_order[]" type="text"></div><div class="col-sm-3"><input class="form-control validate[required]" placeholder="Alt Text" name="alt_text[]" type="text"></div><div class="col-sm-1"><input name="id_img[]" type="hidden"><input name="filename[]" type="hidden" value=""><input name="file_upload_status[]" type="hidden" value="1"><a href="#" data-toggle="tooltip" title="" class="deleteImg" data-original-title="Delete"><i class="fa fa-trash btn-lg btn btn-plen"></i></a></div><div class="clearfix"></div><div style="float:left;color:red" class="error-product-'+ counter +'"></div><div class="col-md-6"><div class="product-result-'+ counter +'" style="max-width: 400px; max-height: 250px"></div></div></div>';
         $(".existingImg").append(addNew);
    });

    var prod_type = "{{ $prod->prod_type }}";
    console.log('prod'+ prod_type);
    

    $("body").on("click", ".deleteImg", function() {
     $(this).parent().parent().remove();
 });

    $("body").on("click", ".DelImg", function() {
        var imgId = $(this).attr("data-value");
        var chk = confirm("Are you sure want to delete this image?");
        if (chk == true) {
            // alert($(this).attr("data-value"));
            $.ajax({
                type: "POST",
                url: "{!! route('admin.products.images.delete') !!}",
                catch : false,
                data: {imgId: imgId},
                success: function(data) {
                    //console.log(data);
                    if(data == 1)
                    {
                        $(".successDel").text("Image deleted successfully.");
                    }                    
                    location.reload();

                }
            });
        }


    });




</script>
@stop
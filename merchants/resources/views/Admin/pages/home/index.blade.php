@extends('Admin.layouts.default')
<style>
    div.logo {
        position: relative;
    }

    div.logo .updateLogo {
        position: absolute;
        right: 0px !important;
        top: 30% !important;
    }
    div.logo .updateLogo a {
        color: #fff !important;
        font-size: 12px;
        font-weight: 600;
    }
    .updateLogo i {
        color: #fff;
        font-size: 20px;
    }

    div.logo .updateTheme {
        position: absolute;
        right: 0px !important;
        top: 30% !important;
    }
    div.logo .updateTheme a {
        color: #fff !important;
        font-size: 12px;
        font-weight: 600;
    }
    .updateTheme i {
        color: #fff;
        font-size: 20px;
    }

    span.editicons {
        position: absolute;
        top: 35%;
        right: 0px;
        cursor: pointer;
    }
    span.editicons i {
        color: #fff;
        font-size: 14px;
    }
    .updateHomeBanner {
        position: absolute;
        left: 0%;
        top: 47%;
        z-index: 999;
        width: 100%;
        text-align: center;
    }
</style>
@section('content')
<!-- Main content -->
<section>
    
    <p id="success_theme_msg" style="color:green;text-align: center;">
        {{ Form::hidden('hdn_session_theme_status_val', Session::get('selectedThemeStatus'), array('id' => 'hdn_session_theme_status_val_id')) }}
        <input type="hidden" name="hdn_session_theme_status_val" id="hdn_session_theme_status_val_id" value="">
        <?php 
        if( (Session::get('selectedThemeStatus')) > 0)
        {
            Session::flash('selectedThemeStatus', "Error");
         ?>
         Theme Updated Successfully <a href="https://{{$hostUrl}}" target="_blank"> Click here to view your page</a>
        <?php
         }?>
     </p>
    <div class="panel-body">    

        <div class="row">
            <div class="col-sm-12 text-center marginBottom20">
                <img src="{{  Config('constants.adminImgPath').'/help-desktop.png' }}" class="mobileFullWidth">	
            </div>
            <div class="col-sm-12 col-xs-12 col-md-8 col-md-offset-2 marginBottom20">
                <h1 class="text-center">Great going!</h1>
                <h4 class="text-center">Here's some help to design and add products to your online store</h4>
            </div>
            <div class="col-sm-12 col-xs-12 col-md-8 col-md-offset-2">
                <div class="box box-solid marginBottom20">
                    <div class="box-header with-border noleftBorder">
                        <h3 class="box-title">Store Logo</h3>
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-defualt btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-defualt btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                    <!-- <center> <img src="{{ asset('public/Admin/dist/img/img-upload-dummy.svg') }}" width="300"> -->
                                <p>Update your brand logo for users to understand it's your online store.</p>
                                <a href="#" class="btn btn-default noAllMargin updateLogo mobileSpecialfullBTN">Update Logo</a>	
                            </div>
                        </div>
                    </div>
                </div>

                <!--Select Theme Option start From here -->
                @if($templateId == 0)
                <div class="box box-solid marginBottom20" id="select_theme_div">
                    <div class="box-header with-border noleftBorder">
                        <h3 class="box-title">Select Theme</h3>
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-defualt btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-defualt btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <p>Update your theme for users to understand it's your online store.</p>
                                <a href="#" class="btn btn-default noAllMargin updateTheme mobileSpecialfullBTN">Update Theme</a>	
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <!--Select Theme Option Ends from here -->

                <div class="box box-solid marginBottom20">
                    <div class="box-header with-border noleftBorder">
                        <h3 class="box-title">Slider Images</h3>
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-defualt btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-defualt btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <center> <img src="{{ Config('constants.adminImgPath').'/img-upload-dummy.svg' }}" width="300">
                                    <p>Add slider images relevant to your products for users to help understand your products well. For your ease, we have already added 3 images related to your industry.</p>
                                    <a  href="{{ route('admin.dynamic-layout.view',['slug'=>'home-page-slider'])}}" class="btn btn-default noAllMargin mobileSpecialfullBTN">Update Homepage Slider Images</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box box-solid marginBottom20">
                    <div class="box-header with-border noleftBorder">
                        <h3 class="box-title">Select Categories</h3>
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-defualt btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-defualt btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <p>Here are ready to use categories. Kindly select the categories that you offer. You can create your own custom categories under Products &gt; Categories in the left menu.</p>										
                                <a href="{{ route('admin.category.view') }}" class="btn btn-default noAllMargin  mobileSpecialfullBTN">Select Categories</a>
                            </div>
                        </div>
                    </div>
                </div>
                @if($feature['tax']==1)
                <div class="box box-solid marginBottom20">
                    <div class="box-header with-border noleftBorder">
                        <h3 class="box-title">Add Taxes</h3>
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-defualt btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-defualt btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <p>Add taxes and their information which are applicable to your business/products.</p>
                                <a href="{{ route('admin.tax.view') }}" class="btn btn-default noAllMargin  mobileSpecialfullBTN">Add Taxes</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <div class="box box-solid marginBottom20">
                    <div class="box-header with-border noleftBorder">
                        <h3 class="box-title">Add Product</h3>
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-defualt btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-defualt btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <p>Take the first step to launching your store. Add products to your store.</p>
                                <a href="{{ route('admin.products.view') }}" class="btn btn-default noAllMargin  mobileSpecialfullBTN">Add Product</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box box-solid marginBottom20">
                    <div class="box-header with-border noleftBorder">
                        <h3 class="box-title">About Store</h3>
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-defualt btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-defualt btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <p>Write few lines about your store for people to understand more about your vision, brand value, quality and services. People like to read it.</p>										
                                <a href="{{ route('admin.staticpages.view') }}" class="btn btn-default noAllMargin  mobileSpecialfullBTN">Update About Store</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box box-solid marginBottom20">
                    <div class="box-header with-border noleftBorder">
                        <h3 class="box-title">Contact Information</h3>
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-defualt btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-defualt btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 text-left">
                                    <!-- <center> <img src="{{ asset('public/Admin/dist/img/img-upload-dummy.svg') }}" width="300"> -->
                                <p>Let people know where can they contact you. This makes communication more simpler. 
                                </p>									

                                <a href="{{ route('admin.staticpages.view') }}" class="btn btn-default noAllMargin  mobileSpecialfullBTN">Update Contact Information</a>
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="box box-solid marginBottom20">
                    <div class="box-header with-border noleftBorder">
                        <h3 class="box-title">Tutorials</h3>
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-defualt btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-defualt btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <p>Stuck anywhere? Checkout our tutorials. They are simple, efficient and easy to understand</p>		
                                <a href="http://veestores.com/veestore-tutorial" class="btn btn-default noAllMargin  mobileSpecialfullBTN">View Tutorials</a>								
                                <!-- <a href="{{ route('admin.testimonial.view') }}" class="btn btn-default noAllMargin">Add Testimonials</a> -->
                            </div>
                        </div>
                    </div>
                </div>
            

            </div>
            
        </div>
    </div>
    <!-- open popup model -->
  
</section>


<!--Theme Selection Modal Popup Div start here-->
<div class="modal fade" id="themeModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">    
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Choose Theme</h4>
            </div>
            <div class="modal-body" id="theme_div">        
                <!--<section id="page-title" class=" page-title-center" style=" padding: 50px 0;" data-stellar-background-ratio="0.3">

                    <div class="container clearfix">
                        <h1 class="">Themes for your online store </h1>
                        <span class="">Easily customizable and mobile friendly themes to match your brand</span>
                    </div>
                
                </section><!-- #page-title end -->


                <!--<section id="content">
                    <div class="content-wrap">
                        <div class="container clearfix">
                
                            

                        </div>
                    </div>
                </section>-->

            <div class='clearfix'></div>
            </div>

        </div>
    </div> 
</div> 
<!--Theme Selection Modal Popup Dive ends here -->


@stop
@section('myscripts')

<script>
$(".toggle-two").change(function () {
    userId = $(this).attr('data-id');
    url_data = $(this).attr('data-url');

    if (url_data == 'default-courier') {

        if ($(this).prop("checked") == true) {
            $('.courierSelect').removeClass("hide");

        } else {
            $('.courierSelect').addClass("hide");
        }
    }
    $.ajax({
        method: "POST",
        data: {'id': userId},
        url: "<?php echo route('admin.generalSetting.changeStatus'); ?>",
        success: function (data) {
            // console.log(data);
            // location.reload();courier-services
        }
    })
});

$("#courierSelect").change(function () {

    var courierId = $(this).val();
//        alert(courierId);
    $('#courierSelect').css('color', '#555');
    $.ajax({
        method: "POST",
        data: {'courierId': courierId},
        url: "<?php echo route('admin.generalSetting.assignCourier'); ?>",
        success: function (data) {
            // console.log(data);
            // location.reload();courier-services
        }
    })
});
$(document).ready(function () {

    //$('#success_theme_msg').delay(5000).fadeOut('slow');

    $(".updateLogo").click(function () {
        $("#logoModal").modal('show');
    });
    $(".updateTheme").click(function () {
        //$("#themeModal").modal('show');

        $.ajax({
            method: "POST",
            url: "<?php echo route('admin.home.showMerchantTheme'); ?>",
            success: function (data) {
                console.log(data);
                //$("#themeModal").modal('show');
                $("#theme_div").html(data);
            }
        })

        $("#themeModal").modal('show');
        
    })

    var modal = document.getElementById('myModal');
    var is_popup_open = "{{ $set_popup->status }}";
    console.log(is_popup_open);
    if (is_popup_open == 1) {
        modal.style.display = "block";
    } else {
        modal.style.display = "none";
    }
    if ($('.courier-services').prop("checked") == true) {
        $('.courierSelect').removeClass("hide");

    }
});

$("#submit").click(function () {
    if ($('.courier-services').prop("checked") == true) {
        if ($('#courierSelect').val() == '') {

            $('#courierSelect').attr("placeholder", "Please Selct Courier Services");
            $('#courierSelect').css('color', '#FF0000');
            $('#courierSelect').focus();
            return false;
        }
    }

    $.ajax({
        method: "POST",
        url: "<?php echo route('admin.home.changePopupStatus'); ?>",
        success: function (data) {
            location.reload();
        }
    })
})

$(window).load(function () {

//hide the select theme div if the theme is applied by merchants admin
var getHdnSelectThemeSessionVal = $("#hdn_session_theme_status_val_id").val();
if(getHdnSelectThemeSessionVal > 0)
{
    $("#select_theme_div").hide();
}

});

/*function applyMerchantTheme(cateId,themeId)
{
    alert("cat id::"+cateId+":: theme id::"+themeId);
    modal.style.display = "none";
    //$("#themeModal").modal('hide');
    $.ajax({
            method: "POST",
            data: {'cateId': cateId, 'themeId': themeId},
            url: "<?php echo route('admin.home.applyMerchantTheme'); ?>",
            success: function (response) {
                alert(response);
                if (response.status == '1' ) {
                    window.location.href = 'admin.home.view';
                } 
            },
            error: function (e) {
                console.log(e.responseText);
            }
            
        })
        return false;  
}*/
</script>

@stop


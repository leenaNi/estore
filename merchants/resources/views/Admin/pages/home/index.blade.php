@extends('Admin.layouts.default')
<style type="text/css">
.toggle.btn{ float: right; }
.modalBodyScroll{ overflow-y: scroll; height: 400px;}
.modalFullWidth{width: 90%!important;}
</style>
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

					<!-- <div class="box box-solid marginBottom20">
						<div class="box-header with-border noleftBorder">
							<h3 class="box-title">See all your orders & sales</h3>
							<div class="pull-right box-tools">
								<button type="button" class="btn btn-defualt btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
								</button>
								<button type="button" class="btn btn-defualt btn-sm" data-widget="remove"><i class="fa fa-times"></i>
								</div>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-sm-12 col-md-12">
										<a href="{{ route('admin.orders.view') }}" class="btn btn-default noAllMargin">View Orders</a> &nbsp;&nbsp;&nbsp;
										<a href="{{ route('admin.sales.byorder') }}" class="btn btn-default noAllMargin">View Sales</a>
									</div>
								</div>
							</div>
						</div> -->

						

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

							<!-- <div class="box box-solid">
							<div class="box-header with-border noleftBorder">
								<h3 class="box-title">Dashboard</h3>
								
								<div class="pull-right box-tools">
									<button type="button" class="btn btn-defualt btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
									</button>
									<button type="button" class="btn btn-defualt btn-sm" data-widget="remove"><i class="fa fa-times"></i>
									</div>
								</div>
								<div class="box-body">
									<div class="row">
										<div class="col-sm-12 col-md-12">
											<center> <img src="{{ asset('public/Admin/dist/img/img-upload-dummy2.svg') }}" width="300"><br><br>
											<p>It's a simpler way to track your progress. latest orders, total users, top selling products, top buyers etc. here
											</p>										
											<a href="{{ route('admin.dashboard') }}" class="btn btn-default noAllMargin">View Dashboard</a>
										</div>
									</div>
								</div>
							</div> -->

					</div>
				</div>
			</div>

<!-- open popup model -->
<div class="modal in cstmodal" id="myModal" role="dialog" style="display: none; padding-left: 17px;">
	<div class="modal-dialog modal-lg modalFullWidth">
		<!-- Modal content-->
		<div class="modal-content" style="background-image: url('{{  Config('constants.adminImgPath').'/bgimage.jpg' }}'); background-repeat: no-repeat; background-position: right;">
			<div class="modal-header">
				<h4 class="modal-title">Let's set up your store -  Help us with few important questions</h4>
			</div>
			<div class="modal-body modalBodyScroll">
			<form action="#">
				<div class="col-md-8 noAllpadding">
				<div class="panel-body questionPopup">
                                 
				@foreach($general_setting as $set)
					<div class="col-md-8 noAllpadding"><p><a href="javascript:;" data-placement="right" title="{{$set->info}}" data-toggle="tooltip" class="tooltip-style">  
                                                    <img src="{{  Config('constants.adminImgPath').'/info-icon.png' }}" width="20"></a> {{ $set->name }} </p> </div>
				@if($set->url_key =='default-courier')
                                <div class="col-md-4">
                                <input type="checkbox" <?php echo $set->status == 1?'checked':''; ?> data-id="{{ $set->id }}" data-url="{{ $set->url_key}}"  data-toggle="toggle" name="onOff" data-size="normal" class="toggle-two courier-services" data-on="Yes" data-off="No">
                                </div>
                                    <div class="col-md-4 courierSelect hide">
						<select class="form-control" id='courierSelect' name="courier_service">
                                                    <option value="" >Select</option>
                                                   @foreach($courier as $cour)
							
							<option value="{{$cour->id}}">{{$cour->name}}</option>
							@endforeach
						</select>
					</div>
                                <hr class="style1">
                               @else
                                <div class="col-md-4">
						<input type="checkbox" <?php echo $set->status == 1?'checked':''; ?> data-id="{{ $set->id }}" data-url="{{ $set->url_key}}"  data-toggle="toggle" name="onOff" data-size="normal" class="toggle-two" data-on="Yes" data-off="No">
					</div>
                                 @endif	
                                <hr class="style1">
                                
					
					@endforeach
                                    
					<div class="col-md-8 noAllpadding"><p> <a href="javascript:;" data-placement="right" title="Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua." data-toggle="tooltip" class="tooltip-style"> <img src="{{ asset('public/Admin/dist/img/info-icon.png') }}" width="20"> </a> Your products will be inclusive/exclusive of taxes? </p></div>
					<div class="col-md-4">
						<select class="form-control" name="">
							<option>Select</option>
							<option value="1" selected>Inclusive</option>
							<option value="0">Exclusive</option>
						</select>
					</div>
					<hr class="style1">
				</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn pull-left btn-default" id="submit" data-dismiss="modal">Set Up My Store</button>
			</div>
			</form>
		</div>

		</div>
	 </div>

		</section>

		@stop

@section('myscripts')

<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
$(".toggle-two").change(function(){
	userId = $(this).attr('data-id');
	url_data = $(this).attr('data-url');
       
        if(url_data=='default-courier'){
          
         if($(this).prop("checked") == true){
              $('.courierSelect').removeClass("hide");
               
            }else{
                $('.courierSelect').addClass("hide"); 
            }
        }
	   $.ajax({
        method:"POST",
        data:{'id':userId },
        url:"<?php  echo route('admin.generalSetting.changeStatus') ;?>",
        success: function(data){
            // console.log(data);
            // location.reload();courier-services
        }
      })
});

$("#courierSelect").change(function(){

	var courierId = $(this).val();
//        alert(courierId);
              $('#courierSelect').css('color', '#555');                            
	$.ajax({
        method:"POST",
        data:{'courierId':courierId },
        url:"<?php  echo route('admin.generalSetting.assignCourier') ;?>",
        success: function(data){
            // console.log(data);
            // location.reload();courier-services
        }
      })
});
$( document ).ready(function() {
 
    $(".updateLogo").click(function () {
        $("#logoModal").modal('show');
    });
    
    var modal = document.getElementById('myModal');
    var is_popup_open = "{{ $set_popup->status }}";
    console.log(is_popup_open);
	 if(is_popup_open == 1){
	 	modal.style.display = "block";
	 }else{
	 	modal.style.display = "none";	
	 }
	if($('.courier-services').prop("checked") == true){
              $('.courierSelect').removeClass("hide");
               
            } 
});
$("#submit").click(function(){
    if($('.courier-services').prop("checked") == true){
       if($('#courierSelect').val()==''){
          
            $('#courierSelect').attr("placeholder", "Please Selct Courier Services");
              $('#courierSelect').css('color', '#FF0000');
            $('#courierSelect').focus();
           return false;
        }
    }
	
	  $.ajax({
        method:"POST",
        url:"<?php  echo route('admin.home.changePopupStatus') ;?>",
        success: function(data){
             location.reload();
        }
      })
})
   
</script>

@stop


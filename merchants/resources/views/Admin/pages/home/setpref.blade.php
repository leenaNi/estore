@extends('Admin.layouts.default')
@section('content')
<!-- Main content -->
<section>
    <div class="panel-body">        
        <div class="row">
            <div class="col-sm-6 col-md-8 col-md-offset-2 marginBottom20">
                <h1 class="text-center">Great going!</h1>
                <h4 class="text-center">Here's some help to design and add products to your online store</h4>
            </div>
        </div>
    </div>
</section>
<div class="modal in cstmodal" id="myModal" role="dialog" style="display: block; padding-left: 17px;">
	<div class="modal-dialog modal-lg" style="width: 90%;">
		<!-- Modal content-->
		<div class="modal-content" style="background-image: url('{{ asset('public/Admin/dist/img/bgimage.jpg') }}'); background-repeat: no-repeat; background-position: right;">
			<div class="modal-header">
				<h4 class="modal-title">Let's set up your store -  Help us with few important questions</h4>
			</div>
			<div class="modal-body" style="overflow-y: scroll; height: 400px;">
			<form action="#">
				<div class="col-md-8 noAllpadding">
				<div class="panel-body questionPopup">
					<div class="col-md-8 noAllpadding"><p> <a href="javascript:;" data-placement="right" title="Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua." data-toggle="tooltip" class="tooltip-style">  <img src="{{ asset('public/Admin/dist/img/info-icon.png') }}" width="20"></a> Do you want to manage stock?  </p> </div>
					<div class="col-md-4">
					<div class="switch-field">
						<input type="radio" id="switch1" name="switch_1" class="switch" value="yes" checked/>
						<label for="switch1">Yes</label>
						<input type="radio" id="switch2" name="switch_1" class="switch" value="no" />
						<label for="switch2">No</label>
					</div>
					</div>
					<hr class="style1">
					<div class="col-md-8 noAllpadding"><p> <a href="javascript:;" data-placement="right" title="Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua." data-toggle="tooltip" class="tooltip-style"> <img src="{{ asset('public/Admin/dist/img/info-icon.png') }}" width="20"> </a> Do you want to use barcode? </p></div>
					<div class="col-md-4">
					<div class="switch-field">
						<input type="radio" id="switch3" name="switch_2" class="switch" value="yes" checked/>
						<label for="switch3">Yes</label>
						<input type="radio" id="switch4" name="switch_2" class="switch" value="no" />
						<label for="switch4">No</label>
					</div>
					</div>
					<hr class="style1">
					<div class="col-md-8 noAllpadding"><p> <a href="javascript:;" data-placement="right" title="Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua." data-toggle="tooltip" class="tooltip-style"> <img src="{{ asset('public/Admin/dist/img/info-icon.png') }}" width="20"> </a> Do you want multi-language? </p></div>
					<div class="col-md-4">
					<div class="switch-field">
						<input type="radio" id="switch5" name="switch_3" class="switch" value="yes" checked/>
						<label for="switch5">Yes</label>
						<input type="radio" id="switch6" name="switch_3" class="switch" value="no" />
						<label for="switch6">No</label>
					</div>
					</div>
					<hr class="style1">
					<div class="col-md-8 noAllpadding"><p> <a href="javascript:;" data-placement="right" title="Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua." data-toggle="tooltip" class="tooltip-style"> <img src="{{ asset('public/Admin/dist/img/info-icon.png') }}" width="20"> </a> Do you want to maintain purchase orders? </p></div>
					<div class="col-md-4">
					<div class="switch-field">
						<input type="radio" id="switch7" name="switch_4" class="switch" value="yes" checked/>
						<label for="switch7">Yes</label>
						<input type="radio" id="switch8" name="switch_4" class="switch" value="no" />
						<label for="switch8">No</label>
					</div>
					</div>
					<hr class="style1">
					<div class="col-md-8 noAllpadding"><p> <a href="javascript:;" data-placement="right" title="Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua." data-toggle="tooltip" class="tooltip-style"> <img src="{{ asset('public/Admin/dist/img/info-icon.png') }}" width="20"> </a> Do you want to manage taxes? </p></div>
					<div class="col-md-4">
					<div class="switch-field">
						<input type="radio" id="switch9" name="switch_5" class="switch" value="yes" checked/>
						<label for="switch9">Yes</label>
						<input type="radio" id="switch10" name="switch_5" class="switch" value="no" />
						<label for="switch10">No</label>
					</div>
					</div>
					<hr class="style1">
					<div class="col-md-8 noAllpadding"><p> <a href="javascript:;" data-placement="right" title="Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua." data-toggle="tooltip" class="tooltip-style"> <img src="{{ asset('public/Admin/dist/img/info-icon.png') }}" width="20"> </a> Your products will be inclusive/exclusive of taxes? </p></div>
					<div class="col-md-4">
						<select class="form-control" name="">
							<option>Select</option>
							<option value="1">Inclusive</option>
							<option value="0">Exclusive</option>
						</select>
					</div>
					<hr class="style1">
					<div class="col-md-8 noAllpadding"><p> <a href="javascript:;" data-placement="right" title="Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua." data-toggle="tooltip" class="tooltip-style"> <img src="{{ asset('public/Admin/dist/img/info-icon.png') }}" width="20"> </a> What types of products you wish to manage/sell? </p></div>
					<div class="col-md-4">
						<select class="form-control" name="">
							<option>Select Product Type</option>
							<option value="1">Product Type 1</option>
							<option value="2">Product Type 2</option>
							<option value="3">Product Type 3</option>
							<option value="4">Product Type 4</option>
							<option value="5">Product Type 5</option>
						</select>
					</div>
					<hr class="style1">
					<div class="col-md-8 noAllpadding"><p> <a href="javascript:;" data-placement="right" title="Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua." data-toggle="tooltip" class="tooltip-style"> <img src="{{ asset('public/Admin/dist/img/info-icon.png') }}" width="20"> </a> Will you offer discounts on your products? </p></div>
					<div class="col-md-4">
						<select class="form-control" name="">
							<option>Select</option>
							<option value="1">Yes</option>
							<option value="0">No</option>
						</select>
					</div>
					<hr class="style1">
					<div class="col-md-8 noAllpadding"><p> <a href="javascript:;" data-placement="right" title="Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua." data-toggle="tooltip" class="tooltip-style"> <img src="{{ asset('public/Admin/dist/img/info-icon.png') }}" width="20"> </a> These are just temporary questions? </p></div>
					<div class="col-md-4">
						<select class="form-control" name="">
							<option>Select</option>
							<option value="1">Ok</option>
							<option value="0">No Problem</option>
						</select>
					</div>
					<hr class="style1">
					<div class="col-md-8 noAllpadding"><p> <a href="javascript:;" data-placement="right" title="Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua." data-toggle="tooltip" class="tooltip-style"> <img src="{{ asset('public/Admin/dist/img/info-icon.png') }}" width="20"> </a> Is Infini the best tech company? </p></div>
					<div class="col-md-4">
						<select class="form-control" name="">
							<option>Select</option>
							<option value="1">Yes</option>
							<option value="0">Ofcourse, yes</option>
						</select>
					</div>
				</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left marginleft20" data-dismiss="modal">Submit</button>
			</div>
			</form>
		</div>
	</div>
</div>
@stop
@section('myscripts')
<script>
	$(".switch").click(function(){
		console.log($(this).val());
	})

	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	})
	
</script>
@stop
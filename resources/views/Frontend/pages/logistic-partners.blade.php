@extends('Frontend.layouts.default')
@section('content')
<section id="page-title" class="page-title-parallax page-title-center" style="background: url('{{ asset(Config('constants.frontendPublicImgPath').'/static.jpg') }}') 0px; padding: 103px 0;">

	<div class="container clearfix">
				<h2 class="white-text bottommargin-xs" data-animate="fadeInUp">CONSISTENT VOLUME, STEADY INCOME</h2>
				<span class="white-text" data-animate="fadeInUp" data-delay="300">Our first-rate delivery experience brings smiles to our customers' doorsteps.</span>
			</div>
</section>
<!-- #page-title end -->
  <section id="content">

			<div class="content-wrap">

				<div class="container clearfix">
					<div class="tabs tabs-alt tabs-tb clearfix" id="tab-8">
						<ul class="tab-nav ecomtab-nav clearfix">
							<li><a href="#tabs-bang">eCommerce(Bangladesh)</a></li>
							<!-- <li><a href="#tabs-ind">eCommerce(India)</a></li> -->
						</ul>
						<div class="tab-container ecomTabContainer">
							<div class="tab-content clearfix" id="tabs-bang">
								<div class="table-responsive">
									<table class="ecomTable table table-striped table-hover table-bordered table-comparison nobottommargin">
										<thead>
										<tr>
											<th>Area</th>
											<th>Up to 500gm (BDT)</th>
										</tr>
										</thead>
										<tbody>
										<tr>
											<td>Inside Dhaka (Next Day)</td>
											<td>45 <i class="icon-taka"></i></td>
										</tr>
										<tr>
											<td>Outside Dhaka District City Only (48-96hrs)</td>
											<td>120 <i class="icon-taka"></i></td>
										</tr>
										</tbody>
									</table>
								</div>
								<div class="customBullet">
								<ul>
									<li> Return Charge will be applicable as same as the delivery charge for inside and for outside double as the delivery charge for reverse pick up.</li>
									<li> COD Charge will be applicable. COD charges will be 1% of the product price.</li>
									<li>20tk will be added for each 1KG parcel.</li>
									<li>Above prices are VAT exclusive. 15% VAT will be added on this above price when invoice or deducted service charges from COD.</li>
									<li>The quoted price is 10% TAX included</li>
								</ul>
								</div>

							</div>
							<!-- <div class="tab-content clearfix" id="tabs-ind">
								<div class="table-responsive">
									<table class="ecomTable table table-striped table-hover table-bordered table-comparison nobottommargin">
										<thead>
										<tr>
											<th>Area</th>
											<th>Currency(<i class="icon-rupee"></i>)</th>
										</tr>
										</thead>
										<tbody>
										<tr>
											<td>1K</td>
											<td>100 <i class="icon-rupee"></i></td>
										</tr>
										<tr>
											<td>2K</td>
											<td>300 <i class="icon-rupee"></i></td>
										</tr>
										<tr>
											<td>3K</td>
											<td>500 <i class="icon-rupee"></i></td>
										</tr>
										</tbody>
									</table>
								</div>
							</div> -->
							<div class="noteBox">
								<p><strong>Note:</strong>  Only when eStorifi Logistic Partner service is used, delivery of the Order and COD (Cash On Delivery) will be managed by eStorifi. These payments will be settled to the Merchant’s bank account within Transaction + 2 working days. The amount transferred will be Amount Transferred = Transaction Amount - Shipping Charges - eStorifi Commission. If Merchant uses his/her own logistic partner, the Merchant will be responsible for delivery of the Order and COD (Cash On Delivery).</p>
								
							</div>
	

</div>

</div>

					
					</div>

				</div>

			</div>

		</section>
@stop
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
							<li><a href="#tabs-ind">eCommerce(India)</a></li>
						</ul>
						<div class="tab-container ecomTabContainer">
							<div class="tab-content clearfix" id="tabs-bang">
								<div class="table-responsive">
									<table class="ecomTable table table-striped table-hover table-bordered table-comparison nobottommargin">
										<thead>
										<tr>
											<th>Area</th>
											<th>Currency(<i class="icon-taka"></i>)</th>
										</tr>
										</thead>
										<tbody>
										<tr>
											<td>1K</td>
											<td>100 <i class="icon-taka"></i></td>
										</tr>
										<tr>
											<td>2K</td>
											<td>300 <i class="icon-taka"></i></td>
										</tr>
										<tr>
											<td>3K</td>
											<td>500 <i class="icon-taka"></i></td>
										</tr>
										</tbody>
									</table>
								</div>
							</div>
							<div class="tab-content clearfix" id="tabs-ind">
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
							</div>
	

</div>

</div>

					
					</div>

				</div>

			</div>

		</section>
@stop
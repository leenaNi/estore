@extends('Frontend.layouts.default')
@section('content')
  <!-- Document Wrapper
	============================================= -->

    <!-- Page Title
		============================================= -->
		<section id="page-title" class="page-title-parallax page-title-center" style="background: url('{{ asset(Config('constants.frontendPublicImgPath').'/static.jpg') }}') 0px; padding: 103px 0;">
			<div class="container clearfix">
				<h2 class="white-text bottommargin-xs" data-animate="fadeInUp">Registration Process</h2>
				<!-- <span class="white-text" data-animate="fadeInUp" data-delay="300">One powerful platform. Two simple plans.</span> -->
			</div>
		</section>
	<!-- #page-title end -->
		<section id="content">
			<div class="content-wrap">
				<div class="container clearfix">
					<div class="col_full nobottommargin">
						<iframe style="max-width:100%; height:400px;"  src="https://www.youtube.com/embed/P2tEViNXn4Q" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</section>
		@stop


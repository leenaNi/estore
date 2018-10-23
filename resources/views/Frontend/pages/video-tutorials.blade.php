@extends('Frontend.layouts.default')
@section('content')
  <!-- Document Wrapper
	============================================= -->

    <!-- Page Title
		============================================= -->
		<section id="page-title" class="page-title-parallax page-title-center" style="background: url('{{ asset(Config('constants.frontendPublicImgPath').'/about-bg.jpg') }}') 0px; padding: 40px 0;">

<div class="container clearfix">
<img src="{{ asset(Config('constants.frontendPublicImgPath').'/about-image.png') }}" alt="Offline to Online">
<h3 class="white-text topmargin-xs bottommargin-xs" data-animate="fadeInUp">Give a digital dimension to your physical store</h3>
	<!--<span class="white-text" data-animate="fadeInUp" data-delay="300">We are trying to expedite the process by providing superior technology and online assistance.</span> -->
</div>
</section>
<!-- #page-title end -->
  <section id="content">
	<div class="content-wrap">

<div class="container clearfix aboutPage">
<div class="col_full nobottommargin">
<iframe style="width:100%; height:450px;"  src="https://www.youtube.com/embed/P2tEViNXn4Q" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
					</div>
					<div class="clearfix"></div>
</div>
</div>




		</section>
		@stop


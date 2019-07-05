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
						<!-- <div class="heading-block1 center">
								<h3>Our story:</h3>
						</div> -->
						<h2 class="text-center ">eStorifi - a technology created to make millions of small businesses flourish by being online through their own webstore.</h3>
						<p class="text-left text-justify">Whether you sell on social media, out of your garage, from the comfort of your home, or in a store, we make sure you reach your buyers anywhere. We wish to make E-commerce easy and better for everyone. </p>
						<p class="text-left text-justify">eStorifi was created from the challenges voiced by small business owners whether selling through a store, social media or market place:</p>
						<p class="text-left text-italic text-justify">"The hassles of managing orders through social media, the offline coordination with customers, difficulties in collecting payments, managing deliveries &amp; inventory, maintaining a daily sales &amp; purchase register, expanding business beyond city limits, not having exclusivity on a market place and most importantly difficulties in getting loans from banks".</p>
						<p class="text-left text-justify">All these small and medium businesses wish to be online but they don't know if they can do so from the comfort of their home without going through the complexities of putting together the many technological aspects of building an ecommerce store.</p>
						<p class="text-left text-justify">At eStorifi, therefore, we created a DIY mechanism and with the help of the many videos and tutorials, a business owner or a budding entrepreneur can create an online e-commerce store in just 5 mins. Not only that, we have integrated logistics and payment gateways to make the entire journey, from setting up the shop to getting paid for the sale, a smooth sailing &amp; hassle free experience.</p>
						<p class="text-left text-justify">In this digital world, the only way you can grow is to match up the fast pace. We will handle the entire hassles of maintaining your webstore, while you focus on growing your business online.</p>
						<p class="text-left text-justify">Happy eStorifi to you!!</p>
					</div>
					<div class="clearfix"></div>
</div>
</div>



<div class="section parallax nomargin notopborder" style="background:#222 !important; padding: 100px 0;">
					<div class="container-fluid center clearfix">

						<div class="col_one_fifth nobottommargin" data-animate="fadeIn" data-delay="200">
							<div class="icon-Box">
									<i class="icon-line-square-check"></i>
							</div>
							<h5 class="white-text">Level 1 PCI<br/>
Compliance</h5>
						</div>

						<div class="col_one_fifth nobottommargin" data-animate="fadeIn" data-delay="400">
						<div class="icon-Box">
									<i class="icon-line2-fire"></i>
							</div>
							<h5 class="white-text">Blazing Fast<br/>
Servers</h5>
						</div>

						<div class="col_one_fifth nobottommargin" data-animate="fadeIn" data-delay="600">
						<div class="icon-Box">
									<i class="icon-bars"></i>
							</div>
							<h5 class="white-text">Unlimited<br/>
Bandwith</h5>
						</div>

						<div class="col_one_fifth nobottommargin" data-animate="fadeIn" data-delay="800">
						<div class="icon-Box">
							<i class="icon-thumbs-up"></i>
							</div>
							<h5 class="white-text">99.97%<br/>
Uptime</h5>
						</div>

						<div class="col_one_fifth nobottommargin col_last" data-animate="fadeIn" data-delay="1000">
						<div class="icon-Box">
									<i class="icon-mobile"></i>
							</div>
							<h5 class="white-text">Exclusive<br/>
APIs</h5>
						</div>

					</div>
				</div>


			
				<!-- <div class="section notopborder nobottomborder nomargin nopadding nobg footer-stick">
					<div class="container clearfix">

						<div class="col_half nobottommargin">
							<img src="{{ asset(Config('constants.frontendPublicImgPath').'/offer.jpg') }}" alt="Men" class="nobottommargin">
						</div>

						<div class="col_half subscribe-widget nobottommargin col_last">

							<div class="valign-middle" style="padding: 130px 100px;">
								<a href="/feature-list" class="btn theme-btn nomargin">View Features</a>
							</div>
						</div>

					</div>
				</div> -->
		</section>
		@stop


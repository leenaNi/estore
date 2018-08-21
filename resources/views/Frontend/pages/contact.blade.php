@extends('Frontend.layouts.default')
@section('content')
  <!-- Document Wrapper
	============================================= -->

 <!-- Page Title
		============================================= -->
		<section id="page-title" class="page-title-pattern page-title-center">

			<div class="container clearfix">
				<h1>Contact</h1>
			</div>

		</section><!-- #page-title end -->
  <section id="content">
	<div class="content-wrap">
		<div class="container clearfix">
			<!-- Postcontent
					============================================= -->
					<div class="postcontent nobottommargin">

						<h3>Get in Touch with Us</h3>

						<div class="contact-widget">
							<form class="nobottommargin" action="" method="post">
								<div class="col_one_third">
									<input type="text" placeholder="Name *" class="sm-form-control required" />
								</div>

								<div class="col_one_third">
									<input type="email" placeholder="Email *" class="required email sm-form-control" />
								</div>

								<div class="col_one_third col_last">
									<input type="text" placeholder="Mobile *" class="sm-form-control" />
								</div>

								<div class="clear"></div>

								<div class="col_full">
									<textarea class="required sm-form-control" placeholder="Your Message" rows="6" cols="30"></textarea>
								</div>

								<div class="col_full">
									<button class="button button-3d nomargin" type="submit" value="submit">Submit</button>
								</div>

							</form>
						</div>

					</div><!-- .postcontent end -->
					<!-- Sidebar
					============================================= -->
					<div class="sidebar col_last nobottommargin">

						<address>
							<strong>Dhaka</strong><br>
							8th Floor, Haque Tower, IA - 28/8 – D, Mohakhali, C/A Dhaka 1212<br>
						</address>
						<address>
							<strong>Mumbai</strong><br>
							C/504, Neelkanth Business Park, Near Vidyavihar Station, 
Vidyavihar West, Mumbai 400086.<br>
						</address>
						<abbr><strong>Email:</strong></abbr> info@infiniteit.biz 

					

						<div class="widget noborder notoppadding">

							<a href="https://www.facebook.com/VeestoresGlobal/" target="_blank" class="social-icon si-small si-dark si-facebook">
								<i class="icon-facebook"></i>
								<i class="icon-facebook"></i>
							</a>

						</div>

					</div><!-- .sidebar end -->
			<div class="clearfix"></div>
		</div>
	</div>
	</section>
		@stop


<!-- Footer
	============================================= -->

	<footer id="footer" class="dark">

		<div class="container">
		<?php  	if($notificationStatus==1) {
	$cols='col-md-3';
	$cols2='col-md-3';
}else{
	$cols='col-md-4';
	$cols2='col-md-5';

}
	?>
				<!-- Footer Widgets
					============================================= -->
					<div class="footer-widgets-wrap clearfix nobottompaddingMob nobottompaddingMob">

						<div class="col_full nobottompaddingMob">
							<div class="{{$cols}} col-sm-6  col-xs-12">

								<div class="widget clearfix abt-secFooter">

									<h4>About</h4>
									@if($footerContent)
									<?php echo substr(html_entity_decode($footerContent),0,130).'...'; ?> 
									@else 
									<p>We believe in <strong>Simple</strong>, <strong>Creative</strong> &amp; <strong>Flexible</strong> Design Standards.</p>

									<p>We believe in <strong>Simple</strong>, <strong>Creative</strong> &amp; <strong>Flexible</strong> Design Standards.</p>
									@endif
									<span><a href="/about-us">Read more.</a></span>
								</div>

							</div>

							<div class="col-md-2 col-sm-6  col-xs-12">

								<div class="widget widget_links clearfix">

									<h4>Links</h4>

									<ul>
										@if(count($staticPages) >0)
										@foreach($staticPages as $page)
										<li><a href="{{route($page->url_key)}}">{{$page->page_name}}</a></li>
										@endforeach
										@endif
									</ul>

								</div>

							</div>
							@if($notificationStatus==1)
							<div class="col-md-4 col-sm-6" ng-controller="myctrl">

								<div class="widget clearfix bottommargin-sm">
									<h4>Newsletter</h4>

									<div class="widget subscribe-widget clearfix  nobottompaddingMob nobottommarginMob">
										<h5><strong>Subscribe</strong> to Our Newsletter to get News, Update &amp; Amazing Offers</h5>
										<div class="widget-subscribe-form-result"></div>

										<form  role="form" method="post" class="nobottommargin" id="subscribe">

											<div class="input-group divcenter">
												<span class="input-group-addon" id="EmailIcon"><i class="icon-email2"></i></span>
												<input type="email" id="emailvalue" name="emailvalue" class="form-control required newsletter-email" placeholder="Enter your email address.">
												<span class="input-group-btn">
													<button class="btn btn-default themeBtn" id="btn-subscribe" type="submit">Subscribe</button>
												</span>

											</div>
											<span id="subscription-success"  style="color:#449d44" ></span>
										</form>
									</div>
								</div>

							</div>
							@endif

							<div class="{{$cols2}}  col-sm-6  col-xs-12">
								<div class="widget clearfix nobottompaddingMob nobottommarginMob">
									<h4>Contact Us</h4>

									<div class="widget subscribe-widget clearfix nobottompaddingMob nobottommarginMob">
										@if(count($contactDetails) >0)
										<?php    $contact =json_decode($contactDetails->contact_details); ?>
										<address class="nobottommargin">
											<abbr><strong>Address:</strong></abbr> 
											{{$contact->address_line1}} , {{$contact->address_line2}} {{$contact->city}} {{$contact->pincode}} 
										</address> 
										<abbr><strong>Phone: {{$contact->mobile}}</strong></abbr> <br>
										<abbr><strong>Email: <a href="mailto:{{$contact->email}}">{{$contact->email}}</a></strong></abbr>

										@else
										<address class="nobottommargin">
											<abbr><strong>Address:</strong></abbr><br>
											C/504,Neelkanth Business Park, Near Vidyavihar Station, Vidyavihar West, Mumbai 400086
											. <br>
										</address>
										<br>
										<abbr><strong>Phone: 89989825658</strong></abbr> <br>
										<abbr><strong>Email: <a href="mailto:support@inficart.com">support@inficart.com</a></strong></abbr>
										@endif
										<!--<p>Neelkanth Business Park, Near Vidyavihar Station, Vidyavihar West, Mumbai 400086</p>-->
										<div class="si-share clearfix">
											<span>Connect with us on:</span>
											<div>
												@if(count($socialMedia) >0)
												@foreach($socialMedia as $socialMedialink)
												<a target="_blank" href="{{$socialMedialink->link}}" class="social-icon si-borderless si-text-color si-{{$socialMedialink->media}}" title="{{$socialMedialink->media}}">
													<i class="icon-{{$socialMedialink->media}}"></i>
													<i class="icon-{{$socialMedialink->media}}"></i>
												</a>
												@endforeach
												@endif
<!--								<a target="_blank" href="https://twitter.com" class="social-icon si-borderless si-text-color si-twitter" title="Twitter">
									<i class="icon-twitter"></i>
									<i class="icon-twitter"></i>
								</a>
								<a target="_blank" href="https://plus.google.com" class="social-icon si-borderless si-text-color si-gplus" title="Google Plus">
									<i class="icon-gplus"></i>
									<i class="icon-gplus"></i>
								</a>-->

							</div>
						</div>
					</div>
				</div>


			</div>
		</div>

	</div><!-- .footer-widgets-wrap end -->

</div>

			<!-- Copyrights
				============================================= -->
				<div id="copyrights">

					<div class="container clearfix">

						<div class="col_half">
							Copyright © <?php echo date("Y"); ?>. <a href="#">{{App\Library\Helper::getSettings()['storeName']}}</a>. 
						</div>

						<div class="col_half col_last tright">
							<div class="fright clearfix">
								Powered by <a href="http://www.veestores.com/" target="_blank">Veestores</a>.
							<!-- <div class="copyrights-menu copyright-links nobottommargin">
								<a href="{{route('home')}}">Home</a>/<a href="#">T &amp; C</a>/<a href="#">Disclaimer</a>/<a href="{{route('contact-us')}}">Contact</a>
							</div> -->
						</div>
						</div>

					</div>

				</div><!-- #copyrights end -->

		</footer><!-- #footer end -->
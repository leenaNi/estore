<!-- Footer
		============================================= -->
		<footer id="footer" class="dark">
			
			<div class="container">

				<!-- Footer Widgets
				============================================= -->
				<div class="footer-widgets-wrap clearfix">

					<div class="col_three_fifth bottommobileMargin0">

						<div class="widget clearfix abt-secFooter bottommobileMargin0 bottommobilePadding0">

							<h4>About</h4>
                                                         @if($footerContent)
                                                              <?php echo substr(html_entity_decode($footerContent),0,130).'...'; ?> 
                                                         @else 
							<p>We believe in <strong>Simple</strong>, <strong>Creative</strong> &amp; <strong>Flexible</strong> Design Standards with a Retina &amp; Responsive Approach. Browse the amazing Features this template offers.</p>
																												@endif
																												<span><a href="/about-us">Read more.</a></span>
																												<div class="clearfix"></div>
							<div class="clearfix topmargin-xs">
                                                               @if(count($contactDetails) >0)
                                                                  <?php    $contact =json_decode($contactDetails->contact_details); ?>
								<div class="col_half topmobileMargin0 bottommobileMargin0 bottommobilePadding0 mt15Mobile">
									<address class="nobottommargin">
										<abbr><strong>Address:</strong></abbr><br>
									{{$contact->address_line1}} , {{$contact->address_line2}} {{$contact->city}} {{$contact->pincode}}
                                                                                <br>
									</address>
								</div>
								<div class="col_half col_last bottommobileMargin0 bottommobilePadding0 ">
									<abbr><strong>Phone:</strong></abbr> {{$contact->mobile}}<br>
									<abbr><strong>Email:</strong></abbr> <a href="mailto:{{$contact->email}}">{{$contact->email}}</a>
								</div>
                                                                    
                                                                     @else 
                                                                     <div class="col_half">
									<address class="nobottommargin">
										<abb><strong>Address:</strong></abbr><br>
										C/504, Neelkanth Business Park, Near Vidyavihar Station, Vidyavihar West, Mumbai 400086. <br>
									</address>
								</div>
								<div class="col_half col_last">
									<abbr><strong>Phone:</strong></abbr> (022) 6697 3260<br>
                                                                        <abbr><strong>Email:</strong></abbr> <a href="mailto:jigar.shah@infiniteit.biz">jigar.shah@infiniteit.biz</a>
								</div>
                                                                     
                                                                @endif
							</div>
                                        @if($notificationStatus==1)
					<div class="widget clearfix topmargin-sm mt15Mobile nobottommargin  bottommobileMargin0 bottommobilePadding0">
                                            <h4>Newsletter</h4>

						<div class="widget subscribe-widget clearfix">
							<h5><strong>Subscribe</strong> to Our Newsletter to get News, Update &amp; Amazing Offers</h5>
							<div class="widget-subscribe-form-result"></div>
							<form id="subscribe" role="form" method="post" class="nobottommargin">
								<div class="input-group divcenter">
									<span class="input-group-addon" id="EmailIcon"><i class="icon-email2"></i></span>
									<input type="email"  id="emailvalue" name="emailvalue" class="form-control required email newsletter-email" placeholder="Enter your email address.">
									<span class="input-group-btn">
										<button class="btn btn-success themeBtn" id="btn-subscribe" type="submit">Subscribe</button>
									</span>
								</div>
                                                              <span id="subscription-success"  style="color:#449d44" ></span>
							</form>
						</div>
					</div>
                                        @endif

						</div>

					</div>

					<div class="col_one_fifth mt15Mobile bottommobileMargin0 bottommobilePadding0">

						<div class="widget widget_links clearfix bottommobileMargin0 bottommobilePadding0">

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

					<div class="col_one_fifth col_last bottommobileMargin0 bottommobilePadding0">

						<div class="widget clearfix">

<!--							<iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Finfinisystems%2F&tabs=timeline&width=250&height=350&small_header=true&adapt_container_width=true&hide_cover=false&show_facepile=false&appId" style="border:none;overflow:hidden; min-width:220px !important; height:350px;" scrolling="no" frameborder="0" allowTransparency="true"></iframe>-->

						</div>

					</div>

				</div><!-- .footer-widgets-wrap end -->

			</div>

			<!-- Copyrights
			============================================= -->
			<div id="copyrights">

				<div class="container clearfix">

					<div class="col_full text-center nobottommargin">
					Copyright © <?php echo date("Y"); ?>. <a href="#">{{App\Library\Helper::getSettings()['storeName']}}</a>. Powered by <a href="http://www.eStorifi.com/" target="_blank">eStorifi</a>. 
						<!-- <div class="clearfix"></div>
						<div class="fleft clearfix">
							<div class="copyrights-menu copyright-links nobottommargin">
								<a href="#">Home</a>/<a href="#">T &amp; C</a>/<a href="#">Disclaimer</a>/<a href="{{route('contact-us')}}">Contact</a>
							</div>
						</div> -->
					</div>

<!--					<div class="col_half col_last tright">
						<div class="fright clearfix">
							<img src="{{ Config('constants.frontendPublicImgPath').'/payment-mode.png'}}" alt="payment Mode"/>
						</div>
					</div>-->

				</div>

			</div><!-- #copyrights end -->

		</footer><!-- #footer end -->
@extends('Frontend.layouts.default')
@section('content')

	<!--==========================

	    Banner Section starts
	  ============================-->
	<section id="intro" class="clearfix">
	    <div class="container d-flex h-100 desk-disp">
	      	<div class="row justify-content-center align-self-center">
		        <div class="col-md-6 intro-info order-md-first order-last">
		          	<h1>Empower your<br>Business</h1>
		          	<p>At your fingertips & always on-the-go</p>
		          	<a href="#" class="link">Learn More <i class="fa fa-angle-right"></i> </a>
				        <div>
					
						<a href="{{route('newstore')}}" class="btn-get-started scrollto">Join eStorifi</a>
                       
				        </div>
		        </div>
		  
		        <div class="col-md-6 intro-img order-md-last order-first">
		          	<img src="{{ asset('public/Frontend/images/banner.jpg')}}" alt="" class="img-fluid">
		        </div>
			</div>
		</div>
		<div class="container d-flex h-100 mob-disp">

		<div class="row justify-content-center align-self-center">
		        <div class="col-md-6 intro-info order-md-first">
		          	<h1>Empower your<br>Business</h1>
		          	<p>At your fingertips & always on-the-go</p>
		          	<a href="#" class="link">Learn More <i class="fa fa-angle-right"></i> </a>
		        </div>
		  
		        <div class="col-md-6 intro-img intro-img-mob order-md-last">
		          	<img src="{{ asset('public/Frontend/images/banner.jpg')}}" alt="" class="img-fluid">
				</div>
				<div class="col-md-12 banner-mob-btn text-center">
					<a href="#" class="btn-get-started scrollto">Join eStorifi</a>
				</div>
				<div class="col-md-12 text-center mt-15">
					<a href="#"><img src="{{ asset('public/Frontend/images/down-arrow.svg')}}" alt="" class="V"></a>
				</div>
		    </div>
		</div>
	    <div class="yellow-shape">
	    	<img src="{{ asset('public/Frontend/images/yellow-shape.svg')}}">
	    </div>
	    
	</section>

	<!--==========================
	    Banner Section ends
	  ============================-->

	<div class="clearfix"></div>
	<!--==========================
	    Sell online Section starts
	  ============================-->
	<section id="online-sell" class="white-bg-section">
	  	<div class="container">
	  		<div class="row">
				<div class="col-md-12">
					<div class="green-bg-section section-spacing">
						<div class="col-md-7 col-xs-12">
						<div class="content">
							<div class="green-bg-section-img margin-bottom-sm">
								<img src="{{ asset('public/Frontend/images/favicon.svg')}}">
							</div>
							
							<h3 class="title slategrey-color mb-5">Sell -</h3>
							<h3 class="title-boogergreen">Online & Offline</h3>
							<p class="slategrey-color">A solution which syncs everything on <br> a single platform.</p>
							<div class="">
								<a href="#" class="boogergreen">Learn More <i class="fa fa-angle-right"></i> </a>
							</div>
						</div>
						</div>
						<div class="lightblue-bg-section bluesection desk-disp">
							<div class="web-screen">
								<img src="{{ asset('public/Frontend/images/banner.jpg')}}" class="img-fluid">
							</div>
							<div class="mobile-screen bg-white">
								<img src="{{ asset('public/Frontend/images/banner.jpg')}}" class="img-fluid">
							</div>
						</div>
					</div>
					<div class="webscreen-mobscreen-carousal testimonials mob-disp">
					<div class="container">

<div class="row">
  <div class="col-sm-12">
	<div id="screen-testimonials" class="owl-carousel">

	  <!--TESTIMONIAL 1 -->
	  <div class="item">
		<div class="img-effect">
		  <img class="img-circle" src="http://themes.audemedia.com/html/goodgrowth/images/testimonial3.jpg" alt="">
		</div>
	  </div>
	  <!--END OF TESTIMONIAL 1 -->
	  <!--TESTIMONIAL 2 -->
	  <div class="item">
		<div class="img-effect">
		  <img class="img-circle" src="http://themes.audemedia.com/html/goodgrowth/images/testimonial3.jpg" alt="">
		</div>
	  </div>
	  <!--END OF TESTIMONIAL 2 -->
	</div>
  </div>
</div>
</div>
					</div>
				</div>
	  		</div>
	  	</div>
	</section>
	<!--==========================
	    sell online Section ends
	  ============================-->

	<!--==========================
	    Amplify Section starts
	  ============================-->

	<section id="amplify" class="text-center">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="amplify-img content">
						<header>
						  	<h3 class="title duskblue-color">Amplify your workforce today</h3>
						  	<p class="slategrey-color">Let eStorifi provide you tools to help you streamline your business <br>today, tomorrow and forever. </p>
						</header>
						<div>
						  	<img src="{{ asset('public/Frontend/images/work-force.svg')}}" class="img-fluid">
						</div>
					</div>
					<div class="features" id="services">
						<div class="ftrs-title desk-disp">
							<header class="content">
								<h3 class="title">Our Features</h3>
							</header>
						</div>
						<div class="ftrs-blocks">
					      	<div class="row">

						        <div class="col-md-6 col-lg-4 wow bounceInUp" data-wow-duration="1.4s">
						          	<div class="box">
						            	<div class="icon">
						            		<img src="{{ asset('public/Frontend/images/wall-clock.svg')}}">
						            	</div>
						            	<span class="title">Easy & Fast Setup</span>
						          	</div>
						        </div>
						        <div class="col-md-6 col-lg-4 wow bounceInUp" data-wow-duration="1.4s">
						          	<div class="box">
						            	<div class="icon">
						            		<img src="{{ asset('public/Frontend/images/window-2.svg')}}">
						            	</div>
						            	<span class="title">30+ Themes</span>
						          	</div>
						        </div>

						        <div class="col-md-6 col-lg-4 wow bounceInUp" data-wow-delay="0.1s" data-wow-duration="1.4s">
						          	<div class="box">
						            	<div class="icon">
						            		<img src="{{ asset('public/Frontend/images/computer.svg')}}">
						            	</div>
						            	<span class="title">Brand Customization</span>
						          	</div>
						        </div>
						        <div class="col-md-6 col-lg-4 wow bounceInUp" data-wow-delay="0.1s" data-wow-duration="1.4s">
						          	<div class="box">
						            	<div class="icon">
						            		<img src="{{ asset('public/Frontend/images/favicon.svg')}}">
						            	</div>
						            	<span class="title">Mobile Ready</span>
						          	</div>
						        </div>

						        <div class="col-md-6 col-lg-4 wow bounceInUp" data-wow-delay="0.2s" data-wow-duration="1.4s">
						          	<div class="box">
						            	<div class="icon">
						            		<img src="{{ asset('public/Frontend/images/tax.svg')}}">
						            	</div>
						            	<span class="title">Taxes & Charges</span>
						          	</div>
						        </div>
						        <div class="col-md-6 col-lg-4 wow bounceInUp" data-wow-delay="0.2s" data-wow-duration="1.4s">
						          	<div class="box">
						            	<div class="icon">
						            		<img src="{{ asset('public/Frontend/images/analytics-3.svg')}}">
						            	</div>
						            	<span class="title">Analytics & Reports</span>
						          	</div>
						        </div>
						        <div class="col-md-6 col-lg-4 wow bounceInUp" data-wow-delay="0.2s" data-wow-duration="1.4s">
							        <div class="box">
						            	<div class="icon">
						            		<img src="{{ asset('public/Frontend/images/megaphone.svg')}}">
						            	</div>
							            <span class="title">Marketing & SEO</span>
							        </div>
						    	</div>
						        <div class="col-md-6 col-lg-4 wow bounceInUp" data-wow-delay="0.3s" data-wow-duration="1.4s">
							        <div class="box">
						            	<div class="icon">
						            		<img src="{{ asset('public/Frontend/images/product.svg')}}">
						            	</div>
							            <span class="title">Products & Inventory</span>
							        </div>
						        </div>
						        <div class="col-md-6 col-lg-4 wow bounceInUp" data-wow-delay="0.3s" data-wow-duration="1.4s">
							        <div class="box">
						            	<div class="icon">
						            		<img src="{{ asset('public/Frontend/images/surface1.svg')}}">
						            	</div>
							            <span class="title">Web Hosting</span>
							        </div>
						        </div>
						        <div class="button-center-align col-md-12 mt-30">
						        	<a href="#" class="theme-btn dark-theme-btn">Browse Features</a>
						        </div>
					      	</div>
				      	</div>
					</div>
				</div>
			</div>

		</div>
		
	</section>
	<!--==========================
	    Amplify Section ends
	  ============================-->

	<div class="clearfix"></div>
	  <!--==========================
	      we serve Section starts
	    ============================-->
	  <section class="text-center duskblue-bg-section" id="industry">
	    	<div class="container">
	    		<div class="row">
	    			<div class="col-md-12">
	    				<div class="content">
	    					<h3 class="title slategrey-color">We serve every type of industry</h3>
	    					<p class="slategrey-color mb-70">Get a preview of how your Online Store would look like <br> and see how eStorifi can help your business grow. </p>
	    					<div class="row">
	    					        <div class="col col-xs-6">
	    					        	<div class="industry-typebox">
	    					        		<div class="image">
	    					        			<img src="{{ asset('public/Frontend/images/basket.svg')}}">
	    					        		</div>
	    					        		<div class="name">
	    					        			<span>Grocery</span>
	    					        		</div>
	    					        	</div>
	    					        </div>
	    					        <div class="col col-xs-6">
	    					        	<div class="industry-typebox">
	    					        		<div class="image">
	    					        			<img src="{{ asset('public/Frontend/images/tablet.svg')}}">
	    					        		</div>
	    					        		<div class="name">
	    					        			<span>Electonics</span>
	    					        		</div>
	    					        	</div>
	    					        </div>
	    					        <div class="col col-xs-6">
	    					        	<div class="industry-typebox">
	    					        		<div class="image">
	    					        			<img src="{{ asset('public/Frontend/images/clothing.svg')}}">
	    					        		</div>
	    					        		<div class="name">
	    					        			<span>Fashion</span>
	    					        		</div>
	    					        	</div>
	    					        </div>
	    					        <div class="col">
	    					        	<div class="industry-typebox">
	    					        		<div class="image">
	    					        			<img src="{{ asset('public/Frontend/images/picnic.svg')}}">
	    					        		</div>
	    					        		<div class="name">
	    					        			<span>Restaurants</span>
	    					        		</div>
	    					        	</div>
	    					        </div>
	    					        <div class="col">
	    					        	<div class="industry-typebox">
	    					        		<div class="image">
	    					        			<img src="{{ asset('public/Frontend/images/living-room.svg')}}">
	    					        		</div>
	    					        		<div class="name">
	    					        			<span>Home Decor</span>
	    					        		</div>
	    					        	</div>
	    					        </div>
	    					        <div class="col mob-disp">
	    					        	<div class="industry-typebox">
	    					        		<div class="image">
	    					        			<img src="{{ asset('public/Frontend/images/hardware.svg')}}">
	    					        		</div>
	    					        		<div class="name">
	    					        			<span>Hardware</span>
	    					        		</div>
	    					        	</div>
	    					        </div>
	    					    </div>
	    					<div class="button-center-align">
	    						<p class="mb-10">Checkout how your business will grow</p>
		  	  					<a href="#" class="text-white">Learn More <i class="fa fa-angle-right"></i> </a>
	    					</div>
	    				</div>
	    			</div>
	    		</div>
	    	</div>
	  </section>
	    <!--==========================
	        we serve Section ends
	      ============================-->

	<div class="clearfix"></div>
	<!--==========================
	    Your Journey Section starts
	  ============================-->
	<section class="text-center white-bg-section">
	  	<div class="container">
	  		<div class="row">
	  			<div class="col-md-12">
	  				<div class="content">
	  					<h3 class="title slategrey-color">Begin your business journey with eStorifi</h3>
	  					<p class="slategrey-color">Create your free account in minutes for free, and explore the power to start, run <br/>and scale your business your way.</p>
	  					<div class="button-center-align">
		  					<a href="#" class="theme-btn dark-theme-btn">Join eStorifi</a>
		  					<a href="#" class="theme-btn border-theme-btn">Need help?</a>
	  					</div>
	  				</div>
	  			</div>
	  		</div>
	  	</div>
	</section>
	  <!--==========================
	      Your Journey Section ends
	    ============================-->
@stop
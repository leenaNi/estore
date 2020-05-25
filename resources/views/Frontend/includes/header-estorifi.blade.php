<!-- Header
                ============================================= -->
<header id="header" class="transparent-header">
<div id="header-wrap">
	<div class="container clearfix">
		<div id="primary-menu-trigger"><i class="icon-reorder"></i></div>
		<!-- Logo
		============================================= -->
		<div id="logo">
			<a href="/" class="standard-logo" data-dark-logo="{{ asset(Config('constants.frontendPublicEstorifiImgPath').'/eStorifi.svg') }}"><img src="{{ asset(Config('constants.frontendPublicEstorifiImgPath').'/eStorifi.svg') }}" alt="eStorifi"></a>
			<a href="/" class="retina-logo" data-dark-logo="{{ asset(Config('constants.frontendPublicEstorifiImgPath').'/eStorifi.svg') }}"><img src="{{ asset(Config('constants.frontendPublicEstorifiImgPath').'/eStorifi.svg') }}" alt="eStorifi"></a>
		</div><!-- #logo end -->
		<!-- Primary Navigation
		============================================= -->
		<nav id="primary-menu">
			<ul>
				<li class="{{(Route::currentRouteName() == 'home')? 'active': ''}}"><a href="/"><div>Home</div></a></li>
				<!-- <li><a href="{{ route('about') }}" class="smooth-me"><div>About</div></a></li> -->
				<li class="{{(Route::currentRouteName() == 'features')? 'active': ''}}"><a href="/features" class="smooth-me"><div>Features</div></a></li>
				<li class="{{(Route::currentRouteName() == 'pricing')? 'active': ''}}"><a href="/pricing" class="smooth-me"><div>Pricing</div></a></li>
				<!-- <li><a href="{{ route('pricing') }}" class="smooth-me"><div>Pricing</div></a></li> -->
				<!-- <li><a href="http://www.veestores.com/#howitwork" class="smooth-me"><div>How It Works </div></a></li> -->
				<li class="{{(Route::currentRouteName() == 'selectThemes')? 'active': ''}}"><a href="{{ route('selectThemes') }}"><div>Themes</div></a></li>
			   <!-- <li><a href="{{ route('video-tutorials') }}"><div>Tutorial</div></a></li> -->
				@if(Session::get('merchantid'))
				 <li class="{{(Route::currentRouteName() == 'veestoreMyaccount')? 'active': ''}}"><a href="{{ route('veestoreMyaccount') }}" ><div>My Account</div></a></li>
					@if(Session::get('merchantstorecount') <=0)
				<li ><a href="{{ route('veestoresLogout') }}" ><div>Logout</div></a></li>
					@endif
				@else
				<li class="loginLink"><a href="#" data-toggle="modal" data-target=".loginpop" data-backdrop="static" data-keyboard="false"><div>Login</div></a></li>
				@endif
			</ul>
			<!-- Top Search
			============================================= -->
			<!-- <div id="top-search">
				<select class="sel-lang">
					<option>English</option>
					<option>Bengali</option>
				</select>
			</div> -->
			<!-- <div class="accountBoxLinks">
				<ul>
					<li>
						<a href="#"><i class="icon-user"></i></a>
						<ul>
							<li><a href="#">Login</a></li>
							<li><a href="#">My Account</a></li>
						</ul>
					</li>
				</ul>
			</div> -->
			<!-- #top-search end -->
		</nav><!-- #primary-menu end -->
	</div>
</div>
</header><!-- #header end -->

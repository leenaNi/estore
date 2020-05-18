
<header id="header">

    <div class="container clearfix header-container">

    	<div class="logo float-left">
        <!-- Uncomment below if you prefer to use an image logo -->
	        <!-- <h1 class="text-light"><a href="#intro" class="scrollto"><span>eStorifi</span></a></h1> -->
	        <a href="#header" class="scrollto"><img src="{{ asset('public/Frontend/images/eStorifi.svg')}}" alt="eStorifi" class="img-fluid"></a>
	     </div>

      	<nav class="main-nav float-right d-none d-lg-block">
        <ul>
         	<li class="active"><a href="https://www.estorifi.com/">Home</a></li>
			  <li><a href="https://www.estorifi.com/features">Features</a></li>
			  <li><a href="https://www.estorifi.com/pricing">Pricing</a></li>
			  <li><a href="https://www.estorifi.com/select-themes">Themes</a></li>
			  <li><a href="#about">Login</a></li>
          	<!-- <li class="drop-down"><a href="#">Merchants</a>
		        <ul>
		           	<li><a href="#">Drop Down 1</a></li>
		            <li class="drop-down"><a href="#">Drop Down 2</a>
		            	<ul>
		                	<li class="drop-down"><a href="#">Deep Drop Down 1</a></li>
		                		<ul>
		                		   	<li><a href="#">Drop Down in1</a></li>
		                		   	<li><a href="#">Drop Down in2</a></li>
		                		   	<li><a href="#">Drop Down in3</a></li>
		                		</ul>
		                	<li><a href="#">Deep Drop Down 2</a></li>
		                  	<li><a href="#">Deep Drop Down 3</a></li>
		                  	<li><a href="#">Deep Drop Down 4</a></li>
		                 	<li><a href="#">Deep Drop Down 5</a></li>
		                </ul>
              		</li>
              		<li><a href="#">Drop Down 3</a></li>
              		<li><a href="#">Drop Down 4</a></li>
              		<li><a href="#">Drop Down 5</a></li>
            	</ul>
          	</li>
          	<li class="drop-down"><a href="#">Distributors</a>
		        <ul>
		           	<li><a href="#">Drop Down 1</a></li>
		            <li class="drop-down"><a href="#">Drop Down 2</a>
		            	<ul>
		                	<li class="drop-down"><a href="#">Deep Drop Down 1</a></li>
		                		<ul>
		                		   	<li><a href="#">Drop Down in1</a></li>
		                		   	<li><a href="#">Drop Down in2</a></li>
		                		   	<li><a href="#">Drop Down in3</a></li>
		                		</ul>
		                	<li><a href="#">Deep Drop Down 2</a></li>
		                  	<li><a href="#">Deep Drop Down 3</a></li>
		                  	<li><a href="#">Deep Drop Down 4</a></li>
		                 	<li><a href="#">Deep Drop Down 5</a></li>
		                </ul>
              		</li>
              		<li><a href="#">Drop Down 3</a></li>
              		<li><a href="#">Drop Down 4</a></li>
              		<li><a href="#">Drop Down 5</a></li>
            	</ul>
          	</li>
			  @if(Session::get('merchantid'))
                     <li><a href="{{ route('veestoreMyaccount') }}" ><div>My Account</div></a></li> 
                        @if(Session::get('merchantstorecount') <=0)
                    <li><a href="{{ route('veestoresLogout') }}" ><div>Logout</div></a></li>
                        @endif
                    @else 
                    <li class="loginLink"><a href="#" data-toggle="modal" data-target=".loginpop" data-backdrop="static" data-keyboard="false"><div>Login</div></a></li>
                    @endif -->
        </ul>
	  </nav><!-- .main-nav -->
	  <div class="clearfix"></div>
      <!-- <hr class="header-divider"> -->
    </div>
  </header><!-- #header -->
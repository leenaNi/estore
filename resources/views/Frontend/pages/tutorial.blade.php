@extends('Frontend.layouts.default')
@section('content')
    <style>
    .profile-box {
    border: 1px solid #ddd;
    padding: 10px;
    border-radius: 4px;
}
.profile-name {
    font-weight: bold;
    font-size: 16px;
}
ul.profile-account-pagelist {
    list-style-type: none;
    padding: 0px 10px;
}
ul.profile-account-pagelist li {
    padding-bottom: 10px;
    margin-bottom: 10px;
    border-bottom: 1px dashed #ddd;
}
ul.profile-account-pagelist li:last-child {
    padding-bottom: 0px;
    margin-bottom: 0px;
    border-bottom: 0;
}
.account-linksbox{    border: 1px solid #ddd;
    padding: 10px;
    padding-top: 10px !important;
    margin-top: 30px !important;}
    .account-heading:after {
    content: '';
    display: block;
    margin-top: 10px;
    width: 100px;
    border-top: 2px solid #444;
}
.account-heading {
    margin-bottom: 40px;
}
.account-heading h2 {
    margin-bottom: 15px;
}
#page-title{padding: 20px 0 !important;}
    </style>
  

		<!-- Content
		============================================= -->
		<section id="content">

			<div class="content-wrap">

				<div class="container clearfix">
<!-- Sidebar
                    ============================================= -->
                    <div class="sidebar nobottommargin">
                        <div class="sidebar-widgets-wrap">

                            <div class="profile-box">
                                <div class="profile-name text-center topmargin-xs clearfix">{{$merchant->firstname}} {{$merchant->lastname}}</div>
                                <div class="email-profile text-center topmargin-xs clearfix"><strong><i class="icon-icon-envelope"></i></strong> {{$merchant->email}}</div>
                                <div class="mobile-profile text-center topmargin-xs bottommargin-xs clearfix"><strong><i class="icon-mobile"></i></strong> {{$merchant->phone}}</div>
                            </div>

                            <div class="widget account-linksbox clearfix">
                                <ul class="profile-account-pagelist nobottommargin">
                             <li><a href="#"> Tutorial</a></li>
                            @if(Session::get('merchantstorecount') >0)				
                            <li><a href="http://{{$merchant->my_Store}}"> Go to My Store</a></li>
                            <li><a href="http://{{$merchant->my_Store_admin}}">Go to My Store Admin</a></li>
                            @endif
                            <li><a href="{{ route('veestoreMyaccount') }}" >Edit Profile</a></li>
                            <li><a href="{{route('veestoresChangePassword')}}">Change Password</a></li>
                            <li><a href="{{ route('veestoresLogout') }}">Logout</a></li>
                            </ul>
                            </div>

                        </div>
                    </div><!-- .sidebar end -->
					<!-- Post Content
					============================================= -->
					<div class="postcontent nobottommargin col_last">
							<div class="profile-content">
								<!-- <div class="account-heading">
							<h2>Tutorials</h2>
						</div> -->
								<div class="text-center">
                                    <h2>Coming Soon</h2>
                                </div>
							</div><!-- .postcontent end -->
</div>
					

				</div>

			</div>

		</section><!-- #content end -->
@stop

@section('myscripts')
@stop
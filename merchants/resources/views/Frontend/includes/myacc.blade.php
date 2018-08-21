<div class="col-md-12 sidebar sidebar-left">
    <div class="col-lg-12 col-md-12">
        <div class="col-sm-12" style="padding-left:0px;">
            <?php
            //print_r(Session::all());
            $loggedUser = App\Models\User::find(Session::get('loggedin_user_id'));
            ?>
            <div id="recent-posts-2 recent-post-mar-bot" class="sidebar-widget widget_recent_entries">
                <h4 class="widget-title"><span style="padding-right:0px;">{{ $loggedUser->firstname." ".$loggedUser->lastname }},</span></h4>
            </div>
        </div>
        <div class="col-sm-12 prof-bg">
            <!--<h3 class="widget-title">{{ App\Models\User::find(Session::get('loggedin_user_id'))->firstname." ".App\Models\User::find(Session::get('loggedin_user_id'))->lastname }}</h3>-->
            <div id="recent-posts-2 recent-post-mar-top" class="sidebar-widget widget_recent_entries mar-bot-imp">
                <ul>
                    <li><strong>Email:</strong> {{$loggedUser->email}}</li>
                    <li><strong>Mobile:</strong> {{$loggedUser->telephone}}</li>
                  
                </ul>
            </div>
            <div id="archives-2" class="sidebar-widget widget_archive">
                <h4 class="widget-title"></h4>
                <ul>
                    <li class="{{ (Route::currentRouteName() == 'myProfile')?'myaccActive':'' }}"><a href="{{ route('myProfile') }}">My Orders</a></li>
                    <li class="{{ (Route::currentRouteName() == 'editProfile')?'myaccActive':'' }}" ><a href="{{ route('editProfile') }}">Edit Profile</a></li>
                    <li class="{{ (Route::currentRouteName() == 'wishlists')?'myaccActive':'' }}" ><a href="{{ route('wishlists') }}">Wishlist</a></li>
                    <li class="{{ (Route::currentRouteName() == 'cashBackHistory')?'myaccActive':'' }}" ><a href="{{ route('cashBackHistory') }}">Cashback history</a></li>
                    <li class="{{ (Route::currentRouteName() == 'changePasswordMyAcc')?'myaccActive':'' }}" ><a href="{{ route('changePasswordMyAcc') }}">Change Password</a></li>
                    <li class="{{ (Route::currentRouteName() == 'myaccFeedback')?'myaccActive':'' }}" ><a href="{{ route('myaccFeedback') }}">Feedback</a></li>
                    <!--                                    <li><a href="#">Change Password</a></li>
                                                        <li class="lastItem"><a href="#">FeedBack</a></li>-->
                </ul>
            </div>
        </div>
    </div>
</div>
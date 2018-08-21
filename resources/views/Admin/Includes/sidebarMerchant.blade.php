<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <ul class="sidebar-menu">
            <li class="{{ (in_array(Route::currentRouteName(),['admin.dashboard'])?'active':'') }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fa fa-bar-chart"></i> <span>Dashboard</span> <i class=""></i>
                </a>
            </li>

            <li class="{{ (in_array(Route::currentRouteName(),['admin.merchants.view'])?'active':'') }}">
                <a href="{{ route('admin.merchants.view') }}">
                    <i class="fa fa-users"></i> <span>Merchants</span>
                </a>
            </li>

            <li class="{{ (in_array(Route::currentRouteName(),['admin.stores.view'])?'active':'') }}">
                <a href="{{ route('admin.stores.view') }}">
                    <i class="fa fa-shopping-cart"></i> <span>Stores</span>

                </a>

            </li>


<!--
            <li class="treeview {{ in_array(Route::currentRouteName(),['admin.analytics.byCategory','admin.analytics.byMerchant','admin.analytics.byStore','admin.analytics.byDate']) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-area-chart"></i> <span>Analytics</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu {{ in_array(Route::currentRouteName(),['admin.analytics.byCategory','admin.analytics.byMerchant','admin.analytics.byStore','admin.analytics.byDate']) ? 'menu-open' : '' }}">

                    <li class="{{ in_array(Route::currentRouteName(),['admin.analytics.byMerchant']) ? 'active' : '' }}"><a href="{{ route('admin.analytics.byMerchant') }}"><i class="fa fa-circle-o"></i>By Merchant</a></li>

                    <li class="{{ in_array(Route::currentRouteName(),['admin.analytics.byStore']) ? 'active' : '' }}"><a href="{{ route('admin.analytics.byStore') }}"><i class="fa fa-circle-o"></i>By Store</a></li>
                    <li class="{{ in_array(Route::currentRouteName(),['admin.analytics.byDate']) ? 'active' : '' }}"><a href="{{ route('admin.analytics.byDate') }}"><i class="fa fa-circle-o"></i>By Date</a></li>
                                        <li class="{{ in_array(Route::currentRouteName(),['admin.analytics.byCategory']) ? 'active' : '' }}"><a href="{{ route('admin.analytics.byCategory') }}"><i class="fa fa-circle-o"></i>By Category</a></li>

                </ul>

            </li>-->
       

  
     

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
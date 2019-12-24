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



            <li class="treeview {{ in_array(Route::currentRouteName(),['admin.analytics.byCategory','admin.analytics.byMerchant','admin.analytics.byStore','admin.analytics.byDate','admin.analytics.byBank']) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-area-chart"></i> <span>Analytics</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu {{ in_array(Route::currentRouteName(),['admin.analytics.byCategory','admin.analytics.byMerchant','admin.analytics.byStore','admin.analytics.byDate','admin.analytics.byBank']) ? 'menu-open' : '' }}">
               <!--  <li class="{{ in_array(Route::currentRouteName(),['admin.analytics.byBank']) ? 'active' : '' }}"><a href="{{ route('admin.analytics.byBank') }}"><i class="fa fa-circle-o"></i>By Bank</a></li>

                    <li class="{{ in_array(Route::currentRouteName(),['admin.analytics.byMerchant']) ? 'active' : '' }}"><a href="{{ route('admin.analytics.byMerchant') }}"><i class="fa fa-circle-o"></i>By Merchant</a></li> -->

                    <li class="{{ in_array(Route::currentRouteName(),['admin.analytics.byStore']) ? 'active' : '' }}"><a href="{{ route('admin.analytics.byStore') }}"><i class="fa fa-circle-o"></i>By Store</a></li>
                    <!-- <li class="{{ in_array(Route::currentRouteName(),['admin.analytics.byDate']) ? 'active' : '' }}"><a href="{{ route('admin.analytics.byDate') }}"><i class="fa fa-circle-o"></i>By Date</a></li> -->
                    <li class="{{ in_array(Route::currentRouteName(),['admin.analytics.byCategory']) ? 'active' : '' }}"><a href="{{ route('admin.analytics.byCategory') }}"><i class="fa fa-circle-o"></i>By Category</a></li>

                </ul>

            </li>


            <li class="treeview {{ in_array(Route::currentRouteName(),['admin.payment-settlement','admin.payment-settlements.settlementSummary']) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-money"></i> <span>Payment Settlement</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu {{ in_array(Route::currentRouteName(),['admin.payment-settlement.view','admin.payment-settlements.settlementSummary']) ? 'menu-open' : '' }}">
                    <li class="{{ in_array(Route::currentRouteName(),['admin.payment-settlement.view']) ? 'active' : '' }}"><a href="{{ route('admin.payment-settlement.view') }}"><i class="fa fa-circle-o"></i>Payment Settlement</a></li>

                    <li class="{{ in_array(Route::currentRouteName(),['admin.payment-settlements.settlementSummary']) ? 'active' : '' }}"><a href="{{route('admin.payment-settlements.settlementSummary')}}"><i class="fa fa-circle-o"></i>Settlement Summary</a></li>

                </ul>

            </li>
          
            <li class="treeview {{ in_array(Route::currentRouteName(),['admin.systemusers.roles.view','admin.systemusers.users.view']) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-users"></i> <span>System Users</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu {{ in_array(Route::currentRouteName(),['admin.systemusers.roles.view','admin.systemusers.users.view']) ? 'menu-open' : '' }}">
                    <li class="active"><a href="{{ route('admin.systemusers.roles.view') }}"><i class="fa fa-circle-o"></i>Roles</a></li>
                    <li><a href="{{ route('admin.systemusers.users.view') }}"><i class="fa fa-circle-o"></i>Users</a></li>

                </ul>

            </li>
              <li class="{{ (in_array(Route::currentRouteName(),['admin.courier.view'])?'active':'') }}">
                <a href="{{ route('admin.courier.view') }}">
                    <i class="fa fa-truck"></i> <span>Courier Services</span>

                </a>

            </li>
            <li class="treeview {{ in_array(Route::currentRouteName(),['admin.notification.view']) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-users"></i> <span>Push Notification</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu {{ in_array(Route::currentRouteName(),['admin.notification.view']) ? 'menu-open' : '' }}">

                    <li><a href="{{ route('admin.notification.view') }}"><i class="fa fa-circle-o"></i>Sent Notification</a></li>

                </ul>

            </li>

            <li class="treeview  {{ in_array(Route::currentRouteName(),['admin.masters.category.view','admin.masters.language.view','admin.masters.language.addEdit','admin.masters.category.addEdit','admin.masters.themes.view','admin.masters.themes.addEdit']) ? 'active' : '' }}" >
                <a href="#">
                    <i class="fa fa-database"></i> <span>Masters</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>

                </a>

                <ul class="treeview-menu {{ in_array(Route::currentRouteName(),[
                                'admin.masters.language.view',
                               'admin.masters.language.view'
                            ]) ? 'menu-open' : '' }}">
                    <li class="{{ in_array(Route::currentRouteName(),['admin.masters.category.view','admin.masters.category.addEdit'])?'active':'' }}"><a href="{{ route('admin.masters.category.view') }}"><i class="fa fa-circle-o"></i>Store Categories</a></li>


                    <li class="{{ in_array(Route::currentRouteName(),['admin.masters.language.view','admin.masters.language.addEdit'])?'active':'' }}"><a href="{{ route('admin.masters.language.view') }}"><i class="fa fa-circle-o"></i>Language</a></li>
                    <li class="{{ in_array(Route::currentRouteName(),['admin.masters.translation.view'])?'active':'' }}"><a href="{{ route('admin.masters.translation.view') }}"><i class="fa fa-circle-o"></i>Translation</a></li>
                    <li class="{{ in_array(Route::currentRouteName(),['admin.masters.themes.view','admin.masters.themes.addEdit'])?'active':'' }}"><a href="{{ route('admin.masters.themes.view') }}"><i class="fa fa-circle-o"></i>Themes</a></li>


                </ul>
            </li>
           
            <li class="treeview {{ in_array(Route::currentRouteName(),['admin.reports.view','admin.reports.getstoreorders']) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-file"></i> <span>Reports</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu {{ in_array(Route::currentRouteName(),[
                                'admin.masters.language.view',
                               'admin.masters.language.view'
                            ]) ? 'menu-open' : '' }}">
                    <li class="{{ in_array(Route::currentRouteName(),['admin.reports.view','admin.reports.getstoreorders'])?'active':'' }}"><a href="{{ route('admin.reports.view') }}"><i class="fa fa-circle-o"></i>Store Orders</a></li>
                </ul>

            </li>
            <li class="{{ (in_array(Route::currentRouteName(),['admin.settings.view'])?'active':'') }}">
                <a href="{{route('admin.settings.view')}}">
                    <i class="fa fa-cogs"></i> <span>Settings</span>
                </a>
            </li>
<!--            <li class="{{ (in_array(Route::currentRouteName(),['admin.templates.view'])?'active':'') }}">
                <a href="{{route('admin.templates.view')}}">
                    <i class="fa fa-laptop"></i> <span>Templates</span>
                </a>
            </li>-->
            <li class="treeview {{ in_array(Route::currentRouteName(),['admin.updates.codeUpdate.view','admin.updates.databaseUpdate.view']) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-wrench"></i> <span>Version Upgrade</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>

                </a>
                <ul class="treeview-menu {{ in_array(Route::currentRouteName(),['admin.updates.codeUpdate.view','admin.updates.databaseUpdate.view']) ? 'menu-open' : '' }}">
                    <li><a href="{{ route('admin.updates.codeUpdate.view') }}"><i class="fa fa-circle-o"></i>Code Update</a></li>

<!--                    <li class="active"><a href="{{ route('admin.updates.databaseUpdate.view') }}"><i class="fa fa-circle-o"></i>Database Update</a></li>-->

                </ul>
            </li>


        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
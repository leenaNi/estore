<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <ul class="sidebar-menu">
            <li class="{{ (in_array(Route::currentRouteName(),['admin.dashboard'])?'active':'') }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fa fa-bar-chart"></i> <span>Home</span> <i class=""></i>
                </a>
            </li>
            <li class="treeview {{ in_array(Route::currentRouteName(),['admin.payment-settlement.view','admin.payment-settlements.settlementSummary']) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-money"></i> <span>Sales</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu {{ in_array(Route::currentRouteName(),['admin.payment-settlement.view','admin.payment-settlements.settlementSummary']) ? 'menu-open' : '' }}">
                    <li class="{{ in_array(Route::currentRouteName(),['admin.payment-settlement.view']) ? 'active' : '' }}"><a href="{{ route('admin.payment-settlement.view') }}"><i class="fa fa-circle-o"></i>Payment Settlement</a></li>
                    <li class="{{ in_array(Route::currentRouteName(),['admin.payment-settlements.settlementSummary']) ? 'active' : '' }}"><a href="{{route('admin.payment-settlements.settlementSummary')}}"><i class="fa fa-circle-o"></i>Settlement Summary</a></li>
                </ul>
            </li>

            <li class="treeview  {{ in_array(Route::currentRouteName(),['admin.masters.category.view','admin.masters.company.view','admin.masters.brand.view','admin.masters.language.view','admin.masters.translation.view','admin.masters.language.addEdit','admin.masters.category.addEdit','admin.masters.company.addEdit','admin.masters.brand.addEdit','admin.masters.themes.view','admin.masters.themes.addEdit','admin.masters.country.view','admin.masters.country.addEdit','admin.masters.currency.view','admin.masters.currency.addEdit','admin.category.view','admin.category.add','admin.category.edit','admin.category.categoriesRequested']) ? 'active' : '' }}" >
                <a href="#">
                    <i class="fa fa-database"></i> <span>Catalog</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu {{ in_array(Route::currentRouteName(),[
                                'admin.masters.language.view',
                               'admin.masters.language.view',
                               'admin.category', 'admin.masters.themes', 'admin.masters.brand', 'admin.masters.country', 'admin.masters.currency'

                            ]) ? 'menu-open' : '' }}">
                    <li class="{{ in_array(Route::currentRouteName(),['admin.masters.category.view','admin.masters.category.addEdit'])?'active':'' }}"><a href="{{ route('admin.masters.category.view') }}"><i class="fa fa-circle-o"></i>Industry</a></li>
                    <li class="treeview {{ preg_match('/admin.category|admin.category.addEdit|admin.category.categoriesRequested/',Route::currentRouteName())? 'active' : ''}}">
                        <a href="#">
                            <i class="fa fa-database"></i> <span>Categories</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{ in_array(Route::currentRouteName(),['admin.category.view','admin.category.add','admin.category.edit'])?'active':'' }}"><a href="{{ route('admin.category.view') }}"><i class="fa fa-circle-o"></i>Master</a></li>
                            <li class="{{ in_array(Route::currentRouteName(),['admin.category.categoriesRequested'])?'active':'' }}"><a href="{{ route('admin.category.categoriesRequested') }}"><i class="fa fa-circle-o"></i>Requested</a></li>
                        </ul>
                    </li>
                    <li class="{{ in_array(Route::currentRouteName(),['admin.masters.company.view','admin.masters.company.addEdit'])?'active':'' }}"><a href="{{ route('admin.masters.company.view') }}"><i class="fa fa-circle-o"></i>Company</a></li>
                    <li class="{{ in_array(Route::currentRouteName(),['admin.masters.brand.view','admin.masters.brand.addEdit'])?'active':'' }}"><a href="{{ route('admin.masters.brand.view') }}"><i class="fa fa-circle-o"></i>Brand</a></li>
                    <li class="{{ in_array(Route::currentRouteName(),['admin.masters.language.view','admin.masters.language.addEdit'])?'active':'' }}"><a href="{{ route('admin.masters.language.view') }}"><i class="fa fa-circle-o"></i>Language</a></li>
                    <li class="{{ in_array(Route::currentRouteName(),['admin.masters.translation.view'])?'active':'' }}"><a href="{{ route('admin.masters.translation.view') }}"><i class="fa fa-circle-o"></i>Translation</a></li>
                    <li class="{{ in_array(Route::currentRouteName(),['admin.masters.themes.view','admin.masters.themes.addEdit'])?'active':'' }}"><a href="{{ route('admin.masters.themes.view') }}"><i class="fa fa-circle-o"></i>Themes</a></li>
                    <li class="{{ in_array(Route::currentRouteName(),['admin.masters.country.view','admin.masters.country.addEdit'])?'active':'' }}"><a href="{{ route('admin.masters.country.view') }}"><i class="fa fa-circle-o"></i>Country</a></li>
                    <li class="{{ in_array(Route::currentRouteName(),['admin.masters.currency.view','admin.masters.currency.addEdit'])?'active':'' }}"><a href="{{ route('admin.masters.currency.view') }}"><i class="fa fa-circle-o"></i>Currency</a></li>
                </ul>
            </li>

            <li class="treeview {{ in_array(Route::currentRouteName(),['admin.reports.view','admin.reports.getstoreorders','admin.analytics.byStore','admin.analytics.byCategory']) ? 'active' : '' }}">
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
                </ul>
            </li>
            <li class="{{ (in_array(Route::currentRouteName(),['admin.courier.view', 'admin.courier.add', 'admin.courier.edit', 'admin.courier.update', 'admin.courier.save', 'admin.settings.view', 'admin.notification.view'])?'active':'') }}">
                <a href="{{route('admin.settings.view')}}">
                    <i class="fa fa-cogs"></i> <span>Configurations</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu {{ in_array(Route::currentRouteName(),['admin.courier.view','admin.courier.add','admin.courier.edit','admin.courier.save','admin.courier.update','admin.courier.changeStatus', 'admin.courier.delete','admin.notification.view','admin.notification.addNew', 'admin.settings.view','admin.settings.update']) ? 'menu-open' : '' }}">
                    <li class="{{ in_array(Route::currentRouteName(),['admin.settings.view','admin.settings.update']) ? 'active' : '' }}"><a href="{{route('admin.settings.view')}}"><i class="fa fa-circle-o"></i>Settings</a></li>
                    <li class="{{ in_array(Route::currentRouteName(),['admin.notification.view','admin.notification.addNew']) ? 'active' : '' }}"><a href="{{ route('admin.notification.view') }}"><i class="fa fa-circle-o"></i>Sent Notification</a></li>
                    <li class="{{ in_array(Route::currentRouteName(),['admin.courier.view','admin.courier.add','admin.courier.edit','admin.courier.save','admin.courier.update','admin.courier.changeStatus','admin.courier.delete']) ? 'active' : '' }}"><a href="{{ route('admin.courier.view') }}"><i class="fa fa-circle-o"></i>Courier Services</a></li>
                </ul>
            </li>

            <li class="treeview {{ in_array(Route::currentRouteName(),['admin.systemusers.roles.view','admin.systemusers.users.view']) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-users"></i> <span>System Users</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu {{ in_array(Route::currentRouteName(),['admin.systemusers.roles.view','admin.systemusers.roles.addEdit','admin.systemusers.roles.saveUpdate','admin.systemusers.roles.delete','admin.systemusers.users.view','admin.systemusers.users.addEdit','admin.systemusers.users.saveUpdate','admin.systemusers.users.delete']) ? 'menu-open' : '' }}">
                    <li class="{{ in_array(Route::currentRouteName(),['admin.systemusers.roles.view','admin.systemusers.roles.addEdit','admin.systemusers.roles.saveUpdate','admin.systemusers.roles.delete']) ? 'active' : '' }}"><a href="{{ route('admin.systemusers.roles.view') }}"><i class="fa fa-circle-o"></i>Roles</a></li>
                    <li class="{{ in_array(Route::currentRouteName(),['admin.systemusers.users.view','admin.systemusers.users.addEdit','admin.systemusers.users.saveUpdate','admin.systemusers.users.delete']) ? 'active' : '' }}"><a href="{{ route('admin.systemusers.users.view') }}"><i class="fa fa-circle-o"></i>Users</a></li>

                </ul>
            </li>
            <li class="{{ (in_array(Route::currentRouteName(),['admin.merchants.view','admin.merchants.addEdit'])?'active':'') }}">
                <a href="{{ route('admin.merchants.view') }}">
                    <i class="fa fa-users"></i> <span>Merchants</span>
                </a>
            </li>
            <li class="{{ (in_array(Route::currentRouteName(),['admin.distributors.view','admin.distributors.addEdit','admin.distributors.saveUpdate'])?'active':'') }}">
                <a href="{{ route('admin.distributors.view') }}">
                    <i class="fa fa-users"></i> <span>Distributors</span>
                </a>
            </li>
            <li class="{{ (in_array(Route::currentRouteName(),['admin.stores.view','admin.stores.addEdit'])?'active':'') }}">
                <a href="{{ route('admin.stores.view') }}">
                    <i class="fa fa-shopping-cart"></i> <span>Stores</span>
                </a>
            </li>
<!--            <li class="{{ (in_array(Route::currentRouteName(),['admin.templates.view'])?'active':'') }}">
                <a href="{{route('admin.templates.view')}}">
                    <i class="fa fa-laptop"></i> <span>Templates</span>
                </a>
            </li>-->
            <li class="treeview {{ in_array(Route::currentRouteName(),['admin.updates.codeUpdate.view','admin.updates.databaseUpdate.view','admin.updates.codeUpdate.newCodeUpdate','admin.updates.backup.index']) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-wrench"></i> <span>Version Upgrade</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu {{ in_array(Route::currentRouteName(),['admin.updates.codeUpdate.view','admin.updates.codeUpdate.newCodeUpdate','admin.updates.databaseUpdate.view','admin.updates.backup.index']) ? 'menu-open' : '' }}">
                    <li class="{{ in_array(Route::currentRouteName(),['admin.updates.codeUpdate.view','admin.updates.codeUpdate.newCodeUpdate','admin.updates.backup.index']) ? 'active' : '' }}"><a href="{{ route('admin.updates.codeUpdate.view') }}"><i class="fa fa-circle-o"></i>Code Update</a></li>
<!--                    <li class="active"><a href="{{ route('admin.updates.databaseUpdate.view') }}"><i class="fa fa-circle-o"></i>Database Update</a></li>-->
                </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

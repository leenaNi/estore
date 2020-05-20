<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
         <li class="{{ Route::currentRouteName() == 'admin.vendors.dashboard' ? 'active' : '' }}">
                <a href="{{ route('admin.vendors.dashboard') }}">
                    <i class="fa fa-bar-chart"></i><span>Dashboard</span> <i class=""></i>
                </a>
            </li>
            <li class="{{ Route::currentRouteName() == 'admin.vendors.product' ? 'active' : '' }}">
                <a href="{{ route('admin.vendors.product') }}">
                    <i class="fa fa-bar-chart"></i><span>Products</span> <i class=""></i>
                </a>
            </li>
            <li class="{{ Route::currentRouteName() == 'admin.vendors.orders' ? 'active' : '' }}">
                <a href="{{ route('admin.vendors.orders') }}">
                    <i class="fa fa-bar-chart"></i><span>Orders</span> <i class=""></i>
                </a>
            </li>
             <li class="treeview {{ preg_match("/admin.vendors.saleByOrder|admin.vendors.saleByProduct/",Route::currentRouteName()) ? 'active' : '' }}">
                <a href="">
                    <i class="fa fa-line-chart"></i><span>Analytics</span>
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ preg_match("/admin.vendors.saleByOrder/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.vendors.saleByOrder') }}"><i class="fa fa-angle-right"></i>By Orders</a></li>
                </ul>
                <ul class="treeview-menu">
                    <li class="{{ preg_match("/admin.vendors.saleByProduct/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.vendors.saleByProduct') }}"><i class="fa fa-angle-right"></i>By Products</a></li>
                </ul>
                

        </ul>
    
    </section>

</aside>
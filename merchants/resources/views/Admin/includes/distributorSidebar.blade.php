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
            <li class="treeview {{ preg_match("/admin.orders|admin.orders.OrderReturn|admin.miscellaneous.flags|admin.order_status|additional-charges/",Route::currentRouteName()) ? 'active' : '' }}">
                <a href="">
                    <i class="fa fa-shopping-cart"></i><span>Orders</span>
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ preg_match("/admin.orders.view/",Route::currentRouteName()) ? 'active' : '' }}">
                        <a  href="{{ route('admin.orders.view') }}"><i class="fa fa-angle-right"></i>All Orders</a>
                    </li>
                    <li class="{{ preg_match("/admin.orders.OrderReturn/",Route::currentRouteName()) ? 'active' : '' }}">
                        <a  href="{{ route('admin.orders.OrderReturn') }}"><i class="fa fa-angle-right"></i>Return Orders</a>
                    </li>
                    <li class="{{ preg_match("/admin.orders.cancelOrder/",Route::currentRouteName()) ? 'active' : '' }}">
                        <a  href="{{ route('admin.orders.cancelOrder') }}"><i class="fa fa-angle-right"></i>Cancel Orders</a>
                    </li>
                    @if($feature['flag'] == 1)
                    <li class="{{ preg_match("/admin.miscellaneous.flags/",Route::currentRouteName()) ? 'active' : '' }} {{$storeViesion}}" >
                        <a  href="{{ route('admin.miscellaneous.flags') }}"><i class="fa fa-angle-right"></i>Flags</a></li>
                    @endif
                    <li class="{{ preg_match("/admin.order_status.view/",Route::currentRouteName()) ? 'active' : '' }}">
                        <a  href="{{ route('admin.order_status.view') }}"><i class="fa fa-angle-right"></i>Order Status</a></li>
                    @if($feature['additional-charge'] == 1)
                    <li class="{{ preg_match("/admin.additional-charges.view/",Route::currentRouteName()) ? 'active' : '' }}">
                        <a  href="{{ route('admin.additional-charges.view') }}"><i class="fa fa-angle-right"></i>Additional Charges</a></li>
                    @endif
                </ul>
            </li>
            <li class="treeview {{ preg_match("/admin.category|admin.reviews.view|admin.products|admin.attribute.set|admin.tax|admin.attributes|admin.sizechart|admin.raw-material|admin.stock/",Route::currentRouteName()) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-product-hunt"></i><span>Products</span>
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ preg_match("/admin.products/",Route::currentRouteName()) ? 'active' : '' }}"><a href="{{ route('admin.products.view') }}"><i class="fa fa-angle-right"></i>All Products</a></li>
                    <li class="{{ preg_match("/admin.reviews/",Route::currentRouteName()) ? 'active' : '' }}"><a href="{{ route('admin.reviews.view') }}"><i class="fa fa-angle-right"></i>Customer Reviews</a></li>
                    <li class="{{ preg_match("/admin.category/",Route::currentRouteName()) ? 'active' : '' }}"><a href="{{ route('admin.category.view') }}"><i class="fa fa-angle-right"></i>Categories</a></li>

                    @if($settingStatus['products-with-variants'] == 1)

                    <li class="{{ preg_match("/admin.attribute.set/",Route::currentRouteName()) ? 'active' : '' }}"><a href="{{ route('admin.attribute.set.view') }}"><i class="fa fa-angle-right"></i>Variant Sets</a></li>
                    <li class="{{ preg_match("/admin.attributes/",Route::currentRouteName()) ? 'active' : '' }}"><a href="{{ route('admin.attributes.view') }}"><i class="fa fa-angle-right"></i>Attributes</a></li>
                    @endif

                    @if($feature['stock'] == 1)
                    <li class="{{ preg_match("/admin.stock/",Route::currentRouteName()) ? 'active' : '' }}"">
                        <a href="#"><i class="fa fa-angle-right"></i>Inventory</a>
                        <ul class="treeview-menu">
                            <li class="treeview {{ preg_match("/admin.stock.view/",Route::currentRouteName()) ? 'active' : '' }}">
                                <a href="{{ route('admin.stock.view') }}"><i class="fa fa-angle-right"></i>In Stock</a>
                            </li>
                            <li class="treeview {{ preg_match("/admin.stock.runningShort/",Route::currentRouteName()) ? 'active' : '' }}">
                                <a href="{{ route('admin.stock.runningShort') }}"><i class="fa fa-angle-right"></i>Running Short</a>
                            </li>
                            <li class="treeview {{ preg_match("/admin.stock.outOfStock/",Route::currentRouteName()) ? 'active' : '' }}">
                                <a href="{{ route('admin.stock.outOfStock') }}"><i class="fa fa-angle-right"></i>Out of Stock</a>
                            </li>


                        </ul>
                    </li>
                    @endif
                    @if($feature['tax']==1)
                    <li class="{{ preg_match("/admin.tax/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.tax.view') }}"><i class="fa fa-angle-right"></i>Taxes</a></li>
                    @endif

                    @if($feature['row-material'] == 1)
                    <li class="{{ preg_match("/admin.raw-material/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.raw-material.view') }}"><i class="fa fa-angle-right"></i>Raw Material</a></li>
                    @endif

                </ul>
            </li>
            <li class="{{ Route::currentRouteName() == 'admin.vendors.product' ? 'active' : '' }}">
                <a href="{{ route('admin.vendors.product') }}">
                    <i class="fa fa-bar-chart"></i><span>Products</span> <i class=""></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ preg_match("/admin.products/",Route::currentRouteName()) ? 'active' : '' }}"><a href="{{ route('admin.products.view') }}"><i class="fa fa-angle-right"></i>All Products</a></li>
                    <li class="{{ preg_match("/admin.reviews/",Route::currentRouteName()) ? 'active' : '' }}"><a href="{{ route('admin.reviews.view') }}"><i class="fa fa-angle-right"></i>Customer Reviews</a></li>
                    <li class="{{ preg_match("/admin.category/",Route::currentRouteName()) ? 'active' : '' }}"><a href="{{ route('admin.category.view') }}"><i class="fa fa-angle-right"></i>Categories</a></li>

                    @if($settingStatus['products-with-variants'] == 1)

                    <li class="{{ preg_match("/admin.attribute.set/",Route::currentRouteName()) ? 'active' : '' }}"><a href="{{ route('admin.attribute.set.view') }}"><i class="fa fa-angle-right"></i>Variant Sets</a></li>
                    <li class="{{ preg_match("/admin.attributes/",Route::currentRouteName()) ? 'active' : '' }}"><a href="{{ route('admin.attributes.view') }}"><i class="fa fa-angle-right"></i>Attributes</a></li>
                    @endif

                    @if($feature['stock'] == 1)
                    <li class="{{ preg_match("/admin.stock/",Route::currentRouteName()) ? 'active' : '' }}"">
                        <a href="#"><i class="fa fa-angle-right"></i>Inventory</a>
                        <ul class="treeview-menu">
                            <li class="treeview {{ preg_match("/admin.stock.view/",Route::currentRouteName()) ? 'active' : '' }}">
                                <a href="{{ route('admin.stock.view') }}"><i class="fa fa-angle-right"></i>In Stock</a>
                            </li>
                            <li class="treeview {{ preg_match("/admin.stock.runningShort/",Route::currentRouteName()) ? 'active' : '' }}">
                                <a href="{{ route('admin.stock.runningShort') }}"><i class="fa fa-angle-right"></i>Running Short</a>
                            </li>
                            <li class="treeview {{ preg_match("/admin.stock.outOfStock/",Route::currentRouteName()) ? 'active' : '' }}">
                                <a href="{{ route('admin.stock.outOfStock') }}"><i class="fa fa-angle-right"></i>Out of Stock</a>
                            </li>


                        </ul>
                    </li>
                    @endif
                    @if($feature['tax']==1)  
                    <li class="{{ preg_match("/admin.tax/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.tax.view') }}"><i class="fa fa-angle-right"></i>Taxes</a></li>
                    @endif

                    @if($feature['row-material'] == 1)
                    <li class="{{ preg_match("/admin.raw-material/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.raw-material.view') }}"><i class="fa fa-angle-right"></i>Raw Material</a></li>
                    @endif

                </ul>
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
            </li>
            <li class="treeview {{ preg_match("/admin.orders|admin.orders.OrderReturn|admin.miscellaneous.flags|admin.order_status|additional-charges/",Route::currentRouteName()) ? 'active' : '' }}">
                <a href="">
                    <i class="fa fa-shopping-cart"></i><span>Orders</span>
                    <i class="fa fa-angle-down pull-right"></i>
                </a>

                <ul class="treeview-menu">
                    <li class="{{ preg_match("/admin.orders.view/",Route::currentRouteName()) ? 'active' : '' }}">
                        <a  href="{{ route('admin.orders.view') }}"><i class="fa fa-angle-right"></i>All Orders</a>
                    </li>
                    <li class="{{ preg_match("/admin.orders.OrderReturn/",Route::currentRouteName()) ? 'active' : '' }}">
                        <a  href="{{ route('admin.orders.OrderReturn') }}"><i class="fa fa-angle-right"></i>Return Orders</a>
                    </li>
                    <li class="{{ preg_match("/admin.orders.cancelOrder/",Route::currentRouteName()) ? 'active' : '' }}">
                        <a  href="{{ route('admin.orders.cancelOrder') }}"><i class="fa fa-angle-right"></i>Cancel Orders</a>
                    </li>
                    @if($feature['flag'] == 1)                   
                    <li class="{{ preg_match("/admin.miscellaneous.flags/",Route::currentRouteName()) ? 'active' : '' }} {{$storeViesion}}" >
                        <a  href="{{ route('admin.miscellaneous.flags') }}"><i class="fa fa-angle-right"></i>Flags</a></li>
                    @endif
                    <li class="{{ preg_match("/admin.order_status.view/",Route::currentRouteName()) ? 'active' : '' }}">
                        <a  href="{{ route('admin.order_status.view') }}"><i class="fa fa-angle-right"></i>Order Status</a></li>
                    @if($feature['additional-charge'] == 1)
                    <li class="{{ preg_match("/admin.additional-charges.view/",Route::currentRouteName()) ? 'active' : '' }}">
                        <a  href="{{ route('admin.additional-charges.view') }}"><i class="fa fa-angle-right"></i>Additional Charges</a></li> 
                    @endif                          
                </ul>
            </li>
            @if($feature['tax']==1)  
                <li class="{{ preg_match("/admin.tax/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.tax.view') }}"><i class="fa fa-angle-right"></i>Taxes</a></li>
            @endif

            @if($feature['stock'] == 1)
                <li class="{{ preg_match("/admin.stock/",Route::currentRouteName()) ? 'active' : '' }}"">
                    <a href="#"><i class="fa fa-angle-right"></i>Inventory</a>
                    <ul class="treeview-menu">
                        <li class="treeview {{ preg_match("/admin.stock.view/",Route::currentRouteName()) ? 'active' : '' }}">
                            <a href="{{ route('admin.stock.view') }}"><i class="fa fa-angle-right"></i>In Stock</a>
                        </li>
                        <li class="treeview {{ preg_match("/admin.stock.runningShort/",Route::currentRouteName()) ? 'active' : '' }}">
                            <a href="{{ route('admin.stock.runningShort') }}"><i class="fa fa-angle-right"></i>Running Short</a>
                        </li>
                        <li class="treeview {{ preg_match("/admin.stock.outOfStock/",Route::currentRouteName()) ? 'active' : '' }}">
                            <a href="{{ route('admin.stock.outOfStock') }}"><i class="fa fa-angle-right"></i>Out of Stock</a>
                        </li>
                    </ul>
                </li>
            @endif
            <li class="treeview {{ preg_match("/admin.campaign|admin.coupons|admin.loyalty|admin.advanceSetting|admin.referralProgram|admin.home.newsletter|admin.marketing.emails|admin.emailcampaign.viewemails|admin.emailcampaign.addemail|admin.emailcampaign.editemail|admin.marketing.emailTemplates/",Route::currentRouteName())? 'active' : ''}}">
                <a href="#">
                    <i class="fa fa-bullhorn"></i><span>Marketing</span>
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    @if($feature['coupon']==1)  
                    <li class="{{ preg_match("/admin.coupons/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.coupons.view') }}"><i class="fa fa-angle-right"></i>Coupons</a></li>
                    @endif             
                    @if($feature['loyalty']==1)  
                    <li class="{{ preg_match("/admin.loyalty/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.loyalty.view') }}"><i class="fa fa-angle-right"></i>Loyalty Program</a></li>                                     
                    @endif   
                </ul>
            </li>
            <li class="treeview {{ preg_match("/admin.report.productIndex|admin.report.ordersIndex/",Route::currentRouteName()) ? 'active' : '' }}">
                <a href="">
                    <i class="fa fa-file"></i><span>Reports</span>
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ preg_match("/admin.report.ordersIndex/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.report.ordersIndex') }}"><i class="fa fa-angle-right"></i>Orders Report</a></li> 
                </ul>

                <ul class="treeview-menu">
                    <li class="{{ preg_match("/admin.report.productIndex/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.report.productIndex') }}"><i class="fa fa-angle-right"></i>Top Selling Products</a></li>
                </ul>
            </li>
            <li class="treeview {{ preg_match("/admin.customers|admin.storecontacts/",Route::currentRouteName())? 'active' : ''}}">
                <a href="#">
                    <i class="fa fa-users"></i><span>Customers</span>
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    @if($feature['acl'] == 1)
                    <li class="{{ preg_match("/admin.customers/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.customers.view') }}"><i class="fa fa-angle-right"></i>All Customers</a></li> 
                    <li class="{{ preg_match("/admin.storecontacts/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.storecontacts.view') }}"><i class="fa fa-angle-right"></i>All Contacts</a></li> 
                    @endif
                </ul>
            </li>
            <li class="treeview {{ preg_match("/admin.roles.view|admin.systemusers.view/",Route::currentRouteName())? 'active' : ''}}">
                <a href="#">
                    <i class="fa fa-user-plus"></i><span>ACL</span>
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                   
                    <li class="{{ preg_match("/admin.systemusers/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.systemusers.view') }}"><i class="fa fa-angle-right"></i>System Users</a></li>

                    @if($feature['acl'] == 1)
                    <li class="{{ preg_match("/admin.roles/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.roles.view') }}"><i class="fa fa-angle-right"></i>Roles</a></li>

                    @endif
                    @if($settingStatus['purchase'] == 1)   
                    <li class="{{ preg_match("/admin.vendors/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.vendors.view') }}"><i class="fa fa-angle-right"></i>Vendors</a></li>
                    @endif

                </ul>
            </li>
            <li class="treeview {{ preg_match("/admin.storeSetting|admin.currency|admin.state|admin.language|admin.translation|admin.cities|admin.country|admin.generalSetting|admin.pincodes|admin.domains|admin.emailSetting|admin.paymentSetting|admin.returnPolicy|admin.courier/",Route::currentRouteName()) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-cogs"></i><span>Settings</span>
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ preg_match("/admin.storeSetting/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.storeSetting.view') }}"><i class="fa fa-angle-right"></i>Store Setting</a></li>
                    <li class="{{ preg_match("/admin.domains/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.domains.view') }}"><i class="fa fa-angle-right"></i>Domain</a></li>
                    <li class="{{ preg_match("/admin.bankDetails/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.bankDetails.view') }}"><i class="fa fa-angle-right"></i>Bank Details </a></li>
                </ul>                                                  
            </li>
            <li  class="{{ Route::currentRouteName() == 'admin.vendors.addMerchant' ? 'active' : '' }}">
                <a href="{{ route('admin.vendors.addMerchant') }}">
                    <i class="fa fa-user-plus"></i><span>Add Merchant</span>
                    <i></i>
                </a>
            </li>
            
        </ul>
    
    </section>

</aside>
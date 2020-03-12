<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <!-- <li class="{{ Route::currentRouteName() == 'admin.vendors.dashboard' ? 'active' : '' }}">
                <a href="{{ route('admin.vendors.dashboard') }}">
                    <i class="fa fa-bar-chart"></i><span>Dashboard</span> <i class=""></i>
                </a>
            </li> -->
            <li class="{{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}"> 
                    <img class="left-menu-img" src="{{ Config('constants.adminImgangePath') }}/icons/{{'home.svg'}}"> <span>Home</span>  
                </a>
            </li>
            <li class="treeview {{ preg_match("/admin.orders|admin.orders.OrderReturn|admin.miscellaneous.flags|admin.order_status|additional-charges/",Route::currentRouteName()) ? 'active' : '' }}">
                <a href=""> 
                    <img class="left-menu-img" src="{{ Config('constants.adminImgangePath') }}/icons/{{'noun_invoice.svg'}}"> <span>Sales</span> 
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ preg_match("/admin.orders.view|admin.orders.add|admin.orders.createOrder|admin.orders.edit|admin.orders.delete/",Route::currentRouteName()) ? 'active' : '' }}">
                        <a  href="{{ route('admin.orders.view') }}"> All Orders</a>
                    </li>
                    <li class="{{ preg_match("/admin.orders.OrderReturn|admin.orders.editreturn|admin.orders.UpdateReturnOrderStatus|admin.orders.ReturnOrderCal/",Route::currentRouteName()) ? 'active' : '' }}">
                        <a  href="{{ route('admin.orders.OrderReturn') }}"> Return Orders</a>
                    </li>
                    <li class="{{ preg_match("/admin.orders.cancelOrder|admin.orders.cancelOrderEdit|admin.orders.cancelOrderUpdate/",Route::currentRouteName()) ? 'active' : '' }}">
                        <a  href="{{ route('admin.orders.cancelOrder') }}"> Cancel Orders</a>
                    </li>
                    @if($feature['flag'] == 1)
                    <li class="{{ preg_match("/admin.miscellaneous.flags/",Route::currentRouteName()) ? 'active' : '' }} {{$storeViesion}}" >
                        <a  href="{{ route('admin.miscellaneous.flags') }}"> Flags</a></li>
                    @endif
                    <li class="{{ preg_match("/admin.order_status.view|admin.order_status.add|admin.order_status.edit|admin.order_status.save|admin.order_status.update|admin.order_status.delete|admin.order_status.changeStatus/",Route::currentRouteName()) ? 'active' : '' }}">
                        <a  href="{{ route('admin.order_status.view') }}"> Order Status</a></li>
                    @if($feature['additional-charge'] == 1)
                    <li class="{{ preg_match("/admin.additional-charges.view/",Route::currentRouteName()) ? 'active' : '' }}">
                        <a  href="{{ route('admin.additional-charges.view') }}"> Additional Charges</a></li>
                    @endif
                </ul>
            </li>
            <li class="treeview {{ preg_match("/admin.category|admin.reviews.view|admin.products|admin.attribute.set|admin.tax|admin.attributes|admin.sizechart|admin.raw-material|admin.stock/",Route::currentRouteName()) ? 'active' : '' }}">
                <a href="#">
                    <img class="left-menu-img" src="{{ Config('constants.adminImgangePath') }}/icons/{{'catalog.svg'}}"> <span>Catalog</span>
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ preg_match("/admin.products/",Route::currentRouteName()) ? 'active' : '' }}"><a href="{{ route('admin.products.view') }}"> All Products</a></li>
                    <li class="{{ preg_match("/admin.reviews/",Route::currentRouteName()) ? 'active' : '' }}"><a href="{{ route('admin.reviews.view') }}"> Customer Reviews</a></li>
                    <li class="{{ preg_match("/admin.category/",Route::currentRouteName()) ? 'active' : '' }}"><a href="{{ route('admin.category.view') }}"> Categories</a></li>

                    @if($settingStatus['products-with-variants'] == 1)

                    <li class="{{ preg_match("/admin.attribute.set/",Route::currentRouteName()) ? 'active' : '' }}"><a href="{{ route('admin.attribute.set.view') }}"> Variant Sets</a></li>
                    <li class="{{ preg_match("/admin.attributes/",Route::currentRouteName()) ? 'active' : '' }}"><a href="{{ route('admin.attributes.view') }}"> Attributes</a></li>
                    @endif

                    @if($feature['stock'] == 1)
                    <li class="{{ preg_match("/admin.stock/",Route::currentRouteName()) ? 'active' : '' }}"">
                        <a href="#"> 
                            Inventory
                            <i class="fa fa-angle-down pull-right subMenuArrow"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="treeview {{ preg_match("/admin.stock.view/",Route::currentRouteName()) ? 'active' : '' }}">
                                <a href="{{ route('admin.stock.view') }}"> In Stock</a>
                            </li>
                            <li class="treeview {{ preg_match("/admin.stock.runningShort/",Route::currentRouteName()) ? 'active' : '' }}">
                                <a href="{{ route('admin.stock.runningShort') }}"> Running Short</a>
                            </li>
                            <li class="treeview {{ preg_match("/admin.stock.outOfStock/",Route::currentRouteName()) ? 'active' : '' }}">
                                <a href="{{ route('admin.stock.outOfStock') }}"> Out of Stock</a>
                            </li>


                        </ul>
                    </li>
                    @endif
                    @if($feature['tax']==1)
                    <li class="{{ preg_match("/admin.tax/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.tax.view') }}"> Taxes</a></li>
                    @endif

                    @if($feature['row-material'] == 1)
                    <li class="{{ preg_match("/admin.raw-material/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.raw-material.view') }}"> Raw Material</a></li>
                    @endif

                </ul>
            </li>

            <li class="treeview {{ preg_match("/admin.offers|admin.campaign|admin.coupons|admin.loyalty|admin.advanceSetting|admin.referralProgram|admin.home.newsletter|admin.marketing.emails|admin.emailcampaign.viewemails|admin.emailcampaign.addemail|admin.emailcampaign.editemail|admin.marketing.emailTemplates/",Route::currentRouteName())? 'active' : ''}}">
                <a href="#">
                    <img class="left-menu-img" src="{{ Config('constants.adminImgangePath') }}/icons/{{'marketing.svg'}}"> <span>Marketing</span>
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ preg_match("/admin.offers/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.offers.view') }}"> Offers</a></li>    
                    @if($feature['coupon']==1)  
                    <li class="{{ preg_match("/admin.coupons/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.coupons.view') }}"> Coupons</a></li>
                    @endif             
                    @if($feature['loyalty']==1)  
                    <li class="{{ preg_match("/admin.loyalty/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.loyalty.view') }}"> Loyalty Program</a></li>                                     
                    @endif  
                </ul>
            </li>


            
            <li class="treeview {{ preg_match('/admin.vendors.allMerchant|admin.vendors.addMerchant|admin.storecontacts/',Route::currentRouteName())? 'active' : ''}}">
                <a href="#">
                     <img class="left-menu-img" src="{{ Config('constants.adminImgangePath') }}/icons/{{'merchants.svg'}}"> <span>Merchants</span>
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    @if($feature['acl'] == 1) 
                    <li class="{{ Route::currentRouteName() == 'admin.vendors.allMerchant' ? 'active' : '' }}"><a  href="{{ route('admin.vendors.allMerchant') }}"> All Merchants</a></li> 
                    <li  class="{{ Route::currentRouteName() == 'admin.vendors.addMerchant' ? 'active' : '' }}">
                        <a href="{{ route('admin.vendors.addMerchant') }}"> Add Merchant</a>
                    </li>
                    @endif
                </ul>
            </li> 

            <li class="treeview {{ preg_match("/admin.report.productIndex|admin.report.ordersIndex|admin.vendors.saleByOrder|admin.vendors.saleByProduct/",Route::currentRouteName()) ? 'active' : '' }}">
                <a href="">
                    <img class="left-menu-img" src="{{ Config('constants.adminImgangePath') }}/icons/{{'analytics.svg'}}"> <span>Reports</span>
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                <li class="treeview {{ preg_match("/admin.vendors.saleByOrder|admin.vendors.saleByProduct/",Route::currentRouteName()) ? 'active' : '' }}">
                <a href="">
                    Analytics</span>
                    <i class="fa fa-angle-down pull-right subMenuArrow"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ preg_match("/admin.vendors.saleByOrder/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.vendors.saleByOrder') }}"> By Orders</a></li>
                </ul>
                <ul class="treeview-menu">
                    <li class="{{ preg_match("/admin.vendors.saleByProduct/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.vendors.saleByProduct') }}"> By Products</a></li>
                </ul>
            </li>
                </ul>
                <ul class="treeview-menu">
                    <li class="{{ preg_match("/admin.report.ordersIndex/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.report.ordersIndex') }}"> Orders Report</a></li> 
                </ul>

                <ul class="treeview-menu">
                    <li class="{{ preg_match("/admin.report.productIndex/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.report.productIndex') }}"> Top Selling Products</a></li>
                </ul>
                
            </li>
            
            @if($feature['tax']==1)  
                <li class="{{ preg_match("/admin.tax/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.tax.view') }}"> </i>Taxes</a></li>
            @endif

            <!-- @if($feature['stock'] == 1)
                <li class="treeview {{ preg_match("/admin.stock/",Route::currentRouteName()) ? 'active' : '' }}">
                    <a href="#"> 
                        <i class="fa fa-line-chart"></i><span>Inventory</span>                        
                        <i class="fa fa-angle-down pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li class="treeview {{ preg_match("/admin.stock.view/",Route::currentRouteName()) ? 'active' : '' }}">
                            <a href="{{ route('admin.stock.view') }}"> In Stock</a>
                        </li>
                        <li class="treeview {{ preg_match("/admin.stock.runningShort/",Route::currentRouteName()) ? 'active' : '' }}">
                            <a href="{{ route('admin.stock.runningShort') }}"> Running Short</a>
                        </li>
                        <li class="treeview {{ preg_match("/admin.stock.outOfStock/",Route::currentRouteName()) ? 'active' : '' }}">
                            <a href="{{ route('admin.stock.outOfStock') }}"> Out of Stock</a>
                        </li>
                    </ul>
                </li>
            @endif -->
            <!-- <li class="treeview {{ preg_match("/admin.roles.view|admin.systemusers.view/",Route::currentRouteName())? 'active' : ''}}">
                <a href="#">
                    <i class="fa fa-user-plus"></i><span>ACL</span>
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                   
                    <li class="{{ preg_match("/admin.systemusers/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.systemusers.view') }}"> System Users</a></li>

                    @if($feature['acl'] == 1)
                    <li class="{{ preg_match("/admin.roles/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.roles.view') }}"> Roles</a></li>

                    @endif
                    @if($settingStatus['purchase'] == 1)   
                    <li class="{{ preg_match("/admin.vendors/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.vendors.view') }}"> Vendors</a></li>
                    @endif

                </ul>
            </li> -->
            <!--<li class="treeview {{ preg_match("/admin.storeSetting|admin.currency|admin.state|admin.language|admin.translation|admin.cities|admin.country|admin.generalSetting|admin.pincodes|admin.domains|admin.emailSetting|admin.paymentSetting|admin.returnPolicy|admin.courier/",Route::currentRouteName()) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-cogs"></i><span>Settings</span>
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ preg_match("/admin.storeSetting/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.storeSetting.view') }}"><i class="fa fa-angle-right"></i>Store Setting</a></li>
                    <li class="{{ preg_match("/admin.domains/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.domains.view') }}"><i class="fa fa-angle-right"></i>Domain</a></li>
                    <li class="{{ preg_match("/admin.bankDetails/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.bankDetails.view') }}"><i class="fa fa-angle-right"></i>Bank Details </a></li>
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
                </ul>                                                  
            </li>-->
            <!--<li  class="{{ Route::currentRouteName() == 'admin.vendors.addMerchant' ? 'active' : '' }}">
                <a href="{{ route('admin.vendors.addMerchant') }}">
                    <i class="fa fa-user-plus"></i><span>Add Merchant</span>
                    <i></i>
                </a>
            </li>-->
            
        </ul>
    
    </section>

</aside>
<?php
$productReturnStatus = App\Models\GeneralSetting::where('url_key', 'return-product')->where('status', 1)->get();
?>

<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
         

        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="{{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">
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
                   
                    <li class="{{ preg_match("/admin.order_status.view/",Route::currentRouteName()) ? 'active' : '' }}">
                        <a  href="{{ route('admin.order_status.view') }}"><i class="fa fa-angle-right"></i>Order Status</a></li>
                    @if($feature['additional-charge'] == 1)
                    <li class="{{ preg_match("/admin.additional-charges.view/",Route::currentRouteName()) ? 'active' : '' }}">
                        <a  href="{{ route('admin.additional-charges.view') }}"><i class="fa fa-angle-right"></i>Additional Charges</a></li> 
                    @endif                          
                </ul>
            </li>
             <li class="{{ Route::currentRouteName() == 'admin.products' ? 'active' : '' }}">
                <a href="{{ route('admin.products.view') }}">
                    <i class="fa fa-folder-open"></i><span>Product</span> <i class=""></i>
                </a>
            </li>
             <li class="{{ Route::currentRouteName() == 'admin.category' ? 'active' : '' }}">
                <a href="{{ route('admin.category.view') }}">
                    <i class="fa fa-industry"></i><span>Category</span> <i class=""></i>
                </a>
            </li>
             
             <li class="{{ Route::currentRouteName() == 'admin.pincodes' ? 'active' : '' }}">
                <a href="{{ route('admin.pincodes.view') }}">
                    <i class="fa fa-folder-open"></i><span>Pincodes</span> <i class=""></i>
                </a>
            </li>
          
          
 
<!--            <li class="treeview {{ preg_match("/admin.staticpages|admin.testimonial|admin.contact|admin.sliders|admin.dynamic-layout|admin.masterList|admin.socialmedialink|admin.templateSetting/",Route::currentRouteName())? 'active' : ''}}">
                <a href="#">
                    <i class="fa fa-pencil-square-o"></i><span>Content</span>
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">

                    <li class="{{ preg_match("/admin.staticpages/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.staticpages.view') }}"><i class="fa fa-angle-right"></i>Online Pages</a></li>

                    <li class="{{ preg_match("/admin.socialmedialink/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.socialmedialink.view') }}"><i class="fa fa-angle-right"></i>Social Media Links</a></li>
                     @if($feature['testimonial'] == 1) 
                    <li class="{{ preg_match("/admin.testimonial/",Route::currentRouteName()) ? 'active' : '' }} {{$storeViesion}}"><a  href="{{ route('admin.testimonial.view') }}"><i class="fa fa-angle-right"></i>Testimonials</a></li> 
                    @endif
                   
                  
                 
                </ul>
            </li>    -->


<!--            <li class="treeview {{ preg_match("/admin.storeSetting|admin.currency|admin.state|admin.language|admin.translation|admin.cities|admin.country|admin.generalSetting|admin.pincodes|admin.domains|admin.emailSetting|admin.paymentSetting|admin.returnPolicy|admin.courier/",Route::currentRouteName()) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-cogs"></i><span>Settings</span>
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                                        <li class="{{ preg_match("/admin.storeSetting/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.storeSetting.view') }}"><i class="fa fa-angle-right"></i>Store Setting</a></li>
                                        
                    <li class="{{ preg_match("/admin.domains/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.domains.view') }}"><i class="fa fa-angle-right"></i>Domain</a></li>
                    



                    <li class="{{ preg_match("/admin.generalSetting/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.generalSetting.view') }}"><i class="fa fa-angle-right"></i>Feature Activation</a></li>
                                        <li class="{{ preg_match("/admin.paymentSetting/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.paymentSetting.view') }}"><i class="fa fa-angle-right"></i>Payment Gateway</a></li>                     
                @if($feature['courier-services'] == 1) 
                    <li class="{{ preg_match("/admin.courier/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.courier.view') }}"><i class="fa fa-angle-right"></i>Courier Services</a></li>
                    @endif
                       <li class="{{ preg_match("/admin.bankDetails/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.bankDetails.view') }}"><i class="fa fa-angle-right"></i>Bank Details </a></li>
                      @if($feature['email-facility'] == 1) 
                    <li class="{{ preg_match("/admin.emailSetting/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.emailSetting.view') }}"><i class="fa fa-angle-right"></i>Email Gateway</a></li>
                    @endif
              
         
                    @if($feature['pincode']==1)
                    <li class="{{ preg_match("/admin.pincodes/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.pincodes.view') }}"><i class="fa fa-angle-right"></i>Pincodes</a></li>
                    @endif
     

                  
            </li>
            
        </ul>
        </li>-->
        
        </ul>
    </section>
</aside>
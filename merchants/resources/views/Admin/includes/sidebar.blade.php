<?php
$productReturnStatus = App\Models\GeneralSetting::where('url_key', 'return-product')->where('status', 1)->get();
?> 

<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <!--            <div class="pull-left image">
                            <img src="{{ asset('public/Admin/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
                        </div>
                        <div class="pull-left info">
                            <p>{{ @App\Models\User::find(Session::get('loggedinUserId'))->first_name }}</p>
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>-->

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
            <?php
            $settingsdata = App\Library\Helper::getSettings();
            ?>
            @if(array_key_exists('industry_id',$settingsdata))
            
            @if($settingsdata['industry_id'] == 5)
            <li class="treeview {{ preg_match("/admin.table|admin.restaurantlayout/",Route::currentRouteName()) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-cutlery"></i><span>Tables</span>
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ preg_match("/admin.tables/",Route::currentRouteName()) ? 'active' : '' }}"><a href="{{ route('admin.tables.view') }}"><i class="fa fa-angle-right"></i> Manage Tables </a></li>
                    <li class="{{ preg_match("/admin.restaurantlayout/",Route::currentRouteName()) ? 'active' : '' }}"><a href="{{ route('admin.restaurantlayout.view') }}"><i class="fa fa-angle-right"></i>Restaurant Layout</a></li>
                    <li class="{{ preg_match("/admin.tableorder/",Route::currentRouteName()) ? 'active' : '' }}"><a href="{{ route('admin.tableorder.view') }}"><i class="fa fa-angle-right"></i>Manage Orders</a></li>

                </ul>
            </li>
            
           

           @endif
           @else 
                   <li class="treeview {{ preg_match("/admin.table|admin.restaurantlayout/",Route::currentRouteName()) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-cutlery"></i><span>Tables</span>
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ preg_match("/admin.tables/",Route::currentRouteName()) ? 'active' : '' }}"><a href="{{ route('admin.tables.view') }}"><i class="fa fa-angle-right"></i> Manage Tables </a></li>
                    <li class="{{ preg_match("/admin.restaurantlayout/",Route::currentRouteName()) ? 'active' : '' }}"><a href="{{ route('admin.restaurantlayout.view') }}"><i class="fa fa-angle-right"></i>Restaurant Layout</a></li>
                    <li class="{{ preg_match("/admin.tableorder/",Route::currentRouteName()) ? 'active' : '' }}"><a href="{{ route('admin.tableorder.view') }}"><i class="fa fa-angle-right"></i>Manage Orders</a></li>

                </ul>
            </li>
           
          
           @endif
            <li class="treeview {{ preg_match("/admin.category|admin.products|admin.attribute.set|admin.tax|admin.attributes|admin.sizechart|admin.raw-material|admin.stock/",Route::currentRouteName()) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-folder-open"></i><span>Products</span>
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ preg_match("/admin.products/",Route::currentRouteName()) ? 'active' : '' }}"><a href="{{ route('admin.products.view') }}"><i class="fa fa-angle-right"></i>All Products</a></li>
                    <li class="{{ preg_match("/admin.reviews/",Route::currentRouteName()) ? 'active' : '' }}"><a href="{{ route('admin.reviews.view') }}"><i class="fa fa-angle-right"></i>Customer Reviews</a></li>
                    <li class="{{ preg_match("/admin.category/",Route::currentRouteName()) ? 'active' : '' }}"><a href="{{ route('admin.category.view') }}"><i class="fa fa-angle-right"></i>Categories</a></li>

                    @if($settingStatus['30'] == 1)

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
            <li class="treeview {{ preg_match("/admin.coupons|admin.loyalty|admin.advanceSetting|admin.referralProgram|admin.home.newsletter|admin.marketing.emails|admin.marketing.emailTemplates/",Route::currentRouteName())? 'active' : ''}}">
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


                    <?php if (array_key_exists('referral', $feature)) { ?>
                        @if($feature['referral']==1) 
                        <li class="{{ preg_match("/admin.referralProgram/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.referralProgram.view') }}"><i class="fa fa-angle-right"></i>Referral Program</a></li>                
                        @endif 
                        @if($feature['notification']==1) 
                        <li class="{{ preg_match("/admin.home/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.home.newsletter') }}"><i class="fa fa-angle-right"></i>NewsLetters</a></li> 
                        @endif 
                        <!-- <li class="{{ preg_match("/admin.smsSubscription/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.smsSubscription.view') }}"><i class="fa fa-angle-right"></i>SMS</a></li> -->
                    <?php } ?>

                    {{-- <li class="{{ preg_match("/admin.newsletter/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.smsSubscription.view') }}"><i class="fa fa-angle-right"></i>NewsLetter</a></li> --}}
                        
<!--                             <li class="treeview {{ preg_match("/admin.marketing.emails|admin.marketing.emailTemplates/",Route::currentRouteName())? 'active' : ''}}">
                <a href="#">
                    <i class="fa fa-angle-right"></i><span>Bulk Email</span>
                   
                </a>
                <ul class="treeview-menu">
                    <li class="{{ preg_match("/admin.marketing.emails/",Route::currentRouteName()) ? 'active' : '' }}"><a href="{{ route('admin.marketing.emails') }}"><i class="fa fa-angle-right"></i>Emails & Groups</a></li>
                    <li class="{{ preg_match("/admin.marketing.emailTemplates/",Route::currentRouteName()) ? 'active' : '' }}"><a href="{{ route('admin.marketing.emailTemplates') }}"><i class="fa fa-angle-right"></i>Templates</a></li>
                    <li class="{{ preg_match("/admin.marketing.emailTemplates/",Route::currentRouteName()) ? 'active' : '' }}"><a href="{{ route('admin.tables.view') }}"><i class="fa fa-angle-right"></i>Analytics</a></li>
                </ul>
            </li>-->
                </ul>
                
                
            </li>
       



            <li class="treeview {{ preg_match("/admin.sales.byorder|admin.sales.byproduct|admin.sales.bycategory|admin.sales.byattribute|admin.sales.bycustomer/",Route::currentRouteName()) ? 'active' : '' }}">
                <a href="">
                    <i class="fa fa-line-chart"></i><span>Analytics</span>
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ preg_match("/admin.sales.byorder/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.sales.byorder') }}"><i class="fa fa-angle-right"></i>By Orders</a></li>
                </ul>
                <ul class="treeview-menu">
                    <li class="{{ preg_match("/admin.sales.byproduct/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.sales.byproduct') }}"><i class="fa fa-angle-right"></i>By Products</a></li>
                </ul>
                <ul class="treeview-menu">
                    <li class="{{ preg_match("/admin.sales.bycustomer/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.sales.bycustomer') }}"><i class="fa fa-angle-right"></i>By Customers</a></li>
                </ul>
                <ul class="treeview-menu">
                    <li class="{{ preg_match("/admin.sales.bycategory/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.sales.bycategory') }}"><i class="fa fa-angle-right"></i>By Category</a></li>
                </ul>
                <ul class="treeview-menu">
                    <li class="{{ preg_match("/admin.sales.byattribute/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.sales.byattribute') }}"><i class="fa fa-angle-right"></i>By Attributes</a></li>
                </ul>

            </li>

            <li class="treeview {{ preg_match("/admin.roles.view|admin.systemusers.view|admin.customers.view|admin.vendors.view/",Route::currentRouteName())? 'active' : ''}}">
                <a href="#">
                    <i class="fa fa-users"></i><span>Users</span>
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    @if($feature['acl'] == 1)
                    <li class="{{ preg_match("/admin.customers/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.customers.view') }}"><i class="fa fa-angle-right"></i>Customers</a></li> 
                    @endif
                    <li class="{{ preg_match("/admin.systemusers/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.systemusers.view') }}"><i class="fa fa-angle-right"></i>System Users</a></li>

                    @if($feature['acl'] == 1)
                    <li class="{{ preg_match("/admin.roles/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.roles.view') }}"><i class="fa fa-angle-right"></i>Roles</a></li>

                    @endif
                    @if($settingStatus['25'] == 1)   
<!--                    <li class="{{ preg_match("/admin.vendors/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.vendors.view') }}"><i class="fa fa-angle-right"></i>Vendors</a></li>-->
                    @endif

                </ul>
            </li>      



            <li class="treeview {{ preg_match("/admin.staticpages|admin.testimonial|admin.contact|admin.sliders|admin.dynamic-layout|admin.masterList|admin.socialmedialink|admin.templateSetting/",Route::currentRouteName())? 'active' : ''}}">
                <a href="#">
                    <i class="fa fa-pencil-square-o"></i><span>Content</span>
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">

    @foreach($dynamicayout as $layout)
                    <li class="{{ preg_match("/admin.dynamic-layout.view/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.dynamic-layout.view',['slug'=>$layout->url_key]) }}"><i class="fa fa-angle-right"></i>{{$layout->name}}</a></li>
                    @endforeach

                    <li class="{{ preg_match("/admin.staticpages/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.staticpages.view') }}"><i class="fa fa-angle-right"></i>Online Pages</a></li>



                    <li class="{{ preg_match("/admin.socialmedialink/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.socialmedialink.view') }}"><i class="fa fa-angle-right"></i>Social Media Links</a></li>
                     @if($feature['testimonial'] == 1) 
                    <li class="{{ preg_match("/admin.testimonial/",Route::currentRouteName()) ? 'active' : '' }} {{$storeViesion}}"><a  href="{{ route('admin.testimonial.view') }}"><i class="fa fa-angle-right"></i>Testimonials</a></li> 
                    @endif
                    @if($feature['email-facility'] == 1) 
                    <li class="{{ preg_match("/admin.templateSetting/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.templateSetting.view') }}"><i class="fa fa-angle-right"></i>Email Templates</a></li> 
                    @endif 
                  
                 
                </ul>
            </li>    

       

            <!--            <li class="treeview {{ preg_match("/admin.apicat/",Route::currentRouteName()) ? 'active' : '' }}">
                            <a href="{{ route('admin.apicat.view') }}">
                                <i class="fa fa-th-list"></i>
                                <span>API Category</span>
                            </a>
                        </li>-->

            <!--            <li class="treeview {{ preg_match("/admin.apicat|admin.apiprod/",Route::currentRouteName())? 'active' : ''}}">
                            <a href="#">
                                <i class="fa fa-rocket"></i>
                                <span>API</span>
                                <i class="fa fa-angle-down pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li class="{{ preg_match("/admin.apicat/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.apicat.view') }}"><i class="fa fa-user-secret"></i>Category</a></li>
                                <li class="{{ preg_match("/admin.apiprod/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.apiprod.view') }}"><i class="fa fa-user"></i>Product</a></li>
                            </ul>
                        </li>-->




         

            <li class="treeview {{ preg_match("/admin.storeSetting|admin.currency|admin.state|admin.language|admin.translation|admin.cities|admin.country|admin.generalSetting|admin.pincodes|admin.domains|admin.emailSetting|admin.paymentSetting|admin.returnPolicy|admin.courier/",Route::currentRouteName()) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-cogs"></i><span>Settings</span>
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                                        <li class="{{ preg_match("/admin.storeSetting/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.storeSetting.view') }}"><i class="fa fa-angle-right"></i>Store Setting</a></li>
                                        
                    <li class="{{ preg_match("/admin.domains/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.domains.view') }}"><i class="fa fa-angle-right"></i>Domain</a></li>
                    



                    <li class="{{ preg_match("/admin.generalSetting/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.generalSetting.view') }}"><i class="fa fa-angle-right"></i>Feature Activation</a></li>
                                        <li class="{{ preg_match("/admin.paymentSetting/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.paymentSetting.view') }}"><i class="fa fa-angle-right"></i>Payment Gateway</a></li>                     
<!--                @if($feature['courier-services'] == 1) 
                    <li class="{{ preg_match("/admin.courier/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.courier.view') }}"><i class="fa fa-angle-right"></i>Courier Services</a></li>
                    @endif-->
                       <li class="{{ preg_match("/admin.bankDetails/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.bankDetails.view') }}"><i class="fa fa-angle-right"></i>Bank Details </a></li>
                      @if($feature['email-facility'] == 1) 
                    <li class="{{ preg_match("/admin.emailSetting/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.emailSetting.view') }}"><i class="fa fa-angle-right"></i>Email Gateway</a></li>
                    @endif
                    @if(count($productReturnStatus)>0)
                    <li class="{{ preg_match("/admin.returnPolicy/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.returnPolicy.view') }}"><i class="fa fa-angle-right"></i>Return Policy</a></li>
                    @endif
                    <!--                    <li class="{{ preg_match("/admin.slider/",Route::currentRouteName()) ? 'active' : '' }}"">
                                            <a href="#"><i class="fa fa-sliders"></i>Slider</a>
                                            <ul class="treeview-menu">
                                                <li class="treeview {{ preg_match("/admin.slider.masterList/",Route::currentRouteName()) ? 'active' : '' }}">
                                                    <a href="{{ route('admin.slider.masterList') }}"><i class="f0a fa-sliders"></i>Master List</a>
                                                </li>
                                                <li class="treeview {{ preg_match("/admin.sliders.view/",Route::currentRouteName()) ? 'active' : '' }}">
                                                    <a href="{{ route('admin.sliders.view') }}"><i class="fa fa-sliders"></i>Slider</a>
                                                </li>
                                            </ul>
                                        </li>-->
                    <li class="{{ preg_match("/admin.country/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.country.view') }}"><i class="fa fa-angle-right"></i>Countries</a></li>
<!--                    <li class="{{ preg_match("/admin.state/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.state.view') }}"><i class="fa fa-angle-right"></i>States</a></li>-->
                    <!-- <li class="{{ preg_match("/admin.cities/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.cities.view') }}"><i class="fa fa-angle-right"></i>Cities</a></li> -->

                  



                    @if($feature['pincode']==1)
                    <li class="{{ preg_match("/admin.pincodes/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.pincodes.view') }}"><i class="fa fa-angle-right"></i>Pincodes</a></li>
                    @endif
                    <!-- <li class="{{ preg_match("/admin.currency/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.currency.view') }}"><i class="fa fa-angle-right"></i>Currency Conversion</a></li>  -->
                    @if($feature['multi-language'] == 1)        
<!--                    <li class="{{ preg_match("/admin.language/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.language.view') }}"><i class="fa fa-angle-right"></i>Languages</a></li>-->
<!--                    <li class="{{ preg_match("/admin.translation/",Route::currentRouteName()) ? 'active' : '' }}"><a  href="{{ route('admin.translation.view') }}"><i class="fa fa-angle-right"></i>Languages Translations</a></li> -->
                    @endif

                  
            </li>
            
        </ul>
        </li>
           <li class="{{ Route::currentRouteName() == 'admin.home.view' ? 'active' : '' }}">
                <a href="{{ route('admin.home.view') }}">
                    <i class="fa fa-question-circle"></i><span>Help</span> <i class=""></i>
                </a>
            </li>
        </ul>
    </section>
</aside>
@extends('Frontend.layouts.default')
@section('content')
<section id="page-title" class="page-title-parallax page-title-center feature-bg-title" style="background: url('{{ asset(Config('constants.frontendPublicEstorifiImgPath').'/features-bg.jpg') }}') 0px; padding: 103px 0;">
    <div class="container clearfix">
        <h2 class="white-text bottommargin-xs" data-animate="fadeInUp">Get all the features that you really need to sell online</h2>
        <span class="white-text" data-animate="fadeInUp" data-delay="300">The complete ecommerce ecosystem designed to make a difference</span>
    </div>
</section><!-- #page-title end -->
<section id="content">
    <div class="content-wrap">
        <div class="container clearfix">
            <div class="feature-row clearfix">
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="">
                        <h2 class="nobottommargin">Store Creation</h2>
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Easy to Create</h4>
                        <p>Create your own online store in less than 5 minutes. No technical skills required.</p>
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Facebook/Mobile Login</h4>
                        <p>No need to remember a new password. eStorifi allows you to create your online store with Facebook authentication. You can also create your online store by validating your mobile number.</p>
                    </div>
                </div>
                <div class="col_one_fourth col_last marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Free Primary Domain</h4>
                        <p>Get a free primary domain with your StoreName being part of it.</p>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15 hidden-xs">
                    <div class="">

                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Starter/Advanced Version</h4>
                        <p>Get the freedom of choosing either simple (Starter) or complex (Advanced) version of the online store.</p>
                    </div>
                </div>
                 <div class="clear"></div>
                <div class="line-new"></div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="">
                        <h2 class="nobottommargin">One Account. All of eStorifi</h2>
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Free Account</h4>
                        <p>All the customers of the stores created by the merchants on eStorifi get an account which is free forever.</p>
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Quick Registration</h4>
                        <p>Customers can register themselves just by giving few basic information. It’s easy and quick.</p>
                    </div>
                </div>
                <div class="col_one_fourth col_last marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>One account for all eStorifi </h4>
                        <p> Customers can login on any store created on eStorifi with their eStorifi  Account. No need to remember new login passwords for different ecommerce website.</p>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="line-new"></div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="">
                        <h2 class="nobottommargin">Themes &amp; Designs</h2>
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>50+ Theme Designs</h4>
                        <p>Choose from designs that have been developed for various industry needs.</p>
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Responsive Templates</h4>
                        <p>Present a professional online store to your customer everywhere and anywhere through desktop, laptop, mobiles, tablets etc.</p>
                    </div>
                </div>
                <div class="col_one_fourth col_last marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Customization &amp; Design</h4>
                        <p>Unlock your creative potential and design your online store the way you want it. Take complete control over your store, make real-time changes to logo, slider images etc.</p>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15 hidden-xs">
                    <div class="">

                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Customized Store Admin</h4>
                        <p>Give your store admin the flavour of your brand color by changing the color theme.</p>
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Switch Themes</h4>
                        <p>Switch entire theme of your store anytime. Its free and easy.</p>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="line-new"></div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="">
                        <h2 class="nobottommargin">Inventory Management</h2>
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>In Stock</h4>
                        <p>Maintain track of all your In Stock products. Get option to update the stock real-time.</p>
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Running Short</h4>
                        <p>Get notifications for all the products running short.</p>
                    </div>
                </div>
                <div class="col_one_fourth col_last marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Out of Stock</h4>
                        <p>Maintain track of all your Out of Stock products. Get real-time notification and option to update the stock.</p>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="line-new"></div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="">
                        <h2 class="nobottommargin">Store Management</h2>
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Online Store</h4>
                        <p>Manage your store through frontend website. Login with your credentials and get the priveledge to design your store.</p>
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Online Store Admin</h4>
                        <p>Manage your store through the admin panel which has all the exaustive ready to use features.</p>
                    </div>
                </div>
                <div class="col_one_fourth col_last marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Mobile App</h4>
                        <p>Manage your store anywhere and anytime with eStorifi Merchant App. It is simple, efficient and easy to use.</p>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="line-new"></div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="">
                        <h2 class="nobottommargin">Payment Integration</h2>
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Integrated Payment Gateway</h4>
                        <p>Customers can pay by Credit Cards, Debit Cards, Net Banking etc. through the integrated payment gateway partner.</p>
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Reputed Payment Partner</h4>
                        <p>Reputed partner with leading payment solutions to help your customers to ensure verified and secure transactions.</p>
                    </div>
                </div>
                <div class="col_one_fourth col_last marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Safe &amp; Secure Payment</h4>
                        <p>A secure online store with SSL certification to encourange customers for a worry free shopping.</p>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15 hidden-xs">
                    <div class="">

                    </div>
                </div>
                <div class="col_one_fourth col_last marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Cash On Delivery (COD)</h4>
                        <p>Given your customers to pay cash at the time of delivery at their doorsteps with additional COD charges, if required.</p>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="line-new"></div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="">
                        <h2 class="nobottommargin">Shipping Integration</h2>
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Integrated Shipping</h4>
                        <p>Get an integrated delivery solution with your store to secure the sales through integrating shipping partner.</p>
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Easy &amp; Fast</h4>
                        <p>Engaged with multiple shipping and logistics partners for easy and fast delivery of orders to the customers.</p>
                    </div>
                </div>
                <div class="col_one_fourth col_last marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Preferential rates</h4>
                        <p>Enjoy pre-negotiated shipping rates with the logistics partners and get better savings each time.</p>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="line-new"></div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="">
                        <h2 class="nobottommargin">Technology</h2>
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Cloud Hosting</h4>
                        <p>No more hassle and worry about server &amp; hosting, we take care of everything with 100% uptime. We host your online store on our secured cloud server. </p>
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>SSL</h4>
                        <p>Your online store is safe &amp; secured from the time you create it. SSL (Secure Socket Layer) is one of the most important components of online business.</p>
                    </div>
                </div>
                <div class="col_one_fourth col_last marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>SEO Friendly</h4>
                        <p>A store that has SEO features to write your desired search description and meta tags without needing any coding knowledge to get traffic on your website.</p>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="line-new"></div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="">
                        <h2 class="nobottommargin">Data Insights &amp; Analystics</h2>
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Dashboard</h4>
                        <p>Give a quick access to all the relevant information such as top selling products, latest orders, new customers, sales etc. for you to make business decisions.</p>
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Analystics</h4>
                        <p>Get a detailed analystics from the platform for orders, products, customers </p>
                    </div>
                </div>
                <div class="col_one_fourth col_last marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Export Analystics</h4>
                        <p>Allows to export the analysitcs in excel for easy sharing with your management and team</p>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="line-new"></div>
               <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="">
                        <h2 class="nobottommargin">Mobile App</h2>
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Create Store</h4>
                        <p>Create your own online store in less than 5 minutes from eStorifi Merchant App. No technical skills required.</p>
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Free Mobile App</h4>
                        <p>The mobile app is Free and available to download from the app store.</p>
                    </div>
                </div>
                <div class="col_one_fourth col_last marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Manage Store</h4>
                        <p>Manage your entire online business on the go on eStorifi Merchant App.</p>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15 hidden-xs">
                    <div class="">

                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Order Placement</h4>
                        <p>Apart from receiving orders online, place your offline/walkin orders from the app to get a perfect audit report. Manage both onine and offline orders from the app.</p>
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Inventory Management</h4>
                        <p>Manages your inventory easily from mobile. Update stock on your finger tips.</p>
                    </div>
                </div>

                <div class="col_one_fourth col_last marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Thermal Printer</h4>
                        <p>Print invoice on the spot on the intergrated thermal printer which can be connected via bluetooth to any smartphone.</p>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15 hidden-xs">
                    <div class="">
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Save customers as contact</h4>
                        <p>Save customers as contact on your smartphone to communicate with them easily or send them promotional offers via WhatApp, Vider, SMS etc.</p>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="line-new"></div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="">
                        <h2 class="nobottommargin">Marketing</h2>
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Coupons</h4>
                        <p>Create discount coupon codes for the customers to encourage more sales. Customer specific coupons can be created too.</p>
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Loyalty Program</h4>
                        <p>Give loyalty points to your customer depending on the percentage of purchase they make. These points can be redeemed when they shop next time. More they shop more discounts they get.</p>
                    </div>
                </div>
                <div class="col_one_fourth col_last marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Referral Program</h4>
                        <p>Referral marketing is a method of promoting products or services to the new customers through referrals, usually word of mouth. This benefits both referral and referee.</p>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15 hidden-xs">
                    <div class="">
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Social Media Share</h4>
                        <p>Get social media sharing option on product detail page of your online store which helps customer to share your products on social platform giving more exposure to your products.</p>
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Email Marketing</h4>
                        <p>Broadcast and promote your online store offers and products through bulk emails feature.</p>
                    </div>
                </div>
                <div class="col_one_fourth col_last marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Newsletters</h4>
                        <p>Allow users to subscribe and get the benefits of getting your newsletters by subscribing</p>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="line-new"></div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="">
                        <h2 class="nobottommargin">Taxes</h2>
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Custom Taxes</h4>
                        <p>Create and charge the appropriate taxes on the goods and services you sell online so that your online business is tax compliant at all times.</p>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="line-new"></div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="">
                        <h2 class="nobottommargin">Orders</h2>
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Cancel or Return Order</h4>
                        <p>An online store which give facility to customers to cancel or return their orders. Store owner has control to activate or deactivate this feature.</p>
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Custom Order Status &amp; Additional Charges</h4>
                        <p>Define your own Order status, also allows to create any additional charges for the order</p>
                    </div>
                </div>
                <div class="col_one_fourth col_last marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Order Notification via Email</h4>
                        <p>Receive automated order notifciation via email to ensure prompt services</p>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15 hidden-xs">
                    <div class="">
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Flags</h4>
                        <p>Flagging is a unique feature which allows you to assigns flags to the orders. Flags can be of type important, pending, completed etc. You can define your own flag with a color.</p>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="line-new"></div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="">
                        <h2 class="nobottommargin">Table Management</h2>
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Manage Table</h4>
                        <p>Create &amp; manage number of tables you have in your restaurant. Create & manage orders against these tables.</p>
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Restaurant Layout</h4>
                        <p>Create your restaurant layout. For eg. Square, rectangle or circle tables. Manage occupied v/s free tables.</p>
                    </div>
                </div>
                <div class="col_one_fourth col_last marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Manage Restaurant Orders</h4>
                        <p>Place take away orders from the system to get a perfect audit report.</p>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="line-new"></div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="">
                        <h2 class="nobottommargin">Products</h2>
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Unlimited Product Listings</h4>
                        <p>List as many products as you wish to create a comprehensive catalog on your online store. There are no restrictions and no additional charges.</p>
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Categories &amp; Sub-Categories</h4>
                        <p>Organize your products by assigning them under Categories and sub categories for easy categorization.</p>
                    </div>
                </div>
                <div class="col_one_fourth col_last marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Multiple Image Upload</h4>
                        <p>You can showcase products in your catalog optimally to customers by having up to 4 product images per listing.</p>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15 hidden-xs">
                    <div class="">

                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Bulk Upload</h4>
                        <p>Add products via bulk uploads using simple CSV file format for fast addition of products.</p>
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Products with Variants</h4>
                        <p>Within product listing, indicate the different product options available such as variations in color, size, weight, etc., so you can sell better to your customers.</p>
                    </div>
                </div>
                <div class="col_one_fourth col_last marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>SEO</h4>
                        <p>Write your desired search description, meta tags etc. without needing any coding knowledge to get traffic on your website.</p>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="line-new"></div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="">
                        <h2 class="nobottommargin">Users</h2>
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Customers</h4>
                        <p>Get access to all your customer information like name, email id, mobile number etc. on your finger tips.</p>
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>System Users</h4>
                        <p>Create &amp; manage system users like admin, manager etc. for easy and secured use of the system.</p>
                    </div>
                </div>
                <div class="col_one_fourth col_last marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Roles</h4>
                        <p>Assigns specific or restricted roles to the system users. You decide what should be seen to other system users and what not.</p>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="line-new"></div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="">
                        <h2 class="nobottommargin">Content Management</h2>
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>About Store</h4>
                        <p>Share about the store which helps your customers know a little more about you.</p>
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Contact Details</h4>
                        <p>Display your contact details to help customers to reach to you.</p>
                    </div>
                </div>
                <div class="col_one_fourth col_last marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Social Media Links</h4>
                        <p>Share your social media links with your customers for better sales.</p>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15 hidden-xs">
                    <div class="">
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Email Templates</h4>
                        <p>Edit all the email templates which customer receives on order success, registration, forgot password etc.</p>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="line-new"></div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="">
                        <h2 class="nobottommargin">Domains</h2>
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>GoDaddy Domain</h4>
                        <p>Connect your eStorifi store with GoDaddy domain. Easy to understand steps are given to assit you.</p>
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Other Domain</h4>
                        <p>Connect your eStorifi store with any other domain provider. Easy to understand steps are given to assit you.</p>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="line-new"></div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="">
                        <h2 class="nobottommargin">Others</h2>
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Multi-Currency Store</h4>
                        <p>Create your store in the currency you wish to sell in.</p>
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Feature Activation</h4>
                        <p>Feature activation made easy by a simple Yes/No toggle. Mark features yes that you wish to offer in your store.</p>
                    </div>
                </div>
                <div class="col_one_fourth col_last marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Guest Checkout</h4>
                        <p>Gives flexibility to the customers to place order without registering on your store.</p>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="line-new"></div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="">
                        <h2 class="nobottommargin">Support/Help</h2>
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>24x7 Support</h4>
                        <p>Our experts are always ready to help you. Feel free to reach out to us anytime of the day.</p>
                    </div>
                </div>
                <div class="col_one_fourth marginBottom15 mobMarginbottom15">
                    <div class="feautreBox">
                        <h4>Live Chat</h4>
                        <p>Get Live Chat support to discuss your doubts and concerns to get instant solutions.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop
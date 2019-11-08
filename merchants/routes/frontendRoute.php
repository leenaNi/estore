<?php

Route::group(['middleware' => ['web', 'SetTheme'], 'namespace' => 'Auth'], function() {
    Route::get('login/{provider?}/{from?}', ['as' => 'login', 'uses' => 'AuthController@login']);
});

Route::group(['middleware' => ['web', 'SetTheme'], 'namespace' => 'Frontend'], function() {
    //Route::get('statusofnotification', ['as' => 'statusofnotification', 'uses' => 'HomeController@statusofnotification']);
    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
    //Set Cuurency 
    Route::any('/sc', ['as' => 'setCurrency', 'uses' => 'HomeController@setCurrency']);
    Route::get('notification', ["as" => "notification", "uses" => "HomeController@notify"]);
    Route::any('get-login', ["as" => "get-login", "uses" => "HomeController@getLogin"]);
     Route::any('get-log', ["as" => "get-log", "uses" => "HomeController@getLog"]);
    Route::any('check-pincode-home', ["as" => "checkPincodeHome", "uses" => "HomeController@checkPincode"]);
    Route::any('/subscription-mail', ['as' => 'subscriptionMail', 'uses' => 'HomeController@subscription']);
    Route::get('checkemail', ["as" => "checkemail", "uses" => "HomeController@checkemail"]);
    Route::any('saveProduct', ["as" => "saveProduct", "uses" => "HomeController@saveProduct"]);
    Route::any('/change-country', array('as' => 'changeCountry', 'uses' => 'HomeController@change_country'));
    Route::post('/check-user', ['as' => 'checkUser', 'uses' => 'LoginController@checkUser']);
    Route::post('/check-existing-user', ['as' => 'checkExistingUser', 'uses' => 'LoginController@checkExistingUser']);
    Route::post('/check-existing-mobile', ['as' => 'checkExistingMobileNo', 'uses' => 'LoginController@checkExistingMobileNo']);
    Route::get('/user-register', ['as' => 'userRegister', 'uses' => 'LoginController@userRegister']);
    Route::post('/save-register', ['as' => 'saveRegister', 'uses' => 'LoginController@saveRegister']);
    Route::post('/check-fb-user', ['as' => 'checkFbUser', 'uses' => 'LoginController@checkFbUser']);
    Route::get('/dashboard', ['as' => 'dashboard', 'uses' => 'LoginController@dashboard']);
    Route::get('/login-user', ['as' => 'loginUser', 'uses' => 'LoginController@login']);
    Route::get('/logout', ['as' => 'logout', 'uses' => 'LoginController@logout']);
    Route::any('/about-us', ['as' => 'about-us', "uses" => 'HomeController@aboutUs']);
    Route::any('/contact-us', ['as' => 'contact-us', "uses" => 'HomeController@contactUs']);
    Route::post('/contact-sent', ['as' => 'contact-sent', "uses" => 'HomeController@contactSent']);
    Route::any('/terms-conditions', ['as' => 'terms-conditions', "uses" => 'HomeController@termsConditions']);
    Route::any('/privacy-policy', ['as' => 'privacy-policy', "uses" => 'HomeController@privacyPolicy']);
    Route::any('/disclaimer', ['as' => 'disclaimer', "uses" => 'HomeController@disclaimer']);
    Route::get('/forgot-password', array('as' => 'forgotPassword', 'uses' => 'HomeController@forgotPassword'));
    Route::any('/forget-password', array('as' => 'chkForgotPasswordEmail', 'uses' => 'LoginController@chkForgotPasswordEmail'));
    Route::get('/reset-password/{link?}', array('as' => 'resetNewPwd', 'uses' => 'HomeController@resetNewPwd'));
    Route::post('/save-reset-password', array('as' => 'saveResetPwd', 'uses' => 'LoginController@saveResetPwd'));
    Route::get('/contact_us', array('as' => 'contactUs1', 'uses' => 'HomeController@contactUs1'));
    Route::any('/home-edit', ['as' => 'updateHomeSettings', 'uses' => 'HomeEditController@updateStoreSettings']);
    Route::any('/home-banner-add', ['as' => 'addHomeBanner', 'uses' => 'HomeEditController@addHomeBanner']);
    Route::any('/home-banner-edit', ['as' => 'updateHomeBanner', 'uses' => 'HomeEditController@updateHomeBanner']);  
//Route::group(array('before' => 'auth.account'), function() {
    Route::group(['prefix' => 'myaccount', 'middleware' => ['web', 'auth']], function() {
        Route::get('/', array('as' => 'myProfile', 'uses' => 'UserController@my_profile'));
        Route::get('/orders', array('as' => 'myOrders', 'uses' => 'UserController@myOrders'));
        Route::get('/wishlists', array('as' => 'wishlists', 'uses' => 'UserController@wishlists'));
        Route::get('/order-details/{id}', array('as' => 'orderDetails', 'uses' => 'UserController@orderDetails'));
        Route::any('/order-details-json', array('as' => 'orderDetailsJson', 'uses' => 'UserController@orderDetails_json'));
        Route::any('/order-return-cal', array('as' => 'orderReturnCal', 'uses' => 'UserController@order_return_cal'));
        Route::any('/order-cancel-status', array('as' => 'statusOrderCancel', 'uses' => 'UserController@statusOrderCancel'));
        Route::any('/update-return-order-statusf', ['as' => 'UpdateReturnOrderStatusf', 'uses' => 'UserController@update_return_order_statusf']);
        Route::get('/edit-profie', array('as' => 'editProfile', 'uses' => 'UserController@editProfile'));
        Route::post('/update-profile', array('as' => 'updateProfile', 'uses' => 'UserController@updateProfile'));
        Route::post('/update-profile-image', array('as' => 'updateProfileImage', 'uses' => 'UserController@updateProfileImage'));
        Route::get('/change-password-myacc', array('as' => 'changePasswordMyAcc', 'uses' => 'UserController@changePasswordMyAcc'));
        Route::post('/update-change-password-myacc', array('as' => 'updateMyaccChangePassword', 'uses' => 'UserController@updateMyaccChangePassword'));
        Route::get('/order-feedback', array('as' => 'myaccFeedback', 'uses' => 'UserController@myaccFeedback'));
        Route::post('/save-feedback-myacc', array('as' => 'saveFeedbackMyacc', 'uses' => 'UserController@saveFeedbackMyacc'));
        Route::any('/download-efiles', array('as' => 'downloadEfiles', 'uses' => 'UserController@downloadEfiles'));
        Route::any('/filedown/{g?}', array('as' => 'filedown', 'uses' => 'UserController@fileDownload'));
        Route::any('/cashback-history', array('as' => 'cashBackHistory', 'uses' => 'UserController@cashback_history'));
        Route::post('/cancel-order', array('as' => 'cancel-order', 'uses' => 'UserController@cancelOrder'));
    });
    //});
    Route::group(array('prefix' => Config('constants.cartSlug'), 'middleware' => ['web']), function() {
        Route::get('/cart', array('as' => 'cart', 'uses' => 'CartController@index'));
        Route::any('/add-to-cart/', array('as' => 'addToCart', 'uses' => 'CartController@add'));
        Route::any('/edit-cart/', array('as' => 'editCart', 'uses' => 'CartController@edit'));
        Route::any('/get-cart-count/', array('as' => 'getCartCount', 'uses' => 'CartController@getCartCount'));
        Route::any('/delete-cart/', array('as' => 'deleteCart', 'uses' => 'CartController@delete'));
    });
    Route::post('/update-cart-ramt', ['as' => 'UpdateCartRamt', 'uses' => 'CartController@updatecartramt']);
    Route::post('/verifygiftcoupon', ['as' => 'verifygiftcoupon', 'uses' => 'CartController@verifygiftcoupon']);
    Route::post('/erasegiftcoupon', ['as' => 'erasegiftcoupon', 'uses' => 'CartController@erasegiftcoupon']);
    Route::any('/check_coupon', ['as' => 'check_coupon', 'uses' => 'CartController@check_coupon']);
    Route::any('/update_pay_amt', ['as' => 'update_pay_amt', 'uses' => 'CartController@update_pay_amt']);
//for checkout page
    Route::any('/save-manage-categories', ['as' => 'saveManageCategories', 'uses' => 'HomeController@saveManageCategories']);
    Route::any('/update-home-page-3-boxes', ['as' => 'updateHomePage3Boxes', 'uses' => 'HomeController@updateHomePage3Boxes']);
    Route::any('/change-status-home-page3Boxes', ['as' => 'changeStatusHomePage3Boxes', 'uses' => 'HomeController@changeStatusHomePage3Boxes']);
    Route::any('/ecurier-tracking', ['as' => 'ecurierTracking', 'uses' => 'HomeController@ecurierTracking']);

    Route::any('/checkout', ['as' => 'checkout', 'uses' => 'CheckoutController@index']);
//    Route::any('/new-checkout', ['as' => 'newCheckout', 'uses' => 'CheckoutController@newCheckout']);
    Route::any('/new_user_login_new', array('as' => 'new_user_login_new', 'uses' => 'CheckoutController@new_user_login_new'));
    Route::any('/get_exist_user_login_new', array('as' => 'get_exist_user_login_new', 'uses' => 'CheckoutController@get_exist_user_login_new'));
    Route::any('/guest_checkout', array('as' => 'guestCheckout', 'uses' => 'CheckoutController@guestCheckout'));
    Route::any('/testmail', array('as' => 'testmail', 'uses' => 'CheckoutController@testMail'));
    Route::any('/check-stock-checkout', array('as' => 'check-stock-checkout', 'uses' => 'CheckoutController@checkStockCheckout'));
    Route::any('/check-pincode', array('as' => 'checkPincode', 'uses' => 'CheckoutController@checkPincode'));
    Route::any('/order-without-product', ['as' => 'orderWithoutProduct', 'uses' => 'CheckoutController@orderWithoutProduct']);
    Route::post('/save-order-without-product', ['as' => 'saveOrderwithproduct', 'uses' => 'CheckoutController@saveOrderwithproduct']);
    Route::post('/check-loyalty', ['as' => 'checkLoyalty', 'uses' => 'CheckoutController@checkLoyalty']);
    Route::any('/change_default_status', ['as' => 'change_default_status', 'uses' => 'CheckoutController@change_default_status']);
    Route::any('/check-stock/', ['as' => 'checkStock', 'uses' => 'ProductController@checkStock']);

    Route::any('/fb_details_checkout_new', array('as' => 'fb_details_checkout_new', 'uses' => 'CheckoutController@fb_details_checkout_new'));
    Route::any('/save_address', array('as' => 'save_address', 'uses' => 'CheckoutController@save_address'));
    Route::any('/save_billing_address', array('as' => 'save_billing_address', 'uses' => 'CheckoutController@save_billing_address'));
    Route::any('/get_address', array('as' => 'get_address', 'uses' => 'CheckoutController@get_address'));
    Route::any('/get_zone', array('as' => 'get_zone', 'uses' => 'CheckoutController@get_zone'));

    Route::any('/get_country_zone', array('as' => 'get_country_zone', 'uses' => 'CheckoutController@get_country_zone'));
    Route::any('/del_address', array('as' => 'del_address', 'uses' => 'CheckoutController@del_address'));
    Route::any('/del_bill_address', array('as' => 'del_bill_address', 'uses' => 'CheckoutController@del_bill_address'));
    Route::any('/sel_address', array('as' => 'sel_address', 'uses' => 'CheckoutController@sel_address'));
    Route::any('/getBillSummary', array('as' => 'getBillSummary', 'uses' => 'CheckoutController@getBillSummary'));
    Route::any('/check_voucher/{id?}', array('as' => 'check_voucher', 'uses' => 'CheckoutController@check_voucher'));
    Route::post('/check_user_level_discount/{id?}', array('as' => 'check_user_level_discount', 'uses' => 'CheckoutController@check_user_level_discount'));
    Route::post('/revert_user_level_discount', array('as' => 'revert_user_level_discount', 'uses' => 'CheckoutController@revert_user_level_discount'));
    Route::post('/require_cashback/{id?}', array('as' => 'require_cashback', 'uses' => 'CheckoutController@require_cashback'));
    Route::post('/revert_cashback', array('as' => 'revert_cashback', 'uses' => 'CheckoutController@revert_cashback'));
    Route::any('/response', array('as' => 'response', 'uses' => 'CheckoutController@response'));
    Route::post('/check_referal_code/{id?}', array('as' => 'check_referal_code', 'uses' => 'CheckoutController@check_referal_code'));
    Route::post('/order_cash_on_delivery', array('as' => 'order_cash_on_delivery', 'uses' => 'CheckoutController@order_cash_on_delivery'));
    Route::post('/ebs', array('as' => 'ebs', 'uses' => 'CheckoutController@ebs'));
    Route::post('/paypal_process', array('as' => 'paypal_process', 'uses' => 'CheckoutController@paypal_process'));
    Route::get('/paypal_success', array('as' => 'paypal_success', 'uses' => 'CheckoutController@paypal_success'));
    Route::get('/paypal_cancel', array('as' => 'paypal_cancel', 'uses' => 'CheckoutController@paypal_cancel'));
    Route::any('/toPayment', array('as' => 'toPayment', 'uses' => 'CheckoutController@toPayment'));
    Route::any('/get_loggedindata', array('as' => 'get_loggedindata', 'uses' => 'CheckoutController@get_loggedindata'));
    Route::any('/get_billingdata', array('as' => 'get_billingdata', 'uses' => 'CheckoutController@get_billingdata'));
    Route::any('/update_pay', array('as' => 'update_pay', 'uses' => 'CheckoutController@update_pay'));
    Route::any('/get_g_plus_login', array('as' => 'get_g_plus_login', 'uses' => 'CheckoutController@get_g_plus_login'));
    Route::any('/apply_gift_wrap', array('as' => 'apply_gift_wrap', 'uses' => 'CheckoutController@apply_gift_wrap'));
    Route::any('/revert_gift_wrap', array('as' => 'revert_gift_wrap', 'uses' => 'CheckoutController@revert_gift_wrap'));
    Route::any('/check_international', array('as' => 'check_international', 'uses' => 'CheckoutController@check_international'));
    Route::any('/back_to_address', array('as' => 'back_to_address', 'uses' => 'CheckoutController@back_to_address'));
    Route::any('/back_to_bill', array('as' => 'back_to_bill', 'uses' => 'CheckoutController@back_to_bill'));
    Route::any('/apply_cod_charges', array('as' => 'apply_cod_charges', 'uses' => 'CheckoutController@apply_cod_charges'));
    Route::any('/revert_cod_charges', array('as' => 'revert_cod_charges', 'uses' => 'CheckoutController@revert_cod_charges'));
    Route::any('/chk-cart-inventory', array('as' => 'chk_cart_inventory', 'uses' => 'CheckoutController@chk_cart_inventory'));
    Route::any('/get-payu', array('as' => 'getPayu', 'uses' => 'CheckoutController@getPayu'));
    Route::any('/get-razorpay', array('as' => 'getRazorpay', 'uses' => 'CheckoutController@getRazorpay'));
    Route::any('/get-razorpay-response', array('as' => 'getRazorpayResponse', 'uses' => 'CheckoutController@getRazorpayResponse'));
    Route::any('/get-citrus', array('as' => 'getCitrus', 'uses' => 'CheckoutController@getCitrus'));
    Route::any('/get-citrus-response', array('as' => 'getCitrusResponse', 'uses' => 'CheckoutController@getCitrusResponse'));
    Route::any('/get-citrus-failure', array('as' => 'getCitrusFailure', 'uses' => 'CheckoutController@getCitrusFailure'));
    Route::any('/order-success', array('as' => 'orderSuccess', 'uses' => 'CheckoutController@orderSuccess'));
    Route::any('/order-failure', array('as' => 'orderFailure', 'uses' => 'CheckoutController@orderFailure'));
    Route::any('/order-cancel', array('as' => 'orderCancel', 'uses' => 'CheckoutController@orderCancel'));
    Route::any('/gifting', array('as' => 'gifting', 'uses' => 'VoucherController@index'));
    Route::get('giftemail', ["as" => "giftemail", "uses" => "VoucherController@giftemail"]);
    Route::any('/payu-success', array('as' => 'payuSuccess', 'uses' => 'CheckoutController@payuSuccess'));
    Route::any('/payu-failure', array('as' => 'payuFailure', 'uses' => 'CheckoutController@payuFailure'));
    Route::any('/get-config-prod', ['as' => 'getConfigProd', 'uses' => 'ProductController@getConfigProd']);
    Route::any('/get-avail-prod', ['as' => 'getAvailProd', 'uses' => 'ProductController@getAvailProd']);
    Route::any('/get-prod-varient', ['as' => 'get-prod-varient', 'uses' => 'ProductController@getProdVarient']);
    Route::any('/get_billing_address', array('as' => 'get_billing_address', 'uses' => 'UserController@get_billing_address'));
    Route::any('/get_shipping_address', array('as' => 'get_shipping_address', 'uses' => 'UserController@get_shipping_address'));
    Route::any('/save_review', array('as' => 'save_review', 'uses' => 'UserController@save_review'));
    Route::any('/get_review', array('as' => 'get_review', 'uses' => 'UserController@get_review'));
    Route::any('/get_states', array('as' => 'get_states', 'uses' => 'UserController@get_zone'));
    Route::post('/save-wishlist', ['as' => 'addToWishlist', 'uses' => 'UserController@addToWishlist']);
    Route::post('/remove-wishlist', ['as' => 'removeWishlist', 'uses' => 'UserController@removeWishlist']);
    Route::post('/get-sub-prod', ['as' => 'getSubProd', 'uses' => 'ProductController@getSubProd']);
    Route::any('/getListingFilter', ['as' => 'getListingFilter', 'uses' => 'CategoriesController@getListingFilter']);
    Route::any('/get-product-listing', ['as' => 'getProductListing', 'uses' => 'CategoriesController@getProductListing']);
    Route::any('/get-combo-prod', ['as' => 'getComboProd', 'uses' => 'ProductController@getComboProd']);
    Route::any('/get-combo-prod-info', array('as' => 'getComboProdInfo', 'uses' => 'ProductController@getComboProdInfo'));
    Route::any('/get-product-quickview', ['as' => 'getProductQuickView', 'uses' => 'ProductController@getProductQuickView']);
    Route::get('/static-page/{id}', ['as' => 'staticpage', 'uses' => 'StaticPagesController@showPage']);
    
    Route::any('/get-city-pay', array('as' => 'getCityPay', 'uses' => 'CheckoutController@getCityPay'));
    Route::any('/get-city-approved', array('as' => 'getCityApproved', 'uses' => 'CheckoutController@getCityApproved'));
    Route::any('/get-city-declined', array('as' => 'getCityDeclined', 'uses' => 'CheckoutController@getCityDeclined'));
    Route::any('/get-city-cancelled', array('as' => 'getCityCancelled', 'uses' => 'CheckoutController@getCityCancelled'));
    Route::any('/get-city-createOrder', array('as' => 'getCityCreateOrder', 'uses' => 'CheckoutController@getCityCreateOrder'));
    Route::any('/payment-success', array('as' => 'paymentSuccess', 'uses' => 'CheckoutController@paymentSuccess'));
    
    
    Route::any('/notify-mail', ['as' => 'notifyMail', 'uses' => 'ProductController@notify_mail']);
    Route::get('/explore/{slug?}', ['as' => 'category', 'uses' => 'CategoriesController@index']);
    Route::get('/{slug}/', ['as' => 'prod', 'uses' => 'ProductController@index']);
});


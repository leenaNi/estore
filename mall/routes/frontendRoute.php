<?php

Route::group(['middleware' => ['web'], 'namespace' => 'Auth'], function() {
    Route::get('login/{provider?}/{from?}', ['as' => 'login', 'uses' => 'AuthController@login']);
});

Route::group(['middleware' => ['web'], 'namespace' => 'Frontend'], function() {
    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
    Route::any('/sc', ['as' => 'setCurrency', 'uses' => 'HomeController@setCurrency']);
    Route::any('/change-country', array('as' => 'changeCountry', 'uses' => 'HomeController@change_country'));
    Route::any('/subscription-mail', ['as' => 'subscriptionMail', 'uses' => 'HomeController@subscription']);

    Route::post('/check-fb-user', ['as' => 'checkFbUser', 'uses' => 'LoginController@checkFbUser']);
    Route::get('/login-user', ['as' => 'loginUser', 'uses' => 'LoginController@login']);
    Route::get('/logout', ['as' => 'logoutUser', 'uses' => 'LoginController@logout']);
    Route::post('/check-user', ['as' => 'checkUser', 'uses' => 'LoginController@checkUser']);
    Route::post('/check-existing-user', ['as' => 'checkExistingUser', 'uses' => 'LoginController@checkExistingUser']);
    Route::post('/check-existing-mobile', ['as' => 'checkExistingMobileNo', 'uses' => 'LoginController@checkExistingMobileNo']);
    Route::get('/user-register', ['as' => 'userRegister', 'uses' => 'LoginController@userRegister']);
    Route::post('/save-register', ['as' => 'saveRegister', 'uses' => 'LoginController@saveRegister']);
    Route::get('/forgot-password', array('as' => 'forgotPassword', 'uses' => 'HomeController@forgotPassword'));
    Route::any('/forget-password', array('as' => 'chkForgotPasswordEmail', 'uses' => 'LoginController@chkForgotPasswordEmail'));
    Route::get('/reset-password/{link?}', array('as' => 'resetNewPwd', 'uses' => 'HomeController@resetNewPwd'));
    Route::post('/save-reset-password', array('as' => 'saveResetPwd', 'uses' => 'LoginController@saveResetPwd'));

    //CART ROUTES
    Route::group(array('prefix' => Config('constants.cartSlug'), 'middleware' => ['web']), function() {
        Route::get('/cart', array('as' => 'cart', 'uses' => 'CartController@index'));
        Route::any('/add-to-cart/', array('as' => 'addToCart', 'uses' => 'CartController@add'));
        Route::any('/edit-cart/', array('as' => 'editCart', 'uses' => 'CartController@edit'));
        Route::any('/get-cart-count/', array('as' => 'getCartCount', 'uses' => 'CartController@getCartCount'));
        Route::any('/delete-cart/', array('as' => 'deleteCart', 'uses' => 'CartController@delete'));
    });


    //PRODUCT LISTING ROUTES
    ;
    Route::any('/check_coupon', ['as' => 'check_coupon', 'uses' => 'CartController@check_coupon']);
    Route::any('/checkout', ['as' => 'checkout', 'uses' => 'CheckoutController@index']);
    Route::any('/new_user_login_new', array('as' => 'new_user_login_new', 'uses' => 'CheckoutController@new_user_login_new'));
    Route::any('/get_exist_user_login_new', array('as' => 'get_exist_user_login_new', 'uses' => 'CheckoutController@get_exist_user_login_new'));
    Route::any('check-pincode-home', ["as" => "checkPincodeHome", "uses" => "HomeController@checkPincode"]);
    Route::any('/check-pincode', array('as' => 'checkPincode', 'uses' => 'CheckoutController@checkPincode'));
    Route::any('/get_loggedindata', array('as' => 'get_loggedindata', 'uses' => 'CheckoutController@get_loggedindata'));
    Route::any('/get_country_zone', array('as' => 'get_country_zone', 'uses' => 'CheckoutController@get_country_zone'));
    Route::any('/get_zone', array('as' => 'get_zone', 'uses' => 'CheckoutController@get_zone'));
    Route::any('/save_address', array('as' => 'save_address', 'uses' => 'CheckoutController@save_address'));
    Route::any('/sel_address', array('as' => 'sel_address', 'uses' => 'CheckoutController@sel_address'));
    Route::any('/check_international', array('as' => 'check_international', 'uses' => 'CheckoutController@check_international'));
    Route::any('/back_to_address', array('as' => 'back_to_address', 'uses' => 'CheckoutController@back_to_address'));
    Route::any('/back_to_bill', array('as' => 'back_to_bill', 'uses' => 'CheckoutController@back_to_bill'));
     Route::any('/getBillSummary', array('as' => 'getBillSummary', 'uses' => 'CheckoutController@getBillSummary'));
      Route::any('/toPayment', array('as' => 'toPayment', 'uses' => 'CheckoutController@toPayment'));
      Route::any('/chk-cart-inventory', array('as' => 'chk_cart_inventory', 'uses' => 'CheckoutController@chk_cart_inventory'));
    Route::any('/getListingFilter', ['as' => 'getListingFilter', 'uses' => 'CategoriesController@getListingFilter']);
    Route::any('/get-product-listing', ['as' => 'getProductListing', 'uses' => 'CategoriesController@getProductListing']);
    //Category Listing

    Route::get('/explore/{slug?}', ['as' => 'category', 'uses' => 'CategoriesController@index']);
});


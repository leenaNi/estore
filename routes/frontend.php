<?php

Route::group(['middleware' => ['web'], 'namespace' => 'Auth'], function() {
    Route::get('login/{provider?}/{from?}', ['as' => 'login', 'uses' => 'AuthController@login']);
});

Route::group(['middleware' => ['web'], 'namespace' => 'Frontend'], function() {
     Route::any('/clear-db', ['as' => 'cleardb', 'uses' => 'HomeController@cleardb']);

    Route::any('/', ['as' => 'home', 'uses' => 'HomeController@index']);
    Route::any('/new-store', ['as' => 'newstore', 'uses' => 'HomeController@newStore']);
     Route::any('/clear-db', ['as' => 'clear_db', 'uses' => 'HomeController@clear_db']);
    
    Route::any('/check-user', ['as' => 'checkUser', 'uses' => 'HomeController@checkUser']);
    Route::any('/check-fbuser', ['as' => 'checkFbUser', 'uses' => 'HomeController@checkFbUser']);
        Route::any('/check-fbuser-login', ['as' => 'checkFbUserLogin', 'uses' => 'HomeController@checkFbUserLogin']);

    Route::any('/show-themes', ['as' => 'showThemes', 'uses' => 'HomeController@showThemes']);
    Route::any('/select-themes', ['as' => 'selectThemes', 'uses' => 'HomeController@selectThemes']);
    Route::any('/congrats/{data?}', ['as' => 'congrats', 'uses' => 'HomeController@congrats']);
      Route::any('/congratulations', ['as' => 'getcongrats', 'uses' => 'HomeController@getcongrats']);
    
    Route::any('/thankyou', ['as' => 'thankYou', 'uses' => 'HomeController@thankYou']);
    Route::any('/wait-process', ['as' => 'waitProcess', 'uses' => 'HomeController@waitProcess']);
    Route::any('/pricing', ['as' => 'pricing', 'uses' => 'HomeController@pricing']);
    Route::post('/check-existing-user', ['as' => 'checkExistingUser', 'uses' => 'HomeController@checkExistingUser']);
    Route::post('/check-existing-phone', ['as' => 'checkExistingphone', 'uses' => 'HomeController@checkExistingphone']);
    Route::any('/infinisys', ['as' => 'home1', 'uses' => 'HomeController@infiniSys']);
    Route::any('/check-store', ['as' => 'checkStore', 'uses' => 'HomeController@checkStore']);
    Route::any('create-store', ['as' => 'createStore', 'uses' => 'HomeController@createStore']);
    Route::any('confirm-mail', ['as' => 'confirmMail', 'uses' => 'HomeController@confirmMail']);
    Route::any('check-domain-avail', ['as' => 'checkDomainAvail', 'uses' => 'HomeController@checkDomainAvail']);
    Route::any('reset-new-pwd/{link?}', ['as' => 'resetNewPwd', 'uses' => 'HomeController@resetNewPwd']);
    Route::any('reset-new-pwd-save', ['as' => 'resetNewPwdSave', 'uses' => 'HomeController@resetNewPwdSave']);
    //frontend forgot password
     Route::any('merchant-forgot-password', ['as' => 'merchantForgotPassword', 'uses' => 'HomeController@merchantForgotPassword']);


    Route::any('avail-domain', ['as' => 'availDomain', 'uses' => 'HomeController@availDomain']);

    Route::any('read', ['as' => 'read', 'uses' => 'HomeController@read']);
    Route::any('/veestores-logout', ['as' => 'veestoresLogout', 'uses' => 'HomeController@veestoresLogout']);
    Route::any('/veestore-login', ['as' => 'veestoreLogin', 'uses' => 'HomeController@veestoreLogin']);
    Route::any('/veestore-myaccount', ['as' => 'veestoreMyaccount', 'uses' => 'HomeController@veestoresMyaccount']);
    Route::any('/veestore-change-password', ['as' => 'veestoresChangePassword', 'uses' => 'HomeController@veestoresChangePassword']);
    Route::any('/veestore-updateProfile', ['as' => 'veestoresUpdateProfile', 'uses' => 'HomeController@veestoresUpdateProfile']);
    Route::any('/veestore-UpdateChangePassword', ['as' => 'veestoresUpdateChangePassword', 'uses' => 'HomeController@veestoresUpdateChangePassword']);
    Route::any('/veestore-tutorial', ['as' => 'veestoresTutorial', 'uses' => 'HomeController@veestoresTutorial']);
    Route::any('/features', ['as' => 'pricing', 'uses' => 'HomeController@featureList']);
    Route::any('/terms-condition', ['as' => 'terms-condition', 'uses' => 'HomeController@termCondition']);
    Route::any('/privacy-policy', ['as' => 'privacy-policy', 'uses' => 'HomeController@privacyPolicy']);
    Route::any('/about', ['as' => 'about', 'uses' => 'HomeController@aboutUs']);
    Route::any('/contact', ['as' => 'contact', 'uses' => 'HomeController@contactUs']);
    Route::any('/contact-send', ['as' => 'contactSend', 'uses' => 'HomeController@contactSend']);
    Route::any('/faqs', ['as' => 'faqs', 'uses' => 'HomeController@faqS']);
   Route::any('/send-otp', ['as' => 'sendOpt', 'uses' => 'HomeController@sendOtp']);
    Route::any('/check-otp', ['as' => 'checkOtp', 'uses' => 'HomeController@checkOtp']);
    Route::any('/not-found', ['as' => 'not-found', 'uses' => 'HomeController@notFound']);
    

    Route::any('/get-city-pay', array('as' => 'getCityPay', 'uses' => 'PaymentController@getCityPay'));
     Route::any('/get-city-approved', array('as' => 'getCityApproved', 'uses' => 'PaymentController@getCityApproved'));
    Route::any('/get-city-pay-renew/{storeid}/{version}', array('as' => 'getCityPayRenew', 'uses' => 'PaymentController@getCityPayRenew')); 
    Route::any('/get-renew-city-approved', array('as' => 'getRenewCityApproved', 'uses' => 'PaymentController@getRenewCityApproved'));
    Route::any('/get-city-declined', array('as' => 'getCityDeclined', 'uses' => 'PaymentController@getCityDeclined'));
    Route::any('/get-city-cancelled', array('as' => 'getCityCancelled', 'uses' => 'PaymentController@getCityCancelled'));
    Route::any('/get-city-createOrder', array('as' => 'getCityCreateOrder', 'uses' => 'PaymentController@getCityCreateOrder'));
    Route::any('/payment-success', array('as' => 'paymentSuccess', 'uses' => 'PaymentController@paymentSuccess'));
    Route::any('/order-failure', array('as' => 'orderFailure', 'uses' => 'PaymentController@orderFailure'));
});

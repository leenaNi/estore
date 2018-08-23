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
//    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
});


<?php

Route::group(['namespace' => 'Admin'], function () {
    Route::get('/', ["as" => "admin.login", "uses" => "LoginController@login"]);
    Route::get('/logout', ["as" => "admin.merchant.logout", "uses" => "LoginController@merchantLogout"]);
    Route::post('/check-bank-login', ["as" => "admin.login.checkMerchantLogin", "uses" => "LoginController@checkMerchantLogin"]);
    //->middleware('auth.basic:bank-users-web-guard')

    Route::group(['middleware' => ['auth:merchant-users-web-guard']], function () {
        Route::get('/dashboard', ["as" => "admin.dashboard", "uses" => "LoginController@dashboard"]);
        Route::group(['prefix' => 'merchants'], function () {
            Route::get('/', ["as" => "admin.merchants.view", "uses" => "MerchantController@index"]);
            Route::any('/add-edit', ["as" => "admin.merchants.addEdit", "uses" => "MerchantController@addEdit"]);
            Route::post('/save-update', ["as" => "admin.merchants.saveUpdate", "uses" => "MerchantController@saveUpdate"]);
            Route::any('/save-update-documents', ["as" => "admin.merchants.saveUpdateDocuments", "uses" => "MerchantController@saveUpdateDocuments"]);
            Route::any('/delete-document', ["as" => "admin.merchants.deleteDocument", "uses" => "MerchantController@deleteDocument"]);
            Route::any('/merchant-autocomplete', ["as" => "admin.merchants.merchantAutocomplete", "uses" => "MerchantController@merchantAutocomplete"]);
            Route::post('/check-existing-merchant', ["as" => "admin.merchants.checkExistingMerchant", "uses" => "MerchantController@checkExistingMerchant"]);
        });
        Route::group(['prefix' => 'stores'], function () {
            Route::get('/', ["as" => "admin.stores.view", "uses" => "StoreController@index"]);
            Route::any('/add-edit', ["as" => "admin.stores.addEdit", "uses" => "StoreController@addEdit"]);
            Route::post('/save-update-general', ["as" => "admin.stores.saveUpdateGeneral", "uses" => "StoreController@saveUpdateGeneral"]);
            Route::post('/save-update-contact', ["as" => "admin.stores.saveUpdateContact", "uses" => "StoreController@saveUpdateContact"]);
            Route::post('/save-update-business', ["as" => "admin.stores.saveUpdateBusiness", "uses" => "StoreController@saveUpdateBusiness"]);
            Route::post('/save-update-bank', ["as" => "admin.stores.saveUpdateBank", "uses" => "StoreController@saveUpdateBank"]);
            Route::post('/save-update-store', ["as" => "admin.stores.saveUpdateStoreDoc", "uses" => "StoreController@saveUpdateStoreDoc"]);
            Route::post('/delete-store-document', ["as" => "admin.stores.deleteStoreDoc", "uses" => "StoreController@deleteStoreDoc"]);
            Route::get('/get-zone-dropdown/{id?}', ["as" => "admin.stores.getZoneDropdown", "uses" => "StoreController@getZoneDropdown"]);
        });
        Route::group(['prefix' => 'analytics'], function () {
            Route::get('/by-category', ["as" => "admin.analytics.byCategory", "uses" => "AnalyticController@byCategory"]);
            Route::get('/by-date', ["as" => "admin.analytics.byDate", "uses" => "AnalyticController@byDate"]);
            Route::get('/by-merchant', ["as" => "admin.analytics.byMerchant", "uses" => "AnalyticController@byMerchant"]);
            Route::any('/by-merchant-export', ["as" => "admin.analytics.byMerchant.export", "uses" => "AnalyticController@byMerchantExport"]);
            Route::any('/by-store-export', ["as" => "admin.analytics.byStore.export", "uses" => "AnalyticController@byStoreExport"]);
            Route::get('/by-store', ["as" => "admin.analytics.byStore", "uses" => "AnalyticController@byStore"]);
            Route::any('/by-date-get-yearly', ["as" => "admin.analytics.byDateGetYearly", "uses" => "AnalyticController@byDateGetYearly"]);
            Route::any('/by-date-get-daily', ["as" => "admin.analytics.byDateGetDaily", "uses" => "AnalyticController@byDateGetDaily"]);
            Route::any('/by-date-get-monthly', ["as" => "admin.analytics.byDateGetMonthly", "uses" => "AnalyticController@byDateGetMonthly"]);
           Route::any('/by-category-export', ["as" => "admin.analytics.byCategoryExport", "uses" => "AnalyticController@byCategoryExport"]);

        });
   
      
    });
});
<?php

Route::group(['namespace' => 'Admin'], function () {
    Route::get('/unauthorized', function() {
        return view('Admin.Pages.unauthorized');
    });
    Route::get('/', ["as" => "admin.login", "uses" => "LoginController@login"]);
    Route::get('/logout', ["as" => "admin.vswipe.logout", "uses" => "LoginController@vswipeLogout"]);
    Route::any('/forgot-password', ["as" => "adminForgotPassword", "uses" => "LoginController@forgotPassword"]);
     Route::any('/forgot-password-check', ["as" => "adminChkForgotPasswordEmail", "uses" => "LoginController@chkForgotPasswordEmail"]);
    Route::any('/reset-password/{link?}', ["as" => "adminResetPassword", "uses" => "LoginController@adminResetNewPassword"]);
    Route::any('/save-resetPwd', ["as" => "adminSaveResetPwd", "uses" => "LoginController@adminSaveResetPwd"]);
    
    Route::any('/check-veeswipe-login', ["as" => "admin.login.checkVeeswipeLogin", "uses" => "LoginController@checkVeeswipeLogin"]);
    Route::group(['middleware' => ['auth:vswipe-users-web-guard', 'CheckUser']], function () {
        Route::get('/dashboard', ["as" => "admin.dashboard", "uses" => "LoginController@dashboard"]);
        Route::get('/getOrderDateWise', ["as" => "admin.getOrderDateWise", "uses" => "LoginController@getOrderDateWise"]);
        Route::get('/getSalesDateWise', ["as" => "admin.getSalesDateWise", "uses" => "LoginController@getSalesDateWise"]);
        Route::group(['prefix' => 'merchants'], function () {
            Route::get('/', ["as" => "admin.merchants.view", "uses" => "MerchantController@index"]);
            Route::any('/add-edit', ["as" => "admin.merchants.addEdit", "uses" => "MerchantController@addEdit"]);
            Route::post('/save-update', ["as" => "admin.merchants.saveUpdate", "uses" => "MerchantController@saveUpdate"]);
            Route::any('/save-update-documents', ["as" => "admin.merchants.saveUpdateDocuments", "uses" => "MerchantController@saveUpdateDocuments"]);
            Route::any('/delete-document', ["as" => "admin.merchants.deleteDocument", "uses" => "MerchantController@deleteDocument"]);
            Route::any('/merchant-autocomplete', ["as" => "admin.merchants.merchantAutocomplete", "uses" => "MerchantController@merchantAutocomplete"]);
            Route::post('/check-existing-merchant', ["as" => "admin.merchants.checkExistingMerchant", "uses" => "MerchantController@checkExistingMerchant"]);
            Route::post('/check-existing-user', ['as' => 'checkExistingUser', 'uses' => 'MerchantController@checkExistingUser']);
            Route::post('/check-existing-phone', ['as' => 'checkExistingphone', 'uses' => 'MerchantController@checkExistingphone']);
            
        });
        Route::group(['prefix' => 'stores'], function () {
            Route::get('/', ["as" => "admin.stores.view", "uses" => "StoreController@index"]);
            Route::any('/check-store', ['as' => 'checkStoreAdmin', 'uses' => 'StoreController@checkStore']);
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
            Route::get('/by-store', ["as" => "admin.analytics.byStore", "uses" => "AnalyticController@byStore"]);
            Route::any('/by-bank', ["as" => "admin.analytics.byBank", "uses" => "AnalyticController@byBank"]);

            Route::any('/by-bank-export', ["as" => "admin.analytics.byBank.export", "uses" => "AnalyticController@byBankExport"]);
            Route::any('/by-merchant-export', ["as" => "admin.analytics.byMerchant.export", "uses" => "AnalyticController@byMerchantExport"]);
            Route::any('/by-store-export', ["as" => "admin.analytics.byStore.export", "uses" => "AnalyticController@byStoreExport"]);
            Route::any('/by-date-get-yearly', ["as" => "admin.analytics.byDateGetYearly", "uses" => "AnalyticController@byDateGetYearly"]);
            Route::any('/by-date-get-daily', ["as" => "admin.analytics.byDateGetDaily", "uses" => "AnalyticController@byDateGetDaily"]);
            Route::any('/by-date-get-monthly', ["as" => "admin.analytics.byDateGetMonthly", "uses" => "AnalyticController@byDateGetMonthly"]);
            Route::any('/by-category-export', ["as" => "admin.analytics.byCategoryExport", "uses" => "AnalyticController@byCategoryExport"]);

            
        });
        Route::group(['prefix' => 'systemusers'], function () {
            Route::group(['prefix' => 'roles'], function() {
                Route::get('/', ['as' => 'admin.systemusers.roles.view', 'uses' => 'VswipeRolesController@index']);
                Route::any('/add', ['as' => 'admin.systemusers.roles.addEdit', 'uses' => 'VswipeRolesController@addEdit']);
                Route::post('/save-update', ['as' => 'admin.systemusers.roles.saveUpdate', 'uses' => 'VswipeRolesController@saveUpdate']);
                Route::get('/delete', ['as' => 'admin.systemusers.roles.delete', 'uses' => 'VswipeRolesController@delete']);
            });
            Route::group(['prefix' => 'users'], function() {
                Route::get('/', ['as' => 'admin.systemusers.users.view', 'uses' => 'VswipeUsersController@index']);
                Route::any('/add', ['as' => 'admin.systemusers.users.addEdit', 'uses' => 'VswipeUsersController@addEdit']);
                Route::post('/save-update', ['as' => 'admin.systemusers.users.saveUpdate', 'uses' => 'VswipeUsersController@saveUpdate']);
                Route::get('/delete', ['as' => 'admin.systemusers.users.delete', 'uses' => 'VswipeUsersController@delete']);
            });
        });

        Route::group(['prefix' => 'masters'], function () {
            Route::group(['prefix' => 'category'], function () {
                Route::get('/', ["as" => "admin.masters.category.view", "uses" => "CategoryController@index"]);
                Route::any('/add-edit', ["as" => "admin.masters.category.addEdit", "uses" => "CategoryController@addEdit"]);
                Route::post('/save-update', ["as" => "admin.masters.category.saveUpdate", "uses" => "CategoryController@saveUpdate"]);
                Route::post('/change-status', ["as" => "admin.masters.category.changeStatus", "uses" => "CategoryController@changeStatus"]);
                Route::any('/add-category', ["as" => "admin.masters.addCategory", "uses" => "CategoryController@addCategory"]);
                Route::any('/add-attributeSet', ["as" => "admin.masters.addAttributeSet", "uses" => "CategoryController@addAttributeSet"]);
                Route::any('/add-attribute', ["as" => "admin.masters.addAttribute", "uses" => "CategoryController@addAttribute"]);
            });
            Route::group(['prefix' => 'language'], function () {
                Route::get('/', ["as" => "admin.masters.language.view", "uses" => "LanguageController@index"]);
                Route::any('/add-edit', ["as" => "admin.masters.language.addEdit", "uses" => "LanguageController@addEdit"]);
                Route::post('/save-update', ["as" => "admin.masters.language.saveUpdate", "uses" => "LanguageController@saveUpdate"]);
                Route::post('/change-status', ["as" => "admin.masters.language.changeStatus", "uses" => "LanguageController@changeStatus"]);
            });
            Route::group(['prefix' => 'translation'], function () {
                Route::get('/', ["as" => "admin.masters.translation.view", "uses" => "TranslationController@index"]);
                Route::post('/save-update', ["as" => "admin.masters.translation.saveUpdate", "uses" => "TranslationController@saveUpdate"]);
                Route::post('/delete', ["as" => "admin.masters.translation.delete", "uses" => "TranslationController@delete"]);
            });
            
              Route::group(['prefix' => 'themes'], function () {
                Route::get('/', ["as" => "admin.masters.themes.view", "uses" => "StoreThemesController@index"]);
                Route::any('/add-edit', ["as" => "admin.masters.themes.addEdit", "uses" => "StoreThemesController@addEdit"]);
                Route::post('/save-update', ["as" => "admin.masters.themes.saveUpdate", "uses" => "StoreThemesController@saveUpdate"]);
                Route::post('/change-status', ["as" => "admin.masters.themes.changeStatus", "uses" => "StoreThemesController@changeStatus"]);
                Route::get('/delete-banner', ["as" => "admin.masters.themes.deleteBanner", "uses" => "StoreThemesController@deleteBanner"]);
            });
        });
        Route::group(['prefix' => 'settings'], function () {
            Route::get('/', ["as" => "admin.settings.view", "uses" => "SettingsController@index"]);
            Route::post('/', ["as" => "admin.settings.update", "uses" => "SettingsController@update"]);
        });
        
        Route::group(['prefix' => 'templates'], function () {
            Route::get('/', ["as" => "admin.templates.view", "uses" => "TemplatesController@index"]);
            Route::any('/add', ["as" => "admin.templates.add", "uses" => "TemplatesController@add"]);
            Route::any('/edit', ["as" => "admin.templates.edit", "uses" => "TemplatesController@edit"]);
            Route::post('/save', ["as" => "admin.templates.save", "uses" => "TemplatesController@save"]);
            Route::get('/delete', ["as" => "admin.templates.delete", "uses" => "TemplatesController@delete"]);
        });
        
        Route::group(['prefix' => 'updates'], function () {
            Route::group(['prefix' => 'codeupdate'], function () {
                Route::get('/', ["as" => "admin.updates.codeUpdate.view", "uses" => "UpdatesController@codeUpdate"]);
                Route::any('/new-code-update', ["as" => "admin.updates.codeUpdate.newCodeUpdate", "uses" => "UpdatesController@newCodeUpdate"]);
                Route::any('/backup-index', ["as" => "admin.updates.backup.index", "uses" => "UpdatesController@backupIndex"]);
                Route::post('/save-update', ["as" => "admin.updates.codeUpdate.save", "uses" => "UpdatesController@save"]);
                Route::post('/save-new', ["as" => "admin.updates.codeUpdate.saveNew", "uses" => "UpdatesController@saveNew"]);
            });
            Route::group(['prefix' => 'databaseupdate'], function () {
                Route::get('/', ["as" => "admin.updates.databaseUpdate.view", "uses" => "UpdatesController@databaseUpdate"]);
                Route::post('/new-db-update', ["as" => "admin.updates.databaseUpdate.newDatabaseUpdate", "uses" => "UpdatesController@newDatabaseUpdate"]);
            });
        });
         Route::group(['prefix' => 'courier-service', 'middlewareGroups' => ['web']], function() {
            Route::get('/', ['as' => 'admin.courier.view', 'uses' => 'CourierController@index']);
            Route::get('/add', ['as' => 'admin.courier.add', 'uses' => 'CourierController@add']);
            Route::post('/save', ['as' => 'admin.courier.save', 'uses' => 'CourierController@save']);
            Route::post('/update', ['as' => 'admin.courier.update', 'uses' => 'CourierController@update']);
            Route::get('/edit', ['as' => 'admin.courier.edit', 'uses' => 'CourierController@edit']);
            Route::get('/delete', ['as' => 'admin.courier.delete', 'uses' => 'CourierController@delete']);
            Route::any('/changeStatus', ['as' => 'admin.courier.changeStatus', 'uses' => 'CourierController@changeStatus']);
        });
        
        Route::group(['prefix' => 'bank'], function () {
            Route::get('/', ["as" => "admin.banks.view", "uses" => "BankController@index"]);
            Route::any('/add-edit', ["as" => "admin.banks.addEdit", "uses" => "BankController@addEdit"]);
            Route::post('/save-update', ["as" => "admin.banks.saveUpdate", "uses" => "BankController@saveUpdate"]);
            Route::any('/save-update-documents', ["as" => "admin.banks.saveUpdateDocuments", "uses" => "BankController@saveUpdateDocuments"]);
            Route::any('/delete-document', ["as" => "admin.banks.deleteDocument", "uses" => "BankController@deleteDocument"]);
        });
             Route::group(['prefix' => 'notification', 'middlewareGroups' => ['web']], function() {
            Route::get('/', ['as' => 'admin.notification.view', 'uses' => 'PushNotificationController@index']);
            Route::get('/new-notificatiom', ['as' => 'admin.notification.addNew', 'uses' => 'PushNotificationController@addNew']);
            Route::any('/notication-send', ['as' => 'admin.notification.send', 'uses' => 'PushNotificationController@sendNotification']);
            Route::any('/notication-resend', ['as' => 'admin.notification.resend', 'uses' => 'PushNotificationController@resendNotification']);
           
          
        });
         Route::group(['prefix' => 'payment-settlement'], function() {
            Route::get('/', ['as' => 'admin.payment-settlement.view', 'uses' => 'PaymentSettlementController@index']);
            Route::any('/settled-payment', ['as' => 'admin.payment-settlements.settledPayment', 'uses' => 'PaymentSettlementController@settledPayment']);
            Route::any('/settlement-summary', ['as' => 'admin.payment-settlements.settlementSummary', 'uses' => 'PaymentSettlementController@settlementSummary']);
        });
        Route::group(['prefix' => 'set-cron'], function() {
            Route::get('/get-update-sales', ['as' => 'admin.setCron.getDashboard', 'uses' => 'SetCronController@updateSales']);
        });
    });
});




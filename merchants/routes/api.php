<?php

use Illuminate\Http\Request;

/*
  |--------------------------------------------------------------------------
  | API Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register API routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | is assigned the "api" middleware group. Enjoy building your API!
  |
 */

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:api');
Route::group(['middleware' => ['api'], 'prefix' => 'api'], function () {
    
});
Route::group(['namespace' => 'Frontend'], function() {
    Route::post('/login', ['as' => 'api-login', 'uses' => 'ApiController@savelogin']);

    Route::group(['middleware' => 'jwt-auth-frontend'], function () {

        Route::post('/get_user_details', ['as' => 'get_user_details', 'uses' => 'ApiController@get_user_details']);
        Route::get('/logout', ['as' => 'logout', 'uses' => 'ApiController@logout']);
        Route::any('/order-without-product', ['as' => 'orderWithoutProduct', 'uses' => 'CheckoutController@orderWithoutProduct']);
        Route::post('/save-order-without-product', ['as' => 'saveOrderwithproduct', 'uses' => 'CheckoutController@saveOrderwithproduct']);
        Route::post('/check-loyalty', ['as' => 'checkLoyalty', 'uses' => 'ApiController@checkLoyalty']);
        Route::post('/get-loyalty-group', ['as' => 'getLoyaltyGroup', 'uses' => 'ApiController@getLoyaltyGroup']);
        Route::post('/checkout', ['as' => 'checkout', 'uses' => 'ApiController@checkout']);
        Route::post('/create-normal-order', ['as' => 'createNormalOrder', 'uses' => 'ApiController@createNormalOrder']);
        Route::post('/create-guest-order', ['as' => 'createGuestOrder', 'uses' => 'ApiController@createGuestOrder']);
        Route::post('/create-express-order', ['as' => 'createExpressOrder', 'uses' => 'ApiController@createExpressOrder']);
        Route::post('/check-coupon', ['as' => 'checkCoupon', 'uses' => 'ApiController@check_coupon']);
        Route::post('/check-user-level-discount', ['as' => 'checkUserLevelDiscount', 'uses' => 'ApiController@check_user_level_discount']);
        Route::post('/cancel-order', array('as' => 'cancel-order', 'uses' => 'UserController@cancelOrder'));
        Route::post('/order_cash_on_delivery', array('as' => 'order_cash_on_delivery', 'uses' => 'CheckoutController@order_cash_on_delivery'));
        Route::any('/forget-password', array('as' => 'chkForgotPasswordEmail', 'uses' => 'LoginController@chkForgotPasswordEmail'));
        Route::get('/reset-password/{link?}', array('as' => 'resetNewPwd', 'uses' => 'HomeController@resetNewPwd'));
        Route::post('/save-reset-password', array('as' => 'saveResetPwd', 'uses' => 'LoginController@saveResetPwd'));
        Route::get('/order-details', array('as' => 'orderDetails', 'uses' => 'UserController@orderDetails'));
        Route::post('/update-change-password-myacc', array('as' => 'updateMyaccPassword', 'uses' => 'LoginController@updateMyaccPassword'));
        Route::post('/save-reset-password', array('as' => 'saveResetPwd', 'uses' => 'LoginController@saveResetPwd'));
    });
});


// admin routes
Route::group(['namespace' => 'Admin'], function() {
    Route::group(['middleware' => 'jwt-auth'], function () {
        Route::get('/unauthorized', ["as" => "unauthorized", "uses" => "ApiController@unauthorized"]);
        Route::group(['prefix' => 'apicat'], function() {
            Route::get('/', ['as' => 'admin.apicat.view', 'uses' => 'ApiCatController@index']);
            Route::get('/add', ['as' => 'admin.apicat.add', 'uses' => 'ApiCatController@add']);
            Route::post('/save', ['as' => 'admin.apicat.save', 'uses' => 'ApiCatController@save']);
            Route::get('/edit', ['as' => 'admin.apicat.edit', 'uses' => 'ApiCatController@edit']);
            Route::post('/delete', ['as' => 'admin.apicat.delete', 'uses' => 'ApiCatController@delete']);
            Route::get('/cat-seo', ['as' => 'admin.apicat.catSeo', 'uses' => 'ApiCatController@catSeo']);
            Route::post('/cat-seo-save', ['as' => 'admin.apicat.saveCatSeo', 'uses' => 'ApiCatController@saveCatSeo']);
        });
        Route::group(['prefix' => 'apiprod'], function() {
            Route::get('/', ['as' => 'admin.apiprod.view', 'uses' => 'ApiProductController@index']);
            Route::get('/add', ['as' => 'admin.apiprod.add', 'uses' => 'ApiProductController@add']);
            Route::post('/save', ['as' => 'admin.apiprod.save', 'uses' => 'ApiProductController@save']);
            Route::get('/edit', ['as' => 'admin.apiprod.edit', 'uses' => 'ApiProductController@edit']);
            Route::post('/delete', ['as' => 'admin.apiprod.delete', 'uses' => 'ApiProductController@delete']);
            Route::get('/change-status', ['as' => 'admin.apiprod.changeStatus', 'uses' => 'ApiProductController@changeStatus']);

            //Route::get('/search-user', ['as' => 'admin.tax.searchUser', 'uses' => 'TaxController@searchUser']);
        });
        Route::group(['prefix' => 'coupons'], function() {
            Route::get('/', ['as' => 'admin.coupons.view', 'uses' => 'CouponsController@index']);
            Route::get('/add', ['as' => 'admin.coupons.add', 'uses' => 'CouponsController@addCoupon']);
            Route::post('/save', ['as' => 'admin.coupons.save', 'uses' => 'CouponsController@saveCoupon']);
            Route::get('/edit', ['as' => 'admin.coupons.edit', 'uses' => 'CouponsController@editCoupon']);
            Route::get('/history', ['as' => 'admin.coupons.history', 'uses' => 'CouponsController@couponHistory']);
            Route::get('/delete', ['as' => 'admin.coupons.delete', 'uses' => 'CouponsController@delete']);
            // Route::get('/search-user', ['as' => 'admin.coupons.searchUser', 'uses' => 'CouponsController@searchUser']);
        });

        Route::group(['prefix' => 'loyalty'], function() {
            Route::get('/', array('as' => 'admin.loyalty.view', 'uses' => 'LoyaltyController@index'));
            Route::get('/add', array('as' => 'admin.loyalty.add', 'uses' => 'LoyaltyController@add'));
            Route::post('/save', array('as' => 'admin.loyalty.save', 'uses' => 'LoyaltyController@save'));
            Route::get('/edit', array('as' => 'admin.loyalty.edit', 'uses' => 'LoyaltyController@edit'));
            Route::post('/update', array('as' => 'admin.loyalty.update', 'uses' => 'LoyaltyController@update'));
            Route::post('/delete', array('as' => 'admin.loyalty.delete', 'uses' => 'LoyaltyController@delete'));
        });
        Route::group(['prefix' => 'stock'], function() {
            Route::get('/', ['as' => 'admin.stock.view', 'uses' => 'StockController@index']);
            Route::get('/out-of-stock', ['as' => 'admin.stock.outOfStock', 'uses' => 'StockController@outOfStock']);
            Route::get('/running-short', ['as' => 'admin.stock.runningShort', 'uses' => 'StockController@runningShort']);
            Route::post('/update-prod-stock', ['as' => 'admin.stock.updateProdStock', 'uses' => 'StockController@updateProdStock']);
        });
        Route::group(['prefix' => 'tax'], function() {
            Route::get('/', ['as' => 'admin.tax.view', 'uses' => 'TaxController@index']);
            Route::get('/add', ['as' => 'admin.tax.add', 'uses' => 'TaxController@add']);
            Route::post('/save', ['as' => 'admin.tax.save', 'uses' => 'TaxController@save']);
            Route::get('/edit', ['as' => 'admin.tax.edit', 'uses' => 'TaxController@edit']);
            Route::post('/delete', ['as' => 'admin.tax.delete', 'uses' => 'TaxController@delete']);
            Route::get('/change-status', ['as' => 'admin.tax.changeStatus', 'uses' => 'TaxController@changeStatus']);
            //Route::get('/search-user', ['as' => 'admin.tax.searchUser', 'uses' => 'TaxController@searchUser']);
        });
        Route::group(['prefix' => 'acl'], function() {
            Route::group(['prefix' => 'roles'], function() {
                Route::get('/', ['as' => 'admin.roles.view', 'uses' => 'RolesController@index']);
                Route::get('/add', ['as' => 'admin.roles.add', 'uses' => 'RolesController@add']);
                Route::post('/save', ['as' => 'admin.roles.save', 'uses' => 'RolesController@save']);
                Route::get('/edit', ['as' => 'admin.roles.edit', 'uses' => 'RolesController@edit']);
                Route::get('/delete', ['as' => 'admin.roles.delete', 'uses' => 'RolesController@delete']);
            });
            Route::group(array('prefix' => 'customers'), function() {
                Route::get('/', array('as' => 'admin.customers.view', 'uses' => 'CustomersController@index'));
                Route::get('/add', array('as' => 'admin.customers.add', 'uses' => 'CustomersController@add'));
                Route::post('/save', array('as' => 'admin.customers.save', 'uses' => 'CustomersController@save'));
                Route::post('/edit', array('as' => 'admin.customers.edit', 'uses' => 'CustomersController@edit'));
                Route::post('/update', array('as' => 'admin.customers.update', 'uses' => 'CustomersController@update'));
                Route::get('/delete', array('as' => 'admin.customers.delete', 'uses' => 'CustomersController@delete'));
                Route::get('/export', ['as' => 'admin.customers.export', 'uses' => 'CustomersController@export']);
                Route::post('/chk-existing-useremail', ['as' => 'admin.customers.chkExistingUseremail', 'uses' => 'CustomersController@chkExistingUseremail']);
            });
            Route::group(['prefix' => 'systemusers'], function() {
                Route::post('/chk_existing_username', ['as' => 'chk_existing_username', 'uses' => 'SystemUsersController@chk_existing_username']);
                Route::get('/', ['as' => 'admin.systemusers.view', 'uses' => 'SystemUsersController@index']);
                Route::get('/add', ['as' => 'admin.systemusers.add', 'uses' => 'SystemUsersController@add']);
                Route::post('/save', ['as' => 'admin.systemusers.save', 'uses' => 'SystemUsersController@save']);
                Route::post('/edit', ['as' => 'admin.systemusers.edit', 'uses' => 'SystemUsersController@edit']);
                Route::post('/update', ['as' => 'admin.systemusers.update', 'uses' => 'SystemUsersController@update']);
                Route::post('/delete', ['as' => 'admin.systemusers.delete', 'uses' => 'SystemUsersController@delete']);
                Route::post('/export', ['as' => 'admin.systemusers.export', 'uses' => 'SystemUsersController@export']);
            });
        });
        Route::group(['prefix' => 'orders'], function() {
            Route::get('/', ['as' => 'admin.orders.view', 'uses' => 'OrdersController@index']);
            Route::get('/add', ['as' => 'admin.orders.add', 'uses' => 'OrdersController@add']);
            Route::get('/payment-status', ['as' => 'payment-status', 'uses' => 'OrdersController@paymentStatus']);
            Route::get('/payment-method', ['as' => 'payment-status', 'uses' => 'OrdersController@paymentMethod']);
            Route::post('/order-update-payment', ['as' => 'admin.orders.update.payment', 'uses' => 'OrdersController@updatePaymentStatus']);
        });
        Route::group(['prefix' => 'sales'], function() {
            Route::post('/by-order', array('as' => 'admin.sales.byorder', 'uses' => 'ApiSalesController@order'));
            Route::post('/by-customer', array('as' => 'admin.sales.bycustomer', 'uses' => 'ApiSalesController@bycustomer'));
        });

    });
});


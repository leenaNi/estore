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

Route::get('/', function () {
    return view('welcome');
});
 
Route::group(['namespace' => 'Admin'], function () {
  Route::post('/merchant-login', ["as" => "admin.merchant.login" ,"uses" => "ApiMerchantController@merchantLogin"]);
  Route::post('/merchant-fb-login', ["as" => "admin.merchant.fblogin" ,"uses" => "ApiMerchantController@FbMerchantLogin"]);
  Route::any('/merchant-forgot_password', ["as" => "admin.merchant.forgotPassword" ,"uses" => "ApiMerchantController@forgotPassword"]);
 
    Route::group(['prefix' => 'createStore'], function() {
            Route::get('/Sing-up-dropdown', array('as' => 'admin.createStore.signUpDropDown', 'uses' => 'ApiCreateStoreController@signUpDropDown'));
            Route::post('/fb-signup-check', array('as' => 'admin.createStore.fbSignUpCheck', 'uses' => 'ApiCreateStoreController@fbSignUpCheck'));
            Route::post('/save-sign-up', array('as' => 'admin.createStore.saveSignUp', 'uses' => 'ApiCreateStoreController@saveSignUp'));
            Route::post('/apply-store-theme', array('as' => 'admin.createStore.applyStoreTheme', 'uses' => 'ApiCreateStoreController@applyStoreTheme'));
            Route::post('/get-theme', array('as' => 'admin.createStore.getTheme', 'uses' => 'ApiCreateStoreController@getTheme'));
            Route::post('/check-domain', array('as' => 'admin.createStore.checkDomain', 'uses' => 'ApiCreateStoreController@checkDomain'));
            Route::post('/check-store', array('as' => 'admin.createStore.checkStore', 'uses' => 'ApiCreateStoreController@checkStore'));
            Route::post('/check-mobile', array('as' => 'admin.createStore.checkMobile', 'uses' => 'ApiCreateStoreController@checkMobile'));
            Route::any('/send-otp', array('as' => 'admin.createStore.sendOtp', 'uses' => 'ApiCreateStoreController@sendOtp'));
    }); 
        
   Route::group(['middleware' => ['jwt-auth']], function () {
     
            Route::group(['prefix' => 'merchants'], function () {
            Route::get('/', ["as" => "admin.merchants.view", "uses" => "MerchantController@index"]);
            Route::post('/device-register', ['as' => 'deviceRegister', 'uses' => 'LoginController@deviceRegister']);
            Route::get('/logout', ['as' => 'logout', 'uses' => 'LoginController@logout']);
            Route::get('/storeSetUp', ["as" => "admin.merchants.setup", "uses" => "MerchantController@storeSetUp"]);           
            Route::any('/storeSetUpSave', ["as" => "admin.merchants.setupSave", "uses" => "MerchantController@storeSetUpSave"]);           
            Route::post('/storeDesign', ["as" => "admin.merchants.setupDesign", "uses" => "MerchantController@storeDesign"]);           
            Route::post('/storeLogo', ["as" => "admin.merchants.storeLogo", "uses" => "MerchantController@storeLogo"]);           
            Route::post('/updateStoreLogo', ["as" => "admin.merchants.updateStoreLogo", "uses" => "MerchantController@updateStoreLogo"]);           
            Route::any('/getCategory', ["as" => "admin.merchants.getCategory", "uses" => "MerchantController@getCategory"]);           
            Route::any('/save-category', ["as" => "admin.merchants.saveCategory", "uses" => "MerchantController@saveCategory"]);           
            Route::any('/delete-category', ["as" => "admin.merchants.deleteCategory", "uses" => "MerchantController@deleteCategory"]);           
            Route::any('/viewStore', ["as" => "admin.merchants.viewStore", "uses" => "MerchantController@viewStore"]);           
            Route::any('/updateCategory', ["as" => "admin.merchants.updateCategory", "uses" => "MerchantController@updateCategory"]);           
            Route::any('/getContactInfo', ["as" => "admin.merchants.getContactInfo", "uses" => "MerchantController@getContactInfo"]);           
            Route::any('/updateContactInfo', ["as" => "admin.merchants.updateContactInfo", "uses" => "MerchantController@updateContactInfo"]);           
            Route::post('/updateStoreLogo', ["as" => "admin.merchants.updateStoreLogo", "uses" => "MerchantController@updateStoreLogo"]);           
            Route::get('/dashboard', ["as" => "admin.dashboard", "uses" => "LoginController@dashboard"]);
            Route::get('/add-edit', ["as" => "admin.merchants.addEdit", "uses" => "MerchantController@addEdit"]);
            Route::any('/save-update', ["as" => "admin.merchants.saveUpdate", "uses" => "MerchantController@saveUpdate"]);
            Route::any('/save-update-documents', ["as" => "admin.merchants.saveUpdateDocuments", "uses" => "MerchantController@saveUpdateDocuments"]);
            Route::get('/delete-document', ["as" => "admin.merchants.deleteDocument", "uses" => "MerchantController@deleteDocument"]);
            Route::get('/merchant-autocomplete', ["as" => "admin.merchants.merchantAutocomplete", "uses" => "MerchantController@merchantAutocomplete"]);
            Route::get('/feature-listing', ["as" => "admin.merchants.featureList", "uses" => "MerchantController@featureList"]);
            Route::get('/check-existing-merchant', ["as" => "admin.merchants.checkExistingMerchant", "uses" => "MerchantController@checkExistingMerchant"]);
            Route::post('/update-feature', ["as" => "admin.merchants.updateFeature", "uses" => "MerchantController@updateFeature"]);
            Route::get('/get-profile', ["as" => "admin.merchants.getProfile", "uses" => "ApiMerchantController@getProfile"]);
            Route::post('/update-profile', ["as" => "admin.merchants.updateProfile", "uses" => "ApiMerchantController@updateProfile"]);
            Route::get('/get-bank-details', ["as" => "admin.merchants.getBankDetails", "uses" => "ApiMerchantController@getBankDetails"]);
            Route::post('/update-bank-details', ["as" => "admin.merchants.updateBankDetails", "uses" => "ApiMerchantController@updateBankDetails"]);
            Route::post('/store-info', ["as" => "admin.merchants.storeInfo", "uses" => "MerchantController@storeInfo"]);
            Route::any('/get-courier', ["as" => "admin.merchants.getCourier", "uses" => "MerchantController@getCourier"]);
        });
        Route::group(['prefix' => 'stores'], function () {
            Route::get('/', ["as" => "admin.stores.view", "uses" => "StoreController@index"]);
            Route::any('/add-edit', ["as" => "admin.stores.addEdit", "uses" => "StoreController@addEdit"]);
            Route::any('/save-update-general', ["as" => "admin.stores.saveUpdateGeneral", "uses" => "StoreController@saveUpdateGeneral"]);
            Route::any('/save-update-contact', ["as" => "admin.stores.saveUpdateContact", "uses" => "StoreController@saveUpdateContact"]);
            Route::any('/save-update-business', ["as" => "admin.stores.saveUpdateBusiness", "uses" => "StoreController@saveUpdateBusiness"]);
            Route::any('/save-update-bank', ["as" => "admin.stores.saveUpdateBank", "uses" => "StoreController@saveUpdateBank"]);
            Route::any('/save-update-store-doc', ["as" => "admin.stores.saveUpdateStoreDoc", "uses" => "StoreController@saveUpdateStoreDoc"]);
            Route::any('/delete-store-document', ["as" => "admin.stores.deleteStoreDoc", "uses" => "StoreController@deleteStoreDoc"]);
            Route::any('/get-zone-dropdown/{id?}', ["as" => "admin.stores.getZoneDropdown", "uses" => "StoreController@getZoneDropdown"]);
            Route::any('/api-store-save-update', ["as" => "admin.api.stores.saveUpdate", "uses" => "StoreController@ApiStoreSaveUpdate"]);

            
        });   
        
        Route::group(['prefix' => 'products'], function () {
          Route::get('/', ['as' => 'admin.apiprod.view', 'uses' => 'ApiProductController@index']);
          Route::get('/categoryListing', ['as' => 'admin.apiprod.add', 'uses' => 'ApiProductController@categoryListing']);
          Route::post('/save', ['as' => 'admin.apiprod.save', 'uses' => 'ApiProductController@save']);
          Route::post('/save-config-prod', ['as' => 'admin.apiprod.saveConfigProd', 'uses' => 'ApiProductController@saveConfigProd']);
          Route::post('/get-config-product', ['as' => 'admin.apiprod.getConfigProduct', 'uses' => 'ApiProductController@getConfigProduct']);
          Route::post('/edit-product', ['as' => 'admin.apiprod.editProduct', 'uses' => 'ApiProductController@editProduct']);
          Route::post('/save-edit-variant', ['as' => 'admin.apiprod.saveEditVariant', 'uses' => 'ApiProductController@saveEditVariant']);
          Route::post('/delete', ['as' => 'admin.apiprod.delete', 'uses' => 'ApiProductController@delete']);
          Route::post('/delete-variant', ['as' => 'admin.apiprod.deleteVariant', 'uses' => 'ApiProductController@deleteVariant']);
          Route::post('/calculate-tax', ['as' => 'admin.apiprod.calculateTaxWithDis', 'uses' => 'ApiProductController@calculateTaxWithDis']);
          Route::get('/prodSeo', ['as' => 'admin.apiseo.view', 'uses' => 'ApiProductController@prodSeo']);
          Route::post('/prodSaveSeo', ['as' => 'admin.apiseo.save', 'uses' => 'ApiProductController@prodSaveSeo']);
          Route::get('/catSeo', ['as' => 'admin.apicat.catSeo', 'uses' => 'ApiProductController@catSeo']);
          Route::post('/catSeoSave', ['as' => 'admin.apicat.saveCatSeo', 'uses' => 'ApiProductController@catSeoSave']);

        }); 
        
          Route::group(['prefix' => 'order'], function () {
          Route::get('/', ['as' => 'admin.apiorder.view', 'uses' => 'ApiOrderController@index']);
          Route::post('/checkOut', ['as' => 'admin.apiorder.checkout', 'uses' => 'ApiOrderController@checkOut']);
          Route::any('/saveOrder', ['as' => 'admin.apiorder.saveOrder', 'uses' => 'ApiOrderController@saveOrder']);
          Route::any('/checkOutSaveOrder', ['as' => 'admin.apiorder.checkOutSaveOrder', 'uses' => 'ApiOrderController@checkOutSaveOrder']);
          Route::any('/returnOrder', ['as' => 'admin.apiorder.returnOrder', 'uses' => 'ApiOrderController@returnOrder']);
          Route::any('/editReturnOrder', ['as' => 'admin.apiorder.editReturnOrder', 'uses' => 'ApiOrderController@editReturnOrder']);
          Route::any('/cancelOrder', ['as' => 'admin.apiorder.cancelOrder', 'uses' => 'ApiOrderController@cancelOrder']);
          Route::any('/order-success-mail', ['as' => 'admin.apiorder.orderSuccessEmail', 'uses' => 'ApiOrderController@orderSuccessEmail']);
          Route::post('/update-payment-status', ['as' => 'admin.apiorder.updatePaymentStatus', 'uses' => 'ApiOrderController@updatePaymentStatus']);
          Route::post('/update-order-status', ['as' => 'admin.apiorder.updateOrderStatus', 'uses' => 'ApiOrderController@updateOrderStatus']);
          Route::any('/cal-aditional-charge', ['as' => 'admin.apiorder.calAditionalCharge', 'uses' => 'ApiOrderController@calAditionalCharge']);
          
        });  
        
          Route::group(['prefix' => 'systemUser'], function () {
          Route::get('/', ['as' => 'admin.apiuser.view', 'uses' => 'ApiUserController@index']);
          Route::get('/roles', ['as' => 'admin.apiuser.roles', 'uses' => 'ApiUserController@AddEdit']);
          Route::post('/saveAddEdit', ['as' => 'admin.apiuser.saveAddEdit', 'uses' => 'ApiUserController@saveAddEdit']);
          Route::post('/deleteSysUser', ['as' => 'admin.apiuser.deleteSysUser', 'uses' => 'ApiUserController@deleteSystemUser']);   
          Route::get('/getLoyalty', ['as' => 'admin.apiuser.getLoyalty', 'uses' => 'ApiUserController@getLoyalty']);
          Route::get('/getReferral', ['as' => 'admin.apiuser.getReferral', 'uses' => 'ApiUserController@getReferral']);
          Route::post('/updateReferral', ['as' => 'admin.apiuser.updateReferral', 'uses' => 'ApiUserController@updateReferral']);
          Route::post('/customerAddEdit', ['as' => 'admin.apiuser.customerAddEdit', 'uses' => 'ApiUserController@customerAddEdit']);
          Route::post('/delete-customer', ['as' => 'admin.apiuser.deleteCustomer', 'uses' => 'ApiUserController@deleteCustomer']);
          Route::get('/getCustomer', ['as' => 'admin.apiuser.getCustomer', 'uses' => 'ApiUserController@getCustomer']);
  
        }); 
        
          Route::group(['prefix' => 'coupons'], function() {
            Route::get('/', ['as' => 'admin.coupons.view', 'uses' => 'ApiCouponController@index']);
            Route::get('/add', ['as' => 'admin.coupons.add', 'uses' => 'ApiCouponController@addCoupon']);
            Route::post('/saveCoupon', ['as' => 'admin.coupons.save', 'uses' => 'ApiCouponController@saveCoupon']);
            Route::get('/editCoupon', ['as' => 'admin.coupons.edit', 'uses' => 'ApiCouponController@editCoupon']);
            Route::post('/check_coupon', ['as' => 'admin.coupons.checkCoupon', 'uses' => 'ApiCouponController@check_coupon']);
            Route::get('/delete', ['as' => 'admin.coupons.delete', 'uses' => 'ApiCouponController@delete']);
            Route::post('/loyalty-cashback', array('as' => 'admin.coupons.LoyaltyCashback', 'uses' => 'ApiCouponController@LoyaltyCashback'));
            Route::post('/revert-loyalty', array('as' => 'admin.coupons.revertLoyalty', 'uses' => 'ApiCouponController@revertLoyalty'));
            Route::post('/check-user-discount', array('as' => 'admin.coupons.checkUserdiscount', 'uses' => 'ApiCouponController@checkUserdiscount'));
            Route::post('/revert-user-discount', array('as' => 'admin.coupons.revertUserdiscount', 'uses' => 'ApiCouponController@revertUserdiscount'));
            Route::post('/tax-re-calculate', array('as' => 'admin.coupons.taxReCalculate', 'uses' => 'ApiCouponController@taxReCalculate'));
//            Route::get('/history', ['as' => 'admin.coupons.history', 'uses' => 'CouponsController@couponHistory']);
          
            // Route::get('/search-user', ['as' => 'admin.coupons.searchUser', 'uses' => 'CouponsController@searchUser']);
        });


            Route::group(['prefix' => 'newsletter'], function() {
              Route::get('/', ["as" => "admin.newsletter.view", "uses" => "ApiNewsletterController@index"]);
              Route::post('/saveNewsLetter', ["as" => "admin.newsletter.save", "uses" => "ApiNewsletterController@saveNewsLetter"]);
            });

            Route::group(['prefix' => 'smscampaign'], function() {
              Route::get('/', ["as" => "admin.smscampaign.view", "uses" => "ApiCampaignController@index"]);
              Route::post('/savesms', ["as" => "admin.smscampaign.save", "uses" => "ApiCampaignController@savesms"]);
            });
        
            Route::group(['prefix' => 'loyalty'], function() {
            Route::get('/', array('as' => 'admin.loyalty.view', 'uses' => 'ApiCouponController@getLoyalty'));
            Route::get('/add', array('as' => 'admin.loyalty.add', 'uses' => 'LoyaltyController@add'));
            Route::post('/saveLoyalty', array('as' => 'admin.loyalty.save', 'uses' => 'ApiCouponController@saveLoyalty'));
            Route::get('/editLoyalty', array('as' => 'admin.loyalty.edit', 'uses' => 'ApiCouponController@editLoyalty'));
            Route::post('/update', array('as' => 'admin.loyalty.update', 'uses' => 'LoyaltyController@update'));
            Route::post('/delete', array('as' => 'admin.loyalty.delete', 'uses' => 'LoyaltyController@delete'));
            Route::post('/loyalty-cashback', array('as' => 'admin.loyalty.LoyaltyCashback', 'uses' => 'LoyaltyController@LoyaltyCashback'));
        });
        
          Route::group(['prefix' => 'sales'], function() {
            Route::post('/by-order', array('as' => 'admin.sales.byorder', 'uses' => 'ApiSalesController@order'));
            Route::post('/by-product', array('as' => 'admin.sales.byproduct', 'uses' => 'ApiSalesController@byProduct'));
            Route::post('/by-customer', array('as' => 'admin.sales.bycustomer', 'uses' => 'ApiSalesController@byCustomer'));
            Route::post('/by-category', array('as' => 'admin.sales.bycategory', 'uses' => 'ApiSalesController@byCategory'));
            Route::post('/by-attribute', array('as' => 'admin.sales.byattribute', 'uses' => 'ApiSalesController@byAttribute'));
        });
        
           Route::group(['prefix' => 'tax'], function() {
            Route::get('/', array('as' => 'admin.tax.view', 'uses' => 'ApiUserController@getTax'));
            Route::post('/save-tax', array('as' => 'admin.tax.save', 'uses' => 'ApiUserController@saveTax'));
            Route::post('/delete-tax', array('as' => 'admin.tax.deleteTax', 'uses' => 'ApiUserController@deleteTax'));
        }); 
        
        Route::group(['prefix' => 'stock'], function() {
            Route::get('/', ['as' => 'admin.stock.view', 'uses' => 'StockController@index']);
            Route::get('/out-of-stock', ['as' => 'admin.stock.outOfStock', 'uses' => 'StockController@outOfStock']);
            Route::get('/running-short', ['as' => 'admin.stock.runningShort', 'uses' => 'StockController@runningShort']);
            Route::post('/update-prod-stock', ['as' => 'admin.stock.updateProdStock', 'uses' => 'StockController@updateProdStock']);
        });
            Route::group(['prefix' => 'miscellaneous'], function() {
            Route::get('/', ['as' => 'admin.miscellaneous.view', 'uses' => 'MiscellaneousController@contactListing']);
            Route::post('/contact-save', ['as' => 'admin.miscellaneous.saveUpdate', 'uses' => 'MiscellaneousController@saveUpdate']);
            Route::get('/aditional-charges', ['as' => 'admin.miscellaneous.aditionalCharges', 'uses' => 'MiscellaneousController@aditionalCharges']);
            Route::post('/aditional-charges-save', ['as' => 'admin.miscellaneous.aditionalChargesSave', 'uses' => 'MiscellaneousController@aditionalChargesSave']);
            Route::post('/aditional-charges-delete', ['as' => 'admin.miscellaneous.aditionalChargesDelete', 'uses' => 'MiscellaneousController@aditionalChargesDelete']);
            Route::get('/social-media-link', ['as' => 'admin.miscellaneous.socialMediaLink', 'uses' => 'MiscellaneousController@socialMediaLink']);
            Route::post('/social-media-update', ['as' => 'admin.miscellaneous.socialMediaUpdate', 'uses' => 'MiscellaneousController@socialMediaUpdate']);
            Route::get('/get-country', ['as' => 'admin.miscellaneous.getcountry', 'uses' => 'MiscellaneousController@getCountry']);
            Route::post('/get-state', ['as' => 'admin.miscellaneous.getState', 'uses' => 'MiscellaneousController@getState']);
            Route::post('/get-online-page', ['as' => 'admin.miscellaneous.getOnlinePage', 'uses' => 'MiscellaneousController@getOnlinePage']);
            Route::post('/update-online-page', ['as' => 'admin.miscellaneous.updateOnlinePage', 'uses' => 'MiscellaneousController@updateOnlinePage']);
            Route::get('/get-store-setting', ['as' => 'admin.miscellaneous.getStoreSetting', 'uses' => 'MiscellaneousController@getStoreSetting']);
            Route::post('/update-store-setting', ['as' => 'admin.miscellaneous.updateStoreSetting', 'uses' => 'MiscellaneousController@updateStoreSetting']);
            Route::post('/online-pages-with-key', ['as' => 'admin.miscellaneous.getContactDetails', 'uses' => 'MiscellaneousController@getContactDetails']);
            Route::get('/storeSeo', ['as' => 'admin.miscellaneous.seoview', 'uses' => 'MiscellaneousController@storeSeo']);
            Route::post('/storeSaveSeo', ['as' => 'admin.miscellaneous.seosave', 'uses' => 'MiscellaneousController@storeSaveSeo']);
        });
        
            Route::group(['prefix' => 'attributes'], function() {
            Route::get('/attribute-set', ['as' => 'admin.attributes.view', 'uses' => 'AttributeController@index']);
            Route::post('/attributeSet-save', ['as' => 'admin.attributes.attributeSetSave', 'uses' => 'AttributeController@attributeSetSave']);
            Route::post('/attributeSet-delete', ['as' => 'admin.attributes.attributeSetDelete', 'uses' => 'AttributeController@attributeSetDelete']);
            Route::get('/attribute-type', ['as' => 'admin.attributes.attributeType', 'uses' => 'AttributeController@attributeType']);
            Route::get('/get-attribute', ['as' => 'admin.attributes.getAttribute', 'uses' => 'AttributeController@attributes']);
            Route::post('/attribute-delete', ['as' => 'admin.attributes.attributeDelete', 'uses' => 'AttributeController@attributesDelete']);
            Route::post('/attribute-save', ['as' => 'admin.attributes.attributeSave', 'uses' => 'AttributeController@attributeSave']);
            Route::post('/attribute-options-delete', ['as' => 'admin.attributes.attributeOptionDelete', 'uses' => 'AttributeController@deleteAttributeOption']);
           
           
        });
       
        
   });


});

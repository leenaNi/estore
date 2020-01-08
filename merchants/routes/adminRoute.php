<?php

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['web']], function() { 
    Route::get('/', ["as" => "adminLogin", "uses" => "LoginController@index"]);
    Route::get('/unauthorized', ["as" => "unauthorized", "uses" => "LoginController@unauthorized"]);
    Route::post('/check-user', ["as" => "check_admin_user", "uses" => "LoginController@chk_admin_user"]);
    Route::post('/check-fb-user', ["as" => "check_fb_admin_user", "uses" => "LoginController@chk_fb_admin_user"]);
    Route::get('/admin-logout', ["as" => "adminLogout", "uses" => "LoginController@admin_logout"]);
    Route::any('/forgot-password', ["as" => "adminForgotPassword", "uses" => "LoginController@forgotPassword"]);
    Route::any('/forgot-password-check', ["as" => "adminChkForgotPasswordEmail", "uses" => "LoginController@chkForgotPasswordEmail"]);
    Route::any('/reset-password/{link?}', ["as" => "adminResetPassword", "uses" => "LoginController@adminResetNewPassword"]);
    Route::any('/save-resetPwd', ["as" => "adminSaveResetPwd", "uses" => "LoginController@adminSaveResetPwd"]);
    Route::any('/admin-edit-profile', ["as" => "adminEditProfile", "uses" => "LoginController@admin_edit_profile"]);
    Route::any('/admin-save-profile', ["as" => "adminSaveProfile", "uses" => "LoginController@admin_save_profile"]);
    Route::any('/check-cur-password', ["as" => "adminCheckCurPassowrd", "uses" => "LoginController@adminCheckCurPassowrd"]);
// Route::any('/newsletter',function(){
//              echo "test";
//          });
    Route::group(['middleware' => 'CheckUser', 'web'], function() {
        Route::get('/home', ["as" => "admin.home.view", "uses" => "HomeController@index"]);
//       
        Route::any('/newsletter', ["as" => "admin.home.newsletter", "uses" => "HomeController@newsLetter"]);
        Route::post('/saveNewsLetter', ["as" => "admin.home.saveNewsLetter", "uses" => "HomeController@saveNewsLetter"]);
        Route::any('/export-newsLetter', ["as" => "admin.home.exportNewsLetter", "uses" => "HomeController@exportNewsLetter"]);
        Route::get('/set-preference', ["as" => "admin.set.preference", "uses" => "HomeController@setPref"]);
        Route::post('/changePopupStatus', ["as" => "admin.home.changePopupStatus", "uses" => "HomeController@changePopupStatus"]);



        Route::get('/dashboard', ["as" => "admin.dashboard", "uses" => "PagesController@index"]);
        Route::post('/order-stat', ["as" => "admin.dashboard.orderStat", "uses" => "PagesController@orderStat"]);
        Route::post('/sales-stat', ["as" => "admin.dashboard.saleStat", "uses" => "PagesController@salesStat"]);
        Route::group(['prefix' => 'catalog', 'middlewareGroups' => ['CheckUser', 'web']], function() {
            Route::group(['prefix' => 'category', 'middlewareGroups' => ['web']], function() {
                Route::get('/', ['as' => 'admin.category.view', 'test' => 'test', 'uses' => 'CategoryController@index']);
                Route::get('/add', ['as' => 'admin.category.add', 'uses' => 'CategoryController@add']);
                Route::post('/save', ['as' => 'admin.category.save', 'uses' => 'CategoryController@save']);
                Route::get('/edit', ['as' => 'admin.category.edit', 'uses' => 'CategoryController@edit']);
                Route::any('/delete', ['as' => 'admin.category.delete', 'uses' => 'CategoryController@delete']);
                Route::get('/cat-seo', ['as' => 'admin.category.catSeo', 'uses' => 'CategoryController@catSeo']);
                Route::post('/cat-seo-save', ['as' => 'admin.category.saveCatSeo', 'uses' => 'CategoryController@saveCatSeo']);
                Route::any('/sample-category-download', ['as' => 'admin.category.sampleCategoryDownload', 'uses' => 'CategoryController@sampleCategoryDownload']);
                Route::any('/sample-bulk-download', ['as' => 'admin.category.sampleBulkDownload', 'uses' => 'CategoryController@sampleBulkDownload']);
                Route::any('/category-bulk-upload', ['as' => 'admin.category.categoryBulkUpload', 'uses' => 'CategoryController@categoryBulkUpload']);
                Route::any('/category-bulk-image-upload', ['as' => 'admin.category.catBulkImgUpload', 'uses' => 'CategoryController@catBulkImgUpload']);
                Route::any('/category-check', ['as' => 'admin.category.checkcat', 'uses' => 'CategoryController@checkCatName']);
                Route::any('/change-status', ['as' => 'admin.category.changeStatus', 'uses' => 'CategoryController@changeStatus']);
                 Route::any('/category-img-delete', ['as' => 'admin.category.catImgDelete', 'uses' => 'CategoryController@catImgDelete']);
                Route::any('/size-chart', ['as' => 'admin.category.sizeChart', 'uses' => 'CategoryController@sizeChart']);
            });

            Route::group(['prefix' => 'reviews', 'middlewareGroups' => ['web']], function() {
                Route::get('/', ['as' => 'admin.reviews.view', 'uses' => 'ReviewController@index']);
                Route::get('/get_review', array('as' => 'admin.custreview', 'uses' => 'ReviewController@get_review'));
                Route::any('/review-status', array('as' => 'admin.review.status', 'uses' => 'ReviewController@ReviewStatus'));
            });

            Route::group(['prefix' => 'attrSets', 'middlewareGroups' => ['web']], function() {
                Route::get('/', ['as' => 'admin.attribute.set.view', 'uses' => 'AttributeSetsController@index']);
                Route::get('/add', ['as' => 'admin.attribute.set.add', 'uses' => 'AttributeSetsController@add']);
                Route::post('/save', ['as' => 'admin.attribute.set.save', 'uses' => 'AttributeSetsController@save']);
                Route::get('/edit', ['as' => 'admin.attribute.set.edit', 'uses' => 'AttributeSetsController@edit']);
                Route::get('/delete', ['as' => 'admin.attribute.set.delete', 'uses' => 'AttributeSetsController@delete']);
                Route::post('/check', ['as' => 'admin.attribute.set.checkattrset', 'uses' => 'AttributeSetsController@checkExistingAttrSet']);
                Route::get('/change-status', ['as' => 'admin.attribute.set.changeStatus', 'uses' => 'AttributeSetsController@changeStatus']);
            });

            Route::group(['prefix' => 'attrs', 'middlewareGroups' => ['web']], function() {
                Route::get('/', ['as' => 'admin.attributes.view', 'uses' => 'AttributesController@index']);
                Route::get('/add', ['as' => 'admin.attributes.add', 'uses' => 'AttributesController@add']);
                Route::post('/save', ['as' => 'admin.attributes.save', 'uses' => 'AttributesController@save']);
                Route::get('/edit', ['as' => 'admin.attributes.edit', 'uses' => 'AttributesController@edit']);
                Route::get('/delete', ['as' => 'admin.attributes.delete', 'uses' => 'AttributesController@delete']);
                Route::post('/check', ['as' => 'admin.attributes.checkattr', 'uses' => 'AttributesController@checkExistingAttr']);
                Route::get('/change-status', ['as' => 'admin.attributes.changeStatus', 'uses' => 'AttributesController@changeStatus']);
            });

            Route::group(['prefix' => 'products', 'middlewareGroups' => ['web']], function() {
                Route::get('/', ['as' => 'admin.products.view', 'uses' => 'ProductsController@index']);
                Route::get('/add', ['as' => 'admin.products.add', 'uses' => 'ProductsController@add']);
                Route::get('/delete', ['as' => 'admin.products.delete', 'uses' => 'ProductsController@delete']);
                Route::get('/delete-varient', ['as' => 'admin.products.deleteVarient', 'uses' => 'ProductsController@deleteVarient']);
                Route::get('/change-status', ['as' => 'admin.products.changeStatus', 'uses' => 'ProductsController@changeStatus']);
                Route::post('/save', ['as' => 'admin.products.save', 'uses' => 'ProductsController@save']);
                Route::get('/edit-Info', ['as' => 'admin.products.general.info', 'uses' => 'ProductsController@edit']);
                Route::post('/update', array('as' => 'admin.products.update', 'uses' => 'ProductsController@update'));
                Route::get('/edit-cat', ['as' => 'admin.products.edit.category', 'uses' => 'ProductsController@edit_category']);
                Route::post('/update-edit-cat', array('as' => 'admin.products.update.category', 'uses' => 'ProductsController@update_edit_category'));
                Route::get('/duplicate-prod', ['as' => 'admin.products.duplicate', 'uses' => 'ProductsController@duplicate_prod']);
                Route::post('/update-combo', array('as' => 'admin.products.update.combo', 'uses' => 'ProductsController@update5'));
                Route::post('/combo-attach', array('as' => 'admin.products.update.combo.attach', 'uses' => 'ProductsController@comboAttach'));
                Route::post('/combo-detach', array('as' => 'admin.products.update.combo.detach', 'uses' => 'ProductsController@comboDetach'));
                Route::get('/catalog-images', ['as' => 'admin.products.images', 'uses' => 'ProductsController@img']);
                Route::post('/save-img', array('as' => 'admin.products.images.save', 'uses' => 'ProductsController@saveImg'));
                Route::post('/del-img', array('as' => 'admin.products.images.delete', 'uses' => 'ProductsController@delImg'));
                Route::get('/update-product-attr/{id}', array('as' => 'admin.products.attributes.update', 'uses' => 'ProductsController@prodAttrs'));
                Route::get('/config-product-attrs/{id}', array('as' => 'admin.products.configurable.attributes', 'uses' => 'ProductsController@configProdAttrs'));
                Route::post('/update-conf', array('as' => 'admin.products.configurable.update', 'uses' => 'ProductsController@update4'));
                Route::post('/update-conf-without-stock', array('as' => 'admin.products.configurable.update.without.stock', 'uses' => 'ProductsController@updateWithoutStock'));
                Route::get('/config-attrs-without-stock/{id}', array('as' => 'admin.products.configurable.without.stock.attributes', 'uses' => 'ProductsController@configProdAttrsWithoutStock'));
                Route::get('/comboProds/{id?}', array('as' => 'admin.combo.products.view', 'uses' => 'ProductsController@comboProds'));
                Route::get('/update-product-variant', array('as' => 'admin.products.variant.update', 'uses' => 'ProductsController@updateProdVariant'));
                Route::post('/update-attributes', array('as' => 'admin.products.attributes.update', 'uses' => 'ProductsController@update2'));
//            Route::get('/update-config-product-attr/{id}', array('as' => 'admin.products.configurable.edit.update', 'uses' => 'ProductsController@configProdAttrs'));
                Route::post('/update-related-upsell', array('as' => 'admin.products.upsell', 'uses' => 'ProductsController@update3'));
                Route::get('/update-related-upsell-products/{id}', array('as' => 'admin.products.upsell.related', 'uses' => 'ProductsController@updateRelatedUpsellProds'));
                Route::get('/update-upsell-products/{id}', array('as' => 'admin.products.upsell.product', 'uses' => 'ProductsController@updateUpsellProds'));
                Route::post('/rel-attach', array('as' => 'admin.products.related.attach', 'uses' => 'ProductsController@relAttach'));
                Route::any('/rel-detach', array('as' => 'admin.products.related.detach', 'uses' => 'ProductsController@relDetach'));
                Route::any('/admin-products-upsell-related-search', array('as' => 'admin.products.upsell.related.search', 'uses' => 'ProductsController@ProductsUpsellRelatedSearch'));
                Route::any('/admin-products-related-search', array('as' => 'admin.products.related.search', 'uses' => 'ProductsController@ProductsRelatedSearch'));
                Route::post('/upsell-attach', array('as' => 'admin.products.upsell.attach', 'uses' => 'ProductsController@upsellAttach'));
                Route::post('/upsell-detach', array('as' => 'admin.products.upsell.detach', 'uses' => 'ProductsController@upsellDetach'));
                Route::get('/product-attribute', ['as' => 'admin.products.attribute', 'uses' => 'ProductsController@attribute']);
                Route::post('/save-attribute', array('as' => 'admin.products.attribute.save', 'uses' => 'ProductsController@saveAttribute'));
                Route::get('/product-seo', ['as' => 'admin.products.prodSeo', 'uses' => 'ProductsController@prodSeo']);
                Route::post('/product-save-seo', ['as' => 'admin.products.prodSaveSeo', 'uses' => 'ProductsController@prodSaveSeo']);
                Route::get('/product-upload', ['as' => 'admin.products.prodUpload', 'uses' => 'ProductsController@prodUpload']);
                Route::post('/del-product-upload', ['as' => 'admin.products.prodUploadDel', 'uses' => 'ProductsController@prodUploadDel']);
                Route::post('/product-save-upload', ['as' => 'admin.products.prodSaveUpload', 'uses' => 'ProductsController@prodSaveUpload']);
                Route::any('/sample-bulk-download', ['as' => 'admin.products.sampleBulkDownload', 'uses' => 'ProductsController@sampleBulkDownload']);
                Route::any('/product-bulk-upload', ['as' => 'admin.products.productBulkUpload', 'uses' => 'ProductsController@productBulkUpload']);
                Route::any('/product-bulk-image-upload', ['as' => 'admin.products.prdBulkImgUpload', 'uses' => 'ProductsController@prdBulkImgUpload']);
                Route::any('/generate-barcode', ['as' => 'admin.products.generateBarcode', 'uses' => 'ProductsController@generateBarcode']);
                Route::any('/print-barcode', ['as' => 'admin.products.printBarcode', 'uses' => 'ProductsController@printBarcode']);
                Route::post('/barcode-form', ['as' => 'admin.products.barcodeForm', 'uses' => 'ProductsController@barcodeForm']);
                Route::post('/bulk-update', ['as' => 'admin.products.bulkUpdate', 'uses' => 'ProductsController@bulkUpdate']);
                Route::post('/product-export', ['as' => 'admin.products.export', 'uses' => 'ProductsController@exportExcel']);
                Route::get('/download-barcode', ['as' => 'admin.products.downloadbarcode', 'uses' => 'ProductsController@downloadbarcode']);
                Route::any('/show-barcodes', ['as' => 'admin.products.showbarcodes', 'uses' => 'ProductsController@showbarcodes']);
                Route::post('/check-product-attribute', ['as' => 'admin.products.checkattr', 'uses' => 'ProductsController@checkAttribute']);
                Route::any('/admin-product-vendors/{id}', array('as' => 'admin.product.vendors', 'uses' => 'ProductsController@productVendors'));
                Route::any('/admin-product-vendors-search', array('as' => 'admin.product.vendors.search', 'uses' => 'ProductsController@ProductVendorsSearch'));
                Route::post('/admin-product-vendors-save', array('as' => 'admin.product.vendors.save', 'uses' => 'ProductsController@ProductVendorsSave'));
                Route::get('/admin-product-wishlist', array('as' => 'admin.product.wishlist', 'uses' => 'ProductsController@exportWishlist'));
                Route::post('/admin-product-vendors-delete', array('as' => 'admin.product.vendors.delete', 'uses' => 'ProductsController@ProductVendorsDelete'));
                Route::post('/admin-product-mall-category', array('as' => 'admin.product.mall.category', 'uses' => 'ProductsController@getMallCategory'));
                Route::any('/admin-mall-product-add', array('as' => 'admin.product.mall.product.Add', 'uses' => 'ProductsController@mallProductAdd'));
                Route::post('/admin-mall-product-update', array('as' => 'admin.product.mall.product.update', 'uses' => 'ProductsController@mallProductUpdate'));
            });
        });

        Route::group(array('prefix' => 'dynamic-layout', 'middlewareGroups' => ['web']), function() {
            Route::any('/add-Edit', array('as' => 'admin.dynamic-layout.addEdit', 'uses' => 'DyLayoutController@addEdit'));
            Route::any('/save', array('as' => 'admin.dynamic-layout.save', 'uses' => 'DyLayoutController@saveUpdate'));
            Route::any('/edit', array('as' => 'admin.dynamic-layout.edit', 'uses' => 'DyLayoutController@edit'));
            Route::any('/saveEdit', array('as' => 'admin.dynamic-layout.saveEdit', 'uses' => 'DyLayoutController@saveEdit'));
            Route::any('/change_status', array('as' => 'admin.dynamic-layout.changeStatus', 'uses' => 'DyLayoutController@changeStatus'));
            Route::any('/{slug}', array('as' => 'admin.dynamic-layout.view', 'uses' => 'DyLayoutController@index'));
        });

        Route::group(['prefix' => 'campaign', 'middlewareGroups' => ['CheckUser', 'web']], function() {
            Route::get('/', ['as' => 'admin.campaign.view', 'uses' => 'CampaignController@index']);
            Route::get('/add', ['as' => 'admin.campaign.add', 'uses' => 'CampaignController@add']);
            Route::post('/save', ['as' => 'admin.campaign.save', 'uses' => 'CampaignController@save']);
            Route::get('/edit', ['as' => 'admin.campaign.edit', 'uses' => 'CampaignController@edit']);
            Route::get('/delete', ['as' => 'admin.campaign.delete', 'uses' => 'CampaignController@delete']);
            Route::post('/sendsms', ['as' => 'admin.campaign.sendsms', 'uses' => 'CampaignController@sendCampaignSMS']);

            Route::get('/viewemails', ['as' => 'admin.emailcampaign.viewemails', 'uses' => 'CampaignController@viewemails']);
            Route::get('/addemail', ['as' => 'admin.emailcampaign.addemail', 'uses' => 'CampaignController@addEmail']);
            Route::post('/saveemail', ['as' => 'admin.emailcampaign.saveemail', 'uses' => 'CampaignController@saveEmail']);
            Route::get('/editemail', ['as' => 'admin.emailcampaign.editemail', 'uses' => 'CampaignController@editEmail']);
            Route::get('/deleteemail', ['as' => 'admin.emailcampaign.deleteemail', 'uses' => 'CampaignController@deleteEmail']);
            Route::post('/sendemail', ['as' => 'admin.emailcampaign.sendemail', 'uses' => 'CampaignController@sendCampaignEmail']);
        });

        Route::group(['prefix' => 'coupons', 'middlewareGroups' => ['CheckUser', 'web']], function() {
            Route::get('/', ['as' => 'admin.coupons.view', 'uses' => 'CouponsController@index']);
            Route::get('/add', ['as' => 'admin.coupons.add', 'uses' => 'CouponsController@add']);
            Route::post('/save', ['as' => 'admin.coupons.save', 'uses' => 'CouponsController@save']);
            Route::get('/edit', ['as' => 'admin.coupons.edit', 'uses' => 'CouponsController@edit']);
            Route::get('/history', ['as' => 'admin.coupons.history', 'uses' => 'CouponsController@couponHistory']);
            Route::get('/delete', ['as' => 'admin.coupons.delete', 'uses' => 'CouponsController@delete']);
            Route::get('/search-user', ['as' => 'admin.coupons.searchUser', 'uses' => 'CouponsController@searchUser']);
            Route::post('/check', ['as' => 'admin.coupons.checkcoupon', 'uses' => 'CouponsController@checkExistingCode']);
            Route::get('/change-status', ['as' => 'admin.coupons.changeStatus', 'uses' => 'CouponsController@changeStatus']);
        });

        Route::group(['prefix' => 'stock', 'middlewareGroups' => ['CheckUser', 'web']], function() {
            Route::get('/', ['as' => 'admin.stock.view', 'uses' => 'StockController@index']);
            Route::get('/out-of-stock', ['as' => 'admin.stock.outOfStock', 'uses' => 'StockController@outOfStock']);
            Route::get('/running-short', ['as' => 'admin.stock.runningShort', 'uses' => 'StockController@runningShort']);
            Route::get('/running-short-count', ['as' => 'admin.stock.runningShortCount', 'uses' => 'StockController@runningShortCount']);
            Route::post('/update-prod-stock', ['as' => 'admin.stock.updateProdStock', 'uses' => 'StockController@updateProdStock']);
        });

        Route::group(['prefix' => 'tax', 'middlewareGroups' => ['CheckUser', 'web']], function() {
            Route::get('/', ['as' => 'admin.tax.view', 'uses' => 'TaxController@index']);
            Route::get('/add', ['as' => 'admin.tax.add', 'uses' => 'TaxController@add']);
            Route::post('/save', ['as' => 'admin.tax.save', 'uses' => 'TaxController@save']);
            Route::get('/edit', ['as' => 'admin.tax.edit', 'uses' => 'TaxController@edit']);
            Route::get('/delete', ['as' => 'admin.tax.delete', 'uses' => 'TaxController@delete']);
            Route::get('/change-status', ['as' => 'admin.tax.changeStatus', 'uses' => 'TaxController@changeStatus']);
            Route::any('/check-tax', ['as' => 'admin.tax.checktax', 'uses' => 'TaxController@checkTax']);
        });

        Route::group(['prefix' => 'order', 'middlewareGroups' => ['CheckUser', 'web']], function() {
            Route::get('/', ['as' => 'admin.order.view', 'uses' => 'OrderController@index']);
            Route::get('/edit', ['as' => 'admin.order.edit', 'uses' => 'OrderController@edit']);
            Route::get('/status', ['as' => 'admin.order.status', 'uses' => 'OrderController@orderStatus']);
        });

        Route::group(array('prefix' => 'tables', 'middlewareGroups' => ['web']), function() {
            Route::any('/', array('as' => 'admin.tables.view', 'uses' => 'TableController@index'));
            Route::any('/addEdit', array('as' => 'admin.tables.addEdit', 'uses' => 'TableController@addEdit'));
            Route::any('/save', array('as' => 'admin.tables.save', 'uses' => 'TableController@save'));
            Route::any('/delete', array('as' => 'admin.tables.delete', 'uses' => 'TableController@delete'));
            Route::any('/chage-status', array('as' => 'admin.tables.changeStatus', 'uses' => 'TableController@changeStatus'));
            Route::any('/chage-coupon', array('as' => 'admin.tables.checkCoupon', 'uses' => 'TableController@checkCoupon'));
            Route::any('/req-loyalty', array('as' => 'admin.tables.reqloyalty', 'uses' => 'TableController@reqLoyalty'));
            Route::any('/rev-loyalty', array('as' => 'admin.tables.revloyalty', 'uses' => 'TableController@revLoyalty'));
            Route::any('/table-cod', array('as' => 'admin.tables.tableCod', 'uses' => 'TableController@cashOnDelivary'));
            Route::any('/get-add-charge', array('as' => 'admin.tables.getAdditionalcharge', 'uses' => 'TableController@getAddCharges'));
        });
        Route::group(array('prefix' => 'restaurant-layout', 'middlewareGroups' => ['web']), function() {
            Route::any('/', array('as' => 'admin.restaurantlayout.view', 'uses' => 'TableController@layout'));
            Route::any('/addEdit', array('as' => 'admin.restaurantlayout.addEdit', 'uses' => 'TableController@layoutAddEdit'));
            Route::any('/save', array('as' => 'admin.restaurantlayout.save', 'uses' => 'TableController@layoutsave'));
        });

        Route::group(array('prefix' => 'table-orders', 'middlewareGroups' => ['web']), function() {
            Route::any('/', array('as' => 'admin.tableorder.view', 'uses' => 'TableController@orderview'));
            Route::any('/addEdit', array('as' => 'admin.tableorder.addEdit', 'uses' => 'TableController@layoutAddEdit'));
            Route::any('/save', array('as' => 'admin.tableorder.save', 'uses' => 'TableController@ordersave'));
            Route::any('/add-items/{id}', array('as' => 'admin.order.additems', 'uses' => 'TableController@additems'));
            Route::any('/save-items', array('as' => 'admin.order.saveitems', 'uses' => 'TableController@saveItems'));
            Route::any('/transfer-kot', array('as' => 'admin.order.transferKot', 'uses' => 'TableController@transferKot'));
            Route::any('/add-new-order', array('as' => 'admin.order.addNewOrder', 'uses' => 'TableController@addNewOrder'));
            Route::any('/get-join-table-checkbox', array('as' => 'admin.order.getJoinTableCheckbox', 'uses' => 'TableController@getJoinTableCheckbox'));
            Route::any('/save-join-table-order', array('as' => 'admin.order.saveJoinTableOrder', 'uses' => 'TableController@saveJoinTableOrder'));
            Route::any('/get-order-kot-prods', array('as' => 'admin.order.getOrderKotProds', 'uses' => 'TableController@getOrderKotProds'));
            Route::any('/get-occupied-table-order', array('as' => 'admin.tableOccupiedOrder', 'uses' => 'TableController@tableOccupiedOrder'));
            Route::any('/get-orderBill/{id?}', array('as' => 'admin.order.getbill', 'uses' => 'TableController@tableOccupiedOrderBill'));
            Route::any('/get-cart-amount', array('as' => 'admin.getCartAmt', 'uses' => 'TableController@getCartAmt'));

            Route::any('/delete-kot-prods', array('as' => 'admin.order.deleteKotProds', 'uses' => 'TableController@deleteKotProds'));
        });


        Route::group(['prefix' => 'orders', 'middlewareGroups' => ['CheckUser', 'web']], function() {
            Route::get('/', ['as' => 'admin.orders.view', 'uses' => 'OrdersController@index']);
            Route::get('/add', ['as' => 'admin.orders.add', 'uses' => 'OrdersController@add']);
            Route::any('/create-order', ['as' => 'admin.orders.createOrder', 'uses' => 'OrdersController@createOrder']);
            Route::any('/get-customer-emails', ['as' => 'admin.orders.getCustomerEmails', 'uses' => 'OrdersController@getCustomerEmails']);
            Route::any('/get-customer-data', ['as' => 'admin.orders.getCustomerData', 'uses' => 'OrdersController@getCustomerData']);
            Route::any('/get-customer-zone', ['as' => 'admin.orders.getCustomerZone', 'uses' => 'OrdersController@getCustomerZone']);
            Route::any('/get-customer-add', ['as' => 'admin.orders.getCustomerAdd', 'uses' => 'OrdersController@getCustomerAdd']);
            Route::any('/save-customer-add', ['as' => 'admin.orders.saveCustomerAdd', 'uses' => 'OrdersController@saveCustomerAdd']);

            Route::any('/get-cat-prods', ['as' => 'admin.orders.getSearchProds', 'uses' => 'OrdersController@getSearchProds']);

            Route::any('/get-sub-prods', ['as' => 'admin.orders.getSubProds', 'uses' => 'OrdersController@getSubProds']);
            Route::any('/save-cart-data', ['as' => 'admin.orders.saveCartData', 'uses' => 'OrdersController@saveCartData']);
            Route::any('/get-prod-price', ['as' => 'admin.orders.getProdPrice', 'uses' => 'OrdersController@getProdPrice']);

            Route::any('/order-invoice/{OrderIds?}', ['as' => 'admin.orders.invoice', 'uses' => 'OrdersController@invoice']);
            Route::post('/order-invoice-print', ['as' => 'admin.orders.invoice.print', 'uses' => 'OrdersController@setPrintInvoice']);
            Route::any('/order-export', ['as' => 'admin.orders.export', 'uses' => 'OrdersController@export']);
            Route::any('/order-sample-export', ['as' => 'admin.orders.sampleexport', 'uses' => 'OrdersController@exportsamplecsv']);
            Route::post('/order-update-payment', ['as' => 'admin.orders.update.payment', 'uses' => 'OrdersController@updatePaymentStatus']);
            Route::post('/order-update-status', ['as' => 'admin.orders.update.status', 'uses' => 'OrdersController@updateOrderStatus']);
            Route::post('/order-update-return-quantity', ['as' => 'admin.orders.update.return', 'uses' => 'OrdersController@updateRetutnQty']);
            Route::post('/order-revert-return-quantity', ['as' => 'admin.orders.revert.return', 'uses' => 'OrdersController@revertReturnQty']);
            Route::get('/order-update', ['as' => 'admin.orders.update', 'uses' => 'OrdersController@update']);
            Route::post('/save', ['as' => 'admin.orders.save', 'uses' => 'OrdersController@save']);
            Route::get('/edit', ['as' => 'admin.orders.edit', 'uses' => 'OrdersController@edit']);
            Route::get('/delete', ['as' => 'admin.orders.delete', 'uses' => 'OrdersController@delete']);
            Route::get('/return-order/{id}', ['as' => 'admin.orders.ReturnOrder', 'uses' => 'OrdersController@return_order']);
            Route::any('/return-order-cal', ['as' => 'admin.orders.ReturnOrderCal', 'uses' => 'OrdersController@return_order_cal']);
            Route::get('/order-return', ['as' => 'admin.orders.OrderReturn', 'uses' => 'OrdersController@order_return']);
            Route::any('/edit-return/{id}', ['as' => 'admin.orders.editreturn', 'uses' => 'OrdersController@editorder_return']);
            Route::any('/update-return-order-status', ['as' => 'admin.orders.UpdateReturnOrderStatus', 'uses' => 'OrdersController@update_return_order_status']);
            Route::post('/add-flag', ['as' => 'admin.orders.addFlag', 'uses' => 'OrdersController@addOrderFlag']);
            Route::post('/add-mul-flag', ['as' => 'admin.orders.addMulFlag', 'uses' => 'OrdersController@addMulFlag']);
            Route::get('/order-history', ['as' => 'admin.orders.orderHistory', 'uses' => 'OrdersController@orderHistory']);
            Route::get('/edit-re-order', ['as' => 'admin.orders.editReOrder', 'uses' => 'OrdersController@edit_re_order']);
            Route::any('/get-prod-details', ['as' => 'admin.orders.getProdDetails', 'uses' => 'OrdersController@get_prod_details']);
            Route::any('/quantity-update', ['as' => 'admin.orders.quantityUpdate', 'uses' => 'OrdersController@quantityUpdate']);
            Route::any('/save-re-order', ['as' => 'admin.orders.saveReOrder', 'uses' => 'OrdersController@save_re_order']);
            Route::any('/add-to-cart', ['as' => 'admin.orders.addToCart', 'uses' => 'OrdersController@add_to_cart']);
            Route::post('/check-order-coupon', ['as' => 'admin.orders.checkOrderCoupon', 'uses' => 'OrdersController@checkOrderCoupon']);
            Route::any('/waybill/{OrderIds?}', ['as' => 'admin.orders.waybill', 'uses' => 'OrdersController@waybill']);
            Route::post('/mallOrderSave', ['as' => 'admin.orders.mallOrderSave', 'uses' => 'OrdersController@mallOrderSave']);

            Route::post('/editOrderChkStock', ['as' => 'admin.orders.editOrderChkStock', 'uses' => 'OrdersController@editOrderChkStock']);
            Route::post('/getCartEditProd', ['as' => 'admin.orders.getCartEditProd', 'uses' => 'OrdersController@getCartEditProd']);
            Route::post('/getCartEditProdVar', ['as' => 'admin.orders.getCartEditProdVar', 'uses' => 'OrdersController@getCartEditProdVar']);
            Route::post('/cartEditGetComboSelect', ['as' => 'admin.orders.cartEditGetComboSelect', 'uses' => 'OrdersController@cartEditGetComboSelect']);

            Route::post('/applyCashback', ['as' => 'admin.orders.applyCashback', 'uses' => 'OrdersController@applyCashback']);
            Route::post('/applyVoucher', ['as' => 'admin.orders.applyVoucher', 'uses' => 'OrdersController@applyVoucher']);
            Route::post('/applyUserLevelDisc', ['as' => 'admin.orders.applyUserLevelDisc', 'uses' => 'OrdersController@applyUserLevelDisc']);
            Route::post('/applyReferel', ['as' => 'admin.orders.applyReferel', 'uses' => 'OrdersController@applyReferel']);
            Route::any("/cancel-order", ['as' => 'admin.orders.cancelOrder', 'uses' => 'CancelOrderController@index']);
            Route::any("/cancel-order-edit/{id}", ['as' => 'admin.orders.cancelOrderEdit', 'uses' => 'CancelOrderController@edit']);
            Route::any("/cancel-order-update", ['as' => 'admin.orders.cancelOrderUpdate', 'uses' => 'CancelOrderController@update']);

            //Get order payments
            Route::post('/get-payments', ['as' => 'admin.orders.getPayments', 'uses' => 'OrdersController@getPayments']);
            //for courier services
            Route::any("/get-e-courier", ['as' => 'admin.orders.getECourier', 'uses' => 'OrdersController@getECourier']);
        });

        Route::group(['prefix' => 'sales', 'middlewareGroups' => ['CheckUser', 'web']], function() {
            Route::get('/by-order', array('as' => 'admin.sales.byorder', 'uses' => 'SalesController@order'));
            Route::get('/by-product', array('as' => 'admin.sales.byproduct', 'uses' => 'SalesController@products'));
            Route::get('/by-category', array('as' => 'admin.sales.bycategory', 'uses' => 'SalesController@categories'));
            Route::post('/export-attr', array('as' => 'admin.sales.export.attribute', 'uses' => 'SalesController@attrExport'));
            Route::post('/export-cat', array('as' => 'admin.sales.export.category', 'uses' => 'SalesController@catExport'));
            Route::post('/export-prod', array('as' => 'admin.sales.export.product', 'uses' => 'SalesController@prodExport'));
            Route::any('/export-by-order', array('as' => 'admin.sales.export.order', 'uses' => 'SalesController@orderExport'));
            Route::any('/users-data', array('as' => 'admin.sales.users', 'uses' => 'SalesController@usersData'));
            Route::get('/by-attr', array('as' => 'admin.sales.byattribute', 'uses' => 'SalesController@attributes'));
            Route::any('/by-customer', array('as' => 'admin.sales.bycustomer', 'uses' => 'SalesController@bycustomer'));
            Route::any('/by-customer-chart', array('as' => 'admin.sales.bycustomerchart', 'uses' => 'SalesController@bycustomerChart'));


            Route::any('/order-by-customer/{id}', array('as' => 'admin.sales.orderByCustomer', 'uses' => 'SalesController@order_by_customer'));
            Route::any('/order-by-customer-export', array('as' => 'admin.sales.orderByCustomerExport', 'uses' => 'SalesController@order_by_customer_export'));
        });

        Route::group(['prefix' => 'offers', 'middlewareGroups' => ['CheckUser', 'web']], function() {
            Route::get('/', ['as' => 'admin.offers.view', 'uses' => 'OffersController@index']);
            Route::get('/add', ['as' => 'admin.offers.add', 'uses' => 'OffersController@add']);
            Route::post('/save', ['as' => 'admin.offers.save', 'uses' => 'OffersController@save']);
            Route::get('/edit', ['as' => 'admin.offers.edit', 'uses' => 'OffersController@edit']);
            Route::get('/delete', ['as' => 'admin.offers.delete', 'uses' => 'OffersController@delete']);
            Route::get('/search-user', ['as' => 'admin.offers.searchUser', 'uses' => 'OffersController@searchUser']);
        });

        Route::group(['prefix' => 'apicat'], function() {
            Route::get('/', ['as' => 'admin.apicat.view', 'uses' => 'ApiCatController@index']);
            Route::get('/add', ['as' => 'admin.apicat.add', 'uses' => 'ApiCatController@add']);
            Route::post('/save', ['as' => 'admin.apicat.save', 'uses' => 'ApiCatController@save']);
            Route::get('/edit', ['as' => 'admin.apicat.edit', 'uses' => 'ApiCatController@edit']);
            Route::get('/delete', ['as' => 'admin.apicat.delete', 'uses' => 'ApiCatController@delete']);
            Route::get('/cat-seo', ['as' => 'admin.apicat.catSeo', 'uses' => 'ApiCatController@catSeo']);
            Route::post('/cat-seo-save', ['as' => 'admin.apicat.saveCatSeo', 'uses' => 'ApiCatController@saveCatSeo']);
        });
        Route::group(['prefix' => 'apiprod'], function() {
            Route::get('/', ['as' => 'admin.apiprod.view', 'uses' => 'ApiProductController@index']);
            Route::get('/add', ['as' => 'admin.apiprod.add', 'uses' => 'ApiProductController@add']);
            Route::post('/save', ['as' => 'admin.apiprod.save', 'uses' => 'ApiProductController@save']);
            Route::get('/edit', ['as' => 'admin.apiprod.edit', 'uses' => 'ApiProductController@edit']);
            Route::get('/delete', ['as' => 'admin.apiprod.delete', 'uses' => 'ApiProductController@delete']);
            Route::get('/change-status', ['as' => 'admin.apiprod.changeStatus', 'uses' => 'ApiProductController@changeStatus']);

            //Route::get('/search-user', ['as' => 'admin.tax.searchUser', 'uses' => 'TaxController@searchUser']);
        });
        Route::group(['prefix' => 'international', 'middlewareGroups' => ['web']], function() {
            Route::group(['prefix' => 'country', 'middlewareGroups' => ['web']], function() {
                Route::get('/', ['as' => 'admin.country.view', 'uses' => 'InternationalController@country_list']);
                //Route::get('/add', ['as' => 'admin.paymentSetting.add', 'uses' => 'MiscellaneousController@paymentSettingAdd']);
                Route::get('/edit', ['as' => 'admin.country.edit', 'uses' => 'InternationalController@edit']);
                Route::post('/save', ['as' => 'admin.country.save', 'uses' => 'InternationalController@save']);
                Route::get('/delete', ['as' => 'admin.country.delete', 'uses' => 'InternationalController@delete']);
                Route::any('/country-status', ['as' => 'admin.country.countryStatus', 'uses' => 'InternationalController@countryStatus']);
            });

            Route::group(['prefix' => 'currency', 'middlewareGroups' => ['web']], function() {
                Route::get('/', ['as' => 'admin.currency.view', 'uses' => 'InternationalController@currencyListing']);
                Route::get('/edit-currency-listing/{id?}', ['as' => 'admin.currency.editCurrencyListing', 'uses' => 'InternationalController@editCurrencyListing']);
                Route::post('/save', ['as' => 'admin.currency.save', 'uses' => 'InternationalController@saveCurrencyListing']);
                Route::get('/currency-status', ['as' => 'admin.currency.currencyStatus', 'uses' => 'InternationalController@currencyStatus']);
            });
        });

        Route::group(['prefix' => 'acl', 'middlewareGroups' => ['CheckUser', 'web']], function() {
            Route::group(['prefix' => 'roles'], function() {
                Route::get('/', ['as' => 'admin.roles.view', 'uses' => 'RolesController@index']);
                Route::get('/add', ['as' => 'admin.roles.add', 'uses' => 'RolesController@add']);
                Route::post('/save', ['as' => 'admin.roles.save', 'uses' => 'RolesController@save']);
                Route::get('/edit', ['as' => 'admin.roles.edit', 'uses' => 'RolesController@edit']);
                Route::get('/delete', ['as' => 'admin.roles.delete', 'uses' => 'RolesController@delete']);
            });

            Route::group(array('prefix' => 'customers', 'middlewareGroups' => ['web']), function() {
                Route::get('/', array('as' => 'admin.customers.view', 'uses' => 'CustomersController@index'));
                Route::get('/add', array('as' => 'admin.customers.add', 'uses' => 'CustomersController@add'));
                Route::post('/save', array('as' => 'admin.customers.save', 'uses' => 'CustomersController@save'));
                Route::get('/edit', array('as' => 'admin.customers.edit', 'uses' => 'CustomersController@edit'));
                Route::post('/update', array('as' => 'admin.customers.update', 'uses' => 'CustomersController@update'));
                Route::get('/delete', array('as' => 'admin.customers.delete', 'uses' => 'CustomersController@delete'));
                Route::get('/change-status', array('as' => 'admin.customers.changeStatus', 'uses' => 'CustomersController@changeStatus'));
                Route::get('/export', ['as' => 'admin.customers.export', 'uses' => 'CustomersController@export']);
                Route::post('/chk-existing-useremail', ['as' => 'admin.customers.chkExistingUseremail', 'uses' => 'CustomersController@chkExistingUseremail']);
            });

            Route::group(array('prefix' => 'storecontacts', 'middlewareGroups' => ['web']), function() {
                Route::get('/', array('as' => 'admin.storecontacts.view', 'uses' => 'StoreContactsController@index')); 
                Route::get('/add', array('as' => 'admin.storecontacts.add', 'uses' => 'StoreContactsController@add'));
                Route::post('/save', array('as' => 'admin.storecontacts.save', 'uses' => 'StoreContactsController@save'));
                Route::get('/edit', array('as' => 'admin.storecontacts.edit', 'uses' => 'StoreContactsController@edit'));
                Route::post('/update', array('as' => 'admin.storecontacts.update', 'uses' => 'StoreContactsController@update'));
                Route::any('/import', array('as' => 'admin.storecontacts.import', 'uses' => 'StoreContactsController@import'));
                Route::get('/exportsamplecsv', ['as' => 'admin.storecontacts.exportsamplecsv', 'uses' => 'StoreContactsController@exportsamplecsv']);
                Route::get('/exportgroupcontacts', ['as' => 'admin.storecontacts.exportgroupcontacts', 'uses' => 'StoreContactsController@exportGroupContacts']);
                Route::any('/contactgroups', array('as' => 'admin.storecontacts.contactgroups', 'uses' => 'StoreContactsController@getContactGroups'));
                Route::post('/contactgroup', array('as' => 'admin.storecontacts.contactgroup', 'uses' => 'StoreContactsController@contactgroup')); 
                Route::post('/renamegroup', array('as' => 'admin.storecontacts.renamegroup', 'uses' => 'StoreContactsController@renameGroup')); 
            });

            Route::group(array('prefix' => 'loyalty', 'middlewareGroups' => ['web']), function() {
                Route::get('/', array('as' => 'admin.loyalty.view', 'uses' => 'LoyaltyController@index'));
                Route::get('/add', array('as' => 'admin.loyalty.add', 'uses' => 'LoyaltyController@add'));
                Route::post('/save', array('as' => 'admin.loyalty.save', 'uses' => 'LoyaltyController@save'));
                Route::get('/edit', array('as' => 'admin.loyalty.edit', 'uses' => 'LoyaltyController@edit'));
                Route::post('/update', array('as' => 'admin.loyalty.update', 'uses' => 'LoyaltyController@update'));
                Route::any('/delete', array('as' => 'admin.loyalty.delete', 'uses' => 'LoyaltyController@delete'));
                Route::any('/check-name', array('as' => 'admin.loyalty.checkName', 'uses' => 'LoyaltyController@checkName'));
                Route::any('/check-range', array('as' => 'admin.loyalty.checkRange', 'uses' => 'LoyaltyController@checkRange'));
                Route::get('/change-status', ['as' => 'admin.loyalty.changeStatus', 'uses' => 'LoyaltyController@changeStatus']);
            });

            Route::group(array('prefix' => 'testimonial', 'middlewareGroups' => ['web']), function() {
                Route::get('/', array('as' => 'admin.testimonial.view', 'uses' => 'TestimonialController@index'));
                Route::get('/delete', array('as' => 'admin.testimonial.delete', 'uses' => 'TestimonialController@delete'));
                Route::get('/addEdit', ['as' => 'admin.testimonial.addEdit', 'uses' => 'TestimonialController@addEdit']);
                Route::post('/save', ['as' => 'admin.testimonial.save', 'uses' => 'TestimonialController@save']);
                Route::get('/change-status', ['as' => 'admin.testimonial.changeStatus', 'uses' => 'TestimonialController@changeStatus']);
            });

            Route::group(['prefix' => 'dynamicLayout', 'middlewareGroups' => ['web']], function() {
                Route::get('/', ['as' => 'admin.dynamicLayout.view', 'uses' => 'DynamicLayoutController@index']);
                Route::get('/add', ['as' => 'admin.dynamicLayout.add', 'uses' => 'DynamicLayoutController@addEdit']);
                Route::get('/edit', ['as' => 'admin.dynamicLayout.edit', 'uses' => 'DynamicLayoutController@addEdit']);
                Route::post('/save', ['as' => 'admin.dynamicLayout.save', 'uses' => 'DynamicLayoutController@Save']);
                Route::get('/delete', ['as' => 'admin.dynamicLayout.delete', 'uses' => 'DynamicLayoutController@Delete']);
                Route::any('/dynamic-layout-change-status', ['as' => 'admin.dynamicLayout.changeStatus', 'uses' => 'DynamicLayoutController@changeStatus']);
            });

            Route::group(['prefix' => 'sizechart', 'middlewareGroups' => ['web']], function() {
                Route::get('/', ['as' => 'admin.sizechart.view', 'uses' => 'SizechartController@index']);
                Route::get('/add', ['as' => 'admin.sizechart.add', 'uses' => 'SizechartController@add']);
                Route::post('/save', ['as' => 'admin.sizechart.save', 'uses' => 'SizechartController@save']);
                Route::get('/edit', ['as' => 'admin.sizechart.edit', 'uses' => 'SizechartController@edit']);
                Route::get('/delete', ['as' => 'admin.sizechart.delete', 'uses' => 'SizechartController@delete']);
            });

            Route::group(array('prefix' => 'pincodes', 'middlewareGroups' => ['web']), function() {
                Route::any('/', array('as' => 'admin.pincodes.view', 'uses' => 'PincodeController@index'));
                Route::any('/uploadCsvPincode', array('as' => 'admin.pincodes.upload', 'uses' => 'PincodeController@upload_csv_pincode'));
                Route::any('/addEdit', array('as' => 'admin.pincodes.addEdit', 'uses' => 'PincodeController@addEdit'));
                Route::any('/save', array('as' => 'admin.pincodes.save', 'uses' => 'PincodeController@save'));
                Route::any('/cod_status', array('as' => 'admin.pincodes.codStatusChange', 'uses' => 'PincodeController@codStatusChange'));
                Route::any('/delivary_status', array('as' => 'admin.pincodes.delivaryStatusChange', 'uses' => 'PincodeController@delivaryStatusChange'));
                Route::any('/delete', array('as' => 'admin.pincodes.delete', 'uses' => 'PincodeController@delete'));
                Route::any('/import-csv-pincodes', array('as' => 'admin.pincodes.sampleBulkDownload', 'uses' => 'PincodeController@samplePincodeDownload'));
                Route::post('/export-csv-pincodes', array('as' => 'admin.pincodes.samplecsv', 'uses' => 'PincodeController@export_csv_pincode'));
                Route::any('/change_status', array('as' => 'admin.pincodes.changeStatus', 'uses' => 'PincodeController@changeStatus'));
            });

            Route::group(array('prefix' => 'smsSubscription', 'middlewareGroups' => ['web']), function() {
                Route::any('/', array('as' => 'admin.smsSubscription.view', 'uses' => 'SmsSubscriptionController@index'));
                Route::any('/addEdit', array('as' => 'admin.smsSubscription.addEdit', 'uses' => 'SmsSubscriptionController@addEdit'));
                Route::any('/save', array('as' => 'admin.smsSubscription.save', 'uses' => 'SmsSubscriptionController@save'));
                Route::any('/delete', array('as' => 'admin.smsSubscription.delete', 'uses' => 'SmsSubscriptionController@delete'));
            });

            Route::group(array('prefix' => 'language', 'middlewareGroups' => ['web']), function() {
                Route::any('/', array('as' => 'admin.language.view', 'uses' => 'LanguageController@index'));
                Route::any('/addEdit', array('as' => 'admin.language.addEdit', 'uses' => 'LanguageController@addEdit'));
                Route::any('/save', array('as' => 'admin.language.save', 'uses' => 'LanguageController@save'));
                Route::any('/delete', array('as' => 'admin.language.delete', 'uses' => 'LanguageController@delete'));
                Route::any('/chage-status', array('as' => 'admin.language.changeStatus', 'uses' => 'LanguageController@changeStatus'));
            });





            Route::group(array('prefix' => 'translation', 'middlewareGroups' => ['web']), function() {
                Route::any('/', array('as' => 'admin.translation.view', 'uses' => 'TranslationController@index'));
                Route::any('/addEdit', array('as' => 'admin.translation.addEdit', 'uses' => 'TranslationController@addEdit'));
                Route::any('/save', array('as' => 'admin.translation.save', 'uses' => 'TranslationController@save'));
                Route::any('/delete', array('as' => 'admin.translation.delete', 'uses' => 'TranslationController@delete'));
                Route::any('/chage-status', array('as' => 'admin.translation.changeStatus', 'uses' => 'TranslationController@changeStatus'));
            });

            Route::group(array('prefix' => 'state', 'middlewareGroups' => ['web']), function() {
                Route::any('/', array('as' => 'admin.state.view', 'uses' => 'StateController@index'));
                Route::any('/addEdit', array('as' => 'admin.state.addEdit', 'uses' => 'StateController@addEdit'));
                Route::any('/save', array('as' => 'admin.state.save', 'uses' => 'StateController@save'));
                Route::any('/delete', array('as' => 'admin.state.delete', 'uses' => 'StateController@delete'));
                Route::post('/getState', array('as' => 'admin.state.getState', 'uses' => 'StateController@getState'));
            });

            Route::group(array('prefix' => 'cities', 'middlewareGroups' => ['web']), function() {
                Route::any('/', array('as' => 'admin.cities.view', 'uses' => 'CityController@index'));
                Route::any('/addEdit', array('as' => 'admin.cities.addEdit', 'uses' => 'CityController@addEdit'));
                Route::any('/save', array('as' => 'admin.cities.save', 'uses' => 'CityController@save'));
                Route::any('/delete', array('as' => 'admin.cities.delete', 'uses' => 'CityController@delete'));
                Route::any('/change-status', array('as' => 'admin.cities.changeStatus', 'uses' => 'CityController@changeStatus'));
                Route::any('/delivary-status', array('as' => 'admin.cities.changeDelivaryStatus', 'uses' => 'CityController@changeDelivaryStatus'));
                Route::any('/cod-status', array('as' => 'admin.cities.changeCodStatus', 'uses' => 'CityController@changeCodStatus'));
            });


            Route::group(array('prefix' => 'slider', 'middlewareGroups' => ['web']), function() {
                Route::get('/', array('as' => 'admin.sliders.view', 'uses' => 'SliderController@index'));
                Route::get('/add', array('as' => 'admin.slider.add', 'uses' => 'SliderController@add'));
                Route::any('/edit', array('as' => 'admin.slider.edit', 'uses' => 'SliderController@edit'));
                Route::post('/save', array('as' => 'admin.slider.save', 'uses' => 'SliderController@save'));
                Route::post('/update', array('as' => 'admin.slider.update', 'uses' => 'SliderController@update'));
                Route::any('/delete', array('as' => 'admin.slider.delete', 'uses' => 'SliderController@delete'));
                Route::any('/change-status', array('as' => 'admin.slider.changestatus', 'uses' => 'SliderController@changeStatus'));

                Route::any('/list', array('as' => 'admin.slider.masterList', 'uses' => 'SliderController@list_slider'));
                Route::any('/add-slider', array('as' => 'admin.slider.addSlider', 'uses' => 'SliderController@add_slider'));
                Route::any('/edit-slider/{id}', array('as' => 'admin.slider.editSlider', 'uses' => 'SliderController@edit_slider'));
                Route::any('/slider-delete/{id}', array('as' => 'admin.slider.sliderDelete', 'uses' => 'SliderController@soft_delete'));
                Route::any('/save-edit-slider', array('as' => 'admin.slider.saveEditSlider', 'uses' => 'SliderController@save_edit_slider'));
                Route::any('/update-master-list', array('as' => 'admin.slider.updateMasterList', 'uses' => 'SliderController@updateMasterList'));
            });

            Route::group(['prefix' => 'Miscellaneous', 'middlewareGroups' => ['web']], function() {

                Route::group(['prefix' => 'GeneralSettings', 'middlewareGroups' => ['web']], function() {
                    Route::get('/', ['as' => 'admin.generalSetting.view', 'uses' => 'MiscellaneousController@generalSetting']);
                    Route::get('/add', ['as' => 'admin.generalSetting.add', 'uses' => 'MiscellaneousController@generalSettingAdd']);
                    Route::get('/edit', ['as' => 'admin.generalSetting.edit', 'uses' => 'MiscellaneousController@generalSettingEdit']);
                    Route::post('/save', ['as' => 'admin.generalSetting.save', 'uses' => 'MiscellaneousController@generalSettingSave']);
                    Route::get('/delete', ['as' => 'admin.generalSetting.delete', 'uses' => 'MiscellaneousController@generalSettingDelete']);
                    Route::any('/changeStatus', ['as' => 'admin.generalSetting.changeStatus', 'uses' => 'MiscellaneousController@changeStatus']);
                    Route::any('/assign-courier', ['as' => 'admin.generalSetting.assignCourier', 'uses' => 'MiscellaneousController@assignCourier']);
                    Route::any('/get-store-version', ['as' => 'admin.generalSetting.storeVersion', 'uses' => 'MiscellaneousController@storeVersion']);
                });

                Route::group(['prefix' => 'storeSettings', 'middlewareGroups' => ['web']], function() {
                    Route::get('/', ['as' => 'admin.storeSetting.view', 'uses' => 'MiscellaneousController@storeSetting']);
                    Route::any('/add', ['as' => 'admin.storeSetting.add', 'uses' => 'MiscellaneousController@generalStoreAdd']);
                });
                Route::group(['prefix' => 'domains', 'middlewareGroups' => ['web']], function() {
                    Route::get('/', ['as' => 'admin.domains.view', 'uses' => 'MiscellaneousController@domains']);
                    Route::get('/success', ['as' => 'admin.domains.success', 'uses' => 'MiscellaneousController@domain_success']);
                });
                Route::group(['prefix' => 'retunPolicy', 'middlewareGroups' => ['web']], function() {
                    Route::get('/', ['as' => 'admin.returnPolicy.view', 'uses' => 'MiscellaneousController@returnPolicy']);
                    Route::any('/edit', ['as' => 'admin.returnPolicy.edit', 'uses' => 'MiscellaneousController@returnPolicyEdit']);
                    Route::any('/save', ['as' => 'admin.returnPolicy.save', 'uses' => 'MiscellaneousController@returnPolicySave']);
                    Route::any('/changeStatus', ['as' => 'admin.returnPolicy.changeStatus', 'uses' => 'MiscellaneousController@changeStatus']);
                });

                Route::group(['prefix' => 'PaymentSetting', 'middlewareGroups' => ['web']], function() {
                    Route::get('/', ['as' => 'admin.paymentSetting.view', 'uses' => 'MiscellaneousController@paymentSetting']);
                    Route::get('/add', ['as' => 'admin.paymentSetting.add', 'uses' => 'MiscellaneousController@paymentSettingAdd']);
                    Route::get('/edit', ['as' => 'admin.paymentSetting.edit', 'uses' => 'MiscellaneousController@paymentSettingEdit']);
                    Route::any('/change-status', ['as' => 'admin.paymentSetting.changeStatus', 'uses' => 'MiscellaneousController@paymentSettingStatus']);
                    Route::post('/save', ['as' => 'admin.paymentSetting.save', 'uses' => 'MiscellaneousController@paymentSettingSave']);
                    Route::get('/delete', ['as' => 'admin.paymentSetting.delete', 'uses' => 'MiscellaneousController@paymentSettingDelete']);
                });

                Route::group(['prefix' => 'AdvanceSetting', 'middlewareGroups' => ['web']], function() {
                    Route::any('/', ['as' => 'admin.advanceSetting.view', 'uses' => 'MiscellaneousController@advanceSetting']);
                });
                Route::group(['prefix' => 'referralProgram', 'middlewareGroups' => ['web']], function() {
                    Route::any('/', ['as' => 'admin.referralProgram.view', 'uses' => 'MiscellaneousController@referralProgram']);
                    Route::any('/editReferral', ['as' => 'admin.referralProgram.editReferral', 'uses' => 'MiscellaneousController@editReferral']);
                    Route::any('/saveReferral', ['as' => 'admin.referralProgram.saveReferral', 'uses' => 'MiscellaneousController@saveReferral']);
                });
                Route::group(['prefix' => 'EmailSetting', 'middlewareGroups' => ['web']], function() {
                    Route::get('/', ['as' => 'admin.emailSetting.view', 'uses' => 'MiscellaneousController@emailSetting']);
                    Route::get('/add', ['as' => 'admin.emailSetting.add', 'uses' => 'MiscellaneousController@emailSettingAdd']);
                    Route::get('/edit', ['as' => 'admin.emailSetting.edit', 'uses' => 'MiscellaneousController@emailSettingEdit']);
                    Route::post('/save', ['as' => 'admin.emailSetting.save', 'uses' => 'MiscellaneousController@emailSettingSave']);
                    Route::get('/delete', ['as' => 'admin.emailSetting.delete', 'uses' => 'MiscellaneousController@emailSettingDelete']);
                    Route::get('/status', ['as' => 'admin.emailSetting.status', 'uses' => 'MiscellaneousController@emailSettingEmailStatus']);
                    Route::any('/change-status', ['as' => 'admin.email.status', 'uses' => 'MiscellaneousController@TemplateEmailStatus']);
                });

                Route::group(['prefix' => 'TemplateSetting'], function() {
                    Route::get('/', ['as' => 'admin.templateSetting.view', 'uses' => 'MiscellaneousController@templateSetting']);
                    Route::get('/add', ['as' => 'admin.templateSetting.add', 'uses' => 'MiscellaneousController@emailSettingAdd']);
                    Route::get('/edit', ['as' => 'admin.templateSetting.edit', 'uses' => 'MiscellaneousController@templateSettingEdit']);
                    Route::post('/save', ['as' => 'admin.templateSetting.save', 'uses' => 'MiscellaneousController@templateSettingSave']);
                    Route::get('/delete', ['as' => 'admin.templateSetting.delete', 'uses' => 'MiscellaneousController@emailSettingDelete']);
                    Route::get('/status', ['as' => 'admin.templateSetting.status', 'uses' => 'MiscellaneousController@emailSettingEmailStatus']);
                    Route::get('/send', ['as' => 'admin.templateSetting.status', 'uses' => 'MiscellaneousController@emailSend']);
                });
                Route::group(['prefix' => 'stockSetting'], function() {
                    Route::get('/', ['as' => 'admin.stockSetting.view', 'uses' => 'MiscellaneousController@stockSetting']);
                    Route::post('/save', ['as' => 'admin.stockSetting.save', 'uses' => 'MiscellaneousController@saveStockLimit']);
                });
                Route::group(['prefix' => 'bankDetails'], function() {
                    Route::get('/', ['as' => 'admin.bankDetails.view', 'uses' => 'MiscellaneousController@bankDetails']);
                    Route::get('/addEdit', ['as' => 'admin.bankDetails.addEdit', 'uses' => 'MiscellaneousController@addEditBankDetails']);
                    Route::post('/update', ['as' => 'admin.bankDetails.update', 'uses' => 'MiscellaneousController@updateBankDetails']);
                });
                Route::group(array('prefix' => 'flags'), function() {
                    Route::get('/', array('as' => 'admin.miscellaneous.flags', 'uses' => 'FlagController@index'));
                    Route::get('/add', array('as' => 'admin.miscellaneous.addNewFlag', 'uses' => 'FlagController@add'));
                    Route::get('/edit', array('as' => 'admin.miscellaneous.editFlag', 'uses' => 'FlagController@edit'));
                    Route::post('/save', array('as' => 'admin.miscellaneous.saveFlag', 'uses' => 'FlagController@save'));
                    Route::post('/update', array('as' => 'admin.miscellaneous.updateFlag', 'uses' => 'FlagController@update'));
                    Route::get('/delete', array('as' => 'admin.miscellaneous.deleteFlag', 'uses' => 'FlagController@delete'));
                });
                Route::group(array('prefix' => 'order_status'), function() {
                    Route::get('/', array('as' => 'admin.order_status.view', 'uses' => 'OrderStatusController@index'));
                    Route::get('/add', array('as' => 'admin.order_status.add', 'uses' => 'OrderStatusController@add'));
                    Route::get('/edit', array('as' => 'admin.order_status.edit', 'uses' => 'OrderStatusController@edit'));
                    Route::post('/save', array('as' => 'admin.order_status.save', 'uses' => 'OrderStatusController@save'));
                    Route::post('/update', array('as' => 'admin.order_status.update', 'uses' => 'OrderStatusController@update'));
                    Route::get('/delete', array('as' => 'admin.order_status.delete', 'uses' => 'OrderStatusController@delete'));
                    Route::get('/changeStatus', ['as' => 'admin.order_status.changeStatus', 'uses' => 'OrderStatusController@changeStatus']);
                });
            });

            Route::group(['prefix' => 'systemusers', 'middlewareGroups' => ['web']], function() {
                Route::post('/chk_existing_username', ['as' => 'chk_existing_username', 'uses' => 'SystemUsersController@chk_existing_username']);
                Route::get('/', ['as' => 'admin.systemusers.view', 'uses' => 'SystemUsersController@index']);
                Route::get('/add', ['as' => 'admin.systemusers.add', 'uses' => 'SystemUsersController@add']);
                Route::post('/save', ['as' => 'admin.systemusers.save', 'uses' => 'SystemUsersController@save']);
                Route::get('/edit', ['as' => 'admin.systemusers.edit', 'uses' => 'SystemUsersController@edit']);
                Route::post('/update', ['as' => 'admin.systemusers.update', 'uses' => 'SystemUsersController@update']);
                Route::get('/delete', ['as' => 'admin.systemusers.delete', 'uses' => 'SystemUsersController@delete']);
                Route::any('/export', ['as' => 'admin.systemusers.export', 'uses' => 'SystemUsersController@export']);
                Route::get('/system-change-status', ['as' => 'admin.systemusers.changeStatus', 'uses' => 'SystemUsersController@changeStatus']);
            });

            Route::group(['prefix' => 'staticpages', 'middlewareGroups' => ['web']], function() {
                Route::get('/', ['as' => 'admin.staticpages.view', 'uses' => 'StaticPageController@index']);
                Route::get('/add', ['as' => 'admin.staticpages.add', 'uses' => 'StaticPageController@add']);
                Route::post('/save', ['as' => 'admin.staticpages.save', 'uses' => 'StaticPageController@save']);
                Route::post('/update', ['as' => 'admin.staticpages.update', 'uses' => 'StaticPageController@update']);
                Route::get('/edit', ['as' => 'admin.staticpages.edit', 'uses' => 'StaticPageController@edit']);
                Route::get('/delete', ['as' => 'admin.staticpages.delete', 'uses' => 'StaticPageController@delete']);
                 Route::any('/staticpages-img-delete', ['as' => 'admin.staticpages.imgdelete', 'uses' => 'StaticPageController@imgDelete']);
                Route::get('/change-status', ['as' => 'admin.staticpages.changeStatus', 'uses' => 'StaticPageController@changeStatus']);
                Route::post('/get_description', ['as' => 'admin.staticpages.getdesc', 'uses' => 'StaticPageController@getDescription']);
            });
        });

        Route::group(['prefix' => 'contact', 'middlewareGroups' => ['CheckUser', 'web']], function() {
            Route::get('/', ['as' => 'admin.contact.view', 'uses' => 'ContactController@index']);
            Route::get('/add', ['as' => 'admin.contact.add', 'uses' => 'ContactController@add']);
            Route::post('/save', ['as' => 'admin.contact.save', 'uses' => 'ContactController@save']);
            Route::post('/update', ['as' => 'admin.contact.update', 'uses' => 'ContactController@update']);
            Route::get('/edit', ['as' => 'admin.contact.edit', 'uses' => 'ContactController@edit']);
            Route::get('/delete', ['as' => 'admin.contact.delete', 'uses' => 'ContactController@delete']);
            Route::any('/get-state', ['as' => 'admin.contact.getState', 'uses' => 'ContactController@getState']);
            Route::get('/change-status', ['as' => 'admin.contact.changeStatus', 'uses' => 'ContactController@changeStatus']);
        });

        Route::group(['prefix' => 'socialmedialink', 'middlewareGroups' => ['CheckUser', 'web']], function() {
            Route::get('/', ['as' => 'admin.socialmedialink.view', 'uses' => 'SocialMediaLinksController@index']);
            Route::get('/add', ['as' => 'admin.socialmedialink.add', 'uses' => 'SocialMediaLinksController@add']);
            Route::post('/save', ['as' => 'admin.socialmedialink.save', 'uses' => 'SocialMediaLinksController@save']);
            Route::post('/update', ['as' => 'admin.socialmedialink.update', 'uses' => 'SocialMediaLinksController@update']);
            Route::get('/edit', ['as' => 'admin.socialmedialink.edit', 'uses' => 'SocialMediaLinksController@edit']);
            Route::get('/delete', ['as' => 'admin.socialmedialink.delete', 'uses' => 'SocialMediaLinksController@delete']);
            Route::get('/change-status', ['as' => 'admin.socialmedialink.changeStatus', 'uses' => 'SocialMediaLinksController@changeStatus']);
        });

        Route::group(['prefix' => 'purchases', 'middlewareGroups' => ['web']], function() {
            Route::group(['prefix' => 'bills', 'middlewareGroups' => ['CheckUser', 'web']], function() {
                Route::get('/', ['as' => 'admin.bill.view', 'uses' => 'BillsController@index']);
                Route::get('/add', ['as' => 'admin.bill.add', 'uses' => 'BillsController@add']);
                Route::post('/save', ['as' => 'admin.bill.save', 'uses' => 'BillsController@save']);
                Route::post('/update', ['as' => 'admin.bill.update', 'uses' => 'BillsController@update']);
                Route::get('/edit', ['as' => 'admin.bill.edit', 'uses' => 'BillsController@edit']);
                Route::get('/delete', ['as' => 'admin.bill.delete', 'uses' => 'BillsController@delete']);
            });

            Route::group(['prefix' => 'vendors', 'middlewareGroups' => ['CheckUser', 'web']], function() {
                Route::get('/', ['as' => 'admin.vendors.view', 'uses' => 'VendorsController@index']);
                Route::get('/dashboard', ['as' => 'admin.vendors.dashboard', 'uses' => 'VendorsController@vendorDashboard']);
                Route::get('/add', ['as' => 'admin.vendors.add', 'uses' => 'VendorsController@add']);
                Route::post('/save', ['as' => 'admin.vendors.save', 'uses' => 'VendorsController@save']);
                Route::post('/update', ['as' => 'admin.vendors.update', 'uses' => 'VendorsController@update']);
                Route::get('/edit', ['as' => 'admin.vendors.edit', 'uses' => 'VendorsController@edit']);
                Route::get('/delete', ['as' => 'admin.vendors.delete', 'uses' => 'VendorsController@delete']);
                Route::get('/orders', ['as' => 'admin.vendors.orders', 'uses' => 'VendorsController@orders']);
                Route::get('/orders/order-details/{id}', ['as' => 'admin.vendors.ordersDetails', 'uses' => 'VendorsController@ordersDetails']);
                Route::post('/rejectOrders', ['as' => 'admin.vendors.rejectOrders', 'uses' => 'VendorsController@rejectOrders']);
                Route::get('/product', ['as' => 'admin.vendors.product', 'uses' => 'VendorsController@products']);
                Route::get('/productstatus/{id}', ['as' => 'admin.vendors.productStatus', 'uses' => 'VendorsController@productStatus']);
                Route::post('/productBulkAction', ['as' => 'admin.vendors.productBulkAction', 'uses' => 'VendorsController@productBulkAction']);
                Route::get('/sales/by-order', ['as' => 'admin.vendors.saleByOrder', 'uses' => 'VendorsController@saleByOrder']);
                Route::get('/sales/by-product', ['as' => 'admin.vendors.saleByProduct', 'uses' => 'VendorsController@saleByProduct']);
                Route::any('/export-by-order', array('as' => 'admin.vendor.export.order', 'uses' => 'VendorsController@orderExport'));
                Route::any('/update-order-status', array('as' => 'admin.vendor.order.status', 'uses' => 'VendorsController@updateOrderStatus'));
                // Route::post('/getState', ['as' => 'admin.vendors.state', 'uses' => 'VendorsController@getState']);
            });

            Route::group(['prefix' => 'purchase-requisition', 'middlewareGroups' => ['CheckUser', 'web']], function() {
                Route::get('/', ['as' => 'admin.requisition.view', 'uses' => 'PurchaseRequisitionController@index']);
                Route::get('/add', ['as' => 'admin.requisition.add', 'uses' => 'PurchaseRequisitionController@createOrder']);
                Route::get('/edit', ['as' => 'admin.requisition.edit', 'uses' => 'PurchaseRequisitionController@edit']);
                Route::get('/vieworder', ['as' => 'admin.requisition.vieworder', 'uses' => 'PurchaseRequisitionController@view']);

            });

            // Raw material
            Route::group(['prefix' => 'raw-material', 'middlewareGroups' => ['CheckUser', 'web']], function() {
                Route::get('/', ['as' => 'admin.raw-material.view', 'uses' => 'RawMaterialController@index']);
                Route::get('/add', ['as' => 'admin.raw-material.add', 'uses' => 'RawMaterialController@add']);
                Route::post('/save', ['as' => 'admin.raw-material.save', 'uses' => 'RawMaterialController@save']);
                Route::post('/update', ['as' => 'admin.raw-material.update', 'uses' => 'RawMaterialController@update']);
                Route::get('/edit', ['as' => 'admin.raw-material.edit', 'uses' => 'RawMaterialController@edit']);
                Route::get('/delete', ['as' => 'admin.raw-material.delete', 'uses' => 'RawMaterialController@delete']);
                // Route::post('/getState', ['as' => 'admin.vendors.state', 'uses' => 'VendorsController@getState']);
                Route::any('/check-status', ['as' => 'admin.raw-material.checkStatus', 'uses' => 'RawMaterialController@checkStatus']);
            });
        });

        Route::group(['prefix' => 'additional-charges', 'middlewareGroups' => ['CheckUser', 'web']], function() {
            Route::get('/', ['as' => 'admin.additional-charges.view', 'uses' => 'AdditionalChargesController@index']);
            Route::get('/add', ['as' => 'admin.additional-charges.add', 'uses' => 'AdditionalChargesController@add']);
            Route::post('/save', ['as' => 'admin.additional-charges.save', 'uses' => 'AdditionalChargesController@save']);
            Route::get('/edit', ['as' => 'admin.additional-charges.edit', 'uses' => 'AdditionalChargesController@edit']);
            Route::get('/delete', ['as' => 'admin.additional-charges.delete', 'uses' => 'AdditionalChargesController@delete']);
            Route::get('/change-status', ['as' => 'admin.additional-charges.changeStatus', 'uses' => 'AdditionalChargesController@changeStatus']);
            Route::post('/get-additional-charge', ['as' => 'admin.additional-charges.getAditionalCharge', 'uses' => 'AdditionalChargesController@getAditionalCharge']);
        });

        Route::group(['prefix' => 'section', 'middlewareGroups' => ['CheckUser', 'web']], function() {
            Route::get('/', ['as' => 'admin.section.view', 'uses' => 'SectionController@index']);
            Route::get('/add', ['as' => 'admin.section.add', 'uses' => 'SectionController@add']);
            Route::post('/save', ['as' => 'admin.section.save', 'uses' => 'SectionController@save']);
            Route::post('/update', ['as' => 'admin.section.update', 'uses' => 'SectionController@update']);
            Route::get('/edit', ['as' => 'admin.section.edit', 'uses' => 'SectionController@edit']);
            Route::get('/delete', ['as' => 'admin.section.delete', 'uses' => 'SectionController@delete']);
            // Route::post('/getState', ['as' => 'admin.vendors.state', 'uses' => 'VendorsController@getState']);
        });

        Route::group(['prefix' => 'courier-service', 'middlewareGroups' => ['CheckUser', 'web']], function() {
            Route::get('/', ['as' => 'admin.courier.view', 'uses' => 'CourierController@index']);
            Route::get('/add', ['as' => 'admin.courier.add', 'uses' => 'CourierController@add']);
            Route::post('/save', ['as' => 'admin.courier.save', 'uses' => 'CourierController@save']);
            Route::post('/update', ['as' => 'admin.courier.update', 'uses' => 'CourierController@update']);
            Route::get('/edit', ['as' => 'admin.courier.edit', 'uses' => 'CourierController@edit']);
            Route::get('/delete', ['as' => 'admin.courier.delete', 'uses' => 'CourierController@delete']);
            Route::any('/changeStatus', ['as' => 'admin.courier.changeStatus', 'uses' => 'CourierController@changeStatus']);
        });

        Route::group(['prefix' => 'marketing', 'middlewareGroups' => ['CheckUser', 'web']], function() {
            Route::get('/emails', ['as' => 'admin.marketing.emails', 'uses' => 'MarketingEmailsController@emails']);
            Route::get('/add-group', ['as' => 'admin.marketing.addGroup', 'uses' => 'MarketingEmailsController@addGroup']);
            Route::get('/edit-group', ['as' => 'admin.marketing.editGroup', 'uses' => 'MarketingEmailsController@editGroup']);
            Route::post('/save-group', ['as' => 'admin.marketing.saveGroup', 'uses' => 'MarketingEmailsController@saveGroup']);
            Route::get('/change-status', ['as' => 'admin.marketing.changeStatus', 'uses' => 'MarketingEmailsController@changeStatus']);
            Route::get('/email-group', ['as' => 'admin.marketing.groups', 'uses' => 'MarketingEmailsController@emailGroups']);
            Route::group(['prefix' => 'email-template'], function() {
                Route::get('/', ['as' => 'admin.marketing.emailTemplates', 'uses' => 'MarketingEmailsController@emailTemplates']);
                Route::get('/change-temp-status', ['as' => 'admin.marketing.changeTempStatus', 'uses' => 'MarketingEmailsController@changeTempStatus']);
                Route::get('/add-email-temp', ['as' => 'admin.marketing.addEmailTemp', 'uses' => 'MarketingEmailsController@addEmailTemp']);
                Route::get('/edit-email-temp', ['as' => 'admin.marketing.editEmailTemp', 'uses' => 'MarketingEmailsController@editEmailTemp']);
                Route::post('/save-email-temp', ['as' => 'admin.marketing.saveEmailTemp', 'uses' => 'MarketingEmailsController@saveEmailTemp']);
            });
        });

        Route::group(['prefix' => 'report', 'middlewareGroups' => ['CheckUser', 'web']], function() {
            Route::get('/orders', ['as' => 'admin.report.ordersIndex', 'uses' => 'ReportController@ordersIndex']);
            Route::get('/product', ['as' => 'admin.report.productIndex', 'uses' => 'ReportController@productIndex']);
            Route::get('/category-wise', ['as' => 'admin.report.categoryWise', 'uses' => 'ReportController@categoryWise']);
            Route::any('/order-index-export', array('as' => 'admin.report.orderIndexExport', 'uses' => 'ReportController@ordersIndexExport'));
            Route::any('/product-index-export', array('as' => 'admin.report.productIndexExport', 'uses' => 'ReportController@productIndexExport'));
            });
    });

    Route::group(['prefix' => 'route-list', 'middlewareGroups' => ['CheckUser', 'web']], function() {
        Route::get('/', ['as' => 'admin.pages.view', 'uses' => 'PagesController@pages']);
    });
    Route::group(['prefix' => 'traits'], function() {
        Route::any('/orders', ['uses' => 'OrdersController@bulkUpload', 'as' => 'admin.traits.orders']);
    });
});

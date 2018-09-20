<?php

Route::group(['namespace' => 'Cron', 'prefix' => 'cron', 'middleware' => ['web']], function() {
    Route::group(['prefix' => 'loyalty','middleware' => ['web']], function() {
        Route::any('/user-loyalty-cron', ["as" => "cron.loyalty.UserLoyaltyCron", "uses" => "LoyaltyController@indexCron"]);
//        Route::any('/user-referral-cron', ["as" => "cron.loyalty.checkReferal", "uses" => "LoyaltyController@checkReferal"]);
    });
});

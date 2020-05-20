<?php

Route::group(['namespace' => 'Cron', 'prefix' => 'cron', 'middleware' => ['web']], function() {
//       Route::any('/user-check', function(){
//           echo "fwerewrwe";
//       });
    Route::group(['prefix' => 'currencyUpdate','middleware' => ['web']], function() {
        Route::any('/update-currency-cron', ["as" => "cron.CurrencyUpdate.UpdateCurrencyCron", "uses" => "UpdateCurrencyController@index"]);
    
    });
});
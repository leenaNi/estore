<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class ReturnOrder extends Model {

    protected $table = 'return_order';

    function reason() {
        return $this->belongsTo('App\Models\OrderReturnReason')->select('id', 'reason');
    }
    function exchangeProduct(){
        return $this->belongsTo('App\Models\Product','exchange_product_id','id');
    }
    function opened() {
        return $this->belongsTo('App\Models\OrderReturnOpenUnopen')->select('id', 'status');
    }
    
    function product_id() {
        return $this->belongsTo('App\Models\Product', 'product_id')->select('id', 'product', 'product_code');
    }
    function products() {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }
    
    function return_status_id() {
        return $this->belongsTo('App\Models\OrderReturnStatus', 'return_status')->select('id', 'status');
    }

    function order_id() {
        return $this->belongsTo('App\Models\Order', 'order_id')->select('id', 'first_name', 'last_name', 'address1', 'address2', 'address3', 'phone_no', 'country_id', 'zone_id', 'postal_code', 'city', 'user_id');
    }
    
    

}

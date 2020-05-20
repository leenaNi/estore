<?php

namespace App\Models;

use Conner\Tagging\TaggableTrait;

class Offer extends \Eloquent {

    protected $table = 'offers';
    protected $fillable = ['id', 'offer_name', 'offer_discount_type', 'offer_type', 'offer_discount_value', 'min_order_qty', 'min_free_qty', 'min_order_amt', 'max_discount_amt', 'max_usage', 'actual_usage', 'full_incremental_order', 'start_date', 'end_date', 'user_specific', 'status', 'created_at'];

    public function categories() {
        return $this->belongsToMany('App\Models\Category', 'offers_categories', 'offer_id', 'cat_id');
    }
    
    public function products() {
        return $this->belongsToMany('App\Models\Product', 'offers_products', 'offer_id', 'prod_id');
    }
    
    public function userspecific() {
        return $this->belongsToMany('App\Models\User', 'offers_users', 'offer_id', 'user_id');
    }
    
}

<?php

namespace App\Models;

use Conner\Tagging\TaggableTrait;

class Coupon extends \Eloquent {


    protected $table = 'coupons';
    protected $fillable = ['id', 'coupon_name', 'coupon_code', 'discount_type', 'coupon_value', 'min_order_amt', 'coupon_type', 'coupon_image', 'coupon_desc', 'no_times_allowed', 'start_date', 'end_date', 'user_specific'];

    public function categories() {
        return $this->belongsToMany('App\Models\Category', 'coupons_categories', 'c_id', 'cat_id');
    }
    
    public function products() {
        return $this->belongsToMany('App\Models\Product', 'coupons_products', 'c_id', 'prod_id');
    }
    
    public function userspecific() {
        return $this->belongsToMany('App\Models\User', 'coupons_users', 'c_id', 'user_id');
    }
    
}

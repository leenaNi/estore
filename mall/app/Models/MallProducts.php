<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MallProducts extends Model {

    protected $table = 'mall_products';

    public function categories() {
        return $this->belongsToMany('App\Models\MallProdCategory', 'has_categories', 'prod_id', 'cat_id');
    }
    public function wishlist() {
        return $this->belongsToMany('App\Models\User', 'wishlist', 'prod_id', 'user_id');
    }
}

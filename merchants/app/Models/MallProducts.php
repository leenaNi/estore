<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MallProducts extends Model {

    protected $connection = 'mysql2';
    protected $table = 'mall_products';

    public function mallcategories() {
        return $this->belongsToMany('App\Models\MallProdCategory', 'has_categories', 'prod_id', 'cat_id');
    }

}

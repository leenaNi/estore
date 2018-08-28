<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Baum\Node;

class MallProdCategory extends Node {
   
    
    protected $connection = 'mysql2';
    protected $table = 'mall_prod_categories';
    
    public function children() {
        return $this->hasMany('App\Models\MallProdCategory', 'parent_id', 'id')->where('status', 1);
    }
    public function adminChildren() {
        return $this->hasMany('App\Models\MallProdCategory', 'parent_id', 'id');
    }

    
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Conner\Tagging\TaggableTrait;
use Kyslik\ColumnSortable\Sortable;

class MallProducts extends Model {

    protected $table = 'mall_products';

    use Sluggable,
        \Conner\Tagging\Taggable,
        Sortable;

    public function sluggable() {
        return [
            'url_key' => [
                'source' => 'product',
                'separator' => '-',
                'includeTrashed' => true,
            ]
        ];
    }

    public $sortable = ['id', 'product', 'product_code', 'price', 'prod_type', 'spl_price', 'stock'];

    public function mallcategories() {
        return $this->belongsToMany('App\Models\MallProdCategory', 'has_categories', 'prod_id', 'cat_id');
    }

    public function categories() {
        return $this->belongsToMany('App\Models\MallProdCategory', 'has_categories', 'prod_id', 'cat_id');
    }

    public function subproducts() {
        return $this->hasMany('App\Models\MallProducts', 'parent_prod_id')->where('status', 1);
    }

}

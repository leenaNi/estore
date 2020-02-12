<?php

namespace App\Models;

use Baum\Node;
use Cviebrock\EloquentSluggable\Sluggable;

class StoreCategory extends Node
{

    protected $table = 'store_categories';

    use Sluggable;

    public function sluggable()
    {
        return [
            'url_key' => [
                'source' => 'category',
                'separator' => '-',
                'includeTrashed' => true,
            ],
        ];
    }
    protected $orderColumn = "sort_order";

    public function categoryName()
    {
        return $this->belongsTo('App\Models\MasterCategory', 'category_id', 'id');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'has_categories', 'cat_id', 'prod_id');
    }

    public function catimgs()
    {
        return $this->hasMany('App\Models\CatalogImage', 'catalog_id')->where("image_type", 2);
    }

    public function children()
    {
        return $this->hasMany('App\Models\Category', 'parent_id', 'id')->where('status', 1);
    }
    public function adminChildren()
    {
        return $this->hasMany('App\Models\Category', 'parent_id', 'id');
    }

    public function cat_tax()
    {
        return $this->belongsToMany('App\Models\Tax', 'has_taxes', 'category_id', 'tax_id');
    }

    public function parent()
    {
        return $this->belongsTo('App\Models\Category', 'parent_id');

    }

}
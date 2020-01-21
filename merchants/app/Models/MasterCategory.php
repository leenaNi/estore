<?php

namespace App\Models;

use Baum\Node;
use Cviebrock\EloquentSluggable\Sluggable;

class MasterCategory extends Node
{

    protected $table = 'categories';

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

    public function children()
    {
        return $this->hasMany('App\Models\Category', 'parent_id', 'id')->where('status', 1);
    }
    public function adminChildren()
    {
        return $this->hasMany('App\Models\Category', 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo('App\Models\Category', 'parent_id');

    }

}

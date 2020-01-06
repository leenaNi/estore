<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Library\Helper;

class Newsletter extends Model {

    protected $table = 'newsletter';
//    protected $fillable = ['title', 'image', 'is_active', 'sub_title', 'link', 'sort_order', 'alt'];
//    public $timestamps = false;

    public function newQuery($excludeDeleted = true)
    {
        return parent::newQuery($excludeDeleted = true)
            ->where('store_id', Helper::getSettings()['store_id']);
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryRequested extends Model {

    protected $table = 'temp_categories';

    public function requestedBy() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function parent() {
        return $this->belongsTo('App\Models\CategoryMaster', 'parent_id');
    }
    

}

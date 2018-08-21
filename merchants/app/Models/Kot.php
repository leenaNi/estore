<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Kot extends Model {

    protected $table = 'kot';
   public $timestamps = false;
    public function products() {
        return $this->hasMany('App\Models\HasProducts', 'kot');
    }
    
    public function order() {
        return $this->hasMany('App\Models\Order', 'order_id');
    }

}

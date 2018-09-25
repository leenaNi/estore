<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasCourier extends Model
{
   protected $connection = 'mysql2';
    protected $table = 'has_couriers';
    
     public function couriername() {
        return $this->belongsTo('App\Models\Courier', 'courier_id');
    }
}

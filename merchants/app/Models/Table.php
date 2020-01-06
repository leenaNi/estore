<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $table='restaurant_tables';
    protected $guarded = [];
    
     public function tablestatus() {
        return $this->belongsTo('App\Models\TableStatus', 'ostatus');
    }
    
    public function orders(){
          return $this->hasMany('App\Models\Order', 'table_id');
    }
    
}

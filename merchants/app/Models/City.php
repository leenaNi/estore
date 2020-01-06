<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
     protected $table='cities';
     
     public function state(){
         
       return $this->belongsTo('App\models\State','state_id');  
     }
}

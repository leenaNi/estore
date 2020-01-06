<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\Library\Helper;

class City extends Model
{
     protected $table='cities';
     
     public function newQuery($excludeDeleted = true)
     {
         return parent::newQuery($excludeDeleted = true)
             ->where('store_id', Helper::getSettings()['store_id']);
     }

     public function state(){
         
       return $this->belongsTo('App\models\State','state_id');  
     }
}

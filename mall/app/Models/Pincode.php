<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pincode extends Model
{
     protected $table = 'pincodes';
     
     public function cities(){
         return $this->belongsTo('App\models\City' ,'city_id');
     }

     public function seviceProvider(){
     	return $this->belongsTo('App\Models\Courier','service_provider');
     }
}

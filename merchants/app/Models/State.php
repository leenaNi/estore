<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table='states';
    
    public function countries(){
        return $this->belongsTo('App\Models\Country','country_id');
    }
    
}

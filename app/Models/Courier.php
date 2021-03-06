<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    
    protected $table = 'couriers';
    protected $fillable = ['name','status','pref'];
    
     public function countryname() {
        return $this->belongsTo('App\Models\Country', 'country');
    }
}

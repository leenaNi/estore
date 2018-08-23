<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Testimonials extends Model
{
    protected $table='testimonials';
  
     public function users() {
        return $this->belongsTo('App\Models\User', "user_id");
    }
}
?>